<?php if(isset($rowData['Config_Carousel'])&&$rowData['Config_Carousel']==1){ ?>
	<style>
		@media (max-width: 2048px) {
			#hero {height: 80vh!important;}
		}
		@media (max-width: 1024px) {
			#hero {height: 60vh!important;}
		}
		@media (max-width: 768px) {
			#hero {height: 40vh!important;}
		}
		@media (max-width: 575px) {
			#hero {height: 30vh!important;}
		}
		@media (max-width: 420px) {
			#hero {height: 20vh!important;}
		}
	</style>

	<section id="hero" class="d-flex flex-column justify-content-center align-items-center">
		<div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
			<div class="carousel-indicators">
				<?php
				//Contador
				$slider_c = 0;
				//recorro el Carousel
				foreach ($arrCarousel as $menu) {
					//verifico si esta activo
					if($slider_c==0){
						$slider_active = 'class="active" aria-current="true"';
					}else{
						$slider_active = '';
					}
					//imprimo
					echo '<button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="'.$slider_c.'" '.$slider_active.' aria-label="Slide '.$slider_c.'"></button>';
					//sumo 1
					$slider_c++;
				} ?>
			</div>
			<div class="carousel-inner">
				<?php
				//Contador
				$slider_c = 0;
				//recorro el Carousel
				foreach ($arrCarousel as $menu) {
					//verifico si esta activo
					if($slider_c==0){
						$slider_active = 'active';
					}else{
						$slider_active = '';
					}
					//imprimo
					echo '<div class="carousel-item '.$slider_active.'">';
						echo '<img src="upload/slider/'.$menu['Imagen'].'" class="d-block w-100" alt="'.$menu['Titulo'].'">';
						echo '<div class="carousel-caption d-none d-md-block" style="bottom: '.$menu['PosicionBloque'].'rem;">';
							if(isset($menu['Titulo'])&&$menu['Titulo']!=''){echo '<h4 style="width: 100%;margin-bottom: 20px;'.$menu['TituloStyle'].'">'.$menu['Titulo'].'</h4>';}
							if(isset($menu['Subtitulo'])&&$menu['Subtitulo']!=''){ echo '<h2 style="width: 100%;margin-bottom: 20px;'.$menu['SubtituloStyle'].'">'.$menu['Subtitulo'].'</h2>';}
							if(isset($menu['Texto'])&&$menu['Texto']!=''){  echo '<p  style="width: 100%;margin-bottom: 20px;'.$menu['TextoStyle'].'">'.$menu['Texto'].'</p>';}
						echo '</div>';
					echo '</div>';
					//sumo 1
					$slider_c++;
				} ?>
			</div>
			<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="visually-hidden">Anterior</span>
			</button>
			<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="visually-hidden">Siguiente</span>
			</button>
		</div>
	</section>
<?php }else{ ?>
	<section id="hero" class="d-flex align-items-center">

		<div class="container" data-aos="zoom-out" data-aos-delay="100">
			<div class="row">
				<div class="col-xl-6">
					<?php
					if(isset($rowData['Header_Titulo'])&&$rowData['Header_Titulo']!=''){
						echo '<h1 style="'.$rowData['Header_TituloStyle'].'">'.$rowData['Header_Titulo'].'</h1>';
					}
					if(isset($rowData['Header_Texto'])&&$rowData['Header_Texto']!=''){
						echo '<h2 style="'.$rowData['Header_TextoStyle'].'">'.$rowData['Header_Texto'].'</h2>';
					}
					if(isset($rowData['Header_LinkURL'])&&$rowData['Header_LinkURL']!=''){

						//opción nuevo tab
						switch ($rowData['Header_idNewTab']) {
							case 1: $tab = 'target="_blank" rel="noopener noreferrer"'; break;
							case 2: $tab = '';break;
						}

						//opción popup
						switch ($rowData['Header_idPopup']) {
							case 1: $frame = 'glightbox'; break;
							case 2: $frame = '';break;
						}

						//se crea el enlace
						echo '<a href="'.$rowData['Header_LinkURL'].'" style="'.$rowData['Header_LinkStyle'].'" class="'.$frame.' play-btn mb-4" '.$tab.'>'.$rowData['Header_LinkNombre'].'</a>';
					}
					?>
				</div>
			</div>
		</div>

	</section>

<?php } ?>
