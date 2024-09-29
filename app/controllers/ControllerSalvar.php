<?php

namespace app\controllers;

use app\database\builder\SelectQuery;


class ControllerSalvar extends Base
{
    public function logar($request, $response)
    {
        try {
            // Captura dos dados de formulário
            $form = $request->getParsedBody();
            $nome = filter_var($form['usuario'], FILTER_UNSAFE_RAW);
            $login = filter_var($form['login'], FILTER_UNSAFE_RAW);
            $senha = filter_var($form['senha'], FILTER_UNSAFE_RAW);

            $user = SelectQuery::select()
                ->from('usuario')
                ->where('login', '=', $login) // Corrigido para verificar login
                ->fetch();

            // Checagem do usuário   
            if (!$user) {
                $data = [
                    'status' => false,
                    'msg' => 'Usuário não encontrado!'
                ];
                return $response->withJson($data, 403);
            }

            // Checagem de senha
            if (!password_verify($senha, $user['senha'])) { // Verifica a senha armazenada
                $data = [
                    'status' => false,
                    'msg' => 'Senha incorreta!'
                ];
                return $response->withJson($data, 403);
            }

            // Criação da sessão do usuário
            $_SESSION['usuario'] = [
                'logado' => true,
                'usuario' => $nome
            ];

            $data = [
                'status' => true,
                'msg' => 'Usuário logado!'
            ];

            return $response->withJson($data, 200);
        } catch (\Exception $e) {
            var_dump($e->getMessage());
            throw new \PDOException("Erro: " . $e->getMessage());
        }
    }
}
