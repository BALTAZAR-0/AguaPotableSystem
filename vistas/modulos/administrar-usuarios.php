
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
    <h1>Consulta de monto a entregar</h1>
    <ol class="breadcrumb">
      <li><a href=""><i class="fa fa-dashboard"></i>Inicio</a></li>
      <li class="active">Consulta de monto a entregar</li>
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
                        <h3 class="panel-title">Datos del Usuario</h3>
                      </center>
                    </div>
                    <div class="panel-body" style="padding:0px">
                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="inputCity">Nombres y Apellidos:</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-child"></i></span>

                            <input type="hidden" class="form-control" id="idpersona" name="idpersona" required>

                            <input type="hidden" class="form-control" id="idusuario" name="idpersona" required>

                            <input type="text" class="form-control" id="nuevoNombreCliente" name="nuevoNombreCliente" placeholder="Nombres y Apellidos" required readonly="">                           
                            
                            <span class="input-group-btn">
                              <button id="usuarios" type="button" class="btn btn-success"><span class="fa fa-search"></span> Usuarios</button>

                          </div>

                        </div>
                      </div>


                      <div class="form-row">
                        <div class="form-group col-md-3">
                          <label for="inputCity">Perfil:</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-address-card"></i></span>
                            <input type="text" class="form-control" id="nuevoDocumento" name="nuevoDocumento" placeholder="Perfil" required readonly>
                          </div>
                        </div>

                        <div class="form-group col-md-3">
                          <label for="inputCity">Nombre de Usuario:</label>
                          <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-volume-control-phone"></i></span>
                            <input type="text" class="form-control" id="nuevoTelefono" name="nuevoTelefono" placeholder="Systemw codephp" required readonly>
                          </div>
                        </div>                      
                        
                      </div>                    

                    </div>
                  </div>
                </div> 


                <div class="form-group form-space col-md-12">
                  <div class="panel">
                    <div class="panel-body " >
                      <div class="form-row">
                        <div class="form-group col-md-4 ">
                          <label>Reportes</label>
                          <select class="selectReporte form-control" disabled>
                            <option value="0">Seleccionar</option>
                            <option value="dia">Hoy</option>
                            <option value="semana">Últimos 7 días</option>
                            <option value="mensual">Últimos 30 días</option>
                          </select> 

                        </div>
                      </div>
                        
                      </div>                    

                    </div>
                  </div>



                <div class="form-group form-space col-md-12">
                 

                  


                <div class="form-row">
                <div class="box-body">

                <table class="table table-bordered table-striped table-hover table-condensed vistaCronograma" id="vistaCronograma">
         
        <thead>
         
         <tr>
           
           <th style="width:10px">#</th>
           <th>Servicio</th>
           <th>Codigo</th>
           <th>Fecha de cobro</th>
           <th>Total</th>                    

         </tr> 

        </thead>

        <tbody id="tablebody2">
          
          <tr id="fila">

            

          </tr>

          
        </tbody id="cronogramapago">

       </table>

                </div>

                     

                </div>

                    
                  

                   

                  

                </div>    

              </div>


            </div>  
            
          </form>
        </div>
      </div>

    </div>
  </section>

</div>


<!--=====================================
MODAL AGREGAR CLIENTE
======================================-->

<div id="modalAgregarUsuario" class="modal fade" role="dialog">
  
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
           <th>Nombre</th>
           <th>Perfil</th>
           <th>Usuario</th>
           <th>Estado</th>
           <th>Ultimo Login</th>          
                 
           <th>Seleccionar</th>

         </tr> 

        </thead>

        <tbody>
          <?php

          $item = null;
          $valor = null;

          $personas = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);

          foreach ($personas as $key => $value) {
            

            echo '<tr>

                    <td>'.($key+1).'</td>

                    <td>'.$value["nombre"].'</td>

                    <td>'.$value["perfil"].'</td>

                    <td>'.$value["usuario"].'</td>';

                    if ($value["estado"] == 1){
                      echo '<td><span class="badge bg-green" >Activo</span></td>';
                    }else{
                      echo '<td><span class="badge bg-grey" >Inactivo</span></td>';
                    }


                   echo  '<td>'.$value["ultimo_login"].'</td>
                                     

                    <td>

                      <div class="btn-group">
                          
                        <button type="button" class="btn btn-success btnAgregarUsuario" idusuario="'.$value["id"].'"><i class="fa fa-check"></i></button>

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

