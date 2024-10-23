<?php

if($_SESSION["perfil"] == "Especial"){

  echo '<script>

    window.location = "inicio";

  </script>';

  return;


}

$data2 = json_decode($_SESSION['arregloC'],true);

?>
<div class="content-wrapper">
  <section class="content-header">
    <h1> <SMALL><B>DETALLE DE COBRO</B></SMALL></h1>
    <ol class="breadcrumb">
      <li><a href=""><i class="fa fa-dashboard"></i>Inicio</a></li>
      <li class="active">Detalle de cobro</li>
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
                        <h3 class="panel-title"><b>DATOS DEL CLIENTE</b></h3>
                      </center>
                    </div>
                    <div class="panel-body" style="padding:0px">
                      <div class="form-row">
                        <div class="form-group col-md-4">
                          <label for="inputCity">Nombres y Apellidos:</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-child"></i></span>

                            <input type="hidden" class="form-control" id="idpersona" name="idpersona" >
                            <input type="hidden" class="form-control" id="IdUsuario" name="IdUsuario" value="<?php echo $_SESSION["id"]; ?>">
                            <input type="hidden" class="form-control" id="CodigoContrato" name="CodigoContrato" >
                            <input type="hidden" class="form-control" id="idservicios" name="idservicios" >
                            <input type="text" class="form-control" id="nuevoNombreCliente" name="nuevoNombreCliente" value="<?php echo $data2[0]["nombres"] ?>" required readonly>                           
                            
                            
                          </div>

                        </div>
                      </div>


                      <div class="form-row">
                        <div class="form-group col-md-2">
                          <label for="inputCity">Documento:</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-address-card"></i></span>
                            <input type="text" class="form-control" id="nuevoDocumento" name="nuevoDocumento" value="<?php echo $data2[0]["documento"] ?>" required readonly>
                          </div>
                        </div>

                        <div class="form-group col-md-2">
                          <label for="inputCity">Telefono:</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-volume-control-phone"></i></span>
                            <input type="text" class="form-control" id="nuevoTelefono" name="nuevoTelefono" value="<?php echo $data2[0]["telefono"] ?>" required readonly>
                          </div>
                        </div>                      
                        
                      </div>

                      <div class="form-group col-md-2">
                          <label for="inputCity">Código A:</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-key"></i></span>
                            <input type="text" class="form-control" id="nuevoCodigo" name="nuevoCodigo" value="<?php echo $data2[0]["codigoservicio"] ?>" readonly>

                            
                          </div>
                        </div>

                        <div class="form-group col-md-2">
                          <label for="inputCity">Código R:</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-key"></i></span>
                            <input type="text" class="form-control" id="nuevoCodigoR" name="nuevoCodigoR" value="<?php echo $data2[0]["codigoservicio"] ?>" readonly>

                            
                          </div>
                        </div>                    

                    </div>
                  </div>
                </div>                


                <div class="form-group form-space col-md-12">
              

                  


                <div class="form-row">
                <div class="box-body">

                  <!-- tabla para mostrar el detalle de cada cobro -->

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
                        

                 echo '</tr>';
              }

            ?>

          
         
          
        </tbody >

        <tfoot>
            <th></th>
            <th>Totales</th>
            <th><?= $data2[0]["newtotalm3"] ?></th>
            <th><?= $data2[0]["newvalorm3"] ?></th>
            <th><?= $data2[0]["newsubtotal"] ?></th>
            <th><?= $data2[0]["newigv"] ?></th>
            <th><?= $data2[0]["newcargofijo"] ?></th>
            <th><?= $data2[0]["newotroscobros"] ?></th>
            <th><?= $data2[0]["newmora"] ?></th>
            <th><?= $data2[0]["newtotalpagar"] ?></th>
                                        
                                    
                                     
        </tfoot>

       </table>

                </div>

                     

                </div>

                    
                  

                   

                  

                </div>    

              </div>


            </div>  
            <div class="box-footer">

             <a href="cobros" type="button" class="btn btn-danger"><i class="fa fa-arrow-circle-left"></i> Regresar</a>

          </div>
          </form>
        </div>
      </div>


      <?php
/*
        $crearCobros = new ControladorCobros();
        $crearCobros -> ctrCrearCobros();
*/
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
                          
                        <button class="btn btn-success btnAgregarDatos" idPersonaServicio="'.$value["idpersona"].'"><i class="fa fa-check"></i></button>

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





