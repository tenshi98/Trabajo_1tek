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
$original = "mantencion_backup.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['Nombre']) && $_GET['Nombre']!=''){	$location .= "&Nombre=".$_GET['Nombre'];	$search .= "&Nombre=".$_GET['Nombre'];}
/********************************************************************/

//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//se hace la mantencion
if (!empty($_GET['backup'])){

	function __backup_mysql_database($params,$location,$dbConn){

		//time limit execution
		set_time_limit(36000);

		$mtables = array(); $contents = "-- Database: `".$params['db_to_backup']."` --\n";

		$mysqli = new mysqli($params['db_host'], $params['db_uname'], $params['db_password'], $params['db_to_backup']);
		if ($mysqli->connect_error) {
			die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
		}

		$results = $mysqli->query("SHOW TABLES");

		while($row = $results->fetch_array()){
			if (!in_array($row[0], $params['db_exclude_tables'])){
				$mtables[] = $row[0];
			}
		}

		foreach($mtables as $table){
			$contents .= "-- Table `".$table."` --\n";

			$results = $mysqli->query("SHOW CREATE TABLE ".$table);
			while($row = $results->fetch_array()){
				$contents .= $row[1].";\n\n";
			}

			$results = $mysqli->query("SELECT * FROM ".$table);
			$row_count = $results->num_rows;
			$fields = $results->fetch_fields();
			$fields_count = count($fields);

			$insert_head = "INSERT INTO `".$table."` (";
			for($i=0; $i < $fields_count; $i++){
				$insert_head  .= "`".$fields[$i]->name."`";
					if($i < $fields_count-1){
							$insert_head  .= ', ';
						}
			}
			$insert_head .=  ")";
			$insert_head .= " VALUES\n";

			if($row_count>0){
				$r = 0;
				while($row = $results->fetch_array()){
					if(($r % 400)  == 0){
						$contents .= $insert_head;
					}
					$contents .= "(";
					for($i=0; $i < $fields_count; $i++){
						$row_content =  str_replace("\n","\\n",$mysqli->real_escape_string($row[$i]));

						switch($fields[$i]->type){
							case 8: case 3:
								$contents .=  $row_content;
								break;
							default:
								$contents .= "'". $row_content ."'";
						}
						if($i < $fields_count-1){
								$contents  .= ', ';
							}
					}
					if(($r+1) == $row_count || ($r % 400) == 399){
						$contents .= ");\n\n";
					}else{
						$contents .= "),\n";
					}
					$r++;
				}
			}
		}

		if (!is_dir ( $params['db_backup_path'] )){
			mkdir ( $params['db_backup_path'], 0777, true );
		}

		//variables
		$Fecha     = fecha_actual();
		$Hora      = hora_actual_val();
		$Hora2     = hora_actual();
		$Nombre    = 'Respaldo del '.$Fecha.' a las '.$Hora.' hrs';
		$FileName  = 'sql-backup-'.$Fecha.'--'.$Hora.'.sql';

		//$backup_file_name = "sql-backup-".date( "d-m-Y--h-i-s").".sql";

		$fp = fopen($params['db_backup_path'].$FileName ,'w+');
		if (($result = fwrite($fp, $contents))){
			//echo "Backup file created '--$backup_file_name' ($result)";
		}
		fclose($fp);

		//Se guarda el registro en la ba
		$a  = "'".$Nombre."'";
		$a .= ",'".$FileName."'";
		$a .= ",'".$Fecha."'";
		$a .= ",'".$Hora2."'";

		// inserto los datos de registro en la db
		$query  = "INSERT INTO `mantencion_backup` (Nombre,FileName, Fecha, Hora) VALUES (".$a.")";
		//Consulta
		$resultado = mysqli_query ($dbConn, $query);
		//Si ejecuto correctamente la consulta
		if(!$resultado){
			//Genero numero aleatorio
			$vardata = genera_password(8,'alfanumerico');

			//Guardo el error en una variable temporal
			
			
			

		}

		header( 'Location: '.$location.'&created=true' );
		die;

	}

	/************************************************************************************/
	$para = array(
		'db_host'=> DB_SERVER,  //mysql host
		'db_uname' => DB_USER,  //user
		'db_password' => DB_PASS, //pass
		'db_to_backup' => DB_NAME, //database name
		'db_backup_path' => dirname(__FILE__).'/backups/', //where to backup
		'db_exclude_tables' => array('mantencion_backup') //tables to exclude
	);
	__backup_mysql_database($para,$location,$dbConn);

}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Respaldo Creado correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Respaldo Modificado correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Respaldo Borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['id'])){
	//valido los permisos
	validaPermisoUser($rowlevel['level'], 2, $dbConn); ?>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
	/**********************************************************/
	//paginador de resultados
	if(isset($_GET['pagina'])){$num_pag = $_GET['pagina'];} else {$num_pag = 1;}
	//Defino la cantidad total de elementos por pagina
	$cant_reg = 30;
	//resto de variables
	if (!$num_pag){$comienzo = 0;$num_pag = 1;} else {$comienzo = ( $num_pag - 1 ) * $cant_reg ;}
	/**********************************************************/
	//ordenamiento
	if(isset($_GET['order_by'])&&$_GET['order_by']!=''){
		switch ($_GET['order_by']) {
			case 'fecha_asc':    $order_by = 'Fecha ASC ';    $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha Ascendente'; break;
			case 'fecha_desc':   $order_by = 'Fecha DESC ';   $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha Descendente';break;
			case 'hora_asc':     $order_by = 'Hora ASC ';     $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Hora Ascendente';break;
			case 'hora_desc':    $order_by = 'Hora DESC ';    $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Hora Descendente';break;
			case 'nombre_asc':   $order_by = 'Nombre ASC ';   $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente';break;
			case 'nombre_desc':  $order_by = 'Nombre DESC ';  $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Nombre Descendente';break;

			default: $order_by = 'Fecha DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha Descendente';
		}
	}else{
		$order_by = 'Fecha DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha Descendente';
	}
	/**********************************************************/
	//Variable de busqueda
	$SIS_where = "mantencion_backup.idBackup!=0";
	/**********************************************************/
	//Realizo una consulta para saber el total de elementos existentes
	$cuenta_registros = db_select_nrows (false, 'idBackup', 'mantencion_backup', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
	//Realizo la operacion para saber la cantidad de paginas que hay
	$total_paginas = ceil($cuenta_registros / $cant_reg);
	// Se trae un listado con todos los elementos
	$SIS_query = 'idBackup, Nombre,FileName,Fecha,Hora';
	$SIS_join  = '';
	$SIS_order = $order_by.' LIMIT '.$comienzo.', '.$cant_reg;
	$arrBackup = array();
	$arrBackup = db_select_array (false, $SIS_query, 'mantencion_backup', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrBackup');

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar">

		<ul class="btn-group btn-breadcrumb pull-left">
			<li class="btn btn-default"><i class="fa fa-search" aria-hidden="true"></i></li>
			<li class="btn btn-default"><?php echo $bread_order; ?></li>
		</ul>

		<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $location; ?>&backup=true" class="btn btn-default pull-right margin_width fmrbtn" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Backup</a><?php } ?>

	</div>
	<div class="clearfix"></div>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Backups</h5>
				<div class="toolbar">
					<?php
					//Se llama al paginador
					echo paginador_2('pagsup',$total_paginas, $original, $search, $num_pag ) ?>
				</div>
			</header>
			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
							<th width="120">
								<div class="pull-left">Fecha</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=fecha_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=fecha_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th width="160">
								<div class="pull-left">Hora</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=hora_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=hora_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Nombre</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=nombre_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=nombre_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th width="10">Acciones</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrBackup as $back) { ?>
						<tr class="odd">
							<td><?php echo $back['Fecha']; ?></td>
							<td><?php echo $back['Hora']; ?></td>
							<td><?php echo $back['Nombre']; ?></td>
							<td>
								<div class="btn-group" style="width: 35px;" >
									<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo '1download.php?dir='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($back['FileName'], fecha_actual()); ?>" title="Descargar Backup" class="btn btn-primary btn-sm tooltip"><i class="fa fa-download" aria-hidden="true"></i></a><?php } ?>
								</div>
							</td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
			</div>
			<div class="pagrow">
				<?php
				//se llama al paginador
				echo paginador_2('paginf',$total_paginas, $original, $search, $num_pag ) ?>
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
