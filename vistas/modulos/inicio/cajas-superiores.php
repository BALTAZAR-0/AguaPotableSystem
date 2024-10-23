<?php

$item = null;
$valor = null;


$contratos = ControladorContratos::ctrMostrarContratos($item, $valor);
$totalContratos = count($contratos);

$cobros = ControladorCobros::ctrMostrarDetalleCobros($item, $valor);
$totalCobros = count($cobros);


$servicios = ControladorServicios::ctrMostrarServicios($item, $valor);
$totalServicios = count($servicios);


$personas = ControladorPersonas::ctrMostrarPersonas($item, $valor);
$totalPersonas = count($personas);

?>



<div class="col-lg-3 col-xs-6">

  <div class="small-box bg-aqua">
    
    <div class="inner">
      
      <h3><?php echo number_format($totalContratos); ?></h3>
<p><MARQUEE SCROLLDELAY =200> <B>Administrar Lecturas</B></MARQUEE></p>

      
    
    </div>
    
    <div class="icon">
      
      <i class="fa fa-book"></i>
    
    </div>
    
    <a href="contratos" class="small-box-footer">
      
      <B>Más info</B> <i class="fa fa-arrow-circle-right"></i>
    
    </a>

  </div>

</div>

<div class="col-lg-3 col-xs-6">

  <div class="small-box bg-green">
    
    <div class="inner">
    
      <h3><?php echo number_format($totalCobros); ?></h3>
<p><MARQUEE SCROLLDELAY =200> <B>Administrar Cobros</B></MARQUEE></p>
      
    </div>
    
    <div class="icon">
    
      <i class="ion ion-social-usd"></i>
    
    </div>
    
    <a href="cobros" class="small-box-footer">
      
      <B>Más info </B><i class="fa fa-arrow-circle-right"></i>
    
    </a>

  </div>

</div>




<div class="col-lg-3 col-xs-6">

  <div class="small-box bg-red">
  
    <div class="inner">
    
      <h3><?php echo number_format($totalPersonas); ?></h3>
<p><MARQUEE SCROLLDELAY =200> <B>Registros de Clientes</B></MARQUEE></p>
     
    
    </div>
    
    <div class="icon">
      
      <i class="ion ion-ios-people-outline"></i>
    
    </div>
    
    <a href="personas" class="small-box-footer">
      
      <B>Más info </B><i class="fa fa-arrow-circle-right"></i>
    
    </a>

  </div>

</div>






<div class="col-lg-3 col-xs-6">

  <div class="small-box bg-teal">
  
     <div class="inner">
    
      <h3><?php echo number_format($totalServicios); ?></h3>
<p><MARQUEE SCROLLDELAY =200> <B>Configuracion de Servicio</B></MARQUEE></p>
     
    
    </div>
    
    <div class="icon">
    
      <i class="fa fa-audio-description"></i>
    
    </div>
    
    <a href="servicios" class="small-box-footer">
      
      <B>Más info </B><i class="fa fa-arrow-circle-right"></i>
    
    </a>

  </div>

</div>