<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1011-005).');
}

?>
<section id="faq" class="faq">
    <div class="container" data-aos="fade-up">

        <div class="section-title">
			<h2>Preguntas Frecuentes</h2>
        </div>

        <ul class="faq-list accordion" data-aos="fade-up">

			<?php
			foreach ($arrBody as $tipos) {
				if(isset($tipos['idTipo'])&&$tipos['idTipo']==$FAQ){
					echo '
					<li>
						<a data-bs-toggle="collapse" class="collapsed" data-bs-target="#faq'.$tipos['idPosicion'].'">
							'.$tipos['Titulo'].'
							<i class="bx bx-chevron-down icon-show"></i>
							<i class="bx bx-x icon-close"></i>
						</a>
						<div id="faq'.$tipos['idPosicion'].'" class="collapse" data-bs-parent=".faq-list">
							<p>'.$tipos['Texto'].'</p>
						</div>
					</li>';
				}
			}
			?>

        </ul>

    </div>
</section>
