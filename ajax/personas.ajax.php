<?php

require_once "../controladores/personas.controlador.php";
require_once "../modelos/personas.modelo.php";

class AjaxPersonas{

	/*=============================================
	EDITAR PERSONA
	=============================================*/	

	public $idPersona;

	public function ajaxEditarPersona(){

		$item = "idpersona";
		$valor = $this->idPersona;

		$respuesta = ControladorPersonas::ctrMostrarPersonas($item, $valor);

		echo json_encode($respuesta);


	}

	public function ajaxMostrarPersonaServicio(){

		$item = "idpersona";
		$valor = $this->idPersona;

		$respuesta = ControladorPersonas::ctrMostrarPersonaServicio($item, $valor);

		echo json_encode($respuesta);


	}

	public function ajaxMostrarPersona(){

		$item = "idpersona";
		$valor = $this->idPersona;

		$respuesta = ControladorPersonas::ctrMostrarPersona($item, $valor);

		echo json_encode($respuesta);


	}

	/*=============================================
	VALIDAR NO REPETIR PERSONA
	=============================================*/	

	public $validarPersona;

	public function ajaxValidarPersona(){

		$item = "documento";
		$valor = $this->validarPersona;

		$respuesta = ControladorPersonas::ctrMostrarPersonas($item, $valor);

		echo json_encode($respuesta);

	}

	// public function ajaxFiltrar(){
	// 	$valor = $this->valor;
	// 	$item = $this->item;
	// 	$tabla = $this->tabla;
	// 	$respuesta = ControladorPersonas::ctrMostrarFiltro($tabla,$item,$valor);

	// 	echo json_encode($respuesta);
	// }

}



/*=============================================
VALIDAR NO REPETIR PERSONA
=============================================*/

if(isset( $_POST["validarPersona"])){

	$valPersona = new AjaxPersonas();
	$valPersona -> validarPersona = $_POST["validarPersona"];
	$valPersona -> ajaxValidarPersona();

}


/*=============================================
EDITAR PERSONA
=============================================*/	

if(isset($_POST["idPersona"])){

	$persona = new AjaxPersonas();
	$persona -> idPersona = $_POST["idPersona"];
	$persona -> ajaxEditarPersona();

}


if(isset($_POST["idPersonaServicio"])){

	$persona = new AjaxPersonas();
	$persona -> idPersona = $_POST["idPersonaServicio"];
	$persona -> ajaxMostrarPersonaServicio();

}
	

if(isset($_POST["idPersonaContrato"])){

	$persona = new AjaxPersonas();
	$persona -> idPersona = $_POST["idPersonaContrato"];
	$persona -> ajaxMostrarPersona();

}
	
