<?php

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";

class AjaxUsuarios{

	/*=============================================
	EDITAR USUARIO
	=============================================*/	

	public $idUsuario;
	public $reporte;

	public function ajaxEditarUsuario(){

		$item = "id";
		$valor = $this->idUsuario;

		$respuesta = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);

		echo json_encode($respuesta);

	}

	/*=============================================
	ACTIVAR USUARIO
	=============================================*/	

	public $activarUsuario;
	public $activarId;


	public function ajaxActivarUsuario(){

		$tabla = "usuarios";

		$item1 = "estado";
		$valor1 = $this->activarUsuario;

		$item2 = "id";
		$valor2 = $this->activarId;

		$respuesta = ModeloUsuarios::mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2);

	}

	/*=============================================
	VALIDAR NO REPETIR USUARIO
	=============================================*/	

	public $validarUsuario;

	public function ajaxValidarUsuario(){

		$item = "usuario";
		$valor = $this->validarUsuario;

		$respuesta = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);

		echo json_encode($respuesta);

	}


	public function ajaxMostrarUsuarioCobros(){

		$item = "idusuario";
		$valor = $this->idUsuario;

		$respuesta = ControladorUsuarios::ctrMostrarUsuariosCobros($item, $valor);

		echo json_encode($respuesta);

	}



	public function ajaxReporteUsuarios(){

		$item = "idusuario";
		$valor = $this->idUsuario;
		$valor2 = $this->reporte;

		$respuesta = ControladorUsuarios::ctrReporteUsuarios($item, $valor,$valor2);

		 echo json_encode($respuesta);

	}


}

/*=============================================
EDITAR USUARIO
=============================================*/
if(isset($_POST["idUsuario"])){

	$editar = new AjaxUsuarios();
	$editar -> idUsuario = $_POST["idUsuario"];
	$editar -> ajaxEditarUsuario();

}

/*=============================================
ACTIVAR USUARIO
=============================================*/	

if(isset($_POST["activarUsuario"])){

	$activarUsuario = new AjaxUsuarios();
	$activarUsuario -> activarUsuario = $_POST["activarUsuario"];
	$activarUsuario -> activarId = $_POST["activarId"];
	$activarUsuario -> ajaxActivarUsuario();

}

/*=============================================
VALIDAR NO REPETIR USUARIO
=============================================*/

if(isset( $_POST["validarUsuario"])){

	$valUsuario = new AjaxUsuarios();
	$valUsuario -> validarUsuario = $_POST["validarUsuario"];
	$valUsuario -> ajaxValidarUsuario();

}


if(isset( $_POST["usuarioid"])){

	$valUsuario = new AjaxUsuarios();
	$valUsuario -> idUsuario = $_POST["usuarioid"];
	$valUsuario -> ajaxMostrarUsuarioCobros();

}


if(isset( $_POST["reporte"])){

	//$data = json_decode($_POST["reporte"],true);

	$valUsuario = new AjaxUsuarios();
	$valUsuario -> reporte = $_POST["reporte"];
	$valUsuario -> idUsuario = $_POST["usuarioids"];
	$valUsuario -> ajaxReporteUsuarios();

}