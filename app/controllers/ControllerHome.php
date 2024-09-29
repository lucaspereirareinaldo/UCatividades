<?php

namespace app\controllers;

use app\database\builder\UpdateQuery;

class ControllerHome extends Base
{
    public function home($request, $response)
    {
        $TempleteData = [
            'titulo' => 'HOME'
        ];
        return $this->getTwig()
            ->render($response, $this->setView('pagina-inicial'), $TempleteData)
            ->withHeader('Content-Type', 'text/html')
            ->withStatus(200);
    }
}