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
$original = "informe_pagos_04.php";
$location = $original;
//Se agregan ubicaciones
$search ='&submit_filter=Filtrar';
if(isset($_GET['idCliente'])&&$_GET['idCliente']!=''){ $search .="&idCliente=".$_GET['idCliente'];}
if(isset($_GET['N_Doc'])&&$_GET['N_Doc']!=''){         $search .="&N_Doc=".$_GET['N_Doc'];}
if(isset($_GET['f_creacion_inicio'], $_GET['f_creacion_termino'])&&$_GET['f_creacion_inicio']!=''&&$_GET['f_creacion_termino']!=''){
	$search .="&f_creacion_inicio=".$_GET['f_creacion_inicio'];
	$search .="&f_creacion_termino=".$_GET['f_creacion_termino'];
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
//Variable de busqueda
$z1 = "WHERE bodegas_arriendos_facturacion.idEstado=1";
$z2 = "WHERE bodegas_insumos_facturacion.idEstado=1";
$z3 = "WHERE bodegas_productos_facturacion.idEstado=1";
$z4 = "WHERE bodegas_servicios_facturacion.idEstado=1";
//se traen solo las notas de credito
$z1.=" AND bodegas_arriendos_facturacion.idDocumentos=3";
$z2.=" AND bodegas_insumos_facturacion.idDocumentos=3";
$z3.=" AND bodegas_productos_facturacion.idDocumentos=3";
$z4.=" AND bodegas_servicios_facturacion.idDocumentos=3";
//Se verifica que no tengan documentos relacionados
$z1.=" AND bodegas_arriendos_facturacion.idFacturacionRelacionado=0";
$z2.=" AND bodegas_insumos_facturacion.idFacturacionRelacionado=0";
$z3.=" AND bodegas_productos_facturacion.idFacturacionRelacionado=0";
$z4.=" AND bodegas_servicios_facturacion.idFacturacionRelacionado=0";
//Verifico el tipo de usuario que esta ingresando
$z1.=" AND bodegas_arriendos_facturacion.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
$z2.=" AND bodegas_insumos_facturacion.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
$z3.=" AND bodegas_productos_facturacion.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
$z4.=" AND bodegas_servicios_facturacion.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
//Verifico que sean solo compras
$z1.=" AND bodegas_arriendos_facturacion.idTipo=13";
$z2.=" AND bodegas_insumos_facturacion.idTipo=13";
$z3.=" AND bodegas_productos_facturacion.idTipo=13";
$z4.=" AND bodegas_servicios_facturacion.idTipo=13";	

if(isset($_GET['idCliente'])&&$_GET['idCliente']!=''){  
	$z1.=" AND bodegas_arriendos_facturacion.idCliente=".$_GET['idCliente'];
	$z2.=" AND bodegas_insumos_facturacion.idCliente=".$_GET['idCliente'];
	$z3.=" AND bodegas_productos_facturacion.idCliente=".$_GET['idCliente'];
	$z4.=" AND bodegas_servicios_facturacion.idCliente=".$_GET['idCliente'];
}
if(isset($_GET['N_Doc'])&&$_GET['N_Doc']!=''){       
	$z1.=" AND bodegas_arriendos_facturacion.N_Doc=".$_GET['N_Doc'];
	$z2.=" AND bodegas_insumos_facturacion.N_Doc=".$_GET['N_Doc'];
	$z3.=" AND bodegas_productos_facturacion.N_Doc=".$_GET['N_Doc'];
	$z4.=" AND bodegas_servicios_facturacion.N_Doc=".$_GET['N_Doc'];
}
if(isset($_GET['f_creacion_inicio'], $_GET['f_creacion_termino'])&&$_GET['f_creacion_inicio']!=''&&$_GET['f_creacion_termino']!=''){
	$z1.=" AND bodegas_arriendos_facturacion.Creacion_fecha BETWEEN '".$_GET['f_creacion_inicio']."' AND '".$_GET['f_creacion_termino']."'";
	$z2.=" AND bodegas_insumos_facturacion.Creacion_fecha BETWEEN '".$_GET['f_creacion_inicio']."' AND '".$_GET['f_creacion_termino']."'";
	$z3.=" AND bodegas_productos_facturacion.Creacion_fecha BETWEEN '".$_GET['f_creacion_inicio']."' AND '".$_GET['f_creacion_termino']."'";
	$z4.=" AND bodegas_servicios_facturacion.Creacion_fecha BETWEEN '".$_GET['f_creacion_inicio']."' AND '".$_GET['f_creacion_termino']."'";
}

/*************************************************************************************/
// Se trae un listado con todos los elementos
$arrTipo1 = array();
$query = "SELECT 
bodegas_arriendos_facturacion.idFacturacion,
bodegas_arriendos_facturacion.Creacion_fecha,
bodegas_arriendos_facturacion.N_Doc,
core_sistemas.Nombre AS Sistema,
clientes_listado.Nombre AS Cliente,
bodegas_arriendos_facturacion.ValorTotal

FROM `bodegas_arriendos_facturacion`
LEFT JOIN `core_sistemas`      ON core_sistemas.idSistema      = bodegas_arriendos_facturacion.idSistema
LEFT JOIN `clientes_listado`   ON clientes_listado.idCliente   = bodegas_arriendos_facturacion.idCliente
".$z1;
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrTipo1,$row );
}
/*************************************************************************************/
// Se trae un listado con todos los elementos
$arrTipo2 = array();
$query = "SELECT 
bodegas_insumos_facturacion.idFacturacion,
bodegas_insumos_facturacion.Creacion_fecha,
bodegas_insumos_facturacion.N_Doc,
core_sistemas.Nombre AS Sistema,
clientes_listado.Nombre AS Cliente,
bodegas_insumos_facturacion.ValorTotal

