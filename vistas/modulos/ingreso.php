


<div id="back"></div>

<div class="login-box">
  


  <div class="login-box-body">
  
  <div >

    <img src="vistas/img/plantilla/user.png" class="img-responsive" style="padding:3px 120px 0px 120px">

  </div>

    <!-- <p class="login-box-msg">Ingrese sus datos de Acceso</p> -->
    <p class="login-box-msg"><SMALL><B> INICIAR SESIÓN</B></SMALL> </p>

    <form method="post">

      <div class="form-group has-feedback">

        <input type="text" class="form-control" placeholder="Usuario" name="ingUsuario" required>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>

      </div>

      <div class="form-group has-feedback">

        <input type="password" class="form-control" placeholder="Contraseña" name="ingPassword" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      
      </div>

      <div >

    <img src="vistas/img/plantilla/nocaptcha.gif" class="img-responsive" style="padding:5px 55px 0px 55px">

  </div>
  <center><span class="text-f">Al Utilizar Nuestros Servicios Aceptas Nuestros <a href="register.php">Términos y Condiciones y Política de Tratamiento de Datos.</a></span></center>
  
      <div class="row">
       
        <center><div class="acede">

          <button type="submit" class="btn btn-primary btn-block btn-flat">ACCEDER </button>
        
        </div></center>

     
            <center><span class="text-ff"><a href="register.php"><br>¿Olvidaste la Contraseña?</a><br>
            <span class="text-ff"></a>¿No tienes cuenta?
                <a href="register.php">Registrate</a></center>
            </span></span><br>
            <div >

    <img src="vistas/img/plantilla/vv.png" class="img-responsive" style="padding:5px 100px 0px 100px">

  </div>
        </div>

      <?php

        $login = new ControladorUsuarios();
        $login -> ctrIngresoUsuario();
        
      ?>

    </form>

  </div>


</div>


