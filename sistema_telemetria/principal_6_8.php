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
$original = "principal.php";
$location = $original;
//oculto el menu
$_SESSION['menu'] = 2;
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//consultas anidadas, se utiliza las variables anteriores para consultar cada permiso
$SIS_query = 'idOpcionesGen_6';
$SIS_where = 'idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
$n_permisos = db_select_data (false, $SIS_query, 'core_sistemas','', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'n_permisos');
/************************************************************************************/
//variable de numero de permiso
$x_nperm = 0;

//CrossCheking
$x_nperm++; $trans[$x_nperm] = "cross_solicitud_aplicacion_crear.php";          //01 - Solicitud Aplicacion - 01 Crear
$x_nperm++; $trans[$x_nperm] = "cross_solicitud_aplicacion_ejecutar.php";       //02 - Solicitud Aplicacion - 02 Programar
$x_nperm++; $trans[$x_nperm] = "cross_solicitud_aplicacion_ejecucion.php";      //03 - Solicitud Aplicacion - 03 Cerrar
$x_nperm++; $trans[$x_nperm] = "cross_solicitud_aplicacion_terminar.php";       //04 - Solicitud Aplicacion - 04 Verificar cierre
$x_nperm++; $trans[$x_nperm] = "cross_solicitud_aplicacion_borrar.php";         //05 - Solicitud Aplicacion - Borrar
$x_nperm++; $trans[$x_nperm] = "informe_cross_checking_06.php";                 //06 - 1 - Informe resumen de aplicaciones
$x_nperm++; $trans[$x_nperm] = "informe_cross_checking_05.php";                 //07 - 2 - Resumen Ejecutivo de aplicaciones
$x_nperm++; $trans[$x_nperm] = "informe_cross_checking_04.php";                 //08 - 3 - Trazabilidad y homogeneidad de aplicación
$x_nperm++; $trans[$x_nperm] = "informe_cross_checking_02.php";                 //09 - 4 - Informe monitoreo de dispositivos
$x_nperm++; $trans[$x_nperm] = "informe_cross_checking_01.php";                 //10 - 5 - Listado solicitudes de aplicaciones
$x_nperm++; $trans[$x_nperm] = "informe_cross_checking_03.php";                 //11 - 6 - Cuaderno de Campo - Exportador datos
$x_nperm++; $trans[$x_nperm] = "cross_checking_monitor_aplicaciones.php";       //12 - Monitor de Aplicaciones

//1Tek C
$x_nperm++; $trans[$x_nperm] = "informe_telemetria_errores_2.php";              //13 - Alerta Sensores
$x_nperm++; $trans[$x_nperm] = "informe_telemetria_registro_sensores_4.php";    //14 - Exportar Datos
$x_nperm++; $trans[$x_nperm] = "informe_telemetria_fuera_linea_2.php";          //15 - Fuera de Linea
$x_nperm++; $trans[$x_nperm] = "informe_telemetria_registro_promedios_4.php";   //16 - Max – Min Camara
$x_nperm++; $trans[$x_nperm] = "informe_telemetria_registro_promedios_2.php";   //17 - Max – Min Sensor
$x_nperm++; $trans[$x_nperm] = "informe_telemetria_registro_promedios_6.php";   //18 - Promedio Diario
$x_nperm++; $trans[$x_nperm] = "informe_telemetria_registro_sensores_6.php";    //19 - Registro Camara
$x_nperm++; $trans[$x_nperm] = "informe_telemetria_registro_sensores_2.php";    //20 - Registro Sensores
$x_nperm++; $trans[$x_nperm] = "informe_telemetria_registro_sensores_12.php";   //21 - Trazabilidad

