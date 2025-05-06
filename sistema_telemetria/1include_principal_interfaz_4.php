<?php
/*****************************************************************************************************************/
/*                                               Transacciones                                                   */
/*****************************************************************************************************************/
//Tipo de usuario
$idTipoUsuario  = $_SESSION['usuario']['basic_data']['idTipoUsuario'];

//variable de numero de permiso
$x_nperm = 0;

//permisos a las transacciones
$x_nperm++; $trans[$x_nperm] = "telemetria_gestion_flota.php";                    //01 - Acceso a la transaccion de administracion de gestion de flota (vehiculos)
$x_nperm++; $trans[$x_nperm] = "telemetria_gestion_sensores.php";                 //02 - Acceso a la transaccion de administracion de gestion sensores (colegios)
$x_nperm++; $trans[$x_nperm] = "telemetria_gestion_equipos.php";                  //03 - Acceso a la transaccion de administracion de gestion de equipos (todos los sensores)

//Genero los permisos
for ($i = 1; $i <= $x_nperm; $i++) {
	//Seteo la variable a 0
	$prm_x[$i] = 0;
	//recorro los permisos
	if(isset($_SESSION['usuario']['menu'])){
		foreach($_SESSION['usuario']['menu'] as $menu=>$productos) {
			foreach($productos as $producto) {
				//elimino los datos extras
				$str = str_replace("?pagina=1", "", $producto['TransaccionURL']);
				//le asigno el valor 1 en caso de que exista
				if($trans[$i]==$str){
					$prm_x[$i] = 1;
				}
			}
		}
	}
}
/************************************************************************************/
//consultas anidadas, se utiliza las variables anteriores para consultar cada permiso
$SIS_query = 'idOpcionesTel,idOpcionesGen_4, idOpcionesGen_6';
$SIS_join  = '';
$SIS_where = 'idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
$n_permisos = db_select_data (false, $SIS_query, 'core_sistemas',$SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'n_permisos');

/*****************************************************************************************************************/
/*                                                Modelado                                                       */
/*****************************************************************************************************************/

?>

