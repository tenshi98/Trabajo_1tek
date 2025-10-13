<?php
echo '
<div class="cover-info">
	<div class="avatar">';
		if ($_SESSION['usuario']['basic_data']['Direccion_img']=='') {
			echo '<img alt="Imagen Referencia" src="'.DB_SITE_REPO.'/LIB_assets/img/usr.png">';
		}else{
			echo '<img alt="Imagen Referencia" src="upload/'.$_SESSION['usuario']['basic_data']['Direccion_img'].'">';
		}
		echo '
	</div>
	<div class="name"><a href="#">'.$_SESSION['usuario']['basic_data']['Nombre'].'</a></div>

	<ul class="cover-nav nav nav-tabs">';
		echo '<li class="active"><a href="#Menu_tab_1" data-toggle="tab"><i class="fa fa-fw fa-bars" aria-hidden="true"></i> Resumen</a></li>';

		//Telemetria
		$temp = $prm_x[7] + $prm_x[8] + $prm_x[9];
		if($temp!=0){
			echo '<li><a href="#Menu_tab_2" data-toggle="tab"><i class="fa fa-fw fa-bullseye" aria-hidden="true"></i> Telemetria</a></li>';
		}

		//Bodegas
		$temp = $prm_x[1] + $prm_x[2] + $prm_x[3] + $prm_x[4] + $prm_x[5];
		if($temp!=0){
			echo '<li><a href="#Menu_tab_3" data-toggle="tab"><i class="fa fa-fw fa-cubes" aria-hidden="true"></i> Bodegas</a></li>';
		}

		//Lubricacion
		$temp = $prm_x[6] + $prm_x[10] + $prm_x[11];
		if($temp!=0) {
			echo '<li><a href="#Menu_tab_4" data-toggle="tab"><i class="fa fa-fw fa-cubes" aria-hidden="true"></i> Operaciones x Contrato</a></li>';
		}

		//Repositorio
		if($n_permisos['idOpcionesGen_9']=='1' OR $idTipoUsuario==1){
			echo '<li><a href="#Menu_tab_5" data-toggle="tab"><i class="fa fa-database" aria-hidden="true"></i> Repositorio</a></li>';
		}

		//Agro Shipping
		$temp = $prm_x[32] + $prm_x[33] + $prm_x[34] + $prm_x[35] + $prm_x[36] + $prm_x[37];
		if($temp!=0) {
			echo '<li><a href="#Menu_tab_6" data-toggle="tab"><i class="fa fa-truck" aria-hidden="true"></i> Agro Shipping</a></li>';
		}

		//Agro Checking
		$temp = $prm_x[38] + $prm_x[39] + $prm_x[40] + $prm_x[41];
		if($temp!=0) {
			echo '<li><a href="#Menu_tab_7" data-toggle="tab"><i class="fa fa-map-marker" aria-hidden="true"></i> Agro Checking</a></li>';
		}

		//Log de cambios
		if($idTipoUsuario==1 OR $idTipoUsuario==2) {
			echo '<li><a href="#Menu_tab_99" data-toggle="tab"><i class="fa fa-refresh" aria-hidden="true"></i> Actualizaciones</a></li>';
		}

echo '
	</ul>
</div>';

?>
