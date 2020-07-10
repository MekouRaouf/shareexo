<?php

namespace Shareexo\Validation\Forms;

use Respect\Validation\Validator as v;

class SolutionForm{

    public static function rules(){

        return [
            'name' => v::alpha(' '),
            'email' => v::optional(v::email()),           
            'image' => v::optional(v::image()),
            'description' => v::allOf()
        ];

    }

}