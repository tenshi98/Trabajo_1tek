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
$original = "informe_cross_telemetria_01.php";
$location = $original;
//Se agregan ubicaciones
$search ='&submit_filter=Filtrar';
$location .= "?submit_filter=Filtrar";
if(isset($_GET['idTelemetria']) && $_GET['idTelemetria']!=''){      $location .= "&idTelemetria=".$_GET['idTelemetria'];      $search .= "&idTelemetria=".$_GET['idTelemetria'];}
if(isset($_GET['idPredio']) && $_GET['idPredio']!=''){       $location .= "&idPredio=".$_GET['idPredio'];              $search .= "&idPredio=".$_GET['idPredio'];}
if(isset($_GET['idZona']) && $_GET['idZona']!=''){           $location .= "&idZona=".$_GET['idZona'];                  $search .= "&idZona=".$_GET['idZona'];}
if(isset($_GET['fecha_desde'], $_GET['fecha_hasta'])&&$_GET['fecha_desde']!=''&&$_GET['fecha_hasta']!=''){
	$search .="&fecha_desde=".$_GET['fecha_desde'];
	$search .="&fecha_hasta=".$_GET['fecha_hasta'];
}
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
//Variable de busqueda
$SIS_where = "telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".idTabla!=0";
/**********************************************************/
//Se aplican los filtros
if(isset($_GET['idPredio']) && $_GET['idPredio']!=''){   $SIS_where .= " AND cross_predios_listado_zonas.idPredio=".$_GET['idPredio'];}
if(isset($_GET['idZona']) && $_GET['idZona']!=''){$SIS_where .= " AND telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".idZona=".$_GET['idZona'];}
if(isset($_GET['fecha_desde'], $_GET['fecha_hasta'])&&$_GET['fecha_desde']!=''&&$_GET['fecha_hasta']!=''){
	$SIS_where.=" AND telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".FechaSistema BETWEEN '".$_GET['fecha_desde']."' AND '".$_GET['fecha_hasta']."'";
}
$SIS_where .=" GROUP BY cross_predios_listado_zonas.idPredio, telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".idZona, telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".idTelemetria";
$SIS_join  = '
	LEFT JOIN `cross_predios_listado_zonas`   ON cross_predios_listado_zonas.idZona     = telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.idZona
	LEFT JOIN `cross_predios_listado`         ON cross_predios_listado.idPredio         = cross_predios_listado_zonas.idPredio';

//verifico el numero de datos antes de hacer la consulta
$ndata_1 = db_select_nrows (false, 'idTabla', 'telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'], $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'ndata_1');

