<?php

require_once "conexion.php";

class ModeloServicios{

	/*=============================================
	CREAR SERVICIO
	=============================================*/

	static public function mdlIngresarServicio($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre, descripcion, cantidad_bolsa, valor_servicio) VALUES (:nombre, :descripcion, :cantidad_bolsa, :valor_servicio)");

		
		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
		$stmt->bindParam(":cantidad_bolsa", $datos["cantidad_bolsa"], PDO::PARAM_STR);
		$stmt->bindParam(":valor_servicio", $datos["valor_servicio"], PDO::PARAM_STR);
		


		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}


	/*=============================================
	MOSTRAR SERVICIO
	=============================================*/

	static public function mdlMostrarServicios($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();

		$stmt = null;

	}	

	static public function mdlMostrarContratosServicios($tabla, $item, $valor,$valor2){

		if($valor != "" && $valor2 != ""){
			$stmt = Conexion::conectar()->prepare("SELECT * from $tabla WHERE estado = :item and idzona = :idzona");

				$stmt -> bindParam(":item", $valor, PDO::PARAM_STR);
				$stmt -> bindParam(":idzona", $valor2, PDO::PARAM_INT);

				$stmt -> execute();

				return $stmt -> fetchAll();
		}else if ($valor2 != ""){
			$stmt = Conexion::conectar()->prepare("SELECT * from $tabla WHERE idzona = :idzona");

				$stmt -> bindParam(":idzona", $valor2, PDO::PARAM_INT);

				$stmt -> execute();

				return $stmt -> fetchAll();

		}else if($valor != ""){
			$stmt = Conexion::conectar()->prepare("SELECT * from $tabla WHERE estado = :item");

				$stmt -> bindParam(":item", $valor, PDO::PARAM_STR);

				$stmt -> execute();

				return $stmt -> fetchAll();
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

			$stmt -> execute();

			return $stmt -> fetchAll();
		}

		
		$stmt -> close();

		$stmt = null;

	}

	static public function mdlMostrarServiciosPersona($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE idpersona = :item");

			$stmt -> bindParam(":item", $item, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetchAll();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();

		$stmt = null;

	}	
	
	

	/*=============================================
	EDITAR SERVICIO
	=============================================*/

	static public function mdlEditarTipoServicio($tabla, $datos){
		date_default_timezone_set("America/Lima");
		setlocale(LC_ALL, 'spanish');
		$fechaActual = date('Y-m-d');

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre =:nombre, descripcion =:descripcion, valor1 =:valor1, valor2 =:valor2, igv = :igv, cargofijo = :cargofijo, otroscobros = :otroscobros, mora =  :mora, update_at = :update_at WHERE idtiposervicio = :idtiposervicio");

		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":valor1", $datos["valor1"], PDO::PARAM_STR);
		$stmt->bindParam(":valor2", $datos["valor2"], PDO::PARAM_STR);
		$stmt->bindParam(":igv", $datos["igv"], PDO::PARAM_STR);
		$stmt->bindParam(":cargofijo", $datos["cargofijo"], PDO::PARAM_STR);

		$stmt->bindParam(":otroscobros", $datos["otroscobros"], PDO::PARAM_STR);
		$stmt->bindParam(":mora", $datos["mora"], PDO::PARAM_STR);
		$stmt->bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
		$stmt->bindParam(":update_at", $fechaActual, PDO::PARAM_STR);
		$stmt->bindParam(":idtiposervicio", $datos["idtiposervicio"], PDO::PARAM_INT);

		if( $stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	ELIMINAR SERVICIO
	=============================================*/

	static public function mdlEliminarServicio($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE idtipo_servicios = :idtipo_servicios");

		$stmt -> bindParam(":idtipo_servicios", $datos, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}






}