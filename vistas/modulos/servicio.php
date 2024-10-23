<div class="row contenedor">
  <header class="col-md-12 header" style="display: flex; align-items: center; justify-content: space-between; padding: 0 0 10px 0; margin: 0"> <!-- Usamos Flexbox para centrar verticalmente -->
    <div class="logo-left col-md-3" style="padding: 0; margin: 0;">
      <div class="col-md-12 logo" style="max-width: none;"> <!-- Aseguramos que el contenedor no limite el tamaño -->
        <img src="vistas/img/logo.png" class="img-responsive" style="margin-top: -60px; width: 250px; max-width: none;"> <!-- Subimos más el logo -->
      </div>
    </div>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&display=swap" rel="stylesheet">
    
    <!-- Bloque de texto centrado verticalmente y aumentado en tamaño -->
    <div class="datos-empresa col-md-6" style="padding: 0; margin: -60px 0 0 0; text-align: center; font-size: 60px;"> <!-- Reducimos el margen superior -->
      <h2 style="font-size: 43px;"><SMALL><B>COBRO DE SERVICIOS DE AGUA POTABLE "COCODE DE VUELTAMINA"</B></SMALL></h2>
      <h2 style="font-size: 43px;"><SMALL><B>AGUA POTABLE PARA TODO EL PUEBLO</B></SMALL></h2>
    </div>

    <!-- Alinear "Iniciar Sesión" a la derecha y en el medio -->
	<div class="contactanos col-md-3" style="padding-top: 0; margin-top: -50px; text-align: right;"> <!-- Flexbox eliminado, volvemos al estilo anterior -->
  <CENTER>
    <a href="ingreso">
      <img src="vistas/img/ava.png" class="img-responsive" style="width: 80px;"> <!-- Imagen ya ajustada, no la tocamos -->
	  <SMALL><B style="font-size: 15px;">INICIAR SESION</B></SMALL> <!-- Aumentamos el tamaño del texto a 20px -->
    </a>
  </CENTER>
</div>


  </header>

  <!-- Ajuste de la línea para subirla más -->
  <div class="col-md-12 linea" style="margin-top: -65px; padding: 0;"></div> <!-- Subimos más la línea -->

