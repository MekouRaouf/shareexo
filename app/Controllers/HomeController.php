<?php

namespace Shareexo\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Shareexo\History\History;
use Shareexo\Models\Question;
use Shareexo\Pagination\Paginator;
use Slim\Views\Twig;

class HomeController{

    public function index(ServerRequestInterface $request, ResponseInterface $response, Twig $view, Question $question, History $history){        
        $questions = $question->orderBy('id', 'desc')->get();
        $pagination = new Paginator($request, $questions, 10, 7);

        return $view->render($response, 'home.twig', [
            'paginationItems' => $pagination->getItems(),
            'buttons' => $pagination->pages(),
            'pagination' => $pagination,
            'history' => $history->all_history()
        ]);

    }

}