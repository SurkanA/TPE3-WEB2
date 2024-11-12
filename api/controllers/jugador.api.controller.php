<?php
require_once('api/models/jugador.api.model.php');
require_once('api/views/apiView.php');
class JugadorApiController
{
    private $model;
    private $view;
    public function __construct()
    {
        $this->model = new JugadorApiModel();
        $this->view = new APIView();
    }
    public function obtenerJugadores()
    {
        $jugadores = $this->model->getJugadores();
        $this->view->response($jugadores, 200);
    }

    public function obtenerJugador($req)
    {
        $equipo = $req[':EQUIPO'];
        $equipo = str_replace('', '', $equipo);
        $id = $req[':ID'];
        if (empty($id) || empty($equipo)) {
            return $this->view->response("Jugador no encontrado", 404);
        } else {
            $jugador = $this->model->getJugador($equipo, $id);
            if (!empty($jugador)) {
                return $this->view->response($jugador, 200);
            }
        }
    }

    public function crearJugador($req)
    {
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);
        $nombre_jugador = $data['nombre_jugador'];
        $nombre_equipo = $data['nombre_equipo'];
        $id_jugador = $data['id_jugador'];
        $edad = $data['edad'];
        $posicion = $data['posicion'];
        if (isset($data['biografia'])) {
            $biografia = $data['biografia'];
        } else {
            $biografia = 'No se introdujo una biografia';
        }

        if (isset($data['imagen_url'])) {
            $imagen_url = $data['imagen_url'];
        } else {
            $imagen_url = 'https://static.vecteezy.com/system/resources/previews/005/228/939/non_2x/avatar-man-face-silhouette-user-sign-person-profile-picture-male-icon-black-color-illustration-flat-style-image-vector.jpg';
        }

        if (isset($data['nombre_jugador']) && $data['nombre_equipo'] && $this->model->teamExist($nombre_equipo) && $data['id_jugador'] && $data['edad'] && $data['posicion']) {
            $this->model->createPlayer($nombre_jugador, $nombre_equipo, $id_jugador, $edad, $posicion, $biografia, $imagen_url);
            return $this->view->response("Se ha creado el jugador $nombre_jugador", 200);
        } else {
            return $this->view->response("Algo ha fallado en la creacion del jugador", 400);
        }
        // {
        //     "nombre_jugador": "Iniesta",
        //     "nombre_equipo": "Estudiantes",
        //     "id_jugador": "8",
        //     "edad": "20",
        //     "posicion": "Delantero"
        // }
    }
    public function borrarJugador($req)
    {
        $equipo = $req[':EQUIPO'];
        $equipo = str_replace('', '', $equipo);
        $id = $req[':ID'];
        $jugador = $this->model->getJugador($equipo, $id);
        $jugador_nombre = $jugador[0]->nombre_jugador;
        if ($jugador) {
            $this->model->deleteJugador($equipo, $id);
            return $this->view->response("Jugador $jugador_nombre eliminado con éxito", 200);
        } else {
            $this->view->response("Jugador no encontrado", 404);
        }
    }
}