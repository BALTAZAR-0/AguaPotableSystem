<?php
// Include the main TCPDF library (search for installation path).
require_once "../../../controladores/cobros.controlador.php";
require_once "../../../modelos/cobros.modelo.php";
require_once('tcpdf_include.php');
$colorE = "#08a7df";
$color_titulos = "#0288C0";

//datos usuario
$nombreUsuario = "Fredy Yela";
$dniUsuario = "1111111111";
$direccionUsuario = "Alameda";

//datos empresa
$nombreEmpresa = "";
$ruc = "1313313131";
$direccionEmpresa = "Peru";
$telefono = "313131131";

$item = "iddetallepago";
$valor = $_GET['id'];

$respuesta = ControladorCobros::ctrGetDetalleCobro($item,$valor);

//var_dump($respuesta); exit;

//datos del cliente
$nombreCliente = $respuesta[0]['nombres'];
$dniCliente = $respuesta[0]['documento'];
$direccionCliente = $respuesta[0]['direccion'];
$estadoDetalle = $respuesta[0]['estadodetalle'];
if($estadoDetalle == 0 ){
    $newEstadoDetalle = "Pagado";
    $colorEstado = "green";
} else if($estadoDetalle == 1 ){
    $newEstadoDetalle = "Pendiente";
    $colorEstado = "orange";
} else if($estadoDetalle == 2 ){
    $newEstadoDetalle = "Rechazado";
    $colorEstado = "red";
} 

//datos del recibo globales
$codigoRecibo = $respuesta[0]['idrecibo'];
$newSubtotal = $respuesta[0]['newsubtotal'];
$newCargoFijo = $respuesta[0]['newcargofijo'];
$newOtrosCobros = $respuesta[0]['newotroscobros'];
$newMora = $respuesta[0]['newmora'];
$newTotalPagar = $respuesta[0]['newtotalpagar'];

$entregoEfectivo = $respuesta[0]['dineropagado'];
$cambio = $respuesta[0]['cambio'];
$mesFacturado = "Abril 2021";
$lecturaActual = 10;

$cantidadItem = count($respuesta);
$altoTick = (228 + $cantidadItem * 10);
    

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
	private $nombreEmpresa = "";
	private $ruc = "1313313131";
	private $direccionEmpresa = "Peru";
	private $telefono = "313131131";
	//Page header
	public function Header() {
		// Logo
		$image_file = K_PATH_IMAGES.'logo_mcp.png';
		$this->Image($image_file, 6, 5, 60, 25, 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);

	}

}

// create new PDF document

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);




// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetPrintFooter(false);


// set page format (read source code documentation for further information)
// MediaBox - width = urx - llx 210 (mm), height = ury - lly = 297 (mm) this is A4
$page_format = array(
    'MediaBox' => array ('llx' => 0, 'lly' => 0, 'urx' => 80, 'ury' => $altoTick),//228 - 8,  226  234 - 8, 242 -8
    //'CropBox' => array ('llx' => 0, 'lly' => 0, 'urx' => 210, 'ury' => 297),
    //'BleedBox' => array ('llx' => 5, 'lly' => 5, 'urx' => 205, 'ury' => 292),
    //'TrimBox' => array ('llx' => 10, 'lly' => 10, 'urx' => 200, 'ury' => 287),
    //'ArtBox' => array ('llx' => 15, 'lly' => 15, 'urx' => 195, 'ury' => 282),
    'Dur' => 3,
    'trans' => array(
        'D' => 1,
        'S' => 'Split',
        'Dm' => 'V',
        'M' => 'O'
    ),
    'Rotate' => 0,
    'PZ' => 10,
);

// Check the example n. 29 for viewer preferences

// add first page ---
$pdf->AddPage('P', $page_format, false, false);

// ---------------------------------------------------------

// set font
//$pdf->SetFont('helvetica', 'BI', 12);
//$pdf->SetFont('verdana', '', 12);

// add a page
//$pdf->AddPage('P','A7');

// set some text to print
$pdf->SetFont('helvetica', 'B', 10);

$pdf->SetMargins(0, 0, 0, 0);
    //$pdf->SetAutoPageBreak(TRUE, 0);
