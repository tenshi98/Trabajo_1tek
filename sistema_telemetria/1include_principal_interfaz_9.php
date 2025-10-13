<?php

//listado de sitios
// Se trae un listado con todos los elementos
$SIS_query = '
sitios_listado.idSitio,
sitios_listado.Nombre,
sitios_listado.Domain, 
sitios_listado.idEstado,
sitios_listado.Config_Logo_Nombre,
sitios_listado.Config_Logo_Archivo,
sitios_listado.Config_Root_Folder,
core_estados.Nombre AS Estado';
$SIS_join  = 'LEFT JOIN `core_estados` ON core_estados.idEstado = sitios_listado.idEstado';
$SIS_where = 'sitios_listado.idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
$SIS_order = 'sitios_listado.Nombre ASC';
$arrSitio = array();
$arrSitio = db_select_array (false, $SIS_query, 'sitios_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrSitio');

//muestro los sitios
foreach ($arrSitio as $trab) { ?>
	<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
		<div class="panel panel-primary">
			<div class="panel-heading panel-altura">
				<?php if (isset($trab['Config_Logo_Archivo'])&&$trab['Config_Logo_Archivo']!='') { ?>
					<img class="img-fluid" alt="Imagen Referencia" src="<?php echo DB_SITE_REPO.'/'.$trab['Config_Root_Folder'].'/upload/'.$trab['Config_Logo_Archivo'] ?>">
				<?php } ?>
			</div>
			<div class="panel-body">
				<h4><?php echo $trab['Nombre']; ?></h4>
				<label class="label <?php if(isset($trab['idEstado'])&&$trab['idEstado']==1){echo 'label-success';}else{echo 'label-danger';} ?>"><?php echo $trab['Estado']; ?></label>
				<div class="clearfix"></div>
				<br/>
				<div class="btn-group-vertical" role="group" aria-label="..." style="width: 100%;">
					<a class="btn btn-default" href="<?php echo 'sitios_listado.php?pagina=1&id='.simpleEncode($trab['idSitio'], fecha_actual()); ?>" role="button" style="width:100%;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar</a>
					<a class="btn btn-primary" href="<?php echo $trab['Domain']; ?>" target="_blank" rel="noopener noreferrer" role="button" style="width:100%;"><i class="fa fa-link" aria-hidden="true"></i> Abrir Sitio</a>
				</div>
			</div>
		</div>
	</div>
<?php } ?>

<style>
	.panel-altura{height: 100px;}
	.panel-altura .img-fluid {max-width: 100%;height: auto;padding:10px;width: 100%;}


</style>




