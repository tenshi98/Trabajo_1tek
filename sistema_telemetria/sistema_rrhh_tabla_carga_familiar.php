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
$original = "sistema_rrhh_tabla_carga_familiar.php";
$location = $original;
/********************************************************************/
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para editar
if (!empty($_POST['submit_edit'])){
	//Llamamos al formulario
	$form_trabajo= 'update';
	require_once 'A1XRXS_sys/xrxs_form/z_sistema_rrhh_tabla_carga_familiar.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Carga Familiar Creada correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Carga Familiar Modificada correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Carga Familiar Borrada correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['id'])){
//valido los permisos
validaPermisoUser($rowlevel['level'], 2, $dbConn);
// consulto los datos
$query = "SELECT Tramo,Valor_Desde,Valor_Hasta,Valor_Pago
FROM `sistema_rrhh_tabla_carga_familiar`
WHERE idTablaCarga = ".$_GET['id'];
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
$rowData = mysqli_fetch_assoc ($resultado);	?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Modificación de la Carga Familiar</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($Tramo)){         $x1  = $Tramo;           }else{$x1  = $rowData['Tramo'];}
				if(isset($Valor_Desde)){   $x2  = $Valor_Desde;     }else{$x2  = $rowData['Valor_Desde'];}
				if(isset($Valor_Hasta)){   $x3  = $Valor_Hasta;     }else{$x3  = $rowData['Valor_Hasta'];}
				if(isset($Valor_Pago)){    $x4  = $Valor_Pago;      }else{$x4  = $rowData['Valor_Pago'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_input_text('Tramo', 'Tramo', $x1, 2);
				$Form_Inputs->form_values('Valor Desde', 'Valor_Desde', $x2, 1);
				$Form_Inputs->form_values('Valor Hasta', 'Valor_Hasta', $x3, 2);
				$Form_Inputs->form_values('Valor Pago', 'Valor_Pago', $x4, 1);

				$Form_Inputs->form_input_hidden('idTablaCarga', $_GET['id'], 2);
				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edit">
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
$arrAmonestacion = array();
$query = "SELECT idTablaCarga,Tramo, Valor_Desde, Valor_Hasta, Valor_Pago
FROM `sistema_rrhh_tabla_carga_familiar`";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrAmonestacion,$row );
} ?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Tramos Cargas Familiares</h5>
		</header>
		<div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th>Tramo</th>
						<th>Desde</th>
						<th>Hasta</th>
						<th>Valor a pagar por carga</th>
						<th width="10">Acciones</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
				<?php foreach ($arrAmonestacion as $amon) { ?>
					<tr class="odd">
						<td><?php echo $amon['Tramo']; ?></td>
						<td align="right"><?php echo valores($amon['Valor_Desde'], 0); ?></td>
						<td align="right"><?php echo valores($amon['Valor_Hasta'], 0); ?></td>
						<td align="right"><?php echo valores($amon['Valor_Pago'], 0); ?></td>
						<td>
							<div class="btn-group" style="width: 35px;" >
								<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'?id='.$amon['idTablaCarga']; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
							</div>
						</td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
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
