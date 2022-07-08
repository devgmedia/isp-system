<?php

namespace Gmedia\IspSystem\Facades;

use Gmedia\IspSystem\Models\ApInvoice;
use Gmedia\IspSystem\Models\Spm as SpmModel;
use Gmedia\IspSystem\Models\SpmBranchManagerApproval;
use Gmedia\IspSystem\Models\SpmFinanceApproval;
use Gmedia\IspSystem\Models\SpmGeneralManagerApproval;
use Gmedia\IspSystem\Models\SpmDirectorApproval;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Mail;
use App\Mail\Spm\BranchManagerApprovalMail;
use App\Mail\Spm\BranchManagerApprovalInformationMail;
use App\Mail\Spm\FinanceApprovalMail;
use App\Mail\Spm\FinanceApprovalInformationMail;
use App\Mail\Spm\GeneralManagerApprovalMail;
use App\Mail\Spm\GeneralManagerApprovalInformationMail;
use App\Mail\Spm\DirectorApprovalMail;
use App\Mail\Spm\DirectorApprovalInformationMail;
use App\Facades\Mail as MailFac;

class Spm
{
    public static function generateApprovalId()
    {
        $log = applog('erp, spm__fac, generate_approval_id');
        $log->save('debug');

        $approval_id = null;

        do {
            $approval_id = Uuid::uuid4();
        } while (SpmModel::where('approval_id', $approval_id)->exists());
        
        return $approval_id;
    }

    public static function setInvalidToApproval(SpmModel $spm)
    {
        $log = applog('erp, spm__fac, set_invalid_to_approval');
        $log->save('debug');

        $spm->update([
            'approval_id' => static::generateApprovalId(),
        ]);

        $spm->branch_manager_approvals->each(function ($approval) {
            $approval->update(['invalid' => true]);
        });

        $spm->finance_approvals->each(function ($approval) {
            $approval->update(['invalid' => true]);
        });

        $spm->general_manager_approvals->each(function ($approval) {
            $approval->update(['invalid' => true]);
        });

        $spm->director_approvals->each(function ($approval) {
            $approval->update(['invalid' => true]);
        });
    }

    public static function setInvalidToApprovalByInvoice(ApInvoice $invoice)
    {
        $log = applog('erp, spm__fac, set_invalid_to_approval_by_invoice');
        $log->save('debug');
        
        $invoice->spms->each(function ($spm) {
            static::setInvalidToApproval($spm); 
        });
    }

    public static function sendBranchManagerApprovalRequestEmail(SpmBranchManagerApproval $spm_approval)
    {
        $log = applog('erp, spm__fac, send_branch_manager_approval_request_email');
        $log->save('debug');

        $spm_on_views = [];
        $paid_total = 0.0;

        $spm_approval->spms->each(function ($spm) use (&$spm_on_views, &$paid_total) {
            $spm_paid_total = '-';
            
            if ($spm->paid_total)
            {
                $paid_total += $spm->paid_total;
                $spm_paid_total = number_format($spm->paid_total, 2, ',', '.');
            }

            array_push($spm_on_views, [
                'id' => $spm->id,
                'uuid' => $spm->uuid,
                'name' => $spm->name,
                'paid_total' => $spm_paid_total,

                'number' => $spm->number,
                'receiver' => $spm->receiver ? $spm->receiver->name : null,

                'branch_manager_approval_note' => $spm->branch_manager_approval_note,
                'finance_approval_note' => $spm->finance_approval_note,
                'general_manager_approval_note' => $spm->general_manager_approval_note,
                'director_approval_note' => $spm->director_approval_note,

                'cancel' => $spm->cancel,
                'authorized' => $spm->authorized,

                'note' => $spm->note,
            ]);
        });

        $to = $spm_approval->branch->spm_pic_email;
        $cc = [$spm_approval->request_by_ref->user->email];

        $params = [
            'spms' => $spm_on_views,
            'paid_total' => number_format($paid_total, 2, ',', '.'),
            'approval_uuid' => $spm_approval->uuid,
            'approval_name' => $spm_approval->branch->spm_pic,
            'request_date' => $spm_approval->request_at->translatedFormat('d F Y'),
        ];

        $mailable = new BranchManagerApprovalMail($params);

        $default_mail = Mail::getSwiftMailer();
        $spm_mail = $default_mail;
        if (in_array(\App::environment(), ['development', 'testing'])) {
            $to = config('app.dev_mail_address');
            $cc = config('app.dev_cc_mail_address');
            $spm_mail = MailFac::getSwiftMailer('dev');
        }
        Mail::setSwiftMailer($spm_mail);

        Mail::to($to)->cc($cc)->send($mailable);

        Mail::setSwiftMailer($default_mail);
    }

