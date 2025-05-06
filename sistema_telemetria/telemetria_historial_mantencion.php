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
$original = "telemetria_historial_mantencion.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['idServicio']) && $_GET['idServicio']!=''){      $location .= "&idServicio=".$_GET['idServicio'];      $search .= "&idServicio=".$_GET['idServicio'];}
if(isset($_GET['idOpciones_1']) && $_GET['idOpciones_1']!=''){  $location .= "&idOpciones_1=".$_GET['idOpciones_1'];  $search .= "&idOpciones_1=".$_GET['idOpciones_1'];}
if(isset($_GET['idOpciones_2']) && $_GET['idOpciones_2']!=''){  $location .= "&idOpciones_2=".$_GET['idOpciones_2'];  $search .= "&idOpciones_2=".$_GET['idOpciones_2'];}
if(isset($_GET['idOpciones_3']) && $_GET['idOpciones_3']!=''){  $location .= "&idOpciones_3=".$_GET['idOpciones_3'];  $search .= "&idOpciones_3=".$_GET['idOpciones_3'];}
if(isset($_GET['Fecha']) && $_GET['Fecha']!=''){         $location .= "&Fecha=".$_GET['Fecha'];                $search .= "&Fecha=".$_GET['Fecha'];}
if(isset($_GET['idUsuario']) && $_GET['idUsuario']!=''){ $location .= "&idUsuario=".$_GET['idUsuario'];        $search .= "&idUsuario=".$_GET['idUsuario'];}
if(isset($_GET['idSistema']) && $_GET['idSistema']!=''){ $location .= "&idSistema=".$_GET['idSistema'];        $search .= "&idSistema=".$_GET['idSistema'];}
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
	require_once 'A1XRXS_sys/xrxs_form/z_telemetria_historial_mantencion.php';
}
//se borra un dato
if (!empty($_GET['del'])){
	//Llamamos al formulario
	$form_trabajo= 'del';
	require_once 'A1XRXS_sys/xrxs_form/z_telemetria_historial_mantencion.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Mantencion Creada correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Mantencion Modificada correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Mantencion Borrada correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['id'])){
//valido los permisos
validaPermisoUser($rowlevel['level'], 2, $dbConn);
//filtro
$query = "SELECT 
core_sistemas.Nombre AS SistemaOrigen,
sis_or_ciudad.Nombre AS SistemaOrigenCiudad,
sis_or_comuna.Nombre AS SistemaOrigenComuna,
core_sistemas.Direccion AS SistemaOrigenDireccion,
core_sistemas.Contacto_Fono1 AS SistemaOrigenFono,
core_sistemas.email_principal AS SistemaOrigenEmail,
core_sistemas.Rut AS SistemaOrigenRut,
core_sistemas.Contacto_Nombre AS SistemaContacto,

usuarios_listado.Nombre AS NombreEncargado,

telemetria_historial_mantencion.Fecha, 
telemetria_historial_mantencion.h_Inicio, 
telemetria_historial_mantencion.h_Termino, 
telemetria_historial_mantencion.Duracion, 
telemetria_historial_mantencion.Resumen, 
telemetria_historial_mantencion.Resolucion,
telemetria_historial_mantencion.idOpciones_1,
telemetria_historial_mantencion.idOpciones_2,
telemetria_historial_mantencion.idOpciones_3,
telemetria_historial_mantencion.Recepcion_Nombre,
telemetria_historial_mantencion.Recepcion_Rut, 
telemetria_historial_mantencion.Recepcion_Email,

core_telemetria_servicio_tecnico.Nombre AS Servicio

FROM `telemetria_historial_mantencion`
LEFT JOIN `usuarios_listado`                        ON usuarios_listado.idUsuario                   = telemetria_historial_mantencion.idUsuario
LEFT JOIN `core_telemetria_servicio_tecnico`        ON core_telemetria_servicio_tecnico.idServicio  = telemetria_historial_mantencion.idServicio
LEFT JOIN `core_sistemas`                           ON core_sistemas.idSistema                      = telemetria_historial_mantencion.idSistema
LEFT JOIN `core_ubicacion_ciudad`   sis_or_ciudad   ON sis_or_ciudad.idCiudad                       = core_sistemas.idCiudad
LEFT JOIN `core_ubicacion_comunas`  sis_or_comuna   ON sis_or_comuna.idComuna                       = core_sistemas.idComuna

WHERE telemetria_historial_mantencion.idMantencion = ".$_GET['id'];
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
$rowData = mysqli_fetch_assoc ($resultado); 

/**********************************/
$arrOpciones = array();
$query = "SELECT idOpciones, Nombre
FROM `core_telemetria_servicio_tecnico_opciones`
ORDER BY Nombre ASC";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrOpciones,$row );
}
/**********************************/
$arrOpcionesDisplay = array();
foreach ($arrOpciones as $mant) {
	$arrOpcionesDisplay[$mant['idOpciones']]['Nombre'] = $mant['Nombre'];
}
/*************************************************************************/
//Se buscan todos los archivos relacionados
$arrEquipos = array();
$query = "SELECT 
telemetria_listado.Identificador AS Identificador,
telemetria_listado.Nombre AS Equipo

