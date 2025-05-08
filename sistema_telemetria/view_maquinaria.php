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
require_once 'core/Load.Utils.Views.php';
/**********************************************************************************************************************************/
/*                                                 Variables Globales                                                             */
/**********************************************************************************************************************************/
//Tiempo Maximo de la consulta, 40 minutos por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigTime'])&&$_SESSION['usuario']['basic_data']['ConfigTime']!=0){$n_lim = $_SESSION['usuario']['basic_data']['ConfigTime']*60;set_time_limit($n_lim);}else{set_time_limit(2400);}
//Memora RAM Maxima del servidor, 4GB por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigRam'])&&$_SESSION['usuario']['basic_data']['ConfigRam']!=0){$n_ram = $_SESSION['usuario']['basic_data']['ConfigRam']; ini_set('memory_limit', $n_ram.'M');}else{ini_set('memory_limit', '4096M');}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Views.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Version antigua de view
//se verifica si es un numero lo que se recibe
if (validarNumero($_GET['view'])){
	//Verifica si el numero recibido es un entero
	if (validaEntero($_GET['view'])){
		$X_Puntero = $_GET['view'];
	} else {
		$X_Puntero = simpleDecode($_GET['view'], fecha_actual());
	}
} else {
	$X_Puntero = simpleDecode($_GET['view'], fecha_actual());
}
/**************************************************************/
//se traen los datos basicos de la licitacion
$SIS_query = '
maquinas_listado.Codigo,
maquinas_listado.Nombre,
maquinas_listado.Modelo,
maquinas_listado.Serie,
maquinas_listado.Fabricante,
maquinas_listado.fincorporacion,
maquinas_listado.Direccion_img,
maquinas_listado.Descripcion,
maquinas_listado.FichaTecnica,
maquinas_listado.HDS,
maquinas_listado.idConfig_1,
core_estados.Nombre AS Estado,
ops1.Nombre AS Componentes,
ops2.Nombre AS Matriz';
$SIS_join  = '
LEFT JOIN `core_estados`                  ON core_estados.idEstado  = maquinas_listado.idEstado
LEFT JOIN `core_sistemas_opciones` ops1   ON ops1.idOpciones        = maquinas_listado.idConfig_1
LEFT JOIN `core_sistemas_opciones` ops2   ON ops2.idOpciones        = maquinas_listado.idConfig_2';
$SIS_where = 'maquinas_listado.idMaquina='.$X_Puntero;
$rowData = db_select_data (false, $SIS_query, 'maquinas_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');


