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
$original = "informe_busqueda_insumos_02.php";
$location = $original;
//Se agregan ubicaciones
$search ='&submit_filter=Filtrar';
if(isset($_GET['idProveedor'])&&$_GET['idProveedor']!=''){    $search .="&idProveedor=".$_GET['idProveedor'];}
if(isset($_GET['idTrabajador'])&&$_GET['idTrabajador']!=''){  $search .="&idTrabajador=".$_GET['idTrabajador'];}
if(isset($_GET['idDocumentos'])&&$_GET['idDocumentos']!=''){  $search .="&idDocumentos=".$_GET['idDocumentos'];}
if(isset($_GET['N_Doc'])&&$_GET['N_Doc']!=''){         $search .="&N_Doc=".$_GET['N_Doc'];}
if(isset($_GET['idEstado'])&&$_GET['idEstado']!=''){   $search .="&idEstado=".$_GET['idEstado'];}
if(isset($_GET['idDocPago'])&&$_GET['idDocPago']!=''){ $search .="&idDocPago=".$_GET['idDocPago'];}
if(isset($_GET['N_DocPago'])&&$_GET['N_DocPago']!=''){ $search .="&N_DocPago=".$_GET['N_DocPago'];}
if(isset($_GET['f_creacion_inicio'], $_GET['f_creacion_termino'])&&$_GET['f_creacion_inicio']!=''&&$_GET['f_creacion_termino']!=''){
	$search .="&f_creacion_inicio=".$_GET['f_creacion_inicio'];
	$search .="&f_creacion_termino=".$_GET['f_creacion_termino'];
}
if(isset($_GET['f_pago_inicio'], $_GET['f_pago_termino'])&&$_GET['f_pago_inicio']!=''&&$_GET['f_pago_termino']!=''){
	$search .="&f_pago_inicio=".$_GET['f_pago_inicio'];
	$search .="&f_pago_termino=".$_GET['f_pago_termino'];
}
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
/**********************************************************/
//ordenamiento
if(isset($_GET['order_by'])&&$_GET['order_by']!=''){
	switch ($_GET['order_by']) {
		case 'proveedor_asc':    $order_by = 'proveedor_listado.Nombre ASC ';                                             $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Proveedor Ascendente'; break;
		case 'proveedor_desc':   $order_by = 'proveedor_listado.Nombre DESC ';                                            $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Proveedor Descendente';break;
		case 'documento_asc':    $order_by = 'core_documentos_mercantiles.Nombre ASC ';                                   $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Documento Ascendente';break;
		case 'documento_desc':   $order_by = 'core_documentos_mercantiles.Nombre DESC ';                                  $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Documento Descendente';break;
		case 'fingreso_asc':     $order_by = 'bodegas_insumos_facturacion.Creacion_fecha ASC ';                           $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha ingreso Ascendente';break;
		case 'fingreso_desc':    $order_by = 'bodegas_insumos_facturacion.Creacion_fecha DESC ';                          $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha ingreso Descendente';break;
		case 'fpago_asc':        $order_by = 'bodegas_insumos_facturacion.Pago_fecha ASC ';                               $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha Pago Programado Ascendente';break;
		case 'fpago_desc':       $order_by = 'bodegas_insumos_facturacion.Pago_fecha DESC ';                              $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha Pago Programado Descendente';break;
		case 'tipo_asc':         $order_by = 'bodegas_insumos_facturacion_tipo.Nombre ASC ';                              $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Tipo Movimiento Ascendente';break;
		case 'tipo_desc':        $order_by = 'bodegas_insumos_facturacion_tipo.Nombre DESC ';                             $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Tipo Movimiento Descendente';break;
		case 'vendedor_asc':     $order_by = 'trabajadores_listado.ApellidoPat ASC, trabajadores_listado.Nombre ASC ';    $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Vendedor Ascendente';break;
		case 'vendedor_desc':    $order_by = 'trabajadores_listado.ApellidoPat DESC, trabajadores_listado.Nombre DESC ';  $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Vendedor Descendente';break;
		case 'estado_asc':       $order_by = 'core_estado_facturacion.Nombre ASC ';                                       $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Estado Ascendente';break;
		case 'estado_desc':      $order_by = 'core_estado_facturacion.Nombre DESC ';                                      $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Estado Descendente';break;

		default: $order_by = 'bodegas_insumos_facturacion.Creacion_fecha ASC, proveedor_listado.Nombre ASC, bodegas_insumos_facturacion.N_Doc ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha Ingreso, Proveedor, N°Documento Ascendente';
	}
}else{
	$order_by = 'bodegas_insumos_facturacion.Creacion_fecha ASC, proveedor_listado.Nombre ASC, bodegas_insumos_facturacion.N_Doc ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha Ingreso, Proveedor, N°Documento Ascendente';
}
/**********************************************************/
//Variable de busqueda
$SIS_where = "bodegas_insumos_facturacion.idEstado=1";
//Verifico el tipo de usuario que esta ingresando
$SIS_where.= " AND bodegas_insumos_facturacion.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
$SIS_where.= " AND bodegas_insumos_facturacion.idTipo=1"; //solo compras
$SIS_where.= " AND bodegas_insumos_facturacion.Pago_fecha<'".fecha_actual()."'"; //fecha actual

