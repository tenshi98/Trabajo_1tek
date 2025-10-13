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
$original = "informe_documentos_pagar_01.php";
$location = $original;
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/********************************************************************/
//Variables para filtro y paginacion
$search ='&submit_filter=Filtrar';
if(isset($_GET['idCajaChica']) && $_GET['idCajaChica']!=''){                            $location .= "&idCajaChica=".$_GET['idCajaChica'];                            $search .= "&idCajaChica=".$_GET['idCajaChica'];}
if(isset($_GET['idTrabajador']) && $_GET['idTrabajador']!=''){                          $location .= "&idTrabajador=".$_GET['idTrabajador'];                          $search .= "&idTrabajador=".$_GET['idTrabajador'];}
if(isset($_GET['Creacion_fecha']) && $_GET['Creacion_fecha']!=''){                      $location .= "&Creacion_fecha=".$_GET['Creacion_fecha'];                      $search .= "&Creacion_fecha=".$_GET['Creacion_fecha'];}
if(isset($_GET['idFacturacionRelacionada']) && $_GET['idFacturacionRelacionada']!=''){  $location .= "&idFacturacionRelacionada=".$_GET['idFacturacionRelacionada'];  $search .= "&idFacturacionRelacionada=".$_GET['idFacturacionRelacionada'];}
if(isset($_GET['idTipo']) && $_GET['idTipo']!=''){                                      $location .= "&idTipo=".$_GET['idTipo'];                                      $search .= "&idTipo=".$_GET['idTipo'];}
if(isset($_GET['idEstado']) && $_GET['idEstado']!=''){                                  $location .= "&idEstado=".$_GET['idEstado'];                                  $search .= "&idEstado=".$_GET['idEstado'];}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Se definen las variables
if(isset($_GET['Mes'])){   $Mes = $_GET['Mes'];   } else { $Mes  = mes_actual();}
if(isset($_GET['Ano'])){   $Ano = $_GET['Ano'];   } else { $Ano  = ano_actual();}
$diaActual = dia_actual();

//calculo de los dias del mes, cuando inicia y cuando termina
$diaSemana      = date("w",mktime(0,0,0,$Mes,1,$Ano))+7;
$ultimoDiaMes   = date("d",(mktime(0,0,0,$Mes+1,1,$Ano)-1));


