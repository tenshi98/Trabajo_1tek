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
$original = "informe_busqueda_general_01.php";
$location = $original;
//Se agregan ubicaciones
$search ='&submit_filter=Filtrar';
if(isset($_GET['idOcompra'])&&$_GET['idOcompra']!=''){ $search .="&idOcompra=".$_GET['idOcompra'];}
if(isset($_GET['idDocumentos'])&&$_GET['idDocumentos']!=''){  $search .="&idDocumentos=".$_GET['idDocumentos'];}
if(isset($_GET['N_Doc'])&&$_GET['N_Doc']!=''){         $search .="&N_Doc=".$_GET['N_Doc'];}
if(isset($_GET['type'])&&$_GET['type']!=''){           $search .="&type=".$_GET['type'];}
					    
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
	
/***********************************************************************************/
//Si se esta buscando desde una OC
if(isset($_GET['type'])&&$_GET['type']!=''&&$_GET['type']==1){
	
	echo widget_Doc_relacionados($_GET['idOcompra'],
							$_SESSION['usuario']['basic_data']['idTipoUsuario'],$_SESSION['usuario']['basic_data']['idSistema'], 
							$dbConn);

/***********************************************************************************/
//Si se busca desde una factura	
}elseif(isset($_GET['type'])&&$_GET['type']!=''&&$_GET['type']==2){

	//variables
	$z0 = " WHERE ocompra_listado.idOcompra!=0";
	$z1 = " WHERE bodegas_insumos_facturacion.idFacturacion!=0";
	$z2 = " WHERE bodegas_productos_facturacion.idFacturacion!=0";
	$z3 = " WHERE bodegas_arriendos_facturacion.idFacturacion!=0";
	$z4 = " WHERE bodegas_servicios_facturacion.idFacturacion!=0";
	//filtros
	if(isset($_GET['idDocumentos'])&&$_GET['idDocumentos']!=''){
		$z1.=" AND bodegas_insumos_facturacion.idDocumentos=".$_GET['idDocumentos'];
		$z2.=" AND bodegas_productos_facturacion.idDocumentos=".$_GET['idDocumentos'];
		$z3.=" AND bodegas_arriendos_facturacion.idDocumentos=".$_GET['idDocumentos'];
		$z4.=" AND bodegas_servicios_facturacion.idDocumentos=".$_GET['idDocumentos'];
	}
	if(isset($_GET['N_Doc'])&&$_GET['N_Doc']!=''){       
		$z1.=" AND bodegas_insumos_facturacion.N_Doc=".$_GET['N_Doc'];
		$z2.=" AND bodegas_productos_facturacion.N_Doc=".$_GET['N_Doc'];
		$z3.=" AND bodegas_arriendos_facturacion.N_Doc=".$_GET['N_Doc'];
		$z4.=" AND bodegas_servicios_facturacion.N_Doc=".$_GET['N_Doc'];
	}
	if(isset($_GET['idProveedor'])&&$_GET['idProveedor']!=''){  
		$z0.=" AND ocompra_listado.idProveedor=".$_GET['idProveedor'];
		$z1.=" AND bodegas_insumos_facturacion.idProveedor=".$_GET['idProveedor'];
		$z2.=" AND bodegas_productos_facturacion.idProveedor=".$_GET['idProveedor'];
		$z3.=" AND bodegas_arriendos_facturacion.idProveedor=".$_GET['idProveedor'];
		$z4.=" AND bodegas_servicios_facturacion.idProveedor=".$_GET['idProveedor'];
	}
	/*************************************************************/
	/******************************************************/
	// Se trae un listado con todos los elementos
	$arrInsumos = array();
	$query = "SELECT  idOcompra FROM `bodegas_insumos_facturacion` ".$z1;
	//Consulta
	$resultado = mysqli_query ($dbConn, $query);
	//Si ejecuto correctamente la consulta
	if(!$resultado){
		//Genero numero aleatorio
		$vardata = genera_password(8,'alfanumerico');
						
		//Guardo el error en una variable temporal
		
		
		
						
	}
	while ( $row = mysqli_fetch_assoc ($resultado)){
	array_push( $arrInsumos,$row );
	}
	/******************************************************/
	// Se trae un listado con todos los elementos
	$arrProductos = array();
	$query = "SELECT idOcompra FROM `bodegas_productos_facturacion` ".$z2;
	//Consulta
	$resultado = mysqli_query ($dbConn, $query);
	//Si ejecuto correctamente la consulta
	if(!$resultado){
		//Genero numero aleatorio
		$vardata = genera_password(8,'alfanumerico');
						
		//Guardo el error en una variable temporal
		
		
		
						
	}
	while ( $row = mysqli_fetch_assoc ($resultado)){
	array_push( $arrProductos,$row );
	}
	/******************************************************/
	// Se trae un listado con todos los elementos
	$arrArriendos = array();
	$query = "SELECT idOcompra FROM `bodegas_arriendos_facturacion` ".$z3;
	//Consulta
	$resultado = mysqli_query ($dbConn, $query);
	//Si ejecuto correctamente la consulta
	if(!$resultado){
		//Genero numero aleatorio
		$vardata = genera_password(8,'alfanumerico');
						
		//Guardo el error en una variable temporal
		
		
		
						
	}
	while ( $row = mysqli_fetch_assoc ($resultado)){
	array_push( $arrArriendos,$row );
	}
	/******************************************************/
	// Se trae un listado con todos los elementos
	$arrServicios = array();
	$query = "SELECT idOcompra FROM `bodegas_servicios_facturacion` ".$z4;
	//Consulta
	$resultado = mysqli_query ($dbConn, $query);
	//Si ejecuto correctamente la consulta
	if(!$resultado){
		//Genero numero aleatorio
		$vardata = genera_password(8,'alfanumerico');
						
		//Guardo el error en una variable temporal
		
		
		
						
	}
	while ( $row = mysqli_fetch_assoc ($resultado)){
	array_push( $arrServicios,$row );
	}
	/******************************************************************************/
	//Se buscan las OC relacionadas en base a las fac
	$noc = 0;
	foreach ($arrInsumos as $tipo) {
		if(isset($tipo['idOcompra'])&&$tipo['idOcompra']!=''){
			$noc = $tipo['idOcompra'];
		}
	}
	foreach ($arrProductos as $tipo) {
		if(isset($tipo['idOcompra'])&&$tipo['idOcompra']!=''){
			$noc = $tipo['idOcompra'];
		}
	}
	foreach ($arrArriendos as $tipo) {
		if(isset($tipo['idOcompra'])&&$tipo['idOcompra']!=''){
			$noc = $tipo['idOcompra'];
		}
	}
	foreach ($arrServicios as $tipo) {
		if(isset($tipo['idOcompra'])&&$tipo['idOcompra']!=''){
			$noc = $tipo['idOcompra'];
		}
	}
	//Se escriben los datos
	if($noc!=0){
		
		echo widget_Doc_relacionados($noc,
							$_SESSION['usuario']['basic_data']['idTipoUsuario'],$_SESSION['usuario']['basic_data']['idSistema'], 
							$dbConn);
	}

}

