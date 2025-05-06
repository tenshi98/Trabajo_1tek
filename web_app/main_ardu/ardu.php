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
require_once 'A1XRXS_sys/xrxs_configuracion/config.php';                                   //Configuracion de la plataforma
require_once '../../Legacy/gestion_modular/funciones/Helpers.Functions.Propias.ardu.php';  //carga librerias de la plataforma

// obtengo puntero de conexion con la db
$dbConn = conectar();
//Se elimina la restriccion del sql 5.7
mysqli_query($dbConn, "SET SESSION sql_mode = ''");
/**********************************************************************************************************************************/
/*                                            Configuracion del sistema                                                           */
/**********************************************************************************************************************************/

	include '1_global_config.php';

/**********************************************************************************************************************************/
/*                                                Ejecucion del sistema                                                           */
/**********************************************************************************************************************************/
//Variables
$Sensor            = array();
$Var_Counter       = 0;              //Contador de sensores recibidos
$GeoLatitud        = 0;              //Latitud
$GeoLongitud       = 0;              //Longitud
$GeoMovimiento     = 0;              //Movimiento en metros
$Velocidad         = '';             //Mensaje Velocidad
$GPS_en0           = '';             //Mensaje GPS en 0
$Vehi_Detenido     = '';             //Mensaje Vehiculo Detenido
$Alertas_perso     = '';             //Mensaje Alertas personalizadas
$Alertas_criticas  = '';             //Mensaje Alertas criticas
$FueraLinea        = '';             //Mensaje FueraLinea
$LogAlertas        = '';             //Log de las alertas enviadas
$FechaSistema      = fecha_actual(); //Fecha del servidor
$HoraSistema       = hora_actual();  //Hora del servidor
$saltoLinea = '
';

//Obtengo los valores enviados por el equipo
include 'ardu_include_01_gets.php';

