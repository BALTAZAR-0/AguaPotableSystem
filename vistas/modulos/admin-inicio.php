<div class="content-wrapper">

  <section class="content-header">
    
    <h1>
      
      <SMALL><B>BIENVENIDO A SISTEMA DE COBRO DE AGUA POTABLE</B></SMALL>
      
    
    </h1>

    <ol class="breadcrumb">
      
      <li><a href="admin-inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
      
      <li class="active">Panel de Inicio</li>
    
    </ol>

  </section>

  <section class="content">

    <div class="row">

      <?php

        if($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Secretaria"){

          include "inicio/cajas-superiores.php";

        }

      ?>      
    

    </div> 

     <div class="row">
       
        <div class="col-lg-12">

          <?php

            if($_SESSION["perfil"] =="Administrador"){

              //include "reportes/grafico-acta-nacimientos.php";

            }

          ?> 

        </div>

        <div class="col-lg-6">

          

        </div>

         <div class="col-lg-6">

          

        </div>

         <div class="col-lg-12">
           
          <?php

          if($_SESSION["perfil"] =="Invitado" || $_SESSION["perfil"] =="Registrador"){

             echo '<div class="box box-success">

             <div class="box-header">

             <h1>Bienvenid@ ' .$_SESSION["nombre"].'</h1>

             </div>

             </div>';

          }

          ?>

         </div>

     </div>

  </section>
 
</div>
