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
$original = "informe_cross_crane_01.php";
$location = $original;
//Se agregan ubicaciones
$search ='&submit_filter=Filtrar';
$location .= "?submit_filter=Filtrar";
if(isset($_GET['f_inicio']) && $_GET['f_inicio']!=''){   $location .= "&f_inicio=".$_GET['f_inicio'];          $search .= "&f_inicio=".$_GET['f_inicio'];}
if(isset($_GET['h_inicio']) && $_GET['h_inicio']!=''){   $location .= "&h_inicio=".$_GET['h_inicio'];          $search .= "&h_inicio=".$_GET['h_inicio'];}
if(isset($_GET['f_termino']) && $_GET['f_termino']!=''){ $location .= "&f_termino=".$_GET['f_termino'];        $search .= "&f_termino=".$_GET['f_termino'];}
if(isset($_GET['h_termino']) && $_GET['h_termino']!=''){ $location .= "&h_termino=".$_GET['h_termino'];        $search .= "&h_termino=".$_GET['h_termino'];}
if(isset($_GET['idGrafico']) && $_GET['idGrafico']!=''){ $location .= "&idGrafico=".$_GET['idGrafico'];        $search .= "&idGrafico=".$_GET['idGrafico'];}
if(isset($_GET['idTelemetria']) && $_GET['idTelemetria']!=''){  $location .= "&idTelemetria=".$_GET['idTelemetria'];  $search .= "&idTelemetria=".$_GET['idTelemetria'];}
						     
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
$SIS_where_1 = "telemetria_listado_errores.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
$SIS_where_2 = "telemetria_listado_errores.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
if(isset($_GET['f_inicio'], $_GET['f_termino'], $_GET['h_inicio'], $_GET['h_termino']) && $_GET['f_inicio'] != '' && $_GET['f_termino'] != '' && $_GET['h_inicio'] != '' && $_GET['h_termino']!=''){
	$SIS_where_1.= " AND telemetria_listado_errores.TimeStamp BETWEEN '".$_GET['f_inicio']." ".$_GET['h_inicio']."' AND '".$_GET['f_termino']." ".$_GET['h_termino']."'";
}elseif(isset($_GET['f_inicio'], $_GET['f_termino']) && $_GET['f_inicio'] != '' && $_GET['f_termino']!=''){
	$SIS_where_1.= " AND telemetria_listado_errores.Fecha BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."'";
}
if(isset($_GET['idTelemetria']) && $_GET['idTelemetria']!=''){  
	$SIS_where_1.= " AND telemetria_listado_errores.idTelemetria=".$_GET['idTelemetria'];
	$SIS_where_2.= " AND telemetria_listado_errores.idTelemetria=".$_GET['idTelemetria'];
}
//Filtro por unidad medida de energia electrica
$SIS_where_1.=" AND (telemetria_listado_errores.idUniMed=4 OR telemetria_listado_errores.idUniMed=5 OR telemetria_listado_errores.idUniMed=10)";
$SIS_where_2.=" AND (telemetria_listado_errores.idUniMed=4 OR telemetria_listado_errores.idUniMed=5 OR telemetria_listado_errores.idUniMed=10)";
//Agrupo
$SIS_where_1.= " GROUP BY telemetria_listado.Nombre,telemetria_listado_errores.Descripcion, telemetria_listado_errores.Fecha, telemetria_listado_errores.idUniMed";
$SIS_where_2.= " GROUP BY telemetria_listado.Nombre,telemetria_listado_errores.Fecha";

