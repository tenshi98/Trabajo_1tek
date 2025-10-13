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
$original = "trabajadores_listado.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['Nombre']) && $_GET['Nombre']!=''){      $location .= "&Nombre=".$_GET['Nombre'];            $search .= "&Nombre=".$_GET['Nombre'];}
if(isset($_GET['ApellidoPat']) && $_GET['ApellidoPat']!=''){   $location .= "&ApellidoPat=".$_GET['ApellidoPat'];  $search .= "&ApellidoPat=".$_GET['ApellidoPat'];}
if(isset($_GET['ApellidoMat']) && $_GET['ApellidoMat']!=''){   $location .= "&ApellidoMat=".$_GET['ApellidoMat'];  $search .= "&ApellidoMat=".$_GET['ApellidoMat'];}
if(isset($_GET['Rut']) && $_GET['Rut']!=''){            $location .= "&Rut=".$_GET['Rut'];                  $search .= "&Rut=".$_GET['Rut'];}
if(isset($_GET['idTipo']) && $_GET['idTipo']!=''){      $location .= "&idTipo=".$_GET['idTipo'];            $search .= "&idTipo=".$_GET['idTipo'];}
if(isset($_GET['Cargo']) && $_GET['Cargo']!=''){        $location .= "&Cargo=".$_GET['Cargo'];              $search .= "&Cargo=".$_GET['Cargo'];}
if(isset($_GET['Fono']) && $_GET['Fono']!=''){          $location .= "&Fono=".$_GET['Fono'];                $search .= "&Fono=".$_GET['Fono'];}
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
	require_once 'A1XRXS_sys/xrxs_form/trabajadores_listado.php';
}
//formulario para crear
if (!empty($_POST['submit_plant'])){
	//Llamamos al formulario
	$form_trabajo= 'insert_plant';
	require_once 'A1XRXS_sys/xrxs_form/trabajadores_listado.php';
}
//se borra un dato
if (!empty($_GET['del'])){
	//Llamamos al formulario
	$form_trabajo= 'del';
	require_once 'A1XRXS_sys/xrxs_form/trabajadores_listado.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Trabajador Creado correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Trabajador Modificado correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Trabajador Borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['new_plantilla'])){
//valido los permisos
validaPermisoUser($rowlevel['level'], 3, $dbConn);
//cuadro para descargar
$Alert_Text  = 'Descargar Plantilla';
$Alert_Text .= '<a href="1download.php?dir='.simpleEncode('templates', fecha_actual()).'&file='.simpleEncode('plantilla_trabajador.xlsx', fecha_actual()).'" title="Descargar Plantilla" class="btn btn-primary btn-sm pull-right" ><i class="fa fa-download" aria-hidden="true"></i> Descargar</a>';
alert_post_data(2,1,2,0, $Alert_Text);

?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Crear Trabajador con Plantilla</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" enctype="multipart/form-data" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idOpciones)){  $x1 = $idOpciones;   }else{$x1 = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_multiple_upload('Seleccionar archivo','FileTrabajador', 1, '"xlsx"');
				$Form_Inputs->form_select('¿Envio de correos?','idOpciones', $x1, 2, 'idOpciones', 'Nombre', 'core_sistemas_opciones', 0, '', $dbConn);

				$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idEstado', 1, 2);
				$Form_Inputs->form_input_hidden('idTipoTrabajo', 1, 2);

				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_plant">
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
core_ubicacion_ciudad.Nombre AS nombre_region,
core_ubicacion_comunas.Nombre AS nombre_comuna,
trabajadores_listado.Direccion,
core_estado_civil.Nombre AS EstadoCivil,
core_estados.Nombre AS Estado,
core_sistemas.Nombre AS Sistema,

trabajadores_listado.ContactoPersona,
trabajadores_listado.ContactoFono,

trabajadores_listado_tipos.Nombre AS TipoTrabajador,
trabajadores_listado.Cargo, 
sistema_afp.Nombre AS nombre_afp,
sistema_salud.Nombre AS nombre_salud,
core_tipos_contrato.Nombre AS TipoContrato,
trabajadores_listado.FechaContrato,
trabajadores_listado.F_Inicio_Contrato,
trabajadores_listado.F_Termino_Contrato,
trabajadores_listado.Observaciones,
trabajadores_listado.SueldoLiquido,
trabajadores_listado.UbicacionTrabajo,

core_tipos_licencia_conducir.Nombre AS LicenciaTipo,
trabajadores_listado.CA_Licencia AS LicenciaCA, 
trabajadores_listado.LicenciaFechaControlUltimo AS LicenciaControlUlt,
trabajadores_listado.LicenciaFechaControl AS LicenciaControl,

trabajadores_listado.File_Curriculum,
trabajadores_listado.File_Antecedentes,
trabajadores_listado.File_Carnet,
trabajadores_listado.File_Contrato,
trabajadores_listado.File_Licencia,
trabajadores_listado.File_RHTM,
trabajadores_listado.File_RHTM_Fecha,

contratista_listado.Nombre AS Contratista,

centrocosto_listado.Nombre AS CentroCosto_Nombre,
centrocosto_listado_level_1.Nombre AS CentroCosto_Level_1,
centrocosto_listado_level_2.Nombre AS CentroCosto_Level_2,
centrocosto_listado_level_3.Nombre AS CentroCosto_Level_3,
centrocosto_listado_level_4.Nombre AS CentroCosto_Level_4,
centrocosto_listado_level_5.Nombre AS CentroCosto_Level_5,

core_bancos.Nombre AS Pago_Banco,
core_tipo_cuenta.Nombre AS Pago_TipoCuenta,
trabajadores_listado.N_Cuenta AS Pago_N_Cuenta

FROM `trabajadores_listado`
LEFT JOIN `core_estados`                     ON core_estados.idEstado                               = trabajadores_listado.idEstado
LEFT JOIN `trabajadores_listado_tipos`       ON trabajadores_listado_tipos.idTipo                   = trabajadores_listado.idTipo
LEFT JOIN `core_sistemas`                    ON core_sistemas.idSistema                             = trabajadores_listado.idSistema
LEFT JOIN `core_ubicacion_ciudad`            ON core_ubicacion_ciudad.idCiudad                      = trabajadores_listado.idCiudad
LEFT JOIN `core_ubicacion_comunas`           ON core_ubicacion_comunas.idComuna                     = trabajadores_listado.idComuna
LEFT JOIN `sistema_afp`                      ON sistema_afp.idAFP                                   = trabajadores_listado.idAFP
LEFT JOIN `sistema_salud`                    ON sistema_salud.idSalud                               = trabajadores_listado.idSalud
LEFT JOIN `core_tipos_contrato`              ON core_tipos_contrato.idTipoContrato                  = trabajadores_listado.idTipoContrato
LEFT JOIN `core_tipos_licencia_conducir`     ON core_tipos_licencia_conducir.idTipoLicencia         = trabajadores_listado.idTipoLicencia
LEFT JOIN `core_sexo`                        ON core_sexo.idSexo                                    = trabajadores_listado.idSexo
LEFT JOIN `core_estado_civil`                ON core_estado_civil.idEstadoCivil                     = trabajadores_listado.idEstadoCivil
LEFT JOIN `contratista_listado`              ON contratista_listado.idContratista                   = trabajadores_listado.idContratista
LEFT JOIN `centrocosto_listado`              ON centrocosto_listado.idCentroCosto                   = trabajadores_listado.idCentroCosto
LEFT JOIN `centrocosto_listado_level_1`      ON centrocosto_listado_level_1.idLevel_1               = trabajadores_listado.idLevel_1
LEFT JOIN `centrocosto_listado_level_2`      ON centrocosto_listado_level_2.idLevel_2               = trabajadores_listado.idLevel_2
LEFT JOIN `centrocosto_listado_level_3`      ON centrocosto_listado_level_3.idLevel_3               = trabajadores_listado.idLevel_3
LEFT JOIN `centrocosto_listado_level_4`      ON centrocosto_listado_level_4.idLevel_4               = trabajadores_listado.idLevel_4
LEFT JOIN `centrocosto_listado_level_5`      ON centrocosto_listado_level_5.idLevel_5               = trabajadores_listado.idLevel_5
LEFT JOIN `core_bancos`                      ON core_bancos.idBanco                                 = trabajadores_listado.idBanco
LEFT JOIN `core_tipo_cuenta`                 ON core_tipo_cuenta.idTipoCuenta                       = trabajadores_listado.idTipoCuenta

WHERE trabajadores_listado.idTrabajador = ".$_GET['id'];
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
$rowData = mysqli_fetch_assoc ($resultado);

// Se trae un listado con todos los elementos
$arrCargas = array();
$query = "SELECT  Nombre,ApellidoPat, ApellidoMat
FROM `trabajadores_listado_cargas`
WHERE idTrabajador = ".$_GET['id']."
ORDER BY idCarga ASC ";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	
	
	
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrCargas,$row );
}

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Trabajador', $rowData['Nombre'].' '.$rowData['ApellidoPat'].' '.$rowData['ApellidoMat'], 'Resumen'); ?>
</div>
<div class="clearfix"></div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class="active"><a href="<?php echo 'trabajadores_listado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class=""><a href="<?php echo 'trabajadores_listado_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
				<li class=""><a href="<?php echo 'trabajadores_listado_contacto.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-address-book-o" aria-hidden="true"></i> Datos Contacto</a></li>
				<li class="dropdown">
					<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
					<ul class="dropdown-menu" role="menu">
						<li class=""><a href="<?php echo 'trabajadores_listado_laboral.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-university" aria-hidden="true"></i> Información Laboral</a></li>
						<li class=""><a href="<?php echo 'trabajadores_listado_cargas.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-user-plus" aria-hidden="true"></i> Cargas Familiares</a></li>
						<li class=""><a href="<?php echo 'trabajadores_listado_estado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-power-off" aria-hidden="true"></i> Estado</a></li>

						<li class=""><a href="<?php echo 'trabajadores_listado_contrato.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - Contrato</a></li>
						<li class=""><a href="<?php echo 'trabajadores_listado_licencia.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - Licencia Conducir</a></li>
						<li class=""><a href="<?php echo 'trabajadores_listado_imagen.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - Foto</a></li>
						<li class=""><a href="<?php echo 'trabajadores_listado_curriculum.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - Curriculum</a></li>
						<li class=""><a href="<?php echo 'trabajadores_listado_antecedentes.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - Antecedentes</a></li>
						<li class=""><a href="<?php echo 'trabajadores_listado_carnet.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - Carnet</a></li>
						<li class=""><a href="<?php echo 'trabajadores_listado_rhtm.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - Permiso Trabajo Menor Edad</a></li>

					</ul>
                </li>
			</ul>
		</header>
        <div class="tab-content">

			<div class="tab-pane fade active in" id="basicos">
				<div class="wmd-panel">

					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<?php if ($rowData['Direccion_img']=='') { ?>
							<img style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="Imagen Referencia" src="<?php echo DB_SITE_REPO ?>/LIB_assets/img/usr.png">
						<?php }else{  ?>
							<img style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="Imagen Referencia" src="upload/<?php echo $rowData['Direccion_img']; ?>">
						<?php } ?>
					</div>
					<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos Básicos</h2>
						<p class="text-muted">
							<strong>Nombre : </strong><?php echo $rowData['Nombre'].' '.$rowData['ApellidoPat'].' '.$rowData['ApellidoMat']; ?><br/>
							<strong>Rut : </strong><?php echo $rowData['Rut']; ?><br/>
							<strong>Sexo : </strong><?php echo $rowData['Sexo']; ?><br/>
							<strong>Fecha de Nacimiento : </strong><?php echo Fecha_estandar($rowData['FNacimiento']); ?><br/>
							<strong>Fono : </strong><?php echo formatPhone($rowData['Fono']); ?><br/>
							<strong>Email : </strong><?php echo $rowData['email']; ?><br/>
							<strong>Dirección : </strong><?php echo $rowData['Direccion'].', '.$rowData['nombre_comuna'].', '.$rowData['nombre_region']; ?><br/>
							<strong>Estado Civil: </strong><?php echo $rowData['EstadoCivil']; ?><br/>
							<strong>Estado : </strong><?php echo $rowData['Estado']; ?><br/>
							<strong>Sistema : </strong><?php echo $rowData['Sistema']; ?>
						</p>

						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Cargas Familiares</h2>
						<p class="text-muted">
							<?php
							//Se existen cargas estas se despliegan
							if($arrCargas!=false){
								//variable
								$n_carga = 1;
								//recorro
								foreach ($arrCargas as $carga) {
									echo '<strong>Carga #'.$n_carga.' : </strong>'.$carga['Nombre'].' '.$carga['ApellidoPat'].' '.$carga['ApellidoMat'].'<br/>';
									$n_carga++;
								}
							//si no existen cargas se muestra mensaje
							}else{
								echo 'Trabajador sin cargas familiares';
							}
							?>
						</p>

						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos de Contacto</h2>
						<p class="text-muted">
							<strong>Persona de Contacto : </strong><?php echo $rowData['ContactoPersona']; ?><br/>
							<strong>Fono de Persona de Contacto : </strong><?php echo formatPhone($rowData['ContactoFono']); ?><br/>
						</p>

						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos Laborales</h2>
						<p class="text-muted word_break">
							<?php if(isset($rowData['Contratista'])&&$rowData['Contratista']!=''){ ?><strong>Contratista : </strong><?php echo $rowData['Contratista']; ?><br/><?php } ?>
							<strong>Tipo Trabajador : </strong><?php echo $rowData['TipoTrabajador']; ?><br/>
							<strong>Cargo : </strong><?php echo $rowData['Cargo']; ?><br/>
							<strong>AFP : </strong><?php echo $rowData['nombre_afp']; ?><br/>
							<strong>Salud : </strong><?php echo $rowData['nombre_salud']; ?><br/>
							<strong>Tipo de Contrato : </strong><?php echo $rowData['TipoContrato']; ?><br/>
							<strong>Fecha de Contrato : </strong><?php if(isset($rowData['FechaContrato'])&&$rowData['FechaContrato']!='0000-00-00'){echo Fecha_estandar($rowData['FechaContrato']);}else{echo 'Sin fecha de Contrato';} ?><br/>
							<strong>Fecha de Inicio Contrato : </strong><?php if(isset($rowData['F_Inicio_Contrato'])&&$rowData['F_Inicio_Contrato']!='0000-00-00'){echo Fecha_estandar($rowData['F_Inicio_Contrato']);}else{echo 'Sin fecha de inicio';} ?><br/>
							<strong>Fecha de Termino Contrato : </strong><?php if(isset($rowData['F_Termino_Contrato'])&&$rowData['F_Termino_Contrato']!='0000-00-00'){echo Fecha_estandar($rowData['F_Termino_Contrato']);}else{echo 'Sin fecha de termino';} ?><br/>
							<strong>Sueldo Liquido a Pago : </strong><?php echo valores($rowData['SueldoLiquido'], 0); ?><br/>
							<strong>Ubicación Trabajo : </strong><?php echo $rowData['UbicacionTrabajo']; ?><br/>
							<?php
							if(isset($rowData['CentroCosto_Nombre'])&&$rowData['CentroCosto_Nombre']!=''){
								echo '<strong>Centro de Costo : </strong>'.$rowData['CentroCosto_Nombre'];
								if(isset($rowData['CentroCosto_Level_1'])&&$rowData['CentroCosto_Level_1']!=''){echo ' - '.$rowData['CentroCosto_Level_1'];}
								if(isset($rowData['CentroCosto_Level_2'])&&$rowData['CentroCosto_Level_2']!=''){echo ' - '.$rowData['CentroCosto_Level_2'];}
								if(isset($rowData['CentroCosto_Level_3'])&&$rowData['CentroCosto_Level_3']!=''){echo ' - '.$rowData['CentroCosto_Level_3'];}
								if(isset($rowData['CentroCosto_Level_4'])&&$rowData['CentroCosto_Level_4']!=''){echo ' - '.$rowData['CentroCosto_Level_4'];}
								if(isset($rowData['CentroCosto_Level_5'])&&$rowData['CentroCosto_Level_5']!=''){echo ' - '.$rowData['CentroCosto_Level_5'];}
								echo '<br/>';
							}
							?>
							<strong>Observaciones : </strong><br/>
								<div class="text-muted well well-sm no-shadow">
									<?php if(isset($rowData['Observaciones'])&&$rowData['Observaciones']!=''){echo $rowData['Observaciones'];}else{echo 'Sin Observaciones';} ?>
									<div class="clearfix"></div>
								</div>
						</p>

						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Forma de Pago</h2>
						<p class="text-muted">
							<strong>Banco : </strong><?php echo $rowData['Pago_Banco']; ?><br/>
							<strong>Tipo de cuenta deposito : </strong><?php echo $rowData['Pago_TipoCuenta']; ?><br/>
							<strong>Nro. Cta. Deposito : </strong><?php echo $rowData['Pago_N_Cuenta']; ?><br/>
						</p>

						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Licencia de Conducir</h2>
						<p class="text-muted">
							<strong>Tipo de Licencia : </strong><?php echo $rowData['LicenciaTipo']; ?><br/>
							<strong>Numero CA : </strong><?php echo $rowData['LicenciaCA']; ?><br/>
							<strong>Fecha Ultimo Control : </strong><?php if(isset($rowData['LicenciaControlUlt'])&&$rowData['LicenciaControlUlt']!='0000-00-00'){echo Fecha_estandar($rowData['LicenciaControlUlt']);}else{echo 'Sin fecha de ultimo control';} ?><br/>
							<strong>Fecha Control : </strong><?php if(isset($rowData['LicenciaControl'])&&$rowData['LicenciaControl']!='0000-00-00'){echo Fecha_estandar($rowData['LicenciaControl']);}else{echo 'Sin fecha de control';} ?>
						</p>

						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Archivos</h2>
						<table id="items" style="margin-bottom: 20px;">
							<tbody>
								<?php
								//Contrato
								if(isset($rowData['File_Contrato'])&&$rowData['File_Contrato']!=''){
									echo '
										<tr class="item-row">
											<td>Contrato de Trabajo</td>
											<td width="10">
												<div class="btn-group" style="width: 70px;">
													<a href="view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['File_Contrato'], fecha_actual()).'" title="Ver Documento" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
													<a href="1download.php?dir='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['File_Contrato'], fecha_actual()).'" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-download" aria-hidden="true"></i></a>
												</div>
											</td>
										</tr>
									';
								}
								//Curriculum
								if(isset($rowData['File_Curriculum'])&&$rowData['File_Curriculum']!=''){
									echo '
										<tr class="item-row">
											<td>Curriculum</td>
											<td width="10">
												<div class="btn-group" style="width: 70px;">
													<a href="view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['File_Curriculum'], fecha_actual()).'" title="Ver Documento" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
													<a href="1download.php?dir='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['File_Curriculum'], fecha_actual()).'" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-download" aria-hidden="true"></i></a>
												</div>
											</td>
										</tr>
									';
								}
								//Antecedentes
								if(isset($rowData['File_Antecedentes'])&&$rowData['File_Antecedentes']!=''){
									echo '
										<tr class="item-row">
											<td>Papel de Antecedentes</td>
											<td width="10">
												<div class="btn-group" style="width: 70px;">
													<a href="view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['File_Antecedentes'], fecha_actual()).'" title="Ver Documento" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
													<a href="1download.php?dir='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['File_Antecedentes'], fecha_actual()).'" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-download" aria-hidden="true"></i></a>
												</div>
											</td>
										</tr>
									';
								}
								//Carnet
								if(isset($rowData['File_Carnet'])&&$rowData['File_Carnet']!=''){
									echo '
										<tr class="item-row">
											<td>Carnet de Identidad</td>
											<td width="10">
												<div class="btn-group" style="width: 70px;">
													<a href="view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['File_Carnet'], fecha_actual()).'" title="Ver Documento" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
													<a href="1download.php?dir='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['File_Carnet'], fecha_actual()).'" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-download" aria-hidden="true"></i></a>
												</div>
											</td>
										</tr>
									';
								}
								//Licencia
								if(isset($rowData['File_Licencia'])&&$rowData['File_Licencia']!=''){
									echo '
										<tr class="item-row">
											<td>Licencia de Conducir</td>
											<td width="10">
												<div class="btn-group" style="width: 70px;">
													<a href="view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['File_Licencia'], fecha_actual()).'" title="Ver Documento" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
													<a href="1download.php?dir='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['File_Licencia'], fecha_actual()).'" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-download" aria-hidden="true"></i></a>
												</div>
											</td>
										</tr>
									';
								}
								//RHTM
								if(isset($rowData['File_RHTM'])&&$rowData['File_RHTM']!=''){
									echo '
										<tr class="item-row">
											<td>RHTM Revisado el '.fecha_estandar($rowData['File_RHTM_Fecha']).'</td>
											<td width="10">
												<div class="btn-group" style="width: 70px;">
													<a href="view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['File_RHTM'], fecha_actual()).'" title="Ver Documento" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
													<a href="1download.php?dir='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['File_RHTM'], fecha_actual()).'" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-download" aria-hidden="true"></i></a>
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
validaPermisoUser($rowlevel['level'], 3, $dbConn); ?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Crear Trabajador</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($Nombre)){              $x1  = $Nombre;               }else{$x1  = '';}
				if(isset($ApellidoPat)){         $x2  = $ApellidoPat;          }else{$x2  = '';}
				if(isset($ApellidoMat)){         $x3  = $ApellidoMat;          }else{$x3  = '';}
				if(isset($Rut)){                 $x4  = $Rut;                  }else{$x4  = '';}
				if(isset($N_Documento)){         $x5  = $N_Documento;          }else{$x5  = '';}
				if(isset($idTipo)){              $x6  = $idTipo;               }else{$x6  = '';}
				if(isset($Cargo)){               $x7  = $Cargo;                }else{$x7  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_tittle(3, 'Datos Básicos');
				$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 2);
				$Form_Inputs->form_input_text('Apellido Paterno', 'ApellidoPat', $x2, 2);
				$Form_Inputs->form_input_text('Apellido Materno', 'ApellidoMat', $x3, 2);
				$Form_Inputs->form_input_rut('Rut', 'Rut', $x4, 2);
				$Form_Inputs->form_input_text('N Documento', 'N_Documento', $x5, 1);

				$Form_Inputs->form_tittle(3, 'Datos Laborales');
				$Form_Inputs->form_select('Tipo Trabajador','idTipo', $x6, 2, 'idTipo', 'Nombre', 'trabajadores_listado_tipos', 0, '', $dbConn);
				$Form_Inputs->form_input_text('Cargo', 'Cargo', $x7, 1);

				$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idEstado', 1, 2);
				$Form_Inputs->form_input_hidden('idTipoTrabajo', 1, 2);
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
		case 'nombre_asc':   $order_by = 'trabajadores_listado.ApellidoPat ASC, trabajadores_listado.ApellidoMat ASC, trabajadores_listado.Nombre ASC ';      $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente'; break;
		case 'nombre_desc':  $order_by = 'trabajadores_listado.ApellidoPat DESC, trabajadores_listado.ApellidoMat DESC, trabajadores_listado.Nombre DESC ';   $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Nombre Descendente';break;
		case 'tipo_asc':     $order_by = 'trabajadores_listado_tipos.Nombre ASC ';                                                                            $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Tipo Ascendente';break;
		case 'tipo_desc':    $order_by = 'trabajadores_listado_tipos.Nombre DESC ';                                                                           $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Tipo Descendente';break;
		case 'estado_asc':   $order_by = 'core_estados.Nombre ASC ';                                                                                          $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Estado Ascendente';break;
		case 'estado_desc':  $order_by = 'core_estados.Nombre DESC ';                                                                                         $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Estado Descendente';break;
		case 'rut_asc':      $order_by = 'trabajadores_listado.Rut ASC';                                                                                      $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Rut Ascendente'; break;
		case 'rut_desc':     $order_by = 'trabajadores_listado.Rut DESC';                                                                                     $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Rut Descendente';break;

		default: $order_by = 'trabajadores_listado.idEstado ASC, trabajadores_listado.ApellidoPat ASC, trabajadores_listado.ApellidoMat ASC, trabajadores_listado.Nombre ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente';
	}
}else{
	$order_by = 'trabajadores_listado.idEstado ASC, trabajadores_listado.ApellidoPat ASC, trabajadores_listado.ApellidoMat ASC, trabajadores_listado.Nombre ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente';
}
/**********************************************************/
//Variable de busqueda
$SIS_where = "trabajadores_listado.idTrabajador!=0";
//Verifico el tipo de usuario que esta ingresando
$SIS_where.= " AND trabajadores_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
/**********************************************************/
//Se aplican los filtros
if(isset($_GET['Nombre']) && $_GET['Nombre']!=''){     $SIS_where .= " AND trabajadores_listado.Nombre LIKE '%".EstandarizarInput($_GET['Nombre'])."%'";}
if(isset($_GET['ApellidoPat']) && $_GET['ApellidoPat']!=''){  $SIS_where .= " AND trabajadores_listado.ApellidoPat LIKE '%".EstandarizarInput($_GET['ApellidoPat'])."%'";}
if(isset($_GET['ApellidoMat']) && $_GET['ApellidoMat']!=''){  $SIS_where .= " AND trabajadores_listado.ApellidoMat LIKE '%".EstandarizarInput($_GET['ApellidoMat'])."%'";}
if(isset($_GET['Rut']) && $_GET['Rut']!=''){           $SIS_where .= " AND trabajadores_listado.Rut LIKE '%".EstandarizarInput($_GET['Rut'])."%'";}
if(isset($_GET['idTipo']) && $_GET['idTipo']!=''){     $SIS_where .= " AND trabajadores_listado.idTipo=".$_GET['idTipo'];}
if(isset($_GET['Cargo']) && $_GET['Cargo']!=''){       $SIS_where .= " AND trabajadores_listado.Cargo LIKE '%".EstandarizarInput($_GET['Cargo'])."%'";}
if(isset($_GET['Fono']) && $_GET['Fono']!=''){         $SIS_where .= " AND trabajadores_listado.Fono LIKE '%".EstandarizarInput($_GET['Fono'])."%'";}

