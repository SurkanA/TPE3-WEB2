<?php
require_once('api/models/jugador.api.model.php');
require_once('api/controllers/auth.api.controller.php');
require_once('api/views/apiView.php');
class JugadorApiController
{
    private $model;
    private $view;
    private $auth;
    private $data;
    public function __construct()
    {
        $this->data = file_get_contents("php://input");
        $this->model = new JugadorApiModel();
        $this->view = new APIView();
        $this->auth = new AuthController();
    }

    public function getData()
    {
        return json_decode($this->data);
    }

    public function obtenerJugadores()
    {
        $jugadores = $this->model->getJugadores();
        $this->view->response($jugadores, 200);
    }

    public function obtenerJugadoresPaginado($req)
    {
        $limite = $req[':CANTIDAD'];
        $jugadores = $this->model->getJugadoresPaginado($limite);
        $this->view->response($jugadores, 200);
    }
    public function obtenerJugadoresOrdenado($req)
    {
        $categoria = $req[':CATEGORIA'];
        $orden = $req[':ORDEN'];
        if ($orden == 'ascendente') {
            $orden = 'ASC';
        } else if ($orden == 'descendente') {
            $orden = 'DESC';
        }

        switch ($categoria) {
            case 'nombre':
                $categoria = 'nombre_jugador';
                break;
            case 'equipo':
                $categoria = 'nombre_equipo';
                break;
            case 'id':
                $categoria = 'id_jugador';
                break;
            case 'edad':
                $categoria = 'edad';
                break;
            case 'posicion':
                $categoria = 'posicion';
                break;
            case 'imagen':
                $categoria = 'imagen_url';
            default:
                break;
        }
        $jugadores = $this->model->getJugadoresOrdenado($categoria, $orden);
        $this->view->response($jugadores, 200);
    }
    public function obtenerJugadoresFiltro($req)
    {
        $filtro = $req[':FILTRO'];
        $valor = $req[':VALOR'];
        switch ($filtro) {
            case 'nombre':
                $filtro = 'nombre_jugador';
                $valor = str_replace('', '', $valor);
                break;
            case 'equipo':
                $filtro = 'nombre_equipo';
                $valor = str_replace('', '', $valor);
                break;
            case 'id':
                $filtro = 'id_jugador';
                break;
            case 'edad':
                $filtro = 'edad';
                break;
            case 'posicion':
                $filtro = 'posicion';
                break;
            case 'imagen':
                $filtro = 'imagen_url';
            default:
                break;
        }
        $jugadores = $this->model->getJugadoresFiltro($filtro, $valor);
        $this->view->response($jugadores, 200);
    }

    public function obtenerJugador($req)
    {
        $equipo = $req[':EQUIPO'];
        // Saca los espacio del nombre del equipo para una mejor url
        $equipo = str_replace('', '', $equipo);
        $id = $req[':ID'];
        $jugador = $this->model->getJugador($equipo, $id);
        if ($jugador) {
            return $this->view->response($jugador, 200);
        }

    }

