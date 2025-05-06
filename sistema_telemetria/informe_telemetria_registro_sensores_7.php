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
$original = "informe_telemetria_registro_sensores_7.php";
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

             
  
/*********************************************************************************/
//Verifico si se selecciono el equipo
if(isset($_GET['idTelemetria'])&&$_GET['idTelemetria']!=''){
	//Se traen todos los registros
	$SIS_query = 'telemetria_listado.Nombre,
	COUNT(telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.idTabla) AS Total';
	$SIS_join  = 'LEFT JOIN `telemetria_listado` ON telemetria_listado.idTelemetria = telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.idTelemetria';
	$SIS_where = '(telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'].'.FechaSistema BETWEEN "'.$_GET['f_inicio'].'" AND "'.$_GET['f_termino'].'")';
	$rowData = db_select_data (false, $SIS_query, 'telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'], $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	/*****************************************/
	//Se escribe el dato
	$Alert_Text  = 'Total de registros encontrados de '.$rowData['Nombre'].': '.Cantidades($rowData['Total'], 0);
	$Alert_Text .= 'vaya a la transaccion <strong>Administrar - Administrar productos - Tag Datos Comerciales</strong> y';
	$Alert_Text .= 'realice los cambios';
	alert_post_data(1,1,1,0, $Alert_Text);

	$total_files = ceil($rowData['Total']/5000);
	for ($i = 1; $i <= $total_files; $i++) {
		$reg_ini = (5000*$i)-4999;
		$reg_fin = 5000*$i;
		$datosx  = '&idTelemetria='.$_GET['idTelemetria'];
		$datosx .= '&f_inicio='.$_GET['f_inicio'];
		$datosx .= '&f_termino='.$_GET['f_termino'];
		$datosx .= '&num='.$i;

		$Alert_Text  = '<span class="pull-left">Exportar archivo '.$i.' registros del '.Cantidades($reg_ini, 0).' al '.Cantidades($reg_fin, 0).'</span>';
		$Alert_Text .= '<a target="new" href="informe_telemetria_registro_sensores_7_to_excel.php?bla=bla'.$datosx.'" class="btn btn-sm btn-metis-2 pull-right "><i class="fa fa-file-excel-o" aria-hidden="true"></i> Exportar a Excel</a>';
		$Alert_Text .= '<div class="clearfix"></div>';
		alert_post_data(2,1,1,0, $Alert_Text);
		  
	}
//Si no se slecciono se traen todos los equipos a los cuales tiene permiso
}else{
	//Inicia variable
	$SIS_where = "telemetria_listado.idTelemetria>0";
	$SIS_where.= " AND telemetria_listado.id_Geo='1'";
	$SIS_where.= " AND telemetria_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
	$datosx  = '&f_inicio='.$_GET['f_inicio'];
	$datosx .= '&f_termino='.$_GET['f_termino'];
	$datosx .= '&idTipoUsuario='.$_SESSION['usuario']['basic_data']['idTipoUsuario'];
	$datosx .= '&idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
	$datosx .= '&idUsuario='.$_SESSION['usuario']['basic_data']['idUsuario'];

	//Verifico el tipo de usuario que esta ingresando
	$SIS_join  = '';
	if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
		$SIS_join .= " INNER JOIN usuarios_equipos_telemetria ON usuarios_equipos_telemetria.idTelemetria = telemetria_listado.idTelemetria ";
		$SIS_where.= ' AND usuarios_equipos_telemetria.idUsuario='.$_SESSION['usuario']['basic_data']['idUsuario'];
	}

	/*********************************************/
	// Se trae un listado con todos los elementos
	$SIS_query = 'telemetria_listado.idTelemetria,telemetria_listado.Nombre';
	$SIS_order = 'idTelemetria ASC';
	$arrEquipos = array();
	$arrEquipos = db_select_array (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrEquipos');

	/*********************************************/
	$s_max = 0;
	$Alert_Text  = '';
	foreach ($arrEquipos as $equipo) {
		//Se traen todos los registros
		$SIS_query = 'COUNT(idTabla) AS Total';
		$SIS_where = '(FechaSistema BETWEEN "'.$_GET['f_inicio'].'" AND "'.$_GET['f_termino'].'")';
		$rowData = db_select_data (false, $SIS_query, 'telemetria_listado_tablarelacionada_'.$_GET['idTelemetria'], '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

		$Alert_Text .= 'Total de registros encontrados de '.$equipo['Nombre'].': '.Cantidades($rowData['Total'], 0).'<br/>';
		//verifico el valor maximo
		if($s_max<$rowData['Total']){
			$s_max=$rowData['Total'];
		}
	}
	alert_post_data(2,1,1,0, $Alert_Text);
	
	
	/*****************************************/
	//Se escribe el dato
	$total_files = ceil($s_max/5000);
	for ($i = 1; $i <= $total_files; $i++) {
		$reg_ini = (5000*$i)-4999;
		$reg_fin = 5000*$i;

		$datosx .= '&num='.$i;

		$Alert_Text  = '<span class="pull-left">Exportar archivo '.$i.' registros del '.Cantidades($reg_ini, 0).' al '.Cantidades($reg_fin, 0).'</span>';
		$Alert_Text .= '<a target="new" href="informe_telemetria_registro_sensores_7_to_excel.php?bla=bla'.$datosx.'" class="btn btn-sm btn-metis-2 pull-right "><i class="fa fa-file-excel-o" aria-hidden="true"></i> Exportar a Excel</a>';
		$Alert_Text .= '<div class="clearfix"></div>';
		alert_post_data(4,1,1,0, $Alert_Text);
		  
	}

}

?>






<div class="clearfix"></div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
	<a href="<?php echo $location ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
	<div class="clearfix"></div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
//Filtro de Búsqueda
$z  = "telemetria_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];   //Sistema
$z .= " AND telemetria_listado.id_Geo=1";                                                //Geolocalizacion activa
//Verifico el tipo de usuario que esta ingresando
if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
	$z .= " AND usuarios_equipos_telemetria.idUsuario = ".$_SESSION['usuario']['basic_data']['idUsuario'];
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
				if(isset($f_inicio)){      $x1  = $f_inicio;     }else{$x1  = '';}
				if(isset($f_termino)){     $x2  = $f_termino;    }else{$x2  = '';}
				if(isset($idTelemetria)){  $x3  = $idTelemetria; }else{$x3  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_date('Fecha Inicio','f_inicio', $x1, 2);
				$Form_Inputs->form_date('Fecha Termino','f_termino', $x2, 2);
				//Verifico el tipo de usuario que esta ingresando
				if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
					$Form_Inputs->form_select_filter('Equipo','idTelemetria', $x3, 1, 'idTelemetria', 'Nombre', 'telemetria_listado', $z, '', $dbConn);
				}else{
					$Form_Inputs->form_select_join_filter('Equipo','idTelemetria', $x3, 1, 'idTelemetria', 'Nombre', 'telemetria_listado', 'usuarios_equipos_telemetria', $z, $dbConn);
				}
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
