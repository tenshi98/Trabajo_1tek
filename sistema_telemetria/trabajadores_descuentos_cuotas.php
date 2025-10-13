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
$original = "trabajadores_descuentos_cuotas.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['idTrabajador']) && $_GET['idTrabajador']!=''){      $location .= "&idTrabajador=".$_GET['idTrabajador'];       $search .= "&idTrabajador=".$_GET['idTrabajador'];}
if(isset($_GET['Creacion_fecha']) && $_GET['Creacion_fecha']!=''){  $location .= "&Creacion_fecha=".$_GET['Creacion_fecha'];   $search .= "&Creacion_fecha=".$_GET['Creacion_fecha'];}
if(isset($_GET['idTipo']) && $_GET['idTipo']!=''){           $location .= "&idTipo=".$_GET['idTipo'];                   $search .= "&idTipo=".$_GET['idTipo'];}
if(isset($_GET['Monto']) && $_GET['Monto']!=''){             $location .= "&Monto=".$_GET['Monto'];                     $search .= "&Monto=".$_GET['Monto'];}
if(isset($_GET['N_Cuotas']) && $_GET['N_Cuotas']!=''){       $location .= "&N_Cuotas=".$_GET['N_Cuotas'];               $search .= "&N_Cuotas=".$_GET['N_Cuotas'];}
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
	require_once 'A1XRXS_sys/xrxs_form/z_trabajadores_descuentos_cuotas.php';
}
//formulario para editar
if (!empty($_POST['submit_modBase'])){
	//Llamamos al formulario
	$form_trabajo= 'modBase_ing';
	require_once 'A1XRXS_sys/xrxs_form/z_trabajadores_descuentos_cuotas.php';
}
//formulario para editar
if (!empty($_GET['clear_all'])){
	//Llamamos al formulario
	$form_trabajo= 'clear_all_ing';
	require_once 'A1XRXS_sys/xrxs_form/z_trabajadores_descuentos_cuotas.php';
}
/**********************************************/
//formulario para crear
if (!empty($_POST['submit_edit_cuotas'])){
	//Llamamos al formulario
	$form_trabajo= 'edit_cuota_ing';
	require_once 'A1XRXS_sys/xrxs_form/z_trabajadores_descuentos_cuotas.php';
}
/**********************************************/
//formulario para crear
if (!empty($_POST['submit_file'])){
	//Llamamos al formulario
	$form_trabajo= 'new_file_ing';
	require_once 'A1XRXS_sys/xrxs_form/z_trabajadores_descuentos_cuotas.php';
}
//se borra un dato
if (!empty($_GET['del_file'])){
	//Llamamos al formulario
	$form_trabajo= 'del_file_ing';
	require_once 'A1XRXS_sys/xrxs_form/z_trabajadores_descuentos_cuotas.php';
}
/**********************************************/
if (!empty($_GET['ing_bodega'])){
	//Llamamos al formulario
	$form_trabajo= 'ing_bodega';
	require_once 'A1XRXS_sys/xrxs_form/z_trabajadores_descuentos_cuotas.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Documento Realizado correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Documento Modificado correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Documento Borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['addFile'])){ ?>

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
}elseif(!empty($_GET['editCuotas'])){  ?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Editar Servicios</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($FechaCuota)){  $x1  = $FechaCuota;  }else{$x1  = $_SESSION['desc_cuotas_listado'][$_GET['editCuotas']]['fecha'];}
				if(isset($MontoCuota)){  $x2  = $MontoCuota;  }else{$x2  = Cantidades_decimales_justos($_SESSION['desc_cuotas_listado'][$_GET['editCuotas']]['monto']);}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_date('Fecha Cuota','FechaCuota', $x1, 2);
				$Form_Inputs->form_input_number('Monto Cuota', 'MontoCuota', $x2, 2);

				$Form_Inputs->form_input_hidden('oldidProducto', $_GET['editCuotas'], 2);

				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edit_cuotas">
					<a href="<?php echo $location.'&view=true'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['modBase'])){
$w = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";

