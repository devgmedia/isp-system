<?php

namespace Gmedia\IspSystem\Facades;

use App;
use Gmedia\IspSystem\Models\AgentCashWithdrawal as AgentCashWithdrawalModel;
use Gmedia\IspSystem\Models\Employee;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AgentCashWithdrawal
{
    public static function sendWhatsapp(AgentCashWithdrawalModel $agent_cash_withdrawal)
    {
        $log = applog('erp, agent_cash_withdrawal__fac, send_whatsapp');
        $log->save('debug');

        $agent = $agent_cash_withdrawal->agent;

        $phone_numbers = collect();
        $agent->phone_numbers->each(function ($phone_number) use (&$phone_numbers) {
            $phone_numbers->push($phone_number->number);
        });
        $phone_numbers = $phone_numbers->all();

        if (!App::environment('production')) {
            $dev_phone_numbers = config('phone_number.dev_list');

            if (App::environment(['staging', 'testing', 'development']) && $dev_phone_numbers) {
                $phone_numbers = $dev_phone_numbers;
            } else {
                return response(['message' => 'Delivery failed'], 500);
            }
        }

        $template_name = 'agent_fee_confirmation';
        $parameters = [
            [
                'type' => 'text',
                'text' => $agent_cash_withdrawal->date,
            ],
        ];

        $success = false;

        $proof_of_transaction = $agent_cash_withdrawal->proof_of_transaction;
        if ($proof_of_transaction) {            
            $storage = Storage::disk(config('disk.primary'));
            $file_path = 'agent_cash_withdrawal_proof_of_transaction/'.$proof_of_transaction;

            if ($storage->exists($file_path)) {
                $file_url = $storage->url($file_path);

                $template_name = 'agent_fee_confirm_with_document';
                $components = [
                    [
                        'type' => 'header',
                        'parameters' => [
                            [
                                'type' => 'image',
                                'image' => [
                                    'link' => $file_url,
                                ],
                            ],
                        ],
                    ],
                    [
                        'type' => 'body',
                        'parameters' => $parameters,
                    ],
                ];
            }

            $success = Whatsapp::sendMultipleReceivers($template_name, null, $phone_numbers, false, $components);
        } else {
            $success = Whatsapp::sendMultipleReceivers($template_name, $parameters, $phone_numbers);
        }

        if ($success) {
            $agent->update([
                'whatsapp_fee_confirmation_sent_at' => Carbon::now()->toDateTimeString(),
            ]);
    
            $agent_cash_withdrawal->update([
                'whatsapp_sent_at' => Carbon::now()->toDateTimeString(),
                'whatsapp_sent_by' => Employee::where('user_id', Auth::guard('api')->id())->value('id'),
            ]);
        }

        return $success;
    }

    public static function sendWhatsappDaily()
    {
        $log = applog('erp, agent_cash_withdrawal__fac, send_whatsapp_daily');
        $log->save('debug');

        AgentCashWithdrawalModel::whereDay('created_at', Carbon::now()->day)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->cursor()
            ->each(function ($agent_cash_withdrawal) {
                static::sendWhatsapp($agent_cash_withdrawal);
            });
    }
}
