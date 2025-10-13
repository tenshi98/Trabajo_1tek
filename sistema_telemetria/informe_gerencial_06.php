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
$original = "informe_gerencial_06.php";
$location = $original;
//Se agregan ubicaciones
$location .='?filtro=true';			
       
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
$search ='?submit_filter=Filtrar';
$z1 = "WHERE pagos_facturas_proveedores.idPago!=0";

if(isset($_GET['idProveedor'])&&$_GET['idProveedor']!=''){
	$z1.=" AND pagos_facturas_proveedores.idProveedor=".$_GET['idProveedor'];
	$search .="&idProveedor=".$_GET['idProveedor'];
}
if(isset($_GET['idDocPago'])&&$_GET['idDocPago']!=''){
	$z1.=" AND pagos_facturas_proveedores.idDocPago=".$_GET['idDocPago'];
	$search .="&idDocPago=".$_GET['idDocPago'];
}
if(isset($_GET['f_inicio_pago'])&&$_GET['f_inicio_pago']!=''&&isset($_GET['f_termino_pago'])&&$_GET['f_termino_pago']!=''){
	$z1.=" AND pagos_facturas_proveedores.F_Pago BETWEEN '".$_GET['f_inicio_pago']."' AND '".$_GET['f_termino_pago']."'";
	$search .="&f_inicio_p=".$_GET['f_inicio_pago'];
	$search .="&f_termino_p=".$_GET['f_termino_pago'];
}

/*************************************************************************************************/
//Bodega de Insumos
$arrTemporal = array();
$query = "SELECT 
pagos_facturas_proveedores.idProveedor,
pagos_facturas_proveedores.idDocPago,
pagos_facturas_proveedores.F_Pago_Semana,
pagos_facturas_proveedores.F_Pago_ano,
proveedor_listado.Nombre AS Proveedor,
proveedor_listado.Rut AS ProveedorRut,
SUM(pagos_facturas_proveedores.MontoPagado) AS Pagado
FROM `pagos_facturas_proveedores`
LEFT JOIN `proveedor_listado`         ON proveedor_listado.idProveedor       = pagos_facturas_proveedores.idProveedor
".$z1."
GROUP BY pagos_facturas_proveedores.idProveedor, pagos_facturas_proveedores.F_Pago_ano, pagos_facturas_proveedores.F_Pago_Semana, pagos_facturas_proveedores.idDocPago
ORDER BY pagos_facturas_proveedores.F_Pago_ano DESC, pagos_facturas_proveedores.F_Pago_Semana DESC";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrTemporal,$row );
}
//Se crea arreglo
$arrProvIns = array();
$ult_ano = 0;
$ult_semana = 0;
foreach ($arrTemporal as $temp) {
	$arrProvIns[$temp['idProveedor']][$temp['F_Pago_ano']][$temp['F_Pago_Semana']]['idProveedor']                 = $temp['idProveedor'];
	$arrProvIns[$temp['idProveedor']][$temp['F_Pago_ano']][$temp['F_Pago_Semana']]['Proveedor']                   = $temp['Proveedor'];
	$arrProvIns[$temp['idProveedor']][$temp['F_Pago_ano']][$temp['F_Pago_Semana']]['F_Pago_Semana']               = $temp['F_Pago_Semana'];
	$arrProvIns[$temp['idProveedor']][$temp['F_Pago_ano']][$temp['F_Pago_Semana']]['F_Pago_ano']                  = $temp['F_Pago_ano'];
	$arrProvIns[$temp['idProveedor']][$temp['F_Pago_ano']][$temp['F_Pago_Semana']]['ProveedorRut']                = $temp['ProveedorRut'];
	$arrProvIns[$temp['idProveedor']][$temp['F_Pago_ano']][$temp['F_Pago_Semana']][$temp['idDocPago']]['Pagado']  = $temp['Pagado'];
	//se guardan los datos
	$ult_ano     = $temp['F_Pago_ano'];
	$ult_semana  = $temp['F_Pago_Semana'];
}

/*************************************************************************************************/
//Listado de documentos
$arrDocumentos = array();
$query = "SELECT idDocPago, Nombre
FROM `sistema_documentos_pago`
ORDER BY idDocPago ASC";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrDocumentos,$row );
}
//Variables
$TotalGeneral = 0;

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Pagos Proveedores</h5>
		</header>
		<div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th colspan="2">Empresa</th>
						<?php
						$nFormPago = 0;
						foreach ($arrDocumentos as $ins) {
							echo '<th>'.$ins['Nombre'].'</th>';
							$nFormPago++;
						} 
						//Total de celdas
						$cel = $nFormPago + 2;
						$cel2 = $nFormPago + 3;
						$title = $nFormPago + 5; ?>
						<th>Total</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php 
					
					$TotalCat = 0;
					//Se recorren los datos
					foreach ($arrProvIns as $key => $prod_1){
						echo '<tr class="odd"><td colspan="'.$cel2.'" style="background-color:#f1f1f1 !important;">'.$prod_1[$ult_ano][$ult_semana]['Proveedor'].'</td></tr>';
						foreach ($prod_1 as $prod_2) {
							echo '<tr class="odd"><td colspan="'.$cel2.'" style="background-color:#f1f1f1 !important;">Periodo '.$prod_2[$ult_semana]['F_Pago_ano'].'</td></tr>';
							foreach ($prod_2 as $prod) {
								$Total = 0;	 
								echo '
								<tr class="odd">
									<td></td>
									<td>Semana '.$prod['F_Pago_Semana'].'</td>';
									foreach ($arrDocumentos as $ins) { 
										echo '<td align="right">';
										if(isset($prod[$ins['idDocPago']]['Pagado'])&&$prod[$ins['idDocPago']]['Pagado']!=0){
											echo valores($prod[$ins['idDocPago']]['Pagado'], 0);
											$Total = $Total + $prod[$ins['idDocPago']]['Pagado'];
											$TotalCat = $TotalCat + $prod[$ins['idDocPago']]['Pagado'];
											$TotalGeneral = $TotalGeneral + $prod[$ins['idDocPago']]['Pagado'];
										}else{
											echo '0';
										}
										echo '</td>';
									}

									echo '<td align="right">'.valores($Total, 0).'</td>
								</tr>';
							}
						}
					} 
					?>
					
				  
					
					<tr class="invoice-total" bgcolor="#f1f1f1">
						<td colspan="<?php echo $cel; ?>" align="right"> <strong>Total General</strong></td>
						<td align="right"><?php echo Valores($TotalGeneral, 0); ?></td>
					</tr>
			                   
				</tbody>
			</table>
		</div>
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
				if(isset($idProveedor)){     $x1  = $idProveedor;      }else{$x1  = '';}
				if(isset($idDocPago)){       $x2  = $idDocPago;        }else{$x2  = '';}
				if(isset($f_inicio_pago)){   $x3  = $f_inicio_pago;    }else{$x3  = '';}
				if(isset($f_termino_pago)){  $x4  = $f_termino_pago;   }else{$x4  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_filter('Proveedor','idProveedor', $x1, 1, 'idProveedor', 'Nombre', 'proveedor_listado', $z, '', $dbConn);
				$Form_Inputs->form_select_filter('Documento de Pago','idDocPago', $x2, 1, 'idDocPago', 'Nombre', 'sistema_documentos_pago', 0, '', $dbConn);
				$Form_Inputs->form_date('Fecha Pago Inicio','f_inicio_pago', $x3, 1);
				$Form_Inputs->form_date('Fecha Pago Termino','f_termino_pago', $x4, 1);

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