    public function crearJugador($req)
    {
        // Datos obtenidos del $req
        $data = $this->getData();
        $nombre_jugador = $data->nombre_jugador;
        $nombre_equipo = $data->nombre_equipo;
        $id_jugador = $data->id_jugador;
        $edad = $data->edad;
        $posicion = $data->posicion;

        // Si no se introduce biografia o imagen_url, se le asigna un valor por defecto
        if (isset($data->biografia)) {
            $biografia = $data->biografia;
        } else {
            $biografia = 'No se introdujo una biografia';
        }

        if (isset($data->imagen_url)) {
            $imagen_url = $data->imagen_url;
        } else {
            $imagen_url = 'https://static.vecteezy.com/system/resources/previews/005/228/939/non_2x/avatar-man-face-silhouette-user-sign-person-profile-picture-male-icon-black-color-illustration-flat-style-image-vector.jpg';
        }

        if (isset($data['nombre_jugador']) && isset($data['nombre_equipo']) && $this->model->teamExist($nombre_equipo) && isset($data['id_jugador']) && isset($data['edad']) && isset($data['posicion'])) {
            $this->model->createPlayer($nombre_jugador, $nombre_equipo, $id_jugador, $edad, $posicion, $biografia, $imagen_url);
            return $this->view->response("Se ha creado el jugador $nombre_jugador", 201);
        } else {
            return $this->view->response("Algo ha fallado en la creacion del jugador", 400);
        }
        // Template para mandar via el body para el Postman
        // {
        //     "nombre_jugador": "Iniesta",
        //     "nombre_equipo": "Real Madrid",
        //     "id_jugador": "1",
        //     "edad": "30",
        //     "posicion": "Delantero",
        //     "biografia": "Iniesta es un jugador delantero del Real Madrid",
        //     "imagen_url": "https://as.com/futbol/la-croqueta-asi-era-el-regate-con-nombre-culinario-mas-letal-de-andres-iniesta-n/"
        // }
    }
    public function borrarJugador($req)
    {
        // Verificacion si esta authenticado
        $this->auth->autenticar();
        // Datos obtenidos del $req
        $equipo = $req[':EQUIPO'];
        // Saca los espacio del nombre del equipo para una mejor url
        $equipo = str_replace('', '', $equipo);
        $id = $req[':ID'];

        // Busca el nombre del jugador para el view->response
        $jugador = $this->model->getJugador($equipo, $id);
        $jugador_nombre = $jugador->nombre_jugador;

        // Respecto a el checkeo de $jugador esto es porque si al buscar el jugador no se encuentra nada devuelve false
        if ($jugador) {
            $this->model->deleteJugador($equipo, $id);
            return $this->view->response("Jugador $jugador_nombre eliminado con éxito", 200);
        } else {
            $this->view->response("Jugador no encontrado", 404);
        }
    }

    public function actualizarJugador($req)
    {
        // Verificacion si esta authenticado
        $this->auth->autenticar();
        // Datos obtenidos del $req
        $equipo = $req[':EQUIPO'];
        // Saca los espacio del nombre del equipo para una mejor url
        $equipo = str_replace('', '', $equipo);
        $id = $req[':ID'];
        // Busca el nombre del jugador para el view->response
        $jugador = $this->model->getJugador($equipo, $id);
        $jugador_nombre = $jugador->nombre_jugador;

        // JSON mandado en el body del postman
        $data = $this->getData();
        $nombre_jugador = $data->nombre_jugador;
        $nombre_equipo = $data->nombre_equipo;
        $id_jugador = $data->id_jugador;
        $edad = $data->edad;
        $posicion = $data->posicion;

        // Si no se introduce biografia o imagen_url, se le asigna un valor por defecto
        if (isset($data->biografia)) {
            $biografia = $data->biografia;
        } else {
            $biografia = 'No se introdujo una biografia';
        }

        if (isset($data->imagen_url)) {
            $imagen_url = $data->imagen_url;
        } else {
            $imagen_url = 'https://static.vecteezy.com/system/resources/previews/005/228/939/non_2x/avatar-man-face-silhouette-user-sign-person-profile-picture-male-icon-black-color-illustration-flat-style-image-vector.jpg';
        }

        // Respecto a el checkeo de $jugador esto es porque si al buscar el jugador no se encuentra nada devuelve false
        if ($jugador && isset($nombre_jugador) && isset($nombre_equipo) && isset($id_jugador) && isset($edad) && isset($posicion) && isset($equipo) && isset($id)) {
            $this->model->updatePlayer($nombre_jugador, $nombre_equipo, $id_jugador, $edad, $posicion, $biografia, $imagen_url, $equipo, $id);
            return $this->view->response("Se ha actualizado el jugador $jugador_nombre", 200);
        } else {
            return $this->view->response("Algo ha fallado en la actualizacion del jugador", 400);
        }
    }
}