    public static function sendBranchManagerApprovalInformationEmail(SpmBranchManagerApproval $spm_approval)
    {
        $log = applog('erp, spm__fac, send_branch_manager_approval_information_email');
        $log->save('debug');

        $spm_on_views = [];
        $paid_total = 0.0;

        $rejected_spm_on_views = [];
        $rejected_paid_total = 0.0;

        $spm_approval->spms->each(function ($spm) use (&$spm_on_views, &$paid_total, &$rejected_spm_on_views, &$rejected_paid_total) {
            $spm_paid_total = '-';
            $rejected_spm_paid_total = '-';

            if ($spm->branch_manager_approved) {
                if ($spm->paid_total)
                {
                    $paid_total += $spm->paid_total;
                    $spm_paid_total = number_format($spm->paid_total, 2, ',', '.');
                }

                array_push($spm_on_views, [
                    'id' => $spm->id,
                    'uuid' => $spm->uuid,
                    'name' => $spm->name,
                    'paid_total' => $spm_paid_total,

                    'number' => $spm->number,
                    'reference' => $spm->invoice ? $spm->invoice->invoice_number : null,
                    'due_date' => $spm->due_date ? $spm->due_date->format('Y-m-d') : null,
                    'receiver' => $spm->receiver ? $spm->receiver->name : null,
                    'source_of_funds' => $spm->cash_bank ? $spm->cash_bank->name : null,

                    'branch_manager_approval_note' => $spm->branch_manager_approval_note,
                    'finance_approval_note' => $spm->finance_approval_note,
                    'general_manager_approval_note' => $spm->general_manager_approval_note,
                    'director_approval_note' => $spm->director_approval_note,

                    'cancel' => $spm->cancel,
                    'authorized' => $spm->authorized,

                    'note' => $spm->note,
                ]);
            } else {
                if ($spm->paid_total)
                {
                    $rejected_paid_total += $spm->paid_total;
                    $rejected_spm_paid_total = number_format($spm->paid_total, 2, ',', '.');
                }

                array_push($rejected_spm_on_views, [
                    'id' => $spm->id,
                    'uuid' => $spm->uuid,
                    'name' => $spm->name,
                    'paid_total' => $rejected_spm_paid_total,

                    'number' => $spm->number,
                    'reference' => $spm->invoice ? $spm->invoice->invoice_number : null,
                    'due_date' => $spm->due_date ? $spm->due_date->format('Y-m-d') : null,
                    'receiver' => $spm->receiver ? $spm->receiver->name : null,
                    'source_of_funds' => $spm->cash_bank ? $spm->cash_bank->name : null,

                    'branch_manager_approval_note' => $spm->branch_manager_approval_note,
                    'finance_approval_note' => $spm->finance_approval_note,
                    'general_manager_approval_note' => $spm->general_manager_approval_note,
                    'director_approval_note' => $spm->director_approval_note,

                    'cancel' => $spm->cancel,
                    'authorized' => $spm->authorized,

                    'note' => $spm->note,
                ]);
            }
        });

        $to = $spm_approval->request_by_ref->user->email;
        $cc = [];

        $branch = $spm_approval->branch;
        $regional = $branch->regional;
        
        if ($branch->spm_is_active) array_push($cc, $branch->spm_pic_email);
        if ($regional->spm_finance_is_active) array_push($cc, $regional->spm_finance_pic_email);
        if ($regional->spm_general_manager_is_active) array_push($cc, $regional->spm_general_manager_pic_email);
        if ($regional->spm_director_is_active) array_push($cc, $regional->spm_director_pic_email);

        $params = [
            'spms' => $spm_on_views,
            'paid_total' => number_format($paid_total, 2, ',', '.'),

            'rejected_spms' => $rejected_spm_on_views,
            'rejected_paid_total' => number_format($rejected_paid_total, 2, ',', '.'),

            'approval_uuid' => $spm_approval->uuid,
            'approval_name' => $spm_approval->branch->spm_pic,
            'request_date' => $spm_approval->request_at->translatedFormat('d F Y'),
        ];

        $mailable = new BranchManagerApprovalInformationMail($params);

        $default_mail = Mail::getSwiftMailer();
        $spm_mail = $default_mail;
        if (in_array(\App::environment(), ['development', 'testing'])) {
            $to = config('app.dev_mail_address');
            $cc = config('app.dev_cc_mail_address');
            $spm_mail = MailFac::getSwiftMailer('dev');
        }
        Mail::setSwiftMailer($spm_mail);

        Mail::to($to)->cc($cc)->send($mailable);

        Mail::setSwiftMailer($default_mail);
    }

