<?php 
require 'header-inicio.php'; 
/*<body class="hold-transition skin-blue sidebar-collapse sidebar-mini login-page"> */

     if(isset($_GET["ruta"])){

            if($_GET["ruta"] == "ingreso" ||
                $_GET["ruta"] == "inicio" ||  
                $_GET["ruta"] == "servicio" ||
                $_GET["ruta"] == "salir"){

                include "vistas/modulos/".$_GET["ruta"].".php";

            }else{

              include "vistas/modulos/inicio.php";

          }
      } else {
        include ('vistas/modulos/inicio.php');
      }

    


  ?>


<?php require 'footer-inicio.php'; ?>