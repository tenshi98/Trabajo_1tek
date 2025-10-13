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
require_once '../../Legacy/1tek_public/funciones/Helpers.Functions.Propias.ardu.php';  //carga librerias de la plataforma

// obtengo puntero de conexion con la db
$dbConn = conectar();
//Se elimina la restriccion del sql 5.7
mysqli_query($dbConn, "SET SESSION sql_mode = ''");
/**********************************************************************************************************************************/
/*                                               FUNCION DEL CRON                                                                 */
/**********************************************************************************************************************************/
//elimina las microparadas
/**********************************************************************************************************************************/
/*                                       VARIABLES GLOBALES DE CONFIGURACION                                                      */
/**********************************************************************************************************************************/
//Tiempo Maximo de la consulta, 40 minutos por defecto
set_time_limit(2400);
//Memora RAM Maxima del servidor, 4GB por defecto
ini_set('memory_limit', '6096M');

//Variables
$SIS_columns1  = 'idTelemetria';
$SIS_columns2  = 'idTelemetria';
$SIS_columns3  = 'idTelemetria';
$SIS_columns4  = 'idTelemetria';
$SIS_columns5  = 'idTelemetria';
$SIS_columns6  = 'idTelemetria';
$SIS_columns7  = 'idTelemetria';
$SIS_columns8  = 'idTelemetria';
$SIS_columns9  = 'idTelemetria';
$SIS_columns10 = 'idTelemetria';
$SIS_columns11 = 'idTelemetria';
$SIS_columns12 = 'idTelemetria';
$SIS_columns13 = 'idTelemetria';
$SIS_columns14 = 'idTelemetria';
$SIS_columns15 = 'idTelemetria';

//Consulta
$SIS_query = 'idTelemetria';
$Var_Counter = 72;
for ($i = 1; $i <= $Var_Counter; $i++) {
	$SIS_query .= ',SensoresAccionAlerta_'.$i;
    $SIS_query .= ',SensoresAccionC_'.$i;
    $SIS_query .= ',SensoresAccionMedC_'.$i;
	$SIS_query .= ',SensoresAccionMedT_'.$i;
    $SIS_query .= ',SensoresAccionT_'.$i;
    $SIS_query .= ',SensoresActivo_'.$i;
    $SIS_query .= ',SensoresGrupo_'.$i;
    $SIS_query .= ',SensoresMedActual_'.$i;
    $SIS_query .= ',SensoresNombre_'.$i;
    $SIS_query .= ',SensoresRevision_'.$i;
	$SIS_query .= ',SensoresRevisionGrupo_'.$i;
    $SIS_query .= ',SensoresTipo_'.$i;
    $SIS_query .= ',SensoresUniMed_'.$i;
    $SIS_query .= ',SensoresUso_'.$i;
    $SIS_query .= ',SensoresFechaUso_'.$i;
    //Variables
    $SIS_columns1  .= ',SensoresAccionAlerta_'.$i;
    $SIS_columns2  .= ',SensoresAccionC_'.$i;
    $SIS_columns3  .= ',SensoresAccionMedC_'.$i;
	$SIS_columns4  .= ',SensoresAccionMedT_'.$i;
    $SIS_columns5  .= ',SensoresAccionT_'.$i;
    $SIS_columns6  .= ',SensoresActivo_'.$i;
    $SIS_columns7  .= ',SensoresGrupo_'.$i;
    $SIS_columns8  .= ',SensoresMedActual_'.$i;
    $SIS_columns9  .= ',SensoresNombre_'.$i;
    $SIS_columns10 .= ',SensoresRevision_'.$i;
	$SIS_columns11 .= ',SensoresRevisionGrupo_'.$i;
    $SIS_columns12 .= ',SensoresTipo_'.$i;
    $SIS_columns13 .= ',SensoresUniMed_'.$i;
    $SIS_columns14 .= ',SensoresUso_'.$i;
    $SIS_columns15 .= ',SensoresFechaUso_'.$i;
}
//Se realiza consulta por los ultimos datos guardados
$SIS_join  = '';
$SIS_where = 'idTelemetria!=0';
$SIS_order = 'idTelemetria ASC';
$arrGruas = array();
$arrGruas = db_select_array (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'arrGruas');

