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
require_once 'core/Load.Utils.Print.php';
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
// Se traen todos los datos de la tarjeta
$query = "SELECT 
card_listado.Nombre AS CardNombre,
card_listado.Direccion_img,
card_listado.idCardImage,
card_listado.idCardType,
card_listado.idPosition

FROM `card_listado`
WHERE card_listado.idCard = ".$_GET['idCard'];
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//variables
	$NombreUsr   = $_SESSION['usuario']['basic_data']['Nombre'];
	$Transaccion = basename($_SERVER["REQUEST_URI"], ".php");

	//generar log
	php_error_log($NombreUsr, $Transaccion, '', mysqli_errno($dbConn), mysqli_error($dbConn), $query );
		
}
$rowCard = mysqli_fetch_assoc ($resultado);

/****************************************************************************/
// consulto los datos
$query = "SELECT 
trabajadores_listado.Direccion_img,
trabajadores_listado.Nombre,
trabajadores_listado.ApellidoPat,
trabajadores_listado.ApellidoMat,
trabajadores_listado.Rut,
core_sexo.Nombre AS Sexo,
trabajadores_listado.FNacimiento,
trabajadores_listado.Fono,
trabajadores_listado.email,
core_sistemas.Nombre AS Sistema				

FROM `trabajadores_listado`
LEFT JOIN `core_sexo`       ON core_sexo.idSexo         = trabajadores_listado.idSexo
LEFT JOIN `core_sistemas`   ON core_sistemas.idSistema  = trabajadores_listado.idSistema
WHERE trabajadores_listado.idTrabajador = ".$_GET['idTrabajador'];
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){

	//variables
	$NombreUsr   = $_SESSION['usuario']['basic_data']['Nombre'];
	$Transaccion = basename($_SERVER["REQUEST_URI"], ".php");

	//generar log
	php_error_log($NombreUsr, $Transaccion, '', mysqli_errno($dbConn), mysqli_error($dbConn), $query );
		
}
$rowTrabajador = mysqli_fetch_assoc ($resultado);

//Tipo Tarjeta
switch ($rowCard['idCardType']) {
	//Tarjeta 3x2
	case 1:
		echo '
		<style>
			#identification_card{
				float:left;
				width:360px;
				height:230px;
				margin:5px;
				border:1px solid black;
				background-image: url("upload/'.$rowCard['Direccion_img'].'");
				background-repeat: no-repeat;
				background-size: 360px 230px;
				-webkit-print-color-adjust: exact;
			}';
		switch ($rowCard['idPosition']) {
			//Texto Izquierda
			case 1:
				echo '	
				#identification_card #card_box{
					margin-top:65px;
					margin-left:120px;
					width:80px;
					height:120px;
				}
				#identification_card #card_box #card_ID{
					width:80px; 
					height:20px;
					padding:5px;

				}
				#identification_card #card_text{
					margin-left:10px;
					float:left;
					width:220px;
					height:200px;
				}
				#identification_card #card_text table{
					margin-top:62px;
				}
				#identification_card #card_text table td{
				   font-size:12px;
				}';
			break;
			//Texto Centro
			case 2:
				echo '	
				#identification_card #card_text{
					margin-left:100px;
					width:220px;
					height:200px;
				}
				#identification_card #card_text table{
					margin-top:62px;
				}
				#identification_card #card_text table td{
				   font-size:12px;
				}';
			break;
			//Texto Derecha
			case 3:
				echo '	
				#identification_card #card_box{
					margin-top:65px;
					margin-left:10px;
					float:left;
					width:80px;
					height:120px;
				}
				#identification_card #card_box #card_ID{
					width:80px; 
					height:20px;
					padding:5px;

				}
				#identification_card #card_text{
					margin-left:120px;
					width:220px;
					height:200px;
				}
				#identification_card #card_text table{
					margin-top:62px;
				}
				#identification_card #card_text table td{
				   font-size:12px;
				}';
			break;

		}
		
			
		echo '	
		</style>
		';
		break;
	//Tarjeta 2x3
	case 2:
		echo '
		<style>
			#identification_card{
				float:left;
				width:230px;
				height:400px;
				margin:5px;
				border:1px solid black;
				background-image: url("upload/'.$rowCard['Direccion_img'].'");
				background-repeat: no-repeat;
				background-size: 230px 400px;
				-webkit-print-color-adjust: exact;
			}';
		switch ($rowCard['idPosition']) {
			//Texto Superior
			case 4:
				echo '	
				#identification_card #card_box{
					margin-top:5px;
					margin-left:70px;
					width:80px;
					height:120px;
				}
				#identification_card #card_box #card_ID{
					width:80px; 
					height:20px;
					padding:5px;

				}
				#identification_card #card_text{
					margin-top:95px;
					margin-left:10px;
					width:220px;
				}
				#identification_card #card_text table{
					margin-top:62px;
				}
				#identification_card #card_text table td{
				   font-size:12px;
				}';
			break;
			//Texto Centro
			case 5:
				echo '	
				#identification_card #card_text{
					margin-left:10px;
					margin-top:160px;
					width:220px;
					height:200px;
				}
				#identification_card #card_text table{
					margin-top:62px;
				}
				#identification_card #card_text table td{
				   font-size:12px;
				}';
			break;
			//Texto Inferior
			case 6:
				echo '	
				#identification_card #card_box{
					margin-top:95px;
					margin-left:70px;
					width:80px;
					height:120px;
				}
				#identification_card #card_box #card_ID{
					width:80px; 
					height:20px;
					padding:5px;

				}
				#identification_card #card_text{
					margin-top:15px;
					margin-left:10px;
					width:220px;
				}
				#identification_card #card_text table td{
				   font-size:12px;
				}';
			break;
			
			
			
		}
		
			
		echo '	
		</style>
		';
		break;
	//Tarjeta 1x3
	case 3:
		echo '
		<style>
			#identification_card{
				float:left;
				width:230px;
				height:500px;
				margin:5px;
				border:1px solid black;
				background-image: url("upload/'.$rowCard['Direccion_img'].'");
				background-repeat: no-repeat;
				background-size: 230px 500px;
				-webkit-print-color-adjust: exact;
			}';
		switch ($rowCard['idPosition']) {
			//Texto Superior
			case 7:
				echo '	
				#identification_card #card_box{
					margin-top:15px;
					margin-left:70px;
					width:80px;
					height:120px;
				}
				#identification_card #card_box #card_ID{
					width:80px; 
					height:20px;
					padding:5px;

				}
				#identification_card #card_text{
					margin-top:145px;
					margin-left:10px;
					width:220px;
				}
				#identification_card #card_text table{
					margin-top:62px;
				}
				#identification_card #card_text table td{
				   font-size:12px;
				}';
			break;
			//Texto Centro
			case 8:
				echo '	
				#identification_card #card_text{
					margin-left:10px;
					margin-top:210px;
					width:220px;
					height:200px;
				}
				#identification_card #card_text table{
					margin-top:62px;
				}
				#identification_card #card_text table td{
				   font-size:12px;
				}';
			break;
			//Texto Inferior
			case 9:
				echo '	
				#identification_card #card_box{
					margin-top:145px;
					margin-left:70px;
					width:80px;
					height:120px;
				}
				#identification_card #card_box #card_ID{
					width:80px; 
					height:20px;
					padding:5px;

				}
				#identification_card #card_text{
					margin-top:15px;
					margin-left:10px;
					width:220px;
				}
				#identification_card #card_text table td{
				   font-size:12px;
				}';
			break;
			
			
			
		}
		
			
		echo '	
		</style>
		';
		break;

}

