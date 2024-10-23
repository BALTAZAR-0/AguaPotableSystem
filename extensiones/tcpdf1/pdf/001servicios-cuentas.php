<?php

require_once "../../../controladores/contratos.controlador.php";
require_once "../../../modelos/contratos.modelo.php";

require_once "../../../controladores/personas.controlador.php";
require_once "../../../modelos/personas.modelo.php";

require_once "../../../controladores/usuarios.controlador.php";
require_once "../../../modelos/usuarios.modelo.php";

require_once "../../../controladores/cobros.controlador.php";
require_once "../../../modelos/cobros.modelo.php";

// require_once "../../../controladores/productos.controlador.php";
// require_once "../../../modelos/productos.modelo.php";

class imprimirEstadoServicio{

public $estado;
public $zona;


public function traerImpresionEstadoServicio(){

	date_default_timezone_set("America/Mexico_City");
    setlocale(LC_ALL, 'spanish');

    $width = [10, 20, 20, 10, 20, 10];

//TRAEMOS LA INFORMACIÓN DE LA VENTA

$estado_servicio = $this->estado;
$zona_servicio = $this->zona;



//Se agrego la funcion en Controlador Contratos Y Modelo Contratos

$respuestaContrata = ControladorContratos::ctrMostrarServiciosReporte($estado_servicio,$zona_servicio);
//var_dump($respuestaContrata);


//REQUERIMOS LA CLASE TCPDF

require_once('tcpdf_include.php');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->startPageGroup();

$pdf->AddPage('L','JIS_B4');

// ---------------------------------------------------------

$bloque1 = <<<EOF

	<table>
		
		<tr>
			
			<td style="width:100%"><img src="images/header_reportes.png"></td>

			

		</tr>



	</table>



EOF;

$pdf->writeHTML($bloque1, false, false, false, false, '');


//se modificaron las columnas

$bloque3 = <<<EOF

	<table style="font-size:9px; padding:5px 10px;">

		<tr>
		<br>
		<br>
		

		<td width="$width[0]%" style="border: 1px solid #666; background-color:white; text-align:center"><b>Cod. Servicio</b></td>
		
		<td width="$width[1]%" style="border: 1px solid #666; background-color:white; text-align:center"><b>Cliente</b></td>

		<td width="$width[2]%" style="border: 1px solid #666; background-color:white; text-align:center"><b>Zona</b></td>
		<td width="$width[3]%" style="border: 1px solid #666; background-color:white; text-align:center"><b>Dirección</b></td>
		<td width="$width[4]%" style="border: 1px solid #666; background-color:white; text-align:center"><b>N° Medidor</b></td>
		<td width="$width[5]%" style="border: 1px solid #666; background-color:white; text-align:center"><b>Estado</b></td>
		</tr>

	</table>

EOF;

$pdf->writeHTML($bloque3, false, false, false, false, '');

// -------------------------------------------------

// Aqui  hace el ciclo para agregar las filas 

foreach ($respuestaContrata as $key => $value) {
/*
	$cont = $key + 1;

	$fecha = strtotime($value["fechas_pagos"]);

	$mes = strftime("%B", $fecha)." - ".strftime("%Y", $fecha) ;
*/
	$mes = "";
	$fecha = "";

	$nombres = $value['nombres'].' '.$value['apaterno'].' '.$value['amaterno'];
/*
	$respuestaUltimoPago = ControladorCobros::ctrUltimoPago($value["idservicios"]);
	var_dump($respuestaUltimoPago);
	exit;

	if ($respuestaUltimoPago != null){
		$fecha = strtotime($respuestaUltimoPago["fechas_pagos"]);
		$mes = ucfirst(strftime("%B", $fecha));
	}
*/
	$suma = 0;
/*
	$respuestaMesesFaltantes = ControladorCobros::ctrMesesFlatantes($value["idservicios"]);

	if ($respuestaMesesFaltantes != null){
		$suma = $respuestaMesesFaltantes["numromeses"] - $respuestaMesesFaltantes["cont"];
	}
*/
	$estadoPago = "";

//	$valor = "S/.".$value["valor_servicio"].".00";
	//$fecha = substr($value["fecha_inicio"],0,-8); 

	if($value["estado"] == 0){
		$estadoPago = "ACTIVO";
	}else if($value["estado"] == 1){
		$estadoPago = "SUSPENDIDO";
	}else if ($value["estado"] == 2){
		$estadoPago = "FINALIZADO";
	}

	$valor = "";
/*
	if($value["fecha_reconexion"] != null){
		$valor = "5";
	}
*/
$bloque4 = <<<EOF

 	<table style="font-size:10px; padding:5px 10px;">

 		<tr>
 			<td width="$width[0]%" style="border: 1px solid #666; color:#333; background-color:white; text-align:center"><b>
 				$value[codigo]</b>
 			</td>
			
 			<td width="$width[1]%" style="border: 1px solid #666; color:#333; background-color:white; text-align:center">
 				$nombres
 			</td>


 			<td width="$width[2]%" style="border: 1px solid #666; color:#333; background-color:white; text-align:center">$value[nombrezona]
 			</td>

 			<td width="$width[3]%" style="border: 1px solid #666; color:#333; background-color:white; text-align:center">$value[direccion]
 			</td>

 			<td width="$width[4]%" style="border: 1px solid #666; color:#333; background-color:white; text-align:center">$value[codigomedidor]
 			</td>


 			<td width="$width[5]%" style="border: 1px solid #666; color:#333; background-color:white; text-align:center">$estadoPago
 			</td>

 		</tr>

 	</table>


EOF;

	$pdf->writeHTML($bloque4, false, false, false, false, '');

}




//SALIDA DEL ARCHIVO 

//$pdf->Output('factura.pdf', 'D');
$pdf->Output('Estado_Cuenta.pdf');

}

}

$factura = new imprimirEstadoServicio();
$factura -> estado = $_GET["estado"];
$factura -> zona = $_GET["zona"];
$factura -> traerImpresionEstadoServicio();

?>