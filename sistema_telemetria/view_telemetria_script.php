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
telemetria_listado_script.idShield,
telemetria_listado_script.idTab,
telemetria_listado_script.Fecha,
telemetria_listado_script.Version,
telemetria_listado_script.id_Sensores,
telemetria_listado_script.cantSensores,
telemetria_listado_script.id_Geo,
telemetria_listado_script.pinMode,

telemetria_listado_script_puerto_serial.Nombre AS PuertoSerial,
telemetria_listado.Nombre AS nombre_equipo,
usuarios_listado.Nombre AS nombre_usuario,
core_telemetria_tabs.Nombre AS Tab,
telemetria_listado_dispositivos.Nombre AS Dispositivo,
telemetria_listado_shield.Nombre AS Shield,
opc2.Nombre AS Geo,
opc3.Nombre AS Sensores,
telemetria_listado_script.idFormaEnvio,
telemetria_listado_script.Observacion,
telemetria_listado.Identificador AS Identificador,
telemetria_listado_forma_envio.Nombre AS FormaEnvio,
telemetria_listado_script_apn_listado.Nombre AS APN_direction,
telemetria_listado_script.idModificado,
opc1.Nombre AS Modificado';
$SIS_join  = '
LEFT JOIN `telemetria_listado`                        ON telemetria_listado.idTelemetria                          = telemetria_listado_script.idTelemetria
LEFT JOIN `usuarios_listado`                          ON usuarios_listado.idUsuario                               = telemetria_listado_script.idUsuario
LEFT JOIN `telemetria_listado_dispositivos`           ON telemetria_listado_dispositivos.idDispositivo            = telemetria_listado_script.idDispositivo
LEFT JOIN `telemetria_listado_shield`                 ON telemetria_listado_shield.idShield                       = telemetria_listado_script.idShield
LEFT JOIN `telemetria_listado_forma_envio`            ON telemetria_listado_forma_envio.idFormaEnvio              = telemetria_listado_script.idFormaEnvio
LEFT JOIN `core_telemetria_tabs`                      ON core_telemetria_tabs.idTab                               = telemetria_listado_script.idTab
LEFT JOIN `core_sistemas_opciones`        opc1        ON opc1.idOpciones                                          = telemetria_listado_script.idModificado
LEFT JOIN `core_sistemas_opciones`        opc2        ON opc2.idOpciones                                          = telemetria_listado_script.id_Geo
LEFT JOIN `core_sistemas_opciones`        opc3        ON opc3.idOpciones                                          = telemetria_listado_script.id_Sensores
LEFT JOIN `telemetria_listado_script_puerto_serial`   ON telemetria_listado_script_puerto_serial.idPuertoSerial   = telemetria_listado_script.idPuertoSerial
LEFT JOIN `telemetria_listado_script_apn_listado`     ON telemetria_listado_script_apn_listado.idAPNListado       = telemetria_listado_script.idAPNListado';
$SIS_where = 'telemetria_listado_script.idScript ='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'telemetria_listado_script', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

