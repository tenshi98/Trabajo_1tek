
<header id="header" class="fixed-top d-flex align-items-center">
	<div class="container d-flex align-items-center">
		<?php
			if (isset($rowData['Config_Logo_Archivo'])&&$rowData['Config_Logo_Archivo']!='') {
				echo '<a href="index.php" class="logo me-auto"><img src="upload/'.$rowData['Config_Logo_Archivo'].'" alt="" class="img-fluid"></a>';
			}elseif (isset($rowData['Config_Logo_Nombre'])&&$rowData['Config_Logo_Nombre']!='') {
				echo '<h1 class="logo me-auto"><a href="index.php">'.$rowData['Config_Logo_Nombre'].'</a></h1>';
			}else{
				echo '<h1 class="logo me-auto"><a href="index.php">Inicio</a></h1>';
			}
			?>
		<nav id="navbar" class="navbar order-last order-lg-0">
			<ul>
				<?php
				//conteo
				$count_menu = 0;
				//Menu normal
				foreach ($arrMenu as $menu) {

					//opción nuevo tab
					switch ($menu['idNewTab']) {
						case 1: $tab = 'target="_blank" rel="noopener noreferrer"'; break;
						case 2: $tab = '';break;
					}

					//opción popup
					switch ($menu['idPopup']) {
						case 1: $frame = 'glightbox'; break;
						case 2: $frame = '';break;
					}

					//si esta activo o no
					if(isset($count_menu)&&$count_menu==0){
						$active = 'active';$count_menu++;
					}else{
						$active = '';
					}

					//se crea el enlace
					echo '<li><a class="'.$frame.' nav-link scrollto '.$active.'" href="'.$menu['Link'].'" '.$tab.'>'.$menu['Nombre'].'</a></li>';
				}
				//Menu desplegable
				if(isset($rowData['Config_MenuOtros'])&&$rowData['Config_MenuOtros']==1){
					echo '<li class="dropdown"><a href="#"><span>Ver Mas</span> <i class="bi bi-chevron-down"></i></a>';
					echo '<ul>';
					//listo
					foreach ($arrMenuDesplegable as $menu) {

						//opción nuevo tab
						switch ($menu['idNewTab']) {
							case 1: $tab = 'target="_blank" rel="noopener noreferrer"'; break;
							case 2: $tab = '';break;
						}

						//opción popup
						switch ($menu['idPopup']) {
							case 1: $frame = 'glightbox'; break;
							case 2: $frame = '';break;
						}

						//se crea el enlace
						echo '<li><a class="'.$frame.'" href="'.$menu['Link'].'" '.$tab.'>'.$menu['Nombre'].'</a></li>';
					}
					echo '</ul>';
					echo '</li>';
				} ?>
			</ul>
			<i class="bi bi-list mobile-nav-toggle"></i>
		</nav>

		<?php
		foreach ($arrBody as $tipos) {
			if(isset($tipos['idTipo'])&&$tipos['idTipo']==$MenuExtra){

				//opción nuevo tab
				switch ($tipos['idNewTab']) {
					case 1: $tab = 'target="_blank" rel="noopener noreferrer"'; break;
					case 2: $tab = '';break;
				}

				//opción popup
				switch ($tipos['idPopup']) {
					case 1: $frame = 'glightbox'; break;
					case 2: $frame = '';break;
				}

				//se crea el enlace
				echo '<a href="'.$tipos['LinkURL'].'" class="'.$frame.' get-started-btn scrollto" style="'.$tipos['LinkStyle'].'" '.$tab.'>'.$tipos['LinkNombre'].'</a>';

			}
		}

		//se crea el enlace
		echo '<a  target="_blank" rel="noopener noreferrer" href="https://api.whatsapp.com/send?phone=+56943497697&amp;text=Necesito un poco de información" class="get-started-btn scrollto" ><i style="font-size: 20px;" class="bx bxl-whatsapp"></i></a>';

		?>

	</div>
</header>
