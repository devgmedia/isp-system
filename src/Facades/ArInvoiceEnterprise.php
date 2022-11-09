<?php

namespace Gmedia\IspSystem\Facades;

use App;
use Carbon\Carbon;
use Gmedia\IspSystem\Facades\Mail as MailFac;
use Gmedia\IspSystem\Mail\ArInvoiceEnterprise\ReminderMail;
use Gmedia\IspSystem\Models\ArInvoice;
use Illuminate\Support\Facades\Mail;

class ArInvoiceEnterprise
{
    public static function sendReminderEmail(ArInvoice $invoice)
    {
        $log = applog(
            'erp, '
            .'ar_invoice_enterprise__fac, '
            .'send_reminder_email'
        );
        $log->save('debug');

        $payer = $invoice->payer_ref;
        if (! $payer) {
            $log->save('payer not found');

            return;
        }

        $invoices = [];
        $invoices_total = 0;
        $invoice_reminders = [];
        $invoice_objects = [];

        $payer->invoice_pays()
            ->where('paid', false)
            ->each(function ($invoice) use (
                &$invoices,
                &$invoices_total,
                &$invoice_reminders,
                &$invoice_objects
            ) {
                $invoices_total += $invoice->total;

                array_push($invoices, [
                    'date' => $invoice->date->format('d-m-Y'),
                    'number' => $invoice->number,
                    'cid' => $invoice->payer_cid,
                    'service' => $invoice->payer_name,
                    'total' => number_format($invoice->total, 0, ',', '.'),
                ]);

                array_push($invoice_reminders, [
                    'ar_invoice_id' => $invoice->id,
                ]);

                array_push($invoice_objects, $invoice);

                $invoice->email_reminders()->create();
            });

        $invoices_total = number_format($invoices_total, 0, ',', '.');

        $to = null;
        $cc = collect();

        $payer->emails->each(function ($email, $key) use (&$to, &$cc) {
            if ($key === 0) {
                $to = $email->name;

                return true;
            }

            $cc->push($email->name);
        });

        if (! $to && ! in_array(App::environment(), ['staging', 'testing', 'development'])) {
            return false;
        }
        $cc = $cc->all();

        $log->new()->properties(['to' => $to, 'cc' => $cc])->save('email address');

        $default_mail = Mail::getSwiftMailer();
        $invoice_reminder_mail = MailFac::getSwiftMailer('internet_enterprise_billing');
        if (in_array(App::environment(), ['staging', 'testing', 'development'])) {
            $to = config('mail_address.dev');
            $cc = config('mail_address.dev_cc');
            $invoice_reminder_mail = MailFac::getSwiftMailer('dev');
        }
        Mail::setSwiftMailer($invoice_reminder_mail);

        Mail::to($to)->cc($cc)->send(new ReminderMail([
            'branch_name' => $invoice->branch->name,
            'month_year_sent' => Carbon::now()->translatedFormat('F Y'),
            'receiver_name' => $invoice->receiver_name,

            'billing_date' => Carbon::now()->translatedFormat('d F Y'),
            'payment_due_date' => Carbon::now()->endOfMonth()->translatedFormat('d F Y'),

            'invoices' => $invoices,
            'invoices_total' => $invoices_total,
        ]));

        Mail::setSwiftMailer($default_mail);

        foreach ($invoice_objects as $key => $invoice) {
            if (! ($invoice->reminder_email_count >= 0)) {
                $invoice->reminder_email_count = 0;
            }

            $invoice->reminder_email_count += 1;
            $invoice->save();
        }

        return true;
    }
}
