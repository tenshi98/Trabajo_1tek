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
$original = "informe_telemetria_registro_sensores_23.php";
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
	$search .= '&SensoresUniMed='.$_GET['SensoresUniMed'];
	if(isset($_GET['f_inicio'], $_GET['f_termino'], $_GET['h_inicio'], $_GET['h_termino'])&&$_GET['f_inicio']!=''&&$_GET['f_termino']!=''&&$_GET['h_inicio']!=''&&$_GET['h_termino']!=''){
		$SIS_where .=" (telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".TimeStamp BETWEEN '".$_GET['f_inicio']." ".$_GET['h_inicio']."' AND '".$_GET['f_termino']." ".$_GET['h_termino']."')";
		$search    .="&f_inicio=".$_GET['f_inicio']."&h_inicio=".$_GET['h_inicio'];
		$search    .="&f_termino=".$_GET['f_termino']."&h_termino=".$_GET['h_termino'];
	}elseif(isset($_GET['f_inicio'], $_GET['f_termino'])&&$_GET['f_inicio']!=''&&$_GET['f_termino']!=''){
		$SIS_where .=" (telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".FechaSistema BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."')";
		$search    .="&f_inicio=".$_GET['f_inicio'];
		$search    .="&f_termino=".$_GET['f_termino'];
	}
	foreach ($_GET["idGrupo"] as $gru) { $search .="&idGrupo[]=".$gru;}

	/*******************************************************************/
	//variables
	$ndata_1 = 0;
	$ndata_2 = 0;
	$ndata_3 = 0;
	$error   = '';
	//Se verifica si el dato existe
	$ndata_1 = db_select_nrows (false, 'idTabla', 'telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'], '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'ndata_1');
	foreach ($_GET["idGrupo"] as $gru) { $ndata_2++;}
	if(!isset($_GET['SensoresUniMed']) OR $_GET['SensoresUniMed']==''){$ndata_3++;}
	//generacion de errores
	if($ndata_1>=10001) { $error = 'Estas tratando de seleccionar mas de 10.000 datos, trata con un rango inferior para poder mostrar resultados';}
	if($ndata_2==0) {     $error = 'No ha seleccionado ningun grupo';}
	if($ndata_3!=0) {     $error = 'No ha seleccionado ninguna unidad de medida';}
	/*******************************************************************/

	//Si no hay errores ejecuto el codigo
	if(isset($error)&&$error!=''){
		alert_post_data(4,1,1,0, $error);
	}else{
		/****************************************************************/
		//Numero de sensores
		$rowNSensores = db_select_data (false, 'cantSensores', 'telemetria_listado', '', 'idTelemetria='.$_GET['idTelemetria'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowEquipo');

		/****************************************************************/
		//obtengo la cantidad real de sensores
		$SIS_query = 'telemetria_listado.Nombre AS NombreEquipo';
		for ($i = 1; $i <= $rowNSensores['cantSensores']; $i++) {
			$SIS_query .= ',telemetria_listado_sensores_grupo.SensoresGrupo_'.$i.' AS SensoresGrupo_'.$i;
			$SIS_query .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i.' AS SensoresUniMed_'.$i;
			$SIS_query .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$i.' AS SensoresActivo_'.$i;
		}
		$SIS_join  = '
		LEFT JOIN `telemetria_listado_sensores_grupo`   ON telemetria_listado_sensores_grupo.idTelemetria   = telemetria_listado.idTelemetria
		LEFT JOIN `telemetria_listado_sensores_unimed`  ON telemetria_listado_sensores_unimed.idTelemetria  = telemetria_listado.idTelemetria
		LEFT JOIN `telemetria_listado_sensores_activo`  ON telemetria_listado_sensores_activo.idTelemetria  = telemetria_listado.idTelemetria';
		$rowEquipo = db_select_data (false, $SIS_query, 'telemetria_listado', $SIS_join, 'telemetria_listado.idTelemetria='.$_GET['idTelemetria'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowEquipo');

		/****************************************************************/
		//se traen lo datos del equipo
		$SIS_query = 'FechaSistema,HoraSistema';
		for ($i = 1; $i <= $rowNSensores['cantSensores']; $i++) {
			$SIS_query .= ',Sensor_'.$i.' AS SensorValue_'.$i;
		}
		$SIS_join  = '';
		$SIS_order = 'FechaSistema ASC, HoraSistema ASC LIMIT 10000';
		$arrMediciones = array();
		$arrMediciones = db_select_array (false, $SIS_query, 'telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'], $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrMediciones');

		/*************************************************************/
		//busco los grupos disponibles
		$arrSubgrupo          = array();
		$SIS_whereSubgrupo    = 'idGrupo=0';
		//creo arreglo
		foreach ($_GET["idGrupo"] as $gru) {
			$SIS_whereSubgrupo .= ' OR idGrupo='.$gru;
		}

		/****************************************/
		//Se consulta
		$arrGrupos = array();
		$arrGrupos = db_select_array (false, 'idGrupo, Nombre', 'telemetria_listado_grupos', '', $SIS_whereSubgrupo, 'idGrupo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrGrupos');
		//se recorre
		$arrGruposTemp = array();
		foreach ($arrGrupos as $gru) {
			$arrGruposTemp[$gru['idGrupo']]['Nombre'] = TituloMenu($gru['Nombre']);
			$arrGruposTemp[$gru['idGrupo']]['Valor']  = '';
		}

		/****************************************************************/
		//Variables
		$m_table_title  = '';
		//recorro los grupos
		foreach ($_GET["idGrupo"] as $gru) { $m_table_title .= '<th>'.$arrGruposTemp[$gru]['Nombre'].'</th>';}
		$m_table        = '';
		$Temp_1         = '';
		/****************************************************************/
		//titulo de la tabla
		switch ($_GET['SensoresUniMed']) {
			case 3:  $gr_tittle = 'Temperatura';       $gr_unimed = '(°C)';break;
			case 13: $gr_tittle = 'Sensacion Termica'; $gr_unimed = '(°C)';break;
			case 2:  $gr_tittle = 'Humedad';           $gr_unimed = '(%)';break;
		}

		/*******************************************************************************/
		//se arman datos
		foreach ($arrMediciones as $fac) {
			/************************/
			//Tabla
			$m_table .= '<tr class="odd">';
			$m_table .= '<td>'.fecha_estandar($fac['FechaSistema']).'</td>';
			$m_table .= '<td>'.$fac['HoraSistema'].'</td>';
			//Fecha
			$Temp_1  .= "'".Fecha_estandar($fac['FechaSistema'])." - ".Hora_estandar($fac['HoraSistema'])."',";
			/************************/
			//Variables
			$arrTemp        = array();
			//recorro los grupos
			foreach ($_GET["idGrupo"] as $gru) {
				/***********************************************/
				//recorro los sensores
				for ($x = 1; $x <= $rowNSensores['cantSensores']; $x++) {
					if($rowEquipo['SensoresGrupo_'.$x]==$gru){
						//Verifico si el sensor esta activo para guardar el dato
						if(isset($rowEquipo['SensoresActivo_'.$x])&&$rowEquipo['SensoresActivo_'.$x]==1){
							//Que el valor medido sea distinto de 999
							if(isset($fac['SensorValue_'.$x])&&$fac['SensorValue_'.$x]<99900){
								//promedio
								if($rowEquipo['SensoresUniMed_'.$x]==$_GET['SensoresUniMed']){
									$arrTemp[$gru]['Value'] = $arrTemp[$gru]['Value'] + $fac['SensorValue_'.$x];
									$arrTemp[$gru]['Count']++;
								}
							}
						}
					}
				}
				/***********************************************/
				//saco promedios
				if($arrTemp[$gru]['Count']!=0){
					$arrTemp[$gru]['Prom'] = $arrTemp[$gru]['Value']/$arrTemp[$gru]['Count'];
				}else{
					$arrTemp[$gru]['Prom'] = 0;
				}

				/***********************************************/
				//grafico
				if(isset($arrGruposTemp[$gru]['Valor'])&&$arrGruposTemp[$gru]['Valor']!=''){
					$arrGruposTemp[$gru]['Valor'] .= ", ".$arrTemp[$gru]['Prom'];
				//si no lo crea
				}else{
					$arrGruposTemp[$gru]['Valor'] = $arrTemp[$gru]['Prom'];
				}

				/***********************************************/
				//tabla
				$m_table .= '<td>'.Cantidades($arrTemp[$gru]['Prom'], 1).'</td>';
			}

			/************************/
			//Tabla
			$m_table .= '</tr>';
		}
		/*******************************************************************************/
		//graficos
		$Graphics_xData      ='var xData = [';
		$Graphics_yData      ='var yData = [';
		$Graphics_names      = 'var names = [';
		$Graphics_types      = "var types = [";
		$Graphics_texts      = "var texts = [";
		$Graphics_lineColors = "var lineColors = [";
		$Graphics_lineDash   = "var lineDash = [";
		$Graphics_lineWidth  = "var lineWidth = [";
		//recorro los grupos
		foreach ($_GET["idGrupo"] as $gru) {
			//las fechas
			$Graphics_xData     .='['.$Temp_1.'],';
			//los valores
			$Graphics_yData     .='['.$arrGruposTemp[$gru]['Valor'].'],';
			//los nombres
			$Graphics_names     .= '"'.$arrGruposTemp[$gru]['Nombre'].'",';
			//los tipos
			$Graphics_types     .= "'',";
			//si lleva texto en las burbujas
			$Graphics_texts     .= "[],";
			//los colores de linea
			$Graphics_lineColors.= "'',";
			//los tipos de linea
			$Graphics_lineDash  .= "'',";
			//los anchos de la linea
			$Graphics_lineWidth .= "'',";
		}
		//las fechas
		$Graphics_xData     .='];';
		$Graphics_yData     .='];';
		$Graphics_names     .= '];';
		$Graphics_types     .= "];";
		$Graphics_texts     .= "];";
		$Graphics_lineColors.= "];";
		$Graphics_lineDash  .= "];";
		$Graphics_lineWidth .= "];";

		?>

		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Trazabilidad', $_SESSION['usuario']['basic_data']['RazonSocial'], 'Informe del equipo '.$rowEquipo['NombreEquipo']); ?>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 clearfix">
				<a target="new" href="<?php echo 'informe_telemetria_registro_sensores_23_to_excel.php?bla=bla'.$search ; ?>" class="btn btn-sm btn-metis-2 pull-right margin_width"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Exportar a Excel</a>
				<a target="new" href="<?php echo 'informe_telemetria_registro_sensores_23_to_pdf.php?bla=bla'.$search ; ?>" class="btn btn-sm btn-metis-3 pull-right margin_width"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Exportar a PDF</a>
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
						<h5>Graficos del equipo <?php echo $rowEquipo['NombreEquipo']; ?></h5>
					</header>
					<div class="table-responsive">
						<?php
						echo GraphLinear_1('graphLinear_1', $gr_tittle, 'Fecha', $gr_unimed, $Graphics_xData, $Graphics_yData, $Graphics_names, $Graphics_types, $Graphics_texts, $Graphics_lineColors, $Graphics_lineDash, $Graphics_lineWidth, 0);

						?>
					</div>
				</div>
			</div>
		<?php } ?>

		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="box">
				<header>
					<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
					<h5>Informe equipo <?php echo $rowEquipo['NombreEquipo']; ?></h5>
				</header>
				<div class="table-responsive">
					<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
						<tbody role="alert" aria-live="polite" aria-relevant="all">
							<tr class="odd">
								<th>Fecha</th>
								<th>Hora</th>
								<?php echo $m_table_title; ?>
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
	//filtros
	$z  = "telemetria_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];   //Sistema
	$z .= " AND telemetria_listado.id_Geo=2";                                                //Geolocalizacion inactiva
	//Verifico el tipo de usuario que esta ingresando
	if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
		$z .= " AND usuarios_equipos_telemetria.idUsuario = ".$_SESSION['usuario']['basic_data']['idUsuario'];
	}
	//Solo para plataforma 1Tek
	if(isset($_SESSION['usuario']['basic_data']['idInterfaz'])&&$_SESSION['usuario']['basic_data']['idInterfaz']==6){
		$z .= " AND telemetria_listado.idTab=2";//1Tek C
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
					//Si es redireccionado desde otra pagina con datos precargados
					if(isset($_GET['view'])&&$_GET['view']!='') { $x5  = $_GET['view'];}

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
					$Form_Inputs->form_select_tel_group_checkbox('Grupos','idGrupo', 'idTelemetria', 'form1', $dbConn);
					$Form_Inputs->form_select('Mostrar Graficos','idGrafico', $x8, 2, 'idOpciones', 'Nombre', 'core_sistemas_opciones', 0, '', $dbConn);
					$Form_Inputs->form_select_tel_unimed_radio('Unidad Medida','SensoresUniMed', 'idTelemetria', 'form1', $dbConn);

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
