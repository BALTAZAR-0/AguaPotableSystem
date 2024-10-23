<?php 
session_start();

if(isset($_GET["ruta"])){

   if($_GET["ruta"] == "inicio" ||  
      $_GET["ruta"] == "servicio" ||
  	  $_GET["ruta"] == "ingreso"){

      require 'modulos/templetes/plantilla-inicio.php';

   } else {
   		if(isset($_SESSION["iniciarSesion"]) && $_SESSION["iniciarSesion"] == "ok"){
		    require 'modulos/templetes/plantilla-admin.php';
		} else {
			require 'modulos/templetes/plantilla-inicio.php';
		}
   }
} else {

    require 'modulos/templetes/plantilla-inicio.php';

}

  ?>