<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<?php
/**************************************************************************/
$temp = $prm_x[1] + $prm_x[2] + $prm_x[3];
if($temp!=0){
	//si los segundos no estan configurados
	if(isset($n_permisos['idOpcionesGen_6'])&&$n_permisos['idOpcionesGen_6']!=0){
		$x_seg = $n_permisos['idOpcionesGen_6'] * 1000;
	}else{
		$x_seg = 60000;
	}

	//Verifico si esta activada la actualizacion de la pagina
	if($n_permisos['idOpcionesGen_4']=='1'&&$n_permisos['idOpcionesTel']!=11&&$n_permisos['idOpcionesTel']!=12) { 

		$Url  = 'principal_telemetria_alt.php';
		$Url .= '?bla=bla';
		$Url .= '&idTipoUsuario='.$idTipoUsuario;
		$Url .= '&prm_x_7='.$prm_x[1];
		$Url .= '&prm_x_8='.$prm_x[2];
		$Url .= '&prm_x_9='.$prm_x[3];
		$Url .= '&idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
		$Url .= '&Config_IDGoogle='.$_SESSION['usuario']['basic_data']['Config_IDGoogle'];
		$Url .= '&idUsuario='.$_SESSION['usuario']['basic_data']['idUsuario'];
		$Url .= '&trans_8='.$prm_x[2];
		$Url .= '&trans_9='.$prm_x[3];
		$Url .= '&idOpcionesTel='.$n_permisos['idOpcionesTel'];
		$Url .= '&x_seg='.$x_seg;

		echo '
		<script type="text/javascript">
			function actualiza_contenido() {
				$("#update_tel").load('.$Url.');
			}
			setInterval("actualiza_contenido()", '.$x_seg.');

		</script>';
	}
	/***************************************************************/
	echo '
	<div class="panel-heading">
		<span class="panel-title"  style="color: #666;font-weight: 700 !important;">Telemetria</span>
	</div>';

	echo '
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="update_tel">
		<span class="panel-title"  style="color: #1E90FF;font-weight: 700 !important;" id="update_text_HoraRefresco">Hora Refresco: '.hora_actual().'</span>';

		switch ($n_permisos['idOpcionesTel']) {
			/*****************************************************/
			//Si no esta configurado
			case 0:
				echo widget_GPS_equipos('Equipos Telemetria','Equipos', 2, 2, $_SESSION['usuario']['basic_data']['idSistema'],
										$_SESSION['usuario']['basic_data']['Config_IDGoogle'],
										$_SESSION['usuario']['basic_data']['idTipoUsuario'],
										$_SESSION['usuario']['basic_data']['idUsuario'],$dbConn);
				echo widget_GPS_equipos_lista('Ultimas Mediciones', 2, 0, $prm_x[2],
												$_SESSION['usuario']['basic_data']['idSistema'],
												$_SESSION['usuario']['basic_data']['idTipoUsuario'],
												$_SESSION['usuario']['basic_data']['idUsuario'], $dbConn);
			break;
			/*****************************************************/
			//Detalle por GPS
			case 1:
				echo widget_GPS_equipos('Equipos GPS','Vehiculos', 1, 2, $_SESSION['usuario']['basic_data']['idSistema'],
										$_SESSION['usuario']['basic_data']['Config_IDGoogle'],
										$_SESSION['usuario']['basic_data']['idTipoUsuario'],
										$_SESSION['usuario']['basic_data']['idUsuario'],$dbConn);
				echo widget_Resumen_GPS_equipos('Vehiculos', 1, $_SESSION['usuario']['basic_data']['idSistema'],
												$_SESSION['usuario']['basic_data']['idTipoUsuario'],
												$_SESSION['usuario']['basic_data']['idUsuario'],$dbConn);
			break;
			/*****************************************************/
			//Lista Equipos
			case 2:
				echo widget_GPS_equipos('Equipos Fijos','Fijos', 2, 2, $_SESSION['usuario']['basic_data']['idSistema'],
										$_SESSION['usuario']['basic_data']['Config_IDGoogle'],
										$_SESSION['usuario']['basic_data']['idTipoUsuario'],
										$_SESSION['usuario']['basic_data']['idUsuario'],$dbConn);
				echo widget_GPS_equipos_lista('Ultimas Mediciones', 2, 0, $prm_x[2],
												$_SESSION['usuario']['basic_data']['idSistema'],
												$_SESSION['usuario']['basic_data']['idTipoUsuario'],
												$_SESSION['usuario']['basic_data']['idUsuario'], $dbConn);
			break;
			/*****************************************************/
			//Detalle por Equipos
			case 3:
				echo widget_Equipos('Equipos Telemetria', 2, 0,$prm_x[3], $_SESSION['usuario']['basic_data']['idSistema'],
									$_SESSION['usuario']['basic_data']['idTipoUsuario'],
									$_SESSION['usuario']['basic_data']['idUsuario'], $dbConn);
				echo widget_Resumen_equipo('Ultimas Mediciones', 2, 0, 0,
											$_SESSION['usuario']['basic_data']['idSistema'],
											$_SESSION['usuario']['basic_data']['idTipoUsuario'],
											$_SESSION['usuario']['basic_data']['idUsuario'], $dbConn);
			break;
			/*****************************************************/
			//Lista GPS
			case 4:
				echo widget_GPS_equipos('Equipos GPS','Vehiculos', 1, 2, $_SESSION['usuario']['basic_data']['idSistema'],
										$_SESSION['usuario']['basic_data']['Config_IDGoogle'],
										$_SESSION['usuario']['basic_data']['idTipoUsuario'],
										$_SESSION['usuario']['basic_data']['idUsuario'],$dbConn);
				echo widget_GPS_lista('Ultimas Mediciones', 1, 0, $prm_x[2],
										$_SESSION['usuario']['basic_data']['idSistema'],
										$_SESSION['usuario']['basic_data']['idTipoUsuario'],
										$_SESSION['usuario']['basic_data']['idUsuario'], $dbConn);
			break;
			/*****************************************************/
			//Detalle por GPS y Detalle por Equipos
			case 5:
				//Detalle por GPS
				echo widget_GPS_equipos('Equipos GPS','Vehiculos', 1, 2, $_SESSION['usuario']['basic_data']['idSistema'],
										$_SESSION['usuario']['basic_data']['Config_IDGoogle'],
										$_SESSION['usuario']['basic_data']['idTipoUsuario'],
										$_SESSION['usuario']['basic_data']['idUsuario'],$dbConn);
				echo widget_Resumen_GPS_equipos('Vehiculos', 1, $_SESSION['usuario']['basic_data']['idSistema'],
												$_SESSION['usuario']['basic_data']['idTipoUsuario'],
												$_SESSION['usuario']['basic_data']['idUsuario'],$dbConn);
				//Detalle por Equipos
				echo widget_Equipos('Equipos Telemetria', 2, 0,$prm_x[3], $_SESSION['usuario']['basic_data']['idSistema'],
									$_SESSION['usuario']['basic_data']['idTipoUsuario'],
									$_SESSION['usuario']['basic_data']['idUsuario'], $dbConn);
				echo widget_Resumen_equipo('Ultimas Mediciones', 2, 0, 0,
											$_SESSION['usuario']['basic_data']['idSistema'],
											$_SESSION['usuario']['basic_data']['idTipoUsuario'],
											$_SESSION['usuario']['basic_data']['idUsuario'], $dbConn);
			break;
			/*****************************************************/
			//Detalle por GPS y Lista Equipos
			case 6:
				//Detalle por GPS
				echo widget_GPS_equipos('Equipos GPS','Vehiculos', 1, 2, $_SESSION['usuario']['basic_data']['idSistema'],
										$_SESSION['usuario']['basic_data']['Config_IDGoogle'],
										$_SESSION['usuario']['basic_data']['idTipoUsuario'],
										$_SESSION['usuario']['basic_data']['idUsuario'],$dbConn);
				echo widget_Resumen_GPS_equipos('Vehiculos', 1, $_SESSION['usuario']['basic_data']['idSistema'],
												$_SESSION['usuario']['basic_data']['idTipoUsuario'],
												$_SESSION['usuario']['basic_data']['idUsuario'],$dbConn);
				//Lista Equipos
				echo widget_GPS_equipos('Equipos Fijos','Fijos', 2, 2, $_SESSION['usuario']['basic_data']['idSistema'],
										$_SESSION['usuario']['basic_data']['Config_IDGoogle'],
										$_SESSION['usuario']['basic_data']['idTipoUsuario'],
										$_SESSION['usuario']['basic_data']['idUsuario'],$dbConn);
				echo widget_GPS_equipos_lista('Ultimas Mediciones', 2, 0, $prm_x[2],
												$_SESSION['usuario']['basic_data']['idSistema'],
												$_SESSION['usuario']['basic_data']['idTipoUsuario'],
												$_SESSION['usuario']['basic_data']['idUsuario'], $dbConn);
			break;
			/*****************************************************/
			//Lista GPS y Detalle por Equipos
			case 7:
				//Lista GPS
				echo widget_GPS_equipos('Equipos GPS','Vehiculos', 1, 2, $_SESSION['usuario']['basic_data']['idSistema'],
										$_SESSION['usuario']['basic_data']['Config_IDGoogle'],
										$_SESSION['usuario']['basic_data']['idTipoUsuario'],
										$_SESSION['usuario']['basic_data']['idUsuario'],$dbConn);
				echo widget_GPS_lista('Ultimas Mediciones', 1, 0, $prm_x[2],
										$_SESSION['usuario']['basic_data']['idSistema'],
										$_SESSION['usuario']['basic_data']['idTipoUsuario'],
										$_SESSION['usuario']['basic_data']['idUsuario'], $dbConn);
				//Detalle por Equipos
				echo widget_Equipos('Equipos Telemetria', 2, 0,$prm_x[3], $_SESSION['usuario']['basic_data']['idSistema'],
									$_SESSION['usuario']['basic_data']['idTipoUsuario'],
									$_SESSION['usuario']['basic_data']['idUsuario'], $dbConn);
				echo widget_Resumen_equipo('Ultimas Mediciones', 2, 0, 0,
											$_SESSION['usuario']['basic_data']['idSistema'],
											$_SESSION['usuario']['basic_data']['idTipoUsuario'],
											$_SESSION['usuario']['basic_data']['idUsuario'], $dbConn);
			break;
			/*****************************************************/
			//Lista GPS y Lista Equipos
			case 8:
				//Lista GPS
				echo widget_GPS_equipos('Equipos GPS','Vehiculos', 1, 2, $_SESSION['usuario']['basic_data']['idSistema'],
										$_SESSION['usuario']['basic_data']['Config_IDGoogle'],
										$_SESSION['usuario']['basic_data']['idTipoUsuario'],
										$_SESSION['usuario']['basic_data']['idUsuario'],$dbConn);
				echo widget_GPS_lista('Ultimas Mediciones', 1, 0, $prm_x[2],
										$_SESSION['usuario']['basic_data']['idSistema'],
										$_SESSION['usuario']['basic_data']['idTipoUsuario'],
										$_SESSION['usuario']['basic_data']['idUsuario'], $dbConn);
				//Lista Equipos
				echo widget_GPS_equipos('Equipos Fijos','Fijos', 2, 2, $_SESSION['usuario']['basic_data']['idSistema'],
										$_SESSION['usuario']['basic_data']['Config_IDGoogle'],
										$_SESSION['usuario']['basic_data']['idTipoUsuario'],
										$_SESSION['usuario']['basic_data']['idUsuario'],$dbConn);
				echo widget_GPS_equipos_lista('Ultimas Mediciones', 2, 0, $prm_x[2],
												$_SESSION['usuario']['basic_data']['idSistema'],
												$_SESSION['usuario']['basic_data']['idTipoUsuario'],
												$_SESSION['usuario']['basic_data']['idUsuario'], $dbConn);
			break;
			/*****************************************************/
			//Detalle por Equipos
			case 9:
				echo widget_Equipos('Equipos Telemetria', 2, 0,$prm_x[3], $_SESSION['usuario']['basic_data']['idSistema'],
									$_SESSION['usuario']['basic_data']['idTipoUsuario'],
									$_SESSION['usuario']['basic_data']['idUsuario'], $dbConn);
				echo widget_Promedios_equipo('Mediciones Promedios Actuales', 2, 0, 0,
											$_SESSION['usuario']['basic_data']['idSistema'],
											$_SESSION['usuario']['basic_data']['idTipoUsuario'],
											$_SESSION['usuario']['basic_data']['idUsuario'], $dbConn);
			break;
			/*****************************************************/
			//Detalle por Equipos grupos
			case 10:
				echo widget_Equipos('Equipos Telemetria', 2, 0,$prm_x[3], $_SESSION['usuario']['basic_data']['idSistema'],
									$_SESSION['usuario']['basic_data']['idTipoUsuario'],
									$_SESSION['usuario']['basic_data']['idUsuario'], $dbConn);
				echo widget_Promedios_equipo_grupos('Mediciones Promedios Actuales', 2, 0, 0,
													$_SESSION['usuario']['basic_data']['idSistema'],
													$_SESSION['usuario']['basic_data']['idTipoUsuario'],
													$_SESSION['usuario']['basic_data']['idUsuario'], $dbConn);
			break;
			/*****************************************************/
			//Gestion de Flota
			case 11:
				echo widget_Gestion_Flota('Gestion de Flota',
										$_SESSION['usuario']['basic_data']['idSistema'],
										$_SESSION['usuario']['basic_data']['Config_IDGoogle'],
										$_SESSION['usuario']['basic_data']['idTipoUsuario'],
										$_SESSION['usuario']['basic_data']['idUsuario'],
										$x_seg,
										$dbConn);
			break;
			/*****************************************************/
			//Gestion de Equipos
			case 12:
				echo widget_Gestion_Equipos('Gestion de Equipos',
											$_SESSION['usuario']['basic_data']['idSistema'],
											$_SESSION['usuario']['basic_data']['Config_IDGoogle'],
											$_SESSION['usuario']['basic_data']['idTipoUsuario'],
											$_SESSION['usuario']['basic_data']['idUsuario'],
											$x_seg,
											$dbConn);
			break;

		}

	echo '</div>';
}

?>

	</div>
</div>
