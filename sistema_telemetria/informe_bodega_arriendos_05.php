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
$original = "informe_bodega_arriendos_05.php";
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
	/*******************************************************/
	$search = "?d=d";
	if(isset($_GET['idBodegaOrigen']) && $_GET['idBodegaOrigen']!=''){	        $search .= "&idBodegaOrigen=".$_GET['idBodegaOrigen'];}
	if(isset($_GET['idBodegaDestino']) && $_GET['idBodegaDestino']!=''){        $search .= "&idBodegaDestino=".$_GET['idBodegaDestino'];}
	if(isset($_GET['idSistema']) && $_GET['idSistema']!=''){             	    $search .= "&idSistema=".$_GET['idSistema'];}
	if(isset($_GET['idSistemaDestino']) && $_GET['idSistemaDestino']!=''){      $search .= "&idSistemaDestino=".$_GET['idSistemaDestino'];}
	if(isset($_GET['idDocumentos']) && $_GET['idDocumentos']!=''){    	        $search .= "&idDocumentos=".$_GET['idDocumentos'];}
	if(isset($_GET['N_Doc']) && $_GET['N_Doc']!=''){                  	        $search .= "&N_Doc=".$_GET['N_Doc'];}
	if(isset($_GET['idTipo']) && $_GET['idTipo']!=''){                        	$search .= "&idTipo=".$_GET['idTipo'];}
	if(isset($_GET['idTrabajador']) && $_GET['idTrabajador']!=''){        	    $search .= "&idTrabajador=".$_GET['idTrabajador'];}
	if(isset($_GET['idProveedor']) && $_GET['idProveedor']!=''){          	    $search .= "&idProveedor=".$_GET['idProveedor'];}
	if(isset($_GET['idCliente']) && $_GET['idCliente']!=''){                  	$search .= "&idCliente=".$_GET['idCliente'];}
	if(isset($_GET['idEstado']) && $_GET['idEstado']!=''){                    	$search .= "&idEstado=".$_GET['idEstado'];}
	if(isset($_GET['idDocPago']) && $_GET['idDocPago']!=''){                  	$search .= "&idDocPago=".$_GET['idDocPago'];}
	if(isset($_GET['N_DocPago']) && $_GET['N_DocPago']!=''){              	    $search .= "&N_DocPago=".$_GET['N_DocPago'];}
	if(isset($_GET['idProducto']) && $_GET['idProducto']!=''){                	$search .= "&idProducto=".$_GET['idProducto'];}
	if(isset($_GET['idEstadoDevolucion']) && $_GET['idEstadoDevolucion']!=''){  $search .= "&idEstadoDevolucion=".$_GET['idEstadoDevolucion'];}
	if(isset($_GET['Creacion_fecha_ini'], $_GET['Creacion_fecha_fin']) && $_GET['Creacion_fecha_ini'] != '' && $_GET['Creacion_fecha_fin']!=''){
		$search .= "&Creacion_fecha_ini=".$_GET['Creacion_fecha_ini'];
		$search .= "&Creacion_fecha_fin=".$_GET['Creacion_fecha_fin'];
	}
	if(isset($_GET['Pago_fecha_ini'], $_GET['Pago_fecha_fin']) && $_GET['Pago_fecha_ini'] != '' && $_GET['Pago_fecha_fin']!=''){
		$search .= "&Pago_fecha_ini=".$_GET['Pago_fecha_ini'];
		$search .= "&Pago_fecha_fin=".$_GET['Pago_fecha_fin'];
	}
	if(isset($_GET['F_Pago_ini'], $_GET['F_Pago_fin']) && $_GET['F_Pago_ini'] != '' && $_GET['F_Pago_fin']!=''){
		$search .= "&F_Pago_ini=".$_GET['F_Pago_ini'];
		$search .= "&F_Pago_fin=".$_GET['F_Pago_fin'];
	}
	if(isset($_GET['F_Devolucion_ini'], $_GET['F_Devolucion_fin']) && $_GET['F_Devolucion_ini'] != '' && $_GET['F_Devolucion_fin']!=''){
		$search .= "&F_Devolucion_ini=".$_GET['F_Devolucion_ini'];
		$search .= "&F_Devolucion_fin=".$_GET['F_Devolucion_fin'];
	}
	/*******************************************************/
	// consulto los datos
	$SIS_query = '
	bodegas_arriendos_facturacion.Creacion_fecha,
	bodegas_arriendos_facturacion.Creacion_Semana,
	bodegas_arriendos_facturacion.Creacion_mes,
	bodegas_arriendos_facturacion.Creacion_ano,
	bodegas_arriendos_facturacion.N_Doc,
	bodegas_arriendos_facturacion.idOT,
	bodegas_arriendos_facturacion.Pago_fecha,
	bodegas_arriendos_facturacion.Pago_dia,
	bodegas_arriendos_facturacion.Pago_Semana,
	bodegas_arriendos_facturacion.Pago_mes,
	bodegas_arriendos_facturacion.Pago_ano,
	bodegas_arriendos_facturacion.DocRel,
	bodegas_arriendos_facturacion.N_DocPago,
	bodegas_arriendos_facturacion.F_Pago,
	bodegas_arriendos_facturacion.F_Pago_dia,
	bodegas_arriendos_facturacion.F_Pago_mes,
	bodegas_arriendos_facturacion.F_Pago_ano,

	bodegas_arriendos_facturacion_existencias.Cantidad_ing,
	bodegas_arriendos_facturacion_existencias.Cantidad_eg,
	bodegas_arriendos_facturacion_existencias.Valor,
	bodegas_arriendos_facturacion_existencias.ValorTotal,

	equipos_arriendo_listado.Nombre AS Producto,
	bod_origen.Nombre AS Bodega_origen,
	sist_origen.Nombre AS Sistema_origen,
	core_documentos_mercantiles.Nombre AS Documento_tipo,
	bodegas_arriendos_facturacion_tipo.Nombre AS Tipo,
	trabajadores_listado.Nombre AS Trab_Nombre,
	trabajadores_listado.ApellidoPat AS Trab_ApellidoPat,
	trabajadores_listado.ApellidoMat AS Trab_ApellidoMat,
	proveedor_listado.Nombre AS Prov_Nombre,
	clientes_listado.Nombre AS Cliente_Nombre,
	core_estado_facturacion.Nombre AS Estado,
	usuarios_listado.Nombre AS UsuarioPago,
	sistema_documentos_pago.Nombre AS Documento_pago,

	core_estado_devolucion.Nombre AS EstadoDevolucion,
	bodegas_arriendos_facturacion.Devolucion_fecha,
	bodegas_arriendos_facturacion.Devolucion_dia,
	bodegas_arriendos_facturacion.Devolucion_Semana,
	bodegas_arriendos_facturacion.Devolucion_mes,
	bodegas_arriendos_facturacion.Devolucion_ano';
	$SIS_join  = '
	LEFT JOIN `bodegas_arriendos_facturacion`          ON bodegas_arriendos_facturacion.idFacturacion  = bodegas_arriendos_facturacion_existencias.idFacturacion
	LEFT JOIN `equipos_arriendo_listado`               ON equipos_arriendo_listado.idEquipo            = bodegas_arriendos_facturacion_existencias.idEquipo
	LEFT JOIN `bodegas_arriendos_listado`  bod_origen  ON bod_origen.idBodega                          = bodegas_arriendos_facturacion.idBodega
	LEFT JOIN `core_sistemas`  sist_origen             ON sist_origen.idSistema                        = bodegas_arriendos_facturacion.idSistema
	LEFT JOIN `core_documentos_mercantiles`            ON core_documentos_mercantiles.idDocumentos     = bodegas_arriendos_facturacion.idDocumentos
	LEFT JOIN `bodegas_arriendos_facturacion_tipo`     ON bodegas_arriendos_facturacion_tipo.idTipo    = bodegas_arriendos_facturacion.idTipo
	LEFT JOIN `trabajadores_listado`                   ON trabajadores_listado.idTrabajador            = bodegas_arriendos_facturacion.idTrabajador
	LEFT JOIN `proveedor_listado`                      ON proveedor_listado.idProveedor                = bodegas_arriendos_facturacion.idProveedor
	LEFT JOIN `clientes_listado`                       ON clientes_listado.idCliente                   = bodegas_arriendos_facturacion.idCliente
	LEFT JOIN `core_estado_facturacion`                ON core_estado_facturacion.idEstado             = bodegas_arriendos_facturacion.idEstado
	LEFT JOIN `usuarios_listado`                       ON usuarios_listado.idUsuario                   = bodegas_arriendos_facturacion.idUsuarioPago
	LEFT JOIN `sistema_documentos_pago`                ON sistema_documentos_pago.idDocPago            = bodegas_arriendos_facturacion.idDocPago
	LEFT JOIN `core_estado_devolucion`                 ON core_estado_devolucion.idEstadoDevolucion    = bodegas_arriendos_facturacion.idEstadoDevolucion';
	$SIS_where = 'bodegas_arriendos_facturacion_existencias.idExistencia!=0';
	if(isset($_GET['idBodegaOrigen']) && $_GET['idBodegaOrigen']!=''){	       $SIS_where .= " AND bodegas_arriendos_facturacion.idBodegaOrigen=".$_GET['idBodegaOrigen'];}
	if(isset($_GET['idBodegaDestino']) && $_GET['idBodegaDestino']!=''){       $SIS_where .= " AND bodegas_arriendos_facturacion.idBodegaDestino=".$_GET['idBodegaDestino'];}
	if(isset($_GET['idSistema']) && $_GET['idSistema']!=''){         	       $SIS_where .= " AND bodegas_arriendos_facturacion.idSistema=".$_GET['idSistema'];}
	if(isset($_GET['idSistemaDestino']) && $_GET['idSistemaDestino']!=''){     $SIS_where .= " AND bodegas_arriendos_facturacion.idSistemaDestino=".$_GET['idSistemaDestino'];}
	if(isset($_GET['idDocumentos']) && $_GET['idDocumentos']!=''){    	       $SIS_where .= " AND bodegas_arriendos_facturacion.idDocumentos=".$_GET['idDocumentos'];}
	if(isset($_GET['N_Doc']) && $_GET['N_Doc']!=''){                  	       $SIS_where .= " AND bodegas_arriendos_facturacion.N_Doc LIKE '%".EstandarizarInput($_GET['N_Doc'])."%'";}
	if(isset($_GET['idTipo']) && $_GET['idTipo']!=''){                	       $SIS_where .= " AND bodegas_arriendos_facturacion.idTipo=".$_GET['idTipo'];}
	if(isset($_GET['idTrabajador']) && $_GET['idTrabajador']!=''){    	       $SIS_where .= " AND bodegas_arriendos_facturacion.idTrabajador=".$_GET['idTrabajador'];}
	if(isset($_GET['idProveedor']) && $_GET['idProveedor']!=''){      	       $SIS_where .= " AND bodegas_arriendos_facturacion.idProveedor=".$_GET['idProveedor'];}
	if(isset($_GET['idCliente']) && $_GET['idCliente']!=''){          	       $SIS_where .= " AND bodegas_arriendos_facturacion.idCliente=".$_GET['idCliente'];}
	if(isset($_GET['idEstado']) && $_GET['idEstado']!=''){            	       $SIS_where .= " AND bodegas_arriendos_facturacion.idEstado=".$_GET['idEstado'];}
	if(isset($_GET['idDocPago']) && $_GET['idDocPago']!=''){          	       $SIS_where .= " AND bodegas_arriendos_facturacion.idDocPago=".$_GET['idDocPago'];}
	if(isset($_GET['N_DocPago']) && $_GET['N_DocPago']!=''){          	       $SIS_where .= " AND bodegas_arriendos_facturacion.N_DocPago LIKE '%".EstandarizarInput($_GET['N_DocPago'])."%'";}
	if(isset($_GET['idProducto']) && $_GET['idProducto']!=''){        	       $SIS_where .= " AND bodegas_arriendos_facturacion_existencias.idProducto=".$_GET['idProducto'];}
	if(isset($_GET['idEstadoDevolucion']) && $_GET['idEstadoDevolucion']!=''){ $SIS_where .= " AND bodegas_arriendos_facturacion.idEstadoDevolucion=".$_GET['idEstadoDevolucion'];}
	if(isset($_GET['Creacion_fecha_ini'], $_GET['Creacion_fecha_fin']) && $_GET['Creacion_fecha_ini'] != '' && $_GET['Creacion_fecha_fin']!=''){
		$SIS_where .= " AND bodegas_arriendos_facturacion.Creacion_fecha BETWEEN '".$_GET['Creacion_fecha_ini']."' AND '".$_GET['Creacion_fecha_fin']."'";
	}
	if(isset($_GET['Pago_fecha_ini'], $_GET['Pago_fecha_fin']) && $_GET['Pago_fecha_ini'] != '' && $_GET['Pago_fecha_fin']!=''){
		$SIS_where .= " AND bodegas_arriendos_facturacion.Pago_fecha BETWEEN '".$_GET['Pago_fecha_ini']."' AND '".$_GET['Pago_fecha_fin']."'";
	}
	if(isset($_GET['F_Pago_ini'], $_GET['F_Pago_fin']) && $_GET['F_Pago_ini'] != '' && $_GET['F_Pago_fin']!=''){
		$SIS_where .= " AND bodegas_arriendos_facturacion.F_Pago BETWEEN '".$_GET['F_Pago_ini']."' AND '".$_GET['F_Pago_fin']."'";
	}
	if(isset($_GET['F_Devolucion_ini'], $_GET['F_Devolucion_fin']) && $_GET['F_Devolucion_ini'] != '' && $_GET['F_Devolucion_fin']!=''){
		$SIS_where .= " AND bodegas_arriendos_facturacion.F_Pago BETWEEN '".$_GET['F_Devolucion_ini']."' AND '".$_GET['F_Devolucion_fin']."'";
	}
	$SIS_order = 0;
	$arrProductos = array();
	$arrProductos = db_select_array (false, $SIS_query, 'bodegas_arriendos_facturacion_existencias', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrProductos');

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 clearfix">
		<a target="new" href="<?php echo 'informe_bodega_arriendos_05_to_excel.php?bla=bla'.$search ; ?>" class="btn btn-sm btn-metis-2 pull-right margin_width"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Exportar a Excel</a>
	</div>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Productos de la bodega</h5>
			</header>
			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
							<th>Bodega</th>
							<th>Sistema</th>
							<th>Creacion fecha</th>
							<th>Creacion Semana</th>
							<th>Creacion mes</th>
							<th>Creacion año</th>
							<th>Documento tipo</th>
							<th>N Doc</th>
							<th>Tipo</th>
							<th>OT</th>
							<th>Trabajador</th>
							<th>Proveedor Nombre</th>
							<th>Cliente Nombre</th>
							<th>Vencimiento fecha</th>
							<th>Vencimiento dia</th>
							<th>Vencimiento Semana</th>
							<th>Vencimiento mes</th>
							<th>Vencimiento ano</th>
							<th>Estado</th>
							<th>Devolucion fecha</th>
							<th>Devolucion dia</th>
							<th>Devolucion Semana</th>
							<th>Devolucion mes</th>
							<th>Devolucion ano</th>
							<th>Estado Devolucion</th>
							<th>Documento Relacionado</th>
							<th>Usuario Pago</th>
							<th>Documento pago</th>
							<th>N Doc Pago</th>
							<th>F Pago</th>
							<th>F Pago dia</th>
							<th>F Pago mes</th>
							<th>F Pago ano</th>
							<th>Producto</th>
							<th>Cantidad ing</th>
							<th>Cantidad eg</th>
							<th>Valor</th>
							<th>Valor Total</th>
						</tr>
					</thead>

					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php foreach ($arrProductos as $productos) { ?>
							<tr class="odd">
								<td><?php echo $productos['Bodega_origen']; ?></td>
								<td><?php echo $productos['Sistema_origen']; ?></td>
								<td><?php echo $productos['Creacion_fecha']; ?></td>
								<td><?php echo $productos['Creacion_Semana']; ?></td>
								<td><?php echo $productos['Creacion_mes']; ?></td>
								<td><?php echo $productos['Creacion_ano']; ?></td>
								<td><?php echo $productos['Documento_tipo']; ?></td>
								<td><?php echo $productos['N_Doc']; ?></td>
								<td><?php echo $productos['Tipo']; ?></td>
								<td><?php echo $productos['idOT']; ?></td>
								<td><?php echo $productos['Trab_Nombre'].' '.$productos['Trab_ApellidoPat'].' '.$productos['Trab_ApellidoMat']; ?></td>
								<td><?php echo $productos['Prov_Nombre']; ?></td>
								<td><?php echo $productos['Cliente_Nombre']; ?></td>
								<td><?php echo $productos['Pago_fecha']; ?></td>
								<td><?php echo $productos['Pago_dia']; ?></td>
								<td><?php echo $productos['Pago_Semana']; ?></td>
								<td><?php echo $productos['Pago_mes']; ?></td>
								<td><?php echo $productos['Pago_ano']; ?></td>
								<td><?php echo $productos['Estado']; ?></td>
								<td><?php echo $productos['Devolucion_fecha']; ?></td>
								<td><?php echo $productos['Devolucion_dia']; ?></td>
								<td><?php echo $productos['Devolucion_Semana']; ?></td>
								<td><?php echo $productos['Devolucion_mes']; ?></td>
								<td><?php echo $productos['Devolucion_ano']; ?></td>
								<td><?php echo $productos['EstadoDevolucion']; ?></td>
								<td><?php echo $productos['DocRel']; ?></td>
								<td><?php echo $productos['UsuarioPago']; ?></td>
								<td><?php echo $productos['Documento_pago']; ?></td>
								<td><?php echo $productos['N_DocPago']; ?></td>
								<td><?php echo $productos['F_Pago']; ?></td>
								<td><?php echo $productos['F_Pago_dia']; ?></td>
								<td><?php echo $productos['F_Pago_mes']; ?></td>
								<td><?php echo $productos['F_Pago_ano']; ?></td>
								<td><?php echo $productos['Producto']; ?></td>
								<td><?php echo Cantidades_decimales_justos($productos['Cantidad_ing']); ?></td>
								<td><?php echo Cantidades_decimales_justos($productos['Cantidad_eg']); ?></td>
								<td><?php echo Cantidades_decimales_justos($productos['Valor']); ?></td>
								<td><?php echo Cantidades_decimales_justos($productos['ValorTotal']); ?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
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
	$z1 = "bodegas_arriendos_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
	$z2 = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']; 
	//Verifico el tipo de usuario que esta ingresando
	if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
		$z1 .= " AND usuarios_bodegas_arriendos.idUsuario = ".$_SESSION['usuario']['basic_data']['idUsuario'];
	}

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
					if(isset($idBodegaOrigen)){       $x1  = $idBodegaOrigen;        }else{$x1  = '';}
					if(isset($idBodegaDestino)){      $x2  = $idBodegaDestino;       }else{$x2  = '';}
					if(isset($idSistema)){            $x3  = $idSistema;             }else{$x3  = '';}
					if(isset($idSistemaDestino)){     $x4  = $idSistemaDestino;      }else{$x4  = '';}
					if(isset($Creacion_fecha_ini)){   $x5  = $Creacion_fecha_ini;    }else{$x5  = '';}
					if(isset($Creacion_fecha_fin)){   $x6  = $Creacion_fecha_fin;    }else{$x6  = '';}
					if(isset($idDocumentos)){         $x7  = $idDocumentos;          }else{$x7  = '';}
					if(isset($N_Doc)){                $x8  = $N_Doc;                 }else{$x8  = '';}
					if(isset($idTipo)){               $x9  = $idTipo;                }else{$x9  = '';}
					if(isset($idTrabajador)){         $x10 = $idTrabajador;          }else{$x10 = '';}
					if(isset($idProveedor)){          $x11 = $idProveedor;           }else{$x11 = '';}
					if(isset($idCliente)){            $x12 = $idCliente;             }else{$x12 = '';}
					if(isset($Pago_fecha_ini)){       $x13 = $Pago_fecha_ini;        }else{$x13 = '';}
					if(isset($Pago_fecha_fin)){       $x14 = $Pago_fecha_fin;        }else{$x14 = '';}
					if(isset($idEstado)){             $x15 = $idEstado;              }else{$x15 = '';}
					if(isset($idDocPago)){            $x16 = $idDocPago;             }else{$x16 = '';}
					if(isset($N_DocPago)){            $x17 = $N_DocPago;             }else{$x17 = '';}
					if(isset($F_Pago_ini)){           $x18 = $F_Pago_ini;            }else{$x18 = '';}
					if(isset($F_Pago_fin)){           $x19 = $F_Pago_fin;            }else{$x19 = '';}
					if(isset($F_Devolucion_ini)){     $x20 = $F_Devolucion_ini;      }else{$x20 = '';}
					if(isset($F_Devolucion_fin)){     $x21 = $F_Devolucion_fin;      }else{$x21 = '';}
					if(isset($idEquipo)){             $x22 = $idEquipo;              }else{$x22 = '';}
					if(isset($idEstadoDevolucion)){   $x23 = $idEstadoDevolucion;    }else{$x23 = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select_join_filter('Bodega Origen','idBodegaOrigen', $x1, 1, 'idBodega', 'Nombre', 'bodegas_arriendos_listado', 'usuarios_bodegas_arriendos', $z1, $dbConn);
					$Form_Inputs->form_select_join_filter('Bodega Destino','idBodegaDestino', $x2, 1, 'idBodega', 'Nombre', 'bodegas_arriendos_listado', 'usuarios_bodegas_arriendos', $z1, $dbConn);
					$Form_Inputs->form_select('Sistema Origen','idSistema', $x3, 1, 'idSistema', 'Nombre', 'core_sistemas',0, '', $dbConn);
					$Form_Inputs->form_select('Sistema Destino','idSistemaDestino', $x4, 1, 'idSistema', 'Nombre', 'core_sistemas',0, '', $dbConn);
					$Form_Inputs->form_date('F Creacion Ini','Creacion_fecha_ini', $x5, 1);
					$Form_Inputs->form_date('F Creacion Fin','Creacion_fecha_fin', $x6, 1);
					$Form_Inputs->form_select('Documento de Pago','idDocumentos', $x7, 1, 'idDocumentos', 'Nombre', 'core_documentos_mercantiles', 0, '', $dbConn);
					$Form_Inputs->form_input_number('N° Documento de Pago', 'N_Doc', $x8, 1);
					$Form_Inputs->form_select('Documento de Pago','idTipo', $x9, 1, 'idTipo', 'Nombre', 'bodegas_arriendos_facturacion_tipo', 0, '', $dbConn);
					$Form_Inputs->form_select_filter('Trabajador','idTrabajador', $x10, 1, 'idTrabajador', 'Rut,Nombre,ApellidoPat,ApellidoMat', 'trabajadores_listado', $z2, '', $dbConn);
					$Form_Inputs->form_select_filter('Proveedor','idProveedor', $x11, 1, 'idProveedor', 'Nombre', 'proveedor_listado', $z2, '', $dbConn);
					$Form_Inputs->form_select_filter('Cliente','idCliente', $x12, 1, 'idCliente', 'Nombre', 'clientes_listado', $z2, '', $dbConn);
					$Form_Inputs->form_date('F Vencimiento Ini','Pago_fecha_ini', $x13, 1);
					$Form_Inputs->form_date('F Vencimiento Fin','Pago_fecha_fin', $x14, 1);
					$Form_Inputs->form_select('Estado Pago','idEstado', $x15, 1, 'idEstado', 'Nombre', 'core_estado_facturacion', 0, '', $dbConn);
					$Form_Inputs->form_select('Documento de Pago','idDocPago', $x16, 1, 'idDocPago', 'Nombre', 'sistema_documentos_pago', 0, '', $dbConn);
					$Form_Inputs->form_input_number('N° Documento de Pago', 'N_DocPago', $x17, 1);
					$Form_Inputs->form_date('F Pago Ini','F_Pago_ini', $x18, 1);
					$Form_Inputs->form_date('F Pago Fin','F_Pago_fin', $x19, 1);
					$Form_Inputs->form_date('F Devolucion Ini','F_Devolucion_ini', $x20, 1);
					$Form_Inputs->form_date('F Devolucion Fin','F_Devolucion_fin', $x21, 1);
					$Form_Inputs->form_select_filter('Equipo Arrendado','idEquipo', $x22, 1, 'idEquipo', 'Nombre', 'equipos_arriendo_listado', 0, '', $dbConn);
					$Form_Inputs->form_select('Estado Devolucion','idEstadoDevolucion', $x23, 1, 'idEstadoDevolucion', 'Nombre', 'core_estado_devolucion', 0, '', $dbConn);

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
