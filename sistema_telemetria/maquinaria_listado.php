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
$original = "maquinaria_listado.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['Codigo']) && $_GET['Codigo']!=''){  $location .= "&Codigo=".$_GET['Codigo'];  $search .= "&Codigo=".$_GET['Codigo'];}
if(isset($_GET['Nombre']) && $_GET['Nombre']!=''){  $location .= "&Nombre=".$_GET['Nombre'];  $search .= "&Nombre=".$_GET['Nombre'];}
/********************************************************************/
//Verifico los permisos del usuario sobre la transaccion
require_once '../A2XRXS_gears/xrxs_configuracion/Load.User.Permission.php';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/

//------------------------------------- Licitacion -------------------------------------//
//formulario para crear
if (!empty($_POST['submit_Maquina'])){
	//Llamamos al formulario
	$form_trabajo= 'createBasicData';
	require_once 'A1XRXS_sys/xrxs_form/z_maquinas_listado.php';
}
//se borra un dato
if (!empty($_GET['del'])){
	//Llamamos al formulario
	$form_trabajo= 'delBasicData';
	require_once 'A1XRXS_sys/xrxs_form/z_maquinas_listado.php';
}
//se clona la maquina
if (!empty($_POST['clone_Maquina'])){
	//Llamamos al formulario
	$form_trabajo= 'clone_Maquina';
	require_once 'A1XRXS_sys/xrxs_form/z_maquinas_listado.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Maquina Creada correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Maquina Modificada correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Maquina Borrada correctamente';}
