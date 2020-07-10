<?php

session_start();

use Shareexo\App;
use Illuminate\Database\Capsule\Manager as Capsule;
use Shareexo\Middlewares\OldInputMiddleware;
use Shareexo\Middlewares\QuestionSlugMiddleWare;
use Shareexo\Middlewares\ValidationErrorsMiddleware;
use Slim\Views\Twig;



require dirname(__DIR__) .DIRECTORY_SEPARATOR. 'vendor' .DIRECTORY_SEPARATOR. 'autoload.php';

$app = new App;

$container = $app->getContainer();

$capsule = new Capsule;

$capsule->addConnection([
    'driver' => 'sqlite',
    'database' => dirname(__DIR__) .DIRECTORY_SEPARATOR. 'shareexo.db',
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => ''
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

require dirname(__DIR__) .DIRECTORY_SEPARATOR. 'app' .DIRECTORY_SEPARATOR. 'routes.php';

$app->add(new ValidationErrorsMiddleware($container->get(Twig::class)));
$app->add(new OldInputMiddleware($container->get(Twig::class)));
$app->add(new QuestionSlugMiddleware());
