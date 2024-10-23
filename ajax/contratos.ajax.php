<?php

require_once "../controladores/contratos.controlador.php";
require_once "../modelos/contratos.modelo.php";

class AjaxContratos{

	/*=============================================
	EDITAR ACTA
	=============================================*/	

	public $idservicios;
	public $codigo;
	
	public function ajaxMostrarUltimalectura(){
		$item = "codigo";
		$valor = $this->codigo;

		$respuesta = ControladorContratos::ctrMostrarUltimalectura($item, $valor);

		echo json_encode($respuesta);
	}

	public function ajaxEditarContratos(){

		$item = "idservicios";
		$valor = $this->idservicios;

		$respuesta = ControladorContratos::ctrMostrarContratos($item, $valor);

		echo json_encode($respuesta);


	}

	public function ajaxMostrarCobros(){

		$item = "idservicios";
		$valor = $this->idservicios;

		$respuesta = ControladorContratos::ctrMostrarCobros($item, $valor);

		echo json_encode($respuesta);


	}

	public function ajaxEliminarServicio(){

		$item = "idservicio";
		$valor = $this->idservicios;

		$respuesta = ControladorContratos::ctrEliminarServicio($item, $valor);

		echo json_encode($respuesta);


	}



	public function ajaxEditarServicio(){

		$item = "idservicio";
		$valor = $this->idservicios;

		$respuesta = ControladorContratos::ctrEditarServicio($item, $valor);

		echo json_encode($respuesta);


	}

   

	
}


/*=============================================
EDITAR ACTA
=============================================*/	

if(isset($_POST["idservicios"])){

	$persona = new AjaxActasNacimiento();
	$persona -> idPersona = $_POST["idservicios"];
	$persona -> ajaxEditarActaNacimientos();

}

if(isset($_POST["idserviciosCobro"])){

	$persona = new AjaxContratos();
	$persona -> idservicios = $_POST["idserviciosCobro"];
	$persona -> ajaxMostrarCobros();

}

if(isset($_POST["idserviciosEliminar"])){

	$persona = new AjaxContratos();
	$persona -> idservicios = $_POST["idserviciosEliminar"];
	$persona -> ajaxEliminarServicio();

}


if(isset($_POST["editarServicio"])){

	$persona = new AjaxContratos();
	$persona -> idservicios = $_POST["editarServicio"];
	$persona -> ajaxEditarServicio();

}
if(isset($_POST["codigo"])){

	$persona = new AjaxContratos();
	$persona -> codigo = $_POST["codigo"];
	$persona -> ajaxMostrarUltimalectura();

}



