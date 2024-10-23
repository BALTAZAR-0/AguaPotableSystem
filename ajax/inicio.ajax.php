<?php
require_once "../controladores/contratos.controlador.php";
require_once "../modelos/contratos.modelo.php";


class InicioAjax {
	public $dni;

	public function mostrarRecibos(){
		$data = [
			"status" => "error",
			"code" => 404,
			"message" => "el cliente no cuenta con servicios activos"
		];

		$item = "documento";
		$valor = $this->dni;
		$respuesta = ControladorContratos::ctrMostrarContratosReporte($item, $valor);
		
		if(is_array($respuesta) && !empty($respuesta)){
			session_start();
			$_SESSION['datosServicio'] = $valor;
			$data = [
			"status" => "success",
			"code" => 200,
			];
		}

		echo json_encode($data);
	}

}

if(isset($_POST['dni'])){
	
	$ini = new InicioAjax();
	$ini->dni = $_POST['dni'];
	$ini->mostrarRecibos();
}

?>