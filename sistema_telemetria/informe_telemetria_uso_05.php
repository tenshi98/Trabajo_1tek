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
$original = "informe_telemetria_uso_05.php";
$location = $original;
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['idTelemetria']) && $_GET['idTelemetria']!=''){  $location .= "&idTelemetria=".$_GET['idTelemetria'];  $search .= "&idTelemetria=".$_GET['idTelemetria'];}
if(isset($_GET['F_inicio']) && $_GET['F_inicio']!=''){          $location .= "&F_inicio=".$_GET['F_inicio'];          $search .= "&F_inicio=".$_GET['F_inicio'];}
if(isset($_GET['H_inicio']) && $_GET['H_inicio']!=''){          $location .= "&H_inicio=".$_GET['H_inicio'];          $search .= "&H_inicio=".$_GET['H_inicio'];}
if(isset($_GET['F_termino']) && $_GET['F_termino']!=''){        $location .= "&F_termino=".$_GET['F_termino'];        $search .= "&F_termino=".$_GET['F_termino'];}
if(isset($_GET['H_termino']) && $_GET['H_termino']!=''){        $location .= "&H_termino=".$_GET['H_termino'];        $search .= "&H_termino=".$_GET['H_termino'];}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['submit_filter'])){
	/****************************************************************/
	//obtengo la cantidad real de sensores
	$rowCantSensores = db_select_data (false, 'cantSensores', 'telemetria_listado', '', 'idTelemetria='.$_GET['idTelemetria'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowEquipo');

	/****************************************************************/
	//numero sensores equipo
	$SIS_query = 'telemetria_listado.Nombre';
	for ($i = 1; $i <= $rowCantSensores['cantSensores']; $i++) {
		$SIS_query .= ',telemetria_listado_sensores_revision_grupo.SensoresRevisionGrupo_'.$i;
	}
	$SIS_join  = 'LEFT JOIN `telemetria_listado_sensores_revision_grupo`  ON telemetria_listado_sensores_revision_grupo.idTelemetria  = telemetria_listado.idTelemetria';
	// consulto los datos
	$rowData = db_select_data (false, $SIS_query, 'telemetria_listado', $SIS_join, 'telemetria_listado.idTelemetria ='.$_GET['idTelemetria'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	/**********************************************************/
	//Variable de busqueda
	$SIS_where = 'idSupervisado=1 AND (idGrupo = 0 ';
	for ($i = 1; $i <= $rowCantSensores['cantSensores']; $i++) {
		if(isset($rowData['SensoresRevisionGrupo_'.$i])&&$rowData['SensoresRevisionGrupo_'.$i]!=0){
			$SIS_where .= ' OR idGrupo = '.$rowData['SensoresRevisionGrupo_'.$i];
		}
	}
	$SIS_where .= ')';
	//Se consultan datos
	$arrGruposRev = array();
	$arrGruposRev = db_select_array (false, 'idGrupo, Nombre', 'telemetria_listado_grupos_uso', '', $SIS_where, 'idGrupo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrGruposRev');

	/**********************************************************/
	//Variable de busqueda
	$SIS_where = "telemetria_listado_historial_uso.idUso!=0";
	//Se aplican los filtros
	if(isset($_GET['idTelemetria']) && $_GET['idTelemetria']!=''){$SIS_where.=" AND telemetria_listado_historial_uso.idTelemetria =".$_GET['idTelemetria'];}
	if(isset($_GET['f_inicio'], $_GET['f_termino']) && $_GET['f_inicio'] != '' && $_GET['f_termino']!=''){
		$SIS_where.=" AND telemetria_listado_historial_uso.Fecha BETWEEN '".$_GET['F_inicio']."' AND '".$_GET['F_termino']."'";
	}
	/**********************************************************/
	//numero sensores equipo
	$SIS_query = 'Fecha, Horas_Sensor_activo';
	for ($i = 1; $i <= $rowCantSensores['cantSensores']; $i++) {
		$SIS_query .= ',Horas_'.$i;
	}
	//se consulta
	$arrConsulta = array();
	$arrConsulta = db_select_array (false, $SIS_query, 'telemetria_listado_historial_uso', '', $SIS_where, 'telemetria_listado_historial_uso.Fecha ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrConsulta');

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5><?php echo $rowData['Nombre']; ?></h5>
			</header>
			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
							<th width="120">Fecha</th>
							<th>Encendido</th>
							<?php /*foreach ($arrGruposRev as $col) {
								echo '<th>'.$col['Nombre'].'</th>';
							}*/ ?>
							<th width="10">Acciones</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php
						//variables
						$arrSuma    = array();
						$t_s_activo = 0;
						//recorrio
						foreach ($arrConsulta as $con) {
							//sumo el tiempo activo
							$t_s_activo = $t_s_activo + $con['Horas_Sensor_activo']; ?>
							<tr class="odd">
								<td><?php echo fecha_estandar($con['Fecha']); ?></td>
								<td><?php echo gmdate("H:i:s", $con['Horas_Sensor_activo']); ?></td>
								<?php
								//recorro los grupos
								/*foreach ($arrGruposRev as $col) {
									//contador
									$Count = 0;
									$Sum   = 0;
									//recorro los sensores
									for ($i = 1; $i <= $rowCantSensores['cantSensores']; $i++) {
										//si es el mismo
										if($rowData['SensoresRevisionGrupo_'.$i]==$col['idGrupo']){
											//sumo el tiempo
											$Sum = $Sum + $con['Horas_'.$i];
											$Count++;
										}
										//verifico si existe
										if(isset($arrSuma[$col['idGrupo']]['Suma'])&&$arrSuma[$col['idGrupo']]['Suma']!=0){
											$arrSuma[$col['idGrupo']]['Suma'] = $arrSuma[$col['idGrupo']]['Suma'] + $con['Horas_'.$i];
										}else{
											$arrSuma[$col['idGrupo']]['Suma'] = $con['Horas_'.$i];
										}
										$arrSuma[$col['idGrupo']]['Count']++;
									}
									if($Count!=0){
										echo '<td>'.gmdate("H:i:s", ($Sum/$Count)).'</td>';
									}else{
										echo '<td></td>';
									}
								}*/ ?>
								<td>
									<div class="btn-group" style="width: 35px;" >
										<a href="<?php echo 'informe_telemetria_uso_05_popup.php?idTelemetria='.$_GET['idTelemetria'].'&Fecha='.$con['Fecha']; ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
									</div>
								</td>

							</tr>
						<?php } ?>
						<tr class="odd">
							<td><strong>Total</strong></td>
							<td><strong><?php echo segundos2horas($t_s_activo); ?></strong></td>
							<?php
							foreach ($arrGruposRev as $col) {
								//verifico si existe
								if(isset($arrSuma[$col['idGrupo']]['Count'])&&$arrSuma[$col['idGrupo']]['Count']!=''){
									echo '<td><strong>'.segundos2horas($arrSuma[$col['idGrupo']]['Suma'] / $arrSuma[$col['idGrupo']]['Count']).'</strong></td>';
								}else{
									echo '<td></td>';
								}
							} ?>
						</tr>

					</tbody>
				</table>
			</div>
		</div>
	</div>

	<div class="clearfix"></div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
		<a href="<?php echo $original; ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
		<div class="clearfix"></div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
	//Filtro de Búsqueda
	$w  = "telemetria_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];   //Sistema
	$w .= " AND telemetria_listado.id_Geo=2";                                                //Geolocalizacion inactiva
	$w .= " AND telemetria_listado.idTab=2";                                                 //Power-Crane
	//Verifico el tipo de usuario que esta ingresando
	if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
		$w .= " AND usuarios_equipos_telemetria.idUsuario = ".$_SESSION['usuario']['basic_data']['idUsuario'];
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
					if(isset($idTelemetria)){  $x1  = $idTelemetria;  }else{$x1  = '';}
					if(isset($F_inicio)){      $x2  = $F_inicio;      }else{$x2  = '';}
					if(isset($F_termino)){     $x3  = $F_termino;     }else{$x3  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					//Verifico el tipo de usuario que esta ingresando
					if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
						$Form_Inputs->form_select_filter('Equipo','idTelemetria', $x1, 2, 'idTelemetria', 'Nombre', 'telemetria_listado', $w, '', $dbConn);
					}else{
						$Form_Inputs->form_select_join_filter('Equipo','idTelemetria', $x1, 2, 'idTelemetria', 'Nombre', 'telemetria_listado', 'usuarios_equipos_telemetria', $w, $dbConn);
					}
					$Form_Inputs->form_date('Fecha Inicio','F_inicio', $x2, 2);
					$Form_Inputs->form_date('Fecha Termino','F_termino', $x3, 2);

					$Form_Inputs->form_input_hidden('pagina', 1, 2);
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
