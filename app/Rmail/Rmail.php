<?php

namespace Shareexo\Rmail;

use Psr\Http\Message\ServerRequestInterface;
use Shareexo\Rmail\Contracts\RmailInterface;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

class Rmail implements RmailInterface {

    protected $transport;
    protected $mailer;

    public function __construct()
    {
        $this->transport = new Swift_SmtpTransport('localhost', 1025);
        $this->mailer = new Swift_Mailer($this->transport);
    }

    public function mailer()
    {
        return $this->mailer;
    }

    public function send($request, $message)
    {
        $smessage = (new Swift_Message())
                    ->setSubject('Shareexo')
                    ->setFrom('team@shareexo.com', 'Mekou Raouf')
                    ->setTo($request->getParam('email'), $request->getParam('name'))
                    ->setBody($message);
        $this->mailer->send($smessage);
    }

}