<section class="col-md-12">
    <?php if(isset($_SESSION['datosServicio'])){ 
         //$data2 = $_SESSION['datosServicio'];
         $item = "documento";
          $valor = $_SESSION['datosServicio'];
          $data2 = ControladorContratos::ctrMostrarContratosReporte($item, $valor);


          $configuracion = ControladorPlantilla::ctrConfiguracion();
          echo '<input type="hidden" id="conf-igv" value="'.$configuracion[0]['igv'].'" />';
               
        ?>
	<div class="container">
		<div class="cotenedor-tabla">
		<h2 style="text-align: center;">DATOS DEL USUARIO</h2>
		<table class="tabla-datos-usuario" style="width: 100%">
			<tr>
				<th>DPI / NIT</th>
				<th><?= $data2[0]['documento'] ?></th>
			</tr>
			<tr>
				<th>CLIENTE :</th>
				<th id="nombresCliente"><?= $data2[0]['nombres'] ?></th>
			</tr>
			<tr>
				<th>SERIE MEDIDOR</th>
				<th id="numeroMedidor"><?= $data2[0]['codigomedidor'] ?></th>
			</tr>
		</table>
		<h4>SELECCIONE UNA OPCIÓN:</h4>
		<div class="col-md-12 p-0">
			<div class="col-md-6 p-0 pr">
				<button class="btn btn-primary btn-block btn-adeudosPagados">Adeudos Pagados</button>
			</div>
			<div class="col-md-6 p-0 pl">
				<button class="btn btn-primary btn-block btn-adeudosVigentes active">Adeudos vigentes</button>
			</div>
		</div>
		</div>


<!-- deudas pagadas contenedor -->
		<div class="col-md-12 deudasPendientes">
            <br>
			<table class="detalle table table-bordered table-striped table-hover table-condensed">
           
                        <thead>
             
                           <tr>
                              <th>#</th>
                             <th>Meses</th>
                             <th>Lectura</th>
                             <th>Valor M3</th>           
                             <th>SUB TOTAL</th>
                             <th>CARGO FIJO</th>
                             <th>OTROS COBROS</th>
                             <th>MORA</th>
                             <th>TOTAL</th>
                             <th>ESTADO</th>
                             <th></th>
                           </tr> 

                        </thead>

                        <tbody id="cronogramapago">

        <tbody id="cronogramapago">


         
            <?php 
               //var_dump($data2);
              foreach ($data2 as $key => $value) {
                if($value['estado'] == 1 || $value['estado'] == 2 || $value['estado'] == 3  || $value['estado'] == 4){
                echo '<tr id="fila">
                        <td>'.($key+1).'</td>
                        <td>'.$value["month_billed"].'</td>
                        <td>'.$value["totalM3"].'</td>
                        <td>'.$value["valorM3"].'</td>                        
                        <td>'.$value["subtotal"].'</td>
                        <td class="igv-row"><?php echo $value["igv"]; ?></td>

                        <td>'.$value["cargofijo"].'</td>
                        <td>'.$value["otroscobros"].'</td>
                        <td>'.$value["mora"].'</td>
                        <td>'.$value["totalpagar"].'</td>';
                        if($value["estado"] == 0){
                          echo '<td><span class="badge bg-green">Pagado</span></td>';
                        }else if($value["estado"] == 1){
                          echo '<td><span class="badge bg-yellow">Pendiente</span></td>';
                        }else if($value["estado"] == 2){
                          echo '<td><span class="badge bg-red">Vencido</span></td>';
                        }else if($value["estado"] == 3){
                          echo '<td><span class="badge bg-yellow">........</span></td>';
                        }
                        else if($value["estado"] == 4){
                          echo '<td><span class="badge bg-black">Rechazado</span></td>';
                        }

                        if($value["estado"] == 3 || $value["estado"] == 4){
                          echo '<td></td>';
                        }else {
                        echo '<td>

                      <div> 
                      <input type="checkbox" name="check-cobros" class="check-cobro" value="'.$value["idrecibo"].'" data-totalm3="'.$value["totalM3"].'" data-valorm3="'.$value["valorM3"].'" data-idservicio="'.$value["idservicio"].'" data-cargofijo="'.$value["cargofijo"].'" data-otroscobros="'.$value["otroscobros"].'" data-mora="'.$value["mora"].'" data-igv="'.$value["igv"].'" data-subtotal="'.$value["subtotal"].'" data-total="'.$value["totalpagar"].'"/>';
                        }

                 echo '</tr>';
              }
          }

            ?>   
        </tbody >
         <tfoot id="cronogramapagofooter">
                                                                                   
          </tfoot>
       </table>
			   <div class="col-md-12">
                      <div class="col-md-6">
                        <div class="form-row">
                          <div class="form-group col-md-12">
                            <label for="inputCity">Ingrese numero de transación:</label>
                            <div class="col-md-12" style="padding-left: 0!important;">
                              <div class="col-md-8">
                                <div class="input-group">
                                  <span class="input-group-addon"><i class="fa fa-address-card"></i></span>
                                  <input type="text" class="form-control" id="idtransacion" name="idtransacion">
                                </div>
                              </div>
                              <br>
                              <div class="col-md-8" style="margin-top: 10px; text-align: center;">
                                <button type="button" class="btn btn-primary btn-gurdarPago">Enviar e imprimir comprobante</button>
                              </div>
                            </div>
                          </div>
                          <div class="form-froup col-md-12">
                            <h4 style="font-size: 30px; font-weight: 600;"></h4>
                             
                          </div>
                          

                        </div>
                      </div>
                      <div class="col-md-6" id="detallePago" style="text-align: right;">
                        
                      </div>
        </div>
        <div class="col-md-3"></div>
         <div class="col-md-8">
          <img src="vistas/img/Error.png" width="90%" alt="">
          
        </div>
		</div>
  






<!-- deudas pendientes tabla -->
<div class="col-md-12 d-none deudasPagadas">
        <br>
        <table class="detalle table table-bordered table-striped table-hover table-condensed">
       
                    <thead>
         
                       <tr>
                          <th>#</th>
                         <th>Meses</th>
                         <th>Total M3</th>
                         <th>Valor M3</th>           
                         <th>SUB TOTAL</th>
                         <th>CARGO FIJO</th>
                         <th>OTROS COBROS</th>
                         <th>MORA</th>
                         <th>TOTAL</th>
                         <th>ESTADO</th>
                         <th></th>
                       </tr> 

                    </thead>

                    <tbody id="cronogramapago">

    <tbody id="cronogramapago">


     
        <?php 
          foreach ($data2 as $key => $value) {
            if($value['estado'] == 0){
              
            echo '<tr id="fila">
                    <td>'.($key+1).'</td>
                    <td>'.$value["month_billed"].'</td>
                    <td>'.$value["totalM3"].'</td>
                    <td>'.$value["valorM3"].'</td>                        
                    <td>'.$value["subtotal"].'</td>
                    <td>'.$value["igv"].'</td>
                    <td>'.$value["cargofijo"].'</td>
                    <td>'.$value["otroscobros"].'</td>
                    <td>'.$value["mora"].'</td>
                    <td>'.$value["totalpagar"].'</td>';
                    if($value["estado"] == 0){
                      echo '<td><span class="badge bg-green">Pagado</span></td>';
                    }else if($value["estado"] == 1){
                      echo '<td><span class="badge bg-yellow">Pendiente</span></td>';
                    }else if($value["estado"] == 2){
                      echo '<td><span class="badge bg-red">Vencido</span></td>';
                    }


                    echo '<td>

                  <div> 
                  <button class="btn btn-info btnImprimirRecibo" idrecibo="'.$value["iddetallepago"].'">
                    <i class="fa fa-print"></i></button>';
                    

             echo '</tr>';
          }
      }

        ?>
    </tbody >


   </table>

</div>


	</div>
<?php  } ?>
</section>



</div>




<!--=====================================
MODAL GENERAR COBRO SERVICIO
======================================-->

<div id="modalMostrarRecibo" class="modal fade" role="dialog">
  
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header" style="background:#3c8dbc; color:white">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body"> 

          <div class="form-group form-space col-md-12">
            <div class="panel panel-success">
              <div class="panel-body" style="padding:0px">
                <div class="form-row">

                  <div class="recibo-pago" style="text-align: center;">
                    
                  </div>
                  
                    
                    
                </div>

              </div>
            </div>
          </div>  
      </div>

      <div class="modal-footer">
        
        <div class="col-md-12 text-center">
          <div class="boton-imprimir-recibo" style="display: inline-block; margin-right: 20px">
                
        </div>
          <button type="button" class="btn btn-danger btn-aceptar" data-dismiss="modal">
          Aceptar
        </button>
        </div>
        
      </div>
    </div>

  </div>

</div>