//si el dato es superior a 10.000
if(isset($ndata_1)&&$ndata_1>=10001){
	alert_post_data(4,1,1,0, 'Estas tratando de seleccionar mas de 10.000 datos, trata con un rango inferior para poder mostrar resultados');
}else{
	//obtengo la cantidad real de sensores
	$rowEquipo = db_select_data (false, 'Nombre AS EquipoNombre', 'telemetria_listado', '', 'idTelemetria='.$_GET['idTelemetria'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowEquipo');

	/****************************************/
	//Numero del sensor
	$NSensor = 1;
	//consulto
	$SIS_query = '
	cross_predios_listado.Nombre AS PredioNombre,
	cross_predios_listado_zonas.Nombre AS CuartelNombre,

	telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.idZona,
	cross_predios_listado_zonas.idPredio,

	MIN(NULLIF(IF(telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.Sensor_'.$NSensor.'<99900,telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.Sensor_'.$NSensor.',0),0)) AS MedMin,
	MAX(NULLIF(IF(telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.Sensor_'.$NSensor.'<99900,telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.Sensor_'.$NSensor.',0),0)) AS MedMax,
	AVG(NULLIF(IF(telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.Sensor_'.$NSensor.'<99900,telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.Sensor_'.$NSensor.',0),0)) AS MedProm,
	STDDEV(NULLIF(IF(telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.Sensor_'.$NSensor.'<99900,telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.Sensor_'.$NSensor.',0),0)) AS MedDesStan,
	COUNT(telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.idTabla) AS CantidadMuestra';
	$SIS_order = 'cross_predios_listado_zonas.idPredio ASC, telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.idZona ASC, telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.idTelemetria ASC LIMIT 10000';
	$arrMediciones = array();
	$arrMediciones = db_select_array (false, $SIS_query, 'telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'], $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrMediciones');
									
	?>


	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Resumen Mediciones</h5>
			</header>
			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
							<th>Predio</th>
							<th>Cuartel</th>
							<th>Equipo</th>
							<th>Cantidad Muestras</th>
							<th>Minimo</th>
							<th>Maximo</th>
							<th>Promedio</th>
							<th>Desviacion Estandar</th>
							<th width="10">Acciones</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php foreach ($arrMediciones as $med) { ?>
							<tr class="odd">
								<td><?php echo $med['PredioNombre']; ?></td>
								<td><?php echo $med['CuartelNombre']; ?></td>
								<td><?php echo $rowEquipo['EquipoNombre']; ?></td>

								<td><?php echo $med['CantidadMuestra']; ?></td>
								<td><?php echo $med['MedMin']; ?></td>
								<td><?php echo $med['MedMax']; ?></td>
								<td><?php echo $med['MedProm']; ?></td>
								<td><?php echo $med['MedDesStan']; ?></td>

								<td>
									<div class="btn-group" style="width: 70px;" >
										<?php
										$search  = "&idTelemetria=".$_GET['idTelemetria'];
										$search .="&idZona=".$med['idZona'];
										$search .="&idPredio=".$med['idPredio'];
										if(isset($_GET['fecha_desde'], $_GET['fecha_hasta'])&&$_GET['fecha_desde']!=''&&$_GET['fecha_hasta']!=''){
											$search .="&fecha_desde=".$_GET['fecha_desde'];
											$search .="&fecha_hasta=".$_GET['fecha_hasta'];
										}
										?>
										<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'informe_cross_telemetria_01_map.php?bla=bla'.$search; ?>" title="Ver Mapa" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-map" aria-hidden="true"></i></a><?php } ?>
										<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'informe_cross_telemetria_01_view.php?bla=bla'.$search; ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
									</div>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

<?php } ?>
  
<div class="clearfix"></div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
	<a href="<?php echo $original; ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
	<div class="clearfix"></div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
$y = "idEstado=1";
$x = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
//Filtro de Búsqueda
$w  = "telemetria_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];   //Sistema
//Verifico el tipo de usuario que esta ingresando
if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
	$w .= " AND usuarios_equipos_telemetria.idUsuario = ".$_SESSION['usuario']['basic_data']['idUsuario'];
}
//Se escribe el dato
$Alert_Text  = 'La busqueda esta limitada a 10.000 registros, en caso de necesitar mas registros favor comunicarse con el administrador';
alert_post_data(2,1,1,0, $Alert_Text);

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
				if(isset($idTelemetria)){           $x1  = $idTelemetria;           }else{$x1  = '';}
				if(isset($idPredio)){               $x2  = $idPredio;               }else{$x2  = '';}
				if(isset($idZona)){                 $x3  = $idZona;                 }else{$x3  = '';}
				if(isset($fecha_desde)){            $x4  = $fecha_desde;            }else{$x4  = '';}
				if(isset($fecha_hasta)){            $x5  = $fecha_hasta;            }else{$x5  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
					$Form_Inputs->form_select_filter('Equipo Medicion','idTelemetria', $x1, 2, 'idTelemetria', 'Nombre', 'telemetria_listado', $w, '', $dbConn);
				}else{
					$Form_Inputs->form_select_join_filter('Equipo Medicion','idTelemetria', $x1, 2, 'idTelemetria', 'Nombre', 'telemetria_listado', 'usuarios_equipos_telemetria', $w, $dbConn);
				}
				$Form_Inputs->form_select_depend1('Predio','idPredio', $x2, 1, 'idPredio', 'Nombre', 'cross_predios_listado', $x, 0,
										 'Cuarteles','idZona', $x3, 1, 'idZona', 'Nombre', 'cross_predios_listado_zonas', 'idEstado=1', 0,
										 $dbConn, 'form1');
				$Form_Inputs->form_date('Fecha Desde','fecha_desde', $x4, 1);
				$Form_Inputs->form_date('Fecha Hasta','fecha_hasta', $x5, 1);

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
