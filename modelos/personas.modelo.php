<?php

require_once "conexion.php";

class ModeloPersonas{

	/*=============================================
	CREAR PERSONA
	=============================================*/

	static public function mdlIngresarPersona($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombres, apaterno, amaterno, documento, sexo, fecha_nacimiento, telefono, idZona, direccion, email) VALUES (:nombres, :apaterno, :amaterno, :documento, :sexo, :fecha_nacimiento, :telefono, :idZona, :direccion, :email)");

		
		$stmt->bindParam(":nombres", $datos["nombres"], PDO::PARAM_STR);
		$stmt->bindParam(":apaterno", $datos["apaterno"], PDO::PARAM_STR);
		$stmt->bindParam(":amaterno", $datos["amaterno"], PDO::PARAM_STR);
		$stmt->bindParam(":documento", $datos["documento"], PDO::PARAM_STR);
		$stmt->bindParam(":sexo", $datos["sexo"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_nacimiento", $datos["fecha_nacimiento"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		$stmt->bindParam(":idZona", $datos["zona"], PDO::PARAM_INT);
		$stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
		$stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}


	/*=============================================
	MOSTRAR CLIENTES
	=============================================*/

	static public function mdlMostrarPersonas($tabla, $item, $valor){
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


	static public function mdlMostrarPersonaServicio($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item AND estado in (1,2)");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		

		$stmt -> close();

		$stmt = null;

	}	



	static public function mdlMostrarPersona($tabla, $item, $valor){

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
	
	

	/*=============================================
	EDITAR PERSONA
	=============================================*/

	static public function mdlEditarPersona($tabla, $datos){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombres = :nombres, apaterno = :apaterno, amaterno = :amaterno, documento= :documento, sexo= :sexo, fecha_nacimiento= :fecha_nacimiento, telefono= :telefono, idZona= :idZona, direccion= :direccion, email= :email WHERE idpersona = :idpersona");

		$stmt->bindParam(":idpersona", $datos["idpersona"], PDO::PARAM_INT);
		$stmt->bindParam(":nombres", $datos["nombres"], PDO::PARAM_STR);
		$stmt->bindParam(":apaterno", $datos["apaterno"], PDO::PARAM_STR);
		$stmt->bindParam(":amaterno", $datos["amaterno"], PDO::PARAM_STR);
		$stmt->bindParam(":documento", $datos["documento"], PDO::PARAM_STR);
		$stmt->bindParam(":sexo", $datos["sexo"], PDO::PARAM_STR);
		$stmt->bindParam(":fecha_nacimiento", $datos["fecha_nacimiento"], PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $datos["telefono"], PDO::PARAM_STR);
		$stmt->bindParam(":idZona", $datos["zona"], PDO::PARAM_INT);
		$stmt->bindParam(":direccion", $datos["direccion"], PDO::PARAM_STR);
		$stmt->bindParam(":email", $datos["email"], PDO::PARAM_STR);



		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	ELIMINAR PERSONA
	=============================================*/

	static public function mdlEliminarPersona($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE idpersona = :idpersona");

		$stmt -> bindParam(":idpersona", $datos, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	ACTUALIZAR CLIENTE
	=============================================*/

	static public function mdlActualizarPersona($tabla, $item1, $valor1, $valor){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE idpersona = :idpersona");

		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":idpersona", $valor, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}


	/*	static public function mdlUpdatePersona($tabla, $idpersona){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla set cobro  = 20 where idpersona = :idpersona");

		$stmt->bindParam(":idpersona", $idpersona, PDO::PARAM_INT);
				

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}*/

		static public function mdlActualizarCliente($tabla, $item1, $valor1, $valor){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE idpersona = :idpersona");

		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":idpersona", $valor, PDO::PARAM_STR);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}

}