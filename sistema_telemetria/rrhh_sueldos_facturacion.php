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
$original = "rrhh_sueldos_facturacion.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['idTrabajador']) && $_GET['idTrabajador']!=''){     $location .= "&idTrabajador=".$_GET['idTrabajador'];     $search .= "&idTrabajador=".$_GET['idTrabajador'];}
if(isset($_GET['N_Doc']) && $_GET['N_Doc']!=''){            $location .= "&N_Doc=".$_GET['N_Doc'];                   $search .= "&N_Doc=".$_GET['N_Doc'];}
if(isset($_GET['Observaciones']) && $_GET['Observaciones']!=''){   $location .= "&Observaciones=".$_GET['Observaciones'];   $search .= "&Observaciones=".$_GET['Observaciones'];}
/********************************************************************/
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para crear
if (!empty($_POST['submit'])){
	//Llamamos al formulario
	$form_trabajo= 'new_ingreso';
	require_once 'A1XRXS_sys/xrxs_form/z_rrhh_sueldos_facturacion.php';
}
//formulario para editar
if (!empty($_POST['submit_modBase'])){
	//Llamamos al formulario
	$form_trabajo= 'modBase_ing';
	require_once 'A1XRXS_sys/xrxs_form/z_rrhh_sueldos_facturacion.php';
}
//formulario para editar
if (!empty($_GET['clear_all'])){
	//Llamamos al formulario
	$form_trabajo= 'clear_all_ing';
	require_once 'A1XRXS_sys/xrxs_form/z_rrhh_sueldos_facturacion.php';
}
/**********************************************/
if (!empty($_GET['del_trab'])){
	//Llamamos al formulario
	$form_trabajo= 'del_trab';
	require_once 'A1XRXS_sys/xrxs_form/z_rrhh_sueldos_facturacion.php';
}
/**********************************************/
//formulario para crear
if (!empty($_POST['submit_file'])){
	//Llamamos al formulario
	$form_trabajo= 'new_file';
	require_once 'A1XRXS_sys/xrxs_form/z_rrhh_sueldos_facturacion.php';
}
//se borra un dato
if (!empty($_GET['del_file'])){
	//Llamamos al formulario
	$form_trabajo= 'del_file';
	require_once 'A1XRXS_sys/xrxs_form/z_rrhh_sueldos_facturacion.php';
}
/**********************************************/
if (!empty($_GET['ing_sueldo'])){
	//Llamamos al formulario
	$form_trabajo= 'ing_sueldo';
	require_once 'A1XRXS_sys/xrxs_form/z_rrhh_sueldos_facturacion.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Facturacion de Sueldos Realizada correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Facturacion de Sueldos Modificada correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Facturacion de Sueldos Borrada correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['details'])){
// Se traen todos los datos del proveedor
$query = "SELECT  fecha_auto, Creacion_fecha, Fecha_desde, Fecha_hasta, Observaciones, 
UF, UTM, IMM, TopeImpAFP, TopeImpIPS, TopeSegCesantia, TopeAPVMensual, TopeDepConv
FROM `rrhh_sueldos_facturacion`
WHERE idFacturacion = ".$_GET['details'];
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
$rowData = mysqli_fetch_assoc ($resultado);
// Se trae un listado con todos los trabajadores
$arrTrabajador = array();
$query = "SELECT  idFactTrab, TrabajadorNombre,TrabajadorRut, TotalHaberes,
TotalDescuentos, TotalAPagar, CentroCosto
FROM `rrhh_sueldos_facturacion_trabajadores`
WHERE idFacturacion = ".$_GET['details'];
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrTrabajador,$row );
}	
// Se trae un listado con todos los archivos
$arrArchivos = array();
$query = "SELECT Nombre
FROM `rrhh_sueldos_facturacion_archivos`
WHERE idFacturacion = ".$_GET['details'];
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrArchivos,$row );
}

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

	<div id="page-wrap">
		<div id="header"> Facturacion Sueldos</div>

		<div id="customer">

			<table id="meta" class="pull-left otdata">
				<tbody>
					<tr>
						<td class="meta-head"><strong>DATOS BASICOS</strong></td>
						<td class="meta-head"></td>
					</tr>
					<tr>
						<td class="meta-head">Periodo Desde</td>
						<td><?php echo Fecha_estandar($rowData['Fecha_desde']); ?></td>
					</tr>
					<tr>
						<td class="meta-head">Periodo Hasta</td>
						<td><?php echo Fecha_estandar($rowData['Fecha_hasta']); ?></td>
					</tr>
					<tr>
						<td class="meta-head"><strong>INDICES</strong></td>
						<td class="meta-head"></td>
					</tr>
					<tr>
						<td class="meta-head">UF</td>
						<td align="right"><?php echo Valores($rowData['UF'], 2) ?></td>
					</tr>
					<tr>
						<td class="meta-head">UTM</td>
						<td align="right"><?php echo Valores($rowData['UTM'], 2) ?></td>
					</tr>
					<tr>
						<td class="meta-head">Renta Minima</td>
						<td align="right"><?php echo Valores($rowData['IMM'], 2) ?></td>
					</tr>
					<tr>
						<td class="meta-head">Tope Imponible AFP</td>
						<td align="right"><?php echo Valores($rowData['TopeImpAFP'], 2) ?></td>
					</tr>
					<tr>
						<td class="meta-head">Tope Imponible IPS</td>
						<td align="right"><?php echo Valores($rowData['TopeImpIPS'], 2) ?></td>
					</tr>
					<tr>
						<td class="meta-head">Tope Seguro Cesantia</td>
						<td align="right"><?php echo Valores($rowData['TopeSegCesantia'], 2) ?></td>
					</tr>
						<td class="meta-head">Tope APV Mensual</td>
						<td align="right"><?php echo Valores($rowData['TopeAPVMensual'], 2) ?></td>
					</tr>
						<td class="meta-head">Tope Deposito Convenido</td>
						<td align="right"><?php echo Valores($rowData['TopeDepConv'], 2) ?></td>
					</tr>
				</tbody>
			</table>
			<table id="meta" class="otdata2">
				<tbody>
					<tr>
						<td class="meta-head">Fecha Creacion</td>
						<td colspan="2"><?php echo Fecha_estandar($rowData['fecha_auto']); ?></td>
					</tr>
					<tr>
						<td class="meta-head">Fecha Facturacion</td>
						<td colspan="2"><?php echo Fecha_estandar($rowData['Creacion_fecha']); ?></td>
					</tr>
				</tbody>
			</table>

				
		</div>

			<table id="items">
				<tbody>

					<tr>
						<th colspan="5">Detalle</th>
						<th width="10">Acciones</th>
					</tr>

					<tr class="item-row fact_tittle">
						<td>Nombre</td>
						<td width="120">Rut</td>
						<td width="120">Alcance Liquido</td>
						<td width="120">Total Deberes</td>
						<td width="120">Total a Pagar</td>
						<td width="10">Acciones</td>
					</tr>
					<?php foreach ($arrTrabajador as $producto){ ?>
						<tr>
							<td class="blank">
								<?php 
								echo $producto['TrabajadorNombre'];
								if(isset($producto['CentroCosto'])&&$producto['CentroCosto']!=''){
									echo '<br/><strong>Centro de Costo: </strong>'.$producto['CentroCosto'];
								}
								?>
							</td>
							<td class="blank"><?php echo $producto['TrabajadorRut']; ?></td>
							<td class="blank" align="right"><?php echo valores($producto['TotalHaberes'], 0); ?></td>
							<td class="blank" align="right"><?php echo valores($producto['TotalDescuentos'], 0); ?></td>
							<td class="blank" align="right"><?php echo valores($producto['TotalAPagar'], 0); ?></td>
							<td class="blank">
								<div class="btn-group" style="width: 35px;" >
									<a href="<?php echo 'view_rrhh_sueldos.php?view='.simpleEncode($producto['idFactTrab'], fecha_actual()); ?>" title="Ver Documento" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
								</div>
							</td>
						<tr>
					<?php } ?>
					

				</tbody>
			</table>
		
		
    </div>

    <div class="col-xs-12">
		<div class="row">
			<p class="lead"><a name="Ancla_obs"></a>Observaciones:</p>
			<p class="text-muted well well-sm no-shadow" ><?php echo $rowData['Observaciones']; ?></p>
		</div>
	</div>
	
    <table id="items" style="margin-bottom: 20px;">
        <tbody>

			<tr class="invoice-total" bgcolor="#f1f1f1">
                <td colspan="5">Archivos Adjuntos</td>
                <td width="160"></td>
            </tr>

			<?php foreach ($arrArchivos as $producto){ ?>
				<tr class="item-row">
					<td colspan="5"><?php echo $producto['Nombre']; ?></td>
					<td>
						<div class="btn-group" style="width: 35px;" >
							<a href="<?php echo 'view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($producto['Nombre'], fecha_actual()); ?>" title="Ver Documento" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
						</div>
					</td>
				</tr>
					 
			<?php } ?>

		</tbody>
    </table>

