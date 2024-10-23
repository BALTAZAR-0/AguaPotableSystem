<?php

if($_SESSION["perfil"] == "Especial"){

  echo '<script>

    window.location = "inicio";

  </script>';

  return;

}


$data2 = json_decode($_SESSION['arregloD'],true);

?>
<div class="content-wrapper">
  <section class="content-header">
    <h1><SMALL><B>DETALLE DE SERVICIO DE AGUA POTABLE</B></SMALL></h1>
    <ol class="breadcrumb">
      <li><a href=""><i class="fa fa-dashboard"></i>Inicio</a></li>
      <li class="active">Nuevo contrato de servicio</li>
    </ol>
  </section>

  <section class="content">

    <div class="row">
      <div class="col-lg-12 col-xs-12">
        <div class="box box-success">
          <form role="form" method="post" class="" enctype="multipart/form-data">
            <div class="row pt-4 mt-4">
              <div class="col-md-12 pt-4 sc"> 

                <div class="form-group form-space col-md-12">
                  <div class="panel panel-success">
                    <div class="panel-heading">
                      <center>
                      <h3 class="panel-title"><B>DATOS DE SERVICIO</B></h3>
                      </center>
                    </div>
                    <div class="panel-body" style="padding:0px">
                      <div class="form-row">
                        <div class="form-group col-md-5">
                          <label for="inputCity">Usuario:</label>

                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input type="text" class="form-control" id="nuevoUsuario" value="<?php echo $_SESSION["nombre"]; ?>" readonly>
                            <input type="hidden" class="form-control" id="IdUsuario" name="IdUsuario" value="<?php echo $_SESSION["id"]; ?>">
                          </div>

                        </div>
                      </div> 

                      <div class="form-group col-md-3">
                          <label for="inputCity">Código Cliente</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-key"></i></span>

                            <input type="text" class="form-control" id="nuevoCodigo" name="nuevoCodigo" value="<?= $data2[0]['codigoservicio'] ?>" readonly>                         

                            
                          </div>
                        </div>
                        
                        
                        
                        <div class="form-group col-md-4">
                          <label for="inputCity">Direccion cliente:</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-file-text"></i></span>
                            <input type="text" class="form-control" id="nuevaDireccion" name="nuevaDireccion" value="<?= $data2[0]['direccion'] ?>" readonly>
                          </div>
                        </div>


                                            <div class="panel-body" style="padding:0px">
                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="inputCity">Nombres y Apellidos:</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-child"></i></span>

                            <input type="hidden" class="form-control" id="idpersona" name="idpersona" required>

                            <input type="text" class="form-control" id="nuevoNombreCliente" name="nuevoNombreCliente" placeholder="Nombres y Apellidos" required value="<?= $data2[0]['nombres'] ?>" readonly>                           
                            
                            <span class="input-group-btn">
                              <button id="cliente" type="button" class="btn btn-success"><span class="fa fa-search"></span> Cliente</button>

                          </div>

                        </div>
                      </div>


                      <div class="form-row">
                        <div class="form-group col-md-3">
                          <label for="inputCity">Numero medidor:</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-address-card"></i></span>
                            <input type="text" class="form-control" id="numeroMedidor" name="numeroMedidor" placeholder="70123050" required value="<?= $data2[0]['codigomedidor'] ?>" readonly>
                          </div>
                        </div>                  
                        
                      </div>                    

                    </div>

                      </div>                        
                    </div>
                  </div>
                         

                  <div class="form-row">
                    <div class="col-md-12">
                      
