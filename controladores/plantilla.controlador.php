<?php

class ControladorPlantilla{

	static public function ctrPlantilla(){
		
			include "vistas/plantilla.php";
			

	}	

	static public function ctrConfiguracion(){
		$item = null;
		$valor = null;
		$tabla = "tiposervicios";
		$respuesta = ModeloServicios::mdlMostrarServiciosPersona($tabla, $item, $valor);
		return $respuesta;
	}

	static public function ctrCambiarEstadoCronograma(){
		date_default_timezone_set("America/Lima");
		setlocale(LC_ALL, 'spanish');
		$tabla = "cronograma_pago";
		$fechaActual = date("Y-m-d H:i:s");

		$respuesta = ModeloCobros::mdlFechaVencido();
		
		foreach ($respuesta as $key => $value) {
			$tabla = "cronograma_pago";
			$fecha_actual = strtotime($fechaActual);
			$fecha_entrada = strtotime($value['fechas_pagos']);

			if($fecha_actual > $fecha_entrada){
					$idCronograma = $value['idcronograma_pago'];
			       	$res = ModeloCobros::mdlActualizarCronogramaVencidos($tabla, $idCronograma);
			       	var_dump($res);

			}
		}
	}


}
//ControladorPlantilla::ctrCambiarEstadoCronograma();	