/**********************************************************/
//Realizo una consulta para saber el total de elementos existentes
$cuenta_registros = db_select_nrows (false, 'idTrabajador', 'trabajadores_listado', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
//Realizo la operacion para saber la cantidad de paginas que hay
$total_paginas = ceil($cuenta_registros / $cant_reg);
// Se trae un listado con todos los elementos
$SIS_query = '
trabajadores_listado.idTrabajador,
trabajadores_listado.Rut, 
trabajadores_listado.Nombre,
trabajadores_listado.ApellidoPat, 
trabajadores_listado.ApellidoMat,
trabajadores_listado_tipos.Nombre AS Tipo,
core_sistemas.Nombre AS RazonSocial,
core_estados.Nombre AS Estado,
trabajadores_listado.idEstado';
$SIS_join  = '
LEFT JOIN `trabajadores_listado_tipos`    ON trabajadores_listado_tipos.idTipo   = trabajadores_listado.idTipo
LEFT JOIN `core_sistemas`                 ON core_sistemas.idSistema             = trabajadores_listado.idSistema
LEFT JOIN `core_estados`                  ON core_estados.idEstado               = trabajadores_listado.idEstado';
$SIS_order = $order_by.' LIMIT '.$comienzo.', '.$cant_reg;
$arrTrabajador = array();
$arrTrabajador = db_select_array (false, $SIS_query, 'trabajadores_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTrabajador');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar">

	<ul class="btn-group btn-breadcrumb pull-left">
		<li class="btn btn-default tooltip" role="button" data-toggle="collapse" href="#collapseForm" aria-expanded="false" aria-controls="collapseForm" title="Presionar para desplegar Formulario de Búsqueda" style="font-size: 14px;"><i class="fa fa-search faa-vertical animated" aria-hidden="true"></i></li>
		<li class="btn btn-default"><?php echo $bread_order; ?></li>
		<?php if(isset($_GET['filtro_form'])&&$_GET['filtro_form']!=''){ ?>
			<li class="btn btn-danger"><a href="<?php echo $original.'?pagina=1'; ?>" style="color:#fff;"><i class="fa fa-trash-o" aria-hidden="true"></i> Limpiar</a></li>
		<?php } ?>
	</ul>

	<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $location; ?>&new=true" class="btn btn-default pull-right margin_width fmrbtn" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Trabajador</a><?php } ?>
	<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $location; ?>&new_plantilla=true" class="btn btn-default pull-right margin_width fmrbtn" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear con Plantilla</a><?php } ?>

</div>
<div class="clearfix"></div>
<div class="collapse col-xs-12 col-sm-12 col-md-12 col-lg-12" id="collapseForm">
	<div class="well">
		<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
			<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" autocomplete="off" novalidate>
				<?php
				//Se verifican si existen los datos
				if(isset($Nombre)){              $x1  = $Nombre;               }else{$x1  = '';}
				if(isset($ApellidoPat)){         $x2  = $ApellidoPat;          }else{$x2  = '';}
				if(isset($ApellidoMat)){         $x3  = $ApellidoMat;          }else{$x3  = '';}
				if(isset($Rut)){                 $x4  = $Rut;                  }else{$x4  = '';}
				if(isset($idTipo)){              $x5  = $idTipo;               }else{$x5  = '';}
				if(isset($Cargo)){               $x6  = $Cargo;                }else{$x6  = '';}
				if(isset($Fono)){                $x7  = $Fono;                 }else{$x7  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 1);
				$Form_Inputs->form_input_text('Apellido Paterno', 'ApellidoPat', $x2, 1);
				$Form_Inputs->form_input_text('Apellido Materno', 'ApellidoMat', $x3, 1);
				$Form_Inputs->form_input_rut('Rut', 'Rut', $x4, 1);
				$Form_Inputs->form_select('Tipo Trabajador','idTipo', $x5, 1, 'idTipo', 'Nombre', 'trabajadores_listado_tipos', 0, '', $dbConn);
				$Form_Inputs->form_input_text('Cargo', 'Cargo', $x6, 1);
				$Form_Inputs->form_post_data(4,1,1, 'Al ingresar el numero telefónico omitir el +56 e ingresar el resto del número' );
				$Form_Inputs->form_input_phone('Fono', 'Fono', $x7, 1);

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
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Trabajadores</h5>
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
						<th width="120">
							<div class="pull-left">Rut</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=rut_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=rut_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Nombre</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=nombre_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=nombre_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th width="120">
							<div class="pull-left">Tipo</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=tipo_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=tipo_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th width="120">
							<div class="pull-left">Estado</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=estado_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=estado_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><th width="160">Sistema</th><?php } ?>
						<th width="10">Acciones</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
				<?php foreach ($arrTrabajador as $trab) { ?>
					<tr class="odd">
						<td><?php echo $trab['Rut']; ?></td>
						<td><?php echo $trab['ApellidoPat'].' '.$trab['ApellidoMat'].' '.$trab['Nombre']; ?></td>
						<td><?php echo $trab['Tipo']; ?></td>
						<td><label class="label <?php if(isset($trab['idEstado'])&&$trab['idEstado']==1){echo 'label-success';}else{echo 'label-danger';} ?>"><?php echo $trab['Estado']; ?></label></td>
						<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><td><?php echo $trab['RazonSocial']; ?></td><?php } ?>
						<td>
							<div class="btn-group" style="width: 105px;" >
								<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_trabajador.php?view='.simpleEncode($trab['idTrabajador'], fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
								<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'&id='.$trab['idTrabajador']; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
								<?php if ($rowlevel['level']>=4){
									$ubicacion = $location.'&del='.simpleEncode($trab['idTrabajador'], fecha_actual());
									$dialogo   = '¿Realmente deseas eliminar el trabajador '.$trab['Nombre'].' '.$trab['ApellidoPat'].' '.$trab['ApellidoMat'].'?'; ?>
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
