<?php
/**************************************************************************/
if($n_permisos['idOpcionesGen_9']=='1' OR $idTipoUsuario==1){ ?>

	<div class="tab-pane fade" id="Menu_tab_5">
		<div class="">
			<script type = "text/javascript">
				//se desactiva el boton f5
				window.onload = function () {
					document.onkeydown = function (e) {
						return (e.which || e.keyCode) != 116;
					};
				}
			</script>
 
	<?php
	//Se dibuja el explorador de archivos
	echo file_explorer(1, 'connector_repositorio', DB_SITE_MAIN_PATH, $_SESSION['usuario']['basic_data']['idSistema'], 1); ?>
		</div>
	</div>

<?php } ?>

