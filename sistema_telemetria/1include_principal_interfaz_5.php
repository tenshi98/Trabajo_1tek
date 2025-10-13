<?php
/************************************************************************************/
//consultas anidadas, se utiliza las variables anteriores para consultar cada permiso
$SIS_query = 'idOpcionesGen_6';
$SIS_join  = '';
$SIS_where = 'idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
$n_permisos = db_select_data (false, $SIS_query, 'core_sistemas',$SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'n_permisos');

/*****************************************************************************************************************/
/*                                                Modelado                                                       */
/*****************************************************************************************************************/

?>

<style>
.nav-tabs.nav-center > li > a {color: #333 !important;}
.nav-tabs.nav-center > li > a:hover, .nav-tabs > li > a:focus {color: #fff !important;background-color: #2E2424;}
.nav-tabs.nav-center > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus {border: 1px solid #ddd;border-bottom: 1px solid #fff;}
.nav-center > li {float:none;display:inline-block;zoom:1;}
.nav-center {text-align:center;}
</style>

<!-- Nav tabs -->
<ul class="nav nav-tabs nav-center" role="tablist">
	<li role="dashboard" class="active"><a href="#resumen"   aria-controls="resumen"   role="tab" data-toggle="tab"><i class="fa fa-truck" aria-hidden="true"></i> Gestion de Flota</a></li>
	<li role="dashboard">               <a href="#online"    aria-controls="online"    role="tab" data-toggle="tab"><i class="fa fa-toggle-on" aria-hidden="true"></i> En Linea</a></li>
	<li role="dashboard">               <a href="#solicitud" aria-controls="solicitud" role="tab" data-toggle="tab"><i class="fa fa-check-square-o" aria-hidden="true"></i> Solicitud Finalizada</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">

	<?php
		//si los segundos no estan configurados
		if(isset($n_permisos['idOpcionesGen_6'])&&$n_permisos['idOpcionesGen_6']!=0){
			$x_seg = $n_permisos['idOpcionesGen_6'] * 1000;
		}else{
			$x_seg = 60000;
		}

		//contenido en tabs
		include '1include_principal_interfaz_5_tab_1.php';
		include '1include_principal_interfaz_5_tab_2.php';
		include '1include_principal_interfaz_5_tab_3.php';
	?>

</div>
