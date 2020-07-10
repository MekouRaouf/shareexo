<?php

namespace Shareexo\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Shareexo\History\History;
use Slim\Views\Twig;

class HistoryController{

    public function index(ServerRequestInterface $request, ResponseInterface $response, Twig $view, History $history){        

        return $view->render($response, 'history/index.twig', [
            'history' => $history,
            'summaries' => $history->all_history()
        ]);
    }

}