    public static function sendFinanceApprovalRequestEmail(SpmFinanceApproval $spm_approval)
    {
        $log = applog('erp, spm__fac, send_finance_approval_request_email');
        $log->save('debug');

        $spm_on_views = [];
        $paid_total = 0.0;

        $spm_approval->spms->each(function ($spm) use (&$spm_on_views, &$paid_total) {
            $spm_paid_total = '-';
            
            if ($spm->paid_total)
            {
                $paid_total += $spm->paid_total;
                $spm_paid_total = number_format($spm->paid_total, 2, ',', '.');
            }

            array_push($spm_on_views, [
                'id' => $spm->id,
                'uuid' => $spm->uuid,
                'name' => $spm->name,
                'paid_total' => $spm_paid_total,

                'number' => $spm->number,
                'reference' => $spm->invoice ? $spm->invoice->invoice_number : null,
                'due_date' => $spm->due_date ? $spm->due_date->format('Y-m-d') : null,
                'receiver' => $spm->receiver ? $spm->receiver->name : null,
                'source_of_funds' => $spm->cash_bank ? $spm->cash_bank->name : null,

                'branch_manager_approval_note' => $spm->branch_manager_approval_note,
                'finance_approval_note' => $spm->finance_approval_note,
                'general_manager_approval_note' => $spm->general_manager_approval_note,
                'director_approval_note' => $spm->director_approval_note,

                'cancel' => $spm->cancel,
                'authorized' => $spm->authorized,

                'note' => $spm->note,
            ]);
        });

        $to = $spm_approval->branch->regional->spm_finance_pic_email;
        $cc = [$spm_approval->request_by_ref->user->email];

        $params = [
            'spms' => $spm_on_views,
            'paid_total' => number_format($paid_total, 2, ',', '.'),
            'approval_uuid' => $spm_approval->uuid,
            'approval_name' => $spm_approval->branch->regional->spm_finance_pic,
            'request_date' => $spm_approval->request_at->translatedFormat('d F Y'),
        ];

        $mailable = new FinanceApprovalMail($params);

        $default_mail = Mail::getSwiftMailer();
        $spm_mail = $default_mail;
        if (in_array(\App::environment(), ['development', 'testing'])) {
            $to = config('app.dev_mail_address');
            $cc = config('app.dev_cc_mail_address');
            $spm_mail = MailFac::getSwiftMailer('dev');
        }
        Mail::setSwiftMailer($spm_mail);

        Mail::to($to)->cc($cc)->send($mailable);

        Mail::setSwiftMailer($default_mail);
    }

