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
$SIS_where = "cross_solicitud_aplicacion_listado.idSolicitud!=0";
//Verifico el tipo de usuario que esta ingresando
$SIS_where.= " AND cross_solicitud_aplicacion_listado.idSistema=".$_GET['idSistema'];
/**********************************************************/
//Se aplican los filtros
if(isset($_GET['NSolicitud']) && $_GET['NSolicitud']!=''){   $SIS_where .= " AND cross_solicitud_aplicacion_listado.NSolicitud=".$_GET['NSolicitud'];}
if(isset($_GET['idPredio']) && $_GET['idPredio']!=''){       $SIS_where .= " AND cross_solicitud_aplicacion_listado.idPredio=".$_GET['idPredio'];}
if(isset($_GET['idZona']) && $_GET['idZona']!=''){           $SIS_where .= " AND cross_solicitud_aplicacion_listado_cuarteles.idZona=".$_GET['idZona'];}
if(isset($_GET['idTemporada']) && $_GET['idTemporada']!=''){ $SIS_where .= " AND cross_solicitud_aplicacion_listado.idTemporada=".$_GET['idTemporada'];}
if(isset($_GET['idEstadoFen']) && $_GET['idEstadoFen']!=''){ $SIS_where .= " AND cross_solicitud_aplicacion_listado.idEstadoFen=".$_GET['idEstadoFen'];}
if(isset($_GET['idCategoria']) && $_GET['idCategoria']!=''){ $SIS_where .= " AND cross_solicitud_aplicacion_listado.idCategoria=".$_GET['idCategoria'];}
if(isset($_GET['idProducto']) && $_GET['idProducto']!=''){   $SIS_where .= " AND cross_solicitud_aplicacion_listado.idProducto=".$_GET['idProducto'];}
if(isset($_GET['idUsuario']) && $_GET['idUsuario']!=''){     $SIS_where .= " AND cross_solicitud_aplicacion_listado.idUsuario=".$_GET['idUsuario'];}
if(isset($_GET['idEstado']) && $_GET['idEstado']!=''){       $SIS_where .= " AND cross_solicitud_aplicacion_listado.idEstado=".$_GET['idEstado'];}
if(isset($_GET['f_programacion_desde'], $_GET['f_programacion_hasta'])&&$_GET['f_programacion_desde']!=''&&$_GET['f_programacion_hasta']!=''){
	$SIS_where.=" AND cross_solicitud_aplicacion_listado.f_programacion BETWEEN '".$_GET['f_programacion_desde']."' AND '".$_GET['f_programacion_hasta']."'";
}
if(isset($_GET['f_ejecucion_desde'], $_GET['f_ejecucion_hasta'])&&$_GET['f_ejecucion_desde']!=''&&$_GET['f_ejecucion_hasta']!=''){
	$SIS_where.=" AND cross_solicitud_aplicacion_listado.f_ejecucion BETWEEN '".$_GET['f_ejecucion_desde']."' AND '".$_GET['f_ejecucion_hasta']."'";
}
if(isset($_GET['f_termino_desde'], $_GET['f_termino_hasta'])&&$_GET['f_termino_desde']!=''&&$_GET['f_termino_hasta']!=''){
	$SIS_where.=" AND cross_solicitud_aplicacion_listado.f_termino BETWEEN '".$_GET['f_termino_desde']."' AND '".$_GET['f_termino_hasta']."'";
}
/**********************************************************/
// Se trae un listado con todos los elementos
$SIS_query = '
cross_solicitud_aplicacion_listado.idSolicitud,
cross_solicitud_aplicacion_listado.NSolicitud,
cross_solicitud_aplicacion_listado.f_creacion,
cross_solicitud_aplicacion_listado.f_programacion,
cross_solicitud_aplicacion_listado.f_ejecucion,
cross_solicitud_aplicacion_listado.f_termino,
cross_solicitud_aplicacion_listado.f_programacion_fin,
cross_solicitud_aplicacion_listado.f_ejecucion_fin,
cross_solicitud_aplicacion_listado.f_termino_fin,
cross_solicitud_aplicacion_listado.horaProg,
cross_solicitud_aplicacion_listado.horaEjecucion,
cross_solicitud_aplicacion_listado.horaTermino,
cross_solicitud_aplicacion_listado.horaProg_fin,
cross_solicitud_aplicacion_listado.horaEjecucion_fin,
cross_solicitud_aplicacion_listado.horaTermino_fin,

