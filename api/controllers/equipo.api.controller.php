<?php
require_once('api/models/equipo.api.model.php');
require_once('api/views/apiView.php');
class EquipoApiController{
    private $model;
    private $view;
    public function __construct(){
        $this->model = new EquipoApiModel();
        $this->view = new APIView();
    }
    public function obtenerEquipos($req, $res){
        $equipos = $this->model->getEquipos();
        $this->view->response($equipos, 200);
    }
    public function obtenerEquipo($req, $res) {
        //$equipo = $req['equipo'];
        // $equipo = str_replace('', '', $equipo);
        // if (empty($id)){
        //     return $this->view->response("equipo no encontrado", 404);
        // } else {
        //     $equipo = $this->model->getEquipo($equipo, $id);
        //     if (!empty($equipo)) {
        //         return $this->view->response($equipo, 200);
        //     }
        // }
        if(!isset($req->params->id)){
            return $this->view->response('Complete la URL', 400);
        }
        $equipo = $req->params->id;
        $respuesta = $this->model->getEquipo($equipo);
        if($respuesta == null){
            return $this->view->response("No hay equipo con este nombre $equipo ", 404);
        }
        return $this->view->response($respuesta, 200);
    }
    public function crearEquipo($req, $res){
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);
        $nombre_equipo = $data['nombre_equipo'];
        $id_equipo = $data['id_equipo'];
        $ciudad = $data['ciudad'];
        $year_fundado = $data['year_fundado'];
       
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
        $equipo_aux = $this->model->teamExist($nombre_equipo);

        if($equipo_aux != null){
            return $this->view->response('Este equipo ya existe' , 404);
        }
        if (isset($data['nombre_equipo'] ) && isset($data['id_equipo']) && isset($data['ciudad']) && isset($data['year_fundado'])) {
            $this->model->createEquipo($nombre_equipo, $id_equipo, $ciudad, $year_fundado, $biografia, $imagen_url);
            return $this->view->response("Se ha creado el equipo $nombre_equipo", 200);
        } else {
            return $this->view->response("Algo ha fallado en la creacion del equipo", 400);
        }
        // {
        //     "nombre_equipo": "Estudiantes",
        //     "id_equipo": "2",
        //     "ciudad": "la plata",
        //     "year_fundado": "1875"
        
    }

    public function borrarEquipo($req ,$res){
        // $equipo = $req[':EQUIPO'];
        // $equipo = str_replace('', '', $equipo);
        // $id = $req[':ID'];
        // $equipo = $this->model->getEquipo($equipo);
        //     if ($equipo) {
        //     $this->model->deleteEquipo($equipo);
        //     return $this->view->response("Equipo $equipo eliminado con éxito", 200);
        // } else {
        //     $this->view->response("Equipo no encontrado", 404);
        // }
        if(!isset($req->params->id)){
            return $this->view->response('Complete la URL', 400);
        }
        $id_equipo = $req->params->id;
        $equipo = $this->model->getEquipo($id_equipo);
        if($equipo == null){
            return $this->view->response("No se encontro con ese nombre = $id_equipo ", 404 );
        }
        $this->model->deleteEquipo($id_equipo);
        return $this->view->response('Se borro con exito', 200);
    }
    public function updateEquipo($req, $res) {
        if(!isset($req->params->id)){
            return $this->view->response('Completar la url', 400);
        }
        $id = $req->params->id;

        // verifico que exista
        $equipo = $this->model->getEquipo($id);
        if (!$equipo) {
            return $this->view->response("El equipo $id no existe", 404);
        }

         // valido los datos
         if (empty($req->body->nombre_equipo) || empty($req->body->ciudad) || empty($req->body->year_fundado)) {
            return $this->view->response('Faltan completar datos', 400);
        }

        // obtengo los datos
        $nombre_equipo = $req->body->nombre_equipo;
        $ciudad = $req->body->ciudad;       
        $year_fundado = $req->body->year_fundado;
        $biografia = $req->body->biografia;
        $imagen_url = $req->body->imagen_url;

        
        // actualiza la equipo
        $this->model->updateEquipo($id, $nombre_equipo, $ciudad, $year_fundado, $biografia, $imagen_url);

        // obtengo la tarea modificada y la devuelvo en la respuesta
        $equipo = $this->model->getEquipo($id);
        $this->view->response($equipo, 200);
    }

}
