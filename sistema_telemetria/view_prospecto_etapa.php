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
/*                                                 Variables Globales                                                             */
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
// consulto los datos
$SIS_query = '
prospectos_listado.Nombre AS nombre_prospecto,
usuarios_listado.Nombre AS nombre_usuario,
prospectos_etapa_fidelizacion.Fecha,
prospectos_etapa_fidelizacion.Observacion,
prospectos_etapa_fidelizacion.Archivo,
prospectos_etapa.Nombre AS Etapa';
$SIS_join  = '
LEFT JOIN `prospectos_listado`   ON prospectos_listado.idProspecto     = prospectos_etapa_fidelizacion.idProspecto
LEFT JOIN `usuarios_listado`     ON usuarios_listado.idUsuario         = prospectos_etapa_fidelizacion.idUsuario
LEFT JOIN `prospectos_etapa`     ON prospectos_etapa.idEtapa           = prospectos_etapa_fidelizacion.idEtapa';
$SIS_where = 'prospectos_etapa_fidelizacion.idEtapaFide ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'prospectos_etapa_fidelizacion', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Ver Datos de la Etapa</h5>
		</header>
        <div class="body">
            <h2 class="text-primary">Datos Básicos</h2>
            <p class="text-muted">
				<strong>Prospecto : </strong><?php echo $rowData['nombre_prospecto']; ?><br/>
				<strong>Etapa : </strong><?php echo $rowData['Etapa']; ?><br/>
				<strong>Usuario : </strong><?php echo $rowData['nombre_usuario']; ?><br/>
				<strong>Fecha : </strong><?php echo Fecha_completa_alt($rowData['Fecha']); ?>
            </p>

            <h2 class="text-primary">Observacion</h2>
            <p class="text-muted word_break">
				<div class="text-muted well well-sm no-shadow">
					<?php if(isset($rowData['Observacion'])&&$rowData['Observacion']!=''){echo $rowData['Observacion'];}else{echo 'Sin Observaciones';} ?>
					<div class="clearfix"></div>
				</div>
			</p>
            
            <?php if(isset($rowData['Archivo'])&&$rowData['Archivo']!=''){ ?>
				<h2 class="text-primary">Archivo</h2>
				<div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 fcenter">
					<?php echo preview_docs(DB_SITE_REPO.DB_SITE_MAIN_PATH, 'upload/'.$rowData['Archivo'], ''); ?>
				</div>
				<div class="clearfix"></div>
			<?php } ?>
			
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
