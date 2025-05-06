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
$original = "informe_vehiculos_registro_kilometraje.php";
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
if(isset($_GET['f_inicio'], $_GET['f_termino'], $_GET['h_inicio'], $_GET['h_termino'])&&$_GET['f_inicio']!=''&&$_GET['f_termino']!=''&&$_GET['h_inicio']!=''&&$_GET['h_termino']!=''){
	$SIS_where.="(TimeStamp BETWEEN '".$_GET['f_inicio']." ".$_GET['h_inicio']."' AND '".$_GET['f_termino']." ".$_GET['h_termino']."')";
}elseif(isset($_GET['f_inicio'], $_GET['f_termino'])&&$_GET['f_inicio']!=''&&$_GET['f_termino']!=''){
	$SIS_where.="(FechaSistema BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."')";
}
//verifico el numero de datos antes de hacer la consulta
$ndata_1 = db_select_nrows (false, 'idTabla', 'vehiculos_listado_tablarelacionada_'.$_GET['idVehiculo'], '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'ndata_1');

//si el dato es superior a 10.000
if(isset($ndata_1)&&$ndata_1>=10001){
	alert_post_data(4,1,1,0, 'Estas tratando de seleccionar mas de 10.000 datos, trata con un rango inferior para poder mostrar resultados');
}else{
	//obtengo la cantidad real de sensores
	$rowEquipo = db_select_data (false, 'Nombre AS NombreEquipo', 'vehiculos_listado', '', 'idVehiculo='.$_GET['idVehiculo'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowEquipo');

	//se consulta
	$SIS_query = 'idTabla,FechaSistema,HoraSistema,GeoVelocidad,GeoMovimiento';
	$SIS_join  = '';
	$SIS_order = 'FechaSistema ASC LIMIT 10000';
	$arrEquipos = array();
	$arrEquipos = db_select_array (false, $SIS_query, 'telemetria_listado_tablarelacionada_'.$_GET['idVehiculo'],  $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrEquipos');

	//cuento la cantidad de registros obtenidos
	$Kilometros = 0;
	foreach ($arrEquipos as $fac) {
		$Kilometros = $Kilometros + $fac['GeoMovimiento'];
	}

	//variable vacia
	$arrData  = array();
	//recorro los datos del equipo
	foreach ($arrEquipos as $rutas) {
		//titulos
		$arrData['Name'] = "'Medicion'";
		//fechas
		if(isset($arrData['Fecha'])&&$arrData['Fecha']!=''){$arrData['Fecha'] .= ",'".Fecha_estandar($rutas['FechaSistema'])." ".$rutas['HoraSistema']."'"; }else{ $arrData['Fecha'] = "'".Fecha_estandar($rutas['FechaSistema'])." ".$rutas['HoraSistema']."'"; }
		//datos
		if(isset($arrData['Value'])&&$arrData['Value']!=''){$arrData['Value'] .= ", ".$rutas['GeoMovimiento'];  }else{ $arrData['Value'] = $rutas['GeoMovimiento'];}

	}
	/******************************************/
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
	if(isset($arrData['Value'])&&$arrData['Value']!=''){
		//las fechas
		$Graphics_xData      .='['.$arrData['Fecha'].'],';
		//los valores
		$Graphics_yData      .='['.$arrData['Value'].'],';
		//los nombres
		$Graphics_names      .= $arrData['Name'].',';
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
	$Graphics_xData      .= '];';
	$Graphics_yData      .= '];';
	$Graphics_names      .= '];';
	$Graphics_types      .= '];';
	$Graphics_texts      .= '];';
	$Graphics_lineColors .= '];';
	$Graphics_lineDash   .= '];';
	$Graphics_lineWidth  .= '];';

?>

	<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
		<div class="box box-blue box-solid">
			<div class="box-header with-border">
				<h3 class="box-title">Kilometros Recorridos</h3>
			</div>
			<div class="box-body">
				<div class="value">
					<span><i class="fa fa-tachometer" aria-hidden="true"></i></span>
					<span><?php echo Cantidades($Kilometros, 2) ?></span>
					Kilometros
				</div>
			</div>
		</div>
	</div>

	<div class="clearfix"></div>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
				<h5> Graficos </h5>
			</header>
			<div class="table-responsive">
				<?php
				$gr_tittle = 'Informe Kilometros Recorridos equipo '.$rowEquipo['NombreEquipo'];
				echo GraphLinear_1('graphLinear_1', $gr_tittle, 'Fecha', 'KM', $Graphics_xData, $Graphics_yData, $Graphics_names, $Graphics_types, $Graphics_texts, $Graphics_lineColors, $Graphics_lineDash, $Graphics_lineWidth, 0);
				?>
			</div>
		</div>
	</div>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
				<h5>Informe Kilometros Recorridos equipo <?php echo $rowEquipo['NombreEquipo']; ?></h5>
			</header>
			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
							<th>Fecha</th>
							<th>Hora</th>
							<th>Velocidad</th>
							<th>Kilometros Recorridos</th>
							<th>Ubicación</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php foreach ($arrEquipos as $rutas) { ?>
							<tr class="odd">
								<td><?php echo $rutas['FechaSistema']; ?></td>
								<td><?php echo $rutas['HoraSistema'].' hrs'; ?></td>
								<td><?php echo Cantidades($rutas['GeoVelocidad'], 4).' KM/h'; ?></td>
								<td><?php echo Cantidades($rutas['GeoMovimiento'], 4).' KM'; ?></td>
								<td>
									<div class="btn-group" style="width: 35px;" >
										<a href="<?php echo 'informe_vehiculos_registro_kilometraje_view.php?idVehiculo='.simpleEncode($_GET['idVehiculo'], fecha_actual()).'&view='.simpleEncode($rutas['idTabla'], fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
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
	<a href="<?php echo $location ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
	<div class="clearfix"></div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
//Verifico el tipo de usuario que esta ingresando
$w="idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
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
				if(isset($idVehiculo)){    $x5  = $idVehiculo;   }else{$x5  = '';}

				//Si es redireccionado desde otra pagina con datos precargados
				if(isset($_GET['view'])&&$_GET['view']!='') { $x5  = $_GET['view'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_date('Fecha Inicio','f_inicio', $x1, 2);
				$Form_Inputs->form_time('Hora Inicio','h_inicio', $x2, 1, 1);
				$Form_Inputs->form_date('Fecha Termino','f_termino', $x3, 2);
				$Form_Inputs->form_time('Hora Termino','h_termino', $x4, 1, 1);
				$Form_Inputs->form_select_filter('Vehiculo','idVehiculo', $x5, 2, 'idVehiculo', 'Nombre', 'vehiculos_listado', $w, '', $dbConn);

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
