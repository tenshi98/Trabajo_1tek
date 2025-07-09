<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1011-003).');
}

?>

<section id="servicios" class="tabs">
	<div class="container" data-aos="fade-up">

		<div class="section-title">
			<h2>Nuestros Servicios</h2>
        </div>

		<ul class="nav nav-tabs row d-flex">
			<?php
			//conteo
			$count_tab = 0;
			//recorro
			foreach ($arrBody as $tipos) {
				if(isset($tipos['idTipo'])&&$tipos['idTipo']==$Servicios){

					//si esta activo o no
					if(isset($count_tab)&&$count_tab==0){
						$active = 'active show';$count_tab++;
					}else{
						$active = '';
					}

					echo '
					<li class="nav-item col-3">
						<a class="nav-link '.$active.'" data-bs-toggle="tab" data-bs-target="#tab-'.$tipos['idPosicion'].'">
						<i class="'.$tipos['Icono'].'"></i>
						<h4 class="d-none d-lg-block">'.$tipos['IconoStyle'].'</h4>
						</a>
					</li>
					';
				}
			}
			?>
		</ul>

		<div class="tab-content">

			<?php
			//conteo
			$count_tab = 0;
			//recorro
			foreach ($arrBody as $tipos) {
				if(isset($tipos['idTipo'])&&$tipos['idTipo']==$Servicios){

					//si esta activo o no
					if(isset($count_tab)&&$count_tab==0){
						$active = 'active show';$count_tab++;
					}else{
						$active = '';
					}

					echo '
						<div class="tab-pane '.$active.'" id="tab-'.$tipos['idPosicion'].'">
							<div class="row">
								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 order-2 order-lg-1 mt-3 mt-lg-0" data-aos="fade-up" data-aos-delay="'.$tipos['idPosicion'].'00">';
									if(isset($tipos['Titulo'])&&$tipos['Titulo']!=''){ echo '<h3 style="'.$tipos['TituloStyle'].'">'.$tipos['Titulo'].'</h3>';}
									if(isset($tipos['Texto'])&&$tipos['Texto']!=''){   echo '<div style="'.$tipos['TextoStyle'].'"><p>'.$tipos['Texto'].'</p></div>';}
									if(isset($tipos['LinkNombre'])&&$tipos['LinkNombre']!=''){
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
										echo '<br/>';
										echo '<a href="'.$tipos['LinkURL'].'" class="about-btn '.$frame.'" style="'.$tipos['LinkStyle'].'" '.$tab.'><span>'.$tipos['LinkNombre'].'</span> <i class="bx bx-chevron-right"></i></a>';
									}

									echo '
								</div>
								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 order-1 order-lg-2 text-center" data-aos="fade-up" data-aos-delay="200">
									<img src="upload/servicios/'.$tipos['Imagen'].'" alt="" class="img-fluid">
								</div>
							</div>
						</div>
					';

				}
			} ?>

		</div>
	</div>
</section>
