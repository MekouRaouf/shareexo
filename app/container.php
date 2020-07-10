<?php

use Interop\Container\ContainerInterface;
use Shareexo\History\History;
use Shareexo\History\QuestionHistory;
use Shareexo\History\SolutionHistory;
use Shareexo\History\Summary;
use Shareexo\Models\Image;
use Shareexo\Models\Question;
use Shareexo\Models\Solution;
use Shareexo\Pagination\Contracts\PaginatorInterface;
use Shareexo\Pagination\Paginator;
use Shareexo\Rmail\Contracts\RmailInterface;
use Shareexo\Rmail\Rmail;
use Shareexo\Support\Storage\Contracts\StorageInterface;
use Shareexo\Support\Storage\SessionStorage;
use Shareexo\Validation\Contracts\ValidatorInterface;
use Shareexo\Validation\Validator;
use Slim\Flash\Messages;
use Slim\Router;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;

use function DI\get;

return [

    'router' => get(Router::class),
    Messages::class => function(ContainerInterface $c){
        return new Messages;
    },
    StorageInterface::class => function(ContainerInterface $c){
        return new SessionStorage('history');
    },
    ValidatorInterface::class => function(ContainerInterface $c){
        return new Validator;
    },
    PaginatorInterface::class => function(ContainerInterface $c){
        return new Paginator;
    },
    Twig::class => function(ContainerInterface $c){
        $twig = new Twig(dirname(__DIR__) .DIRECTORY_SEPARATOR. 'resources' .DIRECTORY_SEPARATOR. 'views', [
            'cache' => false
        ]);

        $twig->addExtension(new TwigExtension(
            $c->get('router'),
            $c->get('request')->getUri()
        ));

        $twig->getEnvironment()->addGlobal('flash', $c->get(Messages::class));

        return $twig;

    },
    Image::class => function(ContainerInterface $c){
        return new Image;
    },
    Question::class => function(ContainerInterface $c){
        return new Question;
    },
    Solution::class => function(ContainerInterface $c){
        return new Solution;
    },
    History::class => function(ContainerInterface $c){
        return new History(
            $c->get(SessionStorage::class)
        );
    },
    QuestionHistory::class => function(ContainerInterface $c){
        return new QuestionHistory(
            $c->get(Question::class),
            $c->get(SessionStorage::class)
        );
    },
    SolutionHistory::class => function(ContainerInterface $c){
        return new SolutionHistory(
            $c->get(Solution::class),
            $c->get(SessionStorage::class)
        );
    },
    Summary::class => function(ContainerInterface $c){
        return new Summary;
    },
    RmailInterface::class => function(ContainerInterface $c){
        return new Rmail;
    }
];