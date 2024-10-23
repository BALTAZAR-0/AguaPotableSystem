<?php  //iniciamos la sesión  
session_name("usuario");  
session_start(); //antes de hacer los cálculos, compruebo que el usuario está logueado
//utilizamos el mismo script que antes  
if ($_SESSION["iniciarSesion"] != "ok") {
    //si no está logueado lo envío a la página de autentificación
    header("location: login.php");
} else {
    //sino, calculamos el tiempo transcurrido
    $fechaGuardada = $_SESSION["ultimo_login"];
    $ahora = time();
    $tiempo_transcurrido = $ahora-$fechaGuardada;

    //comparamos el tiempo transcurrido
     if($tiempo_transcurrido >= 60) {
     //si pasaron 10 minutos o más
      session_destroy(); // destruyo la sesión
      //window.location = "personas"
      header("Location: login.php"); //envío al usuario a la pag. de autenticación
      
      //sino, actualizo la fecha de la sesión
    }else {
    $_SESSION["ultimo_login"] = $ahora;
   }
}  ?>