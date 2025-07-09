<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1011-002).');
}

?>

<section id="nosotros" class="about section-bg">
	<div class="container" data-aos="fade-up">

		<div class="section-title">
			<h2>Nosotros</h2>
        </div>

		<div class="row no-gutters">
			<div class="content col-xl-5 d-flex align-items-stretch">
				<div class="content">
					<?php
					if(isset($rowData['Nosotros_Titulo'])&&$rowData['Nosotros_Titulo']!=''){       echo '<h4 data-aos="fade-up">'.$rowData['Nosotros_Titulo'].'</h4>';}
					if(isset($rowData['Nosotros_Subtitulo'])&&$rowData['Nosotros_Subtitulo']!=''){ echo '<h3 data-aos="fade-up">'.$rowData['Nosotros_Subtitulo'].'</h3>';}
					if(isset($rowData['Nosotros_Texto'])&&$rowData['Nosotros_Texto']!=''){         echo '<p data-aos="fade-up">'.$rowData['Nosotros_Texto'].'</p>';}
					?>

					<a href="#contacto" class="about-btn"><span>Contacto</span> <i class="bx bx-chevron-right"></i></a>
				</div>
			</div>
			<div class="col-xl-7 d-flex align-items-stretch">
				<div class="icon-boxes d-flex flex-column justify-content-center">
					<div class="row">
						<?php
						foreach ($arrBody as $tipos) {
							if(isset($tipos['idTipo'])&&$tipos['idTipo']==$Nosotros){
								echo '
								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 icon-box" data-aos="fade-up" data-aos-delay="'.$tipos['idPosicion'].'00">
									<i style="'.$tipos['IconoStyle'].'" class="'.$tipos['Icono'].'"></i>
									<h4 style="'.$tipos['TituloStyle'].'">'.$tipos['Titulo'].'</h4>
									<p style="'.$tipos['TextoStyle'].'">'.$tipos['Texto'].'</p>
								</div>';
							}
						}
						?>
					</div>
				</div>
			</div>
		</div>

	</div>
</section>
