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
$original = "informe_crosscrane_01.php";
$location = $original;
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['submit_filter'])){

	/**********************************************************/
	//Verifico el tipo de usuario que esta ingresando
	$SIS_where = "telemetria_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
	/**********************************************************/
	//Se aplican los filtros
	if(isset($_GET['idTelemetria']) && $_GET['idTelemetria']!=''){  $SIS_where .= " AND telemetria_listado.idTelemetria=".$_GET['idTelemetria'];}
	if(isset($_GET['idUbicacion']) && $_GET['idUbicacion']!=''){    $SIS_where .= " AND telemetria_listado.idUbicacion=".$_GET['idUbicacion'];}
	/**********************************************************/
	// Se trae un listado con todos los elementos
	$SIS_query = '
	telemetria_listado.idTelemetria,
	telemetria_listado.Identificador,
	telemetria_listado.Nombre,
	telemetria_listado.idEstado,
	telemetria_listado.GeoLatitud,
	telemetria_listado.GeoLongitud,

	core_estados.Nombre AS Estado,
	core_sistemas_opciones.Nombre AS Geo,
	core_telemetria_ubicaciones.Nombre AS Ubicacion
	';
	$SIS_join  = '
	LEFT JOIN `core_estados`                 ON core_estados.idEstado                     = telemetria_listado.idEstado
	LEFT JOIN `core_sistemas_opciones`       ON core_sistemas_opciones.idOpciones         = telemetria_listado.id_Geo
	LEFT JOIN `core_telemetria_ubicaciones`  ON core_telemetria_ubicaciones.idUbicacion   = telemetria_listado.idUbicacion
	
	';
	$SIS_order = 'telemetria_listado.idEstado ASC, telemetria_listado.Nombre ASC';
	$arrEquipos = array();
	$arrEquipos = db_select_array (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrEquipos');



	/**********************************************************/
	//Se traen las zonas
	$SIS_query = '
	telemetria_geocercas.idZona,
	telemetria_geocercas.Nombre,
	telemetria_geocercas_ubicaciones.Latitud,
	telemetria_geocercas_ubicaciones.Longitud';
	$SIS_join  = 'LEFT JOIN `telemetria_geocercas_ubicaciones` ON telemetria_geocercas_ubicaciones.idZona = telemetria_geocercas.idZona';
	$SIS_where = 'telemetria_geocercas.idSistema ='.$_SESSION['usuario']['basic_data']['idSistema'].' AND telemetria_geocercas.idEstado = 1'; //De la plataforma y activa
	$SIS_order = 'telemetria_geocercas.idZona ASC, telemetria_geocercas_ubicaciones.idUbicaciones ASC';
	$arrZonas = array();
	$arrZonas = db_select_array (false, $SIS_query, 'telemetria_geocercas', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrEquipos');

	/**********************************************************/
	//se filtran las zonas
	filtrar($arrZonas, 'idZona');
	//se llama al modulo
	$pointLocation = new subpointLocation();

	/**********************************************************/
	//Buscar el nombre de la zona
	$arrTemp = array();
	foreach($arrZonas as $data=>$datos) {
		$arrTemp[$data]['Nombre'] = $datos[0]['Nombre'];
	}

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Equipos</h5>
			</header>
			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
							<th>Nombre</th>
							<th>Identificador</th>
							<th>Estado</th>
							<th>Geolocalizacion</th>
							<th>Ubicacion</th>
							<th>Ubicacion Real</th>
							<th width="10">Acciones</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php
						//Recorro
						foreach ($arrEquipos as $equip) {
							//verifico la existencia
							if(isset($equip['GeoLatitud'], $equip['GeoLongitud'])&&$equip['GeoLatitud']!=0&&$equip['GeoLongitud']!=0){
								//verifico si esta dentro
								$zonaID = inLocationPoint($arrZonas, $pointLocation, $equip['GeoLatitud'], $equip['GeoLongitud']);
								//Verifico si existe datos
								if(isset($arrTemp[$zonaID]['Nombre'])&&$arrTemp[$zonaID]['Nombre']!=''){
									$Zona = $arrTemp[$zonaID]['Nombre'];
								}else{
									$Zona = 'Fuera de Geocerca';
								}
							}else{
								$Zona = 'Sin GPS';
							}
							?>
							<tr class="odd">
								<td><?php echo $equip['Nombre']; ?></td>
								<td><?php echo $equip['Identificador']; ?></td>
								<td><label class="label <?php if(isset($equip['idEstado'])&&$equip['idEstado']==1){echo 'label-success';}else{echo 'label-danger';} ?>"><?php echo $equip['Estado']; ?></label></td>
								<td><?php echo $equip['Geo']; ?></td>
								<td><?php echo $equip['Ubicacion']; ?></td>
								<td><?php echo $Zona; ?></td>
								<td>
									<div class="btn-group" style="width: 35px;" >
										<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_telemetria.php?view='.simpleEncode($equip['idTelemetria'], fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
									</div>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
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
	//Filtro de Búsqueda
	$z  = "telemetria_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];   //Sistema
	//Verifico el tipo de usuario que esta ingresando
	if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
		$z .= " AND usuarios_equipos_telemetria.idUsuario = ".$_SESSION['usuario']['basic_data']['idUsuario'];
	}
	//Solo para plataforma 1tek
	if(isset($_SESSION['usuario']['basic_data']['idInterfaz'])&&$_SESSION['usuario']['basic_data']['idInterfaz']==6){
		$z .= " AND telemetria_listado.idTab=6";//Power-Crane
	}

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Filtro de Búsqueda</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" autocomplete="off" novalidate>

				<?php
					//Se verifican si existen los datos
					if(isset($idTelemetria)){    $x1  = $idTelemetria;    }else{$x1  = '';}
					if(isset($idUbicacion)){     $x2  = $idUbicacion;     }else{$x2  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					//Verifico el tipo de usuario que esta ingresando
					if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
						$Form_Inputs->form_select_filter('Equipo','idTelemetria', $x1, 1, 'idTelemetria', 'Nombre', 'telemetria_listado', $z, '', $dbConn);
					}else{
						$Form_Inputs->form_select_join_filter('Equipo','idTelemetria', $x1, 1, 'idTelemetria', 'Nombre', 'telemetria_listado', 'usuarios_equipos_telemetria', $z, $dbConn);
					}
					$Form_Inputs->form_select('Ubicación Equipo','idUbicacion', $x2, 1, 'idUbicacion', 'Nombre', 'core_telemetria_ubicaciones', 0, '', $dbConn);

					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf002; Filtrar" name="submit_filter">
					</div>
				</form>
				<?php widget_validator(); ?>
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
