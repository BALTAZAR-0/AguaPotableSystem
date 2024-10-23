<?php

error_reporting(0);

if(isset($_GET["fechaInicial"])){

    $fechaInicial = $_GET["fechaInicial"];
    $fechaFinal = $_GET["fechaFinal"];

}else{

$fechaInicial = null;
$fechaFinal = null;

}



$respuesta = ControladorActaNacimientos::ctrRangoFechasActaNacimientos($fechaInicial, $fechaFinal);
$totalActaNacimientos = count($respuesta);

$arrayFechas = array();
$arrayActaNacimiento = array();
$sumaTotalMes = array();

foreach ($respuesta as $key => $value) {

	#Capturamos sólo el año y el mes
	$fecha = substr($value["fecha_registro"],0,7);

	#Introducir las fechas en arrayFechas
	array_push($arrayFechas, $fecha);

	#Capturamos las Actas de nacimietnos
	$arrayActaNacimiento = array($fecha => $value["idacta_nacimiento"]);

	#Sumamos los pagos que ocurrieron el mismo mes
	foreach ($arrayActaNacimiento as $key => $value) {
		
		//var_dump($arrayActaNacimiento);
        //$sumaTotalMes[$key] += $value;

        $sumaTotalMes[$key] += count($value);
	}



}


$noRepetirFechas = array_unique($arrayFechas);


?>

<!--=====================================
GRÁFICO DE VENTAS
======================================-->


<div class="box box-solid bg-teal-gradient">
	
	<div class="box-header">
		
 		<i class="fa fa-th"></i>

  		<h3 class="box-title">Gráfico de Acta de Nacimientos</h3>

	</div>

	<div class="box-body border-radius-none nuevoGraficoActasNacimientos">

		<div class="chart" id="line-chart-ActasNacimientos" style="height: 250px;"></div>

  </div>

</div>

<script>
	
 var line = new Morris.Line({
    element          : 'line-chart-ActasNacimientos',
    resize           : true,
    data             : [

    <?php

    if($noRepetirFechas != null){

	    foreach($noRepetirFechas as $key){

	    	echo "{ y: '".$key."', Actas_Nacimientos: ".$sumaTotalMes[$key]." },";


	    }

	    echo "{y: '".$key."', Actas_Nacimientos: ".$sumaTotalMes[$key]." }";

    }else{

       echo "{ y: '0', Actas_Nacimientos: '0' }";

    }

    ?>

    ],
    xkey             : 'y',
    ykeys            : ['Actas_Nacimientos'],
    labels           : ['Actas_Nacimientos'],
    lineColors       : ['#efefef'],
    lineWidth        : 2,
    hideHover        : 'auto',
    gridTextColor    : '#fff',
    gridStrokeWidth  : 0.4,
    pointSize        : 4,
    pointStrokeColors: ['#efefef'],
    gridLineColor    : '#efefef',
    gridTextFamily   : 'Open Sans',
    preUnits         : 'Total ',
    gridTextSize     : 10
  });

</script>