    public static function sendFinanceApprovalInformationEmail(SpmFinanceApproval $spm_approval)
    {
        $log = applog('erp, spm__fac, send_finance_approval_information_email');
        $log->save('debug');

        $spm_on_views = [];
        $paid_total = 0.0;

        $rejected_spm_on_views = [];
        $rejected_paid_total = 0.0;

        $spm_approval->spms->each(function ($spm) use (&$spm_on_views, &$paid_total, &$rejected_spm_on_views, &$rejected_paid_total) {
            $spm_paid_total = '-';
            $rejected_spm_paid_total = '-';

            if ($spm->finance_approved) {
                if ($spm->paid_total)
                {
                    $paid_total += $spm->paid_total;
                    $spm_paid_total = number_format($spm->paid_total, 2, ',', '.');
                }

                array_push($spm_on_views, [
                    'id' => $spm->id,
                    'uuid' => $spm->uuid,
                    'name' => $spm->name,
                    'paid_total' => $spm_paid_total,

                    'number' => $spm->number,
                    'reference' => $spm->invoice ? $spm->invoice->invoice_number : null,
                    'due_date' => $spm->due_date ? $spm->due_date->format('Y-m-d') : null,
                    'receiver' => $spm->receiver ? $spm->receiver->name : null,
                    'source_of_funds' => $spm->cash_bank ? $spm->cash_bank->name : null,

                    'branch_manager_approval_note' => $spm->branch_manager_approval_note,
                    'finance_approval_note' => $spm->finance_approval_note,
                    'general_manager_approval_note' => $spm->general_manager_approval_note,
                    'director_approval_note' => $spm->director_approval_note,

                    'cancel' => $spm->cancel,
                    'authorized' => $spm->authorized,

                    'note' => $spm->note,
                ]);
            } else {
                if ($spm->paid_total)
                {
                    $rejected_paid_total += $spm->paid_total;
                    $rejected_spm_paid_total = number_format($spm->paid_total, 2, ',', '.');
                }

                array_push($rejected_spm_on_views, [
                    'id' => $spm->id,
                    'uuid' => $spm->uuid,
                    'name' => $spm->name,
                    'paid_total' => $rejected_spm_paid_total,

                    'number' => $spm->number,
                    'reference' => $spm->invoice ? $spm->invoice->invoice_number : null,
                    'due_date' => $spm->due_date ? $spm->due_date->format('Y-m-d') : null,
                    'receiver' => $spm->receiver ? $spm->receiver->name : null,
                    'source_of_funds' => $spm->cash_bank ? $spm->cash_bank->name : null,

                    'branch_manager_approval_note' => $spm->branch_manager_approval_note,
                    'finance_approval_note' => $spm->finance_approval_note,
                    'general_manager_approval_note' => $spm->general_manager_approval_note,
                    'director_approval_note' => $spm->director_approval_note,

                    'cancel' => $spm->cancel,
                    'authorized' => $spm->authorized,

                    'note' => $spm->note,
                ]);
            }
        });

        $to = $spm_approval->request_by_ref->user->email;
        $cc = [];

        $branch = $spm_approval->branch;
        $regional = $branch->regional;
        
        if ($branch->spm_is_active) array_push($cc, $branch->spm_pic_email);
        if ($regional->spm_finance_is_active) array_push($cc, $regional->spm_finance_pic_email);
        if ($regional->spm_general_manager_is_active) array_push($cc, $regional->spm_general_manager_pic_email);
        if ($regional->spm_director_is_active) array_push($cc, $regional->spm_director_pic_email);

        $params = [
            'spms' => $spm_on_views,
            'paid_total' => number_format($paid_total, 2, ',', '.'),

            'rejected_spms' => $rejected_spm_on_views,
            'rejected_paid_total' => number_format($rejected_paid_total, 2, ',', '.'),

            'approval_uuid' => $spm_approval->uuid,
            'approval_name' => $regional->spm_finance_pic,
            'request_date' => $spm_approval->request_at->translatedFormat('d F Y'),
        ];

        $mailable = new FinanceApprovalInformationMail($params);

        $default_mail = Mail::getSwiftMailer();
        $spm_mail = $default_mail;
        if (in_array(\App::environment(), ['development', 'testing'])) {
            $to = config('app.dev_mail_address');
            $cc = config('app.dev_cc_mail_address');
            $spm_mail = MailFac::getSwiftMailer('dev');
        }
        Mail::setSwiftMailer($spm_mail);

        Mail::to($to)->cc($cc)->send($mailable);

        Mail::setSwiftMailer($default_mail);
    }