//CrossTrack
$x_nperm++; $trans[$x_nperm] = "informe_telemetria_errores_1.php";              //22 - Alerta Sensores
$x_nperm++; $trans[$x_nperm] = "informe_telemetria_detenciones.php";            //23 - Detenciones
$x_nperm++; $trans[$x_nperm] = "informe_telemetria_fuera_linea_1.php";          //24 - Fuera de Linea
$x_nperm++; $trans[$x_nperm] = "informe_telemetria_fuera_geocerca_1.php";       //25 - Fuera de Linea
$x_nperm++; $trans[$x_nperm] = "informe_telemetria_registro_kilometraje.php";   //26 - Kilometros Recorridos
$x_nperm++; $trans[$x_nperm] = "informe_telemetria_registro_promedios_3.php";   //27 - Max – Min Camara
$x_nperm++; $trans[$x_nperm] = "informe_telemetria_registro_promedios_1.php";   //28 - Max – Min Sensor
$x_nperm++; $trans[$x_nperm] = "informe_telemetria_registro_promedios_5.php";   //29 - Promedio Diario
$x_nperm++; $trans[$x_nperm] = "informe_telemetria_registro_sensores_5.php";    //30 - Registro Camara
$x_nperm++; $trans[$x_nperm] = "informe_telemetria_registro_sensores_1.php";    //31 - Registro Sensores
$x_nperm++; $trans[$x_nperm] = "informe_telemetria_registro_ruta.php";          //32 - Rutas Realizadas
$x_nperm++; $trans[$x_nperm] = "informe_telemetria_registro_sensores_11.php";   //33 - Trazabilidad
$x_nperm++; $trans[$x_nperm] = "informe_telemetria_registro_velocidad.php";     //34 - Velocidad
$x_nperm++; $trans[$x_nperm] = "informe_telemetria_registro_sensores_3.php";    //35 - Exportar Datos

//Agro-Weather
$x_nperm++; $trans[$x_nperm] = "informe_telemetria_registro_sensores_13.php";   //36 - Exportar Datos

//Power-Crane
$x_nperm++; $trans[$x_nperm] = "informe_telemetria_activaciones_05.php";        //37 - Activaciones Trabajo
$x_nperm++; $trans[$x_nperm] = "informe_telemetria_uso_03.php";                 //38 - Uso Equipos
$x_nperm++; $trans[$x_nperm] = "informe_telemetria_uso_04.php";                 //39 - Tiempo Motores
$x_nperm++; $trans[$x_nperm] = "informe_telemetria_registro_sensores_17.php";   //40 - Trazabilidad Camara
$x_nperm++; $trans[$x_nperm] = "informe_telemetria_errores_6.php";              //41 - Alerta Sensores

//Power-Energy
$x_nperm++; $trans[$x_nperm] = "informe_telemetria_errores_7.php";              //42 - Alerta Sensores
$x_nperm++; $trans[$x_nperm] = "informe_telemetria_registro_sensores_18.php";   //43 - Trazabilidad Sensor
$x_nperm++; $trans[$x_nperm] = "informe_telemetria_registro_sensores_19.php";   //44 - Trazabilidad Grupo
$x_nperm++; $trans[$x_nperm] = "informe_crossenergy_01.php";                    //45 - Resumen Dia
$x_nperm++; $trans[$x_nperm] = "informe_crossenergy_02.php";                    //46 - Resumen Hora


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

/*Agro-Checking*/   $Tab_1 = $prm_x[1] + $prm_x[2] + $prm_x[3] + $prm_x[4] + $prm_x[5] + $prm_x[6] + $prm_x[7] + $prm_x[8] + $prm_x[9] + $prm_x[10] + $prm_x[11] + $prm_x[12];
/*1Tek C*/          $Tab_2 = $prm_x[13] + $prm_x[14] + $prm_x[15] + $prm_x[16] + $prm_x[17] + $prm_x[18] + $prm_x[19] + $prm_x[20] + $prm_x[21];
/*CrossTrack*/      $Tab_3 = $prm_x[22] + $prm_x[23] + $prm_x[24] + $prm_x[25] + $prm_x[26] + $prm_x[27] + $prm_x[28] + $prm_x[29] + $prm_x[30] + $prm_x[31] + $prm_x[32] + $prm_x[33] + $prm_x[34] + $prm_x[35];
/*Agro-Weather*/    $Tab_4 = $prm_x[36];
/*CrossWater*/      $Tab_5 = 0;
/*Power-Crane*/      $Tab_6 = $prm_x[37] + $prm_x[38] + $prm_x[39] + $prm_x[40] + $prm_x[41];
/*Power-Energy*/     $Tab_7 = $prm_x[42] + $prm_x[43] + $prm_x[44] + $prm_x[45] + $prm_x[46];