?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Modificar datos basicos del Ingreso</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idTrabajador)){       $x1  = $idTrabajador;     }else{$x1  = $_SESSION['desc_cuotas_basicos']['idTrabajador'];}
				if(isset($Creacion_fecha)){     $x2  = $Creacion_fecha;   }else{$x2  = $_SESSION['desc_cuotas_basicos']['Creacion_fecha'];}
				if(isset($idTipo)){             $x3  = $idTipo;           }else{$x3  = $_SESSION['desc_cuotas_basicos']['idTipo'];}
				if(isset($Monto)){              $x4  = $Monto;            }else{$x4  = $_SESSION['desc_cuotas_basicos']['Monto'];}
				if(isset($N_Cuotas)){           $x5  = $N_Cuotas;         }else{$x5  = $_SESSION['desc_cuotas_basicos']['N_Cuotas'];}
				if(isset($Observaciones)){      $x6  = $Observaciones;    }else{$x6  = $_SESSION['desc_cuotas_basicos']['Observaciones'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_filter('Trabajador','idTrabajador', $x1, 2, 'idTrabajador', 'Rut,Nombre,ApellidoPat,ApellidoMat', 'trabajadores_listado', $w, '', $dbConn);
				$Form_Inputs->form_date('Fecha Documento','Creacion_fecha', $x2, 2);
				$Form_Inputs->form_select_filter('Tipo','idTipo', $x3, 2, 'idTipo', 'Nombre', 'trabajadores_descuentos_cuotas_tipos', 0, '', $dbConn);
				$Form_Inputs->form_input_number('Monto', 'Monto', $x4, 2);
				$Form_Inputs->form_select_n_auto('N° Cuotas','N_Cuotas', $x5, 2, 1, 72);
				$Form_Inputs->form_textarea('Observaciones','Observaciones', $x6, 1);

				$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);
				$Form_Inputs->form_input_hidden('fecha_auto', fecha_actual(), 2);
	
	
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
}elseif(!empty($_GET['view'])){
/**************************************/
//totales
$vtotal_neto = 0;
$xval_inc = 0;
//listado de servicios
if (isset($_SESSION['desc_cuotas_listado'])){
	//recorro el lsiatdo entregado por la base de datos
	foreach ($_SESSION['desc_cuotas_listado'] as $key => $producto){
		$vtotal_neto = $vtotal_neto + $producto['monto']; 
		if(isset($producto['fecha'])&&$producto['fecha']=='0000-00-00'){
			$xval_inc++;
		}
	}
}

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
	<div class="btn-group pull-right" role="group" aria-label="...">

		<?php
		$ubicacion = $location.'&clear_all=true';
		$dialogo   = '¿Realmente deseas eliminar todos los registros?'; ?>
		<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" class="btn btn-danger dialogBox"><i class="fa fa-trash-o" aria-hidden="true"></i> Borrar Todo</a>

		<a href="<?php echo $location; ?>"  class="btn btn-danger"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>

		<?php if($vtotal_neto==$_SESSION['desc_cuotas_basicos']['Monto']&&$xval_inc==0){
			$ubicacion = $location.'&view=true&ing_bodega=true';
			$dialogo   = '¿Realmente desea ingresar el documento, una vez realizada no podra realizar cambios?'; ?>
			<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" class="btn btn-primary" ><i class="fa fa-check-square-o" aria-hidden="true"></i> Ingresar Documento</a>			
		<?php } ?>

	</div>
	<div class="clearfix"></div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

	<div id="page-wrap">
		<div id="header"> <?php echo $_SESSION['desc_cuotas_basicos']['TipoDocumento']; ?></div>

		<div id="customer">

			<table id="meta" class="pull-left otdata">
				<tbody>
					<tr>
						<td class="meta-head"><strong>DATOS BASICOS</strong></td>
						<td class="meta-head"><a href="<?php echo $location.'&modBase=true' ?>" title="Modificar Datos Básicos" class="btn btn-xs btn-primary tooltip pull-right" style="position: initial;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Modificar</a></td>
					</tr>
					<tr>
						<td class="meta-head">Trabajador</td>
						<td><?php echo $_SESSION['desc_cuotas_basicos']['Trabajador']; ?></td>
					</tr>
					<tr>
						<td class="meta-head">Monto</td>
						<td align="right"><?php echo valores($_SESSION['desc_cuotas_basicos']['Monto'], 0); ?></td>
					</tr>
					<tr>
						<td class="meta-head">N° Cuotas</td>
						<td><?php echo $_SESSION['desc_cuotas_basicos']['N_Cuotas'].' cuotas'; ?></td>
					</tr>
					<tr>
						<td class="meta-head">Usuario creador</td>
						<td><?php echo $_SESSION['desc_cuotas_basicos']['Usuario']; ?></td>
					</tr>
				</tbody>
			</table>
			<table id="meta" class="otdata2">
				<tbody>
					<tr>
						<td class="meta-head">Fecha Creacion</td>
						<td colspan="2"><?php echo Fecha_estandar($_SESSION['desc_cuotas_basicos']['Creacion_fecha']); ?></td>
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
					<td>Fecha Cobro</td>
					<td colspan="3">Numero Cuota</td>
					<td>Valor</td>
					<td></td>
				</tr>
				<?php
				//listado de servicios
				if (isset($_SESSION['desc_cuotas_listado'])){
					//recorro el lsiatdo entregado por la base de datos
					foreach ($_SESSION['desc_cuotas_listado'] as $key => $producto){ ?>
						<tr class="item-row linea_punteada">
							<td class="item-name"><span <?php if(isset($producto['fecha'])&&$producto['fecha']=='0000-00-00'){echo 'style="color:red;"';} ?>><?php echo fecha_estandar($producto['fecha']); ?></span></td>
							<td class="item-name" colspan="3"><?php echo 'Cuota '.$producto['cuota'].' de '.$_SESSION['desc_cuotas_basicos']['N_Cuotas']; ?></td>
							<td class="item-name" align="right">
								<?php echo valores($producto['monto'], 0); ?>
							</td>
							<td>
								<div class="btn-group" style="width: 70px;" >
									<a href="<?php echo $location.'&editCuotas='.$producto['cuota']; ?>" title="Editar Servicio" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
								</div>
							</td>
						</tr>
					 <?php 	
					}
				}
				echo '<tr id="hiderow"><td colspan="6"><a name="Ancla_obs"></a></td></tr>'; ?>

				<tr class="invoice-total" bgcolor="#f1f1f1">
					<td colspan="4" align="right"><strong>Total Cuotas</strong></td>
					<td align="right"><span <?php if($vtotal_neto!=$_SESSION['desc_cuotas_basicos']['Monto']){echo 'style="color:red;"';} ?>><?php echo Valores($vtotal_neto, 0); ?></span></td>
					<td></td>
				</tr>
					
				
			</tbody>
		</table>
    </div>

    <div class="col-xs-12">
		<div class="row">
			<p class="lead"><a name="Ancla_obs"></a>Observaciones:</p>
			<p class="text-muted well well-sm no-shadow" ><?php echo $_SESSION['desc_cuotas_basicos']['Observaciones']; ?></p>
		</div>
	</div>

    <table id="items" style="margin-bottom: 20px;">
        <tbody>

			<tr class="invoice-total" bgcolor="#f1f1f1">
                <td colspan="5">Archivos Adjuntos</td>
                <td width="160"><a href="<?php echo $location.'&addFile=true' ?>" title="Agregar Archivo" class="btn btn-xs btn-primary tooltip" style="position: initial;"><i class="fa fa-plus" aria-hidden="true"></i> Agregar Archivos</a></td>
            </tr>

			<?php
			if (isset($_SESSION['desc_cuotas_archivos'])){
				//recorro el lsiatdo entregado por la base de datos
				$numeral = 1;
				foreach ($_SESSION['desc_cuotas_archivos'] as $key => $producto){ ?>
					<tr class="item-row">
						<td colspan="5"><?php echo $numeral.' - '.$producto['Nombre']; ?></td>
						<td>
							<div class="btn-group" style="width: 70px;" >
								<a href="<?php echo 'view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($producto['Nombre'], fecha_actual()); ?>" title="Ver Documento" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
								<?php
								$ubicacion = $location.'&del_file='.$producto['idFile'];
								$dialogo   = '¿Realmente deseas eliminar  '.str_replace('"','',$producto['Nombre']).'?'; ?>
								<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Archivo" class="btn btn-danger btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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
validaPermisoUser($rowlevel['level'], 3, $dbConn);
//se crea filtro
$w = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";

?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Ingresar Descuentos</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idTrabajador)){       $x1  = $idTrabajador;     }else{$x1  = '';}
				if(isset($Creacion_fecha)){     $x2  = $Creacion_fecha;   }else{$x2  = '';}
				if(isset($idTipo)){             $x3  = $idTipo;           }else{$x3  = '';}
				if(isset($Monto)){              $x4  = $Monto;            }else{$x4  = '';}
				if(isset($N_Cuotas)){           $x5  = $N_Cuotas;         }else{$x5  = '';}
				if(isset($Observaciones)){      $x6  = $Observaciones;    }else{$x6  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_filter('Trabajador','idTrabajador', $x1, 2, 'idTrabajador', 'Rut,Nombre,ApellidoPat,ApellidoMat', 'trabajadores_listado', $w, '', $dbConn);
				$Form_Inputs->form_date('Fecha Documento','Creacion_fecha', $x2, 2);
				$Form_Inputs->form_select_filter('Tipo','idTipo', $x3, 2, 'idTipo', 'Nombre', 'trabajadores_descuentos_cuotas_tipos', 0, '', $dbConn);
				$Form_Inputs->form_input_number('Monto', 'Monto', $x4, 2);
				$Form_Inputs->form_select_n_auto('N° Cuotas','N_Cuotas', $x5, 2, 1, 72);
				$Form_Inputs->form_textarea('Observaciones','Observaciones', $x6, 1);

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
		case 'fecha_asc':       $order_by = 'trabajadores_descuentos_cuotas.Creacion_fecha ASC ';      $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha Ascendente';break;
		case 'fecha_desc':      $order_by = 'trabajadores_descuentos_cuotas.Creacion_fecha DESC ';     $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha Descendente';break;
		case 'Trabajador_asc':  $order_by = 'trabajadores_listado.Nombre ASC ';                        $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Trabajador Ascendente'; break;
		case 'Trabajador_desc': $order_by = 'trabajadores_listado.Nombre DESC ';                       $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Trabajador Descendente';break;
		case 'tipo_asc':        $order_by = 'trabajadores_descuentos_cuotas_tipos.Nombre ASC ';        $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Tipo Ascendente';break;
		case 'tipo_desc':       $order_by = 'trabajadores_descuentos_cuotas_tipos.Nombre DESC ';       $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Tipo Descendente';break;
		case 'monto_asc':       $order_by = 'trabajadores_descuentos_cuotas.Monto ASC ';               $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Monto Ascendente';break;
		case 'monto_desc':      $order_by = 'trabajadores_descuentos_cuotas.Monto DESC ';              $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Monto Descendente';break;
		case 'cuotas_asc':      $order_by = 'trabajadores_descuentos_cuotas.N_Cuotas ASC ';            $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Numero Cuotas Ascendente';break;
		case 'cuotas_desc':     $order_by = 'trabajadores_descuentos_cuotas.N_Cuotas DESC ';           $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Numero Cuotas Descendente';break;

		default: $order_by = 'trabajadores_descuentos_cuotas.Creacion_fecha DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha Descendente';
	}
}else{
	$order_by = 'trabajadores_descuentos_cuotas.Creacion_fecha DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha Descendente';
}
/**********************************************************/
//Variable con la ubicacion
$SIS_where = "trabajadores_descuentos_cuotas.idFacturacion>=0";//Solo ingresos
//Verifico el tipo de usuario que esta ingresando
$SIS_where.= " AND trabajadores_descuentos_cuotas.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
$w = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
/**********************************************************/
//Se aplican los filtros
if(isset($_GET['idTrabajador']) && $_GET['idTrabajador']!=''){      $SIS_where .= " AND trabajadores_descuentos_cuotas.idTrabajador=".$_GET['idTrabajador'];}
if(isset($_GET['Creacion_fecha']) && $_GET['Creacion_fecha']!=''){  $SIS_where .= " AND trabajadores_descuentos_cuotas.Creacion_fecha='".$_GET['Creacion_fecha']."'";}
if(isset($_GET['idTipo']) && $_GET['idTipo']!=''){           $SIS_where .= " AND trabajadores_descuentos_cuotas.idTipo='".$_GET['idTipo']."'";}
if(isset($_GET['Monto']) && $_GET['Monto']!=''){             $SIS_where .= " AND trabajadores_descuentos_cuotas.N_Doc LIKE '%".EstandarizarInput($_GET['Monto'])."%'";}
if(isset($_GET['N_Cuotas']) && $_GET['N_Cuotas']!=''){       $SIS_where .= " AND trabajadores_descuentos_cuotas.N_Cuotas='".$_GET['N_Cuotas']."'";}