if(isset($_GET['idProveedor'])&&$_GET['idProveedor']!=''){  $SIS_where.= " AND bodegas_insumos_facturacion.idProveedor=".$_GET['idProveedor'];}
if(isset($_GET['idTrabajador'])&&$_GET['idTrabajador']!=''){$SIS_where.= " AND bodegas_insumos_facturacion.idTrabajador=".$_GET['idTrabajador'];}
if(isset($_GET['idDocumentos'])&&$_GET['idDocumentos']!=''){$SIS_where.= " AND bodegas_insumos_facturacion.idDocumentos=".$_GET['idDocumentos'];}
if(isset($_GET['N_Doc'])&&$_GET['N_Doc']!=''){       $SIS_where.= " AND bodegas_insumos_facturacion.N_Doc=".$_GET['N_Doc'];}

if(isset($_GET['f_creacion_inicio'], $_GET['f_creacion_termino'])&&$_GET['f_creacion_inicio']!=''&&$_GET['f_creacion_termino']!=''){
	$SIS_where.= " AND bodegas_insumos_facturacion.Creacion_fecha BETWEEN '".$_GET['f_creacion_inicio']."' AND '".$_GET['f_creacion_termino']."'";
}
if(isset($_GET['f_pago_inicio'], $_GET['f_pago_termino'])&&$_GET['f_pago_inicio']!=''&&$_GET['f_pago_termino']!=''){
	$SIS_where.= " AND bodegas_insumos_facturacion.Pago_fecha BETWEEN '".$_GET['f_pago_inicio']."' AND '".$_GET['f_pago_termino']."'";
}
/**********************************************************/
//Realizo una consulta para saber el total de elementos existentes
$cuenta_registros = db_select_nrows (false, 'idFacturacion', 'bodegas_insumos_facturacion', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
//Realizo la operacion para saber la cantidad de paginas que hay
$total_paginas = ceil($cuenta_registros / $cant_reg);
// Se trae un listado con todos los elementos
$SIS_query = '
bodegas_insumos_facturacion.idFacturacion,
bodegas_insumos_facturacion.Creacion_fecha,
bodegas_insumos_facturacion.Pago_fecha,
bodegas_insumos_facturacion.N_Doc,
core_sistemas.Nombre AS Sistema,
core_documentos_mercantiles.Nombre AS Documento,
proveedor_listado.Nombre AS Proveedor,
bodegas_insumos_facturacion_tipo.Nombre AS Tipo,
clientes_listado.Nombre AS Cliente,
trabajadores_listado.Nombre AS VendedorNombre,
trabajadores_listado.ApellidoPat AS VendedorApellidoPat';
$SIS_join  = '
LEFT JOIN `core_sistemas`                       ON core_sistemas.idSistema                     = bodegas_insumos_facturacion.idSistema
LEFT JOIN `core_documentos_mercantiles`         ON core_documentos_mercantiles.idDocumentos    = bodegas_insumos_facturacion.idDocumentos
LEFT JOIN `proveedor_listado`                   ON proveedor_listado.idProveedor               = bodegas_insumos_facturacion.idProveedor
LEFT JOIN `bodegas_insumos_facturacion_tipo`    ON bodegas_insumos_facturacion_tipo.idTipo     = bodegas_insumos_facturacion.idTipo
LEFT JOIN `clientes_listado`                    ON clientes_listado.idCliente                  = bodegas_insumos_facturacion.idCliente
LEFT JOIN `trabajadores_listado`                ON trabajadores_listado.idTrabajador           = bodegas_insumos_facturacion.idTrabajador';
$SIS_order = $order_by.' LIMIT '.$comienzo.', '.$cant_reg;
$arrTipo = array();
$arrTipo = db_select_array (false, $SIS_query, 'bodegas_insumos_facturacion', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTipo');

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
							<div class="pull-left">Proveedor</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'?d=d'.$search.'&order_by=proveedor_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'?d=d'.$search.'&order_by=proveedor_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Tipo Movimiento</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'?d=d'.$search.'&order_by=tipo_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'?d=d'.$search.'&order_by=tipo_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<<th>
							<div class="pull-left">Documento</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'?d=d'.$search.'&order_by=documento_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'?d=d'.$search.'&order_by=documento_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Vendedor</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'?d=d'.$search.'&order_by=vendedor_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'?d=d'.$search.'&order_by=vendedor_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Fecha <br/> Ingreso</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'?d=d'.$search.'&order_by=fingreso_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'?d=d'.$search.'&order_by=fingreso_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Fecha <br/> Pago Prog</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'?d=d'.$search.'&order_by=fpago_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'?d=d'.$search.'&order_by=fpago_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>Dias <br/>Atraso</th>
						<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><th width="160">Sistema</th><?php } ?>
						<th width="10">Acciones</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrTipo as $tipo) { ?>
					<tr class="odd">
						<td><?php echo $tipo['Proveedor']; ?></td>
						<td><?php echo $tipo['Tipo']; ?></td>
						<td><?php echo $tipo['Documento'].' '.$tipo['N_Doc']; ?></td>
						<td><?php echo $tipo['VendedorNombre'].' '.$tipo['VendedorApellidoPat']; ?></td>
						<td><?php echo Fecha_estandar($tipo['Creacion_fecha']); ?></td>
						<td><?php echo Fecha_estandar($tipo['Pago_fecha']); ?></td>
						<td><?php echo cantidades(dias_transcurridos(fecha_actual(),$tipo['Pago_fecha']), 0); ?></td>
						<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><td><?php echo $tipo['Sistema']; ?></td><?php } ?>
						<td>
							<div class="btn-group" style="width: 35px;" >
								<a href="<?php echo 'view_mov_insumos.php?view='.simpleEncode($tipo['idFacturacion'], fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
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
				if(isset($idProveedor)){          $x1  = $idProveedor;         }else{$x1  = '';}
				if(isset($idTrabajador)){         $x2  = $idTrabajador;        }else{$x2  = '';}
				if(isset($idDocumentos)){         $x3  = $idDocumentos;        }else{$x3  = '';}
				if(isset($N_Doc)){                $x4  = $N_Doc;               }else{$x4  = '';}
				if(isset($f_creacion_inicio)){    $x5  = $f_creacion_inicio;   }else{$x5  = '';}
				if(isset($f_creacion_termino)){   $x6  = $f_creacion_termino;  }else{$x6  = '';}
				if(isset($f_pago_inicio)){        $x7  = $f_pago_inicio;       }else{$x7  = '';}
				if(isset($f_pago_termino)){       $x8  = $f_pago_termino;      }else{$x8  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_tittle(3, 'Emision');
				$Form_Inputs->form_select_filter('Proveedor','idProveedor', $x1, 1, 'idProveedor', 'Nombre', 'proveedor_listado', $z, '', $dbConn);
				$Form_Inputs->form_select_filter('Trabajador','idTrabajador', $x2, 1, 'idTrabajador', 'Rut,Nombre,ApellidoPat,ApellidoMat', 'trabajadores_listado', $z, '', $dbConn);
				$Form_Inputs->form_select('Tipo Documento','idDocumentos', $x3, 1, 'idDocumentos', 'Nombre', 'core_documentos_mercantiles', 'idDocumentos!=1 AND idDocumentos!=3', '', $dbConn);
				$Form_Inputs->form_input_number('N° Documento', 'N_Doc', $x4, 1);
				$Form_Inputs->form_date('Fecha Creacion Desde','f_creacion_inicio', $x5, 1);
				$Form_Inputs->form_date('Fecha Creacion Hasta','f_creacion_termino', $x6, 1);
				$Form_Inputs->form_date('Fecha Pago prog Desde','f_pago_inicio', $x7, 1);
				$Form_Inputs->form_date('Fecha Pago prog Hasta','f_pago_termino', $x8, 1);

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
