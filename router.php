<?php
require_once 'libs/router.php';
require_once 'api/controllers/jugador.api.controller.php';
require_once 'api/controllers/equipo.api.controller.php';

// Defino la base url 
define('BASE_URL', '//' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']) . '/');

$router = new Router();

// Jugadores
$router->addRoute('jugadores', 'GET', 'JugadorApiController', "obtenerJugadores");
$router->addRoute('jugadores/paginar/:CANTIDAD', 'GET', 'JugadorApiController', "obtenerJugadoresPaginado");
$router->addRoute('jugadores/filtrar/:FILTRO/:VALOR', 'GET', 'JugadorApiController', "obtenerJugadoresFiltro");
$router->addRoute('jugadores/ordenar/:CATEGORIA/:ORDEN', 'GET', 'JugadorApiController', "obtenerJugadoresOrdenado");
$router->addRoute('jugador/:EQUIPO/:ID', 'GET', 'JugadorApiController', "obtenerJugador");
$router->addRoute('jugador/:EQUIPO/:ID', 'PUT', 'JugadorApiController', "actualizarJugador");
$router->addRoute('jugador/:EQUIPO/:ID', 'DELETE', 'JugadorApiController', "borrarJugador");
$router->addRoute('jugador', 'POST', 'JugadorApiController', "crearJugador");

// Equipos
$router->addRoute('equipo', 'GET', 'EquipoApiController', 'obtenerEquipos');
$router->addRoute('equipo/:id', 'GET', 'EquipoApiController', "obtenerEquipo");
$router->addRoute('equipo', 'POST', 'EquipoApiController', "crearEquipo");
$router->addRoute('equipo/:id', 'DELETE', 'EquipoApiController', "borrarEquipo");
$router->addroute('equipo/:id', 'PUT', 'EquipoApiController', "updateEquipo");

$router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);