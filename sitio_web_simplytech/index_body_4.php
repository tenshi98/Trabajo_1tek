<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1011-004).');
}

?>

<section id="como" class=" section-bg">
	<div class="container" data-aos="fade-up">

		<div class="section-title">
			<h2>¿Cómo funciona?</h2>
        </div>

		<ul class="timeline">

			<?php
			//
			$como_ultimo = 0;

			//ubico el ultimo elemento
			foreach ($arrBody as $tipos) {
				if(isset($tipos['idTipo'])&&$tipos['idTipo']==$Funcionamiento){
					$como_ultimo = $tipos['idPosicion'];
				}
			}
			//recorro
			foreach ($arrBody as $tipos) {
				if(isset($tipos['idTipo'])&&$tipos['idTipo']==$Funcionamiento){
					//par
					if (($tipos['idPosicion'] % 2) == 0) {
						$li_style = 'timeline-inverted';
					//impar
					} else {
						$li_style = '';
					}

					echo '
					<li class="'.$li_style.'">
						<div class="timeline-image">
							<img class="img-circle img-responsive" src="upload/funcionamiento/'.$tipos['Imagen'].'" alt="">
						</div>
						<div class="timeline-panel">
							<div class="timeline-heading">';
								/*<h4>Step One</h4>
								<h4 class="subheading">Subtitle</h4>*/
							echo '
							</div>
							<div class="timeline-body">
								<p class="text-muted" style="'.$tipos['TextoStyle'].'">'.$tipos['Texto'].'</p>
							</div>
						</div>';
						if($como_ultimo!=$tipos['idPosicion']){
							echo '<div class="line"></div>';
						}

					echo '</li>';
				}
			}
			?>

        </ul>

	</div>
</section>


