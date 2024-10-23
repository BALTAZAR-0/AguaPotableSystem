<?php
// Include the main TCPDF library (search for installation path).
require_once "../../../controladores/contratos.controlador.php";
require_once "../../../modelos/contratos.modelo.php";
require_once('tcpdf_include.php');
$colorE = "#08a7df";
$color_titulos = "#0288C0";

//obtengo la informacion de la base de datos
$item = "idrecibo";
$valor = $_GET['idrecibo'];

$respuesta = ControladorContratos::ctrMostrarContratosReporte($item, $valor);


//$idservicio = $respuesta[0]['idservicio'];

//TRAEMOS LA INFORMACIÓN DEL SERVICIO CONSUMO DEL MES


$itemConsumoMes = "idservicios";
$valorConsumoMes = $respuesta[0]['idservicio'];

$respuestaLecturaAnterior = ControladorContratos::ctrMostrarPenultimalectura($itemConsumoMes, $valorConsumoMes);


if($respuestaLecturaAnterior["totalM3"]!=null){
	$LecturaAnterior = json_decode($respuestaLecturaAnterior["totalM3"], true);
	
}else{	
	$LecturaAnterior = "0";
}

//$LecturaAnterior = json_decode($respuestaLecturaAnterior["totalM3"], true);


//datos usuario
$nombreUsuario = " ";
$dniUsuario = "";
$direccionUsuario = " ";          

//datos empresa
$nombreEmpresa = "";
$ruc = "";
$direccionEmpresa = "Guatemala";
$telefono = "313131131";
$horaAtencion = "Fecha de Emision :".date('d/m/Y');
$numeroComprobante = "MCP-0000" .$valor;                          /*    "MCP-0000002";*/


//datos del cliente
$nombreCliente = $respuesta[0]['nombres'];
$dniCliente = $respuesta[0]['documento'];
$direccionCliente = $respuesta[0]['direccion'];

//datos del recibo
$codigoRecibo = $respuesta[0]['codigorecibo'];
$nMedidor = $respuesta[0]['codigomedidor'];
$concepto = "Agua potable";
$subtotal = $respuesta[0]['subtotal'];
$cargoFijo = $respuesta[0]['cargofijo'];
$otrosCobros = $respuesta[0]['otroscobros'];
$totalPagar = $respuesta[0]['totalpagar'];

$itemV = "codigo";
$resp_lecturaanterior = ControladorContratos::ctrMostrarUltimalectura($itemV, $codigoRecibo);

//Son cincuenta y uno con 20 / 100 nuevos Q:
$formatterES = new NumberFormatter("es-CO", NumberFormatter::SPELLOUT);
$izquierda = intval(floor($totalPagar));
$derecha = intval(($totalPagar - floor($totalPagar)) * 100);
$monedaEscrita = "Son ".$formatterES->format($izquierda) . " con " . $formatterES->format($derecha)." Quetzales.";

$mesFacturado = $respuesta[0]['month_billed'];
$lecturaActual = $respuesta[0]['totalM3'];

$consumoDelMes=$lecturaActual-$LecturaAnterior;

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
$fechaComprobante = "Fecha de Emision: $fechaActual";

//validar el estado del recibo para mostrarlo
$estado = "Pendiente";
$colorEstado = "#f39c12";
if($respuesta[0]['estado'] == 0){
	$estado = "Pagado";
	$colorEstado = "#00C400";
	$fechaVence = "";
} else if($respuesta[0]['estado'] == 2){
	$estado = "Vencido";
	$colorEstado = "BF1704";
}




$lecturaAnterior = 0;

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
	public $horaAtencion = "";
	public $numeroComprobante = "";
	
	//Page header
	public function Header() {
		// Logo
		$image_file = K_PATH_IMAGES.'header_reportes.png';
		$this->Image($image_file, 10, 4, 100, 23, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		/*
		$image_file = K_PATH_IMAGES.'logo_mcp.png';
		$this->Image($image_file, 15, 4, 25, 18, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);*/


		$txt = "NÚMERO DE RECIBO \n ".$this->numeroComprobante." \n ".$this->horaAtencion;
		$this->SetY(4);
		$this->SetX(135);
		$this->SetFont('helvetica', 'B', 12);
		$this->setCellPaddings(2, 4, 6, 8);
		$this->SetFillColor(255, 255, 255);
		$this->SetTextColor(2, 136, 192);
		$this->MultiCell(80, 5, $txt."\n", 0, 'C', 1, 1, '' ,'', true);

	}

}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

//asigno datos a las varibles que estan en la clase.
$pdf->numeroComprobante = $numeroComprobante;
$pdf->horaAtencion = $horaAtencion;

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('');
$pdf->SetTitle('Recibo');
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
$pdf->SetFont('helvetica', 'B', 11);
//$pdf->SetFont('verdana', '', 12);

