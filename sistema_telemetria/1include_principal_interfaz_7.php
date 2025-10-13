<?php
/*****************************************************************************************************************/
/*                                              Conexion Externa                                                 */
/*****************************************************************************************************************/
//Nueva conexion a otra base de datos
//verifica la capa de desarrollo
$whitelist = array( 'localhost', '127.0.0.1', '::1' );
////////////////////////////////////////////////////////////////////////////////
//si estoy en ambiente de desarrollo
if( in_array( $_SERVER['REMOTE_ADDR'], $whitelist) ){
	$CON_Base      = 'power_engine_main';
////////////////////////////////////////////////////////////////////////////////
//si estoy en ambiente de produccion
}else{
	$CON_Base      = 'crosstec_pe_clientes';
}

//Funcion para conectarse
function conectarDB ($servidor, $usuario, $password, $base_datos) {
	$db_con = mysqli_connect($servidor, $usuario, $password, $base_datos);
	$db_con->set_charset("utf8");
	return $db_con;
}

//verifico si existen datos
if($CON_Base!=''){
	//ejecuto conexion
	$dbConn_2 = conectarDB(DB_SERVER, DB_USER, DB_PASS, $CON_Base);
}
/*****************************************************************************************************************/
/*                                                  Consultas                                                    */
/*****************************************************************************************************************/
/************************************************************************************/
/*                                     Tab 1                                        */
/************************************************************************************/
//Datos
$SIS_where_1 = " WHERE idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
$subquery    = '';
$subquery   .= ",(SELECT COUNT(idAgenda) FROM principal_agenda_telefonica      ".$SIS_where_1." AND idUsuario = '".$_SESSION['usuario']['basic_data']['idUsuario']."' OR idUsuario=9999 LIMIT 1) AS CuentaContactos";
$subquery   .= ",(SELECT COUNT(idSoftware) FROM soporte_software_listado LIMIT 1) AS CuentaProgramas";
$subquery   .= ",(SELECT COUNT(idCalendario) FROM principal_calendario_listado ".$SIS_where_1." AND Mes=".mes_actual()." AND Ano=".ano_actual()." AND idUsuario = 9999 LIMIT 1) AS CEvComunes";
$subquery   .= ",(SELECT COUNT(idCalendario) FROM principal_calendario_listado ".$SIS_where_1." AND Mes=".mes_actual()." AND Ano=".ano_actual()." AND idUsuario = '".$_SESSION['usuario']['basic_data']['idUsuario']."' LIMIT 1) AS CEvPropios";

/************************************************************************************/
//consultas anidadas, se utiliza las variables anteriores para consultar cada permiso
$SIS_query = 'core_ubicacion_ciudad.Nombre AS Ciudad,
core_ubicacion_comunas.Nombre AS Comuna,
core_ubicacion_comunas.Wheater AS Wheater'.$subquery;
$SIS_join  = '
LEFT JOIN core_ubicacion_ciudad    ON core_ubicacion_ciudad.idCiudad    = core_sistemas.idCiudad
LEFT JOIN core_ubicacion_comunas   ON core_ubicacion_comunas.idComuna   = core_sistemas.idComuna';
$SIS_where = 'core_sistemas.idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
$subconsulta = db_select_data (false, $SIS_query, 'core_sistemas',$SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'subconsulta');

$CContactos = 0;
$CProgramas = 0;
$CEvComunes = 0;
$CEvPropios = 0;
if(isset($subconsulta['CuentaContactos'])&&$subconsulta['CuentaContactos']!=''){$CContactos = $subconsulta['CuentaContactos'];}
if(isset($subconsulta['CuentaProgramas'])&&$subconsulta['CuentaProgramas']!=''){$CProgramas = $subconsulta['CuentaProgramas'];}
if(isset($subconsulta['CEvComunes'])&&$subconsulta['CEvComunes']!=''){$CEvComunes = $subconsulta['CEvComunes'];}
if(isset($subconsulta['CEvPropios'])&&$subconsulta['CEvPropios']!=''){$CEvPropios = $subconsulta['CEvPropios'];}

/************************************************************************************/
/*                                     Tab 2                                        */
/************************************************************************************/
//Se consulta
$SIS_query = '
telemetria_listado.idTelemetria,
telemetria_listado.idSistema,
telemetria_listado.Nombre,
telemetria_listado.LastUpdateFecha,
telemetria_listado.LastUpdateHora,
telemetria_listado.idTab,
telemetria_listado.id_Geo,

telemetria_listado.TiempoFueraLinea,
telemetria_listado.GeoErrores,
telemetria_listado.GeoLatitud,
telemetria_listado.GeoLongitud,
telemetria_listado.NDetenciones,
telemetria_listado.NErrores,

core_sistemas.Nombre AS Sistema';
$SIS_where = 'telemetria_listado.idEstado = 1 ';  //solo equipos activos
$SIS_where.= ' AND core_sistemas.idEstado = 1 ';  //solo sistemas activos