/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Print.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
$html ='
	<div id="identification_card">';

		if ($rowCard['idPosition']==1 OR $rowCard['idPosition']==4 OR $rowCard['idPosition']==7 OR $rowCard['idPosition']==2 OR $rowCard['idPosition']==5 OR $rowCard['idPosition']==8) {
			$html .= '
			<div id="card_text">
				<table>
					<tr><td><strong>Nombre</strong></td><td><strong>: '.$rowTrabajador['Nombre'].' '.$rowTrabajador['ApellidoPat'].' '.$rowTrabajador['ApellidoMat'].'</strong></td></tr>
					<tr><td><strong>Rut</strong></td><td>: '.$rowTrabajador['Rut'].'</td></tr>
					<tr><td><strong>Sexo</strong></td><td>: '.$rowTrabajador['Sexo'].'</td></tr>
					<tr><td><strong>Fono</strong></td><td>: '.formatPhone($rowTrabajador['Fono']).'</td></tr>
					<tr><td><strong>Email</strong></td><td>: '.$rowTrabajador['email'].'</td></tr>
				</table>
			</div>';
		}
		
		if (isset($rowCard['idCardImage'])&&$rowCard['idCardImage']==1) {
			if ($rowCard['idPosition']!=2 && $rowCard['idPosition']!=5 && $rowCard['idPosition']!=8) {
				$html .= '<div id="card_box">';
					if ($rowTrabajador['Direccion_img']=='') {
						$html .= '<img width="80px" height="100px" style="border:1px solid black;" src="'.DB_SITE_REPO.'/LIB_assets/img/usr.png"><br/>';
					}else{
						$html .= '<img width="80px" height="100px" style="border:1px solid black;"  src="upload/'.$rowTrabajador['Direccion_img'].'"><br/>';
					}
					$html .= '
					<div id="card_ID">
						ID : '.n_doc($_GET['idTrabajador'],5).'
					</div>
				</div>';
			}
		}
		
		if ($rowCard['idPosition']==3 OR $rowCard['idPosition']==6 OR $rowCard['idPosition']==9) {
			$html .= '
			<div id="card_text">
				<table>
					<tr><td><strong>Nombre</strong></td><td><strong>: '.$rowTrabajador['Nombre'].' '.$rowTrabajador['ApellidoPat'].' '.$rowTrabajador['ApellidoMat'].'</strong></td></tr>
					<tr><td><strong>Rut</strong></td><td>: '.$rowTrabajador['Rut'].'</td></tr>
					<tr><td><strong>Sexo</strong></td><td>: '.$rowTrabajador['Sexo'].'</td></tr>
					<tr><td><strong>Fono</strong></td><td>: '.formatPhone($rowTrabajador['Fono']).'</td></tr>
					<tr><td><strong>Email</strong></td><td>: '.$rowTrabajador['email'].'</td></tr>
				</table>
			</div>';
		}
	$html .= '</div>';


echo $html;
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Print.php';

?>