// add a page
$pdf->AddPage('P','A4');
/*
// set some text to print
$txt = <<<EOD
TCPDF Example 003

Custom page header and footer are defined by extending the TCPDF class and overriding the Header() and Footer() methods.
EOD;

// print a block of text using Write()
$pdf->Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);

// ---------------------------------------------------------
*///write1DBarcode($dniCliente, 'C39', '', '', '', 18, 0.4, $stylebarra, 'N');
// define barcode style
$stylebarra = $pdf->serializeTCPDFtagParameters(array($dniCliente, 'C39', '', '', '', 18, 0.4, array(
	 'position' => 'C',
    'align' => 'R',
    'stretch' => false,
    'fitwidth' => true,
    'cellfitalign' => '',
    'border' => true,
    'hpadding' => 'auto',
    'vpadding' => 'auto',
    'fgcolor' => array(0,0,0),
    'bgcolor' => false, //array(255,255,255),
    'text' => true,
    'font' => 'helvetica',
    'fontsize' => 8,
    'stretchtext' => 4), 'N'));

//$codigobarra=$pdf->write1DBarcode('CODE 39 E+', 'C39E+', '', '', 120, 25, 0.4, $style, 'N');

// create some HTML content
$subtable = '<table border="1" cellspacing="6" cellpadding="4"><tr><td>a</td><td>b</td></tr><tr><td>c</td><td>d</td></tr></table>';
$style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
$html = '
<table border="0" cellspacing="3" cellpadding="4">
	<tr>
		<th></th>
	</tr>
    <tr>
        <th width="380">
        	<table cellpadding="3">
				<tr style="background-color: '.$colorE.'; color: #fff; font-size: 14px;">
					<th width="25%" style="border: 0.5px solid '.$colorE.'">
						Cliente
					</th>
					<th width="75%" style="border: 0.5px solid '.$colorE.'">
						'.$nombreCliente.'
					</th>
				</tr>
				<tr style="font-size: 16px;">
					<th width="25%" style="border: 0.5px solid '.$colorE.'">
						DPI
					</th>
					<th width="75%" style="border: 0.5px solid '.$colorE.'">
						'.$dniCliente.'
					</th>
				</tr>
				<tr style="font-size: 16px;">
					<th width="25%" style="border: 0.5px solid '.$colorE.'">
						Dirección
					</th>
					<th width="75%" style="border: 0.5px solid '.$colorE.'">
						'.$direccionCliente.'
					</th>
				</tr>
				
			</table>
        </th>
        <th align="center" width="auto" style="font-size: 14px; color: '.$color_titulos.'">
        		<br>
        		Lectura Anterior : '.$LecturaAnterior.'
        		<br>
        		Lectura Actual: '.$resp_lecturaanterior["totalM3"].'
	        	<br>
	        	Consumo del Mes : '.$consumoDelMes.'
	        	<br>
	        	Mes Facturado : '.$mesFacturado.'
	        	<br>
	        	<span style="color: '.$colorEstado.';">Estado: '.$estado.'</span>
	        	<br>
	        	'.$fechaVence.'
        	
        	
        </th>
    </tr>
  
</table>';
// output the HTML content
//$pdf->writeHTML($html, true, false, true, false, $style);

// Print some HTML Cells

$html .= '<table border="0" cellspacing="2" cellpadding="4">
    <tr>
        <th>
        	<table cellpadding="2" align="center">
				<tr style="background-color: '.$colorE.'; color: #fff; font-size: 15px;">
					<th style="border: 0.5px solid '.$colorE.'" width="20%">
						Codigo:
					</th>
					<th style="border: 0.5px solid '.$colorE.'" width="20%">
						N° medidor:
					</th>
					<th style="border: 0.5px solid '.$colorE.'" width="20%">
						Categoria:
					</th>
					<th style="border: 0.5px solid '.$colorE.'" width="20%">
						Concepto:
					</th>
					<th style="border: 0.5px solid '.$colorE.'" width="20%">
						Importe:
					</th>
				</tr>
				<tr style="font-size: 16px;">
					<th style="border: 0.5px solid '.$colorE.'">
						'.$codigoRecibo.'
					</th>
					<th style="border: 0.5px solid '.$colorE.'">
						'.$nMedidor.'
					</th>
					<th style="border: 0.5px solid '.$colorE.'">
						Categoria
					</th>
					<th style="border: 0.5px solid '.$colorE.'">
						'.$concepto.'
					</th>
					<th style="border: 0.5px solid '.$colorE.'">
						'.$subtotal.'
					</th>
				</tr>
				<tr style="font-size: 13px;">
					<th></th>
					<th></th>
					<th></th>
					<th>
						Sub Total :
						<br>
						Cargo fijo : 
						<br>
						Cobros Anteriores:  
					</th>
					<th>
						'.$subtotal.'
						<br>
						'.$cargoFijo.'
						<br>
						'.$otrosCobros.'
					</th>
				</tr>
				
			</table>
			<table cellpadding="4" align="center">
				<tr style="background-color: '.$colorE.'; color: #fff; font-size: 14px;">
					

					<th width="30%" style="border: 0.5px solid '.$colorE.'; font-size: 15px;">
						TOTAL A PAGAR :
					</th>
					<th width="40%" style="border: 0.5px solid '.$colorE.'; font-size: 15px;">
						  EN QUETZALES
					</th>
					<th width="30%" style="border: 0.5px solid '.$colorE.'; font-size: 15px;">
						Q. '.$totalPagar.'
					</th>
				</tr>
				
				<tr style="font-size: 15px;">
					<td width="100%" align="center">
						<h2 color="'.$color_titulos.'">
				
							<SMALL><B>ATENCIÓN LOS COBROS DE AGUA POTABLE SON DE LUNES A DOMINGO </B></SMALL>
							
						</h2>
					</td>
				</tr>
			</table>
			
				
        </th>
    </tr>
    <tr>
    	<td>
    		<img src="'.K_PATH_IMAGES.'mensajeAgua.png" height="200"/>
    	</td>
    	
    </tr>

     <tr>
    	<td>
    		<img src="'.K_PATH_IMAGES.'Recor.png" height="200"/>
    	</td>
    	
    </tr>

    
  