//$pdf->setCellPaddings(30,30,30,0);
    //$pdf->setFooterMargin(0);
    $html = '
    <div id="ecard-container">
  
        <table width="200" cellspacing="0" cellpadding="0">
            <tr>
                <td width="100%">
                    <div style="font-size: 11; text-align: center">
                        COCODE del Caserío de Vueltamina, Aldea la Mesilla
                    </div>
                </td> 
            </tr>
            <tr>
                <td width="100%">
                    <table>
                        
                        <tr>
                            <td align="center">
                                <span>Cliente: '.$nombreCliente.'</span><br>
                                <span>DPI: '.$dniCliente.'</span><br>
                                <span>Direccion: '.$direccionCliente.'</span>
                                <h3>Tick N°: '.$codigoRecibo.'</h3>
                                <h3>Estado: <span style="color: '.$colorEstado.';">'.$newEstadoDetalle.'</span></h3>
                            </td>
                        </tr>
                        <tr>
                            <td align="auto">
                               __________________________________<br>

                            </td>
                        </tr>
                         <tr style="font-size: 5px;">
                            <td width="15%" align="left">
                                COD
                            </td>
                            <td width="20%" align="left">
                                N° MEDIDOR
                            </td>
                            <td width="20%" align="left">
                                CATEGORIA
                            </td>
                            <td width="25%" align="left">
                                CONCEPTO
                            </td>
                            <td width="20%" align="left">
                                iMPORTE
                            </td>
                        </tr>
                        <tr>
                            <td width="100%" align="center">
                               __________________________________<br>
                            </td>
                        </tr>
                        ';
//datos de los diferentes recibos
foreach ($respuesta as $key => $value) {
    //datos de cada recibo 
    $codigoRecibo = $value['codigorecibo'];
    $nMedidor = "2323233";
    $concepto = "Agua potable";
    $subtotal = $value['subtotal'];

    $html .= '<tr>
                <td width="100%">
                    <table>
                         <tr style="font-size: 6px;">
                            <td width="15%" align="left">
                                '.$codigoRecibo.'
                            </td>
                            <td width="20%" align="left">
                                '.$nMedidor.'
                            </td>
                            <td width="20%" align="left">
                                Domiciliar
                            </td>
                            <th width="25%" align="left">
                                '.$concepto.'

                            </th>
                            <th width="20%" align="center">
                                '.$subtotal.'
                            </th>
                        </tr>
                      
                    </table>
                </td> 
            </tr>';
}  


$html .= '</table></td></tr>
    </table>
</div>
';
    $pdf->writeHTML($html, true, false, true, false, '');   
// ---------------------------------------------------------



/*------- muestro todos los datos del detalle ----------------*/


    $html = '
    <div id="ecard-container">
        <table width="195" cellspacing="0" cellpadding="0">
            
            <tr>
                <td width="100%">
                    <table>
                		<tr style="font-size: 9px;">
                            <td width="100%" align="center"><hr></td>
                        </tr>
                         <tr style="font-size: 9px;">
                            <th width="80%" align="rigth">
                                Sub total: <br>
                                Cargo fijo: <br>
                                Cobros Anteriores: <br>
                                Mora: <br>
                            </th>
                            <th width="20%" align="center">
                                '.$newSubtotal.' <br>
                                '.$newCargoFijo.' <br>
                                '.$newOtrosCobros.' <br>
                                '.$newMora.'
                            </th>
                        </tr>
                         <tr>
                            <td width="0" align="center">
                                __________________________________
                            </td>
                        </tr>
                       
                        <tr style="font-size: 10px;">
                            <td width="20%" align="center"></td>
                            <th width="60%" align="rigth" style="font-size: 12px;">
                                Total a pagar:
                            </th>
                            <th width="20%" align="center">
                                '.$newTotalPagar.'
                            </th>
                        </tr>

                        <tr style="font-size: 10px;">
                            <td width="20%" align="center"></td>
                            <th width="60%" align="rigth">
                                Entregado efectivo: <br>
                                Cambio:
                            </th>
                            <th width="20%" align="center">
                                '.$entregoEfectivo.' <br>
                                '.$cambio.'
                            </th>
                        </tr>

                       
                    </table>
                </td>
            </tr>
        </table>
    </div>
    ';
   
    $pdf->writeHTML($html, true, false, true, false, '');

    $html = '<div id="ecard-container">
        <table width="195" cellspacing="0" cellpadding="0">
            
             <tr>
            	<td width="100%" align="center">
                	<img src="'.K_PATH_IMAGES.'QR.png" width="100" height="90" />
                </td>
            </tr>
           

       
       
        </table>
    </div>';

    $pdf->writeHTML($html, true, false, true, false, '');

$pdf->Output('example_003.pdf', 'I');
?>