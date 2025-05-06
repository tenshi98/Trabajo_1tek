<?php
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Se inicializa el paginador de resultados
//tomo el numero de la pagina si es que este existe
if(isset($_GET['pagina'])){$num_pag = $_GET['pagina'];} else {$num_pag = 1;}
//Defino la cantidad total de elementos por pagina
$cant_reg = 30;
//resto de variables
if (!$num_pag){$comienzo = 0;$num_pag = 1;} else {$comienzo = ( $num_pag - 1 ) * $cant_reg ;}
//Variable con la ubicacion
$SIS_where  = "principal_notificaciones_ver.idNoti>=0";
$SIS_where2 = "principal_notificaciones_ver.idNoti>=0";
if (isset($_GET['filtersender'])){
	if($_GET['filtersender']=='admin'){
		$SIS_where.=" AND principal_notificaciones_ver.idNotificaciones = 0";
	}else{
		$SIS_where.=" AND principal_notificaciones_listado.idUsuario = ".$_GET['filtersender'];
	}		
}
//Filtro
$SIS_where .=" AND principal_notificaciones_ver.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
$SIS_where2.=" AND principal_notificaciones_ver.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];

//Verifico el tipo de usuario que esta ingresando
if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
	$SIS_where .=" AND principal_notificaciones_ver.idUsuario=".$_SESSION['usuario']['basic_data']['idUsuario'];
	$SIS_where2.=" AND principal_notificaciones_ver.idUsuario=".$_SESSION['usuario']['basic_data']['idUsuario'];
}
$SIS_where2.=" GROUP BY usuarios_listado.Nombre";