cross_predios_listado.Nombre AS NombrePredio,
core_estado_solicitud.Nombre AS Estado,
sistema_variedades_categorias.Nombre AS VariedadCat,
variedades_listado.Nombre AS VariedadNombre,
cross_predios_listado_zonas.Nombre AS CuartelNombre,
cross_predios_listado_zonas.AnoPlantacion AS CuartelAnoPlantacion,
cross_predios_listado_zonas.Hectareas AS CuartelHectareas,
cross_predios_listado_zonas.Hileras AS CuartelHileras,
cross_predios_listado_zonas.Plantas AS CuartelPlantas,
cross_predios_listado_zonas.DistanciaPlant AS CuartelDistanciaPlant,
cross_predios_listado_zonas.DistanciaHileras AS CuartelDistanciaHileras,
core_cross_estados_productivos.Nombre AS CuartelEstadoProd,
cross_checking_estado_fenologico.Codigo AS EstadoFenCodigo,
cross_checking_estado_fenologico.Nombre AS EstadoFenNombre,
cross_solicitud_aplicacion_listado_cuarteles.f_cierre AS Cuartelf_cierre,
cross_solicitud_aplicacion_listado_cuarteles.Mojamiento AS CuartelMojamiento,
cross_solicitud_aplicacion_listado_cuarteles.VelTractor AS CuartelVelTractor,
cross_solicitud_aplicacion_listado_cuarteles.VelViento AS CuartelVelViento,
cross_solicitud_aplicacion_listado_cuarteles.TempMin AS CuartelTempMin,
cross_solicitud_aplicacion_listado_cuarteles.TempMax AS CuartelTempMax,
vehiculos_listado.Marca AS Vehiculo_Marca,
telemetria_listado.Nombre AS Telem_Identificador,
telemetria_listado.Capacidad AS Telem_Capacidad,
cross_solicitud_aplicacion_listado_tractores.Diferencia AS Telem_Diferencia,
cross_solicitud_aplicacion_listado_tractores.GeoVelocidadMin AS Telem_GeoVelocidadMin,
cross_solicitud_aplicacion_listado_tractores.GeoVelocidadMax AS Telem_GeoVelocidadMax,
cross_solicitud_aplicacion_listado_tractores.GeoVelocidadProm AS Telem_GeoVelocidadProm,
cross_solicitud_aplicacion_listado_tractores.GeoDistance AS Telem_GeoDistance,
cross_solicitud_aplicacion_listado_tractores.Sensor_1_Prom AS Telem_Sensor_1_Prom,
cross_solicitud_aplicacion_listado_tractores.Sensor_2_Prom AS Telem_Sensor_2_Prom,
cross_solicitud_aplicacion_listado_tractores.Sensor_1_Min AS Telem_Sensor_1_Min,
cross_solicitud_aplicacion_listado_tractores.Sensor_2_Min AS Telem_Sensor_2_Min,
cross_solicitud_aplicacion_listado_tractores.Sensor_1_Max AS Telem_Sensor_1_Max,
cross_solicitud_aplicacion_listado_tractores.Sensor_2_Max AS Telem_Sensor_2_Max,
cross_solicitud_aplicacion_listado_tractores.Sensor_1_Sum AS Telem_Sensor_1_Sum,
cross_solicitud_aplicacion_listado_tractores.Sensor_2_Sum AS Telem_Sensor_2_Sum,
dosificador.Rut AS DosificadorRut,
dosificador.Nombre AS DosificadorNombre,
dosificador.ApellidoPat AS DosificadorApellidoPat,
conductor.Rut AS ConductorRut,
conductor.Nombre AS ConductorNombre,
conductor.ApellidoPat AS ConductorApellidoPat,
usuarios_listado.Nombre AS NombreUsuario,
cross_checking_temporada.Codigo AS TemporadaCodigo,
cross_checking_temporada.Nombre AS TemporadaNombre,
core_cross_prioridad.Nombre AS NombrePrioridad,

