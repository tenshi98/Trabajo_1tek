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
$original = "informe_backup_telemetria_registro_sensores_16.php";
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
$search    = '&idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
$search   .= '&idTelemetria='.$_GET['idTelemetria'].'&f_inicio='.$_GET['f_inicio'].'&f_termino='.$_GET['f_termino'];
if(isset($_GET['f_inicio'], $_GET['f_termino'], $_GET['h_inicio'], $_GET['h_termino'])&&$_GET['f_inicio']!=''&&$_GET['f_termino']!=''&&$_GET['h_inicio']!=''&&$_GET['h_termino']!=''){
	$SIS_where .= "(backup_telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".TimeStamp BETWEEN '".$_GET['f_inicio']." ".$_GET['h_inicio']."' AND '".$_GET['f_termino']." ".$_GET['h_termino']."')";
	$search    .= "&h_inicio=".$_GET['h_inicio']."&h_termino=".$_GET['h_termino'];
}elseif(isset($_GET['f_inicio'], $_GET['f_termino'])&&$_GET['f_inicio']!=''&&$_GET['f_termino']!=''){
	$SIS_where .= "(backup_telemetria_listado_tablarelacionada_".$_GET['idTelemetria'].".FechaSistema BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."')";
}
if(isset($_GET['idGrupo'])&&$_GET['idGrupo']!=''){   $search .= '&idGrupo='.$_GET['idGrupo'];}
if(isset($_GET['idUniMed'])&&$_GET['idUniMed']!=''){ $search .= '&idUniMed='.$_GET['idUniMed'];}

//verifico el numero de datos antes de hacer la consulta
$ndata_1 = db_select_nrows (false, 'idTabla', 'backup_telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'], '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'ndata_1');

