<?php
class ControladorContratos{

	/*=============================================
	MOSTRAR ULTIMO LECTURA
	=============================================*/

	static public function ctrMostrarUltimalectura($item, $valor){

		//$tabla = "servicios";
		$tabla = "recibopagos";

		$respuesta = ModeloContratos::mdlMostrarUltimalectura($tabla, $item, $valor);

		return $respuesta;

	}

		/*=============================================
	MOSTRAR ULTIMO LECTURA SERVICIO
	=============================================*/

	static public function ctrMostrarUltimalecturaServicio($item, $valor){

		//$tabla = "servicios";
		$tabla = "mostrar_detalle_servicio";

		$respuesta = ModeloContratos::mdlMostrarUltimalecturaServicio($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	MOSTRAR CONTRATOS
	=============================================*/

	static public function ctrMostrarContratos($item, $valor){

		//$tabla = "servicios";
		$tabla = "mostrar_servicio_persona";

		$respuesta = ModeloContratos::mdlMostrarContratos($tabla, $item, $valor);

		return $respuesta;

	}


	static public function ctrMostrarContratosCodigo($item, $valor){

		$tabla = "servicios";

		$respuesta = ModeloContratos::mdlMostrarContratosCodigo($tabla, $item, $valor);

		return $respuesta;

	}


	static public function ctrMostrarContratosReporte($item, $valor){

		$tabla = "mostrar_detalle_servicio";

		$respuesta = ModeloContratos::mdlMostrarContratosReporte($tabla, $item, $valor);

		return $respuesta;

	}

	static public function ctrMostrarServiciosReporte($valor,$valor2){

		$tabla = "mostrar_servicio_persona";

		$respuesta = ModeloContratos::mdlMostrarServiciosReporte($tabla, $valor,$valor2);

		return $respuesta;

	}

	static public function ctrMostrarCobros($item, $valor){

		$tabla = "cronograma_pago";

		$respuesta = ModeloContratos::mdlMostrarCobros($tabla, $item, $valor);

		return $respuesta;

	}

	static public function ctrEliminarServicio($item, $valor){

		$tabla = "mostrar_servicio_persona";

		$respuesta = ModeloContratos::mdlMostrarContratos($tabla, $item, $valor);



		if (count($respuesta) != 0){			
			$tabla = "servicios";
			$res2 = ModeloContratos::mdlEliminarServicio($tabla, $item, $valor);

				if ($res2 == "ok") {

					return "ok";
					
				}else{
					return "error";
				}

			
		}else {
			return "error";

		}

	}


	/* Este codigo es para mostrar todo desde vista de la base de datos */	

	static public function ctrMostrarContratosCompleta($item, $valor){

		$tabla = "servicios_completo";

		$respuesta = ModeloContratos::mdlMostrarContratosCompleta($tabla, $item, $valor);

		return $respuesta;

	}

	static public function ctrEditarServicio($item, $valor){

		$tabla = "mostrar_detalle_servicio";

		$respuesta = ModeloContratos::mdlEditarServicio($tabla, $item, $valor);

		return $respuesta;

	}

	
	/*=============================================
	CREAR CONTRATOS
	=============================================*/

	static public function ctrCrearContratos(){
		date_default_timezone_set("America/Lima");
		setlocale(LC_ALL, 'spanish');
		
		$permitidos = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_";
		//'/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/'
		if(isset($_POST["nuevoCodigo"])){

			/*if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoCodigo"]) &&
			   preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["numeroMedidor"])){*/

			   	$tabla = "servicios";
			   $idservicio = 1;
			   $idCliente = $_POST["idpersona"];
			   $serviciosClient = ModeloContratos::mdlUsuarioServicio('servicios', $idCliente);
			   if(is_array($serviciosClient) && empty($serviciosClient)){

				   	$datos = array("codigo"=>$_POST["nuevoCodigo"],
						           "idusuario"=>$_POST["IdUsuario"],
						           "idpersona"=>$_POST["idpersona"],
						           "numeroMedidor"=>$_POST["numeroMedidor"],
						           "idservicio"=>$idservicio
					);

			   		$respuesta = ModeloContratos::mdlIngresarContratos($tabla, $datos);
						/*
					   	$res = ModeloContratos::mdlIngresarCronogramaPagos($datos2);
					   	echo $res;  */
					   	if($respuesta > 0){

							echo'<script>

							swal({
								  type: "success",
								  title: "Nueva lectura generada correctamente",
								  showConfirmButton: true,
								  confirmButtonText: "Cerrar"
								  }).then(function(result){
											if (result.value) {

											window.location = "contratos";

											}
										})

							</script>';

						}

					}else{

						echo'<script>

							swal({
								  type: "error",
								  title: "¡El contrato de servicio no puede ir vacío o llevar caracteres especiales e incluso tener dos servicios!",
								  showConfirmButton: true,
								  confirmButtonText: "Cerrar"
								  }).then(function(result){
									if (result.value) {

									window.location = "contratos";

									}
								})

					  	</script>';



					}

				//}
			}

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


	static public function ctrMostrarServicioRecibo($item, $valor){

		$tabla = "servicios";

		$respuesta = ModeloContratos::mdlMostrarContratoRecibo($tabla, $item, $valor);

		return $respuesta;

	}


		/*=============================================
	MOSTRAR PENULTIMO LECTURA
	=============================================*/

	static public function ctrMostrarPenultimalectura($item, $valor){

		//$tabla = "servicios";
		$tabla = "recibopagos";

		$respuesta = ModeloContratos::mdlMostrarPenultimolectura($tabla, $item, $valor);

		return $respuesta;

	}


	


}