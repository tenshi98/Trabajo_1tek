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
$original = "telemetria_gestion_equipos.php";
$location = $original;
//Se agregan ubicaciones
$location .='?filtro=true';
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
//Variables
$HoraSistema    = hora_actual();
$FechaSistema   = fecha_actual();

//Variable
$SIS_where  = "telemetria_listado.idEstado = 1 ";//solo equipos activos
$SIS_where .= " AND telemetria_listado.id_Geo = 2";//solo los equipos que tengan el seguimiento desactivado
$enlace     = "?dd=true";
//verifico que sea un administrador
$SIS_where .= " AND telemetria_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
$enlace    .= "&idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
if (isset($_GET['idTelemetria'])&&$_GET['idTelemetria']!=''){
	$SIS_where .= " AND telemetria_listado.idTelemetria=".$_GET['idTelemetria'];
	$enlace    .= "&idTelemetria=".$_GET['idTelemetria'];
}

//numero sensores equipo
$N_Maximo_Sensores = 72;
$subquery = '';
for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
	$subquery .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$i;
	$subquery .= ',telemetria_listado_sensores_med_actual.SensoresMedActual_'.$i;
	$subquery .= ',telemetria_listado_sensores_grupo.SensoresGrupo_'.$i;
	$subquery .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i;
}

