<?php

namespace app\controllers;

use app\database\builder\InsertQuery;
use app\database\Connection; // Importando a classe de conexão, ajuste conforme necessário

class ControllerLogin extends Base {
    
    // Método para exibir a página de login
    public function login($request, $response) {
        $TempleteData = [
            'titulo' => 'HOME'
        ];
        return $this->getTwig()
            ->render($response, $this->setView('login'), $TempleteData)
            ->withHeader('Content-Type', 'text/html')
            ->withStatus(200);
    }

    // Método para inserir um novo usuário no banco de dados
    public function insert($request, $response) {
        try {
            // Coleta e filtra os dados do formulário enviados pelo usuário
            $form = $request->getParsedBody();
            $nome = filter_var($form['modalusuario'], FILTER_UNSAFE_RAW);
            $login = filter_var($form['modallogin'], FILTER_UNSAFE_RAW);
            $senha = password_hash(filter_var($form['modalsenha'], FILTER_UNSAFE_RAW), PASSWORD_DEFAULT); // Criptografando a senha
            $IsSave = InsertQuery::table('usuario')
            ->save([

                'nome'   =>   $nome,
                'login'  =>   $login,
                'senha'  =>   $senha,
                

            ]);



        if ($IsSave != true) {
            $data = [
                'status' => false,
                'msg' => 'Restrição: ' . $IsSave,
                'id' => 0
            ];
            $json = json_encode($data, JSON_UNESCAPED_UNICODE);
            $response->getBody()
                ->write($json);
            return $response->withStatus(403)
                ->withHeader('Content-type', 'application/json');
        }
        $data = [
            'status' => true,
            'msg' => 'Registro salvo com sucesso!',
            'id' => 0
        ];
        $json = json_encode($data, JSON_UNESCAPED_UNICODE);
        $response->getBody()
            ->write($json);
        return $response
            ->withStatus(201)
            ->withHeader('Content-type', 'application/json');
    } catch (\Exception $e) {

        var_dump($e->getMessage());
        throw new \PDOException("Restrição" . $e->getMessage());
    }
}
}
 function autenticacao($request, $response) {
    try {
        // Coleta e filtra os dados do formulário
        $form = $request->getParsedBody();
        $login = filter_var($form['login'], FILTER_UNSAFE_RAW);
        $senha = filter_var($form['senha'], FILTER_UNSAFE_RAW);

        // Usando a classe Connection para conectar ao banco de dados
        $pdo = Connection::getConnection();

        // Consulta para verificar se o login existe
        $stmt = $pdo->prepare("SELECT * FROM usuario WHERE login = :login LIMIT 1");
        $stmt->execute(['login' => $login]);

        // Busca o usuário retornado pela consulta
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        // Verifica se o usuário existe e se a senha corresponde
        if ($user && password_verify($senha, $user['senha'])) {
            $data = [
                'status' => true,
                'msg' => 'Autenticação bem-sucedida!',
                'user_id' => $user['id']
            ];
            return $response->withJson($data, 200);
        } else {
            // Retorna uma resposta de erro se o login ou senha estiverem incorretos
            $data = [
                'status' => false,
                'msg' => 'Login ou senha inválidos!'
            ];
            return $response->withJson($data, 401);
        }

    } catch (\Exception $e) {
        // Tratamento de erro
        var_dump($e->getMessage());
        $data = [
            'status' => false,
            'msg' => 'Erro: ' . $e->getMessage()
        ];
        return $response->withJson($data, 500);
    }
}