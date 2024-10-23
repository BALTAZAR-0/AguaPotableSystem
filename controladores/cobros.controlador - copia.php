<?php
class ControladorCobros{
	
	/*=============================================
	MOSTRAR DETALLE DE  COBROS
	=============================================*/

	static public function ctrMostrarDetalleCobros($item, $valor){

		$tabla = "detalle_pagos";

		$respuesta = ModeloCobros::mdlMostrarCobros($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	CREAR VENTA
	=============================================

	static public function ctrActualizarCliente(){

		//--------------------------------------------------

			$tablaClientes = "personas";

			$item = "idpersona";
			$valor = $_POST["idpersona"];
			//$valor = $respuesta[0]['idpersonas'];

			$traerCliente = ModeloPersonas::mdlMostrarPersonas($tablaClientes, $item, $valor);

			$item1a = "cobro";
				
			$valor1a = $_POST["lecturaMedidor"];
			//$valor1a = $respuesta[0]['lecturamedidor'];

			$comprasCliente = ModeloPersonas::mdlActualizarCliente($tablaClientes, $item1a, $valor1a, $valor);

			$item1b = "ultimo_cobro";

			date_default_timezone_set('America/Lima');

			$fecha = date('Y-m-d');
			$hora = date('H:i:s');
			$valor1b = $fecha.' '.$hora;

			$fechaCliente = ModeloPersonas::mdlActualizarCliente($tablaClientes, $item1b, $valor1b, $valor);

			//--------------------------------------------------

	}*/



	/*
	* Realizo una consulta al servicio para posteriormente almacenar en la base de datos
	* un recibo de pago que pertenesca a la fecha
	 */
	static public function ctrConsultarServicioId($datos){

		date_default_timezone_set("America/Lima");
		setlocale(LC_ALL, 'spanish');
		$idservicio = $datos['consultarServicioId'];
		$lecturaMedidor = $datos['lecturaMedidor'];
		$lecturaMedidoranterior = $datos['lecturaMedidoranterior'];
		$mesFacturado = $datos['mesFacturado'];
		$fechaVence = $datos['nuevoFechaVencimiento'];
		$codigoRecibo = $datos['codigoRecibo'];
		$meses = array("mescero","Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");


		$mes = (int)explode("-", $mesFacturado)[0];
		$year = (int)explode("-", $mesFacturado)[1];
		$mesF = $meses[$mes]." - ".$year;

		$respuesta = ModeloCobros::mdlConsultarPagoExisteId($idservicio, $mesF);
		
		// valido que no se duplica un recibo del mismo mes
		if(is_array($respuesta) && empty($respuesta)){

			$respuesta = ModeloCobros::mdlConsultarServicioId($idservicio);

			//$idpersonas = $respuesta[0]['idpersonas'];
			$id = $respuesta[0]['idservicio'];
			$lecturaAnterior = $lecturaMedidoranterior;
			$calculalectura= $lecturaAnterior-$lecturaMedidor;
			$newlectura = str_replace("-"," ",$calculalectura);
			$igv = $respuesta[0]['igv'];

			//subtotal * 0.18
			$cargoFijo = $respuesta[0]['cargofijo'];
			$otrosCobros = $respuesta[0]['otroscobros'];
			$mora = $respuesta[0]['mora'];
			$valor = $respuesta[0]['valor1'];
			if($lecturaMedidor > 8){
				$valor = $respuesta[0]['valor2'];
			}

			$subTotal = $newlectura * $valor;
			$igv = $subTotal * $igv;
			$total = $subTotal + $igv + $cargoFijo + $otrosCobros;
		
			$tabla1 = "recibopagos";

			$datos = [
				'idservicios' => $id,
				'codigo' => $codigoRecibo,
				'codigomedidor' => $respuesta[0]['codigomedidor'],
				'totalM3' => $lecturaMedidor,
				'valorM3' => $valor,
				'subtotal' => $subTotal,
				'igv' => $igv,
				'cargofijo' => $cargoFijo,
				'otroscobros' => $otrosCobros,
				'mora' => 0,
				'month_billed' => $mesF,
				'date_expires' => $fechaVence,
				'totalpagar' => $total,
				'estado' => 1,
			];
			$idRecibo = ModeloCobros::mdlIngresarCobros($tabla1, $datos);


			/*--------------------------------------------------

			$tablaClientes = "personas";

			$item = "idpersona";
			$valor = $_POST["idpersona"];
			//$valor = $respuesta[0]['idpersonas'];

			$traerCliente = ModeloPersonas::mdlMostrarPersonas($tablaClientes, $item, $valor);

			$item1a = "cobro";
				
			$valor1a = $_POST["lecturaMedidor"];
			//$valor1a = $respuesta[0]['lecturamedidor'];

			$comprasCliente = ModeloPersonas::mdlActualizarCliente($tablaClientes, $item1a, $valor1a, $valor);

			$item1b = "ultimo_cobro";

			date_default_timezone_set('America/Lima');

			$fecha = date('Y-m-d');
			$hora = date('H:i:s');
			$valor1b = $fecha.' '.$hora;

			$fechaCliente = ModeloPersonas::mdlActualizarCliente($tablaClientes, $item1b, $valor1b, $valor);

			//--------------------------------------------------*/


			

			
			//sumo 1 mes
			//$nuevaFecha = date("Y-m-d",strtotime($fechaV."+ 1 month")); 
			$tabla = "servicios";
			$datosUpdate = [
				'idservicios' => $id,
				'estado' => 1,
				'date_to' => $fechaVence,
				'lecturamedidor' => $newlectura
			];

			$modificarServicio = ModeloCobros::mdlActualizarServicioDateTo($tabla, $datosUpdate);

			
			if($modificarServicio == "ok"){
				$data = [
					'status' => 'success',
					'code' => 200,
					'datos' => $datos,
					'recibo' => $idRecibo
				];
				
			} 
			else {
				$data = [
					'status' => 'error',
					'message' => 'Error en el registro',
					'code' => 400
				];
			}

		} else {
			$data = [
					'status' => 'error',
					'message' => 'El sistema detecto que ya existe un recibo con esta fecha',
					'code' => 400
				];
			
		}
		return $data;

	}

	/*=============================================
	MOSTRAR CONTRATOS
	=============================================*/

	static public function ctrMostrarCobrosSerieA($item, $valor){

		$tabla = "cobros";

		$respuesta = ModeloCobros::mdlMostrarCobrosSerieA($tabla, $item, $valor);

		return $respuesta;

	}

	static public function ctrcalcularCobro($item, $valor){
		$tabla = "recibopagos";

		$respuesta = ModeloCobros::mdlCalcularReciboPago($tabla, $item, $valor);

		return $respuesta;
	}


	static public function ctrMostrarCronograma($item, $valor){

		$tabla = "persona_servicio_cobros";

		$respuesta = ModeloCobros::mdlMostrarCronograma($tabla, $item, $valor);

		
		return $respuesta;

	}

	static public function ctrMostrarCobrosReporte($item, $valor){

		$tabla = "editar_cobro";

		$respuesta = ModeloCobros::mdlMostrarCobrosReporte($tabla, $item, $valor);

		return $respuesta;

	}

	static public function ctrMostrarCronogramaPago($item, $valor){

		$tabla = "detalle_servicio";

		$respuesta = ModeloCobros::mdlMostrarCronogramaPago($tabla, $item, $valor);

		
		return $respuesta;

	}


	static public function ctrEliminarCobro($valor){

		$tabla0 = "cronograma_pago";
		$tabla1 = "cobros";
		$tabla2 = "detalle_cobros";

		$respuesta4 = "";

		$respuesta = ModeloCobros::mdlObtenercronograma($tabla2,$valor);

		if ($respuesta != null){
			foreach ($respuesta as $value) {
				$respuesta2 = ModeloCobros::mdlActualizarCrono($tabla0,$value["idcronograma_pago"]);
			}
			$respuesta3 = ModeloCobros::mdlEliminarCobros($tabla2, $valor);
			if($respuesta3 == "ok"){
				$respuesta4 = ModeloCobros::mdlEliminarCobros($tabla1, $valor);
			}

			
		}	

		
		return $respuesta4;

	}

	// mostramos los datos del tetalle del cobro 7 abril 2021
	static public function ctrGetDetalleCobro($item,$valor){

		$tabla = "mostrar_detalle_pagos";

		$respuesta = ModeloCobros::mdlMostrarDetalleCobro($tabla,$item, $valor);

		
		return $respuesta;

	}

	static public function ctrUltimoPago($valor){

		$tabla = "cronograma_pago";

		$respuesta = ModeloCobros::mdlUltimoPago($tabla,$valor);

		
		return $respuesta;

	}

	static public function ctrMesesFlatantes($valor){

		$respuesta = ModeloCobros::mdlMesesFlatantes($valor);

		
		return $respuesta;

	}


	/* Este codigo es para mostrar todo desde vista de la base de datos */	

	static public function ctrMostrarContratosCompleta($item, $valor){

		$tabla = "servicios_completo";

		$respuesta = ModeloContratos::mdlMostrarContratosCompleta($tabla, $item, $valor);

		return $respuesta;

	}

	
	/*=============================================
	CREAR CONTRATOS
	=============================================*/

	static public function ctrGuardarPagos($cadena){
		$update = "error";
		$cobroActualizado = "";
		//$data = json_decode($cadena);
		$tipoServicio = ModeloCobros::mdlConsultarTipoServicio();

		if(is_array($tipoServicio) && !empty($tipoServicio)){

			/*[0]newtotalm3, [1]newvalorm3, [2]newsubtotal, [3]newigv, [4]newcargofijo, [5]newotroscobros, [6]newmora, [7]newtotal, [8]idservicio, [9]idusuario, [10]fecha,  [11]valorpaga, [12]nuevocambio, [13]arrayPagosSeleccionados
			datos que estan en el segundo array.
			* [0]idPago, [1]totalM3, [2]valorM3, [3]cargofijo, [4]otroscobros, [5]mora */

			//datos para crear el ditalle del servicio


			$datos = array(
				"idservicios" => $cadena[0][8],
				"totalM3" => $cadena[0][0],
				"valorM3" => $cadena[0][1],
				"subtotal" => $cadena[0][2],
				"igv" => $cadena[0][3],
				"cargofijo" => $cadena[0][4],
				"otroscobros" => $cadena[0][5],
				"mora" => $cadena[0][6],
				"totalpagar" => $cadena[0][7],
				"estado" => 0,
				"tipocobranza" => "Efectivo",
				"nro_transacion" => "",
				"lugarpago" => "Ventanilla",
				"dineropagado" => $cadena[0][11],
				"cambio" => $cadena[0][12],
			);

			$tabla = "detallepagos";
			$idDetalle = ModeloCobros::mdlIngresarDetalleCobros($tabla, $datos);
			
			if($idDetalle > 0){
				$tabla1 = "recibopagos";
				foreach ($cadena[0][13] as $key => $value) {
				/* * [0]idPago, [1]totalM3, [2]valorM3, [3]cargofijo, [4]otroscobros, [5]mora */
					 
					$datos = array(
						"idPago" => $value[0],
						"estado" => 0,
						"update_at" => $cadena[0][10],
						"iddetallepago" => $idDetalle
					);
					$cobroActualizado = ModeloCobros::mdlActualizarCobro($tabla1, $datos);
					
					
				}

				$tabla2 = "recibopagos";
				$item = "idservicios";
				$valor = $cadena[0][8];
				if($cobroActualizado == "ok"){
					$update = "ok";
				} else {
					$update = "error";
				}
				$respuesta = ModeloCobros::mdlServiciosPersona($tabla2, $item, $valor);
				

				if(is_array($respuesta) && empty($respuesta)){
					
					$tabla = "servicios";
					$datos = array(
						"estado" => 0,
						"update_at" => $cadena[0][10],
						"idservicio" => $valor
					);

					$servicio = ModeloCobros::mdlActualizarServicio($tabla, $datos);
					if($servicio == "ok"){
						$update = "ok";
					}
					
				}
				
			}
		}
		echo $update;

	}


	/* 
	*  guardo un detalle de parte del cliente en estado pendiente
	*/
		static public function ctrGuardarPagosPendiente($cadena){
		$update = [
				"status" => 'error',
				"code" => 400,
				'message' => "error al intentar realizar el pago",
			];
		$cobroActualizado = "";
		// realizo consulta para saber si el nrotransacion existe
		//select * from detallepagos where nro_transacion = "23323232332"
		$tabla = "detallepagos";
		$item = "nro_transacion";
		$valor = $cadena[0][12];
		$detallePago = ModeloCobros::mdlMostrarCobrosReporte($tabla, $item, $valor);
		if(is_array($detallePago) && !empty($detallePago)){
			//var_dump($detallePago);
			$update = [
				"status" => 'error',
				"code" => 400,
				'message' => "el numero de transación ya fue utilizado",
			];
		} else {
		
		//$data = json_decode($cadena);
		$tipoServicio = ModeloCobros::mdlConsultarTipoServicio();

		if(is_array($tipoServicio) && !empty($tipoServicio)){

			/*[0]newtotalm3, [1]newvalorm3, [2]newsubtotal, [3]newigv, [4]newcargofijo, [5]newotroscobros, [6]newmora, [7]newtotal, [8]idservicio, [9]idusuario, [10]fecha,  [11]valorpaga, [12]nuevocambio, [13]arrayPagosSeleccionados
			datos que estan en el segundo array.
			* [0]idPago, [1]totalM3, [2]valorM3, [3]cargofijo, [4]otroscobros, [5]mora */

			//datos para crear el ditalle del servicio


			$datos1 = array(
				"idservicios" => $cadena[0][8],
				"totalM3" => $cadena[0][0],
				"valorM3" => $cadena[0][1],
				"subtotal" => $cadena[0][2],
				"igv" => $cadena[0][3],
				"cargofijo" => $cadena[0][4],
				"otroscobros" => $cadena[0][5],
				"mora" => $cadena[0][6],
				"totalpagar" => $cadena[0][7],
				"estado" => 1,
				"tipocobranza" => "Cuenta",
				"nro_transacion" => $cadena[0][12],
				"lugarpago" => "Página",
				"dineropagado" => 0,
				"cambio" => 0,
			);

			$tabla = "detallepagos";
			$idDetalle = ModeloCobros::mdlIngresarDetalleCobros($tabla, $datos1);
			
			if($idDetalle > 0){
				$tabla1 = "recibopagos";
				foreach ($cadena[0][11] as $key => $value) {
				/* * [0]idPago, [1]totalM3, [2]valorM3, [3]cargofijo, [4]otroscobros, [5]mora */
					 
					$datos2 = array(
						"idPago" => $value[0],
						"estado" => 3,
						"update_at" => $cadena[0][10],
						"iddetallepago" => $idDetalle
					);
					$cobroActualizado = ModeloCobros::mdlActualizarCobro($tabla1, $datos2);
					
					
				}

				$tabla2 = "recibopagos";
				$item = "idservicios";
				$valor = $cadena[0][8];
				if($cobroActualizado == "ok"){
					$update = [
							"status" => 'success',
							"code" => 200,
							'datos_detalle' => $datos1,
							'datos_recibo' => $datos2
						];
				}
				$respuesta = ModeloCobros::mdlServiciosPersona($tabla2, $item, $valor);
				

				if(is_array($respuesta) && empty($respuesta)){
					
					$tabla = "servicios";
					$datos = array(
						"estado" => 0,
						"update_at" => $cadena[0][10],
						"idservicio" => $valor
					);

					$servicio = ModeloCobros::mdlActualizarServicio($tabla, $datos);
					if($servicio == "ok"){
						$update = [
							"status" => 'success',
							"code" => 200,
							'datos_detalle' => $datos1,
							'datos_recibo' => $datos2
						];
					}
					
				}
				
			}
		}
	}
		return $update;

	}


	//modificar el estado del servicio  y servicios pendientes
	static public function ctrActualizarPagosPendiente($valor, $nroTransacion){
		date_default_timezone_set("America/Lima");
		setlocale(LC_ALL, 'spanish');
		$fechaActual = date('Y-m-d');
		$data = [
			"status" => "error",
			"code" => 400,
			"message" => "error el servicio no cuenta con pagos pendientes"
		];

		//SELECT * from recibopagos WHERE iddetallepago = 19 and estado = 3
		
		$respuesta = ModeloCobros::mdlConsultarPagosPendientes($valor);
		
		
		if(count($respuesta) != 0) {
			$idServicio = $respuesta[0]['idservicios'];

			// valido si el nro_transacion tuvo un error de dijitación
			if($nroTransacion != null){
				$tabla = "detallepagos";
				$get = null;
				$where = " nro_transacion = $nroTransacion";
				$servicio = ModeloCobros::mdlConsultarItems($tabla, $get, $where);
				
				if(count($servicio) != 0){
					$data = [
						"status" => "error",
						"code" => 400,
						"message" => "numero de transación ya existe"
					]; 
					return $data;
				} else {
					$tabla = "detallepagos";
					$item = ['nro_transacion', 'iddetalle'];
					$datos = [$nroTransacion, $valor];
					$detallePago = ModeloCobros::mdlActualizarItem($tabla, $item, $datos);

				}
			}
			
			//UPDATE recibopagos set estado = 0 WHERE iddetallepago = 19

			$tabla = "recibopagos";
			$actualizar = ModeloCobros::mdlActualizarPagosServicioPendientes($tabla, $valor);

			if($actualizar == "ok"){
				$tabla = "detallepagos";
				$datosUpdate = [
					"iddetalle" => $valor
				];
				//UPDATE detallepagos set estado = 0, update_at = "2021-04-20" WHERE iddetalle = 20
				$actualizar = ModeloCobros::mdlActualizarPagosPendientes($tabla, $datosUpdate);

				/*
				* Consulto si el servicio tiene mas pagos pendientes si no tiene actualizo el estado
				*SELECT * from mostrar_detalle_servicio where idservicio = 2 and estado = 1
				*/
				$tabla = "mostrar_detalle_servicio";
				$get = null;
				$where = " idservicio = $idServicio and estado = 1";
				$servicio = ModeloCobros::mdlConsultarItems($tabla, $get, $where);
				if(count($servicio) == 0){
					$tabla = "servicios";
					$data = [
						"estado" => 0,
						"update_at" => $fechaActual,
						"idservicio" => $idServicio
					];
					ModeloCobros::mdlActualizarServicio($tabla, $data);
				}
				


				$data = [
					"status" => "success",
					"code" => 200,
					"message" => "Registro actualizado con exito"
				];
				
		}
			
			
		}
	
		return $data;

	}


	// funcion para rechazar el pago
	static public function ctrRechazarPago($valor){
		/*
		*cambiar el estado del recibo a 4
		*cambiar el estado del detalle de pago a 2
		*consultar al servicio por id de detalle preguntar si el estado es igual a 0 
		entonces cambiar el estado a 1 para que el servicio quede como pendiente
		*/
		date_default_timezone_set("America/Lima");
		setlocale(LC_ALL, 'spanish');
		$fechaActual = date('Y-m-d');

		$tabla = "recibopagos";
		$item = ["estado", "iddetallepago"];
		$datos = [4, $valor];
		$respuesta = ModeloCobros::mdlActualizarItem($tabla, $item, $datos);

		if($respuesta == "ok"){
			$tabla = "detallepagos";
			$item = ["estado", "update_at", "iddetalle"];
			$datos = [2, $fechaActual, $valor];
			$respuesta = ModeloCobros::mdlActualizarItem($tabla, $item, $datos);

			if($respuesta == "ok"){
				$servicio = ModeloCobros::mdlConsultarServicioDetalle($valor);
				if(is_array($servicio) && !empty($servicio)){
					$tabla = "servicios";
					$idServicio = $servicio[0]['idservicio'];
					$item = ["estado", "update_at", "idservicio"];
					$datos = [1, $fechaActual, $idServicio];
					$respuesta = ModeloCobros::mdlActualizarItem($tabla, $item, $datos);

				}
				
			}
		}

		
		return $respuesta;
	}

	/*=============================================
	RANGO FECHAS
	=============================================*/	

	static public function ctrRangoFechasContratos($fechaInicial, $fechaFinal){

		$tabla = "servicios";

		$respuesta = ModeloContratos::mdlFechasContratos($tabla, $fechaInicial, $fechaFinal);

		return $respuesta;
		
	}



	/*=============================================
	EDITAR CONTRATOS
	=============================================*/

	static public function ctrEditarContratos(){

		if(isset($_POST["nuevoNombreCliente"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoNombreCliente"]) &&
			   preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoTipoServicio"])){

			   	$tabla = "servicios";

			   	$datos = array("idservicios"=>$_POST["idservicios"],
			   				   "codigo"=>$_POST["nuevoCodigo"],
					           "idusuario"=>$_POST["IdUsuario"],
					           "idpersona"=>$_POST["idpersona"],
					           "numromeses"=>$_POST["nuevoMeses"],
					           "idtipo_servicios"=>$_POST["idtipo_servicios"]);

			   	$respuesta = ModeloContratos::mdlEditarContratos($tabla, $datos);

			   	if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "El contrato de servicio ha sido actualizado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "personas";

									}
								})

					</script>';

				}

			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡El contrato de servicio no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "personas";

							}
						})

			  	</script>';



			}

		}

	}	


	/*=============================================
	ELIMINAR CONTRATOS
	=============================================*/

	static public function ctrEliminarContrato(){

		if(isset($_GET["idservicios"])){

			$tabla ="servicios";
			$datos = $_GET["idservicios"];

			$respuesta = ModeloContratos::mdlEliminarContrato($tabla, $datos);

			if($respuesta == "ok"){

				echo'<script>

				swal({
					  type: "success",
					  title: "El cliente ha sido borrado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar",
					  closeOnConfirm: false
					  }).then(function(result){
								if (result.value) {

								window.location = "personas";

								}
							})

				</script>';

			}		

		}

	}	




	


}