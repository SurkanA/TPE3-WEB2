<?php

require_once('api/views/apiView.php');
require_once('api/models/usuario.api.model.php');

class AuthController
{

    protected $view;
    protected $model;
    protected $usuario;

    public function __construct()
    {
        $this->data = file_get_contents("php://input");
        $this->view = new ApiView();
        $this->usuario = new UsuarioApiModel();
    }

    public function validaUsuarioPass($usuario, $password)
    {
        $user = $this->usuario->getUsuario($usuario);
        //Si el usuario existe y las contraseñas coinciden
        if ($user && password_verify($password, ($user->password))) {
            return true;
        }
        return false;
    }

    public function auth_basic()
    {
        $headers = apache_request_headers();
        $authHeader = $headers['Authorization'];
        list($usuario, $password) = explode(':', base64_decode(substr($authHeader, 6)));
        try {
            $usuario = $_SERVER['PHP_AUTH_USER'];
            $password = $_SERVER['PHP_AUTH_PW'];

            return $this->validaUsuarioPass($usuario, $password);
        } catch (\Throwable $th) {
            echo ($th);
            return false;
        }
    }

    public function autenticar()
    {
        if (!$this->auth_basic()) {
            $this->view->response('Acceso denegado', 400);
            die();
        }
    }
}
