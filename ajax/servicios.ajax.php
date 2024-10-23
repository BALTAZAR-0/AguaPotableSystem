<?php

require_once "../controladores/servicios.controlador.php";
require_once "../modelos/servicios.modelo.php";

class AjaxServicios{

	/*=============================================
	EDITAR SERIVICIO
	=============================================*/	

	public $idtipo_servicios;
	public $estadoServicios;
	public $zonaServicios;

	public function ajaxEditarServicios(){

		$item = "idtipo_servicios";
		$valor = $this->idtipo_servicios;

		$respuesta = ControladorServicios::ctrMostrarServicios($item, $valor);

		echo json_encode($respuesta);


	}	


	public function ajaxMostrarContratosServicios(){

		$item = "idtipo_servicios";
		$valor1 = $this->estadoServicios;
		$valor2 = $this->zonaServicios;
		$respuesta = ControladorServicios::ctrMostrarContratosServicios($item, $valor1,$valor2);

		echo json_encode($respuesta);


	}	

	

}

/*=============================================
EDITAR PERSONA
=============================================*/	

if(isset($_POST["idtipo_servicios"])){

	$tipo_servicios = new AjaxServicios();
	$tipo_servicios -> idtipo_servicios = $_POST["idtipo_servicios"];
	$tipo_servicios -> ajaxEditarServicios();

}


if(isset($_POST["estadosServicios"])){

	$tipo_servicios = new AjaxServicios();
	$tipo_servicios -> estadoServicios = $_POST["estadosServicios"];
	$tipo_servicios -> zonaServicios = $_POST["zonaServicios"];
	$tipo_servicios -> ajaxMostrarContratosServicios();

}


	
