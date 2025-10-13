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
/*                                                      Consulta                                                                  */
/**********************************************************************************************************************************/
//Variable
$idTipoUsuario  = $_GET['idTipoUsuario'];
$idSistema      = $_GET['idSistema'];
$idUsuario      = $_GET['idUsuario'];
$idZona         = $_SESSION['usuario']['zona']['idZona'];
if(isset($_SESSION['usuario']['zona']['id_Geo'])&&$_SESSION['usuario']['zona']['id_Geo']!=''){
	$id_Geo = $_SESSION['usuario']['zona']['id_Geo'];
}else{
	$id_Geo = 1;//seguimiento activo
}
//filtro
$SIS_where = "telemetria_listado.idEstado = 1 ";//solo equipos activos
//solo los equipos que tengan el seguimiento activado
$SIS_where .= " AND telemetria_listado.id_Geo = ".$id_Geo;
//Filtro el sistema al cual pertenece
if(isset($idSistema)&&$idSistema!=''&&$idSistema!=0){
	$SIS_where .= " AND telemetria_listado.idSistema = ".$idSistema;
}
//Verifico el tipo de usuario que esta ingresando y el id
$SIS_join = "";
if(isset($idTipoUsuario)&&$idTipoUsuario!=1&&isset($idUsuario)&&$idUsuario!=0){
	$SIS_join   = " INNER JOIN usuarios_equipos_telemetria ON usuarios_equipos_telemetria.idTelemetria = telemetria_listado.idTelemetria ";
	$SIS_where .= " AND usuarios_equipos_telemetria.idUsuario = ".$idUsuario;
}
//filtro la zona
if(isset($idZona)&&$idZona!=''&&$idZona!=9999){
	$SIS_where .= " AND telemetria_listado.idZona = ".$idZona;
}
//Solo para plataforma 1Tek
$SIS_where .= " AND telemetria_listado.idTab=9";//Power-Energy

//numero sensores equipo
$N_Maximo_Sensores = 72;
$subquery = '';
for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
	$subquery .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$i;
	$subquery .= ',telemetria_listado_sensores_med_actual.SensoresMedActual_'.$i;
	$subquery .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i;
	$subquery .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$i;
}

/*******************************************************/
// consulto los datos
$SIS_query = '
telemetria_listado.Nombre,
telemetria_listado.LastUpdateFecha,
telemetria_listado.LastUpdateHora,
telemetria_listado.GeoLatitud,
telemetria_listado.GeoLongitud,
telemetria_listado.cantSensores,
telemetria_listado.id_Sensores'.$subquery;
$SIS_join .= '
LEFT JOIN `telemetria_listado_sensores_nombre`      ON telemetria_listado_sensores_nombre.idTelemetria      = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_med_actual`  ON telemetria_listado_sensores_med_actual.idTelemetria  = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_unimed`      ON telemetria_listado_sensores_unimed.idTelemetria      = telemetria_listado.idTelemetria
LEFT JOIN `telemetria_listado_sensores_activo`      ON telemetria_listado_sensores_activo.idTelemetria      = telemetria_listado.idTelemetria';
$SIS_order = 'telemetria_listado.Nombre ASC';
$arrEquipo = array();
$arrEquipo = db_select_array (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrEquipo');

/*************************************************************/
//Se traen todas las unidades de medida
$arrUnimed = array();
$arrUnimed = db_select_array (false, 'idUniMed,Nombre', 'telemetria_listado_unidad_medida', '', '', 'idUniMed ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrUnimed');

//Ordeno las unidades de medida
$arrFinalUnimed = array();
foreach ($arrUnimed as $data) {
	$arrFinalUnimed[$data['idUniMed']] = $data['Nombre'];
}

?>

<script>
	var HoraRefresco = '<?php echo hora_actual(); ?>';

	<?php
	$GPS = 'var new_locations = [ ';
			foreach ( $arrEquipo as $data ) {
				//burbuja
				$explanation  = '<div class="iw-subTitle">Equipo: '.$data['Nombre'].'</div>';
				$explanation .= 'Actualizado: '.fecha_estandar($data['LastUpdateFecha']).' - '.$data['LastUpdateHora'].'</p>';
				//verifico si tiene sensores configurados
				if(isset($data['id_Sensores'])&&$data['id_Sensores']==1){
					$explanation .= '<div class="iw-subTitle">Sensores: </div><p>';
					for ($i = 1; $i <= $data['cantSensores']; $i++) {
						//verifico que sensor este activo
						if(isset($data['SensoresActivo_'.$i])&&$data['SensoresActivo_'.$i]==1){
							//Unidad medida
							if(isset($arrFinalUnimed[$data['SensoresUniMed_'.$i]])){
								$unimed = ' '.$arrFinalUnimed[$data['SensoresUniMed_'.$i]];
							}else{
								$unimed = '';
							}
							//cadena
							if(isset($data['SensoresMedActual_'.$i])&&$data['SensoresMedActual_'.$i]<99900){$xdata=Cantidades($data['SensoresMedActual_'.$i], 2).$unimed;}else{$xdata='Sin Datos';}
							$explanation .= $data['SensoresNombre_'.$i].' : '.$xdata.'<br/>';
						}
					}
					$explanation .= '</p>';
				}
				//se arma dato
				$GPS .= "[";
					$GPS .= $data['GeoLatitud'];
					$GPS .= ", ".$data['GeoLongitud'];
					$GPS .= ", '".$explanation."'";
				$GPS .= "], ";
			}
		$GPS .= '];';

		echo $GPS;
	?>
</script>

