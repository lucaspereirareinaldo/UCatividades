<?php

use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

require __DIR__ . '/../app/helpers/settings.php';

require __DIR__ . '/../app/routes/routes.php';

$app->run();


$senha_segura = 'senha_segura';

$passwd = password_hash($senha_segura, PASSWORD_DEFAULT);

$senha_correta = password_verify($senha_segura, $passwd);

$senha_vencida = password_needs_rehash($passwd, PASSWORD_DEFAULT);