/*******************************************************/
// consulto los datos
$SIS_query = '
pagos_facturas_proveedores.idTipo,
pagos_facturas_proveedores.idFacturacion,
sistema_documentos_pago.Nombre AS Documento,
pagos_facturas_proveedores.N_DocPago,
pagos_facturas_proveedores.F_Pago,
core_sistemas.Nombre AS Sistema,
proveedor_listado.Nombre AS Proveedor,
pagos_facturas_proveedores.MontoPagado,
pagos_facturas_proveedores_tipo.Nombre AS TipoDoc';
$SIS_join  = '
LEFT JOIN `sistema_documentos_pago`           ON sistema_documentos_pago.idDocPago            = pagos_facturas_proveedores.idDocPago
LEFT JOIN `core_sistemas`                     ON core_sistemas.idSistema                      = pagos_facturas_proveedores.idSistema
LEFT JOIN `proveedor_listado`                 ON proveedor_listado.idProveedor                = pagos_facturas_proveedores.idProveedor
LEFT JOIN `pagos_facturas_proveedores_tipo`   ON pagos_facturas_proveedores_tipo.idTipo       = pagos_facturas_proveedores.idTipo';
if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
	$SIS_join.= " INNER JOIN usuarios_documentos_pago  ON usuarios_documentos_pago.idDocPago  = pagos_facturas_proveedores.idDocPago";
}
$SIS_where = 'pagos_facturas_proveedores.F_Pago_ano='.$Ano;
$SIS_where.= ' AND pagos_facturas_proveedores.F_Pago_mes='.$Mes;
$SIS_where.= " AND pagos_facturas_proveedores.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];//todas las empresas
//verifico el tipo de usuario
if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
	$SIS_where.=" AND usuarios_documentos_pago.idUsuario = ".$_SESSION['usuario']['basic_data']['idUsuario'];
}
$SIS_order = 'sistema_documentos_pago.Nombre ASC, pagos_facturas_proveedores.F_Pago ASC, proveedor_listado.Nombre ASC';
$arrCheques = array();
$arrCheques = db_select_array (false, $SIS_query, 'pagos_facturas_proveedores', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrCheques');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar">
	<a target="_blank" rel="noopener noreferrer" href="principal_datos_documentos_pago.php" class="btn btn-default pull-right margin_width fmrbtn" ><i class="fa fa-file-o" aria-hidden="true"></i> Configurar Documentos</a>
</div>
<div class="clearfix"></div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<?php
			if(isset($_GET['Ano'])){
				$Ano_a  = $_GET['Ano'];
				$Ano_b  = $_GET['Ano'];
			} else {
				$Ano_a  = date("Y");
				$Ano_b  = date("Y");
			}
			if (($Mes-1)==0){$mes_atras=12;   $Ano_a=$Ano_a-1;}else{$mes_atras=$Mes-1; }
			if (($Mes+1)==13) {$mes_adelante=1; $Ano_b=$Ano_b+1;}else{$mes_adelante=$Mes+1; }
			?>
			<div class="btn-group pull-left" style="width: 35px;" >
				<a href="<?php echo $original.'?Mes='.$mes_atras.'&Ano='.$Ano_a ?>" class="btn btn-default"><i class="fa fa-angle-left faa-horizontal animated" aria-hidden="true"></i></a>
			</div>
			<div class="fcenter" >
				<h5>Listado de Documentos por pagar <?php echo $meses[$Mes]." ".$Ano?></h5>
			</div>
			<div class="btn-group pull-right" style="width: 35px;" >
				<a href="<?php echo $original.'?Mes='.$mes_adelante.'&Ano='.$Ano_b ?>" class="btn btn-default"><i class="fa fa-angle-right faa-horizontal animated" aria-hidden="true"></i></a>
			</div>

		</header>
		<div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th>N° Documento</th>
						<th>Monto</th>
						<th>Fecha de Pago</th>
						<th>Proveedor</th>
						<th>Tipo Documento</th>
						<th>Sistema</th>
						<th width="10">Acciones</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php
					filtrar($arrCheques, 'Documento');
					$total = 0;
					foreach($arrCheques as $categoria=>$permisos){
						echo '<tr class="odd" ><td colspan="7"  style="background-color:#DDD"><strong>'.$categoria.'</strong></td></tr>';
						$subtotal = 0;
						foreach ($permisos as $cheques) {  ?>
							<tr class="odd">
								<td><?php echo ' N°'.$cheques['N_DocPago']; ?></td>
								<td align="right"><?php echo valores($cheques['MontoPagado'], 0);$subtotal = $subtotal + $cheques['MontoPagado'];$total = $total + $cheques['MontoPagado']; ?></td>
								<td><?php echo fecha_estandar($cheques['F_Pago']); ?></td>
								<td><?php echo $cheques['Proveedor']; ?></td>
								<td><?php echo $cheques['TipoDoc']; ?></td>
								<td><?php echo $cheques['Sistema']; ?></td>
								<td>
									<div class="btn-group" style="width: 35px;" >
										<?php
										switch ($cheques['idTipo']) {
											//Factura Insumos
											case 1:
												$ver = 'view_mov_insumos.php?view='.simpleEncode($cheques['idFacturacion'], fecha_actual());
											break;
											//Factura Productos
											case 2:
												$ver = 'view_mov_productos.php?view='.simpleEncode($cheques['idFacturacion'], fecha_actual());
											break;
											//Factura Servicios
											case 3:
												$ver = 'view_mov_servicios.php?view='.simpleEncode($cheques['idFacturacion'], fecha_actual());
											break;
											//Factura Arriendos
											case 4:
												$ver = 'view_mov_arriendos.php?view='.simpleEncode($cheques['idFacturacion'], fecha_actual());
											break;
										}
										echo '<a href="'.$ver.'" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>';

										?>

									</div>
								</td>
							</tr>
						<?php }
						echo '
						<tr class="odd" >
							<td style="background-color:#DDD"><strong>Subtotal</strong></td>
							<td align="right" style="background-color:#DDD"><strong>'.valores($subtotal, 0).'</strong></td>
							<td colspan="5"  style="background-color:#DDD"></td>
						</tr>';
					}
					echo '
					<tr class="odd" >
						<td style="background-color:#DDD"><strong>Total</strong></td>
						<td align="right" style="background-color:#DDD"><strong>'.valores($total, 0).'</strong></td>
						<td colspan="5"  style="background-color:#DDD"></td>
					</tr>'; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';

?>
