<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')) {
    die('No tienes acceso a esta carpeta o archivo (Access Code 1003-001).');
}
/*******************************************************************************************************************/
/*                                                                                                                 */
/*                                              Funciones  Horas                                                   */
/*                                                                                                                 */
/*******************************************************************************************************************/
///////////////////////////////////////////////////////////////////////////////////////////////////////////
function sim80x_dht($TipoShield, $rowData) {
	//VARIABLES
	$SensCant         = '';
	$SensListDef      = '';
	$SensListSend     = '';
	$SensListPrint    = '';
	$SensListMed      = '';
	$SensListError    = '';
	$SensListValMed   = '';
	$GPSVarDef        = '';
	$SensDigPortDef   = '';
	$SensDigPortBegin = '';
$saltoLinea = '
';

	/*******************************************************************/
	//si esta configurado para usar sensores, mostrar la cantidad de sensores
	if(isset($rowData['id_Sensores'])&&$rowData['id_Sensores']==1){
		$SensCant     = ' * Numero Sensores: '.$rowData['cantSensores'].$saltoLinea;
		/***********************************************/
		//recorro la cantidad de sensores existentes
		for ($i = 1; $i <= $rowData['cantSensores']; $i++) {
			$SensListDef   .= 'float s'.$i.';'.$saltoLinea;
			$SensListPrint .= $saltoLinea.'	Serial.print("s'.$i.': ");';
			$SensListPrint .= $saltoLinea.'	Serial.println(s'.$i.');';
			$SensListSend  .= $saltoLinea.'	datos += "&s'.$i.'=";';
			$SensListSend  .= $saltoLinea.'	datos += s'.$i.';';
		}

		//se divide el total de sensores en 2
		$totSens  = ceil($rowData['cantSensores']/2);
		$initPort = 26;
		$initSens = 1;
		$SensDigPortDef = '//DHT Se definen instancias y puertos digitales (Por defecto se comienza con el puerto 26, favor modificar en caso de ser necesario)'.$saltoLinea;
		for ($j = 1; $j <= $totSens; $j++) {
			$SensDigPortDef   .= 'DHT dht'.$j.'('.$initPort.', DHT22);'.$saltoLinea;
			$SensDigPortBegin .= $saltoLinea.'	dht'.$j.'.begin();';
			//sumo 2
			$initPort = $initPort + 2;
			//doy un delay de 0.005 segundos
			$SensListMed .= $saltoLinea.'	delay(500);';
			//establezco hasta donde recorro
			$finalSens = $initSens + 1;
			//recorro la cantidad de sensores existentes
			$SensListMed    .= $saltoLinea.'	s'.$initSens.' = dht'.$j.'.readTemperature();';
			$SensListMed    .= $saltoLinea.'	s'.$finalSens.' = dht'.$j.'.readHumidity()';
			//validacion de errores
			$SensListError  .= $saltoLinea.'		if (s'.$initSens.' == 99900 || s'.$finalSens.' == 99900){';
			$SensListError  .= $saltoLinea.'			Serial.println("Error Medicion Sensores s'.$initSens.' / s'.$finalSens.'");';
			$SensListError  .= $saltoLinea.'			s'.$initSens.' = dht'.$j.'.readTemperature();';
			$SensListError  .= $saltoLinea.'			s'.$finalSens.' = dht'.$j.'.readHumidity();';
			$SensListError  .= $saltoLinea.'			delay(500);';
			$SensListError  .= $saltoLinea.'		}';
			//Validacion mediciones
			$SensListValMed .= $saltoLinea.'	if  (s'.$initSens.' < -40 || s'.$initSens.' > 120){s'.$initSens.', s'.$finalSens.' = 99900;}';
			//sumo 2 al sensor de inicio
			$initSens = $initSens + 2;
		}
	}

//////////////////////////////////////////////////////////////////////////////////////////////
//Encabezado con información Basica
$code = '
/* Equipo '.$rowData['nombre_equipo'].'
 * Creado por: '.$rowData['nombre_usuario'].'
 * Fecha Creacion: '.Fecha_completa_alt($rowData['Fecha']).'
 *
 * Version: '.$rowData['Version'].'
 * Master '.$rowData['Tab'].'
 * Placa: '.$rowData['Dispositivo'].'
 * Comunicacion: '.$rowData['Shield'].'
 * Datos Moviles:
 * Uso GPS: '.$rowData['Geo'].'
 * Uso Sensores: '.$rowData['Sensores'].$saltoLinea;
$code .= $SensCant;
//Si hay observaciones relacionadas al script se incluyen
$code .= ' * Obs: '.$rowData['Observacion'].$saltoLinea.' */'.$saltoLinea;
$code .= '#include "DHT.h"'.$saltoLinea;
$code .= '#include <avr/wdt.h>'.$saltoLinea;
//SIM 800
if($TipoShield=='sim800'){
	$code .= '#define TINY_GSM_MODEM_SIM800'.$saltoLinea;
//SIM 808
}elseif($TipoShield=='sim808'){
	$code .= '#define TINY_GSM_MODEM_SIM808'.$saltoLinea;
}
$code .= '#define TINY_GSM_RX_BUFFER 650'.$saltoLinea;
$code .= '#include <TinyGsmClient.h>'.$saltoLinea;
//Identificacion APN
$code .= '
const char apn[]      = "'.$rowData['APN_direction'].'"; //Dirección APN
const char gprsUser[] = "";
const char gprsPass[] = "";

/****** Configuracion Inicial ******/
//Variables Constantes
const String server = "webapp.1tek.cl";
const int  port = 80;

//Variables Normales
String datos, apagado, csq, cop;
String id = "'.$rowData['Identificador'].'";  //Identificador
int reboot=0;

//Variables Globales'.$saltoLinea;
//Si se esa utilizando sensores
$code .= $SensListDef;
$code .= $saltoLinea;
$code .= '#define '.$TipoShield.' '.$rowData['PuertoSerial'].$saltoLinea;
$code .= 'TinyGsm modem('.$TipoShield.');'.$saltoLinea;
$code .= '#include <ArduinoHttpClient.h>'.$saltoLinea;
$code .= 'TinyGsmClient client(modem);'.$saltoLinea;
$code .= 'HttpClient http(client, server, port);'.$saltoLinea;
//DHT Se definen instancias y puertos digitales
$code .= $SensDigPortDef;
$code .= '
//Configuracion inicial de la placa
void setup(){
	Serial.begin(9600);
	'.$TipoShield.'.begin(9600);
	Serial.println("Initializing modem...");
	modem.restart();
	//modem.init();
	String modemInfo = modem.getModemInfo();
	Serial.println(cop);
	Serial.print("Modem Info: ");
	Serial.println(modemInfo);';
	$code .= $SensDigPortBegin;
	$code .= '
	pinMode('.$rowData['pinMode'].', OUTPUT);
	digitalWrite('.$rowData['pinMode'].', LOW);
	delay(1000);
}'.$saltoLinea;
//si hay sensores configurados, se toma la medicion de estos
if(isset($rowData['id_Sensores'])&&$rowData['id_Sensores']==1){
	$code .= $saltoLinea.'void medicion(){';
	$code .= $saltoLinea.'	digitalWrite('.$rowData['pinMode'].', HIGH)';
	$code .= $SensListMed;
	$code .= $saltoLinea.'	delay(500);';
	$code .= $saltoLinea.'	digitalWrite('.$rowData['pinMode'].', LOW);';
	$code .= $saltoLinea.'}';
}
//se imprimen los datos por pantalla para las pruebas
$code .= $saltoLinea.'
//se imprimen los datos por pantalla para las pruebas
void imp(){
	csq = modem.getSignalQuality();
	cop = modem.getOperator();
	Serial.print("Modem Signal: ");
	Serial.println(csq);
	Serial.print("Telco: ");
	Serial.println(cop);
	delay(1000); ';
	$code .= $SensListPrint;
	$code .= '
	Serial.println("************************************************************************************");
}'.$saltoLinea;
//si hay sensores configurados, se verifica para corregir las mediciones
if(isset($rowData['id_Sensores'])&&$rowData['id_Sensores']==1){
	$code .= $saltoLinea.'// Lee nuevamente errores de medicion';
	$code .= $saltoLinea.'void NaN(){ ';
	$code .= $saltoLinea.'	Serial.println("Revision Errores");';
	$code .= $saltoLinea.'	for (int i = 0; i <= 2; i++) {';
	$code .= $saltoLinea.'		digitalWrite('.$rowData['pinMode'].', HIGH);';
	$code .= $saltoLinea.'		Serial.print("Ciclo: ");';
	$code .= $saltoLinea.'		Serial.println(i);';
	$code .= $saltoLinea.'		delay(2000);';
	$code .= $saltoLinea.'		//Error DHT22';
	$code .= $SensListError;
	$code .= $saltoLinea.'		digitalWrite('.$rowData['pinMode'].', LOW);';
	$code .= $saltoLinea.'		delay(1000);';
	$code .= $saltoLinea.'	}';
	$code .= $SensListValMed;
	$code .= $saltoLinea.'	Serial.println("Termino Revision Errores");';
	$code .= $saltoLinea.'}';
}

$code .= $saltoLinea.'
//Se arma la url
void url() {';
	//Get GSM
	if(isset($rowData['idFormaEnvio'])&&$rowData['idFormaEnvio']==1){
		$code .= $saltoLinea.'	datos  = "/crosstech/ardu.php?id=";';
	//AT envio
	}elseif(isset($rowData['idFormaEnvio'])&&$rowData['idFormaEnvio']==2){
		$code .= $saltoLinea.'	datos  = "AT+HTTPPARA=\"URL\",\http://webapp.1tek.cl/crosstech/ardu.php?id=";';
	}
	$code .= '
	datos += id;
	datos += "&csq=";
	datos += csq;
	datos += "&cop=";
	datos += cop;
	datos += "&ver=";
	datos += "'.$rowData['Version'].'";';
	$code .= $SensListSend;
	//AT envio
	if(isset($rowData['idFormaEnvio'])&&$rowData['idFormaEnvio']==2){
		$code .= $saltoLinea.'	datos +="\"";';
	}
	$code .= '
}';

//Get GSM
if(isset($rowData['idFormaEnvio'])&&$rowData['idFormaEnvio']==1){
$code .= $saltoLinea.'
void GSMGET() {
	apagado = "3";
	Serial.print("URL: ");
	Serial.println(datos);
	modem.gprsConnect(apn, gprsUser, gprsPass);
	Serial.print("Waiting for network...");
	if (!modem.waitForNetwork()) {
		Serial.println("fail");
		return;
	}
	Serial.println(" success");
	if (modem.isNetworkConnected()) {
		Serial.println("Network connected");
	}
	Serial.print(F("Connecting to "));
	Serial.print(apn);
	if (!modem.gprsConnect(apn, gprsUser, gprsPass)) {
		Serial.println(" fail");
		delay(10000);
		return;
	}
	Serial.println(" success");
	if (modem.isGprsConnected()) {
		Serial.println("GPRS connected");
	}
	Serial.print(F("Performing HTTP GET request... "));
	int err = http.get(datos);
	if (err != 0) {
		Serial.println(F("failed to connect"));
	}
	// Shutdown
	apagado = http.responseBody();
	Serial.println("");
	Serial.print(F("Response:"));
	Serial.println(apagado);
	http.stop();
	Serial.println(F("Server disconnected"));
	modem.gprsDisconnect();
	Serial.println(F("GPRS disconnected"));
}';
//AT envio
}elseif(isset($rowData['idFormaEnvio'])&&$rowData['idFormaEnvio']==2){
$code .= $saltoLinea.'
void envioAT(){
	Serial.println(F("Enviando HTTP"));
	'.$TipoShield.'.println(F("AT+CSQ"));
	delay(100);
	'.$TipoShield.'.println(F("AT+CGATT?"));
	delay(100);
	Serial.println("");
	'.$TipoShield.'.println(F("AT+SAPBR=3,1,\"CONTYPE\",\"GPRS\""));//setting the SAPBR, the connection type is using gprs
	delay(100);
	'.$TipoShield.'.println(AT+SAPBR=3,1,\"APN\",\"'.$rowData['APN_direction'].'\");
	delay(400);
	'.$TipoShield.'.println(F("AT+SAPBR=1,1"));//setting the SAPBR, for detail you can refer to the AT command mamual
	delay(200);
	'.$TipoShield.'.println(F("AT+HTTPINIT")); //init the HTTP request
	delay(500);
	'.$TipoShield.'.println(datos);
	delay(1000);
	'.$TipoShield.'.println(F("AT+HTTPACTION=0"));//submit the request
	delay(500);
	'.$TipoShield.'.println(F("AT+CIPCLOSE"));//close the connection delay(100);
	delay(100);
	Serial.println(F("Enviado"));
}';
}


$code .= $saltoLinea.'
void loop(){';
	if(isset($rowData['id_Sensores'])&&$rowData['id_Sensores']==1){
		$code .= $saltoLinea.'	medicion();';
		$code .= $saltoLinea.'	NaN();';
	}
	$code .= '
	imp(); //Muestra los datos por pantalla (Comentar en produccion)
	url(); //Genera la URL';
	//Get GSM
	if(isset($rowData['idFormaEnvio'])&&$rowData['idFormaEnvio']==1){
		$code .= $saltoLinea.'	GSMGET();';
	//AT envio
	}elseif(isset($rowData['idFormaEnvio'])&&$rowData['idFormaEnvio']==2){
		$code .= $saltoLinea.'	envioAT();';
	}
	$code .= $saltoLinea.'
	/*
	if (apagado == "1"){
		Serial.println("Conectado");
		digitalWrite(13, HIGH);
		reboot=0;
	} else {
		Serial.println("Desconectado");
		digitalWrite(13, LOW);
		reboot++;
	}
	Serial.print("Reboot: ");
	Serial.println(reboot);
	if (reboot == 5){wdt_enable(WDTO_1S);}*/
	//Tiempo entre cada iteracion
	//delay(60000);   //1 minutos
	//delay(90000);   // 2 minutos
	delay(150000);  // 3 minutos
	//delay(210000);  // 4 minutos
	//delay(270000);  // 5 minutos
}

';

	return $code;
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////
function aaaa($rowData) {
	$saltoLinea = '
';
$SensCant = 0;
//////////////////////////////////////////////////////////////////////////////////////////////
//Encabezado con información Basica
$code = '
/* Equipo '.$rowData['nombre_equipo'].'
 * Creado por: '.$rowData['nombre_usuario'].'
 * Fecha Creacion: '.Fecha_completa_alt($rowData['Fecha']).'
 *
 * Version: '.$rowData['Version'].'
 * Master '.$rowData['Tab'].'
 * Placa: '.$rowData['Dispositivo'].'
 * Comunicacion: '.$rowData['Shield'].'
 * Datos Moviles:
 * Uso GPS: '.$rowData['Geo'].'
 * Uso Sensores: '.$rowData['Sensores'].$saltoLinea;
$code .= $SensCant;
//Si hay observaciones relacionadas al script se incluyen
$code .= ' * Obs: '.$rowData['Observacion'].$saltoLinea.' */'.$saltoLinea;
$code .= '
#include <Bridge.h>
#include <Console.h>
#include <HttpClient.h>
HttpClient http;
char apagado;

#include "EmonLib.h"
EnergyMonitor emon1;
EnergyMonitor emon2;
EnergyMonitor emon3;

//Variables Globales
double Irms1, Irms2, Irms3, p;
int i;
float v0, v3, voltage;

//volt
float voltageSampleRead  = 0;
float voltageSampleCount = 0;
float voltageLastSample  = 0;
float voltageSampleSum   = 0;
float voltageMean ;
float RMSVoltageMean ;
float adjustRMSVoltageMean;
float FinalRMSVoltage;
float voltageOffset1 =0.00 ;
float voltageOffset2 = -4.00;



String id = "200";  //ingresar ID
String datos ="";


void setup() {
	Bridge.begin(115200);
	Console.begin();
	//Calibracion AMP
	emon1.current(A1,  183.65);
	emon2.current(A2,  183.65);
	emon3.current(A3,  183.65);
	Console.println("Inizializando Sensores AMP");
	for (int x = 0; x <= 5; x++){
		Console.println(x);
		Irms1 =  emon1.calcIrms(5588);
		Irms2 =  emon2.calcIrms(5588);
		Irms3 =  emon3.calcIrms(5588);
	}
}



void mediciones() {
	Irms1 =  emon1.calcIrms(5588);   //Alimentacion U
	Irms2 =  emon2.calcIrms(5588);   //Alimentacion V
	Irms3 =  emon3.calcIrms(5588);   //Alimentacion W
	if (Irms1 < 1) {Irms1 = 0;}
	if (Irms2 < 1) {Irms2 = 0;}
	if (Irms3 < 1) {Irms3 = 0;}
	volt();
	p = (Irms1*v0 + Irms2*v0 + Irms3*v0)/1000;  //Potencia
	nivel();
}

void volt(){
	int x = 0;
	Console.println(i);
	while (x < 1000) {
		if(micros() >= voltageLastSample + 1000 ){
			voltageSampleRead = (analogRead(A4)- 512)+ voltageOffset1;
			voltageSampleSum = voltageSampleSum + sq(voltageSampleRead) ;
			voltageSampleCount = voltageSampleCount + 1;
			voltageLastSample = micros() ;
			x++;
		}
	}

	Console.println(voltageSampleCount);
	if(voltageSampleCount == 1000){
		Console.println(voltageSampleCount);
		voltageMean = voltageSampleSum/voltageSampleCount;
		RMSVoltageMean = (sqrt(voltageMean))*1.5;
		adjustRMSVoltageMean = RMSVoltageMean + voltageOffset2;
		FinalRMSVoltage = RMSVoltageMean + voltageOffset2;
		if(FinalRMSVoltage <= 2.5){
			FinalRMSVoltage = 0;
		}
		v0 = FinalRMSVoltage;
		v3 = v0 * sqrt(3);
		if (v3 < 40){v3 = 99900;}
		voltageSampleSum =0;
		voltageSampleCount=0;
		Console.println(i);
		i=0;
	}
}



void nivel(){
	// read the input on analog pin 5:
	int sensorValue = analogRead(A0);
	// Convert the analog reading (which goes from 0 - 1023) to a voltage (0 - 5V):
	voltage = sensorValue * (5.0 / 1024.0);
	Console.println("Valor presion volt: ");
	Console.println(voltage);
	voltage = voltage * 34.54545 - 31.78181;  //Calibracion a % 0% = 0.89v 19% 1.46v
	Console.println("Valor presion %: ");
	Console.println(voltage);
	if (voltage < 0) {voltage = 0;}
}

void url() {
	datos =http://webapp.1tek.cl/crosstech/ardu.php?id=;
	datos += id;
	datos += "&s1=";
	datos += Irms1;
	datos += "&s2=";
	datos += Irms2;
	datos += "&s3=";
	datos += Irms3;
	datos += "&s4=";
	datos += v0;
	datos += "&s5=";
	datos += v3;
	datos += "&s6=";
	datos += p;
	datos += "&s7=";
	datos += voltage;
}

void imp() {
	Console.println(" LAS MEDICIONES SON: ");
	Console.print("irms1: ");
	Console.println(Irms1);
	Console.print("irms2: ");
	Console.println(Irms2);
	Console.print("irms3: ");
	Console.println(Irms3);
	Console.print("Voltaje: ");
	Console.println(v0);
	Console.print("Voltaje3: ");
	Console.println(v3);
	Console.print("Potencia: ");
	Console.println(p);
	Console.print("nivel: ");
	Console.println(voltage);
}

void envio() {
	Console.print("Url Envio: ");
	Console.println(datos);
	http.get(datos);
	int status = http.available();
	Console.print("status code: ");
	Console.println(status);
	apagado = http.read();
	Console.print("Response:");
	Console.println(apagado);
}



void loop() {
	mediciones();
	imp();
	url();
	envio();
	delay(3000);
}
';



	return $code;
}


?>
