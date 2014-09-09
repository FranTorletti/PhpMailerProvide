<?php

/* This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this file,
 * You can obtain one at http://mozilla.org/MPL/2.0/. */


use Silex\Application;
use Silex\ServiceProviderInterface;

include "vendor/phpmailer/phpmailer/PHPMailerAutoload.php";



class PhpMailerServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
    	$app['mail'] = $app->share(function () use ($app) {
    		//Create a new PHPMailer instance
            $mail = new PHPMailer();

            //Tell PHPMailer to use SMTP
            $mail->isSMTP();

            //Enable SMTP debugging
            // 0 = off (for production use)
            // 1 = client messages
            // 2 = client and server messages
            $mail->SMTPDebug = 2;

            //Ask for HTML-friendly debug output
            $mail->Debugoutput = 'html';

            //Set the hostname of the mail server
            $mail->Host = 'smtp.gmail.com';

            //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
            $mail->Port = 587;

            //Set the encryption system to use - ssl (deprecated) or tls
            $mail->SMTPSecure = 'tls';

            //Whether to use SMTP authentication
            $mail->SMTPAuth = true;

            //Username to use for SMTP authentication - use full email address for gmail
            $mail->Username = $app['phpmailer.userMail'];

            //Password to use for SMTP authentication
            $mail->Password = $app['phpmailer.password'];

            //Set who the message is to be sent from
            $mail->setFrom($app['phpmailer.mail'], $app['phpmailer.firm']);
    		
    		return $mail;

        });
    }

    public function boot(Application $app)
    {
    }
}
