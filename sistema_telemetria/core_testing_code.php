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
//Verifico si es superusuario
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Type.php';
/**********************************************************************************************************************************/
/*                                          Modulo de identificacion del documento                                                */
/**********************************************************************************************************************************/
//Cargamos la ubicacion original
$original = "core_testing_code.php";
$location = $original;
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['test_function'])){
	//Values
	$val_factual     = '32';
	$val_factual_val = '10';
	//encode
	$enco1 = simpleEncode($val_factual, fecha_actual());
	$enco2 = simpleEncode($val_factual_val, fecha_actual_val());
	//decode
	$deco1 = simpleDecode($enco1, fecha_actual());
	$deco2 = simpleDecode($enco2, fecha_actual_val());

	?>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
				<h5>Testeo de Funciones</h5>
			</header>
			<div class="tab-content">

				<div class="table-responsive">
					<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
						<thead>
							<tr role="row">
								<th width="100">Dato</th>
								<th>Info</th>
							</tr>
						</thead>
						<tbody role="alert" aria-live="polite" aria-relevant="all">
							<tr class="odd"><td>fecha_actual</td>       <td><?php echo fecha_actual(); ?></td></tr>
							<tr class="odd"><td>fecha_actual_val</td>   <td><?php echo fecha_actual_val(); ?></td></tr>
							<tr class="odd"><td>hora_actual</td>       <td><?php echo hora_actual(); ?></td></tr>
							<tr class="odd"><td>hora_actual_val</td>       <td><?php echo hora_actual_val(); ?></td></tr>
							<tr class="odd"><td>dia_actual</td>       <td><?php echo dia_actual(); ?></td></tr>
							<tr class="odd"><td>semana_actual</td>       <td><?php echo semana_actual(); ?></td></tr>
							<tr class="odd"><td>mes_actual</td>       <td><?php echo mes_actual(); ?></td></tr>
							<tr class="odd"><td>ano_actual</td>       <td><?php echo ano_actual(); ?></td></tr>
							<tr class="odd"><td>genera_password_unica</td>       <td><?php echo genera_password_unica(); ?></td></tr>
							<tr class="odd"><td>generateServerSpecificHash</td>       <td><?php echo generateServerSpecificHash(); ?></td></tr>


							<tr class="odd"><td>Fecha Archivos</td>     <td><?php echo Fecha_archivos(fecha_actual()); ?></td></tr>

							<tr class="odd"><td>simpleEncode Fecha Actual</td>       <td><?php echo $enco1; ?></td></tr>
							<tr class="odd"><td>simpleEncode Fecha Actual Val</td>   <td><?php echo $enco2; ?></td></tr>

							<tr class="odd"><td>simpleDecode Fecha Actual</td>       <td><?php echo $deco1; ?></td></tr>
							<tr class="odd"><td>simpleDecode Fecha Actual Val</td>   <td><?php echo $deco2; ?></td></tr>

						</tbody>
					</table>
				</div>

			</div>
		</div>
	</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['test_proyecciones'])){
	//Libreria
	require_once '../LIBS_php/PHP_ML/vendor/autoload.php';
	//Funcion
	//use Phpml\Regression\LeastSquares;

	$arrContador     = array();
	$arrTemperatura  = array();

	$temp = 10;
	$n_Prediccion = 2;

	for ($counter = 1; $counter <= 10; $counter++) {
		$temp++;
		$arrContador[$counter][0]   = $counter;
		//$arrTemperatura[$counter]   = str_replace(',', '.', cantidades($temp, 2));
		$arrTemperatura[$counter]   = cantidades_google(cantidades($temp, 2));
	}

	echo '<pre>';
	var_dump($arrTemperatura);
	echo '</pre>';

	$regression = new Phpml\Regression\LeastSquares();
	$regression->train($arrContador, $arrTemperatura);
	//se guarda dato (60 datos por 5 horas + 36 datos por 3 horas a futuro)
	$Helada = $regression->predict([$n_Prediccion]);

	echo $Helada;
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['test_logo'])){

	//variables
	$email     = 'tenshi98@gmail.com';
	$Nombre    = 'test';
	$usuario   = 'test';
	$idSistema = 1;

	//logo de la compañia
	$login_logo = DB_SITE_MAIN.'/img/login_logo.png';
	$login_logo2 = 'img/login_logo.png';

	//solo si existe
	if (file_exists($login_logo2)){
		//envio de correo
		try {

			//se consulta el correo
			$rowusr = db_select_data (false, 'Nombre,email_principal, core_sistemas.Config_Gmail_Usuario AS Gmail_Usuario, core_sistemas.Config_Gmail_Password AS Gmail_Password', 'core_sistemas','', 'idSistema='.$idSistema, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowusr');

			//Se crea el cuerpo
			$BodyMail  = '<div style="background-color: #D9D9D9; padding: 10px;">';
			$BodyMail .= '<img src="'.$login_logo.'" style="width: 60%;display:block;margin-left: auto;margin-right: auto;margin-top:30px;margin-bottom:30px;">';
			$BodyMail .= '<h3 style="text-align: center;font-size: 30px;">';
			$BodyMail .= '¡Hola <strong>'.$Nombre.'</strong>!<br/>';
			$BodyMail .= 'Bienvenido/a a <strong>'.$rowusr['Nombre'].'</strong>';
			$BodyMail .= '</h3>';
			$BodyMail .= '<p style="text-align: center;font-size: 20px;">';
			$BodyMail .= 'Tu usuario es: <strong>'.$usuario.'</strong><br/>';
			$BodyMail .= 'La contraseña predeterminada es <strong>1234</strong>, luego el sistema te pedira cambiarla una vez iniciada sesion por primera vez.';
			$BodyMail .= '</p>';
			$BodyMail .= '<a href="'.DB_SITE_MAIN.'" style="display:block;width:100%;text-align: center;font-size: 20px;text-decoration: none;color: #004AAD;"><strong>Empezar &#8594;</strong></a>';
			$BodyMail .= '</div>';

			$rmail = tareas_envio_correo($rowusr['email_principal'], $rowusr['Nombre'],
										 $email, $Nombre,
										 '', '',
										 'Registro de Usuario',
										 $BodyMail,'',
										 '',
										 1,
										 $rowusr['Gmail_Usuario'],
										 $rowusr['Gmail_Password']);
			//se guarda el log
			log_response(1, $rmail, $email.' (Asunto:Registro de Usuario)');

			echo "correo de test enviado";
		} catch (Exception $e) {
			echo "error de test:".$e->getMessage();
		}
	}else{
		echo "logo no existe (".$login_logo.")";
	}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['test_fnx'])){

	$rowData = db_select_data (false, 'Nombre', 'core_sistemas','', 'idSistema=1', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'test_fnx');
	echo 'Nombre Sistema 1:'.$rowData['Nombre'].'<br/>';
	$rowData = db_select_nrows (false, 'idSistema', 'core_sistemas','', 'Nombre="Empresa 1"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'test_fnx');
	echo 'numero Sistema 1:'.$rowData.'<br/>';

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['fact_repair'])){
	/*******************************************************/
	// consulto los datos
	$SIS_query = '
	pagos_facturas_clientes.idPago,
	pagos_facturas_clientes.idTipo,
	pagos_facturas_clientes.idFacturacion,
	pagos_facturas_clientes.MontoPagado AS MontoPagado,

	Factura_Arr.ValorTotal AS Arriendos_MontoFactura,
	NotaCredito_Arr.ValorTotal AS Arriendos_MontoNotaCredito,

	Factura_Ins.ValorTotal AS Insumos_MontoFactura,
	NotaCredito_Ins.ValorTotal AS Insumos_MontoNotaCredito,

	Factura_Prod.ValorTotal AS Productos_MontoFactura,
	NotaCredito_Prod.ValorTotal AS Productos_MontoNotaCredito,

	Factura_Serv.ValorTotal AS Servicios_MontoFactura,
	NotaCredito_Serv.ValorTotal AS Servicios_MontoNotaCredito';
	$SIS_join  = '
	LEFT JOIN `bodegas_arriendos_facturacion`  Factura_Arr       ON Factura_Arr.idFacturacion                   = pagos_facturas_clientes.idFacturacion
	LEFT JOIN `bodegas_arriendos_facturacion`  NotaCredito_Arr   ON NotaCredito_Arr.idFacturacionRelacionado    = pagos_facturas_clientes.idFacturacion
	LEFT JOIN `bodegas_insumos_facturacion`    Factura_Ins       ON Factura_Ins.idFacturacion                   = pagos_facturas_clientes.idFacturacion
	LEFT JOIN `bodegas_insumos_facturacion`    NotaCredito_Ins   ON NotaCredito_Ins.idFacturacionRelacionado    = pagos_facturas_clientes.idFacturacion
	LEFT JOIN `bodegas_productos_facturacion`  Factura_Prod      ON Factura_Prod.idFacturacion                  = pagos_facturas_clientes.idFacturacion
	LEFT JOIN `bodegas_productos_facturacion`  NotaCredito_Prod  ON NotaCredito_Prod.idFacturacionRelacionado   = pagos_facturas_clientes.idFacturacion
	LEFT JOIN `bodegas_servicios_facturacion`  Factura_Serv      ON Factura_Serv.idFacturacion                  = pagos_facturas_clientes.idFacturacion
	LEFT JOIN `bodegas_servicios_facturacion`  NotaCredito_Serv  ON NotaCredito_Serv.idFacturacionRelacionado   = pagos_facturas_clientes.idFacturacion';
	$SIS_where = '';
	$SIS_order = 0;
	$arrPagosClientes = array();
	$arrPagosClientes = db_select_array (false, $SIS_query, 'pagos_facturas_clientes', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'test_logo');

	/*******************************************************/
	// consulto los datos
	$SIS_query = '
	pagos_facturas_proveedores.idPago,
	pagos_facturas_proveedores.idTipo,
	pagos_facturas_proveedores.idFacturacion,
	pagos_facturas_proveedores.MontoPagado AS MontoPagado,

	Factura_Arr.ValorTotal AS Arriendos_MontoFactura,
	NotaCredito_Arr.ValorTotal AS Arriendos_MontoNotaCredito,

	Factura_Ins.ValorTotal AS Insumos_MontoFactura,
	NotaCredito_Ins.ValorTotal AS Insumos_MontoNotaCredito,

	Factura_Prod.ValorTotal AS Productos_MontoFactura,
	NotaCredito_Prod.ValorTotal AS Productos_MontoNotaCredito,

	Factura_Serv.ValorTotal AS Servicios_MontoFactura,
	NotaCredito_Serv.ValorTotal AS Servicios_MontoNotaCredito';
	$SIS_join  = '
	LEFT JOIN `bodegas_arriendos_facturacion`  Factura_Arr       ON Factura_Arr.idFacturacion                   = pagos_facturas_proveedores.idFacturacion
	LEFT JOIN `bodegas_arriendos_facturacion`  NotaCredito_Arr   ON NotaCredito_Arr.idFacturacionRelacionado    = pagos_facturas_proveedores.idFacturacion
	LEFT JOIN `bodegas_insumos_facturacion`    Factura_Ins       ON Factura_Ins.idFacturacion                   = pagos_facturas_proveedores.idFacturacion
	LEFT JOIN `bodegas_insumos_facturacion`    NotaCredito_Ins   ON NotaCredito_Ins.idFacturacionRelacionado    = pagos_facturas_proveedores.idFacturacion
	LEFT JOIN `bodegas_productos_facturacion`  Factura_Prod      ON Factura_Prod.idFacturacion                  = pagos_facturas_proveedores.idFacturacion
	LEFT JOIN `bodegas_productos_facturacion`  NotaCredito_Prod  ON NotaCredito_Prod.idFacturacionRelacionado   = pagos_facturas_proveedores.idFacturacion
	LEFT JOIN `bodegas_servicios_facturacion`  Factura_Serv      ON Factura_Serv.idFacturacion                  = pagos_facturas_proveedores.idFacturacion
	LEFT JOIN `bodegas_servicios_facturacion`  NotaCredito_Serv  ON NotaCredito_Serv.idFacturacionRelacionado   = pagos_facturas_proveedores.idFacturacion';
	$SIS_where = '';
	$SIS_order = 0;
	$arrPagosProveedores = array();
	$arrPagosProveedores = db_select_array (false, $SIS_query, 'pagos_facturas_proveedores', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'test_logo');


	/*******************************************************/
	//recorro
	foreach ($arrPagosClientes as $pagos) {
		//Tipo de pago
		switch ($pagos['idTipo']) {
			//Factura Insumos
			case 1:
				//Si factura es igual a nota de credito
				if($pagos['Insumos_MontoFactura']==$pagos['Insumos_MontoNotaCredito']){
					//elimino el pago
					$query  = "DELETE FROM `pagos_facturas_clientes` WHERE idPago = ".$pagos['idPago'];
					echo $query.';<br/>';
					//cambio el estado de la factura a eliminado
					$query  = "UPDATE bodegas_insumos_facturacion SET idEstado = '3' WHERE idFacturacion = ".$pagos['idFacturacion'];
					echo $query.';<br/><br/>';
				//si no lo es
				}elseif($pagos['Insumos_MontoFactura']!=$pagos['Insumos_MontoNotaCredito']&&$pagos['Insumos_MontoNotaCredito']!=0){
					//actualizo el valor del pago
					$nuevo_valor = $pagos['MontoPagado'] - $pagos['Insumos_MontoNotaCredito'];
					$query  = "UPDATE pagos_facturas_clientes SET MontoPagado = '".$nuevo_valor."' WHERE idPago = ".$pagos['idPago'];
					echo $query.';<br/><br/>';
				}
				break;
			//Factura Productos
			case 2:
				//Si factura es igual a nota de credito
				if($pagos['Productos_MontoFactura']==$pagos['Productos_MontoNotaCredito']){
					//elimino el pago
					$query  = "DELETE FROM `pagos_facturas_clientes` WHERE idPago = ".$pagos['idPago'];
					echo $query.';<br/>';
					//cambio el estado de la factura a eliminado
					$query  = "UPDATE bodegas_productos_facturacion SET idEstado = '3' WHERE idFacturacion = ".$pagos['idFacturacion'];
					echo $query.';<br/><br/>';
				//si no lo es
				}elseif($pagos['Productos_MontoFactura']!=$pagos['Productos_MontoNotaCredito']&&$pagos['Productos_MontoNotaCredito']!=0){
					//actualizo el valor del pago
					$nuevo_valor = $pagos['MontoPagado'] - $pagos['Productos_MontoNotaCredito'];
					$query  = "UPDATE pagos_facturas_clientes SET MontoPagado = '".$nuevo_valor."' WHERE idPago = ".$pagos['idPago'];
					echo $query.';<br/><br/>';
				}
				break;
			//Factura Servicios
			case 3:
				//Si factura es igual a nota de credito
				if($pagos['Servicios_MontoFactura']==$pagos['Servicios_MontoNotaCredito']){
					//elimino el pago
					$query  = "DELETE FROM `pagos_facturas_clientes` WHERE idPago = ".$pagos['idPago'];
					echo $query.';<br/>';
					//cambio el estado de la factura a eliminado
					$query  = "UPDATE bodegas_servicios_facturacion SET idEstado = '3' WHERE idFacturacion = ".$pagos['idFacturacion'];
					echo $query.';<br/><br/>';
				//si no lo es
				}elseif($pagos['Servicios_MontoFactura']!=$pagos['Servicios_MontoNotaCredito']&&$pagos['Servicios_MontoNotaCredito']!=0){
					//actualizo el valor del pago
					$nuevo_valor = $pagos['MontoPagado'] - $pagos['Servicios_MontoNotaCredito'];
					$query  = "UPDATE pagos_facturas_clientes SET MontoPagado = '".$nuevo_valor."' WHERE idPago = ".$pagos['idPago'];
					echo $query.';<br/><br/>';
				}
				break;
			//Factura Arriendos
			case 4:
				//Si factura es igual a nota de credito
				if($pagos['Arriendos_MontoFactura']==$pagos['Arriendos_MontoNotaCredito']){
					//elimino el pago
					$query  = "DELETE FROM `pagos_facturas_clientes` WHERE idPago = ".$pagos['idPago'];
					echo $query.';<br/>';
					//cambio el estado de la factura a eliminado
					$query  = "UPDATE bodegas_arriendos_facturacion SET idEstado = '3' WHERE idFacturacion = ".$pagos['idFacturacion'];
					echo $query.';<br/><br/>';
				//si no lo es
				}elseif($pagos['Arriendos_MontoFactura']!=$pagos['Arriendos_MontoNotaCredito']&&$pagos['Arriendos_MontoNotaCredito']!=0){
					//actualizo el valor del pago
					$nuevo_valor = $pagos['MontoPagado'] - $pagos['Arriendos_MontoNotaCredito'];
					$query  = "UPDATE pagos_facturas_clientes SET MontoPagado = '".$nuevo_valor."' WHERE idPago = ".$pagos['idPago'];
					echo $query.';<br/><br/>';
				}
				break;
		}
	}
	echo '//////////////////////////////////////////////////////////////////////////<br/><br/>';
	/*******************************************************/
	//recorro
	foreach ($arrPagosProveedores as $pagos) {
		//Tipo de pago
		switch ($pagos['idTipo']) {
			//Factura Insumos
			case 1:
				//Si factura es igual a nota de credito
				if($pagos['Insumos_MontoFactura']==$pagos['Insumos_MontoNotaCredito']){
					//elimino el pago
					$query  = "DELETE FROM `pagos_facturas_proveedores` WHERE idPago = ".$pagos['idPago'];
					echo $query.';<br/>';
					//cambio el estado de la factura a eliminado
					$query  = "UPDATE bodegas_insumos_facturacion SET idEstado = '3' WHERE idFacturacion = ".$pagos['idFacturacion'];
					echo $query.';<br/><br/>';
				//si no lo es
				}elseif($pagos['Insumos_MontoFactura']!=$pagos['Insumos_MontoNotaCredito']&&$pagos['Insumos_MontoNotaCredito']!=0){
					//actualizo el valor del pago
					$nuevo_valor = $pagos['MontoPagado'] - $pagos['Insumos_MontoNotaCredito'];
					$query  = "UPDATE pagos_facturas_proveedores SET MontoPagado = '".$nuevo_valor."' WHERE idPago = ".$pagos['idPago'];
					echo $query.';<br/><br/>';
				}
				break;
			//Factura Productos
			case 2:
				//Si factura es igual a nota de credito
				if($pagos['Productos_MontoFactura']==$pagos['Productos_MontoNotaCredito']){
					//elimino el pago
					$query  = "DELETE FROM `pagos_facturas_proveedores` WHERE idPago = ".$pagos['idPago'];
					echo $query.';<br/>';
					//cambio el estado de la factura a eliminado
					$query  = "UPDATE bodegas_productos_facturacion SET idEstado = '3' WHERE idFacturacion = ".$pagos['idFacturacion'];
					echo $query.';<br/><br/>';
				//si no lo es
				}elseif($pagos['Productos_MontoFactura']!=$pagos['Productos_MontoNotaCredito']&&$pagos['Productos_MontoNotaCredito']!=0){
					//actualizo el valor del pago
					$nuevo_valor = $pagos['MontoPagado'] - $pagos['Productos_MontoNotaCredito'];
					$query  = "UPDATE pagos_facturas_proveedores SET MontoPagado = '".$nuevo_valor."' WHERE idPago = ".$pagos['idPago'];
					echo $query.';<br/><br/>';
				}
				break;
			//Factura Servicios
			case 3:
				//Si factura es igual a nota de credito
				if($pagos['Servicios_MontoFactura']==$pagos['Servicios_MontoNotaCredito']){
					//elimino el pago
					$query  = "DELETE FROM `pagos_facturas_proveedores` WHERE idPago = ".$pagos['idPago'];
					echo $query.';<br/>';
					//cambio el estado de la factura a eliminado
					$query  = "UPDATE bodegas_servicios_facturacion SET idEstado = '3' WHERE idFacturacion = ".$pagos['idFacturacion'];
					echo $query.';<br/><br/>';
				//si no lo es
				}elseif($pagos['Servicios_MontoFactura']!=$pagos['Servicios_MontoNotaCredito']&&$pagos['Servicios_MontoNotaCredito']!=0){
					//actualizo el valor del pago
					$nuevo_valor = $pagos['MontoPagado'] - $pagos['Servicios_MontoNotaCredito'];
					$query  = "UPDATE pagos_facturas_proveedores SET MontoPagado = '".$nuevo_valor."' WHERE idPago = ".$pagos['idPago'];
					echo $query.';<br/><br/>';
				}
				break;
			//Factura Arriendos
			case 4:
				//Si factura es igual a nota de credito
				if($pagos['Arriendos_MontoFactura']==$pagos['Arriendos_MontoNotaCredito']){
					//elimino el pago
					$query  = "DELETE FROM `pagos_facturas_proveedores` WHERE idPago = ".$pagos['idPago'];
					echo $query.';<br/>';
					//cambio el estado de la factura a eliminado
					$query  = "UPDATE bodegas_arriendos_facturacion SET idEstado = '3' WHERE idFacturacion = ".$pagos['idFacturacion'];
					echo $query.';<br/><br/>';
				//si no lo es
				}elseif($pagos['Arriendos_MontoFactura']!=$pagos['Arriendos_MontoNotaCredito']&&$pagos['Arriendos_MontoNotaCredito']!=0){
					//actualizo el valor del pago
					$nuevo_valor = $pagos['MontoPagado'] - $pagos['Arriendos_MontoNotaCredito'];
					$query  = "UPDATE pagos_facturas_proveedores SET MontoPagado = '".$nuevo_valor."' WHERE idPago = ".$pagos['idPago'];
					echo $query.';<br/><br/>';
				}
				break;
		}
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['test_cross'])){
	//variables
	$idPredio = 1;
	/*******************************************************/
	// consulto los datos
	$SIS_query = 'Nombre';
	$SIS_join  = '';
	$SIS_where = 'idPredio = '.$idPredio;
	$rowData = db_select_data (false, $SIS_query, 'cross_predios_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'test_logo');

	/*******************************************************/
	// consulto los datos
	$SIS_query = '
	cross_predios_listado_zonas.idZona,
	cross_predios_listado_zonas.Nombre,
	cross_predios_listado_zonas_ubicaciones.Latitud,
	cross_predios_listado_zonas_ubicaciones.Longitud';
	$SIS_join  = 'cross_predios_listado_zonas_ubicaciones` ON cross_predios_listado_zonas_ubicaciones.idZona = cross_predios_listado_zonas.idZona';
	$SIS_where = 'cross_predios_listado_zonas.idPredio = '.$idPredio;
	$SIS_order = 'cross_predios_listado_zonas.idZona ASC,cross_predios_listado_zonas_ubicaciones.idUbicaciones ASC';
	$arrZonas = array();
	$arrZonas = db_select_array (false, $SIS_query, 'cross_predios_listado_zonas', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'test_logo');

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Puntos del Cuartel <?php echo $rowData['Nombre']; ?></h5>
			</header>
			<div class="table-responsive">

				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
					<div class="row">
						<?php
						//Si no existe una ID se utiliza una por defecto
						if(!isset($_SESSION['usuario']['basic_data']['Config_IDGoogle']) OR $_SESSION['usuario']['basic_data']['Config_IDGoogle']==''){
							$Alert_Text  = 'No ha ingresado Una API de Google Maps.';
							alert_post_data(4,2,2,0, $Alert_Text);
						}else{
							$google = $_SESSION['usuario']['basic_data']['Config_IDGoogle'];

							if(isset($_GET['Latitud'])&&isset($_GET['Longitud'])&&$_GET['Latitud']!=''&&$_GET['Longitud']!=''){
								$Latitud = $_GET['Latitud'];
								$Longitud = $_GET['Longitud'];
							}else{
								$Latitud = -33.477271996598965;
								$Longitud = -70.65170304882815;
							}
							?>

							<script async src="https://maps.googleapis.com/maps/api/js?key=<?php echo $google; ?>&callback=initMap"></script>
							<div id="map_canvas" style="width: 100%; height: 550px;"></div>
							<script>
								let map;
								var marker;

								async function initMap() {
									const { Map } = await google.maps.importLibrary("maps");

									var myLatlng = new google.maps.LatLng(<?php echo $Latitud; ?>, <?php echo $Longitud; ?>);

									var myOptions = {
										zoom: 16,
										center: myLatlng,
										mapTypeId: google.maps.MapTypeId.ROADMAP
									};

									map = new Map(document.getElementById("map_canvas"), myOptions);

									marker = new google.maps.Marker({
										draggable	: true,
										position	: myLatlng,
										map			: map,
										title		: "Tu Ubicación",
										animation 	:google.maps.Animation.DROP,
										icon      	:"<?php echo DB_SITE_REPO ?>/LIB_assets/img/map-icons/1_series_orange.png"
									});

									google.maps.event.addListener(marker, 'dragend', function (event) {

										document.getElementById("Latitud").value = event.latLng.lat();
										document.getElementById("Longitud").value = event.latLng.lng();

										document.getElementById("Latitud_fake").value = event.latLng.lat();
										document.getElementById("Longitud_fake").value = event.latLng.lng();

									});

									//RutasAlternativas();
									dibuja_zona();

								}
								/* ************************************************************************** */
								function dibuja_zona() {

									var polygons = [];
									<?php
									//Se filtra por zona
									filtrar($arrZonas, 'idZona');
									//se recorre
									foreach ($arrZonas as $todaszonas=>$zonas) {

										echo 'var path'.$todaszonas.' = [';

										//Variables con la primera posicion
										$Latitud_x = '';
										$Longitud_x = '';

										foreach ($zonas as $puntos) {
											echo '{lat: '.$puntos['Latitud'].', lng: '.$puntos['Longitud'].'},
											';
											if(isset($puntos['Latitud'])&&$puntos['Latitud']!='0'){
												$Latitud_x = $puntos['Latitud'];
												$Longitud_x = $puntos['Longitud'];
											}
										}

										if(isset($Longitud_x)&&$Longitud_x!=''){
											echo '{lat: '.$Latitud_x.', lng: '.$Longitud_x.'}';
										}

										echo '];';

										echo '
										polygons.push(new google.maps.Polygon({
											paths: path'.$todaszonas.',
											strokeColor: \'#FF0000\',
											strokeOpacity: 0.8,
											strokeWeight: 2,
											fillColor: \'#FF0000\',
											fillOpacity: 0.35
										}));
										polygons[polygons.length-1].setMap(map);
										';

									} ?>
								}

							</script>
						<?php } ?>
					</div>
				</div>

				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
					<div style="margin-top:20px;">
						<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" autocomplete="off" novalidate>

							<?php
							//Deteccion de Zona
							$pointLocation = new subpointLocation();
							$nx_zona = 0;
							foreach ($arrZonas as $todaszonas=>$zonas) {
								//arreglo para el pligono
								$polygon = array();
								//variables para cerrar el poligono
								$ini     = 0;
								$f_lat   = 0;
								$f_long  = 0;
								//recorro las zonas
								foreach ($zonas as $puntos) {
									array_push( $polygon,$puntos['Latitud'].' '.$puntos['Longitud'] );
									//echo 'geo='.$puntos['Latitud'].' '.$puntos['Longitud'].'<br/>';
									//si es el primer dato
									if($ini==0){
										$f_lat  = $puntos['Latitud'];
										$f_long = $puntos['Longitud'];
									}
									$ini++;
								}
								//inserto el primer dato como el ultimo para cerrar poligono
								array_push( $polygon,$f_lat.' '.$f_long );
								//verifico
								$c_chek =  $pointLocation->pointInPolygon($Latitud.' '.$Longitud, $polygon);
								if($c_chek=='inside'){
									if($nx_zona==0){
										$nx_zona = $todaszonas;
									}
								}
								//echo 'c_chek='.$c_chek.'<br/>';
							}

							/********************************************************/
							//Inputs
							if(isset($idTelemetria)){   $x1  = $idTelemetria;  }elseif(isset($_GET['idTelemetria'])&&$_GET['idTelemetria']!=''){   $x1  = $_GET['idTelemetria'];   }else{$x1  = '';}
							if(isset($GeoVelocidad)){   $x3  = $GeoVelocidad;  }elseif(isset($_GET['GeoVelocidad'])&&$_GET['GeoVelocidad']!=''){   $x3  = $_GET['GeoVelocidad'];   }else{$x3  = '';}
							if(isset($GeoMovimiento)){  $x4  = $GeoMovimiento; }elseif(isset($_GET['GeoMovimiento'])&&$_GET['GeoMovimiento']!=''){ $x4  = $_GET['GeoMovimiento'];  }else{$x4  = '';}
							if(isset($Sensor_1)){       $x5  = $Sensor_1;      }elseif(isset($_GET['Sensor_1'])&&$_GET['Sensor_1']!=''){    $x5  = $_GET['Sensor_1'];       }else{$x5  = '';}
							if(isset($Sensor_2)){       $x6  = $Sensor_2;      }elseif(isset($_GET['Sensor_2'])&&$_GET['Sensor_2']!=''){    $x6  = $_GET['Sensor_2'];       }else{$x6  = '';}
							if(isset($Sensor_3)){       $x7  = $Sensor_3;      }elseif(isset($_GET['Sensor_3'])&&$_GET['Sensor_3']!=''){    $x7  = $_GET['Sensor_3'];       }else{$x7  = '';}
							if(isset($Sensor_4)){       $x8  = $Sensor_4;      }elseif(isset($_GET['Sensor_4'])&&$_GET['Sensor_4']!=''){    $x8  = $_GET['Sensor_4'];       }else{$x8  = '';}

							//se dibujan los inputs
							$Form_Inputs = new Form_Inputs();
							$Form_Inputs->form_input_disabled( 'Latitud', 'Latitud_fake', $Latitud);
							$Form_Inputs->form_input_disabled( 'Longitud', 'Longitud_fake', $Longitud);

							$Form_Inputs->form_select_filter('Tractor','idTelemetria', $x1, 2, 'idTelemetria', 'Nombre', 'telemetria_listado', 0, '', $dbConn);
							$Form_Inputs->form_input_number('Velocidad','GeoVelocidad', $x3, 2);
							$Form_Inputs->form_input_number('Distancia','GeoMovimiento', $x4, 2);
							$Form_Inputs->form_input_number('Caudal Derecho','Sensor_1', $x5, 2);
							$Form_Inputs->form_input_number('Caudal Izquierdo','Sensor_2', $x6, 2);
							$Form_Inputs->form_input_number('nivel','Sensor_3', $x7, 2);
							$Form_Inputs->form_input_number('otro','Sensor_4', $x8, 2);

							$Form_Inputs->form_input_hidden('FechaSistema', fecha_actual(), 2);
							$Form_Inputs->form_input_hidden('HoraSistema', hora_actual(), 2);
							$Form_Inputs->form_input_hidden('TimeStamp', fecha_actual().' '.hora_actual(), 2);
							$Form_Inputs->form_input_hidden('GeoLatitud', $Latitud, 2);
							$Form_Inputs->form_input_hidden('GeoLongitud', $Longitud, 2);

							//no borrar
							$Form_Inputs->form_input_hidden('Latitud', 0, 2);
							$Form_Inputs->form_input_hidden('Longitud', 0, 2);
							$Form_Inputs->form_input_hidden('test_cross', 'true', 2);

							/********************************************************/
							//Guardo el dato en la tabla relacionada
							if(isset($_GET['idTelemetria'])&&$_GET['idTelemetria']!='') {
								//filtros
								$idTelemetria   = $_GET['idTelemetria'];
								$FechaSistema   = $_GET['FechaSistema'];
								$HoraSistema    = $_GET['HoraSistema'];
								$TimeStamp      = $_GET['TimeStamp'];
								$GeoLatitud     = $_GET['GeoLatitud'];
								$GeoLongitud    = $_GET['GeoLongitud'];
								$GeoVelocidad   = $_GET['GeoVelocidad'];
								$GeoMovimiento  = $_GET['GeoMovimiento'];
								$idZona         = $nx_zona;
								$Sensor_1       = $_GET['Sensor_1'];
								$Sensor_2       = $_GET['Sensor_2'];
								$Sensor_3       = $_GET['Sensor_3'];
								$Sensor_4       = $_GET['Sensor_4'];

								if(isset($idTelemetria) && $idTelemetria!=''){      $a  = "'".$idTelemetria."'";    }else{$a  ="''";}
								if(isset($FechaSistema) && $FechaSistema!=''){      $a .= ",'".$FechaSistema."'";   }else{$a .=",''";}
								if(isset($HoraSistema) && $HoraSistema!=''){        $a .= ",'".$HoraSistema."'";    }else{$a .=",''";}
								if(isset($TimeStamp) && $TimeStamp!=''){            $a .= ",'".$TimeStamp."'";      }else{$a .=",''";}
								if(isset($GeoLatitud) && $GeoLatitud!=''){          $a .= ",'".$GeoLatitud."'";     }else{$a .=",''";}
								if(isset($GeoLongitud) && $GeoLongitud!=''){        $a .= ",'".$GeoLongitud."'";    }else{$a .=",''";}
								if(isset($GeoVelocidad) && $GeoVelocidad!=''){      $a .= ",'".$GeoVelocidad."'";   }else{$a .=",''";}
								if(isset($GeoMovimiento) && $GeoMovimiento!=''){    $a .= ",'".$GeoMovimiento."'";  }else{$a .=",''";}
								if(isset($idZona) && $idZona!=''){                  $a .= ",'".$idZona."'";         }else{$a .=",''";}
								if(isset($Sensor_1) && $Sensor_1!=''){              $a .= ",'".$Sensor_1."'";       }else{$a .=",''";}
								if(isset($Sensor_2) && $Sensor_2!=''){              $a .= ",'".$Sensor_2."'";       }else{$a .=",''";}
								if(isset($Sensor_3) && $Sensor_3!=''){              $a .= ",'".$Sensor_3."'";       }else{$a .=",''";}
								if(isset($Sensor_4) && $Sensor_4!=''){              $a .= ",'".$Sensor_4."'";       }else{$a .=",''";}

								//query
								$query  = "INSERT INTO `telemetria_listado_tablarelacionada_".$idTelemetria."` (
								idTelemetria, FechaSistema, HoraSistema, TimeStamp,
								GeoLatitud, GeoLongitud, GeoVelocidad,GeoMovimiento,
								idZona, Sensor_1, Sensor_2,Sensor_3, Sensor_4
								) VALUES (".$a.")";
								//Consulta
								$resultado = mysqli_query ($dbConn, $query);

							}

							?>

							<div class="form-group">
								<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Punto" name="submit_punto">
							</div>

						</form>
						<?php widget_validator(); ?>

					</div>

					<div style="margin-top:20px;">
						<?php echo 'nx_zona='.$nx_zona; ?>
					</div>
				</div>

			</div>
		</div>
	</div>

	<div class="clearfix"></div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
		<a href="<?php echo $location ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
		<div class="clearfix"></div>
	</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['user_correction'])){
	/*******************************************************/
	// consulto los datos
	$SIS_query = 'idUsuario, idSistema';
	$SIS_join  = '';
	$SIS_where = '';
	$SIS_order = 0;
	$arrUsuarios = array();
	$arrUsuarios = db_select_array (false, $SIS_query, 'usuarios_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'test_logo');

	?>

	<pre>
		<?php
		foreach ($arrUsuarios as $user) {
			if(isset($user['idUsuario']) && $user['idUsuario'] != 0 && isset($user['idSistema']) && $user['idSistema'] != 0){
				$a  = "'".$user['idUsuario']."'";
				$a .= ",'".$user['idSistema']."'";
			}
			// inserto los datos de registro en la db
			echo $query  = "INSERT INTO `usuarios_sistemas` (idUsuario, idSistema) VALUES (".$a.");<br/>";
		}
		?>
	</pre>

	<div class="clearfix"></div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
		<a href="<?php echo $location ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
		<div class="clearfix"></div>
	</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['test_cctv'])){ ?>

	<img name="main" id="main" border="0" width="640" height="480" src="https://victor:victor2019@190.47.221.128/cgi-bin/mjpg/video.cgi?channel=1&subtype=1">

	<div class="clearfix"></div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
		<a href="<?php echo $location ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
		<div class="clearfix"></div>
	</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{ ?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Funciones</h5>
			</header>
			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
							<th>Nombre</th>
							<th width="10">Acciones</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">

						<tr class="odd">
							<td>Agro Checking - Entregar ubicaciones falsas equipo telemetria</td>
							<td>
								<div class="btn-group" style="width: 35px;" >
									<a href="<?php echo $location.'?test_cross=true'; ?>" title="Ingresar Testeo" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
								</div>
							</td>
						</tr>

						<tr class="odd">
							<td>Correccion sistemas usuarios</td>
							<td>
								<div class="btn-group" style="width: 35px;" >
									<a href="<?php echo $location.'?user_correction=true'; ?>" title="Ingresar Testeo" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
								</div>
							</td>
						</tr>

						<tr class="odd">
							<td>Camaras CCTV</td>
							<td>
								<div class="btn-group" style="width: 35px;" >
									<a href="<?php echo $location.'?test_cctv=true'; ?>" title="Ingresar Testeo" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
								</div>
							</td>
						</tr>

						<tr class="odd">
							<td>Arreglar Facturaciones</td>
							<td>
								<div class="btn-group" style="width: 35px;" >
									<a href="<?php echo $location.'?fact_repair=true'; ?>" title="Ingresar Testeo" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
								</div>
							</td>
						</tr>

						<tr class="odd">
							<td>Testeo funciones db_select_data</td>
							<td>
								<div class="btn-group" style="width: 35px;" >
									<a href="<?php echo $location.'?test_fnx=true'; ?>" title="Ingresar Testeo" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
								</div>
							</td>
						</tr>

						<tr class="odd">
							<td>existencia logo y envio correo</td>
							<td>
								<div class="btn-group" style="width: 35px;" >
									<a href="<?php echo $location.'?test_logo=true'; ?>" title="Ingresar Testeo" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
								</div>
							</td>
						</tr>

						<tr class="odd">
							<td>testeo proyecciones</td>
							<td>
								<div class="btn-group" style="width: 35px;" >
									<a href="<?php echo $location.'?test_proyecciones=true'; ?>" title="Ingresar Testeo" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
								</div>
							</td>
						</tr>

						<tr class="odd">
							<td>testeo funciones</td>
							<td>
								<div class="btn-group" style="width: 35px;" >
									<a href="<?php echo $location.'?test_function=true'; ?>" title="Ingresar Testeo" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
								</div>
							</td>
						</tr>

					</tbody>
				</table>
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
