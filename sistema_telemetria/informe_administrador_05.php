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
$original = "informe_administrador_05.php";
$location = $original;
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
?>

<script type="text/javascript">
    var int = self.setInterval("refresh()",60000);
    function refresh()
    {
       location.reload(true);
    }
</script>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

             
  

/*****************************************************************************************************************/
/*                                   Conexxiones a las bases de datos                              */
/*****************************************************************************************************************/
//Funcion para conectarse
function conectarDB ($servidor, $usuario, $password, $base_datos) {
	$db_con = mysqli_connect($servidor, $usuario, $password, $base_datos);
	$db_con->set_charset("utf8");
	return $db_con;
}

//Bases de Datos
$BasesDatos = array();
$BasesDatos[1] = 'crosstech_pe_intranet';

$DB_Servidor = 'localhost';
$DB_Usuario  = 'crosstech_admin';
$DB_Pass     = '&-VSda,#rFvT';

//Conexiones
$dbConn1 = conectarDB($DB_Servidor, $DB_Usuario, $DB_Pass, $BasesDatos[1]);

/*****************************************************************************************************************/
/*                                   Visualizacion de los widget de geolocalizacion                              */
/*****************************************************************************************************************/

echo '<h3 class="supertittle text-primary">Aerosan</h3>';
//Variables
$arreglo = array();
$arreglo[1] = 'si'; //recorrerlo
$arreglo[2] = 'hhttps://clientes.1tek.cl/upload/'; //carpeta de imagenes del sitio
//Se llama a los widget
echo widget_Equipos('Equipo', 2, 0,'#', 1, 1, 1, $dbConn1);
echo widget_Resumen_equipo('Ultimas Mediciones del equipo', 2, 0, $arreglo[2], 1, 1, 1, $dbConn1);
/*****************************************************************************************************************/


?>           
<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';

?>