FROM `bodegas_insumos_facturacion`
LEFT JOIN `core_sistemas`      ON core_sistemas.idSistema       = bodegas_insumos_facturacion.idSistema
LEFT JOIN `clientes_listado`   ON clientes_listado.idCliente    = bodegas_insumos_facturacion.idCliente
".$z2;
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrTipo2,$row );
}
/*************************************************************************************/
// Se trae un listado con todos los elementos
$arrTipo3 = array();
$query = "SELECT 
bodegas_productos_facturacion.idFacturacion,
bodegas_productos_facturacion.Creacion_fecha,
bodegas_productos_facturacion.N_Doc,
core_sistemas.Nombre AS Sistema,
clientes_listado.Nombre AS Cliente,
bodegas_productos_facturacion.ValorTotal

FROM `bodegas_productos_facturacion`
LEFT JOIN `core_sistemas`      ON core_sistemas.idSistema       = bodegas_productos_facturacion.idSistema
LEFT JOIN `clientes_listado`   ON clientes_listado.idCliente    = bodegas_productos_facturacion.idCliente
".$z3;
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrTipo3,$row );
}
/*************************************************************************************/
// Se trae un listado con todos los elementos
$arrTipo4 = array();
$query = "SELECT 
bodegas_servicios_facturacion.idFacturacion,
bodegas_servicios_facturacion.Creacion_fecha,
bodegas_servicios_facturacion.N_Doc,
core_sistemas.Nombre AS Sistema,
clientes_listado.Nombre AS Cliente,
bodegas_servicios_facturacion.ValorTotal

