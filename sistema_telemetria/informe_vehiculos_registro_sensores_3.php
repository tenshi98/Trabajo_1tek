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
$original = "informe_vehiculos_registro_sensores_3.php";
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
if(isset($_GET['idVehiculo'])&&$_GET['idVehiculo']!=''){
	//Se traen todos los registros
	$query = "SELECT 
	vehiculos_listado.Nombre,
	COUNT(vehiculos_listado_tablarelacionada_".$_GET['idVehiculo'].".idTabla) AS Total
	FROM `vehiculos_listado_tablarelacionada_".$_GET['idVehiculo']."`
	LEFT JOIN `vehiculos_listado` ON vehiculos_listado.idVehiculo = vehiculos_listado_tablarelacionada_".$_GET['idVehiculo'].".idVehiculo
	WHERE (vehiculos_listado_tablarelacionada_".$_GET['idVehiculo'].".FechaSistema BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."') ";
	//Consulta
	$resultado = mysqli_query ($dbConn, $query);
	//Si ejecuto correctamente la consulta
	if(!$resultado){
		//Genero numero aleatorio
		$vardata = genera_password(8,'alfanumerico');
						
		//Guardo el error en una variable temporal
		
		
		
						
	}
	$rowData = mysqli_fetch_assoc ($resultado);
	/*****************************************/
	//Se escribe el dato
	$Alert_Text  = 'Total de registros encontrados de '.$rowData['Nombre'].': '.Cantidades($rowData['Total'], 0);
	alert_post_data(1,1,1,0, $Alert_Text);

	$total_files = ceil($rowData['Total']/5000);
	for ($i = 1; $i <= $total_files; $i++) {
		$reg_ini = (5000*$i)-4999;
		$reg_fin = 5000*$i;
		$datosx  = '&idVehiculo='.$_GET['idVehiculo'];
		$datosx .= '&f_inicio='.$_GET['f_inicio'];
		$datosx .= '&f_termino='.$_GET['f_termino'];
		$datosx .= '&num='.$i;

		$Alert_Text  = '<span class="pull-left">Exportar archivo '.$i.' registros del '.Cantidades($reg_ini, 0).' al '.Cantidades($reg_fin, 0).'</span>';
		$Alert_Text .= '<a target="new" href="informe_vehiculos_registro_sensores_3_to_excel.php?bla=bla'.$datosx.'" class="btn btn-sm btn-metis-2 pull-right "><i class="fa fa-file-excel-o" aria-hidden="true"></i> Exportar a Excel</a>';
		$Alert_Text .= '<div class="clearfix"></div>';
		alert_post_data(2,1,1,0, $Alert_Text);
		 
	}
//Si no se slecciono se traen todos los equipos a los cuales tiene permiso
}else{
	//Inicia variable
	$z = "WHERE vehiculos_listado.idVehiculo>0";
	$z.= " AND vehiculos_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
	$datosx  = '&f_inicio='.$_GET['f_inicio'];
	$datosx .= '&f_termino='.$_GET['f_termino'];
	$datosx .= '&idTipoUsuario='.$_SESSION['usuario']['basic_data']['idTipoUsuario'];
	$datosx .= '&idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
	$datosx .= '&idUsuario='.$_SESSION['usuario']['basic_data']['idUsuario'];

	/*********************************************/
	// Se trae un listado con todos los elementos
	$arrEquipos = array();
	$query = "SELECT 
	vehiculos_listado.idVehiculo, 
	vehiculos_listado.Nombre
	FROM `vehiculos_listado`
	".$z."
	ORDER BY idVehiculo ASC ";
	//Consulta
	$resultado = mysqli_query ($dbConn, $query);
	//Si ejecuto correctamente la consulta
	if(!$resultado){
		//Genero numero aleatorio
		$vardata = genera_password(8,'alfanumerico');
						
		//Guardo el error en una variable temporal
		
		
		
						
	}
	while ( $row = mysqli_fetch_assoc ($resultado)){
	array_push( $arrEquipos,$row );
	}
	

	
	/*********************************************/
	$s_max = 0;
	$Alert_Text  = '';

	foreach ($arrEquipos as $equipo) {
		//Se traen todos los registros
		$query = "SELECT 
		COUNT(idTabla) AS Total
		FROM `vehiculos_listado_tablarelacionada_".$equipo['idVehiculo']."`
		WHERE (FechaSistema BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."') ";
		//Consulta
		$resultado = mysqli_query ($dbConn, $query);
		//Si ejecuto correctamente la consulta
		if(!$resultado){
			//Genero numero aleatorio
			$vardata = genera_password(8,'alfanumerico');
							
			//Guardo el error en una variable temporal
			
			
			
							
		}
		$rowData = mysqli_fetch_assoc ($resultado);

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
		$Alert_Text .= '<a target="new" href="informe_vehiculos_registro_sensores_3_to_excel.php?bla=bla'.$datosx.'" class="btn btn-sm btn-metis-2 pull-right "><i class="fa fa-file-excel-o" aria-hidden="true"></i> Exportar a Excel</a>';
		$Alert_Text .= '<div class="clearfix"></div>';
		alert_post_data(2,1,1,0, $Alert_Text);
		 
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
//Verifico el tipo de usuario que esta ingresando
$w="idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
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
				if(isset($idVehiculo)){    $x3  = $idVehiculo;   }else{$x3  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_date('Fecha Inicio','f_inicio', $x1, 2);
				$Form_Inputs->form_date('Fecha Termino','f_termino', $x2, 2);
				$Form_Inputs->form_select_filter('Vehiculo','idVehiculo', $x3, 1, 'idVehiculo', 'Nombre', 'vehiculos_listado', $w, '', $dbConn);

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
