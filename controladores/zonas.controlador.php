<?php 
class ControladorZona {


	static public function ctrCrearZona(){
		if(isset($_POST['nuevoNombre'])){
			if(!empty($_POST['nuevoNombre'])){
				$tabla = "zonas";
				$datos = [
					"nombrezona" => $_POST['nuevoNombre']
				];
				$respuesta = ModeloZonas::mdlCrearZona($tabla, $datos);
				
				if($respuesta == "ok"){
					echo'<script>

							swal({
								  type: "success",
								  title: "La zona ha sido guardado correctamente",
								  showConfirmButton: true,
								  confirmButtonText: "Cerrar"
								  }).then(function(result){
											if (result.value) {

											window.location = "zonas";

											}
										})

							</script>';
						} else {
							echo'<script>

							swal({
								  type: "error",
								  title: "¡El contrato de servicio no puede ir vacío o llevar caracteres especiales e incluso tener dos servicios!",
								  showConfirmButton: true,
								  confirmButtonText: "Cerrar"
								  }).then(function(result){
									if (result.value) {

									window.location = "zonas";

									}
								})

					  	</script>';
						}
			}
		}
	}

	static public function ctrEditarZona(){
		if(isset($_POST['editarNombre']) && isset($_POST['editarIdZona'])){
			if(!empty($_POST['editarNombre']) && !empty($_POST['editarIdZona'])){
				$tabla = "zonas";
				$datos = [
					"nombrezona" => $_POST['editarNombre'],
					"idzona" => $_POST['editarIdZona']
				];
				$respuesta = ModeloZonas::mdlEditarZona($tabla, $datos);
				if($respuesta == "ok"){
					echo'<script>

							swal({
								  type: "success",
								  title: "La zona ha sido guardado correctamente",
								  showConfirmButton: true,
								  confirmButtonText: "Cerrar"
								  }).then(function(result){
											if (result.value) {

											window.location = "zonas";

											}
										})

							</script>';
						} else {
							echo'<script>

							swal({
								  type: "error",
								  title: "¡El contrato de servicio no puede ir vacío o llevar caracteres especiales e incluso tener dos servicios!",
								  showConfirmButton: true,
								  confirmButtonText: "Cerrar"
								  }).then(function(result){
									if (result.value) {

									window.location = "zonas";

									}
								})

					  	</script>';
						}
				
			}
		}
	}

	static public function ctrConsultarZona($item, $valor){
		$tabla = "zonas";
		$respuesta = null;
		if($item == null){
			$respuesta = ModeloZonas::mdlConsultarZonas($tabla);
		} else {
			$respuesta = ModeloZonas::mdlConsultarZonas($tabla, $item, $valor);
			
		}
		return $respuesta;
	}

	static public function ctrEliminar(){
		if(isset($_GET['idZona'])){

			$tabla ="zonas";
			$datos = $_GET['idZona'];

			$respuesta = ModeloZonas::mdlEliminarZona($tabla, $datos);

			if($respuesta == "ok"){

				echo'<script>

				swal({
					  type: "success",
					  title: "La zona ha sido borrado correctamente",
					  showConfirmButton: true,
					  confirmButtonText: "Cerrar",
					  closeOnConfirm: false
					  }).then(function(result){
								if (result.value) {

								window.location = "zonas";

								}
							})

				</script>';

			}		
		}
	}

}


?>