/*********************************************************/					
$SIS_query = '
COUNT(telemetria_listado_errores.idErrores) AS Cuenta,
telemetria_listado.Nombre AS Equipo,
telemetria_listado_errores.Fecha,
telemetria_listado_errores.Descripcion,
telemetria_listado_unidad_medida.Nombre AS Unimed,
MIN(telemetria_listado_errores.Valor) AS Valor_min,
MAX(telemetria_listado_errores.Valor) AS Valor_max';
$SIS_join  = '
LEFT JOIN telemetria_listado               ON telemetria_listado.idTelemetria             = telemetria_listado_errores.idTelemetria
LEFT JOIN telemetria_listado_unidad_medida ON telemetria_listado_unidad_medida.idUniMed   = telemetria_listado_errores.idUniMed';
$SIS_order = 'telemetria_listado.Nombre ASC, telemetria_listado_errores.Descripcion ASC, telemetria_listado_errores.Fecha ASC';
$arrEquipos1 = array();
$arrEquipos1 = db_select_array (false, $SIS_query, 'telemetria_listado_errores', $SIS_join, $SIS_where_1, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrEquipos1');

/*********************************************************/
$SIS_query = '
COUNT(telemetria_listado_errores.idErrores) AS Cuenta,
telemetria_listado.Nombre AS Equipo,
telemetria_listado_errores.Fecha';
$SIS_join  = 'LEFT JOIN telemetria_listado ON telemetria_listado.idTelemetria = telemetria_listado_errores.idTelemetria';
$SIS_order = 'telemetria_listado.Nombre ASC, telemetria_listado_errores.Fecha DESC LIMIT 10000';
$arrEquipos2 = array();
$arrEquipos2 = db_select_array (false, $SIS_query, 'telemetria_listado_errores', $SIS_join, $SIS_where_2, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'arrEquipos2');

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 clearfix">
	<?php
	$search .= '&idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
	$search .= '&idTipoUsuario='.$_SESSION['usuario']['basic_data']['idTipoUsuario'];
	?>		
	<a target="new" href="<?php echo 'informe_cross_crane_01_to_excel.php?bla=bla'.$search ; ?>" class="btn btn-sm btn-metis-2 pull-right margin_width"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Exportar a Excel</a>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Recuento Total de alertas fuera de rango</h5>
		</header>
		<div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th>Equipo</th>
						<th>Descripcion</th>
						<th>Fecha</th>
						<th>N° Registros</th>
						<th>Minimo Observado</th>
						<th>Maximo Observado</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrEquipos1 as $equip) { ?>
						<tr class="odd">
							<td><?php echo $equip['Equipo']; ?></td>
							<td><?php echo $equip['Descripcion']; ?></td>
							<td><?php echo fecha_estandar($equip['Fecha']); ?></td>
							<td><?php echo $equip['Cuenta']; ?></td>
							<td><?php echo Cantidades($equip['Valor_min'], 2).' '.$equip['Unimed']; ?></td>
							<td><?php echo Cantidades($equip['Valor_max'], 2).' '.$equip['Unimed']; ?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Recuento Total de alertas fuera de rango por Dia</h5>
		</header>
		<div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th>Equipo</th>
						<?php
						$ndias = dias_transcurridos($_GET['f_inicio'], $_GET['f_termino']);
						for ($i = 1; $i <= $ndias; $i++) {
							$nuevoDia = sumarDias($_GET['f_inicio'],$i);
							echo '<th>'.Dia_Mes($nuevoDia).'</th>';
						}
						?>
						<th>Total Registros</th>
						<th>Promedio Registros</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php
					//filtro por equipo
					filtrar($arrEquipos2, 'Equipo');
					//recorro los equipos 
					foreach($arrEquipos2 as $equipo=>$dias){
						//imprimo
						echo '<tr class="odd">';
						echo '<td>'.$equipo.'</td>';
						//creo un arreglo
						$DiaActual = array();
						for ($i = 1; $i <= $ndias; $i++) {
							$nuevoDia = sumarDias($_GET['f_inicio'],$i);
							$DiaActual[$i]['fecha'] = $nuevoDia;
							$DiaActual[$i]['valor'] = 0;
						}
						//Variables
						$TotalErrores = 0;
						//recorro los dias
						foreach ($dias as $dia) {
							//recorro arreglo
							for ($i = 1; $i <= $ndias; $i++) {
								if(isset($dia['Fecha'])&&$dia['Fecha']==$DiaActual[$i]['fecha']){
									$DiaActual[$i]['valor'] = $DiaActual[$i]['valor'] + $dia['Cuenta'];
									$TotalErrores = $TotalErrores + $dia['Cuenta'];
								}
							}
						}

						//recorro los datos guardados
						for ($i = 1; $i <= $ndias; $i++) {
							echo '<td>'.$DiaActual[$i]['valor'].'</td>';
						}
						$ss_to = 0;
						if($ndias!=0){$ss_to = $TotalErrores/$ndias;}	
						echo '<td><strong>'.$TotalErrores.'</strong></td>';
						echo '<td><strong>'.cantidades($ss_to, 2).'</strong></td>';
						echo '</tr>';
					} ?>        
				</tbody>
			</table>
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
//Filtro de Búsqueda
$z  = "telemetria_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];   //Sistema
$z .= " AND telemetria_listado.id_Geo=2";                                                //Geolocalizacion inactiva
//Verifico el tipo de usuario que esta ingresando
if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
	$z .= " AND usuarios_equipos_telemetria.idUsuario = ".$_SESSION['usuario']['basic_data']['idUsuario'];
}
//Solo para plataforma 1tek
if(isset($_SESSION['usuario']['basic_data']['idInterfaz'])&&$_SESSION['usuario']['basic_data']['idInterfaz']==6){
	$z .= " AND telemetria_listado.idTab=6";//Power-Crane
}
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
				if(isset($f_inicio)){      $x1  = $f_inicio;      }else{$x1  = '';}
				if(isset($h_inicio)){      $x2  = $h_inicio;      }else{$x2  = '';}
				if(isset($f_termino)){     $x3  = $f_termino;     }else{$x3  = '';}
				if(isset($h_termino)){     $x4  = $h_termino;     }else{$x4  = '';}
				//if(isset($idGrafico)){     $x5  = $idGrafico;     }else{$x5  = '';}
				if(isset($idTelemetria)){  $x6  = $idTelemetria;  }else{if(isset($_GET['idTel'])&&$_GET['idTel']!=''){$x6  = $_GET['idTel'];}else{$x6  = '';}}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_date('Fecha Inicio','f_inicio', $x1, 2);
				$Form_Inputs->form_time('Hora Inicio','h_inicio', $x2, 1, 2);
				$Form_Inputs->form_date('Fecha Termino','f_termino', $x3, 2);
				$Form_Inputs->form_time('Hora Termino','h_termino', $x4, 1, 2);
				//$Form_Inputs->form_select('Mostrar Graficos','idGrafico', $x5, 2, 'idOpciones', 'Nombre', 'core_sistemas_opciones', 0, '', $dbConn);

				//Verifico el tipo de usuario que esta ingresando
				if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
					$Form_Inputs->form_select_filter('Equipo','idTelemetria', $x6, 1, 'idTelemetria', 'Nombre', 'telemetria_listado', $z, '', $dbConn);
				}else{
					$Form_Inputs->form_select_join_filter('Equipo','idTelemetria', $x6, 1, 'idTelemetria', 'Nombre', 'telemetria_listado', 'usuarios_equipos_telemetria', $z, $dbConn);
				}
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