</div>
 



<div class="clearfix"></div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
	<a href="<?php echo $location ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
	<div class="clearfix"></div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['addFile'])){ ?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Subir Archivo</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" enctype="multipart/form-data" autocomplete="off" novalidate>

				<?php
				//Se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_multiple_upload('Seleccionar archivo','exFile', 1, '"jpg", "png", "gif", "jpeg", "doc", "docx", "xls", "xlsx", "ppt", "pptx", "pdf"');

				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_file">
					<a href="<?php echo $location.'&view=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['modBase'])){ ?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<a target="_blank" rel="noopener noreferrer" href="https://www.previred.com/web/previred/indicadores-previsionales" class="btn btn-default pull-right margin_width" ><i class="fa fa-search" aria-hidden="true"></i> Indicadores Previsionales</a>
</div>
<div class="clearfix"></div>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Modificar datos basicos del Ingreso</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				if(isset($Creacion_fecha)){  $x1  = $Creacion_fecha;     }else{$x1  = $_SESSION['fact_sueldos_basicos']['Creacion_fecha'];}
				if(isset($Fecha_desde)){     $x2  = $Fecha_desde;        }else{$x2  = $_SESSION['fact_sueldos_basicos']['Fecha_desde'];}
				if(isset($Fecha_hasta)){     $x3  = $Fecha_hasta;        }else{$x3  = $_SESSION['fact_sueldos_basicos']['Fecha_hasta'];}
				if(isset($UF)){              $x4  = $UF;                 }else{$x4  = $_SESSION['fact_sueldos_basicos']['UF'];}
				if(isset($UTM)){             $x5  = $UTM;                }else{$x5  = $_SESSION['fact_sueldos_basicos']['UTM'];}
				if(isset($IMM)){             $x6  = $IMM;                }else{$x6  = $_SESSION['fact_sueldos_basicos']['IMM'];}
				if(isset($TopeImpAFP)){      $x7  = $TopeImpAFP;         }else{$x7  = $_SESSION['fact_sueldos_basicos']['TopeImpAFP'];}
				if(isset($TopeImpIPS)){      $x8  = $TopeImpIPS;         }else{$x8  = $_SESSION['fact_sueldos_basicos']['TopeImpIPS'];}
				if(isset($TopeSegCesantia)){ $x9  = $TopeSegCesantia;    }else{$x9  = $_SESSION['fact_sueldos_basicos']['TopeSegCesantia'];}
				if(isset($TopeAPVMensual)){  $x10 = $TopeAPVMensual;     }else{$x10 = $_SESSION['fact_sueldos_basicos']['TopeAPVMensual'];}
				if(isset($TopeDepConv)){     $x11 = $TopeDepConv;        }else{$x11 = $_SESSION['fact_sueldos_basicos']['TopeDepConv'];}
				if(isset($Observaciones)){   $x12 = $Observaciones;      }else{$x12 = $_SESSION['fact_sueldos_basicos']['Observaciones'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_tittle(3, 'Datos Facturacion');
				$Form_Inputs->form_date('Fecha Facturacion','Creacion_fecha', $x1, 2);
				$Form_Inputs->form_date('Periodo Inicio','Fecha_desde', $x2, 2);
				$Form_Inputs->form_date('Periodo Termino','Fecha_hasta', $x3, 2);

				$Form_Inputs->form_tittle(3, 'Indicadores');
				$Form_Inputs->form_input_number('UF', 'UF', $x4, 2);
				$Form_Inputs->form_input_number('UTM', 'UTM', $x5, 2);
				$Form_Inputs->form_input_number('Renta Minima', 'IMM', $x6, 2);

				$Form_Inputs->form_tittle(3, 'Topes Legales');
				$Form_Inputs->form_input_number('Tope Imponible AFP', 'TopeImpAFP', $x7, 2);
				$Form_Inputs->form_input_number('Tope Imponible IPS', 'TopeImpIPS', $x8, 2);
				$Form_Inputs->form_input_number('Tope Seguro Cesantia', 'TopeSegCesantia', $x9, 2);
				$Form_Inputs->form_input_number('Tope APV Mensual', 'TopeAPVMensual', $x10, 2);
				$Form_Inputs->form_input_number('Tope Deposito Convenido', 'TopeDepConv', $x11, 2);

				$Form_Inputs->form_textarea('Observaciones','Observaciones', $x12, 1);

				$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_modBase">
					<a href="<?php echo $location.'&view=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['view'])){ ?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
	<div class="btn-group pull-right" role="group" aria-label="...">

		<?php
		$ubicacion = $location.'&clear_all=true';
		$dialogo   = '¿Realmente deseas eliminar todos los registros?'; ?>
		<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" class="btn btn-danger dialogBox"><i class="fa fa-trash-o" aria-hidden="true"></i> Borrar Todo</a>

		<a href="<?php echo $location; ?>"  class="btn btn-danger"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>

		<?php
		$ubicacion = $location.'&view=true&ing_sueldo=true';
		$dialogo   = '¿Realmente desea ingresar el documento, una vez realizada no podra realizar cambios?'; ?>
		<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" class="btn btn-primary" ><i class="fa fa-check-square-o" aria-hidden="true"></i> Ingresar Documento</a>

	</div>
	<div class="clearfix"></div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

	<div id="page-wrap">
		<div id="header"> Facturacion Sueldos</div>

		<div id="customer">

			<table id="meta" class="pull-left otdata">
				<tbody>
					<tr>
						<td class="meta-head"><strong>DATOS BASICOS</strong></td>
						<td class="meta-head"><a href="<?php echo $location.'&modBase=true' ?>" title="Modificar Datos Básicos" class="btn btn-xs btn-primary tooltip pull-right" style="position: initial;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Modificar</a></td>
					</tr>
					<tr>
						<td class="meta-head">Periodo Desde</td>
						<td><?php echo Fecha_estandar($_SESSION['fact_sueldos_basicos']['Fecha_desde']); ?></td>
					</tr>
					<tr>
						<td class="meta-head">Periodo Hasta</td>
						<td><?php echo Fecha_estandar($_SESSION['fact_sueldos_basicos']['Fecha_hasta']); ?></td>
					</tr>
				</tbody>
			</table>
			<table id="meta" class="otdata2">
				<tbody>
					<tr>
						<td class="meta-head">Fecha Facturacion</td>
						<td colspan="2"><?php echo Fecha_estandar($_SESSION['fact_sueldos_basicos']['Creacion_fecha']); ?></td>
					</tr>
				</tbody>
			</table>

				
		</div>

			<table id="items">
				<tbody>

					<tr>
						<th colspan="5">Detalle</th>
						<th width="10">Acciones</th>
					</tr>

					<tr class="item-row fact_tittle">
						<td>Nombre</td>
						<td width="120">Rut</td>
						<td width="120">Alcance Liquido</td>
						<td width="120">Total Deberes</td>
						<td width="120">Total a Pagar</td>
						<td width="10">Acciones</td>
					</tr>
					<?php foreach ($_SESSION['fact_sueldos_sueldos'] as $key => $producto){ ?>
						<tr>
							<td class="blank">
								<?php 
								echo $producto['TrabajadorNombre'];
								if(isset($producto['CentroCosto'])&&$producto['CentroCosto']!=''){echo '<br/><strong>Centro de Costo: </strong>'.$producto['CentroCosto'];}
								?>
							</td>
							<td class="blank"><?php echo $producto['TrabajadorRut']; ?></td>
							<td class="blank" align="right"><?php echo valores($producto['TotalHaberes'], 0); ?></td>
							<td class="blank" align="right"><?php echo valores($producto['TotalDescuentos'], 0); ?></td>
							<td class="blank" align="right"><?php echo valores($producto['TotalAPagar'], 0); ?></td>
							<td class="blank">
								<div class="btn-group" style="width: 70px;" >
									<a href="<?php echo 'view_rrhh_sueldos_pre.php?idTrabajador='.$producto['idTrabajador']; ?>" title="Ver Documento" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
									<?php
									$ubicacion = $location.'&view=true&del_trab='.$producto['idTrabajador'];
									$dialogo   = '¿Realmente deseas eliminar la facturacion de '.$producto['TrabajadorNombre'].'?'; ?>
									<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Información" class="btn btn-metis-1 btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
								</div>
							</td>
						<tr>
					<?php } ?>
			</tbody>
		</table>
    </div>

    <div class="col-xs-12">
		<div class="row">
			<p class="lead"><a name="Ancla_obs"></a>Observaciones:</p>
			<p class="text-muted well well-sm no-shadow" ><?php echo $_SESSION['fact_sueldos_basicos']['Observaciones']; ?></p>
		</div>
	</div>

    <table id="items" style="margin-bottom: 20px;">
        <tbody>

			<tr class="invoice-total" bgcolor="#f1f1f1">
                <td colspan="5">Archivos Adjuntos</td>
                <td width="160"><a href="<?php echo $location.'&addFile=true' ?>" title="Agregar Archivo" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Archivos</a></td>
            </tr>

			<?php
			if (isset($_SESSION['fact_sueldos_archivos'])){
				//recorro el lsiatdo entregado por la base de datos
				$numeral = 1;
				foreach ($_SESSION['fact_sueldos_archivos'] as $key => $producto){ ?>
					<tr class="item-row">
						<td colspan="5"><?php echo $numeral.' - '.$producto['Nombre']; ?></td>
						<td>
							<div class="btn-group" style="width: 70px;" >
								<a href="<?php echo 'view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($producto['Nombre'], fecha_actual()); ?>" title="Ver Documento" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
								<?php
								$ubicacion = $location.'&del_file='.$producto['idFile'];
								$dialogo   = '¿Realmente deseas eliminar  '.str_replace('"','',$producto['Nombre']).'?'; ?>
								<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Archivo" class="btn btn-metis-1 btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
							</div>
						</td>
					</tr>

				 <?php
				$numeral++;
				}
			} ?>

		</tbody>
    </table>

</div>

<div class="clearfix"></div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['new'])){
//valido los permisos
validaPermisoUser($rowlevel['level'], 3, $dbConn); ?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<a target="_blank" rel="noopener noreferrer" href="https://www.previred.com/web/previred/indicadores-previsionales" class="btn btn-default pull-right margin_width" ><i class="fa fa-search" aria-hidden="true"></i> Indicadores Previsionales</a>
</div>
<div class="clearfix"></div>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Facturacion Sueldos</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($Creacion_fecha)){  $x1  = $Creacion_fecha;     }else{$x1  = '';}
				if(isset($Fecha_desde)){     $x2  = $Fecha_desde;        }else{$x2  = '';}
				if(isset($Fecha_hasta)){     $x3  = $Fecha_hasta;        }else{$x3  = '';}
				if(isset($UF)){              $x4  = $UF;                 }else{$x4  = '';}
				if(isset($UTM)){             $x5  = $UTM;                }else{$x5  = '';}
				if(isset($IMM)){             $x6  = $IMM;                }else{$x6  = '';}
				if(isset($TopeImpAFP)){      $x7  = $TopeImpAFP;         }else{$x7  = '';}
				if(isset($TopeImpIPS)){      $x8  = $TopeImpIPS;         }else{$x8  = '';}
				if(isset($TopeSegCesantia)){ $x9  = $TopeSegCesantia;    }else{$x9  = '';}
				if(isset($TopeAPVMensual)){  $x10 = $TopeAPVMensual;     }else{$x10 = '';}
				if(isset($TopeDepConv)){     $x11 = $TopeDepConv;        }else{$x11 = '';}
				if(isset($Observaciones)){   $x12 = $Observaciones;      }else{$x12 = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_tittle(3, 'Datos Facturacion');
				$Form_Inputs->form_date('Fecha Facturacion','Creacion_fecha', $x1, 2);
				$Form_Inputs->form_date('Periodo Inicio','Fecha_desde', $x2, 2);
				$Form_Inputs->form_date('Periodo Termino','Fecha_hasta', $x3, 2);

				$Form_Inputs->form_tittle(3, 'Indicadores');
				$Form_Inputs->form_input_number('UF', 'UF', $x4, 2);
				$Form_Inputs->form_input_number('UTM', 'UTM', $x5, 2);
				$Form_Inputs->form_input_number('Renta Minima', 'IMM', $x6, 2);

				$Form_Inputs->form_tittle(3, 'Topes Legales');
				$Form_Inputs->form_input_number('Tope Imponible AFP', 'TopeImpAFP', $x7, 2);
				$Form_Inputs->form_input_number('Tope Imponible IPS', 'TopeImpIPS', $x8, 2);
				$Form_Inputs->form_input_number('Tope Seguro Cesantia', 'TopeSegCesantia', $x9, 2);
				$Form_Inputs->form_input_number('Tope APV Mensual', 'TopeAPVMensual', $x10, 2);
				$Form_Inputs->form_input_number('Tope Deposito Convenido', 'TopeDepConv', $x11, 2);

				$Form_Inputs->form_textarea('Observaciones','Observaciones', $x12, 1);

				$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
				$Form_Inputs->form_input_hidden('fecha_auto', fecha_actual(), 2);

				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf046; Crear Documento" name="submit">
					<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
//Se inicializa el paginador de resultados
//tomo el numero de la pagina si es que este existe
if(isset($_GET['pagina'])){$num_pag = $_GET['pagina'];} else {$num_pag = 1;}
//Defino la cantidad total de elementos por pagina
$cant_reg = 30;
//resto de variables
if (!$num_pag){$comienzo = 0;$num_pag = 1;} else {$comienzo = ( $num_pag - 1 ) * $cant_reg ;}
/**********************************************************/
//ordenamiento
if(isset($_GET['order_by'])&&$_GET['order_by']!=''){
	switch ($_GET['order_by']) {
		case 'periodo_asc':  $order_by = 'rrhh_sueldos_facturacion.Creacion_ano ASC, rrhh_sueldos_facturacion.Creacion_mes ASC ';    $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Periodo Ascendente'; break;
		case 'periodo_desc': $order_by = 'rrhh_sueldos_facturacion.Creacion_ano DESC, rrhh_sueldos_facturacion.Creacion_mes DESC ';  $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Periodo Descendente';break;
		case 'fechas_asc':   $order_by = 'rrhh_sueldos_facturacion.Fecha_desde ASC ';                                                             $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha Ascendente';break;
		case 'fechas_desc':  $order_by = 'rrhh_sueldos_facturacion.Fecha_desde DESC ';                                                            $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha Descendente';break;
	
		default: $order_by = 'rrhh_sueldos_facturacion.Creacion_ano DESC, rrhh_sueldos_facturacion.Creacion_mes DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Periodo Descendente';
	}
}else{
	$order_by = 'rrhh_sueldos_facturacion.Creacion_ano DESC, rrhh_sueldos_facturacion.Creacion_mes DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Periodo Descendente';
}
/**********************************************************/
//Variable con la ubicacion
$SIS_where = "rrhh_sueldos_facturacion.idFacturacion!=0";
//Verifico el tipo de usuario que esta ingresando
$SIS_where.= " AND rrhh_sueldos_facturacion.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
$w = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
/**********************************************************/
//Se aplican los filtros
if(isset($_GET['Creacion_fecha']) && $_GET['Creacion_fecha']!=''){  $SIS_where .= " AND rrhh_sueldos_facturacion.Creacion_fecha='".$_GET['Creacion_fecha']."'";}
if(isset($_GET['Creacion_mes']) && $_GET['Creacion_mes']!=''){      $SIS_where .= " AND rrhh_sueldos_facturacion.Creacion_mes=".$_GET['Creacion_mes'];}
if(isset($_GET['Creacion_ano']) && $_GET['Creacion_ano']!=''){      $SIS_where .= " AND rrhh_sueldos_facturacion.Creacion_ano=".$_GET['Creacion_ano'];}

/**********************************************************/
//Realizo una consulta para saber el total de elementos existentes
$cuenta_registros = db_select_nrows (false, 'idFacturacion', 'rrhh_sueldos_facturacion', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
//Realizo la operacion para saber la cantidad de paginas que hay
$total_paginas = ceil($cuenta_registros / $cant_reg);
// Se trae un listado con todos los elementos
$SIS_query = '
rrhh_sueldos_facturacion.idFacturacion,
rrhh_sueldos_facturacion.Creacion_fecha,
rrhh_sueldos_facturacion.Creacion_mes,
rrhh_sueldos_facturacion.Creacion_ano,
rrhh_sueldos_facturacion.Fecha_desde,
rrhh_sueldos_facturacion.Fecha_hasta,
core_sistemas.Nombre AS Sistema';
$SIS_join  = 'LEFT JOIN `core_sistemas` ON core_sistemas.idSistema = rrhh_sueldos_facturacion.idSistema';
$SIS_order = $order_by.' LIMIT '.$comienzo.', '.$cant_reg;
$arrTipo = array();
$arrTipo = db_select_array (false, $SIS_query, 'rrhh_sueldos_facturacion', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTipo');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar">

	<ul class="btn-group btn-breadcrumb pull-left">
		<li class="btn btn-default tooltip" role="button" data-toggle="collapse" href="#collapseForm" aria-expanded="false" aria-controls="collapseForm" title="Presionar para desplegar Formulario de Búsqueda" style="font-size: 14px;"><i class="fa fa-search faa-vertical animated" aria-hidden="true"></i></li>
		<li class="btn btn-default"><?php echo $bread_order; ?></li>
		<?php if(isset($_GET['filtro_form'])&&$_GET['filtro_form']!=''){ ?>
			<li class="btn btn-danger"><a href="<?php echo $original.'?pagina=1'; ?>" style="color:#fff;"><i class="fa fa-trash-o" aria-hidden="true"></i> Limpiar</a></li>
		<?php } ?>
	</ul>

	<?php if ($rowlevel['level']>=3){ ?>
		<?php if (isset($_SESSION['fact_sueldos_basicos']['idUsuario'])&&$_SESSION['fact_sueldos_basicos']['idUsuario']!=''){ ?>

			<?php
			$ubicacion = $location.'&clear_all=true';
			$dialogo   = '¿Realmente deseas eliminar todos los registros?'; ?>
			<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-trash-o" aria-hidden="true"></i> Borrar</a>

			<a href="<?php echo $location; ?>&view=true" class="btn btn-default pull-right margin_width" ><i class="fa fa-arrow-right" aria-hidden="true"></i> Continuar Facturacion</a>
		<?php }else{ ?>
			<a href="<?php echo $location; ?>&new=true" class="btn btn-default pull-right margin_width" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Facturacion</a>
		<?php } ?>
	<?php } ?>
</div>
<div class="clearfix"></div>
<div class="collapse col-xs-12 col-sm-12 col-md-12 col-lg-12" id="collapseForm">
	<div class="well">
		<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
			<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" autocomplete="off" novalidate>
				<?php
				//Se verifican si existen los datos
				if(isset($Creacion_fecha)){     $x1  = $Creacion_fecha;   }else{$x1  = '';}
				if(isset($Creacion_mes)){       $x2  = $Creacion_mes;     }else{$x2  = '';}
				if(isset($Creacion_ano)){       $x3  = $Creacion_ano;     }else{$x3  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_date('Fecha Documento','Creacion_fecha', $x1, 1);
				$Form_Inputs->form_select_filter('Mes','Creacion_mes', $x2, 1, 'idMes', 'Nombre', 'core_tiempo_meses', 0, 'idMes ASC', $dbConn);
				$Form_Inputs->form_select_n_auto('Año','Creacion_ano', $x3, 1, 2016, ano_actual());
						
			
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
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Ingreso Horas Extras</h5>
			<div class="toolbar">
				<?php
				//Se llama al paginador
				echo paginador_2('pagsup',$total_paginas, $original, $search, $num_pag ) ?>
			</div>
		</header>
		<div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th>
							<div class="pull-left">Periodo</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=periodo_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=periodo_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Fechas</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=fechas_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=fechas_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><th width="160">Sistema</th><?php } ?>
						<th width="10">Acciones</th>
					</tr>
				</thead>

				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrTipo as $tipo) { ?>
						<tr class="odd">
							<td><?php echo numero_a_mes($tipo['Creacion_mes']).' '.$tipo['Creacion_ano'].' ('.Fecha_estandar($tipo['Creacion_fecha']).')'  ; ?></td>
							<td><?php echo Fecha_estandar($tipo['Fecha_desde']).' al '.Fecha_estandar($tipo['Fecha_hasta']); ?></td>
							<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><td><?php echo $tipo['Sistema']; ?></td><?php } ?>
							<td>
								<div class="btn-group" style="width: 35px;" >
									<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo $location.'&details='.$tipo['idFacturacion']; ?>" title="Ver Facturacion" class="btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
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
