<?php

class ControladorPersonas{
	

	/*=============================================
	CREAR CLIENTES
	=============================================*/

	static public function ctrCrearPersona(){

		if(isset($_POST["nuevoNombres"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nuevoNombres"])){
				// &&			 preg_match('/^[()\-0-9 ]+$/', $_POST["nuevoTelefono"])

			   	$tabla = "personas";

			   	$datos = array("nombres"=>$_POST["nuevoNombres"],
					           "apaterno"=>$_POST["nuevoApellidoPaterno"],
					           "amaterno"=>$_POST["nuevoApellidoMaterno"],
					           "documento"=>$_POST["nuevoDocumento"],
					           "sexo"=>$_POST["sexo"],
					           "fecha_nacimiento"=>$_POST["nuevoFechaNacimiento"],
					           "telefono"=>$_POST["nuevoTelefono"],
					           "zona"=>$_POST["nuevoZona"],
					           "direccion"=>$_POST["nuevoDireccion"],
					           "email"=>$_POST["nuevoEmail"]);

			   	$respuesta = ModeloPersonas::mdlIngresarPersona($tabla, $datos);
			   
			   	if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "El cliente ha sido guardado correctamente",
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
						  title: "¡El Cliente no puede ir vacío o llevar caracteres especiales!",
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
	MOSTRAR CLIENTES
	=============================================*/

	static public function ctrMostrarPersonas($item, $valor){

		$tabla = "personas";

		$respuesta = ModeloPersonas::mdlMostrarPersonas($tabla, $item, $valor);

		return $respuesta;

	}


	static public function ctrMostrarPersonaServicio($item, $valor){

		$tabla = "persona_servicio";

		$respuesta = ModeloPersonas::mdlMostrarPersonaServicio($tabla, $item, $valor);

		return $respuesta;

	}

	static public function ctrMostrarPersona($item, $valor){

		$tabla = "personas";

		$respuesta = ModeloPersonas::mdlMostrarPersona($tabla, $item, $valor);

		return $respuesta;

	}
	

	/*=============================================
	EDITAR CLIENTE
	=============================================*/

	static public function ctrEditarPersona(){

		if(isset($_POST["editarNombres"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["editarNombres"])){
			// &&preg_match('/^[()\-0-9 ]+$/', $_POST["editarTelefono"])
			   	$tabla = "personas";

			   	$datos = array("idpersona"=>$_POST["idpersona"],
			   				   "nombres"=>$_POST["editarNombres"],
					           "apaterno"=>$_POST["editarApellidoPaterno"],
					           "amaterno"=>$_POST["editarApellidoMaterno"],
					           "documento"=>$_POST["editarDocumento"],
					           "sexo"=>$_POST["editarSexo"],
					           "fecha_nacimiento"=>$_POST["editarFechaNacimiento"],
					           "telefono"=>$_POST["editarTelefono"],
					           "zona"=>$_POST["editarZona"],
					           "direccion"=>$_POST["editarDireccion"],
					           "email"=>$_POST["editarEmail"]);

			   	$respuesta = ModeloPersonas::mdlEditarPersona($tabla, $datos);

			   	if($respuesta == "ok"){

					echo'<script>

					swal({
						  type: "success",
						  title: "El Cliente ha sido actualizado correctamente",
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
						  title: "¡El cliente no puede ir vacío o llevar caracteres especiales!",
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
	ELIMINAR CLIENTE
	=============================================*/

	static public function ctrEliminarPersona(){

		if(isset($_GET["idPersona"])){

			$tabla ="personas";
			$datos = $_GET["idPersona"];

			$respuesta = ModeloPersonas::mdlEliminarPersona($tabla, $datos);

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

