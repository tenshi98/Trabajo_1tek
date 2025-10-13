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
$original = "informe_backup_telemetria_activaciones_04.php";
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
/**********************************************************/
//Se consultan datos
$arrGruposRev = array();
$arrGruposRev = db_select_array (false, 'idGrupo, Valor, idSupervisado', 'telemetria_listado_grupos_uso', '', 'idSupervisado=1', 'idGrupo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrGruposRev');

/*******************************************************/
//Se arma la query con los datos justos recibidos
//numero sensores equipo
$N_Maximo_Sensores = 72;
$subquery = '';
$arrNombres = array();
for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
	$subquery .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$i;
	$subquery .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$i;
	$subquery .= ',telemetria_listado_sensores_revision.SensoresRevision_'.$i;
	$subquery .= ',telemetria_listado_sensores_revision_grupo.SensoresRevisionGrupo_'.$i;
}
//Consultas
$SIS_query = '
telemetria_listado.Nombre,
telemetria_listado.cantSensores'.$subquery;
$SIS_join  = '
LEFT JOIN `telemetria_listado_sensores_nombre`          ON telemetria_listado_sensores_nombre.idTelemetria         = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_activo`          ON telemetria_listado_sensores_activo.idTelemetria         = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_revision`        ON telemetria_listado_sensores_revision.idTelemetria       = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_revision_grupo`  ON telemetria_listado_sensores_revision_grupo.idTelemetria = telemetria_listado.idTelemetria';
$SIS_where = 'telemetria_listado.idTelemetria ='.$_GET['idTelemetria'];
//Se traen todos los datos de la maquina
$rowMaquina = db_select_data (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

//Armo la consulta
$subquery = '';
for ($i = 1; $i <= $rowMaquina['cantSensores']; $i++) {
	//recorro los grupos de los sensores que estan siendo supervisados
	foreach ($arrGruposRev as $sen) {
		//verifico que esten activos
		if(isset($rowMaquina['SensoresActivo_'.$i])&&$rowMaquina['SensoresActivo_'.$i]==1){
			//Reviso si el sensor esta siendo supervisado
			if(isset($rowMaquina['SensoresRevision_'.$i])&&$rowMaquina['SensoresRevision_'.$i]==1){
				//verifico que pertenezca al grupo actual
				if($rowMaquina['SensoresRevisionGrupo_'.$i]==$sen['idGrupo']){
					//guardo el nombre
					$arrNombres[$i]['SensorNombre'] = $rowMaquina['SensoresNombre_'.$i];

					//verifico que el valor sea igual o superior al establecido
					if(isset($_GET['Amp'])&&$_GET['Amp']!=''&&$_GET['Amp']!=0){$valor_amp=$_GET['Amp'];}else{$valor_amp=$sen['Valor'];}
					//Consulto el nombre del sensor

					//Consulto el valor minimo
					$subquery .= ',(SELECT Sensor_'.$i.'
					FROM `backup_telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'`
					WHERE FechaSistema=FechaConsultada AND Sensor_'.$i.'>='.$valor_amp.'
					ORDER BY HoraSistema ASC
					LIMIT 1) AS ValorMinimo_'.$i.'';
					$subquery .= ',(SELECT HoraSistema
					FROM `backup_telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'`
					WHERE FechaSistema=FechaConsultada AND Sensor_'.$i.'>='.$valor_amp.'
					ORDER BY HoraSistema ASC
					LIMIT 1) AS HoraMinimo_'.$i.'';

					//Consulto el valor maximo
					$subquery .= ',(SELECT Sensor_'.$i.'
					FROM `backup_telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'`
					WHERE FechaSistema=FechaConsultada AND Sensor_'.$i.'>='.$valor_amp.'
					ORDER BY HoraSistema DESC
					LIMIT 1) AS ValorMaximo_'.$i.'';
					$subquery .= ',(SELECT HoraSistema
					FROM `backup_telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'`
					WHERE FechaSistema=FechaConsultada AND Sensor_'.$i.'>='.$valor_amp.'
					ORDER BY HoraSistema DESC
					LIMIT 1) AS HoraMaximo_'.$i.'';

				}
			}
		}
	}
}
/**********************************************************/
//Se traen todos los registros entre las fechas
$arrMediciones = array();
$arrMediciones = db_select_array (false, 'Fecha AS FechaConsultada'.$subquery, 'telemetria_listado_historial_activaciones', '', 'idTelemetria='.$_GET['idTelemetria'].' AND Fecha BETWEEN "'.$_GET['F_inicio'].'" AND "'.$_GET['F_termino'].'" GROUP BY Fecha',  'Fecha ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrMediciones');

