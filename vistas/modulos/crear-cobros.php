<?php

if($_SESSION["perfil"] == "Especial"){

  echo '<script>

    window.location = "inicio";

  </script>';

  return;

}

?>
<div class="content-wrapper">
  <section class="content-header">
    <h1><small><b>REALIZAR NUEVO COBRO</b></small></h1>
    <ol class="breadcrumb">
      <li><a href=""><i class="fa fa-dashboard"></i>Inicio</a></li>
      <li class="active">Nuevo cobranza</li>
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
                        <h2 class="panel-title"><b>DATOS DEL CLIENTE</b></h2>
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
                            <input type="text" class="form-control" id="nuevoNombreCliente" name="nuevoNombreCliente" placeholder="Nombres y Apellidos" required readonly="">                           
                            
                            <span class="input-group-btn">
                              <button id="cliente" type="button" class="btn btn-success"><span class="fa fa-search"></span> Cliente</button>

                          </div>

                        </div>
                      </div>


                      <div class="form-row">
                        <div class="form-group col-md-2">
                          <label for="inputCity">Documento:</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-address-card"></i></span>
                            <input type="text" class="form-control" id="nuevoDocumento" name="nuevoDocumento" placeholder="75602689" required readonly>
                          </div>
                        </div>

                        <div class="form-group col-md-2">
                          <label for="inputCity">Nro Medidor:</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-code"></i></span>
                            <input type="text" class="form-control" id="nuevoTelefono" name="nuevoTelefono" placeholder="+51918908587" required readonly>
                          </div>
                        </div>                      
                        
                      </div>

                     

                        <div class="form-group col-md-2">
                          <label for="inputCity">Código Cliente:</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-key"></i></span>
                            <input type="text" class="form-control" id="nuevoCodigoR" name="nuevoCodigoR" readonly>
                          </div>
                        </div>                   

                    </div>
                  </div>
                </div>                


                <div class="form-group form-space col-md-12">
                 
                  <div class="form-row">
                    <div class="box-body">

                      <table class="detalle table table-bordered table-striped table-hover table-condensed">
           
                        <thead>
             
                           <tr>
                             <th>MESES</th>
                             <th>LECTURA</th>
                             <th>VALOR M3</th>           
                             <th>SUB TOTAL</th>
                             <th>CARGO FIJO</th>
                             <th>COBROS ANTERIORES</th>
                             <th>MORA</th>
                             <th>TOTAL</th>
                             <th></th>
                           </tr> 

                        </thead>

                        <tbody id="cronogramapago">
                  
                        </tbody id="cronogramapago">

                        <tfoot id="cronogramapagofooter">
                                                                                   
                        </tfoot>
                      </table>
                    </div>
                    <div class="col-md-12">
                      <div class="col-md-6">
                        <div class="form-row">
                          <div class="form-group col-md-12">
                            <label for="inputCity">Con cuanto paga:</label>
                            <div class="col-md-12" style="padding-left: 0!important;">
                              <div class="col-md-8" style="padding: 0;">
                                <div class="input-group">
                                  <span class="input-group-addon"><i class="fa fa-address-card"></i></span>
                                  <input type="text" class="form-control" id="valorPaga" name="valorPaga">
                                </div>
                              </div>
                              <div class="col-md-4" style="padding: 0;">
                                <button type="button" class="btn btn-primary btn-calcularCambio">calcular</button>
                              </div>
                            </div>
                          </div>
                          <div class="form-froup col-md-12">
                            <h4 style="font-size: 30px; font-weight: 600;">Cambio: <span id="nuevoCambio">0</span></h4>
                             
                          </div>
                          

                        </div>
                      </div>
                      <div class="col-md-6" id="detallePago" style="text-align: right;">
                        
                      </div>
                    </div>
                    
                  </div>
                </div>    

              </div>


            </div>  
            <div class="box-footer">

             <a href="cobros"  class="btn btn-danger" ><i class="fa fa-arrow-circle-left"></i> Cancelar</a>

             <!-- <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-save"></i> Guardar</button> -->

            <button type="button" class="btn btn-primary guardarCobro"><i class="fa fa-save"></i> Guardar Cobro</button>

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
           <th>Código</th>
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

                    <td>'.$value["fecha_nacimiento"].'</td>

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