sistema_productos_categorias.Nombre AS ProductoCategoria,
productos_listado.IngredienteActivo AS ProductoIngrediente,
productos_listado.Nombre AS ProductoNombre,
productos_listado.EfectoResidual AS ProductoEfectoResidual,
productos_listado.EfectoRetroactivo AS ProductoEfectoRetroactivo,
productos_listado.CarenciaExportador AS ProductoCarenciaExportador,
sistema_productos_uml.Nombre AS ProductoUniMed,
cross_solicitud_aplicacion_listado_productos.DosisRecomendada AS ProductoDosisRecomendada,
cross_solicitud_aplicacion_listado_productos.DosisAplicar AS ProductoDosisAplicar,
cross_solicitud_aplicacion_listado_productos.Objetivo AS ProductoObjetivo';
$SIS_join  = '
LEFT JOIN `cross_predios_listado`                          ON cross_predios_listado.idPredio                             = cross_solicitud_aplicacion_listado.idPredio
LEFT JOIN `usuarios_listado`                               ON usuarios_listado.idUsuario                                 = cross_solicitud_aplicacion_listado.idUsuario
LEFT JOIN `core_estado_solicitud`                          ON core_estado_solicitud.idEstado                             = cross_solicitud_aplicacion_listado.idEstado
LEFT JOIN `cross_checking_temporada`                       ON cross_checking_temporada.idTemporada                       = cross_solicitud_aplicacion_listado.idTemporada
LEFT JOIN `cross_checking_estado_fenologico`               ON cross_checking_estado_fenologico.idEstadoFen               = cross_solicitud_aplicacion_listado.idEstadoFen
LEFT JOIN `sistema_variedades_categorias`                  ON sistema_variedades_categorias.idCategoria                  = cross_solicitud_aplicacion_listado.idCategoria
LEFT JOIN `variedades_listado`                             ON variedades_listado.idProducto                              = cross_solicitud_aplicacion_listado.idProducto
LEFT JOIN `core_cross_prioridad`                           ON core_cross_prioridad.idPrioridad                           = cross_solicitud_aplicacion_listado.idPrioridad
LEFT JOIN `trabajadores_listado`     dosificador           ON dosificador.idTrabajador                                   = cross_solicitud_aplicacion_listado.idDosificador
LEFT JOIN `cross_solicitud_aplicacion_listado_cuarteles`   ON cross_solicitud_aplicacion_listado_cuarteles.idSolicitud   = cross_solicitud_aplicacion_listado.idSolicitud
LEFT JOIN `cross_predios_listado_zonas`                    ON cross_predios_listado_zonas.idZona                         = cross_solicitud_aplicacion_listado_cuarteles.idZona
LEFT JOIN `core_cross_estados_productivos`                 ON core_cross_estados_productivos.idEstadoProd                = cross_predios_listado_zonas.idEstadoProd
LEFT JOIN `cross_solicitud_aplicacion_listado_tractores`   ON cross_solicitud_aplicacion_listado_tractores.idCuarteles   = cross_solicitud_aplicacion_listado_cuarteles.idCuarteles
LEFT JOIN `telemetria_listado`                             ON telemetria_listado.idTelemetria                            = cross_solicitud_aplicacion_listado_tractores.idTelemetria
LEFT JOIN `vehiculos_listado`                              ON vehiculos_listado.idVehiculo                               = cross_solicitud_aplicacion_listado_tractores.idVehiculo
LEFT JOIN `trabajadores_listado`       conductor           ON conductor.idTrabajador                                     = cross_solicitud_aplicacion_listado_tractores.idTrabajador
LEFT JOIN `cross_solicitud_aplicacion_listado_productos`   ON cross_solicitud_aplicacion_listado_productos.idCuarteles   = cross_solicitud_aplicacion_listado_cuarteles.idCuarteles
LEFT JOIN `productos_listado`                              ON productos_listado.idProducto                               = cross_solicitud_aplicacion_listado_productos.idProducto
LEFT JOIN `sistema_productos_categorias`                   ON sistema_productos_categorias.idCategoria                   = productos_listado.idCategoria
LEFT JOIN `sistema_productos_uml`                          ON sistema_productos_uml.idUml                                = cross_solicitud_aplicacion_listado_productos.idUml';
$SIS_order = 'cross_solicitud_aplicacion_listado.NSolicitud ASC';
$arrOTS = array();
$arrOTS = db_select_array (false, $SIS_query, 'cross_solicitud_aplicacion_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrOTS');

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
			->setCellValue('A1', 'Agro Checking - Exportar Datos');

