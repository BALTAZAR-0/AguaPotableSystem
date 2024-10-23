<?php

class ModeloZonas {

	static public function mdlConsultarZonas($tabla, $item = null, $valor = null){
		if($item == null){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
			$stmt -> execute();
			return $stmt -> fetchAll();
		} else {
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
			$stmt->bindParam(":".$item, $valor, PDO::PARAM_INT);
			$stmt -> execute();
			return $stmt -> fetchAll();
		}
		
		$stmt -> close();
		$stmt = null;
	}

	static public function mdlCrearZona($tabla, $datos){
		$stmt = Conexion::conectar()
			->prepare("INSERT INTO $tabla(nombrezona) VALUES (:nombrezona)");
		$stmt->bindParam(":nombrezona", $datos["nombrezona"], PDO::PARAM_STR);
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;
	}

	//editamos la zona
	static public function mdlEditarZona($tabla, $datos){
		$stmt = Conexion::conectar()
			->prepare("UPDATE $tabla set nombrezona = :nombrezona where idzona = :idzona");
		$stmt->bindParam(":nombrezona", $datos["nombrezona"], PDO::PARAM_STR);
		$stmt->bindParam(":idzona", $datos["idzona"], PDO::PARAM_STR);
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;
	}


	static public function mdlEliminarZona($tabla, $datos){
		$stmt = Conexion::conectar()
			->prepare("DELETE FROM $tabla where idzona = :idzona");
		$stmt->bindParam(":idzona", $datos, PDO::PARAM_INT);
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;
	}

}

?>