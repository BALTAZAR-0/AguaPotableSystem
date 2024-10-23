<?php

class ControladorServicios{
	

	/*=============================================
	CREAR SERVICIOS
	=============================================*/

	static public function ctrCrearServicio(){

		if(isset($_POST["nuevoNombreServicio"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoNombreServicio"]) &&
			   preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoTipoServicio"])){

			   	$tabla = "tipo_servicios";

			   	$datos = array("nombre"=>$_POST["nuevoNombreServicio"],
					           "descripcion"=>$_POST["nuevoTipoServicio"],
					           "cantidad_bolsa"=>$_POST["nuevoCatidadBolsas"],
					           "valor_servicio"=>$_POST["nuevoValorServicio"]);

			   	$respuesta = ModeloServicios::mdlIngresarServicio($tabla, $datos);

			   	if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "El servicio ha sido guardado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "servicios";

									}
								})

					</script>';

				}

			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡El servicio no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "servicios";

							}
						})

			  	</script>';



			}

		}

	}

	/*=============================================
	MOSTRAR TIPO DE SERVICIO
	=============================================*/
	static public function ctrMostrarServicios($item, $valor){


		$tabla = "tiposervicios";

		$respuesta = ModeloServicios::mdlMostrarServicios($tabla, $item, $valor);

		return $respuesta;

	}

	/*=============================================
	EDITAMOS EL TIPO DE SERVICIO
	=============================================*/

	static public function ctrEditarTipoServicio(){
		if(isset($_POST['nuevo_nombre_de_servicio'], $_POST['id_servicio'])){
			if(isset($_POST['valor1'], $_POST['valor2'], $_POST['igv'], $_POST['cargo_fijo'], $_POST['otros_cobros'], $_POST['mora'], $_POST['descripcion'])){
				
				$datos = [
					'idtiposervicio' => $_POST['id_servicio'],
					'nombre' => $_POST['nuevo_nombre_de_servicio'],
					'valor1' => $_POST['valor1'],
					'valor2' => $_POST['valor2'],
					'igv' => $_POST['igv'],
					'cargofijo' => $_POST['cargo_fijo'],
					'otroscobros' => $_POST['otros_cobros'],
					'mora' => $_POST['mora'],
					'descripcion' => $_POST['descripcion']
				];
				$tabla = "tiposervicios";
				$respuesta = ModeloServicios::mdlEditarTipoServicio($tabla, $datos);

				if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "servicio ha sido actualizado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "servicios";

									}
								})

					</script>';

				}

			else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡El servicio no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "servicios";

							}
						})

			  	</script>';

				}
			}
		}
	}

	static public function ctrMostrarContratosServicios($item, $valor1,$valor2){

		$tabla = "mostrar_servicio_persona";

		$respuesta = ModeloServicios::mdlMostrarContratosServicios($tabla, $item, $valor1,$valor2);

		return $respuesta;

	}

	static public function ctrMostrarServiciosPersona($item, $valor){

		$tabla = "servicios";

		$respuesta = ModeloServicios::mdlMostrarServiciosPersona($tabla, $item, $valor);

		return $respuesta;

	}

	

	/*=============================================
	EDITAR SERVICIOS
	=============================================*/

	static public function ctrEditarServicio(){



		if(isset($_POST["editarNombreServicio"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarNombreServicio"]) &&
			   preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarTipoServicio"])){

			   	$tabla = "tipo_servicios";

			   	$datos = array("idtipo_servicios"=>$_POST["idtipo_servicios"],
			   				   "nombre"=>$_POST["editarNombreServicio"],
					           "descripcion"=>$_POST["editarTipoServicio"],
					           "cantidad_bolsa"=>$_POST["editarCatidadBolsas"],
					           "valor_servicio"=>$_POST["editarValorServicio"]);

			   	$respuesta = ModeloServicios::mdlEditarServicio($tabla, $datos);

			   	if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "El servicio ha sido actualizado correctamente",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
									if (result.value) {

									window.location = "servicios";

									}
								})

					</script>';

				}

			}else{

				echo'<script>

					swal({
						  type: "error",
						  title: "¡El servicio no puede ir vacío o llevar caracteres especiales!",
						  showConfirmButton: true,
						  confirmButtonText: "Cerrar"
						  }).then(function(result){
							if (result.value) {

							window.location = "servicios";

							}
						})

			  	</script>';



			}

		}

	}

	/*=============================================
	ELIMINAR SERVICIOS
	=============================================*/

	static public function ctrEliminarServicio(){

		if(isset($_GET["idtipo_servicios"])){

			$tabla ="tipo_servicios";
			$datos = $_GET["idtipo_servicios"];

			$respuesta = ModeloServicios::mdlEliminarServicio($tabla, $datos);

			if($respuesta == "ok"){

				echo'<script>

				swal({
					  type: "success",
					  title: "El servicio ha sido borrado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar",
					  closeOnConfirm: false
					  }).then(function(result){
								if (result.value) {

								window.location = "servicios";

								}
							})

				</script>';

			}		

		}

	}

}

