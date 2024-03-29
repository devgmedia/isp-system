<?php

namespace Gmedia\IspSystem\Facades;

use Gmedia\IspSystem\Facades\Mail as MailFac;
use Gmedia\IspSystem\Mail\Service\InstallationMail;
use Illuminate\Support\Facades\Mail;

class ItemCondition
{
    public static function sendemail($username, $password)
    {
        $log = applog('erp__item_codition');
        $log->save('send item email');

        $to = 'helpdesk.jogja@gmedia.co.id';
        $cc = ['support.jogja@gmedia.co.id'];

        $default_mail = Mail::getSwiftMailer();
        $installation_mail = $default_mail;
        if (in_array(\App::environment(), ['staging', 'testing', 'development'])) {
            $to = config('mail_address.dev');
            $cc = [];
            $installation_mail = MailFac::getSwiftMailer('dev');
        }
        Mail::setSwiftMailer($installation_mail);

        Mail::to($to)->cc($cc)->send(new InstallationMail([
            'service' => [
                'sid' => $customer_product_additional->sid,
                'name' => $customer_product_additional->customer_product->product->name,
                'cid' => $customer_product_additional->customer_product->customer->cid,
                'customer' => $customer_product_additional->customer_product->customer->name,
                'installation_date' => $customer_product_additional->service_date->translatedFormat('d F Y'),
            ],
        ]));

        Mail::setSwiftMailer($default_mail);
    }
}
