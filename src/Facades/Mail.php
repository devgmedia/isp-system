<?php

namespace Gmedia\IspSystem\Facades;

use Swift_Mailer;
use Swift_SmtpTransport;

class Mail
{
    public static function getSwiftMailer($account_name)
    {
        $mail = config('mail_account.'.$account_name);

        $transport = (new Swift_SmtpTransport($mail['host'], $mail['port'], $mail['encryption']))
            ->setUsername($mail['username'])
            ->setPassword($mail['password'])
            ->setTimeout(120);

        return new Swift_Mailer($transport);
    }
}