FROM `telemetria_historial_mantencion_equipos`
LEFT JOIN `telemetria_listado`  ON telemetria_listado.idTelemetria  = telemetria_historial_mantencion_equipos.idTelemetria
WHERE telemetria_historial_mantencion_equipos.idMantencion = ".$_GET['id'];
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrEquipos,$row );
}
/*************************************************************************/
//Se buscan todos los archivos relacionados
$arrArchivos = array();
$query = "SELECT Nombre
FROM `telemetria_historial_mantencion_archivos`
WHERE idMantencion = ".$_GET['id'];
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
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Equipo', $rowData['Servicio'], 'Resumen'); ?>
</div>
<div class="clearfix"></div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class="active"><a href="<?php echo 'telemetria_historial_mantencion.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class=""><a href="<?php echo 'telemetria_historial_mantencion_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
				<li class=""><a href="<?php echo 'telemetria_historial_mantencion_equipos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" >Equipos</a></li>
				<li class="dropdown">
					<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
					<ul class="dropdown-menu" role="menu">
						<li class=""><a href="<?php echo 'telemetria_historial_mantencion_archivos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivos</a></li>          
						<li class=""><a href="<?php echo 'telemetria_historial_mantencion_firma.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" >Firma</a></li>          
					</ul>
                </li>
			</ul>
		</header>
        <div class="tab-content">

			<div class="tab-pane fade active in" id="basicos">
				<div class="wmd-panel">

					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<img style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="Imagen Referencia" src="<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/img/maquina.jpg">
					</div>
					<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Empresa Visitada</h2>
						<p class="text-muted">
							<strong>Nombre : </strong><?php echo $rowData['SistemaOrigen']; ?><br/>
							<strong>Ubicación : </strong><?php echo $rowData['SistemaOrigenCiudad'].', '.$rowData['SistemaOrigenComuna']; ?><br/>
							<strong>Dirección : </strong><?php echo $rowData['SistemaOrigenDireccion']; ?><br/>
							<strong>Fono Fijo : </strong><?php echo formatPhone($rowData['SistemaOrigenFono']); ?><br/>
							<strong>Rut : </strong><?php echo $rowData['SistemaOrigenRut']; ?><br/>
							<strong>Email : </strong><?php echo $rowData['SistemaOrigenEmail']; ?><br/>
							<strong>Persona contacto : </strong><?php echo $rowData['SistemaContacto']; ?><br/>
							<strong>Persona Recepcion Nombre : </strong><?php echo $rowData['Recepcion_Nombre']; ?><br/>
							<strong>Persona Recepcion Rut : </strong><?php echo $rowData['Recepcion_Rut']; ?><br/>
							<strong>Persona Recepcion Email : </strong><?php echo $rowData['Recepcion_Email']; ?><br/>
						</p>

						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Tecnico a Cargo</h2>
						<p class="text-muted">
							<strong>Tecnico Encargado : </strong><?php echo $rowData['NombreEncargado']; ?><br/>
							<strong>Fecha : </strong><?php echo Fecha_estandar($rowData['Fecha']); ?><br/>
							<strong>Hora Inicio : </strong><?php echo $rowData['h_Inicio']; ?><br/>
							<strong>Hora Termino : </strong><?php echo $rowData['h_Termino']; ?><br/>
							<strong>Duracion : </strong><?php echo $rowData['Duracion']; ?><br/>
						</p>

						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Trabajo</h2>
						<p class="text-muted">
							<strong>Servicio : </strong><?php echo $rowData['Servicio']; ?><br/>
							<strong>Opciones : </strong>
								<?php
								$ntot = 0;
								if(isset($rowData['idOpciones_1'])&&$rowData['idOpciones_1']==2){if($ntot!=0){echo ' - '.$arrOpcionesDisplay[1]['Nombre'];$ntot++;}else{echo $arrOpcionesDisplay[1]['Nombre'];$ntot++;}}
								if(isset($rowData['idOpciones_2'])&&$rowData['idOpciones_2']==2){if($ntot!=0){echo ' - '.$arrOpcionesDisplay[2]['Nombre'];$ntot++;}else{echo $arrOpcionesDisplay[2]['Nombre'];$ntot++;}}
								if(isset($rowData['idOpciones_3'])&&$rowData['idOpciones_3']==2){if($ntot!=0){echo ' - '.$arrOpcionesDisplay[3]['Nombre'];$ntot++;}else{echo $arrOpcionesDisplay[3]['Nombre'];$ntot++;}}
								?>
							<br/>
						</p>

						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Equipos</h2>
						<table  class="table table-bordered">
							<?php
							foreach ($arrEquipos as $equipo) { ?>
								<tr class="item-row">
									<td><?php echo $equipo['Identificador']; ?></td>
									<td><?php echo $equipo['Equipo']; ?></td>
								</tr>
							<?php } ?>
						</table>

						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Diagnostico tecnico y acciones realizadas</h2>
						<div class="text-muted well well-sm no-shadow" ><?php echo $rowData['Resumen']; ?></div>

						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Resumen de Visita</h2>
						<div class="text-muted well well-sm no-shadow" ><?php echo $rowData['Resolucion']; ?></div>

						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Archivos Adjuntos</h2>
						<table id="items" style="margin-bottom: 20px;">
							<tbody>
								<?php
								//Ficha Tecnica
								foreach ($arrArchivos as $archivo) {
									echo '
										<tr class="item-row">
											<td>'.$archivo['Nombre'].'</td>
											<td width="10">
												<div class="btn-group" style="width: 70px;">
													<a href="view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($archivo['Nombre'], fecha_actual()).'" title="Ver Documento" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
													<a href="1download.php?dir='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($archivo['Nombre'], fecha_actual()).'" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-download" aria-hidden="true"></i></a>
												</div>
											</td>
										</tr>
									';
								}
								?>
							</tbody>
						</table>
						
						

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
validaPermisoUser($rowlevel['level'], 3, $dbConn);

