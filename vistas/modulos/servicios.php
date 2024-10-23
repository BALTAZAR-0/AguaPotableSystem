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
      
      <small><b>CONFIGURACIÓN DEL COBRO DE AGUA  </b></small>
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="admin-inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Configuración de servicio cobro de agua potable</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">
      <?php 
      $item = null;
      $valor = null;
      $resultado = ControladorServicios::ctrMostrarServicios($item, $valor);

      ?>
    

      <div class="box-body">

        <form action="" method="post" style="width: 70%; margin: 0 auto; margin-top: 20px;">
          <div class="row-form"> 
            <div class="col-md-6">
              <div class="group-control"> 
                <label>Nombre Servicio</label>  
                <input type="hidden" name="id_servicio" value="<?= $resultado[0]['idtiposervicio'] ?>">          
                <input type="text" class="form-control" name="nuevo_nombre_de_servicio" value="<?= $resultado[0]['nombre'] ?>">  
              </div>  
            </div>
            
            <div class="col-md-6">
              <div class="group-control"> 
                <label>Valor 1:</label>            
                <input type="text" pattern="^[0-9]+([.][0-9]+)?$" class="form-control" name="valor1" value="<?= $resultado[0]['valor1'] ?>" >  
              </div>  
            </div>

            <div class="col-md-6">
              <div class="group-control"> 
                <label>Valor 2</label>            
                <input type="text" pattern="^[0-9]+([.][0-9]+)?$" class="form-control" name="valor2" value="<?= $resultado[0]['valor2'] ?>">  
              </div>  
            </div>

            <div class="col-md-6">
              <div class="group-control"> 
                <label>Cargo fijo:</label>            
                <input type="text" pattern="^[0-9]+([.][0-9]+)?$" class="form-control" name="cargo_fijo" value="<?= $resultado[0]['cargofijo'] ?>">  
              </div>  
            </div>

            <div class="col-md-6">
              <div class="group-control"> 
                <label>Cobros anteriores:</label>            
                <input type="text" pattern="^[0-9]+([.][0-9]+)?$" class="form-control" name="otros_cobros" value="<?= $resultado[0]['otroscobros'] ?>">  
              </div>  
            </div>

            <div class="col-md-6">
              <div class="group-control"> 
                <label>Mora:</label>            
                <input type="text" pattern="^[0-9]+([.][0-9]+)?$" class="form-control" name="mora" value="<?= $resultado[0]['mora'] ?>">  
              </div>  
            </div>

            <div class="col-md-12">
              <div class="group-control"> 
                <label>Descripción</label>            
                <textarea name="descripcion" id="" cols="30" rows="3" class="form-control"><?= $resultado[0]['descripcion'] ?></textarea>  
              </div>  
            </div>

            <br>
            <div class="col-md-12 text-center" style="margin: 20px 0px;">
              <button class="btn btn-primary" type="submit">Actualizar</button>
            </div>
                
          </div>
<?php
           ControladorServicios::ctrEditarTipoServicio();
?>
         
        </form>
        
      

      </div>

    </div>

  </section>

</div>

<!--=====================================
MODAL AGREGAR SERVICIO
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

          <h4 class="modal-title">Agregar servicio</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body" style="padding:0px">

          <div class="box-body" style="padding:0px">


                  <div class="form-row"> 

                    <div class="form-group col-md-6">
                      <label for="inputCity">Tipo de Servicio:</label>
                      <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-audio-description"></i></span>
                      <select class="form-control" id="nuevoTipoServicio" name="nuevoTipoServicio" required>
                              <option value="">Seleccione</option>                              
                              <option value="Comercio">Comercio</option>
                              <option value="Domiciliar">Domiciliar</option>                              
                                              
                            </select>  
                      </div>
                    </div>                    
                    
                    <div class="form-group col-md-6">
                      <label for="inputCity">Descripción servicio:</label>
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-american-sign-language-interpreting"></i></span>
                        
                        <input type="text" class="form-control" name="nuevoNombreServicio" placeholder="Nombre del servicio" required>
                      </div>
                    </div>
                    
                    

                  </div>

                  <!-- ENTRADA PARA EL NOMBRE -->

                  <div class="form-row">                    

                    <div class="form-group col-md-6">
                      <label for="inputCity">Cantidad de Bolsas:</label>
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-list-ol"></i></span>
                        <input type="number" min="0" class="form-control" name="nuevoCatidadBolsas" placeholder="Cantidad de Bolsas" required>
                      </div>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="inputCity">Valor del Servicio:</label>
                        <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-usd"></i></span>
                          <input type="text" class="form-control" name="nuevoValorServicio" placeholder="Valor del Servicio" required>
                        </div>
                      </div>

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

        $crearServicio = new ControladorServicios();
        $crearServicio -> ctrCrearServicio();

      ?>

    </div>

  </div>

</div>

<!--=====================================
MODAL EDITAR SERVICIO
======================================-->
<div id="modalEditarServicio" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Editar Servicio</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body" style="padding:0px">

          <div class="box-body" style="padding:0px">

                  <!-- ENTRADA PARA EL NOMBRE -->

                  <div class="form-row">

                    <div class="form-group col-md-6">
                      <label for="inputCity">Tipo de Servicio:</label>
                      <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-audio-description"></i></span>
                      <select class="form-control" name="editarTipoServicio" required>
                              <option value="" id="editarTipoServicio">Seleccione</option>
                              <option value="Comercio">Comercio</option>
                              <option value="Domiciliar">Domiciliar</option>                              
                                              
                            </select>  
                      </div>
                    </div>

                    <div class="form-group col-md-6">
                      <label for="inputCity">Descripción del servicio:</label>
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-american-sign-language-interpreting"></i></span>
                        <input type="hidden" class="form-control" id="idtipo_servicios" name="idtipo_servicios">
                        <input type="text" class="form-control" id="editarNombreServicio" name="editarNombreServicio" placeholder="Nombre del servicio" required>
                      </div>
                    </div>

                  </div>

                  <!-- ENTRADA PARA EL NOMBRE -->

                  <div class="form-row">                    

                    <div class="form-group col-md-6">
                      <label for="inputCity">Cantidad de Bolsas:</label>
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-list-ol"></i></span>
                        <input type="number" min="0" class="form-control" id="editarCatidadBolsas" name="editarCatidadBolsas" placeholder="Cantidad de Bolsas" required>
                      </div>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="inputCity">Valor del Servicio:</label>
                        <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-usd"></i></span>
                          <input type="text" class="form-control" id="editarValorServicio" name="editarValorServicio" placeholder="Valor del Servicio" required>
                        </div>
                      </div>

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

        $editarPersona = new ControladorServicios();
        $editarPersona -> ctrEditarServicio();

      ?>

 

    </div>

  </div>

</div>

<?php

  $eliminarPersona = new ControladorServicios();
  $eliminarPersona -> ctrEliminarServicio();

?>



