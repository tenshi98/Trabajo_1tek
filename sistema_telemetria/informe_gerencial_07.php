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
$original = "informe_gerencial_07.php";
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
$z1 = "WHERE pagos_facturas_clientes.idPago!=0";

if(isset($_GET['idCliente'])&&$_GET['idCliente']!=''){
	$z1.=" AND pagos_facturas_clientes.idCliente=".$_GET['idCliente'];
	$search .="&idCliente=".$_GET['idCliente'];
}
if(isset($_GET['idDocPago'])&&$_GET['idDocPago']!=''){
	$z1.=" AND pagos_facturas_clientes.idDocPago=".$_GET['idDocPago'];
	$search .="&idDocPago=".$_GET['idDocPago'];
}
if(isset($_GET['f_inicio_pago'])&&$_GET['f_inicio_pago']!=''&&isset($_GET['f_termino_pago'])&&$_GET['f_termino_pago']!=''){
	$z1.=" AND pagos_facturas_clientes.F_Pago BETWEEN '".$_GET['f_inicio_pago']."' AND '".$_GET['f_termino_pago']."'";
	$search .="&f_inicio_p=".$_GET['f_inicio_pago'];
	$search .="&f_termino_p=".$_GET['f_termino_pago'];
}

/*************************************************************************************************/
//Bodega de Insumos
$arrTemporal = array();
$query = "SELECT 
pagos_facturas_clientes.idCliente,
pagos_facturas_clientes.idDocPago,
clientes_listado.Nombre AS Cliente,
clientes_listado.Rut AS ClienteRut,
SUM(pagos_facturas_clientes.MontoPagado) AS Pagado
FROM `pagos_facturas_clientes`
LEFT JOIN `clientes_listado`         ON clientes_listado.idCliente       = pagos_facturas_clientes.idCliente
".$z1."
GROUP BY pagos_facturas_clientes.idCliente, pagos_facturas_clientes.idDocPago";
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
foreach ($arrTemporal as $temp) {
	$arrProvIns[$temp['idCliente']]['idCliente']                 = $temp['idCliente'];
	$arrProvIns[$temp['idCliente']]['Cliente']                   = $temp['Cliente'];
	$arrProvIns[$temp['idCliente']]['ClienteRut']                = $temp['ClienteRut'];
	$arrProvIns[$temp['idCliente']][$temp['idDocPago']]['Pagado']  = $temp['Pagado'];
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
			<h5>Pagos Clientes</h5>
		</header>
		<div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th>Empresa</th>
						<th>Rut</th>
						<?php
						$nFormPago = 0;
						foreach ($arrDocumentos as $ins) {
							echo '<th>'.$ins['Nombre'].'</th>';
							$nFormPago++;
						} 
						//Total de celdas
						$cel = $nFormPago + 2;
						$title = $nFormPago + 5; ?>
						<th>Total</th>
						<th width="10">Acciones</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php
					$TotalCat = 0;
					//Se recorren los datos
					foreach ($arrProvIns as $key => $prod){
						//Se verifica si existen datos en esta obra
						if(isset($prod['Cliente'])&&$prod['Cliente']!=''){
							$Total = 0;	 
							echo '
							<tr class="odd">
								<td>'.$prod['Cliente'].'</td>
								<td>'.$prod['ClienteRut'].'</td>';
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
								$search .="&idCliente=".$prod['idCliente'];
								echo '<td align="right">'.valores($Total, 0).'</td>
								<td>
									<div class="btn-group" style="width: 35px;" >
										<a target="_blank" rel="noopener noreferrer" href="informe_gerencial_08.php'.$search.'" title="Ver Información" class="btn btn-primary btn-sm info-tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
									</div>
								</td>
							</tr>';
						}
					} 
					?>
					
				  
					
					<tr class="invoice-total" bgcolor="#f1f1f1">
						<td colspan="<?php echo $cel; ?>" align="right"> <strong>Total General</strong></td>
						<td align="right"><?php echo Valores($TotalGeneral, 0); ?></td>
						<td></td>
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
				if(isset($idCliente)){     $x1  = $idCliente;      }else{$x1  = '';}
				if(isset($idDocPago)){       $x2  = $idDocPago;        }else{$x2  = '';}
				if(isset($f_inicio_pago)){   $x3  = $f_inicio_pago;    }else{$x3  = '';}
				if(isset($f_termino_pago)){  $x4  = $f_termino_pago;   }else{$x4  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_filter('Cliente','idCliente', $x1, 1, 'idCliente', 'Nombre', 'clientes_listado', $z, '', $dbConn);
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
