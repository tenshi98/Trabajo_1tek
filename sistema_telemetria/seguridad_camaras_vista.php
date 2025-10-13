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
$original = "seguridad_camaras_vista.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['Nombre']) && $_GET['Nombre']!=''){
	$location .= "&Nombre=".$_GET['Nombre'];
	$search .= "&Nombre=".$_GET['Nombre'];  	
}
/********************************************************************/

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
if(!empty($_GET['idCamara'])){
// Se trae el usuario
$query = "SELECT Nombre,idSubconfiguracion, idTipoCamara, Config_usuario, Config_Password,
Config_IP, Config_Puerto, Config_Web
FROM `seguridad_camaras_listado`
WHERE idCamara = ".$_GET['idCamara'];
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
$rowCamara = mysqli_fetch_assoc ($resultado);
             

// Se trae un listado con todos los impuestos existentes
$arrCamaras = array();
$query = "SELECT Nombre,idTipoCamara, Config_usuario, Config_Password,
Config_IP, Config_Puerto, Config_Web, Chanel
FROM `seguridad_camaras_listado_canales`
WHERE idCamara = ".$_GET['idCamara'];
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
						
	//Guardo el error en una variable temporal
	
	
	
						
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrCamaras,$row );
}

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Camaras de Seguridad</h5>
		</header>
		<div class="table-responsive">
			<?php
			//recorro las camaras
			foreach ($arrCamaras as $camara) {
				//canal utilizado
				$SIS_Config_Chanel    = $camara['Chanel'];

				//si existe subconfiguracion
				if(isset($rowCamara['idSubconfiguracion'])&&$rowCamara['idSubconfiguracion']==1){

					//Variables
					$SIS_Config_usuario   = $camara['Config_usuario'];
					$SIS_Config_Password  = $camara['Config_Password'];
					$SIS_Config_IP        = $camara['Config_IP'];
					$SIS_Config_Puerto    = $camara['Config_Puerto'];
					$SIS_TipoCamara       = $camara['idTipoCamara'];

					//se crea la dirección web
					$direccion  = 'http://';
					$direccion .= $SIS_Config_usuario;
					$direccion .= ':'.$SIS_Config_Password;
					$direccion .= '@'.$SIS_Config_IP;
					if(isset($SIS_Config_Puerto)&&$SIS_Config_Puerto!=''){$direccion .= ':'.$SIS_Config_Puerto;}

				//si no existe subconfihuracion
				}elseif(isset($rowCamara['idSubconfiguracion'])&&$rowCamara['idSubconfiguracion']==2){

					//Variables
					$SIS_Config_usuario   = $rowCamara['Config_usuario'];
					$SIS_Config_Password  = $rowCamara['Config_Password'];
					$SIS_Config_IP        = $rowCamara['Config_IP'];
					$SIS_Config_Puerto    = $rowCamara['Config_Puerto'];
					$SIS_TipoCamara       = $rowCamara['idTipoCamara'];

					//se crea la dirección web
					$direccion  = 'http://';
					$direccion .= $SIS_Config_usuario;
					$direccion .= ':'.$SIS_Config_Password;
					$direccion .= '@'.$SIS_Config_IP;
					if(isset($SIS_Config_Puerto)&&$SIS_Config_Puerto!=''){$direccion .= ':'.$SIS_Config_Puerto;}

				}

				/****************************************************/
				//si esta configurado
				if($SIS_Config_usuario!=''&&$SIS_Config_Password!=''&&$SIS_Config_IP!=''){
					//Verifico el tipo de camara
					switch ($SIS_TipoCamara) {
						//Dahua
						case 1:
							echo '<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">';
								echo '<img class="img-thumbnail" name="main" id="main" border="0" width="100%" height="100%" src="'.$direccion.'/cgi-bin/mjpg/video.cgi?channel='.$SIS_Config_Chanel.'&subtype=1">';
							echo '</div>';
							break;
						//otra
						case 2:
							//echo '<img name="main" id="main" border="0" width="640" height="480" >';
							break;
					}
				}else{
					echo '<div class="col-xs-12" style="margin-top:15px;">';
						$Alert_Text = 'La camara compartida del canal '.$SIS_Config_Chanel.' no esta completamente configurada';
						alert_post_data(4,3,1,0, $Alert_Text);
					echo '</div>';
				}
			}
			?>

		</div>
	</div>
