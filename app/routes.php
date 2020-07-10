<?php

$app->get('/', ['Shareexo\Controllers\HomeController', 'index'])->setName('home');
$app->get('#menu', [])->setName('#menu');

$app->get('/questions/new', ['Shareexo\Controllers\QuestionController', 'new'])->setName('question.new');
$app->post('/questions/new', ['Shareexo\Controllers\QuestionController', 'create'])->setName('question.create');
$app->get('/questions/{slug}', ['Shareexo\Controllers\QuestionController', 'get'])->setName('question.get');

$app->get('/solutions/new/{slug}', ['Shareexo\Controllers\SolutionController', 'new'])->setName('solution.new');
$app->post('/solutions/new', ['Shareexo\Controllers\SolutionController', 'create'])->setName('solution.create');
$app->get('/solutions/{slug}', ['Shareexo\Controllers\SolutionController', 'get'])->setName('solution.get');

$app->get('/history', ['Shareexo\Controllers\HistoryController', 'index'])->setName('history.index');

$app->get('/about', ['Shareexo\Controllers\AboutController', 'about'])->setName('about');