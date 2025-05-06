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
require_once 'core/Load.Utils.Views.php';
/**********************************************************************************************************************************/
/*                                                Carga del documento HTML                                                        */
/**********************************************************************************************************************************/
//Tiempo Maximo de la consulta, 40 minutos por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigTime'])&&$_SESSION['usuario']['basic_data']['ConfigTime']!=0){$n_lim = $_SESSION['usuario']['basic_data']['ConfigTime']*60;set_time_limit($n_lim);}else{set_time_limit(2400);}
//Memora RAM Maxima del servidor, 4GB por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigRam'])&&$_SESSION['usuario']['basic_data']['ConfigRam']!=0){$n_ram = $_SESSION['usuario']['basic_data']['ConfigRam']; ini_set('memory_limit', $n_ram.'M');}else{ini_set('memory_limit', '4096M');}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Views.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Version antigua de view
//se verifica si es un numero lo que se recibe
if (validarNumero($_GET['view'])){
	//Verifica si el numero recibido es un entero
	if (validaEntero($_GET['view'])){
		$X_Puntero = $_GET['view'];
	} else {
		$X_Puntero = simpleDecode($_GET['view'], fecha_actual());
	}
} else {
	$X_Puntero = simpleDecode($_GET['view'], fecha_actual());
}
/**************************************************************/
// Se traen todos los datos del proveedor
$SIS_query = '
contratista_listado.email, 
contratista_listado.Nombre,
contratista_listado.Rut, 
contratista_listado.fNacimiento, 
contratista_listado.Direccion, 
contratista_listado.Fono1, 
contratista_listado.Fono2, 
contratista_listado.Fax,
contratista_listado.PersonaContacto,
contratista_listado.Web,
contratista_listado.Giro,
contratista_listado.FormaPago,
core_ubicacion_ciudad.Nombre AS nombre_region,
core_ubicacion_comunas.Nombre AS nombre_comuna,
core_estados.Nombre AS estado,
core_sistemas.Nombre AS sistema,
contratista_tipos.Nombre AS tipoCliente,
core_paises.Nombre AS Pais,
core_paises.Flag AS Flag';
$SIS_join  = '
LEFT JOIN `core_estados`            ON core_estados.idEstado            = contratista_listado.idEstado
LEFT JOIN `core_ubicacion_ciudad`   ON core_ubicacion_ciudad.idCiudad   = contratista_listado.idCiudad
LEFT JOIN `core_ubicacion_comunas`  ON core_ubicacion_comunas.idComuna  = contratista_listado.idComuna
LEFT JOIN `core_sistemas`           ON core_sistemas.idSistema          = contratista_listado.idSistema
LEFT JOIN `contratista_tipos`       ON contratista_tipos.idTipo         = contratista_listado.idTipo
LEFT JOIN `core_paises`             ON core_paises.idPais               = contratista_listado.idPais';
$SIS_where = 'contratista_listado.idContratista ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'contratista_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

