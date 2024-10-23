<?php


require_once "controladores/usuarios.controlador.php";
require_once "controladores/zonas.controlador.php";
require_once "controladores/personas.controlador.php";
require_once "controladores/servicios.controlador.php";
require_once "controladores/contratos.controlador.php";
require_once "controladores/cobros.controlador.php";


require_once "modelos/usuarios.modelo.php";
require_once "modelos/zonas.modelo.php";
require_once "modelos/personas.modelo.php";
require_once "modelos/servicios.modelo.php";
require_once "modelos/contratos.modelo.php";
require_once "modelos/cobros.modelo.php";
require_once "controladores/plantilla.controlador.php";

require_once "extensiones/vendor/autoload.php";

$plantilla = new ControladorPlantilla();
$plantilla -> ctrPlantilla();