if (isset($_GET['clone'])){   $error['clone']   = 'sucess/Maquina clonada correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['clone_idMaquina'])){
	//valido los permisos
	validaPermisoUser($rowlevel['level'], 2, $dbConn);

	?>

	<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
				<h5>Clonar Maquina <?php echo $_GET['nombre_maquina']; ?></h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Nombre)){           $x1  = $Nombre;           }else{$x1  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 2);

					$Form_Inputs->form_input_hidden('idMaquina', simpleDecode($_GET['clone_idMaquina'], fecha_actual()), 2);
					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c5; Clonar" name="clone_Maquina">
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

	/*******************************************************/
	// consulto los datos
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
	maquinas_listado.idConfig_2,

	core_estados.Nombre AS Estado,
	ops1.Nombre AS Componentes,
	ops2.Nombre AS Matriz';
	$SIS_join  = '
	LEFT JOIN `core_estados`                  ON core_estados.idEstado  = maquinas_listado.idEstado
	LEFT JOIN `core_sistemas_opciones` ops1   ON ops1.idOpciones        = maquinas_listado.idConfig_1
	LEFT JOIN `core_sistemas_opciones` ops2   ON ops2.idOpciones        = maquinas_listado.idConfig_2';
	$SIS_where = 'maquinas_listado.idMaquina = '.simpleDecode($_GET['id'], fecha_actual());
	$rowData = db_select_data (false, $SIS_query, 'maquinas_listado', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowData');


	if(isset($rowData['idConfig_1'])&&$rowData['idConfig_1']==1){
		//Se crean las variables
		$nmax = 10;
		$z = '';
		$leftjoin = '';
		$orderby = '';
		for ($i = 1; $i <= $nmax; $i++) {
			//consulta
			$z.= ",maquinas_listado_level_".$i.".idLevel_".$i." AS LVL_".$i."_id ";
			$z.= ",maquinas_listado_level_".$i.".Nombre AS LVL_".$i."_Nombre ";
			$z.= ",maquinas_listado_level_".$i.".idUtilizable AS LVL_".$i."_idUtilizable ";
			$z.= ",maquinas_listado_level_".$i.".tabla AS LVL_".$i."_table ";
			$z.= ",maquinas_listado_level_".$i.".table_value AS LVL_".$i."_table_value ";
			$z.= ",maquinas_listado_level_".$i.".Direccion_img AS LVL_".$i."_imagen ";
			//Joins
			$xx = $i + 1;
			if($xx<=$nmax){
				$leftjoin.= " LEFT JOIN `maquinas_listado_level_".$xx."`   ON maquinas_listado_level_".$xx.".idLevel_".$i."    = maquinas_listado_level_".$i.".idLevel_".$i;
			}
			//ORDER BY
			$orderby.= ", maquinas_listado_level_".$i.".Nombre ASC";
		}

		/*******************************************************/
		// consulto los datos
		$SIS_query = 'maquinas_listado_level_1.idLevel_1 AS bla'.$z;
		$SIS_join  = $leftjoin;
		$SIS_where = 'maquinas_listado_level_1.idMaquina='.simpleDecode($_GET['id'], fecha_actual());
		$SIS_order = 'maquinas_listado_level_1.Nombre ASC'.$orderby;
		$arrItemizado = array();
		$arrItemizado = db_select_array (false, $SIS_query, 'maquinas_listado_level_1', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrItemizado');

		/*******************************************************/
		// Se trae un listado con todos los tipos de componentes
		$SIS_query = 'idUtilizable, Nombre';
		$SIS_join  = '';
		$SIS_where = '';
		$SIS_order = 'idUtilizable ASC';
		$arrTipos = array();
		$arrTipos = db_select_array (false, $SIS_query, 'core_maquinas_tipo_componente', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrTipos');

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


		function arrayToUL(array $array, array $TipoMaq, $lv, $rowlevel,$location, $nmax){
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
		<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Maquinas', $rowData['Nombre'], 'Resumen'); ?>
	</div>
	<div class="clearfix"></div>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<ul class="nav nav-tabs pull-right">
					<li class="active"><a href="<?php echo 'maquinaria_listado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']; ?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
					<li class=""><a href="<?php echo 'maquinaria_listado_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']; ?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Básicos</a></li>
					<li class=""><a href="<?php echo 'maquinaria_listado_configuracion.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']; ?>" ><i class="fa fa-wrench" aria-hidden="true"></i> Configuracion</a></li>
					<li class="dropdown">
						<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
						<ul class="dropdown-menu" role="menu">
							<li class=""><a href="<?php echo 'maquinaria_listado_datos_ficha.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']; ?>" ><i class="fa fa-calendar-check-o" aria-hidden="true"></i> Ficha Tecnica</a></li>
							<li class=""><a href="<?php echo 'maquinaria_listado_datos_hds.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']; ?>" ><i class="fa fa-calendar-check-o" aria-hidden="true"></i> HDS</a></li>
							<li class=""><a href="<?php echo 'maquinaria_listado_datos_imagen.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']; ?>" ><i class="fa fa-file-image-o" aria-hidden="true"></i> Imagen</a></li>
							<li class=""><a href="<?php echo 'maquinaria_listado_estado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']; ?>" ><i class="fa fa-power-off" aria-hidden="true"></i> Estado</a></li>
							<li class=""><a href="<?php echo 'maquinaria_listado_datos_descripcion.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']; ?>" ><i class="fa fa-tasks" aria-hidden="true"></i> Descripcion</a></li>
							<?php
							//Uso de componentes
							if(isset($rowData['idConfig_1'])&&$rowData['idConfig_1']==1){ ?>
								<li class=""><a href="<?php echo 'maquinaria_listado_componentes.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']; ?>" ><i class="fa fa-cubes" aria-hidden="true"></i> Componentes</a></li>
							<?php } ?>
							<?php
							//uso de matriz de analisis
							if(isset($rowData['idConfig_2'])&&$rowData['idConfig_2']==1){ ?>
								<li class=""><a href="<?php echo 'maquinaria_listado_matriz_analisis.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']; ?>" ><i class="fa fa-microchip" aria-hidden="true"></i> Matriz Analisis</a></li>
							<?php } ?>

						</ul>
					</li>
				</ul>
			</header>
			<div class="tab-content">

				<div class="tab-pane fade active in" id="basicos">
					<div class="wmd-panel">
						<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
							<?php if ($rowData['Direccion_img']=='') { ?>
								<img style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="Imagen Referencia" src="<?php echo DB_SITE_REPO ?>/Legacy/gestion_modular/img/maquina.jpg">
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
							<table id="items" style="margin-bottom: 20px;">
								<tbody>
									<?php
									//Ficha Tecnica
									if(isset($rowData['FichaTecnica'])&&$rowData['FichaTecnica']!=''){
										echo '
											<tr class="item-row">
												<td>Ficha Tecnica</td>
												<td width="10">
													<div class="btn-group" style="width: 70px;">
														<a href="view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['FichaTecnica'], fecha_actual()).'" title="Ver Documento" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
														<a href="1download.php?dir='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['FichaTecnica'], fecha_actual()).'" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-download" aria-hidden="true"></i></a>
													</div>
												</td>
											</tr>
										';
									}
									//Hoja de seguridad
									if(isset($rowData['HDS'])&&$rowData['HDS']!=''){
										echo '
											<tr class="item-row">
												<td>Hoja de seguridad</td>
												<td width="10">
													<div class="btn-group" style="width: 70px;">
														<a href="view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['HDS'], fecha_actual()).'" title="Ver Documento" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
														<a href="1download.php?dir='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowData['HDS'], fecha_actual()).'" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-download" aria-hidden="true"></i></a>
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
											echo arrayToUL($array3d, $TipoMaq, 0, $rowlevel['level'],$location, $nmax);
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
				<h5>Crear Maquina</h5>
			</header>
			<div class="body">
				<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

					<?php
					//Se verifican si existen los datos
					if(isset($Nombre)){     $x1 = $Nombre;      }else{$x1 = '';}
					if(isset($Codigo)){     $x2 = $Codigo;      }else{$x2 = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 2);
					$Form_Inputs->form_input_text('Codigo', 'Codigo', $x2, 1);

					$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
					$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
					$Form_Inputs->form_input_hidden('idEstado', 1, 2);
					$Form_Inputs->form_input_hidden('idConfig_1', 2, 2); //Uso Componentes - No
					$Form_Inputs->form_input_hidden('idConfig_2', 2, 2); //Uso Matriz - No
					$Form_Inputs->form_input_hidden('idConfig_3', 2, 2); //Dependencia Cliente - No
					$Form_Inputs->form_input_hidden('idConfig_4', 2, 2); //Uso Ubicación - No

					?>

					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar" name="submit_Maquina">
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
			case 'codigo_asc':   $order_by = 'maquinas_listado.Codigo ASC ';     $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Codigo Ascendente'; break;
			case 'codigo_desc':  $order_by = 'maquinas_listado.Codigo DESC ';    $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Codigo Descendente';break;
			case 'nombre_asc':   $order_by = 'maquinas_listado.Nombre ASC ';     $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Maquina Ascendente';break;
			case 'nombre_desc':  $order_by = 'maquinas_listado.Nombre DESC ';    $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Maquina Descendente';break;
			case 'estado_asc':   $order_by = 'core_estados.Nombre ASC ';         $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Estado Ascendente';break;
			case 'estado_desc':  $order_by = 'core_estados.Nombre DESC ';        $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Estado Descendente';break;

			default: $order_by = 'maquinas_listado.Nombre ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Cliente, Nombre Ascendente';
		}
	}else{
		$order_by = 'maquinas_listado.Nombre ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Cliente, Nombre Ascendente';
	}
	/**********************************************************/
	//Verifico el tipo de usuario que esta ingresando
	$SIS_where = "maquinas_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
	/**********************************************************/
	//Se aplican los filtros
	if(isset($_GET['Codigo']) && $_GET['Codigo']!=''){  $SIS_where .= " AND maquinas_listado.Codigo LIKE '%".EstandarizarInput($_GET['Codigo'])."%'";}
	if(isset($_GET['Nombre']) && $_GET['Nombre']!=''){  $SIS_where .= " AND maquinas_listado.Nombre LIKE '%".EstandarizarInput($_GET['Nombre'])."%'";}

	/**********************************************************/
	//Realizo una consulta para saber el total de elementos existentes
	$cuenta_registros = db_select_nrows (false, 'idMaquina', 'maquinas_listado', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'cuenta_registros');
	//Realizo la operacion para saber la cantidad de paginas que hay
	$total_paginas = ceil($cuenta_registros / $cant_reg);
	// Se trae un listado con todos los elementos
	$SIS_query = '
	maquinas_listado.idMaquina,
	maquinas_listado.Codigo,
	maquinas_listado.Nombre,
	core_sistemas.Nombre AS sistema,
	maquinas_listado.idSistema,
	core_estados.Nombre AS Estado,
	maquinas_listado.idEstado';
	$SIS_join  = '
	LEFT JOIN `core_sistemas`  ON core_sistemas.idSistema   = maquinas_listado.idSistema
	LEFT JOIN `core_estados`   ON core_estados.idEstado     = maquinas_listado.idEstado';
	$SIS_order = $order_by.' LIMIT '.$comienzo.', '.$cant_reg;
	$arrMaquina = array();
	$arrMaquina = db_select_array (false, $SIS_query, 'maquinas_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrMaquina');

	?>

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar">

		<ul class="btn-group btn-breadcrumb pull-left">
			<li class="btn btn-default tooltip" role="button" data-toggle="collapse" href="#collapseForm" aria-expanded="false" aria-controls="collapseForm" title="Presionar para desplegar Formulario de Búsqueda" style="font-size: 14px;"><i class="fa fa-search faa-vertical animated" aria-hidden="true"></i></li>
			<li class="btn btn-default"><?php echo $bread_order; ?></li>
			<?php if(isset($_GET['filtro_form'])&&$_GET['filtro_form']!=''){ ?>
				<li class="btn btn-danger"><a href="<?php echo $original.'?pagina=1'; ?>" style="color:#fff;"><i class="fa fa-trash-o" aria-hidden="true"></i> Limpiar</a></li>
			<?php } ?>
		</ul>

		<?php if ($rowlevel['level']>=3){ ?><a href="<?php echo $location; ?>&new=true" class="btn btn-default pull-right margin_width" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Maquina</a><?php } ?>

	</div>
	<div class="clearfix"></div>
	<div class="collapse col-xs-12 col-sm-12 col-md-12 col-lg-12" id="collapseForm">
		<div class="well">
			<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
				<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" autocomplete="off" novalidate>
					<?php
					//Se verifican si existen los datos
					if(isset($Nombre)){     $x1 = $Nombre;      }else{$x1 = '';}
					if(isset($Codigo)){     $x2 = $Codigo;      }else{$x2 = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 1);
					$Form_Inputs->form_input_text('Codigo', 'Codigo', $x2, 1);

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
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Maquinas</h5>
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
								<div class="pull-left">Nombre</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=nombre_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=nombre_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
								</div>
							</th>
							<th width="160">
								<div class="pull-left">Codigo</div>
								<div class="btn-group pull-right" style="width: 50px;" >
									<a href="<?php echo $location.'&order_by=codigo_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&order_by=codigo_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
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
					<?php foreach ($arrMaquina as $maq) { ?>
						<tr class="odd">
							<td><?php echo $maq['Nombre']; ?></td>
							<td><?php echo $maq['Codigo']; ?></td>
							<td><label class="label <?php if(isset($maq['idEstado'])&&$maq['idEstado']==1){echo 'label-success';}else{echo 'label-danger';} ?>"><?php echo $maq['Estado']; ?></label></td>
							<?php if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?><td><?php echo $maq['sistema']; ?></td><?php } ?>
							<td>
								<div class="btn-group" style="width: 140px;" >
									<?php if ($rowlevel['level']>=1){ ?><a href="<?php echo 'view_maquinaria.php?view='.simpleEncode($maq['idMaquina'], fecha_actual()); ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'&nombre_maquina='.$maq['Nombre'].'&clone_idMaquina='.simpleEncode($maq['idMaquina'], fecha_actual()); ?>" title="Clonar Maquina" class="btn btn-primary btn-sm tooltip"><i class="fa fa-files-o" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=2){ ?><a href="<?php echo $location.'&id='.simpleEncode($maq['idMaquina'], fecha_actual()); ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><?php } ?>
									<?php if ($rowlevel['level']>=4){
										$ubicacion = $location.'&del='.simpleEncode($maq['idMaquina'], fecha_actual());
										$dialogo   = '¿Realmente deseas eliminar el registro '.$maq['Nombre'].'?'; ?>
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
