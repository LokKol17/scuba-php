<?php

namespace Scuba\Web\Controller;

use Scuba\Web\Crypt\Crypt;
use Scuba\Web\Mail\Mail;

class SendMail
{
    public static function sendMailTo(array $person): void
    {
        $crypt = Crypt::ssl_crypt($person['email']);
        (new Mail())->sendMail($person['email'], $person['name'], $crypt);
    }
}