<?php
// Include the main TCPDF library (search for installation path).
require_once "../../../controladores/contratos.controlador.php";
require_once "../../../modelos/contratos.modelo.php";
require_once('tcpdf_include.php');
$colorE = "#08a7df";
$color_titulos = "#0288C0";

if(isset($_GET['id']) && !empty($_GET['id']) && $_GET['id'] != "undefined"){



//obtengo la informacion de la base de datos
$item = "idservicio";
$valor = $_GET['id'];

$respuesta = ControladorContratos::ctrMostrarContratosReporte($item, $valor);	


//datos usuario
$nombreUsuario = "Fredy Yela";
$dniUsuario = "1111111111";
$direccionUsuario = "Alameda";

//datos empresa
$nombreEmpresa = "";
$ruc = "";
$direccionEmpresa = "Peru";
$telefono = "313131131";
$horaAtencion = "10: 23 H";
$numeroComprobante = "0121313";

//datos del cliente
$nombreCliente = $respuesta[0]['nombres'];
$dniCliente = $respuesta[0]['documento'];
$direccionCliente = $respuesta[0]['direccion'];

//fecha vencimiento
$meses = array("mescero","Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
$year = (int)explode("-", $respuesta[0]['date_expires'])[0];
$mes = (int)explode("-", $respuesta[0]['date_expires'])[1];
$dia = (int)explode("-", $respuesta[0]['date_expires'])[2];
$fechaVence = "Fecha vence: ". $dia . " de " . $meses[$mes]." - ".$year;

//fecha actual del sistema.
date_default_timezone_set('UTC');
setlocale(LC_ALL,"es_CO");
$fechaActual = date('d/m/Y');
$horaActual = date('g:i a');
$fechaComprobante = "FECHA $fechaActual HORA $horaActual";


// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
	public $horaAtencion = "";
	public $numeroComprobante = "";
	
	//Page header
	public function Header() {
		// Logo
		$image_file = K_PATH_IMAGES.'header_reportes.png';
		$this->Image($image_file, 30, 4, 170, 20, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

		/*
		$image_file = K_PATH_IMAGES.'logo_mcp.png';
		$this->Image($image_file, 15, 4, 25, 18, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);*/

/*
		$txt = "COMPROBANTE \n ".$this->numeroComprobante." \n ".$this->horaAtencion;
		$this->SetY(4);
		$this->SetX(135);
		$this->SetFont('helvetica', 'BI', 12);
		$this->setCellPaddings(2, 4, 6, 8);
		$this->SetFillColor(255, 255, 255);
		$this->SetTextColor(2, 136, 192);
		$this->MultiCell(80, 5, $txt."\n", 0, 'C', 1, 1, '' ,'', true);*/

	}

}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

//asigno datos a las varibles que estan en la clase.
$pdf->numeroComprobante = $numeroComprobante;
$pdf->horaAtencion = $horaAtencion;

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 003');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

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
/*
// set some text to print
$txt = <<<EOD
TCPDF Example 003

Custom page header and footer are defined by extending the TCPDF class and overriding the Header() and Footer() methods.
EOD;

// print a block of text using Write()
$pdf->Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);

// ---------------------------------------------------------
*/


// muestra todos los detalles de un servicio
$html = '<div><div><table border="0" cellpadding="2">
    <tr>
        <th>
        	<table cellpadding="2" align="center">
				<tr style="background-color: '.$colorE.'; color: #fff; font-size: 14px;">
					<th style="border: 0.5px solid '.$colorE.'" width="7%">
						#:
					</th>
					<th style="border: 0.5px solid '.$colorE.'" width="12%">
						Meses:
					</th>
					<th style="border: 0.5px solid '.$colorE.'" width="8%">
						Lectura:
					</th>
					<th style="border: 0.5px solid '.$colorE.'" width="9%">
						Valor M3:
					</th>
					<th style="border: 0.5px solid '.$colorE.'" width="8%">
						Subtotal:
					</th>
					<th style="border: 0.5px solid '.$colorE.'" width="11%">
						cargo Fijo:
					</th>
					<th style="border: 0.5px solid '.$colorE.'" width="11%">
						otros cobros:
					</th>
					<th style="border: 0.5px solid '.$colorE.'" width="8%">
						mora:
					</th>
					<th style="border: 0.5px solid '.$colorE.'" width="10%">
						total:
					</th>
					<th style="border: 0.5px solid '.$colorE.'" width="8%">
						Estado:
					</th>
				</tr>';

$PendientesTotalPagar = 0;
$PendientesSubTotal = 0;
$PendientesCargoFijo = 0;
$PendientesOtroCobro = 0;
$PendientesMora = 0;

$PagadosTotalPagar = 0;
$PagadosSubTotal = 0;
$PagadosCargoFijo = 0;
$PagadosOtroCobro = 0;
$PagadosMora = 0;

foreach ($respuesta as $key => $value) {

	
$indice = $key;
$mesFacturado = $value['month_billed'];
$totalM3 = $value['totalM3'];
$valorM3 = $value['valorM3'];
$subtotal = $value['subtotal'];
$cargoFijo = $value['cargofijo'];
$otrosCobros = $value['otroscobros'];
$mora = $value['mora'];
$totalPagar = $value['totalpagar'];

//sumar para obtener el total de los recibos pendientes
$estado = "Pendiente";
$colorEstado = "#f39c12";
if($value['estado'] == 1 || $value['estado'] == 2 || $value['estado'] == 3){
	$PendientesTotalPagar += $totalPagar;
	$PendientesSubTotal += $subtotal;
	$PendientesCargoFijo += $cargoFijo;
	$PendientesOtroCobro += $otrosCobros;
	$PendientesMora += $mora;
} else if($value['estado'] == 3){
	$estado = "proceso";
}
if($value['estado'] == 2){
	$estado = "vencido";
	$colorEstado = "red";
}

//validar el estado del recibo para mostrarlo


if($value['estado'] == 0){
	$estado = "Pagado";
	$colorEstado = "#00C400";
	$fechaVence = "";

	//realizo la suma de los valores pagados
	$PagadosTotalPagar += $totalPagar;
	$PagadosSubTotal += $subtotal;
	$PagadosCargoFijo += $cargoFijo;
	$PagadosOtroCobro += $otrosCobros;
	$PagadosMora += $mora;

} else if($value['estado'] == 2){
	$estado = "Vencido";
	$colorEstado = "BF1704";
}

			$html .= '
				<tr style="font-size: 14px;">
					<th style="border: 0.5px solid '.$colorE.'" width="7%">
						'.$indice.'
					</th>
					<th style="border: 0.5px solid '.$colorE.'" width="12%">
						'.$mesFacturado.'
					</th>
					<th style="border: 0.5px solid '.$colorE.'" width="8%">
						'.$totalM3.'
					</th>
					<th style="border: 0.5px solid '.$colorE.'" width="9%">
						'.$valorM3.'
					</th>
					<th style="border: 0.5px solid '.$colorE.'" width="8%">
						'.$subtotal.'
					</th>
					<th style="border: 0.5px solid '.$colorE.'" width="11%">
						'.$cargoFijo.'
					</th>
					<th style="border: 0.5px solid '.$colorE.'" width="11%">
						'.$otrosCobros.'
					</th>
					<th style="border: 0.5px solid '.$colorE.'" width="8%">
						'.$mora.'
					</th>
					<th style="border: 0.5px solid '.$colorE.'" width="10%">
						'.$totalPagar.'
					</th>
					<th style="border: 0.5px solid '.$colorE.'; color: '.$colorEstado.'" width="8%">
						'.$estado.'
					</th>
				</tr>';
}

		$html .= '
			<tr>
				<td width="100%">
					
				</td>
			</tr>	
			<tr>
				<td width="45%" style="text-align: center; font-size: 20px;">
					Servicio de agua potable - Pagado
				</td>
				<td width="10%" style="text-align: center; font-size: 20px;">
					
				</td>
				<td width="45%" style="text-align: center; font-size: 20px;">
					Servicio de agua potable - Pendiente
				</td>
			</tr>
			<tr>
				<td width="45%">
					<table cellpadding="6" cellspacing="6" style="border: 1px solid '.$colorE.';">
						<tr>
							<td style="text-align: right;">
								Subtotal: <br>
								Cargo fijo: <br>
								Otros cobros: <br>
								Mora: <br>
								Total:
							</td>
							<td>
								'.number_format($PagadosSubTotal, 2, '.', ',').' <br>
								'.number_format($PagadosCargoFijo, 2, '.', ',').' <br>
								'.number_format($PagadosOtroCobro, 2, '.', ',').' <br>
								'.number_format($PagadosMora, 2, '.', ',').'<br>
								'.number_format($PagadosTotalPagar, 2, '.', ',').'
							</td>
						</tr>
					</table>

				</td>
				<td width="10%" style="text-align: center; font-size: 20px;">
					
				</td>
				<td width="45%">
					<table cellpadding="6" cellspacing="6" style="border: 1px solid '.$colorE.';">
						<tr>
							<td style="text-align: right;">
								Subtotal: <br>
								Cargo fijo: <br>
								Otros cobros: <br>
								Mora: <br>
								Total: 
							</td>
							<td style="text-align: center;">
								'.number_format($PendientesSubTotal, 2, '.', ',').' <br>
								'.number_format($PendientesCargoFijo, 2, '.', ',').' <br>
								'.number_format($PendientesOtroCobro, 2, '.', ',').' <br>
								'.number_format($PendientesMora, 2, '.', ',').'<br>
								'.number_format($PendientesTotalPagar, 2, '.', ',').'
							</td>
						</tr>
					</table>
				</td>
			</tr>
			</table>			
        </th>
    </tr> 
</table>
';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');





//Close and output PDF document
$pdf->Output('example_003.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
}