/***************************************************************************/
//Por tipo de SHIELD
switch ($rowData['idShield']) {
    /********************************************/
    //Dragino
    case 1:
		//Tipo de trabajo que realiza el equipo
		switch ($rowData['idTab']) {
			case 1: break;//Agro-Checking
			case 2: break;//1Tek C
			case 3: break;//CrossTrack
			case 4: break;//Agro-Weather
			case 5: break;//CrossWater
			case 6: break;//Power-Crane
			case 9: break;//Power-Energy
		}
        break;
    /********************************************/
    //Sim808
    case 2:
		//Tipo de trabajo que realiza el equipo
		switch ($rowData['idTab']) {
			case 1: break;//Agro-Checking
			case 2: $code = sim80x_dht('sim808', $rowData);  break;//1Tek C
			case 3: break;//CrossTrack
			case 4: break;//Agro-Weather
			case 5: break;//CrossWater
			case 6: break;//Power-Crane
			case 9: break;//Power-Energy
		}
        break;
    /********************************************/
    //Sim800l
    case 3:
		//Tipo de trabajo que realiza el equipo
		switch ($rowData['idTab']) {
			case 1: break;//Agro-Checking
			case 2: $code = sim80x_dht('sim800', $rowData);  break;//1Tek C
			case 3: break;//CrossTrack
			case 4: break;//Agro-Weather
			case 5: break;//CrossWater
			case 6: break;//Power-Crane
			case 9: break;//Power-Energy
		}
        break;
    /********************************************/
    //Ethernet
    case 4:
        //Tipo de trabajo que realiza el equipo
		switch ($rowData['idTab']) {
			case 1: break;//Agro-Checking
			case 2: break;//1Tek C
			case 3: break;//CrossTrack
			case 4: break;//Agro-Weather
			case 5: break;//CrossWater
			case 6: break;//Power-Crane
			case 9: break;//Power-Energy
		}
        break;
    /********************************************/
    //Dragino Yun
    case 5:
        //Tipo de trabajo que realiza el equipo
		switch ($rowData['idTab']) {
			case 1: break;//Agro-Checking
			case 2: break;//1Tek C
			case 3: break;//CrossTrack
			case 4: break;//Agro-Weather
			case 5: break;//CrossWater
			case 6: break;//Power-Crane
			case 9: break;//Power-Energy
		}
        break;
    /********************************************/
    //Arduino Yun
    case 6:
        //Tipo de trabajo que realiza el equipo
		switch ($rowData['idTab']) {
			case 1: break;//Agro-Checking
			case 2: break;//1Tek C
			case 3: break;//CrossTrack
			case 4: break;//Agro-Weather
			case 5: break;//CrossWater
			case 6: break;//Power-Crane
			case 9: break;//Power-Energy
		}
        break;

}
	
       



?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<h5>Ver Datos del script</h5>
		</header>
        <div class="body">
            <h2 class="text-primary">Datos Básicos</h2>
            <p class="text-muted">
				<strong>Equipo : </strong><?php echo $rowData['nombre_equipo']; ?><br/>
				<strong>Identificador : </strong><?php echo $rowData['Identificador']; ?><br/>
				<strong>Usuario : </strong><?php echo $rowData['nombre_usuario']; ?><br/>
				<strong>Fecha : </strong><?php echo Fecha_completa_alt($rowData['Fecha']); ?><br/>
				<strong>Modificado : </strong><?php if(isset($rowData['idModificado'])&&$rowData['idModificado']==1){ echo '<span class="label label-danger">'.$rowData['Modificado'].'</span>';}else{ echo $rowData['Modificado'];} ?>
			</p>
            
            <h2 class="text-primary">Configuracion Actual</h2>
            <p class="text-muted">
				<strong>Hardware : </strong><?php echo $rowData['Dispositivo']; ?><br/>
				<strong>SHIELD : </strong><?php echo $rowData['Shield']; ?><br/>
				<strong>Tab : </strong><?php echo $rowData['Tab']; ?><br/>
				<strong>Geolocalizacion : </strong><?php echo $rowData['Geo']; ?><br/>
				<strong>Sensores : </strong><?php echo $rowData['Sensores']; ?><br/>
				<strong>Cantidad Sensores : </strong><?php echo $rowData['cantSensores']; ?><br/>
            </p>
                 
            <h2 class="text-primary">Observacion</h2>
            <p class="text-muted word_break">
				<div class="text-muted well well-sm no-shadow">
					<?php if(isset($rowData['Observacion'])&&$rowData['Observacion']!=''){echo $rowData['Observacion'];}else{echo 'Sin Observaciones';} ?>
					<div class="clearfix"></div>
				</div>
			</p>

			<h2 class="text-primary">Script</h2>
			<?php echo widget_code_block(8, $code); ?>
        	
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
