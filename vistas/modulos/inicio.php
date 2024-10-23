<div class="row contenedor">
  <header class="col-md-12 header" style="display: flex; align-items: center; justify-content: space-between; padding: 0 0 10px 0; margin: 0"> <!-- Usamos Flexbox para centrar verticalmente -->
    <div class="logo-left col-md-3" style="padding: 0; margin: 0;">
      <div class="col-md-12 logo" style="max-width: none;"> <!-- Aseguramos que el contenedor no limite el tamaño -->
        <img src="vistas/img/logo.png" class="img-responsive" style="margin-top: -60px; width: 250px; max-width: none;"> <!-- Subimos más el logo -->
      </div>
    </div>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&display=swap" rel="stylesheet">
    
    <!-- Bloque de texto centrado verticalmente y aumentado en tamaño -->
    <div class="datos-empresa col-md-6" style="padding: 0; margin: -60px 0 0 0; text-align: center; font-size: 60px;"> <!-- Reducimos el margen superior -->
      <h2 style="font-size: 43px;"><SMALL><B>COBRO DE SERVICIOS DE AGUA POTABLE "COCODE DE VUELTAMINA"</B></SMALL></h2>
      <h2 style="font-size: 43px;"><SMALL><B>AGUA POTABLE PARA TODO EL PUEBLO</B></SMALL></h2>
    </div>

    <!-- Alinear "Iniciar Sesión" a la derecha y en el medio -->
	<div class="contactanos col-md-3" style="padding-top: 0; margin-top: -50px; text-align: right;"> <!-- Flexbox eliminado, volvemos al estilo anterior -->
  <CENTER>
    <a href="ingreso">
      <img src="vistas/img/ava.png" class="img-responsive" style="width: 80px;"> <!-- Imagen ya ajustada, no la tocamos -->
	  <SMALL><B style="font-size: 15px;">INICIAR SESION</B></SMALL> <!-- Aumentamos el tamaño del texto a 20px -->
    </a>
  </CENTER>
</div>


  </header>

  <!-- Ajuste de la línea para subirla más -->
  <div class="col-md-12 linea" style="margin-top: -65px; padding: 0;"></div> <!-- Subimos más la línea -->

  <section class="col-md-12">
    <div class="inf-pago">
      <h2 class="titulo"> CONSULTA TU RECIBOS DE AGUA POTABLE</h2>
      <img src="vistas/img/agua-mcp.png" width="130" alt="">
      <form action="" style="width: 300px; margin: 10px auto;" id="formInicioDni">
        <div class="form-group">
          <input type="text" name="dni" id="dni" placeholder="Ingrese su N° DPI Ó NIT" class="form-control inputN">
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-primary">Consultar</button>
        </div>
      </form>
      <p class="pagueS"><SMALL><B> AHORA PUEDES HACER TUS CONSULTAS DE TU RECIBO POR EL SERVICIO DE AGUA</B></SMALL></p>

      <div class="col-md-12">
        <div style="width: 500px; margin: 0 auto;">
          <img src="vistas/img/pagos.PNG" width="100%" alt="">
        </div>
      </div>

    </div>
  </section>
</div>