</div>

<div class="clearfix"></div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
	<a href="<?php echo $location; ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
	<div class="clearfix"></div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
//Se inicializa el paginador de resultados
//tomo el numero de la pagina si es que este existe
if(isset($_GET['pagina'])){$num_pag = $_GET['pagina'];} else {$num_pag = 1;}
//Defino la cantidad total de elementos por pagina
$cant_reg = 30;
//resto de variables
if (!$num_pag){$comienzo = 0;$num_pag = 1;} else {$comienzo = ( $num_pag - 1 ) * $cant_reg ;}
/**********************************************************/
//ordenamiento
if(isset($_GET['order_by'])&&$_GET['order_by']!=''){
	switch ($_GET['order_by']) {
		case 'camara_asc':    $order_by = 'seguridad_camaras_listado.Nombre ASC ';    $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Camara Ascendente';break;
		case 'camara_desc':   $order_by = 'seguridad_camaras_listado.Nombre DESC ';   $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Camara Descendente';break;

		default: $order_by = 'seguridad_camaras_listado.Nombre ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Camara Ascendente';
	}
}else{
	$order_by = 'seguridad_camaras_listado.Nombre ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Camara Ascendente';
}
/**********************************************************/
//Variable con la ubicacion
$SIS_where  = "seguridad_camaras_listado.idCamara!=0";
$SIS_where .= " AND seguridad_camaras_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
$SIS_where .= " AND seguridad_camaras_listado.idEstado=1";//activo
$SIS_join   = "";
//Verifico el tipo de usuario que esta ingresando
if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
	$SIS_where.= " AND usuarios_camaras.idUsuario = ".$_SESSION['usuario']['basic_data']['idUsuario'];
	$SIS_join .= " INNER JOIN `usuarios_camaras` ON usuarios_camaras.idCamara = seguridad_camaras_listado.idCamara";
}
$SIS_where .= " GROUP BY seguridad_camaras_listado.idCamara";				
/**********************************************************/
//Realizo una consulta para saber el total de elementos existentes
$cuenta_registros = db_select_nrows (false, 'seguridad_camaras_listado.idCamara', 'seguridad_camaras_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
//Realizo la operacion para saber la cantidad de paginas que hay
$total_paginas = ceil($cuenta_registros / $cant_reg);
// Se trae un listado con todos los elementos
$SIS_query = '
seguridad_camaras_listado.idCamara,
seguridad_camaras_listado.Nombre,
core_sistemas.Nombre AS RazonSocial';
$SIS_join .= ' LEFT JOIN `core_sistemas` ON core_sistemas.idSistema = seguridad_camaras_listado.idSistema';
$SIS_order = $order_by.' LIMIT '.$comienzo.', '.$cant_reg;
$arrTipo = array();
$arrTipo = db_select_array (false, $SIS_query, 'seguridad_camaras_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTipo');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar">

	<ul class="btn-group btn-breadcrumb pull-left">
		<li class="btn btn-default"><i class="fa fa-search" aria-hidden="true"></i></li>
		<li class="btn btn-default"><?php echo $bread_order; ?></li>
	</ul>

</div>
<div class="clearfix"></div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Grupos de Camaras</h5>
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
						<th>
							<div class="pull-left">Camara</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=camara_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=camara_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><th width="160">Sistema</th><?php } ?>
						<th width="10">Acciones</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrTipo as $tipo) { ?>
					<tr class="odd">
						<td><?php echo $tipo['Nombre']; ?></td>
						<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><td><?php echo $tipo['RazonSocial']; ?></td><?php } ?>
						<td>
							<div class="btn-group" style="width: 35px;" >
								<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo $location.'&idCamara='.$tipo['idCamara']; ?>" title="Ver Camara" class="btn btn-primary btn-sm tooltip"><i class="fa fa-video-camera" aria-hidden="true"></i></a><?php } ?>
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
