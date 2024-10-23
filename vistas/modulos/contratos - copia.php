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
    <h1>Nuevo contrato de servicio</h1>
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
                      <h3 class="panel-title">Datos de la contrata</h3>
                      </center>
                    </div>
                    <div class="panel-body" style="padding:0px">
                      <div class="form-row">
                        <div class="form-group col-md-4">
                          <label for="inputCity">Usuario:</label>

                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input type="text" class="form-control" id="nuevoUsuario" value="<?php echo $_SESSION["nombre"]; ?>" readonly>
                            <input type="hidden" class="form-control" id="IdUsuario" name="IdUsuario" value="<?php echo $_SESSION["id"]; ?>">
                          </div>

                        </div>
                      </div> 

                      <div class="form-group col-md-3">
                          <label for="inputCity">Código documento:</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-key"></i></span>
                            <input type="text" class="form-control" name="nuevoCodigo" placeholder="000231" required readonly>
                          </div>
                        </div>
                        
                        <div class="form-group col-md-3">
                          <label for="inputCity">N° de Meses:</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-file-text"></i></span>
                            <input type="text" class="form-control" name="nuevoMeses" placeholder="12" required>
                          </div>
                        </div>
                        
                        <div class="form-group col-md-2">
                          <label for="inputCity">Ejemplo ver:</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-file-text"></i></span>
                            <input type="text" class="form-control" name="nuevoFolio" placeholder="001" required>
                          </div>
                        </div>

                      </div>                        
                    </div>
                  </div>
                

                <div class="form-group form-space col-md-12">
                  <div class="panel panel-success">
                    <div class="panel-heading">
                      <center>
                        <h3 class="panel-title">Datos del Cliente</h3>
                      </center>
                    </div>
                    <div class="panel-body" style="padding:0px">
                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="inputCity">Nombres y Apellidos:</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-child"></i></span>

                            <input type="hidden" class="form-control" id="idpersona" name="idpersona" required>

                            <input type="text" class="form-control" id="nuevoNombreCliente" name="nuevoNombreCliente" placeholder="Nombres y Apellidos" required readonly="">                           
                            
                            <span class="input-group-btn">
                              <button id="cliente" type="button" class="btn btn-success"><span class="fa fa-search"></span> Cliente</button>

                          </div>

                        </div>
                      </div>


                      <div class="form-row">
                        <div class="form-group col-md-3">
                          <label for="inputCity">Documento:</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-address-card"></i></span>
                            <input type="text" class="form-control" name="nuevoDocumento" placeholder="70123050" required readonly>
                          </div>
                        </div>

                        <div class="form-group col-md-3">
                          <label for="inputCity">Telefono:</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-volume-control-phone"></i></span>
                            <input type="text" class="form-control" name="nuevoTelefono" placeholder="+51985448416" required readonly>
                          </div>
                        </div>                      
                        
                      </div>                    

                    </div>
                  </div>
                </div>                


                <div class="form-group form-space col-md-12">
                  <div class="panel panel-success">
                    <div class="panel-heading">
                      <center>
                        <h3 class="panel-title">Datos del Servicio</h3>
                      </center>
                    </div>
                    <div class="panel-body" style="padding:0px">
                      <div class="form-row">

                        <div class="form-group col-md-5">
                          <label for="inputCity">Tipo de Servicio:</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-users"></i></span>

                            <input type="hidden" class="form-control" id="idtipo_servicios" name="idtipo_servicios" required>

                            <input type="text" class="form-control" id="nuevoTipoServicio" name="nuevoTipoServicio" placeholder="Tipo de Servicio" required readonly="">                            
                            
                            <span class="input-group-btn">
                              <button id="PersNac" type="button" class="btn btn-success"><span class="fa fa-search"></span> </button>

                          </div>

                        </div>
                      </div>


                      <div class="form-row">
                        <div class="form-group col-md-3">
                          <label for="inputCity">Descripción del servicio:</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-audio-description"></i></span>
                            <input type="text" class="form-control" name="nuevoDecripcionServ" placeholder="Descripción" required readonly>
                          </div>
                        </div>

                        <div class="form-group col-md-2">
                          <label for="inputCity">Cantidad de Bolsas:</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-align-center"></i></span>
                            <input type="text" class="form-control" name="nuevoCantBolsa" placeholder="8" required readonly>
                          </div>
                        </div>                      
                        
                        <div class="form-group col-md-2">
                          <label for="inputCity">Valor de Servicio:</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-usd"></i></span>
                            <input type="text" class="form-control" name="nuevoValorServicio" placeholder="Q.85.00" required readonly>
                          </div>
                        </div>                       
                        
                      </div>

                    </div>
                  </div>



                  <div class="form-row">
                    <div class="form-group col-md-12">
                      <button class="btn btn-success pull-right"><i class="fa fa-file-text"></i> Genererar Cronograma de pago</button>
                    </div>                                    

                  </div>

                    


                  


                <div class="form-row">
                <div class="box-body">

                <table class="table table-bordered table-striped dt-responsive tablas" width="100%">

                  <thead>

                    <tr>

                      <th style="width:10px">#</th>
                      <th>Valor</th>                     
                      <th>Descripción</th>
                      <th>Fechas de Pago</th> 
                      <th>Estado</th>

                    </tr> 

                  </thead>

                  <tbody>

                  <tr>
                      <td>01</td>
                      <td>Q. 10.00</td>
                      <td>Recolección de Basuras</td>
                      <td>2020-10-11</td>
                      <td>

                        <div>

                        <td><span class="label label-success">Activo</span></td>                


                        </div>  

                      </td>

                  </tr>

                  <tr>

                      <td>02</td>
                      <td>Q. 10.00</td>
                      <td>Recolección de Basuras</td>
                      <td>2020-11-11</td>
                      <td>

                        <div>

                        <td><span class="label label-success">Activo</span></td>                


                        </div>  

                      </td>

                  </tr>

                  <tr>
                      <td>03</td>
                      <td>Q. 10.00</td>
                      <td>Recolección de Basuras</td>
                      <td>2020-12-11</td>
                      <td>

                        <div>

                        <td><span class="label label-success">Activo</span></td>                


                        </div>  

                      </td>

                  </tr>



                  </tbody>

                </table>

                </div>

                     

                </div>

                    
                  

                   

                  

                </div>    

              </div>


            </div>  
            <div class="box-footer">

            <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-save"></i> Guardar</button>

          </div>
          </form>
        </div>
      </div>


      <?php

        /*$crearActa_Nacimiento = new ControladorActaNacimientos();
        $crearActa_Nacimiento -> ctrCrearActaNacimientos();*/

        ?>       
    </div>
  </section>

</div>



