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
$original = "informe_busqueda_pagos_01.php";
$location = $original;
//Se agregan ubicaciones
$search ='&submit_filter=Filtrar';
if(isset($_GET['idType'])&&$_GET['idType']!=''){       $search .="&idType=".$_GET['idType'];}
if(isset($_GET['idProveedor'])&&$_GET['idProveedor']!=''){    $search .="&idProveedor=".$_GET['idProveedor'];}
if(isset($_GET['idCliente'])&&$_GET['idCliente']!=''){ $search .="&idCliente=".$_GET['idCliente'];}
if(isset($_GET['idTipo'])&&$_GET['idTipo']!=''){       $search .="&idTipo=".$_GET['idTipo'];}
if(isset($_GET['idDocPago'])&&$_GET['idDocPago']!=''){ $search .="&idDocPago=".$_GET['idDocPago'];}
if(isset($_GET['N_DocPago'])&&$_GET['N_DocPago']!=''){ $search .="&N_DocPago=".$_GET['N_DocPago'];}
if(isset($_GET['f_inicio_p'], $_GET['f_termino_p'])&&$_GET['f_inicio_p']!=''&&$_GET['f_termino_p']!=''){
	$search .="&f_inicio_p=".$_GET['f_inicio_p'];
	$search .="&f_termino_p=".$_GET['f_termino_p'];
}
	

							
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
/**********************************************************/
//paginador de resultados
if(isset($_GET['pagina'])){$num_pag = $_GET['pagina'];} else {$num_pag = 1;}
//Defino la cantidad total de elementos por pagina
$cant_reg = 30;
//resto de variables
if (!$num_pag){$comienzo = 0;$num_pag = 1;} else {$comienzo = ( $num_pag - 1 ) * $cant_reg ;}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
switch ($_GET['idType']) {
    /**********************************************************/
	//Proveedores
    case 1:
        //ordenamiento
		if(isset($_GET['order_by'])&&$_GET['order_by']!=''){
			switch ($_GET['order_by']) {
				case 'tipo_asc':         $order_by = 'pagos_facturas_proveedores_tipo.Nombre ASC ';       $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Tipo Ascendente'; break;
				case 'tipo_desc':        $order_by = 'pagos_facturas_proveedores_tipo.Nombre DESC ';      $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Tipo Descendente';break;
				case 'empresa_asc':      $order_by = 'proveedor_listado.Nombre ASC ';                     $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Proveedor Ascendente';break;
				case 'empresa_desc':     $order_by = 'proveedor_listado.Nombre DESC ';                    $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Proveedor Descendente';break;
				case 'documento_asc':    $order_by = 'sistema_documentos_pago.Nombre ASC ';               $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Documento Ascendente';break;
				case 'documento_desc':   $order_by = 'sistema_documentos_pago.Nombre DESC ';              $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Documento Descendente';break;
				case 'fechapag_asc':     $order_by = 'pagos_facturas_proveedores.F_Pago ASC ';            $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha Pago Ascendente';break;
				case 'fechapag_desc':    $order_by = 'pagos_facturas_proveedores.F_Pago DESC ';           $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha Pago Descendente';break;
				
				default: $order_by = 'pagos_facturas_proveedores.F_Pago ASC, proveedor_listado.Nombre ASC, pagos_facturas_proveedores.N_DocPago ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha Pago, Proveedor, N° Doc Pago Ascendente';
			}
		}else{
			$order_by = 'pagos_facturas_proveedores.F_Pago ASC, proveedor_listado.Nombre ASC, pagos_facturas_proveedores.N_DocPago ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha Pago, Proveedor, N° Doc Pago Ascendente';
		}
		/**********************************************************/
		//Variable de busqueda
		$SIS_where = "pagos_facturas_proveedores.idPago!=0";
		if(isset($_GET['idDocPago'])&&$_GET['idDocPago']!=''){      $SIS_where.= " AND pagos_facturas_proveedores.idDocPago=".$_GET['idDocPago'];}
		if(isset($_GET['N_DocPago'])&&$_GET['N_DocPago']!=''){      $SIS_where.= " AND pagos_facturas_proveedores.N_DocPago=".$_GET['N_DocPago'];}
		if(isset($_GET['idTipo'])&&$_GET['idTipo']!=''){     $SIS_where.= " AND pagos_facturas_proveedores.idTipo=".$_GET['idTipo'];}
		if(isset($_GET['idProveedor'])&&$_GET['idProveedor']!=''){  $SIS_where.= " AND pagos_facturas_proveedores.idProveedor=".$_GET['idProveedor'];}
		if(isset($_GET['f_inicio_p'], $_GET['f_termino_p'])&&$_GET['f_inicio_p']!=''&&$_GET['f_termino_p']!=''){
			$SIS_where.= " AND pagos_facturas_proveedores.F_Pago BETWEEN '".$_GET['f_inicio_p']."' AND '".$_GET['f_termino_p']."'";
		}	
		/**********************************************************/
		//Realizo una consulta para saber el total de elementos existentes
		$cuenta_registros = db_select_nrows (false, 'idPago', 'pagos_facturas_proveedores', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
		//Realizo la operacion para saber la cantidad de paginas que hay
		$total_paginas = ceil($cuenta_registros / $cant_reg);
		// Se trae un listado con todos los elementos
		$SIS_query = '
		pagos_facturas_proveedores.idTipo,
		pagos_facturas_proveedores_tipo.Nombre AS Tipo,
		sistema_documentos_pago.Nombre AS Documento,
		pagos_facturas_proveedores.N_DocPago,
		proveedor_listado.Nombre AS Empresa,
		core_sistemas.Nombre AS Sistema,
		pagos_facturas_proveedores.idFacturacion,
		pagos_facturas_proveedores.F_Pago';
		$SIS_join  = '
		LEFT JOIN `core_sistemas`                     ON core_sistemas.idSistema                 = pagos_facturas_proveedores.idSistema
		LEFT JOIN `sistema_documentos_pago`           ON sistema_documentos_pago.idDocPago       = pagos_facturas_proveedores.idDocPago
		LEFT JOIN `pagos_facturas_proveedores_tipo`   ON pagos_facturas_proveedores_tipo.idTipo  = pagos_facturas_proveedores.idTipo
		LEFT JOIN `proveedor_listado`                 ON proveedor_listado.idProveedor           = pagos_facturas_proveedores.idProveedor';
		$SIS_order = $order_by.' LIMIT '.$comienzo.', '.$cant_reg;
		$arrTipo = array();
		$arrTipo = db_select_array (false, $SIS_query, 'pagos_facturas_proveedores', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTipo');

        break;
    
    
    /**********************************************************/
	//Clientes
    case 2:
        //ordenamiento
		if(isset($_GET['order_by'])&&$_GET['order_by']!=''){
			switch ($_GET['order_by']) {
				case 'tipo_asc':         $order_by = 'pagos_facturas_clientes_tipo.Nombre ASC ';       $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Tipo Ascendente'; break;
				case 'tipo_desc':        $order_by = 'pagos_facturas_clientes_tipo.Nombre DESC ';      $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Tipo Descendente';break;
				case 'empresa_asc':      $order_by = 'clientes_listado.Nombre ASC ';                     $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Proveedor Ascendente';break;
				case 'empresa_desc':     $order_by = 'clientes_listado.Nombre DESC ';                    $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Proveedor Descendente';break;
				case 'documento_asc':    $order_by = 'sistema_documentos_pago.Nombre ASC ';               $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Documento Ascendente';break;
				case 'documento_desc':   $order_by = 'sistema_documentos_pago.Nombre DESC ';              $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Documento Descendente';break;
				case 'fechapag_asc':     $order_by = 'pagos_facturas_clientes.F_Pago ASC ';            $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha Pago Ascendente';break;
				case 'fechapag_desc':    $order_by = 'pagos_facturas_clientes.F_Pago DESC ';           $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha Pago Descendente';break;
				
				default: $order_by = 'pagos_facturas_clientes.F_Pago ASC, clientes_listado.Nombre ASC, pagos_facturas_clientes.N_DocPago ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha Pago, Proveedor, N° Doc Pago Ascendente';
			}
		}else{
			$order_by = 'pagos_facturas_clientes.F_Pago ASC, clientes_listado.Nombre ASC, pagos_facturas_clientes.N_DocPago ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha Pago, Proveedor, N° Doc Pago Ascendente';
		}
		/**********************************************************/
		//Variable de busqueda
		$SIS_where = "pagos_facturas_clientes.idPago!=0";
		if(isset($_GET['idDocPago'])&&$_GET['idDocPago']!=''){      $SIS_where.= " AND pagos_facturas_clientes.idDocPago=".$_GET['idDocPago'];}
		if(isset($_GET['N_DocPago'])&&$_GET['N_DocPago']!=''){      $SIS_where.= " AND pagos_facturas_clientes.N_DocPago=".$_GET['N_DocPago'];}
		if(isset($_GET['idTipo'])&&$_GET['idTipo']!=''){     $SIS_where.= " AND pagos_facturas_clientes.idTipo=".$_GET['idTipo'];}
		if(isset($_GET['idCliente'])&&$_GET['idCliente']!=''){      $SIS_where.= " AND pagos_facturas_clientes.idCliente=".$_GET['idCliente'];}
		if(isset($_GET['f_inicio_p'], $_GET['f_termino_p'])&&$_GET['f_inicio_p']!=''&&$_GET['f_termino_p']!=''){
			$SIS_where.= " AND pagos_facturas_clientes.F_Pago BETWEEN '".$_GET['f_inicio_p']."' AND '".$_GET['f_termino_p']."'";
		}	
		/**********************************************************/
		//Realizo una consulta para saber el total de elementos existentes
		$cuenta_registros = db_select_nrows (false, 'idPago', 'pagos_facturas_clientes', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
		//Realizo la operacion para saber la cantidad de paginas que hay
		$total_paginas = ceil($cuenta_registros / $cant_reg);
		// Se trae un listado con todos los elementos
		$SIS_query = '
		pagos_facturas_clientes.idTipo,
		pagos_facturas_clientes_tipo.Nombre AS Tipo,
		sistema_documentos_pago.Nombre AS Documento,
		pagos_facturas_clientes.N_DocPago,
		clientes_listado.Nombre AS Empresa,
		core_sistemas.Nombre AS Sistema,
		pagos_facturas_clientes.idFacturacion,
		pagos_facturas_clientes.F_Pago';
		$SIS_join  = '
		LEFT JOIN `core_sistemas`                 ON core_sistemas.idSistema              = pagos_facturas_clientes.idSistema
		LEFT JOIN `sistema_documentos_pago`       ON sistema_documentos_pago.idDocPago    = pagos_facturas_clientes.idDocPago
		LEFT JOIN `pagos_facturas_clientes_tipo`  ON pagos_facturas_clientes_tipo.idTipo  = pagos_facturas_clientes.idTipo
		LEFT JOIN `clientes_listado`              ON clientes_listado.idCliente           = pagos_facturas_clientes.idCliente';
		$SIS_order = $order_by.' LIMIT '.$comienzo.', '.$cant_reg;
		$arrTipo = array();
		$arrTipo = db_select_array (false, $SIS_query, 'pagos_facturas_clientes', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTipo');

        break;
}

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
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Documentos</h5>
			<div class="toolbar">
				<?php echo paginador_2('pagsup',$total_paginas, $original, $search, $num_pag ) ?>
			</div>
		</header>
		<div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th>
							<div class="pull-left">Tipo</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'?d=d'.$search.'&order_by=tipo_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'?d=d'.$search.'&order_by=tipo_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Empresa</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'?d=d'.$search.'&order_by=empresa_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'?d=d'.$search.'&order_by=empresa_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Documento</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'?d=d'.$search.'&order_by=documento_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'?d=d'.$search.'&order_by=documento_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Fecha Pagada</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'?d=d'.$search.'&order_by=fechapag_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'?d=d'.$search.'&order_by=fechapag_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><th width="160">Sistema</th><?php } ?>
						<th width="10">Acciones</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrTipo as $tipo) { ?>
					<tr class="odd">
						<td><?php echo $tipo['Tipo']; ?></td>
						<td><?php echo $tipo['Empresa']; ?></td>
						<td><?php echo $tipo['Documento'].' '.$tipo['N_DocPago']; ?></td>
						<td><?php echo Fecha_estandar($tipo['F_Pago']); ?></td>
						<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><td><?php echo $tipo['Sistema']; ?></td><?php } ?>
						<td>
							<div class="btn-group" style="width: 35px;" >
								<?php
								switch ($tipo['idTipo']) {
									case 1://Factura Insumos
										echo '<a href="view_mov_insumos.php?view='.simpleEncode($tipo['idFacturacion'], fecha_actual()).'" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>';
										break;
									case 2://Factura Productos
										echo '<a href="view_mov_productos.php?view='.simpleEncode($tipo['idFacturacion'], fecha_actual()).'" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>';
										break;
									case 3://Factura Servicios
										echo '<a href="view_mov_servicios.php?view='.simpleEncode($tipo['idFacturacion'], fecha_actual()).'" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>';
										break;
									case 4://Factura Arriendos
										echo '<a href="view_mov_arriendos.php?view='.simpleEncode($tipo['idFacturacion'], fecha_actual()).'" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>';
										break;
								}
								?>
							</div>
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
		<div class="pagrow">
			<?php echo paginador_2('paginf',$total_paginas, $original, $search, $num_pag ) ?>
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
				if(isset($idType)){               $x1  = $idType;              }else{$x1  = '';}
				if(isset($idProveedor)){          $x2  = $idProveedor;         }else{$x2  = '';}
				if(isset($idCliente)){            $x3  = $idCliente;           }else{$x3  = '';}
				if(isset($idTipo)){               $x4  = $idTipo;              }else{$x4  = '';}
				if(isset($idDocPago)){            $x5  = $idDocPago;           }else{$x5  = '';}
				if(isset($N_DocPago)){            $x6  = $N_DocPago;           }else{$x6  = '';}
				if(isset($f_inicio_p)){           $x7  = $f_inicio_p;          }else{$x7  = '';}
				if(isset($f_termino_p)){          $x8  = $f_termino_p;         }else{$x8  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select('Tipo Pago','idType', $x1, 2, 'idType', 'Nombre', 'pagos_facturas_tipos', 0, '', $dbConn);
				$Form_Inputs->form_select_filter('Proveedor','idProveedor', $x2, 1, 'idProveedor', 'Nombre', 'proveedor_listado', $z, '', $dbConn);
				$Form_Inputs->form_select_filter('Cliente','idCliente', $x3, 1, 'idCliente', 'Nombre', 'clientes_listado', $z, '', $dbConn);
				$Form_Inputs->form_select('Documento de Pago','idTipo', $x4, 1, 'idTipo', 'Nombre', 'pagos_facturas_proveedores_tipo', 0, '', $dbConn);
				$Form_Inputs->form_select('Documento de Pago','idDocPago', $x5, 1, 'idDocPago', 'Nombre', 'sistema_documentos_pago', 0, '', $dbConn);
				$Form_Inputs->form_input_number('N° Documento de Pago', 'N_DocPago', $x6, 1);
				$Form_Inputs->form_date('Fecha Pagada Desde','f_inicio_p', $x7, 1);
				$Form_Inputs->form_date('Fecha Pagada Hasta','f_termino_p', $x8, 1);

				?>

				<script>
					document.getElementById('div_idProveedor').style.display = 'none';
					document.getElementById('div_idCliente').style.display = 'none';

					$(document).ready(function(){//se ejecuta al cargar la página (OBLIGATORIO)
						
						$("#idType").on("change", function(){ //se ejecuta al cambiar valor del select
							let tipo_val= $("#idType").val();//Asignamos el valor seleccionado
								
							//Proveedores
							if(tipo_val == 1){
								document.getElementById('div_idProveedor').style.display = '';
								document.getElementById('div_idCliente').style.display = 'none';
							//Clientes	
							} else if(tipo_val == 2){
								document.getElementById('div_idProveedor').style.display = 'none';
								document.getElementById('div_idCliente').style.display = '';
							} else {
								document.getElementById('div_idProveedor').style.display = 'none';
								document.getElementById('div_idCliente').style.display = 'none';
							}

						});
					});
						
					</script>

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