//Se verifica que existe la variable
if(isset($Identificador)&&$Identificador!=''){

	include 'ardu_include_02_1_ponderaciones.php'; //Ponderaciones Manuales de los sensores
	include 'ardu_include_02_2_calibraciones.php'; //Ponderaciones Manuales de los sensores
	include 'ardu_include_03_1_consultas.php';     //Se realiza consulta del equipo de telemetria

	/******************************************/
	//si hay resultados
	if($rowData!=false){
		//Correcciones automaticas segun tipo de sensor y unidad de medida
		include 'ardu_include_03_2_correcciones.php';

		/*******************************************************************************************************/
		//Si el dato enviado corresponde a un equipo, si esta activo
		if(isset($rowData['idTelemetria'], $rowData['idEstado'])&&$rowData['idTelemetria']!=''&&$rowData['idTelemetria']!=0&&$rowData['idEstado']==1){

			/******************************************************************************/
			/*                            Datos Básicos                                   */
			/******************************************************************************/
			//Obtengo el ID y el sistema
			$idTelemetria = $rowData['idTelemetria'];
			$idSistema    = $rowData['idSistema'];

			//Tiempos de la notificacion entre las alertas
			if(isset($rowData['AlertaTemprCritica'])&&$rowData['AlertaTemprCritica']!='00:00:00'){  $TimeAlertMail_Critical = $rowData['AlertaTemprCritica'];}
			if(isset($rowData['AlertaTemprNormal'])&&$rowData['AlertaTemprNormal']!='00:00:00'){    $TimeAlertMail_Normal   = $rowData['AlertaTemprNormal'];}

			//valido si existe hora y fecha por parte del equipo
			if(isset($Fecha, $Hora)&&$Fecha!=''&&validaFecha($Fecha)&&$Hora!=''&&validaHora($Hora)){
				//Si el dato es enviado por el dataloger
				if(isset($Dataloger)&&$Dataloger!=''){
					//Si el dato es superior a 0
					if(isset($Dataloger)&&$Dataloger>=0){
						//Obtengo la nueva hora
						$horasuma    = multHoras('01:00:00',$Dataloger);
						$HoraSistema = sumahoras($Hora,$horasuma);
						//Si la nueva hora calculada es superior a 24
						if($HoraSistema>'24:00:00'){
							$HoraSistema  = restahoras($HoraSistema, '24:00:00');
							$FechaSistema = sumarDias($Fecha,1);
						}
					//Si el dato es inferior a 0
					}else{
						//Paso la variable a positivo
						$Dataloger   = $Dataloger * -1;
						//Obtengo la nueva hora
						$horaresta   = multHoras('01:00:00',$Dataloger);
						$HoraSistema = restahoras($Hora,$horaresta);
						//Si la nueva hora calculada es superior a la anterior
						if($HoraSistema>$Hora){
							$FechaSistema = restarDias($Fecha,1);
						}
					}
				//si no es un dataloger
				}else{
					$FechaSistema = $Fecha;
					$HoraSistema  = $Hora;
				}
			}

			//Verifico la resta de la hora de la ulima actualizacion contra  la hora actual
			$diaInicio   = $rowData['LastUpdateFecha'];
			$diaTermino  = $FechaSistema;
			$horaInicio  = $rowData['LastUpdateHora'];
			$horaTermino = $HoraSistema;
			$HorasTrans  = horas_transcurridas($diaInicio, $diaTermino, $horaInicio, $horaTermino);
			$SegTrans    = horas2segundos($HorasTrans);//Obtengo el tiempo transcurrido

			/******************************************************************************/
			/*                                 Cadena                                     */
			/******************************************************************************/
			//Se genera la cadena para la actualizacion de los datos en la tabla Telemetria_listado
			$chainxMain       = "idTelemetria='".$idTelemetria."'"; //Tabla telemetria_listado
			$chainxMedActual  = "idTelemetria='".$idTelemetria."'"; //Tabla con la medicion Actual
			$chainxMedC       = "idTelemetria='".$idTelemetria."'"; //Tabla contador medicion
			$chainxMedT       = "idTelemetria='".$idTelemetria."'"; //Tabla tiempo medicion
			//se actualizala dirección IP de la maquina cliente
			$chainxMain .= ",IP_Client='".obtenerIpCliente()."'";
			//Se revisa si inserta o solo actualiza
			if(isset($lock)&&$lock!=''&&($lock==1 OR $lock==2)){
				//nada
			//si inserta actualiza el dato
			}else{
				$chainxMain .= ",LastUpdateFecha='".$FechaSistema."'";
				$chainxMain .= ",LastUpdateHora='".$HoraSistema."'";
			}

			/******************************************************************************/
			/*                           Validacion del GPS                               */
			/******************************************************************************/
			//Verificacion si existe latitud y longitud
			if(isset($GeoLatitud, $GeoLongitud)&&$GeoLatitud!=''&&$GeoLatitud!=0&&$GeoLongitud!=''&&$GeoLongitud!=0){
				//chequeo si la latitud y longitud esta dentro de chile, si no esta reemplaza con la anterior
				include 'ardu_include_04_verificacion_gps.php';
				//Obtengo la distancia entre el punto actual y el anterior
				if(isset($rowData['GeoLatitud'], $rowData['GeoLongitud'])&&$rowData['GeoLatitud']!=0&&$rowData['GeoLongitud']!=0 ){
					$GeoMovimiento = obtenerDistancia( $GeoLatitud, $GeoLongitud, $rowData['GeoLatitud'], $rowData['GeoLongitud'] );
				}
				//Genero Cadena de actualizacion de Latitud y Longitud
				$chainxMain .= ",GeoLatitud='".$GeoLatitud."'";
				$chainxMain .= ",GeoLongitud='".$GeoLongitud."'";
			}

			/******************************************************************************/
			/*                           Validacion del GPS                               */
			/******************************************************************************/
			//Se insertan los datos recibidos en la tabla relacionada
			include 'ardu_include_05_insert.php';

			/*******************************************************************************************************/
			/*                                   Si tengo la geolocalizacion activa                                */
			/*******************************************************************************************************/
			if(isset($rowData['id_Geo'])&&$rowData['id_Geo']!=''&&$rowData['id_Geo']==1){
				//Se crea cadena de actualizacion
				if(isset($GeoVelocidad) && $GeoVelocidad!=''){    $chainxMain .= ",GeoVelocidad='".$GeoVelocidad."'";}
				if(isset($GeoDireccion) && $GeoDireccion!=''){    $chainxMain .= ",GeoDireccion='".$GeoDireccion."'";}
				if(isset($GeoMovimiento) && $GeoMovimiento!=''){  $chainxMain .= ",GeoMovimiento='".$GeoMovimiento."'";}

				include 'ardu_include_06_1_geo_velocidad.php';   //Se guarda registro de la alerta de velocidad
				include 'ardu_include_06_2_geo_errores.php';     //Se guardan los errores de latitud o longitud en 0
				include 'ardu_include_06_3_geo_detenciones.php'; //Se verifica si esta detenido en el mismo lugar el tiempo configurado

			}

			/*******************************************************************************************************/
			/*                                   Si tengo los sensores activos                                     */
			/*******************************************************************************************************/
			if(isset($rowData['id_Sensores'])&&$rowData['id_Sensores']!=''&&$rowData['id_Sensores']==1){

				include 'ardu_include_07_1_flujo.php';                  //Ejecucion de la logica
				include 'ardu_include_07_2_alertas_personalizadas.php'; //Alertas configuradas

			}
			/*******************************************************************************************************/
			/*                                    Si ha estado fuera de linea                                      */
			/*******************************************************************************************************/
			//si texiste un tiempo fuera de linea que sea superior al minimo establecido
			if(isset($rowData['TiempoFueraLinea'])&&$rowData['TiempoFueraLinea']!='00:00:00'){
				//Verifico si el equipo esta configurado
				if ( isset($Sensor[$rowData['SensorActivacionID']]['valor'])&&$Sensor[$rowData['SensorActivacionID']]['valor']>=$rowData['SensorActivacionValor'] ) {
					//Include fuera linea
					include 'ardu_include_08_fuera_linea.php';
				//En caso de que el sensor de activacion no este configurado
				}elseif(isset($rowData['SensorActivacionID'])&&$rowData['SensorActivacionID']==0){
					//Include fuera linea
					include 'ardu_include_08_fuera_linea.php';
				}
			}

			/*******************************************************************************************************/
			/*                                 Se actualizan los datos del equipo                                  */
			/*******************************************************************************************************/
			//Se realiza actualizacion en la tabla principal
			$resultado = db_update_data (false, $chainxMain, 'telemetria_listado', 'idTelemetria = "'.$idTelemetria.'"', $dbConn, 'ardu', basename($_SERVER["REQUEST_URI"], ".php"), 'update_data_chainxMain');
			//Si hay cambios en la tabla de mediciones
			if($chainxMedActual!="idTelemetria='".$idTelemetria."'"){
				$resultado1 = db_update_data (false, $chainxMedActual, 'telemetria_listado_sensores_med_actual', 'idTelemetria = "'.$idTelemetria.'"', $dbConn, 'ardu', basename($_SERVER["REQUEST_URI"], ".php"), 'update_data_chainxMedActual');
			}
			//Si hay cambios en la tabla de cuenta de mediciones
			if($chainxMedC!="idTelemetria='".$idTelemetria."'"){
				$resultado2 = db_update_data (false, $chainxMedC, 'telemetria_listado_sensores_accion_med_c', 'idTelemetria = "'.$idTelemetria.'"', $dbConn, 'ardu', basename($_SERVER["REQUEST_URI"], ".php"), 'update_data_chainxMedC');
			}
			//Si hay cambios en la tabla de tiempo de mediciones
			if($chainxMedT!="idTelemetria='".$idTelemetria."'"){
				$resultado3 = db_update_data (false, $chainxMedT, 'telemetria_listado_sensores_accion_med_t', 'idTelemetria = "'.$idTelemetria.'"', $dbConn, 'ardu', basename($_SERVER["REQUEST_URI"], ".php"), 'update_data_chainxMedT');
			}

			//Si ejecuto correctamente la consulta
			if($resultado==true){

				/**************************************/
				//variable conteo notificacion
				$SendNoti = 0;

				if(isset($Alertas_perso)&&$Alertas_perso!=''){       $SendNoti++;}
				if(isset($FueraGeoCerca)&&$FueraGeoCerca!=''){       $SendNoti++;}
				if(isset($Velocidad)&&$Velocidad!=''){               $SendNoti++;}
				if(isset($FueraLinea)&&$FueraLinea!=''){             $SendNoti++;}
				if(isset($Alertas_criticas)&&$Alertas_criticas!=''){ $SendNoti++;}

				/**************************************/
				//si hay notificaciones que enviar se ejecuta la consulta
				if(isset($SendNoti)&&$SendNoti!=0){
					include 'ardu_include_09_1_consultas.php';         //Consulta de a quienes se les envia la notificacion
					include 'ardu_include_09_2_noti_normal.php';       //Envio notificaciones normales
					include 'ardu_include_09_3_noti_catastrofica.php'; //Envio notificaciones catastroficas
					include 'ardu_include_09_4_log_correos.php';       //Se guarda registro de las notificaciones enviadas
				}
			}

		/*******************************************************************************************************/
		//Si el dato enviado corresponde a un equipo, si no esta inactivo
		}elseif(isset($rowData['idTelemetria'])&&$rowData['idTelemetria']!=''&&$rowData['idTelemetria']!=0&&$rowData['idEstado']==2){

		/*******************************************************************************************************/
		//El equipo no fue encontrado
		}else{
			//nada
		}

		/*******************************************************************************************************/
		//se imprime el estado de encendido
		echo $rowData['idEstadoEncendido'];

	/******************************************/
	//si no hay datos
	}elseif(empty($rowData) OR $rowData==''){
		//Devuelvo mensaje
		echo 'No hay datos';
	/******************************************/
	//si existe un error
	}elseif($rowData==false){
		//Devuelvo mensaje
		echo 'Hay un error en la consulta';
	}

}else{
	echo 'No ha enviado el identificador';
}
/******************************************************************************************************/
/*                                                                                                    */
/*                                            BACKUP DE DATOS                                         */
/*                                                                                                    */
/******************************************************************************************************/
//Se guarda en un archivo la salida predefinida de los datos recibidos
include 'ardu_include_10_backup.php';

/******************************************************************************************************/
/*                                                                                                    */
/*                                              CIERRE DE LA BASE                                     */
/*                                                                                                    */
/******************************************************************************************************/
mysqli_close($dbConn);

?>