<div class="box-body">

                  <!-- tabla para mostrar el detalle de cada cobro -->

                  <table class="detalle table table-bordered table-striped table-hover table-condensed">
           
                        <thead>
             
                           <tr>
                              <th>#</th>
                             <th>MESES</th>
                             <th>LECTURA</th>
                             <th>VALOR M3</th>           
                             <th>SUB TOTAL</th>
                             <th>CARGO FIJO</th>
                             <th>COBROS ANTERIORES</th>
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
                        }else if($value["estado"] == 3){
                          echo '<td><span class="badge bg-yellow">........</span></td>';
                        }


                        echo '<td>

                      <div> 
                      <button class="btn btn-info btnImprimirRecibo" idrecibo="'.$value["idrecibo"].'">
                        <i class="fa fa-print"></i></button>';
                        

                 echo '</tr>';
              }

            ?>

          
         
          
        </tbody >


       </table>

                </div>


                    </div>
                  </div>
                    


                  

                   

                  

                </div>    

              </div>


            </div>  
            <div class="box-footer">

             <!-- <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Cancelar</button> -->
             <a href="contratos"  class="btn btn-danger" ><i class="fa fa-arrow-circle-left"></i> Cancelar</a>

             <!-- <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-save"></i> Guardar</button> -->

            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>

          </div>
          </form>
        </div>
      </div>

      <?php

        $crearContrato = new ControladorContratos();
        $crearContrato -> ctrCrearContratos();

        ?>       
    </div>
  </section>

</div>


<!--=====================================
MODAL AGREGAR CLIENTE
======================================-->

<div id="modalAgregarPersona" class="modal fade" role="dialog">
  
<div class="modal-dialog modal-lg">
    <div class="modal-content">

      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Seleccionar cliente</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

            <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
         
        <thead>
         
         <tr>
           
           <th style="width:10px">#</th>
           <th>Documento</th>
           <th>Nombres</th>
           <th>Apellido Paterno</th>
           <th>Apellido Materno</th>
           <th>Sexo</th>          
                 
           <th>Seleccionar</th>

         </tr> 

        </thead>

        <tbody>
          <?php

          $item = null;
          $valor = null;

          $personas = ControladorPersonas::ctrMostrarPersonas($item, $valor);

          foreach ($personas as $key => $value) {
            

            echo '<tr>

                    <td>'.($key+1).'</td>

                    <td>'.$value["documento"].'</td>

                    <td>'.$value["nombres"].'</td>

                    <td>'.$value["apaterno"].'</td>

                    <td>'.$value["amaterno"].'</td>';

                    if($value["sexo"] != "F"){

                        echo '<td><span class="badge bg-blue" idPersona="'.$value["idpersona"].'" sexoPersona="M"><i class="fa fa-male"></i> M</span></td>';

                      }else{

                        echo '<td><span class="badge bg" style="background-color: #f94877;" idPersona="'.$value["idpersona"].'" sexoPersona="F"><i class="fa fa-female"></i> F</span></td>';

                      }

                    

                    echo '<td>

                      <div class="btn-group">
                          
                        <button class="btn btn-success btnAgregarDatosContrato" idPersonaContrato="'.$value["idpersona"].'"><i class="fa fa-check"></i></button>

                      </div>  

                    </td>

                  </tr>';
          
            }

        ?>       
   
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


<!--=====================================
MODAL AGREGAR TIPO DE SERVICIO
======================================-->

<div id="modalAgregarServicio" class="modal fade" role="dialog">
  
<div class="modal-dialog">
    <div class="modal-content">

      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Seleccionar el tipo de servicio</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

            <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
         
        <thead>
         
         <tr>
           
           <th style="width:10px">#</th>
           <th>Documento</th>
           <th>Nombres</th>
           <th>Apellido Paterno</th>
           <th>Apellido Materno</th>                   
                 
           <th>Seleccionar</th>

         </tr> 

        </thead>

        <tbody>
          <?php

          $item = null;
          $valor = null;

          $servicios = ControladorServicios::ctrMostrarServicios($item, $valor);


          foreach ($servicios as $key => $value) {
            

            echo '<tr>

                    <td>'.($key+1).'</td>

                    <td>'.$value["nombre"].'</td>

                    <td>'.$value["descripcion"].'</td>

                    <td>'.$value["cantidad_bolsa"].'</td>

                    <td>'.$value["valor_servicio"].'</td>';                  

                    

                    echo '<td>

                      <div class="btn-group">
                          
                        <button class="btn btn-success btnAgregarDatosS" idtipo_servicios="'.$value["idtipo_servicios"].'"><i class="fa fa-check"></i></button>

                        </div>  

                    </td>

                  </tr>';
          
            }

        ?>       
   
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