$SIS_join  = 'LEFT JOIN `core_sistemas`  ON core_sistemas.idSistema = telemetria_listado.idSistema';
$SIS_order = 'core_sistemas.Nombre ASC, telemetria_listado.Nombre ASC';
$arrEquipo = array();
$arrEquipo = db_select_array (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn_2, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrEquipo');

/************************************************************************************/
/*                                     Tab 3                                        */
/************************************************************************************/
//Se consulta el calendario
//Se definen las variables
if(isset($_GET['Mes'])){   $Mes = $_GET['Mes'];   } else { $Mes  = mes_actual();}
if(isset($_GET['Ano'])){   $Ano = $_GET['Ano'];   } else { $Ano  = ano_actual();}
$diaActual = dia_actual();

//calculo de los dias del mes, cuando inicia y cuando termina
$diaSemana      = date("w",mktime(0,0,0,$Mes,1,$Ano))+7;
$ultimoDiaMes   = date("d",(mktime(0,0,0,$Mes+1,1,$Ano)-1));

//Traigo los eventos guardados en la base de datos
$SIS_query = 'idCalendario, Titulo, Dia, idUsuario';
$SIS_join  = '';
$SIS_where = '(idUsuario='.$_SESSION['usuario']['basic_data']['idUsuario'].' OR idUsuario=9999) AND Ano='.$Ano.' AND Mes='.$Mes.' AND idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
$SIS_order = 'Fecha ASC';
$arrEventos = array();
$arrEventos = db_select_array (false, $SIS_query, 'principal_calendario_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrEventos');

/************************************************************************************/
/*                                     Tab 4                                        */
/************************************************************************************/
// Se trae un listado con todos los elementos
$SIS_query = '
idEstado,
Nombre AS Estado,
idEstado AS ID,
(SELECT COUNT(idTareas) FROM tareas_pendientes_listado WHERE idSistema = '.$_SESSION['usuario']['basic_data']['idSistema'].' AND idEstado = ID) AS Cuenta';
$SIS_join  = '';
$SIS_where = 'idEstado!=0';
$SIS_order = 'idEstado ASC';
$arrTareas = array();
$arrTareas = db_select_array (false, $SIS_query, 'core_tareas_pendientes_estados', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTareas');

/**********************************************************/
// Se trae un listado con todos los elementos
$SIS_query = '
tareas_pendientes_listado.idTareas,
tareas_pendientes_listado.idTareas AS ID,
tareas_pendientes_listado.f_creacion,
tareas_pendientes_listado.Nombre,
tareas_pendientes_listado.idPrioridad,
tareas_pendientes_listado.idEstado,
core_tareas_pendientes_tipos.Nombre AS Tipo,
tareas_pendientes_listado_responsable.idUsuario,
usuarios_listado.Nombre AS UsuarioNombre,
usuarios_listado.Nombre AS UsuarioIMG,
(SELECT COUNT(idTrabajoTareas) FROM tareas_pendientes_listado_tareas WHERE idTareas = ID AND idEstadoTarea=1) AS CuentaPendiente,
(SELECT COUNT(idTrabajoTareas) FROM tareas_pendientes_listado_tareas WHERE idTareas = ID AND (idEstadoTarea=2 OR idEstadoTarea=3)) AS CuentaTerminada';
$SIS_join  = '
LEFT JOIN `core_tareas_pendientes_tipos`            ON core_tareas_pendientes_tipos.idTipo             = tareas_pendientes_listado.idTipo
LEFT JOIN `tareas_pendientes_listado_responsable`   ON tareas_pendientes_listado_responsable.idTareas  = tareas_pendientes_listado.idTareas
LEFT JOIN `usuarios_listado`                        ON usuarios_listado.idUsuario                      = tareas_pendientes_listado_responsable.idUsuario';
$SIS_where = 'tareas_pendientes_listado.idTareas!=0';
$SIS_where.= ' AND tareas_pendientes_listado.idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
$SIS_where.= ' AND (tareas_pendientes_listado.idEstado=1 OR tareas_pendientes_listado.idEstado=2)';
$SIS_order = 'tareas_pendientes_listado.idEstado ASC, tareas_pendientes_listado.idPrioridad ASC, tareas_pendientes_listado.idTareas ASC';
$arrTareasPend = array();
$arrTareasPend = db_select_array (false, $SIS_query, 'tareas_pendientes_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTareas');

$arrTareasTemp = array();
$arrRespTemp   = array();
//filtro
filtrar($arrTareasPend, 'idTareas');
//recorro
foreach($arrTareasPend as $idTareas=>$tareas){
	//Datos principales
	$arrTareasTemp[$tareas[0]['idEstado']][$tareas[0]['idPrioridad']][$idTareas]['idTareas']   = $idTareas;
	$arrTareasTemp[$tareas[0]['idEstado']][$tareas[0]['idPrioridad']][$idTareas]['f_creacion'] = $tareas[0]['f_creacion'];
	$arrTareasTemp[$tareas[0]['idEstado']][$tareas[0]['idPrioridad']][$idTareas]['Nombre']     = $tareas[0]['Nombre'];
	$arrTareasTemp[$tareas[0]['idEstado']][$tareas[0]['idPrioridad']][$idTareas]['Tipo']       = $tareas[0]['Tipo'];
	$arrTareasTemp[$tareas[0]['idEstado']][$tareas[0]['idPrioridad']][$idTareas]['Pendiente']  = $tareas[0]['CuentaPendiente'];
	$arrTareasTemp[$tareas[0]['idEstado']][$tareas[0]['idPrioridad']][$idTareas]['Terminada']  = $tareas[0]['CuentaTerminada'];
	//Responsables
	foreach ($tareas as $tarea) {
		$arrRespTemp[$idTareas][$tarea['idUsuario']]['UsuarioID']     = $tarea['idUsuario'];
		$arrRespTemp[$idTareas][$tarea['idUsuario']]['UsuarioNombre'] = $tarea['UsuarioNombre'];
		$arrRespTemp[$idTareas][$tarea['idUsuario']]['UsuarioIMG']    = $tarea['UsuarioIMG'];
	}
}


/*********************************************************/
//Variables
$Color[1] = 'color-gray';//Pendiente
$Color[2] = 'color-blue';//En Ejecucion
$Color[3] = 'color-green';//Finalizado
$Color[4] = 'color-yellow'; //Vencido
$Color[5] = 'color-red';//Cancelado

$Icon[1] = 'fa fa-commenting-o';//Pendiente
$Icon[2] = 'fa fa-commenting-o';//En Ejecucion
$Icon[3] = 'fa fa-commenting-o';//Finalizado
$Icon[4] = 'fa fa-commenting-o';//Vencido
$Icon[5] = 'fa fa-commenting-o';//Cancelado

$Prioridad[1]['Nombre'] = 'Baja';     //Baja
$Prioridad[2]['Nombre'] = 'Media';    //Media
$Prioridad[3]['Nombre'] = 'Alta';     //Alta
$Prioridad[4]['Nombre'] = 'Muy Alta'; //Muy Alta

$Prioridad[1]['Color'] = 'bs-callout-default';//Baja
$Prioridad[2]['Color'] = 'bs-callout-success';//Media
$Prioridad[3]['Color'] = 'bs-callout-primary';//Alta
$Prioridad[4]['Color'] = 'bs-callout-danger';//Muy Alta

$Prioridad[1]['Label'] = 'label label-default';//Baja
$Prioridad[2]['Label'] = 'label label-success';//Media
$Prioridad[3]['Label'] = 'label label-primary';//Alta
$Prioridad[4]['Label'] = 'label label-danger';//Muy Alta

$Estado[1]['Nombre'] = 'Pendiente';//Pendiente
$Estado[2]['Nombre'] = 'En Ejecucion';//En Ejecucion

/*********************************************************/
//variable de numero de permiso
$x_nperm = 0;

//Verifico permisos de acceso
$x_nperm++; $trans[$x_nperm] = "tareas_pendientes_listado.php";  //53 - Ejecucion de tickets

//Genero los permisos
for ($i = 1; $i <= $x_nperm; $i++) {
	//Seteo la variable a 0
	$prm_x[$i]['Val']  = 0;
	$prm_x[$i]['Link'] = '';
	//recorro los permisos
	if(isset($_SESSION['usuario']['menu'])){
		foreach($_SESSION['usuario']['menu'] as $menu=>$productos) {
			foreach($productos as $producto) {
				//elimino los datos extras
				$str = str_replace("?pagina=1", "", $producto['TransaccionURL']);
				//le asigno el valor 1 en caso de que exista
				if($trans[$i]==$str){
					$prm_x[$i]['Val']  = 1;
					$prm_x[$i]['Link'] = $producto['TransaccionURL'];
				}
			}
		}
	}
}



?>

<div class="row">

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="cover profile">
			<?php include '1include_principal_interfaz_7_portada.php'; ?>
		</div>
		<div class="box profile_content" style="margin-top:0px;">
			<header>
		<ul class="nav nav-tabs pull-left">
			<li class="active"><a href="#Menu_tab_1" data-toggle="tab"><i class="fa fa-fw fa-bars" aria-hidden="true"></i> Resumen</a></li>
			<li class=""><a href="#Menu_tab_2" data-toggle="tab"><i class="fa fa-fw fa-bars" aria-hidden="true"></i> Operacional</a></li>
			<li class=""><a href="#Menu_tab_3" data-toggle="tab"><i class="fa fa-fw fa-bars" aria-hidden="true"></i> Calendario</a></li>
			<li class=""><a href="#Menu_tab_4" data-toggle="tab"><i class="fa fa-fw fa-bars" aria-hidden="true"></i> Tareas</a></li>

		</ul>

	</header>

			<div class="tab-content">

				<?php
				//contenido en tabs
				include '1include_principal_interfaz_7_tab_1.php';
				include '1include_principal_interfaz_7_tab_2.php';
				include '1include_principal_interfaz_7_tab_3.php';
				include '1include_principal_interfaz_7_tab_4.php';

				?>

			</div>
		</div>
	</div>

</div>
