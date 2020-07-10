<?php

namespace Shareexo\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Shareexo\History\History;
use Slim\Views\Twig;

class AboutController{

    public function about(ServerRequestInterface $request, ResponseInterface $response, Twig $view, History $history){        

        return $view->render($response, 'about.twig', [
            'history' => $history->all_history()
        ]);

    }

}