</table>

			<table cellpadding="4" align="center">
				<tr style="font-size: 14px;">
					<th width="60%">
						<img src="'.K_PATH_IMAGES.'header_reportes.png" height="100"/>
					</th>					
					<th width="40%" style="border: 0.5px solid '.$colorE.'; color: '.$color_titulos.'; font-size: 16px;">



						<br>
			        	NÚMERO DE RECIBO
			        	<br>
						'.$numeroComprobante.'
			        	
			        	<br>
			        	'.$fechaComprobante.'
			        	
					</th>
				</tr>
				
</table>

<p>

</p>';

// output the HTML content
//$pdf->writeHTML($html, true, false, true, false, '');


$html .= '<table cellspacing="3" cellpadding="4">
    <tr>
        <th width="380">
        	<table cellpadding="1">
        	<tr style="font-size: 14px;">
					<th width="25%" style="border: 0.5px solid '.$colorE.'">
				Código
			</th>
			<th width="83%" style="border: 0.5px solid '.$colorE.'">
				'.$codigoRecibo.'
			</th>
		</tr>

		</table>
        	<table cellpadding="1">
				<tr style="background-color: '.$colorE.'; color: #fff; font-size: 14px;">
					<th width="25%" style="border: 0.5px solid '.$colorE.'">
						Cliente
					</th>
					<th width="83%" style="border: 0.5px solid '.$colorE.'">
						'.$nombreCliente.'
					</th>
				</tr>
				<tr style="font-size: 14px;">
					<th width="25%" style="border: 0.5px solid '.$colorE.'">
						DPI
					</th>
					<th width="83%" style="border: 0.5px solid '.$colorE.'">
						'.$dniCliente.'
					</th>
				</tr>
				<tr style="font-size: 14px;">
					<th width="25%" style="border: 0.5px solid '.$colorE.'">
						Dirección
					</th>
					<th width="83%" style="border: 0.5px solid '.$colorE.'">
						'.$direccionCliente.'
					</th>
				</tr>
				
			</table>















        </th>
        <th align="center" width="auto" style="font-size: 14px">
        	
        	Lectura Anterior : '.$LecturaAnterior.'
    		<br>
        	Lectura Actual : '.$lecturaActual.'
        	<br>
        	Consumo del Mes : '.$consumoDelMes.'
        	<br>
        	Mes Facturado : '.$mesFacturado.'

        	
        </th>
    </tr>

    
    	 
    


				
				

    
    <tr>

<table cellpadding="4" align="center">
				<tr style="background-color: '.$colorE.'; color: #fff; font-size: 14px;">
					

					<th width="30%" style="border: 0.5px solid '.$colorE.'; font-size: 15px;">
						TOTAL A PAGAR :
					</th>
					<th width="40%" style="border: 0.5px solid '.$colorE.'; font-size: 15px;">
						  EN QUETZALES
					</th>
					<th width="30%" style="border: 0.5px solid '.$colorE.'; font-size: 15px;">
						Q. '.$totalPagar.'
					</th>
				</tr>




	   
			
		</table>
			
    	<td width="100%" align="center">
    	<tcpdf method="write1DBarcode" params="'.$stylebarra.'"/>
    	</td>
    	<td>';
  	
    	$html.='</td>
    </tr>
  
</table>';
//$pdf->SetXY(15, 80);
//$pdf->write1DBarcode($dniCliente, 'C39', '', '', '', 18, 0.4, $stylebarra, 'N');
// output the HTML content
$pdf->writeHTML($html, true, false, true, false, $style);


//<tcpdf method="write1DBarcode" params="'.$dniCliente, 'C39', '', '', '', 18, 0.4, $stylebarra.'" />

//Close and output PDF document
$pdf->Output('example_003.pdf');

//============================================================+
// END OF FILE
//============================================================+
