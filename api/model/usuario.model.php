<?php
require_once('model.php');

class UsuarioModel extends Model
{

    //Función que pide a la DB un usuario a partir de un user
    public function getUsuario($user)
    {
        $pdo = $this->createConnection();

        $sql = "select * from usuario where user = ?";
        $query = $pdo->prepare($sql);
        $query->execute([$user]);

        $usuario = $query->fetch(PDO::FETCH_OBJ);

        return $usuario;
    }

    //Función para crear una nuevo usuario
    public function createUser($user, $hash, $administrator)
    {
        $pDO = $this->createConnection();

        $sql = 'INSERT INTO usuario (id_user, user, password, administrator) 
                VALUES (NULL, ?, ?, ?)';

        $query = $pDO->prepare($sql);
        try {
            $query->execute([$user, $hash, $administrator]);
        } catch (\Throwable $th) {
            return null;
        }
    }
}