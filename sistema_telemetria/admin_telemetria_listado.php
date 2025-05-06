<?php
/**********************************************************************************************************************************/
/*                                                   Se define la Sesion                                                          */
/**********************************************************************************************************************************/
$timeout = 604800;                               //Se setea la expiracion a una semana
ini_set( "session.gc_maxlifetime", $timeout );   //Establecer la vida útil máxima de la sesión
ini_set( "session.cookie_lifetime", $timeout );  //Establecer la duración de las cookies de la sesión
session_start();                                 //Iniciar una nueva sesión
/**********************************************************************************************************************************/
/*                                           Se define la variable de seguridad                                                   */
/**********************************************************************************************************************************/
define('XMBCXRXSKGC', 1);
/**********************************************************************************************************************************/
/*                                          Se llaman a los archivos necesarios                                                   */
/**********************************************************************************************************************************/
require_once 'core/Load.Utils.Web.php';
/**********************************************************************************************************************************/
/*                                          Modulo de identificacion del documento                                                */
/**********************************************************************************************************************************/
//Cargamos la ubicacion original
$original = "admin_telemetria_listado.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['Identificador']) && $_GET['Identificador']!=''){   $location .= "&Identificador=".$_GET['Identificador'];   $search .= "&Identificador=".$_GET['Identificador'];}
if(isset($_GET['Nombre']) && $_GET['Nombre']!=''){                 $location .= "&Nombre=".$_GET['Nombre'];                 $search .= "&Nombre=".$_GET['Nombre'];}
if(isset($_GET['idEstado']) && $_GET['idEstado']!=''){             $location .= "&idEstado=".$_GET['idEstado'];             $search .= "&idEstado=".$_GET['idEstado'];}
if(isset($_GET['id_Geo']) && $_GET['id_Geo']!=''){                 $location .= "&id_Geo=".$_GET['id_Geo'];                 $search .= "&id_Geo=".$_GET['id_Geo'];}
/********************************************************************/
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Equipo Creado correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Equipo Modificado correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Equipo Borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['id'])){
	//valido los permisos
	validaPermisoUser($rowlevel['level'], 2, $dbConn);
	// consulto los datos
	$SIS_query = '
	telemetria_listado.Nombre,
	telemetria_listado.IdentificadorEmpresa,
	telemetria_listado.TiempoFueraLinea,
	telemetria_listado.TiempoDetencion,
	opc2.Nombre AS Geo,
	opc3.Nombre AS Sensores,
	telemetria_listado.cantSensores,
	telemetria_listado.Direccion_img,
	core_sistemas.Nombre AS sistema,
	telemetria_listado.id_Geo,
	telemetria_listado.id_Sensores,
	core_estados.Nombre AS Estado,
	telemetria_listado.LimiteVelocidad,
	core_ubicacion_ciudad.Nombre AS Ciudad,
	core_ubicacion_comunas.Nombre AS Comuna,
	telemetria_listado.Direccion,
	telemetria_zonas.Nombre AS Zona,

	telemetria_listado.Jornada_inicio,
	telemetria_listado.Jornada_termino,
	telemetria_listado.Colacion_inicio,
	telemetria_listado.Colacion_termino,
	telemetria_listado.Microparada';
	$SIS_join  = '
	LEFT JOIN `core_sistemas`                    ON core_sistemas.idSistema          = telemetria_listado.idSistema
	LEFT JOIN `core_sistemas_opciones`    opc2   ON opc2.idOpciones                  = telemetria_listado.id_Geo
	LEFT JOIN `core_sistemas_opciones`    opc3   ON opc3.idOpciones                  = telemetria_listado.id_Sensores
	LEFT JOIN `core_estados`                     ON core_estados.idEstado            = telemetria_listado.idEstado
	LEFT JOIN `core_ubicacion_ciudad`            ON core_ubicacion_ciudad.idCiudad   = telemetria_listado.idCiudad
	LEFT JOIN `core_ubicacion_comunas`           ON core_ubicacion_comunas.idComuna  = telemetria_listado.idComuna
	LEFT JOIN `telemetria_zonas`                 ON telemetria_zonas.idZona          = telemetria_listado.idZona';
	$SIS_where = 'telemetria_listado.idTelemetria ='.$_GET['id'];
	$rowData = db_select_data (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	//Se consulta
	$arrOpciones = array();
	$arrOpciones = db_select_array (false, 'idOpciones,Nombre', 'core_sistemas_opciones', '', '', 'idOpciones ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrOpciones');

	/********************************************/
	//recorro
	$arrFinalOpciones = array();

	foreach ($arrOpciones as $sen) { $arrFinalOpciones[$sen['idOpciones']] = $sen['Nombre'];}
	$arrFinalOpciones[0]  = 'No Asignado';

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Equipo', $rowData['Nombre'], 'Resumen'); ?>
	</div>
	<div class="clearfix"></div>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<ul class="nav nav-tabs pull-right">
					<li class="active"><a href="<?php echo 'admin_telemetria_listado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
					<li class=""><a href="<?php echo 'admin_telemetria_listado_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
					<li class=""><a href="<?php echo 'admin_telemetria_listado_configuracion.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-wrench" aria-hidden="true"></i> Configuracion</a></li>
					<li class="dropdown">
						<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
						<ul class="dropdown-menu" role="menu">
							<li class=""><a href="<?php echo 'admin_telemetria_listado_estado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-power-off" aria-hidden="true"></i> Estado</a></li>
							<?php if($rowData['id_Sensores']==1){ ?>
								<li class=""><a href="<?php echo 'admin_telemetria_listado_alarmas_perso.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bullhorn" aria-hidden="true"></i> Alarmas Personalizadas</a></li>
							<?php } ?>
							<?php if($rowData['id_Geo']==2){ ?>
							<li class=""><a href="<?php echo 'admin_telemetria_listado_direccion.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-map-signs" aria-hidden="true"></i> Dirección</a></li>
							<?php } ?>
							<li class=""><a href="<?php echo 'admin_telemetria_listado_imagen.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-file-image-o" aria-hidden="true"></i> Imagen</a></li>
							<li class=""><a href="<?php echo 'admin_telemetria_listado_trabajo.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-clock-o" aria-hidden="true"></i> Jornada Trabajo</a></li>
							<li class=""><a href="<?php echo 'admin_telemetria_listado_otros_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-archive" aria-hidden="true"></i> Otros Datos</a></li>

						</ul>
					</li>
				</ul>
			</header>
			<div class="tab-content">

				<div class="tab-pane fade active in" id="basicos">
					<div class="wmd-panel">

						<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
							<?php if ($rowData['Direccion_img']=='') { ?>
								<img style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="Imagen Referencia" src="<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/img/maquina.jpg">
							<?php }else{  ?>
								<img style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="Imagen Referencia" src="upload/<?php echo $rowData['Direccion_img']; ?>">
							<?php } ?>
						</div>
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
							<h2 class="text-primary">Datos del Equipo</h2>
							<p class="text-muted">
								<strong>Nombre : </strong><?php echo $rowData['Nombre']; ?><br/>
								<strong>Identificador Empresa : </strong><?php echo $rowData['IdentificadorEmpresa']; ?><br/>
							</p>

							<h2 class="text-primary">Datos de Configuracion</h2>
							<p class="text-muted">
								<strong>Estado : </strong><?php echo $rowData['Estado']; ?><br/>

								<strong>Geolocalizacion : </strong><?php echo $rowData['Geo']; ?><br/>
								<?php if($rowData['id_Geo']==1){ ?>
									<strong>Limite Velocidad : </strong><?php echo Cantidades_decimales_justos($rowData['LimiteVelocidad']).' KM/h'; ?><br/>
								<?php }
								if($rowData['id_Geo']==2){ ?>
									<strong>Zona : </strong><?php echo $rowData['Zona']; ?><br/>
									<strong>Dirección : </strong><?php echo $rowData['Direccion'].', '.$rowData['Comuna'].', '.$rowData['Ciudad']; ?><br/>
								<?php } ?>

								<strong>Sensores : </strong><?php echo $rowData['Sensores'].' ';if($rowData['id_Sensores']==1){echo '('.$rowData['cantSensores'].' Sensores)';} ?><br/>

								<strong>Tiempo Fuera Linea Maximo : </strong><?php echo $rowData['TiempoFueraLinea']; ?> Horas<br/>

								<?php if($rowData['id_Geo']==1){ ?>
									<strong>Tiempo Maximo Detencion : </strong><?php echo $rowData['TiempoDetencion']; ?> Horas<br/>
								<?php } ?>

							</p>

							<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Jornada Laboral</h2>
							<p class="text-muted">
								<strong>Hora Inicio Jornada : </strong><?php echo $rowData['Jornada_inicio'].' hrs'; ?><br/>
								<strong>Hora Termino Jornada : </strong><?php echo $rowData['Jornada_termino'].' hrs'; ?><br/>
								<strong>Hora Inicio Colacion : </strong><?php echo $rowData['Colacion_inicio'].' hrs'; ?><br/>
								<strong>Hora Termino Colacion : </strong><?php echo $rowData['Colacion_termino'].' hrs'; ?><br/>
								<strong>Tiempo Microparadas : </strong><?php echo $rowData['Microparada'].' hrs'; ?><br/>
							</p>

						</div>
						<div class="clearfix"></div>

					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="clearfix"></div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
		<a href="<?php echo $location ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
		<div class="clearfix"></div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
	/**********************************************************/
	//paginador de resultados
	if(isset($_GET['pagina'])){$num_pag = $_GET['pagina'];} else {$num_pag = 1;}
	//Defino la cantidad total de elementos por pagina
	$cant_reg = 30;
	//resto de variables
	if (!$num_pag){$comienzo = 0;$num_pag = 1;} else {$comienzo = ( $num_pag - 1 ) * $cant_reg ;}
	/**********************************************************/
	//ordenamiento
	if(isset($_GET['order_by'])&&$_GET['order_by']!=''){
		switch ($_GET['order_by']) {
			case 'nombre_asc':         $order_by = 'telemetria_listado.Nombre ASC ';         $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente'; break;
			case 'nombre_desc':        $order_by = 'telemetria_listado.Nombre DESC ';        $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Nombre Descendente';break;
			case 'identificador_asc':  $order_by = 'telemetria_listado.Identificador ASC ';  $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Identificador Ascendente';break;
			case 'identificador_desc': $order_by = 'telemetria_listado.Identificador DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Identificador Descendente';break;

			default: $order_by = 'telemetria_listado.idEstado ASC, telemetria_listado.Identificador ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Identificador Ascendente';
		}
	}else{
		$order_by = 'telemetria_listado.idEstado ASC, telemetria_listado.Identificador ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Identificador Ascendente';
	}
	/**********************************************************/
	//Variable de busqueda
	$SIS_where = "telemetria_listado.idTelemetria>=0";
	$SIS_where.= " AND telemetria_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
	$SIS_join  = "";
	//Verifico el tipo de usuario que esta ingresando
	if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
		$SIS_where.= " AND usuarios_equipos_telemetria.idUsuario = ".$_SESSION['usuario']['basic_data']['idUsuario'];
		$SIS_join .= "INNER JOIN `usuarios_equipos_telemetria` ON usuarios_equipos_telemetria.idTelemetria = telemetria_listado.idTelemetria";
	}
	/**********************************************************/
	//Se aplican los filtros
	if(isset($_GET['Identificador']) && $_GET['Identificador']!=''){  $SIS_where .= " AND telemetria_listado.Identificador LIKE '%".EstandarizarInput($_GET['Identificador'])."%'";}
	if(isset($_GET['Nombre']) && $_GET['Nombre']!=''){                $SIS_where .= " AND telemetria_listado.Nombre LIKE '%".EstandarizarInput($_GET['Nombre'])."%'";}
	if(isset($_GET['idEstado']) && $_GET['idEstado']!=''){            $SIS_where .= " AND telemetria_listado.idEstado=".$_GET['idEstado'];}
	if(isset($_GET['id_Geo']) && $_GET['id_Geo']!=''){                $SIS_where .= " AND telemetria_listado.id_Geo=".$_GET['id_Geo'];}
	$SIS_where.= " GROUP BY telemetria_listado.idTelemetria";

	/**********************************************************/
	//Realizo una consulta para saber el total de elementos existentes
	$cuenta_registros = db_select_nrows (false, 'telemetria_listado.idTelemetria', 'telemetria_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
	//Realizo la operacion para saber la cantidad de paginas que hay
	$total_paginas = ceil($cuenta_registros / $cant_reg);
	// Se trae un listado con todos los elementos
	$SIS_query = '
	telemetria_listado.idTelemetria,
	telemetria_listado.Identificador,
	telemetria_listado.Nombre,
	core_sistemas.Nombre AS sistema,
	core_estados.Nombre AS Estado,
	telemetria_listado.idEstado';
	$SIS_join .= '
	LEFT JOIN `core_sistemas`   ON core_sistemas.idSistema    = telemetria_listado.idSistema
	LEFT JOIN `core_estados`    ON core_estados.idEstado      = telemetria_listado.idEstado';
	$SIS_order = $order_by.' LIMIT '.$comienzo.', '.$cant_reg;
	$arrUsers = array();
	$arrUsers = db_select_array (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrUsers');

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar">

		<ul class="btn-group btn-breadcrumb pull-left">
			<li class="btn btn-default tooltip" role="button" data-toggle="collapse" href="#collapseForm" aria-expanded="false" aria-controls="collapseForm" title="Presionar para desplegar Formulario de Búsqueda" style="font-size: 14px;"><i class="fa fa-search faa-vertical animated" aria-hidden="true"></i></li>
			<li class="btn btn-default"><?php echo $bread_order; ?></li>
			<?php if(isset($_GET['filtro_form'])&&$_GET['filtro_form']!=''){ ?>
				<li class="btn btn-danger"><a href="<?php echo $original.'?pagina=1'; ?>" style="color:#fff;"><i class="fa fa-trash-o" aria-hidden="true"></i> Limpiar</a></li>
			<?php } ?>
		</ul>

	</div>
	<div class="clearfix"></div>
	<div class="collapse col-xs-12 col-sm-12 col-md-12 col-lg-12" id="collapseForm">
		<div class="well">
			<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
				<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" autocomplete="off" novalidate>
					<?php
					//Se verifican si existen los datos
					if(isset($Identificador)){   $x1  = $Identificador;    }else{$x1  = '';}
					if(isset($Nombre)){          $x2  = $Nombre;           }else{$x2  = '';}
					if(isset($idEstado)){        $x3  = $idEstado;         }else{$x3  = '';}
					if(isset($id_Geo)){          $x4  = $id_Geo;           }else{$x4  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_input_icon('Identificador', 'Identificador', $x1, 1,'fa fa-flag');
					$Form_Inputs->form_input_text('Nombre del Equipo', 'Nombre', $x2, 1);
					$Form_Inputs->form_select('Estado','idEstado', $x3, 1, 'idEstado', 'Nombre', 'core_estados', 0, '', $dbConn);
					$Form_Inputs->form_select('Geolocalizacion','id_Geo', $x4, 1, 'idOpciones', 'Nombre', 'core_sistemas_opciones', 0, '', $dbConn);

					$Form_Inputs->form_input_hidden('pagina', 1, 1);
					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf002; Filtrar" name="filtro_form">
						<a href="<?php echo $original.'?pagina=1'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-trash-o" aria-hidden="true"></i> Limpiar</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Equipos</h5>
				<div class="toolbar">
					<?php
					//Se llama al paginador
					echo paginador_2('pagsup',$total_paginas, $original, $search, $num_pag ) ?>
				</div>
			</header>
			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
							<th>
								<div class="pull-left">Nombre</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=nombre_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=nombre_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Identificador</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=identificador_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=identificador_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Estado</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=estado_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=estado_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><th width="160">Sistema</th><?php } ?>
							<th width="10">Acciones</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php foreach ($arrUsers as $usuarios){ ?>
						<tr class="odd">
							<td><?php echo $usuarios['Nombre']; ?></td>
							<td><?php echo $usuarios['Identificador']; ?></td>
							<td><label class="label <?php if(isset($usuarios['idEstado'])&&$usuarios['idEstado']==1){echo 'label-success';}else{echo 'label-danger';} ?>"><?php echo $usuarios['Estado']; ?></label></td>
							<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><td><?php echo $usuarios['sistema']; ?></td><?php } ?>
							<td>
								<div class="btn-group" style="width: 70px;" >
									<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_telemetria_admin.php?view='.simpleEncode($usuarios['idTelemetria'], fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'&id='.$usuarios['idTelemetria']; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
								</div>
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
			<div class="pagrow">
				<?php
				//se llama al paginador
				echo paginador_2('paginf',$total_paginas, $original, $search, $num_pag ) ?>
			</div>
		</div>
	</div>

<?php } ?>
<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';

?>