/**********************************************************/
//Realizo una consulta para saber el total de elementos existentes
$cuenta_registros = db_select_nrows (false, 'principal_notificaciones_ver.idNoti', 'principal_notificaciones_ver', 'LEFT JOIN `principal_notificaciones_listado`  ON principal_notificaciones_listado.idNotificaciones   = principal_notificaciones_ver.idNotificaciones', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
//Realizo la operacion para saber la cantidad de paginas que hay
$total_paginas = ceil($cuenta_registros / $cant_reg);
// Se trae un listado con todos los elementos
$SIS_query = '
principal_notificaciones_ver.idNoti,
principal_notificaciones_ver.Fecha,
principal_notificaciones_ver.Hora,
principal_notificaciones_ver.Notificacion,
principal_notificaciones_ver.idEstado,
core_estado_notificaciones.Nombre AS Estado,
principal_notificaciones_listado.NoMolestar';
$SIS_join  = '
LEFT JOIN `core_estado_notificaciones`        ON core_estado_notificaciones.idEstado                 = principal_notificaciones_ver.idEstado
LEFT JOIN `principal_notificaciones_listado`  ON principal_notificaciones_listado.idNotificaciones   = principal_notificaciones_ver.idNotificaciones';
$SIS_order = 'principal_notificaciones_ver.idEstado ASC, principal_notificaciones_ver.Fecha DESC, principal_notificaciones_ver.Hora DESC, principal_notificaciones_ver.idNoti ASC LIMIT '.$comienzo.', '.$cant_reg;
$arrNotificaciones = array();
$arrNotificaciones = db_select_array (false, $SIS_query, 'principal_notificaciones_ver', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrNotificaciones');

// Se trae un listado con todos los elementos
$SIS_query = '
principal_notificaciones_listado.idUsuario AS idusuario,
usuarios_listado.Nombre AS usuario,
count(principal_notificaciones_ver.idNotificaciones)AS cuenta';
$SIS_join  = '
LEFT JOIN `principal_notificaciones_listado`  ON principal_notificaciones_listado.idNotificaciones   = principal_notificaciones_ver.idNotificaciones
LEFT JOIN `usuarios_listado`                  ON usuarios_listado.idUsuario                          = principal_notificaciones_listado.idUsuario';
$SIS_order = '';
$arrCategorias = array();
$arrCategorias = db_select_array (false, $SIS_query, 'principal_notificaciones_ver', $SIS_join, $SIS_where2, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrCategorias');

//Variable de busqueda
$search = "";

//verifico si tene la opción de no molestar
$NoMolestar = 0;
foreach ($arrNotificaciones as $tipo) {
	if(isset($tipo['NoMolestar'])&&$tipo['NoMolestar']==1){$NoMolestar++;}
}

//si hay un no meloestar
if($NoMolestar!=0){
echo '
	<table id="items" style="margin-bottom: 20px;margin-top: 20px;">
		<tbody>
			<tr class="item-row">
				<td>No Molestar</td>
				<td width="10">
					<div class="btn-group" style="width: 110px;">
						<a href="'.$location.'&noMolestar=1&idUsuario='.$_SESSION['usuario']['basic_data']['idUsuario'].'&idSistema='.$_SESSION['usuario']['basic_data']['idSistema'].'" title="Desactivar Email por 1 Hora"    class="btn btn-primary btn-sm tooltip"><i class="fa fa-envelope-o" aria-hidden="true"></i></a>
						<a href="'.$location.'&noMolestar=3&idUsuario='.$_SESSION['usuario']['basic_data']['idUsuario'].'&idSistema='.$_SESSION['usuario']['basic_data']['idSistema'].'" title="Desactivar Email por 3 Horas"   class="btn btn-primary btn-sm tooltip"><i class="fa fa-envelope-o" aria-hidden="true"></i></a>
						<a href="'.$location.'&noMolestar=12&idUsuario='.$_SESSION['usuario']['basic_data']['idUsuario'].'&idSistema='.$_SESSION['usuario']['basic_data']['idSistema'].'" title="Desactivar Email por 12 Horas"  class="btn btn-primary btn-sm tooltip"><i class="fa fa-envelope-o" aria-hidden="true"></i></a>
					</div>
				</td>
			</tr>
		</tbody>
	</table>';

}

?>


<div class="row inbox">
	<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Notificaciones</h5>
				<div class="toolbar">
					<a href="<?php echo $location.'&all='.$_SESSION['usuario']['basic_data']['idUsuario']; ?>" class="btn btn-xs btn-primary"><i class="fa fa-check" aria-hidden="true"></i> Marcar Todos Leidos</a>
					<?php
					//Paginador
					echo paginador_2('pagsup',$total_paginas, $original, $search, $num_pag ) ?>
				</div>
			</header>
			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
							<th>Fecha</th>
							<th>Notificación</th>
							<th>Estado</th>
							<th width="10">Acciones</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrNotificaciones as $tipo) { ?>
						<tr class="odd">
							<td><?php echo $tipo['Fecha'].'<br/>'.$tipo['Hora']; ?></td>
							<td class="tdpaddinright"><?php echo $tipo['Notificacion']; ?></td>
							<td><?php echo $tipo['Estado']; ?></td>
							<td>
								<div class="btn-group" style="width: 35px;" >
									<?php if ($tipo['idEstado']==1){ ?><a href="<?php echo $location.'&id='.$tipo['idNoti']; ?>" title="Marcar como leido" class="btn btn-primary btn-sm tooltip"><i class="fa fa-check-square-o" aria-hidden="true"></i></a><?php } ?>
								</div>
							</td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
			</div>

			<div class="pagrow">
				<?php
				//Paginador
				echo paginador_2('paginf',$total_paginas, $original, $search, $num_pag ) ?>
			</div>

		</div>
	</div>

	<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 mail-left-box">
  		<div class="list-group inbox-options">
				<?php
				$todos = 0;
				foreach ($arrCategorias as $cat) {
					$todos = $todos + $cat['cuenta'];
				} ?>

				<div class="list-group-item">Filtro</div>
				<a href="<?php echo $original.'?pagina=1'; ?>" class="list-group-item">
					<i class="fa fa-inbox" aria-hidden="true"></i>
					Mostrar Todos
					<span class="badge  bg-primary"><?php echo $todos; ?></span>
				</a>

			<?php foreach ($arrCategorias as $cat) { ?>
				<?php if($cat['usuario']!=''){ ?>
					<a href="<?php echo $original.'?pagina=1&filtersender='.$cat['idusuario']; ?>" class="list-group-item">
						<i class="fa fa-inbox" aria-hidden="true"></i>
						<?php echo $cat['usuario']; ?>
						<span class="badge bg-primary"><?php echo $cat['cuenta']; ?></span>
					</a>
				<?php }else{ ?>
					<a href="<?php echo $original.'?pagina=1&filtersender=admin'; ?>" class="list-group-item">
						<i class="fa fa-inbox" aria-hidden="true"></i>
						Administrador
						<span class="badge bg-primary"><?php echo $cat['cuenta']; ?></span>
					</a>
				<?php } ?>
			<?php } ?>

  		</div>
	</div>

</div>