    public static function sendGeneralManagerApprovalRequestEmail(SpmGeneralManagerApproval $spm_approval)
    {
        $log = applog('erp, spm__fac, send_general_manager_approval_request_email');
        $log->save('debug');

        $spm_on_views = [];
        $paid_total = 0.0;

        $spm_approval->spms->each(function ($spm) use (&$spm_on_views, &$paid_total) {
            $spm_paid_total = '-';
            
            if ($spm->paid_total)
            {
                $paid_total += $spm->paid_total;
                $spm_paid_total = number_format($spm->paid_total, 2, ',', '.');
            }

            array_push($spm_on_views, [
                'id' => $spm->id,
                'uuid' => $spm->uuid,
                'name' => $spm->name,
                'paid_total' => $spm_paid_total,

                'number' => $spm->number,
                'reference' => $spm->invoice ? $spm->invoice->invoice_number : null,
                'due_date' => $spm->due_date ? $spm->due_date->format('Y-m-d') : null,
                'receiver' => $spm->receiver ? $spm->receiver->name : null,
                'source_of_funds' => $spm->cash_bank ? $spm->cash_bank->name : null,

                'branch_manager_approval_note' => $spm->branch_manager_approval_note,
                'finance_approval_note' => $spm->finance_approval_note,
                'general_manager_approval_note' => $spm->general_manager_approval_note,
                'director_approval_note' => $spm->director_approval_note,

                'cancel' => $spm->cancel,
                'authorized' => $spm->authorized,

                'note' => $spm->note,
            ]);
        });

        $to = $spm_approval->branch->regional->spm_general_manager_pic_email;
        $cc = [$spm_approval->request_by_ref->user->email];

        $params = [
            'spms' => $spm_on_views,
            'paid_total' => number_format($paid_total, 2, ',', '.'),
            'approval_uuid' => $spm_approval->uuid,
            'approval_name' => $spm_approval->branch->regional->spm_general_manager_pic,
            'request_date' => $spm_approval->request_at->translatedFormat('d F Y'),
        ];

        $mailable = new GeneralManagerApprovalMail($params);

        $default_mail = Mail::getSwiftMailer();
        $spm_mail = $default_mail;
        if (in_array(\App::environment(), ['development', 'testing'])) {
            $to = config('app.dev_mail_address');
            $cc = config('app.dev_cc_mail_address');
            $spm_mail = MailFac::getSwiftMailer('dev');
        }
        Mail::setSwiftMailer($spm_mail);

        Mail::to($to)->cc($cc)->send($mailable);

        Mail::setSwiftMailer($default_mail);
    }

    public static function sendGeneralManagerApprovalInformationEmail(SpmGeneralManagerApproval $spm_approval)
    {
        $log = applog('erp, spm__fac, send_general_manager_approval_information_email');
        $log->save('debug');

        $spm_on_views = [];
        $paid_total = 0.0;

        $rejected_spm_on_views = [];
        $rejected_paid_total = 0.0;

        $spm_approval->spms->each(function ($spm) use (&$spm_on_views, &$paid_total, &$rejected_spm_on_views, &$rejected_paid_total) {
            $spm_paid_total = '-';
            $rejected_spm_paid_total = '-';

            if ($spm->general_manager_approved) {
                if ($spm->paid_total)
                {
                    $paid_total += $spm->paid_total;
                    $spm_paid_total = number_format($spm->paid_total, 2, ',', '.');
                }

                array_push($spm_on_views, [
                    'id' => $spm->id,
                    'uuid' => $spm->uuid,
                    'name' => $spm->name,
                    'paid_total' => $spm_paid_total,

                    'number' => $spm->number,
                    'reference' => $spm->invoice ? $spm->invoice->invoice_number : null,
                    'due_date' => $spm->due_date ? $spm->due_date->format('Y-m-d') : null,
                    'receiver' => $spm->receiver ? $spm->receiver->name : null,
                    'source_of_funds' => $spm->cash_bank ? $spm->cash_bank->name : null,

                    'branch_manager_approval_note' => $spm->branch_manager_approval_note,
                    'finance_approval_note' => $spm->finance_approval_note,
                    'general_manager_approval_note' => $spm->general_manager_approval_note,
                    'director_approval_note' => $spm->director_approval_note,

                    'cancel' => $spm->cancel,
                    'authorized' => $spm->authorized,

                    'note' => $spm->note,
                ]);
            } else {
                if ($spm->paid_total)
                {
                    $rejected_paid_total += $spm->paid_total;
                    $rejected_spm_paid_total = number_format($spm->paid_total, 2, ',', '.');
                }

                array_push($rejected_spm_on_views, [
                    'id' => $spm->id,
                    'uuid' => $spm->uuid,
                    'name' => $spm->name,
                    'paid_total' => $rejected_spm_paid_total,

                    'number' => $spm->number,
                    'reference' => $spm->invoice ? $spm->invoice->invoice_number : null,
                    'due_date' => $spm->due_date ? $spm->due_date->format('Y-m-d') : null,
                    'receiver' => $spm->receiver ? $spm->receiver->name : null,
                    'source_of_funds' => $spm->cash_bank ? $spm->cash_bank->name : null,

                    'branch_manager_approval_note' => $spm->branch_manager_approval_note,
                    'finance_approval_note' => $spm->finance_approval_note,
                    'general_manager_approval_note' => $spm->general_manager_approval_note,
                    'director_approval_note' => $spm->director_approval_note,

                    'cancel' => $spm->cancel,
                    'authorized' => $spm->authorized,

                    'note' => $spm->note,
                ]);
            }
        });

        $to = $spm_approval->request_by_ref->user->email;
        $cc = [];

        $branch = $spm_approval->branch;
        $regional = $branch->regional;
        
        if ($branch->spm_is_active) array_push($cc, $branch->spm_pic_email);
        if ($regional->spm_finance_is_active) array_push($cc, $regional->spm_finance_pic_email);
        if ($regional->spm_general_manager_is_active) array_push($cc, $regional->spm_general_manager_pic_email);
        if ($regional->spm_director_is_active) array_push($cc, $regional->spm_director_pic_email);

        $params = [
            'spms' => $spm_on_views,
            'paid_total' => number_format($paid_total, 2, ',', '.'),

            'rejected_spms' => $rejected_spm_on_views,
            'rejected_paid_total' => number_format($rejected_paid_total, 2, ',', '.'),

            'approval_uuid' => $spm_approval->uuid,
            'approval_name' => $regional->spm_general_manager_pic,
            'request_date' => $spm_approval->request_at->translatedFormat('d F Y'),
        ];

        $mailable = new GeneralManagerApprovalInformationMail($params);

        $default_mail = Mail::getSwiftMailer();
        $spm_mail = $default_mail;
        if (in_array(\App::environment(), ['development', 'testing'])) {
            $to = config('app.dev_mail_address');
            $cc = config('app.dev_cc_mail_address');
            $spm_mail = MailFac::getSwiftMailer('dev');
        }
        Mail::setSwiftMailer($spm_mail);

        Mail::to($to)->cc($cc)->send($mailable);

        Mail::setSwiftMailer($default_mail);
    }

