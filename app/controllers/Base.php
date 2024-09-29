<?php

namespace app\controllers;

use app\traits\Template;

abstract class Base
{
    use Template;

    /**
     * Método utilitário para responder com JSON.
     * 
     * @param $response  O objeto de resposta.
     * @param $data      Os dados que serão enviados como JSON.
     * @param $status    O código de status HTTP (padrão 200).
     * 
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function respondWithJson($response, $data, $status = 200) {
        // Definindo o tipo de conteúdo como JSON e o status
        $response = $response->withHeader('Content-Type', 'application/json')
                             ->withStatus($status);
        
        // Codificando os dados para JSON e escrevendo no corpo da resposta
        $response->getBody()->write(json_encode($data));

        return $response;
    }
}