foreach ($arrGruas as $carga) {
    //variable
    $SIS_data1  = "'".$carga['idTelemetria']."'";
    $SIS_data2  = "'".$carga['idTelemetria']."'";
    $SIS_data3  = "'".$carga['idTelemetria']."'";
    $SIS_data4  = "'".$carga['idTelemetria']."'";
    $SIS_data5  = "'".$carga['idTelemetria']."'";
    $SIS_data6  = "'".$carga['idTelemetria']."'";
    $SIS_data7  = "'".$carga['idTelemetria']."'";
    $SIS_data8  = "'".$carga['idTelemetria']."'";
    $SIS_data9  = "'".$carga['idTelemetria']."'";
    $SIS_data10 = "'".$carga['idTelemetria']."'";
    $SIS_data11 = "'".$carga['idTelemetria']."'";
    $SIS_data12 = "'".$carga['idTelemetria']."'";
    $SIS_data13 = "'".$carga['idTelemetria']."'";
    $SIS_data14 = "'".$carga['idTelemetria']."'";
    $SIS_data15 = "'".$carga['idTelemetria']."'";


    for ($i = 1; $i <= $Var_Counter; $i++) {
        $SIS_data1 .= ",'".$carga['SensoresAccionAlerta_'.$i]."'";
        $SIS_data2 .= ",'".$carga['SensoresAccionC_'.$i]."'";
        $SIS_data3 .= ",'".$carga['SensoresAccionMedC_'.$i]."'";
        $SIS_data4 .= ",'".$carga['SensoresAccionMedT_'.$i]."'";
        $SIS_data5 .= ",'".$carga['SensoresAccionT_'.$i]."'";
        $SIS_data6 .= ",'".$carga['SensoresActivo_'.$i]."'";
        $SIS_data7 .= ",'".$carga['SensoresGrupo_'.$i]."'";
        $SIS_data8 .= ",'".$carga['SensoresMedActual_'.$i]."'";
        $SIS_data9 .= ",'".$carga['SensoresNombre_'.$i]."'";
        $SIS_data10.= ",'".$carga['SensoresRevision_'.$i]."'";
        $SIS_data11.= ",'".$carga['SensoresRevisionGrupo_'.$i]."'";
        $SIS_data12.= ",'".$carga['SensoresTipo_'.$i]."'";
        $SIS_data13.= ",'".$carga['SensoresUniMed_'.$i]."'";
        $SIS_data14.= ",'".$carga['SensoresUso_'.$i]."'";
        $SIS_data15.= ",'".$carga['SensoresFechaUso_'.$i]."'";
    }

    $ultimo_id1  = db_insert_data (false, $SIS_columns1,  $SIS_data1,  'telemetria_listado_sensores_accion_alerta', $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'arrGruas');
    $ultimo_id2  = db_insert_data (false, $SIS_columns2,  $SIS_data2,  'telemetria_listado_sensores_accion_c', $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'arrGruas');
    $ultimo_id3  = db_insert_data (false, $SIS_columns3,  $SIS_data3,  'telemetria_listado_sensores_accion_med_c', $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'arrGruas');
    $ultimo_id4  = db_insert_data (false, $SIS_columns4,  $SIS_data4,  'telemetria_listado_sensores_accion_med_t', $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'arrGruas');
    $ultimo_id5  = db_insert_data (false, $SIS_columns5,  $SIS_data5,  'telemetria_listado_sensores_accion_t', $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'arrGruas');
    $ultimo_id6  = db_insert_data (false, $SIS_columns6,  $SIS_data6,  'telemetria_listado_sensores_activo', $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'arrGruas');
    $ultimo_id7  = db_insert_data (false, $SIS_columns7,  $SIS_data7,  'telemetria_listado_sensores_grupo', $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'arrGruas');
    $ultimo_id8  = db_insert_data (false, $SIS_columns8,  $SIS_data8,  'telemetria_listado_sensores_med_actual', $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'arrGruas');
    $ultimo_id9  = db_insert_data (false, $SIS_columns9,  $SIS_data9,  'telemetria_listado_sensores_nombre', $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'arrGruas');
    $ultimo_id10 = db_insert_data (false, $SIS_columns10, $SIS_data10, 'telemetria_listado_sensores_revision', $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'arrGruas');
    $ultimo_id11 = db_insert_data (false, $SIS_columns11, $SIS_data11, 'telemetria_listado_sensores_revision_grupo', $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'arrGruas');
    $ultimo_id12 = db_insert_data (false, $SIS_columns12, $SIS_data12, 'telemetria_listado_sensores_tipo', $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'arrGruas');
    $ultimo_id13 = db_insert_data (false, $SIS_columns13, $SIS_data13, 'telemetria_listado_sensores_unimed', $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'arrGruas');
    $ultimo_id14 = db_insert_data (false, $SIS_columns14, $SIS_data14, 'telemetria_listado_sensores_uso', $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'arrGruas');
    $ultimo_id15 = db_insert_data (false, $SIS_columns15, $SIS_data15, 'telemetria_listado_sensores_uso_fecha', $dbConn, 'Cron', basename($_SERVER["REQUEST_URI"], ".php"), 'arrGruas');


}

?>