<?php

namespace Shareexo\Rmail\Contracts;

use Psr\Http\Message\ServerRequestInterface;

interface RmailInterface {

    public function mailer();
    public function send(ServerRequestInterface $request, $message);

}