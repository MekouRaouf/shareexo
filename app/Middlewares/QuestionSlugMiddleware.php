<?php

namespace Shareexo\Middlewares;

class QuestionSlugMiddleWare{

    public function __invoke($request, $response, $next)
    {

        if(!isset($_SESSION['question_slug'])){
            $_SESSION['question_slug'] = [];
        }
        
        $response = $next($request, $response);

        return $response;
    }

}