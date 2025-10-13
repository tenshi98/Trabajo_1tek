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
$original = "informe_analisis_maquina_01.php";
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

	//filtros
	$SIS_where1 = "maquinas_listado_matriz.idMatriz>=0";
	$SIS_where2 = "maquinas_listado.idMaquina>=0";
	$SIS_where3 = "analisis_listado.idAnalisis>=0";
	if(isset($_GET['idSistema']) && $_GET['idSistema'] != ''){
		$SIS_where3 .= " AND analisis_listado.idSistema = '".$_GET['idSistema']."'";
	}
	if(isset($_GET['idMaquina']) && $_GET['idMaquina'] != ''){
		$SIS_where2 .= " AND maquinas_listado.idMaquina = '".$_GET['idMaquina']."'";
		$SIS_where3 .= " AND analisis_listado.idMaquina = '".$_GET['idMaquina']."'";
	}
	if(isset($_GET['idMatriz']) && $_GET['idMatriz'] != ''){
		$SIS_where1 .= " AND idMatriz = '".$_GET['idMatriz']."'";
		$SIS_where2 .= " AND maquinas_listado_matriz.idMatriz = '".$_GET['idMaquina']."'";
		$SIS_where3 .= " AND analisis_listado.idMatriz = '".$_GET['idMatriz']."'";
	}
	if(isset($_GET['f_inicio'], $_GET['f_termino']) && $_GET['f_inicio'] != '' && $_GET['f_termino']!=''){
		$SIS_where3 .= " AND analisis_listado.f_muestreo BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."'";
	}
	/*********************************************************************/
	//Preconsulta
	$SIS_query = 'cantPuntos';
	$SIS_join  = '';
	$rowpre = db_select_data (false, $SIS_query, 'maquinas_listado_matriz', $SIS_join, $SIS_where1, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'rowpre');

	/*******************************************************/
	// consulto los datos
	$SIS_query = '
	maquinas_listado.Codigo AS MaquinaCodigo,
	maquinas_listado.Nombre AS MaquinaNombre,
	maquinas_listado.Modelo AS MaquinaModelo,
	maquinas_listado.Serie AS MaquinaSerie,
	maquinas_listado.Fabricante AS MaquinaFabricante,
	ubicacion_listado.Nombre  AS MaquinaUbicacion,
	ubicacion_listado_level_1.Nombre  AS MaquinaUbicacion_lvl_1,
	ubicacion_listado_level_2.Nombre  AS MaquinaUbicacion_lvl_2,
	ubicacion_listado_level_3.Nombre  AS MaquinaUbicacion_lvl_3,
	ubicacion_listado_level_4.Nombre  AS MaquinaUbicacion_lvl_4,
	ubicacion_listado_level_5.Nombre  AS MaquinaUbicacion_lvl_5,

	core_sistemas.Nombre AS SistemaOrigen,
	sis_or_ciudad.Nombre AS SistemaOrigenCiudad,
	sis_or_comuna.Nombre AS SistemaOrigenComuna,
	core_sistemas.Direccion AS SistemaOrigenDireccion,
	core_sistemas.Contacto_Fono1 AS SistemaOrigenFono,
	core_sistemas.email_principal AS SistemaOrigenEmail,
	core_sistemas.Rut AS SistemaOrigenRut,

	maquinas_listado_matriz.Nombre AS Analisis_Nombre';
	for ($i = 1; $i <= $rowpre['cantPuntos']; $i++) {
		$SIS_query .= ',maquinas_listado_matriz.PuntoNombre_'.$i.' AS PuntoNombre_'.$i;
		$SIS_query .= ',maquinas_listado_matriz.PuntoMedAceptable_'.$i.' AS PuntoMedAceptable_'.$i;
		$SIS_query .= ',maquinas_listado_matriz.PuntoMedAlerta_'.$i.' AS PuntoMedAlerta_'.$i;
		$SIS_query .= ',maquinas_listado_matriz.PuntoMedCondenatorio_'.$i.' AS PuntoMedCondenatorio_'.$i;
		$SIS_query .= ',maquinas_listado_matriz.PuntoUniMed_'.$i.' AS PuntoUniMed_'.$i;
		$SIS_query .= ',maquinas_listado_matriz.PuntoidTipo_'.$i.' AS PuntoidTipo_'.$i;
		$SIS_query .= ',maquinas_listado_matriz.PuntoidGrupo_'.$i.' AS PuntoidGrupo_'.$i;
	}
	$SIS_join  = '
	LEFT JOIN `ubicacion_listado`                       ON ubicacion_listado.idUbicacion           = maquinas_listado.idUbicacion
	LEFT JOIN `ubicacion_listado_level_1`               ON ubicacion_listado_level_1.idLevel_1     = maquinas_listado.idUbicacion_lvl_1
	LEFT JOIN `ubicacion_listado_level_2`               ON ubicacion_listado_level_2.idLevel_2     = maquinas_listado.idUbicacion_lvl_2
	LEFT JOIN `ubicacion_listado_level_3`               ON ubicacion_listado_level_3.idLevel_3     = maquinas_listado.idUbicacion_lvl_3
	LEFT JOIN `ubicacion_listado_level_4`               ON ubicacion_listado_level_4.idLevel_4     = maquinas_listado.idUbicacion_lvl_4
	LEFT JOIN `ubicacion_listado_level_5`               ON ubicacion_listado_level_5.idLevel_5     = maquinas_listado.idUbicacion_lvl_5
	LEFT JOIN `maquinas_listado_matriz`                 ON maquinas_listado_matriz.idMaquina       = maquinas_listado.idMaquina
	LEFT JOIN `core_sistemas`                           ON core_sistemas.idSistema                 = maquinas_listado.idSistema
	LEFT JOIN `core_ubicacion_ciudad`   sis_or_ciudad   ON sis_or_ciudad.idCiudad                  = core_sistemas.idCiudad
	LEFT JOIN `core_ubicacion_comunas`  sis_or_comuna   ON sis_or_comuna.idComuna                  = core_sistemas.idComuna';
	$SIS_where = '';
	$rowMaquina = db_select_data (false, $SIS_query, 'maquinas_listado', $SIS_join, $SIS_where2, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'test_logo');

	/*******************************************************/
	// consulto los datos
	$SIS_query = '
	core_analisis_estado.Nombre AS AnalisisEstado,
	analisis_listado.f_muestreo';
	for ($i = 1; $i <= $rowpre['cantPuntos']; $i++) {
		$SIS_query .= ',analisis_listado.Medida_'.$i.' AS Analisis_Medida_'.$i;
	}
	$SIS_join  = 'LEFT JOIN `core_analisis_estado` ON core_analisis_estado.idEstado = analisis_listado.idEstado';
	$SIS_order = 'analisis_listado.f_muestreo ASC';
	$arrResultados = array();
	$arrResultados = db_select_array (false, $SIS_query, 'analisis_listado', $SIS_join, $SIS_where3, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'test_logo');

	/*******************************************************/
	// consulto los datos
	$SIS_query = 'idUml,Nombre';
	$SIS_join  = '';
	$SIS_where = '';
	$SIS_order = 'idUml ASC';
	$arrUnimed = array();
	$arrUnimed = db_select_array (false, $SIS_query, 'sistema_analisis_uml', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrUnimed');

	/*******************************************************/
	// consulto los datos
	$SIS_query = 'idGrupo, Nombre';
	$SIS_join  = '';
	$SIS_where = '';
	$SIS_order = 'idGrupo ASC';
	$arrGrupo = array();
	$arrGrupo = db_select_array (false, $SIS_query, 'maquinas_listado_matriz_grupos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrGrupo');

	/*******************************************************/
	// consulto los datos
	$SIS_query = 'idProducto, Nombre';
	$SIS_join  = '';
	$SIS_where = '';
	$SIS_order = 'Nombre ASC';
	$arrProducto = array();
	$arrProducto = db_select_array (false, $SIS_query, 'productos_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrProducto');

	/*******************************************************/
	// consulto los datos
	$SIS_query = 'idDispersancia, Nombre';
	$SIS_join  = '';
	$SIS_where = '';
	$SIS_order = 'Nombre ASC';
	$arrDispersancia = array();
	$arrDispersancia = db_select_array (false, $SIS_query, 'core_analisis_dispersancia', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrDispersancia');

	/*******************************************************/
	// consulto los datos
	$SIS_query = 'idFlashPoint, Nombre';
	$SIS_join  = '';
	$SIS_where = '';
	$SIS_order = 'Nombre ASC';
	$arrFlashpoint = array();
	$arrFlashpoint = db_select_array (false, $SIS_query, 'core_analisis_flashpoint', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrFlashpoint');

	?>

	<section class="invoice">

		<div class="row">
			<div class="col-xs-12">
				<h2 class="page-header">
					<i class="fa fa-globe" aria-hidden="true"></i> <?php echo $rowMaquina['Analisis_Nombre']?>.
					<small class="pull-right">Fecha Consulta: <?php echo Fecha_estandar(fecha_actual()); ?></small>
				</h2>
			</div>
		</div>

		<div class="row invoice-info">

			<?php
			//Si es interno muestro los datos de la empresa

			echo '
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 invoice-col">
				Maquina
				<address>
					<strong>'.$rowMaquina['MaquinaNombre'].'</strong><br/>
					Codigo: '.$rowMaquina['MaquinaCodigo'].'<br/>
					Modelo: '.$rowMaquina['MaquinaModelo'].'<br/>
					Serie: '.$rowMaquina['MaquinaSerie'].'<br/>
					Fabricante: '.$rowMaquina['MaquinaFabricante'].'<br/>
					Ubicación: '.$rowMaquina['MaquinaUbicacion'];
					if(isset($rowMaquina['MaquinaUbicacion_lvl_1'])&&$rowMaquina['MaquinaUbicacion_lvl_1']!=''){
						echo ' - '.$rowMaquina['MaquinaUbicacion_lvl_1'];
					}
					if(isset($rowMaquina['MaquinaUbicacion_lvl_2'])&&$rowMaquina['MaquinaUbicacion_lvl_2']!=''){
						echo ' - '.$rowMaquina['MaquinaUbicacion_lvl_2'];
					}
					if(isset($rowMaquina['MaquinaUbicacion_lvl_3'])&&$rowMaquina['MaquinaUbicacion_lvl_3']!=''){
						echo ' - '.$rowMaquina['MaquinaUbicacion_lvl_3'];
					}
					if(isset($rowMaquina['MaquinaUbicacion_lvl_4'])&&$rowMaquina['MaquinaUbicacion_lvl_4']!=''){
						echo ' - '.$rowMaquina['MaquinaUbicacion_lvl_4'];
					}
					if(isset($rowMaquina['MaquinaUbicacion_lvl_5'])&&$rowMaquina['MaquinaUbicacion_lvl_5']!=''){
						echo ' - '.$rowMaquina['MaquinaUbicacion_lvl_5'];
					}
				echo '
				</address>
			</div>';

			echo '
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 invoice-col">
				Empresa
				<address>
					<strong>'.$rowMaquina['SistemaOrigen'].'</strong><br/>
					'.$rowMaquina['SistemaOrigenCiudad'].', '.$rowMaquina['SistemaOrigenComuna'].'<br/>
					'.$rowMaquina['SistemaOrigenDireccion'].'<br/>
					Fono : '.formatPhone($rowMaquina['SistemaOrigenFono']).'<br/>
					Rut: '.$rowMaquina['SistemaOrigenRut'].'<br/>
					Email: '.$rowMaquina['SistemaOrigenEmail'].'<br/>
				</address>
			</div>';

			echo '
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 invoice-col">
			</div>';
		?>

		</div>

	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script type="text/javascript">google.charts.load('current', {'packages':['bar', 'corechart', 'table']});</script>


		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive"  style="padding-left: 0px; padding-right: 0px;border: 1px solid #ddd;">
				<?php
				//variables
				$x_count = 1;
				//arreglo
				foreach ($arrGrupo as $grupo) {
					//Cuento si hay items dentro de la categoria
					$x_con = 0;
					for ($i = 1; $i <= $rowpre['cantPuntos']; $i++) {
						if($grupo['idGrupo']==$rowMaquina['PuntoidGrupo_'.$i]){
							$x_con++;
						}
					}

					//si hay items se muestra todo
					if($x_con!=0){

						//titulo del grupo
						echo '<h3>'.$grupo['Nombre'].'</h3>';
						//recorro los puntos
						for ($i = 1; $i <= $rowpre['cantPuntos']; $i++) {
							//verifico que pertenezcan al mismo grupo
							if($grupo['idGrupo']==$rowMaquina['PuntoidGrupo_'.$i]){
								//obtengo la unidad de medida
								$uniMed = '';
								foreach ($arrUnimed as $med) {
									if($rowMaquina['PuntoUniMed_'.$i]==$med['idUml']){
										$uniMed = $med['Nombre'];
									}
								}
								//reviso el tipo de resultado
								switch ($rowMaquina['PuntoidTipo_'.$i]) {
									//Medidas
									case 1:
										//
										echo '
										<script>
										google.charts.setOnLoadCallback(drawChart_'.$x_count.');

										function drawChart_'.$x_count.'() {
											var data_prod_1 = new google.visualization.DataTable();
											data_prod_1.addColumn("string", "Fecha");
											data_prod_1.addColumn("number", "Valor");
											data_prod_1.addColumn({type: "string", role: "annotation"});
											data_prod_1.addColumn("number", "Aceptable");
											data_prod_1.addColumn("number", "Alerta");
											data_prod_1.addColumn("number", "Condenatorio");

											data_prod_1.addRows([';
												//recorro los resultados
												foreach ($arrResultados as $result) {
													echo '["'.fecha_estandar($result['f_muestreo']).'", '.Cantidades_decimales_justos($result['Analisis_Medida_'.$i]).', "'.Cantidades_decimales_justos($result['Analisis_Medida_'.$i]).' '.$uniMed.'",
													'.Cantidades_decimales_justos($rowMaquina['PuntoMedAceptable_'.$i]).',
													'.Cantidades_decimales_justos($rowMaquina['PuntoMedAlerta_'.$i]).',
													'.Cantidades_decimales_justos($rowMaquina['PuntoMedCondenatorio_'.$i]).'
													],';
												}
												echo '
												]);

											var options = {
												title: "Grafico '.$rowMaquina['PuntoNombre_'.$i].'",
												hAxis: {title: "Fechas"},
												vAxis: { title: "Valor" },
												width: $(window).width()*0.75,
												height: 500,
												curveType: "function",
												series: {0: {pointsVisible: true},},
												annotations: {alwaysOutside: true,textStyle: {fontSize: 14,color: "#000",auraColor: "none"}},
												colors: ["#FFB347", "#8DB652","#f5b75f","#ec693c"]
											};
											var chart1 = new google.visualization.LineChart(document.getElementById("chart_'.$x_count.'"));
											chart1.draw(data_prod_1, options);
										}
										</script>
										<div id="chart_'.$x_count.'" style="height: 500px; width: 100%;"></div>';

										//Suma de 1
										$x_count++;
									break;
									//Producto
									case 2:

										//Suma de 1
										$x_count++;
									break;
									//Dispersancia
									case 3:

										//Suma de 1
										$x_count++;
									break;
									//Flashpoint
									case 4:
										//Suma de 1
										$x_count++;
									break;
								}

							}
						}
					}
				}
				?>
			</div>
		</div>

	</section>

	<div class="clearfix"></div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px">
		<a href="<?php echo $location; ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
		<div class="clearfix"></div>
	</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
	//Verifico el tipo de usuario que esta ingresando
	$z="idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";

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
					if(isset($idMaquina)){     $x1  = $idMaquina;   }else{$x1  = '';}
					if(isset($idMatriz)){      $x2  = $idMatriz;    }else{$x2  = '';}
					if(isset($f_inicio)){      $x3  = $f_inicio;    }else{$x3  = '';}
					if(isset($f_termino)){     $x4  = $f_termino;   }else{$x4  = '';}

					//se dibujan los inputs
					$Form_Inputs = new Form_Inputs();
					$Form_Inputs->form_select_depend1('Maquina','idMaquina', $x1, 2, 'idMaquina', 'Nombre', 'maquinas_listado', $z, 0,
											'Matriz de Analisis','idMatriz', $x2, 2, 'idMatriz', 'Nombre', 'maquinas_listado_matriz', 'idEstado=1', 0,
											$dbConn, 'form1');
					$Form_Inputs->form_date('Fecha Muestreo Inicio','f_inicio', $x3, 2);
					$Form_Inputs->form_date('Fecha Muestreo Termino','f_termino', $x4, 2);

					$Form_Inputs->form_input_disabled('Empresa Relacionada','fake_emp', $_SESSION['usuario']['basic_data']['RazonSocial']);
					$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
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
