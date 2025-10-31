<?php

// Inclusión de archivos de controladores y modelos
require_once "controladores/rutas.controlador.php";
require_once "controladores/cursos.controlador.php";
require_once "controladores/clientes.controlador.php";
require_once "modelos/clientes.modelo.php";
require_once "modelos/cursos.modelo.php";

// Se crea una instancia del controlador de rutas
$rutas = new ControladorRutas();

// Se invoca el método de inicio que gestionará la solicitud actual
$rutas -> inicio();

?>