<?php

namespace Shareexo\Validation\Forms;

use Respect\Validation\Validator as v;

class QuestionForm{

    public static function rules(){

        return [
            'name' => v::alpha(' '),
            'email' => v::optional(v::email()),            
            'subject' => v::allOf(v::alnum()),
            'image' => v::optional(v::image()),
            'description' => v::allOf()
        ];

    }

}