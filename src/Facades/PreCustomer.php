<?php

namespace Gmedia\IspSystem\Facades;

use Exception;
use Gmedia\IspSystem\Models\PreCustomer as ModelsPreCustomer;

class PreCustomer
{
    public static function send_whatsapp($uuid, $template)
    {
        try {
            $log = applog('erp__pre_customer_installation_approvel');

            $pre_customer = ModelsPreCustomer::with(['phone_numbers'])
                ->where([
                    ['uuid', $uuid],
                ])
                ->first();

            $success = false;

            if ($template == null) {
                $log->save('Failed send whatsapp Pre Customer : '.$pre_customer->name);

                return $success;
            }

            $phone_numbers = collect();
            $pre_customer->phone_numbers->each(function ($phone_number) use (&$phone_numbers) {
                $phone_numbers->push($phone_number->number);
            });

            $parameters = [
                [
                    'type' => 'text',
                    'text' => url('client/bac/'.$uuid),
                ],
            ];
            $success = Whatsapp::sendMultipleReceivers($template, $parameters, $phone_numbers);

            if ($success) {
                $log->save('success send whatsapp Pre Customer : '.$pre_customer->name);
            }

            return $success;
        } catch (Exception $th) {
            return false;
        }
    }
}
