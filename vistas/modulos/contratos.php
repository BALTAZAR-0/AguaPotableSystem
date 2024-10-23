<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      <SMALL><B>ADMINISTRAR LECTURAS DE AGUA POTABLE</B></SMALL>
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="admin-inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar lecturas</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">
  
        <a href="crear-contratos">

          <button class="btn btn-primary">
            
            <B>Agregar cliente</B>

          </button>

        </a>

      </div>

      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive tablas">
         
        <thead>
         
         <tr>
           
           <th style="width:10px">#</th>
           <th>Código Cliente</th>      
           <th>Cliente</th>
           <th>Zona</th>
           <th>Dirección</th>          
           <th>N° Medidor</th>
           <th>Estado</th>
           <th>Acciones</th>

         </tr> 

        </thead>

        <tbody>

        <?php

        $item = null;
        $valor = null;

        $contratos = ControladorContratos::ctrMostrarContratos($item, $valor);
        //Parse error: syntax error, unexpected end of file in C:\xampp\htdocs\SisRecoleccion\vistas\modulos\contratos.php on line 111
        

       foreach ($contratos as $key => $value){
         
          echo ' <tr>
                  <td>'.($key+1).'</td>
                  <td>'.$value["codigo"].'</td>';
                 
                echo '<td>'.$value["nombres"]." ".$value["apaterno"]." ".$value["amaterno"].'</td>';

                
                 echo '<td>'.$value["nombrezona"].'</td>';          
               
                                
                echo '<td>'.$value["direccion"].'</td>';                

                 echo '<td>'.$value["codigomedidor"].'</td>';


                  if($value["estado"] == 0){

                        echo '<td><span class="badge bg-green" idservicios="'.$value["idservicio"].'" estadoPersona="1">Lecturado</span></td>';

                      }else if($value["estado"] == 1){

                        echo '<td><span class="badge bg-yellow" idservicios="'.$value["idservicio"].'" estadoPersona="0">Pendiente</span></td>';

                      }
                      else if($value["estado"] == 2){

                        echo '<td><span class="badge bg-black" idservicios="'.$value["idservicio"].'" estadoPersona="0">Vencido</span></td>';

                      }

                       echo '<td>

                      <div> 
                      <button class="btn bg-success btnGenerarCobro" idservicio="'.$value["idservicio"].'"   idservicios="'.$value["codigo"].'" idserviciosPer="'.$value["idpersona"].'" style="background: #39ff39;">
                        <i class="fa fa-money"></i></button> 
                        
                        <button class="btn btn-info btnImprimirEstado" idservicio="'.$value["idservicio"].'">
                        <i class="fa fa-print"></i></button>                          
                        
                        <button class="btn btn-warning btnDetalleContrato" idservicios="'.$value["idservicio"].'"><i class="fa fa-eye"></i></button>';
                        $cod = 'hola' . $value["idservicio"];
                        
                      if($_SESSION["perfil"] == "Administrador"){

                          echo ' <button class="btn btn-danger btnEliminarContrato" idservicios="'.$value["idservicio"].'"><i class="fa fa-trash"></i></button>';

                      }


                      echo '</div>  

                    </td>            

                  

                </tr>';
        }


        ?> 

        </tbody>

       </table>

      </div>

    </div>

  </section>

</div>



<div id="modalEditarContrato" class="modal fade" role="dialog">
  
<div class="modal-dialog modal-lg">
    <div class="modal-content">

      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->
     
        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Cronograma de Pagos</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

            <table class="table table-bordered table-striped dt-responsive tablas tablaContratos" width="100%">
              
         
        <thead>
         
         <tr>
           
           <th style="width:10px">#</th>
           <th>Fechas de pagos</th>
           <th>Monto</th>
           <th>Estado</th>
           
         </tr> 

        </thead>

        <tbody id="tablebody1">
         
   
        </tbody>

       </table>            
            
  
          </div>

        </div>



        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Cerrar</button>
          

        </div>

      </form>

      </div>

  </div>

</div>




<!--=====================================
MODAL GENERAR COBRO SERVICIO
======================================-->

<div id="modalGenerarCobro" class="modal fade" role="dialog">
  
<div class="modal-dialog modal-lg">
    <div class="modal-content">


        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title"><B>GENERAR NUEVO RECIBO </B> </h4>
        
        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->
       <?php  // $data2 = json_decode($_SESSION['arregloD'],true); ?>

      


        <div class="modal-body">

          <div class="box-body">
          		<form id="formularioReciboContrato" method="post" autocomplete="off">

                   <div class="form-row">
                   		<div class="form-group col-md-4">
                          <label for="inputCity">Codigo cliente:</label>

                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>

                            <input type="hidden" class="form-control" id="idpersona" name="idpersona" placeholder="idPersona" readonly="">

                            <input type="text" class="form-control" id="codigoRecibo" name="codigoRecibo"placeholder="Ingresar Codigo" value= ""  readonly="">
                           
                      
                          </div>
                        </div>
                        <div class="form-group col-md-4">
                          <label for="inputCity">Lecturado Anterior:</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input type="text" class="form-control" id="lecturaMedidoranterior" name="lecturaMedidoranterior"placeholder="Lecturado Anterior" readonly="">
                          </div>
                        </div>
                        <div class="form-group col-md-4">
                          <label for="inputCity">Lecturado Actual:</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input type="text" class="form-control" id="lecturaMedidor" name="lecturaMedidor" placeholder="Monto Lecturado" autocomplete="off">
                          </div>
                        </div>

                        <div class="form-group col-md-4">
                          <label for="inputCity">Fecha Vence de Pago:</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                           <input type="date" class="form-control" id="nuevoFechaVencimiento" name="nuevoFechaVencimiento" placeholder="Fecha nacimiento">
                          </div>
                          
                        </div>

                        <div class="form-group col-md-4">
                          <label for="inputCity">Ultimo Mes Facturado:</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <?php date_default_timezone_set('UTC'); ?>
                           <input type="text" class="form-control" id="mesFacturado" name="mesFacturado" placeholder="Ultimo Mes" data-inputmask="'alias': 'm/yyyy'"  data-mask >
                          </div>
                          
                        </div>
                       
                       <div class="form-group col-md-4">
                         <label for="inputCity"><p></p></label>
                            <div class="input-group">
                              <input type="submit" id="calcularCobro" class="btn btn-primary" value="Generar Recibo" />
                            </div>
                          </div>
                    </div>
                 </form>

                 <?php

                  //$actualizarCliente = new ControladorCobros();
                  //$actualizarCliente -> ctrActualizarCliente();
                  
                ?>

                  <div class="form-group form-space col-md-12">
                    <div class="panel panel-success">
                      <div class="panel-heading">
                        <center>
                        <h3 class="panel-title"><B>DATOS DEL RECIBO</B></h3>
                        </center>
                      </div>
                      <div class="panel-body" style="padding:0px">
                        <div class="form-row">

                        	<div class="recibo-pago" style="text-align: center;">
                        		<h5><B>Por favor genere su recibo...</B></h5>
                        		
                        	</div>
                          
                            
                            
                        </div>

                      </div>
                    </div>
                  </div>    
            
  
          </div>

        </div>



        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">
          
            <div class="boton-imprimir-recibo" style="display: inline-block; margin-right: 20px">
              
            </div>

            <button type="button" class="btn btn-danger pull-right btn-salir" data-dismiss="modal">Cerrar</button>

        
        </div>


      </div>

  </div>

</div>