if(isset($rowData['idConfig_1'])&&$rowData['idConfig_1']==1){
	//Se crean las variables
	$nmax = 10;
	$SIS_query = 'maquinas_listado_level_1.idLevel_1 AS bla';
	$SIS_join  = '';
	$SIS_order = 'maquinas_listado_level_1.Nombre ASC';
	for ($i = 1; $i <= $nmax; $i++) {
		//consulta
		$SIS_query .= ',maquinas_listado_level_'.$i.'.idLevel_'.$i.' AS LVL_'.$i.'_id';
		$SIS_query .= ',maquinas_listado_level_'.$i.'.Nombre AS LVL_'.$i.'_Nombre';
		$SIS_query .= ',maquinas_listado_level_'.$i.'.idUtilizable AS LVL_'.$i.'_idUtilizable';
		$SIS_query .= ',maquinas_listado_level_'.$i.'.tabla AS LVL_'.$i.'_table';
		$SIS_query .= ',maquinas_listado_level_'.$i.'.table_value AS LVL_'.$i.'_table_value';
		$SIS_query .= ',maquinas_listado_level_'.$i.'.Direccion_img AS LVL_'.$i.'_imagen ';
		//Joins
		$xx = $i + 1;
		if($xx<=$nmax){
			$SIS_join .= ' LEFT JOIN `maquinas_listado_level_'.$xx.'`   ON maquinas_listado_level_'.$xx.'.idLevel_'.$i.'    = maquinas_listado_level_'.$i.'.idLevel_'.$i;
		}
		//ORDER BY
		$SIS_order .= ', maquinas_listado_level_'.$i.'.Nombre ASC';
	}

	//se hace la consulta
	$SIS_where = 'maquinas_listado_level_1.idMaquina='.$X_Puntero;
	$arrItemizado = array();
	$arrItemizado = db_select_array (false, $SIS_query, 'maquinas_listado_level_1', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrItemizado');

	/*********************************************************************/
	// Se trae un listado con todos los tipos de componentes
	$SIS_query = 'idUtilizable, Nombre';
	$SIS_join  = '';
	$SIS_where = 'Nombre!=""';
	$SIS_order = 'idUtilizable ASC';
	$arrTipos = array();
	$arrTipos = db_select_array (false, $SIS_query, 'core_maquinas_tipo_componente', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTipos');

	//Se crea el arreglo
	$TipoMaq = array();
	foreach($arrTipos as $tipo) {
		$TipoMaq[$tipo['idUtilizable']]['idUtilizable']  = $tipo['idUtilizable'];
		$TipoMaq[$tipo['idUtilizable']]['Nombre']        = $tipo['Nombre'];
	}

	/*********************************************************************/
	$array3d = array();
	foreach($arrItemizado as $key) {

		//Creo Variables para la rejilla
		for ($i = 1; $i <= $nmax; $i++) {

			//creo la variable vacia
			$d[$i]  = '';
			$n[$i]  = '';
			$u[$i]  = '';
			$y[$i]  = '';
			$m[$i]  = '';
			$t[$i]  = '';

			//si el dato solicitado tiene valores sobreescribe la variable
			if(isset($key['LVL_'.$i.'_id'])&&$key['LVL_'.$i.'_id']!=''){                     $d[$i]  = $key['LVL_'.$i.'_id'];}
			if(isset($key['LVL_'.$i.'_Nombre'])&&$key['LVL_'.$i.'_Nombre']!=''){             $n[$i]  = $key['LVL_'.$i.'_Nombre'];}
			if(isset($key['LVL_'.$i.'_idUtilizable'])&&$key['LVL_'.$i.'_idUtilizable']!=''){ $u[$i]  = $key['LVL_'.$i.'_idUtilizable'];}
			if(isset($key['LVL_'.$i.'_table'])&&$key['LVL_'.$i.'_table']!=''){               $y[$i]  = $key['LVL_'.$i.'_table'];}
			if(isset($key['LVL_'.$i.'_table_value'])&&$key['LVL_'.$i.'_table_value']!=''){   $m[$i]  = $key['LVL_'.$i.'_table_value'];}
			if(isset($key['LVL_'.$i.'_imagen'])&&$key['LVL_'.$i.'_imagen']!=''){             $t[$i]  = $key['LVL_'.$i.'_imagen'];}

		}

		if( $d['1']!=''){
			$array3d[$d['1']]['id']         = $d['1'];
			$array3d[$d['1']]['Nombre']     = $n['1'];
			$array3d[$d['1']]['Tipo']       = $u['1'];
			$array3d[$d['1']]['Tabla']      = $y['1'];
			$array3d[$d['1']]['Valor']      = $m['1'];
			$array3d[$d['1']]['Imagen']     = $t['1'];
		}
		if( $d['2']!=''){
			$array3d[$d['1']][$d['2']]['id']         = $d['2'];
			$array3d[$d['1']][$d['2']]['Nombre']     = $n['2'];
			$array3d[$d['1']][$d['2']]['Tipo']       = $u['2'];
			$array3d[$d['1']][$d['2']]['Tabla']      = $y['2'];
			$array3d[$d['1']][$d['2']]['Valor']      = $m['2'];
			$array3d[$d['1']][$d['2']]['Imagen']     = $t['2'];
		}
		if( $d['3']!=''){
			$array3d[$d['1']][$d['2']][$d['3']]['id']         = $d['3'];
			$array3d[$d['1']][$d['2']][$d['3']]['Nombre']     = $n['3'];
			$array3d[$d['1']][$d['2']][$d['3']]['Tipo']       = $u['3'];
			$array3d[$d['1']][$d['2']][$d['3']]['Tabla']      = $y['3'];
			$array3d[$d['1']][$d['2']][$d['3']]['Valor']      = $m['3'];
			$array3d[$d['1']][$d['2']][$d['3']]['Imagen']     = $t['3'];
		}
		if( $d['4']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']]['id']         = $d['4'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']]['Nombre']     = $n['4'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']]['Tipo']       = $u['4'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']]['Tabla']      = $y['4'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']]['Valor']      = $m['4'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']]['Imagen']     = $t['4'];
		}
		if( $d['5']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']]['id']         = $d['5'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']]['Nombre']     = $n['5'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']]['Tipo']       = $u['5'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']]['Tabla']      = $y['5'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']]['Valor']      = $m['5'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']]['Imagen']     = $t['5'];
		}
		if( $d['6']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']]['id']         = $d['6'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']]['Nombre']     = $n['6'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']]['Tipo']       = $u['6'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']]['Tabla']      = $y['6'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']]['Valor']      = $m['6'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']]['Imagen']     = $t['6'];
		}
		if( $d['7']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']]['id']         = $d['7'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']]['Nombre']     = $n['7'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']]['Tipo']       = $u['7'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']]['Tabla']      = $y['7'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']]['Valor']      = $m['7'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']]['Imagen']     = $t['7'];
		}
		if( $d['8']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']]['id']         = $d['8'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']]['Nombre']     = $n['8'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']]['Tipo']       = $u['8'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']]['Tabla']      = $y['8'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']]['Valor']      = $m['8'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']]['Imagen']     = $t['8'];
		}
		if( $d['9']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']]['id']         = $d['9'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']]['Nombre']     = $n['9'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']]['Tipo']       = $u['9'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']]['Tabla']      = $y['9'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']]['Valor']      = $m['9'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']]['Imagen']     = $t['9'];
		}
		if( $d['10']!=''){
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']]['id']         = $d['10'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']]['Nombre']     = $n['10'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']]['Tipo']       = $u['10'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']]['Tabla']      = $y['10'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']]['Valor']      = $m['10'];
			$array3d[$d['1']][$d['2']][$d['3']][$d['4']][$d['5']][$d['6']][$d['7']][$d['8']][$d['9']][$d['10']]['Imagen']     = $t['10'];
		}
	}

	function arrayToUL(array $array, array $TipoMaq, $lv, $rowlevel,$location, $nmax)	{
		$lv++;
		if($lv==1){
			echo '<ul class="tree">';
		}else{
			echo '<ul style="padding-left: 20px;">';
		}

		foreach ($array as $key => $value){
			//Rearmo la ubicacion de acuerdo a la profundidad
			if (isset($value['id'])){
				$loc = $location.'&lv_'.$lv.'='.$value['id'];
			}else{
				$loc = $location;
			}

			if (isset($value['Nombre'])){
				echo '<li><div class="blum">';
					echo '<div class="pull-left">';
						if(isset($value['Imagen'])&&$value['Imagen']!=''){echo '<div class="btn-group" style="width: 35px;" ><a href="#" title="Click Preview Imagen" class="btn btn-primary btn-sm tooltip pop" src="upload/'.$value['Imagen'].'"><i class="fa fa-picture-o" aria-hidden="true"></i></a></div>';}
						echo '<strong>'.$TipoMaq[$value['Tipo']]['Nombre'].':</strong> ';
						echo $value['Nombre'];
					echo '</div>';
					echo '<div class="clearfix"></div>';
				echo '</div>';
			}
			if (!empty($value) && is_array($value)){
				echo arrayToUL($value, $TipoMaq, $lv, $rowlevel,$loc, $nmax);
			}
			echo '</li>';
		}
		echo '</ul>';
	}
}

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Ver Datos de la Maquina</h5>
		</header>
		<div class="tab-content">

			<div class="tab-pane fade active in" id="basicos">
				<div class="wmd-panel">
					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<?php if ($rowData['Direccion_img']=='') { ?>
							<img style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="Imagen Referencia" src="<?php echo DB_SITE_REPO ?>/Legacy/1tek_public/img/maquina.jpg">
						<?php }else{  ?>
							<img style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="Imagen Referencia" src="upload/<?php echo $rowData['Direccion_img']; ?>">
						<?php } ?>
					</div>
					<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos Básicos</h2>
						<p class="text-muted">
							<strong>Nombre : </strong><?php echo $rowData['Nombre']; ?><br/>
							<strong>Codigo : </strong><?php echo $rowData['Codigo']; ?><br/>
							<strong>Modelo : </strong><?php echo $rowData['Modelo']; ?><br/>
							<strong>Serie : </strong><?php echo $rowData['Serie']; ?><br/>
							<strong>Fabricante : </strong><?php echo $rowData['Fabricante']; ?><br/>
							<strong>Fecha incorporacion : </strong><?php echo fecha_estandar($rowData['fincorporacion']); ?><br/>
							<strong>Estado : </strong><?php echo $rowData['Estado']; ?><br/>
						</p>

						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Configuracion</h2>
						<p class="text-muted">
							<strong>Componentes : </strong><?php echo $rowData['Componentes']; ?><br/>
							<strong>Matriz de Analisis: </strong><?php echo $rowData['Matriz']; ?>
						</p>

						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Descripción</h2>
						<p class="text-muted"><?php echo $rowData['Descripcion']; ?></p>

						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Archivos</h2>
						<p class="text-muted">
							<?php
							//Ficha Tecnica
							if(isset($rowData['FichaTecnica'])&&$rowData['FichaTecnica']!=''){
								echo '<a href="1download.php?dir='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['FichaTecnica'], fecha_actual()).'" class="btn btn-xs btn-primary" style="margin-right: 5px;"><i class="fa fa-download" aria-hidden="true"></i> Descargar Ficha Tecnica</a>';
							}
							//Hoja de seguridad
							if(isset($rowData['HDS'])&&$rowData['HDS']!=''){
								echo '<a href="1download.php?dir='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['HDS'], fecha_actual()).'" class="btn btn-xs btn-primary" style="margin-right: 5px;"><i class="fa fa-download" aria-hidden="true"></i> Descargar Hoja de Seguridad</a>';
							}
							?>

						</p>

					</div>
					<div class="clearfix"></div>

					<?php
						//Uso de componentes
						if(isset($rowData['idConfig_1'])&&$rowData['idConfig_1']==1){ ?>
						<table id="dataTable" class="table table-bordered table-condensed dataTable">
							<tbody role="alert" aria-live="polite" aria-relevant="all">
								<tr>
									<td colspan="2" style="background-color: #ccc;">Componentes</td>
								</tr>
								<tr>
									<td colspan="2">
										<div class="clearfix"></div>
										<?php //Se imprime el arbol
										echo arrayToUL($array3d, $TipoMaq, 0, '','', $nmax);
										?>

										<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-body">
														<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
														<img src="" class="imagepreview" style="width: 100%;padding: 15px;" >
													</div>
												</div>
											</div>
										</div>
										<script>
											$(function() {
													$('.pop').on('click', function() {
														$('.imagepreview').attr('src',$(this).attr('src'));
														$('#imagemodal').modal('show');
													});
											});
										</script>

									</td>
								</tr>
							</tbody>
						</table>
					<?php } ?>

				</div>
			</div>

		</div>
	</div>
</div>

<?php
//si se entrega la opción de mostrar boton volver
if(isset($_GET['return'])&&$_GET['return']!=''){
	//para las versiones antiguas
	if($_GET['return']=='true'){ ?>
		<div class="clearfix"></div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px;margin-top:30px;">
			<a href="#" onclick="history.back()" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
			<div class="clearfix"></div>
		</div>
	<?php
	//para las versiones nuevas que indican donde volver
	}else{
		$string = basename($_SERVER["REQUEST_URI"], ".php");
		$array  = explode("&return=", $string, 3);
		$volver = $array[1];
		?>
		<div class="clearfix"></div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px;margin-top:30px;">
			<a href="<?php echo $volver; ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
			<div class="clearfix"></div>
		</div>

	<?php }
} ?>

<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Views.php';

?>
