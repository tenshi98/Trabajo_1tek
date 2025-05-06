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
$original = "informe_cross_checking_07.php";
$location = $original;
//Se agregan ubicaciones
$search ='&submit_filter=Filtrar';
$location .= "?submit_filter=Filtrar";
if(isset($_GET['NSolicitud']) && $_GET['NSolicitud']!=''){   $location .= "&NSolicitud=".$_GET['NSolicitud'];          $search .= "&NSolicitud=".$_GET['NSolicitud'];}
if(isset($_GET['idPredio']) && $_GET['idPredio']!=''){       $location .= "&idPredio=".$_GET['idPredio'];              $search .= "&idPredio=".$_GET['idPredio'];}
if(isset($_GET['idZona']) && $_GET['idZona']!=''){           $location .= "&idZona=".$_GET['idZona'];                  $search .= "&idZona=".$_GET['idZona'];}
if(isset($_GET['idTemporada']) && $_GET['idTemporada']!=''){ $location .= "&idTemporada=".$_GET['idTemporada'];        $search .= "&idTemporada=".$_GET['idTemporada'];}
if(isset($_GET['idEstadoFen']) && $_GET['idEstadoFen']!=''){ $location .= "&idEstadoFen=".$_GET['idEstadoFen'];        $search .= "&idEstadoFen=".$_GET['idEstadoFen'];}
if(isset($_GET['idCategoria']) && $_GET['idCategoria']!=''){ $location .= "&idCategoria=".$_GET['idCategoria'];        $search .= "&idCategoria=".$_GET['idCategoria'];}
if(isset($_GET['idProducto']) && $_GET['idProducto']!=''){   $location .= "&idProducto=".$_GET['idProducto'];          $search .= "&idProducto=".$_GET['idProducto'];}
if(isset($_GET['idUsuario']) && $_GET['idUsuario']!=''){     $location .= "&idUsuario=".$_GET['idUsuario'];            $search .= "&idUsuario=".$_GET['idUsuario'];}
if(isset($_GET['idEstado']) && $_GET['idEstado']!=''){       $location .= "&idEstado=".$_GET['idEstado'];              $search .= "&idEstado=".$_GET['idEstado'];}
if(isset($_GET['f_programacion_desde'], $_GET['f_programacion_hasta'])&&$_GET['f_programacion_desde']!=''&&$_GET['f_programacion_hasta']!=''){
	$search .="&f_programacion_desde=".$_GET['f_programacion_desde'];
	$search .="&f_programacion_hasta=".$_GET['f_programacion_hasta'];
}
if(isset($_GET['f_ejecucion_desde'], $_GET['f_ejecucion_hasta'])&&$_GET['f_ejecucion_desde']!=''&&$_GET['f_ejecucion_hasta']!=''){
	$search .="&f_ejecucion_desde=".$_GET['f_ejecucion_desde'];
	$search .="&f_ejecucion_hasta=".$_GET['f_ejecucion_hasta'];
}
if(isset($_GET['f_termino_desde'], $_GET['f_termino_hasta'])&&$_GET['f_termino_desde']!=''&&$_GET['f_termino_hasta']!=''){
	$search .="&f_termino_desde=".$_GET['f_termino_desde'];
	$search .="&f_termino_hasta=".$_GET['f_termino_hasta'];
}     
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
/**********************************************************/
//paginador de resultados
if(isset($_GET["pagina"])){
	$num_pag = $_GET["pagina"];
} else {$num_pag = 1;
}
//Defino la cantidad total de elementos por pagina
$cant_reg = 30;
//resto de variables
if (!$num_pag){$comienzo = 0;$num_pag = 1;} else {$comienzo = ( $num_pag - 1 ) * $cant_reg ;}
/**********************************************************/
//Variable de busqueda
$SIS_where = "cross_solicitud_aplicacion_listado.idSolicitud!=0";
//Verifico el tipo de usuario que esta ingresando
$SIS_where.= " AND cross_solicitud_aplicacion_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
/**********************************************************/
//Se aplican los filtros
if(isset($_GET['NSolicitud']) && $_GET['NSolicitud']!=''){   $SIS_where .= " AND cross_solicitud_aplicacion_listado.NSolicitud=".$_GET['NSolicitud'];}
if(isset($_GET['idPredio']) && $_GET['idPredio']!=''){       $SIS_where .= " AND cross_solicitud_aplicacion_listado.idPredio=".$_GET['idPredio'];}
if(isset($_GET['idZona']) && $_GET['idZona']!=''){           $SIS_where .= " AND cross_solicitud_aplicacion_listado_cuarteles.idZona=".$_GET['idZona'];}
if(isset($_GET['idTemporada']) && $_GET['idTemporada']!=''){ $SIS_where .= " AND cross_solicitud_aplicacion_listado.idTemporada=".$_GET['idTemporada'];}
if(isset($_GET['idEstadoFen']) && $_GET['idEstadoFen']!=''){ $SIS_where .= " AND cross_solicitud_aplicacion_listado.idEstadoFen=".$_GET['idEstadoFen'];}
if(isset($_GET['idCategoria']) && $_GET['idCategoria']!=''){ $SIS_where .= " AND cross_solicitud_aplicacion_listado.idCategoria=".$_GET['idCategoria'];}
if(isset($_GET['idProducto']) && $_GET['idProducto']!=''){   $SIS_where .= " AND cross_solicitud_aplicacion_listado.idProducto=".$_GET['idProducto'];}
if(isset($_GET['idUsuario']) && $_GET['idUsuario']!=''){     $SIS_where .= " AND cross_solicitud_aplicacion_listado.idUsuario=".$_GET['idUsuario'];}
if(isset($_GET['idEstado']) && $_GET['idEstado']!=''){       $SIS_where .= " AND cross_solicitud_aplicacion_listado.idEstado=".$_GET['idEstado'];}
if(isset($_GET['f_programacion_desde'], $_GET['f_programacion_hasta'])&&$_GET['f_programacion_desde']!=''&&$_GET['f_programacion_hasta']!=''){
	$SIS_where.=" AND cross_solicitud_aplicacion_listado.f_programacion BETWEEN '".$_GET['f_programacion_desde']."' AND '".$_GET['f_programacion_hasta']."'";
}
if(isset($_GET['f_ejecucion_desde'], $_GET['f_ejecucion_hasta'])&&$_GET['f_ejecucion_desde']!=''&&$_GET['f_ejecucion_hasta']!=''){
	$SIS_where.=" AND cross_solicitud_aplicacion_listado.f_ejecucion BETWEEN '".$_GET['f_ejecucion_desde']."' AND '".$_GET['f_ejecucion_hasta']."'";
}
if(isset($_GET['f_termino_desde'], $_GET['f_termino_hasta'])&&$_GET['f_termino_desde']!=''&&$_GET['f_termino_hasta']!=''){
	$SIS_where.=" AND cross_solicitud_aplicacion_listado.f_termino BETWEEN '".$_GET['f_termino_desde']."' AND '".$_GET['f_termino_hasta']."'";
}
$SIS_join  = 'LEFT JOIN `cross_solicitud_aplicacion_listado_cuarteles`   ON cross_solicitud_aplicacion_listado_cuarteles.idSolicitud   = cross_solicitud_aplicacion_listado.idSolicitud';
/**********************************************************/
//Realizo una consulta para saber el total de elementos existentes
$cuenta_registros = db_select_nrows (false, 'cross_solicitud_aplicacion_listado.idSolicitud', 'cross_solicitud_aplicacion_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
//Realizo la operacion para saber la cantidad de paginas que hay
$total_paginas = ceil($cuenta_registros / $cant_reg);
// Se trae un listado con todos los elementos
$SIS_query = '
cross_solicitud_aplicacion_listado.NSolicitud,
cross_solicitud_aplicacion_listado.f_programacion,
cross_solicitud_aplicacion_listado.f_ejecucion,
cross_solicitud_aplicacion_listado.f_termino,
cross_solicitud_aplicacion_listado.f_programacion_fin,
cross_solicitud_aplicacion_listado.f_ejecucion_fin,
cross_solicitud_aplicacion_listado.f_termino_fin,
cross_solicitud_aplicacion_listado.horaProg,
cross_solicitud_aplicacion_listado.horaEjecucion,
cross_solicitud_aplicacion_listado.horaTermino,
cross_solicitud_aplicacion_listado.horaProg_fin,
cross_solicitud_aplicacion_listado.horaEjecucion_fin,
cross_solicitud_aplicacion_listado.horaTermino_fin,

cross_checking_temporada.Nombre AS TemporadaNombre,
cross_predios_listado_zonas.Nombre AS CuartelNombre,
cross_predios_listado_zonas.Hectareas AS CuartelHectareas,
sistema_variedades_categorias.Nombre AS VariedadCat,
variedades_listado.Nombre AS VariedadNombre,
productos_listado.Nombre AS ProductoNombre,
productos_listado.IngredienteActivo AS ProductoIngrediente,
productos_listado.Carencia AS ProductoCarencia,
productos_listado.AporteNutricional AS ProductoAporteNutricional,
cross_solicitud_aplicacion_listado_productos.DosisAplicar AS ProductoDosisAplicar,
sistema_productos_uml.Nombre AS ProductoUniMed,
cross_solicitud_aplicacion_listado_cuarteles.Mojamiento AS CuartelMojamiento,
cross_solicitud_aplicacion_listado_tractores.Diferencia AS Telem_Diferencia,
conductor.Rut AS ConductorRut,
conductor.Nombre AS ConductorNombre,
conductor.ApellidoPat AS ConductorApellidoPat,
dosificador.Rut AS DosificadorRut,
dosificador.Nombre AS DosificadorNombre,
dosificador.ApellidoPat AS DosificadorApellidoPat,
sistema_productos_categorias.Nombre AS ProductoCategoria


';
$SIS_join  = '
LEFT JOIN `cross_checking_temporada`                       ON cross_checking_temporada.idTemporada                       = cross_solicitud_aplicacion_listado.idTemporada
LEFT JOIN `cross_solicitud_aplicacion_listado_cuarteles`   ON cross_solicitud_aplicacion_listado_cuarteles.idSolicitud   = cross_solicitud_aplicacion_listado.idSolicitud
LEFT JOIN `cross_predios_listado_zonas`                    ON cross_predios_listado_zonas.idZona                         = cross_solicitud_aplicacion_listado_cuarteles.idZona
LEFT JOIN `sistema_variedades_categorias`                  ON sistema_variedades_categorias.idCategoria                  = cross_solicitud_aplicacion_listado.idCategoria
LEFT JOIN `variedades_listado`                             ON variedades_listado.idProducto                              = cross_solicitud_aplicacion_listado.idProducto
LEFT JOIN `cross_solicitud_aplicacion_listado_productos`   ON cross_solicitud_aplicacion_listado_productos.idCuarteles   = cross_solicitud_aplicacion_listado_cuarteles.idCuarteles
LEFT JOIN `productos_listado`                              ON productos_listado.idProducto                               = cross_solicitud_aplicacion_listado_productos.idProducto
LEFT JOIN `sistema_productos_uml`                          ON sistema_productos_uml.idUml                                = cross_solicitud_aplicacion_listado_productos.idUml
LEFT JOIN `cross_solicitud_aplicacion_listado_tractores`   ON cross_solicitud_aplicacion_listado_tractores.idCuarteles   = cross_solicitud_aplicacion_listado_cuarteles.idCuarteles
LEFT JOIN `trabajadores_listado`       conductor           ON conductor.idTrabajador                                     = cross_solicitud_aplicacion_listado_tractores.idTrabajador
LEFT JOIN `trabajadores_listado`     dosificador           ON dosificador.idTrabajador                                   = cross_solicitud_aplicacion_listado.idDosificador
LEFT JOIN `sistema_productos_categorias`                   ON sistema_productos_categorias.idCategoria                   = productos_listado.idCategoria



';
$SIS_order = 'cross_solicitud_aplicacion_listado.NSolicitud ASC LIMIT '.$comienzo.', '.$cant_reg;
$arrOTS = array();
$arrOTS = db_select_array (false, $SIS_query, 'cross_solicitud_aplicacion_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrOTS');


?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 clearfix">
	<?php
	$search .= '&idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
	$search .= '&idTipoUsuario='.$_SESSION['usuario']['basic_data']['idTipoUsuario'];
	?>		
	<a target="new" href="<?php echo 'informe_cross_checking_07_to_excel.php?bla=bla'.$search ; ?>" class="btn btn-sm btn-metis-2 pull-right margin_width"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Exportar a Excel</a>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Registro de Aplicaciones</h5>
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
						<th>Nro. Solicitud</th>
						<th>Fecha Inicio</th>
						<th>Fecha Termino</th>
						<th>Temporada</th>
						<th>Horario Inicio</th>
						<th>Horario Termino</th>
						<th>Codigo Contable</th>
						<th>N° Cuartel</th>
						<th>Superficie cuartel (Hectareas)</th>
						<th>Especie</th>
						<th>Variedad</th>
						<th>Nombre comercial producto</th>
						<th>Ingrediente Activo</th>
						<th>Aporte Nutricional</th>
						<th>Dosis (Unid/100L)</th>
						<th>Unidad Medida</th>
						<th>Mojamiento</th>
						<th>lts. Aplicados</th>
						<th>Dosis x HA</th>
						<th>Total Producto Aplicado</th>
						<th>N° Maquinadas</th>
						<th>Dias para Cosechar</th>
						<th>Fecha de cosecha</th>
						<th>Fecha viable de cosecha</th>
						<th>Metodo de aplicacion</th>
						<th>Carencia (Dias)</th>
						<th>Aplicador</th>
						<th>Dosificador</th>
						<th>Tecnico Responsable</th>
						<th>Tipo de Familia</th>
						<th>Reingreso SAG</th>
						<th>Toxicidad</th>
						<th>Reingreso 48 hrs</th>
						<th>EPP</th>
						<th>Control de</th>
						<th>Especie</th>
						<th>Consumo de Agua</th>
						<th>Condición Climatica C°</th>
						<th>Viento KM</th>
						<th>Lavado de maquinaria</th>
						<th>Caldo sobrante</th>
						<th>Uso de EPP</th>

					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrOTS as $ot) {
						//Especie
						if(isset($ot['VariedadCat'])&&$ot['VariedadCat']!=''){
							$VariedadCat = $ot['VariedadCat'];
						}else{
							$VariedadCat = 'Todas las especies';
						}
						//Variedad
						if(isset($ot['VariedadNombre'])&&$ot['VariedadNombre']!=''){
							$VariedadNombre = $ot['VariedadNombre'];
						}else{
							$VariedadNombre = 'Todas las variedades';
						}

						?>

						<tr class="odd">
							<td><?php echo n_doc($ot['NSolicitud'], 5); ?></td>
							<td>
								<?php 
								if(isset($ot['f_programacion'])&&$ot['f_programacion']!='00-00-0000'){ echo '<strong>Programada: </strong>'.fecha_estandar($ot['f_programacion']).'<br/>';}
								if(isset($ot['f_ejecucion'])&&$ot['f_ejecucion']!='00-00-0000'){       echo '<strong>Ejecutada: </strong>'.fecha_estandar($ot['f_ejecucion']).'<br/>';}
								if(isset($ot['f_termino'])&&$ot['f_termino']!='00-00-0000'){           echo '<strong>Terminada: </strong>'.fecha_estandar($ot['f_termino']);}
								?>
							</td>
							<td>
								<?php 
								if(isset($ot['f_programacion_fin'])&&$ot['f_programacion_fin']!='00-00-0000'){ echo '<strong>Programada: </strong>'.fecha_estandar($ot['f_programacion_fin']).'<br/>';}
								if(isset($ot['f_ejecucion_fin'])&&$ot['f_ejecucion_fin']!='00-00-0000'){       echo '<strong>Ejecutada: </strong>'.fecha_estandar($ot['f_ejecucion_fin']).'<br/>';}
								if(isset($ot['f_termino_fin'])&&$ot['f_termino_fin']!='00-00-0000'){           echo '<strong>Terminada: </strong>'.fecha_estandar($ot['f_termino_fin']);}
								?>
							</td>
							<td><?php echo $ot['TemporadaNombre']; ?></td>
							<td>
								<?php 
								if(isset($ot['horaProg'])&&$ot['horaProg']!='00:00:00'){           echo '<strong>Programada: </strong>'.$ot['horaProg'].'<br/>';}
								if(isset($ot['horaEjecucion'])&&$ot['horaEjecucion']!='00:00:00'){ echo '<strong>Ejecutada: </strong>'.$ot['horaEjecucion'].'<br/>';}
								if(isset($ot['horaTermino'])&&$ot['horaTermino']!='00:00:00'){     echo '<strong>Terminada: </strong>'.$ot['horaTermino'];}
								?>
							</td>
							<td>
								<?php 
								if(isset($ot['horaProg_fin'])&&$ot['horaProg_fin']!='00:00:00'){           echo '<strong>Programada: </strong>'.$ot['horaProg_fin'].'<br/>';}
								if(isset($ot['horaEjecucion_fin'])&&$ot['horaEjecucion_fin']!='00:00:00'){ echo '<strong>Ejecutada: </strong>'.$ot['horaEjecucion_fin'].'<br/>';}
								if(isset($ot['horaTermino_fin'])&&$ot['horaTermino_fin']!='00:00:00'){     echo '<strong>Terminada: </strong>'.$ot['horaTermino_fin'];}
								?>
							</td>
							<td><strong>Codigo Contable</strong></td>
							<td><?php echo $ot['CuartelNombre']; ?></td>
							<td><?php echo $ot['CuartelHectareas']; ?></td>
							<td><?php echo $VariedadCat; ?></td>
							<td><?php echo $VariedadNombre; ?></td>
							<td><?php echo $ot['ProductoNombre']; ?></td>
							<td><?php echo $ot['ProductoIngrediente']; ?></td>
							<td><?php echo $ot['ProductoAporteNutricional']; ?></td>
							<td><?php echo $ot['ProductoDosisAplicar']; ?></td>
							<td><?php echo $ot['ProductoUniMed']; ?></td>
							<td><?php echo Cantidades($ot['CuartelMojamiento'], 0); ?></td>
							<td><?php echo Cantidades($ot['Telem_Diferencia'], 0); ?></td>
							<td><strong>Dosis x HA</strong></td>
							<td><strong>Total Producto Aplicado</strong></td>
							<td><strong>N° Maquinadas</strong></td>
							<td><strong>Dias para Cosechar</strong></td>
							<td><strong>Fecha de cosecha</strong></td>
							<td><strong>Fecha viable de cosecha</strong></td>
							<td><strong>Metodo de aplicacion</strong></td>
							<td><?php echo $ot['ProductoCarencia']; ?></td>
							<td><?php echo $ot['ConductorRut'].' - '.$ot['ConductorNombre'].' '.$ot['ConductorApellidoPat']; ?></td>
							<td><?php echo $ot['DosificadorRut'].' - '.$ot['DosificadorNombre'].' '.$ot['DosificadorApellidoPat']; ?></td>
							<td><strong>Tecnico Responsable</strong></td>
							<td><?php echo $ot['ProductoCategoria']; ?></td>
							<td><strong>Reingreso SAG</strong></td>
							<td><strong>Toxicidad</strong></td>
							<td><strong>Reingreso 48 hrs</strong></td>
							<td><strong>EPP</strong></td>
							<td><strong>Control de</strong></td>
							<td><strong>Especie</strong></td>
							<td><strong>Consumo de Agua</strong></td>
							<td><strong>Condición Climatica C°</strong></td>
							<td><strong>Viento KM</strong></td>
							<td><strong>Lavado de maquinaria</strong></td>
							<td><strong>Caldo sobrante</strong></td>
							<td><strong>Uso de EPP</strong></td>

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

<div class="clearfix"></div>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
	<a href="<?php echo $original; ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
	<div class="clearfix"></div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
//Verifico el tipo de usuario que esta ingresando
$usrfil = 'usuarios_listado.idEstado=1 AND usuarios_listado.idTipoUsuario!=1';
//Verifico el tipo de usuario que esta ingresando
if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
	$usrfil .= " AND usuarios_sistemas.idSistema = ".$_SESSION['usuario']['basic_data']['idSistema'];
}
$y = "idEstado=1";
$x = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
$w = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];

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
				if(isset($NSolicitud)){             $x1  = $NSolicitud;             }else{$x1  = '';}
				if(isset($idPredio)){               $x2  = $idPredio;               }else{$x2  = '';}
				if(isset($idZona)){                 $x3  = $idZona;                 }else{$x3  = '';}
				if(isset($idTemporada)){            $x4  = $idTemporada;            }else{$x4  = '';}
				if(isset($idEstadoFen)){            $x5  = $idEstadoFen;            }else{$x5  = '';}
				if(isset($idCategoria)){            $x6  = $idCategoria;            }else{$x6  = '';}
				if(isset($idProducto)){             $x7  = $idProducto;             }else{$x7  = '';}
				if(isset($f_programacion_desde)){   $x8  = $f_programacion_desde;   }else{$x8  = '';}
				if(isset($f_programacion_hasta)){   $x9  = $f_programacion_hasta;   }else{$x9  = '';}
				if(isset($f_ejecucion_desde)){      $x10 = $f_ejecucion_desde;      }else{$x10 = '';}
				if(isset($f_ejecucion_hasta)){      $x11 = $f_ejecucion_hasta;      }else{$x11 = '';}
				if(isset($f_termino_desde)){        $x12 = $f_termino_desde;        }else{$x12 = '';}
				if(isset($f_termino_hasta)){        $x13 = $f_termino_hasta;        }else{$x13 = '';}
				if(isset($idUsuario)){              $x14 = $idUsuario;              }else{$x14 = '';}
				if(isset($idEstado)){               $x15 = $idEstado;               }else{$x15 = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_filter('Temporada','idTemporada', $x4, 1, 'idTemporada', 'Codigo,Nombre', 'cross_checking_temporada', $y, '', $dbConn);
				$Form_Inputs->form_select_depend1('Predio','idPredio', $x2, 1, 'idPredio', 'Nombre', 'cross_predios_listado', $x, 0,
										 'Cuarteles','idZona', $x3, 1, 'idZona', 'Nombre', 'cross_predios_listado_zonas', 'idEstado=1', 0,
										 $dbConn, 'form1');
				$Form_Inputs->form_select_depend1('Especie','idCategoria', $x6, 1, 'idCategoria', 'Nombre', 'sistema_variedades_categorias', 0, 0,
										 'Variedad','idProducto', $x7, 1, 'idProducto', 'Nombre', 'variedades_listado', 'idEstado=1', 0,
										 $dbConn, 'form1');					 
				$Form_Inputs->form_select_filter('N° Solicitud','NSolicitud', $x1, 1, 'NSolicitud', 'NSolicitud', 'cross_solicitud_aplicacion_listado', $w, '', $dbConn);
				$Form_Inputs->form_select('Estado','idEstado', $x15, 2, 'idEstado', 'Nombre', 'core_estado_solicitud', 0, '', $dbConn);
				$Form_Inputs->form_date('Fecha Programada Desde','f_programacion_desde', $x8, 1);
				$Form_Inputs->form_date('Fecha Programada Hasta','f_programacion_hasta', $x9, 1);
				$Form_Inputs->form_date('Fecha Ejecutada Desde','f_ejecucion_desde', $x10, 1);
				$Form_Inputs->form_date('Fecha Ejecutada Hasta','f_ejecucion_hasta', $x11, 1);
				$Form_Inputs->form_date('Fecha Terminada Desde','f_termino_desde', $x12, 1);
				$Form_Inputs->form_date('Fecha Terminada Hasta','f_termino_hasta', $x13, 1);
				
				/*
				$Form_Inputs->form_select_join_filter('Usuario Creador','idUsuario', $x14, 1, 'idUsuario', 'Nombre', 'usuarios_listado', 'usuarios_sistemas',$usrfil, $dbConn);
				$Form_Inputs->form_select('Estado','idEstado', $x15, 1, 'idEstado', 'Nombre', 'core_estado_solicitud', 0, '', $dbConn);
				$Form_Inputs->form_input_number('N° Solicitud','NSolicitud', $x1, 1);
				$Form_Inputs->form_select_filter('Estado Fenológico','idEstadoFen', $x5, 1, 'idEstadoFen', 'Codigo,Nombre', 'cross_checking_estado_fenologico', $y, '', $dbConn);
					*/	
				?>

				<script>
					/**********************************************************************/
					$(document).ready(function(){
						document.getElementById('div_f_programacion_desde').style.display = 'none';
						document.getElementById('div_f_programacion_hasta').style.display = 'none';
						document.getElementById('div_f_ejecucion_desde').style.display = 'none';
						document.getElementById('div_f_ejecucion_hasta').style.display = 'none';
						document.getElementById('div_f_termino_desde').style.display = 'none';
						document.getElementById('div_f_termino_hasta').style.display = 'none';
					});

					/**********************************************************************/
					document.getElementById("idEstado").onchange = function() {LoadEstado(1)};

					/**********************************************************************/
					function LoadEstado(caseLoad){
						//obtengo los valores
						let idEstado = $("#idEstado").val();
						//selecciono
						switch(idEstado) {
							//Solicitado
							case '1':
								document.getElementById('div_f_programacion_desde').style.display = 'block';
								document.getElementById('div_f_programacion_hasta').style.display = 'block';
								document.getElementById('div_f_ejecucion_desde').style.display = 'none';
								document.getElementById('div_f_ejecucion_hasta').style.display = 'none';
								document.getElementById('div_f_termino_desde').style.display = 'none';
								document.getElementById('div_f_termino_hasta').style.display = 'none';
								//Reseteo los valores a 0
								if(caseLoad==1){
									document.querySelector('input[name="f_ejecucion_desde"]').value = '';
									document.querySelector('input[name="f_ejecucion_hasta"]').value = '';
									document.querySelector('input[name="f_termino_desde"]').value = '';
									document.querySelector('input[name="f_termino_hasta"]').value = '';
								}
							break;
							//Programado
							case '2':
								document.getElementById('div_f_programacion_desde').style.display = 'none';
								document.getElementById('div_f_programacion_hasta').style.display = 'none';
								document.getElementById('div_f_ejecucion_desde').style.display = 'block';
								document.getElementById('div_f_ejecucion_hasta').style.display = 'block';
								document.getElementById('div_f_termino_desde').style.display = 'none';
								document.getElementById('div_f_termino_hasta').style.display = 'none';
								//Reseteo los valores a 0
								if(caseLoad==1){
									document.querySelector('input[name="f_programacion_desde"]').value = '';
									document.querySelector('input[name="f_programacion_hasta"]').value = '';
									document.querySelector('input[name="f_termino_desde"]').value = '';
									document.querySelector('input[name="f_termino_hasta"]').value = '';
								}
							break;
							//Ejecutado
							case '3':
								document.getElementById('div_f_programacion_desde').style.display = 'none';
								document.getElementById('div_f_programacion_hasta').style.display = 'none';
								document.getElementById('div_f_ejecucion_desde').style.display = 'none';
								document.getElementById('div_f_ejecucion_hasta').style.display = 'none';
								document.getElementById('div_f_termino_desde').style.display = 'block';
								document.getElementById('div_f_termino_hasta').style.display = 'block';
								//Reseteo los valores a 0
								if(caseLoad==1){
									document.querySelector('input[name="f_programacion_desde"]').value = '';
									document.querySelector('input[name="f_programacion_hasta"]').value = '';
									document.querySelector('input[name="f_ejecucion_desde"]').value = '';
									document.querySelector('input[name="f_ejecucion_hasta"]').value = '';
								}
							break;
							//el resto
							default:
								document.getElementById('div_f_programacion_desde').style.display = 'none';
								document.getElementById('div_f_programacion_hasta').style.display = 'none';
								document.getElementById('div_f_ejecucion_desde').style.display = 'none';
								document.getElementById('div_f_ejecucion_hasta').style.display = 'none';
								document.getElementById('div_f_termino_desde').style.display = 'none';
								document.getElementById('div_f_termino_hasta').style.display = 'none';
								//Reseteo los valores a 0
								if(caseLoad==1){
									document.querySelector('input[name="f_programacion_desde"]').value = '';
									document.querySelector('input[name="f_programacion_hasta"]').value = '';
									document.querySelector('input[name="f_ejecucion_desde"]').value = '';
									document.querySelector('input[name="f_ejecucion_hasta"]').value = '';
									document.querySelector('input[name="f_termino_desde"]').value = '';
									document.querySelector('input[name="f_termino_hasta"]').value = '';
								}
							break;
						}
					}

				</script>

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
