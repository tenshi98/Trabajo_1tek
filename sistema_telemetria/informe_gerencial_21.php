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
$original = "informe_gerencial_21.php";
$location = $original;
//Se agregan ubicaciones
$location .='?submit_filter=Filtrar';			
       
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
//Solo compras pagadas totalmente
$z1 = "WHERE bodegas_arriendos_facturacion.idTipo=1"; //solo ventas
$z2 = "WHERE bodegas_insumos_facturacion.idTipo=1";   //solo ventas
$z3 = "WHERE bodegas_productos_facturacion.idTipo=1"; //solo ventas
$z4 = "WHERE bodegas_servicios_facturacion.idTipo=1"; //solo ventas
//sololas del mismo sistema
$z1.=" AND bodegas_arriendos_facturacion.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
$z2.=" AND bodegas_insumos_facturacion.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
$z3.=" AND bodegas_productos_facturacion.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
$z4.=" AND bodegas_servicios_facturacion.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
//variable
$search = '';
if(isset($_GET['idProveedor'])&&$_GET['idProveedor']!=''){
	$z1.=" AND bodegas_arriendos_facturacion.idProveedor=".$_GET['idProveedor'];
	$z2.=" AND bodegas_insumos_facturacion.idProveedor=".$_GET['idProveedor'];
	$z3.=" AND bodegas_productos_facturacion.idProveedor=".$_GET['idProveedor'];
	$z4.=" AND bodegas_servicios_facturacion.idProveedor=".$_GET['idProveedor'];
	$location .="&idProveedor=".$_GET['idProveedor'];
	$search .="&idProveedor=".$_GET['idProveedor'];
}
if(isset($_GET['idEstado'])&&$_GET['idEstado']!=''){
	$z1.=" AND bodegas_arriendos_facturacion.idEstado=".$_GET['idEstado'];
	$z2.=" AND bodegas_insumos_facturacion.idEstado=".$_GET['idEstado'];
	$z3.=" AND bodegas_productos_facturacion.idEstado=".$_GET['idEstado'];
	$z4.=" AND bodegas_servicios_facturacion.idEstado=".$_GET['idEstado'];
	$location .="&idEstado=".$_GET['idEstado'];
	$search .="&idEstado=".$_GET['idEstado'];
}
if(isset($_GET['f_inicio'], $_GET['f_termino'])&&$_GET['f_inicio']!=''&&$_GET['f_termino']!=''){
	$z1.=" AND bodegas_arriendos_facturacion.Creacion_fecha BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."'";
	$z2.=" AND bodegas_insumos_facturacion.Creacion_fecha BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."'";
	$z3.=" AND bodegas_productos_facturacion.Creacion_fecha BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."'";
	$z4.=" AND bodegas_servicios_facturacion.Creacion_fecha BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."'";
	$location .="&f_inicio=".$_GET['f_inicio'];
	$location .="&f_termino=".$_GET['f_termino'];
	$search .="&f_inicio=".$_GET['f_inicio'];
	$search .="&f_termino=".$_GET['f_termino'];
}


					
/*************************************************************************************************/
//Bodega de Arriendos
$arrTemporal_1 = array();
$query = "SELECT 
bodegas_arriendos_facturacion.idProveedor,
proveedor_listado.Nombre AS ProveedorNombre,
bodegas_arriendos_facturacion.Creacion_mes,
bodegas_arriendos_facturacion.Creacion_fecha,
bodegas_arriendos_facturacion.Creacion_Semana,
bodegas_arriendos_facturacion.Creacion_ano,
SUM(bodegas_arriendos_facturacion.ValorNetoImp) AS ValorNeto,
SUM(bodegas_arriendos_facturacion.ValorTotal) AS ValorTotal

FROM `bodegas_arriendos_facturacion`
LEFT JOIN `proveedor_listado`    ON proveedor_listado.idProveedor   = bodegas_arriendos_facturacion.idProveedor
".$z1."
GROUP BY bodegas_arriendos_facturacion.idProveedor";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrTemporal_1,$row );
}
/*************************************************************************************************/
//Bodega de Insumos
$arrTemporal_2 = array();
$query = "SELECT 
bodegas_insumos_facturacion.idProveedor,
proveedor_listado.Nombre AS ProveedorNombre,
bodegas_insumos_facturacion.Creacion_mes,
bodegas_insumos_facturacion.Creacion_fecha,
bodegas_insumos_facturacion.Creacion_Semana,
bodegas_insumos_facturacion.Creacion_ano,
SUM(bodegas_insumos_facturacion.ValorNetoImp) AS ValorNeto,
SUM(bodegas_insumos_facturacion.ValorTotal) AS ValorTotal

FROM `bodegas_insumos_facturacion`
LEFT JOIN `proveedor_listado`    ON proveedor_listado.idProveedor   = bodegas_insumos_facturacion.idProveedor
".$z2."
GROUP BY bodegas_insumos_facturacion.idProveedor";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrTemporal_2,$row );
}
/*************************************************************************************************/
//Bodega de Productos
$arrTemporal_3 = array();
$query = "SELECT 
bodegas_productos_facturacion.idProveedor,
proveedor_listado.Nombre AS ProveedorNombre,
bodegas_productos_facturacion.Creacion_mes,
bodegas_productos_facturacion.Creacion_fecha,
bodegas_productos_facturacion.Creacion_Semana,
bodegas_productos_facturacion.Creacion_ano,
SUM(bodegas_productos_facturacion.ValorNetoImp) AS ValorNeto,
SUM(bodegas_productos_facturacion.ValorTotal) AS ValorTotal

