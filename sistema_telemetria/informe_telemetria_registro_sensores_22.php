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
$original = "informe_telemetria_registro_sensores_22.php";
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

	//se verifica si se ingreso la hora, es un dato optativo
	$SIS_where = '';
	$search  = '&idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
	$search .= '&idTelemetria='.$_GET['idTelemetria'];
	if(isset($_GET['f_inicio'], $_GET['f_termino'], $_GET['h_inicio'], $_GET['h_termino'])&&$_GET['f_inicio']!=''&&$_GET['f_termino']!=''&&$_GET['h_inicio']!=''&&$_GET['h_termino']!=''){
		$SIS_where .= "(telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".TimeStamp BETWEEN '".$_GET['f_inicio']." ".$_GET['h_inicio']."' AND '".$_GET['f_termino']." ".$_GET['h_termino']."')";
		$search    .="&f_inicio=".$_GET['f_inicio']."&h_inicio=".$_GET['h_inicio'];
		$search    .="&f_termino=".$_GET['f_termino']."&h_termino=".$_GET['h_termino'];
	}elseif(isset($_GET['f_inicio'], $_GET['f_termino'])&&$_GET['f_inicio']!=''&&$_GET['f_termino']!=''){
		$SIS_where .= "(telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".FechaSistema BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."')";
		$search    .="&f_inicio=".$_GET['f_inicio'];
		$search    .="&f_termino=".$_GET['f_termino'];
	}

	//verifico el numero de datos antes de hacer la consulta
	$ndata_1 = db_select_nrows (false, 'idTabla', 'telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'], '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'ndata_1');

	//si el dato es superior a 10.000
	if(isset($ndata_1)&&$ndata_1>=10001){
		alert_post_data(4,1,1,0, 'Estas tratando de seleccionar mas de 10.000 datos, trata con un rango inferior para poder mostrar resultados');
	}else{
		//obtengo la cantidad real de sensores
		$rowCantSensores = db_select_data (false, 'cantSensores', 'telemetria_listado', '', 'idTelemetria='.$_GET['idTelemetria'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowEquipo');

		/****************************************************************/
		//obtengo la cantidad real de sensores
		$SIS_query = 'telemetria_listado.Nombre AS NombreEquipo';
		for ($i = 1; $i <= $rowCantSensores['cantSensores']; $i++) {
			$SIS_query .= ',telemetria_listado_sensores_grupo.SensoresGrupo_'.$i.' AS SensoresGrupo_'.$i;
		}
		$SIS_join  = 'LEFT JOIN `telemetria_listado_sensores_grupo`   ON telemetria_listado_sensores_grupo.idTelemetria   = telemetria_listado.idTelemetria';
		$rowEquipo = db_select_data (false, $SIS_query, 'telemetria_listado', $SIS_join, 'telemetria_listado.idTelemetria='.$_GET['idTelemetria'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowEquipo');

		/****************************************************************/
		//se traen lo datos del equipo
		$SIS_query = 'FechaSistema, HoraSistema';
		for ($i = 1; $i <= $rowCantSensores['cantSensores']; $i++) {
			$SIS_query .= ',Sensor_'.$i.' AS SensorValue_'.$i;
		}
		$SIS_join  = '';
		$SIS_order = 'FechaSistema ASC, HoraSistema ASC LIMIT 10000';
		$arrDatos = array();
		$arrDatos = db_select_array (false, $SIS_query, 'telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'], $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrDatos');

		/*************************************************************************/
		//Variable de busqueda
		$SIS_where = 'idGrupo = 0 ';
		for ($i = 1; $i <= $rowCantSensores['cantSensores']; $i++) {
			//verifico si existe
			if(isset($rowEquipo['SensoresGrupo_'.$i])&&$rowEquipo['SensoresGrupo_'.$i]!=0){
				$SIS_where .= ' OR idGrupo='.$rowEquipo['SensoresGrupo_'.$i];
			}
		}
		//consulto grupos
		$arrGrupos = array();
		$arrGrupos = db_select_array (false, 'idGrupo, Nombre', 'telemetria_listado_grupos', '', $SIS_where, 'idGrupo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrGrupos');

		/*************************************************************************/
		//Variables
		$m_table        = '';
		$m_table_title  = '';
		$Temp_1         = '';
		$count          = 0;
		$arrData        = array();

		//se arman datos
		foreach ($arrDatos as $fac) {

			//variables
			$arrDato       = array();
			$SubTotal      = 0;
			$CountSubTotal = 0;

			//recorro los sensores
			for ($x = 1; $x <= $rowCantSensores['cantSensores']; $x++) {
				//Que el valor medido sea distinto de 999
				if(isset($fac['SensorValue_'.$x])&&$fac['SensorValue_'.$x]<99900){
					//verifico si existe
					if(isset($arrDato[$rowEquipo['SensoresGrupo_'.$x]]['Valor'])&&$arrDato[$rowEquipo['SensoresGrupo_'.$x]]['Valor']!=''){
						$arrDato[$rowEquipo['SensoresGrupo_'.$x]]['Valor'] = $arrDato[$rowEquipo['SensoresGrupo_'.$x]]['Valor'] + $fac['SensorValue_'.$x];
						$arrDato[$rowEquipo['SensoresGrupo_'.$x]]['Cuenta']++;
					//si no lo crea
					}else{
						$arrDato[$rowEquipo['SensoresGrupo_'.$x]]['Valor']  = $fac['SensorValue_'.$x];
						$arrDato[$rowEquipo['SensoresGrupo_'.$x]]['Cuenta'] = 1;
					}
				}
			}

			//Guardo la fecha
			$Temp_1 .= "'".Fecha_estandar($fac['FechaSistema'])." - ".$fac['HoraSistema']."',";

			/***********************************************/
			//imprimo tabla
			$m_table .= '
			<tr class="odd">
				<td>'.fecha_estandar($fac['FechaSistema']).'</td>
				<td>'.$fac['HoraSistema'].'</td>';
				//recorro los grupos
				foreach ($arrGrupos as $gru) {

					/***********************************************/
					//verifico si hay datos
					if($arrDato[$gru['idGrupo']]['Cuenta']!=0){
						$New_Dato = $arrDato[$gru['idGrupo']]['Valor']/$arrDato[$gru['idGrupo']]['Cuenta'];
					}else{
						$New_Dato = 0;
					}

					/***********************************************/
					//guardo dentro del grupo
					//verifico si existe
					if(isset($arrData[$gru['idGrupo']]['Value'])&&$arrData[$gru['idGrupo']]['Value']!=''){
						$arrData[$gru['idGrupo']]['Value'] .= ", ".$New_Dato;
					//si no lo crea
					}else{
						$arrData[$gru['idGrupo']]['Value'] = $New_Dato;
					}

					/***********************************************/
					//imprimo tabla
					$m_table .= '<td>'.cantidades($New_Dato, 2).'</td>';
					//guardo subtotal de la fila
					$SubTotal = $SubTotal + $New_Dato;
					$CountSubTotal++;
				}
			/***********************************************/
			//verifico si existe
			if(isset($CountSubTotal)&&$CountSubTotal!=0){
				if(isset($arrData[9999]['Value'])&&$arrData[9999]['Value']!=''){
					$arrData[9999]['Value'] .= ", ".($SubTotal/$CountSubTotal);
				//si no lo crea
				}else{
					$arrData[9999]['Value'] = ($SubTotal/$CountSubTotal);
				}
				//imprimo SubTotal
				$m_table .= '<td>'.cantidades($SubTotal/$CountSubTotal, 2).'</td>';
			}
			//imprimo tabla
			$m_table .= '</tr>';
			//contador
			$count++;
		}
		//variables
		$Graphics_xData       = 'var xData = [';
		$Graphics_yData       = 'var yData = [';
		$Graphics_names       = 'var names = [';
		$Graphics_types       = 'var types = [';
		$Graphics_texts       = 'var texts = [';
		$Graphics_lineColors  = 'var lineColors = [';
		$Graphics_lineDash    = 'var lineDash = [';
		$Graphics_lineWidth   = 'var lineWidth = [';
		//se agrega nuevo item
		$stack = [ "idGrupo" => 9999, "Nombre" => "Promedio"];
		array_push($arrGrupos, $stack);
		//Se crean los datos
		foreach ($arrGrupos as $gru) {
			if(isset($arrData[$gru['idGrupo']]['Value'])&&$arrData[$gru['idGrupo']]['Value']!=''){
				//las fechas
				$Graphics_xData      .='['.$Temp_1.'],';
				//los valores
				$Graphics_yData      .='['.$arrData[$gru['idGrupo']]['Value'].'],';
				//los nombres
				$Graphics_names      .= '"'.$gru['Nombre'].'",';
				//los tipos
				$Graphics_types      .= "'',";
				//si lleva texto en las burbujas
				$Graphics_texts      .= "[],";
				//los colores de linea
				$Graphics_lineColors .= "'',";
				//si es subtotal
				if(isset($gru['idGrupo'])&&$gru['idGrupo']==9999){
					//los tipos de linea
					$Graphics_lineDash   .= "'dot',";
					//los anchos de la linea
					$Graphics_lineWidth  .= "'3',";
				}else{
					//los tipos de linea
					$Graphics_lineDash   .= "'',";
					//los anchos de la linea
					$Graphics_lineWidth  .= "'',";
				}
			}
		}
		$Graphics_xData      .= '];';
		$Graphics_yData      .= '];';
		$Graphics_names      .= '];';
		$Graphics_types      .= '];';
		$Graphics_texts      .= '];';
		$Graphics_lineColors .= '];';
		$Graphics_lineDash   .= '];';
		$Graphics_lineWidth  .= '];';

		?>

		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Comparacion Grupos Sensores', $_SESSION['usuario']['basic_data']['RazonSocial'], 'Informe del equipo '.$rowEquipo['NombreEquipo']); ?>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 clearfix">
				<a target="new" href="<?php echo 'informe_telemetria_registro_sensores_22_to_pdf.php?bla=bla'.$search ; ?>" class="btn btn-sm btn-metis-3 pull-right margin_width"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Exportar a PDF</a>
			</div>
		</div>
		<div class="clearfix"></div>

		<?php
		//Se verifica si se pidieron los graficos
		if(isset($_GET['idGrafico'])&&$_GET['idGrafico']==1){ ?>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="box">
					<header>
						<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
						<h5> Graficos del equipo <?php echo $rowEquipo['NombreEquipo']; ?></h5>
					</header>
					<div class="table-responsive" id="grf">

						<?php
						$gr_tittle = 'Grafico';
						$gr_unimed = 'Consumo';

						echo GraphLinear_1('graphLinear_1', $gr_tittle, 'Fecha', $gr_unimed, $Graphics_xData, $Graphics_yData, $Graphics_names, $Graphics_types, $Graphics_texts, $Graphics_lineColors, $Graphics_lineDash, $Graphics_lineWidth, 0); ?>

					</div>
				</div>
			</div>
		<?php } ?>

		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="box">
				<header>
					<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
					<h5>Tabla de Datos del equipo <?php echo $rowEquipo['NombreEquipo']; ?></h5>
				</header>
				<div class="table-responsive">
					<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
						<tbody role="alert" aria-live="polite" aria-relevant="all">
							<tr class="odd">
								<th>Fecha</th>
								<th>Hora</th>
								<?php foreach ($arrGrupos as $gru) { echo '<th>'.$gru['Nombre'].'</th>'; } ?>
							</tr>
							<?php echo $m_table; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>

	<?php } ?>

	<div class="clearfix"></div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
		<a href="<?php echo $location ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
		<div class="clearfix"></div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
	//Filtro de Búsqueda
	$z  = "telemetria_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];   //Sistema
	$z .= " AND telemetria_listado.id_Geo=2";                                                //Geolocalizacion inactiva
	$z .= " AND telemetria_listado.idTab=2";                                                 //1Tek C
	//Verifico el tipo de usuario que esta ingresando
	if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
		$z .= " AND usuarios_equipos_telemetria.idUsuario = ".$_SESSION['usuario']['basic_data']['idUsuario'];
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
					if(isset($f_inicio)){      $x1  = $f_inicio;     }else{$x1  = '';}
					if(isset($h_inicio)){      $x2  = $h_inicio;     }else{$x2  = '';}
					if(isset($f_termino)){     $x3  = $f_termino;    }else{$x3  = '';}
					if(isset($h_termino)){     $x4  = $h_termino;    }else{$x4  = '';}
					if(isset($idTelemetria)){  $x5  = $idTelemetria; }else{$x5  = '';}
					if(isset($idGrafico)){     $x8  = $idGrafico;    }else{$x8  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_date('Fecha Inicio','f_inicio', $x1, 2);
					$Form_Inputs->form_time('Hora Inicio','h_inicio', $x2, 1, 1);
					$Form_Inputs->form_date('Fecha Termino','f_termino', $x3, 2);
					$Form_Inputs->form_time('Hora Termino','h_termino', $x4, 1, 1);
					//Verifico el tipo de usuario que esta ingresando
					if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
						$Form_Inputs->form_select_filter('Equipo','idTelemetria', $x5, 2, 'idTelemetria', 'Nombre', 'telemetria_listado', $z, '', $dbConn);
					}else{
						$Form_Inputs->form_select_join_filter('Equipo','idTelemetria', $x5, 2, 'idTelemetria', 'Nombre', 'telemetria_listado', 'usuarios_equipos_telemetria', $z, $dbConn);
					}
					$Form_Inputs->form_select('Mostrar Graficos','idGrafico', $x8, 2, 'idOpciones', 'Nombre', 'core_sistemas_opciones', 0, '', $dbConn);

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
