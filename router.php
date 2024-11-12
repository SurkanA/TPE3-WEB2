<?php
require_once 'libs/router.php';

require_once 'api/controllers/jugador.api.controller.php';

$router = new Router();

$router->addRoute('jugadores', 'GET', 'JugadorApiController', "obtenerJugadores");
$router->addRoute('jugadores/:EQUIPO/:ID', 'GET', 'JugadorApiController', "obtenerJugador");
$router->addRoute('jugadores/:EQUIPO/:ID', 'DELETE', 'JugadorApiController', "borrarJugador");
$router->addRoute('jugadores', 'POST', 'JugadorApiController', "crearJugador");

$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);