    public static function sendDirectorApprovalRequestEmail(SpmDirectorApproval $spm_approval)
    {
        $log = applog('erp, spm__fac, send_director_approval_request_email');
        $log->save('debug');

        $spm_on_views = [];
        $paid_total = 0.0;

        $spm_approval->spms->each(function ($spm) use (&$spm_on_views, &$paid_total) {
            $spm_paid_total = '-';
            
            if ($spm->paid_total)
            {
                $paid_total += $spm->paid_total;
                $spm_paid_total = number_format($spm->paid_total, 2, ',', '.');
            }

            array_push($spm_on_views, [
                'id' => $spm->id,
                'uuid' => $spm->uuid,
                'name' => $spm->name,
                'paid_total' => $spm_paid_total,

                'number' => $spm->number,
                'reference' => $spm->invoice ? $spm->invoice->invoice_number : null,
                'due_date' => $spm->due_date ? $spm->due_date->format('Y-m-d') : null,
                'receiver' => $spm->receiver ? $spm->receiver->name : null,
                'source_of_funds' => $spm->cash_bank ? $spm->cash_bank->name : null,

                'branch_manager_approval_note' => $spm->branch_manager_approval_note,
                'finance_approval_note' => $spm->finance_approval_note,
                'general_manager_approval_note' => $spm->general_manager_approval_note,
                'director_approval_note' => $spm->director_approval_note,

                'cancel' => $spm->cancel,
                'authorized' => $spm->authorized,

                'note' => $spm->note,
            ]);
        });

        $to = $spm_approval->branch->regional->spm_director_pic_email;
        $cc = [$spm_approval->request_by_ref->user->email];

        $params = [
            'spms' => $spm_on_views,
            'paid_total' => number_format($paid_total, 2, ',', '.'),
            'approval_uuid' => $spm_approval->uuid,
            'approval_name' => $spm_approval->branch->regional->spm_director_pic,
            'request_date' => $spm_approval->request_at->translatedFormat('d F Y'),
        ];

        $mailable = new DirectorApprovalMail($params);

        $default_mail = Mail::getSwiftMailer();
        $spm_mail = $default_mail;
        if (in_array(\App::environment(), ['development', 'testing'])) {
            $to = config('app.dev_mail_address');
            $cc = config('app.dev_cc_mail_address');
            $spm_mail = MailFac::getSwiftMailer('dev');
        }
        Mail::setSwiftMailer($spm_mail);

        Mail::to($to)->cc($cc)->send($mailable);

        Mail::setSwiftMailer($default_mail);
    }

