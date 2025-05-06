<?php
/**********************************************************************************************************************************/
/*                                                   Se define la Sesion                                                          */
/**********************************************************************************************************************************/
$timeout = 604800;                               //Se setea la expiracion a una semana
ini_set( "session.gc_maxlifetime", $timeout );   //Establecer la vida útil máxima de la sesión
ini_set( "session.cookie_lifetime", $timeout );  //Establecer la duración de las cookies de la sesión
session_start();                                 //Iniciar una nueva sesión
/**********************************************************************************************************************************/
/*                                                     Se llama la libreria                                                       */
/**********************************************************************************************************************************/
require '../LIBS_php/PhpOffice/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
/**********************************************************************************************************************************/
/*                                           Se define la variable de seguridad                                                   */
/**********************************************************************************************************************************/
define('XMBCXRXSKGC', 1);
/**********************************************************************************************************************************/
/*                                          Se llaman a los archivos necesarios                                                   */
/**********************************************************************************************************************************/
require_once 'core/Load.Utils.Excel.php';
/**********************************************************************************************************************************/
/*                                                 Variables Globales                                                             */
/**********************************************************************************************************************************/
//Tiempo Maximo de la consulta, 40 minutos por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigTime'])&&$_SESSION['usuario']['basic_data']['ConfigTime']!=0){$n_lim = $_SESSION['usuario']['basic_data']['ConfigTime']*60;set_time_limit($n_lim);}else{set_time_limit(2400);}
//Memora RAM Maxima del servidor, 4GB por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigRam'])&&$_SESSION['usuario']['basic_data']['ConfigRam']!=0){$n_ram = $_SESSION['usuario']['basic_data']['ConfigRam']; ini_set('memory_limit', $n_ram.'M');}else{ini_set('memory_limit', '4096M');}
/**********************************************************************************************************************************/
/*                                                          Consultas                                                             */
/**********************************************************************************************************************************/
//obtengo los datos de la empresa
$rowEmpresa = db_select_data (false, 'Nombre', 'core_sistemas','', 'idSistema='.$_GET['idSistema'], $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowEmpresa');

/**********************************************************/
//Variable de busqueda
$SIS_where = "telemetria_listado_historial_activaciones.idEstado=1";
/**********************************************************/
//Se aplican los filtros
if(isset($_GET['idTelemetria']) && $_GET['idTelemetria']!=''){$SIS_where.=" AND telemetria_listado_historial_activaciones.idTelemetria =".$_GET['idTelemetria'];}
if(isset($_GET['F_inicio'], $_GET['F_termino'], $_GET['h_inicio'], $_GET['h_termino']) && $_GET['F_inicio'] != '' && $_GET['F_termino'] != '' && $_GET['h_inicio'] != '' && $_GET['h_termino']!=''){
	$SIS_where.=" AND telemetria_listado_historial_activaciones.TimeStamp BETWEEN '".$_GET['F_inicio']." ".$_GET['H_inicio']."' AND '".$_GET['F_termino']." ".$_GET['H_termino']."'";
}elseif(isset($_GET['F_inicio'], $_GET['F_termino']) && $_GET['F_inicio'] != '' && $_GET['F_termino']!=''){
	$SIS_where.=" AND telemetria_listado_historial_activaciones.Fecha BETWEEN '".$_GET['F_inicio']."' AND '".$_GET['F_termino']."'";
}
//verifico el numero de datos antes de hacer la consulta
$ndata_1 = db_select_nrows (false, 'idTelemetria', 'telemetria_listado_historial_activaciones', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'ndata_1');

//si el dato es superior a 10.000
if(isset($ndata_1)&&$ndata_1>=10001){
	alert_post_data(4,1,1,0, 'Estas tratando de seleccionar mas de 10.000 datos, trata con un rango inferior para poder mostrar resultados');
}else{
	/**********************************************************/
	//se consulta
	$SIS_query = '
	telemetria_listado_historial_activaciones.idTelemetria,
	telemetria_listado_historial_activaciones.Fecha AS EquipoFecha,
	telemetria_listado_historial_activaciones.Hora AS EquipoHora,
	telemetria_listado_historial_activaciones.SensorActivacionValor AS EquipoActivacionValor,
	telemetria_listado_historial_activaciones.Valor AS EquipoValor,
	telemetria_listado_historial_activaciones.idFueraHorario AS FueraHorario,

	telemetria_listado.Nombre AS EquipoNombre,
	telemetria_listado.Identificador AS CodigoInterno,
	telemetria_listado.cantSensores AS EquipoN_Sensores,
	telemetria_listado.Direccion AS Direccion,
	telemetria_listado.Jornada_inicio AS EquipoJornada_inicio,
	telemetria_listado.Jornada_termino AS EquipoJornada_termino,
	telemetria_listado.Colacion_inicio AS EquipoColacion_inicio,
	telemetria_listado.Colacion_termino AS EquipoColacion_termino,
	telemetria_listado.Microparada AS EquipoMicroparada';
	$SIS_join  = 'LEFT JOIN `telemetria_listado` ON telemetria_listado.idTelemetria = telemetria_listado_historial_activaciones.idTelemetria';

	$SIS_order = 'telemetria_listado_historial_activaciones.idTelemetria ASC, telemetria_listado_historial_activaciones.Fecha ASC, telemetria_listado_historial_activaciones.Hora ASC';
	$arrConsulta = array();
	$arrConsulta = db_select_array (false, $SIS_query,  'telemetria_listado_historial_activaciones', $SIS_join,  $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrConsulta');

	/**********************************************************************************************************************************/
	/*                                                          Ejecucion                                                             */
	/**********************************************************************************************************************************/
	// Create new Spreadsheet object
	$spreadsheet = new Spreadsheet();

	// Set document properties
	$spreadsheet->getProperties()->setCreator(DeSanitizar($rowEmpresa['Nombre']))
				->setLastModifiedBy(DeSanitizar($rowEmpresa['Nombre']))
				->setTitle("Office 2007")
				->setSubject("Office 2007")
				->setDescription("Document for Office 2007")
				->setKeywords("office 2007")
				->setCategory("office 2007 result file");
			
	//Titulo columnas
	$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A1', 'Equipo')
				->setCellValue('B1', 'Codigo Interno')
				->setCellValue('C1', 'Dirección')
				->setCellValue('D1', 'Fecha')
				->setCellValue('E1', 'Hora Inicio')
				->setCellValue('F1', 'Hora Termino')
				->setCellValue('G1', 'Tiempo Colacion')
				->setCellValue('H1', 'Tiempo Muerto')
				->setCellValue('I1', 'Tiempo Perdido')
				->setCellValue('J1', 'Sobre Tiempo');

	$nn=2;
	filtrar($arrConsulta, 'EquipoNombre');
	foreach($arrConsulta as $categoria=>$permisos){

		//Variables
		$fecha              = '';
		$HoraInicio         = '';
		$HoraTermino        = '';
		$TiempoColacionIni  = '00:00:00';
		$TiempoColacionTer  = '00:00:00';
		$TiempoColacionTot  = '00:00:00';
		$TiempoMuerto       = '00:00:00';
		$TiempoMuertoTemp   = '00:00:00';
		$TiempoPerdido      = '00:00:00';
		$SobreTiempo_1      = '00:00:00';
		$SobreTiempo_2      = '00:00:00';
		$colacion           = 0;
		$FueraHorario       = 0;
		$Direccion          = '';
		$CodigoInterno      = '';
								
		//Recorrido
		foreach ($permisos as $con) {
			//Contrato Codigo
			$Direccion          = $con['Direccion'];
			$CodigoInterno      = $con['CodigoInterno'];

			/*****************************************************************/
			//Verifico si esta dentro del mismo dia
			if($fecha!=''&&$fecha==$con['EquipoFecha']){

				/***************************************/
				//Verifico hora inicio
				if($HoraInicio>$con['EquipoHora']&&$con['EquipoValor']==$con['EquipoActivacionValor']){
					$HoraInicio = $con['EquipoHora'];
				}
				//verifico hora termino
				if($HoraTermino<$con['EquipoHora']&&$con['EquipoValor']!=$con['EquipoActivacionValor']){
					$HoraTermino = $con['EquipoHora'];
				}
				/***************************************/
				//verifico la hora de inicio de colacion
				if($con['EquipoColacion_inicio']<=$con['EquipoHora']&&$con['EquipoColacion_termino']>=$con['EquipoHora']&&$con['EquipoValor']!=$con['EquipoActivacionValor']){
					$TiempoColacionIni = $con['EquipoHora'];
					$colacion = 1;
				}
				//se verifica el termino de la colacion
				if($colacion==1&&$TiempoColacionTot=='00:00:00'&&$con['EquipoValor']==$con['EquipoActivacionValor']){
					//reseteo
					$colacion = 0;
					$TiempoColacionTer = $con['EquipoHora'];
					//Calculo colacion
					$Tiempo = restahoras($TiempoColacionIni, $TiempoColacionTer);
					if($Tiempo>'00:30:00'){
						$TiempoColacionTot = $Tiempo;
					}
											
				}
				/***************************************/
				//Verifico el tiempo muerto
				if($con['EquipoValor']!=$con['EquipoActivacionValor']){
					$TiempoMuertoTemp  = $con['EquipoHora'];
				}
				if($con['EquipoValor']==$con['EquipoActivacionValor']&&$TiempoMuertoTemp!='00:00:00'){
					//calculo los tiempos
					$Tiempo = restahoras($TiempoMuertoTemp ,$con['EquipoHora']);
					//verifico que sea superior a la microparadas
					if($Tiempo>=$con['EquipoMicroparada']){
						$TiempoMuerto1 = sumahoras($TiempoMuerto,$Tiempo);
						//validacion
						if($TiempoMuerto1!='El dato ingresado no es una hora'){
							$TiempoMuerto = $TiempoMuerto1;
						}
						//le resto el tiempo de colacion solo si el tiempo muerto es igual o superior
						if($TiempoMuerto>=$TiempoColacionTot){
							$TiempoMuerto = restahoras($TiempoColacionTot ,$TiempoMuerto);
						}
					}
				}
										
				/***************************************/
				//Verifico el sobretiempo
				if($SobreTiempo_1=='00:00:00'&&$con['EquipoJornada_inicio']>=$con['EquipoHora']&&$con['EquipoValor']==$con['EquipoActivacionValor']){
					$SobreTiempo_1 = sumahoras($SobreTiempo_1, restahoras($con['EquipoHora'], $con['EquipoJornada_inicio']));
				}
				if($con['EquipoJornada_termino']<=$con['EquipoHora']&&$con['EquipoValor']!=$con['EquipoActivacionValor']){
					$SobreTiempo_2 = restahoras($con['EquipoJornada_termino'],$con['EquipoHora'] );
				}
										
				/***************************************/
				//Verifico si tiene algun dato que figure como fuera de horario
				if(isset($con['FueraHorario'])&&$con['FueraHorario']!=0){
					$FueraHorario++;
				}

			/*****************************************************************/
			//Si cambia de dia
			}elseif($fecha!=''&&$fecha!=$con['EquipoFecha']){ 
				
				//Calculo de la perdida de tiempo
				if($con['EquipoJornada_inicio']<=$HoraInicio){
					$TiempoPerdido = sumahoras($TiempoPerdido, restahoras($con['EquipoJornada_inicio'], $HoraInicio));
				}
				if($con['EquipoJornada_termino']>=$HoraTermino){
					$TiempoPerdido = sumahoras($TiempoPerdido, restahoras($HoraTermino, $con['EquipoJornada_termino'] ));
				}

				$spreadsheet->setActiveSheetIndex(0)
							->setCellValue('A'.$nn, DeSanitizar($categoria))
							->setCellValue('B'.$nn, DeSanitizar($CodigoInterno))
							->setCellValue('C'.$nn, DeSanitizar($Direccion))
							->setCellValue('D'.$nn, fecha_estandar($fecha))
							->setCellValue('E'.$nn, $HoraInicio)
							->setCellValue('F'.$nn, $HoraTermino)
							->setCellValue('G'.$nn, $TiempoColacionTot)
							->setCellValue('H'.$nn, $TiempoMuerto)
							->setCellValue('I'.$nn, $TiempoPerdido)
							->setCellValue('J'.$nn, sumahoras($SobreTiempo_1,$SobreTiempo_2));
				$nn++;

				//redeclaro variables
				$fecha              = $con['EquipoFecha'];
				$HoraInicio         = $con['EquipoHora'];
				$HoraTermino        = $con['EquipoHora'];
				$TiempoColacionIni  = '00:00:00';
				$TiempoColacionTer  = '00:00:00';
				$TiempoColacionTot  = '00:00:00';
				$TiempoMuerto       = '00:00:00';
				$TiempoMuertoTemp   = '00:00:00';
				$TiempoPerdido      = '00:00:00';
				$SobreTiempo_1      = '00:00:00';
				$SobreTiempo_2      = '00:00:00';
				$colacion           = 0;
				$FueraHorario       = 0;

				/***************************************/
				//Verifico el sobretiempo
				if($SobreTiempo_1=='00:00:00'&&$con['EquipoJornada_inicio']>=$con['EquipoHora']&&$con['EquipoValor']==$con['EquipoActivacionValor']){
					$SobreTiempo_1 = sumahoras($SobreTiempo_1, restahoras($con['EquipoHora'], $con['EquipoJornada_inicio']));
				}
				if($con['EquipoJornada_termino']<=$con['EquipoHora']&&$con['EquipoValor']!=$con['EquipoActivacionValor']){
					$SobreTiempo_2 = restahoras($con['EquipoJornada_termino'],$con['EquipoHora'] );
				}
				/***************************************/
				//Verifico si tiene algun dato que figure como fuera de horario
				if(isset($con['FueraHorario'])&&$con['FueraHorario']!=0){
					$FueraHorario++;
				}
										
			/*****************************************************************/
			//Primer dato
			}else{
				$fecha              = $con['EquipoFecha'];
				$HoraInicio         = $con['EquipoHora'];
				$HoraTermino        = $con['EquipoHora'];
				$TiempoColacionIni  = '00:00:00';
				$TiempoColacionTer  = '00:00:00';
				$TiempoColacionTot  = '00:00:00';
				$TiempoMuerto       = '00:00:00';
				$TiempoMuertoTemp   = '00:00:00';
				$TiempoPerdido      = '00:00:00';
				$SobreTiempo_1      = '00:00:00';
				$SobreTiempo_2      = '00:00:00';
				$colacion           = 0;
				$FueraHorario       = 0;
				$Direccion          = $con['Direccion'];
				$CodigoInterno      = $con['CodigoInterno'];

				/***************************************/
				//Verifico el sobretiempo
				if($SobreTiempo_1=='00:00:00'&&$con['EquipoJornada_inicio']>=$con['EquipoHora']&&$con['EquipoValor']==$con['EquipoActivacionValor']){
					$SobreTiempo_1 = sumahoras($SobreTiempo_1, restahoras($con['EquipoHora'], $con['EquipoJornada_inicio']));
				}
				if($con['EquipoJornada_termino']<=$con['EquipoHora']&&$con['EquipoValor']!=$con['EquipoActivacionValor']){
					$SobreTiempo_2 = restahoras($con['EquipoJornada_termino'],$con['EquipoHora'] );
				}
				/***************************************/
				//Verifico si tiene algun dato que figure como fuera de horario
				if(isset($con['FueraHorario'])&&$con['FueraHorario']!=0){
					$FueraHorario++;
				}

			}
									
			$l_ejti = $con['EquipoJornada_inicio'];
			$l_ejtt = $con['EquipoJornada_termino'];
			$l_mp   = $con['EquipoMicroparada'];
			$l_v1   = $con['EquipoValor'];
			$l_v2   = $con['EquipoActivacionValor'];
							
		} 
		/**********************************************************************************/
		//ultimo dato
		//Calculo colacion
		//$TiempoColacionTot = restahoras($TiempoColacionIni, $TiempoColacionTer);
		//Calculo de la perdida de tiempo
		if($l_ejti<=$HoraInicio){
			$TiempoPerdido = sumahoras($TiempoPerdido, restahoras($l_ejti, $HoraInicio));
		}
		if($l_ejtt>=$HoraTermino){
			$TiempoPerdido = sumahoras($TiempoPerdido, restahoras($HoraTermino, $l_ejtt ));
		}
		//Verifico el sobretiempo
		if($l_ejti>=$HoraInicio&&$l_v1==$l_v2){
			$SobreTiempo_1 = sumahoras($SobreTiempo_1, restahoras($HoraInicio,$l_ejti));
		}
		if($l_ejtt<=$HoraInicio&&$l_v1!=$l_v2){
			$SobreTiempo_2 = sumahoras($SobreTiempo_2, restahoras($l_ejtt,$HoraInicio ));
		}	
		
		$spreadsheet->setActiveSheetIndex(0)
					->setCellValue('A'.$nn, DeSanitizar($categoria))
					->setCellValue('B'.$nn, DeSanitizar($CodigoInterno))
					->setCellValue('C'.$nn, DeSanitizar($Direccion))
					->setCellValue('D'.$nn, fecha_estandar($fecha))
					->setCellValue('E'.$nn, $HoraInicio)
					->setCellValue('F'.$nn, $HoraTermino)
					->setCellValue('G'.$nn, $TiempoColacionTot)
					->setCellValue('H'.$nn, $TiempoMuerto)
					->setCellValue('I'.$nn, $TiempoPerdido)
					->setCellValue('J'.$nn, sumahoras($SobreTiempo_1,$SobreTiempo_2));
		$nn++;		
			
	}		




	// Rename worksheet
	$spreadsheet->getActiveSheet()->setTitle('Activaciones');

	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$spreadsheet->setActiveSheetIndex(0);

	/**************************************************************************/
	//Nombre del archivo
	$filename = 'Informe Activaciones';
	// Redirect output to a client’s web browser (Xlsx)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="'.DeSanitizar($filename).'.xlsx"');
	header('Cache-Control: max-age=0');
	// If you're serving to IE 9, then the following may be needed
	header('Cache-Control: max-age=1');

	// If you're serving to IE over SSL, then the following may be needed
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
	header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
	header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	header('Pragma: public'); // HTTP/1.0

	$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
	$writer->save('php://output');
	exit;
}
