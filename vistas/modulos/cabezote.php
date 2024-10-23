 <header class="main-header">
 	
	<!--=====================================
	LOGOTIPO
	======================================-->
	<a href="admin-inicio" class="logo"><img width="190" height="50" src="vistas/img/AGUA MPC.png">
		
		<!-- logo mini -->
		

		<!-- logo normal -->

		

	</a>

	<!--=====================================
	BARRA DE NAVEGACIÓN
	======================================-->
	<nav class="navbar navbar-static-top" role="navigation">
		
		<!-- Botón de navegación -->

	 	<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        	
        	<span class="sr-only">Toggle navigation</span>
      	
      	</a>

		<!-- perfil de usuario -->

		<div class="navbar-custom-menu">
				
			<ul class="nav navbar-nav">
				
				<li class="dropdown user user-menu">
					
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">

					<?php

					if($_SESSION["foto"] != ""){

						echo '<img src="'.$_SESSION["foto"].'" class="user-image">';

					}else{


						echo '<img src="vistas/img/usuarios/default/anonymous.png" class="user-image">';

					}


					?>
						
						<span class="hidden-xs"><?php  echo $_SESSION["nombre"]; ?></span>

					</a>

					<!-- Dropdown-toggle -->

					<ul class="dropdown-menu">
	                  <!-- User image -->
	                  <li class="user-header">

	                    <?php

							if($_SESSION["foto"] != ""){

								echo '<img src="'.$_SESSION["foto"].'" class="img-circle" alt="User Image">';

							}else{


								echo '<img src="vistas/img/usuarios/default/anonymous.png" class="user-image">';

							}

						?>

	                    <p>
	                      <B><SMALL><SMALL> </SMALL></SMALL></B></p>
	             
  

	                      
	                    
	                  </li>
	                  
	                  <!-- Menu Footer-->
	                  <li class="user-footer">
	                    
	                    <div class="pull-right">	                      
	                      <a href="salir" class="btn btn-default btn-flat">Cerrar sesión</a>
	                    </div>
	                  </li>
	                </ul>


				</li>

			</ul>

		</div>

	</nav>

 </header>