    public static function sendDirectorApprovalInformationEmail(SpmDirectorApproval $spm_approval)
    {
        $log = applog('erp, spm__fac, send_director_approval_information_email');
        $log->save('debug');

        $spm_on_views = [];
        $paid_total = 0.0;

        $rejected_spm_on_views = [];
        $rejected_paid_total = 0.0;

        $spm_approval->spms->each(function ($spm) use (&$spm_on_views, &$paid_total, &$rejected_spm_on_views, &$rejected_paid_total) {
            $spm_paid_total = '-';
            $rejected_spm_paid_total = '-';

            if ($spm->director_approved) {
                if ($spm->paid_total)
                {
                    $paid_total += $spm->paid_total;
                    $spm_paid_total = number_format($spm->paid_total, 2, ',', '.');
                }

                array_push($spm_on_views, [
                    'id' => $spm->id,
                    'uuid' => $spm->uuid,
                    'name' => $spm->name,
                    'paid_total' => $spm_paid_total,

                    'number' => $spm->number,
                    'reference' => $spm->invoice ? $spm->invoice->invoice_number : null,
                    'due_date' => $spm->due_date ? $spm->due_date->format('Y-m-d') : null,
                    'receiver' => $spm->receiver ? $spm->receiver->name : null,
                    'source_of_funds' => $spm->cash_bank ? $spm->cash_bank->name : null,

                    'branch_manager_approval_note' => $spm->branch_manager_approval_note,
                    'finance_approval_note' => $spm->finance_approval_note,
                    'general_manager_approval_note' => $spm->general_manager_approval_note,
                    'director_approval_note' => $spm->director_approval_note,

                    'cancel' => $spm->cancel,
                    'authorized' => $spm->authorized,

                    'note' => $spm->note,
                ]);
            } else {
                if ($spm->paid_total)
                {
                    $rejected_paid_total += $spm->paid_total;
                    $rejected_spm_paid_total = number_format($spm->paid_total, 2, ',', '.');
                }

                array_push($rejected_spm_on_views, [
                    'id' => $spm->id,
                    'uuid' => $spm->uuid,
                    'name' => $spm->name,
                    'paid_total' => $rejected_spm_paid_total,

                    'number' => $spm->number,
                    'reference' => $spm->invoice ? $spm->invoice->invoice_number : null,
                    'due_date' => $spm->due_date ? $spm->due_date->format('Y-m-d') : null,
                    'receiver' => $spm->receiver ? $spm->receiver->name : null,
                    'source_of_funds' => $spm->cash_bank ? $spm->cash_bank->name : null,

                    'branch_manager_approval_note' => $spm->branch_manager_approval_note,
                    'finance_approval_note' => $spm->finance_approval_note,
                    'general_manager_approval_note' => $spm->general_manager_approval_note,
                    'director_approval_note' => $spm->director_approval_note,

                    'cancel' => $spm->cancel,
                    'authorized' => $spm->authorized,

                    'note' => $spm->note,
                ]);
            }
        });

        $to = $spm_approval->request_by_ref->user->email;
        $cc = [];

        $branch = $spm_approval->branch;
        $regional = $branch->regional;
        
        if ($branch->spm_is_active) array_push($cc, $branch->spm_pic_email);
        if ($regional->spm_finance_is_active) array_push($cc, $regional->spm_finance_pic_email);
        if ($regional->spm_general_manager_is_active) array_push($cc, $regional->spm_general_manager_pic_email);
        if ($regional->spm_director_is_active) array_push($cc, $regional->spm_director_pic_email);

        $params = [
            'spms' => $spm_on_views,
            'paid_total' => number_format($paid_total, 2, ',', '.'),

            'rejected_spms' => $rejected_spm_on_views,
            'rejected_paid_total' => number_format($rejected_paid_total, 2, ',', '.'),

            'approval_uuid' => $spm_approval->uuid,
            'approval_name' => $regional->spm_director_pic,
            'request_date' => $spm_approval->request_at->translatedFormat('d F Y'),
        ];

        $mailable = new DirectorApprovalInformationMail($params);

        $default_mail = Mail::getSwiftMailer();
        $spm_mail = $default_mail;
        if (in_array(\App::environment(), ['development', 'testing'])) {
            $to = config('app.dev_mail_address');
            $cc = config('app.dev_cc_mail_address');
            $spm_mail = MailFac::getSwiftMailer('dev');
        }
        Mail::setSwiftMailer($spm_mail);

        Mail::to($to)->cc($cc)->send($mailable);

        Mail::setSwiftMailer($default_mail);
    }
}
