<?php

if($_SESSION["perfil"] == "Invitado" || $_SESSION["perfil"] == "Vendedor"){

  echo '<script>

    window.location = "admin-inicio";

  </script>';

  return;

}

?>

<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      <small><b>ADMINISTRAR ZONAS  </b></small>
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="admin-inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar zonas</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">
  
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarZona">
          
          <b>Agregar zona</b>

        </button>

      </div>

      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive tablas" width="auto">
         
        <thead>
         
         <tr>
           
           <th style="width:10px">#</th>
           <th>Nombre</th>
           <th>Acciones</th>

         </tr> 

        </thead>

        <tbody>

        <?php

        $item = null;
        $valor = null;

        $usuarios = ControladorZona::ctrConsultarZona($item, $valor);

       foreach ($usuarios as $key => $value){
         
          echo ' <tr>
                  <td>'.($key+1).'</td>
                  <td>'.$value["nombrezona"];

                          

                  echo '
                  <td>

                    <div>
                        
                      <button class="btn btn-warning btnEditarZona" idZona="'.$value["idzona"].'" nombreZona="'.$value["nombrezona"].'" data-toggle="modal" data-target="#modalEditarZona"><i class="fa fa-pencil"></i></button>

                      <button class="btn btn-danger btnEliminarZona" idZona="'.$value["idzona"].'" fotoUsuario="'.$value["idzona"].'" usuario="'.$value["idzona"].'"><i class="fa fa-trash"></i></button>

                    </div>  

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
MODAL AGREGAR USUARIO
======================================-->

<div id="modalAgregarZona" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Agregar zona</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

            <!-- ENTRADA PARA EL NOMBRE -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-user"></i></span> 

                <input type="text" class="form-control input-lg" name="nuevoNombre" placeholder="Ingresar nombre zona" required>

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

        <?php

          $crearzona = new ControladorZona();
          $crearzona -> ctrCrearZona();

        ?>

      </form>

    </div>

  </div>

</div>

<!--=====================================
MODAL EDITAR USUARIO
======================================-->

<div id="modalEditarZona" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal">&times;</button>

          <h4 class="modal-title">Editar usuario</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

            <!-- ENTRADA PARA EL NOMBRE -->
            
            <div class="form-group">
              
              <div class="input-group">
              
                <span class="input-group-addon"><i class="fa fa-user"></i></span> 

                <input type="text" class="form-control input-lg" id="editarNombre" name="editarNombre" value="" required>

                <input type="hidden" class="form-control input-lg" id="editarIdZona" name="editarIdZona" value="" required>

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

     <?php

          $editarUsuario = new ControladorZona();
          $editarUsuario -> ctrEditarZona();

        ?> 

      </form>

    </div>

  </div>

</div>

<?php

  $eliminarZona = new ControladorZona();
  $eliminarZona -> ctrEliminar();

?>


