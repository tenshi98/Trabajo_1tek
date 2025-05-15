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
require_once 'core/Load.Utils.Web.php';
/**********************************************************************************************************************************/
/*                                          Modulo de identificacion del documento                                                */
/**********************************************************************************************************************************/
//Cargamos la ubicacion original
$original = "telemetria_listado.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['Identificador']) && $_GET['Identificador']!=''){  $location .= "&Identificador=".$_GET['Identificador'];  $search .= "&Identificador=".$_GET['Identificador'];}
if(isset($_GET['Nombre']) && $_GET['Nombre']!=''){                $location .= "&Nombre=".$_GET['Nombre'];                $search .= "&Nombre=".$_GET['Nombre'];}
if(isset($_GET['NumSerie']) && $_GET['NumSerie']!=''){            $location .= "&NumSerie=".$_GET['NumSerie'];            $search .= "&NumSerie=".$_GET['NumSerie'];}
if(isset($_GET['idEstado']) && $_GET['idEstado']!=''){            $location .= "&idEstado=".$_GET['idEstado'];            $search .= "&idEstado=".$_GET['idEstado'];}
if(isset($_GET['id_Geo']) && $_GET['id_Geo']!=''){                $location .= "&id_Geo=".$_GET['id_Geo'];                $search .= "&id_Geo=".$_GET['id_Geo'];}
if(isset($_GET['idTab']) && $_GET['idTab']!=''){                  $location .= "&idTab=".$_GET['idTab'];                  $search .= "&idTab=".$_GET['idTab'];}
/********************************************************************/
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para crear
if (!empty($_POST['submit'])){
	//Llamamos al formulario
	$form_trabajo= 'insert';
	require_once 'A1XRXS_sys/xrxs_form/z_telemetria_listado.php';
}
//se borra un dato
if (!empty($_GET['del'])){
	//Llamamos al formulario
	$form_trabajo= 'del';
	require_once 'A1XRXS_sys/xrxs_form/z_telemetria_listado.php';
}
//se clona la maquina
if (!empty($_POST['clone_Equipo'])){
	//Llamamos al formulario
	$form_trabajo= 'clone_Equipo';
	require_once 'A1XRXS_sys/xrxs_form/z_telemetria_listado.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Equipo Creado correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Equipo Modificado correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Equipo Borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['clone_idTelemetria'])){ ?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Clonar Equipo <?php echo $_GET['nombre_equipo']; ?></h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					//if(isset($Identificador)){   $x1  = $Identificador;    }else{$x1  = '';}
					if(isset($Nombre)){          $x2  = $Nombre;           }else{$x2  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_tittle(3, 'Datos Básicos');
					//$Form_Inputs->form_input_icon('Identificador', 'Identificador', $x1, 2,'fa fa-flag');
					$Form_Inputs->form_input_text('Nombre del Equipo', 'Nombre', $x2, 2);

					$Form_Inputs->form_input_hidden('idEstado', 2, 2);
					$Form_Inputs->form_input_hidden('idTelemetria', $_GET['clone_idTelemetria'], 2);
					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c5; Clonar" name="clone_Equipo">
						<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['id'])){
	//valido los permisos
	validaPermisoUser($rowlevel['level'], 2, $dbConn);
	/********************************************/
	//se consulta
	$SIS_query = '
	telemetria_listado.Identificador,
	telemetria_listado.Nombre,
	telemetria_listado.NumSerie,
	telemetria_listado.IP_Client,
	telemetria_listado.Sim_Num_Tel,
	telemetria_listado.Sim_Num_Serie,
	telemetria_listado.Sim_modelo,
	telemetria_listado.Sim_marca,
	telemetria_listado.Sim_Compania,
	telemetria_listado.IdentificadorEmpresa,
	telemetria_listado.TiempoFueraLinea,
	telemetria_listado.TiempoDetencion,
	telemetria_listado.Capacidad,
	telemetria_listado.Marca,
	telemetria_listado.Modelo,
	telemetria_listado.Patente,
	telemetria_listado.Num_serie,
	telemetria_listado.AnoFab,
	telemetria_listado.CapacidadPersonas,
	telemetria_listado.CapacidadKilos,
	telemetria_listado.MCubicos,
	telemetria_listado.CrossCMinHorno,
	opc2.Nombre AS Geo,
	opc3.Nombre AS Sensores,
	opc5.Nombre AS Predio,
	telemetria_listado.cantSensores,
	telemetria_listado.Direccion_img,
	core_sistemas.Nombre AS sistema,
	telemetria_listado.id_Geo,
	telemetria_listado.id_Sensores,
	telemetria_listado_dispositivos.Nombre AS Dispositivo,

	telemetria_listado.Jornada_inicio,
	telemetria_listado.Jornada_termino,
	telemetria_listado.Colacion_inicio,
	telemetria_listado.Colacion_termino,
	telemetria_listado.Microparada,

	core_estados.Nombre AS Estado,
	telemetria_listado_shield.Nombre AS Shield,
	telemetria_listado.LimiteVelocidad,
	core_ubicacion_ciudad.Nombre AS Ciudad,
	core_ubicacion_comunas.Nombre AS Comuna,
	telemetria_listado.Direccion,
	telemetria_zonas.Nombre AS ZonaSinGPS,
	core_telemetria_tabs.Nombre AS Tab,
	opc7.Nombre AS Backup,
	telemetria_listado.NregBackup,
	opc8.Nombre AS Generador,
	generador.Nombre AS GeneradorNombre,
	telemetria_listado.FechaInsGen AS GeneradorFecha,
	opc9.Nombre AS AlertaTemprana,
	opc10.Nombre AS UsoFTP,
	telemetria_listado.idUsoFTP,
	telemetria_listado.FTP_Carpeta,
	core_telemetria_ubicaciones.Nombre AS Ubicacion,

	telemetria_listado.CrossCrane_tiempo_revision AS TiempoRevision,
	grupo_1.Nombre AS Grupo_amperaje,
	grupo_2.Nombre AS Grupo_elevacion,
	grupo_3.Nombre AS Grupo_giro,
	grupo_4.Nombre AS Grupo_carro,
	grupo_5.Nombre AS Grupo_voltaje,
	grupo_6.Nombre AS Grupo_motor_subida,
	grupo_7.Nombre AS Grupo_motor_bajada,
	grupo_8.Nombre AS Grupo_Despliegue,
	grupo_9.Nombre AS Grupo_Vmonofasico,
	grupo_10.Nombre AS Grupo_VTrifasico,
	grupo_11.Nombre AS Grupo_Potencia,
	grupo_12.Nombre AS Grupo_ConsumoMesHabil,
	grupo_13.Nombre AS Grupo_ConsumoMesCurso,
	grupo_14.Nombre AS Grupo_Estanque';
	$SIS_join  = '
	LEFT JOIN `core_sistemas`                        ON core_sistemas.idSistema                            = telemetria_listado.idSistema
	LEFT JOIN `core_sistemas_opciones`        opc2   ON opc2.idOpciones                                    = telemetria_listado.id_Geo
	LEFT JOIN `core_sistemas_opciones`        opc3   ON opc3.idOpciones                                    = telemetria_listado.id_Sensores
	LEFT JOIN `core_sistemas_opciones`        opc5   ON opc5.idOpciones                                    = telemetria_listado.idUsoPredio
	LEFT JOIN `telemetria_listado_dispositivos`      ON telemetria_listado_dispositivos.idDispositivo      = telemetria_listado.idDispositivo
	LEFT JOIN `core_estados`                         ON core_estados.idEstado                              = telemetria_listado.idEstado
	LEFT JOIN `telemetria_listado_shield`            ON telemetria_listado_shield.idShield                 = telemetria_listado.idShield
	LEFT JOIN `core_ubicacion_ciudad`                ON core_ubicacion_ciudad.idCiudad                     = telemetria_listado.idCiudad
	LEFT JOIN `core_ubicacion_comunas`               ON core_ubicacion_comunas.idComuna                    = telemetria_listado.idComuna
	LEFT JOIN `telemetria_zonas`                     ON telemetria_zonas.idZona                            = telemetria_listado.idZona
	LEFT JOIN `core_telemetria_tabs`                 ON core_telemetria_tabs.idTab                         = telemetria_listado.idTab
	LEFT JOIN `core_sistemas_opciones`        opc7   ON opc7.idOpciones                                    = telemetria_listado.idBackup
	LEFT JOIN `core_sistemas_opciones`        opc8   ON opc8.idOpciones                                    = telemetria_listado.idGenerador
	LEFT JOIN `telemetria_listado`       generador   ON generador.idTelemetria                             = telemetria_listado.idTelGenerador
	LEFT JOIN `core_sistemas_opciones`        opc9   ON opc9.idOpciones                                    = telemetria_listado.idAlertaTemprana
	LEFT JOIN `core_sistemas_opciones`       opc10   ON opc10.idOpciones                                   = telemetria_listado.idUsoFTP
	LEFT JOIN `telemetria_listado_grupos`  grupo_1   ON grupo_1.idGrupo                                    = telemetria_listado.CrossCrane_grupo_amperaje
	LEFT JOIN `telemetria_listado_grupos`  grupo_2   ON grupo_2.idGrupo                                    = telemetria_listado.CrossCrane_grupo_elevacion
	LEFT JOIN `telemetria_listado_grupos`  grupo_3   ON grupo_3.idGrupo                                    = telemetria_listado.CrossCrane_grupo_giro
	LEFT JOIN `telemetria_listado_grupos`  grupo_4   ON grupo_4.idGrupo                                    = telemetria_listado.CrossCrane_grupo_carro
	LEFT JOIN `telemetria_listado_grupos`  grupo_5   ON grupo_5.idGrupo                                    = telemetria_listado.CrossCrane_grupo_voltaje
	LEFT JOIN `telemetria_listado_grupos`  grupo_6   ON grupo_6.idGrupo                                    = telemetria_listado.CrossCrane_grupo_motor_subida
	LEFT JOIN `telemetria_listado_grupos`  grupo_7   ON grupo_7.idGrupo                                    = telemetria_listado.CrossCrane_grupo_motor_bajada
	LEFT JOIN `telemetria_listado_grupos`  grupo_8   ON grupo_8.idGrupo                                    = telemetria_listado.idGrupoDespliegue
	LEFT JOIN `telemetria_listado_grupos`  grupo_9   ON grupo_9.idGrupo                                    = telemetria_listado.idGrupoVmonofasico
	LEFT JOIN `telemetria_listado_grupos`  grupo_10  ON grupo_10.idGrupo                                   = telemetria_listado.idGrupoVTrifasico
	LEFT JOIN `telemetria_listado_grupos`  grupo_11  ON grupo_11.idGrupo                                   = telemetria_listado.idGrupoPotencia
	LEFT JOIN `telemetria_listado_grupos`  grupo_12  ON grupo_12.idGrupo                                   = telemetria_listado.idGrupoConsumoMesHabil
	LEFT JOIN `telemetria_listado_grupos`  grupo_13  ON grupo_13.idGrupo                                   = telemetria_listado.idGrupoConsumoMesCurso
	LEFT JOIN `telemetria_listado_grupos`  grupo_14  ON grupo_14.idGrupo                                   = telemetria_listado.idGrupoEstanque
	LEFT JOIN `core_telemetria_ubicaciones`          ON core_telemetria_ubicaciones.idUbicacion            = telemetria_listado.idUbicacion';
	$SIS_where = 'telemetria_listado.idTelemetria = '.$_GET['id'];
	$rowData = db_select_data (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');

	$arrOpciones = array();
	$arrOpciones = db_select_array (false, 'idOpciones,Nombre', 'core_sistemas_opciones', '', '', 'idOpciones ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrOpciones');

	//recorro
	$arrEXOpciones = array();
	foreach ($arrOpciones as $sen) {
		$arrEXOpciones[$sen['idOpciones']] = $sen['Nombre'];
	}
	$arrEXOpciones[0] = 'No Asignado';


	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Equipo', $rowData['Nombre'], 'Resumen'); ?>
	</div>
	<div class="clearfix"></div>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<ul class="nav nav-tabs pull-right">
					<li class="active"><a href="<?php echo 'telemetria_listado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
					<li class=""><a href="<?php echo 'telemetria_listado_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
					<li class=""><a href="<?php echo 'telemetria_listado_configuracion.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-wrench" aria-hidden="true"></i> Configuracion</a></li>
					<li class="dropdown">
						<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
						<ul class="dropdown-menu" role="menu">
							<li class=""><a href="<?php echo 'telemetria_listado_estado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-power-off" aria-hidden="true"></i> Estado</a></li>
							<?php if($rowData['id_Sensores']==1){ ?>
								<li class=""><a href="<?php echo 'telemetria_listado_alarmas_perso.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bullhorn" aria-hidden="true"></i> Alarmas Personalizadas</a></li>
							<?php } ?>
							<?php if($rowData['id_Geo']==1){ ?>
								<li class=""><a href="<?php echo 'telemetria_listado_gps.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-map-marker" aria-hidden="true"></i> Datos GPS</a></li>
							<?php }elseif($rowData['id_Geo']==2){ ?>
								<li class=""><a href="<?php echo 'telemetria_listado_direccion.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-map-signs" aria-hidden="true"></i> Dirección</a></li>
							<?php } ?>
							<?php if($rowData['id_Sensores']==1){ ?>
								<li class=""><a href="<?php echo 'telemetria_listado_parametros.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-sliders" aria-hidden="true"></i> Sensores</a></li>
								<li class=""><a href="<?php echo 'telemetria_listado_sensor_operaciones.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-sliders" aria-hidden="true"></i> Definicion Operacional</a></li>
							<?php } ?>
							<li class=""><a href="<?php echo 'telemetria_listado_imagen.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-file-image-o" aria-hidden="true"></i> Imagen</a></li>
							<li class=""><a href="<?php echo 'telemetria_listado_trabajo.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-clock-o" aria-hidden="true"></i> Jornada Trabajo</a></li>
							<li class=""><a href="<?php echo 'telemetria_listado_otros_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-archive" aria-hidden="true"></i> Otros Datos</a></li>
							<li class=""><a href="<?php echo 'telemetria_listado_observaciones.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-tasks" aria-hidden="true"></i> Observaciones</a></li>
							<li class=""><a href="<?php echo 'telemetria_listado_archivos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivos</a></li>

						</ul>
					</li>
				</ul>
			</header>
			<div class="tab-content">

				<div class="tab-pane fade active in" id="basicos">
					<div class="wmd-panel">

						<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
							<?php if ($rowData['Direccion_img']=='') { ?>
								<img style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="Imagen Referencia" src="<?php echo DB_SITE_REPO ?>/Legacy/1tek_public/img/maquina.jpg">
							<?php }else{  ?>
								<img style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="Imagen Referencia" src="upload/<?php echo $rowData['Direccion_img']; ?>">
							<?php } ?>
						</div>
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
							<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos del Equipo</h2>
							<p class="text-muted">
								<?php if(isset($rowData['Nombre'])&&$rowData['Nombre']!=''){ ?>                              <strong>Nombre Equipo: </strong><?php echo $rowData['Nombre']; ?><br/><?php } ?>
								<?php if(isset($rowData['NumSerie'])&&$rowData['NumSerie']!=''){ ?>                          <strong>Numero de Serie: </strong><?php echo $rowData['NumSerie']; ?><br/><?php } ?>
								<?php if(isset($rowData['IdentificadorEmpresa'])&&$rowData['IdentificadorEmpresa']!=''){ ?>  <strong>Identificador Empresa : </strong><?php echo $rowData['IdentificadorEmpresa']; ?><br/><?php } ?>
								<?php if(isset($rowData['Sim_Num_Tel'])&&$rowData['Sim_Num_Tel']!=''){ ?>                    <strong>SIM - Numero Telefonico : </strong><?php echo $rowData['Sim_Num_Tel']; ?><br/><?php } ?>
								<?php if(isset($rowData['Sim_Num_Serie'])&&$rowData['Sim_Num_Serie']!=''){ ?>                <strong>SIM - Numero Serie : </strong><?php echo $rowData['Sim_Num_Serie']; ?><br/><?php } ?>
								<?php if(isset($rowData['Sim_Compania'])&&$rowData['Sim_Compania']!=''){ ?>                  <strong>SIM - Compañia : </strong><?php echo $rowData['Sim_Compania']; ?><br/><?php } ?>
								<?php if(isset($rowData['Sim_marca'])&&$rowData['Sim_marca']!=''){ ?>                        <strong>BAM - Marca : </strong><?php echo $rowData['Sim_marca']; ?><br/><?php } ?>
								<?php if(isset($rowData['Sim_modelo'])&&$rowData['Sim_modelo']!=''){ ?>                      <strong>BAM - Modelo : </strong><?php echo $rowData['Sim_modelo']; ?><br/><?php } ?>
								<?php if(isset($rowData['IP_Client'])&&$rowData['IP_Client']!=''){ ?>                        <strong>IP Cliente : </strong><?php echo $rowData['IP_Client']; ?><br/><?php } ?>
								<?php if(isset($rowData['idTelemetria'])&&$rowData['idTelemetria']!=''){ ?>                  <strong>ID Equipo : </strong><?php echo $rowData['idTelemetria']; ?><br/><?php } ?>
								<?php if(isset($rowData['Estado'])&&$rowData['Estado']!=''){ ?>                              <strong>Estado : </strong><?php echo $rowData['Estado']; ?><br/><?php } ?>

							</p>

							<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos de Configuracion</h2>
							<p class="text-muted">
								<strong class="color-red-dark">Basicos</strong><br/>
								<strong>Identificador : </strong><?php echo $rowData['Identificador']; ?><br/>
								<?php if(isset($rowData['Dispositivo'])&&$rowData['Dispositivo']!=''){ ?>            <strong>Hardware : </strong><?php echo $rowData['Dispositivo']; ?><br/><?php } ?>
								<?php if(isset($rowData['Shield'])&&$rowData['Shield']!=''){ ?>                      <strong>Shield : </strong><?php echo $rowData['Shield']; ?><br/><?php } ?>
								<?php if(isset($rowData['TiempoFueraLinea'])&&$rowData['TiempoFueraLinea']!=''){ ?>  <strong>Tiempo Fuera Linea Maximo : </strong><?php echo $rowData['TiempoFueraLinea']; ?> Horas<br/><?php } ?>
								<?php if(isset($rowData['Tab'])&&$rowData['Tab']!=''){ ?>                            <strong>Tab: </strong><?php echo $rowData['Tab']; ?><br/><?php } ?>

								<br/>
								<strong class="color-red-dark">Funciones</strong><br/>
								<?php if(isset($rowData['Geo'])&&$rowData['Geo']!=''){ ?>                        <strong>Geolocalizacion : </strong><?php echo $rowData['Geo']; ?><br/><?php } ?>
								<?php if(isset($rowData['Sensores'])&&$rowData['Sensores']!=''){ ?>              <strong>Sensores : </strong><?php echo $rowData['Sensores'].' ';if($rowData['id_Sensores']==1){echo '('.$rowData['cantSensores'].' Sensores)';} ?><br/><?php } ?>
								<?php if(isset($rowData['Predio'])&&$rowData['Predio']!=''){ ?>                  <strong>Utilizacion de Predios : </strong><?php echo $rowData['Predio']; ?><br/><?php } ?>
								<?php if(isset($rowData['Backup'])&&$rowData['Backup']!=''){ ?>                  <strong>Utilizacion de Backup : </strong><?php echo $rowData['Backup'].' ';if(isset($rowData['NregBackup'])&&$rowData['NregBackup']!=''&&$rowData['NregBackup']!=0){echo '('.$rowData['NregBackup'].' Registros)';} ?><br/><?php } ?>
								<?php if(isset($rowData['Generador'])&&$rowData['Generador']!=''){ ?>            <strong>Generador Electrico : </strong><?php echo $rowData['Generador'].' ';if(isset($rowData['GeneradorNombre'])&&$rowData['GeneradorNombre']!=''){echo'('.$rowData['GeneradorNombre'].' instaladado el '.fecha_estandar($rowData['GeneradorFecha']).')';} ?><br/><?php } ?>
								<?php if(isset($rowData['AlertaTemprana'])&&$rowData['AlertaTemprana']!=''){ ?>  <strong>Alerta Temprana : </strong><?php echo $rowData['AlertaTemprana']; ?><br/><?php } ?>
								<?php if(isset($rowData['UsoFTP'])&&$rowData['UsoFTP']!=''){ ?>                  <strong>Uso FTP : </strong><?php echo $rowData['UsoFTP']; ?><br/><?php } ?>
								<?php if(isset($rowData['idUsoFTP'])&&$rowData['idUsoFTP']==1){ ?>               <strong>Carpeta FTP : </strong><?php echo $rowData['FTP_Carpeta']; ?><br/><?php } ?>

								<br/>
								<strong class="color-red-dark">Otros Datos</strong><br/>
								<?php if(isset($rowData['Capacidad'])&&$rowData['Capacidad']!=0){ ?>                             <strong>Capacidad Nebulizador: </strong><?php echo Cantidades_decimales_justos($rowData['Capacidad']); ?><br/><?php } ?>
								<?php if(isset($rowData['TiempoRevision'])&&$rowData['TiempoRevision']!=0){ ?>                   <strong>Hora Revision: </strong><?php echo $rowData['TiempoRevision']; ?><br/><?php } ?>
								<?php if(isset($rowData['Grupo_amperaje'])&&$rowData['Grupo_amperaje']!=0){ ?>                   <strong>Gruas - Grupo Alimentacion: </strong><?php echo $rowData['Grupo_amperaje']; ?><br/><?php } ?>
								<?php if(isset($rowData['Grupo_elevacion'])&&$rowData['Grupo_elevacion']!=0){ ?>                 <strong>Gruas - Grupo Elevacion: </strong><?php echo $rowData['Grupo_elevacion']; ?><br/><?php } ?>
								<?php if(isset($rowData['Grupo_giro'])&&$rowData['Grupo_giro']!=0){ ?>                           <strong>Gruas - Grupo Giro: </strong><?php echo $rowData['Grupo_giro']; ?><br/><?php } ?>
								<?php if(isset($rowData['Grupo_carro'])&&$rowData['Grupo_carro']!=0){ ?>                         <strong>Gruas - Grupo Carro: </strong><?php echo $rowData['Grupo_carro']; ?><br/><?php } ?>
								<?php if(isset($rowData['Grupo_voltaje'])&&$rowData['Grupo_voltaje']!=0){ ?>                     <strong>Gruas - Grupo Voltaje: </strong><?php echo $rowData['Grupo_voltaje']; ?><br/><?php } ?>
								<?php if(isset($rowData['Ubicacion'])&&$rowData['Ubicacion']!=0){ ?>                             <strong>Gruas - Ubicación: </strong><?php echo $rowData['Ubicacion']; ?><br/><?php } ?>
								<?php if(isset($rowData['Grupo_motor_subida'])&&$rowData['Grupo_motor_subida']!=0){ ?>           <strong>Ascensores - Grupo Amperaje Motor Subida: </strong><?php echo $rowData['Grupo_motor_subida']; ?><br/><?php } ?>
								<?php if(isset($rowData['Grupo_motor_bajada'])&&$rowData['Grupo_motor_bajada']!=0){ ?>           <strong>Ascensores - Grupo Amperaje Motor Bajada: </strong><?php echo $rowData['Grupo_motor_bajada']; ?><br/><?php } ?>
								<?php if(isset($rowData['Grupo_Despliegue'])&&$rowData['Grupo_Despliegue']!=0){ ?>               <strong>SimpliEnergy - Grupo Despliegue: </strong><?php echo $rowData['Grupo_Despliegue']; ?><br/><?php } ?>
								<?php if(isset($rowData['Grupo_Vmonofasico'])&&$rowData['Grupo_Vmonofasico']!=0){ ?>             <strong>SimpliEnergy - Grupo V monofasico: </strong><?php echo $rowData['Grupo_Vmonofasico']; ?><br/><?php } ?>
								<?php if(isset($rowData['Grupo_VTrifasico'])&&$rowData['Grupo_VTrifasico']!=0){ ?>               <strong>SimpliEnergy - Grupo V Trifasico: </strong><?php echo $rowData['Grupo_VTrifasico']; ?><br/><?php } ?>
								<?php if(isset($rowData['Grupo_Potencia'])&&$rowData['Grupo_Potencia']!=0){ ?>                   <strong>SimpliEnergy - Grupo Potencia: </strong><?php echo $rowData['Grupo_Potencia']; ?><br/><?php } ?>
								<?php if(isset($rowData['Grupo_ConsumoMesHabil'])&&$rowData['Grupo_ConsumoMesHabil']!=0){ ?>     <strong>SimpliEnergy - Grupo Consumo Mes Habil: </strong><?php echo $rowData['Grupo_ConsumoMesHabil']; ?><br/><?php } ?>
								<?php if(isset($rowData['Grupo_ConsumoMesCurso'])&&$rowData['Grupo_ConsumoMesCurso']!=0){ ?>     <strong>SimpliEnergy - Grupo Consumo Mes Curso: </strong><?php echo $rowData['Grupo_ConsumoMesCurso']; ?><br/><?php } ?>
								<?php if(isset($rowData['Grupo_Estanque'])&&$rowData['Grupo_Estanque']!=0){ ?>                   <strong>SimpliEnergy - Grupo Estanque Combustible: </strong><?php echo $rowData['Grupo_Estanque']; ?><br/><?php } ?>
								<?php if(isset($rowData['CrossCMinHorno'])&&$rowData['CrossCMinHorno']!=0){ ?>                   <strong>SimpliC - Temperatura Minima del Horno: </strong><?php echo $rowData['CrossCMinHorno']; ?><br/><?php } ?>

								<?php if($rowData['id_Geo']==2){ ?>
									<br/>
									<strong class="color-red-dark">Ubicación</strong><br/>
									<?php if(isset($rowData['ZonaSinGPS'])&&$rowData['ZonaSinGPS']!=''){ ?> <strong>Zona de Trabajo : </strong><?php echo $rowData['ZonaSinGPS']; ?><br/><?php } ?>
									<?php if(isset($rowData['Direccion'])&&$rowData['Direccion']!=''){ ?>   <strong>Dirección : </strong><?php echo $rowData['Direccion'].', '.$rowData['Comuna'].', '.$rowData['Ciudad']; ?><br/><?php } ?>
								<?php } ?>

							</p>

							<?php if($rowData['id_Geo']==1){ ?>
								<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos GPS</h2>
								<p class="text-muted">
									<strong class="color-red-dark">Basicos</strong><br/>
									<strong>Tipo de Vehiculo : </strong><?php echo $rowData['TipoVehiculo']; ?><br/>
									<strong>Marca : </strong><?php echo $rowData['Marca']; ?><br/>
									<strong>Modelo : </strong><?php echo $rowData['Modelo']; ?><br/>
									<strong>Patente : </strong><?php echo $rowData['Patente']; ?><br/>
									<strong>Numero de serie : </strong><?php echo $rowData['Num_serie']; ?><br/>
									<strong>Año de Fabricacion : </strong><?php echo $rowData['AnoFab']; ?><br/>

									<br/>
									<strong class="color-red-dark">Caracteristicos</strong><br/>
									<strong>Zona de Trabajo : </strong><?php echo $rowData['ZonaConGPS']; ?><br/>
									<strong>Capacidad Pasajeros : </strong><?php echo $rowData['CapacidadPersonas']; ?><br/>
									<strong>Capacidad (Kilos) : </strong><?php echo Cantidades_decimales_justos($rowData['CapacidadKilos']); ?><br/>
									<strong>Metros Cubicos (M3) : </strong><?php echo Cantidades_decimales_justos($rowData['MCubicos']); ?><br/>

									<br/>
									<strong class="color-red-dark">Datos Movilizacion</strong><br/>
									<strong>Limite Velocidad : </strong><?php echo Cantidades_decimales_justos($rowData['LimiteVelocidad']).' KM/h'; ?><br/>
									<strong>Tiempo Maximo Detencion : </strong><?php echo $rowData['TiempoDetencion']; ?> Horas<br/>
								</p>

							<?php } ?>

							<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Jornada Laboral</h2>
							<p class="text-muted">
								<strong>Jornada : </strong><?php echo 'De '.$rowData['Jornada_inicio'].' a '.$rowData['Jornada_termino']; ?><br/>
								<strong>Colacion : </strong><?php echo 'De '.$rowData['Colacion_inicio'].' a '.$rowData['Colacion_termino']; ?><br/>
								<strong>Tiempo Microparadas : </strong><?php echo $rowData['Microparada'].' hrs'; ?><br/>
							</p>


						</div>
						<div class="clearfix"></div>

					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="clearfix"></div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
		<a href="<?php echo $location ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
		<div class="clearfix"></div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['new'])){
	//valido los permisos
	validaPermisoUser($rowlevel['level'], 3, $dbConn); ?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Crear Equipo</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					//if(isset($Identificador)){   $x1  = $Identificador;    }else{$x1  = '';}
					if(isset($Nombre)){          $x2  = $Nombre;           }else{$x2  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_tittle(3, 'Datos Básicos');
					//$Form_Inputs->form_input_icon('Identificador', 'Identificador', $x1, 2,'fa fa-flag');
					$Form_Inputs->form_input_text('Nombre del Equipo', 'Nombre', $x2, 2);

					$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
					$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
					$Form_Inputs->form_input_hidden('id_Geo', 2, 2);             //Sin geolocalizacion
					$Form_Inputs->form_input_hidden('id_Sensores', 2, 2);        //Sin sensores
					$Form_Inputs->form_input_hidden('idEstado', 1, 2);          //activa
					$Form_Inputs->form_input_hidden('idUsoPredio', 2, 2);        //sin uso de predio
					$Form_Inputs->form_input_hidden('idMantencion', 2, 2);       //no esta en mantencion
					$Form_Inputs->form_input_hidden('idEstadoEncendido', 1, 2); //esta encendida
					$Form_Inputs->form_input_hidden('idBackup', 1, 2);          //tiene backup activo
					$Form_Inputs->form_input_hidden('NregBackup', 200000, 2);    //guarda 200000 en tabla relacionada
					$Form_Inputs->form_input_hidden('idGenerador', 2, 2);        //No tiene generador
					$Form_Inputs->form_input_hidden('idAlertaTemprana', 2, 2);   //no manda alerta temprana
					$Form_Inputs->form_input_hidden('idUsoFTP', 2, 2);           //No usa FTP
					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit">
						<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
					</div>
				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
	/**********************************************************/
	//paginador de resultados
	if(isset($_GET['pagina'])){$num_pag = $_GET['pagina'];} else {$num_pag = 1;}
	//Defino la cantidad total de elementos por pagina
	$cant_reg = 30;
	//resto de variables
	if (!$num_pag){$comienzo = 0;$num_pag = 1;} else {$comienzo = ( $num_pag - 1 ) * $cant_reg ;}
	/**********************************************************/
	//ordenamiento
	if(isset($_GET['order_by'])&&$_GET['order_by']!=''){
		switch ($_GET['order_by']) {
			case 'nombre_asc':           $order_by = 'telemetria_listado.Nombre ASC ';         $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente'; break;
			case 'nombre_desc':          $order_by = 'telemetria_listado.Nombre DESC ';        $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Nombre Descendente';break;
			case 'identificador_asc':    $order_by = 'telemetria_listado.Identificador ASC ';  $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Identificador Ascendente';break;
			case 'identificador_desc':   $order_by = 'telemetria_listado.Identificador DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Identificador Descendente';break;
			case 'numserie_asc':         $order_by = 'telemetria_listado.NumSerie ASC ';       $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Numero de Serie Ascendente';break;
			case 'numserie_desc':        $order_by = 'telemetria_listado.NumSerie DESC ';      $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Numero de Serie Descendente';break;
			case 'estado_asc':           $order_by = 'telemetria_listado.idEstado ASC ';       $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Estado Ascendente';break;
			case 'estado_desc':          $order_by = 'telemetria_listado.idEstado DESC ';      $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Estado Descendente';break;
			case 'geo_asc':              $order_by = 'core_sistemas_opciones.Nombre ASC ';     $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Geolocalizacion Ascendente';break;
			case 'geo_desc':             $order_by = 'core_sistemas_opciones.Nombre DESC ';    $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Geolocalizacion Descendente';break;
			case 'tab_asc':              $order_by = 'core_telemetria_tabs.Nombre ASC ';       $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Tab Ascendente';break;
			case 'tab_desc':             $order_by = 'core_telemetria_tabs.Nombre DESC ';      $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Tab Descendente';break;

			default: $order_by = 'telemetria_listado.idEstado ASC, telemetria_listado.Nombre ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente';
		}
	}else{
		$order_by = 'telemetria_listado.idEstado ASC, telemetria_listado.Nombre ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente';
	}
	/**********************************************************/
	//Verifico el tipo de usuario que esta ingresando
	$SIS_where = "telemetria_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
	/**********************************************************/
	//Se aplican los filtros
	if(isset($_GET['Identificador']) && $_GET['Identificador']!=''){  $SIS_where .= " AND telemetria_listado.Identificador LIKE '%".EstandarizarInput($_GET['Identificador'])."%'";}
	if(isset($_GET['Nombre']) && $_GET['Nombre']!=''){                $SIS_where .= " AND telemetria_listado.Nombre LIKE '%".EstandarizarInput($_GET['Nombre'])."%'";}
	if(isset($_GET['NumSerie']) && $_GET['NumSerie']!=''){            $SIS_where .= " AND telemetria_listado.NumSerie LIKE '%".EstandarizarInput($_GET['NumSerie'])."%'";}
	if(isset($_GET['idEstado']) && $_GET['idEstado']!=''){            $SIS_where .= " AND telemetria_listado.idEstado=".$_GET['idEstado'];}
	if(isset($_GET['id_Geo']) && $_GET['id_Geo']!=''){                $SIS_where .= " AND telemetria_listado.id_Geo=".$_GET['id_Geo'];}
	if(isset($_GET['idTab']) && $_GET['idTab']!=''){                  $SIS_where .= " AND telemetria_listado.idTab=".$_GET['idTab'];}
	/**********************************************************/
	//Realizo una consulta para saber el total de elementos existentes
	$cuenta_registros = db_select_nrows (false, 'idTelemetria', 'telemetria_listado', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
	//Realizo la operacion para saber la cantidad de paginas que hay
	$total_paginas = ceil($cuenta_registros / $cant_reg);
	// Se trae un listado con todos los elementos
	$SIS_query = '
	telemetria_listado.idTelemetria,
	telemetria_listado.Identificador,
	telemetria_listado.Nombre,
	telemetria_listado.NumSerie,
	core_sistemas.Nombre AS sistema,
	core_estados.Nombre AS Estado,
	telemetria_listado.idEstado,
	core_sistemas_opciones.Nombre AS Geo,
	core_telemetria_tabs.Nombre AS Tab';
	$SIS_join  = '
	LEFT JOIN `core_sistemas`           ON core_sistemas.idSistema             = telemetria_listado.idSistema
	LEFT JOIN `core_estados`            ON core_estados.idEstado               = telemetria_listado.idEstado
	LEFT JOIN `core_sistemas_opciones`  ON core_sistemas_opciones.idOpciones   = telemetria_listado.id_Geo
	LEFT JOIN `core_telemetria_tabs`    ON core_telemetria_tabs.idTab          = telemetria_listado.idTab';
	$SIS_order = $order_by.' LIMIT '.$comienzo.', '.$cant_reg;
	$arrEquipos = array();
	$arrEquipos = db_select_array (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrEquipos');

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar">

		<ul class="btn-group btn-breadcrumb pull-left">
			<li class="btn btn-default tooltip" role="button" data-toggle="collapse" href="#collapseForm" aria-expanded="false" aria-controls="collapseForm" title="Presionar para desplegar Formulario de Búsqueda" style="font-size: 14px;"><i class="fa fa-search faa-vertical animated" aria-hidden="true"></i></li>
			<li class="btn btn-default"><?php echo $bread_order; ?></li>
			<?php if(isset($_GET['filtro_form'])&&$_GET['filtro_form']!=''){ ?>
				<li class="btn btn-danger"><a href="<?php echo $original.'?pagina=1'; ?>" style="color:#fff;"><i class="fa fa-trash-o" aria-hidden="true"></i> Limpiar</a></li>
			<?php } ?>
		</ul>

		<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $location; ?>&new=true" class="btn btn-default pull-right margin_width fmrbtn" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Equipo</a><?php } ?>

	</div>
	<div class="clearfix"></div>
	<div class="collapse col-xs-12 col-sm-12 col-md-12 col-lg-12" id="collapseForm">
		<div class="well">
			<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
				<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" autocomplete="off" novalidate>
					<?php
					//Se verifican si existen los datos
					if(isset($Identificador)){   $x1  = $Identificador;    }else{$x1  = '';}
					if(isset($Nombre)){          $x2  = $Nombre;           }else{$x2  = '';}
					if(isset($NumSerie)){        $x3  = $NumSerie;         }else{$x3  = '';}
					if(isset($idEstado)){        $x4  = $idEstado;         }else{$x4  = '';}
					if(isset($id_Geo)){          $x5  = $id_Geo;           }else{$x5  = '';}
					if(isset($idTab)){           $x6  = $idTab;            }else{$x6  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_input_icon('Identificador', 'Identificador', $x1, 1,'fa fa-flag');
					$Form_Inputs->form_input_text('Nombre del Equipo', 'Nombre', $x2, 1);
					$Form_Inputs->form_input_icon('Numero de Serie', 'NumSerie', $x3, 1,'fa fa-barcode');
					$Form_Inputs->form_select('Estado','idEstado', $x4, 1, 'idEstado', 'Nombre', 'core_estados', 0, '', $dbConn);
					$Form_Inputs->form_select('Geolocalizacion','id_Geo', $x5, 1, 'idOpciones', 'Nombre', 'core_sistemas_opciones', 0, '', $dbConn);
					$Form_Inputs->form_select('Tab','idTab', $x6, 1, 'idTab', 'Nombre', 'core_telemetria_tabs', 0, '', $dbConn);

					$Form_Inputs->form_input_hidden('pagina', 1, 1);
					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf002; Filtrar" name="filtro_form">
						<a href="<?php echo $original.'?pagina=1'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-trash-o" aria-hidden="true"></i> Limpiar</a>
					</div>

				</form>
				<?php widget_validator(); ?>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Equipos</h5>
				<div class="toolbar">
					<?php
					//se llama al paginador
					echo paginador_2('pagsup',$total_paginas, $original, $search, $num_pag ) ?>
				</div>
			</header>
			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
							<th>
								<div class="pull-left">Nombre</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=nombre_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=nombre_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Identificador</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=identificador_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=identificador_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Numero de Serie</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=numserie_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=numserie_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Estado</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=estado_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=estado_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">GPS</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=geo_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=geo_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th>
								<div class="pull-left">Tag</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=tab_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=tab_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>

							<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><th width="160">Sistema</th><?php } ?>
							<th width="10">Acciones</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php foreach ($arrEquipos as $equip) { ?>
						<tr class="odd">
							<td><?php echo $equip['Nombre']; ?></td>
							<td><?php echo $equip['Identificador']; ?></td>
							<td><?php echo $equip['NumSerie']; ?></td>
							<td><label class="label <?php if(isset($equip['idEstado'])&&$equip['idEstado']==1){echo 'label-success';}else{echo 'label-danger';} ?>"><?php echo $equip['Estado']; ?></label></td>
							<td><?php echo $equip['Geo']; ?></td>
							<td><?php echo $equip['Tab']; ?></td>
							<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><td><?php echo $equip['sistema']; ?></td><?php } ?>
							<td>
								<div class="btn-group" style="width: 140px;" >
									<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_telemetria.php?view='.simpleEncode($equip['idTelemetria'], fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'&nombre_equipo='.$equip['Nombre'].'&clone_idTelemetria='.$equip['idTelemetria']; ?>" title="Clonar Equipo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-files-o" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'&id='.$equip['idTelemetria']; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=4){
										//se verifica que el usuario no sea uno mismo
										$ubicacion = $location.'&del='.simpleEncode($equip['idTelemetria'], fecha_actual());
										$dialogo   = '¿Realmente deseas eliminar el equipo '.$equip['Nombre'].'?'; ?>
										<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Información" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
									<?php } ?>
								</div>
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
			<div class="pagrow">
				<?php
				//se llama al paginador
				echo paginador_2('paginf',$total_paginas, $original, $search, $num_pag ) ?>
			</div>
		</div>
	</div>

<?php } ?>
<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';

?>