/*****************************************/
// consulto los datos
$SIS_query = '
usuarios_listado.Nombre AS nombre_usuario,
contratista_observaciones.Fecha,
contratista_observaciones.Observacion';
$SIS_join  = 'LEFT JOIN `usuarios_listado` ON usuarios_listado.idUsuario = contratista_observaciones.idUsuario';
$SIS_where = 'contratista_observaciones.idContratista ='.$X_Puntero;
$SIS_order = 'contratista_observaciones.idObservacion ASC LIMIT 15';
$arrObservaciones = array();
$arrObservaciones = db_select_array (false, $SIS_query, 'contratista_observaciones', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrObservaciones');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Datos del Contratista</h5>
			<ul class="nav nav-tabs pull-right">
				<li class="active"><a href="#basicos" data-toggle="tab"><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
				<li class=""><a href="#observaciones" data-toggle="tab"><i class="fa fa-tasks" aria-hidden="true"></i> Observaciones</a></li>
			</ul>
		</header>
        <div class="tab-content">

			<div class="tab-pane fade active in" id="basicos">
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<div class="row" style="border-right: 1px solid #333;">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos Básicos</h2>
							<p class="text-muted word_break">
								<strong>Tipo de Contratista : </strong><?php echo $rowData['tipoCliente']; ?><br/>
								<strong>Nombre : </strong><?php echo $rowData['Nombre']; ?><br/>
								<strong>Rut : </strong><?php echo $rowData['Rut']; ?><br/>
								<strong>Fecha de Ingreso : </strong><?php echo Fecha_completa($rowData['fNacimiento']); ?><br/>
								<strong>Pais : </strong><img src="<?php echo DB_SITE_REPO.'/LIB_assets/img/flags/'.strtolower($rowData['Flag']).'.png'; ?>" alt="flag" height="11" width="16"> <?php echo $rowData['Pais']; ?><br/>
								<strong>Región : </strong><?php echo $rowData['nombre_region']; ?><br/>
								<strong>Comuna : </strong><?php echo $rowData['nombre_comuna']; ?><br/>
								<strong>Dirección : </strong><?php echo $rowData['Direccion']; ?><br/>
								<strong>Giro de la empresa: </strong><?php echo $rowData['Giro']; ?><br/>
								<strong>Sistema Relacionado : </strong><?php echo $rowData['sistema']; ?><br/>
								<strong>Estado : </strong><?php echo $rowData['estado']; ?>
							</p>
											
							<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos de Contacto</h2>
							<p class="text-muted word_break">
								<strong>Persona de Contacto : </strong><?php echo $rowData['PersonaContacto']; ?><br/>
								<strong>Telefono 1 : </strong><?php echo formatPhone($rowData['Fono1']); ?><br/>
								<strong>Telefono 2 : </strong><?php echo formatPhone($rowData['Fono2']); ?><br/>
								<strong>Fax : </strong><?php echo $rowData['Fax']; ?><br/>
								<strong>Email : </strong><a href="mailto:<?php echo $rowData['email']; ?>"><?php echo $rowData['email']; ?></a><br/>
								<strong>Web : </strong><a target="_blank" rel="noopener noreferrer" href="https://<?php echo $rowData['Web']; ?>"><?php echo $rowData['Web']; ?></a>
							</p>

							<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos de Facturacion</h2>
							<p class="text-muted word_break"><strong>Forma de Pago : </strong><?php echo $rowData['FormaPago']; ?></p>
										
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<div class="row">
						<?php
							//se arma la dirección
							$direccion = "";
							if(isset($rowData["Direccion"])&&$rowData["Direccion"]!=''){           $direccion .= $rowData["Direccion"];}
							if(isset($rowData["nombre_comuna"])&&$rowData["nombre_comuna"]!=''){   $direccion .= ', '.$rowData["nombre_comuna"];}
							if(isset($rowData["nombre_region"])&&$rowData["nombre_region"]!=''){   $direccion .= ', '.$rowData["nombre_region"];}
							//se despliega mensaje en caso de no existir dirección
							if($direccion!=''){
								echo mapa_from_direccion($direccion, 0, $_SESSION['usuario']['basic_data']['Config_IDGoogle'], 18, 1);
							}else{
								$Alert_Text  = 'No tiene una dirección definida';
								alert_post_data(4,2,2,0, $Alert_Text);
							}
						?>
					</div>
				</div>
				<div class="clearfix"></div>

			</div>

			<div class="tab-pane fade" id="observaciones">
				<div class="wmd-panel">
					<div class="table-responsive">
						<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
							<thead>
								<tr role="row">
									<th>Autor</th>
									<th width="120">Fecha</th>
									<th>Observacion</th>
								</tr>
							</thead>
							<tbody role="alert" aria-live="polite" aria-relevant="all">
							<?php foreach ($arrObservaciones as $observaciones){ ?>
								<tr class="odd">
									<td><?php echo $observaciones['nombre_usuario']; ?></td>
									<td><?php echo $observaciones['Fecha']; ?></td>
									<td class="word_break"><?php echo $observaciones['Observacion']; ?></td>
								</tr>
							<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>

        </div>
	</div>
</div>

<?php
//si se entrega la opción de mostrar boton volver
if(isset($_GET['return'])&&$_GET['return']!=''){
	//para las versiones antiguas
	if($_GET['return']=='true'){ ?>
		<div class="clearfix"></div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px;margin-top:30px;">
			<a href="#" onclick="history.back()" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
			<div class="clearfix"></div>
		</div>
	<?php
	//para las versiones nuevas que indican donde volver
	}else{
		$string = basename($_SERVER["REQUEST_URI"], ".php");
		$array  = explode("&return=", $string, 3);
		$volver = $array[1];
		?>
		<div class="clearfix"></div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px;margin-top:30px;">
			<a href="<?php echo $volver; ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
			<div class="clearfix"></div>
		</div>

	<?php }
} ?>

<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Views.php';

?>
