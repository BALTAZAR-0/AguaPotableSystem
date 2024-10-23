<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      <small><b> ADMINISTRAR COBRANZAS REALIZADOS </b></small> 
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="admin-inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Administrar cobranzas</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">
  
        <a href="crear-cobros">

          <button class="btn btn-primary">
            
           <B> Realizar Cobro</B>

          </button>

        </a>

      </div>

      <div class="box-body">
        
       <table class="table table-bordered table-striped dt-responsive tablas">
         
        <thead>
         
         <tr>
           
           <th style="width:10px">#</th>
           <th>Código</th>
           <th>Cliente</th>      
           <th>Dirección</th>
           <th>Sub total</th> 
           <th>Valor Total</th>                      
           <th>Fecha</th>
           <th>Estado</th>            
           <th>Acciones</th>

         </tr> 

        </thead>

        <tbody>

        <?php

        $item = null;
        $valor = null;

        $cobros = ControladorCobros::ctrMostrarDetalleCobros($item, $valor);
        //Parse error: syntax error, unexpected end of file in C:\xampp\htdocs\SisRecoleccion\vistas\modulos\contratos.php on line 111
      
       foreach ($cobros as $key => $value){
         
          echo ' <tr>
                  <td>'.($key+1).'</td>
                  <td>'.$value["iddetalle"].'</td>';

  

                echo '<td>'.$value["nombres"].'</td>';

                echo '<td>'.$value["direccion"].'</td>';

                echo '<td>'.$value["subtotal"].'</td>';

                echo '<td>'.$value["igv"].'</td>';

                echo '<td>'.$value["totalpagar"].'</td>';

                echo '<td>'.$value["create_at"].'</td>';

                                


                 if($value["estado"] == 1){

                    echo '<td><span class="badge bg-red" idUsuario="'.$value["idservicios"].'" estadoCobro="1">Pendiente</span></td>';



                  }else if($value["estado"] == 2){
                    echo '<td><span class="badge bg-red" idUsuario="'.$value["idservicios"].'" estadoCobro="0">Rechazado</span></td>';
                  } else {

                    echo '<td><span class="badge bg-green" idUsuario="'.$value["idservicios"].'" estadoCobro="0">Aceptado - Pagado</span></td>';

                  }                                
                

                       echo '<td>


                      <div> 

                        <button class="btn btn-success btnImprimirComprobanteC" iddetalle="'.$value["iddetalle"].'">
                        <i class="fa fa-file"></i></button>                        
                        
                        <button class="btn btn-warning btnDetalleCobro"  iddetalle="'.$value["iddetalle"].'"><i class="fa fa-eye"></i></button>';

                      

                          if($value["estado"] != 0){

                            echo ' <button class="btn btn-info btnAceptarPago" iddetalle="'.$value["iddetalle"].'" nro_transacion="'.$value['nro_transacion'].'" data-toggle="modal" data-target="#aceptarPago"><i class="fa fa-refresh"></i></button>';

                            echo ' <button class="btn btn-danger btnEliminarCobros" iddetalle="'.$value["iddetalle"].'" estadoCobro="0"><i class="fa fa-trash"></i></button>';



                          }else{

                            if($_SESSION["perfil"] == "Administrador"){

                            echo ' <button class="btn btn-danger btnEliminarCobros" iddetalle="'.$value["iddetalle"].'" estadoCobro="0"><i class="fa fa-trash"></i></button>';
                          }
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


<!-- Modal -->
<div class="modal fade" id="aceptarPago" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><b>ACEPTAR LAS TRANSFERENCIAS INGRESADAS</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" id="formAceptarPago">
          <div class="form-group text-center">
            <input type="hidden" id="aceptarIdDetalle" name="aceptarIdDetalle" class="form-control">
            <h4>Aceptar pago N° transacción: </h4>
            <input class="form-control text-center" name="nro_transacion" id="nro_transacion" style="width: 50%; margin: 10px auto;" disabled/>
            <div class="col-md-12">
              <input type="checkbox" id="numeroIncrorrecto">
              <label for="numeroIncrorrecto"> N° transacción es incorrecto</label>
            </div>
            <button type="submit" class="btn btn-primary">Aceptar Pago</button>
            <button type="button" class="btn btn-primary btn-rechazar-pago">Rechazar Pago</button>

          </div>
        </form>
      </div>
      <div class="modal-footer">
        
      </div>
    </div>
  </div>
</div>