//variables
$nn=2;
//Titulo columnas
$spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.$nn, 'Predio')
            ->setCellValue('B'.$nn, 'Nro. Solicitud')
            ->setCellValue('C'.$nn, 'Fecha creación')
            ->setCellValue('D'.$nn, 'Solicitud Fecha Inicio')
            ->setCellValue('E'.$nn, 'Solicitud Fecha Termino')
            ->setCellValue('F'.$nn, 'Programacion Fecha Inicio')
            ->setCellValue('G'.$nn, 'Programacion Fecha Termino')
            ->setCellValue('H'.$nn, 'Termino Fecha Inicio')
            ->setCellValue('I'.$nn, 'Termino Fecha Termino')
            ->setCellValue('J'.$nn, 'Solicitado Por')
            ->setCellValue('K'.$nn, 'Especie')
            ->setCellValue('L'.$nn, 'Variedad')
            ->setCellValue('M'.$nn, 'Cuartel')
            ->setCellValue('N'.$nn, 'Nro. Plantas')
            ->setCellValue('O'.$nn, 'Hectareas')
            ->setCellValue('P'.$nn, 'Año Plantacion')
            ->setCellValue('Q'.$nn, 'Estado Fenologico')
            ->setCellValue('R'.$nn, 'Estado Productivo')
            ->setCellValue('S'.$nn, 'Estado')
            ->setCellValue('T'.$nn, 'Dosificador')
            ->setCellValue('U'.$nn, 'Aplicador')
            ->setCellValue('V'.$nn, 'Equipo')
            ->setCellValue('W'.$nn, 'Capacidad Estanque')
            ->setCellValue('X'.$nn, 'Veloc. Promedio')
            ->setCellValue('Y'.$nn, 'lts. Aplicados')
            ->setCellValue('Z'.$nn, 'lts. por hectarias')
            ->setCellValue('AA'.$nn, 'Plantas aplicada')
            ->setCellValue('AB'.$nn, 'Caudal Izquierdo')
            ->setCellValue('AC'.$nn, 'Caudal Derecho')
            ->setCellValue('AD'.$nn, 'Estado Aplicación')
            ->setCellValue('AE'.$nn, 'Ingrediente Activo')
            ->setCellValue('AF'.$nn, 'Nombre Producto')
            ->setCellValue('AG'.$nn, 'Categoria Producto Quimico')
            ->setCellValue('AH'.$nn, 'Dosis Recomendada')
            ->setCellValue('AI'.$nn, 'Dosis Solicitada')
            ->setCellValue('AJ'.$nn, 'Objetivo Producto')
            ->setCellValue('AK'.$nn, 'Fin Carencia')
            ->setCellValue('AL'.$nn, 'Fin efecto Residual')
            ->setCellValue('AM'.$nn, 'Objetivo');
            
            /*->setCellValue('H'.$nn, 'Hileras')
            ->setCellValue('J'.$nn, 'Distancia Plant')
            ->setCellValue('K'.$nn, 'Distancia Hileras')
            ->setCellValue('AA'.$nn, 'Fecha de Cierre')
            ->setCellValue('AB'.$nn, 'Vel Tractor')
            ->setCellValue('AC'.$nn, 'Vel Viento')
            ->setCellValue('AD'.$nn, 'Temp Min')
            ->setCellValue('AE'.$nn, 'Temp Max')
            ->setCellValue('AF'.$nn, 'Codigo Tractor')
            ->setCellValue('AI'.$nn, 'Velocidad Min')
            ->setCellValue('AJ'.$nn, 'Velocidad Max')
            ->setCellValue('AL'.$nn, 'Distancia recorridas (mtrs.)')
            ->setCellValue('AO'.$nn, 'Unidad de medida')
            ->setCellValue('AS'.$nn, 'Efecto Retroactivo')
            ->setCellValue('AU'.$nn, 'Maquinadas')
            ->setCellValue('AW'.$nn, 'Mojamiento')
            ->setCellValue('AZ'.$nn, 'Telem Sensor 1 Min')
            ->setCellValue('BA'.$nn, 'Telem Sensor 1 Max')
            ->setCellValue('BC'.$nn, 'Telem Sensor 2 Min')
            ->setCellValue('BD'.$nn, 'Telem Sensor 2 Max')
            ->setCellValue('BH'.$nn, 'Temporada')
            ->setCellValue('BI'.$nn, 'Prioridad')*/