?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Crear Mantencion</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idSistema)){         $x0  = $idSistema;          }else{$x0  = '';}
				if(isset($idServicio)){        $x1  = $idServicio;         }else{$x1  = '';}
				if(isset($idOpciones_1)){      $x2  = $idOpciones_1;       }else{$x2  = '';}
				if(isset($idOpciones_2)){      $x2 .= ','.$idOpciones_2;   }else{$x2 .= '';}
				if(isset($idOpciones_3)){      $x2 .= ','.$idOpciones_3;   }else{$x2 .= '';}
				if(isset($Fecha)){   $x3  = $Fecha;              }else{$x3  = '';}
				if(isset($h_Inicio)){          $x4  = $h_Inicio;           }else{$x4  = '';}
				if(isset($h_Termino)){         $x5  = $h_Termino;          }else{$x5  = '';}
				if(isset($Resumen)){           $x6  = $Resumen;            }else{$x6  = '';}
				if(isset($Resolucion)){        $x7  = $Resolucion;         }else{$x7  = '';}
				if(isset($Recepcion_Nombre)){  $x8  = $Recepcion_Nombre;   }else{$x8  = '';}
				if(isset($Recepcion_Rut)){     $x9  = $Recepcion_Rut;      }else{$x9  = '';}
				if(isset($Recepcion_Email)){   $x10 = $Recepcion_Email;    }else{$x10 = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_filter('Sistema','idSistema', $x0, 2, 'idSistema', 'Nombre', 'core_sistemas',0, '', $dbConn);
				$Form_Inputs->form_select('Tipo de Servicio','idServicio', $x1, 2, 'idServicio', 'Nombre', 'core_telemetria_servicio_tecnico', 0, '', $dbConn);
				$Form_Inputs->form_checkbox_active('Selecciona una Opción','idOpciones', $x2, 2, 2, 'idOpciones', 'Nombre', 'core_telemetria_servicio_tecnico_opciones', 0, $dbConn);
				$Form_Inputs->form_date('Fecha Mantencion','Fecha', $x3, 2);
				$Form_Inputs->form_time('Hora Inicio','h_Inicio', $x4, 2, 2);
				$Form_Inputs->form_time('Hora Termino','h_Termino', $x5, 2, 2);
				$Form_Inputs->form_ckeditor('Diagnostico tecnico y acciones realizadas','Resumen', $x6, 2, 2);
				$Form_Inputs->form_ckeditor('Resumen de Visita','Resolucion', $x7, 1, 2);
				$Form_Inputs->form_input_text('Nombre persona recepcion', 'Recepcion_Nombre', $x8, 1);
				$Form_Inputs->form_input_rut('Rut persona recepcion', 'Recepcion_Rut', $x9, 1);
				$Form_Inputs->form_input_icon('Email persona recepcion', 'Recepcion_Email', $x10, 1,'fa fa-envelope-o');

				$Form_Inputs->form_input_hidden('idUsuario', $_SESSION['usuario']['basic_data']['idUsuario'], 2);

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
		case 'fecha_asc':     $order_by = 'telemetria_historial_mantencion.Fecha ASC ';      $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha Ascendente'; break;
		case 'fecha_desc':    $order_by = 'telemetria_historial_mantencion.Fecha DESC ';     $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha Descendente';break;
		case 'usuario_asc':   $order_by = 'usuarios_listado.Nombre ASC ';                    $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Usuario Ascendente';break;
		case 'usuario_desc':  $order_by = 'usuarios_listado.Nombre DESC ';                   $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Usuario Descendente';break;
		case 'sistema_asc':   $order_by = 'core_sistemas.Nombre ASC ';                       $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Sistema Ascendente'; break;
		case 'sistema_desc':  $order_by = 'core_sistemas.Nombre DESC ';                      $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Sistema Descendente';break;
		case 'servicio_asc':  $order_by = 'core_telemetria_servicio_tecnico.Nombre ASC ';    $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Servicio Ascendente'; break;
		case 'servicio_desc': $order_by = 'core_telemetria_servicio_tecnico.Nombre DESC ';   $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Servicio Descendente';break;

		default: $order_by = 'telemetria_historial_mantencion.Fecha DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha Descendente';
	}
}else{
	$order_by = 'telemetria_historial_mantencion.Fecha DESC '; $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha Descendente';
}
/**********************************************************/
//Verifico el tipo de usuario que esta ingresando
$usrfil = 'usuarios_listado.idEstado=1 AND usuarios_listado.idTipoUsuario!=1';
//Verifico el tipo de usuario que esta ingresando
if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
	$usrfil .= " AND usuarios_sistemas.idSistema = ".$_SESSION['usuario']['basic_data']['idSistema'];
}
/**********************************************************/
//Variable de busqueda
$SIS_where = "telemetria_historial_mantencion.idMantencion!=0";
/**********************************************************/
//Se aplican los filtros
if(isset($_GET['idServicio']) && $_GET['idServicio']!=''){     $SIS_where .= " AND telemetria_historial_mantencion.idServicio=".$_GET['idServicio'];}
if(isset($_GET['idOpciones_1']) && $_GET['idOpciones_1']!=''){ $SIS_where .= " AND telemetria_historial_mantencion.idOpciones_1=".$_GET['idOpciones_1'];}
if(isset($_GET['idOpciones_2']) && $_GET['idOpciones_2']!=''){ $SIS_where .= " AND telemetria_historial_mantencion.idOpciones_2=".$_GET['idOpciones_2'];}
if(isset($_GET['idOpciones_3']) && $_GET['idOpciones_3']!=''){ $SIS_where .= " AND telemetria_historial_mantencion.idOpciones_3=".$_GET['idOpciones_3'];}
if(isset($_GET['Fecha']) && $_GET['Fecha']!=''){        $SIS_where .= " AND telemetria_historial_mantencion.Fecha='".$_GET['Fecha']."'";}
if(isset($_GET['idUsuario']) && $_GET['idUsuario']!=''){$SIS_where .= " AND telemetria_historial_mantencion.idUsuario='".$_GET['idUsuario']."'";}
if(isset($_GET['idSistema']) && $_GET['idSistema']!=''){$SIS_where .= " AND telemetria_historial_mantencion.idSistema='".$_GET['idSistema']."'";}

