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
$original = "trabajadores_card_generator.php";
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
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['submit_filter'])){
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
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
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

	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
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

?>

<div class="row no-print">
	<div class="col-xs-12">
		<a target="new" href="trabajadores_card_generator_to_print.php<?php echo '?idTrabajador='.$_GET['idTrabajador'].'&idCard='.$_GET['idCard'] ?>" class="btn btn-default pull-right" style="margin-right: 5px;">
			<i class="fa fa-print" aria-hidden="true"></i> Imprimir
		</a>
	</div>
</div>
   


 
<div id="identification_card" class="fcenter">

	<?php if ($rowCard['idPosition']==1 OR $rowCard['idPosition']==4 OR $rowCard['idPosition']==7 OR $rowCard['idPosition']==2 OR $rowCard['idPosition']==5 OR $rowCard['idPosition']==8) { ?>
		<div id="card_text">
			<table>
				<tr><td><strong>Nombre</strong></td><td><strong>: <?php echo $rowTrabajador['Nombre'].' '.$rowTrabajador['ApellidoPat'].' '.$rowTrabajador['ApellidoMat']; ?></strong></td></tr>
				<tr><td><strong>Rut</strong></td><td>: <?php echo $rowTrabajador['Rut']; ?></td></tr>
				<tr><td><strong>Sexo</strong></td><td>: <?php echo $rowTrabajador['Sexo']; ?></td></tr>
				<tr><td><strong>Fono</strong></td><td>: <?php echo formatPhone($rowTrabajador['Fono']); ?></td></tr>
				<tr><td><strong>Email</strong></td><td>: <?php echo $rowTrabajador['email']; ?></td></tr>
			</table> 
		</div>
	<?php } ?>

	<?php if (isset($rowCard['idCardImage'])&&$rowCard['idCardImage']==1) { ?>
		<?php if ($rowCard['idPosition']!=2 && $rowCard['idPosition']!=5 && $rowCard['idPosition']!=8) { ?>
			<div id="card_box">
				<?php if ($rowTrabajador['Direccion_img']=='') { ?>
					<img width="80px" height="100px" style="border:1px solid black;" src="<?php echo DB_SITE_REPO ?>/LIB_assets/img/usr.png"><br/>
				<?php }else{  ?>
					<img width="80px" height="100px" style="border:1px solid black;"  src="upload/<?php echo $rowTrabajador['Direccion_img']; ?>"><br/>
				<?php } ?>		
				<div id="card_ID">
					ID : <?php echo n_doc($_GET['idTrabajador'],5); ?>
				</div>
			</div>
		<?php } ?>
	<?php } ?>

	<?php if ($rowCard['idPosition']==3 OR $rowCard['idPosition']==6 OR $rowCard['idPosition']==9) { ?>
		<div id="card_text">
			<table>
				<tr><td><strong>Nombre</strong></td><td><strong>: <?php echo $rowTrabajador['Nombre'].' '.$rowTrabajador['ApellidoPat'].' '.$rowTrabajador['ApellidoMat']; ?></strong></td></tr>
				<tr><td><strong>Rut</strong></td><td>: <?php echo $rowTrabajador['Rut']; ?></td></tr>
				<tr><td><strong>Sexo</strong></td><td>: <?php echo $rowTrabajador['Sexo']; ?></td></tr>
				<tr><td><strong>Fono</strong></td><td>: <?php echo formatPhone($rowTrabajador['Fono']); ?></td></tr>
				<tr><td><strong>Email</strong></td><td>: <?php echo $rowTrabajador['email']; ?></td></tr>
			</table> 
		</div>
	<?php } ?>
</div>

<div class="clearfix"></div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
	<a href="<?php echo $location ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
	<div class="clearfix"></div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
//Verifico el tipo de usuario que esta ingresando
$z = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
 ?>
<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Filtro de Búsqueda</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idTrabajador)){  $x1  = $idTrabajador;  }else{$x1  = '';}
				if(isset($idCard)){        $x2  = $idCard;        }else{$x2  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_filter('Trabajador','idTrabajador', $x1, 2, 'idTrabajador', 'Rut,Nombre,ApellidoPat,ApellidoMat', 'trabajadores_listado', $z, '', $dbConn);
				$Form_Inputs->form_select_filter('Tarjeta','idCard', $x2, 2, 'idCard', 'Nombre', 'card_listado', 0, '', $dbConn);

				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf002; Filtrar" name="submit_filter">
				</div>
			</form>
			<?php widget_validator(); ?>
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
