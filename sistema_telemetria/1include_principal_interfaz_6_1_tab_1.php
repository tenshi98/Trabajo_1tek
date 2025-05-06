
<div role="tabpanel" class="tab-pane fade in active" id="gestion">

		<?php
			/**************************************************************************/
			$temp = 1;//siempre pasa
			if($temp!=0){
				echo '
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<span class="panel-title" style="color: #1E90FF;font-weight: 700 !important;" id="update_text_HoraRefresco">Hora Refresco: '.hora_actual().'</span>';

					echo widget_Gestion_Flota_CrossTech('Gestion de Flota',
														$_SESSION['usuario']['basic_data']['idSistema'],
														$_SESSION['usuario']['basic_data']['Config_IDGoogle'],
														$_SESSION['usuario']['basic_data']['idTipoUsuario'],
														$_SESSION['usuario']['basic_data']['idUsuario'],
														$x_seg,
														1,
														2,
														$dbConn);

				echo '</div>';
			}

		?>

</div>
