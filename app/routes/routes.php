<?php

use app\controllers\ControllerCliente;
use app\controllers\ControllerDisciplina;
use app\controllers\ControllerHome;
use Slim\Routing\RouteCollectorProxy;
use app\controllers\ControllerLogin;
use app\Middleware\Middleware;


$app->get('/', ControllerHome::class . ':home')->add(Middleware::route());

$app->get('/login', ControllerLogin::class . ':login');
$app->post('/insert', ControllerLogin::class . ':insert');
$app->post('/autenticacao', ControllerLogin::class . ':logar');



$app->group('/cliente', function (RouteCollectorProxy $group) {
    $group->get('/cadastro', ControllerCliente::class . ':cadastro');
});
$app->group('/disciplina', function (RouteCollectorProxy $group) {
    $group->get('/lista', ControllerDisciplina::class . ':lista');
    $group->get('/cadastro', ControllerDisciplina::class . ':cadastro');
    $group->get('/alterar/{id}', ControllerDisciplina::class . ':alterar');
    $group->post('/delete', ControllerDisciplina::class . ':delete');
});
