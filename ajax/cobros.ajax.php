<?php


require_once "../controladores/cobros.controlador.php";
require_once "../modelos/cobros.modelo.php";

class AjaxContratos{

	/*=============================================
	EDITAR ACTA
	=============================================*/	

	public $idservicio;

	public function ajaxEditarContratos(){

		$item = "idservicios";
		$valor = $this->idservicio;

		$respuesta = ControladorContratos::ctrMostrarContratos($item, $valor);

		echo json_encode($respuesta);


	}
	public function ajaxMostrarCronograma(){

		$item = "idservicio";
		$valor = $this->idservicio;

		$respuesta = ControladorCobros::ctrMostrarCronograma($item, $valor);

		echo json_encode($respuesta);


	}

	public function ajaxMostrarCronogramaPago(){

		$item = "idcronograma_pago";
		$valor = $this->idservicio;

		$respuesta = ControladorCobros::ctrMostrarCronogramaPago($item, $valor);

		echo json_encode($respuesta);


	}


	public function ajaxGuardarPagos(){

		//$item = "idcronograma_pago";
		$valor = $this->idservicio;

		$respuesta = ControladorCobros::ctrGuardarPagos($valor);

		return json_encode($respuesta);


	}

	public function ajaxGuardarPagosClientes(){
		$valor = $this->idservicio;
		$respuesta = ControladorCobros::ctrGuardarPagosPendiente($valor);

		echo json_encode($respuesta);
	}

	public function ajaxAceptarPago($nroTransacion){

		$valor = $this->idservicio;

		$respuesta = ControladorCobros::ctrActualizarPagosPendiente($valor, $nroTransacion);

		echo json_encode($respuesta);
	}

	public function ajaxRechazarPago(){
		$valor = $this->idservicio;

		$respuesta = ControladorCobros::ctrRechazarPago($valor);

		echo $respuesta;
	}


	public function ajaxEliminarCobro(){

		//$item = "idcronograma_pago";
		$valor = $this->idservicio;

		$respuesta = ControladorCobros::ctrEliminarCobro($valor);

		echo json_encode($respuesta);


	}

	public function ajaxEditarCobro(){

		$item = "iddetallepago";
		$valor = $this->idservicio;

		$respuesta = ControladorCobros::ctrGetDetalleCobro($item,$valor);

		echo json_encode($respuesta);


	}


	/*=============================================
	ELIMINAR COBROS O DESACTIVAR
	=============================================*/	

	public $desactivarCobros;
	public $activarId;


	public function ajaxDesactivarCobros(){

		$tabla = "cobros";

		$item1 = "estado";
		$valor1 = $this->desactivarCobros;

		$item2 = "idcobros";
		$valor2 = $this->activarId;

		$respuesta = ModeloCobros::mdlDesactivarCobros($tabla, $item1, $valor1, $item2, $valor2);

		

	}

	public function ajaxConsultarServicioId(){
		$datos = $this->activarId;
		$respuesta = ControladorCobros::ctrConsultarServicioId($datos);
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



if(isset($_POST["idservicio"])){

	$servicio = new AjaxContratos();
	$servicio -> idservicio = $_POST["idservicio"];
	$servicio -> ajaxMostrarCronograma();

}


if(isset($_POST["idcronograma_pago"])){

	$servicio = new AjaxContratos();
	$servicio -> idservicio = $_POST["idcronograma_pago"];
	$servicio -> ajaxMostrarCronogramaPago();

}


if(isset($_POST["arreglo"])){

	$data = json_decode($_POST["arreglo"],true);
	//var_dump($data);
	$servicio = new AjaxContratos();
	$servicio -> idservicio = $data;
	$servicio -> ajaxGuardarPagos();

}

if(isset($_POST["crearDetallePago"])){
	$data = json_decode($_POST["crearDetallePago"],true);
	$servicio = new AjaxContratos();
	$servicio -> idservicio = $data;
	$servicio -> ajaxGuardarPagosClientes();
	

}



if(isset($_POST["idcronograma"])){

	$servicio = new AjaxContratos();
	$servicio -> idservicio = $_POST["idcronograma"];
	$servicio -> ajaxEliminarCobro();

}




if(isset($_POST["editarCobros"])){

	$servicio = new AjaxContratos();
	$servicio -> idservicio = $_POST["editarCobros"];
	$servicio -> ajaxEditarCobro();

}


/*=============================================
ELIMINAR COBROS O DESACTIVAR
=============================================*/	

if(isset($_POST["desactivarCobros"])){

	$desactivarCobros = new AjaxContratos();
	$desactivarCobros -> desactivarCobros = $_POST["desactivarCobros"];
	$desactivarCobros -> activarId = $_POST["activarId"];
	$desactivarCobros -> ajaxDesactivarCobros();

}

if(isset($_POST["consultarServicioId"])){

	$desactivarCobros = new AjaxContratos();
	$desactivarCobros -> activarId = $_POST;
	$desactivarCobros -> ajaxConsultarServicioId();

}

if(isset($_POST['aceptarIdDetalle'])){
	//echo json_encode('hola esta es una prueba '.$_POST['aceptarIdDetalle']);
	$desactivarCobros = new AjaxContratos();
	$desactivarCobros -> idservicio = $_POST['aceptarIdDetalle'];
	$nroTransacion = null;
	if(isset($_POST['nro_transacion']))
		$nroTransacion = $_POST['nro_transacion'];

	$desactivarCobros -> ajaxAceptarPago($nroTransacion);
}
if(isset($_POST['rechazar_pago'])){
	$desactivarCobros = new AjaxContratos();
	$desactivarCobros -> idservicio = $_POST['rechazar_pago'];
	$desactivarCobros -> ajaxRechazarPago();
}