/************************************************************************************/
// Listado con los nombres del tab
$arrTabMenu = array();
$arrTabMenu = db_select_array (false, 'idTab, Nombre', 'core_telemetria_tabs', '', '', 'Nombre ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTabMenu');
//Recorro
foreach ($arrTabMenu as $tab) {
	$arrOrderTabMenu[$tab['idTab']] = $tab['Nombre'];
}
/*****************************************************************************************************************/
/*                                                Modelado                                                       */
/*****************************************************************************************************************/
?>
<style>
.noborderbox{border: none!important;-webkit-box-shadow: none!important;box-shadow: none!important;}
.noborderbox .header {background-color: #fff!important;color: #333!important;border-color: #ddd!important;}
.noborderbox .header .nav-tabs {border-bottom: 1px solid #ddd!important;}
.noborderbox .header .nav-tabs > li.active > a{color: #333 !important;border-color: #ddd!important;border-bottom-color: transparent!important;}
.noborderbox .header .nav-tabs > li > a {color: #ffffff !important;}
.noborderbox .header .nav-tabs > li > a:hover, .noborderbox .header .nav-tabs > li > a:focus {color: #fff !important;background-color: rgba(0, 0, 0, 0.4);}
.noborderbox .header .nav-tabs > li.active > a:hover, .noborderbox .header .nav-tabs > li.active > a:focus{color: #333 !important;}
</style>

<div class="">
	<div class="box noborderbox">
		<header class="header">
			<ul class="nav nav-tabs nav-center">
				<li>                        <a href="principal.php">Inicio</a></li>
				<?php if($Tab_2!=0){ ?><li> <a href="principal_6_2.php"><?php echo $arrOrderTabMenu[2]; ?></a></li><?php } ?>
				<?php if($Tab_1!=0){ ?><li> <a href="principal_6_1.php"><?php echo $arrOrderTabMenu[1]; ?></a></li><?php } ?>
				<?php if($Tab_6!=0){ ?><li> <a href="principal_6_6.php"><?php echo $arrOrderTabMenu[6]; ?></a></li><?php } ?>
				<?php if($Tab_3!=0){ ?><li> <a href="principal_6_3.php"><?php echo $arrOrderTabMenu[3]; ?></a></li><?php } ?>
				<?php if($Tab_5!=0){ ?><li> <a href="principal_6_5.php"><?php echo $arrOrderTabMenu[5]; ?></a></li><?php } ?>
				<?php if($Tab_4!=0){ ?><li> <a href="principal_6_4.php"><?php echo $arrOrderTabMenu[4]; ?></a></li><?php } ?>
				<?php if($Tab_7!=0){ ?><li> <a href="principal_6_7.php"><?php echo $arrOrderTabMenu[9]; ?></a></li><?php } ?>
			</ul>
		</header>
		<div class="tab-content">
			<script type = "text/javascript">
				//se desactiva el boton f5
				window.onload = function () {
					document.onkeydown = function (e) {
						return (e.which || e.keyCode) != 116;
					};
				}
			</script>
			 
			<?php
				//Se dibuja el explorador de archivos
				echo file_explorer(1, 'connector_tutoriales', DB_SITE_MAIN_PATH, $_SESSION['usuario']['basic_data']['idSistema'], 1); ?>


			
		</div>
	</div>
</div>

<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';

?>
