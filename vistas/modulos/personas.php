<?php

if($_SESSION["perfil"] == "Invitado"){

  echo '<script>

    window.location = "admin-inicio";

  </script>';

  return;

}

?>

<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      <small><b>ADMINISTRAR CLIENTES  </b></small>
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="admin-inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar clientes</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">
  
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarPersona">
          
          <b>Nuevo cliente</b>

        </button>

      </div>

      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive tablas" width="100%">
         
        <thead>
         
         <tr>
           
           <th style="width:10px">#</th>           
           <th>Datos Cliente</th>
           <th>Nro Documento</th>
           <th>Codigo Cliente</th>
           <th>Sexo</th>
           <th>Zona</th>           
           <th>Nro Medidor</th>    
           <th>Acciones</th>

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
                    

                    <td>'.$value["apaterno"].' '.$value["amaterno"].', '.$value["nombres"].'</td>

                    <td>'.$value["documento"].'</td>

                    <td>'.$value["fecha_nacimiento"].'</td>';


                    if($value["sexo"] != "F"){

                        echo '<td><span class="badge bg-blue" idPersona="'.$value["idpersona"].'" sexoPersona="M"><i class="fa fa-male"></i> M</span></td>';

                      }else{

                        echo '<td><span class="badge bg" style="background-color: #f94877;" idPersona="'.$value["idpersona"].'" sexoPersona="F"><i class="fa fa-female"></i> F</span></td>';

                      }
                      $item = "idzona";
                      $datos = $value["idZona"];
                      $datosZona = ControladorZona::ctrConsultarZona($item, $datos);
                     echo '<td>'.$datosZona[0]["nombrezona"].'</td>';

                    echo '<td>'.$value["telefono"].'</td>';

                    /*if($value["estado"] == 0){

                        echo '<td><span class="label label-success" idPersona="'.$value["idpersona"].'" estadoPersona="1">Activo</span></td>';

                      }else if($value["estado"] == 1){

                        echo '<td><span class="label label-warning" idPersona="'.$value["idpersona"].'" estadoPersona="0">Suspendido</span></td>';

                      }
                      else if($value["estado"] == 2){

                        echo '<td><span class="label label-danger" idPersona="'.$value["idpersona"].'" estadoPersona="0">Cancelado</span></td>';

                      }*/
                      

                    echo '<td>

                      <div>                         
                        
                        <button class="btn btn-warning btnEditarPersona" data-toggle="modal" data-target="#modalEditarPersona" idPersona="'.$value["idpersona"].'"><i class="fa fa-pencil"></i></button>';

                      if($_SESSION["perfil"] == "Administrador"){

                          echo ' <button class="btn btn-danger btnEliminarPersona" idPersona="'.$value["idpersona"].'"><i class="fa fa-trash"></i></button>';

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

<!--=====================================
MODAL AGREGAR CLIENTE
======================================-->

<div id="modalAgregarPersona" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Agregar cliente</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body" style="padding:0px">

          <div class="box-body" style="padding:0px">

                  <!-- ENTRADA PARA EL NOMBRE -->

                  <div class="form-row">

                    <div class="form-group col-md-6">
                      <label for="inputCity">Nombres:</label>
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-address-card"></i></span>
                        <input type="text" class="form-control" name="nuevoNombres" placeholder="Nombres" required>
                      </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputCity">Apellido Paterno:</label>
                        <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-address-card"></i></span>
                          <input type="text" class="form-control" name="nuevoApellidoPaterno" placeholder="Apellido paterno">
                        </div>
                      </div>

                  </div>

                  <div class="form-row">                     
                    
                    <div class="form-group col-md-6">
                      <label for="inputCity">Apellido Materno:</label>
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-address-card"></i></span>
                        <input type="text" class="form-control" name="nuevoApellidoMaterno" placeholder="Apellido materno">
                      </div>
                    </div>
                    
                    <div class="form-group col-md-6">
                      <label for="inputCity">Nro Documento</label>
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-drivers-license-o"></i></span>              
                        <input type="text" class="form-control" id="nuevoDocumento" name="nuevoDocumento" placeholder="N° DPI" required>
                      </div>
                    </div>

                  </div>

                  <div class="form-row">
                    <div class="form-group col-md-6">

                      <label for="inputCity">Sexo:</label>

                        <div class="">

                          
                            <label>                                         
                              <input type="radio" class="minimal porcentaje" name="sexo" id="sexo" value="M" checked="checked">
                              Masculino                         
                            </label>
                          
                            <label>                                          
                              <input type="radio" class="minimal porcentaje" name="sexo" id="sexo" value="F">
                              Femenino                            
                            </label>
                          

                        </div>

                    </div>
                  

                  <div class="form-group col-md-6">
                      <label for="inputCity">Codigo Cliente:</label>
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-gg-circle"></i></span>
                        <input type="text" class="form-control" name="nuevoFechaNacimiento" placeholder="Codigo Cliente">
                      </div>
                    </div>  





                </div>

                <div class="form-row">                     
                    
                    <div class="form-group col-md-6">
                      <label for="inputCity">Nro Medidor:</label>
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-code"></i></span>
                        <input type="text" class="form-control" name="nuevoTelefono" placeholder="Nro Medidor" required>
                      </div>
                    </div>

                    
                    <div class="form-group col-md-6">
                      <label for="inputCity">Zona:</label>
                      <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-flag-checkered"></i></span>
                      <select class="form-control" id="nuevoZona" name="nuevoZona" required>
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

                  </div>


                  <div class="form-row">                     
                    
                    <div class="form-group col-md-12">
                      <label for="inputCity">Dirección:</label>
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                        <input type="text" class="form-control" name="nuevoDireccion" placeholder="Dirección">                      
                      </div>
                    </div>
                      
                     <!--<div class="form-group col-md-12">
                      <label for="inputCity">E-mail:</label>
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
                        <input type="text" class="form-control" name="nuevoEmail" placeholder="E-mail">
                        
                      </div>
                    </div>-->

                  </div>
  
        </div>
    </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>

          <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>

        </div>

      </form>

      <?php

        $crearPersona = new ControladorPersonas();
        $crearPersona -> ctrCrearPersona();

      ?>

    </div>

  </div>

</div>

<!--=====================================
MODAL EDITAR CLIENTE
======================================-->
<div id="modalEditarPersona" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Editar cliente</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body" style="padding:0px">

          <div class="box-body" style="padding:0px">

                  <!-- ENTRADA PARA EL NOMBRE -->

                  <div class="form-row">

                    <div class="form-group col-md-6">
                      <label for="inputCity">Nombres:</label>
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-address-card"></i></span>
                        
                        <input type="hidden" min="0" class="form-control" id="idpersona" name="idpersona">
                        <input type="text" class="form-control" id="editarNombres" name="editarNombres" placeholder="Nombres" required>
                      </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputCity">Apellido Paterno:</label>
                        <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-address-card"></i></span>
                          <input type="text" class="form-control" id="editarApellidoPaterno" name="editarApellidoPaterno" placeholder="Apellido paterno">
                        </div>
                      </div>

                  </div>

                  <div class="form-row">                     
                    
                    <div class="form-group col-md-6">
                      <label for="inputCity">Apellido Materno:</label>
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-address-card"></i></span>
                        <input type="text" class="form-control" id="editarApellidoMaterno" name="editarApellidoMaterno" placeholder="Apellido materno">
                      </div>
                    </div>
                    
                    <div class="form-group col-md-6">
                      <label for="inputCity">Nro Documento:</label>
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-drivers-license-o"></i></span>              
                        <input required class="form-control" id="editarDocumento" name="editarDocumento" placeholder="N° Documento" required>
                      </div>
                    </div>

                  </div>

                  <div class="form-row">
                    <div class="form-group col-md-6">

                      <label for="inputCity">Sexo:</label>

                        <div class="">

                          
                            <label>                                         
                              <input type="radio" class="minimal porcentaje" name="editarSexo" id="editarSexoM" value="M">
                              Masculino                         
                            </label>
                          
                            <label>                                          
                              <input type="radio" class="minimal porcentaje" name="editarSexo" id="editarSexoF" value="F">
                              Femenino                            
                            </label>
                          

                        </div>

                    </div>
                  

                  <div class="form-group col-md-6">
                      <label for="inputCity">Codigo Cliente:</label>
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-gg-circle"></i></span>
                        <input type="text" class="form-control" id="editarFechaNacimiento" name="editarFechaNacimiento" placeholder="Codigo Cliente">
                      </div>
                    </div>                  

               </div>   

                <div class="form-row">                     
                    
                    <div class="form-group col-md-6">
                      <label for="inputCity">Nro Medidor:</label>
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-code"></i></span>
                        <input type="text" class="form-control" id="editarTelefono" name="editarTelefono" placeholder="Nro Medidor" required>
                      </div>
                    </div>
                    
                    <div class="form-group col-md-6">
                      <label for="inputCity">Zona:</label>
                      <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-flag-checkered"></i></span>
                      <select class="form-control" name="editarZona" id="editarZona" required>
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

                  </div>


                  <div class="form-row">                     
                    
                    <div class="form-group col-md-12">
                      <label for="inputCity">Dirección:</label>
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                        <input type="text" class="form-control" id="editarDireccion" name="editarDireccion" placeholder="Dirección">                      
                      </div>
                    </div>
                      
                    <!--<div class="form-group col-md-12">
                      <label for="inputCity">E-mail:</label>
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
                        <input type="text" class="form-control" id="editarEmail" name="editarEmail" placeholder="E-mail">
                        
                      </div>
                    </div>-->

                  </div>          

            
  
        </div>
    </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>

          <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar cambios</button>

        </div>

      </form>

        <?php

        $editarPersona = new ControladorPersonas();
        $editarPersona -> ctrEditarPersona();

      ?>

 

    </div>

  </div>

</div>

<?php

  $eliminarPersona = new ControladorPersonas();
  $eliminarPersona -> ctrEliminarPersona();

?>



