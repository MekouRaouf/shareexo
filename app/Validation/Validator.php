<?php

namespace Shareexo\Validation;

use Psr\Http\Message\ServerRequestInterface;
use Respect\Validation\Exceptions\NestedValidationException;
use Shareexo\Validation\Contracts\ValidatorInterface;

class Validator implements ValidatorInterface{

    protected $errors = [];

    public function validate(ServerRequestInterface $request, array $rules){

        foreach($rules as $field => $rule){

            try{
                $rule->setName(ucfirst($field))->assert($request->getParam($field));
            } catch (NestedValidationException $e) {
                $this->errors[$field] = $e->getMessages();
            }

        }

        $_SESSION['errors'] = $this->errors;
        
        return $this;
    }

    public function fails(){
        return !empty($this->errors);
    }

}