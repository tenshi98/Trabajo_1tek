<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1011-001).');
}

?>

<section id="clientes" class="clients">
	<div class="container" data-aos="zoom-in">

		<div class="clients-slider swiper">
			<div class="swiper-wrapper align-items-center">
				<?php
				/****************************************************/
				//listo los archivos
				//variables
				$Car_items       = '';

				//funcion
				$thefolder = 'upload/clientes/';
				if ($handler = opendir($thefolder)){
					while (false !== ($file = readdir($handler))){
						if ($file != '.' && $file != '..'){
							$Car_items  .= '<div class="swiper-slide"><img src="'.$thefolder.$file.'" class="img-fluid" alt=""></div>';
						}
					}
					closedir($handler);
				}
				//imprimo
				echo $Car_items;

				?>

			</div>
			<div class="swiper-pagination"></div>
		</div>

	</div>
</section>