/**********************************************************/
//Realizo una consulta para saber el total de elementos existentes
$cuenta_registros = db_select_nrows (false, 'idMantencion', 'telemetria_historial_mantencion', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
//Realizo la operacion para saber la cantidad de paginas que hay
$total_paginas = ceil($cuenta_registros / $cant_reg);
// Se trae un listado con todos los elementos
$SIS_query = '
telemetria_historial_mantencion.idMantencion,
telemetria_historial_mantencion.idOpciones_1,
telemetria_historial_mantencion.idOpciones_2,
telemetria_historial_mantencion.idOpciones_3,
telemetria_historial_mantencion.Fecha,
usuarios_listado.Nombre AS Usuario,
core_telemetria_servicio_tecnico.Nombre AS Servicio,
core_sistemas.Nombre AS sistema';
$SIS_join  = '
LEFT JOIN `usuarios_listado`                 ON usuarios_listado.idUsuario                   = telemetria_historial_mantencion.idUsuario
LEFT JOIN `core_telemetria_servicio_tecnico` ON core_telemetria_servicio_tecnico.idServicio  = telemetria_historial_mantencion.idServicio
LEFT JOIN `core_sistemas`                    ON core_sistemas.idSistema                      = telemetria_historial_mantencion.idSistema';
$SIS_order = $order_by.' LIMIT '.$comienzo.', '.$cant_reg;
$arrMantenciones = array();
$arrMantenciones = db_select_array (false, $SIS_query, 'telemetria_historial_mantencion', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrMantenciones');

/**********************************/
// Se trae un listado con todos los elementos
$arrOpciones = array();
$arrOpciones = db_select_array (false, 'idOpciones, Nombre', 'core_telemetria_servicio_tecnico_opciones', '', '', 'Nombre ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrOpciones');

/**********************************/
$arrOpcionesDisplay = array();
foreach ($arrOpciones as $mant) {
	$arrOpcionesDisplay[$mant['idOpciones']]['Nombre'] = $mant['Nombre'];
}

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar">

	<ul class="btn-group btn-breadcrumb pull-left">
		<li class="btn btn-default tooltip" role="button" data-toggle="collapse" href="#collapseForm" aria-expanded="false" aria-controls="collapseForm" title="Presionar para desplegar Formulario de Búsqueda" style="font-size: 14px;"><i class="fa fa-search faa-vertical animated" aria-hidden="true"></i></li>
		<li class="btn btn-default"><?php echo $bread_order; ?></li>
		<?php if(isset($_GET['filtro_form'])&&$_GET['filtro_form']!=''){ ?>
			<li class="btn btn-danger"><a href="<?php echo $original.'?pagina=1'; ?>" style="color:#fff;"><i class="fa fa-trash-o" aria-hidden="true"></i> Limpiar</a></li>
		<?php } ?>
	</ul>

	<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $location; ?>&new=true" class="btn btn-default pull-right margin_width fmrbtn" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Mantencion</a><?php } ?>

</div>
<div class="clearfix"></div>
<div class="collapse col-xs-12 col-sm-12 col-md-12 col-lg-12" id="collapseForm">
	<div class="well">
		<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
			<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" autocomplete="off" novalidate>
				<?php
				//Se verifican si existen los datos
				if(isset($idServicio)){     $x1  = $idServicio;         }else{$x1  = '';}
				if(isset($idOpciones_1)){   $x2  = $idOpciones_1;       }else{$x2  = '';}
				if(isset($idOpciones_2)){   $x2 .= ','.$idOpciones_2;   }else{$x2 .= '';}
				if(isset($idOpciones_3)){   $x2 .= ','.$idOpciones_3;   }else{$x2 .= '';}
				if(isset($Fecha)){$x3  = $Fecha;              }else{$x3  = '';}
				if(isset($idUsuario)){      $x4  = $idUsuario;          }else{$x4  = '';}
				if(isset($idSistema)){      $x5  = $idSistema;          }else{$x5  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select('Tipo de Servicio','idServicio', $x1, 1, 'idServicio', 'Nombre', 'core_telemetria_servicio_tecnico', 0, '', $dbConn);
				$Form_Inputs->form_checkbox_active('Selecciona una Opción','idOpciones', $x2, 1, 2, 'idOpciones', 'Nombre', 'core_telemetria_servicio_tecnico_opciones', 0, $dbConn);
				$Form_Inputs->form_date('Fecha Mantencion','Fecha', $x3, 1);
				$Form_Inputs->form_select_join_filter('Tecnico','idUsuario', $x4, 1, 'idUsuario', 'Nombre', 'usuarios_listado', 'usuarios_sistemas',$usrfil, $dbConn);
				$Form_Inputs->form_select('Sistema','idSistema', $x5, 1, 'idSistema', 'Nombre', 'core_sistemas',0, '', $dbConn);

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
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Mantenciones</h5>
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
							<div class="pull-left">Servicio</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=servicio_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=servicio_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>Opciones</th>
						<th>
							<div class="pull-left">Fecha</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=fecha_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=fecha_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Tecnico</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=usuario_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=usuario_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Sistema</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=sistema_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=sistema_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th width="10">Acciones</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
				<?php foreach ($arrMantenciones as $mant) { ?>
					<tr class="odd">
						<td><?php echo $mant['Servicio']; ?></td>
						<td>
							<?php
							$ntot = 0;
							if(isset($mant['idOpciones_1'])&&$mant['idOpciones_1']!=0){if($ntot!=0){echo ' - '.$arrOpcionesDisplay[1]['Nombre'];$ntot++;}else{echo $arrOpcionesDisplay[1]['Nombre'];$ntot++;}}
							if(isset($mant['idOpciones_2'])&&$mant['idOpciones_2']!=0){if($ntot!=0){echo ' - '.$arrOpcionesDisplay[2]['Nombre'];$ntot++;}else{echo $arrOpcionesDisplay[2]['Nombre'];$ntot++;}}
							if(isset($mant['idOpciones_3'])&&$mant['idOpciones_3']!=0){if($ntot!=0){echo ' - '.$arrOpcionesDisplay[3]['Nombre'];$ntot++;}else{echo $arrOpcionesDisplay[3]['Nombre'];$ntot++;}}
							?>
						</td>
						<td><?php echo fecha_estandar($mant['Fecha']); ?></td>
						<td><?php echo $mant['Usuario']; ?></td>
						<td><?php echo $mant['sistema']; ?></td>
						<td>
							<div class="btn-group" style="width: 105px;" >
								<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_telemetria_mantencion.php?view='.simpleEncode($mant['idMantencion'], fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
								<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'&id='.$mant['idMantencion']; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
								<?php if ($rowlevel['level']>=4){
									$ubicacion = $location.'&del='.simpleEncode($mant['idMantencion'], fecha_actual());
									$dialogo   = '¿Realmente deseas eliminar la mantencion N° '.$mant['idMantencion'].'?'; ?>
									<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Información" class="btn btn-metis-1 btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
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
