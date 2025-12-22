<!-- Burbuja de ayuda -->
<script>
	<!--
	$(document).ready(function() {
		$('.tooltip').tooltipster({
			animation: 'grow',
			delay: 130,
			maxWidth: 300
		});
	});
	//-->
</script>

<?php
try {
	if (isset($_SESSION['usuario']['basic_data']['idTipoUsuario'])&&$_SESSION['usuario']['basic_data']['idTipoUsuario']==1) {
		logRemoto('https://pruebas.digitalcreations.cl/remote_logs/receiver.php');
	}
} catch (\Throwable $th) {
	//throw $th;
}


