<?php

require_once "conexion.php";

class ModeloCobros{

	/* funcion para editar enviando los parametro desde el controlador */
	static public function mdlActualizarItem($tabla, $item, $datos){
		if(count($item) <= 2){
			$sql = "UPDATE $tabla SET $item[0] = :$item[0] WHERE $item[1] = :$item[1]";
			$stmt = Conexion::conectar()->prepare($sql);

			$stmt->bindParam(":".$item[0], $datos[0], PDO::PARAM_STR);
			$stmt->bindParam(":".$item[1], $datos[1], PDO::PARAM_STR);
		} else if (count($item) == 3){
			$sql = "UPDATE $tabla SET $item[0] = :$item[0], $item[1] = :$item[1] WHERE $item[2] = :$item[2]";
			$stmt = Conexion::conectar()->prepare($sql);

			$stmt->bindParam(":".$item[0], $datos[0], PDO::PARAM_INT);
			$stmt->bindParam(":".$item[1], $datos[1], PDO::PARAM_STR);
			$stmt->bindParam(":".$item[2], $datos[2], PDO::PARAM_INT);
		}
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	// funcion para consultar cualquier dato;
	static public function mdlConsultarItems($tabla, $get, $where){
		$sql = '';
		if($get == null){
			$sql = "SELECT * FROM $tabla";
			if($where != null){
				$sql = "SELECT * FROM $tabla where $where";
			}
		} else if($where == null){
			$sql = "SELECT $get FROM $tabla";
		} else {
			$sql = "SELECT $get FROM $tabla where $where";
		}
		
	
		
		$stmt = Conexion::conectar()->prepare($sql);

		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

	static public function mdlConsultarServicioDetalle($valor){
		$sql = "SELECT * FROM servicios as ser inner join detallepagos as det on ser.idservicio=det.idservicios  WHERE det.iddetalle=$valor and ser.estado = 0";
		$stmt = Conexion::conectar()->prepare($sql);

		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}




	/*=============================================
	CREAR CONTRATOS
	=============================================*/

	static public function mdlIngresarContratos($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(codigo, idusuario, idpersona, numromeses, idtipo_servicios) VALUES (:codigo, :idusuario, :idpersona, :numromeses, :idtipo_servicios)");

		
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

	static public function mdlConsultarServicioId($valor){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM servicios inner join tiposervicios on servicios.idtiposervicios = tiposervicios.idtiposervicio WHERE idservicio = :idservicio");
		$stmt -> bindParam(":idservicio", $valor, PDO::PARAM_STR);
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

	static public function mdlConsultarPagosPendientes($valor){
		$stmt = Conexion::conectar()->prepare("SELECT * from recibopagos WHERE iddetallepago = :iddetallepago and (estado = 3 or estado = 4)");
		$stmt -> bindParam(":iddetallepago", $valor, PDO::PARAM_STR);
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

	static public function mdlActualizarPagosPendientes($tabla, $datosUpdate){
		//UPDATE detallepagos set estado = 1, update_at = "2021-04-20" WHERE iddetalle = 20
		date_default_timezone_set("America/Lima");
		setlocale(LC_ALL, 'spanish');
		
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado = 0, update_at = :update_at WHERE iddetalle = :iddetalle");

		$date = date("Y-m-d H:i:s");
		$stmt->bindParam(":iddetalle", $datosUpdate['iddetalle'], PDO::PARAM_INT);
		$stmt->bindParam(":update_at", $date, PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	static public function mdlActualizarPagosServicioPendientes($tabla, $idDetalle){
		//UPDATE recibopagos set estado = 3 WHERE iddetallepago = 19
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado = 0 WHERE iddetallepago = :iddetallepago");
		$stmt->bindParam(":iddetallepago", $idDetalle, PDO::PARAM_INT);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	static public function mdlConsultarTipoServicio(){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM `tiposervicios`");
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

	static public function mdlConsultarPagoExisteId($id, $fecha){
		$stmt = Conexion::conectar()->prepare("SELECT * from recibopagos where idservicios = :idservicios and month_billed = :month_billed");
		$stmt -> bindParam(":idservicios", $id, PDO::PARAM_STR);
		$stmt -> bindParam(":month_billed", $fecha, PDO::PARAM_STR);
		$stmt -> execute();
		return $stmt -> fetchAll();
		$stmt -> close();
		$stmt = null;
	}

	// consultar si un cronograma de pago ya vencio
	static public function mdlFechaVencido(){

			$stmt = Conexion::conectar()->prepare("SELECT idcronograma_pago, fechas_pagos from cronograma_pago WHERE estado = 0");

			$stmt -> execute();

			return $stmt -> fetchAll();

		
		$stmt -> close();

		$stmt = null;
	}



static public function mdlIngresarCobros($tabla, $datos){
//insert into recibopagos(idservicios, codigo, codigomedidor, totalM3, valorM3, subtotal, igv, totalpagar, estado) value($id, $codigo, $codigoMedidor, $lecturaActual, $valor, $subTotal, $igv, $total, 1);
		$con = Conexion::conectar();

		$stmt = $con->prepare("INSERT INTO $tabla(idservicios, codigo, codigomedidor, totalM3, valorM3, subtotal, igv, cargofijo, otroscobros, mora, month_billed, date_expires, totalpagar, estado) VALUES (:idservicios,:codigo, :codigomedidor, :totalM3, :valorM3, :subtotal, :igv, :cargofijo, :otroscobros, :mora, :month_billed, :date_expires, :totalpagar, :estado)");
		
		$stmt->bindParam(":idservicios", $datos["idservicios"], PDO::PARAM_INT);
		$stmt->bindParam(":codigo", $datos["codigo"], PDO::PARAM_STR);
		$stmt->bindParam(":codigomedidor", $datos["codigomedidor"], PDO::PARAM_STR);
		$stmt->bindParam(":totalM3", $datos["totalM3"], PDO::PARAM_INT);
		$stmt->bindParam(":valorM3", $datos["valorM3"], PDO::PARAM_STR);
		$stmt->bindParam(":subtotal", $datos["subtotal"], PDO::PARAM_STR);
		$stmt->bindParam(":igv", $datos["igv"], PDO::PARAM_STR);
		$stmt->bindParam(":cargofijo", $datos["cargofijo"], PDO::PARAM_STR);
		$stmt->bindParam(":otroscobros", $datos["otroscobros"], PDO::PARAM_STR);
		$stmt->bindParam(":mora", $datos["mora"], PDO::PARAM_STR);
		$stmt->bindParam(":month_billed", $datos["month_billed"], PDO::PARAM_STR);
		$stmt->bindParam(":date_expires", $datos["date_expires"], PDO::PARAM_STR);
		$stmt->bindParam(":totalpagar", $datos["totalpagar"], PDO::PARAM_STR);
		$stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_INT);	


		if($stmt->execute()){
			$idd = $con->lastInsertId();

			return $idd;

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	static public function mdlIngresarDetalleCobros($tabla, $datos){
//insert into detallepagos (idservicios, idrecivopagos, totalM3, valorM3, subtotal, igv, cargofijo, mora, totalpagar, estado, tipocobranza, nro_transacion, lugarpago, dineropagado, cambio) value();
		$con = Conexion::conectar();

		$stmt = $con->prepare("INSERT INTO $tabla(idservicios, totalM3, valorM3, subtotal, igv, cargofijo, otroscobros, mora, totalpagar, estado, tipocobranza, nro_transacion, lugarpago, dineropagado, cambio) VALUES (:idservicios, :totalM3, :valorM3, :subtotal, :igv, :cargofijo, :otroscobros, :mora, :totalpagar, :estado, :tipocobranza, :nro_transacion, :lugarpago, :dineropagado, :cambio)");
		
		$stmt->bindParam(":idservicios", $datos["idservicios"], PDO::PARAM_INT);
		$stmt->bindParam(":totalM3", $datos["totalM3"], PDO::PARAM_INT);
		$stmt->bindParam(":valorM3", $datos["valorM3"], PDO::PARAM_STR);
		$stmt->bindParam(":subtotal", $datos["subtotal"], PDO::PARAM_STR);
		$stmt->bindParam(":igv", $datos["igv"], PDO::PARAM_STR);
		$stmt->bindParam(":cargofijo", $datos["cargofijo"], PDO::PARAM_STR);

		$stmt->bindParam(":otroscobros", $datos["otroscobros"], PDO::PARAM_STR);

		$stmt->bindParam(":mora", $datos["mora"], PDO::PARAM_STR);
		$stmt->bindParam(":totalpagar", $datos["totalpagar"], PDO::PARAM_STR);
		$stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_INT);	

		$stmt->bindParam(":tipocobranza", $datos["tipocobranza"], PDO::PARAM_STR);
		$stmt->bindParam(":nro_transacion", $datos["nro_transacion"], PDO::PARAM_STR);
		$stmt->bindParam(":lugarpago", $datos["lugarpago"], PDO::PARAM_STR);
		$stmt->bindParam(":dineropagado", $datos["dineropagado"], PDO::PARAM_STR);
		$stmt->bindParam(":cambio", $datos["cambio"], PDO::PARAM_STR);	


		if($stmt->execute()){
			$idd = $con->lastInsertId();

			return $idd;

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	static public function mdlActualizarServicioDateTo($tabla, $datosUpdate){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado = :estado, date_to = :date_to, lecturamedidor = :lecturamedidor WHERE idservicio = :idservicios");
		$stmt->bindParam(":estado", $datosUpdate['estado'], PDO::PARAM_INT);
		$stmt->bindParam(":date_to", $datosUpdate['date_to'], PDO::PARAM_STR);
		$stmt->bindParam(":lecturamedidor", $datosUpdate['lecturamedidor'], PDO::PARAM_STR);
		$stmt->bindParam(":idservicios", $datosUpdate['idservicios'], PDO::PARAM_INT);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	static public function mdlIngresarDetalleCobross($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(idcobros, idcronograma_pago) VALUES (:idcobros,:idcronograma_pago)");
		
		$stmt->bindParam(":idcobros", $datos["idcobro"], PDO::PARAM_INT);
		$stmt->bindParam(":idcronograma_pago", $datos["idcronograma_pago"], PDO::PARAM_INT);	


		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	static public function mdlMostrarCobrosReporte($tabla, $item, $valor){

		
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetchAll();

		

		$stmt -> close();

		$stmt = null;

	}


	static public function mdlActualizarCronograma($tabla, $idcronograma_pago){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado = 1 WHERE idcronograma_pago = :idcronograma_pago");

		$stmt->bindParam(":idcronograma_pago", $idcronograma_pago, PDO::PARAM_INT);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	
	

	// actualiza el cobro 03 abril 2021
	static public function mdlActualizarCobro($tabla, $data){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado = :estado, iddetallepago = :iddetallepago WHERE idrecibo = :idPago");

		$stmt->bindParam(":estado", $data['estado'], PDO::PARAM_INT);
		$stmt->bindParam(":iddetallepago", $data['iddetallepago'], PDO::PARAM_STR);
		$stmt->bindParam(":idPago", $data['idPago'], PDO::PARAM_INT);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	//valida si la misma perona contiene mas servicios registrados
	static public function mdlServiciosPersona($tabla, $item, $valor){
		$stmt = Conexion::conectar()->prepare("SELECT idrecibo from $tabla where $item = :$item and estado = 1");

		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();

		$stmt = null;
	}


	static public function mdlEliminarCobro($tabla, $idcronograma_pago){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado = 0 WHERE idcronograma_pago = :idcronograma_pago");

		$stmt->bindParam(":idcronograma_pago", $idcronograma_pago, PDO::PARAM_INT);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	// actualiza el servicio 03 abril 2021
	static public function mdlActualizarServicio($tabla, $data){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado = :estado, update_at = :update_at WHERE idservicio = :idservicio");

		$stmt->bindParam(":estado", $data['estado'], PDO::PARAM_INT);
		$stmt->bindParam(":update_at", $data['update_at'], PDO::PARAM_STR);
		$stmt->bindParam(":idservicio", $data['idservicio'], PDO::PARAM_INT);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	static public function mdlActualizarServicioR($tabla, $idservicios){
		date_default_timezone_set("America/Lima");
		setlocale(LC_ALL, 'spanish');
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado = 0, fecha_suspension = null, fecha_reconexion = :fecha_reconexion WHERE idservicios = :idservicios");

		$date = date("Y-m-d H:i:s");
		$stmt->bindParam(":idservicios", $idservicios, PDO::PARAM_INT);
		$stmt->bindParam(":fecha_reconexion", $date, PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	static public function mdlActualizarCrono($tabla, $idservicios){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado = 0 WHERE idcronograma_pago = :idservicios");

		$stmt->bindParam(":idservicios", $idservicios, PDO::PARAM_INT);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}

	static public function mdlFinalizarServicio($idservicios){
		date_default_timezone_set("America/Lima");
		setlocale(LC_ALL, 'spanish');
		$stmt = Conexion::conectar()->prepare("UPDATE servicios SET estado = 2,fecha_suspension = null, fecha_reconexion = null, fecha_finalizacion = :fecha_finalizacion WHERE idservicios = :idservicios");

		$date = date("Y-m-d H:i:s");
		$stmt->bindParam(":idservicios", $idservicios, PDO::PARAM_INT);
		$stmt->bindParam(":fecha_finalizacion", $date, PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

	}


	static public function mdlMostrarDetalleCobro($tabla, $item, $valor){

		
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY idrecibo DESC");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetchAll();

		
		$stmt -> close();

		$stmt = null;

	}	


	static public function mdlUltimoPago($tabla, $valor){

		
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE estado = 1 AND idservicios = :item ORDER BY idcronograma_pago DESC");

			$stmt -> bindParam(":item", $valor, PDO::PARAM_INT);

			$stmt -> execute();

			return $stmt -> fetch();

		
		$stmt -> close();

		$stmt = null;

	}


	static public function mdlMesesFlatantes( $valor){

		
			$stmt = Conexion::conectar()->prepare("SELECT * FROM contar_meses WHERE idservicios = :valor");

			$stmt -> bindParam(":valor", $valor, PDO::PARAM_INT);
			$stmt -> execute();

			return $stmt -> fetch();

		
		$stmt -> close();

		$stmt = null;

	}	


	static public function mdlObtenerCobrosFaltantes($valor){

		
			$stmt = Conexion::conectar()->prepare("SELECT COUNT(estado) AS conteo FROM cronograma_pago WHERE estado in (0,2) AND idservicios = :item");

			$stmt -> bindParam(":item", $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		
		$stmt -> close();

		$stmt = null;

	}	

	static public function mdlObtenercronograma($tabla,$valor){

		
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE idcobros = :item");

			$stmt -> bindParam(":item", $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetchAll();

		
		$stmt -> close();

		$stmt = null;

	}	


	/*=============================================
	MOSTRAR CONTRATOS
	=============================================*/

	static public function mdlMostrarCobros($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY idservicio DESC");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla  ORDER BY iddetalle DESC");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();

		$stmt = null;

	}

 	static public function mdlCalcularReciboPago($tabla, $item, $valor){
 		$stmt = Conexion::conectar()->prepare("select sum(totalpagar) as total from $tabla where $item = :$item and estado = 1");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();
 	}
	/*=============================================
	MOSTRAR CONTRATOS
	=============================================*/

	static public function mdlMostrarCobrosSerieA($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item ORDER BY idcobros ASC");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla  ORDER BY idcobros ASC");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();

		$stmt = null;

	}	


	static public function mdlMostrarCronograma($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item and estadorecibo IN (1,2)");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);

			$stmt -> execute();

			//echo $tabla +" "+ $item +" "+ $valor;

			return $stmt -> fetchAll();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();

		$stmt = null;

	}	



	static public function mdlMostrarCronogramaPago($tabla, $item, $valor){

		if($item != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);

			$stmt -> execute();

			//echo $tabla +" "+ $item +" "+ $valor;

			return $stmt -> fetch();

		}

		$stmt -> close();

		$stmt = null;

	}	


	static public function mdlEliminarCobros($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE idcobros = :idcobros");

		$stmt -> bindParam(":idcobros", $datos, PDO::PARAM_INT);

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
	ELIMINAR COBROS O DESACTIVAR
	=============================================*/

	static public function mdlDesactivarCobros($tabla, $item1, $valor1, $item2, $valor2){

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

	
	

}