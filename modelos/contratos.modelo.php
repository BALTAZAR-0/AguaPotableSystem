<?php

require_once "conexion.php";

class ModeloContratos{

	/*=============================================
	MOSTRAR ULTIMO LECTURADO
	=============================================*/

	static public function mdlMostrarUltimalectura($tabla, $item, $valor){
		//$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE idrecibo=(SELECT MIN(idrecibo) FROM $tabla WHERE $item = :$item);");
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE idrecibo=(SELECT MAX(idrecibo) FROM $tabla WHERE $item = :$item);");

		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetch();
		$stmt -> close();

		$stmt = null;

	}	

	/*=============================================
	CREAR CONTRATOS
	=============================================*/

	static public function mdlIngresarContratos($tabla, $datos){
		date_default_timezone_set("America/Lima");
		setlocale(LC_ALL, 'spanish');

		$estado = 0;
		$con = Conexion::conectar();

		$stmt = $con->prepare("INSERT INTO $tabla(codigo, idusuarios, idpersonas, idtiposervicios, codigomedidor, estado) VALUES (:codigo, :idusuarios, :idpersonas, :idtiposervicios, :codigomedidor, :estado)");
		
		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
		$stmt->bindParam(":idusuarios", $datos["idusuario"], PDO::PARAM_INT);
		$stmt->bindParam(":idpersonas", $datos["idpersona"], PDO::PARAM_INT);
		$stmt->bindParam(":idtiposervicios", $datos["idservicio"], PDO::PARAM_INT);
		$stmt->bindParam(":codigomedidor", $datos["numeroMedidor"], PDO::PARAM_STR);
		$stmt->bindParam(":estado", $estado, PDO::PARAM_INT);

		if($stmt->execute()){
			$idd = $con->lastInsertId();

			return $idd;

		}else{
			

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}



	static public function mdlIngresarCronogramaPagos($datos){
		date_default_timezone_set("America/Lima");
		setlocale(LC_ALL, 'spanish');
		$con = Conexion::conectar();

		try{
			$stmt = $con->prepare("INSERT INTO cronograma_pago(idservicios,monto,fechas_pagos,estado) VALUES (:servicio,:monto,:fechas_pagos,:estado)");

			$con->beginTransaction(); 
			//Esta es para registrar + un mes SI i <= $datos["numromeses"] lo tomara 12 meses contando desde cero
			//for ($i = 1; $i <= $datos["numromeses"]; $i++) {
			for ($i = 0; $i < $datos["numromeses"]; $i++) {
				$stmt->execute([
					'servicio'=> $datos["idservicios"],
					'monto'=> $datos["monto"],
					//'fechas_pagos'=> date("Y-m-d",strtotime($datos["fechas_pagos"] ."+". $i." month")),
					'fechas_pagos'=> date("Y-m-01",strtotime($datos["fechas_pagos"] ."+". $i." month")),
					'estado'=> $datos["estado"]
					
				]);
			}

			$con->commit();
			return "ok";

		}
		catch(Exception $e){
			if($con->inTransaction()){
				$con->rollback();
			}
			throw $e;
			return "error";
		}

		

	}


	/*=============================================
	MOSTRAR CONTRATOS
	=============================================*/

	static public function mdlMostrarContratos($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY idservicio DESC");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY idservicio DESC");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();

		$stmt = null;

	}

		static public function mdlMostrarContratosCodigo($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY idservicios ASC");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY idservicios ASC");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();