FROM `bodegas_productos_facturacion`
LEFT JOIN `proveedor_listado`    ON proveedor_listado.idProveedor   = bodegas_productos_facturacion.idProveedor
".$z3."
GROUP BY bodegas_productos_facturacion.idProveedor";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrTemporal_3,$row );
}
/*************************************************************************************************/
//Bodega de Servicios
$arrTemporal_4 = array();
$query = "SELECT 
bodegas_servicios_facturacion.idProveedor,
proveedor_listado.Nombre AS ProveedorNombre,
bodegas_servicios_facturacion.Creacion_mes,
bodegas_servicios_facturacion.Creacion_fecha,
bodegas_servicios_facturacion.Creacion_Semana,
bodegas_servicios_facturacion.Creacion_ano,
SUM(bodegas_servicios_facturacion.ValorNetoImp) AS ValorNeto,
SUM(bodegas_servicios_facturacion.ValorTotal) AS ValorTotal

FROM `bodegas_servicios_facturacion`
LEFT JOIN `proveedor_listado`    ON proveedor_listado.idProveedor   = bodegas_servicios_facturacion.idProveedor
".$z4."
GROUP BY bodegas_servicios_facturacion.idProveedor";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrTemporal_4,$row );
}

//







?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="table-responsive" style="height: 800px;">

		<?php
		//Datos
		$tabla = '';
		foreach ($arrTemporal_1 as $temp) {
			$tabla .= '{"Tipo": "Arriendos","Proveedor": "'.$temp['ProveedorNombre'].'","Fecha": "'.$temp['Creacion_fecha'].'","Semana": '.$temp['Creacion_Semana'].',"Mes": '.$temp['Creacion_mes'].',"Ano": '.$temp['Creacion_ano'].',"Valor_Neto": '.$temp['ValorNeto'].',"Valor_Total": '.$temp['ValorTotal'].'},';
		}
		foreach ($arrTemporal_2 as $temp) {
			$tabla .= '{"Tipo": "Insumos","Proveedor": "'.$temp['ProveedorNombre'].'","Fecha": "'.$temp['Creacion_fecha'].'","Semana": '.$temp['Creacion_Semana'].',"Mes": '.$temp['Creacion_mes'].',"Ano": '.$temp['Creacion_ano'].',"Valor_Neto": '.$temp['ValorNeto'].',"Valor_Total": '.$temp['ValorTotal'].'},';
		}
		foreach ($arrTemporal_3 as $temp) {
			$tabla .= '{"Tipo": "Productos","Proveedor": "'.$temp['ProveedorNombre'].'","Fecha": "'.$temp['Creacion_fecha'].'","Semana": '.$temp['Creacion_Semana'].',"Mes": '.$temp['Creacion_mes'].',"Ano": '.$temp['Creacion_ano'].',"Valor_Neto": '.$temp['ValorNeto'].',"Valor_Total": '.$temp['ValorTotal'].'},';
		}
		foreach ($arrTemporal_4 as $temp) {
			$tabla .= '{"Tipo": "Servicios","Proveedor": "'.$temp['ProveedorNombre'].'","Fecha": "'.$temp['Creacion_fecha'].'","Semana": '.$temp['Creacion_Semana'].',"Mes": '.$temp['Creacion_mes'].',"Ano": '.$temp['Creacion_ano'].',"Valor_Neto": '.$temp['ValorNeto'].',"Valor_Total": '.$temp['ValorTotal'].'},';
		}

		//
		$extraconfig = '
		slice: {
					rows: [
						{"uniqueName": "Proveedor"}
					],
					columns: [
						{"uniqueName": "Measures"},
						{"uniqueName": "Ano"},
						{"uniqueName": "Mes"},
						{"uniqueName": "Tipo"}
					],
					measures: [
						{"uniqueName": "Valor_Total","aggregation": "sum"}
					],
					sorting: {
						"column": {"type": "desc","tuple": null,"measure": "Valor_Total"}
					},
					expands: {
						"columns": [
							{"tuple": ["Ano.2017"]},
							{"tuple": ["Ano.2017","Mes.12"]}
						]
					}
				}';
		
		echo widget_excel('wdr-component', $tabla, $extraconfig); ?>
		 
		
    
	</div>
</div>

<div class="clearfix"></div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
	<a href="<?php echo $original; ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
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
		</header>
		<div class="body">
			<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idProveedor)){  $x1  = $idProveedor;  }else{$x1  = '';}
				if(isset($idEstado)){     $x2  = $idEstado;     }else{$x2  = '';}
				if(isset($f_inicio)){     $x3  = $f_inicio;     }else{$x3  = '';}
				if(isset($f_termino)){    $x4  = $f_termino;    }else{$x4  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_filter('Proveedor','idProveedor', $x1, 1, 'idProveedor', 'Rut,Nombre', 'proveedor_listado', $z, '', $dbConn);
				$Form_Inputs->form_select_filter('Estado de Pago','idEstado', $x2, 1, 'idEstado', 'Nombre', 'core_estado_facturacion', 0, '', $dbConn);
				$Form_Inputs->form_date('Fecha Inicio','f_inicio', $x3, 1);
				$Form_Inputs->form_date('Fecha Termino','f_termino', $x4, 1);

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
