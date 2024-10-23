<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
       <SMALL><B>ADMINISTRAR ESTADOS DE SERVICIOS</B></SMALL>
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="admin-inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar estados de servicios</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">



        <div class="form-row">                     
                                       
                    <div class="form-group col-md-3">
                      <label for="inputCity">Estado del Servicio:</label>
                      <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-flag-checkered"></i></span>
                      <select class="form-control" id="estadoServicio" name="estadoServicio" required>
                              <option value="">Seleccione</option>                    
                              <option value="0">Pagado</option>
                              <option value="1">Pendiente</option>                         
                                              
                      </select>  
                      </div>
                    </div>

                    <div class="form-group col-md-3">
                      <label for="inputCity">Zona:</label>
                      <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-flag-checkered"></i></span>
                      <input type="hidden" id="perfilusuario" value="<?= $_SESSION["perfil"] ?>">
                      <select class="form-control" id="zonaServicio" name="zonaServicio" required>
                        <option value="">Seleccione</option>                              
                         <?php 
                            $item = null;
                            $valor = null;
                            $zonas = ControladorZona::ctrConsultarZona($item, $valor);
                            foreach ($zonas as $key => $value) {
                               echo '<option value="'.$value["idzona"].'">'.$value["nombrezona"].'</option>';
                            }
                          ?>
                                              
                            </select>  
                      </div>
                    </div>

                    <div class="form-group col-md-3">
                      <label for="inputCity"></label>
                      <div class="input-group">
                      

                      <button class="btn btn-success reportePDF" >
          
                        <B>Descargar reporte </B><i class="fa fa-file-pdf-o"></i>

                      </button>
                        
                      </div>
                    </div>

                  </div>


  
        

      </div>

      <div class="box-body">
        
      <table class="table table-bordered table-striped dt-responsive tablas serviConti">
         
        <thead>
         
         <tr>
           
           <th style="width:10px">#</th>
           <th>Código</th>      
           <th>Cliente</th>
           <th>Zona</th>
           <th>Dirección</th>          
           <th>N° Medidor</th>
           <th>Estado</th>
           <th>Acciones</th>

         </tr> 

        </thead>

        <tbody id="serviCont">

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

                        echo '<td><span class="badge bg-green" idservicios="'.$value["idservicio"].'" estadoPersona="1">Pagado</span></td>';

                      }else if($value["estado"] == 1){

                        echo '<td><span class="badge bg-yellow" idservicios="'.$value["idservicio"].'" estadoPersona="0">Pendiente</span></td>';

                      }
                      else if($value["estado"] == 2){

                        echo '<td><span class="badge bg-black" idservicios="'.$value["idservicio"].'" estadoPersona="0">Vencido</span></td>';

                      }

                       echo '<td>

                      <div> 

                        <button class="btn btn-info btnImprimirEstado" idservicio="'.$value["idservicio"].'">
                        <i class="fa fa-print"></i></button>                          
                        
                        <button class="btn btn-warning btnDetalleContrato" idservicios="'.$value["idservicio"].'"><i class="fa fa-eye"></i></button>';

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

          <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Close</button>
          

        </div>

      </form>

      </div>

  </div>

</div>
