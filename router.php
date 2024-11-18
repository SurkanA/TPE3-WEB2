<?php
require_once 'libs/router.php';
require_once 'api/controllers/jugador.api.controller.php';

$router = new Router();

// Jugadores
$router->addRoute('jugadores', 'GET', 'JugadorApiController', "obtenerJugadores");
$router->addRoute('jugadores/:CANTIDAD', 'GET', 'JugadorApiController', "obtenerJugadoresPaginado");
$router->addRoute('jugador/:EQUIPO/:ID', 'GET', 'JugadorApiController', "obtenerJugador");
$router->addRoute('jugador/:EQUIPO/:ID', 'PUT', 'JugadorApiController', "actualizarJugador");
$router->addRoute('jugador/:EQUIPO/:ID', 'DELETE', 'JugadorApiController', "borrarJugador");
$router->addRoute('jugador', 'POST', 'JugadorApiController', "crearJugador");

$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);