FROM `bodegas_servicios_facturacion`
LEFT JOIN `core_sistemas`      ON core_sistemas.idSistema      = bodegas_servicios_facturacion.idSistema
LEFT JOIN `clientes_listado`   ON clientes_listado.idCliente   = bodegas_servicios_facturacion.idCliente
".$z4;
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrTipo4,$row );
}

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Documentos</h5>
		</header>
		<div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th>Cliente</th>
						<th>Documento</th>
						<th>Fecha de Ingreso</th>
						<th>Valor Total</th>
						<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><th width="160">Sistema</th><?php } ?>
						<th width="10">Acciones</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<tr class="odd"><td style="background-color:#DDD" colspan="<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){echo '8';}else{echo '7';} ?>">Arriendos</td></tr>
					<?php foreach ($arrTipo1 as $tipo) { ?>
						<tr class="odd">
							<td><?php echo $tipo['Cliente']; ?></td>
							<td><?php echo 'Nota de Credito N°'.$tipo['N_Doc']; ?></td>
							<td><?php echo Fecha_estandar($tipo['Creacion_fecha']); ?></td>
							<td align="right"><?php echo Valores($tipo['ValorTotal'], 0); ?></td>
							<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><td><?php echo $tipo['Sistema']; ?></td><?php } ?>
							<td>
								<div class="btn-group" style="width: 35px;" >
									<a href="<?php echo 'view_mov_arriendos.php?view='.simpleEncode($tipo['idFacturacion'], fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
								</div>
							</td>
						</tr>
					<?php } ?>
					<tr class="odd"><td style="background-color:#DDD" colspan="<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){echo '8';}else{echo '7';} ?>">Insumos</td></tr>
					<?php foreach ($arrTipo2 as $tipo) { ?>
						<tr class="odd">
							<td><?php echo $tipo['Cliente']; ?></td>
							<td><?php echo 'Nota de Credito N°'.$tipo['N_Doc']; ?></td>
							<td><?php echo Fecha_estandar($tipo['Creacion_fecha']); ?></td>
							<td align="right"><?php echo Valores($tipo['ValorTotal'], 0); ?></td>
							<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><td><?php echo $tipo['Sistema']; ?></td><?php } ?>
							<td>
								<div class="btn-group" style="width: 35px;" >
									<a href="<?php echo 'view_mov_insumos.php?view='.simpleEncode($tipo['idFacturacion'], fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
								</div>
							</td>
						</tr>
					<?php } ?>
					<tr class="odd"><td style="background-color:#DDD" colspan="<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){echo '8';}else{echo '7';} ?>">Productos</td></tr>
					<?php foreach ($arrTipo3 as $tipo) { ?>
						<tr class="odd">
							<td><?php echo $tipo['Cliente']; ?></td>
							<td><?php echo 'Nota de Credito N°'.$tipo['N_Doc']; ?></td>
							<td><?php echo Fecha_estandar($tipo['Creacion_fecha']); ?></td>
							<td align="right"><?php echo Valores($tipo['ValorTotal'], 0); ?></td>
							<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><td><?php echo $tipo['Sistema']; ?></td><?php } ?>
							<td>
								<div class="btn-group" style="width: 35px;" >
									<a href="<?php echo 'view_mov_productos.php?view='.simpleEncode($tipo['idFacturacion'], fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
								</div>
							</td>
						</tr>
					<?php } ?>
					<tr class="odd"><td style="background-color:#DDD" colspan="<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){echo '8';}else{echo '7';} ?>">Servicios</td></tr>
					<?php foreach ($arrTipo4 as $tipo) { ?>
						<tr class="odd">
							<td><?php echo $tipo['Cliente']; ?></td>
							<td><?php echo 'Nota de Credito N°'.$tipo['N_Doc']; ?></td>
							<td><?php echo Fecha_estandar($tipo['Creacion_fecha']); ?></td>
							<td align="right"><?php echo Valores($tipo['ValorTotal'], 0); ?></td>
							<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><td><?php echo $tipo['Sistema']; ?></td><?php } ?>
							<td>
								<div class="btn-group" style="width: 35px;" >
									<a href="<?php echo 'view_mov_servicios.php?view='.simpleEncode($tipo['idFacturacion'], fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
								</div>
							</td>
						</tr>
					<?php } ?>
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
				if(isset($idCliente)){            $x1  = $idCliente;           }else{$x1  = '';}
				if(isset($N_Doc)){                $x3  = $N_Doc;               }else{$x3  = '';}
				if(isset($f_creacion_inicio)){    $x4  = $f_creacion_inicio;   }else{$x4  = '';}
				if(isset($f_creacion_termino)){   $x5  = $f_creacion_termino;  }else{$x5  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_tittle(3, 'Emision');
				$Form_Inputs->form_select_filter('Cliente','idCliente', $x1, 1, 'idCliente', 'Nombre', 'clientes_listado', $z, '', $dbConn);
				$Form_Inputs->form_input_number('N° Documento', 'N_Doc', $x3, 1);
				$Form_Inputs->form_date('Fecha Creacion Desde','f_creacion_inicio', $x4, 1);
				$Form_Inputs->form_date('Fecha Creacion Hasta','f_creacion_termino', $x5, 1);

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