//Se consultan datos
$SIS_query = '
telemetria_listado.GeoLatitud,
telemetria_listado.GeoLongitud,
telemetria_listado.idTelemetria,
telemetria_listado.Nombre,
telemetria_listado.Direccion_img,
telemetria_listado.LastUpdateHora,
telemetria_listado.LastUpdateFecha,
telemetria_listado.cantSensores,
telemetria_listado.TiempoFueraLinea,
telemetria_listado.NErrores,
core_sistemas.idOpcionesGen_3'.$subquery;
$SIS_join  = '
LEFT JOIN `core_sistemas`                           ON core_sistemas.idSistema                              = telemetria_listado.idSistema
LEFT JOIN `telemetria_listado_sensores_nombre`      ON telemetria_listado_sensores_nombre.idTelemetria      = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_med_actual`  ON telemetria_listado_sensores_med_actual.idTelemetria  = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_grupo`       ON telemetria_listado_sensores_grupo.idTelemetria       = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_unimed`      ON telemetria_listado_sensores_unimed.idTelemetria      = telemetria_listado.idTelemetria';
$rowDatos = db_select_data (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowDatos');

//Se consultan datos
$arrUnimed = array();
$arrUnimed = db_select_array (false, 'idUniMed,Nombre', 'telemetria_listado_unidad_medida', '', '', 'idUniMed ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrUnimed');

//Se consultan datos
$arrGrupos = array();
$arrGrupos = db_select_array (false, 'idGrupo,Nombre', 'telemetria_listado_grupos', '', '', 'idGrupo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrUnimed');

//Guardo los datos en un arreglo
$arrFinalUnimed = array();
foreach ($arrUnimed as $sen) {
	$arrFinalUnimed[$sen['idUniMed']] = $sen['Nombre'];
}

//Guardo los datos en un arreglo
$arrFinalGrupos = array();
foreach ($arrGrupos as $sen) {
	$arrFinalGrupos[$sen['idGrupo']] = $sen['Nombre'];
}

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Gestion de Equipos en Tiempo Real</h5>
		</header>
        <div class="table-responsive">

			<div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
				<div class="row">
					<div id="consulta">
						<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
							<thead>
								<tr role="row">
									<th>Nombre</th>
									<th width="80">Estado</th>
									<th width="80">Acciones</th>
								</tr>
							</thead>
							<tbody role="alert" aria-live="polite" aria-relevant="all">
								<?php
								/**********************************************/
								//Se resetean
								$in_eq_alertas     = 0;
								$in_eq_fueralinea  = 0;

								/**********************************************/
								//Fuera de linea
								$diaInicio   = $rowDatos['LastUpdateFecha'];
								$diaTermino  = $FechaSistema;
								$tiempo1     = $rowDatos['LastUpdateHora'];
								$tiempo2     = $HoraSistema;
								$Tiempo      = horas_transcurridas($diaInicio, $diaTermino, $tiempo1, $tiempo2);

								//Comparaciones de tiempo
								$Time_Tiempo     = horas2segundos($Tiempo);
								$Time_Tiempo_FL  = horas2segundos($rowDatos['TiempoFueraLinea']);
								$Time_Tiempo_Max = horas2segundos('48:00:00');
								$Time_Fake_Ini   = horas2segundos('23:59:50');
								$Time_Fake_Fin   = horas2segundos('24:00:00');
								//comparacion
								if(($Time_Tiempo<$Time_Fake_Ini OR $Time_Tiempo>$Time_Fake_Fin)&&(($Time_Tiempo>$Time_Tiempo_FL&&$Time_Tiempo_FL!=0) OR ($Time_Tiempo>$Time_Tiempo_Max&&$Time_Tiempo_FL==0))){
									$in_eq_fueralinea++;
								}

								/**********************************************/
								//NErrores
								if(isset($rowDatos['NErrores'])&&$rowDatos['NErrores']>0){ $in_eq_alertas++; }

								/*******************************************************/
								//rearmo
								if($in_eq_alertas>0){
									$danger = 'warning';
									$eq_ok  = '<a href="#" title="Con Alertas" class="btn btn-warning btn-sm tooltip"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></a>';
								}elseif($in_eq_fueralinea>0){
									$danger = 'danger';
									$eq_ok  = '<a href="#" title="Fuera de Linea" class="btn btn-danger btn-sm tooltip"><i class="fa fa-chain-broken" aria-hidden="true"></i></a>';
								}else{
									$danger = '';
									$eq_ok  = '<a href="#" title="Sin Problemas" class="btn btn-success btn-sm tooltip"><i class="fa fa-check" aria-hidden="true"></i></a>';
								}

								?>

								<tr class="odd <?php echo $danger; ?>">
									<td><?php echo $rowDatos['Nombre']; ?></td>
									<td><div class="btn-group" ><?php echo $eq_ok; ?></div></td>
									<td>
										<div class="btn-group" style="width: 35px;" >
											<a href="<?php echo 'telemetria_gestion_equipos_view_equipo.php?view='.simpleEncode($rowDatos['idTelemetria'], fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>						
										</div>
									</td>
								</tr>
								<tr class="odd" style="background-color: #CCCCCC;">
									<td>Grupo</td>
									<td colspan="2">Mediciones</td>
								</tr>

								<?php
								$arrGruposTitulo = array();
								$n_sensores = 0;
								$sensor = 0;
								for ($i = 1; $i <= $rowDatos['cantSensores']; $i++) {
									//Unidad medida
									if(isset($arrFinalUnimed[$rowDatos['SensoresUniMed_'.$i]])){
										$unimed = ' '.$arrFinalUnimed[$rowDatos['SensoresUniMed_'.$i]];
									}else{
										$unimed = '';
									}
									//Titulo del cuadro
									if(isset($arrFinalGrupos[$rowDatos['SensoresGrupo_'.$i]])){
										$Titulo = $arrFinalGrupos[$rowDatos['SensoresGrupo_'.$i]];
									}else{
										$Titulo = '';
									}
									//Verifico que no sea el mismo sensor
									if(isset($rowDatos['SensoresMedActual_'.$i])&&$rowDatos['SensoresMedActual_'.$i]<99900){$xdata=Cantidades_decimales_justos($rowDatos['SensoresMedActual_'.$i]).$unimed;}else{$xdata='Sin Datos';}
									//Guardo el valor correspondiente
									$arrGruposTitulo[$Titulo][$i]['Descripcion'] = $rowDatos['SensoresNombre_'.$i].' : '.$xdata;
									$arrGruposTitulo[$Titulo][$i]['valor']       = $rowDatos['SensoresMedActual_'.$i];
									$arrGruposTitulo[$Titulo][$i]['unimed']      = $unimed;
								}

								//Ordenamiento por titulo de grupo
								$names = array();
								foreach ($arrGruposTitulo as $titulo=>$items) {
									$names[] = $titulo;
								}
								array_multisort($names, SORT_ASC, $arrGruposTitulo);

								//se recorre el arreglo
								foreach($arrGruposTitulo as $titulo=>$items) {

									$columna_a = '';
									$columna_b = '';
									$total_col1 = 0;
									$total_col2 = 0;
									$ntotal_col1 = 0;
									$ntotal_col2 = 0;
									$unimed_col1 = '';
									$unimed_col2 = '';
									$y = 1;
									?>
									<tr class="odd">
										<td><?php echo $titulo ?></td>
										<?php foreach($items as $datos) {
											if($y==1){
												$columna_a .= $datos['Descripcion'].'<br/>';
												//Verifico que el dato no sea 99900
												if(isset($datos['valor'])&&$datos['valor']<99900){
													$total_col1 = $total_col1 + $datos['valor'];
													$ntotal_col1++;
												}
												$unimed_col1 = $datos['unimed'];
												$y=2;
											}else{
												$columna_b .= $datos['Descripcion'].'<br/>';
												//Verifico que el dato no sea 99900
												if(isset($datos['valor'])&&$datos['valor']<99900){
													$total_col2 = $total_col2 + $datos['valor'];
													$ntotal_col2++;
												}
												$unimed_col2 = $datos['unimed'];
												$y=1;
											}
										} ?>

										<td><?php echo $columna_a ?></td>
										<td><?php echo $columna_b ?></td>
									</tr>

									<?php if($rowDatos['idOpcionesGen_3']==1){ ?>
										<tr class="odd">
											<td>Promedio</td>
											<td><?php if($ntotal_col1!=0){echo Cantidades_decimales_justos($total_col1/$ntotal_col1).$unimed_col1;} ?></td>
											<td><?php if($ntotal_col2!=0){echo Cantidades_decimales_justos($total_col2/$ntotal_col2).$unimed_col2;} ?></td>
										</tr>
									<?php } ?>

					            <?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>

			<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
				<div class="row">
					<?php if ($rowDatos['Direccion_img']=='') { ?>
						<img style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="Imagen Referencia" src="<?php echo DB_SITE_REPO ?>/Legacy/1tek_public/img/maquina.jpg">
					<?php }else{  ?>
						<img style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="Imagen Referencia" src="upload/<?php echo $rowDatos['Direccion_img']; ?>">
					<?php } ?>
				</div>
			</div>

		</div>
	</div>
</div>

<script type="text/javascript">
	function initialize() {
		setInterval(function(){myTimer2()},10000)
	}
	function myTimer2() {
		$('#consulta').load('telemetria_gestion_equipos_update.php<?php echo $enlace; ?>');
	}
	initialize();
</script>

<div class="clearfix"></div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
	<a href="<?php echo $original; ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
	<div class="clearfix"></div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
//Verifico el tipo de usuario que esta ingresando
if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
	$filter = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND id_Geo=2";
}else{
	//filtro
	$filter = "idTelemetria=0";
	//Se revisan los permisos a los contratos
	$SIS_query = 'idTelemetria';
	$SIS_join  = '';
	$SIS_where = 'idUsuario='.$_SESSION['usuario']['basic_data']['idUsuario'];
	$SIS_order = 'idTelemetria ASC';
	$arrPermisos = array();
	$arrPermisos = db_select_array (false, $SIS_query, 'usuarios_equipos_telemetria', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrPermisos');

	foreach ($arrPermisos as $prod) {
		$filter .= " OR (idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1 AND id_Geo=2 AND idTelemetria=".$prod['idTelemetria'].")";
	}
	//$z = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND id_Geo=2";
}

?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Filtro de Búsqueda</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" action="<?php echo $original; ?>" id="form1" name="form1" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idTelemetria)){     $x1  = $idTelemetria;      }else{$x1  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_filter('Equipo','idTelemetria', $x1, 2, 'idTelemetria', 'Nombre', 'telemetria_listado', $filter, '', $dbConn);
				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf002; Ver" name="submit_filter">
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