/*******************************************************/
?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 clearfix">
	<?php
	$search .= '&idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
	$search .= '&idTipoUsuario='.$_SESSION['usuario']['basic_data']['idTipoUsuario'];
	?>
	<a target="new" href="<?php echo 'informe_backup_telemetria_activaciones_04_to_excel.php?bla=bla'.$search ; ?>" class="btn btn-sm btn-metis-2 pull-right margin_width"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Exportar a Excel</a>
	<a target="new" href="<?php echo 'informe_backup_telemetria_activaciones_04_to_pdf.php?bla=bla'.$search ; ?>"   class="btn btn-sm btn-metis-3 pull-right margin_width"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Exportar a PDF</a>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Amperaje del equipo <?php echo $rowMaquina['Nombre']; ?></h5>
		</header>
		<div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th>Fecha</th>
						<?php
						//Titulos de los sensores
						for ($i = 1; $i <= $rowMaquina['cantSensores']; $i++) {
							if(isset($arrNombres[$i]['SensorNombre'])&&$arrNombres[$i]['SensorNombre']!=''){
								echo '<th></th>';
							}
						}
						?>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrMediciones as $med) {
						//verifico si existen datos
						$exd = 0;
						for ($i = 1; $i <= $rowMaquina['cantSensores']; $i++) {
							if(isset($med['ValorMinimo_'.$i])){
								$exd++;
							}
						}
						if($exd>0){
						 ?>
							<tr class="odd">
								<td><?php echo fecha_estandar($med['FechaConsultada']); ?></td>
								<?php
								//Titulos de los sensores
								for ($i = 1; $i <= $rowMaquina['cantSensores']; $i++) {
									if(isset($med['ValorMinimo_'.$i])){
										echo '<td>';
										echo '<strong>'.$arrNombres[$i]['SensorNombre'].'</strong><br/>';
										echo 'Inicio: '.Cantidades_decimales_justos($med['ValorMinimo_'.$i]).' a las '.$med['HoraMinimo_'.$i].'<br/>';
										echo 'Termino: '.Cantidades_decimales_justos($med['ValorMaximo_'.$i]).' a las '.$med['HoraMaximo_'.$i].'<br/>';
										echo '</td>';
									}
								}
								?>
							</tr>
						<?php } ?>
					<?php } ?>
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
//filtros
$w = "telemetria_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];   //Sistema
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
				if(isset($H_inicio)){      $x3  = $H_inicio;      }else{$x3  = '';}
				if(isset($F_termino)){     $x4  = $F_termino;     }else{$x4  = '';}
				if(isset($H_termino)){     $x5  = $H_termino;     }else{$x5  = '';}
				if(isset($Amp)){           $x6  = $Amp;           }else{$x6  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				//Verifico el tipo de usuario que esta ingresando
				if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
					$Form_Inputs->form_select_filter('Equipo','idTelemetria', $x1, 2, 'idTelemetria', 'Nombre', 'telemetria_listado', $w, '', $dbConn);
				}else{
					$Form_Inputs->form_select_join_filter('Equipo','idTelemetria', $x1, 2, 'idTelemetria', 'Nombre', 'telemetria_listado', 'usuarios_equipos_telemetria', $w, $dbConn);
				}
				$Form_Inputs->form_date('Fecha Inicio','F_inicio', $x2, 2);
				//$Form_Inputs->form_time('Hora Inicio','H_inicio', $x3, 1, 2);
				$Form_Inputs->form_date('Fecha Termino','F_termino', $x4, 2);
				//$Form_Inputs->form_time('Hora Termino','H_termino', $x5, 1, 1);
				$Form_Inputs->form_input_number('Amperes a revisar', 'Amp', $x6, 1);

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
