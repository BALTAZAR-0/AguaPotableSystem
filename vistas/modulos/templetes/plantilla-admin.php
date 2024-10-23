<?php 
require 'header-admin.php'; 
/*<body class="hold-transition skin-blue sidebar-collapse sidebar-mini login-page"> */

  
  if(isset($_SESSION["iniciarSesion"]) && $_SESSION["iniciarSesion"] == "ok" ){

   echo '<div class="wrapper">';

    /*=============================================
    CABEZOTE
    =============================================*/

    include "vistas/modulos/cabezote.php";

    /*=============================================
    MENU
    =============================================*/

    include "vistas/modulos/menu.php";

    /*=============================================
    CONTENIDO
    =============================================*/

    if(isset($_GET["ruta"])){

      if($_GET["ruta"] == "admin-inicio" ||
         $_GET["ruta"] == "usuarios" ||
         $_GET["ruta"] == "zonas" ||
         $_GET["ruta"] == "personas" ||         
         $_GET["ruta"] == "servicios" ||
         $_GET["ruta"] == "contratos" || 
         $_GET["ruta"] == "consulta-servicios" ||
         $_GET["ruta"] == "detalle-contrato" ||
         $_GET["ruta"] == "detalle-cobro" ||  
         $_GET["ruta"] == "administrar-usuarios" ||    
         $_GET["ruta"] == "crear-contratos" ||
         $_GET["ruta"] == "editar-contratos" ||

         $_GET["ruta"] == "cobros" ||
         $_GET["ruta"] == "editar-cobros" ||
          $_GET["ruta"] == "crear-cobros" ||     

         $_GET["ruta"] == "salir"){

        include "vistas/modulos/".$_GET["ruta"].".php";

      }else{

        include "vistas/modulos/404.php";

      }

    }else{
      
      include "vistas/modulos/admin-inicio.php";

    }

    /*=============================================
    FOOTER
    =============================================*/

    include "vistas/modulos/footer.php";

    echo '</div>';

  }  else{

    include "vistas/modulos/login.php";

  }

  ?>


<?php require 'footer-admin.php'; ?>