//variables
$nn=3;
foreach ($arrOTS as $ot) {
	//Litros aplicados
	$sdata1 = $ot['Telem_Diferencia'];
	//litros por hectareas
	if(isset($ot['CuartelHectareas'])&&$ot['CuartelHectareas']!=0){
		$sdata2 = ($ot['Telem_Diferencia']/$ot['CuartelHectareas']);
	}else{
		$sdata2 = 0;
	}
	//se verifica plantas faltantes
	if(isset($temp['Telem_GeoDistance'])&&$temp['Telem_GeoDistance']!=0){
		$sdata3 = ((($temp['Telem_GeoDistance']*1000))/$temp['CuartelDistanciaPlant']);
		if($sdata3<0){
			$sdata3 = 0;
		}
	}else{
		$sdata3 = 0;
	}
	//Maquinadas
	if(isset($ot['Telem_Capacidad'])&&$ot['Telem_Capacidad']!=0){
		$sdata4 = $ot['Telem_Diferencia']/$ot['Telem_Capacidad'];
	}else{
		$sdata4 = 'Capacidad con valor 0';
	}
	//Especie
	if(isset($ot['VariedadCat'])&&$ot['VariedadCat']!=''){
		$VariedadCat = $ot['VariedadCat'];
	}else{
		$VariedadCat = 'Todas las especies';
	}
	//Variedad
	if(isset($ot['VariedadNombre'])&&$ot['VariedadNombre']!=''){
		$VariedadNombre = $ot['VariedadNombre'];
	}else{
		$VariedadNombre = 'Todas las variedades';
	}

	/**************************************************************/
	$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A'.$nn, DeSanitizar($ot['NombrePredio']))
				->setCellValue('B'.$nn, DeSanitizar($ot['NSolicitud']))
				->setCellValue('C'.$nn, fecha_estandar($ot['f_creacion']))
				->setCellValue('D'.$nn, fecha_estandar($ot['f_programacion']).' '.$ot['horaProg'])
				->setCellValue('E'.$nn, fecha_estandar($ot['f_programacion_fin']).' '.$ot['horaProg_fin'])
				->setCellValue('F'.$nn, fecha_estandar($ot['f_ejecucion']).' '.$ot['horaEjecucion'])
				->setCellValue('G'.$nn, fecha_estandar($ot['f_ejecucion_fin']).' '.$ot['horaEjecucion_fin'])
				->setCellValue('H'.$nn, fecha_estandar($ot['f_termino']).' '.$ot['horaTermino'])
				->setCellValue('I'.$nn, fecha_estandar($ot['f_termino_fin']).' '.$ot['horaTermino_fin'])
				->setCellValue('J'.$nn, DeSanitizar($ot['NombreUsuario']))
				->setCellValue('K'.$nn, DeSanitizar($VariedadCat))
				->setCellValue('L'.$nn, DeSanitizar($VariedadNombre))
				->setCellValue('M'.$nn, DeSanitizar($ot['CuartelNombre']))
				->setCellValue('N'.$nn, DeSanitizar($ot['CuartelPlantas']))
				->setCellValue('O'.$nn, DeSanitizar($ot['CuartelHectareas']))
				->setCellValue('P'.$nn, DeSanitizar($ot['CuartelAnoPlantacion']))
				->setCellValue('Q'.$nn, DeSanitizar($ot['EstadoFenNombre']))
				->setCellValue('R'.$nn, DeSanitizar($ot['CuartelEstadoProd']))
				->setCellValue('S'.$nn, DeSanitizar($ot['Estado']))
				->setCellValue('T'.$nn, DeSanitizar($ot['DosificadorRut'].' - '.$ot['DosificadorNombre'].' '.$ot['DosificadorApellidoPat']))
				->setCellValue('U'.$nn, DeSanitizar($ot['ConductorRut'].' - '.$ot['ConductorNombre'].' '.$ot['ConductorApellidoPat']))
				->setCellValue('V'.$nn, DeSanitizar($ot['Telem_Identificador']))
				->setCellValue('W'.$nn, DeSanitizar($ot['Telem_Capacidad']))
				->setCellValue('X'.$nn, DeSanitizar($ot['Telem_GeoVelocidadProm']))
				->setCellValue('Y'.$nn, DeSanitizar($sdata1))
				->setCellValue('Z'.$nn, DeSanitizar($sdata2))
				->setCellValue('AA'.$nn, DeSanitizar($sdata3))
				->setCellValue('AB'.$nn, $ot['Telem_Sensor_1_Prom'])
				->setCellValue('AC'.$nn, $ot['Telem_Sensor_2_Prom'])
				->setCellValue('AD'.$nn, DeSanitizar($ot['Estado']))
				->setCellValue('AE'.$nn, DeSanitizar($ot['ProductoIngrediente']))
				->setCellValue('AF'.$nn, DeSanitizar($ot['ProductoNombre']))
				->setCellValue('AG'.$nn, DeSanitizar($ot['ProductoCategoria']))
				->setCellValue('AH'.$nn, DeSanitizar($ot['ProductoDosisRecomendada']))
				->setCellValue('AI'.$nn, DeSanitizar($ot['ProductoDosisAplicar']))
				->setCellValue('AJ'.$nn, DeSanitizar($ot['ProductoObjetivo']))
				->setCellValue('AK'.$nn, DeSanitizar($ot['ProductoCarenciaExportador']))
				->setCellValue('AL'.$nn, DeSanitizar($ot['ProductoEfectoResidual']))
				->setCellValue('AM'.$nn, DeSanitizar($ot['ProductoObjetivo']));
				
				
				/*
				 * ->setCellValue('H'.$nn, $ot['CuartelHileras'])
				->setCellValue('J'.$nn, $ot['CuartelDistanciaPlant'])
				->setCellValue('K'.$nn, $ot['CuartelDistanciaHileras'])
				->setCellValue('AA'.$nn, $ot['Cuartelf_cierre'])
				->setCellValue('AB'.$nn, $ot['CuartelVelTractor'])
				->setCellValue('AC'.$nn, $ot['CuartelVelViento'])
				->setCellValue('AD'.$nn, $ot['CuartelTempMin'])
				->setCellValue('AE'.$nn, $ot['CuartelTempMax'])
				->setCellValue('AF'.$nn, $ot['Vehiculo_Marca'])
				->setCellValue('AI'.$nn, $ot['Telem_GeoVelocidadMin'])
				->setCellValue('AJ'.$nn, $ot['Telem_GeoVelocidadMax'])
				->setCellValue('AL'.$nn, $ot['Telem_GeoDistance'])
				->setCellValue('AO'.$nn, $ot['ProductoUniMed'])
				->setCellValue('AS'.$nn, $ot['ProductoEfectoRetroactivo'])
				->setCellValue('AU'.$nn, $sdata4)
				->setCellValue('AW'.$nn, $ot['CuartelMojamiento'])
				->setCellValue('AZ'.$nn, $ot['Telem_Sensor_1_Min'])
				->setCellValue('BA'.$nn, $ot['Telem_Sensor_1_Max'])
				->setCellValue('BC'.$nn, $ot['Telem_Sensor_2_Min'])
				->setCellValue('BD'.$nn, $ot['Telem_Sensor_2_Max'])
				->setCellValue('BH'.$nn, $ot['TemporadaCodigo'].' '.$ot['TemporadaNombre'])
				->setCellValue('BI'.$nn, $ot['NombrePrioridad'])*/

	//Se suma 1
	$nn++;
}

// Rename worksheet
$spreadsheet->getActiveSheet()->setTitle('Exportacion');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$spreadsheet->setActiveSheetIndex(0);

/**************************************************************************/
//Nombre del archivo
$filename = 'Agro Checking - Exportar Datos';
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
