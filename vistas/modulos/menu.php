<aside class="main-sidebar">

	 <section class="sidebar">

		 <div class="user-panel">
	        <div class="pull-left image">
	          <?php

							if($_SESSION["foto"] != ""){

								echo '<img src="'.$_SESSION["foto"].'" class="img-circle" alt="User Image">';

							}else{


								echo '<img src="vistas/img/usuarios/default/anonymous.png" class="user-image">';

							}

						?>
	        </div>
	        <div class="pull-left info">
	          <p><?php  echo $_SESSION["nombre"]; ?></p>
	          <a><i class="fa fa-circle text-success"></i> <?php  echo $_SESSION["perfil"]; ?></a>
	        </div>
	     </div>

		<ul class="sidebar-menu">



		<?php

		if($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Lecturador"){
		  //echo '<li class="active">
			echo '<li>

				<a href="admin-inicio">
		            <i class="fa fa-home"></i> <span>Inicio</span>
		            <span class="pull-right-container">              
		            </span>
		         </a>

			</li>';

		}

		if($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Lecturador"){

			echo '<li class="treeview">

				<a href="#">

					<i class="fa fa-book"></i>
					
					<span>Lecturas</span>
					
					<span class="pull-right-container">
					
						<i class="fa fa-angle-left pull-right"></i>

					</span>

				</a>

				<ul class="treeview-menu">
					
					<li>

						<a href="contratos">
							
							<i class="fa fa-circle-o"></i>
							<span>Administrar Lecturas</span>

						</a>

					</li>

					<li>

						<a href="crear-contratos">
							
							<i class="fa fa-circle-o"></i>
							<span>Nuevo Cliente</span>

						</a>

					</li>';

			

				echo '</ul>

			</li>';

		}

		if($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Registrador"){

			echo '<li class="treeview">

				<a href="#">

					<i class="fa fa-audio-description"></i>
					
					<span>Consulta de Cobros</span>
					
					<span class="pull-right-container">
					
						<i class="fa fa-angle-left pull-right"></i>

					</span>

				</a>

				<ul class="treeview-menu">
					
					<li>

						<a href="consulta-servicios">
							
							<i class="fa fa-circle-o"></i>
							<span>Consultar</span>

						</a>

					</li>';					

				

				echo '</ul>

			</li>';

		}

		if($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Lecturador" || $_SESSION["perfil"] == "Cobrador"){

			echo '<li class="treeview">

				<a href="#">

					<i class="ion ion-social-usd"></i>
					
					<span>Realizar Cobros</span>
					
					<span class="pull-right-container">
					
						<i class="fa fa-angle-left pull-right"></i>

					</span>

				</a>

				<ul class="treeview-menu">
					
					<li>

						<a href="cobros">
							
							<i class="fa fa-circle-o"></i>
							<span>Cobros Realizados</span>

						</a>

					</li>

					<li>

						<a href="crear-cobros">
							
							<i class="fa fa-circle-o"></i>
							<span>Realizar Cobro</span>

						</a>

					</li>';					

				

				echo '</ul>

			</li>';

		}



			if($_SESSION["perfil"] == "Administrador"){

			echo '<li>

				<a href="usuarios">

					<i class="fa fa-user"></i>
					<span>Usuarios</span>

				</a>

			</li>';
			}

			if($_SESSION["perfil"] == "Administrador"){

			echo '<li>

				<a href="zonas">

					<i class="fa fa-user"></i>
					<span>zonas</span>

				</a>

			</li>';
			}

			if($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Lecturador" || $_SESSION["perfil"] == "Cobrador"){

			echo '<li>

				<a href="personas">

					<i class="fa fa-user"></i>
					<span>Clientes</span>

				</a>

			</li>

			<li>';
		}

		if($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == ""){

			echo '<a href="servicios">

					<i class="fa fa-audio-description"></i>
					<span>Configuración de servicio</span>

				</a>

			</li>';

		}

			if($_SESSION["perfil"] == "Administrador" || $_SESSION["perfil"] == "Lecturador" || $_SESSION["perfil"] == "Cobrador"){

			echo '<li>

			

			</li>';

		}


		?>

		</ul>

	 </section>

</aside>