		$stmt = null;

	}
	// 2021-01-04 obtengo cuantos servicios tiene un usuario
	static public function mdlUsuarioServicio($tabla, $id){
		//select * from servicios where idpersonas = 1
		$stmt = Conexion::conectar()->prepare("SELECT * from $tabla where idpersonas = $id");
			$stmt -> execute();
			return $stmt -> fetchAll();
	}

	


	static public function mdlMostrarContratosReporte($tabla, $item, $valor){

		
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetchAll();

		

		$stmt -> close();

		$stmt = null;

	}

	static public function mdlMostrarServiciosReporte($tabla, $valor,$valor2){

		if($valor2 != "" && $valor != ""){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE estado = :item AND idzona = :idzona");

			$stmt -> bindParam(":item", $valor, PDO::PARAM_INT);
			$stmt -> bindParam(":idzona", $valor2, PDO::PARAM_INT);
			

			$stmt -> execute();

			return $stmt -> fetchAll();

		}else if ($valor2 != "") {
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE idzona = :idzona");

			$stmt -> bindParam(":idzona", $valor2, PDO::PARAM_INT);

			$stmt -> execute();

			return $stmt -> fetchAll();
			
		}else if ($valor != ""){
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE estado = :item");

			$stmt -> bindParam(":item", $valor, PDO::PARAM_INT);

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


	static public function mdlEditarServicio($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetchall();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();

		$stmt = null;

	}	
	



	static public function mdlMostrarCobros($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

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


	static public function ctrComprobarServicio($tabla, $item, $valor){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE estado = 1 AND $item = :$item ");
		
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetch();


		$stmt -> close();

		$stmt = null;

	}	

	static public function mdlEliminarServicio($tabla, $item, $valor){

		
		$stmt = Conexion::conectar()->prepare("DELETE FROM servicios WHERE idservicio = :idservicios");

		$stmt -> bindParam(":idservicios", $valor, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}	

	static public function mdlEliminarServicioCobros($tabla, $item, $valor){

		
		$stmt = Conexion::conectar()->prepare("DELETE FROM cronograma_pago WHERE idservicios = :idservicios");

		$stmt -> bindParam(":idservicios", $valor, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}	
	
	

	/*=============================================
	EDITAR CONTRATOS
	=============================================*/

	static public function mdlEditarContratos($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET idservicios = :idservicios, codigo = :codigo, idusuario = :idusuario, idpersona= :idpersona, numromeses= :numromeses, idtipo_servicios= :idtipo_servicios WHERE idservicios = :idservicios");

		$stmt->bindParam(":idservicios", $datos["idservicios"], PDO::PARAM_INT);
		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_INT);
		$stmt->bindParam(":idusuario", $datos["idusuario"], PDO::PARAM_INT);
		$stmt->bindParam(":idpersona", $datos["idpersona"], PDO::PARAM_INT);
		$stmt->bindParam(":numromeses", $datos["numromeses"], PDO::PARAM_STR);
		$stmt->bindParam(":idtipo_servicios", $datos["idtipo_servicios"], PDO::PARAM_INT);



		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	/*=============================================
	ELIMINAR CONTRATOS OJO
	=============================================*/

	static public function mdlEliminarContrato($tabla, $datos){

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
	ACTUALIZAR CONTRARO
	=============================================*/

	static public function mdlActualizarContrato($tabla, $item1, $valor1, $valor){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE id = :id");

		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":id", $valor, PDO::PARAM_STR);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}


	/*=============================================
	MOSTRAR ULTIMO LECTURADO
	=============================================*/

	static public function mdlMostrarUltimalecturaServicio($tabla, $item, $valor){
		//$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE idrecibo=(SELECT MIN(idrecibo) FROM $tabla WHERE $item = :$item);");
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE idservicio=(SELECT MAX(idservicio) FROM $tabla WHERE $item = :$item);");

		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetch();
		$stmt -> close();

		$stmt = null;

	}	


	static public function mdlMostrarContratoRecibo($tabla, $item, $valor){

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
	

		static public function mdlMostrarPenultimolectura($tabla, $item, $valor){
		//$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE idrecibo=(SELECT MIN(idrecibo) FROM $tabla WHERE $item = :$item);");
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE idrecibo=(SELECT MAX(idrecibo)-1 FROM $tabla WHERE $item = :$item);");

		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetch();
		$stmt -> close();

		$stmt = null;

	}

}