//si el dato es superior a 10.000
if(isset($ndata_1)&&$ndata_1>=10001){
	alert_post_data(4,1,1,0, 'Estas tratando de seleccionar mas de 10.000 datos, trata con un rango inferior para poder mostrar resultados');
}else{
	//obtengo la cantidad real de sensores
	$rowEquipo = db_select_data (false, 'Nombre AS NombreEquipo,cantSensores', 'telemetria_listado', '', 'idTelemetria='.$_GET['idTelemetria'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowEquipo');

	/****************************************************************/
	//numero sensores equipo
	$consql = '';
	for ($i = 1; $i <= $rowEquipo['cantSensores']; $i++) {
		$consql .= ',telemetria_listado_sensores_grupo.SensoresGrupo_'.$i.' AS SensoresGrupo_'.$i;
		$consql .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i.' AS SensoresUniMed_'.$i;
		$consql .= ',backup_telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.Sensor_'.$i.' AS SensorValue_'.$i;
	}
	/****************************************************************/
	//se traen lo datos del equipo
	$SIS_query = '
	backup_telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.FechaSistema,
	backup_telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.HoraSistema'.$consql;
	$SIS_join  = '
	LEFT JOIN `telemetria_listado`                  ON telemetria_listado.idTelemetria                  = backup_telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_grupo`   ON telemetria_listado_sensores_grupo.idTelemetria   = backup_telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_unimed`  ON telemetria_listado_sensores_unimed.idTelemetria  = backup_telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.idTelemetria';
	$SIS_order = 'backup_telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.FechaSistema ASC, backup_telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.HoraSistema ASC LIMIT 10000';
	$arrEquipos = array();
	$arrEquipos = db_select_array (false, $SIS_query, 'backup_telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'], $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrEquipos');

	/*************************************************************************/
	//busco los grupos disponibles
	$arrSubgrupos = array();
	$SIS_where    = 'idGrupo=0';
	foreach ($arrEquipos as $fac) {
		for ($x = 1; $x <= $rowEquipo['cantSensores']; $x++) {
			$arrSubgrupos[$fac['SensoresGrupo_'.$x]]['idGrupo'] = $fac['SensoresGrupo_'.$x];
		}
	}
	foreach($arrSubgrupos as $categoria=>$sub){
		$SIS_where .= ' OR idGrupo='.$sub['idGrupo'];
	}

	//consulto grupos
	$arrGrupos = array();
	$arrGrupos = db_select_array (false, 'idGrupo, Nombre', 'telemetria_listado_grupos', '', $SIS_where, 'idGrupo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrGrupos');
	//consulto unidad de medida
	$rowUnimed = db_select_data (false, 'idUniMed, Nombre', 'telemetria_listado_unidad_medida', '', 'idUniMed='.$_GET['idUniMed'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowUnimed');

	/*************************************************************************/
	//Variables
	$m_table        = '';
	$m_table_title  = '';
	$Temp_1         = '';
	$count          = 0;
	$arrData        = array();

	//se arman datos
	foreach ($arrEquipos as $fac) {

		//numero sensores equipo
		$N_Maximo_Sensores  = $rowEquipo['cantSensores'];
		$arrDato            = array();

		//recorro los sensores
		for ($x = 1; $x <= $N_Maximo_Sensores; $x++) {
			//Que el valor medido sea distinto de 999
			if(isset($fac['SensorValue_'.$x])&&$fac['SensorValue_'.$x]<99900){
				//verifico si se envio el grupo y si corresponde a algun sensor
				if(isset($_GET['idGrupo'])&&$_GET['idGrupo']!=''&&$fac['SensoresGrupo_'.$x]==$_GET['idGrupo']){
					if($fac['SensoresUniMed_'.$x]==$_GET['idUniMed']){
						//verifico si existe
						if(isset($arrDato[$fac['SensoresGrupo_'.$x]]['Valor'])&&$arrDato[$fac['SensoresGrupo_'.$x]]['Valor']!=''){
							$arrDato[$fac['SensoresGrupo_'.$x]]['Valor'] = $arrDato[$fac['SensoresGrupo_'.$x]]['Valor'] + $fac['SensorValue_'.$x];
							$arrDato[$fac['SensoresGrupo_'.$x]]['Cuenta']++;
						//si no lo crea
						}else{
							$arrDato[$fac['SensoresGrupo_'.$x]]['Valor']  = $fac['SensorValue_'.$x];
							$arrDato[$fac['SensoresGrupo_'.$x]]['Cuenta'] = 1;
						}
					}
				//si no hay grupo seleccionado
				}else{
					if($fac['SensoresUniMed_'.$x]==$_GET['idUniMed']){
						//verifico si existe
						if(isset($arrDato[$fac['SensoresGrupo_'.$x]]['Valor'])&&$arrDato[$fac['SensoresGrupo_'.$x]]['Valor']!=''){
							$arrDato[$fac['SensoresGrupo_'.$x]]['Valor'] = $arrDato[$fac['SensoresGrupo_'.$x]]['Valor'] + $fac['SensorValue_'.$x];
							$arrDato[$fac['SensoresGrupo_'.$x]]['Cuenta']++;
						//si no lo crea
						}else{
							$arrDato[$fac['SensoresGrupo_'.$x]]['Valor']  = $fac['SensorValue_'.$x];
							$arrDato[$fac['SensoresGrupo_'.$x]]['Cuenta'] = 1;
						}
					}
				}
			}
		}

		//Guardo la fecha
		$Temp_1 .= "'".Fecha_estandar($fac['FechaSistema'])." - ".$fac['HoraSistema']."',";

		//verifico si el grupo existe
		if(isset($_GET['idGrupo'])&&$_GET['idGrupo']!=''){

			/***********************************************/
			//realizo los calculos
			//verifico si hay datos
			if($arrDato[$_GET['idGrupo']]['Cuenta']!=0){
				$New_Dato = $arrDato[$_GET['idGrupo']]['Valor']/$arrDato[$_GET['idGrupo']]['Cuenta'];
			}else{
				$New_Dato = 0;
			}

			/***********************************************/
			//guardo dentro del grupo
			//verifico si existe
			if(isset($arrData[$_GET['idGrupo']]['Value'])&&$arrData[$_GET['idGrupo']]['Value']!=''){
				$arrData[$_GET['idGrupo']]['Value'] .= ", ".$New_Dato;
			//si no lo crea
			}else{
				$arrData[$_GET['idGrupo']]['Value'] = $New_Dato;
			}

			/***********************************************/
			//imprimo tabla
			$m_table .= '
			<tr class="odd">
				<td>'.fecha_estandar($fac['FechaSistema']).'</td>
				<td>'.$fac['HoraSistema'].'</td>
				<td>'.cantidades($New_Dato, 2).' '.$rowUnimed['Nombre'].'</td>
			</tr>';
		}else{

			/***********************************************/
			//imprimo tabla
			$m_table .= '
			<tr class="odd">
				<td>'.fecha_estandar($fac['FechaSistema']).'</td>
				<td>'.$fac['HoraSistema'].'</td>';

			foreach ($arrGrupos as $gru) {

				/***********************************************/
				//realizo los calculos
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
				$m_table .= '<td>'.cantidades($New_Dato, 2).' '.$rowUnimed['Nombre'].'</td>';

			}
			/***********************************************/
			//imprimo tabla
			$m_table .= '</tr>';

		}
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
			//los tipos de linea
			$Graphics_lineDash   .= "'',";
			//los anchos de la linea
			$Graphics_lineWidth  .= "'',";
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


	//si hay mas de 9000 registros
	if(isset($count)&&$count>9000){
		//Se escribe el dato
		echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
			$Alert_Text  = 'La busqueda esta limitada a 10.000 registros, en caso de necesitar mas registros favor comunicarse con el administrador';
			alert_post_data(3,1,1,0, $Alert_Text);
		echo '</div>';
	}
	?>

	<style>
	#loading {display: block;position: absolute;top: 0;left: 0;z-index: 100;width: 100%;height: 100%;background-color: rgba(192, 192, 192, 0.5);background-image: url("<?php echo DB_SITE_REPO.'/LIB_assets/img/loader.gif'; ?>");background-repeat: no-repeat;background-position: center;}
	</style>
	<div id="loading"></div>
	<script>
	//oculto el loader
	document.getElementById("loading").style.display = "none";
	</script>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Comparacion Grupos Sensores', $_SESSION['usuario']['basic_data']['RazonSocial'], 'Informe del equipo '.$rowEquipo['NombreEquipo']); ?>
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 clearfix">
			<a target="new" href="<?php echo 'informe_backup_telemetria_registro_sensores_16_to_excel.php?bla=bla'.$search ; ?>" class="btn btn-sm btn-metis-2 pull-right margin_width"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Exportar a Excel</a>

			<?php if(isset($_GET['idGrafico'])&&$_GET['idGrafico']==1){ ?>
				<input class="btn btn-sm btn-metis-3 pull-right margin_width fa-input" type="button" onclick="Export()" value="&#xf1c1; Exportar a PDF"/>
			<?php }else{ ?>
				<a target="new" href="<?php echo 'informe_backup_telemetria_registro_sensores_16_to_pdf.php?bla=bla'.$search ; ?>" class="btn btn-sm btn-metis-3 pull-right margin_width"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Exportar a PDF</a>
			<?php } ?>

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
					if(isset($rowUnimed['Nombre'])&&$rowUnimed['Nombre']!=''){$uni = $rowUnimed['Nombre'];}else{$uni = 'Consumo';}
					$gr_tittle = 'Grafico ('.$uni.')';
					$gr_unimed = $uni;

					echo GraphLinear_1('graphLinear_1', $gr_tittle, 'Fecha', $gr_unimed, $Graphics_xData, $Graphics_yData, $Graphics_names, $Graphics_types, $Graphics_texts, $Graphics_lineColors, $Graphics_lineDash, $Graphics_lineWidth, 0); ?>

				</div>
			</div>
		</div>

		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="display: none;">

			<form method="post" id="make_pdf" action="informe_backup_telemetria_registro_sensores_16_to_pdf.php">
				<input type="hidden" name="img_adj" id="img_adj" />

				<input type="hidden" name="idSistema"     id="idSistema"    value="<?php echo $_SESSION['usuario']['basic_data']['idSistema']; ?>" />
				<input type="hidden" name="f_inicio"      id="f_inicio"     value="<?php echo $_GET['f_inicio']; ?>" />
				<input type="hidden" name="f_termino"     id="f_termino"    value="<?php echo $_GET['f_termino']; ?>" />
				<input type="hidden" name="idTelemetria"  id="idTelemetria" value="<?php echo $_GET['idTelemetria']; ?>" />
				<input type="hidden" name="idUniMed"      id="idUniMed"     value="<?php echo $_GET['idUniMed']; ?>" />

				<?php if(isset($_GET['idGrupo'])&&$_GET['idGrupo']!=''){ ?>     <input type="hidden" name="idGrupo"    id="idGrupo"   value="<?php echo $_GET['idGrupo']; ?>" /><?php } ?>
				<?php if(isset($_GET['h_inicio'])&&$_GET['h_inicio']!=''){ ?>   <input type="hidden" name="h_inicio"   id="h_inicio"  value="<?php echo $_GET['h_inicio']; ?>" /><?php } ?>
				<?php if(isset($_GET['h_termino'])&&$_GET['h_termino']!=''){ ?> <input type="hidden" name="h_termino"  id="h_termino" value="<?php echo $_GET['h_termino']; ?>" /><?php } ?>

				<button type="button" name="create_pdf" id="create_pdf" class="btn btn-danger btn-xs">Hacer PDF</button>

			</form>

			<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIB_assets/js/dom-to-image.min.js"></script>
			<script>
				var node = document.getElementById('graphLinear_1');

				function sendDatatoSRV(img) {
					$('#img_adj').val(img);
					//$('#img_adj').val($('#img-out').html());
					$('#make_pdf').submit();
					//oculto el loader
					document.getElementById("loading").style.display = "none";
				}
				function Export() {
					//muestro el loader
					document.getElementById("loading").style.display = "block";
					//Exporto
					setTimeout(
						function(){
							domtoimage.toPng(node)
							.then(function (dataUrl) {
								var img = new Image();
								img.src = dataUrl;
								//document.getElementById('img-out').appendChild(img);
								//alert(img.src);
								sendDatatoSRV(img.src);
							})
							.catch(function (error) {
								console.error('oops, something went wrong!', error);
								Swal.fire({icon: 'error',title: 'Oops...',text: 'No se puede exportar!'});
								document.getElementById("loading").style.display = "none";
							});
						}
					, 3000);
				}

			</script>
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
							<?php foreach ($arrGrupos as $gru) { ?>
								<th><?php echo $gru['Nombre']; ?></th>
							<?php } ?>
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
//Verifico el tipo de usuario que esta ingresando
if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
	$z .= " AND usuarios_equipos_telemetria.idUsuario = ".$_SESSION['usuario']['basic_data']['idUsuario'];
}
//Solo para plataforma 1tek
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
				if(isset($idUniMed)){      $x9  = $idUniMed;     }else{$x9  = '';}

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
				$Form_Inputs->form_select('Unidad de Medida','idUniMed', $x9, 2, 'idUniMed', 'Nombre', 'telemetria_listado_unidad_medida', 'idUniMed=2 OR idUniMed=3', '', $dbConn);

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
