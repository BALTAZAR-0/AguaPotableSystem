<?php

require_once "conexion.php";

class ModeloUsuarios{

	/*=============================================
	MOSTRAR USUARIOS
	=============================================*/

	static public function mdlMostrarUsuarios($tabla, $item, $valor){

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


	static public function MdlMostrarUsuariosCobros($tabla, $item, $valor){
		

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetchall();
		

		$stmt -> close();

		$stmt = null;

	}


	static public function MdlReporteUsuarios($tabla, $item, $valor,$valor2){
		date_default_timezone_set("America/Mexico_City");
    	setlocale(LC_ALL, 'spanish');
		
		if($valor2 == "dia"){

			
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item and  DATE_FORMAT(fecha_cobro, '%Y-%m-%d') = CURDATE() ");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetchall();
			$stmt -> close();

		$stmt = null;

		}else if ($valor2 == "semana") {

			$date = date("Y-m-d");
			$mod_date = strtotime($date."- 7 days");
			$fecha_final =  date("Y-m-d",$mod_date);

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item and DATE_FORMAT(fecha_cobro, '%Y-%m-%d') BETWEEN :fechaFinal AND CURDATE()");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> bindParam(":fechaFinal", $fecha_final, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetchall();
			$stmt -> close();

		$stmt = null;
			
		}else if ($valor2 == "mensual") {
			$date = date("Y-m-d");
			$mod_date = strtotime($date."- 30 days");
			$fecha_final =  date("Y-m-d",$mod_date);
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item and DATE_FORMAT(fecha_cobro, '%Y-%m-%d') BETWEEN :fechaFinal AND CURDATE()");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> bindParam(":fechaFinal", $fecha_final, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetchall();
			$stmt -> close();

		$stmt = null;
			
		}

		

	}



	static public function mdlMostrarCronograma(){
		date_default_timezone_set("America/Lima");
    	setlocale(LC_ALL, 'spanish');
///////cambiosss
		$stmt = Conexion::conectar()->prepare("SELECT * FROM cronograma_pago WHERE fechas_pagos BETWEEN CURRENT_DATE() - INTERVAL 5 DAY AND CURRENT_DATE() - INTERVAL 1 DAY  AND estado = 0");

		$stmt -> execute();

		return $stmt -> fetchAll();

		
		$stmt -> close();

		$stmt = null;

	}	


	static public function mdlObtenerSuspendidos(){
		

		$stmt = Conexion::conectar()->prepare("SELECT DISTINCT idservicios, count(estado) AS conteo FROM cronograma_pago WHERE estado = 2 GROUP BY idservicios");

		$stmt -> execute();

		return $stmt -> fetchAll();

		
		$stmt -> close();

		$stmt = null;

	}	


	static public function mdlActualizarCronograma($idcronograma_pago){
	
		$stmt = Conexion::conectar()->prepare("UPDATE cronograma_pago SET estado = :estado WHERE idcronograma_pago = :idcronograma_pago");

		$estado = 2;

		$stmt -> bindParam(":estado", $estado, PDO::PARAM_INT);
		$stmt -> bindParam(":idcronograma_pago", $idcronograma_pago, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}


	static public function mdlUpdateSuspendidos($idservicios){
		date_default_timezone_set("America/Lima");
		setlocale(LC_ALL, 'spanish');
		$stmt = Conexion::conectar()->prepare("UPDATE servicios SET estado = 1, fecha_suspension = :fecha_suspension WHERE idservicios = :idservicios");


		$date = date("Y-m-d H:i:s");
		$stmt -> bindParam(":idservicios", $idservicios, PDO::PARAM_INT);
		$stmt -> bindParam(":fecha_suspension", $date, PDO::PARAM_STR);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}

	static public function mdlActualizarServicio($idservicios){
	
		$stmt = Conexion::conectar()->prepare("UPDATE servicios SET estado = :estado WHERE idservicios = :idservicios");

		$estado = 1;

		$stmt -> bindParam(":estado", $estado, PDO::PARAM_INT);
		$stmt -> bindParam(":idservicios", $idservicios, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}


	/*=============================================
	REGISTRO DE USUARIO
	=============================================*/

	static public function mdlIngresarUsuario($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre, usuario, password, perfil, foto) VALUES (:nombre, :usuario, :password, :perfil, :foto)");

		$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
		$stmt->bindParam(":password", $datos["password"], PDO::PARAM_STR);
		$stmt->bindParam(":perfil", $datos["perfil"], PDO::PARAM_STR);
		$stmt->bindParam(":foto", $datos["foto"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";	

		}else{

			return "error";
		
		}

		$stmt->close();
		
		$stmt = null;

	}

	/*=============================================
	EDITAR USUARIO
	=============================================*/

	static public function mdlEditarUsuario($tabla, $datos){
	
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre = :nombre, password = :password, perfil = :perfil, foto = :foto WHERE usuario = :usuario");

		$stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":password", $datos["password"], PDO::PARAM_STR);
		$stmt -> bindParam(":perfil", $datos["perfil"], PDO::PARAM_STR);
		$stmt -> bindParam(":foto", $datos["foto"], PDO::PARAM_STR);
		$stmt -> bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	ACTUALIZAR USUARIO
	=============================================*/

	static public function mdlActualizarUsuario($tabla, $item1, $valor1, $item2, $valor2){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE $item2 = :$item2");

		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_STR);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	BORRAR USUARIO
	=============================================*/

	static public function mdlBorrarUsuario($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");

		$stmt -> bindParam(":id", $datos, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;


	}

}