?>


  
<div class="clearfix"></div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
<a href="<?php echo $original; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
<div class="clearfix"></div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
//Verifico el tipo de usuario que esta ingresando
$z = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];

?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Filtro de Búsqueda</h5>
			<ul class="nav nav-tabs pull-right">
				<li class="active"><a href="#tab_1" data-toggle="tab"><i class="fa fa-search" aria-hidden="true"></i> Por OC</a></li>
				<li class=""><a href="#tab_2" data-toggle="tab"><i class="fa fa-search" aria-hidden="true"></i> Por Facturas</a></li>

			</ul>
		</header>
		<div class="body">
			<div class="tab-content">

				<?php
				//Se verifican si existen los datos
				if(isset($idOcompra)){      $x1  = $idOcompra;      }else{$x1  = '';}
				if(isset($idDocumentos)){   $x2  = $idDocumentos;   }else{$x2  = '';}
				if(isset($N_Doc)){          $x3  = $N_Doc;          }else{$x3  = '';}
				if(isset($idProveedor)){    $x4  = $idProveedor;    }else{$x4  = '';}

				$Form_Inputs = new Form_Inputs();
				?>

				<div class="tab-pane fade active in" id="tab_1">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" autocomplete="off" novalidate>
							<?php
							$Form_Inputs->form_tittle(3, 'Ordenes de Compra');
							$Form_Inputs->form_input_number('N° OC', 'idOcompra', $x1, 2);

							$Form_Inputs->form_input_hidden('type', 1, 2);
							?>
							<div class="form-group">
								<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf002; Filtrar" name="submit_filter">
							</div>
						</form>
					</div>
				</div>

				<div class="tab-pane fade" id="tab_2">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<form class="form-horizontal" id="form2" name="form1" action="<?php echo $location; ?>" novalidate>
							<?php
							$Form_Inputs->form_tittle(3, 'Facturas');
							$Form_Inputs->form_select_filter('Proveedor','idProveedor', $x4, 2, 'idProveedor', 'Nombre', 'proveedor_listado', $z, '', $dbConn);
							$Form_Inputs->form_select('Tipo Documento','idDocumentos', $x2, 2, 'idDocumentos', 'Nombre', 'core_documentos_mercantiles', 0, '', $dbConn);
							$Form_Inputs->form_input_number('N° Documento', 'N_Doc', $x3, 2);

							$Form_Inputs->form_input_hidden('type', 2, 2);
							?>
							<div class="form-group">
								<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf002; Filtrar" name="submit_filter">
							</div>
						</form>		
					</div>
				</div>
				<?php widget_validator(); ?>
				
				
				
            </div>      
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