/**********************************************************/
//Realizo una consulta para saber el total de elementos existentes
$cuenta_registros = db_select_nrows (false, 'idFacturacion', 'trabajadores_descuentos_cuotas', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
//Realizo la operacion para saber la cantidad de paginas que hay
$total_paginas = ceil($cuenta_registros / $cant_reg);
// Se trae un listado con todos los elementos
$SIS_query = '
trabajadores_descuentos_cuotas.idFacturacion,
trabajadores_descuentos_cuotas.Creacion_fecha,
trabajadores_descuentos_cuotas.Monto,
trabajadores_descuentos_cuotas.N_Cuotas,
trabajadores_listado.Nombre AS TrabajadorNombre,
trabajadores_listado.ApellidoPat AS TrabajadorApellidoPat,
trabajadores_listado.ApellidoMat AS TrabajadorApellidoMat,
trabajadores_descuentos_cuotas_tipos.Nombre AS Tipo,
core_sistemas.Nombre AS Sistema';
$SIS_join  = '
LEFT JOIN `core_sistemas`                           ON core_sistemas.idSistema                       = trabajadores_descuentos_cuotas.idSistema
LEFT JOIN `trabajadores_listado`                    ON trabajadores_listado.idTrabajador             = trabajadores_descuentos_cuotas.idTrabajador
LEFT JOIN `trabajadores_descuentos_cuotas_tipos`    ON trabajadores_descuentos_cuotas_tipos.idTipo   = trabajadores_descuentos_cuotas.idTipo';
$SIS_order = $order_by.' LIMIT '.$comienzo.', '.$cant_reg;
$arrTipo = array();
$arrTipo = db_select_array (false, $SIS_query, 'trabajadores_descuentos_cuotas', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTipo');

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
		<?php if (isset($_SESSION['desc_cuotas_basicos']['idTrabajador'])&&$_SESSION['desc_cuotas_basicos']['idTrabajador']!=''){ ?>

			<?php
			$ubicacion = $location.'&clear_all=true';
			$dialogo   = '¿Realmente deseas eliminar todos los registros?'; ?>
			<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-trash-o" aria-hidden="true"></i> Borrar</a>

			<a href="<?php echo $location; ?>&view=true" class="btn btn-default pull-right margin_width" ><i class="fa fa-arrow-right" aria-hidden="true"></i> Continuar Descuentos</a>
		<?php }else{ ?>
			<a href="<?php echo $location; ?>&new=true" class="btn btn-default pull-right margin_width" ><i class="fa fa-file-o" aria-hidden="true"></i> Ingresar Descuentos</a>
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
				if(isset($idTrabajador)){       $x1  = $idTrabajador;     }else{$x1  = '';}
				if(isset($Creacion_fecha)){     $x2  = $Creacion_fecha;   }else{$x2  = '';}
				if(isset($idTipo)){             $x3  = $idTipo;           }else{$x3  = '';}
				if(isset($Monto)){              $x4  = $Monto;            }else{$x4  = '';}
				if(isset($N_Cuotas)){           $x5  = $N_Cuotas;         }else{$x5  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_filter('Trabajador','idTrabajador', $x1, 1, 'idTrabajador', 'Rut,Nombre,ApellidoPat,ApellidoMat', 'trabajadores_listado', $w, '', $dbConn);
				$Form_Inputs->form_date('Fecha Documento','Creacion_fecha', $x2, 1);
				$Form_Inputs->form_select_filter('Tipo','idTipo', $x3, 1, 'idTipo', 'Nombre', 'trabajadores_descuentos_cuotas_tipos', 0, '', $dbConn);
				$Form_Inputs->form_input_number('Monto', 'Monto', $x4, 1);
				$Form_Inputs->form_select_n_auto('N° Cuotas','N_Cuotas', $x5, 1, 1, 72);

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
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Descuentos</h5>
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
							<div class="pull-left">Fecha</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=fecha_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=fecha_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Trabajador</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=Trabajador_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=Trabajador_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Tipo</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=tipo_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=tipo_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Monto</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=monto_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=monto_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">N° Cuotas</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=cuotas_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=cuotas_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><th width="160">Sistema</th><?php } ?>
						<th width="10">Acciones</th>
					</tr>
				</thead>

				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrTipo as $tipo) { ?>
					<tr class="odd">
						<td><?php echo Fecha_estandar($tipo['Creacion_fecha']); ?></td>
						<td><?php echo $tipo['TrabajadorNombre'].' '.$tipo['TrabajadorApellidoPat'].' '.$tipo['TrabajadorApellidoMat']; ?></td>
						<td><?php echo $tipo['Tipo']; ?></td>
						<td align="right"><?php echo valores($tipo['Monto'], 0); ?></td>
						<td><?php echo $tipo['N_Cuotas']; ?></td>
						<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><td><?php echo $tipo['Sistema']; ?></td><?php } ?>
						<td>
							<div class="btn-group" style="width: 35px;" >
								<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_descuentos_cuotas.php?view='.simpleEncode($tipo['idFacturacion'], fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
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
