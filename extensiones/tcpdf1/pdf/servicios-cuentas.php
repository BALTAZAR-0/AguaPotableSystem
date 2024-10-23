<?php
// Include the main TCPDF library (search for installation path).
require_once "../../../controladores/contratos.controlador.php";
require_once "../../../modelos/contratos.modelo.php";
require_once('tcpdf_include.php');
$colorE = "#08a7df";
$color_titulos = "#0288C0";

if(isset($_GET['estado'], $_GET['zona'])){

$estado_servicio = $_GET['estado'];
$zona_servicio = $_GET['zona'];


$respuestaContrata = ControladorContratos::ctrMostrarServiciosReporte($estado_servicio,$zona_servicio);


//fecha actual del sistema.
date_default_timezone_set('UTC');
setlocale(LC_ALL,"es_CO");
$fechaActual = date('d/m/Y');
$horaActual = date('g:i a');
$fechaComprobante = "FECHA $fechaActual HORA $horaActual";

    $width = [10, 20, 20, 10, 20, 10];


// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
	public $horaAtencion = "";
	public $numeroComprobante = "";
	
	//Page header
	public function Header() {
		// Logo
		$image_file = K_PATH_IMAGES.'header_reportes.png';
		$this->Image($image_file, 10, 4, 300, 23, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

	}

}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);



// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetPrintFooter(false);
Fuente: https://www.iteramos.com/pregunta/64344/-cambiar-o-eliminar-header-ampamp-footer-en-el-tcpdf-

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', 'BI', 12);
//$pdf->SetFont('verdana', '', 12);

// add a page
$pdf->AddPage('L','A4');

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

// Aqui  hace el ciclo para agregar las filas 

foreach ($respuestaContrata as $key => $value) {

	$nombres = $value['nombres'].' '.$value['apaterno'].' '.$value['amaterno'];

	$estadoPago = "";

	if($value["estado"] == 0){
		$estadoPago = "ACTIVO";
	}else if($value["estado"] == 1){
		$estadoPago = "SUSPENDIDO";
	}else if ($value["estado"] == 2){
		$estadoPago = "FINALIZADO";
	}

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







//Close and output PDF document
$pdf->Output('example_003.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
}