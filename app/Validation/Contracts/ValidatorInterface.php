<?php

namespace Shareexo\Validation\Contracts;

use Psr\Http\Message\ServerRequestInterface;

interface ValidatorInterface{

    public function validate(ServerRequestInterface $request, array $rules);
    public function fails();

}