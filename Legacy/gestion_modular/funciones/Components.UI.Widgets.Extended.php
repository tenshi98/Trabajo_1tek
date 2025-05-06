<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')) {
    die('No tienes acceso a esta carpeta o archivo (Access Code 1005-003).');
}
/*******************************************************************************************************************/
/*                                                                                                                 */
/*                                    Se llama a la clase de la que se hereda                                      */
/*                                                                                                                 */
/*******************************************************************************************************************/
require_once '../A2XRXS_gears/xrxs_funciones/Components.UI.Widgets.Common.php';
require_once '../A2XRXS_gears/xrxs_funciones/Components.UI.Widgets.Graphics.php';
require_once '../A2XRXS_gears/xrxs_funciones/Components.UI.Widgets.Maps.php';
/*******************************************************************************************************************/
/*                                                                                                                 */
/*                                                  Funciones                                                      */
/*                                                                                                                 */
/*******************************************************************************************************************/
//construye el listado de errores
function notifications_list($errores){

	$despliegue = '<div id="notifications_list">Notificaciones <a id="close_btn_noti">cerrar</a>';

	if (!empty($errores)) {
		foreach ($errores as $mensaje) {
			list($tipo, $error) = explode("/", $mensaje);
			$despliegue .= '<p><img src="'.DB_SITE_REPO.'/Legacy/gestion_modular/img/icon_'.$tipo.'.png" style="width: 24px;height: 24px;">  '.$error.'</p>';
		}
	}

	$despliegue .= '</div>';

	$despliegue .= "<script type='text/javascript'>
						document.getElementById('close_btn_noti').addEventListener('click', function() {
							document.getElementById('notifications_list').style.display = 'none';
						}, false);
					</script>";

	return $despliegue;
}
/*******************************************************************************************************************/
//paginador
function paginador_1($total_paginas, $original, $search, $num_pag){
	$paginador='';

	//Verifico si hay mas de una pagina, sino coulto el paginador
	if($total_paginas>1){
	//Cargamos la ubicacion original
	$location = $original;
	$location .='?pagina=';

	$paginador .='<div class="row">
			<div class="contaux">
				<div class="dataTables_paginate paging_bootstrap">
					<ul class="pagination menucent">';
						if(($num_pag - 1) > 0) {
							$paginador .='<li class="prev"><a href="'.$location.($num_pag-1).$search.'">← Anterior</a></li>';
						} else {
							$paginador .='<li class="prev disabled"><a href="">← Anterior</a></li>';
						}

						if ($total_paginas>10){
							if(0>$num_pag-5){
								for ($i = 1; $i <= 10; $i++) {
									if ($i==$num_pag){ $xx='class="active"';}else{ $xx='';}
									$paginador .='<li '.$xx.'><a href="'.$location.$i.$search.'">'.$i.'</a></li>';
								 }
							}elseif($total_paginas<$num_pag+5){
								for ($i = $num_pag-5; $i <= $total_paginas; $i++) {
									if ($i==$num_pag){ $xx='class="active"';}else{ $xx='';}
									$paginador .='<li '.$xx.'><a href="'.$location.$i.$search.'">'.$i.'</a></li>';
								 }
							}else{
								for ($i = $num_pag-4; $i <= $num_pag+5; $i++) {
									if ($i==$num_pag){ $xx='class="active"';}else{ $xx='';}
									$paginador .='<li '.$xx.'><a href="'.$location.$i.$search.'">'.$i.'</a></li>';
								}
							}
						}else{
							for ($i = 1; $i <= $total_paginas; $i++) {
								if ($i==$num_pag){ $xx='class="active"';}else{ $xx='';}
								$paginador .='<li '.$xx.'><a href="'.$location.$i.$search.'">'.$i.'</a></li>';
							}
						}
						if(($num_pag + 1)<=$total_paginas) {
							$paginador .='<li class="next"><a href="'.$location.($num_pag+1).$search.'">Siguiente → </a></li>';
						} else {
							$paginador .='<li class="next disabled"><a href="">Siguiente → </a></li>';
						}
					$paginador .='</ul>
				</div>
			</div>
		</div>';
	}
	return $paginador;
}
/*******************************************************************************************************************/
//paginador
function paginador_2($Nombre,$total_paginas, $original, $search, $num_pag){

	$paginador='';

	//Verifico si hay mas de una pagina, sino coulto el paginador
	if($total_paginas>1){
		//Cargamos la ubicacion original
		$location = $original;
		$location .='?pagina=';

		$paginador .='
				<div id="dataTable_paginate" class="dataTables_paginate paging_simple_numbers pull-right">
					<ul class="pagination tablepag custom-pagination">';
						if(($num_pag - 1) > 0) {
							$paginador .='<li class="prev"><a href="'.$location.($num_pag-1).$search.'"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>';
						} else {
							$paginador .='<li class="prev disabled"><a href=""><i class="fa fa-angle-double-left" aria-hidden="true"></i></a></li>';
						}

						$paginador .='<li>
						<select class="form-control" id="'.$Nombre.'" onchange="myFunction'.$Nombre.'()">';
						for ($i = 1; $i <= $total_paginas; $i++) {
							if ($i==$num_pag){ $xx='selected="selected"';}else{ $xx='';}
							$paginador .='<option value="'.$i.'" '.$xx.' >'.$i.'</option>';
						}
						$paginador .='</select>
						</li>
						<script>
							function myFunction'.$Nombre.'() {
								const npage = document.getElementById("'.$Nombre.'").value;
								window.location.href = "'.$location.'"+npage+"'.$search.'";
							}
						</script>';

						if(($num_pag + 1)<=$total_paginas) {
							$paginador .='<li class="next"><a href="'.$location.($num_pag+1).$search.'"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>';
						} else {
							$paginador .='<li class="next disabled"><a href=""><i class="fa fa-angle-double-right" aria-hidden="true"></i></a></li>';
						}
					$paginador .='</ul>
				</div>
				<div class="clearfix"></div>';
	}
	return $paginador;
}
/*******************************************************************************************************************/
//Muestra el nombre de la transaccion a solicitar
function widget_nombre($dato){
	switch ($dato) {
		case "tipo1": return 'Compras';                         break;//Compras
		case "tipo2": return 'Ventas';                          break;//Ventas
		case "tipo3": return 'Gastos';                          break;//Gastos
		case "tipo4": return 'Traspaso entre Bodegas';          break;//Traspaso entre Bodegas
		case "tipo5": return 'Transformacion';                  break;//Transformacion
		case "tipo6": return 'Traspaso otra empresa';           break;//Traspaso otra empresa
		case "tipo7": return 'Gasto de materiales OT';          break;//Gasto de materiales OT
		case "tipo8": return 'Traspaso Manual a otra Empresa';  break;//Traspaso Manual a otra Empresa
		case "tipo9": return 'Ingreso Manual';                  break;//Ingreso Manual

	}
}
/*******************************************************************************************************************/
//Muestra el nombre de la transaccion a solicitar
function widget_pagina($dato, $type){

	//bodegas de productos
	if($type==1){
		switch ($dato) {
			case "tipo1": return 'bodegas_productos_ingreso.php?pagina=1';                  break;//Compras
			case "tipo2": return 'bodegas_productos_egreso.php?pagina=1';                   break;//Ventas
			case "tipo3": return 'bodegas_productos_gasto.php?pagina=1';                    break;//Gastos
			case "tipo4": return 'bodegas_productos_traspaso.php?pagina=1';                 break;//Traspaso entre Bodegas
			case "tipo5": return 'bodegas_productos_transformacion.php?pagina=1';           break;//Transformacion
			case "tipo6": return 'bodegas_productos_traspaso_empresa.php?pagina=1';         break;//Traspaso otra empresa
			case "tipo7": return 'bodegas_productos_egreso_ot.php?pagina=1';                break;//Gasto de materiales OT
			case "tipo8": return 'bodegas_productos_traspaso_empresa_manual.php?pagina=1';  break;//Traspaso Manual a otra Empresa
			case "tipo9": return 'bodegas_productos_ingreso_manual.php?pagina=1';           break;//Ingreso Manual

		}
	//bodegas de insumos
	}elseif($type==2){
		switch ($dato) {
			case "tipo1": return 'bodegas_insumos_ingreso.php?pagina=1';                  break;//Compras
			case "tipo2": return 'bodegas_insumos_ventas.php?pagina=1';                   break;//Ventas
			case "tipo3": return 'bodegas_insumos_egreso.php?pagina=1';                   break;//Gastos
			case "tipo4": return 'bodegas_insumos_traspaso.php?pagina=1';                 break;//Traspaso entre Bodegas
			case "tipo5": return '';                                                      break;//Transformacion
			case "tipo6": return 'bodegas_insumos_traspaso_empresa.php?pagina=1';         break;//Traspaso otra empresa
			case "tipo7": return 'bodegas_insumos_egreso_ot.php?pagina=1';                break;//Gasto de materiales OT
			case "tipo8": return 'bodegas_insumos_traspaso_empresa_manual.php?pagina=1';  break;//Traspaso Manual a otra Empresa
			case "tipo9": return 'bodegas_insumos_ingreso_manual.php?pagina=1';           break;//Ingreso Manual

		}
	//bodegas de arriendos
	}elseif($type==3){
		switch ($dato) {
			case "tipo1": return 'bodegas_arriendos_ingreso.php?pagina=1';                break;//Compras
			case "tipo2": return 'bodegas_arriendos_egreso.php?pagina=1';                 break;//Ventas
		}
	//bodegas de servicios
	}elseif($type==4){
		switch ($dato) {
			case "tipo1": return 'bodegas_servicios_ingreso.php?pagina=1';                break;//Compras
			case "tipo2": return 'bodegas_servicios_egreso.php?pagina=1';                 break;//Ventas
		}
	}
}
/*******************************************************************************************************************/
//Muestra el nombre de la transaccion a solicitar
function widget_barcolor($dato){
	switch ($dato) {
		case "tipo1": return '#FF6961';   break;//Compras
		case "tipo2": return '#779ECB';   break;//Ventas
		case "tipo3": return '#836953';   break;//Gastos
		case "tipo4": return '#B19CD9';   break;//Traspaso entre Bodegas
		case "tipo5": return '#AEC6CF';   break;//Transformacion
		case "tipo6": return '#77DD77';   break;//Traspaso otra empresa
		case "tipo7": return '#CFCFC4';   break;//Gasto de materiales OT
		case "tipo8": return '#B39EB5';   break;//Traspaso Manual a otra Empresa
		case "tipo9": return '#FFB347';   break;//Ingreso Manual

	}
}
/*******************************************************************************************************************/
//Muestra el nombre de la transaccion a solicitar
function widget_widgetcolor($dato){
	switch ($dato) {
		case "tipo1": return 'bg-pastel_red';             break;//Compras
		case "tipo2": return 'bg-dark_pastel_blue';       break;//Ventas
		case "tipo3": return 'bg-pastel_brown';           break;//Gastos
		case "tipo4": return 'bg-light_pastel_purple';    break;//Traspaso entre Bodegas
		case "tipo5": return 'bg-pastel_blue';            break;//Transformacion
		case "tipo6": return 'bg-pastel_green';           break;//Traspaso otra empresa
		case "tipo7": return 'bg-pastel_gray';            break;//Gasto de materiales OT
		case "tipo8": return 'bg-pastel_purple';          break;//Traspaso Manual a otra Empresa
		case "tipo9": return 'bg-pastel_orange';          break;//Ingreso Manual

	}
}
/*******************************************************************************************************************/
//Muestra los widget de acceso comun
function widget_comunes($com_tras, $Wheater, $NombreUsuario, $Notificacion,$CuentaContactos,$CuentaEventos,$CuentaProgramas){

	$comunes='
	<div class="row">

		<script src="'.DB_SITE_REPO.'/Legacy/gestion_modular/lib/weather/jquery.simpleWeather.js"></script>
		<script src="'.DB_SITE_REPO.'/Legacy/gestion_modular/lib/skycons/skycons.js"></script>

		<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
			<div class="info-box bg-aqua" id="weather">
			</div>
		</div>';

		$comuna = 'Santiago';
		if(isset($com_tras)&&$com_tras!=''){$comuna = $com_tras;}

		$comunes.='
		<script>
				$(document).ready(function() {
				  $.simpleWeather({
					location: \''.$comuna.', Chile\',
					woeid: \'\',
					unit: \'c\',
					success: function(weather) {

						let meteo = "";
						switch (weather.code) {
							case \'1\':
							case \'2\':
							case \'3\':
							case \'4\':
							case \'37\':
							case \'38\':
							case \'39\':
							case \'45\':
							case \'47\':
								meteo = "rain";
								break;

							case \'5\':
							case \'6\':
							case \'7\':
							case \'8\':
							case \'10\':
							case \'15\':
							case \'17\':
							case \'18\':
							case \'35\':
							case \'40\':
							case \'42\':
							case \'43\':
							case \'46\':
								meteo = "sleet";
								break;

							case \'9\':
							case \'11\':
							case \'12\':
							case \'13\':
							case \'14\':
							case \'16\':
							case \'42\':
								meteo = "snow";
								break;

							case \'19\':
							case \'20\':
							case \'21\':
							case \'22\':
							case \'23\':
								meteo = "fog";
								break;

							case \'19\':
							case \'20\':
							case \'21\':
							case \'22\':
							case \'23\':
								meteo = "fog";
								break;

							case \'24\':
							case \'25\':
								meteo = "wind";
								break;

							case \'27\':
							case \'29\':
							case \'44\':
								meteo = "partly-cloudy-night";
								break;

							case \'28\':
							case \'30\':
								meteo = "wind";
								break;

							case \'31\':
							case \'33\':
								meteo = "clear-night";
								break;

							case \'32\':
							case \'34\':
							case \'36\':
								meteo = "clear-day";
								break;

							case \'26\':
								meteo = "cloudy";
								break;

						}

						html  = \'<span class="info-box-icon"><canvas id="\'+meteo+\'" width="64" height="64" style="margin-top:12px;"></canvas></span>\';
						html += \'<div class="info-box-content">\';
						html += \'	<span class="info-box-text">El Tiempo</span>\';
						html += \'	<span class="info-box-number">\'+weather.temp+\'&deg;\'+weather.units.temp+\'</span>\';
						html += \'	<div class="progress">\';
						html += \'		<div class="progress-bar" style="width: 100%"></div>\';
						html += \'	</div>\';
						html += \'	<span class="progress-description">\';
						html += \'		<a target="_blank" rel="noopener noreferrer" href="'.$Wheater.'">\';
						html += \'         '.$comuna.', Chile\';
						html += \'		</a>\';
						html += \'	</span>\';
						html += \'</div>\';

					  $("#weather").html(html);
					  //agrego los icono animados
					  var icons = new Skycons({"color": "white"}),
						  list  = [
							"clear-day", "clear-night", "partly-cloudy-day",
							"partly-cloudy-night", "cloudy", "rain", "sleet", "snow", "wind",
							"fog"
						  ],
						  i;

					  for(i = list.length; i--; )
						icons.set(list[i], list[i]);

					  icons.play();

					},
					error: function(error) {
					  $("#weather").html(\'<p>\'+error+\'</p>\');
					}
				  });
				});
			</script>';

		$comunes.=widget_Ficha_1('bg-green', 'fa-user', 100, 'Perfil', $NombreUsuario, 'principal_datos.php', 'Editar Mis Datos', 1, 1);

		$animated = '';
		if($Notificacion!=0){ $animated = 'faa-horizontal animated';}

		$comunes.=widget_Ficha_1('bg-yellow', 'fa-commenting-o '.$animated, 100, 'Notificaciones', $Notificacion.' sin leer', 'principal_notificaciones.php?pagina=1', 'Ver Notificaciones', 1, 1);
		$comunes.=widget_Ficha_1('bg-red', 'fa-question', 100, 'Archivos de ayuda', 'Archivos', 'principal_ayuda.php?pagina=1', 'Ver Archivos', 1, 1);
		$comunes.=widget_Ficha_1('bg-purple', 'fa-file-word-o', 100, 'Procedimientos', 'Archivos', 'principal_procedimientos.php?pagina=1', 'Ver Procedimientos', 1, 1);
		$comunes.=widget_Ficha_1('bg-black', 'fa-phone', 100, 'Contactos', $CuentaContactos.' Contactos', 'principal_agenda_telefonica.php?pagina=1', 'Ver Contactos', 1, 1);
		$comunes.=widget_Ficha_1('bg-aqua', 'fa-calendar', 100, 'Calendario', $CuentaEventos.' Este Mes', 'principal_calendario.php?pagina=1', 'Ver Eventos', 1, 1);
		$comunes.=widget_Ficha_1('bg-green', 'fa-desktop', 100, 'Programas Recomendados', $CuentaProgramas.' Programas', 'principal_software.php?pagina=1', 'Ver Programas', 1, 1);

		$comunes.='</div>';

	return $comunes;
}
/*******************************************************************************************************************/
//Muestra los widget de acceso especificos
function widget_especificos($idTipoUsuario,
							$n_link_1,$link_1,$cant_link_1,
							$n_link_2,$link_2,$cant_link_2,
							$n_link_3,$link_3,$cant_link_3,
							$n_link_4,$link_4,$cant_link_4){

	$especificos='
	<div class="row">';

		/*****************************************************************************************************************/
		/*                                         Administracion de clientes                                            */
		/*****************************************************************************************************************/
		if($n_link_1=='1' OR $idTipoUsuario==1) {
			$especificos.= widget_Ficha_3('btn-primary', 'fa-user', $cant_link_1, 'Clientes', $link_1.'?pagina=1', 'Administrar', 1, 1);
		}
		/*****************************************************************************************************************/
		/*                                         Administracion de Usuarios                                            */
		/*****************************************************************************************************************/
		if($n_link_2=='1' OR $idTipoUsuario==1) {
			$especificos.= widget_Ficha_3('bg-green', 'fa-users', $cant_link_2, 'Usuarios', $link_2.'?pagina=1', 'Administrar', 1, 1);
		}
		/*****************************************************************************************************************/
		/*                                        Administracion de Proveedores                                          */
		/*****************************************************************************************************************/
		if($n_link_3=='1' OR $idTipoUsuario==1) {
			$especificos.= widget_Ficha_3('bg-yellow', 'fa-truck', $cant_link_2, 'Proveedores', $link_3.'?pagina=1', 'Administrar', 1, 1);
		}
		/*****************************************************************************************************************/
		/*                                      Administracion de Trabajadores                                           */
		/*****************************************************************************************************************/
		if($n_link_4=='1' OR $idTipoUsuario==1) {
			$especificos.= widget_Ficha_3('bg-red', 'fa-male', $cant_link_4, 'Trabajadores', $link_4.'?pagina=1', 'Administrar', 1, 1);
		}

	$especificos.='
	</div>';

	return $especificos;
}
/*******************************************************************************************************************/
//Muestra los widget de acceso a recordatorios
function widget_recordatorios($idTipoUsuario,
							  $n_link_1,$cant_link_1,
							  $n_link_2,$cant_link_2,
							  $n_link_3,$cant_link_3,
							  $n_link_4,$cant_link_4a,$cant_link_4b,
							  $n_link_5,$cant_link_5,
							  $n_link_6,$cant_link_6,
							  $n_link_7,$cant_link_7,
							  $n_link_8,$cant_link_8){

	$recordatorios = '';
	/////////////////////////////////////////////////////////////////////////////////////
	$recordatorios .= '<h3 class="supertittle text-primary">Recordatorios</h3>';
	$recordatorios .= '<div class="row">';
		/*****************************************************************************************************************/
		/*                                       Cargas por vencer esta semana                                           */
		/*****************************************************************************************************************/
		if($n_link_1=='1' OR $idTipoUsuario==1) {
			$recordatorios.=widget_Ficha_1('bg-aqua', 'fa-usd', 100, 'Cargas por Vencer', $cant_link_1.' Esta Semana', 'principal_cargas.php?pagina=1', 'Ver Cargas', 1, 1);
		}
		/*****************************************************************************************************************/
		/*                                       Solicitudes sin OC Asignada                                             */
		/*****************************************************************************************************************/
		if($n_link_2=='1' OR $idTipoUsuario==1) {
			$recordatorios.=widget_Ficha_1('bg-green', 'fa-cube', 100, 'Solicitudes sin OC', $cant_link_2.' Sin Asignar', 'ocompra_generacion.php', 'Ver Solicitudes', 1, 1);
		}
		/*****************************************************************************************************************/
		/*                                             OC sin Aprobar                                                    */
		/*****************************************************************************************************************/
		if($n_link_3=='1' OR $idTipoUsuario==1) {
			$recordatorios.=widget_Ficha_1('bg-yellow', 'fa-database', 100, 'OC sin Aprobar', $cant_link_3.' Pendientes', 'ocompra_listado_sin_aprobar.php?pagina=1', 'Ver OC sin Aprobar', 1, 1);
		}
	/*****************************************************************************************************************/
	$recordatorios.='</div>';
	/////////////////////////////////////////////////////////////////////////////////////
	$recordatorios .= '<h3 class="supertittle text-primary">Compras</h3>';
	$recordatorios .= '<div class="row">';
		/*****************************************************************************************************************/
		/*                                       Facturas a pagar o retrasadas                                           */
		/*****************************************************************************************************************/
		if($n_link_4!='0' OR $idTipoUsuario==1) {
			if($cant_link_4b!=0){
				$recordatorios.=widget_Ficha_1('bg-red', 'fa-cc-paypal', 100, 'Facturas atrasadas', $cant_link_4b.' Pago Atrasado', 'principal_facturas.php?pagina=1&idTipo=1', 'Ver Facturas', 1, 1);
			}else{
				$recordatorios.=widget_Ficha_1('bg-black', 'fa-cc-paypal', 100, 'Facturas x Pagar', $cant_link_4a.' Esta Semana', 'principal_facturas.php?pagina=1&idTipo=1', 'Ver Facturas', 1, 1);
			}
		}

		/*****************************************************************************************************************/
		/*                                     Arriendos por vencer esta semana                                          */
		/*****************************************************************************************************************/
		if($n_link_5=='1' OR $idTipoUsuario==1) {
			$recordatorios.=widget_Ficha_1('bg-yellow', 'fa-calendar-o', 100, 'Devolucion Arriendos', $cant_link_5.' Devoluciones', 'principal_arriendos.php?pagina=1&idTipo=1', 'Ver Devolucion Arriendos', 1, 1);
		}
		/*****************************************************************************************************************/
		/*                                          Documentos por pagar                                                 */
		/*****************************************************************************************************************/
		if($n_link_8!=0 OR $idTipoUsuario==1) {
			$recordatorios.=widget_Ficha_1('bg-aqua', 'fa-credit-card', 100, 'Documentos por Pagar', $cant_link_8.' Esta Semana', 'principal_cheques_pagar.php?pagina=1', 'Ver Documentos', 1, 1);
		}
	/*****************************************************************************************************************/
	$recordatorios.='</div>';
	/////////////////////////////////////////////////////////////////////////////////////
	$recordatorios .= '<h3 class="supertittle text-primary">Ventas</h3>';
	$recordatorios .= '<div class="row">';
		/*****************************************************************************************************************/
		/*                                            Facturas a Cobrar                                                  */
		/*****************************************************************************************************************/
		if($n_link_6!='0' OR $idTipoUsuario==1) {
			$recordatorios.=widget_Ficha_1('bg-black', 'fa-cc-paypal', 100, 'Facturas x Cobrar', $cant_link_6.' Esta Semana', 'principal_facturas.php?pagina=1&idTipo=2', 'Ver Facturas', 1, 1);
		}
		/*****************************************************************************************************************/
		/*                                     Arriendos por vencer esta semana                                          */
		/*****************************************************************************************************************/
		if($n_link_7=='1' OR $idTipoUsuario==1) {
			$recordatorios.=widget_Ficha_1('bg-yellow', 'fa-calendar-o', 100, 'Devolucion Arriendos', $cant_link_7.' Devoluciones', 'principal_arriendos.php?pagina=1&idTipo=2', 'Ver Devolucion Arriendos', 1, 1);
		}
	/*****************************************************************************************************************/
	$recordatorios.='</div>';

	return $recordatorios;
}
/*******************************************************************************************************************/
//Despliega un detalle de las bodegas
function widget_bodega($titulo,
					   $bodega, $bodega_existencia, $bodega_tipo,
					   $producto, $uml, $required,$type,
					   $enlace,$dbConn,
					   $tablaPermiso, $idSistema){

	/***********************************************************/
	//Se limitan los permisos a las bodegas asignadas
	if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
		//$x1 ="idSistema>=0";
		$x2 ="idUsuario>=0";
	}else{
		//$x1 ="idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
		$x2 ="idUsuario = ".$_SESSION['usuario']['basic_data']['idUsuario'];
	}
	$x1 ="idSistema=".$idSistema;
	//Variables
	$join_1  = "";
	$where_1 = "";
	//Si existe el dato de la tabla
	if($tablaPermiso!=''){
		$join_1  = "INNER JOIN ".$tablaPermiso." ON ".$tablaPermiso.".idBodega = ".$bodega_existencia.".idBodega";
		$where_1 = " AND ".$bodega_existencia.".".$x1." AND ".$tablaPermiso.".".$x2;
	}

	//Variable
	$Graficos = '';

	/***********************************************************/
	// Se trae un listado con los valores de las existencias actuales
	$ano_pasado = ano_actual()-1;
	if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
		$z = "idSistema>=0 AND Creacion_ano >= ".$ano_pasado;
	}else{
		$z = "idSistema='".$_SESSION['usuario']['basic_data']['idSistema']."' AND Creacion_ano >= ".$ano_pasado;
	}

	$SIS_query = 'Creacion_ano,Creacion_mes,idTipo,SUM(ValorTotal) AS Valor';
	$SIS_join  = $join_1;
	$SIS_where = $z.$where_1.' GROUP BY Creacion_ano,Creacion_mes,idTipo';
	$SIS_order = 'Creacion_ano ASC, Creacion_mes ASC';

	$arrExistencias = array();
	$arrExistencias = db_select_array (false, $SIS_query, $bodega_existencia, $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrExistencias');

	/***********************************************************/
	//Se verifica si existe tabla relacionada a los permisos
	if(isset($uml)&&$uml!=''&&$uml!='0'){
		$SIS_where = $bodega_existencia.".Creacion_ano=".ano_actual();
		// Se trae un listado con todos los movimientos de bodega
		if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
			$SIS_where .= " AND ".$bodega_existencia.".idSistema>=0";
		}else{
			$SIS_where .= " AND ".$bodega_existencia.".idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
		}

		$SIS_query = '
		'.$bodega_existencia.'.Creacion_fecha,
		'.$bodega_existencia.'.Cantidad_ing,
		'.$bodega_existencia.'.Cantidad_eg,
		'.$bodega_existencia.'.idFacturacion,
		'.$bodega_tipo.'.Nombre AS TipoMovimiento,
		'.$producto.'.Nombre AS NombreProducto,
		'.$uml.'.Nombre AS UnidadMedida,
		'.$bodega.'.Nombre AS NombreBodega';
		$SIS_join  = '
		LEFT JOIN `'.$bodega_tipo.'`  ON '.$bodega_tipo.'.idTipo    = '.$bodega_existencia.'.idTipo
		LEFT JOIN `'.$producto.'`     ON '.$producto.'.idProducto   = '.$bodega_existencia.'.idProducto
		LEFT JOIN `'.$uml.'`          ON '.$uml.'.idUml             = '.$producto.'.idUml
		LEFT JOIN `'.$bodega.'`       ON '.$bodega.'.idBodega       = '.$bodega_existencia.'.idBodega
		'.$join_1;
		$SIS_where.= $where_1;
		$SIS_order = $bodega_existencia.'.Creacion_fecha DESC LIMIT 10';
		$arrMovimientos = array();
		$arrMovimientos = db_select_array (false, $SIS_query, $bodega_existencia, $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrMovimientos');

		/***********************************************************/
		//Productos con bajo stock
		$SIS_query = '
		'.$producto.'.StockLimite,
		'.$producto.'.Nombre AS NombreProd,
		'.$uml.'.Nombre AS UnidadMedida,
		(SELECT SUM(Cantidad_ing) FROM '.$bodega_existencia.' WHERE idProducto = '.$producto.'.idProducto AND idSistema = '.$_SESSION['usuario']['basic_data']['idSistema'].' ) AS stock_entrada,
		(SELECT SUM(Cantidad_eg)  FROM '.$bodega_existencia.' WHERE idProducto = '.$producto.'.idProducto AND idSistema = '.$_SESSION['usuario']['basic_data']['idSistema'].' ) AS stock_salida';
		$SIS_join  = 'LEFT JOIN `'.$uml.'` ON '.$uml.'.idUml = '.$producto.'.idUml';
		$SIS_where = $producto.'.StockLimite >0';
		$SIS_order = $producto.'.StockLimite DESC, '.$producto.'.Nombre ASC LIMIT 10';
		$arrProductos = array();
		$arrProductos = db_select_array (false, $SIS_query, $producto, $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrProductos');

	}

	/***********************************************************/
	//Calculo para los graficos
	$mes = array();
	foreach ($arrExistencias as $existencias) {
		//se crean las variables con valor 0
		if(!isset($mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo1'])){   $mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo1']  = 0;}
		if(!isset($mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo2'])){   $mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo2']  = 0;}
		if(!isset($mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo3'])){   $mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo3']  = 0;}
		if(!isset($mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo4'])){   $mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo4']  = 0;}
		if(!isset($mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo5'])){   $mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo5']  = 0;}
		if(!isset($mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo6'])){   $mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo6']  = 0;}
		if(!isset($mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo7'])){   $mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo7']  = 0;}
		if(!isset($mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo8'])){   $mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo8']  = 0;}
		if(!isset($mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo9'])){   $mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo9']  = 0;}

		//se comienza a guardar los datos
		switch ($existencias['idTipo']) {
			//Compra de Productos a bodega
			case 1:
				$mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo1'] = $mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo1'] + $existencias['Valor'];
				break;

			//Venta de Productos de bodega
			case 2:
				$mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo2'] = $mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo2'] + $existencias['Valor'];
				break;

			//Gasto de Productos
			case 3:
				$mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo3'] = $mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo3'] + $existencias['Valor'];
				break;

			//Traspaso de Productos entre bodegas
			case 4:
				$mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo4'] = $mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo4'] + $existencias['Valor'];
				break;

			//Transformacion de Productos
			case 5:
				$mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo5'] = $mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo5'] + $existencias['Valor'];
				break;

			//Traspaso de Productos a otra Empresa
			case 6:
				if($existencias['Cantidad_ing']!=0){
					$mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo1'] = $mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo1'] + $existencias['Valor'];
				}else{
					$mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo6'] = $mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo6'] + $existencias['Valor'];
				}
				break;

			//Gasto de Productos en una Orden de Trabajo
			case 7:
				$mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo7'] = $mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo7'] + $existencias['Valor'];
				break;

			//Traspaso Manual de Productos a otra Empresa
			case 8:
				$mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo8'] = $mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo8'] + $existencias['Valor'];
				break;
			//Ingreso Manual
			case 9:
				$mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo9'] = $mes[$existencias['Creacion_ano']][$existencias['Creacion_mes']]['tipo9'] + $existencias['Valor'];
				break;
		}
	}

	//guardo los datos correspondientes
	$xmes = mes_actual();
	$xaño = ano_actual();
	$grafico = array();
	for ($xcontador = 12; $xcontador > 0; $xcontador--) {

		if($xmes>0){

			$grafico[$xcontador]['mes'] = $xmes;
			$grafico[$xcontador]['año'] = $xaño;
			if(isset($mes[$xaño][$xmes]['tipo1'])){  $grafico[$xcontador]['tipo1'] = $mes[$xaño][$xmes]['tipo1'];  }else{$grafico[$xcontador]['tipo1'] = 0;};
			if(isset($mes[$xaño][$xmes]['tipo2'])){  $grafico[$xcontador]['tipo2'] = $mes[$xaño][$xmes]['tipo2'];  }else{$grafico[$xcontador]['tipo2'] = 0;};
			if(isset($mes[$xaño][$xmes]['tipo3'])){  $grafico[$xcontador]['tipo3'] = $mes[$xaño][$xmes]['tipo3'];  }else{$grafico[$xcontador]['tipo3'] = 0;};
			if(isset($mes[$xaño][$xmes]['tipo4'])){  $grafico[$xcontador]['tipo4'] = $mes[$xaño][$xmes]['tipo4'];  }else{$grafico[$xcontador]['tipo4'] = 0;};
			if(isset($mes[$xaño][$xmes]['tipo5'])){  $grafico[$xcontador]['tipo5'] = $mes[$xaño][$xmes]['tipo5'];  }else{$grafico[$xcontador]['tipo5'] = 0;};
			if(isset($mes[$xaño][$xmes]['tipo6'])){  $grafico[$xcontador]['tipo6'] = $mes[$xaño][$xmes]['tipo6'];  }else{$grafico[$xcontador]['tipo6'] = 0;};
			if(isset($mes[$xaño][$xmes]['tipo7'])){  $grafico[$xcontador]['tipo7'] = $mes[$xaño][$xmes]['tipo7'];  }else{$grafico[$xcontador]['tipo7'] = 0;};
			if(isset($mes[$xaño][$xmes]['tipo8'])){  $grafico[$xcontador]['tipo8'] = $mes[$xaño][$xmes]['tipo8'];  }else{$grafico[$xcontador]['tipo8'] = 0;};
			if(isset($mes[$xaño][$xmes]['tipo9'])){  $grafico[$xcontador]['tipo9'] = $mes[$xaño][$xmes]['tipo9'];  }else{$grafico[$xcontador]['tipo9'] = 0;};

		}else{

			$xmes = 12;
			$xaño = $xaño-1;
			$grafico[$xcontador]['mes'] = $xmes;
			$grafico[$xcontador]['año'] = $xaño;
			if(isset($mes[$xaño][$xmes]['tipo1'])){  $grafico[$xcontador]['tipo1'] = $mes[$xaño][$xmes]['tipo1'];  }else{$grafico[$xcontador]['tipo1'] = 0;};
			if(isset($mes[$xaño][$xmes]['tipo2'])){  $grafico[$xcontador]['tipo2'] = $mes[$xaño][$xmes]['tipo2'];  }else{$grafico[$xcontador]['tipo2'] = 0;};
			if(isset($mes[$xaño][$xmes]['tipo3'])){  $grafico[$xcontador]['tipo3'] = $mes[$xaño][$xmes]['tipo3'];  }else{$grafico[$xcontador]['tipo3'] = 0;};
			if(isset($mes[$xaño][$xmes]['tipo4'])){  $grafico[$xcontador]['tipo4'] = $mes[$xaño][$xmes]['tipo4'];  }else{$grafico[$xcontador]['tipo4'] = 0;};
			if(isset($mes[$xaño][$xmes]['tipo5'])){  $grafico[$xcontador]['tipo5'] = $mes[$xaño][$xmes]['tipo5'];  }else{$grafico[$xcontador]['tipo5'] = 0;};
			if(isset($mes[$xaño][$xmes]['tipo6'])){  $grafico[$xcontador]['tipo6'] = $mes[$xaño][$xmes]['tipo6'];  }else{$grafico[$xcontador]['tipo6'] = 0;};
			if(isset($mes[$xaño][$xmes]['tipo7'])){  $grafico[$xcontador]['tipo7'] = $mes[$xaño][$xmes]['tipo7'];  }else{$grafico[$xcontador]['tipo7'] = 0;};
			if(isset($mes[$xaño][$xmes]['tipo8'])){  $grafico[$xcontador]['tipo8'] = $mes[$xaño][$xmes]['tipo8'];  }else{$grafico[$xcontador]['tipo8'] = 0;};
			if(isset($mes[$xaño][$xmes]['tipo9'])){  $grafico[$xcontador]['tipo9'] = $mes[$xaño][$xmes]['tipo9'];  }else{$grafico[$xcontador]['tipo9'] = 0;};

		}
		$xmes = $xmes-1;

	}

	//Separo los datos solicitados
	$datos = explode(",", $required);
	if(count($datos)==1){
		$data_required = ",'".widget_nombre($datos[0])."'";
		$colors = "'".widget_barcolor($datos[0])."'";
	}else{
		$data_required = '';
		$colors = '';
		foreach($datos as $dato){
			$data_required .= ",'".widget_nombre($dato)."'";
			$colors .= "'".widget_barcolor($dato)."',";
		}
	}


	$Graficos = '';

		//verifico si se envio un dato en enlace para asi ver si imprimo o no el marco contenedor del grafico
		if(isset($enlace)&&$enlace!=''){
			$Graficos .= '
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="box">
						<header>
							<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>'.$titulo.'</h5>
							<div class="toolbar">
								<a target="new" href="'.$enlace.'?pagina=1" class="btn btn-xs btn-primary btn-line">Ver Mas</a>
							</div>

						</header>

						<div class="body">
							<div class="box-body">';
		}
			$Graficos .= '
						<div class="row">
							<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
								<div class="chart">';

			$Graficos .= "
									<script type='text/javascript'>
									google.charts.setOnLoadCallback(drawChart_".$type.");
									function drawChart_".$type."() {
										var data = google.visualization.arrayToDataTable([

										['Meses'".$data_required."]";

											//Recorro los meses
											for ($xyz = 1; $xyz <= 12; $xyz++) {
												//Se agrega el mes
												$Graficos .= ",['".numero_a_mes_corto($grafico[$xyz]['mes'])."'";
												//Se agregan los datos
												if(count($datos)==1){
													$Graficos .= ", ".$grafico[$xyz][$datos[0]];
												}else{
													foreach($datos as $dato){
														$Graficos .= ", ".$grafico[$xyz][$dato];
													}
												}
												$Graficos .= " ]";
											}


			$Graficos .= '

										]);

										var options = {
										chart_'.$type.': {
											title: \'Balance\',
											subtitle: \'Movimientos ultimos 12 Meses\',

										},
										vAxis: {format: \'none\'},
										legend: { position: \'none\' },
										colors: ['.$colors.'],

										};

										var chart_'.$type.' = new google.charts.Bar(document.getElementById(\'columnchart_'.$type.'_material\'));
										var table_'.$type.' = new google.visualization.Table(document.getElementById(\'table_div_'.$type.'\'));
										table_'.$type.'.draw(data, {showRowNumber: true, width: \'100%\', height: \'100%\'});

										google.visualization.events.addListener(chart_'.$type.', \'error\', function (googleError) {
											google.visualization.errors.removeError(googleError.id);
											document.getElementById("error_'.$type.'_msg").innerHTML = "Message removed = \'" + googleError.message + "\'";
										});


										chart_'.$type.'.draw(data, options);
									}
									</script>

									<div id="columnchart_'.$type.'_material" style="width: 100%; height: 500px;"></div>
									<div id="table_div_'.$type.'" ></div>
									<div id="error_'.$type.'_msg"></div>

								</div>
							</div>
							<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">';

				//Se crean los widget de forma dinamica
				if(count($datos)==1){
					if(isset($grafico[12][$datos[0]])&&$grafico[12][$datos[0]]!=''){
						$Graficos .= '
						<div class="info-box '.widget_widgetcolor($datos[0]).'">
							<span class="info-box-icon"><i class="fa fa-cubes" aria-hidden="true"></i></span>
							<div class="info-box-content">
								<span class="info-box-text">Total '.widget_nombre($datos[0]).' del mes</span>
								<span class="info-box-number">';
								if(isset($grafico[12][$datos[0]])&&$grafico[12][$datos[0]]!=''){
									$Graficos .= Valores($grafico[12][$datos[0]], 0);
								}else{
									$Graficos .= Valores(0, 0);
								}
							$Graficos .= '</span>
								<div class="progress">
									<div class="progress-bar" style="width: 100%"></div>
								</div>
								<span class="progress-description">
									<a href="'.widget_pagina($datos[0], $type).'" class="faa-parent animated-hover">
										Ver '.widget_nombre($datos[0]).' <i class="fa fa-arrow-circle-right faa-passing" aria-hidden="true"></i>
									</a>
								</span>
							</div>
						</div>';
					}

				}else{
					foreach($datos as $dato){
						if(isset($grafico[12][$dato])&&$grafico[12][$dato]!=''){
							$Graficos .= '
							<div class="info-box '.widget_widgetcolor($dato).'">
								<span class="info-box-icon"><i class="fa fa-cubes" aria-hidden="true"></i></span>
								<div class="info-box-content">
									<span class="info-box-text">Total '.widget_nombre($dato).' del mes</span>
									<span class="info-box-number">';
									if(isset($grafico[12][$dato])&&$grafico[12][$dato]!=''){
										$Graficos .= Valores($grafico[12][$dato], 0);
									}else{
										$Graficos .= Valores(0, 0);
									}
								$Graficos .= '</span>
									<div class="progress">
										<div class="progress-bar" style="width: 100%"></div>
									</div>
									<span class="progress-description">
										<a href="'.widget_pagina($dato, $type).'" class="faa-parent animated-hover">
											Ver '.widget_nombre($dato).' <i class="fa fa-arrow-circle-right faa-passing" aria-hidden="true"></i>
										</a>
									</span>
								</div>
							</div>';
						}
					}
				}

							$Graficos .= '</div>
						</div>';

		//verifico si se envio un dato en enlace para asi ver si imprimo o no el marco contenedor del grafico
		if(isset($enlace)&&$enlace!=''){
					$Graficos .= '
					</div>
					<div class="box-footer"></div>
				</div>
			</div>
		</div>
	</div>';
	}
	/**************************************************************************/
	//Si el usuario es distinto a los gerentes
	if ($_SESSION['usuario']['basic_data']['idTipoUsuario']!=4&&isset($uml)&&$uml!=''&&$uml!='0'){
	$Graficos .= '<div class="row">

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				<div class="box">
					<header>
						<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Ultimos movimientos</h5>
					</header>
					<div class="table-responsive">
						<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
							<thead>
								<tr role="row">
									<th>Movimiento</th>
									<th>Fecha</th>
									<th>Producto</th>
									<th>Bodega</th>
									<th>Cantidad</th>
								</tr>
							</thead>

							<tbody role="alert" aria-live="polite" aria-relevant="all">';
							foreach ($arrMovimientos as $mov) {

								$Graficos .= '<tr class="odd">
									<td>'.$mov['TipoMovimiento'].'</td>
									<td>'.Fecha_estandar($mov['Creacion_fecha']).'</td>
									<td>'.$mov['NombreProducto'].'</td>
									<td>'.$mov['NombreBodega'].'</td>
									<td>';
									if(isset($mov['Cantidad_ing'])&&$mov['Cantidad_ing']!=0){
										$Graficos .= 'Ingreso '.Cantidades_decimales_justos($mov['Cantidad_ing']).' '.$mov['UnidadMedida'];
									}else{
										$Graficos .= 'Egreso '.Cantidades_decimales_justos($mov['Cantidad_eg']).' '.$mov['UnidadMedida'];
									}

								$Graficos .= '</td>
								</tr>';
							}
							$Graficos .= '</tbody>
						</table>
					</div>
				</div>
			</div>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				<div class="box">
					<header>
						<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Productos con bajo Stock</h5>
					</header>
					<div class="table-responsive">
						<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
							<thead>
								<tr role="row">
									<th>Producto</th>
									<th>Stock Min</th>
									<th>Stock Act</th>
								</tr>
							</thead>
							<tbody role="alert" aria-live="polite" aria-relevant="all">';
							foreach ($arrProductos as $productos) {
								$stock_actual = $productos['stock_entrada'] - $productos['stock_salida'];
								if ($productos['StockLimite']>$stock_actual){
								$Graficos .= '<tr class="odd">
									<td>'.$productos['NombreProd'].'</td>
									<td>'.Cantidades_decimales_justos($productos['StockLimite']).' '.$productos['UnidadMedida'].'</td>
									<td>'.Cantidades_decimales_justos($stock_actual).' '.$productos['UnidadMedida'].'</td>
								</tr>';
								}
							}
							$Graficos .= '</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>';
	}



	return $Graficos;
}
/*******************************************************************************************************************/
//Muestra los equipos en el mapa
function widget_GPS_equipos($titulo,$nombreEquipo, $seguimiento, $map_visibility, $idSistema,
							$IDGoogle, $idTipoUsuario, $idUsuario, $dbConn){

	//Si no existe una ID se utiliza una por defecto
	if(!isset($IDGoogle) OR $IDGoogle==''){
		return alert_post_data(4,1,1,0, 'No ha ingresado Una API de Google Maps');
	}else{

		/*******************************************************************************/
		//variables
		$HoraSistema    = hora_actual();
		$FechaSistema   = fecha_actual();
		$eq_alertas     = 0;
		$eq_fueralinea  = 0;
		$eq_fueraruta   = 0;
		$eq_detenidos   = 0;
		$eq_gps_fuera   = 0;
		$eq_ok          = 0;
		$google         = $IDGoogle;

		/*******************************************************************************/
		//Variable
		$SIS_where = "telemetria_listado.idEstado = 1 ";//solo equipos activos
		//solo los equipos que tengan el seguimiento activado
		if(isset($seguimiento)&&$seguimiento!=''&&$seguimiento!=0){
			$SIS_where .= " AND telemetria_listado.id_Geo = ".$seguimiento;
		}
		//Filtro el sistema al cual pertenece
		if(isset($idSistema)&&$idSistema!=''&&$idSistema!=0){
			$SIS_where .= " AND telemetria_listado.idSistema = ".$idSistema;
		}
		//Verifico el tipo de usuario que esta ingresando y el id
		$SIS_join = "";
		if(isset($idTipoUsuario, $idUsuario)&&$idTipoUsuario!=1&&$idUsuario!=0){
			$SIS_join  .= " INNER JOIN usuarios_equipos_telemetria ON usuarios_equipos_telemetria.idTelemetria = telemetria_listado.idTelemetria ";
			$SIS_where .= " AND usuarios_equipos_telemetria.idUsuario = ".$idUsuario;
		}

		$SIS_query = '
		telemetria_listado.LastUpdateFecha,
		telemetria_listado.LastUpdateHora,
		telemetria_listado.cantSensores,
		telemetria_listado.GeoLatitud,
		telemetria_listado.GeoLongitud,
		telemetria_listado.NDetenciones,
		telemetria_listado.TiempoFueraLinea,
		telemetria_listado.GeoErrores,
		telemetria_listado.NErrores';
		$SIS_order = 'telemetria_listado.Nombre ASC';
		$arrEquipo = array();
		$arrEquipo = db_select_array (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrEquipo');

		/*******************************************************************************/
		//recorro
		foreach ($arrEquipo as $data) {

			/**********************************************/
			//Se resetean
			$in_eq_alertas     = 0;
			$in_eq_fueralinea  = 0;
			$in_eq_fueraruta   = 0;
			$in_eq_detenidos   = 0;
			$in_eq_gps_fuera   = 0;
			$in_eq_ok          = 1;

			/**********************************************/
			//Fuera de linea
			$diaInicio   = $data['LastUpdateFecha'];
			$diaTermino  = $FechaSistema;
			$tiempo1     = $data['LastUpdateHora'];
			$tiempo2     = $HoraSistema;
			$Tiempo      = horas_transcurridas($diaInicio, $diaTermino, $tiempo1, $tiempo2);

			//Comparaciones de tiempo
			$Time_Tiempo     = horas2segundos($Tiempo);
			$Time_Tiempo_FL  = horas2segundos($data['TiempoFueraLinea']);
			$Time_Tiempo_Max = horas2segundos('48:00:00');
			$Time_Fake_Ini   = horas2segundos('23:59:50');
			$Time_Fake_Fin   = horas2segundos('24:00:00');
			//comparacion
			if(($Time_Tiempo<$Time_Fake_Ini OR $Time_Tiempo>$Time_Fake_Fin)&&(($Time_Tiempo>$Time_Tiempo_FL&&$Time_Tiempo_FL!=0) OR ($Time_Tiempo>$Time_Tiempo_Max&&$Time_Tiempo_FL==0))){
				$in_eq_fueralinea++;
			}

			/**********************************************/
			//GPS con problemas
			if(isset($data['GeoErrores'])&&$data['GeoErrores']>0){ $in_eq_gps_fuera++; }

			/**********************************************/
			//Equipos Errores
			if(isset($data['NErrores'])&&$data['NErrores']>0){ $in_eq_alertas++; }

			/**********************************************/
			//Equipos detenidos
			if(isset($data['NDetenciones'])&&$data['NDetenciones']>0){ $in_eq_detenidos++; }

			/*******************************************************/
			//rearmo
			if($in_eq_detenidos>0){  $in_eq_ok = 0;$in_eq_detenidos = 1;}
			if($in_eq_alertas>0){    $in_eq_ok = 0;$in_eq_alertas = 1;    $in_eq_detenidos = 0;}
			if($in_eq_fueraruta>0){  $in_eq_ok = 0;$in_eq_fueraruta = 1;  $in_eq_alertas = 0;   $in_eq_detenidos = 0;}
			if($in_eq_gps_fuera>0){  $in_eq_ok = 0;$in_eq_gps_fuera = 1;  $in_eq_fueraruta = 0; $in_eq_alertas = 0;    $in_eq_detenidos = 0;}
			if($in_eq_fueralinea>0){ $in_eq_ok = 0;$in_eq_fueralinea = 1; $in_eq_gps_fuera = 0; $in_eq_fueraruta = 0;  $in_eq_alertas = 0;  $in_eq_detenidos = 0;}

			//Se guardan los valores
			$eq_alertas     = $eq_alertas + $in_eq_alertas;
			$eq_fueralinea  = $eq_fueralinea + $in_eq_fueralinea;
			$eq_fueraruta   = $eq_fueraruta + $in_eq_fueraruta;
			$eq_detenidos   = $eq_detenidos + $in_eq_detenidos;
			$eq_gps_fuera   = $eq_gps_fuera + $in_eq_gps_fuera;
			$eq_ok          = $eq_ok + $in_eq_ok;

		}



		/*******************************************************************************/
		//Imprimo
		$GPS = '<h3 class="supertittle text-primary">'.$titulo.'</h3>';
		$GPS.= '<div class="clearfix"></div>';

		if(isset($map_visibility)&&$map_visibility!=''&&$map_visibility==1){
			$GPS .= '
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<div class="box box-blue xbox box-solid">
						<div class="box-header with-border">
							<h3 class="box-title">'.$titulo.'</h3>
							<div class="box-tools pull-right">';
							if(isset($seguimiento)&&$seguimiento!=''&&$seguimiento==1){
								$GPS .= '<a target="new" href="telemetria_gestion_flota.php" class="btn btn-xs btn-primary btn-line">Ver Mas</a>';
							}elseif(isset($seguimiento)&&$seguimiento!=''&&$seguimiento==2){
								$GPS .= '';
							}
							$GPS .= '</div>
						</div>
						<div class="box-body">
							<div class="">
								<script async src="https://maps.googleapis.com/maps/api/js?key='.$google.'&callback=initMap"></script>
								<div id="map_canvas" style="width: 100%; height: 550px;"></div>
								<div id="consulta"></div>

								<script>
									let map;
									var marker;

									async function initMap() {
										const { Map } = await google.maps.importLibrary("maps");

										var myLatlng = new google.maps.LatLng(-33.477271996598965, -70.65170304882815);

										var myOptions = {
											zoom: 12,
											zoomControl: false,
											scaleControl: false,
											scrollwheel: false,
											disableDoubleClickZoom: true,
											disableDefaultUI: true,
											center: myLatlng,
											mapTypeId: google.maps.MapTypeId.ROADMAP
										};

										map = new Map(document.getElementById("map_canvas"), myOptions);';

										if(isset($seguimiento)&&$seguimiento!=''&&$seguimiento==1){
											$GPS .= '
											//Ubicación de los distintos dispositivos
											transMarker(10000);';
										}elseif(isset($seguimiento)&&$seguimiento!=''&&$seguimiento==2){
											$GPS .= 'ubiquity();';
										}

										$GPS .= '

									}

									/* ************************************************************************** */
									function ubiquity() {

										var locations = [ ';

										$ordenx=1;
										foreach ( $arrEquipo as $pos ) {
											$GPS .= "['".$ordenx."', ".$pos['GeoLatitud'].", ".$pos['GeoLongitud']."], ";
											$ordenx++;
										}
										$GPS .= '];

										//Se ocultan y eliminan los iconos
										hideMarkers(\'transMarkers\');
										deleteMarkers(\'transMarkers\');

										for(var i in locations){
											transporte = addMarker(icon_transMarker);
											transporte.show().setPosition(new google.maps.LatLng(locations[i][1], locations[i][2]));
										}
									}
									/* ************************************************************************** */
									var icon_transMarker = {
											name: \'transMarkers\',
											visible: true
									}

									var markers={}

									function transMarker(time) {
										setInterval(function(){myTimer2()},time);
									}

									var mapax = 0;
									function myTimer2() {

										switch(mapax) {
											//Ejecutar formulario con el recorrido y la ruta
											case 1:
												$(\'#consulta\').load(\'principal_update_map.php?idSistema='.$idSistema.'\');
											break;
											//se dibujan los iconos
											case 2:
												//Se ocultan y eliminan los iconos
												hideMarkers(\'transMarkers\');
												deleteMarkers(\'transMarkers\');

												for(var i in locations){
													transporte = addMarker(icon_transMarker);
													transporte.show().setPosition(new google.maps.LatLng(locations[i][1], locations[i][2]));
												}

											break;
										}

										mapax++;
										if(mapax==3){mapax=1}
									}

									/* ************************************************************************** */
									var foreachMarkerByName=function(name,callback){

										var toRet=false

										if (typeof name != \'object\') {
											name=[name]
										}

										for (var a in name){
											var tmp=name[a];

											if (tmp==undefined||markers[tmp]==undefined) {
												continue;
											}

											toRet=true;

											for (var a in markers[tmp]) callback(markers[tmp][a]);
										}

										return toRet;
									}
									/* ************************************************************************** */
									hideMarkers=function(name){
										foreachMarkerByName(name,function(el){
											el.hide();
										});
										return this;
									}
									/* ************************************************************************** */
									deleteMarkers=function(name){
										foreachMarkerByName(name,function(el){
											el.delete();
										});
										delete markers[name];
										return this;
									}
									/* ************************************************************************** */
									addMarker=function(opt){

										if (opt == undefined) return false;

										opt.map=map;

										var tmp=new google.maps.Marker(opt);

										if (opt.pos) tmp.setPosition(opt.pos);
										//tmp.setVisible(opt.visible||true);

										if (opt.name) {
											if (markers[opt.name] == undefined) markers[opt.name]=[];

											markers[opt.name].push(tmp);

											tmp.markerFamilyName=opt.name;
											tmp.markerFamilyPos=markers[opt.name].length-1;
										}

										if (opt.events) {
											for (var a in opt.events) {
												google.maps.event.addListener(tmp,a,opt.events[a].bind(tmp));
											}
										}

										// Borrar, esconder y mostrar
										tmp.delete=function(){
											this.deleteInfo();
											this.setMap(null);

											return this;
										}.bind(tmp);

										tmp.hide=function(){
											this.setVisible(false);

											return this;
										}.bind(tmp);

										tmp.show=function(){
											google.maps.event.trigger(this, \'show\');
											this.setVisible(true);

											return this;
										}.bind(tmp)

										tmp.isVisible=function(){
											return this.visible
										}.bind(tmp)

										// Agrega mensajes a los marcadores
										tmp.info=function(message,click,opt){

											opt=opt||{}

											var custom=click===true;

											click=typeof click==\'function\'?click:opt.click||function(){};

											var opt=$.extend({content: message},opt);

											this.infoBox=custom;

											if (custom) {
												this.infoWindow = new InfoBox(opt);
											}else {
												this.infoWindow = new google.maps.InfoWindow(opt);
											}


											this.infoWindowListener=google.maps.event.addListener(this, \'click\', function () {

												if (activeInfoWindow) {
													activeInfoWindow.close();
												}
												this.infoWindow.open(map, this);
												activeInfoWindow=this.infoWindow;
												click.bind(this)();

												return this;

											}.bind(this));
										}.bind(tmp);

										tmp.deleteInfo=function(){
											if (this.infoWindow) {
												this.infoWindow.setMap(null);
												delete this.infoWindow;

												google.maps.event.removeListener(this.infoWindowListener);
												delete this.infoWindowListener;
											}
											return this;

										}.bind(tmp);

										tmp.click=function(){
											google.maps.event.trigger(this, \'click\');
										}.bind(tmp);

										return tmp;

									}
								</script>

							</div>

						</div>
					</div>
				</div>
			</div>';
		}

		if(isset($seguimiento)&&$seguimiento!=''&&$seguimiento==1){

			$GPS .= '<div class="row">';
				$GPS .= widget_Ficha_2('box-yellow', 'fa-truck faa-float animated', $eq_alertas, 4, $nombreEquipo.' con alertas', 'Equipos', 'principal_gps_view.php?seguimiento='.simpleEncode($seguimiento, fecha_actual()).'&idSistema='.simpleEncode($idSistema, fecha_actual()).'&dataType='.simpleEncode( 1, fecha_actual()), 'Ver Mas', 'btn-warning', 1, 2);
				$GPS .= widget_Ficha_2('box-red', 'fa-truck faa-float animated', $eq_fueralinea, 4, $nombreEquipo.' fuera de linea', 'Equipos', 'principal_gps_view.php?seguimiento='.simpleEncode($seguimiento, fecha_actual()).'&idSistema='.simpleEncode($idSistema, fecha_actual()).'&dataType='.simpleEncode( 2, fecha_actual()), 'Ver Mas', 'btn-danger', 1, 2);
				$GPS .= widget_Ficha_2('box-green', 'fa-truck faa-float animated', $eq_fueraruta, 4, $nombreEquipo.' fuera de ruta', 'Equipos', 'principal_gps_view.php?seguimiento='.simpleEncode($seguimiento, fecha_actual()).'&idSistema='.simpleEncode($idSistema, fecha_actual()).'&dataType='.simpleEncode( 3, fecha_actual()), 'Ver Mas', 'btn-success', 1, 2);
				$GPS .= widget_Ficha_2('box-purple', 'fa-truck faa-float animated', $eq_detenidos, 4, $nombreEquipo.' detenidos', 'Equipos', 'principal_gps_view.php?seguimiento='.simpleEncode($seguimiento, fecha_actual()).'&idSistema='.simpleEncode($idSistema, fecha_actual()).'&dataType='.simpleEncode( 5, fecha_actual()), 'Ver Mas', 'btn-primary', 1, 2);
				$GPS .= widget_Ficha_2('box-yellow', 'fa-truck faa-float animated', $eq_gps_fuera, 4, $nombreEquipo.' con GPS en 0', 'Equipos', 'principal_gps_view.php?seguimiento='.simpleEncode($seguimiento, fecha_actual()).'&idSistema='.simpleEncode($idSistema, fecha_actual()).'&dataType='.simpleEncode( 5, fecha_actual()), 'Ver Mas', 'btn-warning', 1, 2);
				$GPS .= widget_Ficha_2('box-blue', 'fa-truck faa-float animated', $eq_ok, 4, $nombreEquipo.' OK', 'Equipos', 'principal_gps_view.php?seguimiento='.simpleEncode($seguimiento, fecha_actual()).'&idSistema='.simpleEncode($idSistema, fecha_actual()).'&dataType='.simpleEncode( 4, fecha_actual()), 'Ver Mas', 'btn-primary', 1, 2);
			$GPS .= '</div>';

		}elseif(isset($seguimiento)&&$seguimiento!=''&&$seguimiento==2){

			$GPS .= '<div class="row">';
				$GPS .= widget_Ficha_2('box-yellow', 'fa-industry', $eq_alertas, 4, $nombreEquipo.' con alertas', 'Equipos', 'principal_gps_view.php?seguimiento='.simpleEncode($seguimiento, fecha_actual()).'&idSistema='.simpleEncode($idSistema, fecha_actual()).'&dataType='.simpleEncode( 1, fecha_actual()), 'Ver Mas', 'btn-warning', 1, 2);
				$GPS .= widget_Ficha_2('box-red', 'fa-industry', $eq_fueralinea, 4, $nombreEquipo.' fuera de linea', 'Equipos', 'principal_gps_view.php?seguimiento='.simpleEncode($seguimiento, fecha_actual()).'&idSistema='.simpleEncode($idSistema, fecha_actual()).'&dataType='.simpleEncode( 2, fecha_actual()), 'Ver Mas', 'btn-danger', 1, 2);
				$GPS .= widget_Ficha_2('box-blue', 'fa-industry', $eq_ok, 4, $nombreEquipo.' OK', 'Equipos', 'principal_gps_view.php?seguimiento='.simpleEncode($seguimiento, fecha_actual()).'&idSistema='.simpleEncode($idSistema, fecha_actual()).'&dataType='.simpleEncode( 4, fecha_actual()), 'Ver Mas', 'btn-primary', 1, 2);
			$GPS .= '</div>';
		}
	}

	return $GPS;
}
/*******************************************************************************************************************/
//Muestra los equipos
function widget_Equipos($nombreEquipo, $seguimiento, $equipo, $enlace, $idSistema, $idTipoUsuario, $idUsuario, $dbConn){

	/*********************************************************************/
	//variables
	$HoraSistema    = hora_actual();
	$FechaSistema   = fecha_actual();
	$eq_alertas     = 0;
	$eq_fueralinea  = 0;
	$eq_ok          = 0;

	/*********************************************************************/
	//Variable
	$SIS_where = "telemetria_listado.idEstado = 1 ";//solo equipos activos
	//solo los equipos que tengan el seguimiento activado
	if(isset($seguimiento)&&$seguimiento!=''&&$seguimiento!=0){
		$SIS_where .= " AND telemetria_listado.id_Geo = ".$seguimiento;
	}
	//Filtro el sistema al cual pertenece
	if(isset($idSistema)&&$idSistema!=''&&$idSistema!=0){
		$SIS_where .= " AND telemetria_listado.idSistema = ".$idSistema;
	}
	//El equipo a ver
	if (isset($equipo)&&$equipo!=''&&$equipo!=0){
		$SIS_where .= " AND telemetria_listado.idTelemetria=".$equipo;
	}
	//Verifico el tipo de usuario que esta ingresando y el id
	$SIS_join = "";
	if(isset($idTipoUsuario, $idUsuario)&&$idTipoUsuario!=1&&$idUsuario!=0){
		$SIS_join  .= " INNER JOIN usuarios_equipos_telemetria ON usuarios_equipos_telemetria.idTelemetria = telemetria_listado.idTelemetria ";
		$SIS_where .= " AND usuarios_equipos_telemetria.idUsuario = ".$idUsuario;
	}

	$SIS_query = '
	telemetria_listado.LastUpdateFecha,
	telemetria_listado.LastUpdateHora,
	telemetria_listado.cantSensores,
	telemetria_listado.GeoLatitud,
	telemetria_listado.GeoLongitud,
	telemetria_listado.NDetenciones,
	telemetria_listado.TiempoFueraLinea,
	telemetria_listado.NErrores';
	$SIS_order = 'telemetria_listado.Nombre ASC';
	$arrEquipo = array();
	$arrEquipo = db_select_array (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrEquipo');

	/*********************************************************************/
	//recorro
	foreach ($arrEquipo as $data) {

		/**********************************************/
		//Se resetean
		$in_eq_alertas     = 0;
		$in_eq_fueralinea  = 0;
		$in_eq_ok          = 1;

		/**********************************************/
		//Fuera de linea
		$diaInicio   = $data['LastUpdateFecha'];
		$diaTermino  = $FechaSistema;
		$tiempo1     = $data['LastUpdateHora'];
		$tiempo2     = $HoraSistema;
		$Tiempo      = horas_transcurridas($diaInicio, $diaTermino, $tiempo1, $tiempo2);

		//Comparaciones de tiempo
		$Time_Tiempo     = horas2segundos($Tiempo);
		$Time_Tiempo_FL  = horas2segundos($data['TiempoFueraLinea']);
		$Time_Tiempo_Max = horas2segundos('48:00:00');
		$Time_Fake_Ini   = horas2segundos('23:59:50');
		$Time_Fake_Fin   = horas2segundos('24:00:00');
		//comparacion
		if(($Time_Tiempo<$Time_Fake_Ini OR $Time_Tiempo>$Time_Fake_Fin)&&(($Time_Tiempo>$Time_Tiempo_FL&&$Time_Tiempo_FL!=0) OR ($Time_Tiempo>$Time_Tiempo_Max&&$Time_Tiempo_FL==0))){
				$in_eq_fueralinea++;
		}

		/**********************************************/
		//NErrores
		if(isset($data['NErrores'])&&$data['NErrores']>0){ $in_eq_alertas++; }

		/*******************************************************/
		//rearmo
		if($in_eq_alertas>0){    $in_eq_ok = 0;$in_eq_alertas = 1;    }
		if($in_eq_fueralinea>0){ $in_eq_ok = 0;$in_eq_fueralinea = 1; $in_eq_alertas = 0;}

		//Se guardan los valores
		$eq_alertas     = $eq_alertas + $in_eq_alertas;
		$eq_fueralinea  = $eq_fueralinea + $in_eq_fueralinea;
		$eq_ok          = $eq_ok + $in_eq_ok;

	}


	/*********************************************************************/
	//imprimo
	$GPS = '
	<div class="row">
		<h3 class="supertittle text-primary">'.$nombreEquipo.'</h3>';

		$GPS .= widget_Ficha_2('box-yellow', 'fa-industry', $eq_alertas, 4, $nombreEquipo.' con alertas', 'Equipos', 'principal_gps_view.php?seguimiento='.simpleEncode($seguimiento, fecha_actual()).'&idSistema='.simpleEncode($idSistema, fecha_actual()).'&dataType='.simpleEncode( 1, fecha_actual()), 'Ver Mas', 'btn-warning', 1, 2);
		$GPS .= widget_Ficha_2('box-red', 'fa-industry', $eq_fueralinea, 4, $nombreEquipo.' fuera de linea', 'Equipos', 'principal_gps_view.php?seguimiento='.simpleEncode($seguimiento, fecha_actual()).'&idSistema='.simpleEncode($idSistema, fecha_actual()).'&dataType='.simpleEncode( 2, fecha_actual()), 'Ver Mas', 'btn-danger', 1, 2);
		$GPS .= widget_Ficha_2('box-blue', 'fa-industry', $eq_ok, 4, $nombreEquipo.' OK', 'Equipos', 'principal_gps_view.php?seguimiento='.simpleEncode($seguimiento, fecha_actual()).'&idSistema='.simpleEncode($idSistema, fecha_actual()).'&dataType='.simpleEncode( 4, fecha_actual()), 'Ver Mas', 'btn-primary', 1, 2);

	$GPS .= '</div>';

	return $GPS;
}
/*******************************************************************************************************************/
//Muestra una tabla con los equipos gps
function widget_Resumen_GPS_equipos($titulo, $seguimiento, $idSistema, $idTipoUsuario, $idUsuario, $dbConn){

	/********************************************************************/
	//Variable
	$SIS_where = "telemetria_listado.idEstado = 1 ";//solo equipos activos
	//solo los equipos que tengan el seguimiento activado
	if(isset($seguimiento)&&$seguimiento!=''&&$seguimiento!=0){
		$SIS_where .= " AND telemetria_listado.id_Geo = ".$seguimiento;
	}
	//Filtro el sistema al cual pertenece
	if(isset($idSistema)&&$idSistema!=''&&$idSistema!=0){
		$SIS_where .= " AND telemetria_listado.idSistema = ".$idSistema;
	}
	//Verifico el tipo de usuario que esta ingresando y el id
	$SIS_join = '';
	if(isset($idTipoUsuario, $idUsuario)&&$idTipoUsuario!=1&&$idUsuario!=0){
		$SIS_join  .= ' INNER JOIN usuarios_equipos_telemetria ON usuarios_equipos_telemetria.idTelemetria = telemetria_listado.idTelemetria ';
		$SIS_where .= ' AND usuarios_equipos_telemetria.idUsuario = '.$idUsuario;
	}

	//numero sensores equipo
	$N_Maximo_Sensores = 60;
	$subquery = '';
	for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
		$subquery .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$i;
		$subquery .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i;
		$subquery .= ',telemetria_listado_sensores_med_actual.SensoresMedActual_'.$i;
		$subquery .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$i;
	}
	$SIS_query = '
	telemetria_listado.Nombre,
	telemetria_listado.cantSensores,
	telemetria_listado.LastUpdateFecha,
	telemetria_listado.LastUpdateHora,
	telemetria_listado.id_Sensores,
	telemetria_listado.TiempoFueraLinea,
	telemetria_listado.NErrores'.$subquery;
	$SIS_join .= '
	LEFT JOIN `telemetria_listado_sensores_nombre`          ON telemetria_listado_sensores_nombre.idTelemetria         = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_unimed`          ON telemetria_listado_sensores_unimed.idTelemetria         = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_med_actual`      ON telemetria_listado_sensores_med_actual.idTelemetria     = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_activo`          ON telemetria_listado_sensores_activo.idTelemetria         = telemetria_listado.idTelemetria';
	$SIS_order = 'telemetria_listado.Nombre ASC';
	$arrEquipo = array();
	$arrEquipo = db_select_array (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrEquipo');

	//Se traen todas las unidades de medida
	$arrUnimed = array();
	$arrUnimed = db_select_array (false, 'idUniMed,Nombre', 'telemetria_listado_unidad_medida', '', '', 'idUniMed ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrUnimed');

	$arrFinalUnimed = array();
	foreach ($arrUnimed as $sen) {
		$arrFinalUnimed[$sen['idUniMed']] = $sen['Nombre'];
	}

	$Subicon = array();
	$Subicon[1] = 'fa fa-truck';
	$Subicon[2] = 'fa fa-industry';


	/********************************************************************/
	//Imprimo
	$GPS = '<div class="row">';

		$GPS .= '
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="box">
				<header>
					<div class="icons"><i class="'.$Subicon[$seguimiento].'"></i></div><h5>'.$titulo.'</h5>
				</header>
				<div class="table-responsive">';

						$GPS .= '

						<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
							<thead>
								<tr role="row">
									<th colspan="2">ZONA</th>
								</tr>
							</thead>

							<tbody role="alert" aria-live="polite" aria-relevant="all">
								<tr class="odd">
									<td>';

										foreach($arrEquipo as $equip) {

											//alertas
											$xx = 0;
											$xy = 0;
											$xz = 0;
											$xw = 0;
											//si hay errores
											if(isset($equip['NErrores'])&&$equip['NErrores']>0){
												$xw = 1;
											}

											//Fuera de linea
											$diaInicio   = $equip['LastUpdateFecha'];
											$diaTermino  = fecha_actual();
											$tiempo1     = $equip['LastUpdateHora'];
											$tiempo2     = hora_actual();
											$Tiempo      = horas_transcurridas($diaInicio, $diaTermino, $tiempo1, $tiempo2);

											//Comparaciones de tiempo
											$Time_Tiempo     = horas2segundos($Tiempo);
											$Time_Tiempo_FL  = horas2segundos($equip['TiempoFueraLinea']);
											$Time_Tiempo_Max = horas2segundos('48:00:00');
											$Time_Fake_Ini   = horas2segundos('23:59:50');
											$Time_Fake_Fin   = horas2segundos('24:00:00');
											//comparacion
											if(($Time_Tiempo<$Time_Fake_Ini OR $Time_Tiempo>$Time_Fake_Fin)&&(($Time_Tiempo>$Time_Tiempo_FL&&$Time_Tiempo_FL!=0) OR ($Time_Tiempo>$Time_Tiempo_Max&&$Time_Tiempo_FL==0))){
												$xz = 1;
											}

											//Condiciono el color
											//if($xz!=0){$danger = 'box-red';}else{$danger = 'box-blue';}
											if($xz!=0){
												$danger = 'box-red';
											}elseif($xw!=0){
												$danger = 'box-yellow';
											}else{
												$danger = 'box-blue';
											}

											$GPS .= '
												<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
													<div class="box '.$danger.' box-solid">
														<div class="box-header with-border">
															<h3 class="box-title">'.$equip['Nombre'].'</h3>
														</div>
														<div class="box-body">
															<div class="value">';
																$GPS .= 'El '.fecha_estandar($equip['LastUpdateFecha']).' a las '.$equip['LastUpdateHora'].'<br/>';

																//Solo se muestran los datos de los sensores en caso de que estos esten activos
																if(isset($equip['id_Sensores'])&&$equip['id_Sensores']==1){
																	for ($i = 1; $i <= $equip['cantSensores']; $i++) {
																		//solo sensores activos
																		if(isset($equip['SensoresActivo_'.$i])&&$equip['SensoresActivo_'.$i]==1){
																			//Unidad de medida
																			if(isset($arrFinalUnimed[$equip['SensoresUniMed_'.$i]])){
																				$unimed = ' '.$arrFinalUnimed[$equip['SensoresUniMed_'.$i]];
																			}else{
																				$unimed = '';
																			}
																			//Nombre del sensor
																			if(isset($equip['SensoresNombre_'.$i])){
																				$GPS .= '<strong>'.$equip['SensoresNombre_'.$i].' :</strong>';
																			}
																			if(isset($equip['SensoresMedActual_'.$i])&&$equip['SensoresMedActual_'.$i]<99900){$xdata=Cantidades_decimales_justos($equip['SensoresMedActual_'.$i]).$unimed;}else{$xdata='Sin Datos';}
																			$GPS .= $xdata.'<br/>';
																		}
																	}
																}

															$GPS .= '
															</div>
														</div>
													</div>
												</div>';
										}
									$GPS .= '
									</td>
								</tr>
							</tbody>
						</table>
				</div>
			</div>
		</div>

	</div>';

	return $GPS;
}
/*******************************************************************************************************************/
//Muestra una tabla con los equipos
function widget_Resumen_equipo($titulo_cuadro, $seguimiento, $equipo, $enlace, $idSistema, $idTipoUsuario, $idUsuario, $dbConn){

	//Variables
	$HoraSistema    = hora_actual();
	$FechaSistema   = fecha_actual();

	//Variable
	$SIS_where = "telemetria_listado.idEstado = 1 ";//solo equipos activos
	//solo los equipos que tengan el seguimiento activado
	if(isset($seguimiento)&&$seguimiento!=''&&$seguimiento!=0){
		$SIS_where .= " AND telemetria_listado.id_Geo = ".$seguimiento;
	}
	//Filtro el sistema al cual pertenece
	if(isset($idSistema)&&$idSistema!=''&&$idSistema!=0){
		$SIS_where .= " AND telemetria_listado.idSistema = ".$idSistema;
	}
	if (isset($equipo)&&$equipo!=''&&$equipo!=0){
		$SIS_where .= " AND telemetria_listado.idTelemetria=".$equipo;
	}
	//Verifico el tipo de usuario que esta ingresando y el id
	$SIS_join  = 'LEFT JOIN `core_sistemas` ON core_sistemas.idSistema = telemetria_listado.idSistema';
	if(isset($idTipoUsuario, $idUsuario)&&$idTipoUsuario!=1&&$idUsuario!=0){
		$SIS_join  .= ' INNER JOIN usuarios_equipos_telemetria ON usuarios_equipos_telemetria.idTelemetria = telemetria_listado.idTelemetria ';
		$SIS_where .= ' AND usuarios_equipos_telemetria.idUsuario = '.$idUsuario;
	}

	//numero sensores equipo
	$N_Maximo_Sensores = 60;
	$subquery = '';
	for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
		$subquery .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$i;
		$subquery .= ',telemetria_listado_sensores_med_actual.SensoresMedActual_'.$i;
		$subquery .= ',telemetria_listado_sensores_grupo.SensoresGrupo_'.$i;
		$subquery .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i;
		$subquery .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$i;
	}

	/*****************************/
	//Consulto
	$SIS_query = '
	telemetria_listado.idTelemetria,
	telemetria_listado.Nombre,
	telemetria_listado.Direccion_img,
	telemetria_listado.LastUpdateHora,
	telemetria_listado.LastUpdateFecha,
	telemetria_listado.cantSensores,
	telemetria_listado.TiempoFueraLinea,
	telemetria_listado.NErrores,
	core_sistemas.idOpcionesGen_3'.$subquery;
	$SIS_join .= '
	LEFT JOIN `telemetria_listado_sensores_nombre`          ON telemetria_listado_sensores_nombre.idTelemetria         = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_med_actual`      ON telemetria_listado_sensores_med_actual.idTelemetria     = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_grupo`           ON telemetria_listado_sensores_grupo.idTelemetria          = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_unimed`          ON telemetria_listado_sensores_unimed.idTelemetria         = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_activo`          ON telemetria_listado_sensores_activo.idTelemetria         = telemetria_listado.idTelemetria';
	$SIS_order = 'telemetria_listado.Nombre ASC';
	$arrEquipo = array();
	$arrEquipo = db_select_array (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrEquipo');

	$arrUnimed = array();
	$arrUnimed = db_select_array (false, 'idUniMed,Nombre', 'telemetria_listado_unidad_medida', '', '', 'idUniMed ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrUnimed');

	$arrGrupos = array();
	$arrGrupos = db_select_array (false, 'idGrupo,Nombre,nColumnas', 'telemetria_listado_grupos', '', '', 'idGrupo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrGrupos');

	$arrFinalUnimed = array();
	$arrFinalGrupos = array();
	foreach ($arrUnimed as $sen) { $arrFinalUnimed[$sen['idUniMed']] = $sen['Nombre'];}
	foreach ($arrGrupos as $sen) { $arrFinalGrupos[$sen['idGrupo']]['Nombre'] = $sen['Nombre']; $arrFinalGrupos[$sen['idGrupo']]['nColumnas'] = $sen['nColumnas']; $arrFinalGrupos[$sen['idGrupo']]['idGrupo'] = $sen['idGrupo'];}


	$GPS = '
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="box">
				<header>
					<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
					<h5>'.$titulo_cuadro.'</h5>
					<div class="toolbar"></div>
					<ul class="nav nav-tabs pull-right">';
						$xcounter_tel = 1;
						foreach($arrEquipo as $equip) {
							if($xcounter_tel==1){$xactive_tel = 'active';}else{$xactive_tel = '';}
							if($xcounter_tel==4){$GPS .= '<li class="dropdown"><a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a><ul class="dropdown-menu" role="menu">';} 
							$GPS .= '<li class="'.$xactive_tel.'"><a href="#tel_id_'.$xcounter_tel.'" data-toggle="tab">'.$equip['Nombre'].'</a></li>';
							$xcounter_tel++;
						}
						if($xcounter_tel>3){$GPS .= '</ul></li>';}
					$GPS .= '
					</ul>
				</header>


				<div class="tab-content">';
					$xcounter_tel_2 = 1;
					foreach($arrEquipo as $equip) {

						if($xcounter_tel_2==1){$xactive_tel = 'active in';}else{$xactive_tel = '';}

						$GPS .= '
						<div class="tab-pane fade '.$xactive_tel.'" id="tel_id_'.$xcounter_tel_2.'">
							<div class="wmd-panel">
								<div class="table-responsive">

									<div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
										<div class="row">
											<div id="consulta">
												<table id="dataTable" class="table table-bordered table-condensed table-hover dataTable">
													<thead>
														<tr role="row">
															<th>Nombre</th>
															<th>Estado</th>
															<th width="160">Acciones</th>
														</tr>
													</thead>
													<tbody role="alert" aria-live="polite" aria-relevant="all">
														<tr class="odd">
															<td colspan="3">Medicion el '.fecha_estandar($equip['LastUpdateFecha']).' a las '.$equip['LastUpdateHora'].' hrs</td>	
														</tr>';

														/**********************************************/
														//Se resetean
														$in_eq_alertas     = 0;
														$in_eq_fueralinea  = 0;

														/**********************************************/
														//Fuera de linea
														$diaInicio   = $equip['LastUpdateFecha'];
														$diaTermino  = $FechaSistema;
														$tiempo1     = $equip['LastUpdateHora'];
														$tiempo2     = $HoraSistema;
														$Tiempo      = horas_transcurridas($diaInicio, $diaTermino, $tiempo1, $tiempo2);

														//Comparaciones de tiempo
														$Time_Tiempo     = horas2segundos($Tiempo);
														$Time_Tiempo_FL  = horas2segundos($equip['TiempoFueraLinea']);
														$Time_Tiempo_Max = horas2segundos('48:00:00');
														$Time_Fake_Ini   = horas2segundos('23:59:50');
														$Time_Fake_Fin   = horas2segundos('24:00:00');
														//comparacion
														if(($Time_Tiempo<$Time_Fake_Ini OR $Time_Tiempo>$Time_Fake_Fin)&&(($Time_Tiempo>$Time_Tiempo_FL&&$Time_Tiempo_FL!=0) OR ($Time_Tiempo>$Time_Tiempo_Max&&$Time_Tiempo_FL==0))){
															$in_eq_fueralinea++;
														}

														/**********************************************/
														//NErrores
														if(isset($equip['NErrores'])&&$equip['NErrores']>0){ $in_eq_alertas++; }

														/*******************************************************/
														//rearmo
														if($in_eq_alertas>0){
															$danger = 'warning';
															$eq_ok  = '<a href="#" title="Con Alertas" class="btn btn-warning btn-sm tooltip"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></a>';
														}elseif($in_eq_fueralinea>0){
															$danger = 'danger';
															$eq_ok  = '<a href="#" title="Fuera de Linea" class="btn btn-danger btn-sm tooltip"><i class="fa fa-chain-broken" aria-hidden="true"></i></a>';
														}else{
															$danger = '';
															$eq_ok  = '<a href="#" title="Sin Problemas" class="btn btn-success btn-sm tooltip"><i class="fa fa-check" aria-hidden="true"></i></a>';
														}

														$GPS .= '
														<tr class="odd '.$danger.'">
															<td>'.$equip['Nombre'].'</td>
															<td><div class="btn-group" >'.$eq_ok.'</div></td>
															<td>
																<div class="btn-group" style="width: 70px;" >
																	<a href="telemetria_gestion_equipos_view_equipo.php?view='.simpleEncode($equip['idTelemetria'], fecha_actual()).'" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
																	<a href="telemetria_gestion_equipos_view_equipo_uso.php?view='.simpleEncode($equip['idTelemetria'], fecha_actual()).'" title="Ver Uso" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-wrench" aria-hidden="true"></i></a>
																</div>
															</td>
														</tr>
														<tr class="odd" style="background-color: #CCCCCC;">
															<td>Grupo</td>
															<td colspan="2">Mediciones</td>
														</tr>';

														$arrGruposTitulo = array();
														$n_sensores = 0;
														$sensor = 0;
														for ($i = 1; $i <= $equip['cantSensores']; $i++) {
															//solo sensores activos
															if(isset($equip['SensoresActivo_'.$i])&&$equip['SensoresActivo_'.$i]==1){
																//Unidad medida
																if(isset($arrFinalUnimed[$equip['SensoresUniMed_'.$i]])){
																	$unimed = ' '.$arrFinalUnimed[$equip['SensoresUniMed_'.$i]];
																}else{
																	$unimed = '';
																}
																//Titulo del cuadro
																if(isset($arrFinalGrupos[$equip['SensoresGrupo_'.$i]]['Nombre'])){
																	$Titulo    = $arrFinalGrupos[$equip['SensoresGrupo_'.$i]]['Nombre'];
																}else{
																	$Titulo    = '';
																}
																if(isset($arrFinalGrupos[$equip['SensoresGrupo_'.$i]]['nColumnas'])){
																	$nColumnas = $arrFinalGrupos[$equip['SensoresGrupo_'.$i]]['nColumnas'];
																}else{
																	$nColumnas = '';
																}
																//Verifico que no sea el mismo sensor
																if(isset($equip['SensoresMedActual_'.$i])&&$equip['SensoresMedActual_'.$i]<99900){$xdata=Cantidades_decimales_justos($equip['SensoresMedActual_'.$i]).$unimed;}else{$xdata='Sin Datos';}
																//Guardo el valor correspondiente
																$arrGruposTitulo[$Titulo][$i]['Descripcion'] = $equip['SensoresNombre_'.$i].' : '.$xdata;
																$arrGruposTitulo[$Titulo][$i]['valor']       = $equip['SensoresMedActual_'.$i];
																$arrGruposTitulo[$Titulo][$i]['unimed']      = $unimed;
																$arrGruposTitulo[$Titulo][$i]['nColumnas']   = $nColumnas;
															}
														}

														//Ordenamiento por titulo de grupo
														$names = array();
														foreach ($arrGruposTitulo as $titulo=>$items) {
															$names[] = $titulo;
														}
														array_multisort($names, SORT_ASC, $arrGruposTitulo);

														//se recorre el arreglo
														foreach($arrGruposTitulo as $titulo=>$items) {
															$ndatacol    = 0;
															$columna_a   = '';
															$columna_b   = '';
															$total_col1  = 0;
															$total_col2  = 0;
															$ntotal_col1 = 0;
															$ntotal_col2 = 0;
															$unimed_col1 = '';
															$unimed_col2 = '';

															$GPS .= '
															<tr class="odd">
																<td>'.$titulo.'</td>';
																$y = 1;
																foreach($items as $datos) {
																	//si el grupo solo tiene una columna
																	if(isset($datos['nColumnas'])&&$datos['nColumnas']==1){
																		//Especifico el numero de columnas
																		$ndatacol = 1;
																		//Se guardan los datos
																		$columna_a .= $datos['Descripcion'].'<br/>';
																		//Verifico que el dato no sea 99900
																		if(isset($datos['valor'])&&$datos['valor']<99900){
																			$total_col1 = $total_col1 + $datos['valor'];
																			$ntotal_col1++;
																		}
																		$unimed_col1 = $datos['unimed'];

																	//si el grupo tiene 2 columnas
																	}elseif(isset($datos['nColumnas'])&&$datos['nColumnas']==2){
																		//Especifico el numero de columnas
																		$ndatacol = 2;
																		//Se guardan los datos
																		if($y==1){
																			$columna_a .= $datos['Descripcion'].'<br/>';
																			//Verifico que el dato no sea 99900
																			if(isset($datos['valor'])&&$datos['valor']<99900){
																				$total_col1 = $total_col1 + $datos['valor'];
																				$ntotal_col1++;
																			}
																			$unimed_col1 = $datos['unimed'];
																			$y=2;
																		}else{
																			$columna_b .= $datos['Descripcion'].'<br/>';
																			//Verifico que el dato no sea 99900
																			if(isset($datos['valor'])&&$datos['valor']<99900){
																				$total_col2 = $total_col2 + $datos['valor'];
																				$ntotal_col2++;
																			}
																			$unimed_col2 = $datos['unimed'];
																			$y=1;
																		}
																	}

																}
																/***********************/
																if($ndatacol==1){
																	$GPS .= '
																	<td colspan="2">'.$columna_a.'</td>';
																}elseif($ndatacol==2){
																	$GPS .= '
																	<td>'.$columna_a.'</td>
																	<td>'.$columna_b.'</td>';
																}

															$GPS .= '</tr>';

															/*************************************************/
															if($equip['idOpcionesGen_3']==1){
																$GPS .= '
																<tr class="odd">
																	<td>Promedio</td>';
																	/***********************/
																	if($ndatacol==1){
																		if($ntotal_col1!=0){$GPS .= '<td colspan="2">'.Cantidades(($total_col1/$ntotal_col1), 1).$unimed_col1.'</td>';}else{$GPS .= '<td colspan="2">0'.$unimed_col1.'</td>';}
																	}elseif($ndatacol==2){
																		if($ntotal_col1!=0){$GPS .= '<td>'.Cantidades(($total_col1/$ntotal_col1), 1).$unimed_col1.'</td>';}else{$GPS .= '<td>0'.$unimed_col1.'</td>';}
																		if($ntotal_col2!=0){$GPS .= '<td>'.Cantidades(($total_col2/$ntotal_col2), 1).$unimed_col2.'</td>';}else{$GPS .= '<td>0'.$unimed_col2.'</td>';}
																	}

																$GPS .= '
																</tr>
																<tr class="odd">
																	<td colspan="3"></td>
																</tr>';
															}
														}

														$GPS .= '
													</tbody>
												</table>
											</div>
										</div>
									</div>

									<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
										<div class="row">';
										if(isset($enlace)&&$enlace!=''&&$enlace!=0){
											if ($equip['Direccion_img']=='') {
												$GPS .= '<img style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="Imagen Referencia" src="'.DB_SITE_REPO.'/Legacy/gestion_modular/img/maquina.jpg">';
											}else{
												$GPS .= '<img style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="Imagen Referencia" src="'.$enlace.$equip['Direccion_img'].'">';
											}
										}else{
											if ($equip['Direccion_img']=='') {
												$GPS .= '<img style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="Imagen Referencia" src="'.DB_SITE_REPO.'/Legacy/gestion_modular/img/maquina.jpg">';
											}else{
												$GPS .= '<img style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="Imagen Referencia" src="upload/'.$equip['Direccion_img'].'">';
											}
										}

										$GPS .= '
										</div>
									</div>

								</div>
							</div>
						</div>
						';
						$xcounter_tel_2++;
					}
				$GPS .= '
				</div>
			</div>
		</div>
	</div>';


	return $GPS;
}
/*******************************************************************************************************************/
//Muestra una lista de quipos gps
function widget_GPS_equipos_lista($titulo_cuadro, $seguimiento, $equipo, $enlace,
								  $idSistema, $idTipoUsuario, $idUsuario, $dbConn){

	//Variables
	$HoraSistema    = hora_actual();
	$FechaSistema   = fecha_actual();

	//Variable
	$SIS_where = "telemetria_listado.idEstado = 1 ";//solo equipos activos
	//solo los equipos que tengan el seguimiento activado
	if(isset($seguimiento)&&$seguimiento!=''&&$seguimiento!=0){
		$SIS_where .= " AND telemetria_listado.id_Geo = ".$seguimiento;
	}
	//Filtro el sistema al cual pertenece
	if(isset($idSistema)&&$idSistema!=''&&$idSistema!=0){
		$SIS_where .= " AND telemetria_listado.idSistema = ".$idSistema;
	}
	if (isset($equipo)&&$equipo!=''&&$equipo!=0){
		$SIS_where .= " AND telemetria_listado.idTelemetria=".$equipo;
	}
	//Verifico el tipo de usuario que esta ingresando y el id
	$SIS_join  = '';
	if(isset($idTipoUsuario, $idUsuario)&&$idTipoUsuario!=1&&$idUsuario!=0){
		$SIS_join  .= " INNER JOIN usuarios_equipos_telemetria ON usuarios_equipos_telemetria.idTelemetria = telemetria_listado.idTelemetria ";
		$SIS_where .= " AND usuarios_equipos_telemetria.idUsuario = ".$idUsuario;
	}

	/*****************************/
	//Consulto
	$SIS_query = '
	telemetria_listado.idTelemetria,
	telemetria_listado.Nombre,
	telemetria_listado.Identificador AS Caja,
	telemetria_listado.LastUpdateHora,
	telemetria_listado.LastUpdateFecha,
	telemetria_listado.TiempoFueraLinea,
	telemetria_listado.NDetenciones,
	telemetria_listado.GeoErrores,
	telemetria_listado.NErrores';
	$SIS_order = 'telemetria_listado.Nombre ASC';
	$arrEquipo = array();
	$arrEquipo = db_select_array (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrEquipo');

	$GPS = '
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="box">
					<header>
						<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>'.$titulo_cuadro.'</h5>
					</header>
					<div class="table-responsive">
						<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
							<thead>
								<tr role="row">
									<th>Nombre</th>
									<th>ID Caja</th>
									<th>Fecha - Hora</th>
									<th>Estado</th>
									<th width="10">Acciones</th>
								</tr>
								<tr role="row">
									<th colspan="5"><input class="form-control" id="InputTableFilter_tel_1" type="text" placeholder="Filtrar.."></th>
								</tr>
							</thead>
							<tbody role="alert" aria-live="polite" aria-relevant="all" id="TableFiltered_tel_1">';

								//Recorro
								foreach ($arrEquipo as $data) {

									/**********************************************/
									//Se resetean
									$in_eq_alertas     = 0;
									$in_eq_fueralinea  = 0;
									$in_eq_fueraruta   = 0;
									$in_eq_detenidos   = 0;
									$in_eq_gps_fuera   = 0;
									$in_eq_ok          = 1;

									/**********************************************/
									//Fuera de linea
									$diaInicio   = $data['LastUpdateFecha'];
									$diaTermino  = $FechaSistema;
									$tiempo1     = $data['LastUpdateHora'];
									$tiempo2     = $HoraSistema;
									$Tiempo      = horas_transcurridas($diaInicio, $diaTermino, $tiempo1, $tiempo2);

									//Comparaciones de tiempo
									$Time_Tiempo     = horas2segundos($Tiempo);
									$Time_Tiempo_FL  = horas2segundos($data['TiempoFueraLinea']);
									$Time_Tiempo_Max = horas2segundos('48:00:00');
									$Time_Fake_Ini   = horas2segundos('23:59:50');
									$Time_Fake_Fin   = horas2segundos('24:00:00');
									//comparacion
									if(($Time_Tiempo<$Time_Fake_Ini OR $Time_Tiempo>$Time_Fake_Fin)&&(($Time_Tiempo>$Time_Tiempo_FL&&$Time_Tiempo_FL!=0) OR ($Time_Tiempo>$Time_Tiempo_Max&&$Time_Tiempo_FL==0))){
										$in_eq_fueralinea++;
									}

									/**********************************************/
									//GPS con problemas
									if(isset($data['GeoErrores'])&&$data['GeoErrores']>0){ $in_eq_gps_fuera++; }

									/**********************************************/
									//Equipos con errores
									if(isset($data['NErrores'])&&$data['NErrores']>0){ $in_eq_alertas++; }

									/**********************************************/
									//Equipos detenidos
									if(isset($data['NDetenciones'])&&$data['NDetenciones']>0){ $in_eq_detenidos++; }

									/*******************************************************/
									//rearmo
									if($in_eq_detenidos>0){  $in_eq_ok = 0;$in_eq_detenidos = 1;}
									if($in_eq_alertas>0){    $in_eq_ok = 0;$in_eq_alertas = 1;    $in_eq_detenidos = 0;}
									if($in_eq_fueraruta>0){  $in_eq_ok = 0;$in_eq_fueraruta = 1;  $in_eq_alertas = 0;   $in_eq_detenidos = 0;}
									if($in_eq_gps_fuera>0){  $in_eq_ok = 0;$in_eq_gps_fuera = 1;  $in_eq_fueraruta = 0; $in_eq_alertas = 0;    $in_eq_detenidos = 0;}
									if($in_eq_fueralinea>0){ $in_eq_ok = 0;$in_eq_fueralinea = 1; $in_eq_gps_fuera = 0; $in_eq_fueraruta = 0;  $in_eq_alertas = 0;  $in_eq_detenidos = 0;}

									/*******************************************************/
									//se guardan estados
									$danger = '';
									if($in_eq_detenidos>0){  $danger = 'info';     $dataex = '<a href="#" title="Equipo Detenido"       class="btn btn-danger btn-sm tooltip"><i class="fa fa-car" aria-hidden="true"></i></a>';}
									if($in_eq_alertas>0){    $danger = 'warning';  $dataex = '<a href="#" title="Equipo con Alertas"    class="btn btn-warning btn-sm tooltip"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></a>';}
									if($in_eq_fueraruta>0){  $danger = 'success';  $dataex = '<a href="#" title="Equipo fuera de ruta"  class="btn btn-danger btn-sm tooltip"><i class="fa fa-location-arrow" aria-hidden="true"></i></a>';}
									if($in_eq_gps_fuera>0){  $danger = 'warning';  $dataex = '<a href="#" title="Equipo con GPS en 0"   class="btn btn-danger btn-sm tooltip"><i class="fa fa-map-marker" aria-hidden="true"></i></a>';}
									if($in_eq_fueralinea>0){ $danger = 'danger';   $dataex = '<a href="#" title="Fuera de Linea"        class="btn btn-danger btn-sm tooltip"><i class="fa fa-chain-broken" aria-hidden="true"></i></a>';}

									/*******************************************************/
									//traspasan los estados
									if($in_eq_ok==1){
										$eq_ok = '<a href="#" title="Sin Problemas" class="btn btn-success btn-sm tooltip"><i class="fa fa-check" aria-hidden="true"></i></a>';
									}else{
										$eq_ok = $dataex;
									}

									/*******************************************************/
									//se escriben los datos
									$GPS .= '
										<tr class="odd '.$danger.'">
											<td>'.$data['Nombre'].'</td>
											<td>'.$data['Caja'].'</td>
											<td>'.fecha_estandar($data['LastUpdateFecha']).' a las '.$data['LastUpdateHora'].' hrs</td>
											<td><div class="btn-group" >'.$eq_ok.'</div></td>
											<td>
												<div class="btn-group" style="width: 35px;" >
													<a href="telemetria_gestion_flota_view_equipo_mapa.php?view='.simpleEncode($data['idTelemetria'], fecha_actual()).'" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
												</div>
											</td>
										</tr>';

								}

								$GPS .= '
							</tbody>
						</table>
						<script>
							$(document).ready(function(){
							$("#InputTableFilter_tel_1").on("keyup", function() {
								let value = $(this).val().toLowerCase();
								$("#TableFiltered_tel_1 tr").filter(function() {
								$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
								});
							});
							});
						</script>

					</div>
				</div>
			</div>
		</div>';

	return $GPS;
}
/*******************************************************************************************************************/
//Muestra una lista de quipos gps
function widget_GPS_lista($titulo_cuadro, $seguimiento, $equipo, $enlace,
						  $idSistema, $idTipoUsuario, $idUsuario, $dbConn){

	//Variables
	$HoraSistema    = hora_actual();
	$FechaSistema   = fecha_actual();

	//Variable
	$SIS_where = "telemetria_listado.idEstado = 1 ";//solo equipos activos
	//solo los equipos que tengan el seguimiento activado
	if(isset($seguimiento)&&$seguimiento!=''&&$seguimiento!=0){
		$SIS_where .= " AND telemetria_listado.id_Geo = ".$seguimiento;
	}
	//Filtro el sistema al cual pertenece
	if(isset($idSistema)&&$idSistema!=''&&$idSistema!=0){
		$SIS_where .= " AND telemetria_listado.idSistema = ".$idSistema;
	}
	if (isset($equipo)&&$equipo!=''&&$equipo!=0){
		$SIS_where .= " AND telemetria_listado.idTelemetria=".$equipo;
	}
	//Verifico el tipo de usuario que esta ingresando y el id
	$SIS_join  = '';
	if(isset($idTipoUsuario, $idUsuario)&&$idTipoUsuario!=1&&$idUsuario!=0){
		$SIS_join  .= " INNER JOIN usuarios_equipos_telemetria ON usuarios_equipos_telemetria.idTelemetria = telemetria_listado.idTelemetria ";
		$SIS_where .= " AND usuarios_equipos_telemetria.idUsuario = ".$idUsuario;
	}

	/*****************************/
	//Consulto
	$SIS_query = '
	telemetria_listado.idTelemetria,
	telemetria_listado.Nombre,
	telemetria_listado.Identificador AS Caja,
	telemetria_listado.LastUpdateHora,
	telemetria_listado.LastUpdateFecha,
	telemetria_listado.TiempoFueraLinea,
	telemetria_listado.GeoErrores,
	telemetria_listado.NDetenciones,
	telemetria_listado.NErrores';
	$SIS_order = 'telemetria_listado.Nombre ASC';
	$arrEquipo = array();
	$arrEquipo = db_select_array (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrEquipo');

	$GPS = '
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="box">
					<header>
						<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>'.$titulo_cuadro.'</h5>
					</header>
					<div class="table-responsive">
						<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
							<thead>
								<tr role="row">
									<th>Nombre</th>
									<th>ID Caja</th>
									<th>Fecha - Hora</th>
									<th>Estado</th>
									<th width="10">Acciones</th>
								</tr>
								<tr role="row">
									<th colspan="5"><input class="form-control" id="InputTableFilter_tel_1" type="text" placeholder="Filtrar.."></th>
								</tr>
							</thead>
							<tbody role="alert" aria-live="polite" aria-relevant="all" id="TableFiltered_tel_1">';

								//recorro
								foreach ($arrEquipo as $data) {

									/**********************************************/
									//Se resetean
									$in_eq_alertas     = 0;
									$in_eq_fueralinea  = 0;
									$in_eq_fueraruta   = 0;
									$in_eq_detenidos   = 0;
									$in_eq_gps_fuera   = 0;
									$in_eq_ok          = 1;

									/**********************************************/
									//Fuera de linea
									$diaInicio   = $data['LastUpdateFecha'];
									$diaTermino  = $FechaSistema;
									$tiempo1     = $data['LastUpdateHora'];
									$tiempo2     = $HoraSistema;
									$Tiempo      = horas_transcurridas($diaInicio, $diaTermino, $tiempo1, $tiempo2);

									//Comparaciones de tiempo
									$Time_Tiempo     = horas2segundos($Tiempo);
									$Time_Tiempo_FL  = horas2segundos($data['TiempoFueraLinea']);
									$Time_Tiempo_Max = horas2segundos('48:00:00');
									$Time_Fake_Ini   = horas2segundos('23:59:50');
									$Time_Fake_Fin   = horas2segundos('24:00:00');
									//comparacion
									if(($Time_Tiempo<$Time_Fake_Ini OR $Time_Tiempo>$Time_Fake_Fin)&&(($Time_Tiempo>$Time_Tiempo_FL&&$Time_Tiempo_FL!=0) OR ($Time_Tiempo>$Time_Tiempo_Max&&$Time_Tiempo_FL==0))){
										$in_eq_fueralinea++;
									}

									/**********************************************/
									//GPS con problemas
									if(isset($data['GeoErrores'])&&$data['GeoErrores']>0){ $in_eq_gps_fuera++; }

									/**********************************************/
									//NErrores
									if(isset($data['NErrores'])&&$data['NErrores']>0){ $in_eq_alertas++; }

									/**********************************************/
									//Equipos detenidos
									if(isset($data['NDetenciones'])&&$data['NDetenciones']>0){ $in_eq_detenidos++; }

									/*******************************************************/
									//rearmo
									if($in_eq_detenidos>0){  $in_eq_ok = 0;$in_eq_detenidos = 1;}
									if($in_eq_alertas>0){    $in_eq_ok = 0;$in_eq_alertas = 1;    $in_eq_detenidos = 0;}
									if($in_eq_fueraruta>0){  $in_eq_ok = 0;$in_eq_fueraruta = 1;  $in_eq_alertas = 0;   $in_eq_detenidos = 0;}
									if($in_eq_gps_fuera>0){  $in_eq_ok = 0;$in_eq_gps_fuera = 1;  $in_eq_fueraruta = 0; $in_eq_alertas = 0;    $in_eq_detenidos = 0;}
									if($in_eq_fueralinea>0){ $in_eq_ok = 0;$in_eq_fueralinea = 1; $in_eq_gps_fuera = 0; $in_eq_fueraruta = 0;  $in_eq_alertas = 0;  $in_eq_detenidos = 0;}

									/*******************************************************/
									//se guardan estados
									$danger = '';
									if($in_eq_detenidos>0){  $danger = 'info';     $dataex = '<a href="#" title="Equipo Detenido"       class="btn btn-danger btn-sm tooltip"><i class="fa fa-car" aria-hidden="true"></i></a>';}
									if($in_eq_alertas>0){    $danger = 'warning';  $dataex = '<a href="#" title="Equipo con Alertas"    class="btn btn-warning btn-sm tooltip"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></a>';}
									if($in_eq_fueraruta>0){  $danger = 'success';  $dataex = '<a href="#" title="Equipo fuera de ruta"  class="btn btn-danger btn-sm tooltip"><i class="fa fa-location-arrow" aria-hidden="true"></i></a>';}
									if($in_eq_gps_fuera>0){  $danger = 'warning';  $dataex = '<a href="#" title="Equipo con GPS en 0"   class="btn btn-danger btn-sm tooltip"><i class="fa fa-map-marker" aria-hidden="true"></i></a>';}
									if($in_eq_fueralinea>0){ $danger = 'danger';   $dataex = '<a href="#" title="Fuera de Linea"        class="btn btn-danger btn-sm tooltip"><i class="fa fa-chain-broken" aria-hidden="true"></i></a>';}

									/*******************************************************/
									//traspasan los estados
									if($in_eq_ok==1){
										$eq_ok = '<a href="#" title="Sin Problemas" class="btn btn-success btn-sm tooltip"><i class="fa fa-check" aria-hidden="true"></i></a>';
									}else{
										$eq_ok = $dataex;
									}

									/*******************************************************/
									//se escriben los datos
									$GPS .= '
										<tr class="odd '.$danger.'">
											<td>'.$data['Nombre'].'</td>
											<td>'.$data['Caja'].'</td>
											<td>'.fecha_estandar($data['LastUpdateFecha']).' a las '.$data['LastUpdateHora'].' hrs</td>
											<td><div class="btn-group" >'.$eq_ok.'</div></td>
											<td>
												<div class="btn-group" style="width: 35px;" >
													<a href="telemetria_gestion_flota_view_equipo_mapa.php?view='.simpleEncode($data['idTelemetria'], fecha_actual()).'" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
												</div>
											</td>
										</tr>';

								}

								$GPS .= '
							</tbody>
						</table>
						<script>
							$(document).ready(function(){
							$("#InputTableFilter_tel_1").on("keyup", function() {
								let value = $(this).val().toLowerCase();
								$("#TableFiltered_tel_1 tr").filter(function() {
								$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
								});
							});
							});
						</script>

					</div>
				</div>
			</div>
		</div>';

	return $GPS;
}
/*******************************************************************************************************************/
//Muestra los promedios de los equipos
function widget_Promedios_equipo($titulo_cuadro, $seguimiento, $equipo, $enlace, $idSistema, $idTipoUsuario, $idUsuario, $dbConn){

	//Variables
	$HoraSistema    = hora_actual();
	$FechaSistema   = fecha_actual();

	//Variable
	$SIS_where = "telemetria_listado.idEstado = 1 ";//solo equipos activos
	//solo los equipos que tengan el seguimiento activado
	if(isset($seguimiento)&&$seguimiento!=''&&$seguimiento!=0){
		$SIS_where .= " AND telemetria_listado.id_Geo = ".$seguimiento;
	}
	//Filtro el sistema al cual pertenece
	if(isset($idSistema)&&$idSistema!=''&&$idSistema!=0){
		$SIS_where .= " AND telemetria_listado.idSistema = ".$idSistema;
	}
	if (isset($equipo)&&$equipo!=''&&$equipo!=0){
		$SIS_where .= " AND telemetria_listado.idTelemetria=".$equipo;
	}
	//Verifico el tipo de usuario que esta ingresando y el id
	$SIS_join  = '';
	if(isset($idTipoUsuario, $idUsuario)&&$idTipoUsuario!=1&&$idUsuario!=0){
		$SIS_join  .= " INNER JOIN usuarios_equipos_telemetria ON usuarios_equipos_telemetria.idTelemetria = telemetria_listado.idTelemetria ";
		$SIS_where .= " AND usuarios_equipos_telemetria.idUsuario = ".$idUsuario;
	}


	//numero sensores equipo
	$N_Maximo_Sensores = 60;
	$subquery = '';
	for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
		$subquery .= ',telemetria_listado_sensores_med_actual.SensoresMedActual_'.$i;
		$subquery .= ',telemetria_listado_sensores_grupo.SensoresGrupo_'.$i;
		$subquery .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i;
		$subquery .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$i;
	}

	/*****************************/
	//Consulto
	$SIS_query = '
	telemetria_listado.idTelemetria,
	telemetria_listado.Nombre,
	telemetria_listado.LastUpdateHora,
	telemetria_listado.LastUpdateFecha,
	telemetria_listado.cantSensores,
	telemetria_listado.TiempoFueraLinea,
	telemetria_listado.NErrores'.$subquery;
	$SIS_join  .= '
	LEFT JOIN `telemetria_listado_sensores_med_actual`     ON telemetria_listado_sensores_med_actual.idTelemetria     = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_grupo`          ON telemetria_listado_sensores_grupo.idTelemetria          = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_unimed`         ON telemetria_listado_sensores_unimed.idTelemetria         = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_activo`         ON telemetria_listado_sensores_activo.idTelemetria         = telemetria_listado.idTelemetria';
	$SIS_order = 'telemetria_listado.Nombre ASC';
	$arrEquipo = array();
	$arrEquipo = db_select_array (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrEquipo');

	$arrUnimed = array();
	$arrUnimed = db_select_array (false, 'idUniMed,Nombre', 'telemetria_listado_unidad_medida', '', '', 'idUniMed ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrUnimed');

	$arrGrupos = array();
	$arrGrupos = db_select_array (false, 'idGrupo,Nombre,nColumnas', 'telemetria_listado_grupos', '', '', 'idGrupo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrGrupos');

	$arrFinalUnimed = array();
	$arrFinalGrupos = array();
	foreach ($arrUnimed as $sen) { $arrFinalUnimed[$sen['idUniMed']] = $sen['Nombre'];}
	foreach ($arrGrupos as $sen) { $arrFinalGrupos[$sen['idGrupo']]['Nombre'] = $sen['Nombre']; $arrFinalGrupos[$sen['idGrupo']]['nColumnas'] = $sen['nColumnas']; $arrFinalGrupos[$sen['idGrupo']]['idGrupo'] = $sen['idGrupo'];}

	$GPS = '
	<div class="row">

		<h3 class="supertittle text-primary">'.$titulo_cuadro.'</h3>';

		foreach($arrEquipo as $equip) {

			/***************************************/
			//Fuera de linea
			$diaInicio   = $equip['LastUpdateFecha'];
			$diaTermino  = $FechaSistema;
			$tiempo1     = $equip['LastUpdateHora'];
			$tiempo2     = $HoraSistema;
			$Tiempo      = horas_transcurridas($diaInicio, $diaTermino, $tiempo1, $tiempo2);
			$eq_alertas  = 0;

			//Comparaciones de tiempo
			$Time_Tiempo     = horas2segundos($Tiempo);
			$Time_Tiempo_FL  = horas2segundos($equip['TiempoFueraLinea']);
			$Time_Tiempo_Max = horas2segundos('48:00:00');
			$Time_Fake_Ini   = horas2segundos('23:59:50');
			$Time_Fake_Fin   = horas2segundos('24:00:00');
			//comparacion
			if(($Time_Tiempo<$Time_Fake_Ini OR $Time_Tiempo>$Time_Fake_Fin)&&(($Time_Tiempo>$Time_Tiempo_FL&&$Time_Tiempo_FL!=0) OR ($Time_Tiempo>$Time_Tiempo_Max&&$Time_Tiempo_FL==0))){
				$wd_color = 'box-red';
			//sino con azul normal
			}else{
				//NErrores
				if(isset($equip['NErrores'])&&$equip['NErrores']>0){
					$eq_alertas++;
				}

				//verificacion de errores
				if($eq_alertas!=0){
					$wd_color = 'box-yellow';
				}else{
					$wd_color = 'box-blue';
				}
			}

			$GPS .= '
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
				<div class="box '.$wd_color.' box-solid">
					<div class="box-header with-border">
						<h3 class="box-title">'.$equip['Nombre'].'</h3>
						<div class="box-tools pull-right">
							<a target="_blank" rel="noopener noreferrer" href="principal_telemetria_grupo_alt.php?idTelemetria='.simpleEncode($equip['idTelemetria'], fecha_actual()).'" class="iframe btn btn-xs btn-primary btn-line">Ver Mediciones</a>
						</div>
					</div>
					<div class="box-body">
						<table id="dataTable" class="table table-bordered table-condensed table-hover dataTable">
							<tbody role="alert" aria-live="polite" aria-relevant="all">
								<tr class="odd">
									<td colspan="3">Medicion el '.fecha_estandar($equip['LastUpdateFecha']).' a las '.$equip['LastUpdateHora'].' hrs</td>
								</tr>';

								//variables
								$arrGruposTitulo = array();

								for ($i = 1; $i <= $equip['cantSensores']; $i++) {
									//solo sensores activos
									if(isset($equip['SensoresActivo_'.$i])&&$equip['SensoresActivo_'.$i]==1){
										//Unidad medida
										if(isset($arrFinalUnimed[$equip['SensoresUniMed_'.$i]])){
											$unimed = ' '.$arrFinalUnimed[$equip['SensoresUniMed_'.$i]];
										}else{
											$unimed = '';
										}
										//Titulo del cuadro
										if(isset($arrFinalGrupos[$equip['SensoresGrupo_'.$i]]['Nombre'])){
											$Titulo    = $arrFinalGrupos[$equip['SensoresGrupo_'.$i]]['Nombre'];
										}else{
											$Titulo    = '';
										}
										if(isset($arrFinalGrupos[$equip['SensoresGrupo_'.$i]]['nColumnas'])){
											$nColumnas = $arrFinalGrupos[$equip['SensoresGrupo_'.$i]]['nColumnas'];
										}else{
											$nColumnas = '';
										}
										//Guardo el valor correspondiente
										$arrGruposTitulo[$Titulo][$i]['valor']     = $equip['SensoresMedActual_'.$i];
										$arrGruposTitulo[$Titulo][$i]['unimed']    = $unimed;
										$arrGruposTitulo[$Titulo][$i]['nColumnas'] = $nColumnas;
									}
								}

								//Ordenamiento por titulo de grupo
								$names = array();
								foreach ($arrGruposTitulo as $titulo=>$items) {
									$names[] = $titulo;
								}
								array_multisort($names, SORT_ASC, $arrGruposTitulo);

								//se recorre el arreglo
								foreach($arrGruposTitulo as $titulo=>$items) {
									$ndatacol    = 0;
									$total_col1  = 0;
									$total_col2  = 0;
									$ntotal_col1 = 0;
									$ntotal_col2 = 0;
									$unimed_col1 = '';
									$unimed_col2 = '';
									$y           = 1;

									foreach($items as $datos) {
										//si el grupo solo tiene una columna
										if(isset($datos['nColumnas'])&&$datos['nColumnas']==1){
											//Especifico el numero de columnas
											$ndatacol = 1;
											//Verifico que el dato no sea 99900
											if(isset($datos['valor'])&&$datos['valor']<99900){
												$total_col1 = $total_col1 + $datos['valor'];
												$ntotal_col1++;
											}
											$unimed_col1 = $datos['unimed'];

											//si el grupo tiene 2 columnas
										}elseif(isset($datos['nColumnas'])&&$datos['nColumnas']==2){
											//Especifico el numero de columnas
											$ndatacol = 2;
											//Se guardan los datos
											if($y==1){
												//Verifico que el dato no sea 99900
												if(isset($datos['valor'])&&$datos['valor']<99900){
													$total_col1 = $total_col1 + $datos['valor'];
													$ntotal_col1++;
												}
												$unimed_col1 = $datos['unimed'];
												$y=2;
											}else{
												//Verifico que el dato no sea 99900
												if(isset($datos['valor'])&&$datos['valor']<99900){
													$total_col2 = $total_col2 + $datos['valor'];
													$ntotal_col2++;
												}
												$unimed_col2 = $datos['unimed'];
												$y=1;
											}
										}
									}
									/*************************************************/

									$GPS .= '
									<tr class="odd">
										<td>'.$titulo.'</td>';
										/***********************/
										if($ndatacol==1){
											if($ntotal_col1!=0){$GPS .= '<td colspan="2">'.Cantidades(($total_col1/$ntotal_col1), 1).$unimed_col1.'</td>';}else{$GPS .= '<td colspan="2">0'.$unimed_col1.'</td>';}
										}elseif($ndatacol==2){
											if($ntotal_col1!=0){$GPS .= '<td>'.Cantidades(($total_col1/$ntotal_col1), 1).$unimed_col1.'</td>';}else{$GPS .= '<td>0'.$unimed_col1.'</td>';}
											if($ntotal_col2!=0){$GPS .= '<td>'.Cantidades(($total_col2/$ntotal_col2), 1).$unimed_col2.'</td>';}else{$GPS .= '<td>0'.$unimed_col2.'</td>';}
										}

									$GPS .= '</tr>';

								}

								$GPS .= '
							</tbody>
						</table>

					</div>
				</div>
			</div>';
		}

	$GPS .= '</div> ';

	return $GPS;
}
/*******************************************************************************************************************/
//Muestra los promedios de los equipos por grupos
function widget_Promedios_equipo_grupos($titulo_cuadro, $seguimiento, $equipo, $enlace, $idSistema, $idTipoUsuario, $idUsuario, $dbConn){

	//Variables
	$HoraSistema    = hora_actual();
	$FechaSistema   = fecha_actual();

	//Variable
	$SIS_where = "telemetria_listado.idEstado = 1 ";//solo equipos activos
	//solo los equipos que tengan el seguimiento activado
	if(isset($seguimiento)&&$seguimiento!=''&&$seguimiento!=0){
		$SIS_where .= " AND telemetria_listado.id_Geo = ".$seguimiento;
	}
	//Filtro el sistema al cual pertenece
	if(isset($idSistema)&&$idSistema!=''&&$idSistema!=0){
		$SIS_where .= " AND telemetria_listado.idSistema = ".$idSistema;
	}
	if (isset($equipo)&&$equipo!=''&&$equipo!=0){
		$SIS_where .= " AND telemetria_listado.idTelemetria=".$equipo;
	}
	//Verifico el tipo de usuario que esta ingresando y el id
	$SIS_join  = '';
	if(isset($idTipoUsuario, $idUsuario)&&$idTipoUsuario!=1&&$idUsuario!=0){
		$SIS_join  .= " INNER JOIN usuarios_equipos_telemetria ON usuarios_equipos_telemetria.idTelemetria = telemetria_listado.idTelemetria ";
		$SIS_where .= " AND usuarios_equipos_telemetria.idUsuario = ".$idUsuario;
	}

	//numero sensores equipo
	$N_Maximo_Sensores = 60;
	$subquery = '';
	for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
		$subquery .= ',telemetria_listado_sensores_med_actual.SensoresMedActual_'.$i;
		$subquery .= ',telemetria_listado_sensores_grupo.SensoresGrupo_'.$i;
		$subquery .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i;
		$subquery .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$i;
	}

	/*****************************/
	//Consulto
	$SIS_query = '
	telemetria_listado.idTelemetria,
	telemetria_listado.Nombre,
	telemetria_listado.LastUpdateHora,
	telemetria_listado.LastUpdateFecha,
	telemetria_listado.cantSensores,
	telemetria_listado.TiempoFueraLinea,
	telemetria_listado.NErrores'.$subquery;
	$SIS_join  .= '
	LEFT JOIN `telemetria_listado_sensores_med_actual`     ON telemetria_listado_sensores_med_actual.idTelemetria     = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_grupo`          ON telemetria_listado_sensores_grupo.idTelemetria          = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_unimed`         ON telemetria_listado_sensores_unimed.idTelemetria         = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_activo`         ON telemetria_listado_sensores_activo.idTelemetria         = telemetria_listado.idTelemetria';
	$SIS_order = 'telemetria_listado.Nombre ASC';
	$arrEquipo = array();
	$arrEquipo = db_select_array (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrEquipo');

	$arrUnimed = array();
	$arrUnimed = db_select_array (false, 'idUniMed,Nombre', 'telemetria_listado_unidad_medida', '', '', 'idUniMed ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrUnimed');

	$arrGrupos = array();
	$arrGrupos = db_select_array (false, 'idGrupo,Nombre,nColumnas', 'telemetria_listado_grupos', '', '', 'idGrupo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrGrupos');

	$arrFinalUnimed = array();
	$arrFinalGrupos = array();
	foreach ($arrUnimed as $sen) { $arrFinalUnimed[$sen['idUniMed']] = $sen['Nombre'];}
	foreach ($arrGrupos as $sen) { $arrFinalGrupos[$sen['idGrupo']]['Nombre'] = $sen['Nombre']; $arrFinalGrupos[$sen['idGrupo']]['nColumnas'] = $sen['nColumnas']; $arrFinalGrupos[$sen['idGrupo']]['idGrupo'] = $sen['idGrupo'];}

	$GPS = '
	<div class="row">

		<h3 class="supertittle text-primary">'.$titulo_cuadro.'</h3>';

		foreach($arrEquipo as $equip) {

			/***************************************/
			//Fuera de linea
			$diaInicio   = $equip['LastUpdateFecha'];
			$diaTermino  = $FechaSistema;
			$tiempo1     = $equip['LastUpdateHora'];
			$tiempo2     = $HoraSistema;
			$Tiempo      = horas_transcurridas($diaInicio, $diaTermino, $tiempo1, $tiempo2);

			//Comparaciones de tiempo
			$Time_Tiempo     = horas2segundos($Tiempo);
			$Time_Tiempo_FL  = horas2segundos($equip['TiempoFueraLinea']);
			$Time_Tiempo_Max = horas2segundos('48:00:00');
			$Time_Fake_Ini   = horas2segundos('23:59:50');
			$Time_Fake_Fin   = horas2segundos('24:00:00');
			//comparacion
			if(($Time_Tiempo<$Time_Fake_Ini OR $Time_Tiempo>$Time_Fake_Fin)&&(($Time_Tiempo>$Time_Tiempo_FL&&$Time_Tiempo_FL!=0) OR ($Time_Tiempo>$Time_Tiempo_Max&&$Time_Tiempo_FL==0))){
				$wd_color = 'box-red';
			//sino con azul normal
			}else{
				$wd_color = 'box-blue';
			}

			$GPS .= '
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="box '.$wd_color.' box-solid">
					<div class="box-header with-border">
						<h3 class="box-title">'.$equip['Nombre'].'</h3>
						<div class="box-tools pull-right">
							<a target="_blank" rel="noopener noreferrer" href="principal_telemetria_grupo_alt.php?idTelemetria='.simpleEncode($equip['idTelemetria'], fecha_actual()).'" class="iframe btn btn-xs btn-primary btn-line">Ver Mediciones</a>
						</div>
					</div>
					<div class="box-body">
						<h4 class="box-title">Medicion el '.fecha_estandar($equip['LastUpdateFecha']).' a las '.$equip['LastUpdateHora'].' hrs</h4>';

							//variables
							$arrGruposTitulo = array();

							for ($i = 1; $i <= $equip['cantSensores']; $i++) {
								//solo sensores activos
								if(isset($equip['SensoresActivo_'.$i])&&$equip['SensoresActivo_'.$i]==1){
									//Unidad medida
									if(isset($arrFinalUnimed[$equip['SensoresUniMed_'.$i]])){
										$unimed = ' '.$arrFinalUnimed[$equip['SensoresUniMed_'.$i]];
									}else{
										$unimed = '';
									}
									//Titulo del cuadro
									if(isset($arrFinalGrupos[$equip['SensoresGrupo_'.$i]]['Nombre'])){
										$Titulo    = $arrFinalGrupos[$equip['SensoresGrupo_'.$i]]['Nombre'];
									}else{
										$Titulo    = '';
									}
									if(isset($arrFinalGrupos[$equip['SensoresGrupo_'.$i]]['nColumnas'])){
										$nColumnas = $arrFinalGrupos[$equip['SensoresGrupo_'.$i]]['nColumnas'];
									}else{
										$nColumnas = '';
									}
									if(isset($arrFinalGrupos[$equip['SensoresGrupo_'.$i]]['idGrupo'])){
										$s_idGrupo = $arrFinalGrupos[$equip['SensoresGrupo_'.$i]]['idGrupo'];
									}else{
										$s_idGrupo = '';
									}
									//Guardo el valor correspondiente
									$arrGruposTitulo[$Titulo][$i]['Color']     = 'blue';
									$arrGruposTitulo[$Titulo][$i]['valor']     = $equip['SensoresMedActual_'.$i];
									$arrGruposTitulo[$Titulo][$i]['unimed']    = $unimed;
									$arrGruposTitulo[$Titulo][$i]['nColumnas'] = $nColumnas;
									$arrGruposTitulo[$Titulo][$i]['idGrupo']   = $s_idGrupo;
								}
							}

							//Ordenamiento por titulo de grupo
							$names = array();
							foreach ($arrGruposTitulo as $titulo=>$items) {
								$names[] = $titulo;
							}
							array_multisort($names, SORT_ASC, $arrGruposTitulo);

							//se recorre el arreglo
							foreach($arrGruposTitulo as $titulo=>$items) {

								//variables
								$ndatacol    = 0;
								$total_col1  = 0;
								$total_col2  = 0;
								$ntotal_col1 = 0;
								$ntotal_col2 = 0;
								$unimed_col1 = '';
								$unimed_col2 = '';
								$xs_idGrupo  = 0;
								$y           = 1;
								$xs_Color = 'blue';

								foreach($items as $datos) {
									//asigno el grupo
									$xs_idGrupo  = $datos['idGrupo'];
									$xs_Color    = $datos['Color'];
									//si el grupo solo tiene una columna
									if(isset($datos['nColumnas'])&&$datos['nColumnas']==1){
										//Especifico el numero de columnas
										$ndatacol = 1;
										//Verifico que el dato no sea 99900
										if(isset($datos['valor'])&&$datos['valor']<99900){
											$total_col1 = $total_col1 + $datos['valor'];
											$ntotal_col1++;
										}
										$unimed_col1 = $datos['unimed'];

									//si el grupo tiene 2 columnas
									}elseif(isset($datos['nColumnas'])&&$datos['nColumnas']==2){
										//Especifico el numero de columnas
										$ndatacol = 2;
										//Se guardan los datos
										if($y==1){
											//Verifico que el dato no sea 99900
											if(isset($datos['valor'])&&$datos['valor']<99900){
												$total_col1 = $total_col1 + $datos['valor'];
												$ntotal_col1++;
											}
											$unimed_col1 = $datos['unimed'];
											$y=2;
										}else{
											//Verifico que el dato no sea 99900
											if(isset($datos['valor'])&&$datos['valor']<99900){
												$total_col2 = $total_col2 + $datos['valor'];
												$ntotal_col2++;
											}
											$unimed_col2 = $datos['unimed'];
											$y=1;
										}
									}
								}

								/*************************************************/
								$GPS .= '
								<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
									<div class="box box-'.$xs_Color.' box-solid">
										<div class="box-header with-border">
											<h3 class="box-title">Grupo</h3>
											<div class="box-tools pull-right">
												<a target="_blank" rel="noopener noreferrer" href="principal_telemetria_grupo_alt_2.php?idTelemetria='.simpleEncode($equip['idTelemetria'], fecha_actual()).'&idGrupo='.simpleEncode($xs_idGrupo, fecha_actual()).'&titulo='.simpleEncode($titulo, fecha_actual()).'" class="iframe btn btn-xs btn-primary btn-line">Ver Mediciones</a>
											</div>
										</div>
										<div class="box-body">
											<table id="dataTable" class="table table-bordered table-condensed table-hover dataTable">
												<tbody role="alert" aria-live="polite" aria-relevant="all">';

													//Titulo
													$GPS .= '<tr class="odd">';
													$GPS .= '<td colspan="2">'.$titulo.'</td>';
													$GPS .= '</tr>';

													//datos
													$GPS .= '<tr class="odd">';
														/***********************/
														if($ndatacol==1){
															if($ntotal_col1!=0){$GPS .= '<td colspan="2">'.Cantidades(($total_col1/$ntotal_col1), 1).$unimed_col1.'</td>';}else{$GPS .= '<td colspan="2">0'.$unimed_col1.'</td>';}
														}elseif($ndatacol==2){
															if($ntotal_col1!=0){$GPS .= '<td>'.Cantidades(($total_col1/$ntotal_col1), 1).$unimed_col1.'</td>';}else{$GPS .= '<td>0'.$unimed_col1.'</td>';}
															if($ntotal_col2!=0){$GPS .= '<td>'.Cantidades(($total_col2/$ntotal_col2), 1).$unimed_col2.'</td>';}else{$GPS .= '<td>0'.$unimed_col2.'</td>';}
														}

													$GPS .= '</tr>
												</tbody>
											</table>

										</div>
									</div>
								</div>';

							}

							$GPS .= '

						<div class="clearfix"></div>
					</div>
				</div>
			</div>';
		}

	$GPS .= '</div> ';

	return $GPS;
}
/*******************************************************************************************************************/
//Muestra el widget del superadministrador
function widget_superadmin($dbConn, $DB_SERVER, $DB_USER, $DB_PASS, $DB_NAME_1, $DB_NAME_2){

	//tamaño maximo de las carpetas
	$max_folder = 102400/1024;
	$max_site   = 204800/1024;
	//Verifico el tamaño de los directorios
	$folder_backup = cantidades(MeDir('./backups', 1)/1024000, 2);
	$folder_upload = cantidades(MeDir('./upload', 1)/1024000, 2);
	$folder_root   = cantidades(MeDir('.', 1)/1024000, 2);
	//Se calcula el porcentaje
	$porc_1 = cantidades(($folder_backup / $max_folder)*100, 0);
	$porc_2 = cantidades(($folder_upload / $max_folder)*100, 0);
	$porc_3 = cantidades(($folder_root / $max_site)*100, 0);

	//se verifica la cantidad de errores en el sistema
	$handle = fopen("error_log","r");
	static $b = 0;
	while($a = fgets($handle)) {
		$b++;
	}
	$b = $b-1;

	$widget = '
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="box superadmin_box">
				<div class="box-header with-border">
					<h3 class="box-title">Información del Sistema</h3>
				</div>

				<div class="box-body" style="padding-top:5px;">
					<div class="row">
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
							<div class="chart">
								<iframe class="col-xs-12 col-sm-12 col-md-12 col-lg-12" frameborder="0" height="400" src="'.DB_SITE_REPO.'/EXTERNAL_LIBS/linfo/index.php"></iframe>
							</div>
						</div>

						<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<p class="text-center">
									<strong>Tamaño de Carpetas</strong>
								</p>

								<div class="progress-group">
									<span class="progress-text">Root</span>
									<span class="progress-number"><b>'.$folder_root.'</b>/'.$max_site.' MB</span>
									<div class="progress sm">
										<div class="progress-bar progress-bar-green" style="width: '.$porc_3.'%"></div>
									</div>
								</div>

								<div class="progress-group">
									<span class="progress-text">Backups Database</span>
									<span class="progress-number"><b>'.$folder_backup.'</b>/'.$max_folder.' MB</span>
									<div class="progress sm">
										<div class="progress-bar progress-bar-aqua" style="width: '.$porc_1.'%"></div>
									</div>
								</div>

								<div class="progress-group">
									<span class="progress-text">Subidas</span>
									<span class="progress-number"><b>'.$folder_upload.'</b>/'.$max_folder.' MB</span>
									<div class="progress sm">
										<div class="progress-bar progress-bar-red" style="width: '.$porc_2.'%"></div>
									</div>
								</div>

								<p class="text-center">
									<strong>Log del sistema</strong>
								</p>
								<ul class="nav nav-pills nav-stacked">
									<li><a href="#">Errores          <span class="pull-right text-red">0</span></a></li>
									<li><a href="#">Advertencias     <span class="pull-right text-yellow">'.$b.'</span></a></li>
									<li><a href="#">Otros            <span class="pull-right text-green">0</span></a></li>
								</ul>

							</div>

						</div>
					</div>

				</div>

			</div>
		</div>
	</div>';

	return $widget;
}
/*******************************************************************************************************************/
//Muestra los documentos relacionados
function widget_Doc_relacionados($idOcompra,
								$idTipoUsuario, $idSistema,
								$dbConn){
	//Variables
	$z1 = "bodegas_insumos_facturacion.idFacturacion!=0";
	$z2 = "bodegas_productos_facturacion.idFacturacion!=0";
	$z3 = "bodegas_arriendos_facturacion.idFacturacion!=0";
	$z4 = "bodegas_servicios_facturacion.idFacturacion!=0";
	//verifico que sea un administrador
	if($idTipoUsuario==1){
		$z0 = "ocompra_listado.idSistema>=0";
		$z1.= " AND bodegas_insumos_facturacion.idSistema>=0";
		$z2.= " AND bodegas_productos_facturacion.idSistema>=0";
		$z3.= " AND bodegas_arriendos_facturacion.idSistema>=0";
		$z4.= " AND bodegas_servicios_facturacion.idSistema>=0";
	}else{
		$z0 = "ocompra_listado.idSistema=".$idSistema;
		$z1.= " AND bodegas_insumos_facturacion.idSistema=".$idSistema;
		$z2.= " AND bodegas_productos_facturacion.idSistema=".$idSistema;
		$z3.= " AND bodegas_arriendos_facturacion.idSistema=".$idSistema;
		$z4.= " AND bodegas_servicios_facturacion.idSistema=".$idSistema;
	}
	//filtro por ordenes
	$z0.= " AND ocompra_listado.idOcompra=".$idOcompra;
	$z1.= " AND ocompra_listado.idOcompra=".$idOcompra;
	$z2.= " AND ocompra_listado.idOcompra=".$idOcompra;
	$z3.= " AND ocompra_listado.idOcompra=".$idOcompra;
	$z4.= " AND ocompra_listado.idOcompra=".$idOcompra;
	/******************************************************/
	//consulta
	$SIS_query = '
	ocompra_listado.idOcompra,
	ocompra_listado.Creacion_fecha,
	proveedor_listado.Nombre AS NombreProveedor';
	$SIS_join  = 'LEFT JOIN `proveedor_listado`  ON proveedor_listado.idProveedor = ocompra_listado.idProveedor';
	$SIS_where = $z0;
	$SIS_order = 'ocompra_listado.idOcompra DESC';
	$arrOrdenes = array();
	$arrOrdenes = db_select_array (false, $SIS_query, 'ocompra_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrOrdenes');

	/******************************************************/
	// Se trae un listado con todos los elementos
	$SIS_query = '
	bodegas_insumos_facturacion.idFacturacion,
	bodegas_insumos_facturacion.Creacion_fecha,
	bodegas_insumos_facturacion.F_Pago,
	bodegas_insumos_facturacion.N_Doc,
	bodegas_insumos_facturacion.ValorTotal,
	core_sistemas.Nombre AS Sistema,
	core_documentos_mercantiles.Nombre_abrev AS Documento,
	proveedor_listado.Nombre AS Proveedor,
	core_estado_facturacion.Nombre AS Estado';
	$SIS_join  = '
	LEFT JOIN `core_sistemas`                 ON core_sistemas.idSistema                    = bodegas_insumos_facturacion.idSistema
	LEFT JOIN `core_documentos_mercantiles`   ON core_documentos_mercantiles.idDocumentos   = bodegas_insumos_facturacion.idDocumentos
	LEFT JOIN `proveedor_listado`             ON proveedor_listado.idProveedor              = bodegas_insumos_facturacion.idProveedor
	LEFT JOIN `ocompra_listado`               ON ocompra_listado.idOcompra                  = bodegas_insumos_facturacion.idOcompra
	LEFT JOIN `core_estado_facturacion`       ON core_estado_facturacion.idEstado           = bodegas_insumos_facturacion.idEstado';
	$SIS_where = $z1;
	$SIS_order = 'bodegas_insumos_facturacion.F_Pago ASC, proveedor_listado.Nombre ASC, bodegas_insumos_facturacion.N_Doc ASC';
	$arrInsumos = array();
	$arrInsumos = db_select_array (false, $SIS_query, 'bodegas_insumos_facturacion', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrInsumos');

	/******************************************************/
	// Se trae un listado con todos los elementos
	$SIS_query = '
	bodegas_productos_facturacion.idFacturacion,
	bodegas_productos_facturacion.Creacion_fecha,
	bodegas_productos_facturacion.F_Pago,
	bodegas_productos_facturacion.N_Doc,
	bodegas_productos_facturacion.ValorTotal,
	core_sistemas.Nombre AS Sistema,
	core_documentos_mercantiles.Nombre_abrev AS Documento,
	proveedor_listado.Nombre AS Proveedor,
	core_estado_facturacion.Nombre AS Estado';
	$SIS_join  = '
	LEFT JOIN `core_sistemas`                ON core_sistemas.idSistema                   = bodegas_productos_facturacion.idSistema
	LEFT JOIN `core_documentos_mercantiles`  ON core_documentos_mercantiles.idDocumentos  = bodegas_productos_facturacion.idDocumentos
	LEFT JOIN `proveedor_listado`            ON proveedor_listado.idProveedor             = bodegas_productos_facturacion.idProveedor
	LEFT JOIN `ocompra_listado`              ON ocompra_listado.idOcompra                 = bodegas_productos_facturacion.idOcompra
	LEFT JOIN `core_estado_facturacion`      ON core_estado_facturacion.idEstado          = bodegas_productos_facturacion.idEstado';
	$SIS_where = $z2;
	$SIS_order = 'bodegas_productos_facturacion.F_Pago ASC, proveedor_listado.Nombre ASC, bodegas_productos_facturacion.N_Doc ASC';
	$arrProductos = array();
	$arrProductos = db_select_array (false, $SIS_query, 'bodegas_productos_facturacion', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrProductos');

	/******************************************************/
	// Se trae un listado con todos los elementos
	$SIS_query = '
	bodegas_arriendos_facturacion.idFacturacion,
	bodegas_arriendos_facturacion.Creacion_fecha,
	bodegas_arriendos_facturacion.F_Pago,
	bodegas_arriendos_facturacion.N_Doc,
	bodegas_arriendos_facturacion.ValorTotal,
	core_sistemas.Nombre AS Sistema,
	core_documentos_mercantiles.Nombre_abrev AS Documento,
	proveedor_listado.Nombre AS Proveedor,
	core_estado_facturacion.Nombre AS Estado';
	$SIS_join  = '
	LEFT JOIN `core_sistemas`                 ON core_sistemas.idSistema                    = bodegas_arriendos_facturacion.idSistema
	LEFT JOIN `core_documentos_mercantiles`   ON core_documentos_mercantiles.idDocumentos   = bodegas_arriendos_facturacion.idDocumentos
	LEFT JOIN `proveedor_listado`             ON proveedor_listado.idProveedor              = bodegas_arriendos_facturacion.idProveedor
	LEFT JOIN `ocompra_listado`               ON ocompra_listado.idOcompra                  = bodegas_arriendos_facturacion.idOcompra
	LEFT JOIN `core_estado_facturacion`       ON core_estado_facturacion.idEstado           = bodegas_arriendos_facturacion.idEstado';
	$SIS_where = $z3;
	$SIS_order = 'bodegas_arriendos_facturacion.F_Pago ASC, proveedor_listado.Nombre ASC, bodegas_arriendos_facturacion.N_Doc ASC';
	$arrArriendos = array();
	$arrArriendos = db_select_array (false, $SIS_query, 'bodegas_arriendos_facturacion', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrArriendos');

	/******************************************************/
	// Se trae un listado con todos los elementos
	$SIS_query = '
	bodegas_servicios_facturacion.idFacturacion,
	bodegas_servicios_facturacion.Creacion_fecha,
	bodegas_servicios_facturacion.F_Pago,
	bodegas_servicios_facturacion.N_Doc,
	bodegas_servicios_facturacion.ValorTotal,
	core_sistemas.Nombre AS Sistema,
	core_documentos_mercantiles.Nombre_abrev AS Documento,
	proveedor_listado.Nombre AS Proveedor,
	core_estado_facturacion.Nombre AS Estado';
	$SIS_join  = '
	LEFT JOIN `core_sistemas`                 ON core_sistemas.idSistema                    = bodegas_servicios_facturacion.idSistema
	LEFT JOIN `core_documentos_mercantiles`   ON core_documentos_mercantiles.idDocumentos   = bodegas_servicios_facturacion.idDocumentos
	LEFT JOIN `proveedor_listado`             ON proveedor_listado.idProveedor              = bodegas_servicios_facturacion.idProveedor
	LEFT JOIN `ocompra_listado`               ON ocompra_listado.idOcompra                  = bodegas_servicios_facturacion.idOcompra
	LEFT JOIN `core_estado_facturacion`       ON core_estado_facturacion.idEstado           = bodegas_servicios_facturacion.idEstado';
	$SIS_where = $z4;
	$SIS_order = 'bodegas_servicios_facturacion.F_Pago ASC, proveedor_listado.Nombre ASC, bodegas_servicios_facturacion.N_Doc ASC';
	$arrServicios = array();
	$arrServicios = db_select_array (false, $SIS_query, 'bodegas_servicios_facturacion', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrServicios');

	$html = '';
	/******************************************************/
	$html .= '
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Documentos Relacionados</h5>
			</header>
			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
							<th>Tipo</th>
							<th>Proveedor</th>
							<th>Documento</th>
							<th>Fecha Emision</th>
							<th>Fecha Pago</th>
							<th>Estado</th>
							<th width="10">Acciones</th>
						</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">';
							foreach ($arrOrdenes as $orden) {
								$html .= '
								<tr class="odd">
									<td>OC</td>
									<td>'.$orden['NombreProveedor'].'</td>
									<td>OC '.n_doc($orden['idOcompra'], 5).'</td>
									<td>'.Fecha_estandar($orden['Creacion_fecha']).'</td>
									<td></td>
									<td></td>
									<td>
										<div class="btn-group" style="width: 35px;" >
											<a href="view_ocompra.php?view='.simpleEncode($orden['idOcompra'], fecha_actual()).'" title="Ver Orden" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
										</div>
									</td>
								</tr>';
							}
							foreach ($arrInsumos as $tipo) {
								$html .= '
								<tr class="odd">
									<td>Insumos</td>
									<td>'.$tipo['Proveedor'].'</td>
									<td>'.$tipo['Documento'].' '.n_doc($tipo['N_Doc'], 8).' <strong>('.valores($tipo['ValorTotal'], 0).'-C/IVA)</strong> </td>
									<td>'.Fecha_estandar($tipo['Creacion_fecha']).'</td>
									<td>'.Fecha_estandar($tipo['F_Pago']).'</td>
									<td>'.$tipo['Estado'].'</td>
									<td>
										<div class="btn-group" style="width: 35px;" >
											<a href="view_mov_insumos.php?view='.simpleEncode($tipo['idFacturacion'], fecha_actual()).'" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
										</div>
									</td>
								</tr>';
							}
							foreach ($arrProductos as $tipo) {
								$html .= '
								<tr class="odd">
									<td>Materiales</td>
									<td>'.$tipo['Proveedor'].'</td>
									<td>'.$tipo['Documento'].' '.n_doc($tipo['N_Doc'], 8).' <strong>('.valores($tipo['ValorTotal'], 0).'-C/IVA)</strong> </td>
									<td>'.Fecha_estandar($tipo['Creacion_fecha']).'</td>
									<td>'.Fecha_estandar($tipo['F_Pago']).'</td>
									<td>'.$tipo['Estado'].'</td>
									<td>
										<div class="btn-group" style="width: 35px;" >
											<a href="view_mov_productos.php?view='.simpleEncode($tipo['idFacturacion'], fecha_actual()).'" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
										</div>
									</td>
								</tr>';
							}
							foreach ($arrArriendos as $tipo) {
								$html .= '
								<tr class="odd">
									<td>Arriendos</td>
									<td>'.$tipo['Proveedor'].'</td>
									<td>'.$tipo['Documento'].' '.n_doc($tipo['N_Doc'], 8).' <strong>('.valores($tipo['ValorTotal'], 0).'-C/IVA)</strong> </td>
									<td>'.Fecha_estandar($tipo['Creacion_fecha']).'</td>
									<td>'.Fecha_estandar($tipo['F_Pago']).'</td>
									<td>'.$tipo['Estado'].'</td>
									<td>
										<div class="btn-group" style="width: 35px;" >
											<a href="view_mov_arriendos.php?view='.simpleEncode($tipo['idFacturacion'], fecha_actual()).'" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
										</div>
									</td>
								</tr>';
							}
							foreach ($arrServicios as $tipo) {
								$html .= '
								<tr class="odd">
									<td>Servicios</td>
									<td>'.$tipo['Proveedor'].'</td>
									<td>'.$tipo['Documento'].' '.n_doc($tipo['N_Doc'], 8).' <strong>('.valores($tipo['ValorTotal'], 0).'-C/IVA)</strong> </td>
									<td>'.Fecha_estandar($tipo['Creacion_fecha']).'</td>
									<td>'.Fecha_estandar($tipo['F_Pago']).'</td>
									<td>'.$tipo['Estado'].'</td>
									<td>
										<div class="btn-group" style="width: 35px;" >
											<a href="view_mov_servicios.php?view='.simpleEncode($tipo['idFacturacion'], fecha_actual()).'" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
										</div>
									</td>
								</tr>';
							}
							$html .= '
					</tbody>
				</table>
			</div>
		</div>
	</div>
	';
	return $html;
}
/*******************************************************************************************************************/
//Muestra la gestion de flota
function widget_Gestion_Flota($titulo,$idSistema, $IDGoogle, $idTipoUsuario, $idUsuario, $SegActual, $dbConn){

	//Si no existe una ID se utiliza una por defecto
	if(!isset($IDGoogle) OR $IDGoogle==''){
		return alert_post_data(4,1,1,0, 'No ha ingresado Una API de Google Maps');
	}else{

		//variables
		$HoraSistema    = hora_actual();
		$FechaSistema   = fecha_actual();
		$eq_alertas     = 0;
		$eq_fueralinea  = 0;
		$eq_fueraruta   = 0;
		$eq_detenidos   = 0;
		$eq_gps_fuera   = 0;
		$eq_ok          = 0;

		$google = $IDGoogle;

		//enlace para redireccionar
		$enlace  = "?dd=true";
		$enlace .= "&idTipoUsuario=".$idTipoUsuario;
		$enlace .= "&idSistema=".$idSistema;
		$enlace .= "&idUsuario=".$idUsuario;

		//Variable
		$SIS_where = "telemetria_listado.idEstado = 1 ";//solo equipos activos
		//solo los equipos que tengan el seguimiento activado
		$SIS_where .= " AND telemetria_listado.id_Geo = 1";
		//Filtro el sistema al cual pertenece
		if(isset($idSistema)&&$idSistema!=''&&$idSistema!=0){
			$SIS_where .= " AND telemetria_listado.idSistema = ".$idSistema;
		}
		//Verifico el tipo de usuario que esta ingresando y el id
		$SIS_join  = '';
		if(isset($idTipoUsuario, $idUsuario)&&$idTipoUsuario!=1&&$idUsuario!=0){
			$SIS_join  .= ' INNER JOIN usuarios_equipos_telemetria ON usuarios_equipos_telemetria.idTelemetria = telemetria_listado.idTelemetria ';
			$SIS_where .= ' AND usuarios_equipos_telemetria.idUsuario = '.$idUsuario;
		}

		//numero sensores equipo
		$N_Maximo_Sensores = 60;
		$subquery = '';
		for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
			$subquery .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$i;
			$subquery .= ',telemetria_listado_sensores_med_actual.SensoresMedActual_'.$i;
			$subquery .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i;
			$subquery .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$i;
		}

		/*************************************************************/
		//Se consulta
		$SIS_query = '
		telemetria_listado.Nombre,
		telemetria_listado.LastUpdateFecha,
		telemetria_listado.LastUpdateHora,
		telemetria_listado.cantSensores,
		telemetria_listado.GeoLatitud,
		telemetria_listado.GeoLongitud,
		telemetria_listado.NDetenciones,
		telemetria_listado.TiempoFueraLinea,
		telemetria_listado.GeoErrores,
		telemetria_listado.NErrores,
		telemetria_listado.GeoVelocidad,
		telemetria_listado.Patente,
		telemetria_listado.id_Sensores'.$subquery;
		$SIS_join .= '
		LEFT JOIN `telemetria_listado_sensores_nombre`          ON telemetria_listado_sensores_nombre.idTelemetria         = telemetria_listado.idTelemetria
		LEFT JOIN `telemetria_listado_sensores_med_actual`      ON telemetria_listado_sensores_med_actual.idTelemetria     = telemetria_listado.idTelemetria
		LEFT JOIN `telemetria_listado_sensores_unimed`          ON telemetria_listado_sensores_unimed.idTelemetria         = telemetria_listado.idTelemetria
		LEFT JOIN `telemetria_listado_sensores_activo`          ON telemetria_listado_sensores_activo.idTelemetria         = telemetria_listado.idTelemetria';
		$SIS_order = 'telemetria_listado.Nombre ASC';
		$arrEquipo = array();
		$arrEquipo = db_select_array (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrEquipo');

		/*************************************************************/
		//Se traen todas las unidades de medida
		$arrUnimed = array();
		$arrUnimed = db_select_array (false, 'idUniMed,Nombre', 'telemetria_listado_unidad_medida', '', '', 'idUniMed ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrUnimed');

		//Ordeno las unidades de medida
		$arrFinalUnimed = array();
		foreach ($arrUnimed as $data) {
			$arrFinalUnimed[$data['idUniMed']] = $data['Nombre'];
		}

		/*************************************************************/
		//se traen todas las zonas
		$arrZonas = array();
		$arrZonas = db_select_array (false, ' idZona, Nombre', 'vehiculos_zonas', '', '', 'idZona ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrUnimed');

		//defino la variable temporal de la zona
		$_SESSION['usuario']['zona']['idZona']         = 9999;
		$_SESSION['usuario']['zona']['id_Geo']         = 1;
		$_SESSION['usuario']['zona']['idTipoUsuario']  = $idTipoUsuario;
		$_SESSION['usuario']['zona']['idSistema']      = $idSistema;
		$_SESSION['usuario']['zona']['idUsuario']      = $idUsuario;




		$GPS = '
		<script async src="https://maps.googleapis.com/maps/api/js?key='.$google.'&callback=initMap"></script>

		<div class="row"
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="box">
					<header>
						<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>'.$titulo.'</h5>
					</header>
					<div class="table-responsive">
						<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
							<div class="row">
								<div id="vehiContent" class="table-wrapper-scroll-y my-custom-scrollbar">
									<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
										<thead>
											<tr role="row">
												<th colspan="3">
													<div class="field">
														<select name="selectZona" id="selectZona" class="form-control" onchange="chngZona()" >';
															//La opción todos
															$GPS .= '<option value="9999" selected="selected" >Todas las Zonas</option>';
															foreach ( $arrZonas as $select ) {
																$GPS .= '<option value="'.$select['idZona'].'" >'.$select['Nombre'].'</option>';
															}
														$GPS .= '
														</select>
													</div>
												</th>
											</tr>';
											$GPS .= widget_sherlock(1, 3, 'TableFiltered');
											$GPS .= '
										</thead>
										<tbody role="alert" aria-live="polite" aria-relevant="all" id="TableFiltered">';
											$nicon = 0;
											foreach ($arrEquipo as $data) {

												/**********************************************/
												//Se resetean
												$in_eq_alertas     = 0;
												$in_eq_fueralinea  = 0;
												$in_eq_fueraruta   = 0;
												$in_eq_detenidos   = 0;
												$in_eq_gps_fuera   = 0;
												$in_eq_ok          = 1;

												/**********************************************/
												//Fuera de linea
												$diaInicio   = $data['LastUpdateFecha'];
												$diaTermino  = $FechaSistema;
												$tiempo1     = $data['LastUpdateHora'];
												$tiempo2     = $HoraSistema;
												$Tiempo      = horas_transcurridas($diaInicio, $diaTermino, $tiempo1, $tiempo2);

												//Comparaciones de tiempo
												$Time_Tiempo     = horas2segundos($Tiempo);
												$Time_Tiempo_FL  = horas2segundos($data['TiempoFueraLinea']);
												$Time_Tiempo_Max = horas2segundos('48:00:00');
												$Time_Fake_Ini   = horas2segundos('23:59:50');
												$Time_Fake_Fin   = horas2segundos('24:00:00');
												//comparacion
												if(($Time_Tiempo<$Time_Fake_Ini OR $Time_Tiempo>$Time_Fake_Fin)&&(($Time_Tiempo>$Time_Tiempo_FL&&$Time_Tiempo_FL!=0) OR ($Time_Tiempo>$Time_Tiempo_Max&&$Time_Tiempo_FL==0))){
													$in_eq_fueralinea++;
												}

												/**********************************************/
												//GPS con problemas
												if(isset($data['GeoErrores'])&&$data['GeoErrores']>0){    $in_eq_gps_fuera++; }
												if(isset($data['GeoLatitud'])&&$data['GeoLatitud']==0){   $in_eq_gps_fuera++; }
												if(isset($data['GeoLongitud'])&&$data['GeoLongitud']==0){ $in_eq_gps_fuera++; }

												/**********************************************/
												//Equipos Errores
												if(isset($data['NErrores'])&&$data['NErrores']>0){ $in_eq_alertas++; }

												/**********************************************/
												//Equipos detenidos
												if(isset($data['NDetenciones'])&&$data['NDetenciones']>0){ $in_eq_detenidos++; }

												/*******************************************************/
												//rearmo
												if($in_eq_detenidos>0){  $in_eq_ok = 0;$in_eq_detenidos = 1;}
												if($in_eq_alertas>0){    $in_eq_ok = 0;$in_eq_alertas = 1;    $in_eq_detenidos = 0;}
												if($in_eq_fueraruta>0){  $in_eq_ok = 0;$in_eq_fueraruta = 1;  $in_eq_alertas = 0;   $in_eq_detenidos = 0;}
												if($in_eq_gps_fuera>0){  $in_eq_ok = 0;$in_eq_gps_fuera = 1;  $in_eq_fueraruta = 0; $in_eq_alertas = 0;    $in_eq_detenidos = 0;}
												if($in_eq_fueralinea>0){ $in_eq_ok = 0;$in_eq_fueralinea = 1; $in_eq_gps_fuera = 0; $in_eq_fueraruta = 0;  $in_eq_alertas = 0;  $in_eq_detenidos = 0;}

												/*******************************************************/
												//se guardan estados
												$danger = '';
												if($in_eq_detenidos>0){  $danger = '';    $dataex = '<a href="#" title="Equipo Detenido"           class="btn btn-success btn-sm tooltip"><i class="fa fa-car" aria-hidden="true"></i></a>';}
												if($in_eq_alertas>0){    $danger = 'warning';  $dataex = '<a href="#" title="Equipo con Alertas"        class="btn btn-warning btn-sm tooltip"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></a>';}
												if($in_eq_fueraruta>0){  $danger = 'warning';  $dataex = '<a href="#" title="Equipo fuera de ruta"      class="btn btn-warning btn-sm tooltip"><i class="fa fa-location-arrow" aria-hidden="true"></i></a>';}
												if($in_eq_gps_fuera>0){  $danger = 'info';     $dataex = '<a href="#" title="Equipo sin cobertura GPS"  class="btn btn-info btn-sm tooltip"><i class="fa fa-map-marker" aria-hidden="true"></i></a>';}
												if($in_eq_fueralinea>0){ $danger = 'danger';   $dataex = '<a href="#" title="Fuera de Linea"            class="btn btn-danger btn-sm tooltip"><i class="fa fa-chain-broken" aria-hidden="true"></i></a>';}

												/*******************************************************/
												//Se guardan los valores
												$eq_alertas     = $eq_alertas + $in_eq_alertas;
												$eq_fueralinea  = $eq_fueralinea + $in_eq_fueralinea;
												$eq_fueraruta   = $eq_fueraruta + $in_eq_fueraruta;
												$eq_detenidos   = $eq_detenidos + $in_eq_detenidos;
												$eq_gps_fuera   = $eq_gps_fuera + $in_eq_gps_fuera;
												$eq_ok          = $eq_ok + $in_eq_ok;

												/*******************************************************/
												//traspasan los estados
												if($in_eq_ok==1){
													$eq_ok_icon = '<a href="#" title="Sin Problemas" class="btn btn-success btn-sm tooltip"><i class="fa fa-check" aria-hidden="true"></i></a>';
												}else{
													$eq_ok_icon = $dataex;
												}
												$GPS .= '
												<tr class="odd '.$danger.'">
													<td width="10">
														<div class="btn-group" style="width: 35px;" >'.$eq_ok_icon.'</div>
													</td>
													<td>
														'.$data['Nombre'].'<br/>
														'.fecha_estandar($data['LastUpdateFecha']).' '.$data['LastUpdateHora'].'
													</td>
													<td width="10">
														<div class="btn-group" style="width: 35px;" >
															<button onclick="fncCenterMap(\''.$data['GeoLatitud'].'\', \''.$data['GeoLongitud'].'\', \''.$nicon.'\')" title="Ver Ubicación" class="btn btn-default btn-sm tooltip"><i class="fa fa-map-marker" aria-hidden="true"></i></button>
														</div>
													</td>
												</tr>';
												$nicon++;
											}
											$GPS .= '
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
							<div class="row">
								<div id="map_canvas" style="width: 100%; height: 550px;"></div>
								<div id="consulta"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<style>
			.my-custom-scrollbar {position: relative;height: 550px;overflow: auto;}
			.table-wrapper-scroll-y {display: block;}
		</style>

		<script>
			let map;
			var markers = [];
			//Ubicación de los distintos dispositivos
			var locations = [ ';
				foreach ( $arrEquipo as $data ) {
					//burbuja
					if(isset($data['Patente'])&&$data['Patente']!=''){$pate_nte = ' ('.$data['Patente'].')';}else{$pate_nte = '';}
					$explanation  = '<div class="iw-subTitle">Vehiculo: '.$data['Nombre'].$pate_nte.'</div>';
					$explanation .= '<p>Velocidad: '.Cantidades($data['GeoVelocidad'], 0).'<br/>';
					$explanation .= 'Actualizado: '.fecha_estandar($data['LastUpdateFecha']).' - '.$data['LastUpdateHora'].'</p>';
					//verifico si tiene sensores configurados
					if(isset($data['id_Sensores'])&&$data['id_Sensores']==1){
						$explanation .= '<div class="iw-subTitle">Sensores: </div><p>';
						for ($i = 1; $i <= $data['cantSensores']; $i++) {
							//verifico que sensor este activo
							if(isset($data['SensoresActivo_'.$i])&&$data['SensoresActivo_'.$i]==1){
								//Unidad medida
								if(isset($arrFinalUnimed[$data['SensoresUniMed_'.$i]])){
									$unimed = ' '.$arrFinalUnimed[$data['SensoresUniMed_'.$i]];
								}else{
									$unimed = '';
								}
								//cadena
								if(isset($data['SensoresMedActual_'.$i])&&$data['SensoresMedActual_'.$i]<99900){$xdata=Cantidades($data['SensoresMedActual_'.$i], 2).$unimed;}else{$xdata='Sin Datos';}
								$explanation .= $data['SensoresNombre_'.$i].' : '.$xdata.'<br/>';
							}
						}
						$explanation .= '</p>';
					}
					//se arma dato
					$GPS .= "[";
						$GPS .= $data['GeoLatitud'];
						$GPS .= ", ".$data['GeoLongitud'];
						$GPS .= ", '".$explanation."'";
					$GPS .= "], ";
				}
			$GPS .= '];

			async function initMap() {
				const { Map } = await google.maps.importLibrary("maps");

				var myLatlng = new google.maps.LatLng(-33.477271996598965, -70.65170304882815);

				var myOptions = {
					zoom: 12,
					center: myLatlng,
					mapTypeId: google.maps.MapTypeId.ROADMAP
				};

				map = new Map(document.getElementById("map_canvas"), myOptions);
				//ubicacion inicial
				setMarkers(map, locations, 1);
				//actualizacion de posicion
				transMarker(map, '.$SegActual.');

			}

			/* ************************************************************************** */
			function chngZona() {
				idZona = document.getElementById("selectZona").value;
				$(\'#vehiContent\').load(\'principal_update_zonaList_1.php?idZona=\' + idZona);
				setMarkers(map, locations, 1);
			}

			/* ************************************************************************** */
			function fncCenterMap(Latitud, Longitud, n_icon){
				latlon = new google.maps.LatLng(Latitud, Longitud);
				map.panTo(latlon);
				//volver todo a normal
				for (let i = 0; i < markers.length; i++) {
					markers[i].setIcon("'.DB_SITE_REPO.'/LIB_assets/img/map-icons/1_series_orange.png");
				}
				//colorear el seleccionado
				markers[n_icon].setIcon("'.DB_SITE_REPO.'/LIB_assets/img/map-icons/1_series_green.png");
			}

			/* ************************************************************************** */
			function setMarkers(map, locations, optc) {

				var marker, last_latitude, last_longitude;

				for (let i = 0; i < locations.length; i++) {

					//defino ubicacion y datos
					let latitude   = locations[i][0];
					let longitude  = locations[i][1];
					let data       = locations[i][2];

					//guardo las ultimas ubicaciones
					last_latitude   = locations[i][0];
					last_longitude  = locations[i][1];

					latlngset = new google.maps.LatLng(latitude, longitude);

					//se crea marcador
					var marker = new google.maps.Marker({
						map         : map,
						position    : latlngset,
						icon      	: "'.DB_SITE_REPO.'/LIB_assets/img/map-icons/1_series_orange.png"
					});
					markers.push(marker);

					//se define contenido
					var content = 	"<div id=\'iw-container\'>" +
									"<div class=\'iw-title\'>Datos</div>" +
									"<div class=\'iw-content\'>" +
									data +
									"</div>" +
									"<div class=\'iw-bottom-gradient\'></div>" +
									"</div>";

					//se crea infowindow
					var infowindow = new google.maps.InfoWindow();

					//se agrega funcion de click a infowindow
					google.maps.event.addListener(marker,\'click\', (function(marker,content,infowindow){
						return function() {
							infowindow.setContent(content);
							infowindow.open(map,marker);
						};
					})(marker,content,infowindow));

				}
				if(optc==1){
					latlon = new google.maps.LatLng(last_latitude, last_longitude);
					map.panTo(latlon);
				}
			}
			/* ************************************************************************** */
			function transMarker(map, time) {
				var newTime = time / 2;
				setInterval(function(){transMarkerTimer(map)},newTime);
			}
			/* ************************************************************************** */
			var mapax = 0;
			function transMarkerTimer(map) {

				switch(mapax) {
					//Ejecutar formulario con el recorrido y la ruta
					case 1:
						$(\'#consulta\').load(\'principal_update_map_zona_1.php'.$enlace.'\');
						$(\'#vehiContent\').load(\'principal_update_zonaList_1.php\');
						break;
					//se dibujan los iconos
					case 2:
						//Se ocultan y eliminan los iconos
						deleteMarkers();
						setMarkers(map, new_locations, 2);
						//actualizo la hora de actualizacion
						document.getElementById(\'update_text_HoraRefresco\').innerHTML=\'Hora Refresco: \'+HoraRefresco;

						break;
				}

				mapax++;
				if(mapax==3){mapax=1}
			}
			/* ************************************************************************** */
			// Sets the map on all markers in the array.
			function setMapOnAll(map) {
				for (let i = 0; i < markers.length; i++) {
				markers[i].setMap(map);
				}
			}
			/* ************************************************************************** */
			// Removes the markers from the map, but keeps them in the array.
			function clearMarkers() {
				setMapOnAll(null);
			}
			/* ************************************************************************** */
			// Shows any markers currently in the array.
			function showMarkers() {
				setMapOnAll(map);
			}
			/* ************************************************************************** */
			// Deletes all markers in the array by removing references to them.
			function deleteMarkers() {
				clearMarkers();
				markers = [];
			}
		</script>';

			$GPS .= '<div class="row">';
				$GPS .= widget_Ficha_2('box-yellow', 'fa-truck faa-float animated', $eq_alertas, 4, 'Vehiculos con alertas', 'Equipos', 'principal_gps_view.php?seguimiento='.simpleEncode( 1, fecha_actual()).'&idSistema='.simpleEncode($idSistema, fecha_actual()).'&dataType='.simpleEncode( 1, fecha_actual()), 'Ver Mas', 'btn-warning', 1, 2);
				$GPS .= widget_Ficha_2('box-red', 'fa-truck faa-float animated', $eq_fueralinea, 4, 'Vehiculos fuera de linea', 'Equipos', 'principal_gps_view.php?seguimiento='.simpleEncode( 1, fecha_actual()).'&idSistema='.simpleEncode($idSistema, fecha_actual()).'&dataType='.simpleEncode( 2, fecha_actual()), 'Ver Mas', 'btn-danger', 1, 2);
				$GPS .= widget_Ficha_2('box-orange', 'fa-truck faa-float animated', $eq_fueraruta, 4, 'Vehiculos fuera de ruta', 'Equipos', 'principal_gps_view.php?seguimiento='.simpleEncode( 1, fecha_actual()).'&idSistema='.simpleEncode($idSistema, fecha_actual()).'&dataType='.simpleEncode( 3, fecha_actual()), 'Ver Mas', 'btn-warning', 1, 2);
				$GPS .= widget_Ficha_2('box-purple', 'fa-truck faa-float animated', $eq_gps_fuera, 4, 'Vehiculos sin cobertura GPS', 'Equipos', 'principal_gps_view.php?seguimiento='.simpleEncode( 1, fecha_actual()).'&idSistema='.simpleEncode($idSistema, fecha_actual()).'&dataType='.simpleEncode( 5, fecha_actual()), 'Ver Mas', 'btn-primary', 1, 2);
				$GPS .= widget_Ficha_2('box-green', 'fa-truck faa-float animated', ($eq_ok+$eq_detenidos), 4, 'Vehiculos OK', 'Equipos', 'principal_gps_view.php?seguimiento='.simpleEncode( 1, fecha_actual()).'&idSistema='.simpleEncode($idSistema, fecha_actual()).'&dataType='.simpleEncode( 4, fecha_actual()), 'Ver Mas', 'btn-success', 1, 2);

			$GPS .= '</div>';

		return $GPS;

	}
}
/*******************************************************************************************************************/
//Muestra la gestion de equipos
function widget_Gestion_Equipos($titulo,$idSistema, $IDGoogle, $idTipoUsuario, $idUsuario, $SegActual, $dbConn){

	//Si no existe una ID se utiliza una por defecto
	if(!isset($IDGoogle) OR $IDGoogle==''){
		return alert_post_data(4,1,1,0, 'No ha ingresado Una API de Google Maps');
	}else{

		//variables
		$HoraSistema    = hora_actual();
		$FechaSistema   = fecha_actual();
		$eq_alertas     = 0;
		$eq_fueralinea  = 0;
		$eq_ok          = 0;

		$google = $IDGoogle;

		//enlace para redireccionar
		$enlace  = "?dd=true";
		$enlace .= "&idTipoUsuario=".$idTipoUsuario;
		$enlace .= "&idSistema=".$idSistema;
		$enlace .= "&idUsuario=".$idUsuario;

		//Variable
		$SIS_where = "telemetria_listado.idEstado = 1 ";//solo equipos activos
		//solo los equipos que tengan el seguimiento desactivado
		$SIS_where .= " AND telemetria_listado.id_Geo = 2";
		//Filtro el sistema al cual pertenece
		if(isset($idSistema)&&$idSistema!=''&&$idSistema!=0){
			$SIS_where .= " AND telemetria_listado.idSistema = ".$idSistema;
		}
		//Verifico el tipo de usuario que esta ingresando y el id
		$SIS_join  = '';
		if(isset($idTipoUsuario, $idUsuario)&&$idTipoUsuario!=1&&$idUsuario!=0){
			$SIS_join  .= ' INNER JOIN usuarios_equipos_telemetria ON usuarios_equipos_telemetria.idTelemetria = telemetria_listado.idTelemetria ';
			$SIS_where .= ' AND usuarios_equipos_telemetria.idUsuario = '.$idUsuario;
		}

		//numero sensores equipo
		$N_Maximo_Sensores = 60;
		$subquery = '';
		for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
			$subquery .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$i;
			$subquery .= ',telemetria_listado_sensores_med_actual.SensoresMedActual_'.$i;
			$subquery .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i;
			$subquery .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$i;
		}

		/*************************************************************/
		//Se consulta
		$SIS_query = '
		telemetria_listado.Nombre,
		telemetria_listado.LastUpdateFecha,
		telemetria_listado.LastUpdateHora,
		telemetria_listado.cantSensores,
		telemetria_listado.GeoLatitud,
		telemetria_listado.GeoLongitud,
		telemetria_listado.TiempoFueraLinea,
		telemetria_listado.NErrores,
		telemetria_listado.id_Sensores'.$subquery;
		$SIS_join .= '
		LEFT JOIN `telemetria_listado_sensores_nombre`          ON telemetria_listado_sensores_nombre.idTelemetria         = telemetria_listado.idTelemetria
		LEFT JOIN `telemetria_listado_sensores_med_actual`      ON telemetria_listado_sensores_med_actual.idTelemetria     = telemetria_listado.idTelemetria
		LEFT JOIN `telemetria_listado_sensores_unimed`          ON telemetria_listado_sensores_unimed.idTelemetria         = telemetria_listado.idTelemetria
		LEFT JOIN `telemetria_listado_sensores_activo`          ON telemetria_listado_sensores_activo.idTelemetria         = telemetria_listado.idTelemetria';
		$SIS_order = 'telemetria_listado.Nombre ASC';
		$arrEquipo = array();
		$arrEquipo = db_select_array (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrEquipo');

		/*************************************************************/
		//Se traen todas las unidades de medida
		$arrUnimed = array();
		$arrUnimed = db_select_array (false, 'idUniMed,Nombre', 'telemetria_listado_unidad_medida', '', '', 'idUniMed ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrUnimed');

		//Ordeno las unidades de medida
		$arrFinalUnimed = array();
		foreach ($arrUnimed as $data) {
			$arrFinalUnimed[$data['idUniMed']] = $data['Nombre'];
		}

		/*************************************************************/
		//se traen todas las zonas
		$arrZonas = array();
		$arrZonas = db_select_array (false, ' idZona, Nombre', 'telemetria_zonas', '', '', 'idZona ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrUnimed');

		//defino la variable temporal de la zona
		$_SESSION['usuario']['zona']['idZona']         = 9999;
		$_SESSION['usuario']['zona']['id_Geo']         = 2;
		$_SESSION['usuario']['zona']['idTipoUsuario']  = $idTipoUsuario;
		$_SESSION['usuario']['zona']['idSistema']      = $idSistema;
		$_SESSION['usuario']['zona']['idUsuario']      = $idUsuario;


		$GPS = '
		<script async src="https://maps.googleapis.com/maps/api/js?key='.$google.'&callback=initMap"></script>

		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="box">
					<header>
						<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>'.$titulo.'</h5>
					</header>
					<div class="table-responsive">
						<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
							<div class="row">
								<div id="vehiContent" class="table-wrapper-scroll-y my-custom-scrollbar">
									<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
										<thead>
											<tr role="row">
												<th colspan="3">
													<div class="field">
														<select name="selectZona" id="selectZona" class="form-control" onchange="chngZona()" >';
															//La opción todos
															$GPS .= '<option value="9999" selected="selected" >Todas las Zonas</option>';
															foreach ( $arrZonas as $select ) {
																$GPS .= '<option value="'.$select['idZona'].'" >'.$select['Nombre'].'</option>';
															}
														$GPS .= '
														</select>
													</div>
												</th>
											</tr>';
											$GPS .= widget_sherlock(1, 3, 'TableFiltered');
											$GPS .= '
										</thead>
										<tbody role="alert" aria-live="polite" aria-relevant="all" id="TableFiltered">';
											$nicon = 0;
											foreach ($arrEquipo as $data) {

												/**********************************************/
												//Se resetean
												$in_eq_alertas     = 0;
												$in_eq_fueralinea  = 0;
												$in_eq_ok          = 1;

												/**********************************************/
												//Fuera de linea
												$diaInicio   = $data['LastUpdateFecha'];
												$diaTermino  = $FechaSistema;
												$tiempo1     = $data['LastUpdateHora'];
												$tiempo2     = $HoraSistema;
												$Tiempo      = horas_transcurridas($diaInicio, $diaTermino, $tiempo1, $tiempo2);

												//Comparaciones de tiempo
												$Time_Tiempo     = horas2segundos($Tiempo);
												$Time_Tiempo_FL  = horas2segundos($data['TiempoFueraLinea']);
												$Time_Tiempo_Max = horas2segundos('48:00:00');
												$Time_Fake_Ini   = horas2segundos('23:59:50');
												$Time_Fake_Fin   = horas2segundos('24:00:00');
												//comparacion
												if(($Time_Tiempo<$Time_Fake_Ini OR $Time_Tiempo>$Time_Fake_Fin)&&(($Time_Tiempo>$Time_Tiempo_FL&&$Time_Tiempo_FL!=0) OR ($Time_Tiempo>$Time_Tiempo_Max&&$Time_Tiempo_FL==0))){
													$in_eq_fueralinea++;
												}

												/**********************************************/
												//Equipos Errores
												if(isset($data['NErrores'])&&$data['NErrores']>0){ $in_eq_alertas++; }

												/*******************************************************/
												//rearmo
												if($in_eq_alertas>0){    $in_eq_ok = 0;$in_eq_alertas = 1;    }
												if($in_eq_fueralinea>0){ $in_eq_ok = 0;$in_eq_fueralinea = 1; $in_eq_alertas = 0;  }

												/*******************************************************/
												//se guardan estados
												$danger = '';
												if($in_eq_alertas>0){    $danger = 'warning';  $dataex = '<a href="#" title="Equipo con Alertas"        class="btn btn-warning btn-sm tooltip"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></a>';}
												if($in_eq_fueralinea>0){ $danger = 'danger';   $dataex = '<a href="#" title="Fuera de Linea"            class="btn btn-danger btn-sm tooltip"><i class="fa fa-chain-broken" aria-hidden="true"></i></a>';}

												/*******************************************************/
												//Se guardan los valores
												$eq_alertas     = $eq_alertas + $in_eq_alertas;
												$eq_fueralinea  = $eq_fueralinea + $in_eq_fueralinea;
												$eq_ok          = $eq_ok + $in_eq_ok;

												/*******************************************************/
												//traspasan los estados
												if($in_eq_ok==1){
													$eq_ok_icon = '<a href="#" title="Sin Problemas" class="btn btn-success btn-sm tooltip"><i class="fa fa-check" aria-hidden="true"></i></a>';
												}else{
													$eq_ok_icon = $dataex;
												}
												$GPS .= '
												<tr class="odd '.$danger.'">
													<td width="10">
														<div class="btn-group" style="width: 35px;" >'.$eq_ok_icon.'</div>
													</td>
													<td>
														'.$data['Nombre'].'<br/>
														'.fecha_estandar($data['LastUpdateFecha']).' '.$data['LastUpdateHora'].'
													</td>
													<td width="10">
														<div class="btn-group" style="width: 35px;" >
															<button onclick="fncCenterMap(\''.$data['GeoLatitud'].'\', \''.$data['GeoLongitud'].'\', \''.$nicon.'\')" title="Ver Ubicación" class="btn btn-default btn-sm tooltip"><i class="fa fa-map-marker" aria-hidden="true"></i></button>
														</div>
													</td>
												</tr>';
												$nicon++;
											}
											$GPS .= '
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
							<div class="row">
								<div id="map_canvas" style="width: 100%; height: 550px;"></div>
								<div id="consulta"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<style>
		.my-custom-scrollbar {
			position: relative;
			height: 550px;
			overflow: auto;
		}
		.table-wrapper-scroll-y {
			display: block;
		}
		</style>

		<script>
			let map;
			var markers = [];
			//Ubicación de los distintos dispositivos
			var locations = [ ';
				foreach ( $arrEquipo as $data ) {
					//burbuja
					$explanation  = '<div class="iw-subTitle">Equipo: '.$data['Nombre'].'</div>';
					$explanation .= 'Actualizado: '.fecha_estandar($data['LastUpdateFecha']).' - '.$data['LastUpdateHora'].'</p>';
					//verifico si tiene sensores configurados
					if(isset($data['id_Sensores'])&&$data['id_Sensores']==1){
						$explanation .= '<div class="iw-subTitle">Sensores: </div><p>';
						for ($i = 1; $i <= $data['cantSensores']; $i++) {
							//verifico que sensor este activo
							if(isset($data['SensoresActivo_'.$i])&&$data['SensoresActivo_'.$i]==1){
								//Unidad medida
								if(isset($arrFinalUnimed[$data['SensoresUniMed_'.$i]])){
									$unimed = ' '.$arrFinalUnimed[$data['SensoresUniMed_'.$i]];
								}else{
									$unimed = '';
								}
								//cadena
								if(isset($data['SensoresMedActual_'.$i])&&$data['SensoresMedActual_'.$i]<99900){$xdata=Cantidades($data['SensoresMedActual_'.$i], 2).$unimed;}else{$xdata='Sin Datos';}
								$explanation .= $data['SensoresNombre_'.$i].' : '.$xdata.'<br/>';
							}
						}
						$explanation .= '</p>';
					}
					//se arma dato
					$GPS .= "[";
						$GPS .= $data['GeoLatitud'];
						$GPS .= ", ".$data['GeoLongitud'];
						$GPS .= ", '".$explanation."'";
					$GPS .= "], ";
				}
			$GPS .= '];

			async function initMap() {
				const { Map } = await google.maps.importLibrary("maps");

				var myLatlng = new google.maps.LatLng(-33.477271996598965, -70.65170304882815);

				var myOptions = {
					zoom: 12,
					center: myLatlng,
					mapTypeId: google.maps.MapTypeId.ROADMAP
				};

				map = new Map(document.getElementById("map_canvas"), myOptions);

				//ubicacion inicial
				setMarkers(map, locations, 1);
				//actualizacion de posicion
				transMarker(map, '.$SegActual.');

			}

			/* ************************************************************************** */
			function chngZona() {
				idZona = document.getElementById("selectZona").value;
				$(\'#vehiContent\').load(\'principal_update_zonaList_2.php?idZona=\' + idZona);
				setMarkers(map, locations, 1);
			}

			/* ************************************************************************** */
			function fncCenterMap(Latitud, Longitud, n_icon){
				latlon = new google.maps.LatLng(Latitud, Longitud);
				map.panTo(latlon);
				//volver todo a normal
				for (let i = 0; i < markers.length; i++) {
					markers[i].setIcon("'.DB_SITE_REPO.'/LIB_assets/img/map-icons/1_series_orange.png");
				}
				//colorear el seleccionado
				markers[n_icon].setIcon("'.DB_SITE_REPO.'/LIB_assets/img/map-icons/1_series_green.png");
			}

			/* ************************************************************************** */
			function setMarkers(map, locations, optc) {

				var marker, i, last_latitude, last_longitude;

				for (i = 0; i < locations.length; i++) {

					//defino ubicacion y datos
					let latitude   = locations[i][0];
					let longitude  = locations[i][1];
					let data       = locations[i][2];

					//guardo las ultimas ubicaciones
					last_latitude   = locations[i][0];
					last_longitude  = locations[i][1];

					latlngset = new google.maps.LatLng(latitude, longitude);

					//se crea marcador
					var marker = new google.maps.Marker({
						map         : map,
						position    : latlngset,
						icon      	: "'.DB_SITE_REPO.'/LIB_assets/img/map-icons/1_series_orange.png"
					});
					markers.push(marker);

					//se define contenido
					var content = 	"<div id=\'iw-container\'>" +
									"<div class=\'iw-title\'>Datos</div>" +
									"<div class=\'iw-content\'>" +
									data +
									"</div>" +
									"<div class=\'iw-bottom-gradient\'></div>" +
									"</div>";

					//se crea infowindow
					var infowindow = new google.maps.InfoWindow();

					//se agrega funcion de click a infowindow
					google.maps.event.addListener(marker,\'click\', (function(marker,content,infowindow){
						return function() {
							infowindow.setContent(content);
							infowindow.open(map,marker);
						};
					})(marker,content,infowindow));

				}
				if(optc==1){
					latlon = new google.maps.LatLng(last_latitude, last_longitude);
					map.panTo(latlon);
				}
			}
			/* ************************************************************************** */
			function transMarker(map, time) {
				var newTime = time / 2;
				setInterval(function(){transMarkerTimer(map)},newTime);
			}
			/* ************************************************************************** */
			var mapax = 0;
			function transMarkerTimer(map) {

				switch(mapax) {
					//Ejecutar formulario con el recorrido y la ruta
					case 1:
						$(\'#consulta\').load(\'principal_update_map_zona_2.php'.$enlace.'\');
						$(\'#vehiContent\').load(\'principal_update_zonaList_2.php\');
						break;
					//se dibujan los iconos
					case 2:
						//Se ocultan y eliminan los iconos
						deleteMarkers();
						setMarkers(map, new_locations, 2);
						//actualizo la hora de actualizacion
						document.getElementById(\'update_text_HoraRefresco\').innerHTML=\'Hora Refresco: \'+HoraRefresco;

						break;
				}

				mapax++;
				if(mapax==3){mapax=1}
			}
			/* ************************************************************************** */
			// Sets the map on all markers in the array.
			function setMapOnAll(map) {
				for (let i = 0; i < markers.length; i++) {
				markers[i].setMap(map);
				}
			}
			/* ************************************************************************** */
			// Removes the markers from the map, but keeps them in the array.
			function clearMarkers() {
				setMapOnAll(null);
			}
			/* ************************************************************************** */
			// Shows any markers currently in the array.
			function showMarkers() {
				setMapOnAll(map);
			}
			/* ************************************************************************** */
			// Deletes all markers in the array by removing references to them.
			function deleteMarkers() {
				clearMarkers();
				markers = [];
			}
		</script>

		';


			$GPS .= '<div class="row">';
				$GPS .= widget_Ficha_2('box-yellow', 'fa-industry', $eq_alertas, 4, 'Equipos con alertas', 'Sensores', 'principal_gps_view.php?seguimiento='.simpleEncode( 2, fecha_actual()).'&idSistema='.simpleEncode($idSistema, fecha_actual()).'&dataType='.simpleEncode( 1, fecha_actual()), 'Ver Mas', 'btn-warning', 1, 2);
				$GPS .= widget_Ficha_2('box-red', 'fa-industry', $eq_fueralinea, 4, 'Equipos fuera de linea', 'Equipos', 'principal_gps_view.php?seguimiento='.simpleEncode( 2, fecha_actual()).'&idSistema='.simpleEncode($idSistema, fecha_actual()).'&dataType='.simpleEncode( 2, fecha_actual()), 'Ver Mas', 'btn-danger', 1, 2);
				$GPS .= widget_Ficha_2('box-blue', 'fa-industry', $eq_ok, 4, 'Equipos OK', 'Equipos', 'principal_gps_view.php?seguimiento='.simpleEncode( 2, fecha_actual()).'&idSistema='.simpleEncode($idSistema, fecha_actual()).'&dataType='.simpleEncode( 4, fecha_actual()), 'Ver Mas', 'btn-primary', 1, 2);
			$GPS .= '</div>';

		return $GPS;


	}
}
/*******************************************************************************************************************/
//Muestra la gestion de equipos cross
function widget_Gestion_Flota_Cross($titulo,$idSistema, $IDGoogle, $idTipoUsuario, $idUsuario, $SegActual, $dbConn){

	//Si no existe una ID se utiliza una por defecto
	if(!isset($IDGoogle) OR $IDGoogle==''){
		return alert_post_data(4,1,1,0, 'No ha ingresado Una API de Google Maps');
	}else{

		//variables
		$HoraSistema    = hora_actual();
		$FechaSistema   = fecha_actual();
		$eq_alertas     = 0;
		$eq_fueralinea  = 0;
		$eq_fueraruta   = 0;
		$eq_detenidos   = 0;
		$eq_gps_fuera   = 0;
		$eq_ok          = 0;

		$google = $IDGoogle;

		//enlace para redireccionar
		$enlace  = "?dd=true";
		$enlace .= "&idTipoUsuario=".$idTipoUsuario;
		$enlace .= "&idSistema=".$idSistema;
		$enlace .= "&idUsuario=".$idUsuario;

		//Variable
		$SIS_where = "telemetria_listado.idEstado = 1 ";//solo equipos activos
		//solo los equipos que tengan el seguimiento activado
		$SIS_where .= " AND telemetria_listado.id_Geo = 1";
		//Filtro el sistema al cual pertenece
		if(isset($idSistema)&&$idSistema!=''&&$idSistema!=0){
			$SIS_where .= " AND telemetria_listado.idSistema = ".$idSistema;
		}
		//Verifico el tipo de usuario que esta ingresando y el id
		$SIS_join  = '';
		if(isset($idTipoUsuario, $idUsuario)&&$idTipoUsuario!=1&&$idUsuario!=0){
			$SIS_join  .= ' INNER JOIN usuarios_equipos_telemetria ON usuarios_equipos_telemetria.idTelemetria = telemetria_listado.idTelemetria ';
			$SIS_where .= ' AND usuarios_equipos_telemetria.idUsuario = '.$idUsuario;
		}

		//numero sensores equipo
		$N_Maximo_Sensores = 60;
		$subquery = '';
		for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
			$subquery .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$i;
			$subquery .= ',telemetria_listado_sensores_med_actual.SensoresMedActual_'.$i;
			$subquery .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i;
			$subquery .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$i;
		}

		/*************************************************************/
		//Se consulta
		$SIS_query = '
		telemetria_listado.Nombre,
		telemetria_listado.LastUpdateFecha,
		telemetria_listado.LastUpdateHora,
		telemetria_listado.cantSensores,
		telemetria_listado.GeoLatitud,
		telemetria_listado.GeoLongitud,
		telemetria_listado.NDetenciones,
		telemetria_listado.TiempoFueraLinea,
		telemetria_listado.GeoErrores,
		telemetria_listado.NErrores,
		telemetria_listado.GeoVelocidad,
		telemetria_listado.Patente,
		telemetria_listado.id_Sensores'.$subquery;
		$SIS_join .= '
		LEFT JOIN `telemetria_listado_sensores_nombre`          ON telemetria_listado_sensores_nombre.idTelemetria         = telemetria_listado.idTelemetria
		LEFT JOIN `telemetria_listado_sensores_med_actual`      ON telemetria_listado_sensores_med_actual.idTelemetria     = telemetria_listado.idTelemetria
		LEFT JOIN `telemetria_listado_sensores_unimed`          ON telemetria_listado_sensores_unimed.idTelemetria         = telemetria_listado.idTelemetria
		LEFT JOIN `telemetria_listado_sensores_activo`          ON telemetria_listado_sensores_activo.idTelemetria         = telemetria_listado.idTelemetria';
		$SIS_order = 'telemetria_listado.Nombre ASC';
		$arrEquipo = array();
		$arrEquipo = db_select_array (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrEquipo');

		/*************************************************************/
		//Se traen todas las unidades de medida
		$arrUnimed = array();
		$arrUnimed = db_select_array (false, 'idUniMed,Nombre', 'telemetria_listado_unidad_medida', '', '', 'idUniMed ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrUnimed');

		//Ordeno las unidades de medida
		$arrFinalUnimed = array();
		foreach ($arrUnimed as $data) {
			$arrFinalUnimed[$data['idUniMed']] = $data['Nombre'];
		}

		/*************************************************************/
		//se traen todas las zonas
		$arrZonas = array();
		$arrZonas = db_select_array (false, ' idZona, Nombre', 'vehiculos_zonas', '', '', 'idZona ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrUnimed');

		//defino la variable temporal de la zona
		$_SESSION['usuario']['zona']['idZona']         = 9999;
		$_SESSION['usuario']['zona']['id_Geo']         = 1;
		$_SESSION['usuario']['zona']['idTipoUsuario']  = $idTipoUsuario;
		$_SESSION['usuario']['zona']['idSistema']      = $idSistema;
		$_SESSION['usuario']['zona']['idUsuario']      = $idUsuario;




		$GPS = '
		<script async src="https://maps.googleapis.com/maps/api/js?key='.$google.'&callback=initMap"></script>

		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="box">
					<header>
						<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>'.$titulo.'</h5>
					</header>
					<div class="table-responsive">
						<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
							<div class="row">
								<div id="vehiContent" class="table-wrapper-scroll-y my-custom-scrollbar">
									<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
										<thead>
											<tr role="row">
												<th colspan="3">
													<div class="field">
														<select name="selectZona" id="selectZona" class="form-control" onchange="chngZona()" >';
															//La opción todos
															$GPS .= '<option value="9999" selected="selected" >Todas las Zonas</option>';
															foreach ( $arrZonas as $select ) {
																$GPS .= '<option value="'.$select['idZona'].'" >'.$select['Nombre'].'</option>';
															}
														$GPS .= '
														</select>
													</div>
												</th>
											</tr>';
											$GPS .= widget_sherlock(1, 3, 'TableFiltered');
											$GPS .= '
										</thead>
										<tbody role="alert" aria-live="polite" aria-relevant="all" id="TableFiltered">';
											$nicon = 0;
											foreach ($arrEquipo as $data) {

												/**********************************************/
												//Se resetean
												$in_eq_alertas     = 0;
												$in_eq_fueralinea  = 0;
												$in_eq_fueraruta   = 0;
												$in_eq_detenidos   = 0;
												$in_eq_gps_fuera   = 0;
												$in_eq_ok          = 1;

												/**********************************************/
												//Fuera de linea
												$diaInicio   = $data['LastUpdateFecha'];
												$diaTermino  = $FechaSistema;
												$tiempo1     = $data['LastUpdateHora'];
												$tiempo2     = $HoraSistema;
												$Tiempo      = horas_transcurridas($diaInicio, $diaTermino, $tiempo1, $tiempo2);

												//Comparaciones de tiempo
												$Time_Tiempo     = horas2segundos($Tiempo);
												$Time_Tiempo_FL  = horas2segundos($data['TiempoFueraLinea']);
												$Time_Tiempo_Max = horas2segundos('48:00:00');
												$Time_Fake_Ini   = horas2segundos('23:59:50');
												$Time_Fake_Fin   = horas2segundos('24:00:00');
												//comparacion
												if(($Time_Tiempo<$Time_Fake_Ini OR $Time_Tiempo>$Time_Fake_Fin)&&(($Time_Tiempo>$Time_Tiempo_FL&&$Time_Tiempo_FL!=0) OR ($Time_Tiempo>$Time_Tiempo_Max&&$Time_Tiempo_FL==0))){
													$in_eq_fueralinea++;
												}

												/**********************************************/
												//GPS con problemas
												if(isset($data['GeoErrores'])&&$data['GeoErrores']>0){    $in_eq_gps_fuera++; }
												if(isset($data['GeoLatitud'])&&$data['GeoLatitud']==0){   $in_eq_gps_fuera++; }
												if(isset($data['GeoLongitud'])&&$data['GeoLongitud']==0){ $in_eq_gps_fuera++; }

												/**********************************************/
												//Equipos Errores
												if(isset($data['NErrores'])&&$data['NErrores']>0){ $in_eq_alertas++; }

												/**********************************************/
												//Equipos detenidos
												if(isset($data['NDetenciones'])&&$data['NDetenciones']>0){ $in_eq_detenidos++; }

												/*******************************************************/
												//rearmo
												if($in_eq_detenidos>0){  $in_eq_ok = 0;$in_eq_detenidos = 1;}
												if($in_eq_alertas>0){    $in_eq_ok = 0;$in_eq_alertas = 1;    $in_eq_detenidos = 0;}
												if($in_eq_fueraruta>0){  $in_eq_ok = 0;$in_eq_fueraruta = 1;  $in_eq_alertas = 0;   $in_eq_detenidos = 0;}
												if($in_eq_gps_fuera>0){  $in_eq_ok = 0;$in_eq_gps_fuera = 1;  $in_eq_fueraruta = 0; $in_eq_alertas = 0;    $in_eq_detenidos = 0;}
												if($in_eq_fueralinea>0){ $in_eq_ok = 0;$in_eq_fueralinea = 1; $in_eq_gps_fuera = 0; $in_eq_fueraruta = 0;  $in_eq_alertas = 0;  $in_eq_detenidos = 0;}

												/*******************************************************/
												//se guardan estados
												$danger = '';
												if($in_eq_detenidos>0){  $danger = '';    $dataex = '<a href="#" title="Equipo Detenido"           class="btn btn-success btn-sm tooltip"><i class="fa fa-car" aria-hidden="true"></i></a>';}
												if($in_eq_alertas>0){    $danger = 'warning';  $dataex = '<a href="#" title="Equipo con Alertas"        class="btn btn-warning btn-sm tooltip"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></a>';}
												if($in_eq_fueraruta>0){  $danger = 'warning';  $dataex = '<a href="#" title="Equipo fuera de ruta"      class="btn btn-warning btn-sm tooltip"><i class="fa fa-location-arrow" aria-hidden="true"></i></a>';}
												if($in_eq_gps_fuera>0){  $danger = 'info';     $dataex = '<a href="#" title="Equipo sin cobertura GPS"  class="btn btn-info btn-sm tooltip"><i class="fa fa-map-marker" aria-hidden="true"></i></a>';}
												if($in_eq_fueralinea>0){ $danger = 'danger';   $dataex = '<a href="#" title="Fuera de Linea"            class="btn btn-danger btn-sm tooltip"><i class="fa fa-chain-broken" aria-hidden="true"></i></a>';}

												/*******************************************************/
												//Se guardan los valores
												$eq_alertas     = $eq_alertas + $in_eq_alertas;
												$eq_fueralinea  = $eq_fueralinea + $in_eq_fueralinea;
												$eq_fueraruta   = $eq_fueraruta + $in_eq_fueraruta;
												$eq_detenidos   = $eq_detenidos + $in_eq_detenidos;
												$eq_gps_fuera   = $eq_gps_fuera + $in_eq_gps_fuera;
												$eq_ok          = $eq_ok + $in_eq_ok;

												/*******************************************************/
												//traspasan los estados
												if($in_eq_ok==1){
													$eq_ok_icon = '<a href="#" title="Sin Problemas" class="btn btn-success btn-sm tooltip"><i class="fa fa-check" aria-hidden="true"></i></a>';
												}else{
													$eq_ok_icon = $dataex;
												}
												$GPS .= '
												<tr class="odd '.$danger.'">
													<td width="10">
														<div class="btn-group" style="width: 35px;" >'.$eq_ok_icon.'</div>
													</td>
													<td>
														'.$data['Nombre'].'<br/>
														'.fecha_estandar($data['LastUpdateFecha']).' '.$data['LastUpdateHora'].'
													</td>
													<td width="10">
														<div class="btn-group" style="width: 35px;" >
															<button onclick="fncCenterMap(\''.$data['GeoLatitud'].'\', \''.$data['GeoLongitud'].'\', \''.$nicon.'\')" title="Ver Ubicación" class="btn btn-default btn-sm tooltip"><i class="fa fa-map-marker" aria-hidden="true"></i></button>
														</div>
													</td>
												</tr>';
												$nicon++;
											}
											$GPS .= '
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
							<div class="row">
								<div id="map_canvas" style="width: 100%; height: 550px;"></div>
								<div id="consulta"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<style>
		.my-custom-scrollbar {
			position: relative;
			height: 550px;
			overflow: auto;
		}
		.table-wrapper-scroll-y {
			display: block;
		}
		</style>

		<script>
			let map;
			var markers = [];
			//Ubicación de los distintos dispositivos
			var locations = [ ';
				foreach ( $arrEquipo as $data ) {
					//burbuja
					if(isset($data['Patente'])&&$data['Patente']!=''){$pate_nte = ' ('.$data['Patente'].')';}else{$pate_nte = '';}
					$explanation  = '<div class="iw-subTitle">Vehiculo: '.$data['Nombre'].$pate_nte.'</div>';
					$explanation .= '<p>Velocidad: '.Cantidades($data['GeoVelocidad'], 0).'<br/>';
					$explanation .= 'Actualizado: '.fecha_estandar($data['LastUpdateFecha']).' - '.$data['LastUpdateHora'].'</p>';
					//verifico si tiene sensores configurados
					if(isset($data['id_Sensores'])&&$data['id_Sensores']==1){
						$explanation .= '<div class="iw-subTitle">Sensores: </div><p>';
						for ($i = 1; $i <= $data['cantSensores']; $i++) {
							//verifico que sensor este activo
							if(isset($data['SensoresActivo_'.$i])&&$data['SensoresActivo_'.$i]==1){
								//Unidad medida
								if(isset($arrFinalUnimed[$data['SensoresUniMed_'.$i]])){
									$unimed = ' '.$arrFinalUnimed[$data['SensoresUniMed_'.$i]];
								}else{
									$unimed = '';
								}
								//cadena
								if(isset($data['SensoresMedActual_'.$i])&&$data['SensoresMedActual_'.$i]<99900){$xdata=Cantidades($data['SensoresMedActual_'.$i], 2).$unimed;}else{$xdata='Sin Datos';}
								$explanation .= $data['SensoresNombre_'.$i].' : '.$xdata.'<br/>';
							}
						}
						$explanation .= '</p>';
					}
					//se arma dato
					$GPS .= "[";
						$GPS .= $data['GeoLatitud'];
						$GPS .= ", ".$data['GeoLongitud'];
						$GPS .= ", '".$explanation."'";
					$GPS .= "], ";
				}
			$GPS .= '];

			async function initMap() {
				const { Map } = await google.maps.importLibrary("maps");

				var myLatlng = new google.maps.LatLng(-33.477271996598965, -70.65170304882815);

				var myOptions = {
					zoom: 12,
					center: myLatlng,
					mapTypeId: google.maps.MapTypeId.ROADMAP
				};

				map = new Map(document.getElementById("map_canvas"), myOptions);

				//ubicacion inicial
				setMarkers(map, locations, 1);
				//actualizacion de posicion
				transMarker(map, '.$SegActual.');

			}

			/* ************************************************************************** */
			function chngZona() {
				idZona = document.getElementById("selectZona").value;
				$(\'#vehiContent\').load(\'principal_update_zonaList_1_cross.php?idZona=\' + idZona);
				setMarkers(map, locations, 1);
			}

			/* ************************************************************************** */
			function fncCenterMap(Latitud, Longitud, n_icon){
				latlon = new google.maps.LatLng(Latitud, Longitud);
				map.panTo(latlon);
				//volver todo a normal
				for (let i = 0; i < markers.length; i++) {
					markers[i].setIcon("'.DB_SITE_REPO.'/LIB_assets/img/map-icons/1_series_orange.png");
				}
				//colorear el seleccionado
				markers[n_icon].setIcon("'.DB_SITE_REPO.'/LIB_assets/img/map-icons/1_series_green.png");
			}

			/* ************************************************************************** */
			function setMarkers(map, locations, optc) {

				var marker, i, last_latitude, last_longitude;

				for (i = 0; i < locations.length; i++) {

					//defino ubicacion y datos
					let latitude   = locations[i][0];
					let longitude  = locations[i][1];
					let data       = locations[i][2];

					//guardo las ultimas ubicaciones
					last_latitude   = locations[i][0];
					last_longitude  = locations[i][1];

					latlngset = new google.maps.LatLng(latitude, longitude);

					//se crea marcador
					var marker = new google.maps.Marker({
						map         : map,
						position    : latlngset,
						icon      	: "'.DB_SITE_REPO.'/LIB_assets/img/map-icons/1_series_orange.png"
					});
					markers.push(marker);

					//se define contenido
					var content = 	"<div id=\'iw-container\'>" +
									"<div class=\'iw-title\'>Datos</div>" +
									"<div class=\'iw-content\'>" +
									data +
									"</div>" +
									"<div class=\'iw-bottom-gradient\'></div>" +
									"</div>";

					//se crea infowindow
					var infowindow = new google.maps.InfoWindow();

					//se agrega funcion de click a infowindow
					google.maps.event.addListener(marker,\'click\', (function(marker,content,infowindow){
						return function() {
							infowindow.setContent(content);
							infowindow.open(map,marker);
						};
					})(marker,content,infowindow));

				}
				if(optc==1){
					latlon = new google.maps.LatLng(last_latitude, last_longitude);
					map.panTo(latlon);
				}
			}
			/* ************************************************************************** */
			function transMarker(map, time) {
				var newTime = time / 2;
				setInterval(function(){transMarkerTimer(map)},newTime);
			}
			/* ************************************************************************** */
			var mapax = 0;
			function transMarkerTimer(map) {

				switch(mapax) {
					//Ejecutar formulario con el recorrido y la ruta
					case 1:
						$(\'#consulta\').load(\'principal_update_map_zona_1_cross.php'.$enlace.'\');
						$(\'#vehiContent\').load(\'principal_update_zonaList_1_cross.php\');
						break;
					//se dibujan los iconos
					case 2:
						//Se ocultan y eliminan los iconos
						deleteMarkers();
						setMarkers(map, new_locations, 2);
						//actualizo la hora de actualizacion
						document.getElementById(\'update_text_HoraRefresco\').innerHTML=\'Hora Refresco: \'+HoraRefresco;

						break;
				}

				mapax++;
				if(mapax==3){mapax=1}
			}
			/* ************************************************************************** */
			// Sets the map on all markers in the array.
			function setMapOnAll(map) {
				for (let i = 0; i < markers.length; i++) {
				  markers[i].setMap(map);
				}
			}
			/* ************************************************************************** */
			// Removes the markers from the map, but keeps them in the array.
			function clearMarkers() {
				setMapOnAll(null);
			}
			/* ************************************************************************** */
			// Shows any markers currently in the array.
			function showMarkers() {
				setMapOnAll(map);
			}
			/* ************************************************************************** */
			// Deletes all markers in the array by removing references to them.
			function deleteMarkers() {
				clearMarkers();
				markers = [];
			}
		</script>';

			$GPS .= '<div class="row">';
				$GPS .= widget_Ficha_2('box-yellow', 'fa-truck faa-float animated', $eq_alertas, 4, 'Vehiculos con alertas', 'Equipos', 'principal_gps_view.php?seguimiento='.simpleEncode( 1, fecha_actual()).'&idSistema='.simpleEncode($idSistema, fecha_actual()).'&dataType='.simpleEncode( 1, fecha_actual()), 'Ver Mas', 'btn-warning', 1, 2);
				$GPS .= widget_Ficha_2('box-red', 'fa-truck faa-float animated', $eq_fueralinea, 4, 'Vehiculos fuera de linea', 'Equipos', 'principal_gps_view.php?seguimiento='.simpleEncode( 1, fecha_actual()).'&idSistema='.simpleEncode($idSistema, fecha_actual()).'&dataType='.simpleEncode( 2, fecha_actual()), 'Ver Mas', 'btn-danger', 1, 2);
				$GPS .= widget_Ficha_2('box-orange', 'fa-truck faa-float animated', $eq_fueraruta, 4, 'Vehiculos fuera de ruta', 'Equipos', 'principal_gps_view.php?seguimiento='.simpleEncode( 1, fecha_actual()).'&idSistema='.simpleEncode($idSistema, fecha_actual()).'&dataType='.simpleEncode( 3, fecha_actual()), 'Ver Mas', 'btn-warning', 1, 2);
				$GPS .= widget_Ficha_2('box-purple', 'fa-truck faa-float animated', $eq_gps_fuera, 4, 'Vehiculos sin cobertura GPS', 'Equipos', 'principal_gps_view.php?seguimiento='.simpleEncode( 1, fecha_actual()).'&idSistema='.simpleEncode($idSistema, fecha_actual()).'&dataType='.simpleEncode( 5, fecha_actual()), 'Ver Mas', 'btn-primary', 1, 2);
				$GPS .= widget_Ficha_2('box-green', 'fa-truck faa-float animated', ($eq_ok+$eq_detenidos), 4, 'Vehiculos OK', 'Equipos', 'principal_gps_view.php?seguimiento='.simpleEncode( 1, fecha_actual()).'&idSistema='.simpleEncode($idSistema, fecha_actual()).'&dataType='.simpleEncode( 4, fecha_actual()), 'Ver Mas', 'btn-success', 1, 2);
			$GPS .= '</div>';

		return $GPS;


	}
}
/*******************************************************************************************************************/
//Muestra la gestion de flota crosstech
function widget_Gestion_Flota_CrossTech($titulo, $idSistema, $IDGoogle, $idTipoUsuario, $idUsuario,
										$SegActual, $idTab, $miniwidget, $dbConn){

	//Si no existe una ID se utiliza una por defecto
	if(!isset($IDGoogle) OR $IDGoogle==''){
		return alert_post_data(4,1,1,0, 'No ha ingresado Una API de Google Maps');
	}else{

		//variables
		$HoraSistema    = hora_actual();
		$FechaSistema   = fecha_actual();
		$eq_alertas     = 0;
		$eq_fueralinea  = 0;
		$eq_fueraruta   = 0;
		$eq_detenidos   = 0;
		$eq_gps_fuera   = 0;
		$eq_ok          = 0;

		$google = $IDGoogle;

		//enlace para redireccionar
		$enlace  = "?dd=true";
		$enlace .= "&idTipoUsuario=".$idTipoUsuario;
		$enlace .= "&idSistema=".$idSistema;
		$enlace .= "&idUsuario=".$idUsuario;
		$enlace .= "&idTab=".$idTab;

		//Variable
		$SIS_where = "telemetria_listado.idEstado = 1 ";//solo equipos activos
		//solo los equipos que tengan el seguimiento activado
		$SIS_where .= " AND telemetria_listado.id_Geo = 1";
		//Filtro de los tab
		$SIS_where .= " AND telemetria_listado.idTab = ".$idTab;
		//Filtro el sistema al cual pertenece
		if(isset($idSistema)&&$idSistema!=''&&$idSistema!=0){
			$SIS_where .= " AND telemetria_listado.idSistema = ".$idSistema;
		}
		//Verifico el tipo de usuario que esta ingresando y el id
		$SIS_join  = '';
		if(isset($idTipoUsuario, $idUsuario)&&$idTipoUsuario!=1&&$idUsuario!=0){
			$SIS_join  .= ' INNER JOIN usuarios_equipos_telemetria ON usuarios_equipos_telemetria.idTelemetria = telemetria_listado.idTelemetria ';
			$SIS_where .= ' AND usuarios_equipos_telemetria.idUsuario = '.$idUsuario;
		}

		//numero sensores equipo
		$N_Maximo_Sensores = 10;
		$subquery = '';
		for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
			$subquery .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$i;
			$subquery .= ',telemetria_listado_sensores_med_actual.SensoresMedActual_'.$i;
			$subquery .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i;
			$subquery .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$i;
		}

		/*************************************************************/
		//Se consulta
		$SIS_query = '
		telemetria_listado.idTelemetria,
		telemetria_listado.Nombre,
		telemetria_listado.LastUpdateFecha,
		telemetria_listado.LastUpdateHora,
		telemetria_listado.cantSensores,
		telemetria_listado.GeoLatitud,
		telemetria_listado.GeoLongitud,
		telemetria_listado.NDetenciones,
		telemetria_listado.TiempoFueraLinea,
		telemetria_listado.GeoErrores,
		telemetria_listado.NErrores,
		telemetria_listado.GeoVelocidad,
		telemetria_listado.Patente,
		telemetria_listado.id_Sensores'.$subquery;
		$SIS_join .= '
		LEFT JOIN `telemetria_listado_sensores_nombre`          ON telemetria_listado_sensores_nombre.idTelemetria         = telemetria_listado.idTelemetria
		LEFT JOIN `telemetria_listado_sensores_med_actual`      ON telemetria_listado_sensores_med_actual.idTelemetria     = telemetria_listado.idTelemetria
		LEFT JOIN `telemetria_listado_sensores_unimed`          ON telemetria_listado_sensores_unimed.idTelemetria         = telemetria_listado.idTelemetria
		LEFT JOIN `telemetria_listado_sensores_activo`          ON telemetria_listado_sensores_activo.idTelemetria         = telemetria_listado.idTelemetria';
		$SIS_order = 'telemetria_listado.Nombre ASC';
		$arrEquipo = array();
		$arrEquipo = db_select_array (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrEquipo');

		/*************************************************************/
		//Se traen todas las unidades de medida
		$arrUnimed = array();
		$arrUnimed = db_select_array (false, 'idUniMed,Nombre', 'telemetria_listado_unidad_medida', '', '', 'idUniMed ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrUnimed');

		//Ordeno las unidades de medida
		$arrFinalUnimed = array();
		foreach ($arrUnimed as $data) {
			$arrFinalUnimed[$data['idUniMed']] = $data['Nombre'];
		}

		/*************************************************************/
		//se traen todas las zonas
		$arrZonas = array();
		$arrZonas = db_select_array (false, ' idZona, Nombre', 'vehiculos_zonas', '', '', 'idZona ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrUnimed');

		//defino la variable temporal de la zona
		$_SESSION['usuario']['zona']['idZona']         = 9999;
		$_SESSION['usuario']['zona']['id_Geo']         = 1;
		$_SESSION['usuario']['zona']['idTipoUsuario']  = $idTipoUsuario;
		$_SESSION['usuario']['zona']['idSistema']      = $idSistema;
		$_SESSION['usuario']['zona']['idUsuario']      = $idUsuario;

		/*************************************************************/
		//Predios
		$SIS_query = '
		cross_predios_listado_zonas.idZona,
		cross_predios_listado_zonas.Nombre,
		cross_predios_listado_zonas_ubicaciones.Latitud,
		cross_predios_listado_zonas_ubicaciones.Longitud';
		$SIS_join  = '
		LEFT JOIN `cross_predios_listado_zonas_ubicaciones`  ON cross_predios_listado_zonas_ubicaciones.idZona  = cross_predios_listado_zonas.idZona
		LEFT JOIN `cross_predios_listado`                    ON cross_predios_listado.idPredio                  = cross_predios_listado_zonas.idPredio';
		$SIS_where = 'cross_predios_listado.idSistema='.$idSistema;
		$SIS_order = 'cross_predios_listado_zonas.idZona ASC, cross_predios_listado_zonas_ubicaciones.idUbicaciones ASC';
		$arrPredios = array();
		$arrPredios = db_select_array (false, $SIS_query, 'cross_predios_listado_zonas', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrPredios');

		$GPS = '
		<script async src="https://maps.googleapis.com/maps/api/js?key='.$google.'&callback=initMap"></script>
		<style>
			.my_marker {color: black;background-color:#1E90FF;border: solid 1px black;font-weight: 900;padding: 4px;top: -8px;}
			.my_marker::after {content: "";position: absolute;top: 100%;left: 50%;transform: translate(-50%, 0%);border: solid 8px transparent;border-top-color: black;}
		</style>

		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="box">
					<header>
						<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>'.$titulo.'</h5>
					</header>
					<div class="table-responsive">
						<div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
							<div class="row">
								<div id="vehiContent_'.$idTab.'" class="table-wrapper-scroll-y my-custom-scrollbar">
									<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
										<thead>
											<tr role="row">
												<th colspan="7">
													<div class="field">
														<select name="selectZona" id="selectZona" class="form-control" onchange="chngZona()" >';
															//La opción todos
															$GPS .= '<option value="9999" selected="selected" >Todas las Zonas</option>';
															foreach ( $arrZonas as $select ) {
																$GPS .= '<option value="'.$select['idZona'].'" >'.$select['Nombre'].'</option>';
															}
														$GPS .= '
														</select>
													</div>
												</th>
											</tr>';
											$GPS .= widget_sherlock(1, 7, 'TableFiltered');

											//Si es Agro-Checking
											if(isset($idTab)&&$idTab==1){
												$GPS .= '
												<tr role="row">
													<th></th>
													<th>Equipo</th>
													<th>Velocidad (km/h)</th>
													<th>Estanque (%)</th>
													<th>F. izq (l/min)</th>
													<th>F. der (l/min)</th>
													<th></th>
												</tr>';
											}
											$GPS .= '
										</thead>
										<tbody role="alert" aria-live="polite" aria-relevant="all" id="TableFiltered">';
											$nicon = 0;
											foreach ($arrEquipo as $data) {

												/**********************************************/
												//Se resetean
												$in_eq_alertas     = 0;
												$in_eq_fueralinea  = 0;
												$in_eq_fueraruta   = 0;
												$in_eq_detenidos   = 0;
												$in_eq_gps_fuera   = 0;
												$in_eq_ok          = 1;

												/**********************************************/
												//Fuera de linea
												$diaInicio   = $data['LastUpdateFecha'];
												$diaTermino  = $FechaSistema;
												$tiempo1     = $data['LastUpdateHora'];
												$tiempo2     = $HoraSistema;
												$Tiempo      = horas_transcurridas($diaInicio, $diaTermino, $tiempo1, $tiempo2);

												//Comparaciones de tiempo
												$Time_Tiempo     = horas2segundos($Tiempo);
												$Time_Tiempo_FL  = horas2segundos($data['TiempoFueraLinea']);
												$Time_Tiempo_Max = horas2segundos('48:00:00');
												$Time_Fake_Ini   = horas2segundos('23:59:50');
												$Time_Fake_Fin   = horas2segundos('24:00:00');
												//comparacion
												if(($Time_Tiempo<$Time_Fake_Ini OR $Time_Tiempo>$Time_Fake_Fin)&&(($Time_Tiempo>$Time_Tiempo_FL&&$Time_Tiempo_FL!=0) OR ($Time_Tiempo>$Time_Tiempo_Max&&$Time_Tiempo_FL==0))){
													$in_eq_fueralinea++;
												}

												/**********************************************/
												//GPS con problemas
												if(isset($data['GeoErrores'])&&$data['GeoErrores']>0){    $in_eq_gps_fuera++; }
												if(isset($data['GeoLatitud'])&&$data['GeoLatitud']==0){   $in_eq_gps_fuera++; }
												if(isset($data['GeoLongitud'])&&$data['GeoLongitud']==0){ $in_eq_gps_fuera++; }

												/**********************************************/
												//Equipos Errores
												if(isset($data['NErrores'])&&$data['NErrores']>0){ $in_eq_alertas++; }

												/**********************************************/
												//Equipos detenidos
												if(isset($data['NDetenciones'])&&$data['NDetenciones']>0){ $in_eq_detenidos++; }

												/*******************************************************/
												//rearmo
												if($in_eq_detenidos>0){  $in_eq_ok = 0;$in_eq_detenidos = 1;}
												if($in_eq_alertas>0){    $in_eq_ok = 0;$in_eq_alertas = 1;    $in_eq_detenidos = 0;}
												if($in_eq_fueraruta>0){  $in_eq_ok = 0;$in_eq_fueraruta = 1;  $in_eq_alertas = 0;   $in_eq_detenidos = 0;}
												if($in_eq_gps_fuera>0){  $in_eq_ok = 0;$in_eq_gps_fuera = 1;  $in_eq_fueraruta = 0; $in_eq_alertas = 0;    $in_eq_detenidos = 0;}
												if($in_eq_fueralinea>0){ $in_eq_ok = 0;$in_eq_fueralinea = 1; $in_eq_gps_fuera = 0; $in_eq_fueraruta = 0;  $in_eq_alertas = 0;  $in_eq_detenidos = 0;}

												/*******************************************************/
												//se guardan estados
												$danger = '';
												if($in_eq_detenidos>0){  $danger = '';    $dataex = '<a href="#" title="Equipo Detenido"           class="btn btn-success btn-sm tooltip"><i class="fa fa-car" aria-hidden="true"></i></a>';}
												if($in_eq_alertas>0){    $danger = 'warning';  $dataex = '<a href="#" title="Equipo con Alertas"        class="btn btn-warning btn-sm tooltip"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></a>';}
												if($in_eq_fueraruta>0){  $danger = 'warning';  $dataex = '<a href="#" title="Equipo fuera de ruta"      class="btn btn-warning btn-sm tooltip"><i class="fa fa-location-arrow" aria-hidden="true"></i></a>';}
												if($in_eq_gps_fuera>0){  $danger = 'info';     $dataex = '<a href="#" title="Equipo sin cobertura GPS"  class="btn btn-info btn-sm tooltip"><i class="fa fa-map-marker" aria-hidden="true"></i></a>';}
												if($in_eq_fueralinea>0){ $danger = 'danger';   $dataex = '<a href="#" title="Fuera de Linea"            class="btn btn-danger btn-sm tooltip"><i class="fa fa-chain-broken" aria-hidden="true"></i></a>';}

												/*******************************************************/
												//Se guardan los valores
												$eq_alertas     = $eq_alertas + $in_eq_alertas;
												$eq_fueralinea  = $eq_fueralinea + $in_eq_fueralinea;
												$eq_fueraruta   = $eq_fueraruta + $in_eq_fueraruta;
												$eq_detenidos   = $eq_detenidos + $in_eq_detenidos;
												$eq_gps_fuera   = $eq_gps_fuera + $in_eq_gps_fuera;
												$eq_ok          = $eq_ok + $in_eq_ok;

												/*******************************************************/
												//traspasan los estados
												if($in_eq_ok==1){
													$eq_ok_icon = '<a href="#" title="Sin Problemas" class="btn btn-success btn-sm tooltip"><i class="fa fa-check" aria-hidden="true"></i></a>';
												}else{
													$eq_ok_icon = $dataex;
												}

												/*******************************************************/
												//cadena
												if(isset($data['SensoresMedActual_1'])&&$data['SensoresMedActual_1']<99900){$xdata_1 = Cantidades($data['SensoresMedActual_1'], 2);}else{$xdata_1 = 'Sin Datos';}
												if(isset($data['SensoresMedActual_2'])&&$data['SensoresMedActual_2']<99900){$xdata_2 = Cantidades($data['SensoresMedActual_2'], 2);}else{$xdata_2 = 'Sin Datos';}
												if(isset($data['SensoresMedActual_3'])&&$data['SensoresMedActual_3']<99900){$xdata_3 = Cantidades($data['SensoresMedActual_3'], 2);}else{$xdata_3 = 'Sin Datos';}

												$GPS .= '
												<tr class="odd '.$danger.'">
													<td width="10">
														<div class="btn-group" style="width: 35px;" >'.$eq_ok_icon.'</div>
													</td>';

													if(isset($idTab)&&$idTab==1){
														$GPS .= '
														<td>
															'.$data['Nombre'].'<br/>
															'.fecha_estandar($data['LastUpdateFecha']).' '.$data['LastUpdateHora'].'
														</td>
														<td>'.Cantidades($data['GeoVelocidad'], 0).' km/h</td>
														<td>'.$xdata_3.' %</td>
														<td>'.$xdata_2.' l/min</td>
														<td>'.$xdata_1.' l/min</td>';
													}else{
														$GPS .= '
														<td colspan="5">
															'.$data['Nombre'].'<br/>
															'.fecha_estandar($data['LastUpdateFecha']).' '.$data['LastUpdateHora'].'
														</td>';
													}
													$GPS .= '
													<td width="10">
														<div class="btn-group" style="width: 70px;" >
															<a href="view_telemetria_registro_ruta.php?view='.simpleEncode($data['idTelemetria'], fecha_actual()).'" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-line-chart" aria-hidden="true"></i></a>
															<button onclick="fncCenterMap(\''.$data['GeoLatitud'].'\', \''.$data['GeoLongitud'].'\', \''.$nicon.'\')" title="Ver Ubicación" class="btn btn-default btn-sm tooltip"><i class="fa fa-map-marker" aria-hidden="true"></i></button>
														</div>
													</td>
												</tr>';
												$nicon++;
											}
											$GPS .= '
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
							<div class="row">
								<div id="map_canvas" style="width: 100%; height: 550px;"></div>
								<div id="map_content_'.$idTab.'"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<style>
		.my-custom-scrollbar {
			position: relative;
			height: 550px;
			overflow: auto;
		}
		.table-wrapper-scroll-y {
			display: block;
		}
		</style>

		<script>
			let map;
			var markers = [];
			//Ubicación de los distintos dispositivos
			var locations = [ ';
				foreach ( $arrEquipo as $data ) {
					//burbuja
					if(isset($data['Patente'])&&$data['Patente']!=''){$pate_nte = ' ('.$data['Patente'].')';}else{$pate_nte = '';}
					$explanation  = '<div class="iw-subTitle">Vehiculo: '.$data['Nombre'].$pate_nte.'</div>';
					$explanation .= '<p>Velocidad: '.Cantidades($data['GeoVelocidad'], 0).'<br/>';
					$explanation .= 'Actualizado: '.fecha_estandar($data['LastUpdateFecha']).' - '.$data['LastUpdateHora'].'</p>';
					//verifico si tiene sensores configurados
					if(isset($data['id_Sensores'])&&$data['id_Sensores']==1){
						$explanation .= '<div class="iw-subTitle">Sensores: </div><p>';
						for ($i = 1; $i <= $data['cantSensores']; $i++) {
							//verifico que sensor este activo
							if(isset($data['SensoresActivo_'.$i])&&$data['SensoresActivo_'.$i]==1){
								//Unidad medida
								if(isset($arrFinalUnimed[$data['SensoresUniMed_'.$i]])){
									$unimed = ' '.$arrFinalUnimed[$data['SensoresUniMed_'.$i]];
								}else{
									$unimed = '';
								}
								//cadena
								if(isset($data['SensoresMedActual_'.$i])&&$data['SensoresMedActual_'.$i]<99900){$xdata=Cantidades($data['SensoresMedActual_'.$i], 2).$unimed;}else{$xdata='Sin Datos';}
								$explanation .= $data['SensoresNombre_'.$i].' : '.$xdata.'<br/>';
							}
						}
						$explanation .= '</p>';
					}
					//se arma dato
					$GPS .= "[";
						$GPS .= $data['GeoLatitud'];
						$GPS .= ", ".$data['GeoLongitud'];
						$GPS .= ", '".$explanation."'";
					$GPS .= "], ";
				}
			$GPS .= '];

			async function initMap() {
				const { Map } = await google.maps.importLibrary("maps");

				var myLatlng = new google.maps.LatLng(-33.477271996598965, -70.65170304882815);

				var myOptions = {
					zoom: 14,
					center: myLatlng,
					mapTypeId: google.maps.MapTypeId.SATELLITE
				};

				map = new Map(document.getElementById("map_canvas"), myOptions);
				//dibuja zonas
				map.setTilt(0);
				//dibuja zonas
				dibuja_zona();

			}

			/* ************************************************************************** */
			function chngZona() {
				idZona = document.getElementById("selectZona").value;
				$(\'#vehiContent_'.$idTab.'\').load(\'principal_update_zonaList_1_crosstech.php'.$enlace.'&idZona=\' + idZona);
				setMarkers(map, locations, 1);
			}

			/* ************************************************************************** */
			function fncCenterMap(Latitud, Longitud, n_icon){
				latlon = new google.maps.LatLng(Latitud, Longitud);
				map.panTo(latlon);
				//volver todo a normal
				for (let i = 0; i < markers.length; i++) {
					markers[i].setIcon("'.DB_SITE_REPO.'/LIB_assets/img/map-icons/1_series_orange.png");
				}
				//colorear el seleccionado
				markers[n_icon].setIcon("'.DB_SITE_REPO.'/LIB_assets/img/map-icons/1_series_green.png");
			}

			/* ************************************************************************** */
			class MyMarker extends google.maps.OverlayView {
				constructor(params) {
					super();
					this.position = params.position;

					const content = document.createElement(\'div\');
					content.classList.add(\'my_marker\');
					content.textContent = params.label;
					content.style.position = \'absolute\';
					content.style.transform = \'translate(-50%, -100%)\';

					const container = document.createElement(\'div\');
					container.style.position = \'absolute\';
					container.style.cursor = \'pointer\';
					container.appendChild(content);

					this.container = container;
				}

				onAdd() {
					this.getPanes().floatPane.appendChild(this.container);
				}

				onRemove() {
					this.container.remove();
				}

				draw() {
					const pos = this.getProjection().fromLatLngToDivPixel(this.position);
					this.container.style.left = pos.x + \'px\';
					this.container.style.top = pos.y + \'px\';
				}
			}
			/* ************************************************************************** */
			function setMarkers(map, locations, optc) {

				var marker, i, last_latitude, last_longitude;

				for (i = 0; i < locations.length; i++) {

					//defino ubicacion y datos
					let latitude   = locations[i][0];
					let longitude  = locations[i][1];
					let data       = locations[i][2];

					//guardo las ultimas ubicaciones
					last_latitude   = locations[i][0];
					last_longitude  = locations[i][1];

					latlngset = new google.maps.LatLng(latitude, longitude);

					//se crea marcador
					var marker = new google.maps.Marker({
						map         : map,
						position    : latlngset,
						icon      	: "'.DB_SITE_REPO.'/LIB_assets/img/map-icons/1_series_orange.png",
						zIndex:99999999
					});
					markers.push(marker);

					//se define contenido
					var content = 	"<div id=\'iw-container\'>" +
									"<div class=\'iw-title\'>Datos</div>" +
									"<div class=\'iw-content\'>" +
									data +
									"</div>" +
									"<div class=\'iw-bottom-gradient\'></div>" +
									"</div>";

					//se crea infowindow
					var infowindow = new google.maps.InfoWindow();

					//se agrega funcion de click a infowindow
					google.maps.event.addListener(marker,\'click\', (function(marker,content,infowindow){
						return function() {
							infowindow.setContent(content);
							infowindow.open(map,marker);
						};
					})(marker,content,infowindow));

				}
				if(optc==1){
					latlon = new google.maps.LatLng(last_latitude, last_longitude);
					map.panTo(latlon);
				}
			}
			/* ************************************************************************** */
			function transMarker(map, time) {
				var newTime = time / 2;
				setInterval(function(){transMarkerTimer(map)},newTime);
			}
			/* ************************************************************************** */
			var mapax = 0;
			function transMarkerTimer(map) {

				switch(mapax) {
					//Ejecutar formulario con el recorrido y la ruta
					case 1:
						$(\'#map_content_'.$idTab.'\').load(\'principal_update_map_zona_1_crosstech.php'.$enlace.'\');
						$(\'#vehiContent_'.$idTab.'\').load(\'principal_update_zonaList_1_crosstech.php'.$enlace.'\');
						break;
					//se dibujan los iconos
					case 2:
						//Se ocultan y eliminan los iconos
						deleteMarkers();
						setMarkers(map, new_locations, 2);
						//actualizo la hora de actualizacion
						document.getElementById(\'update_text_HoraRefresco\').innerHTML=\'Hora Refresco: \'+HoraRefresco;

						break;
				}

				mapax++;
				if(mapax==3){mapax=1}
			}
			/* ************************************************************************** */
			// Sets the map on all markers in the array.
			function setMapOnAll(map) {
				for (let i = 0; i < markers.length; i++) {
				  markers[i].setMap(map);
				}
			}
			/* ************************************************************************** */
			// Removes the markers from the map, but keeps them in the array.
			function clearMarkers() {
				setMapOnAll(null);
			}
			/* ************************************************************************** */
			// Shows any markers currently in the array.
			function showMarkers() {
				setMapOnAll(map);
			}
			/* ************************************************************************** */
			// Deletes all markers in the array by removing references to them.
			function deleteMarkers() {
				clearMarkers();
				markers = [];
			}
			/* ************************************************************************** */
			function dibuja_zona() {

				var polygons = [];';

				//variables
				$Latitud_z        = 0;
				$Longitud_z       = 0;
				$Latitud_z_prom   = 0;
				$Longitud_z_prom  = 0;
				$zcounter         = 0;
				$zcounter2        = 0;

				//Se filtra por zona
				filtrar($arrPredios, 'idZona');
				//se recorre
				foreach ($arrPredios as $todaszonas=>$zonas) {

					$Latitud_z_2       = 0;
					$Longitud_z_2      = 0;
					$Latitud_z_prom_2  = 0;
					$Longitud_z_prom_2 = 0;
					$zcounter3         = 0;

					$GPS .= 'var path'.$todaszonas.' = [';

					//Variables con la primera posicion
					$Latitud_x = '';
					$Longitud_x = '';

					foreach ($zonas as $puntos) {
						if(isset($puntos['Latitud'], $puntos['Longitud'])&&$puntos['Latitud']!=''&&$puntos['Longitud']!=''){
							$GPS .= '{lat: '.$puntos['Latitud'].', lng: '.$puntos['Longitud'].'},';
							if(isset($puntos['Latitud'], $puntos['Longitud'])&&$puntos['Latitud']!='0'&&$puntos['Longitud']!='0'){
								$Latitud_x  = $puntos['Latitud'];
								$Longitud_x = $puntos['Longitud'];
								//Calculos para centrar mapa
								$Latitud_z    = $Latitud_z+$puntos['Latitud'];
								$Longitud_z   = $Longitud_z+$puntos['Longitud'];
								$Latitud_z_2  = $Latitud_z_2+$puntos['Latitud'];
								$Longitud_z_2 = $Longitud_z_2+$puntos['Longitud'];
								$zcounter++;
								$zcounter3++;
							}
						}
					}
					//se cierra la figura
					if(isset($Longitud_x)&&$Longitud_x!=''){
						$GPS .= '{lat: '.$Latitud_x.', lng: '.$Longitud_x.'}';
					}
					$GPS .= '];';

					$GPS .= '
					polygons.push(new google.maps.Polygon({
						paths: path'.$todaszonas.',
						strokeColor: \'#FF0000\',
						strokeOpacity: 0.8,
						strokeWeight: 2,
						fillColor: \'#FF0000\',
						fillOpacity: 0.35
					}));
					polygons[polygons.length-1].setMap(map);';

					if($zcounter3!=0){
						$Latitud_z_prom_2  = $Latitud_z_2/$zcounter3;
						$Longitud_z_prom_2 = $Longitud_z_2/$zcounter3;
					}

					$GPS .= '
					myLatlng = new google.maps.LatLng('.$Latitud_z_prom_2.', '.$Longitud_z_prom_2.');

					var marker2 = new MyMarker({
						position: myLatlng,
						label: "'.$zonas[0]['Nombre'].'",
						zIndex:9999
					});
					marker2.setMap(map);

					// When the mouse moves within the polygon, display the label and change the BG color.
					google.maps.event.addListener(polygons['.$zcounter2.'], "mousemove", function(event) {
						polygons['.$zcounter2.'].setOptions({
							fillColor: "#00FF00"
						});
					});

					// WHen the mouse moves out of the polygon, hide the label and change the BG color.
					google.maps.event.addListener(polygons['.$zcounter2.'], "mouseout", function(event) {
						polygons['.$zcounter2.'].setOptions({
							fillColor: "#FF0000"
						});
					});';

					$zcounter2++;
				}

				$GPS .= '
				//ubicacion inicial
				setMarkers(map, locations, 1);
				//actualizacion de posicion
				transMarker(map, '.$SegActual.');

			}
		</script>';

		//despliega el resumen
		if(isset($miniwidget)&&$miniwidget==1){
			$GPS .= '<div class="row">';
				$GPS .= widget_Ficha_2('box-yellow', 'fa-truck faa-float animated', $eq_alertas, 4, 'Vehiculos con alertas', 'Equipos', 'principal_gps_view.php?seguimiento='.simpleEncode( 1, fecha_actual()).'&idSistema='.simpleEncode($idSistema, fecha_actual()).'&dataType='.simpleEncode( 1, fecha_actual()), 'Ver Mas', 'btn-warning', 1, 2);
				$GPS .= widget_Ficha_2('box-red', 'fa-truck faa-float animated', $eq_fueralinea, 4, 'Vehiculos fuera de linea', 'Equipos', 'principal_gps_view.php?seguimiento='.simpleEncode( 1, fecha_actual()).'&idSistema='.simpleEncode($idSistema, fecha_actual()).'&dataType='.simpleEncode( 2, fecha_actual()), 'Ver Mas', 'btn-danger', 1, 2);
				$GPS .= widget_Ficha_2('box-orange', 'fa-truck faa-float animated', $eq_fueraruta, 4, 'Vehiculos fuera de ruta', 'Equipos', 'principal_gps_view.php?seguimiento='.simpleEncode( 1, fecha_actual()).'&idSistema='.simpleEncode($idSistema, fecha_actual()).'&dataType='.simpleEncode( 3, fecha_actual()), 'Ver Mas', 'btn-warning', 1, 2);
				$GPS .= widget_Ficha_2('box-purple', 'fa-truck faa-float animated', $eq_gps_fuera, 4, 'Vehiculos sin cobertura GPS', 'Equipos', 'principal_gps_view.php?seguimiento='.simpleEncode( 1, fecha_actual()).'&idSistema='.simpleEncode($idSistema, fecha_actual()).'&dataType='.simpleEncode( 5, fecha_actual()), 'Ver Mas', 'btn-primary', 1, 2);
				$GPS .= widget_Ficha_2('box-green', 'fa-truck faa-float animated', ($eq_ok+$eq_detenidos), 4, 'Vehiculos OK', 'Equipos', 'principal_gps_view.php?seguimiento='.simpleEncode( 1, fecha_actual()).'&idSistema='.simpleEncode($idSistema, fecha_actual()).'&dataType='.simpleEncode( 4, fecha_actual()), 'Ver Mas', 'btn-success', 1, 2);
			$GPS .= '</div>';
		}

		return $GPS;

	}
}
/*******************************************************************************************************************/
//Muestra la gestion de flota crosstech
function widget_Gestion_Flota_CrossTech_Transportes_AB($titulo, $idSistema, $IDGoogle, $idTipoUsuario, $idUsuario,
										               $SegActual, $idTab, $miniwidget, $dbConn){

	//Si no existe una ID se utiliza una por defecto
	if(!isset($IDGoogle) OR $IDGoogle==''){
		return alert_post_data(4,1,1,0, 'No ha ingresado Una API de Google Maps');
	}else{

		//variables
		$HoraSistema    = hora_actual();
		$FechaSistema   = fecha_actual();
		$eq_alertas     = 0;
		$eq_fueralinea  = 0;
		$eq_fueraruta   = 0;
		$eq_detenidos   = 0;
		$eq_gps_fuera   = 0;
		$eq_ok          = 0;

		$google = $IDGoogle;

		//enlace para redireccionar
		$enlace  = "?dd=true";
		$enlace .= "&idTipoUsuario=".$idTipoUsuario;
		$enlace .= "&idSistema=".$idSistema;
		$enlace .= "&idUsuario=".$idUsuario;
		$enlace .= "&idTab=".$idTab;

		//Variable
		$SIS_where = "telemetria_listado.idEstado = 1 ";//solo equipos activos
		//solo los equipos que tengan el seguimiento activado
		$SIS_where .= " AND telemetria_listado.id_Geo = 1";
		//Filtro de los tab
		$SIS_where .= " AND telemetria_listado.idTab = ".$idTab;
		//Filtro el sistema al cual pertenece
		if(isset($idSistema)&&$idSistema!=''&&$idSistema!=0){
			$SIS_where .= " AND telemetria_listado.idSistema = ".$idSistema;
		}
		//Verifico el tipo de usuario que esta ingresando y el id
		$SIS_join  = '';
		if(isset($idTipoUsuario, $idUsuario)&&$idTipoUsuario!=1&&$idUsuario!=0){
			$SIS_join  .= ' INNER JOIN usuarios_equipos_telemetria ON usuarios_equipos_telemetria.idTelemetria = telemetria_listado.idTelemetria ';
			$SIS_where .= ' AND usuarios_equipos_telemetria.idUsuario = '.$idUsuario;
		}

		//numero sensores equipo
		$N_Maximo_Sensores = 10;
		$subquery = '';
		for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
			$subquery .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$i;
			$subquery .= ',telemetria_listado_sensores_med_actual.SensoresMedActual_'.$i;
			$subquery .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i;
			$subquery .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$i;
		}

		/*************************************************************/
		//Se consulta
		$SIS_query = '
		telemetria_listado.idTelemetria,
		telemetria_listado.Nombre,
		telemetria_listado.LastUpdateFecha,
		telemetria_listado.LastUpdateHora,
		telemetria_listado.cantSensores,
		telemetria_listado.GeoLatitud,
		telemetria_listado.GeoLongitud,
		telemetria_listado.NDetenciones,
		telemetria_listado.TiempoFueraLinea,
		telemetria_listado.GeoErrores,
		telemetria_listado.NErrores,
		telemetria_listado.GeoVelocidad,
		telemetria_listado.Patente,
		telemetria_listado.id_Sensores'.$subquery;
		$SIS_join .= '
		LEFT JOIN `telemetria_listado_sensores_nombre`          ON telemetria_listado_sensores_nombre.idTelemetria         = telemetria_listado.idTelemetria
		LEFT JOIN `telemetria_listado_sensores_med_actual`      ON telemetria_listado_sensores_med_actual.idTelemetria     = telemetria_listado.idTelemetria
		LEFT JOIN `telemetria_listado_sensores_unimed`          ON telemetria_listado_sensores_unimed.idTelemetria         = telemetria_listado.idTelemetria
		LEFT JOIN `telemetria_listado_sensores_activo`          ON telemetria_listado_sensores_activo.idTelemetria         = telemetria_listado.idTelemetria';
		$SIS_order = 'telemetria_listado.Nombre ASC';
		$arrEquipo = array();
		$arrEquipo = db_select_array (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrEquipo');

		/*************************************************************/
		//Se traen todas las unidades de medida
		$arrUnimed = array();
		$arrUnimed = db_select_array (false, 'idUniMed,Nombre', 'telemetria_listado_unidad_medida', '', '', 'idUniMed ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrUnimed');

		//Ordeno las unidades de medida
		$arrFinalUnimed = array();
		foreach ($arrUnimed as $data) {
			$arrFinalUnimed[$data['idUniMed']] = $data['Nombre'];
		}

		/*************************************************************/
		//se traen todas las zonas
		$arrZonas = array();
		$arrZonas = db_select_array (false, ' idZona, Nombre', 'vehiculos_zonas', '', '', 'idZona ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrUnimed');

		//defino la variable temporal de la zona
		$_SESSION['usuario']['zona']['idZona']         = 9999;
		$_SESSION['usuario']['zona']['id_Geo']         = 1;
		$_SESSION['usuario']['zona']['idTipoUsuario']  = $idTipoUsuario;
		$_SESSION['usuario']['zona']['idSistema']      = $idSistema;
		$_SESSION['usuario']['zona']['idUsuario']      = $idUsuario;

		/*************************************************************/
		//Predios
		$SIS_query = '
		cross_predios_listado_zonas.idZona,
		cross_predios_listado_zonas.Nombre,
		cross_predios_listado_zonas_ubicaciones.Latitud,
		cross_predios_listado_zonas_ubicaciones.Longitud';
		$SIS_join  = '
		LEFT JOIN `cross_predios_listado_zonas_ubicaciones`  ON cross_predios_listado_zonas_ubicaciones.idZona  = cross_predios_listado_zonas.idZona
		LEFT JOIN `cross_predios_listado`                    ON cross_predios_listado.idPredio                  = cross_predios_listado_zonas.idPredio';
		$SIS_where = 'cross_predios_listado.idSistema='.$idSistema;
		$SIS_order = 'cross_predios_listado_zonas.idZona ASC, cross_predios_listado_zonas_ubicaciones.idUbicaciones ASC';
		$arrPredios = array();
		$arrPredios = db_select_array (false, $SIS_query, 'cross_predios_listado_zonas', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrPredios');

		$GPS = '
		<script async src="https://maps.googleapis.com/maps/api/js?key='.$google.'&callback=initMap"></script>
		<style>
			.my_marker {color: black;background-color:#1E90FF;border: solid 1px black;font-weight: 900;padding: 4px;top: -8px;}
			.my_marker::after {content: "";position: absolute;top: 100%;left: 50%;transform: translate(-50%, 0%);border: solid 8px transparent;border-top-color: black;}
		</style>

		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="box">
					<header>
						<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>'.$titulo.'</h5>
					</header>
					<div class="table-responsive">
						<div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
							<div class="row">
								<div id="vehiContent_'.$idTab.'" class="table-wrapper-scroll-y my-custom-scrollbar">
									<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
										<thead>
											<tr role="row">
												<th colspan="7">
													<div class="field">
														<select name="selectZona" id="selectZona" class="form-control" onchange="chngZona()" >';
															//La opción todos
															$GPS .= '<option value="9999" selected="selected" >Todas las Zonas</option>';
															foreach ( $arrZonas as $select ) {
																$GPS .= '<option value="'.$select['idZona'].'" >'.$select['Nombre'].'</option>';
															}
														$GPS .= '
														</select>
													</div>
												</th>
											</tr>';
											$GPS .= widget_sherlock(1, 7, 'TableFiltered');

											//Si es Agro-Checking
											if(isset($idTab)&&$idTab==1){
												$GPS .= '
												<tr role="row">
													<th></th>
													<th>Equipo</th>
													<th>Velocidad (km/h)</th>
													<th>Estanque (%)</th>
													<th>F. izq (l/min)</th>
													<th>F. der (l/min)</th>
													<th></th>
												</tr>';
											}
											$GPS .= '
										</thead>
										<tbody role="alert" aria-live="polite" aria-relevant="all" id="TableFiltered">';
											$nicon = 0;
											foreach ($arrEquipo as $data) {

												/**********************************************/
												//Se resetean
												$in_eq_alertas     = 0;
												$in_eq_fueralinea  = 0;
												$in_eq_fueraruta   = 0;
												$in_eq_detenidos   = 0;
												$in_eq_gps_fuera   = 0;
												$in_eq_ok          = 1;

												/**********************************************/
												//Fuera de linea
												$diaInicio   = $data['LastUpdateFecha'];
												$diaTermino  = $FechaSistema;
												$tiempo1     = $data['LastUpdateHora'];
												$tiempo2     = $HoraSistema;
												$Tiempo      = horas_transcurridas($diaInicio, $diaTermino, $tiempo1, $tiempo2);

												//Comparaciones de tiempo
												$Time_Tiempo     = horas2segundos($Tiempo);
												$Time_Tiempo_FL  = horas2segundos($data['TiempoFueraLinea']);
												$Time_Tiempo_Max = horas2segundos('48:00:00');
												$Time_Fake_Ini   = horas2segundos('23:59:50');
												$Time_Fake_Fin   = horas2segundos('24:00:00');
												//comparacion
												if(($Time_Tiempo<$Time_Fake_Ini OR $Time_Tiempo>$Time_Fake_Fin)&&(($Time_Tiempo>$Time_Tiempo_FL&&$Time_Tiempo_FL!=0) OR ($Time_Tiempo>$Time_Tiempo_Max&&$Time_Tiempo_FL==0))){
													$in_eq_fueralinea++;
												}

												/**********************************************/
												//GPS con problemas
												if(isset($data['GeoErrores'])&&$data['GeoErrores']>0){    $in_eq_gps_fuera++; }
												if(isset($data['GeoLatitud'])&&$data['GeoLatitud']==0){   $in_eq_gps_fuera++; }
												if(isset($data['GeoLongitud'])&&$data['GeoLongitud']==0){ $in_eq_gps_fuera++; }

												/**********************************************/
												//Equipos Errores
												if(isset($data['NErrores'])&&$data['NErrores']>0){ $in_eq_alertas++; }

												/**********************************************/
												//Equipos detenidos
												if(isset($data['NDetenciones'])&&$data['NDetenciones']>0){ $in_eq_detenidos++; }

												/*******************************************************/
												//rearmo
												if($in_eq_detenidos>0){  $in_eq_ok = 0;$in_eq_detenidos = 1;}
												if($in_eq_alertas>0){    $in_eq_ok = 0;$in_eq_alertas = 1;    $in_eq_detenidos = 0;}
												if($in_eq_fueraruta>0){  $in_eq_ok = 0;$in_eq_fueraruta = 1;  $in_eq_alertas = 0;   $in_eq_detenidos = 0;}
												if($in_eq_gps_fuera>0){  $in_eq_ok = 0;$in_eq_gps_fuera = 1;  $in_eq_fueraruta = 0; $in_eq_alertas = 0;    $in_eq_detenidos = 0;}
												if($in_eq_fueralinea>0){ $in_eq_ok = 0;$in_eq_fueralinea = 1; $in_eq_gps_fuera = 0; $in_eq_fueraruta = 0;  $in_eq_alertas = 0;  $in_eq_detenidos = 0;}

												/*******************************************************/
												//se guardan estados
												$danger = '';
												if($in_eq_detenidos>0){  $danger = '';    $dataex = '<a href="#" title="Equipo Detenido"           class="btn btn-success btn-sm tooltip"><i class="fa fa-car" aria-hidden="true"></i></a>';}
												if($in_eq_alertas>0){    $danger = 'warning';  $dataex = '<a href="#" title="Equipo con Alertas"        class="btn btn-warning btn-sm tooltip"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></a>';}
												if($in_eq_fueraruta>0){  $danger = 'warning';  $dataex = '<a href="#" title="Equipo fuera de ruta"      class="btn btn-warning btn-sm tooltip"><i class="fa fa-location-arrow" aria-hidden="true"></i></a>';}
												if($in_eq_gps_fuera>0){  $danger = 'info';     $dataex = '<a href="#" title="Equipo sin cobertura GPS"  class="btn btn-info btn-sm tooltip"><i class="fa fa-map-marker" aria-hidden="true"></i></a>';}
												if($in_eq_fueralinea>0){ $danger = 'danger';   $dataex = '<a href="#" title="Fuera de Linea"            class="btn btn-danger btn-sm tooltip"><i class="fa fa-chain-broken" aria-hidden="true"></i></a>';}

												/*******************************************************/
												//Se guardan los valores
												$eq_alertas     = $eq_alertas + $in_eq_alertas;
												$eq_fueralinea  = $eq_fueralinea + $in_eq_fueralinea;
												$eq_fueraruta   = $eq_fueraruta + $in_eq_fueraruta;
												$eq_detenidos   = $eq_detenidos + $in_eq_detenidos;
												$eq_gps_fuera   = $eq_gps_fuera + $in_eq_gps_fuera;
												$eq_ok          = $eq_ok + $in_eq_ok;

												/*******************************************************/
												//traspasan los estados
												if($in_eq_ok==1){
													$eq_ok_icon = '<a href="#" title="Sin Problemas" class="btn btn-success btn-sm tooltip"><i class="fa fa-check" aria-hidden="true"></i></a>';
												}else{
													$eq_ok_icon = $dataex;
												}

												/*******************************************************/
												//cadena
												if(isset($data['SensoresMedActual_1'])&&$data['SensoresMedActual_1']<99900){$xdata_1 = Cantidades($data['SensoresMedActual_1'], 2);}else{$xdata_1 = 'Sin Datos';}
												if(isset($data['SensoresMedActual_2'])&&$data['SensoresMedActual_2']<99900){$xdata_2 = Cantidades($data['SensoresMedActual_2'], 2);}else{$xdata_2 = 'Sin Datos';}
												if(isset($data['SensoresMedActual_3'])&&$data['SensoresMedActual_3']<99900){$xdata_3 = Cantidades($data['SensoresMedActual_3'], 2);}else{$xdata_3 = 'Sin Datos';}

												$GPS .= '
												<tr class="odd '.$danger.'">
													<td width="10">
														<div class="btn-group" style="width: 35px;" >'.$eq_ok_icon.'</div>
													</td>';

													if(isset($idTab)&&$idTab==1){
														$GPS .= '
														<td>
															'.$data['Nombre'].'<br/>
															'.fecha_estandar($data['LastUpdateFecha']).' '.$data['LastUpdateHora'].'
														</td>
														<td>'.Cantidades($data['GeoVelocidad'], 0).' km/h</td>
														<td>'.$xdata_3.' %</td>
														<td>'.$xdata_2.' l/min</td>
														<td>'.$xdata_1.' l/min</td>';
													}else{
														$GPS .= '
														<td colspan="5">
															'.$data['Nombre'].'<br/>
															'.fecha_estandar($data['LastUpdateFecha']).' '.$data['LastUpdateHora'].'
														</td>';
													}
													$GPS .= '
													<td width="10">
														<div class="btn-group" style="width: 70px;" >
															<a href="view_telemetria_registro_ruta_transporte_ab.php?view='.simpleEncode($data['idTelemetria'], fecha_actual()).'" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-line-chart" aria-hidden="true"></i></a>
															<button onclick="fncCenterMap(\''.$data['GeoLatitud'].'\', \''.$data['GeoLongitud'].'\', \''.$nicon.'\')" title="Ver Ubicación" class="btn btn-default btn-sm tooltip"><i class="fa fa-map-marker" aria-hidden="true"></i></button>
														</div>
													</td>
												</tr>';
												$nicon++;
											}
											$GPS .= '
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
							<div class="row">
								<div id="map_canvas" style="width: 100%; height: 550px;"></div>
								<div id="map_content_'.$idTab.'"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<style>
		.my-custom-scrollbar {
			position: relative;
			height: 550px;
			overflow: auto;
		}
		.table-wrapper-scroll-y {
			display: block;
		}
		</style>

		<script>
			let map;
			var markers = [];
			//Ubicación de los distintos dispositivos
			var locations = [ ';
				foreach ( $arrEquipo as $data ) {
					//burbuja
					if(isset($data['Patente'])&&$data['Patente']!=''){$pate_nte = ' ('.$data['Patente'].')';}else{$pate_nte = '';}
					$explanation  = '<div class="iw-subTitle">Vehiculo: '.$data['Nombre'].$pate_nte.'</div>';
					$explanation .= '<p>Velocidad: '.Cantidades($data['GeoVelocidad'], 0).'<br/>';
					$explanation .= 'Actualizado: '.fecha_estandar($data['LastUpdateFecha']).' - '.$data['LastUpdateHora'].'</p>';
					//verifico si tiene sensores configurados
					if(isset($data['id_Sensores'])&&$data['id_Sensores']==1){
						$explanation .= '<div class="iw-subTitle">Sensores: </div><p>';
						for ($i = 1; $i <= $data['cantSensores']; $i++) {
							//verifico que sensor este activo
							if(isset($data['SensoresActivo_'.$i])&&$data['SensoresActivo_'.$i]==1){
								//Unidad medida
								if(isset($arrFinalUnimed[$data['SensoresUniMed_'.$i]])){
									$unimed = ' '.$arrFinalUnimed[$data['SensoresUniMed_'.$i]];
								}else{
									$unimed = '';
								}
								//cadena
								if(isset($data['SensoresMedActual_'.$i])&&$data['SensoresMedActual_'.$i]<99900){$xdata=Cantidades($data['SensoresMedActual_'.$i], 2).$unimed;}else{$xdata='Sin Datos';}
								$explanation .= $data['SensoresNombre_'.$i].' : '.$xdata.'<br/>';
							}
						}
						$explanation .= '</p>';
					}
					//se arma dato
					$GPS .= "[";
						$GPS .= $data['GeoLatitud'];
						$GPS .= ", ".$data['GeoLongitud'];
						$GPS .= ", '".$explanation."'";
					$GPS .= "], ";
				}
			$GPS .= '];

			async function initMap() {
				const { Map } = await google.maps.importLibrary("maps");

				var myLatlng = new google.maps.LatLng(-33.477271996598965, -70.65170304882815);

				var myOptions = {
					zoom: 14,
					center: myLatlng,
					mapTypeId: google.maps.MapTypeId.SATELLITE
				};

				map = new Map(document.getElementById("map_canvas"), myOptions);
				//dibuja zonas
				map.setTilt(0);
				//dibuja zonas
				dibuja_zona();

			}

			/* ************************************************************************** */
			function chngZona() {
				idZona = document.getElementById("selectZona").value;
				$(\'#vehiContent_'.$idTab.'\').load(\'principal_update_zonaList_1_transportesAB.php'.$enlace.'&idZona=\' + idZona);
				setMarkers(map, locations, 1);
			}

			/* ************************************************************************** */
			function fncCenterMap(Latitud, Longitud, n_icon){
				latlon = new google.maps.LatLng(Latitud, Longitud);
				map.panTo(latlon);
				//volver todo a normal
				for (let i = 0; i < markers.length; i++) {
					markers[i].setIcon("'.DB_SITE_REPO.'/LIB_assets/img/map-icons/1_series_orange.png");
				}
				//colorear el seleccionado
				markers[n_icon].setIcon("'.DB_SITE_REPO.'/LIB_assets/img/map-icons/1_series_green.png");
			}

			/* ************************************************************************** */
			class MyMarker extends google.maps.OverlayView {
				constructor(params) {
					super();
					this.position = params.position;

					const content = document.createElement(\'div\');
					content.classList.add(\'my_marker\');
					content.textContent = params.label;
					content.style.position = \'absolute\';
					content.style.transform = \'translate(-50%, -100%)\';

					const container = document.createElement(\'div\');
					container.style.position = \'absolute\';
					container.style.cursor = \'pointer\';
					container.appendChild(content);

					this.container = container;
				}

				onAdd() {
					this.getPanes().floatPane.appendChild(this.container);
				}

				onRemove() {
					this.container.remove();
				}

				draw() {
					const pos = this.getProjection().fromLatLngToDivPixel(this.position);
					this.container.style.left = pos.x + \'px\';
					this.container.style.top = pos.y + \'px\';
				}
			}
			/* ************************************************************************** */
			function setMarkers(map, locations, optc) {

				var marker, i, last_latitude, last_longitude;

				for (i = 0; i < locations.length; i++) {

					//defino ubicacion y datos
					let latitude   = locations[i][0];
					let longitude  = locations[i][1];
					let data       = locations[i][2];

					//guardo las ultimas ubicaciones
					last_latitude   = locations[i][0];
					last_longitude  = locations[i][1];

					latlngset = new google.maps.LatLng(latitude, longitude);

					//se crea marcador
					var marker = new google.maps.Marker({
						map         : map,
						position    : latlngset,
						icon      	: "'.DB_SITE_REPO.'/LIB_assets/img/map-icons/1_series_orange.png",
						zIndex:99999999
					});
					markers.push(marker);

					//se define contenido
					var content = 	"<div id=\'iw-container\'>" +
									"<div class=\'iw-title\'>Datos</div>" +
									"<div class=\'iw-content\'>" +
									data +
									"</div>" +
									"<div class=\'iw-bottom-gradient\'></div>" +
									"</div>";

					//se crea infowindow
					var infowindow = new google.maps.InfoWindow();

					//se agrega funcion de click a infowindow
					google.maps.event.addListener(marker,\'click\', (function(marker,content,infowindow){
						return function() {
							infowindow.setContent(content);
							infowindow.open(map,marker);
						};
					})(marker,content,infowindow));

				}
				if(optc==1){
					latlon = new google.maps.LatLng(last_latitude, last_longitude);
					map.panTo(latlon);
				}
			}
			/* ************************************************************************** */
			function transMarker(map, time) {
				var newTime = time / 2;
				setInterval(function(){transMarkerTimer(map)},newTime);
			}
			/* ************************************************************************** */
			var mapax = 0;
			function transMarkerTimer(map) {

				switch(mapax) {
					//Ejecutar formulario con el recorrido y la ruta
					case 1:
						$(\'#map_content_'.$idTab.'\').load(\'principal_update_map_zona_1_crosstech.php'.$enlace.'\');
						$(\'#vehiContent_'.$idTab.'\').load(\'principal_update_zonaList_1_crosstech.php'.$enlace.'\');
						break;
					//se dibujan los iconos
					case 2:
						//Se ocultan y eliminan los iconos
						deleteMarkers();
						setMarkers(map, new_locations, 2);
						//actualizo la hora de actualizacion
						document.getElementById(\'update_text_HoraRefresco\').innerHTML=\'Hora Refresco: \'+HoraRefresco;

						break;
				}

				mapax++;
				if(mapax==3){mapax=1}
			}
			/* ************************************************************************** */
			// Sets the map on all markers in the array.
			function setMapOnAll(map) {
				for (let i = 0; i < markers.length; i++) {
				  markers[i].setMap(map);
				}
			}
			/* ************************************************************************** */
			// Removes the markers from the map, but keeps them in the array.
			function clearMarkers() {
				setMapOnAll(null);
			}
			/* ************************************************************************** */
			// Shows any markers currently in the array.
			function showMarkers() {
				setMapOnAll(map);
			}
			/* ************************************************************************** */
			// Deletes all markers in the array by removing references to them.
			function deleteMarkers() {
				clearMarkers();
				markers = [];
			}
			/* ************************************************************************** */
			function dibuja_zona() {

				var polygons = [];';

				//variables
				$Latitud_z        = 0;
				$Longitud_z       = 0;
				$Latitud_z_prom   = 0;
				$Longitud_z_prom  = 0;
				$zcounter         = 0;
				$zcounter2        = 0;

				//Se filtra por zona
				filtrar($arrPredios, 'idZona');
				//se recorre
				foreach ($arrPredios as $todaszonas=>$zonas) {

					$Latitud_z_2       = 0;
					$Longitud_z_2      = 0;
					$Latitud_z_prom_2  = 0;
					$Longitud_z_prom_2 = 0;
					$zcounter3         = 0;

					$GPS .= 'var path'.$todaszonas.' = [';

					//Variables con la primera posicion
					$Latitud_x = '';
					$Longitud_x = '';

					foreach ($zonas as $puntos) {
						if(isset($puntos['Latitud'], $puntos['Longitud'])&&$puntos['Latitud']!=''&&$puntos['Longitud']!=''){
							$GPS .= '{lat: '.$puntos['Latitud'].', lng: '.$puntos['Longitud'].'},';
							if(isset($puntos['Latitud'], $puntos['Longitud'])&&$puntos['Latitud']!='0'&&$puntos['Longitud']!='0'){
								$Latitud_x  = $puntos['Latitud'];
								$Longitud_x = $puntos['Longitud'];
								//Calculos para centrar mapa
								$Latitud_z    = $Latitud_z+$puntos['Latitud'];
								$Longitud_z   = $Longitud_z+$puntos['Longitud'];
								$Latitud_z_2  = $Latitud_z_2+$puntos['Latitud'];
								$Longitud_z_2 = $Longitud_z_2+$puntos['Longitud'];
								$zcounter++;
								$zcounter3++;
							}
						}
					}
					//se cierra la figura
					if(isset($Longitud_x)&&$Longitud_x!=''){
						$GPS .= '{lat: '.$Latitud_x.', lng: '.$Longitud_x.'}';
					}
					$GPS .= '];';

					$GPS .= '
					polygons.push(new google.maps.Polygon({
						paths: path'.$todaszonas.',
						strokeColor: \'#FF0000\',
						strokeOpacity: 0.8,
						strokeWeight: 2,
						fillColor: \'#FF0000\',
						fillOpacity: 0.35
					}));
					polygons[polygons.length-1].setMap(map);';

					if($zcounter3!=0){
						$Latitud_z_prom_2  = $Latitud_z_2/$zcounter3;
						$Longitud_z_prom_2 = $Longitud_z_2/$zcounter3;
					}

					$GPS .= '
					myLatlng = new google.maps.LatLng('.$Latitud_z_prom_2.', '.$Longitud_z_prom_2.');

					var marker2 = new MyMarker({
						position: myLatlng,
						label: "'.$zonas[0]['Nombre'].'",
						zIndex:9999
					});
					marker2.setMap(map);

					// When the mouse moves within the polygon, display the label and change the BG color.
					google.maps.event.addListener(polygons['.$zcounter2.'], "mousemove", function(event) {
						polygons['.$zcounter2.'].setOptions({
							fillColor: "#00FF00"
						});
					});

					// WHen the mouse moves out of the polygon, hide the label and change the BG color.
					google.maps.event.addListener(polygons['.$zcounter2.'], "mouseout", function(event) {
						polygons['.$zcounter2.'].setOptions({
							fillColor: "#FF0000"
						});
					});';

					$zcounter2++;
				}

				$GPS .= '
				//ubicacion inicial
				setMarkers(map, locations, 1);
				//actualizacion de posicion
				transMarker(map, '.$SegActual.');

			}
		</script>';

		//despliega el resumen
		if(isset($miniwidget)&&$miniwidget==1){
			$GPS .= '<div class="row">';
				$GPS .= widget_Ficha_2('box-yellow', 'fa-truck faa-float animated', $eq_alertas, 4, 'Vehiculos con alertas', 'Equipos', 'principal_gps_view.php?seguimiento='.simpleEncode( 1, fecha_actual()).'&idSistema='.simpleEncode($idSistema, fecha_actual()).'&dataType='.simpleEncode( 1, fecha_actual()), 'Ver Mas', 'btn-warning', 1, 2);
				$GPS .= widget_Ficha_2('box-red', 'fa-truck faa-float animated', $eq_fueralinea, 4, 'Vehiculos fuera de linea', 'Equipos', 'principal_gps_view.php?seguimiento='.simpleEncode( 1, fecha_actual()).'&idSistema='.simpleEncode($idSistema, fecha_actual()).'&dataType='.simpleEncode( 2, fecha_actual()), 'Ver Mas', 'btn-danger', 1, 2);
				$GPS .= widget_Ficha_2('box-orange', 'fa-truck faa-float animated', $eq_fueraruta, 4, 'Vehiculos fuera de ruta', 'Equipos', 'principal_gps_view.php?seguimiento='.simpleEncode( 1, fecha_actual()).'&idSistema='.simpleEncode($idSistema, fecha_actual()).'&dataType='.simpleEncode( 3, fecha_actual()), 'Ver Mas', 'btn-warning', 1, 2);
				$GPS .= widget_Ficha_2('box-purple', 'fa-truck faa-float animated', $eq_gps_fuera, 4, 'Vehiculos sin cobertura GPS', 'Equipos', 'principal_gps_view.php?seguimiento='.simpleEncode( 1, fecha_actual()).'&idSistema='.simpleEncode($idSistema, fecha_actual()).'&dataType='.simpleEncode( 5, fecha_actual()), 'Ver Mas', 'btn-primary', 1, 2);
				$GPS .= widget_Ficha_2('box-green', 'fa-truck faa-float animated', ($eq_ok+$eq_detenidos), 4, 'Vehiculos OK', 'Equipos', 'principal_gps_view.php?seguimiento='.simpleEncode( 1, fecha_actual()).'&idSistema='.simpleEncode($idSistema, fecha_actual()).'&dataType='.simpleEncode( 4, fecha_actual()), 'Ver Mas', 'btn-success', 1, 2);
			$GPS .= '</div>';
		}

		return $GPS;

	}
}
/*******************************************************************************************************************/
//Muestra los equipos
function widget_Equipos_Crosstech($nombreEquipo, $seguimiento, $equipo, $enlace, $idSistema, $idTipoUsuario, $idUsuario, $dbConn){

	//variables
	$HoraSistema    = hora_actual();
	$FechaSistema   = fecha_actual();
	$eq_alertas     = 0;
	$eq_fueralinea  = 0;
	$eq_ok          = 0;

	//Variable
	$SIS_where = "telemetria_listado.idEstado = 1 ";//solo equipos activos
	//Filtro de los tab
	$SIS_where .= " AND telemetria_listado.idTab = 2";//1Tek C
	//solo los equipos que tengan el seguimiento activado
	if(isset($seguimiento)&&$seguimiento!=''&&$seguimiento!=0){
		$SIS_where .= " AND telemetria_listado.id_Geo = ".$seguimiento;
	}
	//Filtro el sistema al cual pertenece
	if(isset($idSistema)&&$idSistema!=''&&$idSistema!=0){
		$SIS_where .= " AND telemetria_listado.idSistema = ".$idSistema;
	}
	//El equipo a ver
	if (isset($equipo)&&$equipo!=''&&$equipo!=0){
		$SIS_where .= " AND telemetria_listado.idTelemetria=".$equipo;
	}
	//Verifico el tipo de usuario que esta ingresando y el id
	$SIS_join  = '';
	if(isset($idTipoUsuario, $idUsuario)&&$idTipoUsuario!=1&&$idUsuario!=0){
		$SIS_join  .= " INNER JOIN usuarios_equipos_telemetria ON usuarios_equipos_telemetria.idTelemetria = telemetria_listado.idTelemetria ";
		$SIS_where .= " AND usuarios_equipos_telemetria.idUsuario = ".$idUsuario;
	}

	/*************************************************************/
	//Se consulta
	$SIS_query = '
	telemetria_listado.LastUpdateFecha,
	telemetria_listado.LastUpdateHora,
	telemetria_listado.cantSensores,
	telemetria_listado.GeoLatitud,
	telemetria_listado.GeoLongitud,
	telemetria_listado.NDetenciones,
	telemetria_listado.TiempoFueraLinea,
	telemetria_listado.NErrores';
	$SIS_order = 'telemetria_listado.Nombre ASC';
	$arrEquipo = array();
	$arrEquipo = db_select_array (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrEquipo');

	foreach ($arrEquipo as $data) {

		/**********************************************/
		//Se resetean
		$in_eq_alertas     = 0;
		$in_eq_fueralinea  = 0;
		$in_eq_ok          = 1;

		/**********************************************/
		//Fuera de linea
		$diaInicio   = $data['LastUpdateFecha'];
		$diaTermino  = $FechaSistema;
		$tiempo1     = $data['LastUpdateHora'];
		$tiempo2     = $HoraSistema;
		$Tiempo      = horas_transcurridas($diaInicio, $diaTermino, $tiempo1, $tiempo2);

		//Comparaciones de tiempo
		$Time_Tiempo     = horas2segundos($Tiempo);
		$Time_Tiempo_FL  = horas2segundos($data['TiempoFueraLinea']);
		$Time_Tiempo_Max = horas2segundos('48:00:00');
		$Time_Fake_Ini   = horas2segundos('23:59:50');
		$Time_Fake_Fin   = horas2segundos('24:00:00');
		//comparacion
		if(($Time_Tiempo<$Time_Fake_Ini OR $Time_Tiempo>$Time_Fake_Fin)&&(($Time_Tiempo>$Time_Tiempo_FL&&$Time_Tiempo_FL!=0) OR ($Time_Tiempo>$Time_Tiempo_Max&&$Time_Tiempo_FL==0))){
			$in_eq_fueralinea++;
		}

		/**********************************************/
		//NErrores
		if(isset($data['NErrores'])&&$data['NErrores']>0){ $in_eq_alertas++; }

		/*******************************************************/
		//rearmo
		if($in_eq_alertas>0){    $in_eq_ok = 0;$in_eq_alertas = 1;    }
		if($in_eq_fueralinea>0){ $in_eq_ok = 0;$in_eq_fueralinea = 1; $in_eq_alertas = 0;}

		//Se guardan los valores
		$eq_alertas     = $eq_alertas + $in_eq_alertas;
		$eq_fueralinea  = $eq_fueralinea + $in_eq_fueralinea;
		$eq_ok          = $eq_ok + $in_eq_ok;

	}


		$GPS = '<div class="row">
			<h3 class="supertittle text-primary">'.$nombreEquipo.'</h3>';
			$GPS .= widget_Ficha_2('box-yellow', 'fa-industry', $eq_alertas, 4, $nombreEquipo.' con alertas', 'Sensores', 'principal_gps_view.php?seguimiento='.simpleEncode($seguimiento, fecha_actual()).'&idSistema='.simpleEncode($idSistema, fecha_actual()).'&dataType='.simpleEncode( 1, fecha_actual()), 'Ver Mas', 'btn-warning', 1, 2);
			$GPS .= widget_Ficha_2('box-red', 'fa-industry', $eq_fueralinea, 4, $nombreEquipo.' fuera de linea', 'Equipos', 'principal_gps_view.php?seguimiento='.simpleEncode($seguimiento, fecha_actual()).'&idSistema='.simpleEncode($idSistema, fecha_actual()).'&dataType='.simpleEncode( 2, fecha_actual()), 'Ver Mas', 'btn-danger', 1, 2);
			$GPS .= widget_Ficha_2('box-blue', 'fa-industry', $eq_ok, 4, $nombreEquipo.' OK', 'Equipos', 'principal_gps_view.php?seguimiento='.simpleEncode($seguimiento, fecha_actual()).'&idSistema='.simpleEncode($idSistema, fecha_actual()).'&dataType='.simpleEncode( 4, fecha_actual()), 'Ver Mas', 'btn-primary', 1, 2);
		$GPS .= '</div>';

	return $GPS;
}
/*******************************************************************************************************************/
//Muestra los promedios de los equipos
function widget_Promedios_equipo_grupos_Crosstech($titulo_cuadro, $seguimiento, $equipo, $enlace, $idSistema, $idTipoUsuario, $idUsuario, $dbConn){

	//Variables
	$HoraSistema    = hora_actual();
	$FechaSistema   = fecha_actual();

	//Variable
	$SIS_where = "telemetria_listado.idEstado = 1 ";//solo equipos activos
	//Filtro de los tab
	$SIS_where .= " AND telemetria_listado.idTab = 2";//1Tek C
	//solo los equipos que tengan el seguimiento activado
	if(isset($seguimiento)&&$seguimiento!=''&&$seguimiento!=0){
		$SIS_where .= " AND telemetria_listado.id_Geo = ".$seguimiento;
	}
	//Filtro el sistema al cual pertenece
	if(isset($idSistema)&&$idSistema!=''&&$idSistema!=0){
		$SIS_where .= " AND telemetria_listado.idSistema = ".$idSistema;
	}
	if (isset($equipo)&&$equipo!=''&&$equipo!=0){
		$SIS_where .= " AND telemetria_listado.idTelemetria=".$equipo;
	}
	//Verifico el tipo de usuario que esta ingresando y el id
	$SIS_join  = '';
	if(isset($idTipoUsuario, $idUsuario)&&$idTipoUsuario!=1&&$idUsuario!=0){
		$SIS_join  .= " INNER JOIN usuarios_equipos_telemetria ON usuarios_equipos_telemetria.idTelemetria = telemetria_listado.idTelemetria ";
		$SIS_where .= " AND usuarios_equipos_telemetria.idUsuario = ".$idUsuario;
	}

	//numero sensores equipo
	$N_Maximo_Sensores = 60;
	$subquery = '';
	for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
		$subquery .= ',telemetria_listado_sensores_med_actual.SensoresMedActual_'.$i;
		$subquery .= ',telemetria_listado_sensores_grupo.SensoresGrupo_'.$i;
		$subquery .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i;
		$subquery .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$i;
	}

	/*************************************************************/
	//Se consulta
	$SIS_query = '
	telemetria_listado.idTelemetria,
	telemetria_listado.Nombre,
	telemetria_listado.LastUpdateHora,
	telemetria_listado.LastUpdateFecha,
	telemetria_listado.cantSensores,
	telemetria_listado.TiempoFueraLinea'.$subquery;
	$SIS_join  .= '
	LEFT JOIN `telemetria_listado_sensores_med_actual`     ON telemetria_listado_sensores_med_actual.idTelemetria     = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_grupo`          ON telemetria_listado_sensores_grupo.idTelemetria          = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_unimed`         ON telemetria_listado_sensores_unimed.idTelemetria         = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_activo`         ON telemetria_listado_sensores_activo.idTelemetria         = telemetria_listado.idTelemetria';
	$SIS_order = 'telemetria_listado.Nombre ASC';
	$arrEquipo = array();
	$arrEquipo = db_select_array (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrEquipo');

	$arrUnimed = array();
	$arrUnimed = db_select_array (false, 'idUniMed,Nombre', 'telemetria_listado_unidad_medida', '', '', 'idUniMed ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrUnimed');

	$arrGrupos = array();
	$arrGrupos = db_select_array (false, 'idGrupo,Nombre,nColumnas', 'telemetria_listado_grupos', '', '', 'idGrupo ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrGrupos');

	$arrFinalUnimed = array();
	$arrFinalGrupos = array();
	foreach ($arrUnimed as $sen) { $arrFinalUnimed[$sen['idUniMed']] = $sen['Nombre'];}
	foreach ($arrGrupos as $sen) { $arrFinalGrupos[$sen['idGrupo']]['Nombre'] = $sen['Nombre']; $arrFinalGrupos[$sen['idGrupo']]['nColumnas'] = $sen['nColumnas']; $arrFinalGrupos[$sen['idGrupo']]['idGrupo'] = $sen['idGrupo'];}

	$GPS = '
	<div class="row">

		<h3 class="supertittle text-primary">'.$titulo_cuadro.'</h3>';

		foreach($arrEquipo as $equip) {

			/***************************************/
			//Fuera de linea
			$diaInicio   = $equip['LastUpdateFecha'];
			$diaTermino  = $FechaSistema;
			$tiempo1     = $equip['LastUpdateHora'];
			$tiempo2     = $HoraSistema;
			$Tiempo      = horas_transcurridas($diaInicio, $diaTermino, $tiempo1, $tiempo2);

			//Comparaciones de tiempo
			$Time_Tiempo     = horas2segundos($Tiempo);
			$Time_Tiempo_FL  = horas2segundos($equip['TiempoFueraLinea']);
			$Time_Tiempo_Max = horas2segundos('48:00:00');
			$Time_Fake_Ini   = horas2segundos('23:59:50');
			$Time_Fake_Fin   = horas2segundos('24:00:00');
			//comparacion
			if(($Time_Tiempo<$Time_Fake_Ini OR $Time_Tiempo>$Time_Fake_Fin)&&(($Time_Tiempo>$Time_Tiempo_FL&&$Time_Tiempo_FL!=0) OR ($Time_Tiempo>$Time_Tiempo_Max&&$Time_Tiempo_FL==0))){
				$wd_color = 'box-red';
			//sino con azul normal
			}else{
				$wd_color = 'box-blue';
			}

			$GPS .= '
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="box '.$wd_color.' box-solid">
					<div class="box-header with-border">
						<h3 class="box-title">'.$equip['Nombre'].'</h3>';
						//<div class="box-tools pull-right">
						//	<a target="_blank" rel="noopener noreferrer" href="principal_telemetria_grupo_alt.php?idTelemetria='.simpleEncode($equip['idTelemetria'], fecha_actual()).'" class="iframe btn btn-xs btn-primary btn-line">Ver Mediciones</a>
						//</div>
						$GPS .= '
					</div>
					<div class="box-body">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
							<h4 class="box-title">Medicion el '.fecha_estandar($equip['LastUpdateFecha']).' a las '.$equip['LastUpdateHora'].' hrs</h4>
						</div>';

							//Variables
							$arrGruposTitulo = array();

							for ($i = 1; $i <= $equip['cantSensores']; $i++) {
								//solo sensores activos
								if(isset($equip['SensoresActivo_'.$i])&&$equip['SensoresActivo_'.$i]==1){
									//Unidad medida
									if(isset($arrFinalUnimed[$equip['SensoresUniMed_'.$i]])){
										$unimed = ' '.$arrFinalUnimed[$equip['SensoresUniMed_'.$i]];
									}else{
										$unimed = '';
									}
									//Titulo del cuadro
									if(isset($arrFinalGrupos[$equip['SensoresGrupo_'.$i]]['Nombre'])){
										$Titulo    = $arrFinalGrupos[$equip['SensoresGrupo_'.$i]]['Nombre'];
									}else{
										$Titulo    = '';
									}
									if(isset($arrFinalGrupos[$equip['SensoresGrupo_'.$i]]['nColumnas'])){
										$nColumnas = $arrFinalGrupos[$equip['SensoresGrupo_'.$i]]['nColumnas'];
									}else{
										$nColumnas = '';
									}
									if(isset($arrFinalGrupos[$equip['SensoresGrupo_'.$i]]['idGrupo'])){
										$s_idGrupo = $arrFinalGrupos[$equip['SensoresGrupo_'.$i]]['idGrupo'];
									}else{
										$s_idGrupo = '';
									}
									//Guardo el valor correspondiente
									$arrGruposTitulo[$Titulo][$i]['Color']     = 0;
									$arrGruposTitulo[$Titulo][$i]['valor']     = $equip['SensoresMedActual_'.$i];
									$arrGruposTitulo[$Titulo][$i]['unimed']    = $unimed;
									$arrGruposTitulo[$Titulo][$i]['nColumnas'] = $nColumnas;
									$arrGruposTitulo[$Titulo][$i]['idGrupo']   = $s_idGrupo;
								}
							}

							//echo '<pre>';
							//var_dump($arrGruposTitulo);
							//echo '</pre>';

							//Ordenamiento por titulo de grupo
							$names = array();
							foreach ($arrGruposTitulo as $titulo=>$items) {
								$names[] = $titulo;
							}
							array_multisort($names, SORT_ASC, $arrGruposTitulo);

							//se recorre el arreglo
							foreach($arrGruposTitulo as $titulo=>$items) {

								//variables
								$ndatacol    = 0;
								$total_col1  = 0;
								$total_col2  = 0;
								$ntotal_col1 = 0;
								$ntotal_col2 = 0;
								$unimed_col1 = '';
								$unimed_col2 = '';
								$xs_idGrupo  = 0;
								$y           = 1;
								//$xs_Color    = 'blue';
								$xs_Color    = 0;

								foreach($items as $datos) {
									//asigno el grupo
									$xs_idGrupo  = $datos['idGrupo'];
									$xs_Color    = $xs_Color + $datos['Color'];

									//si el grupo solo tiene una columna
									if(isset($datos['nColumnas'])&&$datos['nColumnas']==1){
										//Especifico el numero de columnas
										$ndatacol = 1;
										//Verifico que el dato no sea 99900
										if(isset($datos['valor'])&&$datos['valor']<99900){
											$total_col1 = $total_col1 + $datos['valor'];
											$ntotal_col1++;
										}
										$unimed_col1 = $datos['unimed'];

									//si el grupo tiene 2 columnas
									}elseif(isset($datos['nColumnas'])&&$datos['nColumnas']==2){
										//Especifico el numero de columnas
										$ndatacol = 2;
										//Se guardan los datos
										if($y==1){
											//Verifico que el dato no sea 99900
											if(isset($datos['valor'])&&$datos['valor']<99900){
												$total_col1 = $total_col1 + $datos['valor'];
												$ntotal_col1++;
											}
											$unimed_col1 = $datos['unimed'];
											$y=2;
										}else{
											//Verifico que el dato no sea 99900
											if(isset($datos['valor'])&&$datos['valor']<99900){
												$total_col2 = $total_col2 + $datos['valor'];
												$ntotal_col2++;
											}
											$unimed_col2 = $datos['unimed'];
											$y=1;
										}
									}
								}

								/*************************************************/
								if(isset($xs_Color)&&$xs_Color==0){
									$ss_color = 'blue';
									$sy_color = 'btn-primary';
								}else{
									$ss_color = 'yellow';
									$sy_color = 'btn-warning';
								}
								$GPS .= '
								<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
									<div class="box box-'.$ss_color.' box-solid">
										<div class="box-header with-border">
											<h3 class="box-title">Grupo</h3>
											<div class="box-tools pull-right">
												<a target="_blank" rel="noopener noreferrer" href="principal_telemetria_grupo_alt_2.php?idTelemetria='.simpleEncode($equip['idTelemetria'], fecha_actual()).'&idGrupo='.simpleEncode($xs_idGrupo, fecha_actual()).'&titulo='.simpleEncode($titulo, fecha_actual()).'" class="iframe btn btn-xs '.$sy_color.' btn-line">Ver Mediciones</a>
											</div>
										</div>
										<div class="box-body">
											<table id="dataTable" class="table table-bordered table-condensed table-hover dataTable">
												<tbody role="alert" aria-live="polite" aria-relevant="all">';

													//Titulo
													$GPS .= '<tr class="odd">';
													$GPS .= '<td colspan="2">'.TituloMenu($titulo).'</td>';
													$GPS .= '</tr>';

													//datos
													$GPS .= '<tr class="odd">';
														/***********************/
														if($ndatacol==1){
															if($ntotal_col1!=0){$GPS .= '<td colspan="2">'.Cantidades(($total_col1/$ntotal_col1), 1).$unimed_col1.'</td>';}else{$GPS .= '<td colspan="2">0'.$unimed_col1.'</td>';}
														}elseif($ndatacol==2){
															if($ntotal_col1!=0){$GPS .= '<td>'.Cantidades(($total_col1/$ntotal_col1), 1).$unimed_col1.'</td>';}else{$GPS .= '<td>0'.$unimed_col1.'</td>';}
															if($ntotal_col2!=0){$GPS .= '<td>'.Cantidades(($total_col2/$ntotal_col2), 1).$unimed_col2.'</td>';}else{$GPS .= '<td>0'.$unimed_col2.'</td>';}
														}

													$GPS .= '</tr>
												</tbody>
											</table>

										</div>
									</div>
								</div>';

							}

							$GPS .= '

						<div class="clearfix"></div>
					</div>
				</div>
			</div>';
		}

	$GPS .= '</div> ';

	return $GPS;
}
/*******************************************************************************************************************/
//Muestra la gestion de equipos
function widget_Gestion_Equipos_CrossTech($titulo,$idSistema, $IDGoogle, $idTipoUsuario, $idUsuario,
										  $SegActual, $idTab, $miniwidget, $dbConn){

	//Si no existe una ID se utiliza una por defecto
	if(!isset($IDGoogle) OR $IDGoogle==''){
		return alert_post_data(4,1,1,0, 'No ha ingresado Una API de Google Maps');
	}else{

		//variables
		$HoraSistema    = hora_actual();
		$FechaSistema   = fecha_actual();
		$eq_alertas     = 0;
		$eq_fueralinea  = 0;
		$eq_ok          = 0;

		$google = $IDGoogle;

		//enlace para redireccionar
		$enlace  = "?dd=true";
		$enlace .= "&idTipoUsuario=".$idTipoUsuario;
		$enlace .= "&idSistema=".$idSistema;
		$enlace .= "&idUsuario=".$idUsuario;
		$enlace .= "&idTab=".$idTab;

		//Variable
		$SIS_where = "telemetria_listado.idEstado = 1 ";//solo equipos activos
		//solo los equipos que tengan el seguimiento desactivado
		$SIS_where .= " AND telemetria_listado.id_Geo = 2";
		//Filtro de los tab
		$SIS_where .= " AND telemetria_listado.idTab = ".$idTab;
		//Filtro el sistema al cual pertenece
		if(isset($idSistema)&&$idSistema!=''&&$idSistema!=0){
			$SIS_where .= " AND telemetria_listado.idSistema = ".$idSistema;
		}
		//Verifico el tipo de usuario que esta ingresando y el id
		$SIS_join  = '';
		if(isset($idTipoUsuario, $idUsuario)&&$idTipoUsuario!=1&&$idUsuario!=0){
			$SIS_join  .= ' INNER JOIN usuarios_equipos_telemetria ON usuarios_equipos_telemetria.idTelemetria = telemetria_listado.idTelemetria ';
			$SIS_where .= ' AND usuarios_equipos_telemetria.idUsuario = '.$idUsuario;
		}

		//numero sensores equipo
		$N_Maximo_Sensores = 10;
		$subquery = '';
		for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
			$subquery .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$i;
			$subquery .= ',telemetria_listado_sensores_med_actual.SensoresMedActual_'.$i;
			$subquery .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i;
			$subquery .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$i;
		}

		/*************************************************************/
		//Se consulta
		$SIS_query = '
		telemetria_listado.idTelemetria,
		telemetria_listado.idTelemetria AS ID,
		telemetria_listado.Nombre,
		telemetria_listado.LastUpdateFecha,
		telemetria_listado.LastUpdateHora,
		telemetria_listado.cantSensores,
		telemetria_listado.GeoLatitud,
		telemetria_listado.GeoLongitud,
		telemetria_listado.TiempoFueraLinea,
		telemetria_listado.NErrores,
		telemetria_listado.id_Sensores,
		telemetria_listado.SensorActivacionID,
		telemetria_listado.SensorActivacionValor,
		(SELECT Helada FROM telemetria_listado_aux_equipo WHERE idTelemetria = ID ORDER BY idAuxiliar DESC LIMIT 1) AS TempProyectada
		'.$subquery;
		$SIS_join .= '
		LEFT JOIN `telemetria_listado_sensores_nombre`          ON telemetria_listado_sensores_nombre.idTelemetria         = telemetria_listado.idTelemetria
		LEFT JOIN `telemetria_listado_sensores_med_actual`      ON telemetria_listado_sensores_med_actual.idTelemetria     = telemetria_listado.idTelemetria
		LEFT JOIN `telemetria_listado_sensores_unimed`          ON telemetria_listado_sensores_unimed.idTelemetria         = telemetria_listado.idTelemetria
		LEFT JOIN `telemetria_listado_sensores_activo`          ON telemetria_listado_sensores_activo.idTelemetria         = telemetria_listado.idTelemetria';
		$SIS_order = 'telemetria_listado.Nombre ASC';
		$arrEquipo = array();
		$arrEquipo = db_select_array (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrEquipo');

		/*************************************************************/
		//Se traen todas las unidades de medida
		$arrUnimed = array();
		$arrUnimed = db_select_array (false, 'idUniMed,Nombre', 'telemetria_listado_unidad_medida', '', '', 'idUniMed ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrUnimed');

		//Ordeno las unidades de medida
		$arrFinalUnimed = array();
		foreach ($arrUnimed as $data) {
			$arrFinalUnimed[$data['idUniMed']] = $data['Nombre'];
		}

		/*************************************************************/
		//se traen todas las zonas
		$arrZonas = array();
		$arrZonas = db_select_array (false, 'idZona,Nombre', 'vehiculos_zonas', '', '', 'idZona ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrUnimed');

		//defino la variable temporal de la zona
		$_SESSION['usuario']['zona']['idZona']         = 9999;
		$_SESSION['usuario']['zona']['id_Geo']         = 2;
		$_SESSION['usuario']['zona']['idTipoUsuario']  = $idTipoUsuario;
		$_SESSION['usuario']['zona']['idSistema']      = $idSistema;
		$_SESSION['usuario']['zona']['idUsuario']      = $idUsuario;

		$GPS = '
		<script async src="https://maps.googleapis.com/maps/api/js?key='.$google.'&callback=initMap"></script>
		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
		<script type="text/javascript">google.charts.load(\'current\', {\'packages\':[\'bar\', \'corechart\', \'table\', \'gauge\']});</script>

		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="box">
					<header>
						<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>'.$titulo.'</h5>
					</header>
					<div class="table-responsive">
						<div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
							<div class="row">
								<div id="vehiContent" class="table-wrapper-scroll-y my-custom-scrollbar">
									<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
										<thead>
											<tr role="row">
												<th colspan="8">
													<div class="field">
														<select name="selectZona" id="selectZona" class="form-control" onchange="chngZona()" >';
															//La opción todos
															$GPS .= '<option value="9999" selected="selected" >Todas las Zonas</option>';
															foreach ( $arrZonas as $select ) {
																$GPS .= '<option value="'.$select['idZona'].'" >'.$select['Nombre'].'</option>';
															}
														$GPS .= '
														</select>
													</div>
												</th>
											</tr>';
											$GPS .= widget_sherlock(1, 8, 'TableFiltered');
											$GPS .= '
											<tr role="row">
												<th></th>
												<th>Equipo</th>
												<th>Temp.</th>
												<th>Temp. Proy.</th>
												<th>Hum.</th>
												<th>P. Rocio</th>
												<th>Presion</th>
												<th></th>
											</tr>
										</thead>
										<tbody role="alert" aria-live="polite" aria-relevant="all" id="TableFiltered">';
											$nicon = 0;
											foreach ($arrEquipo as $data) {

												/**********************************************/
												//Se resetean
												$in_eq_alertas     = 0;
												$in_eq_fueralinea  = 0;
												$in_eq_ok          = 1;

												/**********************************************/
												//Fuera de linea
												$diaInicio   = $data['LastUpdateFecha'];
												$diaTermino  = $FechaSistema;
												$tiempo1     = $data['LastUpdateHora'];
												$tiempo2     = $HoraSistema;
												$Tiempo      = horas_transcurridas($diaInicio, $diaTermino, $tiempo1, $tiempo2);

												//Comparaciones de tiempo
												$Time_Tiempo     = horas2segundos($Tiempo);
												$Time_Tiempo_FL  = horas2segundos($data['TiempoFueraLinea']);
												$Time_Tiempo_Max = horas2segundos('48:00:00');
												$Time_Fake_Ini   = horas2segundos('23:59:50');
												$Time_Fake_Fin   = horas2segundos('24:00:00');
												//comparacion
												if(($Time_Tiempo<$Time_Fake_Ini OR $Time_Tiempo>$Time_Fake_Fin)&&(($Time_Tiempo>$Time_Tiempo_FL&&$Time_Tiempo_FL!=0) OR ($Time_Tiempo>$Time_Tiempo_Max&&$Time_Tiempo_FL==0))){
													$in_eq_fueralinea++;
												}

												/**********************************************/
												//Equipos Errores
												if(isset($data['NErrores'])&&$data['NErrores']>0){ $in_eq_alertas++; }

												/*******************************************************/
												//rearmo
												if($in_eq_alertas>0){    $in_eq_ok = 0;$in_eq_alertas = 1;    }
												if($in_eq_fueralinea>0){ $in_eq_ok = 0;$in_eq_fueralinea = 1; $in_eq_alertas = 0;  }

												/*******************************************************/
												//se guardan estados
												$danger = '';
												if($in_eq_alertas>0){    $danger = 'warning';  $dataex = '<a href="#" title="Equipo con Alertas"        class="btn btn-warning btn-sm tooltip"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></a>';}
												if($in_eq_fueralinea>0){ $danger = 'danger';   $dataex = '<a href="#" title="Fuera de Linea"            class="btn btn-danger btn-sm tooltip"><i class="fa fa-chain-broken" aria-hidden="true"></i></a>';}

												/*******************************************************/
												//Se guardan los valores
												$eq_alertas     = $eq_alertas + $in_eq_alertas;
												$eq_fueralinea  = $eq_fueralinea + $in_eq_fueralinea;
												$eq_ok          = $eq_ok + $in_eq_ok;

												/*******************************************************/
												//Verifico que este activo si la configuracion esta correcta
												$eq_act_btn = '';
												$eq_act_med = 70;
												//verifico la configuracion
												if(isset($data['SensorActivacionID'])&&$data['SensorActivacionID']!=0){
													//verifico que sensor de activacion sea superior al valor establecido
													if(isset($data['SensoresMedActual_'.$data['SensorActivacionID']])&&$data['SensoresMedActual_'.$data['SensorActivacionID']]>=$data['SensorActivacionValor']){
														$eq_act_btn = '<a href="#" title="Equipo Encendido" class="btn btn-default btn-sm tooltip"><span style="color:#5cb85c;"><i class="fa fa-toggle-on" aria-hidden="true"></i></span></a>';
														$eq_act_med = 105;
													//equipo apagado
													}else{
														$eq_act_btn = '<a href="#" title="Equipo Apagado"  class="btn btn-default btn-sm tooltip"><span style="color:#d9534f;"><i class="fa fa-toggle-off" aria-hidden="true"></i></span></a>';
														$eq_act_med = 105;
													}
												}

												/*******************************************************/
												//traspasan los estados
												if($in_eq_ok==1){
													$eq_ok_icon = '<a href="#" title="Sin Problemas" class="btn btn-success btn-sm tooltip"><i class="fa fa-check" aria-hidden="true"></i></a>';
												}else{
													$eq_ok_icon = $dataex;
												}
												$GPS .= '
												<tr class="odd '.$danger.'">
													<td width="10">
														<div class="btn-group" style="width: 35px;" >'.$eq_ok_icon.'</div>
													</td>
													<td>';
														$GPS .= $data['Nombre'].'<br/>
														'.fecha_estandar($data['LastUpdateFecha']).' '.$data['LastUpdateHora'].'
													</td>';
													$GPS .= '<td>'.cantidades($data['SensoresMedActual_1'], 1).'°C</td>';
													$GPS .= '<td>'.cantidades($data['TempProyectada'], 1).'°C</td>';
													$GPS .= '<td>'.cantidades($data['SensoresMedActual_2'], 0).'%</td>';
													$GPS .= '<td>'.cantidades($data['SensoresMedActual_3'], 0).'°C</td>';
													$GPS .= '<td>'.cantidades($data['SensoresMedActual_4'], 0).' hPa</td>';
													$GPS .= '
													<td width="10">
														<div class="btn-group" style="width: '.$eq_act_med.'px;" >
															'.$eq_act_btn.'
															<a href="view_crosstech_tel_data.php?idTelemetria='.simpleEncode($data['idTelemetria'], fecha_actual()).'" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
															<button onclick="fncCenterMap(\''.$data['GeoLatitud'].'\', \''.$data['GeoLongitud'].'\', \''.$nicon.'\')" title="Ver Ubicación" class="btn btn-default btn-sm tooltip"><i class="fa fa-map-marker" aria-hidden="true"></i></button>
														</div>
													</td>
												</tr>';
												$nicon++;
											}
											$GPS .= '
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
							<div class="row">
								<div id="map_canvas" style="width: 100%; height: 550px;"></div>
								<div id="consulta"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<style>
		.my-custom-scrollbar {
			position: relative;
			height: 550px;
			overflow: auto;
		}
		.table-wrapper-scroll-y {
			display: block;
		}
		</style>

		<script>
			let map;
			var markers = [];

			async function initMap() {
				const { Map } = await google.maps.importLibrary("maps");

				var myLatlng = new google.maps.LatLng(-33.477271996598965, -70.65170304882815);

				var myOptions = {
					zoom: 12,
					center: myLatlng,
					mapTypeId: google.maps.MapTypeId.ROADMAP
				};

				map = new Map(document.getElementById("map_canvas"), myOptions);
				//Ubicación de los distintos dispositivos
				var locations = [ ';
					foreach ( $arrEquipo as $data ) {
						//burbuja
						$explanation  = '<div class="iw-subTitle">Equipo: '.$data['Nombre'].'</div>';
						$explanation .= 'Actualizado: '.fecha_estandar($data['LastUpdateFecha']).' - '.$data['LastUpdateHora'].'</p>';
						//verifico si tiene sensores configurados
						if(isset($data['id_Sensores'])&&$data['id_Sensores']==1){
							$explanation .= '<div class="iw-subTitle">Sensores: </div><p>';
							for ($i = 1; $i <= $data['cantSensores']; $i++) {
								//verifico que sensor este activo
								if(isset($data['SensoresActivo_'.$i])&&$data['SensoresActivo_'.$i]==1){
									//Unidad medida
									if(isset($arrFinalUnimed[$data['SensoresUniMed_'.$i]])){
										$unimed = ' '.$arrFinalUnimed[$data['SensoresUniMed_'.$i]];
									}else{
										$unimed = '';
									}
									//cadena
									if(isset($data['SensoresMedActual_'.$i])&&$data['SensoresMedActual_'.$i]<99900){$xdata=Cantidades($data['SensoresMedActual_'.$i], 2).$unimed;}else{$xdata='Sin Datos';}
									$explanation .= $data['SensoresNombre_'.$i].' : '.$xdata.'<br/>';
								}
							}
							$explanation .= '</p>';
						}
						//se arma dato
						$GPS .= "[";
							$GPS .= $data['GeoLatitud'];
							$GPS .= ", ".$data['GeoLongitud'];
							$GPS .= ", '".$explanation."'";
						$GPS .= "], ";
					}
				$GPS .= '];

				//ubicacion inicial
				setMarkers(map, locations, 1);
				//actualizacion de posicion
				transMarker(map, '.$SegActual.');

			}

			/* ************************************************************************** */
			function chngZona() {
				idZona = document.getElementById("selectZona").value;
				$(\'#vehiContent\').load(\'principal_update_zonaList_2_crosstech.php'.$enlace.'&idZona=\' + idZona);
				setMarkers(map, locations, 1);
			}

			/* ************************************************************************** */
			function fncCenterMap(Latitud, Longitud, n_icon){
				latlon = new google.maps.LatLng(Latitud, Longitud);
				map.panTo(latlon);
				//volver todo a normal
				for (let i = 0; i < markers.length; i++) {
					markers[i].setIcon("'.DB_SITE_REPO.'/LIB_assets/img/map-icons/1_series_orange.png");
				}
				//colorear el seleccionado
				markers[n_icon].setIcon("'.DB_SITE_REPO.'/LIB_assets/img/map-icons/1_series_green.png");
			}

			/* ************************************************************************** */
			function setMarkers(map, locations, optc) {

				var marker, i, last_latitude, last_longitude;

				for (i = 0; i < locations.length; i++) {

					//defino ubicacion y datos
					let latitude   = locations[i][0];
					let longitude  = locations[i][1];
					let data       = locations[i][2];

					//guardo las ultimas ubicaciones
					last_latitude   = locations[i][0];
					last_longitude  = locations[i][1];

					latlngset = new google.maps.LatLng(latitude, longitude);

					//se crea marcador
					var marker = new google.maps.Marker({
						map         : map,
						position    : latlngset,
						icon      	: "'.DB_SITE_REPO.'/LIB_assets/img/map-icons/1_series_orange.png"
					});
					markers.push(marker);

					//se define contenido
					var content = 	"<div id=\'iw-container\'>" +
									"<div class=\'iw-title\'>Datos</div>" +
									"<div class=\'iw-content\'>" +
									data +
									"</div>" +
									"<div class=\'iw-bottom-gradient\'></div>" +
									"</div>";

					//se crea infowindow
					var infowindow = new google.maps.InfoWindow();

					//se agrega funcion de click a infowindow
					google.maps.event.addListener(marker,\'click\', (function(marker,content,infowindow){
						return function() {
							infowindow.setContent(content);
							infowindow.open(map,marker);
						};
					})(marker,content,infowindow));

				}
				if(optc==1){
					latlon = new google.maps.LatLng(last_latitude, last_longitude);
					map.panTo(latlon);
				}
			}
			/* ************************************************************************** */
			function transMarker(map, time) {
				var newTime = time / 2;
				setInterval(function(){transMarkerTimer(map)},newTime);
			}
			/* ************************************************************************** */
			var mapax = 0;
			function transMarkerTimer(map) {

				switch(mapax) {
					//Ejecutar formulario con el recorrido y la ruta
					case 1:
						$(\'#consulta\').load(\'principal_update_map_zona_2_crosstech.php'.$enlace.'\');
						$(\'#vehiContent\').load(\'principal_update_zonaList_2_crosstech.php'.$enlace.'\');
						break;
					//se dibujan los iconos
					case 2:
						//Se ocultan y eliminan los iconos
						deleteMarkers();
						setMarkers(map, new_locations, 2);
						//actualizo la hora de actualizacion
						document.getElementById(\'update_text_HoraRefresco\').innerHTML=\'Hora Refresco: \'+HoraRefresco;

						break;
				}

				mapax++;
				if(mapax==3){mapax=1}
			}
			/* ************************************************************************** */
			// Sets the map on all markers in the array.
			function setMapOnAll(map) {
				for (let i = 0; i < markers.length; i++) {
				markers[i].setMap(map);
				}
			}
			/* ************************************************************************** */
			// Removes the markers from the map, but keeps them in the array.
			function clearMarkers() {
				setMapOnAll(null);
			}
			/* ************************************************************************** */
			// Shows any markers currently in the array.
			function showMarkers() {
				setMapOnAll(map);
			}
			/* ************************************************************************** */
			// Deletes all markers in the array by removing references to them.
			function deleteMarkers() {
				clearMarkers();
				markers = [];
			}

		</script>

		';

		//despliega el resumen
		if(isset($miniwidget)&&$miniwidget==1){
			$GPS .= '<div class="row">';
				$GPS .= widget_Ficha_2('box-yellow', 'fa-industry', $eq_alertas, 4, 'Equipos con alertas', 'Sensores', 'principal_gps_view.php?seguimiento='.simpleEncode( 2, fecha_actual()).'&idSistema='.simpleEncode($idSistema, fecha_actual()).'&dataType='.simpleEncode( 1, fecha_actual()), 'Ver Mas', 'btn-warning', 1, 2);
				$GPS .= widget_Ficha_2('box-red', 'fa-industry', $eq_fueralinea, 4, 'Equipos fuera de linea', 'Equipos', 'principal_gps_view.php?seguimiento='.simpleEncode( 2, fecha_actual()).'&idSistema='.simpleEncode($idSistema, fecha_actual()).'&dataType='.simpleEncode( 2, fecha_actual()), 'Ver Mas', 'btn-danger', 1, 2);
				$GPS .= widget_Ficha_2('box-blue', 'fa-industry', $eq_ok, 4, 'Equipos OK', 'Equipos', 'principal_gps_view.php?seguimiento='.simpleEncode( 2, fecha_actual()).'&idSistema='.simpleEncode($idSistema, fecha_actual()).'&dataType='.simpleEncode( 4, fecha_actual()), 'Ver Mas', 'btn-primary', 1, 2);
			$GPS .= '</div>';
		}

		return $GPS;

	}
}
/*******************************************************************************************************************/
//Muestra la gestion de equipos decrosscrane
function widget_Gestion_Equipos_crosscrane($titulo,$idSistema, $IDGoogle, $idTipoUsuario, $idUsuario, $SegActual, $dbConn){

	//Si no existe una ID se utiliza una por defecto
	if(!isset($IDGoogle) OR $IDGoogle==''){
		return alert_post_data(4,1,1,0, 'No ha ingresado Una API de Google Maps');
	}else{

		//variables
		$HoraSistema    = hora_actual();
		$FechaSistema   = fecha_actual();
		$Fecha_inicio   = restarDias(fecha_actual(),1);
		$Fecha_fin      = fecha_actual();
		$principioMes   = fecha2Ano($FechaSistema).'-'.fecha2NMes($FechaSistema).'-01';
		$google         = $IDGoogle;

		//enlace para redireccionar
		$enlace  = "?dd=true";
		$enlace .= "&idTipoUsuario=".$idTipoUsuario;
		$enlace .= "&idSistema=".$idSistema;
		$enlace .= "&idUsuario=".$idUsuario;

		//Variable
		$SIS_where = "telemetria_listado.idEstado = 1 ";//solo equipos activos
		//solo los equipos que tengan el seguimiento desactivado
		$SIS_where .= " AND telemetria_listado.id_Geo = 2";
		//Filtro el sistema al cual pertenece
		if(isset($idSistema)&&$idSistema!=''&&$idSistema!=0){
			$SIS_where .= " AND telemetria_listado.idSistema = ".$idSistema;
		}
		//Verifico el tipo de usuario que esta ingresando y el id
		$SIS_join  = '';
		if(isset($idTipoUsuario, $idUsuario)&&$idTipoUsuario!=1&&$idUsuario!=0){
			$SIS_join  .= ' INNER JOIN usuarios_equipos_telemetria ON usuarios_equipos_telemetria.idTelemetria = telemetria_listado.idTelemetria ';
			$SIS_where .= ' AND usuarios_equipos_telemetria.idUsuario = '.$idUsuario;
		}
		//Solo para plataforma 1tek
		$SIS_where .= " AND telemetria_listado.idTab=6";//Power-Crane

		//numero sensores equipo
		$N_Maximo_Sensores = 72;
		$subquery = '';
		for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
			$subquery .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$i;
			$subquery .= ',telemetria_listado_sensores_med_actual.SensoresMedActual_'.$i;
			$subquery .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i;
			$subquery .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$i;
		}

		/*************************************************************/
		//Se consulta
		$SIS_query = '
		telemetria_listado.idTelemetria,
		telemetria_listado.Nombre,
		telemetria_listado.Identificador,
		telemetria_listado.NumSerie,
		telemetria_listado.LastUpdateFecha,
		telemetria_listado.LastUpdateHora,
		telemetria_listado.cantSensores,
		telemetria_listado.GeoLatitud,
		telemetria_listado.GeoLongitud,
		telemetria_listado.TiempoFueraLinea,
		telemetria_listado.NErrores,
		telemetria_listado.NAlertas,
		telemetria_listado.id_Sensores,
		telemetria_listado.idGenerador,
		telemetria_listado.idTelGenerador,
		telemetria_listado.SensorActivacionID,
		telemetria_listado.SensorActivacionValor,
		telemetria_listado.idUsoFTP,
		telemetria_listado.FTP_Carpeta'.$subquery;
		$SIS_join .= '
		LEFT JOIN `telemetria_listado_sensores_nombre`          ON telemetria_listado_sensores_nombre.idTelemetria         = telemetria_listado.idTelemetria
		LEFT JOIN `telemetria_listado_sensores_med_actual`      ON telemetria_listado_sensores_med_actual.idTelemetria     = telemetria_listado.idTelemetria
		LEFT JOIN `telemetria_listado_sensores_unimed`          ON telemetria_listado_sensores_unimed.idTelemetria         = telemetria_listado.idTelemetria
		LEFT JOIN `telemetria_listado_sensores_activo`          ON telemetria_listado_sensores_activo.idTelemetria         = telemetria_listado.idTelemetria';
		$SIS_order = 'telemetria_listado.Nombre ASC';
		$arrEquipo = array();
		$arrEquipo = db_select_array (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrEquipo');

		/*************************************************************/
		//Se traen todas las unidades de medida
		$arrUnimed = array();
		$arrUnimed = db_select_array (false, 'idUniMed,Nombre', 'telemetria_listado_unidad_medida', '', '', 'idUniMed ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrUnimed');

		//Ordeno las unidades de medida
		$arrFinalUnimed = array();
		foreach ($arrUnimed as $data) {
			$arrFinalUnimed[$data['idUniMed']] = $data['Nombre'];
		}

		/*************************************************************/
		//se traen todas las zonas
		$arrZonas = array();
		$arrZonas = db_select_array (false, 'idZona,Nombre', 'telemetria_zonas', '', '', 'idZona ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrUnimed');

		//defino la variable temporal de la zona
		$_SESSION['usuario']['zona']['idZona']         = 9999;
		$_SESSION['usuario']['zona']['id_Geo']         = 2;
		$_SESSION['usuario']['zona']['idTipoUsuario']  = $idTipoUsuario;
		$_SESSION['usuario']['zona']['idSistema']      = $idSistema;
		$_SESSION['usuario']['zona']['idUsuario']      = $idUsuario;

		$nicon    = 0;
		$arrGruas = array();

		//transaccion a verificar
		$transx = "admin_telemetria_encendido_apagado.php";   //Transaccion de encendido-apagado

		//Seteo la variable a 0
		$prm_xa = 0;
		//recorro los permisos
		if(isset($_SESSION['usuario']['menu'])){
			foreach($_SESSION['usuario']['menu'] as $menu=>$productos) {
				foreach($productos as $producto) {
					//elimino los datos extras
					$str = str_replace("?pagina=1", "", $producto['TransaccionURL']);
					//le asigno el valor 1 en caso de que exista
					if($transx==$str){
						$prm_xa = 1;
					}
				}
			}
		}

		foreach ($arrEquipo as $data) {

			/**********************************************/
			//Se resetean
			$in_eq_alertas     = 0;
			$in_eq_fueralinea  = 0;
			$in_eq_ok          = 1;
			$in_sens_activ     = 0;

			/**********************************************/
			//veo si tiene configurado el sensor de activacion y si esta encendido
			if(isset($data['SensorActivacionID'])&&$data['SensorActivacionID']!=0){
				if(isset($data['SensoresMedActual_'.$data['SensorActivacionID']])&&$data['SensoresMedActual_'.$data['SensorActivacionID']]==$data['SensorActivacionValor']){
					$in_sens_activ = 1; //activo encendido
				}else{
					$in_sens_activ = 2; //activo apagado
				}
			}else{
				$in_sens_activ = 0; //inactivo
			}

			/**********************************************/
			//Fuera de linea
			$diaInicio   = $data['LastUpdateFecha'];
			$diaTermino  = $FechaSistema;
			$tiempo1     = $data['LastUpdateHora'];
			$tiempo2     = $HoraSistema;
			$Tiempo      = horas_transcurridas($diaInicio, $diaTermino, $tiempo1, $tiempo2);

			//Comparaciones de tiempo
			$Time_Tiempo     = horas2segundos($Tiempo);
			$Time_Tiempo_FL  = horas2segundos($data['TiempoFueraLinea']);
			$Time_Tiempo_Max = horas2segundos('48:00:00');
			$Time_Fake_Ini   = horas2segundos('23:59:50');
			$Time_Fake_Fin   = horas2segundos('24:00:00');
			//comparacion
			if(($Time_Tiempo<$Time_Fake_Ini OR $Time_Tiempo>$Time_Fake_Fin)&&(($Time_Tiempo>$Time_Tiempo_FL&&$Time_Tiempo_FL!=0) OR ($Time_Tiempo>$Time_Tiempo_Max&&$Time_Tiempo_FL==0))){
				$in_eq_fueralinea++;
			}

			/**********************************************/
			//Equipos Errores
			if(isset($data['NErrores'])&&$data['NErrores']>0){ $in_eq_alertas++; }

			/*******************************************************/
			//rearmo
			if($in_eq_alertas>0){    $in_eq_ok = 0;  $in_eq_alertas    = 1;    }
			if($in_eq_fueralinea>0){ $in_eq_ok = 0;  $in_eq_fueralinea = 1; $in_eq_alertas = 0;  }

			/*******************************************************/
			//se guardan estados
			$danger = '';
			$xdanger = 1;
			if($in_eq_alertas>0){    $danger = 'warning';  $xdanger = 2; $dataex = '<a href="#" title="Equipo con Alertas"        class="btn btn-warning btn-sm tooltip"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></a>';}
			if($in_eq_fueralinea>0){ $danger = 'danger';   $xdanger = 3; $dataex = '<a href="#" title="Fuera de Linea"            class="btn btn-danger btn-sm tooltip"><i class="fa fa-chain-broken" aria-hidden="true"></i></a>';}

			/*******************************************************/
			//traspasan los estados
			if($in_eq_ok==1){
				$eq_ok_icon = '<a href="#" title="Sin Problemas" class="btn btn-success btn-sm tooltip"><i class="fa fa-check" aria-hidden="true"></i></a>';
			}else{
				$eq_ok_icon = $dataex;
			}
			/*******************************************************/
			//El icono de estado de encendido apagado
			$idSensorResp = 38; //sensor que guarda la respuesta del equipo
			//si tiene los permisos
			if(isset($data['SensoresMedActual_'.$idSensorResp])&&$data['SensoresMedActual_'.$idSensorResp]!=''){
				switch ($data['SensoresMedActual_'.$idSensorResp]) {
					//inactivo
					case 0:
						$status_icon = '';
						$wid_status  = 35;
						break;
					//activo encendido
					case 1:
						//$status_icon = '<a href="" title="Encendido Remoto" class="btn btn-success btn-sm tooltip"><i class="fa fa-unlock" aria-hidden="true"></i></a>';
						//$wid_status = 70;
						$status_icon = '';
						$wid_status  = 35;
						break;
					//activo apagado
					case 2:
						$status_icon = '<a href="" title="Apagado Remoto" class="btn btn-warning btn-sm tooltip"><i class="fa fa-lock" aria-hidden="true"></i></a>';
						$wid_status  = 70;
						break;
				}
			}else{
				$status_icon = '';
				$wid_status  = 35;
			}

			/*************************************************************************/
			//Unidad de medida
			if(isset($arrFinalUnimed[$data['SensoresUniMed_37']])){
				$UniMed_37 = $arrFinalUnimed[$data['SensoresUniMed_37']];
			}else{
				$UniMed_37 = '';
			}
			//Unidad de medida
			if(isset($arrFinalUnimed[$data['SensoresUniMed_39']])){
				$UniMed_39 = $arrFinalUnimed[$data['SensoresUniMed_39']];
			}else{
				$UniMed_39 = '';
			}
			//Guardo todos los datos
			$arrGruas[$xdanger][$data['idTelemetria']]['tr_color']     = $danger;
			$arrGruas[$xdanger][$data['idTelemetria']]['wid_status']   = $wid_status;
			$arrGruas[$xdanger][$data['idTelemetria']]['eq_ok_icon']   = $eq_ok_icon;
			$arrGruas[$xdanger][$data['idTelemetria']]['status_icon']  = $status_icon;
			$arrGruas[$xdanger][$data['idTelemetria']]['Nombre']       = $data['Nombre'];
			$arrGruas[$xdanger][$data['idTelemetria']]['LastUpdate']   = fecha_estandar($data['LastUpdateFecha']).' '.$data['LastUpdateHora'];

			if(isset($data['SensoresMedActual_37'])&&$data['SensoresMedActual_37']!=''&&$data['SensoresMedActual_37']!=0&&$data['SensoresMedActual_37']<99900){
				$arrGruas[$xdanger][$data['idTelemetria']]['Voltaje'] = cantidades($data['SensoresMedActual_37'], 1).' '.$UniMed_37;
			}else{
				$arrGruas[$xdanger][$data['idTelemetria']]['Voltaje'] = '0 '.$UniMed_37;
			}
			if(isset($data['SensoresMedActual_39'])&&$data['SensoresMedActual_39']!=''&&$data['SensoresMedActual_39']!=0&&$data['SensoresMedActual_39']<99900){
				$arrGruas[$xdanger][$data['idTelemetria']]['Viento'] = cantidades($data['SensoresMedActual_39'], 1).' '.$UniMed_39;
			}else{
				$arrGruas[$xdanger][$data['idTelemetria']]['Viento'] = 'N/A';
			}
			//si tiene los permisos
			if(isset($prm_xa)&&$prm_xa==1){
				switch ($in_sens_activ) {
					//inactivo
					case 0:
						$arrGruas[$xdanger][$data['idTelemetria']]['in_sens_activ'] = '';
						break;
					//activo encendido
					case 1:
						$arrGruas[$xdanger][$data['idTelemetria']]['in_sens_activ'] = '<a href="view_crosscrane_apagado.php?view='.simpleEncode($data['idTelemetria'], fecha_actual()).'" title="Cambiar Estado" class="iframe btn btn-success btn-sm tooltip"><i class="fa fa-toggle-on" aria-hidden="true"></i></a>';
						break;
					//activo apagado
					case 2:
						$arrGruas[$xdanger][$data['idTelemetria']]['in_sens_activ'] = '<a href="view_crosscrane_apagado.php?view='.simpleEncode($data['idTelemetria'], fecha_actual()).'" title="Cambiar Estado" class="iframe btn btn-danger btn-sm tooltip"><i class="fa fa-toggle-off" aria-hidden="true"></i></a>';
						break;
				}
			}else{
				switch ($in_sens_activ) {
					//inactivo
					case 0:
						$arrGruas[$xdanger][$data['idTelemetria']]['in_sens_activ'] = '';
						break;
					//activo encendido
					case 1:
						$arrGruas[$xdanger][$data['idTelemetria']]['in_sens_activ'] = '<a href="" title="Equipo Encendido" class="btn btn-success btn-sm tooltip"><i class="fa fa-toggle-on" aria-hidden="true"></i></a>';
						break;
					//activo apagado
					case 2:
						$arrGruas[$xdanger][$data['idTelemetria']]['in_sens_activ'] = '<a href="" title="Equipo Apagado" class="btn btn-danger btn-sm tooltip"><i class="fa fa-toggle-off" aria-hidden="true"></i></a>';
						break;
				}
			}

			/****************************************************/
			//busco el tipo de equipo
			$Nombre_equipo = $data['Identificador'];
			$NumSerie      = $data['NumSerie'];
			$buscado_1     = 'elv';
			$buscado_2     = 'gen';
			$s_pos_1       = strpos($NumSerie, $buscado_1);
			$s_pos_2       = strpos($NumSerie, $buscado_2);

			// Nótese el uso de ===. Puesto que == simple no funcionará como se espera
			// porque la posición de 'elv-' está en el 1° (primer) caracter.
			if ($s_pos_1 === false) {
				if ($s_pos_2 === false) {
					$arrGruas[$xdanger][$data['idTelemetria']]['crosscrane_estado']    = '<a href="view_crosscrane_estado.php?view='.simpleEncode($data['idTelemetria'], fecha_actual()).'" title="Estado Equipo" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-tasks" aria-hidden="true"></i></a>';
				}else{
					$arrGruas[$xdanger][$data['idTelemetria']]['crosscrane_estado']    = '<a href="view_generador_data.php?view='.simpleEncode($data['idTelemetria'], fecha_actual()).'" title="Datos Generador" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-battery-full" aria-hidden="true"></i></a>';
				}
			}else{
				$arrGruas[$xdanger][$data['idTelemetria']]['crosscrane_estado']    = '<a href="view_crosscrane_estado_elev.php?view='.simpleEncode($data['idTelemetria'], fecha_actual()).'" title="Estado Equipo" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-tasks" aria-hidden="true"></i></a>';
			}

			/****************************************************/
			//el resto de los botones
			$arrGruas[$xdanger][$data['idTelemetria']]['CenterMap']             = '<button onclick="fncCenterMap(\''.$data['GeoLatitud'].'\', \''.$data['GeoLongitud'].'\', \''.$nicon.'\')" title="Ver Ubicación" class="btn btn-default btn-sm tooltip"><i class="fa fa-map-marker" aria-hidden="true"></i></button>';
			$arrGruas[$xdanger][$data['idTelemetria']]['informe_activaciones']  = '<li><a href="view_telemetria_uso.php?idTelemetria='.$data['idTelemetria'].'&F_inicio='.$principioMes.'&F_termino='.$FechaSistema.'&Amp=&pagina=1&submit_filter=Filtrar" class="iframe" style="white-space: normal;" ><i class="fa fa-clock-o" aria-hidden="true"></i> Uso Grua</a></li>';
			$arrGruas[$xdanger][$data['idTelemetria']]['AlarmasPersonalizadas'] = '<li><a href="view_alertas_personalizadas.php?view='.simpleEncode($data['idTelemetria'], fecha_actual()).'" class="iframe" style="white-space: normal;"><i class="fa fa-bell-o" aria-hidden="true"></i> Alertas Personalizadas</a></li>';
			//si tiene un generador
			/*if(isset($data['idGenerador'])&&$data['idGenerador']==1){
				$arrGruas[$xdanger][$data['idTelemetria']]['Generador'] = '<li><a href="view_generador_data.php?view='.simpleEncode($data['idTelGenerador'], fecha_actual()).'" class="iframe" style="white-space: normal;"><i class="fa fa-battery-full" aria-hidden="true"></i> Datos Generador</a></li>';
			}else{
				$arrGruas[$xdanger][$data['idTelemetria']]['Generador'] = '';
			}*/
			//si utiliza carpeta ftp
			if(isset($data['idUsoFTP'], $data['FTP_Carpeta'])&&$data['idUsoFTP']==1&&$data['FTP_Carpeta']!=''){
				$arrGruas[$xdanger][$data['idTelemetria']]['CarpetaFTP'] = '<li><a href="view_telemetria_data_files.php?view='.simpleEncode($data['FTP_Carpeta'], fecha_actual()).'" class="iframe" style="white-space: normal;"><i class="fa fa-video-camera" aria-hidden="true"></i> Camara</a></li>';
			}else{
				$arrGruas[$xdanger][$data['idTelemetria']]['CarpetaFTP'] = '';
			}

			//boton de alertas pendientes de ver
			if(isset($data['NAlertas'])&&$data['NAlertas']!=''&&$data['NAlertas']!=0){
				//Alertas
				$link_Alertas  = 'view_telemetria_alertas.php';
				$link_Alertas .= '?pagina=1';
				//$link_Alertas .= '?f_inicio='.$Fecha_inicio;
				//$link_Alertas .= '&f_termino='.$Fecha_fin;
				$link_Alertas .= '&idTelemetria='.$data['idTelemetria'];
				$link_Alertas .= '&idLeido=0';
				$link_Alertas .= '&submit_filter=+Filtrar';
				//boton
				$arrGruas[$xdanger][$data['idTelemetria']]['NAlertas'] = '<a href="'.$link_Alertas.'" title="'.$data['NAlertas'].' Alertas Pendientes de ver" class="iframe btn btn-danger btn-sm tooltip"><i class="fa fa-exclamation-triangle faa-horizontal animated" aria-hidden="true"></i></a>';
			}else{
				$arrGruas[$xdanger][$data['idTelemetria']]['NAlertas'] = '';
			}

			$nicon++;
		}

		//Cuento los totales
		$Count_Alerta     = 0;
		$Count_Ok         = 0;
		$Count_FueraLinea = 0;
		$Count_Total      = 0;

		if(isset($arrGruas[2])){foreach ( $arrGruas[2] as $categoria=>$grua ) {$Count_Alerta++;$Count_Total++;}}
		if(isset($arrGruas[1])){foreach ( $arrGruas[1] as $categoria=>$grua ) {$Count_Ok++;$Count_Total++;}}
		if(isset($arrGruas[3])){foreach ( $arrGruas[3] as $categoria=>$grua ) {$Count_FueraLinea++;$Count_Total++;}}

		$GPS = '';

		$GPS .= '
			<div class="row">';
				$GPS .= widget_Ficha_2('box-yellow', 'fa-cog', '<span id="updt_Count_Alerta">'.$Count_Alerta.'</span>', 3, 'Con Alertas', '', '', '', '', 1, 1);
				$GPS .= widget_Ficha_2('box-red', 'fa-cog', '<span id="updt_Count_FueraLinea">'.$Count_FueraLinea.'</span>', 3, 'Fuera de Linea', '', '', '', '', 1, 1);
				$GPS .= widget_Ficha_2('box-green', 'fa-cog', '<span id="updt_Count_Ok">'.$Count_Ok.'</span>', 3, 'Ok', '', '', '', '', 1, 1);
				$GPS .= widget_Ficha_2('box-blue', 'fa-cog', '<span id="updt_Count_Total">'.$Count_Total.'</span>', 3, 'Total', '', '', '', '', 1, 1);
				$GPS .= '
			</div>';

		$GPS .= '
		<script async src="https://maps.googleapis.com/maps/api/js?key='.$google.'&callback=initMap"></script>

		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="box">
					<header>
						<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>'.$titulo.'</h5>
					</header>
					<div class="table-responsive">
						<div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
							<div class="row">
								<div id="vehiContent" class="table-wrapper-scroll-y my-custom-scrollbar">
									<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
										<thead>
											<tr role="row">
												<th colspan="5">
													<div class="field">
														<select name="selectZona" id="selectZona" class="form-control" onchange="chngZona()" >';
															//La opción todos
															$GPS .= '<option value="9999" selected="selected" >Todas las Zonas</option>';
															foreach ( $arrZonas as $select ) {
																$GPS .= '<option value="'.$select['idZona'].'" >'.$select['Nombre'].'</option>';
															}
														$GPS .= '
														</select>
													</div>
												</th>
											</tr>';
											$GPS .= widget_sherlock(1, 5, 'TableFiltered');
											$GPS .= '
											<tr role="row">
												<th></th>
												<th>Equipo</th>
												<th>Voltaje (V)</th>
												<th>Viento (km/h)</th>
												<th>Acciones</th>
											</tr>
										</thead>
										<tbody role="alert" aria-live="polite" aria-relevant="all" id="TableFiltered">';
											/************************************************************/
											//Con alertas
											if(isset($arrGruas[2])){
												foreach ( $arrGruas[2] as $categoria=>$grua ) {
													$GPS .= '
													<tr class="odd '.$grua['tr_color'].'">
														<td width="10">
															<div class="btn-group" style="width: '.$grua['wid_status'].'px;" >';
																$GPS .= $grua['eq_ok_icon'];
																$GPS .= $grua['status_icon'];
															$GPS .= '</div>
														</td>
														<td>
															'.$grua['Nombre'].'<br/>
															'.$grua['LastUpdate'].'
														</td>
														<td>'.$grua['Voltaje'].'</td>
														<td>'.$grua['Viento'].'</td>
														<td width="10">
															<div class="btn-group" style="width: 175px;" >';
																$GPS .= $grua['in_sens_activ'];
																$GPS .= $grua['NAlertas'];
																$GPS .= $grua['crosscrane_estado'];
																$GPS .= $grua['CenterMap'];
																$GPS .= '
																<button type="button" class="btn btn-danger btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
																	<span class="caret"></span>
																	<span class="sr-only">Toggle Dropdown</span>
																</button>
																<ul class="dropdown-menu" style="right: 0;float: right;">
																	'.$grua['informe_activaciones'].'
																	'.$grua['AlarmasPersonalizadas'].'
																	'.$grua['CarpetaFTP'].'
																</ul>
															</div>
														</td>
													</tr>';
												}
											}

											/************************************************************/
											//Ok
											if(isset($arrGruas[1])){
												foreach ( $arrGruas[1] as $categoria=>$grua ) {
													$GPS .= '
													<tr class="odd '.$grua['tr_color'].'">
														<td width="10">
															<div class="btn-group" style="width: '.$grua['wid_status'].'px;" >';
																$GPS .= $grua['eq_ok_icon'];
																$GPS .= $grua['status_icon'];
															$GPS .= '</div>
														</td>
														<td>
															'.$grua['Nombre'].'<br/>
															'.$grua['LastUpdate'].'
														</td>
														<td>'.$grua['Voltaje'].'</td>
														<td>'.$grua['Viento'].'</td>
														<td width="10">
															<div class="btn-group" style="width: 175px;" >';
																$GPS .= $grua['in_sens_activ'];
																$GPS .= $grua['NAlertas'];
																$GPS .= $grua['crosscrane_estado'];
																$GPS .= $grua['CenterMap'];
																$GPS .= '
																<button type="button" class="btn btn-danger btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
																	<span class="caret"></span>
																	<span class="sr-only">Toggle Dropdown</span>
																</button>
																<ul class="dropdown-menu" style="right: 0;float: right;">
																	'.$grua['informe_activaciones'].'
																	'.$grua['AlarmasPersonalizadas'].'
																	'.$grua['CarpetaFTP'].'
																</ul>
															</div>
														</td>
													</tr>';
												}
											}

											/************************************************************/
											//Fuera de linea
											if(isset($arrGruas[3])){
												foreach ( $arrGruas[3] as $categoria=>$grua ) {
													$GPS .= '
													<tr class="odd '.$grua['tr_color'].'">
														<td width="10">
															<div class="btn-group" style="width: '.$grua['wid_status'].'px;" >';
																$GPS .= $grua['eq_ok_icon'];
																$GPS .= $grua['status_icon'];
															$GPS .= '</div>
														</td>
														<td>
															'.$grua['Nombre'].'<br/>
															'.$grua['LastUpdate'].'
														</td>
														<td>'.$grua['Voltaje'].'</td>
														<td>'.$grua['Viento'].'</td>
														<td width="10">
															<div class="btn-group" style="width: 175px;" >';
																$GPS .= $grua['in_sens_activ'];
																$GPS .= $grua['NAlertas'];
																$GPS .= $grua['crosscrane_estado'];
																$GPS .= $grua['CenterMap'];
																$GPS .= '
																<button type="button" class="btn btn-danger btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
																	<span class="caret"></span>
																	<span class="sr-only">Toggle Dropdown</span>
																</button>
																<ul class="dropdown-menu" style="right: 0;float: right;">
																	'.$grua['informe_activaciones'].'
																	'.$grua['AlarmasPersonalizadas'].'
																	'.$grua['CarpetaFTP'].'
																</ul>
															</div>
														</td>
													</tr>';
												}
											}

											$GPS .= '
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
							<div class="row">
								<div id="map_canvas" style="width: 100%; height: 550px;"></div>
								<div id="consulta"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<style>
		.my-custom-scrollbar {
			position: relative;
			height: 550px;
			overflow: auto;
		}
		.table-wrapper-scroll-y {
			display: block;
		}
		</style>

		<script>
			let map;
			var markers = [];
			//Ubicación de los distintos dispositivos
			var locations = [ ';
				foreach ( $arrEquipo as $data ) {
					//burbuja
					$explanation  = '<div class="iw-subTitle">Equipo: '.$data['Nombre'].'<br/>Identificador: '.$data['Identificador'].'</div>';
					$explanation .= 'Actualizado: '.fecha_estandar($data['LastUpdateFecha']).' - '.$data['LastUpdateHora'].'</p>';
					//verifico si tiene sensores configurados
					if(isset($data['id_Sensores'])&&$data['id_Sensores']==1){
						$explanation .= '<div class="iw-subTitle">Sensores: </div><p>';
						for ($i = 1; $i <= $data['cantSensores']; $i++) {
							//verifico que sensor este activo
							if(isset($data['SensoresActivo_'.$i])&&$data['SensoresActivo_'.$i]==1){
								//Unidad medida
								if(isset($arrFinalUnimed[$data['SensoresUniMed_'.$i]])){
									$unimed = ' '.$arrFinalUnimed[$data['SensoresUniMed_'.$i]];
								}else{
									$unimed = '';
								}
								//cadena
								if(isset($data['SensoresMedActual_'.$i])&&$data['SensoresMedActual_'.$i]<99900){$xdata=Cantidades($data['SensoresMedActual_'.$i], 2).$unimed;}else{$xdata='Sin Datos';}
								$explanation .= $data['SensoresNombre_'.$i].' : '.$xdata.'<br/>';
							}
						}
						$explanation .= '</p>';
					}
					//se arma dato
					$GPS .= "[";
						$GPS .= $data['GeoLatitud'];
						$GPS .= ", ".$data['GeoLongitud'];
						$GPS .= ", '".$explanation."'";
					$GPS .= "], ";
				}
			$GPS .= '];

			async function initMap() {
				const { Map } = await google.maps.importLibrary("maps");

				var myLatlng = new google.maps.LatLng(-33.477271996598965, -70.65170304882815);

				var myOptions = {
					zoom: 12,
					center: myLatlng,
					mapTypeId: google.maps.MapTypeId.ROADMAP
				};

				map = new Map(document.getElementById("map_canvas"), myOptions);

				//ubicacion inicial
				setMarkers(map, locations, 1);
				//actualizacion de posicion
				transMarker(map, '.$SegActual.');

			}

			/* ************************************************************************** */
			function chngZona() {
				idZona = document.getElementById("selectZona").value;
				$(\'#vehiContent\').load(\'principal_update_zonaList_2_crosscrane.php?idZona=\' + idZona);
				setMarkers(map, locations, 1);
			}

			/* ************************************************************************** */
			function fncCenterMap(Latitud, Longitud, n_icon){
				latlon = new google.maps.LatLng(Latitud, Longitud);
				map.panTo(latlon);
				//volver todo a normal
				for (let i = 0; i < markers.length; i++) {
					markers[i].setIcon("'.DB_SITE_REPO.'/LIB_assets/img/map-icons/1_series_orange.png");
				}
				//colorear el seleccionado
				markers[n_icon].setIcon("'.DB_SITE_REPO.'/LIB_assets/img/map-icons/1_series_green.png");
			}

			/* ************************************************************************** */
			function setMarkers(map, locations, optc) {

				var marker, i, last_latitude, last_longitude;

				for (i = 0; i < locations.length; i++) {

					//defino ubicacion y datos
					let latitude   = locations[i][0];
					let longitude  = locations[i][1];
					let data       = locations[i][2];

					//guardo las ultimas ubicaciones
					last_latitude   = locations[i][0];
					last_longitude  = locations[i][1];

					latlngset = new google.maps.LatLng(latitude, longitude);

					//se crea marcador
					var marker = new google.maps.Marker({
						map         : map,
						position    : latlngset,
						icon      	: "'.DB_SITE_REPO.'/LIB_assets/img/map-icons/1_series_orange.png"
					});
					markers.push(marker);

					//se define contenido
					var content = 	"<div id=\'iw-container\'>" +
									"<div class=\'iw-title\'>Datos</div>" +
									"<div class=\'iw-content\'>" +
									data +
									"</div>" +
									"<div class=\'iw-bottom-gradient\'></div>" +
									"</div>";

					//se crea infowindow
					var infowindow = new google.maps.InfoWindow();

					//se agrega funcion de click a infowindow
					google.maps.event.addListener(marker,\'click\', (function(marker,content,infowindow){
						return function() {
							infowindow.setContent(content);
							infowindow.open(map,marker);
						};
					})(marker,content,infowindow));

				}
				if(optc==1){
					latlon = new google.maps.LatLng(last_latitude, last_longitude);
					map.panTo(latlon);
				}
			}
			/* ************************************************************************** */
			function transMarker(map, time) {
				var newTime = time / 2;
				setInterval(function(){transMarkerTimer(map)},newTime);
			}
			/* ************************************************************************** */
			var mapax = 0;
			function transMarkerTimer(map) {

				switch(mapax) {
					//Ejecutar formulario con el recorrido y la ruta
					case 1:
						$(\'#consulta\').load(\'principal_update_map_zona_2_crosscrane.php'.$enlace.'\');
						$(\'#vehiContent\').load(\'principal_update_zonaList_2_crosscrane.php\');
						break;
					//se dibujan los iconos
					case 2:
						//Se ocultan y eliminan los iconos
						deleteMarkers();
						setMarkers(map, new_locations, 2);
						//actualizo la hora de actualizacion
						document.getElementById(\'update_text_HoraRefresco\').innerHTML=\'Hora Refresco: \'+HoraRefresco;

						break;
				}

				mapax++;
				if(mapax==3){mapax=1}
			}
			/* ************************************************************************** */
			// Sets the map on all markers in the array.
			function setMapOnAll(map) {
				for (let i = 0; i < markers.length; i++) {
				markers[i].setMap(map);
				}
			}
			/* ************************************************************************** */
			// Removes the markers from the map, but keeps them in the array.
			function clearMarkers() {
				setMapOnAll(null);
			}
			/* ************************************************************************** */
			// Shows any markers currently in the array.
			function showMarkers() {
				setMapOnAll(map);
			}
			/* ************************************************************************** */
			// Deletes all markers in the array by removing references to them.
			function deleteMarkers() {
				clearMarkers();
				markers = [];
			}

		</script>

		';

		return $GPS;

	}
}
/*******************************************************************************************************************/
//Muestra los widget de los equipos externos
function widget_Equipos_external($dbConn){

	//variables
	$HoraSistema    = hora_actual();
	$FechaSistema   = fecha_actual();
	$eq_alertas     = 0;
	$eq_fueralinea  = 0;
	$eq_ok          = 0;

	/*************************************************************/
	//Se consulta
	$SIS_query = '
	telemetria_listado.LastUpdateFecha,
	telemetria_listado.LastUpdateHora,
	telemetria_listado.cantSensores,
	telemetria_listado.TiempoFueraLinea,
	telemetria_listado.NErrores';
	$SIS_join  = '';
	$SIS_where = 'telemetria_listado.idEstado = 1';//solo equipos activos
	$SIS_order = 'telemetria_listado.Nombre ASC';
	$arrEquipo = array();
	$arrEquipo = db_select_array (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrEquipo');

	//Se recorre
	foreach ($arrEquipo as $data) {

		/**********************************************/
		//Se resetean
		$in_eq_alertas     = 0;
		$in_eq_fueralinea  = 0;
		$in_eq_ok          = 1;

		/**********************************************/
		//Fuera de linea
		$diaInicio   = $data['LastUpdateFecha'];
		$diaTermino  = $FechaSistema;
		$tiempo1     = $data['LastUpdateHora'];
		$tiempo2     = $HoraSistema;
		$Tiempo      = horas_transcurridas($diaInicio, $diaTermino, $tiempo1, $tiempo2);

		//Comparaciones de tiempo
		$Time_Tiempo     = horas2segundos($Tiempo);
		$Time_Tiempo_FL  = horas2segundos($data['TiempoFueraLinea']);
		$Time_Tiempo_Max = horas2segundos('48:00:00');
		$Time_Fake_Ini   = horas2segundos('23:59:50');
		$Time_Fake_Fin   = horas2segundos('24:00:00');
		//comparacion
		if(($Time_Tiempo<$Time_Fake_Ini OR $Time_Tiempo>$Time_Fake_Fin)&&(($Time_Tiempo>$Time_Tiempo_FL&&$Time_Tiempo_FL!=0) OR ($Time_Tiempo>$Time_Tiempo_Max&&$Time_Tiempo_FL==0))){
			$in_eq_fueralinea++;
		}

		/**********************************************/
		//NErrores
		if(isset($data['NErrores'])&&$data['NErrores']>0){ $in_eq_alertas++; }

		/*******************************************************/
		//rearmo
		if($in_eq_alertas>0){    $in_eq_ok = 0;$in_eq_alertas = 1;    }
		if($in_eq_fueralinea>0){ $in_eq_ok = 0;$in_eq_fueralinea = 1; $in_eq_alertas = 0;}

		//Se guardan los valores
		$eq_alertas     = $eq_alertas + $in_eq_alertas;
		$eq_fueralinea  = $eq_fueralinea + $in_eq_fueralinea;
		$eq_ok          = $eq_ok + $in_eq_ok;

	}


		$GPS = '';
		$GPS .= '
		<div class="row">';
			$GPS .= widget_Ficha_2('box-yellow', 'fa-bell-o', $eq_alertas, 4, 'Equipos con alertas', 'Sensores', 'principal_gps_view_external.php?dataType='.simpleEncode( 1, fecha_actual()), 'Ver Mas', 'btn-warning', 1, 2);
			$GPS .= widget_Ficha_2('box-red', 'fa-exclamation-triangle', $eq_fueralinea, 4, 'Equipos fuera de linea', 'Equipos', 'principal_gps_view_external.php?dataType='.simpleEncode( 2, fecha_actual()), 'Ver Mas', 'btn-danger', 1, 2);
			$GPS .= widget_Ficha_2('box-blue', 'fa-check-circle', $eq_ok, 4, 'Equipos OK', 'Equipos', 'principal_gps_view_external.php?dataType='.simpleEncode( 4, fecha_actual()), 'Ver Mas', 'btn-primary', 1, 2);
			$GPS .= '
		</div>';

	return $GPS;
}
/*******************************************************************************************************************/
//Muestra la gestion de equipos decrosscrane
function widget_Gestion_Equipos_crossEnergy($titulo,$idSistema, $IDGoogle, $idTipoUsuario, $idUsuario, $SegActual, $dbConn){

	//Si no existe una ID se utiliza una por defecto
	if(!isset($IDGoogle) OR $IDGoogle==''){
		return alert_post_data(4,1,1,0, 'No ha ingresado Una API de Google Maps');
	}else{

		//variables
		$HoraSistema    = hora_actual();
		$FechaSistema   = fecha_actual();
		$Fecha_inicio   = restarDias(fecha_actual(),1);
		$Fecha_fin      = fecha_actual();
		$google         = $IDGoogle;
		//Grupo Sensores
		$idGrupoVmonofasico      = 87;
		$idGrupoVTrifasico       = 106;
		$idGrupoPotencia         = 99;

		//enlace para redireccionar
		$enlace  = "?dd=true";
		$enlace .= "&idTipoUsuario=".$idTipoUsuario;
		$enlace .= "&idSistema=".$idSistema;
		$enlace .= "&idUsuario=".$idUsuario;

		//Variable
		$SIS_where = "telemetria_listado.idEstado = 1 ";//solo equipos activos
		//solo los equipos que tengan el seguimiento desactivado
		$SIS_where .= " AND telemetria_listado.id_Geo = 2";
		//Filtro el sistema al cual pertenece
		if(isset($idSistema)&&$idSistema!=''&&$idSistema!=0){
			$SIS_where .= " AND telemetria_listado.idSistema = ".$idSistema;
		}
		//Verifico el tipo de usuario que esta ingresando y el id
		$SIS_join  = '';
		if(isset($idTipoUsuario, $idUsuario)&&$idTipoUsuario!=1&&$idUsuario!=0){
			$SIS_join  .= ' INNER JOIN usuarios_equipos_telemetria ON usuarios_equipos_telemetria.idTelemetria = telemetria_listado.idTelemetria ';
			$SIS_where .= ' AND usuarios_equipos_telemetria.idUsuario = '.$idUsuario;
		}
		//Solo para plataforma 1tek
		$SIS_where .= " AND telemetria_listado.idTab=9";//Power-Energy

		//numero sensores equipo
		$N_Maximo_Sensores = 72;
		$subquery = '';
		for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
			$subquery .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$i;
			$subquery .= ',telemetria_listado_sensores_med_actual.SensoresMedActual_'.$i;
			$subquery .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i;
			$subquery .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$i;
			$subquery .= ',telemetria_listado_sensores_grupo.SensoresGrupo_'.$i;
		}

		/*************************************************************/
		//Se consulta
		$SIS_query = '
		telemetria_listado.idTelemetria,
		telemetria_listado.Nombre,
		telemetria_listado.Identificador,
		telemetria_listado.LastUpdateFecha,
		telemetria_listado.LastUpdateHora,
		telemetria_listado.cantSensores,
		telemetria_listado.GeoLatitud,
		telemetria_listado.GeoLongitud,
		telemetria_listado.TiempoFueraLinea,
		telemetria_listado.NErrores,
		telemetria_listado.NAlertas,
		telemetria_listado.id_Sensores'.$subquery;
		$SIS_join .= '
		LEFT JOIN `telemetria_listado_sensores_nombre`          ON telemetria_listado_sensores_nombre.idTelemetria         = telemetria_listado.idTelemetria
		LEFT JOIN `telemetria_listado_sensores_med_actual`      ON telemetria_listado_sensores_med_actual.idTelemetria     = telemetria_listado.idTelemetria
		LEFT JOIN `telemetria_listado_sensores_unimed`          ON telemetria_listado_sensores_unimed.idTelemetria         = telemetria_listado.idTelemetria
		LEFT JOIN `telemetria_listado_sensores_activo`          ON telemetria_listado_sensores_activo.idTelemetria         = telemetria_listado.idTelemetria
		LEFT JOIN `telemetria_listado_sensores_grupo`           ON telemetria_listado_sensores_grupo.idTelemetria          = telemetria_listado.idTelemetria';
		$SIS_order = 'telemetria_listado.Nombre ASC';
		$arrEquipo = array();
		$arrEquipo = db_select_array (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrEquipo');

		/*************************************************************/
		//Se traen todas las unidades de medida
		$arrUnimed = array();
		$arrUnimed = db_select_array (false, 'idUniMed,Nombre', 'telemetria_listado_unidad_medida', '', '', 'idUniMed ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrUnimed');

		//Ordeno las unidades de medida
		$arrFinalUnimed = array();
		foreach ($arrUnimed as $data) {
			$arrFinalUnimed[$data['idUniMed']] = $data['Nombre'];
		}

		/*************************************************************/
		//se traen todas las zonas
		$arrZonas = array();
		$arrZonas = db_select_array (false, 'idZona,Nombre', 'telemetria_zonas', '', '', 'idZona ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrUnimed');

		//defino la variable temporal de la zona
		$_SESSION['usuario']['zona']['idZona']         = 9999;
		$_SESSION['usuario']['zona']['id_Geo']         = 2;
		$_SESSION['usuario']['zona']['idTipoUsuario']  = $idTipoUsuario;
		$_SESSION['usuario']['zona']['idSistema']      = $idSistema;
		$_SESSION['usuario']['zona']['idUsuario']      = $idUsuario;


		$nicon    = 0;
		$arrGruas = array();

		foreach ($arrEquipo as $data) {

			/**********************************************/
			//Se resetean
			$in_eq_alertas     = 0;
			$in_eq_fueralinea  = 0;
			$in_eq_ok          = 1;

			/**********************************************/
			//Fuera de linea
			$diaInicio   = $data['LastUpdateFecha'];
			$diaTermino  = $FechaSistema;
			$tiempo1     = $data['LastUpdateHora'];
			$tiempo2     = $HoraSistema;
			$Tiempo      = horas_transcurridas($diaInicio, $diaTermino, $tiempo1, $tiempo2);

			//Comparaciones de tiempo
			$Time_Tiempo     = horas2segundos($Tiempo);
			$Time_Tiempo_FL  = horas2segundos($data['TiempoFueraLinea']);
			$Time_Tiempo_Max = horas2segundos('48:00:00');
			$Time_Fake_Ini   = horas2segundos('23:59:50');
			$Time_Fake_Fin   = horas2segundos('24:00:00');
			//comparacion
			if(($Time_Tiempo<$Time_Fake_Ini OR $Time_Tiempo>$Time_Fake_Fin)&&(($Time_Tiempo>$Time_Tiempo_FL&&$Time_Tiempo_FL!=0) OR ($Time_Tiempo>$Time_Tiempo_Max&&$Time_Tiempo_FL==0))){
				$in_eq_fueralinea++;
			}

			/**********************************************/
			//Equipos Errores
			if(isset($data['NErrores'])&&$data['NErrores']>0){ $in_eq_alertas++; }

			/*******************************************************/
			//rearmo
			if($in_eq_alertas>0){    $in_eq_ok = 0;  $in_eq_alertas    = 1;    }
			if($in_eq_fueralinea>0){ $in_eq_ok = 0;  $in_eq_fueralinea = 1; $in_eq_alertas = 0;  }

			/*******************************************************/
			//se guardan estados
			$danger = '';
			$xdanger = 1;
			if($in_eq_alertas>0){    $danger = 'warning';  $xdanger = 2; $dataex = '<a href="#" title="Equipo con Alertas"        class="btn btn-warning btn-sm tooltip"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></a>';}
			if($in_eq_fueralinea>0){ $danger = 'danger';   $xdanger = 3; $dataex = '<a href="#" title="Fuera de Linea"            class="btn btn-danger btn-sm tooltip"><i class="fa fa-chain-broken" aria-hidden="true"></i></a>';}

			/*******************************************************/
			//traspasan los estados
			if($in_eq_ok==1){
				$eq_ok_icon = '<a href="#" title="Sin Problemas" class="btn btn-success btn-sm tooltip"><i class="fa fa-check" aria-hidden="true"></i></a>';
			}else{
				$eq_ok_icon = $dataex;
			}

			/*************************************************************************/
			//Guardo todos los datos
			$arrGruas[$xdanger][$data['idTelemetria']]['tr_color']           = $danger;
			$arrGruas[$xdanger][$data['idTelemetria']]['eq_ok_icon']         = $eq_ok_icon;
			$arrGruas[$xdanger][$data['idTelemetria']]['Nombre']             = $data['Nombre'];
			$arrGruas[$xdanger][$data['idTelemetria']]['LastUpdate']         = fecha_estandar($data['LastUpdateFecha']).' '.$data['LastUpdateHora'];
			$arrGruas[$xdanger][$data['idTelemetria']]['crosscrane_estado']  = '<a href="view_crossenergy_estado.php?view='.simpleEncode($data['idTelemetria'], fecha_actual()).'" title="Consumo Equipo" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-bolt" aria-hidden="true"></i></a>';
			//$arrGruas[$xdanger][$data['idTelemetria']]['crosscrane_detalle'] = '<a href="view_crossenergy_detalle.php?view='.simpleEncode($data['idTelemetria'], fecha_actual()).'" title="Detalle Equipo" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-line-chart" aria-hidden="true"></i></a>';

			//Temporales
			$TempValue_1 = 0;
			$TempValue_2 = 0;
			$TempValue_3 = 0;
			$TempCount_1 = 0;
			$TempCount_2 = 0;
			$TempCount_3 = 0;

			//se recorre
			for ($i = 1; $i <= $data['cantSensores']; $i++) {
				//Si el sensor esta activo
				if(isset($data['SensoresActivo_'.$i])&&$data['SensoresActivo_'.$i]==1){
					//Si pertenece al grupo
					if($data['SensoresGrupo_'.$i]==$idGrupoVmonofasico){
						$TempValue_1 = $TempValue_1 + $data['SensoresMedActual_'.$i];
						$TempCount_1++;
					}
					if($data['SensoresGrupo_'.$i]==$idGrupoVTrifasico){
						$TempValue_2 = $TempValue_2 + $data['SensoresMedActual_'.$i];
						$TempCount_2++;
					}
					if($data['SensoresGrupo_'.$i]==$idGrupoPotencia){
						$TempValue_3 = $TempValue_3 + $data['SensoresMedActual_'.$i];
						$TempCount_3++;
					}
				}
			}

			//Saco promedios
			if($TempCount_1!=0){$arrGruas[$xdanger][$data['idTelemetria']]['Vmonofasico']     = $TempValue_1/$TempCount_1;}else{$arrGruas[$xdanger][$data['idTelemetria']]['Vmonofasico']     = 0;}
			if($TempCount_2!=0){$arrGruas[$xdanger][$data['idTelemetria']]['VTrifasico']      = $TempValue_2/$TempCount_2;}else{$arrGruas[$xdanger][$data['idTelemetria']]['VTrifasico']      = 0;}
			if($TempCount_3!=0){$arrGruas[$xdanger][$data['idTelemetria']]['Potencia']        = $TempValue_3/$TempCount_3;}else{$arrGruas[$xdanger][$data['idTelemetria']]['Potencia']        = 0;}

			/****************************************************/
			//el resto de los botones
			$arrGruas[$xdanger][$data['idTelemetria']]['CenterMap']            = '<button onclick="fncCenterMap(\''.$data['GeoLatitud'].'\', \''.$data['GeoLongitud'].'\', \''.$nicon.'\')" title="Ver Ubicación" class="btn btn-default btn-sm tooltip"><i class="fa fa-map-marker" aria-hidden="true"></i></button>';
			//boton de alertas pendientes de ver
			if(isset($data['NAlertas'])&&$data['NAlertas']!=''&&$data['NAlertas']!=0){
				//Alertas
				$link_Alertas  = 'informe_telemetria_errores_7.php';
				$link_Alertas .= '?bla=bla';
				//$link_Alertas .= '?f_inicio='.$Fecha_inicio;
				//$link_Alertas .= '&f_termino='.$Fecha_fin;
				$link_Alertas .= '&idTelemetria='.$data['idTelemetria'];
				$link_Alertas .= '&idLeido=0';
				$link_Alertas .= '&submit_filter=+Filtrar';
				//boton
				$arrGruas[$xdanger][$data['idTelemetria']]['NAlertas']         = '<a target="_blank" rel="noopener noreferrer" href="'.$link_Alertas.'" title="Alertas Pendientes de ver" class="btn btn-danger btn-sm tooltip"><i class="fa fa-exclamation-triangle faa-horizontal animated" aria-hidden="true"></i></a>';
			}else{
				$arrGruas[$xdanger][$data['idTelemetria']]['NAlertas']         = '';
			}

			$nicon++;
		}

		//Cuento los totales
		$Count_Alerta     = 0;
		$Count_Ok         = 0;
		$Count_FueraLinea = 0;
		$Count_Total      = 0;

		if(isset($arrGruas[2])){foreach ( $arrGruas[2] as $categoria=>$grua ) {$Count_Alerta++;$Count_Total++;}}
		if(isset($arrGruas[1])){foreach ( $arrGruas[1] as $categoria=>$grua ) {$Count_Ok++;$Count_Total++;}}
		if(isset($arrGruas[3])){foreach ( $arrGruas[3] as $categoria=>$grua ) {$Count_FueraLinea++;$Count_Total++;}}

		$GPS = '';

		$GPS .= '
			<div class="row">';
				$GPS .= widget_Ficha_2('box-yellow', 'fa-cog', '<span id="updt_Count_Alerta">'.$Count_Alerta.'</span>', 3, 'Con Alertas', '', '', '', '', 1, 1);
				$GPS .= widget_Ficha_2('box-red', 'fa-cog', '<span id="updt_Count_FueraLinea">'.$Count_FueraLinea.'</span>', 3, 'Fuera de Linea', '', '', '', '', 1, 1);
				$GPS .= widget_Ficha_2('box-green', 'fa-cog', '<span id="updt_Count_Ok">'.$Count_Ok.'</span>', 3, 'Ok', '', '', '', '', 1, 1);
				$GPS .= widget_Ficha_2('box-blue', 'fa-cog', '<span id="updt_Count_Total">'.$Count_Total.'</span>', 3, 'Total', '', '', '', '', 1, 1);
				$GPS .= '
			</div>';

		$GPS .= '
		<script async src="https://maps.googleapis.com/maps/api/js?key='.$google.'&callback=initMap"></script>

		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="box">
					<header>
						<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>'.$titulo.'</h5>
					</header>
					<div class="table-responsive">
						<div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
							<div class="row">
								<div id="vehiContent" class="table-wrapper-scroll-y my-custom-scrollbar">
									<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
										<thead>
											<tr role="row">
												<th colspan="6">
													<div class="field">
														<select name="selectZona" id="selectZona" class="form-control" onchange="chngZona()" >';
															//La opción todos
															$GPS .= '<option value="9999" selected="selected" >Todas las Zonas</option>';
															foreach ( $arrZonas as $select ) {
																$GPS .= '<option value="'.$select['idZona'].'" >'.$select['Nombre'].'</option>';
															}
														$GPS .= '
														</select>
													</div>
												</th>
											</tr>';
											$GPS .= widget_sherlock(1, 6, 'TableFiltered');
											$GPS .= '
											<tr role="row">
												<th></th>
												<th>Equipo</th>
												<th>V. Trifasico</th>
												<th>V. Monofasico</th>
												<th>Potencia</th>
												<th>Acciones</th>
											</tr>
										</thead>
										<tbody role="alert" aria-live="polite" aria-relevant="all" id="TableFiltered">';

											if(isset($arrGruas[2])){
												foreach ( $arrGruas[2] as $categoria=>$grua ) {
													$GPS .= '
													<tr class="odd '.$grua['tr_color'].'">
														<td width="10">
															<div class="btn-group" style="width: 35px;" >';
																$GPS .= $grua['eq_ok_icon'];
															$GPS .= '</div>
														</td>
														<td>
															'.$grua['Nombre'].'<br/>
															'.$grua['LastUpdate'].'
														</td>
														<td>'.cantidades($grua['VTrifasico'], 1).' V</td>
														<td>'.cantidades($grua['Vmonofasico'], 1).' V</td>
														<td>'.cantidades($grua['Potencia'], 1).' kW</td>
														<td width="10">
															<div class="btn-group" style="width: 105px;" >';
																$GPS .= $grua['NAlertas'];
																$GPS .= $grua['crosscrane_estado'];
																//$GPS .= $grua['crosscrane_detalle'];
																$GPS .= $grua['CenterMap'];
																$GPS .= '
															</div>
														</td>
													</tr>';
												}
											}

											if(isset($arrGruas[1])){
												foreach ( $arrGruas[1] as $categoria=>$grua ) {
													$GPS .= '
													<tr class="odd '.$grua['tr_color'].'">
														<td width="10">
															<div class="btn-group" style="width: 35px;" >';
																$GPS .= $grua['eq_ok_icon'];
															$GPS .= '</div>
														</td>
														<td>
															'.$grua['Nombre'].'<br/>
															'.$grua['LastUpdate'].'
														</td>
														<td>'.cantidades($grua['VTrifasico'], 1).' V</td>
														<td>'.cantidades($grua['Vmonofasico'], 1).' V</td>
														<td>'.cantidades($grua['Potencia'], 1).' kW</td>
														<td width="10">
															<div class="btn-group" style="width: 105px;" >';
																$GPS .= $grua['NAlertas'];
																$GPS .= $grua['crosscrane_estado'];
																//$GPS .= $grua['crosscrane_detalle'];
																$GPS .= $grua['CenterMap'];
																$GPS .= '
															</div>
														</td>
													</tr>';
												}
											}

											if(isset($arrGruas[3])){
												foreach ( $arrGruas[3] as $categoria=>$grua ) {
													$GPS .= '
													<tr class="odd '.$grua['tr_color'].'">
														<td width="10">
															<div class="btn-group" style="width: 35px;" >';
																$GPS .= $grua['eq_ok_icon'];
															$GPS .= '</div>
														</td>
														<td>
															'.$grua['Nombre'].'<br/>
															'.$grua['LastUpdate'].'
														</td>
														<td>'.cantidades($grua['VTrifasico'], 1).' V</td>
														<td>'.cantidades($grua['Vmonofasico'], 1).' V</td>
														<td>'.cantidades($grua['Potencia'], 1).' kW</td>
														<td width="10">
															<div class="btn-group" style="width: 105px;" >';
																$GPS .= $grua['NAlertas'];
																$GPS .= $grua['crosscrane_estado'];
																//$GPS .= $grua['crosscrane_detalle'];
																$GPS .= $grua['CenterMap'];
																$GPS .= '
															</div>
														</td>
													</tr>';
												}
											}
											$GPS .= '
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
							<div class="row">
								<div id="map_canvas" style="width: 100%; height: 550px;"></div>
								<div id="consulta"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<style>
		.my-custom-scrollbar {
			position: relative;
			height: 550px;
			overflow: auto;
		}
		.table-wrapper-scroll-y {
			display: block;
		}
		</style>

		<script>
			let map;
			var markers = [];
			//Ubicación de los distintos dispositivos
			var locations = [ ';
				foreach ( $arrEquipo as $data ) {
					//burbuja
					$explanation  = '<div class="iw-subTitle">Equipo: '.$data['Nombre'].'<br/>Identificador: '.$data['Identificador'].'</div>';
					$explanation .= 'Actualizado: '.fecha_estandar($data['LastUpdateFecha']).' - '.$data['LastUpdateHora'].'</p>';
					//verifico si tiene sensores configurados
					if(isset($data['id_Sensores'])&&$data['id_Sensores']==1){
						$explanation .= '<div class="iw-subTitle">Sensores: </div><p>';
						for ($i = 1; $i <= $data['cantSensores']; $i++) {
							//verifico que sensor este activo
							if(isset($data['SensoresActivo_'.$i])&&$data['SensoresActivo_'.$i]==1){
								//Unidad medida
								$unimed = '';
								if(isset($arrFinalUnimed[$data['SensoresUniMed_'.$i]])){
									$unimed .= ' '.$arrFinalUnimed[$data['SensoresUniMed_'.$i]];
								}
								//cadena
								if(isset($data['SensoresMedActual_'.$i])&&$data['SensoresMedActual_'.$i]<99900){$xdata=Cantidades($data['SensoresMedActual_'.$i], 2).$unimed;}else{$xdata='Sin Datos';}
								$explanation .= $data['SensoresNombre_'.$i].' : '.$xdata.'<br/>';
							}
						}
						$explanation .= '</p>';
					}
					//se arma dato
					$GPS .= "[";
						$GPS .= $data['GeoLatitud'];
						$GPS .= ", ".$data['GeoLongitud'];
						$GPS .= ", '".$explanation."'";
					$GPS .= "], ";
				}
			$GPS .= '];

			async function initMap() {
				const { Map } = await google.maps.importLibrary("maps");

				var myLatlng = new google.maps.LatLng(-33.477271996598965, -70.65170304882815);

				var myOptions = {
					zoom: 12,
					center: myLatlng,
					mapTypeId: google.maps.MapTypeId.ROADMAP
				};

				map = new Map(document.getElementById("map_canvas"), myOptions);

				//ubicacion inicial
				setMarkers(map, locations, 1);
				//actualizacion de posicion
				transMarker(map, '.$SegActual.');

			}

			/* ************************************************************************** */
			function chngZona() {
				idZona = document.getElementById("selectZona").value;
				$(\'#vehiContent\').load(\'principal_update_zonaList_2_crossenergy.php?idZona=\' + idZona);
				setMarkers(map, locations, 1);
			}

			/* ************************************************************************** */
			function fncCenterMap(Latitud, Longitud, n_icon){
				latlon = new google.maps.LatLng(Latitud, Longitud);
				map.panTo(latlon);
				//volver todo a normal
				for (let i = 0; i < markers.length; i++) {
					markers[i].setIcon("'.DB_SITE_REPO.'/LIB_assets/img/map-icons/1_series_orange.png");
				}
				//colorear el seleccionado
				markers[n_icon].setIcon("'.DB_SITE_REPO.'/LIB_assets/img/map-icons/1_series_green.png");
			}

			/* ************************************************************************** */
			function setMarkers(map, locations, optc) {

				var marker, i, last_latitude, last_longitude;

				for (i = 0; i < locations.length; i++) {

					//defino ubicacion y datos
					let latitude   = locations[i][0];
					let longitude  = locations[i][1];
					let data       = locations[i][2];

					//guardo las ultimas ubicaciones
					last_latitude   = locations[i][0];
					last_longitude  = locations[i][1];

					latlngset = new google.maps.LatLng(latitude, longitude);

					//se crea marcador
					var marker = new google.maps.Marker({
						map         : map,
						position    : latlngset,
						icon      	: "'.DB_SITE_REPO.'/LIB_assets/img/map-icons/1_series_orange.png"
					});
					markers.push(marker);

					//se define contenido
					var content = 	"<div id=\'iw-container\'>" +
									"<div class=\'iw-title\'>Datos</div>" +
									"<div class=\'iw-content\'>" +
									data +
									"</div>" +
									"<div class=\'iw-bottom-gradient\'></div>" +
									"</div>";

					//se crea infowindow
					var infowindow = new google.maps.InfoWindow();

					//se agrega funcion de click a infowindow
					google.maps.event.addListener(marker,\'click\', (function(marker,content,infowindow){
						return function() {
							infowindow.setContent(content);
							infowindow.open(map,marker);
						};
					})(marker,content,infowindow));

				}
				if(optc==1){
					latlon = new google.maps.LatLng(last_latitude, last_longitude);
					map.panTo(latlon);
				}
			}
			/* ************************************************************************** */
			function transMarker(map, time) {
				var newTime = time / 2;
				setInterval(function(){transMarkerTimer(map)},newTime);
			}
			/* ************************************************************************** */
			var mapax = 0;
			function transMarkerTimer(map) {

				switch(mapax) {
					//Ejecutar formulario con el recorrido y la ruta
					case 1:
						$(\'#consulta\').load(\'principal_update_map_zona_2_crossenergy.php'.$enlace.'\');
						$(\'#vehiContent\').load(\'principal_update_zonaList_2_crossenergy.php\');
						break;
					//se dibujan los iconos
					case 2:
						//Se ocultan y eliminan los iconos
						deleteMarkers();
						setMarkers(map, new_locations, 2);
						//actualizo la hora de actualizacion
						document.getElementById(\'update_text_HoraRefresco\').innerHTML=\'Hora Refresco: \'+HoraRefresco;

						break;
				}

				mapax++;
				if(mapax==3){mapax=1}
			}
			/* ************************************************************************** */
			// Sets the map on all markers in the array.
			function setMapOnAll(map) {
				for (let i = 0; i < markers.length; i++) {
				markers[i].setMap(map);
				}
			}
			/* ************************************************************************** */
			// Removes the markers from the map, but keeps them in the array.
			function clearMarkers() {
				setMapOnAll(null);
			}
			/* ************************************************************************** */
			// Shows any markers currently in the array.
			function showMarkers() {
				setMapOnAll(map);
			}
			/* ************************************************************************** */
			// Deletes all markers in the array by removing references to them.
			function deleteMarkers() {
				clearMarkers();
				markers = [];
			}

		</script>

		';

		return $GPS;

	}
}
/*******************************************************************************************************************/
//Muestra los widget sociales
function widget_Social( $Social_facebook,
						$Social_twitter,
						$Social_instagram,
						$Social_linkedin,
						$Social_rss,
						$Social_youtube,
						$Social_tumblr){



	$GPS = '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
	$GPS .= '<div class="row">';

	$GPS .= '
	<script>
		function whenNoTrackingProtection() {
			if (!whenNoTrackingProtection.promise) {
				whenNoTrackingProtection.promise = new Promise(function(resolve, reject) {
					var time = Date.now();
					var img = new Image();
					img.onload = resolve;
					img.onerror = function() {
						if ((Date.now() - time) < 50) {
							reject(new Error("Rejected."));
						} else {
							resolve(new Error("Takes too long."));
						}
					};
					img.src = "//www.facebook.com/tr/";
				}).then((result) => {
				  console.log("Tracking OK");
				}).catch(e => {
				  console.log("Tracking KAO");
				  console.log(e);
				  alert("Su navegador bloquea los sitios con cockies de seguimiento, algunos widget sociales no se mostraran");
				});
			}
		}
		whenNoTrackingProtection();
	</script>';

	/********************************************************/
	//si existe el dato
	if(isset($Social_facebook)&&$Social_facebook!=''){
		//$GPS .= '<div class="clearfix" ></div>';
		$GPS .= '<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">';
		$GPS .= '<div class="box"><header><div class="icons"><i class="fa fa-facebook" aria-hidden="true"></i></div><h5>Facebook</h5></header><div class="">';
		$GPS .= '<div id="fb-root"></div><script async defer crossorigin="anonymous" src="https://connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v9.0&appId='.$Social_facebook.'&autoLogAppEvents=1" nonce="gEy7ooj1"></script>';
		$GPS .= '<div class="fb-page" data-href="https://www.facebook.com/facebook" data-tabs="timeline" data-width="600" data-height="" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/facebook" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/facebook">Facebook</a></blockquote></div>';
		$GPS .= '</div></div>';
		$GPS .= '</div>';
	}
	/********************************************************/
	//si existe el dato
	if(isset($Social_twitter)&&$Social_twitter!=''){
		$GPS .= '<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">';
		$GPS .= '<div class="box"><header><div class="icons"><i class="fa fa-twitter" aria-hidden="true"></i></div><h5>Twitter</h5></header><div class="external_page">';
		$GPS .= '<a class="twitter-timeline" href="'.$Social_twitter.'?ref_src=twsrc%5Etfw">Tweets by Google</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>';
		$GPS .= '</div></div>';
		$GPS .= '</div>';
	}
	/********************************************************/
	//si existe el dato
	if(isset($Social_instagram)&&$Social_instagram!=''){
		$GPS .= '';
	}
	/********************************************************/
	//si existe el dato
	if(isset($Social_linkedin)&&$Social_linkedin!=''){
		$GPS .= '<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">';
		$GPS .= '<div class="box"><header><div class="icons"><i class="fa fa-linkedin" aria-hidden="true"></i></div><h5>Linkedin</h5></header><div class="external_page">';
		$GPS .= '<script type="text/javascript" src="https://platform.linkedin.com/badges/js/profile.js" async defer></script>';
		$GPS .= '<div class="LI-profile-badge"  data-version="v1" data-size="medium" data-locale="es_ES" data-type="vertical" data-theme="light" data-vanity="'.$Social_linkedin.'"><a class="LI-simple-link" href="https://cl.linkedin.com/in/'.$Social_linkedin.'?trk=profile-badge">Linkedin</a></div>';
		$GPS .= '</div></div>';
		$GPS .= '</div>';
		$GPS .= '<style>
		.LI-badge-container.vertical.light {width: 100%;}
		.LI-badge-container.vertical.light .LI-profile-pic {position: relative;}
		.LI-badge-container.vertical.light .LI-profile-pic {margin-left: auto;margin-right: auto;left: 0px;}
		</style>';
	}
	/********************************************************/
	//si existe el dato
	if(isset($Social_rss)&&$Social_rss!=''){
		$GPS .= '<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">';
		$GPS .= '<div class="box"><header><div class="icons"><i class="fa fa-rss" aria-hidden="true"></i></div><h5>RSS</h5></header><div class="">';
		$GPS .= widget_feed($Social_rss, 10, 500, 'true', 'true');
		$GPS .= '</div></div>';
		$GPS .= '</div>';
	}
	/********************************************************/
	//si existe el dato
	if(isset($Social_youtube)&&$Social_youtube!=''){
		$GPS .= '';
	}
	/********************************************************/
	//si existe el dato
	if(isset($Social_tumblr)&&$Social_tumblr!=''){
		$GPS .= '<iframe src="https://tumblrwidget.com/#/embed/costcopizzablog/true/true/true/56847b/133d43/" width="600" height="600"></iframe>';
	}

	$GPS .= '</div>';
	$GPS .= '</div>';

	return $GPS;
}
/*******************************************************************************************************************/
//Muestra los widget sociales
function widget_Ficha_1($bg_color, $icon, $porcentaje,
						$titulo, $subtitulo,
						$enlace, $texto_enlace, $new_tab, $iframe){

	/********************************************************/
	//Definicion de errores
	$errorn = 0;
	//se definen las opciones disponibles
	$requerido = array(1, 2);
	//verifico si el dato ingresado existe dentro de las opciones
	if (!in_array($new_tab, $requerido)) {
		alert_post_data(4,1,1,0, 'La configuracion $new_tab ('.$new_tab.') no esta dentro de las opciones');
		$errorn++;
	}
	//verifico si el dato ingresado existe dentro de las opciones
	if (!in_array($iframe, $requerido)) {
		alert_post_data(4,1,1,0, 'La configuracion $iframe ('.$iframe.') no esta dentro de las opciones');
		$errorn++;
	}
	//se verifica si es un numero lo que se recibe
	if (!validarNumero($porcentaje)&&$porcentaje!=''){
		alert_post_data(4,1,1,0, 'El valor ingresado en $porcentaje ('.$porcentaje.') no es un numero');
		$errorn++;
	}
	//Verifica si el numero recibido es un entero
	if (!validaEntero($porcentaje)&&$porcentaje!=''){
		alert_post_data(4,1,1,0, 'El valor ingresado en $porcentaje ('.$porcentaje.') no es un numero entero');
		$errorn++;
	}
	/********************************************************/
	//Ejecucion si no hay errores
	if($errorn==0){

		//se crean las opciones
		switch ($new_tab) {
			case 1: $tab = '';break;
			case 2: $tab = 'target="_blank" rel="noopener noreferrer"'; break;
		}

		//se crean las opciones
		switch ($iframe) {
			case 1: $frame = '';break;
			case 2: $frame = 'iframe '; break;
		}

		//se crea el widget
		$widget = '
		<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
			<div class="info-box '.$bg_color.'">
				<span class="info-box-icon"><i class="fa '.$icon.'" aria-hidden="true"></i></span>
				<div class="info-box-content">
					<span class="info-box-text">'.$titulo.'</span>
					<span class="info-box-number">'.$subtitulo.'</span>
					<div class="progress">
						<div class="progress-bar" style="width: '.$porcentaje.'%"></div>
					</div>
					<span class="progress-description">';
						if(isset($enlace)){
							$widget .= '
							<a class="'.$frame.'faa-parent animated-hover" href="'.$enlace.'" '.$tab.'>
								'.$texto_enlace.'
								<i class="fa fa-arrow-circle-right faa-passing" aria-hidden="true"></i>
							</a>';
						}
						$widget .= '
					</span>
				</div>
			</div>
		</div>
		';

		//se devuelve el widget
		return $widget;
	}
}
/*******************************************************************************************************************/
//Muestra los widget sociales
function widget_Ficha_2($bg_color, $icon, $number, $width,
						$titulo, $subtitulo,
						$enlace, $texto_enlace, $color_enlace, $new_tab, $iframe){

	/********************************************************/
	//Definicion de errores
	$errorn = 0;
	//se definen las opciones disponibles
	$requerido = array(1, 2);
	//verifico si el dato ingresado existe dentro de las opciones
	if (!in_array($new_tab, $requerido)) {
		alert_post_data(4,1,1,0, 'La configuracion $new_tab ('.$new_tab.') no esta dentro de las opciones');
		$errorn++;
	}
	//verifico si el dato ingresado existe dentro de las opciones
	if (!in_array($iframe, $requerido)) {
		alert_post_data(4,1,1,0, 'La configuracion $iframe ('.$iframe.') no esta dentro de las opciones');
		$errorn++;
	}
	/********************************************************/
	//Ejecucion si no hay errores
	if($errorn==0){

		//se crean las opciones
		switch ($new_tab) {
			case 1: $tab = '';break;
			case 2: $tab = 'target="_blank" rel="noopener noreferrer"'; break;
		}

		//se crean las opciones
		switch ($iframe) {
			case 1: $frame = '';break;
			case 2: $frame = 'iframe '; break;
		}

		//se crea el widget
		$widget = '
		<div class="col-xs-12 col-sm-6 col-md-'.$width.' col-lg-'.$width.'">
			<div class="box '.$bg_color.' box-solid">
				<div class="box-header with-border">
					<h3 class="box-title">'.$titulo.'</h3>';
					if(isset($enlace)){
						$widget .= '
						<div class="box-tools pull-right">
							<a class="'.$frame.'btn btn-xs '.$color_enlace.' btn-line" href="'.$enlace.'" '.$tab.'>'.$texto_enlace.'</a>
						</div>';
					}
					$widget .= '
				</div>
				<div class="box-body">
					<div class="value">';
						if(isset($icon)){      $widget .= '<span><i class="fa '.$icon.'" aria-hidden="true"></i></span>';}
						if(isset($number)){    $widget .= '<span>'.$number.'</span>';}
						if(isset($subtitulo)){ $widget .= $subtitulo;}

						$widget .= '
					</div>
				</div>
			</div>
		</div>';

		//se devuelve el widget
		return $widget;
	}
}
/*******************************************************************************************************************/
//Muestra los widget sociales
function widget_Ficha_3($bg_color, $icon, $number,
						$titulo,
						$enlace, $texto_enlace, $new_tab, $iframe){

	/********************************************************/
	//Definicion de errores
	$errorn = 0;
	//se definen las opciones disponibles
	$requerido = array(1, 2);
	//verifico si el dato ingresado existe dentro de las opciones
	if (!in_array($new_tab, $requerido)) {
		alert_post_data(4,1,1,0, 'La configuracion $new_tab ('.$new_tab.') no esta dentro de las opciones');
		$errorn++;
	}
	//verifico si el dato ingresado existe dentro de las opciones
	if (!in_array($iframe, $requerido)) {
		alert_post_data(4,1,1,0, 'La configuracion $iframe ('.$iframe.') no esta dentro de las opciones');
		$errorn++;
	}
	//se verifica si es un numero lo que se recibe
	if (!validarNumero($number)&&$number!=''){
		alert_post_data(4,1,1,0, 'El valor ingresado en $number ('.$number.') no es un numero');
		$errorn++;
	}
	//Verifica si el numero recibido es un entero
	if (!validaEntero($number)&&$number!=''){
		alert_post_data(4,1,1,0, 'El valor ingresado en $number ('.$number.') no es un numero entero');
		$errorn++;
	}
	/********************************************************/
	//Ejecucion si no hay errores
	if($errorn==0){

		//se crean las opciones
		switch ($new_tab) {
			case 1: $tab = '';break;
			case 2: $tab = 'target="_blank" rel="noopener noreferrer"'; break;
		}

		//se crean las opciones
		switch ($iframe) {
			case 1: $frame = '';break;
			case 2: $frame = 'iframe '; break;
		}

		//se crea el widget
		$widget = '
		<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
			<div class="small-box '.$bg_color.'">
				<div class="innerbox">
					<h3>'.$number.'</h3>
					<p>'.$titulo.'</p>
				</div>
				<div class="icon">
					<i class="fa '.$icon.'" aria-hidden="true"></i>
				</div>
				<a '.$tab.' href="'.$enlace.'" class="'.$frame.'small-box-footer faa-parent animated-hover">
					'.$texto_enlace.' <i class="fa fa-arrow-circle-right faa-passing" aria-hidden="true"></i>
				</a>
			</div>
		</div>
		';

		//se devuelve el widget
		return $widget;
	}
}
/*******************************************************************************************************************/
//Muestra los widget sociales
function widget_Ficha_4($bg_color, $icon, $titulo, $subtitulo1, $subtitulo2){

	/********************************************************/
	//Definicion de errores
	$errorn = 0;

	/********************************************************/
	//Ejecucion si no hay errores
	if($errorn==0){

		//se crea el widget
		$widget = '
		<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 pull-left">
			<div class="info-box '.$bg_color.'" >
				<span class="info-box-icon">
					<i class="fa '.$icon.'" aria-hidden="true"></i>
				</span>
				<div class="info-box-content">
					<span class="info-box-text">'.$titulo.'</span>
					<span class="info-box-text">'.$subtitulo1.'</span>
					<span class="info-box-number">'.$subtitulo2.'</span>
				</div>
			</div>
		</div>';

		//se devuelve el widget
		return $widget;
	}
}
/*******************************************************************************************************************/
//Muestra los widget sociales
function widget_Ficha_5($bg_color, $icon, $titulo, $subtitulo, $link, $linktext){

	/********************************************************/
	//Definicion de errores
	$errorn = 0;

	/********************************************************/
	//Ejecucion si no hay errores
	if($errorn==0){

		//se crea el widget
		$widget = '
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
			<div class="panel '.$bg_color.'">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
							<i class="fa '.$icon.' fa-5x" aria-hidden="true"></i>
						</div>
						<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 text-right">
							<div class="huge">'.$titulo.'</div>
							<div>'.$subtitulo.'</div>
						</div>
					</div>
				</div>
				<a href="'.$link.'">
					<div class="panel-footer">
						<span class="pull-left">'.$linktext.'</span>
						<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
						<div class="clearfix"></div>
					 </div>
				</a>
			</div>
		</div>';

		//se devuelve el widget
		return $widget;
	}
}
/*******************************************************************************************************************/
//Muestra los widget sociales
function widget_Ficha_6($link, $bg_color, $icon, $titulo, $subtitulo, $linktext){

	/********************************************************/
	//Definicion de errores
	$errorn = 0;

	/********************************************************/
	//Ejecucion si no hay errores
	if($errorn==0){

		//se crea el widget
		$widget = '
		<div class="col-xs-6 col-sm-6 col-md-3 col-lg-2">
            <div class="circle-tile">
                <a href="'.$link.'">
                    <div class="circle-tile-heading '.$bg_color.'">
                        <i class="fa '.$icon.' fa-fw fa-3x"></i>
                    </div>
                </a>
                <div class="circle-tile-content '.$bg_color.'">
                    <div class="circle-tile-description text-faded">
                        '.$titulo.'
                    </div>
                    <div class="circle-tile-number text-faded">
                        '.$subtitulo.'
                        <span id="sparklineA"></span>
                    </div>
                    <a href="'.$link.'" class="circle-tile-footer">'.$linktext.' <i class="fa fa-chevron-circle-right"></i></a>
                </div>
            </div>
        </div>';

		//se devuelve el widget
		return $widget;
	}
}
/*******************************************************************************************************************/
//Muestra los widget sociales
function widget_Ficha_7($icon, $bg_color, $titulo, $value){

	/********************************************************/
	//Definicion de errores
	$errorn = 0;

	/********************************************************/
	//Ejecucion si no hay errores
	if($errorn==0){

		//se crea el widget
		$widget = '
		<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
			<div class="main-box infographic-box">
				<i class="fa '.$icon.' '.$bg_color.'"></i>
				<span class="headline">'.$titulo.'</span>
				<span class="value">
					<span class="timer">'.$value.'</span>
				</span>
			</div>
		</div>';

		//se devuelve el widget
		return $widget;
	}
}
/*******************************************************************************************************************/
//Muestra los widget sociales
function widget_Ficha_8($bg_color, $number, $titulo, $porcentaje, $subtitulos){

	/********************************************************/
	//Definicion de errores
	$errorn = 0;

	/********************************************************/
	//Ejecucion si no hay errores
	if($errorn==0){

		//se crea el widget
		$widget = '
		<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
			<div class="main-box small-graph-box '.$bg_color.'">
				<span class="value">'.$number.'</span>
				<span class="headline">'.$titulo.'</span>
				<div class="progress">
					<div style="width: '.$porcentaje.'%;" aria-valuemax="100" aria-valuemin="0" aria-valuenow="'.$porcentaje.'" role="progressbar" class="progress-bar">
						<span class="sr-only">'.$porcentaje.'% Complete</span>
					</div>
				</div>';
				if(!empty($subtitulos) && $subtitulos!=''){
					foreach ($subtitulos as $datos) {
						$widget.= '<span class="subinfo">'.$datos['dato'].'</span>';
					}
				}
				$widget.= '
			</div>
		</div>';

		//se devuelve el widget
		return $widget;
	}
}
/*******************************************************************************************************************/
//Muestra los widget sociales
function widget_Ficha_9($hover_color, $bg_color, $titulo,
						$porcentaje, $porcentaje_text, $porcentaje_color,
						$footer_1_number, $footer_1_text,
						$footer_2_number, $footer_2_text,
						$footer_3_number, $footer_3_text,
						$footer_extra, $link){

	/********************************************************/
	//Definicion de errores
	$errorn = 0;

	/********************************************************/
	//Ejecucion si no hay errores
	if($errorn==0){

		//se crea el widget
		$widget = '
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
			<div class="main-box clearfix project-box '.$hover_color.'">
				<div class="main-box-body clearfix">
					<div class="project-box-header '.$bg_color.'">
						<div class="name">
							<a href="'.$link.'">'.$titulo.'</a>
						</div>
					</div>
					<div class="project-box-content">
						<span class="chart" data-percent="'.$porcentaje.'" data-bar-color="'.$porcentaje_color.'">
							<span class="percent">'.$porcentaje.'</span>%<br>
							<span class="lbl">'.$porcentaje_text.'</span>
							<canvas width="130" height="130"></canvas>
						</span>
					</div>
					<div class="project-box-footer clearfix">
						<a href="#">
							<span class="value">'.$footer_1_number.'</span>
							<span class="label">'.$footer_1_text.'</span>
						</a>
						<a href="#">
							<span class="value">'.$footer_2_number.'</span>
							<span class="label">'.$footer_2_text.'</span>
						</a>
						<a href="#">
							<span class="value">'.$footer_3_number.'</span>
							<span class="label">'.$footer_3_text.'</span>
						</a>
					</div>
					<div class="project-box-ultrafooter clearfix">
						'.$footer_extra.'
						<a href="'.$link.'" class="link pull-right">
							<i class="fa fa-arrow-circle-right fa-lg"></i>
						</a>
					</div>
				</div>
			</div>
		</div>';

		//se devuelve el widget
		return $widget;
	}
}
/*******************************************************************************************************************/
//Muestra los widget sociales
function widget_Ficha_10($bg_color, $img_direction, $Nombre,$trabajo, $arrDatos, $arrLinks){

	/********************************************************/
	//Definicion de errores
	$errorn = 0;

	/********************************************************/
	//Ejecucion si no hay errores
	if($errorn==0){

		//se crea el widget
		$widget = '
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
			<div class="main-box clearfix profile-box-contact">
				<div class="main-box-body clearfix">
					<div class="profile-box-header '.$bg_color.' clearfix">
						<img src="'.$img_direction.'" alt="" class="profile-img img-responsive">
						<h2>'.$Nombre.'</h2>
						<div class="job-position">'.$trabajo.'</div>
						<ul class="contact-details">';
							foreach ($arrDatos as $datos) {
								$widget.= '<li><i class="fa '.$datos['Icon'].'"></i> '.$datos['Nombre'].'</li>';
							}
						$widget.= '
						</ul>
					</div>';
					if(!empty($arrLinks) && $arrLinks!=''){
						$widget.= '<div class="profile-box-footer clearfix">';
						foreach ($arrLinks as $datos) {
							$widget.= '
							<a href="'.$datos['link'].'">
								<span class="value">'.$datos['valor'].'</span>
								<span class="label">'.$datos['Texto'].'</span>
							</a>';
						}
						$widget.= '</div>';
					}
					$widget.= '
				</div>
			</div>
		</div>';

		//se devuelve el widget
		return $widget;
	}
}
/*******************************************************************************************************************/
//Muestra los widget sociales
function widget_Ficha_11($color, $bg_color, $text_color, $icon_color, $type, $porcentaje, $number, $text, $icon){

	/********************************************************/
	//Definicion de errores
	$errorn = 0;

	/********************************************************/
	//Ejecucion si no hay errores
	if($errorn==0){

		//se crea el widget
		$widget = '
		<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
			<div class="databox '.$color.' radius-bordered">
				<div class="databox-left '.$bg_color.'">
					<div class="databox-piechart">
						<div data-toggle="easypiechart" class="easyPieChart" data-barcolor="#fff" data-linecap="butt" data-percent="'.$porcentaje.'" data-animate="500" data-linewidth="3" data-size="47" data-trackcolor="rgba(255,255,255,0.1)" style="width: 47px; height: 47px; line-height: 47px;">
							<span class="color-white font-90">'.$porcentaje.'%</span>
							<canvas width="47" height="47"></canvas>
						</div>
					</div>
				</div>
				<div class="databox-right">
					<span class="databox-number '.$text_color.'">'.$number.'</span>
					<div class="databox-text color2-darkgray">'.$text.'</div>';
					switch ($type) {
						case 1: $widget.= '<div class="databox-stat '.$icon_color.'"><i class="fa '.$icon.'"></i></div>';break;
						case 2: $widget.= '<div class="databox-state '.$icon_color.'"><i class="fa '.$icon.'"></i></div>';break;
					}
					$widget.= '
				</div>
			</div>
		</div>';

		//se devuelve el widget
		return $widget;
	}
}
/*******************************************************************************************************************/
//Muestra los widget sociales
function widget_title($bg_color, $icon, $porcentaje, $titulo, $subtitulo_1, $subtitulo_2){

	/********************************************************/
	//Definicion de errores
	$errorn = 0;
	//se verifica si es un numero lo que se recibe
	if (!validarNumero($porcentaje)&&$porcentaje!=''){
		alert_post_data(4,1,1,0, 'El valor ingresado en $porcentaje ('.$porcentaje.') no es un numero');
		$errorn++;
	}
	//Verifica si el numero recibido es un entero
	if (!validaEntero($porcentaje)&&$porcentaje!=''){
		alert_post_data(4,1,1,0, 'El valor ingresado en $porcentaje ('.$porcentaje.') no es un numero entero');
		$errorn++;
	}
	/********************************************************/
	//Ejecucion si no hay errores
	if($errorn==0){

		//se crea el widget
		$widget = '
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-4" style="padding-left: 0px;">
			<div class="info-box '.$bg_color.'">
				<span class="info-box-icon"><i class="fa '.$icon.' faa-spin animated " aria-hidden="true"></i></span>
				<div class="info-box-content">
					<span class="info-box-text">'.$titulo.'</span>
					<span class="info-box-number">'.$subtitulo_1.'</span>
					<div class="progress"><div class="progress-bar" style="width: '.$porcentaje.'%"></div></div>
					<span class="progress-description">'.$subtitulo_2.'</span>
				</div>
			</div>
		</div>';

		//se devuelve el widget
		return $widget;
	}
}
/*******************************************************************************************************************/
//Muestra los widget sociales
function widget_titleIMG($bg_color, $img, $porcentaje, $titulo, $subtitulo_1, $subtitulo_2){

	/********************************************************/
	//Definicion de errores
	$errorn = 0;
	//se verifica si es un numero lo que se recibe
	if (!validarNumero($porcentaje)&&$porcentaje!=''){
		alert_post_data(4,1,1,0, 'El valor ingresado en $porcentaje ('.$porcentaje.') no es un numero');
		$errorn++;
	}
	//Verifica si el numero recibido es un entero
	if (!validaEntero($porcentaje)&&$porcentaje!=''){
		alert_post_data(4,1,1,0, 'El valor ingresado en $porcentaje ('.$porcentaje.') no es un numero entero');
		$errorn++;
	}
	/********************************************************/
	//Ejecucion si no hay errores
	if($errorn==0){

		//se crea el widget
		$widget = '
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-4" style="padding-left: 0px;">
			<div class="info-box '.$bg_color.'">
				<span class="info-box-icon">
					<img src="'.$img.'" alt="info-box-icon" width="60" height="60">
				</span>
				<div class="info-box-content">
					<span class="info-box-text">'.$titulo.'</span>
					<span class="info-box-number">'.$subtitulo_1.'</span>
					<div class="progress"><div class="progress-bar" style="width: '.$porcentaje.'%"></div></div>
					<span class="progress-description">'.$subtitulo_2.'</span>
				</div>
			</div>
		</div>';

		//se devuelve el widget
		return $widget;
	}
}
/*******************************************************************************************************************/
//Muestra los promedios de los equipos
function widget_CrossC($titulo, $timeBack, $seguimiento, $idSistema, $idTipoUsuario, $idUsuario, $dbConn){

	//Variable
	$SIS_where = "telemetria_listado.idEstado = 1 ";//solo equipos activos
	//Filtro de los tab
	$SIS_where .= " AND telemetria_listado.idTab = 2";//1Tek C
	//solo los equipos que tengan el seguimiento activado
	if(isset($seguimiento)&&$seguimiento!=''&&$seguimiento!=0){
		$SIS_where .= " AND telemetria_listado.id_Geo = ".$seguimiento;
	}
	//Filtro el sistema al cual pertenece
	if(isset($idSistema)&&$idSistema!=''&&$idSistema!=0){
		$SIS_where .= " AND telemetria_listado.idSistema = ".$idSistema;
	}
	//Verifico el tipo de usuario que esta ingresando y el id
	$SIS_join  = '';
	if(isset($idTipoUsuario, $idUsuario)&&$idTipoUsuario!=1&&$idUsuario!=0){
		$SIS_join  .= " INNER JOIN usuarios_equipos_telemetria ON usuarios_equipos_telemetria.idTelemetria = telemetria_listado.idTelemetria ";
		$SIS_where .= " AND usuarios_equipos_telemetria.idUsuario = ".$idUsuario;
	}

	/*************************************************************/
	//Se consulta
	$SIS_query = '
	telemetria_listado.idTelemetria,
	telemetria_listado.Nombre,
	telemetria_listado.cantSensores';
	$SIS_order = 'telemetria_listado.Nombre ASC';
	$arrEquipo = array();
	$arrEquipo = db_select_array (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrEquipo');

	/**************************************************************/
	//verifico la existencia de al menos un dato
	if(isset($arrEquipo[0]['idTelemetria'])&&$arrEquipo[0]['idTelemetria']!=''){
		/*************************************************************/
		//identificacion
		$idTelemetria      = $arrEquipo[0]['idTelemetria'];
		$N_Maximo_Sensores = $arrEquipo[0]['cantSensores'];

		//Se Guardan datos
		$_SESSION['usuario']['widget_CrossC']['idTelemetria']  = $arrEquipo[0]['idTelemetria'];
		$_SESSION['usuario']['widget_CrossC']['cantSensores']  = $arrEquipo[0]['cantSensores'];
		$_SESSION['usuario']['widget_CrossC']['timeBack']      = $timeBack;
		$_SESSION['usuario']['widget_CrossC']['seguimiento']   = $seguimiento;
		$_SESSION['usuario']['widget_CrossC']['idSistema']     = $idSistema;
		$_SESSION['usuario']['widget_CrossC']['idTipoUsuario'] = $idTipoUsuario;
		$_SESSION['usuario']['widget_CrossC']['idUsuario']     = $idUsuario;

		//variables
		$HoraInicio     = restahoras($timeBack,hora_actual());
		$FechaInicio    = fecha_actual();
		$HoraTermino    = hora_actual();
		$FechaTermino   = fecha_actual();
		if($HoraTermino<$timeBack){
			$FechaInicio = restarDias($FechaTermino,1);
		}

		/*************************************************************/
		//Se consulta
		$SIS_query = '
		telemetria_listado.LastUpdateFecha,
		telemetria_listado.LastUpdateHora,
		telemetria_listado.TiempoFueraLinea';
		for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
			$SIS_query .= ',telemetria_listado_sensores_grupo.SensoresGrupo_'.$i;
			$SIS_query .= ',telemetria_listado_sensores_revision_grupo.SensoresRevisionGrupo_'.$i;
			$SIS_query .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i;
			$SIS_query .= ',telemetria_listado_sensores_med_actual.SensoresMedActual_'.$i;
			$SIS_query .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$i;
		}
		$SIS_join  .= '
		LEFT JOIN `telemetria_listado_sensores_grupo`          ON telemetria_listado_sensores_grupo.idTelemetria          = telemetria_listado.idTelemetria
		LEFT JOIN `telemetria_listado_sensores_revision_grupo` ON telemetria_listado_sensores_revision_grupo.idTelemetria = telemetria_listado.idTelemetria
		LEFT JOIN `telemetria_listado_sensores_unimed`         ON telemetria_listado_sensores_unimed.idTelemetria         = telemetria_listado.idTelemetria
		LEFT JOIN `telemetria_listado_sensores_med_actual`     ON telemetria_listado_sensores_med_actual.idTelemetria     = telemetria_listado.idTelemetria
		LEFT JOIN `telemetria_listado_sensores_activo`         ON telemetria_listado_sensores_activo.idTelemetria         = telemetria_listado.idTelemetria';
		$SIS_where = 'telemetria_listado.idTelemetria='.$idTelemetria;
		$rowEquipo = db_select_data (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $dbConn, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowEquipo');

		//busco los grupos disponibles
		$arrSubgrupo          = array();
		$arrSubgrupoUso       = array();
		$SIS_whereSubgrupo    = 'idGrupo=0';
		$SIS_whereSubgrupoUso = 'idGrupo=0';
		//creo arreglo
		for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
			$arrSubgrupo[$rowEquipo['SensoresGrupo_'.$i]]['idGrupo']            = $rowEquipo['SensoresGrupo_'.$i];
			$arrSubgrupoUso[$rowEquipo['SensoresRevisionGrupo_'.$i]]['idGrupo'] = $rowEquipo['SensoresRevisionGrupo_'.$i];
		}
		//se crea cadena
		foreach($arrSubgrupo as $categoria=>$sub){
			$SIS_whereSubgrupo .= ' OR idGrupo='.$sub['idGrupo'];
		}
		foreach($arrSubgrupoUso as $categoria=>$sub){
			$SIS_whereSubgrupoUso .= ' OR idGrupo='.$sub['idGrupo'];
		}

		/*************************************************************/
		//Se consulta
		$SIS_query = 'FechaSistema,HoraSistema';
		for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
			$SIS_query .= ',Sensor_'.$i.' AS SensorValue_'.$i;
		}
		$SIS_join  = '';
		$SIS_where = '(TimeStamp BETWEEN "'.$FechaInicio.' '.$HoraInicio.'" AND "'.$FechaTermino.' '.$HoraTermino.'")';
		$SIS_order = 'FechaSistema ASC,HoraSistema ASC LIMIT 10000';
		$arrMediciones = array();
		$arrMediciones = db_select_array (false, $SIS_query, 'telemetria_listado_tablarelacionada_'.$idTelemetria, $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrMediciones');

		/*************************************************************/
		//Se consulta
		$arrGrupos = array();
		$arrGrupos = db_select_array (false, 'idGrupo, Nombre', 'telemetria_listado_grupos', '', $SIS_whereSubgrupo, 'Nombre ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrGrupos');
		//se recorre
		$arrGruposTemp = array();
		foreach ($arrGrupos as $gru) {
			$arrGruposTemp[$gru['idGrupo']] = $gru['Nombre'];
		}

		/*************************************************************/
		//Se consulta
		$T_idGrupo    = 0;
		$arrGruposUso = array();
		$arrGruposUso = db_select_array (false, 'idGrupo, Nombre', 'telemetria_listado_grupos_uso', '', $SIS_whereSubgrupoUso, 'Nombre ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrGruposUso');
		//se recorre
		$arrGruposUsoTemp = array();
		foreach ($arrGruposUso as $gruUso) {
			$arrGruposUsoTemp[$gruUso['idGrupo']] = $gruUso['Nombre'];
			//guardo el primer grupo
			if($T_idGrupo==0){
				$T_idGrupo = $gruUso['idGrupo'];
			}
		}

		/*************************************************************/
		//Variables
		$arrTempGrupos = array();
		$arrTempSensor = array();
		$arrTempMed    = array();
		$Temp_1        = '';
		$arrData       = array();
		$arrDatax      = array();

		//Se recorren las mediciones
		foreach($arrMediciones as $cli) {

			/******************************/
			//reseteo
			$arrTemporal = array();

			/******************************/
			//recorro los sensores
			for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
				//Verifico si el sensor esta activo para guardar el dato
				if(isset($rowEquipo['SensoresActivo_'.$i])&&$rowEquipo['SensoresActivo_'.$i]==1){
					//Valido valores
					if(isset($cli['SensorValue_'.$i])&&$cli['SensorValue_'.$i]<999){
						/********************************/
						//datos
						//Sumo los sensores
						if(isset($arrTempMed[$i]['Suma'])&&$arrTempMed[$i]['Suma']!=''){
							$arrTempMed[$i]['Suma'] = $arrTempMed[$i]['Suma'] + $cli['SensorValue_'.$i];
						}else{
							$arrTempMed[$i]['Suma'] = $cli['SensorValue_'.$i];
						}
						//Cuento los sensores
						if(isset($arrTempMed[$i]['Cuenta'])&&$arrTempMed[$i]['Cuenta']!=''){
							$arrTempMed[$i]['Cuenta']++;
						}else{
							$arrTempMed[$i]['Cuenta'] = 1;
						}
						//Min de los sensores
						if(isset($arrTempMed[$i]['Min'])&&$arrTempMed[$i]['Min']!=''){
							//verifico si es menor
							if($arrTempMed[$i]['Min']>$cli['SensorValue_'.$i]){
								$arrTempMed[$i]['Min'] = $cli['SensorValue_'.$i];
							}
						}else{
							$arrTempMed[$i]['Min'] = $cli['SensorValue_'.$i];
						}
						//Max de los sensores
						if(isset($arrTempMed[$i]['Max'])&&$arrTempMed[$i]['Max']!=''){
							//verifico si es mayor
							if($arrTempMed[$i]['Max']<$cli['SensorValue_'.$i]){
								$arrTempMed[$i]['Max'] = $cli['SensorValue_'.$i];
							}
						}else{
							$arrTempMed[$i]['Max'] = $cli['SensorValue_'.$i];
						}

						/********************************/
						//Grafico
						//Si es temperatura
						//if($rowEquipo['SensoresUniMed_'.$i]==3&&$rowEquipo['SensoresRevisionGrupo_'.$i]==$arrGruposUso[0]['idGrupo']){
						if($rowEquipo['SensoresUniMed_'.$i]==3){
							//verifico si existe
							if(isset($arrTemporal[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Valor'])&&$arrTemporal[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Valor']!=''){
								$arrTemporal[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Valor'] = $arrTemporal[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Valor'] + $cli['SensorValue_'.$i];
								$arrTemporal[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Cuenta']++;
							//si no lo crea
							}else{
								$arrTemporal[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Valor']  = $cli['SensorValue_'.$i];
								$arrTemporal[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Cuenta'] = 1;
							}
						}
					}
				}
			}

			//Guardo la fecha
			$Temp_1 .= "'".Fecha_estandar($cli['FechaSistema'])." - ".$cli['HoraSistema']."',";

			/********************************/
			//Grafico
			//recorro grupo de uso
			foreach ($arrGruposUso as $gruUso) {
				//verifico que sea el primer grupo
				if($T_idGrupo==$gruUso['idGrupo']){
					//recorro los grupos
					foreach ($arrGrupos as $gru) {

						/***********************************************/
						//verifico si hay datos
						if(isset($arrTemporal[$gruUso['idGrupo']][$gru['idGrupo']]['Cuenta'])&&$arrTemporal[$gruUso['idGrupo']][$gru['idGrupo']]['Cuenta']!=0){
							//realizo los calculos
							$New_Dato = $arrTemporal[$gruUso['idGrupo']][$gru['idGrupo']]['Valor']/$arrTemporal[$gruUso['idGrupo']][$gru['idGrupo']]['Cuenta'];
							$arrDatax[$gruUso['idGrupo']][$gru['idGrupo']]['New_Dato'] = $New_Dato;
						//si no hay datos utilizo el anterior
						}else{
							$New_Dato = $arrDatax[$gruUso['idGrupo']][$gru['idGrupo']]['New_Dato'];
						}

						/***********************************************/
						//verifico si existe el dato
						if(isset($arrData[$gruUso['idGrupo']][$gru['idGrupo']]['Value'])&&$arrData[$gruUso['idGrupo']][$gru['idGrupo']]['Value']!=''){
							$arrData[$gruUso['idGrupo']][$gru['idGrupo']]['Value'] .= ", ".$New_Dato;
						//si no lo crea
						}else{
							$arrData[$gruUso['idGrupo']][$gru['idGrupo']]['Value'] = $New_Dato;
						}
					}
				}
			}
		}

		//variables
		$x_graph_count        = 0;
		$Graphics_xData       = 'var xData = [';
		$Graphics_yData       = 'var yData = [';
		$Graphics_names       = 'var names = [';
		$Graphics_types       = 'var types = [';
		$Graphics_texts       = 'var texts = [';
		$Graphics_lineColors  = 'var lineColors = [';
		$Graphics_lineDash    = 'var lineDash = [';
		$Graphics_lineWidth   = 'var lineWidth = [';
		//Se crean los datos
		foreach ($arrGruposUso as $gruUso) {
			foreach ($arrGrupos as $gru) {
				if(isset($arrData[$gruUso['idGrupo']][$gru['idGrupo']]['Value'])&&$arrData[$gruUso['idGrupo']][$gru['idGrupo']]['Value']!=''){
					//las fechas
					$Graphics_xData      .='['.$Temp_1.'],';
					//los valores
					$Graphics_yData      .='['.$arrData[$gruUso['idGrupo']][$gru['idGrupo']]['Value'].'],';
					//los nombres
					$Graphics_names      .= '"'.DeSanitizar(TituloMenu($gruUso['Nombre']).' - '.TituloMenu($gru['Nombre'])).'",';
					//los tipos
					$Graphics_types      .= "'',";
					//si lleva texto en las burbujas
					$Graphics_texts      .= "[],";
					//los colores de linea
					$Graphics_lineColors .= "'',";
					//los tipos de linea
					$Graphics_lineDash   .= "'',";
					//los anchos de la linea
					$Graphics_lineWidth  .= "'',";
					//contador
					$x_graph_count++;
				}
			}
		}
		$Graphics_xData      .= '];';
		$Graphics_yData      .= '];';
		$Graphics_names      .= '];';
		$Graphics_types      .= '];';
		$Graphics_texts      .= '];';
		$Graphics_lineColors .= '];';
		$Graphics_lineDash   .= '];';
		$Graphics_lineWidth  .= '];';

		for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
			//Verifico si el sensor esta activo para guardar el dato
			if(isset($rowEquipo['SensoresActivo_'.$i])&&$rowEquipo['SensoresActivo_'.$i]==1){
				/*****************************************/
				//Grupo Uso
				$arrTempGrupos[$rowEquipo['SensoresRevisionGrupo_'.$i]]['Nombre']  = $arrGruposUsoTemp[$rowEquipo['SensoresRevisionGrupo_'.$i]];
				$arrTempGrupos[$rowEquipo['SensoresRevisionGrupo_'.$i]]['idGrupo'] = $rowEquipo['SensoresRevisionGrupo_'.$i];
				/*****************************************/
				//Grupo
				/**********************/
				//Si es temperatura
				if($rowEquipo['SensoresUniMed_'.$i]==3){
					//Nombre y grupo
					$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Nombre']  = $arrGruposTemp[$rowEquipo['SensoresGrupo_'.$i]];
					$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['idGrupo'] = $rowEquipo['SensoresGrupo_'.$i];
					//Temperatura Minima
					if(isset($arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Tmin'])&&$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Tmin']!=''){
						//verifico si es menor
						if($arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Tmin']>$arrTempMed[$i]['Min']){
							$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Tmin'] = $arrTempMed[$i]['Min'];
						}
					}else{
						$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Tmin'] = $arrTempMed[$i]['Min'];
					}
					//Temperatura Maxima
					if(isset($arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Tmax'])&&$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Tmax']!=''){
						//verifico si es mayor
						if($arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Tmax']<$arrTempMed[$i]['Max']){
							$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Tmax'] = $arrTempMed[$i]['Max'];
						}
					}else{
						$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Tmax'] = $arrTempMed[$i]['Max'];
					}
					//valido que este dentro del rango deseado
					if($rowEquipo['SensoresMedActual_'.$i]<999){
						//Temperatura Actual
						if(isset($arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['TActual'])&&$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['TActual']!=''){
							$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['TActual'] = $arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['TActual'] + $rowEquipo['SensoresMedActual_'.$i];
							$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['CountTActual']++;
						}else{
							$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['TActual'] = $rowEquipo['SensoresMedActual_'.$i];
							$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['CountTActual'] = 1;
						}
					}
					//promedio
					if(isset($arrTempMed[$i]['Suma'])){
						if(isset($arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Prom'])&&$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Prom']!=''){
							$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Prom']      = $arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Prom'] + $arrTempMed[$i]['Suma'];
							$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['CountProm'] = $arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['CountProm'] + $arrTempMed[$i]['Cuenta'];
						}else{
							$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Prom']      = $arrTempMed[$i]['Suma'];
							$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['CountProm'] = $arrTempMed[$i]['Cuenta'];
						}
					}else{
						$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Prom']      = 0;
						$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['CountProm'] = 0;
					}

					//estado (siempre pasa)
					$arrTempGrupos[$rowEquipo['SensoresRevisionGrupo_'.$i]]['NErrores'] = 0;
					$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['NErrores'] = 0;

				/**********************/
				//si es humedad
				}elseif($rowEquipo['SensoresUniMed_'.$i]==2){
					//valido que este dentro del rango deseado
					if($rowEquipo['SensoresMedActual_'.$i]<999){
						//Humedad
						if(isset($arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Hum'])&&$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Hum']!=''){
							$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Hum'] = $arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Hum'] + $rowEquipo['SensoresMedActual_'.$i];
							$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['CountHum']++;
						}else{
							$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Hum'] = $rowEquipo['SensoresMedActual_'.$i];
							$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['CountHum'] = 1;
						}
					}
					//estado (siempre pasa)
					$arrTempGrupos[$rowEquipo['SensoresRevisionGrupo_'.$i]]['NErrores'] = 0;
					$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['NErrores'] = 0;

				/**********************/
				//si es boolean
				}elseif($rowEquipo['SensoresUniMed_'.$i]==12){
					//valido que este dentro del rango deseado
					if($rowEquipo['SensoresMedActual_'.$i]<999){
						//Humedad
						if(isset($arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Bool'])&&$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Hum']!=''){
							$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Bool'] = $arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Bool'] + $rowEquipo['SensoresMedActual_'.$i];
							$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['CountBool']++;
						}else{
							$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Bool'] = $rowEquipo['SensoresMedActual_'.$i];
							$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['CountBool'] = 1;
						}
					}
					//estado (siempre pasa)
					/*$arrTempGrupos[$rowEquipo['SensoresRevisionGrupo_'.$i]]['NErrores'] = 0;
					$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['NErrores'] = 0;
					*/
				}
			}
		}

		/*************************************************************/
		//Se dibuja
		$widget = '
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="box">
				<header>
					<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
					<h5>Equipos</h5>
					<ul class="nav nav-tabs pull-right">';
						$xcounter = 1;
						foreach($arrEquipo as $cli) {
							if($xcounter==1){$xactive = 'active';}else{$xactive = '';}
							if($xcounter==4){
								$widget .= '<li class="dropdown"><a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a><ul class="dropdown-menu" role="menu">';
							}
							$widget .= '<li class="'.$xactive.'"><a href="" onClick="chngEquipo('.$cli['idTelemetria'].', '.$cli['cantSensores'].')"  data-toggle="tab"><i class="fa fa-map-marker" aria-hidden="true"></i> '.$cli['Nombre'].'</a></li>';
							$xcounter++;
						}
						if($xcounter>4){ $widget .= '</ul></li>';}
					$widget .= '
					</ul>
				</header>

				<div class="tab-content">

					<div id="loading"></div>

					<div id="update_content">
						<div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
							<div class="row">
								<div class="table-responsive">
									<div class="table-wrapper-scroll-y my-custom-scrollbar">
										<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
											<thead>
												<tr role="row">
													<th colspan="3">Grupo - Subgrupo</th>
													<th>T° Actual</th>
													<th>T° Max</th>
													<th>T° Min</th>
													<th>T° Prom</th>
													<th>Hr. Prom</th>
													<th>Acciones</th>
												</tr>
											</thead>
											<tbody role="alert" aria-live="polite" aria-relevant="all" id="TableFiltered">';

												/**********************************************/
												//variable
												$in_eq_fueralinea = '';
												//Fuera de linea
												$diaInicio   = $rowEquipo['LastUpdateFecha'];
												$diaTermino  = $FechaTermino;
												$tiempo1     = $rowEquipo['LastUpdateHora'];
												$tiempo2     = $HoraTermino;
												$Tiempo      = horas_transcurridas($diaInicio, $diaTermino, $tiempo1, $tiempo2);

												//Comparaciones de tiempo
												$Time_Tiempo     = horas2segundos($Tiempo);
												$Time_Tiempo_FL  = horas2segundos($rowEquipo['TiempoFueraLinea']);
												$Time_Tiempo_Max = horas2segundos('48:00:00');
												$Time_Fake_Ini   = horas2segundos('23:59:50');
												$Time_Fake_Fin   = horas2segundos('24:00:00');
												//comparacion
												if(($Time_Tiempo<$Time_Fake_Ini OR $Time_Tiempo>$Time_Fake_Fin)&&(($Time_Tiempo>$Time_Tiempo_FL&&$Time_Tiempo_FL!=0) OR ($Time_Tiempo>$Time_Tiempo_Max&&$Time_Tiempo_FL==0))){
													$in_eq_fueralinea = '<i class="fa fa-exclamation-triangle faa-bounce animated" style="color: #a94442;" aria-hidden="true"></i>';
												}

												/***********************************************/
												//imprimo
												$widget .= '
													<tr class="odd">
														<th colspan="8">'.$in_eq_fueralinea.' Ultima Medicion: '.fecha_estandar($rowEquipo['LastUpdateFecha']).' a las '.$rowEquipo['LastUpdateHora'].' hrs.</th>
														<th><a href="view_alertas_personalizadas.php?view='.simpleEncode($_SESSION['usuario']['widget_CrossC']['idTelemetria'], fecha_actual()).'" class="iframe btn btn-danger btn-sm"><i class="fa fa-bell-o" aria-hidden="true"></i> Alertas</a></th>
													</tr>';

												//Ordeno
												sort($arrTempGrupos);
												//recorro
												foreach ($arrTempGrupos as $gruUso) {
													//verificar errores
													if(isset($gruUso['NErrores'])&&$gruUso['NErrores']!=0){
														$danger_color = 'warning';
														$danger_icon  = '<a href="#" title="Equipo con Alertas" class="btn btn-warning btn-sm tooltip"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></a>';
													}else{
														$danger_color = '';
														$danger_icon  = '<a href="#" title="Sin Problemas" class="btn btn-success btn-sm tooltip"><i class="fa fa-check" aria-hidden="true"></i></a>';
													}
													$widget .= '
													<tr class="odd '.$danger_color.'">
														<th><div class="btn-group" style="width: 35px;" >'.$danger_icon.'</div></th>
														<th colspan="7">'.TituloMenu($gruUso['Nombre']).'</th>
														<th>
															<div class="btn-group" style="width: 35px;" >
																<button onClick="chngGroupUsoGraph('.$_SESSION['usuario']['widget_CrossC']['idTelemetria'].', '.$_SESSION['usuario']['widget_CrossC']['cantSensores'].', '.$gruUso['idGrupo'].')" title="Ver Información" class="btn btn-primary btn-sm tooltip"><i class="fa fa-line-chart" aria-hidden="true"></i></button>
															</div>
														</th>
													</tr>';
													//se ordena el arreglo
													sort($arrTempSensor[$gruUso['idGrupo']]);
													//recorro el arreglo
													foreach ($arrTempSensor[$gruUso['idGrupo']] as $gru) {
														//verificar errores
														if(isset($gru['NErrores'])&&$gru['NErrores']!=0){
															$danger_color = 'warning';
															$danger_icon  = '<a href="#" title="Equipo con Alertas" class="btn btn-warning btn-sm tooltip"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></a>';
														}else{
															$danger_color = '';
															$danger_icon  = '<a href="#" title="Sin Problemas" class="btn btn-success btn-sm tooltip"><i class="fa fa-check" aria-hidden="true"></i></a>';
														}
														//variables
														$Tmin    = Cantidades($gru['Tmin'], 1);
														$Tmax    = Cantidades($gru['Tmax'], 1);
														if(isset($gru['CountTActual'])&&$gru['CountTActual']!=0){  $TActual = Cantidades(($gru['TActual']/$gru['CountTActual']), 1); }else{ $TActual = 0; }
														if(isset($gru['CountProm'])&&$gru['CountProm']!=0){        $Prom    = Cantidades(($gru['Prom']/$gru['CountProm']), 1);       }else{ $Prom    = 0; }
														if(isset($gru['CountHum'])&&$gru['CountHum']!=0){          $Hum     = Cantidades(($gru['Hum']/$gru['CountHum']), 1);         }else{ $Hum     = 0; }
														if(isset($gru['CountBool'])&&$gru['CountBool']!=0){
															$tempv  = $gru['Bool']/$gru['CountBool'];
															$s_link = 'informe_telemetria_registro_sensores_20.php?f_inicio='.fecha_actual().'&f_termino='.fecha_actual().'&idTelemetria='.$idTelemetria.'&RevisionGrupo='.$gruUso['idGrupo'].'&submit_filter=Filtrar';
															//si esta abierto
															if($tempv!=0){
																$danger_color = 'warning';
																$danger_icon .= '<a target="_blank" rel="noopener noreferrer" href="'.$s_link.'" title="Puertas Abiertas" class="btn btn-warning btn-sm tooltip"><i class="fa fa-sign-out" aria-hidden="true"></i></a>';
															//si esta cerrado
															}else{
																$danger_icon .= '<a target="_blank" rel="noopener noreferrer" href="'.$s_link.'" title="Puertas Cerradas" class="btn btn-success btn-sm tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i></a>';
															}
														//si no hay puertas configuradas
														}else{
															$danger_icon .= '';
														}

														$widget .= '
														<tr class="odd '.$danger_color.'">
															<td></td>
															<td><div class="btn-group" style="width: 70px;" >'.$danger_icon.'</div></td>
															<td>'.TituloMenu($gru['Nombre']).'</td>
															<td>'.$TActual.' °C</td>
															<td>'.$Tmax.' °C</td>
															<td>'.$Tmin.' °C</td>
															<td>'.$Prom.' °C</td>
															<td>'.$Hum.' %</td>
															<td>
																<div class="btn-group" style="width: 70px;" >
																	<button onClick="chngGroupGraph('.$_SESSION['usuario']['widget_CrossC']['idTelemetria'].', '.$_SESSION['usuario']['widget_CrossC']['cantSensores'].', '.$gruUso['idGrupo'].', '.$gru['idGrupo'].')" title="Ver Información" class="btn btn-metis-6 btn-sm tooltip"><i class="fa fa-line-chart" aria-hidden="true"></i></button>
																</div>
															</td>
														</tr>';
													}
												}

											$widget .= '
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
							<div class="row" id="update_graphics">';
								//si hay datos
								if(isset($x_graph_count)&&$x_graph_count!=0){
									$gr_tittle = 'Grafico '.$arrGruposUsoTemp[$arrGruposUso[0]['idGrupo']];
									$gr_unimed = '°C';
									$widget .= GraphLinear_1('graphLinear_1', $gr_tittle, 'Fecha', $gr_unimed, $Graphics_xData, $Graphics_yData, $Graphics_names, $Graphics_types, $Graphics_texts, $Graphics_lineColors, $Graphics_lineDash, $Graphics_lineWidth, 1);
								//si no hay datos
								}else{
									$widget .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><br/>';
									$widget .= '<div class="alert alert-danger alert-white rounded alert_box_correction" role="alert"><div class="icon"><i class="fa fa-info-circle faa-bounce animated" aria-hidden="true"></i></div><span id="alert_post_data">No hay datos para desplegar el grafico</span><div class="clearfix"></div></div>';
									$widget .= '</div>';
								}
								$widget .= '
							</div>
						</div>
					</div>

					<div class="clearfix"></div>

				</div>
			</div>
		</div>';

		$widget .= '
		<script>
		//oculto el loader
		document.getElementById("loading").style.display = "none";

		/* ************************************************************************** */
		function chngEquipo(idTelemetria,cantSensores) {
			//muestro el loader
			document.getElementById("loading").style.display = "block";

			//Pido actualizacion
			$("#update_content").load("principal_update_widget_CrossC.php?idTelemetria=" + idTelemetria + "&cantSensores="+cantSensores);

			//se esperan 3 segundos
			setTimeout(
				function(){
					//oculto el loader
					document.getElementById("loading").style.display = "none";
				}
			, 3000);
		}
		/* ************************************************************************** */
		function chngGroupUsoGraph(idTelemetria,cantSensores,idGrupoUso) {
			//muestro el loader
			document.getElementById("loading").style.display = "block";

			//Pido actualizacion
			$("#update_graphics").load("principal_update_widget_CrossC_Group.php?idTelemetria=" + idTelemetria + "&cantSensores="+cantSensores + "&idGrupoUso="+idGrupoUso);

			//se esperan 3 segundos
			setTimeout(
				function(){
					//oculto el loader
					document.getElementById("loading").style.display = "none";
				}
			, 3000);
		}
		/* ************************************************************************** */
		function chngGroupGraph(idTelemetria,cantSensores,idGrupoUso,idGrupo) {
			//muestro el loader
			document.getElementById("loading").style.display = "block";

			//Pido actualizacion
			$("#update_graphics").load("principal_update_widget_CrossC_Sensor.php?idTelemetria=" + idTelemetria + "&cantSensores="+cantSensores + "&idGrupoUso="+idGrupoUso + "&idGrupo="+idGrupo);

			//se esperan 3 segundos
			setTimeout(
				function(){
					//oculto el loader
					document.getElementById("loading").style.display = "none";
				}
			, 3000);
		}
		</script>
		';
		return $widget;
	}else{

		return alert_post_data(4,1,1,0, 'No hay equipos de este sistema asignados a este perfil');
	}

}
/*******************************************************************************************************************/
//Muestra los promedios de los equipos
function widget_CrossC_Walmart($timeBack, $seguimiento, $idSistema, $idTipoUsuario, $idUsuario, $dbConn){

	//Variable
	$SIS_where = "telemetria_listado.idEstado = 1 ";//solo equipos activos
	//Filtro de los tab
	$SIS_where .= " AND telemetria_listado.idTab = 2";//1Tek C
	$SIS_where .= " AND telemetria_listado.Nombre LIKE 'W.%'";//Comienza por w.
	//solo los equipos que tengan el seguimiento activado
	if(isset($seguimiento)&&$seguimiento!=''&&$seguimiento!=0){
		$SIS_where .= " AND telemetria_listado.id_Geo = ".$seguimiento;
	}
	//Filtro el sistema al cual pertenece
	if(isset($idSistema)&&$idSistema!=''&&$idSistema!=0){
		$SIS_where .= " AND telemetria_listado.idSistema = ".$idSistema;
	}
	//Verifico el tipo de usuario que esta ingresando y el id
	$SIS_join  = '';
	if(isset($idTipoUsuario, $idUsuario)&&$idTipoUsuario!=1&&$idUsuario!=0){
		$SIS_join  .= " INNER JOIN usuarios_equipos_telemetria ON usuarios_equipos_telemetria.idTelemetria = telemetria_listado.idTelemetria ";
		$SIS_where .= " AND usuarios_equipos_telemetria.idUsuario = ".$idUsuario;
	}

	/*************************************************************/
	//Se consulta
	$SIS_query = '
	telemetria_listado.idTelemetria,
	telemetria_listado.Nombre,
	telemetria_listado.cantSensores';
	$SIS_order = 'telemetria_listado.Nombre ASC';
	$arrEquipo = array();
	$arrEquipo = db_select_array (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrEquipo');

	/**************************************************************/
	//verifico la existencia de al menos un dato
	if(isset($arrEquipo[0]['idTelemetria'])&&$arrEquipo[0]['idTelemetria']!=''){
		/*************************************************************/
		//identificacion
		$idTelemetria      = $arrEquipo[0]['idTelemetria'];
		$N_Maximo_Sensores = $arrEquipo[0]['cantSensores'];

		//Se Guardan datos
		$_SESSION['usuario']['widget_CrossC_Walmart']['idTelemetria']  = $arrEquipo[0]['idTelemetria'];
		$_SESSION['usuario']['widget_CrossC_Walmart']['cantSensores']  = $arrEquipo[0]['cantSensores'];
		$_SESSION['usuario']['widget_CrossC_Walmart']['timeBack']      = $timeBack;
		$_SESSION['usuario']['widget_CrossC_Walmart']['seguimiento']   = $seguimiento;
		$_SESSION['usuario']['widget_CrossC_Walmart']['idSistema']     = $idSistema;
		$_SESSION['usuario']['widget_CrossC_Walmart']['idTipoUsuario'] = $idTipoUsuario;
		$_SESSION['usuario']['widget_CrossC_Walmart']['idUsuario']     = $idUsuario;

		//variables
		$HoraInicio     = restahoras($timeBack,hora_actual());
		$FechaInicio    = fecha_actual();
		$HoraTermino    = hora_actual();
		$FechaTermino   = fecha_actual();
		if($HoraTermino<$timeBack){
			$FechaInicio = restarDias($FechaTermino,1);
		}

		/*************************************************************/
		//Se consulta
		$SIS_query = '
		telemetria_listado.LastUpdateFecha,
		telemetria_listado.LastUpdateHora,
		telemetria_listado.TiempoFueraLinea';
		for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
			$SIS_query .= ',telemetria_listado_sensores_grupo.SensoresGrupo_'.$i;
			$SIS_query .= ',telemetria_listado_sensores_revision_grupo.SensoresRevisionGrupo_'.$i;
			$SIS_query .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i;
			$SIS_query .= ',telemetria_listado_sensores_med_actual.SensoresMedActual_'.$i;
			$SIS_query .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$i;
		}
		$SIS_join  .= '
		LEFT JOIN `telemetria_listado_sensores_grupo`          ON telemetria_listado_sensores_grupo.idTelemetria          = telemetria_listado.idTelemetria
		LEFT JOIN `telemetria_listado_sensores_revision_grupo` ON telemetria_listado_sensores_revision_grupo.idTelemetria = telemetria_listado.idTelemetria
		LEFT JOIN `telemetria_listado_sensores_unimed`         ON telemetria_listado_sensores_unimed.idTelemetria         = telemetria_listado.idTelemetria
		LEFT JOIN `telemetria_listado_sensores_med_actual`     ON telemetria_listado_sensores_med_actual.idTelemetria     = telemetria_listado.idTelemetria
		LEFT JOIN `telemetria_listado_sensores_activo`         ON telemetria_listado_sensores_activo.idTelemetria         = telemetria_listado.idTelemetria';
		$SIS_where = 'telemetria_listado.idTelemetria='.$idTelemetria;
		$rowEquipo = db_select_data (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $dbConn, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowEquipo');

		//busco los grupos disponibles
		$arrSubgrupo          = array();
		$arrSubgrupoUso       = array();
		$SIS_whereSubgrupo    = 'idGrupo=0';
		$SIS_whereSubgrupoUso = 'idGrupo=0';
		//creo arreglo
		for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
			$arrSubgrupo[$rowEquipo['SensoresGrupo_'.$i]]['idGrupo']            = $rowEquipo['SensoresGrupo_'.$i];
			$arrSubgrupoUso[$rowEquipo['SensoresRevisionGrupo_'.$i]]['idGrupo'] = $rowEquipo['SensoresRevisionGrupo_'.$i];
		}
		//se crea cadena
		foreach($arrSubgrupo as $categoria=>$sub){
			$SIS_whereSubgrupo .= ' OR idGrupo='.$sub['idGrupo'];
		}
		foreach($arrSubgrupoUso as $categoria=>$sub){
			$SIS_whereSubgrupoUso .= ' OR idGrupo='.$sub['idGrupo'];
		}

		/*************************************************************/
		//Se consulta
		$SIS_query = 'FechaSistema,HoraSistema';
		for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
			$SIS_query .= ',Sensor_'.$i.' AS SensorValue_'.$i;
		}
		$SIS_join  = '';
		$SIS_where = '(TimeStamp BETWEEN "'.$FechaInicio.' '.$HoraInicio.'" AND "'.$FechaTermino.' '.$HoraTermino.'")';
		$SIS_order = 'FechaSistema ASC,HoraSistema ASC LIMIT 10000';
		$arrMediciones = array();
		$arrMediciones = db_select_array (false, $SIS_query, 'telemetria_listado_tablarelacionada_'.$idTelemetria, $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrMediciones');

		/*************************************************************/
		//Se consulta
		$arrGrupos = array();
		$arrGrupos = db_select_array (false, 'idGrupo, Nombre', 'telemetria_listado_grupos', '', $SIS_whereSubgrupo, 'Nombre ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrGrupos');
		//se recorre
		$arrGruposTemp = array();
		foreach ($arrGrupos as $gru) {
			$arrGruposTemp[$gru['idGrupo']] = $gru['Nombre'];
		}

		/*************************************************************/
		//Se consulta
		$T_idGrupo    = 0;
		$arrGruposUso = array();
		$arrGruposUso = db_select_array (false, 'idGrupo, Nombre', 'telemetria_listado_grupos_uso', '', $SIS_whereSubgrupoUso, 'Nombre ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrGruposUso');
		//se recorre
		$arrGruposUsoTemp = array();
		foreach ($arrGruposUso as $gruUso) {
			$arrGruposUsoTemp[$gruUso['idGrupo']] = $gruUso['Nombre'];
			//guardo el primer grupo
			if($T_idGrupo==0){
				$T_idGrupo = $gruUso['idGrupo'];
			}
		}

		/*************************************************************/
		//Variables
		$arrTempGrupos = array();
		$arrTempSensor = array();
		$arrTempMed    = array();
		$Temp_1        = '';
		$arrData       = array();
		$arrDatax      = array();

		//Se recorren las mediciones
		foreach($arrMediciones as $cli) {

			/******************************/
			//reseteo
			$arrTemporal = array();

			/******************************/
			//recorro los sensores
			for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
				//Verifico si el sensor esta activo para guardar el dato
				if(isset($rowEquipo['SensoresActivo_'.$i])&&$rowEquipo['SensoresActivo_'.$i]==1){
					//Valido valores
					if(isset($cli['SensorValue_'.$i])&&$cli['SensorValue_'.$i]<999){
						/********************************/
						//datos
						//Sumo los sensores
						if(isset($arrTempMed[$i]['Suma'])&&$arrTempMed[$i]['Suma']!=''){
							$arrTempMed[$i]['Suma'] = $arrTempMed[$i]['Suma'] + $cli['SensorValue_'.$i];
						}else{
							$arrTempMed[$i]['Suma'] = $cli['SensorValue_'.$i];
						}
						//Cuento los sensores
						if(isset($arrTempMed[$i]['Cuenta'])&&$arrTempMed[$i]['Cuenta']!=''){
							$arrTempMed[$i]['Cuenta']++;
						}else{
							$arrTempMed[$i]['Cuenta'] = 1;
						}
						//Min de los sensores
						if(isset($arrTempMed[$i]['Min'])&&$arrTempMed[$i]['Min']!=''){
							//verifico si es menor
							if($arrTempMed[$i]['Min']>$cli['SensorValue_'.$i]){
								$arrTempMed[$i]['Min'] = $cli['SensorValue_'.$i];
							}
						}else{
							$arrTempMed[$i]['Min'] = $cli['SensorValue_'.$i];
						}
						//Max de los sensores
						if(isset($arrTempMed[$i]['Max'])&&$arrTempMed[$i]['Max']!=''){
							//verifico si es mayor
							if($arrTempMed[$i]['Max']<$cli['SensorValue_'.$i]){
								$arrTempMed[$i]['Max'] = $cli['SensorValue_'.$i];
							}
						}else{
							$arrTempMed[$i]['Max'] = $cli['SensorValue_'.$i];
						}

						/********************************/
						//Grafico
						//Si es temperatura
						//if($rowEquipo['SensoresUniMed_'.$i]==3&&$rowEquipo['SensoresRevisionGrupo_'.$i]==$arrGruposUso[0]['idGrupo']){
						if($rowEquipo['SensoresUniMed_'.$i]==3){
							//verifico si existe
							if(isset($arrTemporal[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Valor'])&&$arrTemporal[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Valor']!=''){
								$arrTemporal[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Valor'] = $arrTemporal[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Valor'] + $cli['SensorValue_'.$i];
								$arrTemporal[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Cuenta']++;
							//si no lo crea
							}else{
								$arrTemporal[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Valor']  = $cli['SensorValue_'.$i];
								$arrTemporal[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Cuenta'] = 1;
							}
						}
					}
				}
			}

			//Guardo la fecha
			$Temp_1 .= "'".Fecha_estandar($cli['FechaSistema'])." - ".$cli['HoraSistema']."',";

			/********************************/
			//Grafico
			//recorro grupo de uso
			foreach ($arrGruposUso as $gruUso) {
				//verifico que sea el primer grupo
				if($T_idGrupo==$gruUso['idGrupo']){
					//recorro los grupos
					foreach ($arrGrupos as $gru) {

						/***********************************************/
						//verifico si hay datos
						if(isset($arrTemporal[$gruUso['idGrupo']][$gru['idGrupo']]['Cuenta'])&&$arrTemporal[$gruUso['idGrupo']][$gru['idGrupo']]['Cuenta']!=0){
							//realizo los calculos
							$New_Dato = $arrTemporal[$gruUso['idGrupo']][$gru['idGrupo']]['Valor']/$arrTemporal[$gruUso['idGrupo']][$gru['idGrupo']]['Cuenta'];
							$arrDatax[$gruUso['idGrupo']][$gru['idGrupo']]['New_Dato'] = $New_Dato;
						//si no hay datos utilizo el anterior
						}else{
							$New_Dato = $arrDatax[$gruUso['idGrupo']][$gru['idGrupo']]['New_Dato'];
						}

						/***********************************************/
						//verifico si existe el dato
						if(isset($arrData[$gruUso['idGrupo']][$gru['idGrupo']]['Value'])&&$arrData[$gruUso['idGrupo']][$gru['idGrupo']]['Value']!=''){
							$arrData[$gruUso['idGrupo']][$gru['idGrupo']]['Value'] .= ", ".$New_Dato;
						//si no lo crea
						}else{
							$arrData[$gruUso['idGrupo']][$gru['idGrupo']]['Value'] = $New_Dato;
						}
					}
				}
			}
		}

		//variables
		$x_graph_count        = 0;
		$Graphics_xData       = 'var xData = [';
		$Graphics_yData       = 'var yData = [';
		$Graphics_names       = 'var names = [';
		$Graphics_types       = 'var types = [';
		$Graphics_texts       = 'var texts = [';
		$Graphics_lineColors  = 'var lineColors = [';
		$Graphics_lineDash    = 'var lineDash = [';
		$Graphics_lineWidth   = 'var lineWidth = [';
		//Se crean los datos
		foreach ($arrGruposUso as $gruUso) {
			foreach ($arrGrupos as $gru) {
				if(isset($arrData[$gruUso['idGrupo']][$gru['idGrupo']]['Value'])&&$arrData[$gruUso['idGrupo']][$gru['idGrupo']]['Value']!=''){
					//las fechas
					$Graphics_xData      .='['.$Temp_1.'],';
					//los valores
					$Graphics_yData      .='['.$arrData[$gruUso['idGrupo']][$gru['idGrupo']]['Value'].'],';
					//los nombres
					$Graphics_names      .= '"'.DeSanitizar(TituloMenu($gruUso['Nombre']).' - '.TituloMenu($gru['Nombre'])).'",';
					//los tipos
					$Graphics_types      .= "'',";
					//si lleva texto en las burbujas
					$Graphics_texts      .= "[],";
					//los colores de linea
					$Graphics_lineColors .= "'',";
					//los tipos de linea
					$Graphics_lineDash   .= "'',";
					//los anchos de la linea
					$Graphics_lineWidth  .= "'',";
					//contador
					$x_graph_count++;
				}
			}
		}
		$Graphics_xData      .= '];';
		$Graphics_yData      .= '];';
		$Graphics_names      .= '];';
		$Graphics_types      .= '];';
		$Graphics_texts      .= '];';
		$Graphics_lineColors .= '];';
		$Graphics_lineDash   .= '];';
		$Graphics_lineWidth  .= '];';

		for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
			//Verifico si el sensor esta activo para guardar el dato
			if(isset($rowEquipo['SensoresActivo_'.$i])&&$rowEquipo['SensoresActivo_'.$i]==1){
				/*****************************************/
				//Grupo Uso
				$arrTempGrupos[$rowEquipo['SensoresRevisionGrupo_'.$i]]['Nombre']  = $arrGruposUsoTemp[$rowEquipo['SensoresRevisionGrupo_'.$i]];
				$arrTempGrupos[$rowEquipo['SensoresRevisionGrupo_'.$i]]['idGrupo'] = $rowEquipo['SensoresRevisionGrupo_'.$i];
				/*****************************************/
				//Grupo
				switch ($rowEquipo['SensoresUniMed_'.$i]) {
					/**********************/
					//Si es temperatura
					case 3:
						//Nombre y grupo
						$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Nombre']  = $arrGruposTemp[$rowEquipo['SensoresGrupo_'.$i]];
						$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['idGrupo'] = $rowEquipo['SensoresGrupo_'.$i];
						//Temperatura Minima
						if(isset($arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Tmin'])&&$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Tmin']!=''){
							//verifico si es menor
							if($arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Tmin']>$arrTempMed[$i]['Min']){
								$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Tmin'] = $arrTempMed[$i]['Min'];
							}
						}else{
							$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Tmin'] = $arrTempMed[$i]['Min'];
						}
						//Temperatura Maxima
						if(isset($arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Tmax'])&&$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Tmax']!=''){
							//verifico si es mayor
							if($arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Tmax']<$arrTempMed[$i]['Max']){
								$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Tmax'] = $arrTempMed[$i]['Max'];
							}
						}else{
							$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Tmax'] = $arrTempMed[$i]['Max'];
						}
						//valido que este dentro del rango deseado
						if($rowEquipo['SensoresMedActual_'.$i]<999){
							//Temperatura Actual
							if(isset($arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['TActual'])&&$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['TActual']!=''){
								$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['TActual'] = $arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['TActual'] + $rowEquipo['SensoresMedActual_'.$i];
								$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['CountTActual']++;
							}else{
								$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['TActual'] = $rowEquipo['SensoresMedActual_'.$i];
								$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['CountTActual'] = 1;
							}
						}
						//promedio
						if(isset($arrTempMed[$i]['Suma'])){
							if(isset($arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Prom'])&&$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Prom']!=''){
								$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Prom']      = $arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Prom'] + $arrTempMed[$i]['Suma'];
								$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['CountProm'] = $arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['CountProm'] + $arrTempMed[$i]['Cuenta'];
							}else{
								$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Prom']      = $arrTempMed[$i]['Suma'];
								$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['CountProm'] = $arrTempMed[$i]['Cuenta'];
							}
						}else{
							$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Prom']      = 0;
							$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['CountProm'] = 0;
						}

						//estado (siempre pasa)
						$arrTempGrupos[$rowEquipo['SensoresRevisionGrupo_'.$i]]['NErrores'] = 0;
						$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['NErrores'] = 0;
						break;
					/**********************/
					//si es humedad
					case 2:
						//valido que este dentro del rango deseado
						if($rowEquipo['SensoresMedActual_'.$i]<999){
							//Humedad
							if(isset($arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Hum'])&&$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Hum']!=''){
								$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Hum'] = $arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Hum'] + $rowEquipo['SensoresMedActual_'.$i];
								$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['CountHum']++;
							}else{
								$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Hum'] = $rowEquipo['SensoresMedActual_'.$i];
								$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['CountHum'] = 1;
							}
						}
						//estado (siempre pasa)
						$arrTempGrupos[$rowEquipo['SensoresRevisionGrupo_'.$i]]['NErrores'] = 0;
						$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['NErrores'] = 0;
						break;
					/**********************/
					//si es boolean
					case 12:
						//valido que este dentro del rango deseado
						if($rowEquipo['SensoresMedActual_'.$i]<999){
							//Humedad
							if(isset($arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Bool'])&&$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Hum']!=''){
								$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Bool'] = $arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Bool'] + $rowEquipo['SensoresMedActual_'.$i];
								$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['CountBool']++;
							}else{
								$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Bool'] = $rowEquipo['SensoresMedActual_'.$i];
								$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['CountBool'] = 1;
							}
						}
						//estado (siempre pasa)
						/*$arrTempGrupos[$rowEquipo['SensoresRevisionGrupo_'.$i]]['NErrores'] = 0;
						$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['NErrores'] = 0;
						*/
						break;
				}
			}
		}

		/*************************************************************/
		//Se dibuja
		$widget = '
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="box">
				<header>
					<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
					<h5>Equipos</h5>
					<ul class="nav nav-tabs pull-right">';
						$xcounter = 1;
						foreach($arrEquipo as $cli) {
							if($xcounter==1){$xactive = 'active';}else{$xactive = '';}
							if($xcounter==4){
								$widget .= '<li class="dropdown"><a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a><ul class="dropdown-menu" role="menu">';
							}
							$widget .= '<li class="'.$xactive.'"><a href="" onClick="chngEquipo('.$cli['idTelemetria'].', '.$cli['cantSensores'].')"  data-toggle="tab"><i class="fa fa-map-marker" aria-hidden="true"></i> '.$cli['Nombre'].'</a></li>';
							$xcounter++;
						}
						if($xcounter>4){ $widget .= '</ul></li>';}
					$widget .= '
					</ul>
				</header>

				<div class="tab-content">

					<div id="loading"></div>

					<div id="update_content">
						<div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
							<div class="row">
								<div class="table-responsive">
									<div class="table-wrapper-scroll-y my-custom-scrollbar">
										<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
											<thead>
												<tr role="row">
													<th colspan="3">Grupo - Subgrupo</th>
													<th>T° Actual</th>
													<th>T° Max</th>
													<th>T° Min</th>
													<th>T° Prom</th>
													<th>Hr. Prom</th>
													<th>Acciones</th>
												</tr>
											</thead>
											<tbody role="alert" aria-live="polite" aria-relevant="all" id="TableFiltered">';

												/**********************************************/
												//variable
												$in_eq_fueralinea = '';
												//Fuera de linea
												$diaInicio   = $rowEquipo['LastUpdateFecha'];
												$diaTermino  = $FechaTermino;
												$tiempo1     = $rowEquipo['LastUpdateHora'];
												$tiempo2     = $HoraTermino;
												$Tiempo      = horas_transcurridas($diaInicio, $diaTermino, $tiempo1, $tiempo2);

												//Comparaciones de tiempo
												$Time_Tiempo     = horas2segundos($Tiempo);
												$Time_Tiempo_FL  = horas2segundos($rowEquipo['TiempoFueraLinea']);
												$Time_Tiempo_Max = horas2segundos('48:00:00');
												$Time_Fake_Ini   = horas2segundos('23:59:50');
												$Time_Fake_Fin   = horas2segundos('24:00:00');
												//comparacion
												if(($Time_Tiempo<$Time_Fake_Ini OR $Time_Tiempo>$Time_Fake_Fin)&&(($Time_Tiempo>$Time_Tiempo_FL&&$Time_Tiempo_FL!=0) OR ($Time_Tiempo>$Time_Tiempo_Max&&$Time_Tiempo_FL==0))){
													$in_eq_fueralinea = '<i class="fa fa-exclamation-triangle faa-bounce animated" style="color: #a94442;" aria-hidden="true"></i>';
												}

												/***********************************************/
												//imprimo
												$widget .= '
													<tr class="odd">
														<th colspan="8">'.$in_eq_fueralinea.' Ultima Medicion: '.fecha_estandar($rowEquipo['LastUpdateFecha']).' a las '.$rowEquipo['LastUpdateHora'].' hrs.</th>
														<th><a href="view_alertas_personalizadas.php?view='.simpleEncode($_SESSION['usuario']['widget_CrossC_Walmart']['idTelemetria'], fecha_actual()).'" class="iframe btn btn-danger btn-sm"><i class="fa fa-bell-o" aria-hidden="true"></i> Alertas</a></th>
													</tr>';

												//Ordeno
												sort($arrTempGrupos);
												//recorro
												foreach ($arrTempGrupos as $gruUso) {
													//verificar errores
													if(isset($gruUso['NErrores'])&&$gruUso['NErrores']!=0){
														$danger_color = 'warning';
														$danger_icon  = '<a href="#" title="Equipo con Alertas" class="btn btn-warning btn-sm tooltip"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></a>';
													}else{
														$danger_color = '';
														$danger_icon  = '<a href="#" title="Sin Problemas" class="btn btn-success btn-sm tooltip"><i class="fa fa-check" aria-hidden="true"></i></a>';
													}
													$widget .= '
													<tr class="odd '.$danger_color.'">
														<th><div class="btn-group" style="width: 35px;" >'.$danger_icon.'</div></th>
														<th colspan="7">'.TituloMenu($gruUso['Nombre']).'</th>
														<th>
															<div class="btn-group" style="width: 35px;" >
																<button onClick="chngGroupUsoGraph('.$_SESSION['usuario']['widget_CrossC_Walmart']['idTelemetria'].', '.$_SESSION['usuario']['widget_CrossC_Walmart']['cantSensores'].', '.$gruUso['idGrupo'].')" title="Ver Información" class="btn btn-primary btn-sm tooltip"><i class="fa fa-line-chart" aria-hidden="true"></i></button>
															</div>
														</th>
													</tr>';
													//se ordena el arreglo
													sort($arrTempSensor[$gruUso['idGrupo']]);
													//recorro el arreglo
													foreach ($arrTempSensor[$gruUso['idGrupo']] as $gru) {
														//verificar errores
														if(isset($gru['NErrores'])&&$gru['NErrores']!=0){
															$danger_color = 'warning';
															$danger_icon  = '<a href="#" title="Equipo con Alertas" class="btn btn-warning btn-sm tooltip"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></a>';
														}else{
															$danger_color = '';
															$danger_icon  = '<a href="#" title="Sin Problemas" class="btn btn-success btn-sm tooltip"><i class="fa fa-check" aria-hidden="true"></i></a>';
														}
														//variables
														$Tmin    = Cantidades($gru['Tmin'], 1);
														$Tmax    = Cantidades($gru['Tmax'], 1);
														if(isset($gru['CountTActual'])&&$gru['CountTActual']!=0){  $TActual = Cantidades(($gru['TActual']/$gru['CountTActual']), 1); }else{ $TActual = 0; }
														if(isset($gru['CountProm'])&&$gru['CountProm']!=0){        $Prom    = Cantidades(($gru['Prom']/$gru['CountProm']), 1);       }else{ $Prom    = 0; }
														if(isset($gru['CountHum'])&&$gru['CountHum']!=0){          $Hum     = Cantidades(($gru['Hum']/$gru['CountHum']), 1);         }else{ $Hum     = 0; }
														if(isset($gru['CountBool'])&&$gru['CountBool']!=0){
															$tempv  = $gru['Bool']/$gru['CountBool'];
															$s_link = 'informe_telemetria_registro_sensores_20.php?f_inicio='.fecha_actual().'&f_termino='.fecha_actual().'&idTelemetria='.$idTelemetria.'&RevisionGrupo='.$gruUso['idGrupo'].'&submit_filter=Filtrar';
															//si esta abierto
															if($tempv!=0){
																$danger_color = 'warning';
																$danger_icon .= '<a target="_blank" rel="noopener noreferrer" href="'.$s_link.'" title="Puertas Abiertas" class="btn btn-warning btn-sm tooltip"><i class="fa fa-sign-out" aria-hidden="true"></i></a>';
															//si esta cerrado
															}else{
																$danger_icon .= '<a target="_blank" rel="noopener noreferrer" href="'.$s_link.'" title="Puertas Cerradas" class="btn btn-success btn-sm tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i></a>';
															}
														//si no hay puertas configuradas
														}else{
															$danger_icon .= '';
														}

														$widget .= '
														<tr class="odd '.$danger_color.'">
															<td></td>
															<td><div class="btn-group" style="width: 70px;" >'.$danger_icon.'</div></td>
															<td>'.TituloMenu($gru['Nombre']).'</td>
															<td>'.$TActual.' °C</td>
															<td>'.$Tmax.' °C</td>
															<td>'.$Tmin.' °C</td>
															<td>'.$Prom.' °C</td>
															<td>'.$Hum.' %</td>
															<td>
																<div class="btn-group" style="width: 70px;" >
																	<button onClick="chngGroupGraph('.$_SESSION['usuario']['widget_CrossC_Walmart']['idTelemetria'].', '.$_SESSION['usuario']['widget_CrossC_Walmart']['cantSensores'].', '.$gruUso['idGrupo'].', '.$gru['idGrupo'].')" title="Ver Información" class="btn btn-metis-6 btn-sm tooltip"><i class="fa fa-line-chart" aria-hidden="true"></i></button>
																</div>
															</td>
														</tr>';
													}
												}

											$widget .= '
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
							<div class="row" id="update_graphics">';
								//si hay datos
								if(isset($x_graph_count)&&$x_graph_count!=0){
									$gr_tittle = 'Grafico '.$arrGruposUsoTemp[$arrGruposUso[0]['idGrupo']];
									$gr_unimed = '°C';
									$widget .= GraphLinear_1('graphLinear_1', $gr_tittle, 'Fecha', $gr_unimed, $Graphics_xData, $Graphics_yData, $Graphics_names, $Graphics_types, $Graphics_texts, $Graphics_lineColors, $Graphics_lineDash, $Graphics_lineWidth, 1);
								//si no hay datos
								}else{
									$widget .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><br/>';
									$widget .= '<div class="alert alert-danger alert-white rounded alert_box_correction" role="alert"><div class="icon"><i class="fa fa-info-circle faa-bounce animated" aria-hidden="true"></i></div><span id="alert_post_data">No hay datos para desplegar el grafico</span><div class="clearfix"></div></div>';
									$widget .= '</div>';
								}
								$widget .= '
							</div>
						</div>
					</div>

					<div class="clearfix"></div>

				</div>
			</div>
		</div>';

		$widget .= '
		<script>
		//oculto el loader
		document.getElementById("loading").style.display = "none";

		/* ************************************************************************** */
		function chngEquipo(idTelemetria,cantSensores) {
			//muestro el loader
			document.getElementById("loading").style.display = "block";

			//Pido actualizacion
			$("#update_content").load("principal_update_widget_CrossC_Walmart.php?idTelemetria=" + idTelemetria + "&cantSensores="+cantSensores);

			//se esperan 3 segundos
			setTimeout(
				function(){
					//oculto el loader
					document.getElementById("loading").style.display = "none";
				}
			, 3000);
		}
		/* ************************************************************************** */
		function chngGroupUsoGraph(idTelemetria,cantSensores,idGrupoUso) {
			//muestro el loader
			document.getElementById("loading").style.display = "block";

			//Pido actualizacion
			$("#update_graphics").load("principal_update_widget_CrossC_Walmart_Group.php?idTelemetria=" + idTelemetria + "&cantSensores="+cantSensores + "&idGrupoUso="+idGrupoUso);

			//se esperan 3 segundos
			setTimeout(
				function(){
					//oculto el loader
					document.getElementById("loading").style.display = "none";
				}
			, 3000);
		}
		/* ************************************************************************** */
		function chngGroupGraph(idTelemetria,cantSensores,idGrupoUso,idGrupo) {
			//muestro el loader
			document.getElementById("loading").style.display = "block";

			//Pido actualizacion
			$("#update_graphics").load("principal_update_widget_CrossC_Walmart_Sensor.php?idTelemetria=" + idTelemetria + "&cantSensores="+cantSensores + "&idGrupoUso="+idGrupoUso + "&idGrupo="+idGrupo);

			//se esperan 3 segundos
			setTimeout(
				function(){
					//oculto el loader
					document.getElementById("loading").style.display = "none";
				}
			, 3000);
		}
		</script>
		';
		return $widget;
	}else{

		return alert_post_data(4,1,1,0, 'No hay equipos de este sistema asignados a este perfil');
	}

}
/*******************************************************************************************************************/
//Muestra los promedios de los equipos
function widget_CrossC_Walmart2($timeBack, $seguimiento, $idSistema, $idTipoUsuario, $idUsuario, $dbConn){

	//Configuracion
	$Maximo_Sensores = 70;

	//Variable
	$SIS_where = "telemetria_listado.idEstado = 1 ";//solo equipos activos
	//Filtro de los tab
	$SIS_where .= " AND telemetria_listado.idTab = 2";//1Tek C
	$SIS_where .= " AND telemetria_listado.Nombre LIKE 'W.%'";//Comienza por w.
	//solo los equipos que tengan el seguimiento activado
	if(isset($seguimiento)&&$seguimiento!=''&&$seguimiento!=0){
		$SIS_where .= " AND telemetria_listado.id_Geo = ".$seguimiento;
	}
	//Filtro el sistema al cual pertenece
	if(isset($idSistema)&&$idSistema!=''&&$idSistema!=0){
		$SIS_where .= " AND telemetria_listado.idSistema = ".$idSistema;
	}
	//Verifico el tipo de usuario que esta ingresando y el id
	$SIS_join  = '';
	if(isset($idTipoUsuario, $idUsuario)&&$idTipoUsuario!=1&&$idUsuario!=0){
		$SIS_join  .= " INNER JOIN usuarios_equipos_telemetria ON usuarios_equipos_telemetria.idTelemetria = telemetria_listado.idTelemetria ";
		$SIS_where .= " AND usuarios_equipos_telemetria.idUsuario = ".$idUsuario;
	}

	/*************************************************************/
	//Se consulta
	$SIS_query = '
	telemetria_listado.idTelemetria,
	telemetria_listado.Nombre,
	telemetria_listado.cantSensores,
	telemetria_listado.LastUpdateFecha,
	telemetria_listado.LastUpdateHora,
	telemetria_listado.TiempoFueraLinea';
	for ($i = 1; $i <= $Maximo_Sensores; $i++) {
		$SIS_query .= ',telemetria_listado_sensores_grupo.SensoresGrupo_'.$i;
		$SIS_query .= ',telemetria_listado_sensores_revision_grupo.SensoresRevisionGrupo_'.$i;
		$SIS_query .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i;
		$SIS_query .= ',telemetria_listado_sensores_med_actual.SensoresMedActual_'.$i;
		$SIS_query .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$i;
	}
	$SIS_join  .= '
	LEFT JOIN `telemetria_listado_sensores_grupo`          ON telemetria_listado_sensores_grupo.idTelemetria          = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_revision_grupo` ON telemetria_listado_sensores_revision_grupo.idTelemetria = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_unimed`         ON telemetria_listado_sensores_unimed.idTelemetria         = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_med_actual`     ON telemetria_listado_sensores_med_actual.idTelemetria     = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_activo`         ON telemetria_listado_sensores_activo.idTelemetria         = telemetria_listado.idTelemetria';
	$SIS_order = 'telemetria_listado.Nombre ASC';
	$arrEquipo = array();
	$arrEquipo = db_select_array (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrEquipo');

	/**************************************************************/
	//variables
	$HoraInicio     = restahoras($timeBack,hora_actual());
	$FechaInicio    = fecha_actual();
	$HoraTermino    = hora_actual();
	$FechaTermino   = fecha_actual();
	if($HoraTermino<$timeBack){
		$FechaInicio = restarDias($FechaTermino,1);
	}

	/*************************************************************/
	//Se consulta
	$arrGrupos = array();
	$arrGrupos = db_select_array (false, 'idGrupo, Nombre', 'telemetria_listado_grupos', '', 'idGrupo!=0', 'Nombre ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrGrupos');
	//Se consulta
	$arrGruposUso = array();
	$arrGruposUso = db_select_array (false, 'idGrupo, Nombre', 'telemetria_listado_grupos_uso', '', 'idGrupo!=0', 'Nombre ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrGruposUso');

    /*************************************************************/
    //se recorre
    $arrGruposTemp = array();
    foreach ($arrGrupos as $gru) {
        $arrGruposTemp[$gru['idGrupo']] = $gru['Nombre'];
    }
    //se recorre
    $arrGruposUsoTemp = array();
    foreach ($arrGruposUso as $gruUso) {
        $arrGruposUsoTemp[$gruUso['idGrupo']] = $gruUso['Nombre'];
    }

    /*************************************************************/
    //variables
    $widget = '';
    //Se dibuja
    $widget_1 = '
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="box">
            <header>
                <div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
                <h5>Equipos</h5>
            </header>

            <div class="tab-content">

                <div id="update_content">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="row">
                            <div class="table-responsive">
                                <div class="table-wrapper-scroll-y my-custom-scrollbar">
                                    <table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
                                        <tbody role="alert" aria-live="polite" aria-relevant="all" id="TableFiltered">';

                                        $widget_2 = '
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="clearfix"></div>

				</div>
			</div>
		</div>';


	/**************************************************************/
    //recorro
	foreach($arrEquipo as $equipo) {
        /*************************************************************/
		//identificacion
		$idTelemetria      = $equipo['idTelemetria'];
		$N_Maximo_Sensores = $equipo['cantSensores'];

		/*************************************************************/
		//Se consulta
		$SIS_query = 'FechaSistema,HoraSistema';
		for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
			$SIS_query .= ',Sensor_'.$i.' AS SensorValue_'.$i;
		}
		$SIS_join  = '';
		$SIS_where = '(TimeStamp BETWEEN "'.$FechaInicio.' '.$HoraInicio.'" AND "'.$FechaTermino.' '.$HoraTermino.'")';
		$SIS_order = 'FechaSistema ASC,HoraSistema ASC LIMIT 10000';
		$arrMediciones = array();
		$arrMediciones = db_select_array (false, $SIS_query, 'telemetria_listado_tablarelacionada_'.$idTelemetria, $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrMediciones');

		/*************************************************************/
		//Variables
		$arrTempGrupos = array();
		$arrTempSensor = array();
		$arrTempMed    = array();

		//Se recorren las mediciones
		foreach($arrMediciones as $cli) {
			/******************************/
			//recorro los sensores
			for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
				//Verifico si el sensor esta activo para guardar el dato
				if(isset($equipo['SensoresActivo_'.$i])&&$equipo['SensoresActivo_'.$i]==1){
					//Valido valores
					if(isset($cli['SensorValue_'.$i])&&$cli['SensorValue_'.$i]<999){
						/********************************/
						//datos
						//Sumo los sensores
						if(isset($arrTempMed[$equipo['idTelemetria']][$i]['Suma'])&&$arrTempMed[$equipo['idTelemetria']][$i]['Suma']!=''){
							$arrTempMed[$equipo['idTelemetria']][$i]['Suma'] = $arrTempMed[$equipo['idTelemetria']][$i]['Suma'] + $cli['SensorValue_'.$i];
						}else{
							$arrTempMed[$equipo['idTelemetria']][$i]['Suma'] = $cli['SensorValue_'.$i];
						}
						//Cuento los sensores
						if(isset($arrTempMed[$equipo['idTelemetria']][$i]['Cuenta'])&&$arrTempMed[$equipo['idTelemetria']][$i]['Cuenta']!=''){
							$arrTempMed[$equipo['idTelemetria']][$i]['Cuenta']++;
						}else{
							$arrTempMed[$equipo['idTelemetria']][$i]['Cuenta'] = 1;
						}
						//Min de los sensores
						if(isset($arrTempMed[$equipo['idTelemetria']][$i]['Min'])&&$arrTempMed[$equipo['idTelemetria']][$i]['Min']!=''){
							//verifico si es menor
							if($arrTempMed[$equipo['idTelemetria']][$i]['Min']>$cli['SensorValue_'.$i]){
								$arrTempMed[$equipo['idTelemetria']][$i]['Min'] = $cli['SensorValue_'.$i];
							}
						}else{
							$arrTempMed[$equipo['idTelemetria']][$i]['Min'] = $cli['SensorValue_'.$i];
						}
						//Max de los sensores
						if(isset($arrTempMed[$equipo['idTelemetria']][$i]['Max'])&&$arrTempMed[$equipo['idTelemetria']][$i]['Max']!=''){
							//verifico si es mayor
							if($arrTempMed[$equipo['idTelemetria']][$i]['Max']<$cli['SensorValue_'.$i]){
								$arrTempMed[$equipo['idTelemetria']][$i]['Max'] = $cli['SensorValue_'.$i];
							}
						}else{
							$arrTempMed[$equipo['idTelemetria']][$i]['Max'] = $cli['SensorValue_'.$i];
						}
					}
				}
			}
		}


		for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
			//Verifico si el sensor esta activo para guardar el dato
			if(isset($equipo['SensoresActivo_'.$i])&&$equipo['SensoresActivo_'.$i]==1){
				/*****************************************/
				//Grupo Uso
				$arrTempGrupos[$equipo['idTelemetria']][$equipo['SensoresRevisionGrupo_'.$i]]['Nombre']  = $arrGruposUsoTemp[$equipo['SensoresRevisionGrupo_'.$i]];
				$arrTempGrupos[$equipo['idTelemetria']][$equipo['SensoresRevisionGrupo_'.$i]]['idGrupo'] = $equipo['SensoresRevisionGrupo_'.$i];
				/*****************************************/
				//Grupo
				switch ($equipo['SensoresUniMed_'.$i]) {
					/**********************/
					//Si es temperatura
					case 3:
						//Nombre y grupo
						$arrTempSensor[$equipo['idTelemetria']][$equipo['SensoresRevisionGrupo_'.$i]][$equipo['SensoresGrupo_'.$i]]['Nombre']  = $arrGruposTemp[$equipo['SensoresGrupo_'.$i]];
						$arrTempSensor[$equipo['idTelemetria']][$equipo['SensoresRevisionGrupo_'.$i]][$equipo['SensoresGrupo_'.$i]]['idGrupo'] = $equipo['SensoresGrupo_'.$i];
						//Temperatura Minima
						if(isset($arrTempSensor[$equipo['idTelemetria']][$equipo['SensoresRevisionGrupo_'.$i]][$equipo['SensoresGrupo_'.$i]]['Tmin'])&&$arrTempSensor[$equipo['idTelemetria']][$equipo['SensoresRevisionGrupo_'.$i]][$equipo['SensoresGrupo_'.$i]]['Tmin']!=''){
							//verifico si es menor
							if($arrTempSensor[$equipo['idTelemetria']][$equipo['SensoresRevisionGrupo_'.$i]][$equipo['SensoresGrupo_'.$i]]['Tmin']>$arrTempMed[$equipo['idTelemetria']][$i]['Min']){
								$arrTempSensor[$equipo['idTelemetria']][$equipo['SensoresRevisionGrupo_'.$i]][$equipo['SensoresGrupo_'.$i]]['Tmin'] = $arrTempMed[$equipo['idTelemetria']][$i]['Min'];
							}
						}else{
							$arrTempSensor[$equipo['idTelemetria']][$equipo['SensoresRevisionGrupo_'.$i]][$equipo['SensoresGrupo_'.$i]]['Tmin'] = $arrTempMed[$equipo['idTelemetria']][$i]['Min'];
						}
						//Temperatura Maxima
						if(isset($arrTempSensor[$equipo['idTelemetria']][$equipo['SensoresRevisionGrupo_'.$i]][$equipo['SensoresGrupo_'.$i]]['Tmax'])&&$arrTempSensor[$equipo['idTelemetria']][$equipo['SensoresRevisionGrupo_'.$i]][$equipo['SensoresGrupo_'.$i]]['Tmax']!=''){
							//verifico si es mayor
							if($arrTempSensor[$equipo['idTelemetria']][$equipo['SensoresRevisionGrupo_'.$i]][$equipo['SensoresGrupo_'.$i]]['Tmax']<$arrTempMed[$equipo['idTelemetria']][$i]['Max']){
								$arrTempSensor[$equipo['idTelemetria']][$equipo['SensoresRevisionGrupo_'.$i]][$equipo['SensoresGrupo_'.$i]]['Tmax'] = $arrTempMed[$equipo['idTelemetria']][$i]['Max'];
							}
						}else{
							$arrTempSensor[$equipo['idTelemetria']][$equipo['SensoresRevisionGrupo_'.$i]][$equipo['SensoresGrupo_'.$i]]['Tmax'] = $arrTempMed[$equipo['idTelemetria']][$i]['Max'];
						}
						//valido que este dentro del rango deseado
						if($equipo['SensoresMedActual_'.$i]<999){
							//Temperatura Actual
							if(isset($arrTempSensor[$equipo['idTelemetria']][$equipo['SensoresRevisionGrupo_'.$i]][$equipo['SensoresGrupo_'.$i]]['TActual'])&&$arrTempSensor[$equipo['idTelemetria']][$equipo['SensoresRevisionGrupo_'.$i]][$equipo['SensoresGrupo_'.$i]]['TActual']!=''){
								$arrTempSensor[$equipo['idTelemetria']][$equipo['SensoresRevisionGrupo_'.$i]][$equipo['SensoresGrupo_'.$i]]['TActual'] = $arrTempSensor[$equipo['idTelemetria']][$equipo['SensoresRevisionGrupo_'.$i]][$equipo['SensoresGrupo_'.$i]]['TActual'] + $equipo['SensoresMedActual_'.$i];
								$arrTempSensor[$equipo['idTelemetria']][$equipo['SensoresRevisionGrupo_'.$i]][$equipo['SensoresGrupo_'.$i]]['CountTActual']++;
							}else{
								$arrTempSensor[$equipo['idTelemetria']][$equipo['SensoresRevisionGrupo_'.$i]][$equipo['SensoresGrupo_'.$i]]['TActual'] = $equipo['SensoresMedActual_'.$i];
								$arrTempSensor[$equipo['idTelemetria']][$equipo['SensoresRevisionGrupo_'.$i]][$equipo['SensoresGrupo_'.$i]]['CountTActual'] = 1;
							}
						}
						//promedio
						if(isset($arrTempMed[$i]['Suma'])){
							if(isset($arrTempSensor[$equipo['idTelemetria']][$equipo['SensoresRevisionGrupo_'.$i]][$equipo['SensoresGrupo_'.$i]]['Prom'])&&$arrTempSensor[$equipo['idTelemetria']][$equipo['SensoresRevisionGrupo_'.$i]][$equipo['SensoresGrupo_'.$i]]['Prom']!=''){
								$arrTempSensor[$equipo['idTelemetria']][$equipo['SensoresRevisionGrupo_'.$i]][$equipo['SensoresGrupo_'.$i]]['Prom']      = $arrTempSensor[$equipo['idTelemetria']][$equipo['SensoresRevisionGrupo_'.$i]][$equipo['SensoresGrupo_'.$i]]['Prom'] + $arrTempMed[$i]['Suma'];
								$arrTempSensor[$equipo['idTelemetria']][$equipo['SensoresRevisionGrupo_'.$i]][$equipo['SensoresGrupo_'.$i]]['CountProm'] = $arrTempSensor[$equipo['idTelemetria']][$equipo['SensoresRevisionGrupo_'.$i]][$equipo['SensoresGrupo_'.$i]]['CountProm'] + $arrTempMed[$i]['Cuenta'];
							}else{
								$arrTempSensor[$equipo['idTelemetria']][$equipo['SensoresRevisionGrupo_'.$i]][$equipo['SensoresGrupo_'.$i]]['Prom']      = $arrTempMed[$equipo['idTelemetria']][$i]['Suma'];
								$arrTempSensor[$equipo['idTelemetria']][$equipo['SensoresRevisionGrupo_'.$i]][$equipo['SensoresGrupo_'.$i]]['CountProm'] = $arrTempMed[$equipo['idTelemetria']][$i]['Cuenta'];
							}
						}else{
							$arrTempSensor[$equipo['idTelemetria']][$equipo['SensoresRevisionGrupo_'.$i]][$equipo['SensoresGrupo_'.$i]]['Prom']      = 0;
							$arrTempSensor[$equipo['idTelemetria']][$equipo['SensoresRevisionGrupo_'.$i]][$equipo['SensoresGrupo_'.$i]]['CountProm'] = 0;
						}

						//estado (siempre pasa)
						$arrTempGrupos[$equipo['idTelemetria']][$equipo['SensoresRevisionGrupo_'.$i]]['NErrores'] = 0;
						$arrTempSensor[$equipo['idTelemetria']][$equipo['SensoresRevisionGrupo_'.$i]][$equipo['SensoresGrupo_'.$i]]['NErrores'] = 0;
						break;
					/**********************/
					//si es humedad
					case 2:
						//valido que este dentro del rango deseado
						if($equipo['SensoresMedActual_'.$i]<999){
							//Humedad
							if(isset($arrTempSensor[$equipo['idTelemetria']][$equipo['SensoresRevisionGrupo_'.$i]][$equipo['SensoresGrupo_'.$i]]['Hum'])&&$arrTempSensor[$equipo['idTelemetria']][$equipo['SensoresRevisionGrupo_'.$i]][$equipo['SensoresGrupo_'.$i]]['Hum']!=''){
								$arrTempSensor[$equipo['idTelemetria']][$equipo['SensoresRevisionGrupo_'.$i]][$equipo['SensoresGrupo_'.$i]]['Hum'] = $arrTempSensor[$equipo['idTelemetria']][$equipo['SensoresRevisionGrupo_'.$i]][$equipo['SensoresGrupo_'.$i]]['Hum'] + $equipo['SensoresMedActual_'.$i];
								$arrTempSensor[$equipo['idTelemetria']][$equipo['SensoresRevisionGrupo_'.$i]][$equipo['SensoresGrupo_'.$i]]['CountHum']++;
							}else{
								$arrTempSensor[$equipo['idTelemetria']][$equipo['SensoresRevisionGrupo_'.$i]][$equipo['SensoresGrupo_'.$i]]['Hum'] = $equipo['SensoresMedActual_'.$i];
								$arrTempSensor[$equipo['idTelemetria']][$equipo['SensoresRevisionGrupo_'.$i]][$equipo['SensoresGrupo_'.$i]]['CountHum'] = 1;
							}
						}
						//estado (siempre pasa)
						$arrTempGrupos[$equipo['idTelemetria']][$equipo['SensoresRevisionGrupo_'.$i]]['NErrores'] = 0;
						$arrTempSensor[$equipo['idTelemetria']][$equipo['SensoresRevisionGrupo_'.$i]][$equipo['SensoresGrupo_'.$i]]['NErrores'] = 0;
						break;
					/**********************/
					//si es boolean
					case 12:
						//valido que este dentro del rango deseado
						if($equipo['SensoresMedActual_'.$i]<999){
							//Humedad
							if(isset($arrTempSensor[$equipo['idTelemetria']][$equipo['SensoresRevisionGrupo_'.$i]][$equipo['SensoresGrupo_'.$i]]['Bool'])&&$arrTempSensor[$equipo['idTelemetria']][$equipo['SensoresRevisionGrupo_'.$i]][$equipo['SensoresGrupo_'.$i]]['Hum']!=''){
								$arrTempSensor[$equipo['idTelemetria']][$equipo['SensoresRevisionGrupo_'.$i]][$equipo['SensoresGrupo_'.$i]]['Bool'] = $arrTempSensor[$equipo['idTelemetria']][$equipo['SensoresRevisionGrupo_'.$i]][$equipo['SensoresGrupo_'.$i]]['Bool'] + $equipo['SensoresMedActual_'.$i];
								$arrTempSensor[$equipo['idTelemetria']][$equipo['SensoresRevisionGrupo_'.$i]][$equipo['SensoresGrupo_'.$i]]['CountBool']++;
							}else{
								$arrTempSensor[$equipo['idTelemetria']][$equipo['SensoresRevisionGrupo_'.$i]][$equipo['SensoresGrupo_'.$i]]['Bool'] = $equipo['SensoresMedActual_'.$i];
								$arrTempSensor[$equipo['idTelemetria']][$equipo['SensoresRevisionGrupo_'.$i]][$equipo['SensoresGrupo_'.$i]]['CountBool'] = 1;
							}
						}
						break;
				}
			}
		}

        /**********************************************/
        //variable
        $in_eq_fueralinea = '';
        //Fuera de linea
        $diaInicio   = $equipo['LastUpdateFecha'];
        $diaTermino  = $FechaTermino;
        $tiempo1     = $equipo['LastUpdateHora'];
        $tiempo2     = $HoraTermino;
        $Tiempo      = horas_transcurridas($diaInicio, $diaTermino, $tiempo1, $tiempo2);

        //Comparaciones de tiempo
        $Time_Tiempo     = horas2segundos($Tiempo);
        $Time_Tiempo_FL  = horas2segundos($equipo['TiempoFueraLinea']);
        $Time_Tiempo_Max = horas2segundos('48:00:00');
        $Time_Fake_Ini   = horas2segundos('23:59:50');
        $Time_Fake_Fin   = horas2segundos('24:00:00');
        //comparacion
        if(($Time_Tiempo<$Time_Fake_Ini OR $Time_Tiempo>$Time_Fake_Fin)&&(($Time_Tiempo>$Time_Tiempo_FL&&$Time_Tiempo_FL!=0) OR ($Time_Tiempo>$Time_Tiempo_Max&&$Time_Tiempo_FL==0))){
            $in_eq_fueralinea = '<i class="fa fa-exclamation-triangle faa-bounce animated" style="color: #a94442;" aria-hidden="true"></i>';
        }

        /***********************************************/
        //imprimo
        $widget .= '
		<tr class="odd" style="background-color: #666;color: #fff;">
			<th colspan="8"><strong>'.$equipo['Nombre'].'</strong></th>
		</tr>';
        $widget .= '
		<tr class="odd">
			<th colspan="7">'.$in_eq_fueralinea.' Ultima Medicion: '.fecha_estandar($equipo['LastUpdateFecha']).' a las '.$equipo['LastUpdateHora'].' hrs.</th>
			<th><a href="view_alertas_personalizadas.php?view='.simpleEncode($equipo['idTelemetria'], fecha_actual()).'" class="iframe btn btn-danger btn-sm"><i class="fa fa-bell-o" aria-hidden="true"></i> Alertas</a></th>
		</tr>';
        $widget .= '
		<tr>
			<th colspan="3">Grupo - Subgrupo</th>
			<th>T° Actual</th>
			<th>T° Max</th>
			<th>T° Min</th>
			<th>T° Prom</th>
			<th>Hr. Prom</th>
		</tr>';

        //Ordeno
        sort($arrTempGrupos[$equipo['idTelemetria']]);
        //recorro
        foreach ($arrTempGrupos[$equipo['idTelemetria']] as $gruUso) {
            //verificar errores
            if(isset($gruUso['NErrores'])&&$gruUso['NErrores']!=0){
                $danger_color = 'warning';
                $danger_icon  = '<a href="#" title="Equipo con Alertas" class="btn btn-warning btn-sm tooltip"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></a>';
            }else{
                $danger_color = '';
                $danger_icon  = '<a href="#" title="Sin Problemas" class="btn btn-success btn-sm tooltip"><i class="fa fa-check" aria-hidden="true"></i></a>';
            }
            $widget .= '
            <tr class="odd '.$danger_color.'">
                <th><div class="btn-group" style="width: 35px;" >'.$danger_icon.'</div></th>
                <th colspan="7">'.TituloMenu($gruUso['Nombre']).'</th>
            </tr>';
            //se ordena el arreglo
            sort($arrTempSensor[$equipo['idTelemetria']][$gruUso['idGrupo']]);
            //recorro el arreglo
            foreach ($arrTempSensor[$equipo['idTelemetria']][$gruUso['idGrupo']] as $gru) {
                //verificar errores
                if(isset($gru['NErrores'])&&$gru['NErrores']!=0){
                    $danger_color = 'warning';
                    $danger_icon  = '<a href="#" title="Equipo con Alertas" class="btn btn-warning btn-sm tooltip"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></a>';
                }else{
                    $danger_color = '';
                    $danger_icon  = '<a href="#" title="Sin Problemas" class="btn btn-success btn-sm tooltip"><i class="fa fa-check" aria-hidden="true"></i></a>';
                }
                //variables
                $Tmin    = Cantidades($gru['Tmin'], 1);
                $Tmax    = Cantidades($gru['Tmax'], 1);
                if(isset($gru['CountTActual'])&&$gru['CountTActual']!=0){  $TActual = Cantidades(($gru['TActual']/$gru['CountTActual']), 1); }else{ $TActual = 0; }
                if(isset($gru['CountProm'])&&$gru['CountProm']!=0){        $Prom    = Cantidades(($gru['Prom']/$gru['CountProm']), 1);       }else{ $Prom    = 0; }
                if(isset($gru['CountHum'])&&$gru['CountHum']!=0){          $Hum     = Cantidades(($gru['Hum']/$gru['CountHum']), 1);         }else{ $Hum     = 0; }
                if(isset($gru['CountBool'])&&$gru['CountBool']!=0){
                    $tempv  = $gru['Bool']/$gru['CountBool'];
                    $s_link = 'informe_telemetria_registro_sensores_20.php?f_inicio='.fecha_actual().'&f_termino='.fecha_actual().'&idTelemetria='.$idTelemetria.'&RevisionGrupo='.$gruUso['idGrupo'].'&submit_filter=Filtrar';
                    //si esta abierto
                    if($tempv!=0){
                        $danger_color = 'warning';
                        $danger_icon .= '<a target="_blank" rel="noopener noreferrer" href="'.$s_link.'" title="Puertas Abiertas" class="btn btn-warning btn-sm tooltip"><i class="fa fa-sign-out" aria-hidden="true"></i></a>';
                    //si esta cerrado
                    }else{
                        $danger_icon .= '<a target="_blank" rel="noopener noreferrer" href="'.$s_link.'" title="Puertas Cerradas" class="btn btn-success btn-sm tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i></a>';
                    }
                //si no hay puertas configuradas
                }else{
                    $danger_icon .= '';
                }

                $widget .= '
                <tr class="odd '.$danger_color.'">
                    <td></td>
                    <td><div class="btn-group" style="width: 70px;" >'.$danger_icon.'</div></td>
                    <td>'.TituloMenu($gru['Nombre']).'</td>
                    <td>'.$TActual.' °C</td>
                    <td>'.$Tmax.' °C</td>
                    <td>'.$Tmin.' °C</td>
                    <td>'.$Prom.' °C</td>
                    <td>'.$Hum.' %</td>
                </tr>';
            }
        }


	}


    /**************************************************************/
    //devuelvo
    $Widget0 = $widget_1;
    $Widget0.= $widget;
    $Widget0.= $widget_2;
    return $Widget0;

}
/*******************************************************************************************************************/
//Muestra los promedios de los equipos
function widget_CrossC_WalmartCloro($timeBack, $seguimiento, $idSistema, $idTipoUsuario, $idUsuario, $dbConn){

	//Variable
	$SIS_where = "telemetria_listado.idEstado = 1 ";//solo equipos activos
	//Filtro de los tab
	$SIS_where .= " AND telemetria_listado.idTab = 2";//1Tek C
	$SIS_where .= " AND telemetria_listado.Nombre LIKE 'Cloro%'";//Comienza por Cloro
	//solo los equipos que tengan el seguimiento activado
	if(isset($seguimiento)&&$seguimiento!=''&&$seguimiento!=0){
		$SIS_where .= " AND telemetria_listado.id_Geo = ".$seguimiento;
	}
	//Filtro el sistema al cual pertenece
	if(isset($idSistema)&&$idSistema!=''&&$idSistema!=0){
		$SIS_where .= " AND telemetria_listado.idSistema = ".$idSistema;
	}
	//Verifico el tipo de usuario que esta ingresando y el id
	$SIS_join  = '';
	if(isset($idTipoUsuario, $idUsuario)&&$idTipoUsuario!=1&&$idUsuario!=0){
		$SIS_join  .= " INNER JOIN usuarios_equipos_telemetria ON usuarios_equipos_telemetria.idTelemetria = telemetria_listado.idTelemetria ";
		$SIS_where .= " AND usuarios_equipos_telemetria.idUsuario = ".$idUsuario;
	}

	/*************************************************************/
	//Se consulta
	$SIS_query = '
	telemetria_listado.idTelemetria,
	telemetria_listado.Nombre,
	telemetria_listado.cantSensores';
	$SIS_order = 'telemetria_listado.Nombre ASC';
	$arrEquipo = array();
	$arrEquipo = db_select_array (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrEquipo');

	/**************************************************************/
	//verifico la existencia de al menos un dato
	if(isset($arrEquipo[0]['idTelemetria'])&&$arrEquipo[0]['idTelemetria']!=''){
		/*************************************************************/
		//identificacion
		$idTelemetria      = $arrEquipo[0]['idTelemetria'];
		$N_Maximo_Sensores = $arrEquipo[0]['cantSensores'];

		//Se Guardan datos
		$_SESSION['usuario']['widget_CrossC_Walmart']['idTelemetria']  = $arrEquipo[0]['idTelemetria'];
		$_SESSION['usuario']['widget_CrossC_Walmart']['cantSensores']  = $arrEquipo[0]['cantSensores'];
		$_SESSION['usuario']['widget_CrossC_Walmart']['timeBack']      = $timeBack;
		$_SESSION['usuario']['widget_CrossC_Walmart']['seguimiento']   = $seguimiento;
		$_SESSION['usuario']['widget_CrossC_Walmart']['idSistema']     = $idSistema;
		$_SESSION['usuario']['widget_CrossC_Walmart']['idTipoUsuario'] = $idTipoUsuario;
		$_SESSION['usuario']['widget_CrossC_Walmart']['idUsuario']     = $idUsuario;

		//variables
		$HoraInicio     = restahoras($timeBack,hora_actual());
		$FechaInicio    = fecha_actual();
		$HoraTermino    = hora_actual();
		$FechaTermino   = fecha_actual();
		if($HoraTermino<$timeBack){
			$FechaInicio = restarDias($FechaTermino,1);
		}

		/*************************************************************/
		//Se consulta
		$SIS_query = '
		telemetria_listado.LastUpdateFecha,
		telemetria_listado.LastUpdateHora,
		telemetria_listado.TiempoFueraLinea';
		for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
			$SIS_query .= ',telemetria_listado_sensores_grupo.SensoresGrupo_'.$i;
			$SIS_query .= ',telemetria_listado_sensores_revision_grupo.SensoresRevisionGrupo_'.$i;
			$SIS_query .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i;
			$SIS_query .= ',telemetria_listado_sensores_med_actual.SensoresMedActual_'.$i;
			$SIS_query .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$i;
		}
		$SIS_join  .= '
		LEFT JOIN `telemetria_listado_sensores_grupo`          ON telemetria_listado_sensores_grupo.idTelemetria          = telemetria_listado.idTelemetria
		LEFT JOIN `telemetria_listado_sensores_revision_grupo` ON telemetria_listado_sensores_revision_grupo.idTelemetria = telemetria_listado.idTelemetria
		LEFT JOIN `telemetria_listado_sensores_unimed`         ON telemetria_listado_sensores_unimed.idTelemetria         = telemetria_listado.idTelemetria
		LEFT JOIN `telemetria_listado_sensores_med_actual`     ON telemetria_listado_sensores_med_actual.idTelemetria     = telemetria_listado.idTelemetria
		LEFT JOIN `telemetria_listado_sensores_activo`         ON telemetria_listado_sensores_activo.idTelemetria         = telemetria_listado.idTelemetria';
		$SIS_where = 'telemetria_listado.idTelemetria='.$idTelemetria;
		$rowEquipo = db_select_data (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $dbConn, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowEquipo');

		//busco los grupos disponibles
		$arrSubgrupo          = array();
		$arrSubgrupoUso       = array();
		$SIS_whereSubgrupo    = 'idGrupo=0';
		$SIS_whereSubgrupoUso = 'idGrupo=0';
		//creo arreglo
		for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
			$arrSubgrupo[$rowEquipo['SensoresGrupo_'.$i]]['idGrupo']            = $rowEquipo['SensoresGrupo_'.$i];
			$arrSubgrupoUso[$rowEquipo['SensoresRevisionGrupo_'.$i]]['idGrupo'] = $rowEquipo['SensoresRevisionGrupo_'.$i];
		}
		//se crea cadena
		foreach($arrSubgrupo as $categoria=>$sub){
			$SIS_whereSubgrupo .= ' OR idGrupo='.$sub['idGrupo'];
		}
		foreach($arrSubgrupoUso as $categoria=>$sub){
			$SIS_whereSubgrupoUso .= ' OR idGrupo='.$sub['idGrupo'];
		}

		/*************************************************************/
		//Se consulta
		$SIS_query = 'FechaSistema,HoraSistema';
		for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
			$SIS_query .= ',Sensor_'.$i.' AS SensorValue_'.$i;
		}
		$SIS_join  = '';
		$SIS_where = '(TimeStamp BETWEEN "'.$FechaInicio.' '.$HoraInicio.'" AND "'.$FechaTermino.' '.$HoraTermino.'")';
		$SIS_order = 'FechaSistema ASC,HoraSistema ASC LIMIT 10000';
		$arrMediciones = array();
		$arrMediciones = db_select_array (false, $SIS_query, 'telemetria_listado_tablarelacionada_'.$idTelemetria, $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrMediciones');

		/*************************************************************/
		//Se consulta
		$arrGrupos = array();
		$arrGrupos = db_select_array (false, 'idGrupo, Nombre', 'telemetria_listado_grupos', '', $SIS_whereSubgrupo, 'Nombre ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrGrupos');
		//se recorre
		$arrGruposTemp = array();
		foreach ($arrGrupos as $gru) {
			$arrGruposTemp[$gru['idGrupo']] = $gru['Nombre'];
		}

		/*************************************************************/
		//Se consulta
		$T_idGrupo    = 0;
		$arrGruposUso = array();
		$arrGruposUso = db_select_array (false, 'idGrupo, Nombre', 'telemetria_listado_grupos_uso', '', $SIS_whereSubgrupoUso, 'Nombre ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrGruposUso');
		//se recorre
		$arrGruposUsoTemp = array();
		foreach ($arrGruposUso as $gruUso) {
			$arrGruposUsoTemp[$gruUso['idGrupo']] = $gruUso['Nombre'];
			//guardo el primer grupo
			if($T_idGrupo==0){
				$T_idGrupo = $gruUso['idGrupo'];
			}
		}

		/*************************************************************/
		//Variables
		$arrTempGrupos = array();
		$arrTempSensor = array();
		$arrTempMed    = array();
		$Temp_1        = '';
		$arrData       = array();
		$arrDatax      = array();

		//Se recorren las mediciones
		foreach($arrMediciones as $cli) {

			/******************************/
			//reseteo
			$arrTemporal = array();

			/******************************/
			//recorro los sensores
			for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
				//Verifico si el sensor esta activo para guardar el dato
				if(isset($rowEquipo['SensoresActivo_'.$i])&&$rowEquipo['SensoresActivo_'.$i]==1){
					//Valido valores
					if(isset($cli['SensorValue_'.$i])&&$cli['SensorValue_'.$i]<999){
						/********************************/
						//datos
						//Sumo los sensores
						if(isset($arrTempMed[$i]['Suma'])&&$arrTempMed[$i]['Suma']!=''){
							$arrTempMed[$i]['Suma'] = $arrTempMed[$i]['Suma'] + $cli['SensorValue_'.$i];
						}else{
							$arrTempMed[$i]['Suma'] = $cli['SensorValue_'.$i];
						}
						//Cuento los sensores
						if(isset($arrTempMed[$i]['Cuenta'])&&$arrTempMed[$i]['Cuenta']!=''){
							$arrTempMed[$i]['Cuenta']++;
						}else{
							$arrTempMed[$i]['Cuenta'] = 1;
						}
						//Min de los sensores
						if(isset($arrTempMed[$i]['Min'])&&$arrTempMed[$i]['Min']!=''){
							//verifico si es menor
							if($arrTempMed[$i]['Min']>$cli['SensorValue_'.$i]){
								$arrTempMed[$i]['Min'] = $cli['SensorValue_'.$i];
							}
						}else{
							$arrTempMed[$i]['Min'] = $cli['SensorValue_'.$i];
						}
						//Max de los sensores
						if(isset($arrTempMed[$i]['Max'])&&$arrTempMed[$i]['Max']!=''){
							//verifico si es mayor
							if($arrTempMed[$i]['Max']<$cli['SensorValue_'.$i]){
								$arrTempMed[$i]['Max'] = $cli['SensorValue_'.$i];
							}
						}else{
							$arrTempMed[$i]['Max'] = $cli['SensorValue_'.$i];
						}

						/********************************/
						//Grafico
						//Si es temperatura
						//if($rowEquipo['SensoresUniMed_'.$i]==3&&$rowEquipo['SensoresRevisionGrupo_'.$i]==$arrGruposUso[0]['idGrupo']){
						if($rowEquipo['SensoresUniMed_'.$i]==15){
							//verifico si existe
							if(isset($arrTemporal[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Valor'])&&$arrTemporal[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Valor']!=''){
								$arrTemporal[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Valor'] = $arrTemporal[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Valor'] + $cli['SensorValue_'.$i];
								$arrTemporal[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Cuenta']++;
							//si no lo crea
							}else{
								$arrTemporal[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Valor']  = $cli['SensorValue_'.$i];
								$arrTemporal[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Cuenta'] = 1;
							}
						}
					}
				}
			}

			//Guardo la fecha
			$Temp_1 .= "'".Fecha_estandar($cli['FechaSistema'])." - ".$cli['HoraSistema']."',";

			/********************************/
			//Grafico
			//recorro grupo de uso
			foreach ($arrGruposUso as $gruUso) {
				//verifico que sea el primer grupo
				if($T_idGrupo==$gruUso['idGrupo']){
					//recorro los grupos
					foreach ($arrGrupos as $gru) {

						/***********************************************/
						//verifico si hay datos
						if(isset($arrTemporal[$gruUso['idGrupo']][$gru['idGrupo']]['Cuenta'])&&$arrTemporal[$gruUso['idGrupo']][$gru['idGrupo']]['Cuenta']!=0){
							//realizo los calculos
							$New_Dato = $arrTemporal[$gruUso['idGrupo']][$gru['idGrupo']]['Valor']/$arrTemporal[$gruUso['idGrupo']][$gru['idGrupo']]['Cuenta'];
							$arrDatax[$gruUso['idGrupo']][$gru['idGrupo']]['New_Dato'] = $New_Dato;
						//si no hay datos utilizo el anterior
						}else{
							$New_Dato = $arrDatax[$gruUso['idGrupo']][$gru['idGrupo']]['New_Dato'];
						}

						/***********************************************/
						//verifico si existe el dato
						if(isset($arrData[$gruUso['idGrupo']][$gru['idGrupo']]['Value'])&&$arrData[$gruUso['idGrupo']][$gru['idGrupo']]['Value']!=''){
							$arrData[$gruUso['idGrupo']][$gru['idGrupo']]['Value'] .= ", ".$New_Dato;
						//si no lo crea
						}else{
							$arrData[$gruUso['idGrupo']][$gru['idGrupo']]['Value'] = $New_Dato;
						}
					}
				}
			}
		}

		//variables
		$x_graph_count        = 0;
		$Graphics_xData       = 'var xData = [';
		$Graphics_yData       = 'var yData = [';
		$Graphics_names       = 'var names = [';
		$Graphics_types       = 'var types = [';
		$Graphics_texts       = 'var texts = [';
		$Graphics_lineColors  = 'var lineColors = [';
		$Graphics_lineDash    = 'var lineDash = [';
		$Graphics_lineWidth   = 'var lineWidth = [';
		//Se crean los datos
		foreach ($arrGruposUso as $gruUso) {
			foreach ($arrGrupos as $gru) {
				if(isset($arrData[$gruUso['idGrupo']][$gru['idGrupo']]['Value'])&&$arrData[$gruUso['idGrupo']][$gru['idGrupo']]['Value']!=''){
					//las fechas
					$Graphics_xData      .='['.$Temp_1.'],';
					//los valores
					$Graphics_yData      .='['.$arrData[$gruUso['idGrupo']][$gru['idGrupo']]['Value'].'],';
					//los nombres
					$Graphics_names      .= '"'.DeSanitizar(TituloMenu($gruUso['Nombre']).' - '.TituloMenu($gru['Nombre'])).'",';
					//los tipos
					$Graphics_types      .= "'',";
					//si lleva texto en las burbujas
					$Graphics_texts      .= "[],";
					//los colores de linea
					$Graphics_lineColors .= "'',";
					//los tipos de linea
					$Graphics_lineDash   .= "'',";
					//los anchos de la linea
					$Graphics_lineWidth  .= "'',";
					//contador
					$x_graph_count++;
				}
			}
		}
		$Graphics_xData      .= '];';
		$Graphics_yData      .= '];';
		$Graphics_names      .= '];';
		$Graphics_types      .= '];';
		$Graphics_texts      .= '];';
		$Graphics_lineColors .= '];';
		$Graphics_lineDash   .= '];';
		$Graphics_lineWidth  .= '];';

		for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
			//Verifico si el sensor esta activo para guardar el dato
			if(isset($rowEquipo['SensoresActivo_'.$i])&&$rowEquipo['SensoresActivo_'.$i]==1){
				/*****************************************/
				//Grupo Uso
				$arrTempGrupos[$rowEquipo['SensoresRevisionGrupo_'.$i]]['Nombre']  = $arrGruposUsoTemp[$rowEquipo['SensoresRevisionGrupo_'.$i]];
				$arrTempGrupos[$rowEquipo['SensoresRevisionGrupo_'.$i]]['idGrupo'] = $rowEquipo['SensoresRevisionGrupo_'.$i];
				/*****************************************/
				//Grupo
				switch ($rowEquipo['SensoresUniMed_'.$i]) {
					/**********************/
					//Si es partes por millón
					case 15:
						//Nombre y grupo
						$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Nombre']  = $arrGruposTemp[$rowEquipo['SensoresGrupo_'.$i]];
						$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['idGrupo'] = $rowEquipo['SensoresGrupo_'.$i];
						//Temperatura Minima
						if(isset($arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Tmin'])&&$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Tmin']!=''){
							//verifico si es menor
							if($arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Tmin']>$arrTempMed[$i]['Min']){
								$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Tmin'] = $arrTempMed[$i]['Min'];
							}
						}else{
							$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Tmin'] = $arrTempMed[$i]['Min'];
						}
						//Temperatura Maxima
						if(isset($arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Tmax'])&&$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Tmax']!=''){
							//verifico si es mayor
							if($arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Tmax']<$arrTempMed[$i]['Max']){
								$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Tmax'] = $arrTempMed[$i]['Max'];
							}
						}else{
							$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Tmax'] = $arrTempMed[$i]['Max'];
						}
						//valido que este dentro del rango deseado
						if($rowEquipo['SensoresMedActual_'.$i]<999){
							//Temperatura Actual
							if(isset($arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['TActual'])&&$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['TActual']!=''){
								$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['TActual'] = $arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['TActual'] + $rowEquipo['SensoresMedActual_'.$i];
								$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['CountTActual']++;
							}else{
								$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['TActual'] = $rowEquipo['SensoresMedActual_'.$i];
								$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['CountTActual'] = 1;
							}
						}
						//promedio
						if(isset($arrTempMed[$i]['Suma'])){
							if(isset($arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Prom'])&&$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Prom']!=''){
								$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Prom']      = $arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Prom'] + $arrTempMed[$i]['Suma'];
								$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['CountProm'] = $arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['CountProm'] + $arrTempMed[$i]['Cuenta'];
							}else{
								$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Prom']      = $arrTempMed[$i]['Suma'];
								$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['CountProm'] = $arrTempMed[$i]['Cuenta'];
							}
						}else{
							$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Prom']      = 0;
							$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['CountProm'] = 0;
						}

						//estado (siempre pasa)
						$arrTempGrupos[$rowEquipo['SensoresRevisionGrupo_'.$i]]['NErrores'] = 0;
						$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['NErrores'] = 0;
						break;
					/**********************/
					//si es humedad
					case 2:
						//valido que este dentro del rango deseado
						if($rowEquipo['SensoresMedActual_'.$i]<999){
							//Humedad
							if(isset($arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Hum'])&&$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Hum']!=''){
								$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Hum'] = $arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Hum'] + $rowEquipo['SensoresMedActual_'.$i];
								$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['CountHum']++;
							}else{
								$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Hum'] = $rowEquipo['SensoresMedActual_'.$i];
								$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['CountHum'] = 1;
							}
						}
						//estado (siempre pasa)
						$arrTempGrupos[$rowEquipo['SensoresRevisionGrupo_'.$i]]['NErrores'] = 0;
						$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['NErrores'] = 0;
						break;
					/**********************/
					//si es boolean
					case 12:
						//valido que este dentro del rango deseado
						if($rowEquipo['SensoresMedActual_'.$i]<999){
							//Humedad
							if(isset($arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Bool'])&&$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Hum']!=''){
								$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Bool'] = $arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Bool'] + $rowEquipo['SensoresMedActual_'.$i];
								$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['CountBool']++;
							}else{
								$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Bool'] = $rowEquipo['SensoresMedActual_'.$i];
								$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['CountBool'] = 1;
							}
						}
						//estado (siempre pasa)
						/*$arrTempGrupos[$rowEquipo['SensoresRevisionGrupo_'.$i]]['NErrores'] = 0;
						$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['NErrores'] = 0;
						*/
						break;
				}
			}
		}

		/*************************************************************/
		//Se dibuja
		$widget = '
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="box">
				<header>
					<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
					<h5>Equipos</h5>
					<ul class="nav nav-tabs pull-right">';
						$xcounter = 1;
						foreach($arrEquipo as $cli) {
							if($xcounter==1){$xactive = 'active';}else{$xactive = '';}
							if($xcounter==4){
								$widget .= '<li class="dropdown"><a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a><ul class="dropdown-menu" role="menu">';
							}
							$widget .= '<li class="'.$xactive.'"><a href="" onClick="chngEquipoCloro('.$cli['idTelemetria'].', '.$cli['cantSensores'].')"  data-toggle="tab"><i class="fa fa-map-marker" aria-hidden="true"></i> '.$cli['Nombre'].'</a></li>';
							$xcounter++;
						}
						if($xcounter>4){ $widget .= '</ul></li>';}
					$widget .= '
					</ul>
				</header>

				<div class="tab-content">

					<div id="loading_cloro"></div>

					<div id="update_content_cloro">
						<div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
							<div class="row">
								<div class="table-responsive">
									<div class="table-wrapper-scroll-y my-custom-scrollbar">
										<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
											<thead>
												<tr role="row">
													<th colspan="3">Grupo - Subgrupo</th>
													<th>ppm Actual</th>
													<th>ppm Max</th>
													<th>ppm Min</th>
													<th>ppm Prom</th>
													<th>Acciones</th>
												</tr>
											</thead>
											<tbody role="alert" aria-live="polite" aria-relevant="all" id="TableFiltered">';

												/**********************************************/
												//variable
												$in_eq_fueralinea = '';
												//Fuera de linea
												$diaInicio   = $rowEquipo['LastUpdateFecha'];
												$diaTermino  = $FechaTermino;
												$tiempo1     = $rowEquipo['LastUpdateHora'];
												$tiempo2     = $HoraTermino;
												$Tiempo      = horas_transcurridas($diaInicio, $diaTermino, $tiempo1, $tiempo2);

												//Comparaciones de tiempo
												$Time_Tiempo     = horas2segundos($Tiempo);
												$Time_Tiempo_FL  = horas2segundos($rowEquipo['TiempoFueraLinea']);
												$Time_Tiempo_Max = horas2segundos('48:00:00');
												$Time_Fake_Ini   = horas2segundos('23:59:50');
												$Time_Fake_Fin   = horas2segundos('24:00:00');
												//comparacion
												if(($Time_Tiempo<$Time_Fake_Ini OR $Time_Tiempo>$Time_Fake_Fin)&&(($Time_Tiempo>$Time_Tiempo_FL&&$Time_Tiempo_FL!=0) OR ($Time_Tiempo>$Time_Tiempo_Max&&$Time_Tiempo_FL==0))){
													$in_eq_fueralinea = '<i class="fa fa-exclamation-triangle faa-bounce animated" style="color: #a94442;" aria-hidden="true"></i>';
												}

												/***********************************************/
												//imprimo
												$widget .= '
													<tr class="odd">
														<th colspan="7">'.$in_eq_fueralinea.' Ultima Medicion: '.fecha_estandar($rowEquipo['LastUpdateFecha']).' a las '.$rowEquipo['LastUpdateHora'].' hrs.</th>
														<th><a href="view_alertas_personalizadas.php?view='.simpleEncode($_SESSION['usuario']['widget_CrossC_Walmart']['idTelemetria'], fecha_actual()).'" class="iframe btn btn-danger btn-sm"><i class="fa fa-bell-o" aria-hidden="true"></i> Alertas</a></th>
													</tr>';

												//Ordeno
												sort($arrTempGrupos);
												//recorro
												foreach ($arrTempGrupos as $gruUso) {
													//verificar errores
													if(isset($gruUso['NErrores'])&&$gruUso['NErrores']!=0){
														$danger_color = 'warning';
														$danger_icon  = '<a href="#" title="Equipo con Alertas" class="btn btn-warning btn-sm tooltip"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></a>';
													}else{
														$danger_color = '';
														$danger_icon  = '<a href="#" title="Sin Problemas" class="btn btn-success btn-sm tooltip"><i class="fa fa-check" aria-hidden="true"></i></a>';
													}
													$widget .= '
													<tr class="odd '.$danger_color.'">
														<th><div class="btn-group" style="width: 35px;" >'.$danger_icon.'</div></th>
														<th colspan="6">'.TituloMenu($gruUso['Nombre']).'</th>
														<th>
															<div class="btn-group" style="width: 35px;" >
																<button onClick="chngGroupUsoGraphCloro('.$_SESSION['usuario']['widget_CrossC_Walmart']['idTelemetria'].', '.$_SESSION['usuario']['widget_CrossC_Walmart']['cantSensores'].', '.$gruUso['idGrupo'].')" title="Ver Información" class="btn btn-primary btn-sm tooltip"><i class="fa fa-line-chart" aria-hidden="true"></i></button>
															</div>
														</th>
													</tr>';
													//se ordena el arreglo
													sort($arrTempSensor[$gruUso['idGrupo']]);
													//recorro el arreglo
													foreach ($arrTempSensor[$gruUso['idGrupo']] as $gru) {
														//verificar errores
														if(isset($gru['NErrores'])&&$gru['NErrores']!=0){
															$danger_color = 'warning';
															$danger_icon  = '<a href="#" title="Equipo con Alertas" class="btn btn-warning btn-sm tooltip"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></a>';
														}else{
															$danger_color = '';
															$danger_icon  = '<a href="#" title="Sin Problemas" class="btn btn-success btn-sm tooltip"><i class="fa fa-check" aria-hidden="true"></i></a>';
														}
														//variables
														$Tmin    = Cantidades($gru['Tmin'], 2);
														$Tmax    = Cantidades($gru['Tmax'], 2);
														if(isset($gru['CountTActual'])&&$gru['CountTActual']!=0){  $TActual = Cantidades(($gru['TActual']/$gru['CountTActual']), 2); }else{ $TActual = 0; }
														if(isset($gru['CountProm'])&&$gru['CountProm']!=0){        $Prom    = Cantidades(($gru['Prom']/$gru['CountProm']), 2);       }else{ $Prom    = 0; }
														if(isset($gru['CountHum'])&&$gru['CountHum']!=0){          $Hum     = Cantidades(($gru['Hum']/$gru['CountHum']), 2);         }else{ $Hum     = 0; }
														if(isset($gru['CountBool'])&&$gru['CountBool']!=0){
															$tempv  = $gru['Bool']/$gru['CountBool'];
															$s_link = 'informe_telemetria_registro_sensores_20.php?f_inicio='.fecha_actual().'&f_termino='.fecha_actual().'&idTelemetria='.$idTelemetria.'&RevisionGrupo='.$gruUso['idGrupo'].'&submit_filter=Filtrar';
															//si esta abierto
															if($tempv!=0){
																$danger_color = 'warning';
																$danger_icon .= '<a target="_blank" rel="noopener noreferrer" href="'.$s_link.'" title="Puertas Abiertas" class="btn btn-warning btn-sm tooltip"><i class="fa fa-sign-out" aria-hidden="true"></i></a>';
															//si esta cerrado
															}else{
																$danger_icon .= '<a target="_blank" rel="noopener noreferrer" href="'.$s_link.'" title="Puertas Cerradas" class="btn btn-success btn-sm tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i></a>';
															}
														//si no hay puertas configuradas
														}else{
															$danger_icon .= '';
														}

														$widget .= '
														<tr class="odd '.$danger_color.'">
															<td></td>
															<td><div class="btn-group" style="width: 70px;" >'.$danger_icon.'</div></td>
															<td>'.TituloMenu($gru['Nombre']).'</td>
															<td>'.$TActual.' ppm</td>
															<td>'.$Tmax.' ppm</td>
															<td>'.$Tmin.' ppm</td>
															<td>'.$Prom.' ppm</td>
															<td>
																<div class="btn-group" style="width: 70px;" >
																	<button onClick="chngGroupGraphCloro('.$_SESSION['usuario']['widget_CrossC_Walmart']['idTelemetria'].', '.$_SESSION['usuario']['widget_CrossC_Walmart']['cantSensores'].', '.$gruUso['idGrupo'].', '.$gru['idGrupo'].')" title="Ver Información" class="btn btn-metis-6 btn-sm tooltip"><i class="fa fa-line-chart" aria-hidden="true"></i></button>
																</div>
															</td>
														</tr>';
													}
												}

											$widget .= '
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
							<div class="row" id="update_graphics_cloro">';
								//si hay datos
								if(isset($x_graph_count)&&$x_graph_count!=0){
									$gr_tittle = 'Grafico '.$arrGruposUsoTemp[$arrGruposUso[0]['idGrupo']];
									$gr_unimed = 'ppm';
									$widget .= GraphLinear_1('graphLinear_cloro', $gr_tittle, 'Fecha', $gr_unimed, $Graphics_xData, $Graphics_yData, $Graphics_names, $Graphics_types, $Graphics_texts, $Graphics_lineColors, $Graphics_lineDash, $Graphics_lineWidth, 1);
								//si no hay datos
								}else{
									$widget .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><br/>';
									$widget .= '<div class="alert alert-danger alert-white rounded alert_box_correction" role="alert"><div class="icon"><i class="fa fa-info-circle faa-bounce animated" aria-hidden="true"></i></div><span id="alert_post_data">No hay datos para desplegar el grafico</span><div class="clearfix"></div></div>';
									$widget .= '</div>';
								}
								$widget .= '
							</div>
						</div>
					</div>

					<div class="clearfix"></div>

				</div>
			</div>
		</div>';

		$widget .= '
		<script>
		//oculto el loader
		document.getElementById("loading_cloro").style.display = "none";

		/* ************************************************************************** */
		function chngEquipoCloro(idTelemetria,cantSensores) {
			//muestro el loader
			document.getElementById("loading_cloro").style.display = "block";

			//Pido actualizacion
			$("#update_content_cloro").load("principal_update_widget_CrossC_Walmart_Cloro.php?idTelemetria=" + idTelemetria + "&cantSensores="+cantSensores);

			//se esperan 3 segundos
			setTimeout(
				function(){
					//oculto el loader
					document.getElementById("loading_cloro").style.display = "none";
				}
			, 3000);
		}
		/* ************************************************************************** */
		function chngGroupUsoGraphCloro(idTelemetria,cantSensores,idGrupoUso) {
			//muestro el loader
			document.getElementById("loading_cloro").style.display = "block";

			//Pido actualizacion
			$("#update_graphics_cloro").load("principal_update_widget_CrossC_Walmart_Cloro_Group.php?idTelemetria=" + idTelemetria + "&cantSensores="+cantSensores + "&idGrupoUso="+idGrupoUso);

			//se esperan 3 segundos
			setTimeout(
				function(){
					//oculto el loader
					document.getElementById("loading_cloro").style.display = "none";
				}
			, 3000);
		}
		/* ************************************************************************** */
		function chngGroupGraphCloro(idTelemetria,cantSensores,idGrupoUso,idGrupo) {
			//muestro el loader
			document.getElementById("loading_cloro").style.display = "block";

			//Pido actualizacion
			$("#update_graphics_cloro").load("principal_update_widget_CrossC_Walmart_Cloro_Sensor.php?idTelemetria=" + idTelemetria + "&cantSensores="+cantSensores + "&idGrupoUso="+idGrupoUso + "&idGrupo="+idGrupo);

			//se esperan 3 segundos
			setTimeout(
				function(){
					//oculto el loader
					document.getElementById("loading_cloro").style.display = "none";
				}
			, 3000);
		}
		</script>
		';
		return $widget;
	}else{

		return alert_post_data(4,1,1,0, 'No hay equipos de este sistema asignados a este perfil');
	}

}
/*******************************************************************************************************************/
//Muestra los promedios de los equipos
function widget_CrossC_WalmartHornos($timeBack, $seguimiento, $idSistema, $idTipoUsuario, $idUsuario, $NMaxSens, $dbConn){

	//Guardar
	$_SESSION['usuario']['widget_CrossC_WalmartHornos']['timeBack']      = $timeBack;
	$_SESSION['usuario']['widget_CrossC_WalmartHornos']['seguimiento']   = $seguimiento;
	$_SESSION['usuario']['widget_CrossC_WalmartHornos']['idSistema']     = $idSistema;
	$_SESSION['usuario']['widget_CrossC_WalmartHornos']['idTipoUsuario'] = $idTipoUsuario;
	$_SESSION['usuario']['widget_CrossC_WalmartHornos']['idUsuario']     = $idUsuario;
	$_SESSION['usuario']['widget_CrossC_WalmartHornos']['NMaxSens']      = $NMaxSens;

	//variables
	$arrDatoGrafico = array();
	$arrDatoEquipo  = array();
	$arrDatoX       = array();
	$arrSubgrupo    = array();
	$arrGraficos    = array();
	$CountGrupo     = 0;
	$Temp_1         = '';
	$HoraInicio     = restahoras($timeBack,hora_actual());
	$FechaInicio    = fecha_actual();
	$HoraTermino    = hora_actual();
	$FechaTermino   = fecha_actual();
	if($HoraTermino<$timeBack){
		$FechaInicio = restarDias($FechaTermino,1);
	}

	//Variable
	$SIS_where = "telemetria_listado.idEstado = 1 ";//solo equipos activos
	//Filtro de los tab
	$SIS_where .= " AND telemetria_listado.idTab = 2";//1Tek C
	$SIS_where .= " AND telemetria_listado.Nombre LIKE 'Horno%'";//Comienza por Horno
	//solo los equipos que tengan el seguimiento activado
	if(isset($seguimiento)&&$seguimiento!=''&&$seguimiento!=0){
		$SIS_where .= " AND telemetria_listado.id_Geo = ".$seguimiento;
	}
	//Filtro el sistema al cual pertenece
	if(isset($idSistema)&&$idSistema!=''&&$idSistema!=0){
		$SIS_where .= " AND telemetria_listado.idSistema = ".$idSistema;
	}
	//Verifico el tipo de usuario que esta ingresando y el id
	$SIS_join  = '';
	if(isset($idTipoUsuario, $idUsuario)&&$idTipoUsuario!=1&&$idUsuario!=0){
		$SIS_join  .= " INNER JOIN usuarios_equipos_telemetria ON usuarios_equipos_telemetria.idTelemetria = telemetria_listado.idTelemetria ";
		$SIS_where .= " AND usuarios_equipos_telemetria.idUsuario = ".$idUsuario;
	}

	/*************************************************************/
	//Se consulta
	$SIS_query = '
	telemetria_listado.idTelemetria,
	telemetria_listado.Nombre,
	telemetria_listado.cantSensores,
	telemetria_listado.LastUpdateFecha,
	telemetria_listado.LastUpdateHora,
	telemetria_listado.TiempoFueraLinea,
	telemetria_listado.NErrores,
	telemetria_listado.NAlertas,
	telemetria_listado.MedicionTiempo,
	telemetria_listado.CrossCMinHorno';
	for ($i = 1; $i <= $NMaxSens; $i++) {
		$SIS_query .= ',telemetria_listado_sensores_grupo.SensoresGrupo_'.$i;
		$SIS_query .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i;
		$SIS_query .= ',telemetria_listado_sensores_med_actual.SensoresMedActual_'.$i;
		$SIS_query .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$i;
	}
	$SIS_join  .= '
	LEFT JOIN `telemetria_listado_sensores_grupo`          ON telemetria_listado_sensores_grupo.idTelemetria          = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_unimed`         ON telemetria_listado_sensores_unimed.idTelemetria         = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_med_actual`     ON telemetria_listado_sensores_med_actual.idTelemetria     = telemetria_listado.idTelemetria
	LEFT JOIN `telemetria_listado_sensores_activo`         ON telemetria_listado_sensores_activo.idTelemetria         = telemetria_listado.idTelemetria';
	$SIS_order = 'telemetria_listado.Nombre ASC';
	$arrEquipo = array();
	$arrEquipo = db_select_array (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrEquipo');

	/*************************************************************/
	//si hay equipos
	if($arrEquipo!=false){
		/*************************************************************/
		//recorro los equipos para obtener el grupo
		foreach($arrEquipo as $equip) {
			//Busco los grupos que utiliza
			for ($i = 1; $i <= $equip['cantSensores']; $i++) {
				/******************************/
				//almaceno el grupo
				$arrSubgrupo[$equip['SensoresGrupo_'.$i]]['idGrupo'] = $equip['SensoresGrupo_'.$i];
				/******************************/
				//Verifico si el sensor esta activo para guardar el dato, esta dentro de los parametros y es un sensor de temperatura
				if(isset($equip['SensoresActivo_'.$i],$equip['SensoresMedActual_'.$i],$equip['SensoresUniMed_'.$i])&&$equip['SensoresActivo_'.$i]==1&&$equip['SensoresMedActual_'.$i]<999&&$equip['SensoresUniMed_'.$i]==3){
					/*****************************/
					//verifico si existe
					if(isset($arrDatoEquipo[$equip['idTelemetria']][$equip['SensoresGrupo_'.$i]]['Valor'])&&$arrDatoEquipo[$equip['idTelemetria']][$equip['SensoresGrupo_'.$i]]['Valor']!=''){
						$arrDatoEquipo[$equip['idTelemetria']][$equip['SensoresGrupo_'.$i]]['Valor'] = $arrDatoEquipo[$equip['idTelemetria']][$equip['SensoresGrupo_'.$i]]['Valor'] + $equip['SensoresMedActual_'.$i];
						$arrDatoEquipo[$equip['idTelemetria']][$equip['SensoresGrupo_'.$i]]['Cuenta']++;
					//si no lo crea
					}else{
						$arrDatoEquipo[$equip['idTelemetria']][$equip['SensoresGrupo_'.$i]]['Valor']  = $equip['SensoresMedActual_'.$i];
						$arrDatoEquipo[$equip['idTelemetria']][$equip['SensoresGrupo_'.$i]]['Cuenta'] = 1;
					}
					/*****************************/
					//verifico si existe
					if(isset($arrDatoX[$equip['idTelemetria']]['Valor'])&&$arrDatoX[$equip['idTelemetria']]['Valor']!=''){
						$arrDatoX[$equip['idTelemetria']]['Valor'] = $arrDatoX[$equip['idTelemetria']]['Valor'] + $equip['SensoresMedActual_'.$i];
						$arrDatoX[$equip['idTelemetria']]['Cuenta']++;
					//si no lo crea
					}else{
						$arrDatoX[$equip['idTelemetria']]['Valor']  = $equip['SensoresMedActual_'.$i];
						$arrDatoX[$equip['idTelemetria']]['Cuenta'] = 1;
					}

				}
			}
		}

		/*************************************************************/
		//se traen solo los grupos activos
		$SIS_whereSubgrupo  = 'idGrupo=0';
		//se crea cadena
		foreach($arrSubgrupo as $categoria=>$sub){
			$SIS_whereSubgrupo .= ' OR idGrupo='.$sub['idGrupo'];
		}
		/******************************/
		//Se consulta
		$arrGrupos = array();
		$arrGrupos = db_select_array (false, 'idGrupo, Nombre', 'telemetria_listado_grupos', '', $SIS_whereSubgrupo, 'Nombre ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrGrupos');
		//se recorre
		if($arrGrupos!=false){
			foreach ($arrGrupos as $gru) {
				//cuento el grupo
				$CountGrupo++;
			}
		}

		/*************************************************************/
		//identificacion
		$idTelemetria      = $arrEquipo[0]['idTelemetria'];
		$N_Maximo_Sensores = $arrEquipo[0]['cantSensores'];

		/*****************************/
		//Se consulta
		$SIS_query = 'FechaSistema,HoraSistema';
		for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
			$SIS_query .= ',Sensor_'.$i.' AS SensorValue_'.$i;
		}
		$SIS_join  = '';
		$SIS_where = '(TimeStamp BETWEEN "'.$FechaInicio.' '.$HoraInicio.'" AND "'.$FechaTermino.' '.$HoraTermino.'")';
		$SIS_order = 'FechaSistema ASC,HoraSistema ASC LIMIT 10000';
		$arrMediciones = array();
		$arrMediciones = db_select_array (false, $SIS_query, 'telemetria_listado_tablarelacionada_'.$idTelemetria, $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrMediciones');

		/*****************************/
		//si hay mediciones
		if($arrMediciones!=false){
			/******************************/
			//Se recorren las mediciones
			foreach($arrMediciones as $cli) {
				/******************************/
				//reseteo
				$arrTemporal = array();

				/******************************/
				//Busco los grupos que utiliza
				for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
					/******************************/
					//Verifico si el sensor esta activo para guardar el dato, esta dentro de los parametros y es un sensor de temperatura
					if(isset($arrEquipo[0]['SensoresActivo_'.$i],$cli['SensorValue_'.$i],$arrEquipo[0]['SensoresUniMed_'.$i])&&$arrEquipo[0]['SensoresActivo_'.$i]==1&&$cli['SensorValue_'.$i]<999&&$arrEquipo[0]['SensoresUniMed_'.$i]==3){
						/*****************************/
						//verifico si existe
						if(isset($arrTemporal[$arrEquipo[0]['SensoresGrupo_'.$i]]['Valor'])&&$arrTemporal[$arrEquipo[0]['SensoresGrupo_'.$i]]['Valor']!=''){
							$arrTemporal[$arrEquipo[0]['SensoresGrupo_'.$i]]['Valor'] = $arrTemporal[$arrEquipo[0]['SensoresGrupo_'.$i]]['Valor'] + $cli['SensorValue_'.$i];
							$arrTemporal[$arrEquipo[0]['SensoresGrupo_'.$i]]['Cuenta']++;
						//si no lo crea
						}else{
							$arrTemporal[$arrEquipo[0]['SensoresGrupo_'.$i]]['Valor']  = $cli['SensorValue_'.$i];
							$arrTemporal[$arrEquipo[0]['SensoresGrupo_'.$i]]['Cuenta'] = 1;
						}
					}
				}
				/******************************/
				//se crean las nuevas columnas
				if($arrGrupos!=false){
					foreach ($arrGrupos as $gru) {
						//verifico si existe el dato
						if(isset($arrDatoGrafico[$gru['idGrupo']]['Value'])&&$arrDatoGrafico[$gru['idGrupo']]['Value']!=''){
							//si hay datos
							if(isset($arrTemporal[$gru['idGrupo']]['Cuenta'])&&$arrTemporal[$gru['idGrupo']]['Cuenta']!=0){
								$arrDatoGrafico[$gru['idGrupo']]['Value'] .= ", ".cantidades_google(Cantidades($arrTemporal[$gru['idGrupo']]['Valor']/$arrTemporal[$gru['idGrupo']]['Cuenta'], 2));
							}else{
								$arrDatoGrafico[$gru['idGrupo']]['Value'] .= ", 0";
							}
						//si no lo crea
						}else{
							//si hay datos
							if(isset($arrTemporal[$gru['idGrupo']]['Cuenta'])&&$arrTemporal[$gru['idGrupo']]['Cuenta']!=0){
								$arrDatoGrafico[$gru['idGrupo']]['Value'] = cantidades_google(Cantidades($arrTemporal[$gru['idGrupo']]['Valor']/$arrTemporal[$gru['idGrupo']]['Cuenta'], 2));
							}else{
								$arrDatoGrafico[$gru['idGrupo']]['Value'] = 0;
							}
						}
					}
				}
				/******************************/
				//Guardo la fecha
				$Temp_1 .= "'".Fecha_estandar($cli['FechaSistema'])." - ".$cli['HoraSistema']."',";
			}
		}

		/*************************************************************/
		//variables
		$x_graph_count        = 0;
		$Graphics_xData       = 'var xData = [';
		$Graphics_yData       = 'var yData = [';
		$Graphics_names       = 'var names = [';
		$Graphics_types       = 'var types = [';
		$Graphics_texts       = 'var texts = [';
		$Graphics_lineColors  = 'var lineColors = [';
		$Graphics_lineDash    = 'var lineDash = [';
		$Graphics_lineWidth   = 'var lineWidth = [';
		//Se crean los datos
		if($arrGrupos!=false){
			foreach ($arrGrupos as $gru) {
				if(isset($arrDatoGrafico[$gru['idGrupo']]['Value'])&&$arrDatoGrafico[$gru['idGrupo']]['Value']!=''){
					//las fechas
					$Graphics_xData      .='['.$Temp_1.'],';
					//los valores
					$Graphics_yData      .='['.$arrDatoGrafico[$gru['idGrupo']]['Value'].'],';
					//los nombres
					$Graphics_names      .= '"'.DeSanitizar(TituloMenu($gru['Nombre'])).'",';
					//los tipos
					$Graphics_types      .= "'',";
					//si lleva texto en las burbujas
					$Graphics_texts      .= "[],";
					//los colores de linea
					$Graphics_lineColors .= "'',";
					//los tipos de linea
					$Graphics_lineDash   .= "'',";
					//los anchos de la linea
					$Graphics_lineWidth  .= "'',";
					//contador
					$x_graph_count++;
				}
			}
		}
		$Graphics_xData      .= '];';
		$Graphics_yData      .= '];';
		$Graphics_names      .= '];';
		$Graphics_types      .= '];';
		$Graphics_texts      .= '];';
		$Graphics_lineColors .= '];';
		$Graphics_lineDash   .= '];';
		$Graphics_lineWidth  .= '];';

		/*************************************************************/
		/*************************************************************/
		//Se dibuja
		$widget = '
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="box">
				<header>
					<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
					<h5>Equipos</h5>
				</header>

				<div class="tab-content">

					<div id="loadingWalmart"></div>

					<div class="" id="update_content__horno">
						<div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
							<div class="row">
								<div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar">
									<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
										<thead>
											<tr role="row">
												<th colspan="3">Datos Equipo</th>
												<th colspan="'.$CountGrupo.'">Temperatura actual C°</th>
												<th></th>
											</tr>
											<tr role="row">
												<th>Horno</th>
												<th>Funcionamiento</th>
												<th>Tiempo Trabajo</th>';
												//se crean las nuevas columnas
												if($arrGrupos!=false){
													foreach ($arrGrupos as $gru) {
														//se dibuja
														$widget.= '<th>'.$gru['Nombre'].'</th>';
													}
												}
												//sigo dibujando
												$widget.= '
												<th>Acciones</th>
											</tr>
										</thead>
										<tbody role="alert" aria-live="polite" aria-relevant="all" id="TableFiltered">';
											//recorro los equipos para obtener el grupo
											foreach($arrEquipo as $equip) {
												/**********************************************/
												//Fuera de linea
												$diaInicio   = $equip['LastUpdateFecha'];
												$diaTermino  = $FechaTermino;
												$tiempo1     = $equip['LastUpdateHora'];
												$tiempo2     = $HoraTermino;
												$Tiempo      = horas_transcurridas($diaInicio, $diaTermino, $tiempo1, $tiempo2);

												//Comparaciones de tiempo
												$Time_Tiempo     = horas2segundos($Tiempo);
												$Time_Tiempo_FL  = horas2segundos($equip['TiempoFueraLinea']);
												$Time_Tiempo_Max = horas2segundos('48:00:00');
												$Time_Fake_Ini   = horas2segundos('23:59:50');
												$Time_Fake_Fin   = horas2segundos('24:00:00');
												//verificar errores
												if(isset($equip['NErrores'],$equip['NAlertas'])&&($equip['NErrores']!=0 OR $equip['NAlertas']!=0)){
													$danger_color = 'warning';
													$danger_btn   = '<a href="view_alertas_personalizadas.php?view='.simpleEncode($equip['idTelemetria'], fecha_actual()).'" title="Ver Información" class="iframe btn btn-danger btn-sm"><i class="fa fa-bell-o" aria-hidden="true"></i></a>';
												}else{
													$danger_color = '';
													$danger_btn   = '';
												}
												//comparacion
												if(($Time_Tiempo<$Time_Fake_Ini OR $Time_Tiempo>$Time_Fake_Fin)&&(($Time_Tiempo>$Time_Tiempo_FL&&$Time_Tiempo_FL!=0) OR ($Time_Tiempo>$Time_Tiempo_Max&&$Time_Tiempo_FL==0))){
													$danger_color = 'danger';
												}
												//verificar temperaturas
												if(isset($arrDatoX[$equip['idTelemetria']]['Cuenta'])&&$arrDatoX[$equip['idTelemetria']]['Cuenta']!=0){
													$PROM_X = $arrDatoX[$equip['idTelemetria']]['Valor'] / $arrDatoX[$equip['idTelemetria']]['Cuenta'];
													//verifico si esta encendido
													if(isset($equip['CrossCMinHorno'])&&$equip['CrossCMinHorno']!=0&&$PROM_X>=$equip['CrossCMinHorno']){
														$danger_icon = '<a href="#" title="Equipo Encendido" class="btn btn-default btn-sm tooltip" style="position: inherit;display: inherit;"><span style="color:#5cb85c;"><i class="fa fa-toggle-on" aria-hidden="true"></i></span></a>';
													}else{
														$danger_icon = '<a href="#" title="Equipo Apagado"   class="btn btn-default btn-sm tooltip" style="position: inherit;display: inherit;"><span style="color:#d9534f;"><i class="fa fa-toggle-off" aria-hidden="true"></i></span></a>';
													}
												}

												$widget .= '
												<tr class="odd '.$danger_color.'">
													<td>'.TituloMenu($equip['Nombre']).'<br/>'.fecha_estandar($equip['LastUpdateFecha']).' a las '.$equip['LastUpdateHora'].' hrs.</td>
													<td>'.$danger_icon.'</td>
													<td>'.Cantidades($equip['MedicionTiempo']/3600, 1).'</td>';
													//se crean las nuevas columnas
													if($arrGrupos!=false){
														foreach ($arrGrupos as $gru) {
															//verifico si existe
															if(isset($arrDatoEquipo[$equip['idTelemetria']][$gru['idGrupo']]['Cuenta'])&&$arrDatoEquipo[$equip['idTelemetria']][$gru['idGrupo']]['Cuenta']!=0){
																$PromGroup = $arrDatoEquipo[$equip['idTelemetria']][$gru['idGrupo']]['Valor'] / $arrDatoEquipo[$equip['idTelemetria']][$gru['idGrupo']]['Cuenta'];
															}else{
																$PromGroup = 0;
															}
															//se dibuja
															$widget.= '<td>'.Cantidades($PromGroup, 1).'</td>';
														}
													}
													//sigo dibujando
													$widget.= '
													<td>
														<div class="btn-group" style="width: 70px;" >
															<button onClick="chngGroupGraphWalmart('.$equip['idTelemetria'].', '.$equip['cantSensores'].')" title="Ver Información" class="btn btn-metis-6 btn-sm tooltip"><i class="fa fa-line-chart" aria-hidden="true"></i></button>
															'.$danger_btn.'
														</div>
													</td>
												</tr>';
											}

										$widget .= '
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
							<div class="row" id="update_graphics__horno">';
								//si hay datos
								if(isset($x_graph_count)&&$x_graph_count!=0){
									$gr_tittle = 'Grafico '.DeSanitizar($arrEquipo[0]['Nombre']).' últimas '.horas2decimales($timeBack).' horas.';
									$gr_unimed = '°C';
									$widget .= GraphLinear_1('graphLinear_1_horno', $gr_tittle, 'Fecha', $gr_unimed, $Graphics_xData, $Graphics_yData, $Graphics_names, $Graphics_types, $Graphics_texts, $Graphics_lineColors, $Graphics_lineDash, $Graphics_lineWidth, 1);
								//si no hay datos
								}else{
									$widget .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><br/>';
									$widget .= '<div class="alert alert-danger alert-white rounded alert_box_correction" role="alert"><div class="icon"><i class="fa fa-info-circle faa-bounce animated" aria-hidden="true"></i></div><span id="alert_post_data">No hay datos para desplegar el grafico</span><div class="clearfix"></div></div>';
									$widget .= '</div>';
								}
								$widget .= '
							</div>
						</div>
					</div>

					<div class="clearfix"></div>

				</div>
			</div>
		</div>';

		/**********************************************/
		$widget .= '
		<script>
		//oculto el loader
		document.getElementById("loadingWalmart").style.display = "none";

		/* ************************************************************************** */
		function chngGroupGraphWalmart(idTelemetria,cantSensores) {
			//muestro el loader
			document.getElementById("loadingWalmart").style.display = "block";

			//Pido actualizacion
			$("#update_graphics__horno").load("principal_update_widget_CrossC_Walmart_Sensor_Horno.php?idTelemetria=" + idTelemetria + "&cantSensores="+cantSensores);

			//se esperan 3 segundos
			setTimeout(
				function(){
					//oculto el loader
					document.getElementById("loadingWalmart").style.display = "none";
				}
			, 3000);
		}
		</script>
		';
		//imprimo
		echo $widget;
	}else{
		return alert_post_data(4,1,1,0, 'No hay equipos de este sistema asignados a este perfil');
	}

}
/*******************************************************************************************************************/
//Muestra los promedios de los equipos
function widget_CrossC_Jumbo($timeBack, $seguimiento, $idSistema, $idTipoUsuario, $idUsuario, $dbConn){

	//Variable
	$SIS_where = "telemetria_listado.idEstado = 1 ";//solo equipos activos
	//Filtro de los tab
	$SIS_where .= " AND telemetria_listado.idTab = 2";//1Tek C
	//solo los equipos que tengan el seguimiento activado
	if(isset($seguimiento)&&$seguimiento!=''&&$seguimiento!=0){
		$SIS_where .= " AND telemetria_listado.id_Geo = ".$seguimiento;
	}
	//Filtro el sistema al cual pertenece
	if(isset($idSistema)&&$idSistema!=''&&$idSistema!=0){
		$SIS_where .= " AND telemetria_listado.idSistema = ".$idSistema;
	}
	//Verifico el tipo de usuario que esta ingresando y el id
	$SIS_join  = '';
	if(isset($idTipoUsuario, $idUsuario)&&$idTipoUsuario!=1&&$idUsuario!=0){
		$SIS_join  .= " INNER JOIN usuarios_equipos_telemetria ON usuarios_equipos_telemetria.idTelemetria = telemetria_listado.idTelemetria ";
		$SIS_where .= " AND usuarios_equipos_telemetria.idUsuario = ".$idUsuario;
	}

	/*************************************************************/
	//Se consulta
	$SIS_query = '
	telemetria_listado.idTelemetria,
	telemetria_listado.Nombre,
	telemetria_listado.cantSensores';
	$SIS_order = 'telemetria_listado.Nombre ASC';
	$arrEquipo = array();
	$arrEquipo = db_select_array (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrEquipo');

	/**************************************************************/
	//verifico la existencia de al menos un dato
	if(isset($arrEquipo[0]['idTelemetria'])&&$arrEquipo[0]['idTelemetria']!=''){
		/*************************************************************/
		//identificacion
		$idTelemetria      = $arrEquipo[0]['idTelemetria'];
		$N_Maximo_Sensores = $arrEquipo[0]['cantSensores'];

		//Se Guardan datos
		$_SESSION['usuario']['widget_CrossC']['idTelemetria']  = $arrEquipo[0]['idTelemetria'];
		$_SESSION['usuario']['widget_CrossC']['cantSensores']  = $arrEquipo[0]['cantSensores'];
		$_SESSION['usuario']['widget_CrossC']['timeBack']      = $timeBack;
		$_SESSION['usuario']['widget_CrossC']['seguimiento']   = $seguimiento;
		$_SESSION['usuario']['widget_CrossC']['idSistema']     = $idSistema;
		$_SESSION['usuario']['widget_CrossC']['idTipoUsuario'] = $idTipoUsuario;
		$_SESSION['usuario']['widget_CrossC']['idUsuario']     = $idUsuario;

		/*************************************************************/
		//Se consulta solo el primer equipo
		$SIS_query = '
		telemetria_listado.Nombre,
		telemetria_listado.LastUpdateFecha,
		telemetria_listado.LastUpdateHora,
		telemetria_listado.TiempoFueraLinea,
		telemetria_listado.Jornada_inicio,
		telemetria_listado.Jornada_termino';
		for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
			$SIS_query .= ',telemetria_listado_sensores_grupo.SensoresGrupo_'.$i;
			$SIS_query .= ',telemetria_listado_sensores_revision_grupo.SensoresRevisionGrupo_'.$i;
			$SIS_query .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i;
			$SIS_query .= ',telemetria_listado_sensores_med_actual.SensoresMedActual_'.$i;
			$SIS_query .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$i;
		}
		$SIS_join  .= '
		LEFT JOIN `telemetria_listado_sensores_grupo`          ON telemetria_listado_sensores_grupo.idTelemetria          = telemetria_listado.idTelemetria
		LEFT JOIN `telemetria_listado_sensores_revision_grupo` ON telemetria_listado_sensores_revision_grupo.idTelemetria = telemetria_listado.idTelemetria
		LEFT JOIN `telemetria_listado_sensores_unimed`         ON telemetria_listado_sensores_unimed.idTelemetria         = telemetria_listado.idTelemetria
		LEFT JOIN `telemetria_listado_sensores_med_actual`     ON telemetria_listado_sensores_med_actual.idTelemetria     = telemetria_listado.idTelemetria
		LEFT JOIN `telemetria_listado_sensores_activo`         ON telemetria_listado_sensores_activo.idTelemetria         = telemetria_listado.idTelemetria';
		$SIS_where = 'telemetria_listado.idTelemetria='.$idTelemetria;
		$rowEquipo = db_select_data (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $dbConn, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'rowEquipo');

		/*************************************************************/
		//Obtengo hora actual
		$hora_actual = hora_actual();
		//verifico si existe, es distinto de 0 y esta entre la jornada de trabajo
		if(isset($rowEquipo['Jornada_inicio'], $rowEquipo['Jornada_termino'])&&$rowEquipo['Jornada_inicio']!='00:00:00'&&$rowEquipo['Jornada_termino']!='00:00:00'&&$hora_actual>$rowEquipo['Jornada_inicio']&&$hora_actual<$rowEquipo['Jornada_termino']){
			//variables
			$HoraInicio     = $rowEquipo['Jornada_inicio'];
			$FechaInicio    = fecha_actual();
			$HoraTermino    = $rowEquipo['Jornada_termino'];
			$FechaTermino   = fecha_actual();
		}else{
			//variables
			$HoraInicio     = restahoras($timeBack,hora_actual());
			$FechaInicio    = fecha_actual();
			$HoraTermino    = hora_actual();
			$FechaTermino   = fecha_actual();
			if($HoraTermino<$timeBack){
				$FechaInicio = restarDias($FechaTermino,1);
			}
		}

		/*************************************************************/
		//Se consulta
		$SIS_query = 'FechaSistema,HoraSistema';
		for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
			$SIS_query .= ',Sensor_'.$i.' AS SensorValue_'.$i;
		}
		$SIS_join  = '';
		$SIS_where = '(TimeStamp BETWEEN "'.$FechaInicio.' '.$HoraInicio.'" AND "'.$FechaTermino.' '.$HoraTermino.'")';
		$SIS_order = 'FechaSistema ASC,HoraSistema ASC LIMIT 10000';
		$arrMediciones = array();
		$arrMediciones = db_select_array (false, $SIS_query, 'telemetria_listado_tablarelacionada_'.$idTelemetria, $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrMediciones');

		/*************************************************************/
		//busco los grupos disponibles
		$arrSubgrupo          = array();
		$arrSubgrupoUso       = array();
		$SIS_whereSubgrupo    = 'idGrupo=0';
		$SIS_whereSubgrupoUso = 'idGrupo=0';
		//creo arreglo
		for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
			$arrSubgrupo[$rowEquipo['SensoresGrupo_'.$i]]['idGrupo']            = $rowEquipo['SensoresGrupo_'.$i];
			$arrSubgrupoUso[$rowEquipo['SensoresRevisionGrupo_'.$i]]['idGrupo'] = $rowEquipo['SensoresRevisionGrupo_'.$i];
		}
		//se crea cadena
		foreach($arrSubgrupo as $categoria=>$sub){
			$SIS_whereSubgrupo .= ' OR idGrupo='.$sub['idGrupo'];
		}
		foreach($arrSubgrupoUso as $categoria=>$sub){
			$SIS_whereSubgrupoUso .= ' OR idGrupo='.$sub['idGrupo'];
		}

		/****************************************/
		//Se consulta
		$arrGrupos = array();
		$arrGrupos = db_select_array (false, 'idGrupo, Nombre', 'telemetria_listado_grupos', '', $SIS_whereSubgrupo, 'Nombre ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrGrupos');
		//se recorre
		$arrGruposTemp = array();
		foreach ($arrGrupos as $gru) {
			$arrGruposTemp[$gru['idGrupo']] = $gru['Nombre'];
		}

		/****************************************/
		//Se consulta
		$T_idGrupo    = 0;
		$arrGruposUso = array();
		$arrGruposUso = db_select_array (false, 'idGrupo, Nombre', 'telemetria_listado_grupos_uso', '', $SIS_whereSubgrupoUso, 'Nombre ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrGruposUso');
		//se recorre
		$arrGruposUsoTemp = array();
		foreach ($arrGruposUso as $gruUso) {
			$arrGruposUsoTemp[$gruUso['idGrupo']] = $gruUso['Nombre'];
			//guardo el primer grupo
			if($T_idGrupo==0){
				$T_idGrupo = $gruUso['idGrupo'];
			}
		}

		/*************************************************************/
		//Variables
		$arrTempGrupos = array();
		$arrTempSensor = array();
		$arrTempMed    = array();
		$Temp_1        = '';
		$arrData       = array();
		$arrDatax      = array();

		//Se recorren las mediciones
		foreach($arrMediciones as $cli) {

			/******************************/
			//reseteo
			$arrTemporal = array();

			/******************************/
			//recorro los sensores
			for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
				//Verifico si el sensor esta activo para guardar el dato
				if(isset($rowEquipo['SensoresActivo_'.$i])&&$rowEquipo['SensoresActivo_'.$i]==1){
					//Valido valores
					if(isset($cli['SensorValue_'.$i])&&$cli['SensorValue_'.$i]<999){
						/********************************/
						//datos
						//Sumo los sensores
						if(isset($arrTempMed[$i]['Suma'])&&$arrTempMed[$i]['Suma']!=''){
							$arrTempMed[$i]['Suma'] = $arrTempMed[$i]['Suma'] + $cli['SensorValue_'.$i];
						}else{
							$arrTempMed[$i]['Suma'] = $cli['SensorValue_'.$i];
						}
						//Cuento los sensores
						if(isset($arrTempMed[$i]['Cuenta'])&&$arrTempMed[$i]['Cuenta']!=''){
							$arrTempMed[$i]['Cuenta']++;
						}else{
							$arrTempMed[$i]['Cuenta'] = 1;
						}
						//Min de los sensores
						if(isset($arrTempMed[$i]['Min'])&&$arrTempMed[$i]['Min']!=''){
							//verifico si es menor
							if($arrTempMed[$i]['Min']>$cli['SensorValue_'.$i]){
								$arrTempMed[$i]['Min'] = $cli['SensorValue_'.$i];
							}
						}else{
							$arrTempMed[$i]['Min'] = $cli['SensorValue_'.$i];
						}
						//Max de los sensores
						if(isset($arrTempMed[$i]['Max'])&&$arrTempMed[$i]['Max']!=''){
							//verifico si es mayor
							if($arrTempMed[$i]['Max']<$cli['SensorValue_'.$i]){
								$arrTempMed[$i]['Max'] = $cli['SensorValue_'.$i];
							}
						}else{
							$arrTempMed[$i]['Max'] = $cli['SensorValue_'.$i];
						}

						/********************************/
						//Grafico
						//Si es temperatura
						if($rowEquipo['SensoresUniMed_'.$i]==3 OR $rowEquipo['SensoresUniMed_'.$i]==13){
							//verifico si existe
							if(isset($arrTemporal[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Valor'])&&$arrTemporal[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Valor']!=''){
								$arrTemporal[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Valor'] = $arrTemporal[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Valor'] + $cli['SensorValue_'.$i];
								$arrTemporal[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Cuenta']++;
							//si no lo crea
							}else{
								$arrTemporal[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Valor']  = $cli['SensorValue_'.$i];
								$arrTemporal[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Cuenta'] = 1;
							}
						}
					}
				}
			}

			//Guardo la fecha
			$Temp_1 .= "'".Fecha_estandar($cli['FechaSistema'])." - ".$cli['HoraSistema']."',";

			/********************************/
			//Grafico
			//recorro grupo de uso
			foreach ($arrGruposUso as $gruUso) {
				//verifico que sea el primer grupo
				if($T_idGrupo==$gruUso['idGrupo']){
					//recorro los grupos
					foreach ($arrGrupos as $gru) {

						/***********************************************/
						//verifico si hay datos
						if(isset($arrTemporal[$gruUso['idGrupo']][$gru['idGrupo']]['Cuenta'])&&$arrTemporal[$gruUso['idGrupo']][$gru['idGrupo']]['Cuenta']!=0){
							//realizo los calculos
							$New_Dato = $arrTemporal[$gruUso['idGrupo']][$gru['idGrupo']]['Valor']/$arrTemporal[$gruUso['idGrupo']][$gru['idGrupo']]['Cuenta'];
							$arrDatax[$gruUso['idGrupo']][$gru['idGrupo']]['New_Dato'] = $New_Dato;
						//si no hay datos utilizo el anterior
						}else{
							$New_Dato = $arrDatax[$gruUso['idGrupo']][$gru['idGrupo']]['New_Dato'];
						}

						/***********************************************/
						//verifico si existe el dato
						if(isset($arrData[$gruUso['idGrupo']][$gru['idGrupo']]['Value'])&&$arrData[$gruUso['idGrupo']][$gru['idGrupo']]['Value']!=''){
							$arrData[$gruUso['idGrupo']][$gru['idGrupo']]['Value'] .= ", ".$New_Dato;
						//si no lo crea
						}else{
							$arrData[$gruUso['idGrupo']][$gru['idGrupo']]['Value'] = $New_Dato;
						}
					}
				}
			}
		}

		//variables
		$x_graph_count        = 0;
		$Graphics_xData       = 'var xData = [';
		$Graphics_yData       = 'var yData = [';
		$Graphics_names       = 'var names = [';
		$Graphics_types       = 'var types = [';
		$Graphics_texts       = 'var texts = [';
		$Graphics_lineColors  = 'var lineColors = [';
		$Graphics_lineDash    = 'var lineDash = [';
		$Graphics_lineWidth   = 'var lineWidth = [';
		//Se crean los datos
		foreach ($arrGruposUso as $gruUso) {
			foreach ($arrGrupos as $gru) {
				if(isset($arrData[$gruUso['idGrupo']][$gru['idGrupo']]['Value'])&&$arrData[$gruUso['idGrupo']][$gru['idGrupo']]['Value']!=''){
					//las fechas
					$Graphics_xData      .='['.$Temp_1.'],';
					//los valores
					$Graphics_yData      .='['.$arrData[$gruUso['idGrupo']][$gru['idGrupo']]['Value'].'],';
					//los nombres
					$Graphics_names      .= '"'.DeSanitizar(TituloMenu($gruUso['Nombre']).' - '.TituloMenu($gru['Nombre'])).'",';
					//los tipos
					$Graphics_types      .= "'',";
					//si lleva texto en las burbujas
					$Graphics_texts      .= "[],";
					//los colores de linea
					$Graphics_lineColors .= "'',";
					//los tipos de linea
					$Graphics_lineDash   .= "'',";
					//los anchos de la linea
					$Graphics_lineWidth  .= "'',";
					//contador
					$x_graph_count++;
				}
			}
		}
		$Graphics_xData      .= '];';
		$Graphics_yData      .= '];';
		$Graphics_names      .= '];';
		$Graphics_types      .= '];';
		$Graphics_texts      .= '];';
		$Graphics_lineColors .= '];';
		$Graphics_lineDash   .= '];';
		$Graphics_lineWidth  .= '];';

		for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
			//Verifico si el sensor esta activo para guardar el dato
			if(isset($rowEquipo['SensoresActivo_'.$i])&&$rowEquipo['SensoresActivo_'.$i]==1){
				/*****************************************/
				//Grupo Uso
				$arrTempGrupos[$rowEquipo['SensoresRevisionGrupo_'.$i]]['Nombre']  = $arrGruposUsoTemp[$rowEquipo['SensoresRevisionGrupo_'.$i]];
				$arrTempGrupos[$rowEquipo['SensoresRevisionGrupo_'.$i]]['idGrupo'] = $rowEquipo['SensoresRevisionGrupo_'.$i];
				/*****************************************/
				//Grupo
				/**********************/
				//Si es temperatura
				if($rowEquipo['SensoresUniMed_'.$i]==3){
					//Nombre y grupo
					$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Nombre']  = $arrGruposTemp[$rowEquipo['SensoresGrupo_'.$i]];
					$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['idGrupo'] = $rowEquipo['SensoresGrupo_'.$i];
					//Temperatura Minima
					if(isset($arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Tmin'])&&$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Tmin']!=''){
						//verifico si es menor
						if($arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Tmin']>$arrTempMed[$i]['Min']){
							$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Tmin'] = $arrTempMed[$i]['Min'];
						}
					}else{
						$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Tmin'] = $arrTempMed[$i]['Min'];
					}
					//Temperatura Maxima
					if(isset($arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Tmax'])&&$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Tmax']!=''){
						//verifico si es mayor
						if($arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Tmax']<$arrTempMed[$i]['Max']){
							$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Tmax'] = $arrTempMed[$i]['Max'];
						}
					}else{
						$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Tmax'] = $arrTempMed[$i]['Max'];
					}
					//valido que este dentro del rango deseado
					if($rowEquipo['SensoresMedActual_'.$i]<999){
						//Temperatura Actual
						if(isset($arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['TActual'])&&$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['TActual']!=''){
							$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['TActual'] = $arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['TActual'] + $rowEquipo['SensoresMedActual_'.$i];
							$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['CountTActual']++;
						}else{
							$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['TActual'] = $rowEquipo['SensoresMedActual_'.$i];
							$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['CountTActual'] = 1;
						}
					}
					//promedio
					if(isset($arrTempMed[$i]['Suma'])){
						if(isset($arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Prom'])&&$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Prom']!=''){
							$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Prom']      = $arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Prom'] + $arrTempMed[$i]['Suma'];
							$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['CountProm'] = $arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['CountProm'] + $arrTempMed[$i]['Cuenta'];
						}else{
							$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Prom']      = $arrTempMed[$i]['Suma'];
							$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['CountProm'] = $arrTempMed[$i]['Cuenta'];
						}
					}else{
						$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Prom']      = 0;
						$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['CountProm'] = 0;
					}

					//estado (siempre pasa)
					$arrTempGrupos[$rowEquipo['SensoresRevisionGrupo_'.$i]]['NErrores'] = 0;
					$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['NErrores'] = 0;

				/**********************/
				//Si es temperatura Sensacion Termica
				}elseif($rowEquipo['SensoresUniMed_'.$i]==13){
					//valido que este dentro del rango deseado
					if($rowEquipo['SensoresMedActual_'.$i]<999){
						//Humedad
						if(isset($arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['ST'])&&$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['ST']!=''){
							$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['ST'] = $arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['ST'] + $rowEquipo['SensoresMedActual_'.$i];
							$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['CountST']++;
						}else{
							$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['ST'] = $rowEquipo['SensoresMedActual_'.$i];
							$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['CountST'] = 1;
						}
					}
					//estado (siempre pasa)
					$arrTempGrupos[$rowEquipo['SensoresRevisionGrupo_'.$i]]['NErrores'] = 0;
					$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['NErrores'] = 0;

				/**********************/
				//si es humedad
				}elseif($rowEquipo['SensoresUniMed_'.$i]==2){
					//valido que este dentro del rango deseado
					if($rowEquipo['SensoresMedActual_'.$i]<999){
						//Humedad
						if(isset($arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Hum'])&&$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Hum']!=''){
							$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Hum'] = $arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Hum'] + $rowEquipo['SensoresMedActual_'.$i];
							$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['CountHum']++;
						}else{
							$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Hum'] = $rowEquipo['SensoresMedActual_'.$i];
							$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['CountHum'] = 1;
						}
					}
					//estado (siempre pasa)
					$arrTempGrupos[$rowEquipo['SensoresRevisionGrupo_'.$i]]['NErrores'] = 0;
					$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['NErrores'] = 0;

				/**********************/
				//si es boolean
				}elseif($rowEquipo['SensoresUniMed_'.$i]==12){
					//valido que este dentro del rango deseado
					if($rowEquipo['SensoresMedActual_'.$i]<999){
						//Humedad
						if(isset($arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Bool'])&&$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Hum']!=''){
							$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Bool'] = $arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Bool'] + $rowEquipo['SensoresMedActual_'.$i];
							$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['CountBool']++;
						}else{
							$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['Bool'] = $rowEquipo['SensoresMedActual_'.$i];
							$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['CountBool'] = 1;
						}
					}
					//estado (siempre pasa)
					/*$arrTempGrupos[$rowEquipo['SensoresRevisionGrupo_'.$i]]['NErrores'] = 0;
					$arrTempSensor[$rowEquipo['SensoresRevisionGrupo_'.$i]][$rowEquipo['SensoresGrupo_'.$i]]['NErrores'] = 0;
					*/
				}
			}
		}

		/*************************************************************/
		//Se dibuja
		$widget = '
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="box">
				<header>
					<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
					<h5>Equipos</h5>
					<ul class="nav nav-tabs pull-right">';
						$xcounter = 1;
						foreach($arrEquipo as $cli) {
							if($xcounter==1){$xactive = 'active';}else{$xactive = '';}
							if($xcounter==4){
								$widget .= '<li class="dropdown"><a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a><ul class="dropdown-menu" role="menu">';
							}
							$widget .= '<li class="'.$xactive.'"><a href="" onClick="chngEquipo('.$cli['idTelemetria'].', '.$cli['cantSensores'].')"  data-toggle="tab"><i class="fa fa-map-marker" aria-hidden="true"></i> '.$cli['Nombre'].'</a></li>';
							$xcounter++;
						}
						if($xcounter>4){ $widget .= '</ul></li>';}
					$widget .= '
					</ul>
				</header>

				<div class="tab-content">

					<div id="loading"></div>

					<div id="update_content">
						<div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
							<div class="row">
								<div class="table-responsive">
									<div class="table-wrapper-scroll-y my-custom-scrollbar">
										<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
											<thead>';
											//verifico si no esta configurado
											if(!isset($rowEquipo['Jornada_inicio'], $rowEquipo['Jornada_termino']) OR $rowEquipo['Jornada_inicio']=='00:00:00' OR $rowEquipo['Jornada_termino']=='00:00:00'){
												$widget .= '<tr role="row" style="background-color: #ec693c;"><th colspan="10">Horario trabajo no configurado, se muestran las últimas '.horas2decimales($timeBack).' horas.</th></tr>';
											}
											$widget .= '
												<tr role="row">
													<th colspan="3">Grupo - Subgrupo</th>
													<th>T° Actual</th>
													<th>T° Max</th>
													<th>T° Min</th>
													<th>T° Prom</th>
													<th>ST Prom</th>
													<th>Hr. Prom</th>
													<th>Acciones</th>
												</tr>
											</thead>
											<tbody role="alert" aria-live="polite" aria-relevant="all" id="TableFiltered">';

												/**********************************************/
												//variable
												$in_eq_fueralinea = '';
												//Fuera de linea
												$diaInicio   = $rowEquipo['LastUpdateFecha'];
												$diaTermino  = $FechaTermino;
												$tiempo1     = $rowEquipo['LastUpdateHora'];
												$tiempo2     = hora_actual();
												$Tiempo      = horas_transcurridas($diaInicio, $diaTermino, $tiempo1, $tiempo2);

												//Comparaciones de tiempo
												$Time_Tiempo     = horas2segundos($Tiempo);
												$Time_Tiempo_FL  = horas2segundos($rowEquipo['TiempoFueraLinea']);
												$Time_Tiempo_Max = horas2segundos('48:00:00');
												$Time_Fake_Ini   = horas2segundos('23:59:50');
												$Time_Fake_Fin   = horas2segundos('24:00:00');
												//comparacion
												if(($Time_Tiempo<$Time_Fake_Ini OR $Time_Tiempo>$Time_Fake_Fin)&&(($Time_Tiempo>$Time_Tiempo_FL&&$Time_Tiempo_FL!=0) OR ($Time_Tiempo>$Time_Tiempo_Max&&$Time_Tiempo_FL==0))){
													$in_eq_fueralinea = '<i class="fa fa-exclamation-triangle faa-bounce animated" style="color: #a94442;" aria-hidden="true"></i>';
												}

												/***********************************************/
												//imprimo
												$widget .= '
													<tr class="odd">
														<th colspan="9">'.$in_eq_fueralinea.' Ultima Medicion: '.fecha_estandar($rowEquipo['LastUpdateFecha']).' a las '.$rowEquipo['LastUpdateHora'].' hrs.</th>
														<th><a href="view_alertas_personalizadas.php?view='.simpleEncode($_SESSION['usuario']['widget_CrossC']['idTelemetria'], fecha_actual()).'" class="iframe btn btn-danger btn-sm"><i class="fa fa-bell-o" aria-hidden="true"></i> Alertas</a></th>
													</tr>';

												//Ordeno
												sort($arrTempGrupos);
												//recorro
												foreach ($arrTempGrupos as $gruUso) {
													//variables vacias
													$Prom_Tmin      = 0;
													$Prom_Tmax      = 0;
													$Prom_TActual   = 0;
													$Prom_Prom      = 0;
													$Prom_ST        = 0;
													$Prom_Hum       = 0;
													$Prom_Count     = 0;

													//verificar errores
													if(isset($gruUso['NErrores'])&&$gruUso['NErrores']!=0){
														$danger_color = 'warning';
														$danger_icon  = '<a href="#" title="Equipo con Alertas" class="btn btn-warning btn-sm tooltip"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></a>';
													}else{
														$danger_color = '';
														$danger_icon  = '<a href="#" title="Sin Problemas" class="btn btn-success btn-sm tooltip"><i class="fa fa-check" aria-hidden="true"></i></a>';
													}
													$widget .= '
													<tr class="odd '.$danger_color.'">
														<th><div class="btn-group" style="width: 35px;" >'.$danger_icon.'</div></th>
														<th colspan="8">'.TituloMenu($gruUso['Nombre']).'</th>
														<th>
															<div class="btn-group" style="width: 35px;" >
																<button onClick="chngGroupUsoGraph('.$_SESSION['usuario']['widget_CrossC']['idTelemetria'].', '.$_SESSION['usuario']['widget_CrossC']['cantSensores'].', '.$gruUso['idGrupo'].')" title="Ver Información" class="btn btn-primary btn-sm tooltip"><i class="fa fa-line-chart" aria-hidden="true"></i></button>
															</div>
														</th>
													</tr>';
													//se ordena el arreglo
													sort($arrTempSensor[$gruUso['idGrupo']]);
													//recorro el arreglo
													foreach ($arrTempSensor[$gruUso['idGrupo']] as $gru) {
														//verificar errores
														if(isset($gru['NErrores'])&&$gru['NErrores']!=0){
															$danger_color = 'warning';
															$danger_icon  = '<a href="#" title="Equipo con Alertas" class="btn btn-warning btn-sm tooltip"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></a>';
														}else{
															$danger_color = '';
															$danger_icon  = '<a href="#" title="Sin Problemas" class="btn btn-success btn-sm tooltip"><i class="fa fa-check" aria-hidden="true"></i></a>';
														}
														//variables
														$Tmin    = Cantidades($gru['Tmin'], 1);
														$Tmax    = Cantidades($gru['Tmax'], 1);
														if(isset($gru['CountTActual'])&&$gru['CountTActual']!=0){  $TActual = Cantidades(($gru['TActual']/$gru['CountTActual']), 1); }else{ $TActual = 0; }
														if(isset($gru['CountProm'])&&$gru['CountProm']!=0){        $Prom    = Cantidades(($gru['Prom']/$gru['CountProm']), 1);       }else{ $Prom    = 0; }
														if(isset($gru['CountST'])&&$gru['CountST']!=0){            $ST      = Cantidades(($gru['ST']/$gru['CountST']), 1);           }else{ $ST      = 0; }
														if(isset($gru['CountHum'])&&$gru['CountHum']!=0){          $Hum     = Cantidades(($gru['Hum']/$gru['CountHum']), 1);         }else{ $Hum     = 0; }
														if(isset($gru['CountBool'])&&$gru['CountBool']!=0){
															$tempv  = $gru['Bool']/$gru['CountBool'];
															$s_link = 'informe_telemetria_registro_sensores_20.php?f_inicio='.fecha_actual().'&f_termino='.fecha_actual().'&idTelemetria='.$idTelemetria.'&RevisionGrupo='.$gruUso['idGrupo'].'&submit_filter=Filtrar';
															//si esta abierto
															if($tempv!=0){
																$danger_color = 'warning';
																$danger_icon .= '<a target="_blank" rel="noopener noreferrer" href="'.$s_link.'" title="Puertas Abiertas" class="btn btn-warning btn-sm tooltip"><i class="fa fa-sign-out" aria-hidden="true"></i></a>';
															//si esta cerrado
															}else{
																$danger_icon .= '<a target="_blank" rel="noopener noreferrer" href="'.$s_link.'" title="Puertas Cerradas" class="btn btn-success btn-sm tooltip"><i class="fa fa-sign-in" aria-hidden="true"></i></a>';
															}
														//si no hay puertas configuradas
														}else{
															$danger_icon .= '';
														}

														$widget .= '
														<tr class="odd '.$danger_color.'">
															<td></td>
															<td><div class="btn-group" style="width: 70px;" >'.$danger_icon.'</div></td>
															<td>'.TituloMenu($gru['Nombre']).'</td>
															<td>'.$TActual.' °C</td>
															<td>'.$Tmax.' °C</td>
															<td>'.$Tmin.' °C</td>
															<td>'.$Prom.' °C</td>
															<td>'.$ST.' °C</td>
															<td>'.$Hum.' %</td>
															<td>
																<div class="btn-group" style="width: 70px;" >
																	<button onClick="chngGroupGraph('.$_SESSION['usuario']['widget_CrossC']['idTelemetria'].', '.$_SESSION['usuario']['widget_CrossC']['cantSensores'].', '.$gruUso['idGrupo'].', '.$gru['idGrupo'].')" title="Ver Información" class="btn btn-metis-6 btn-sm tooltip"><i class="fa fa-area-chart" aria-hidden="true"></i></button>
																</div>
															</td>
														</tr>';

														/***************************************/
														//Se suman para promedios
														$Prom_Tmin = $Prom_Tmin + $gru['Tmin'];
														$Prom_Tmax = $Prom_Tmax + $gru['Tmax'];
														if(isset($gru['CountTActual'])&&$gru['CountTActual']!=0){  $Prom_TActual = $Prom_TActual + ($gru['TActual']/$gru['CountTActual']); }
														if(isset($gru['CountProm'])&&$gru['CountProm']!=0){        $Prom_Prom    = $Prom_Prom + ($gru['Prom']/$gru['CountProm']);       }
														if(isset($gru['CountST'])&&$gru['CountST']!=0){            $Prom_ST      = $Prom_ST + ($gru['ST']/$gru['CountST']);           }
														if(isset($gru['CountHum'])&&$gru['CountHum']!=0){          $Prom_Hum     = $Prom_Hum + ($gru['Hum']/$gru['CountHum']);         }

														//Cuento
														$Prom_Count++;

													}
													/**************************/
													//muestro subtotales
													$widget .= '
													<tr class="odd">
														<td></td>
														<td></td>
														<td>Promedios</td>
														<td><strong>'.Cantidades(($Prom_TActual/$Prom_Count), 1).' °C</strong></td>
														<td><strong>'.Cantidades(($Prom_Tmax/$Prom_Count), 1).' °C</strong></td>
														<td><strong>'.Cantidades(($Prom_Tmin/$Prom_Count), 1).' °C</strong></td>
														<td><strong>'.Cantidades(($Prom_Prom/$Prom_Count), 1).' °C</strong></td>
														<td><strong>'.Cantidades(($Prom_ST/$Prom_Count), 1).' °C</strong></td>
														<td><strong>'.Cantidades(($Prom_Hum/$Prom_Count), 1).' %</strong></td>
														<td></td>
													</tr>';
												}

											$widget .= '
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
							<div class="row" id="update_graphics">';
								//si hay datos
								if(isset($x_graph_count)&&$x_graph_count!=0){
									//verifico si existe, es distinto de 0 y esta entre la jornada de trabajo
									if(isset($rowEquipo['Jornada_inicio'], $rowEquipo['Jornada_termino'])&&$rowEquipo['Jornada_inicio']!='00:00:00'&&$rowEquipo['Jornada_termino']!='00:00:00'&&$hora_actual>$rowEquipo['Jornada_inicio']&&$hora_actual<$rowEquipo['Jornada_termino']){
										$gr_tittle = TituloMenu($rowEquipo['Nombre']).' - '.DeSanitizar(TituloMenu($arrGruposUsoTemp[$arrGruposUso[0]['idGrupo']])).' ('.Hora_estandar($HoraInicio).'-'.Hora_estandar($HoraTermino).')';
									}else{
										$gr_tittle = TituloMenu($rowEquipo['Nombre']).' - '.DeSanitizar(TituloMenu($arrGruposUsoTemp[$arrGruposUso[0]['idGrupo']])).' fuera del horario establecido.';
									}
									$gr_unimed = '°C';
									$widget .= GraphLinear_1('graphLinear_1', $gr_tittle, 'Fecha', $gr_unimed, $Graphics_xData, $Graphics_yData, $Graphics_names, $Graphics_types, $Graphics_texts, $Graphics_lineColors, $Graphics_lineDash, $Graphics_lineWidth, 1);
								//si no hay datos
								}else{
									$widget .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><br/>';
									$widget .= '<div class="alert alert-danger alert-white rounded alert_box_correction" role="alert"><div class="icon"><i class="fa fa-info-circle faa-bounce animated" aria-hidden="true"></i></div><span id="alert_post_data">No hay datos para desplegar el grafico</span><div class="clearfix"></div></div>';
									$widget .= '</div>';
								}
								$widget .= '
							</div>
						</div>
					</div>

					<div class="clearfix"></div>

				</div>
			</div>
		</div>';

		$widget .= '
		<script>
		//oculto el loader
		document.getElementById("loading").style.display = "none";

		/* ************************************************************************** */
		function chngEquipo(idTelemetria,cantSensores) {
			//muestro el loader
			document.getElementById("loading").style.display = "block";

			//Pido actualizacion
			$("#update_content").load("principal_update_widget_CrossC_Jumbo.php?idTelemetria=" + idTelemetria + "&cantSensores="+cantSensores);

			//se esperan 3 segundos
			setTimeout(
				function(){
					//oculto el loader
					document.getElementById("loading").style.display = "none";
				}
			, 3000);
		}
		/* ************************************************************************** */
		function chngGroupUsoGraph(idTelemetria,cantSensores,idGrupoUso) {
			//muestro el loader
			document.getElementById("loading").style.display = "block";

			//Pido actualizacion
			$("#update_graphics").load("principal_update_widget_CrossC_Jumbo_Group.php?idTelemetria=" + idTelemetria + "&cantSensores="+cantSensores + "&idGrupoUso="+idGrupoUso);

			//se esperan 3 segundos
			setTimeout(
				function(){
					//oculto el loader
					document.getElementById("loading").style.display = "none";
				}
			, 3000);
		}
		/* ************************************************************************** */
		function chngGroupGraph(idTelemetria,cantSensores,idGrupoUso,idGrupo) {
			//muestro el loader
			document.getElementById("loading").style.display = "block";

			//Pido actualizacion
			$("#update_graphics").load("principal_update_widget_CrossC_Jumbo_Sensor.php?idTelemetria=" + idTelemetria + "&cantSensores="+cantSensores + "&idGrupoUso="+idGrupoUso + "&idGrupo="+idGrupo);

			//se esperan 3 segundos
			setTimeout(
				function(){
					//oculto el loader
					document.getElementById("loading").style.display = "none";
				}
			, 3000);
		}
		</script>
		';
		return $widget;
	}else{

		return alert_post_data(4,1,1,0, 'No hay equipos de este sistema asignados a este perfil');
	}

}
/*******************************************************************************************************************/
//Muestra los promedios de los equipos
function widget_whatsappFloatBtn($Fono, $Mesage){

	$widget = '
	<style>
		.whatsappfloat{position:fixed;width:60px;height:60px;bottom:40px;right:40px;background-color:#25d366;color:#FFF;border-radius:50px;text-align:center;font-size:30px;box-shadow: 2px 2px 3px #999;z-index:100;}
		.whatsappfloat .float{margin-top:16px;}
	</style>
	<a class="whatsappfloat" target="_blank" rel="noopener noreferrer" href="https://api.whatsapp.com/send?phone='.$Fono.'&text='.$Mesage.'" >
		<i class="fa fa-whatsapp float"></i>
	</a>';

	echo $widget;
}
/*******************************************************************************************************************/
//Muestra la gestion de equipos decrosscrane
function widget_Gestion_Equipos_crosscrane_ubicacion($titulo,$idSistema, $IDGoogle, $idTipoUsuario, $idUsuario, $SegActual, $dbConn){

	//Si no existe una ID se utiliza una por defecto
	if(!isset($IDGoogle) OR $IDGoogle==''){
		return alert_post_data(4,1,1,0, 'No ha ingresado Una API de Google Maps');
	}else{

		//variables
		$HoraSistema    = hora_actual();
		$FechaSistema   = fecha_actual();
		$Fecha_inicio   = restarDias(fecha_actual(),1);
		$Fecha_fin      = fecha_actual();
		$principioMes   = fecha2Ano($FechaSistema).'-'.fecha2NMes($FechaSistema).'-01';
		$google         = $IDGoogle;

		//Variable
		$SIS_where = "telemetria_listado.idEstado = 1 ";//solo equipos activos
		//solo los equipos que tengan el seguimiento desactivado
		$SIS_where .= " AND telemetria_listado.id_Geo = 2";
		//Filtro el sistema al cual pertenece
		if(isset($idSistema)&&$idSistema!=''&&$idSistema!=0){
			$SIS_where .= " AND telemetria_listado.idSistema = ".$idSistema;
		}
		//Verifico el tipo de usuario que esta ingresando y el id
		$SIS_join  = '';
		if(isset($idTipoUsuario, $idUsuario)&&$idTipoUsuario!=1&&$idUsuario!=0){
			$SIS_join  .= ' INNER JOIN usuarios_equipos_telemetria ON usuarios_equipos_telemetria.idTelemetria = telemetria_listado.idTelemetria ';
			$SIS_where .= ' AND usuarios_equipos_telemetria.idUsuario = '.$idUsuario;
		}
		//Solo para plataforma 1tek
		$SIS_where .= " AND telemetria_listado.idTab=6";//Power-Crane

		//numero sensores equipo
		$N_Maximo_Sensores = 72;
		$subquery = '';
		for ($i = 1; $i <= $N_Maximo_Sensores; $i++) {
			$subquery .= ',telemetria_listado_sensores_nombre.SensoresNombre_'.$i;
			$subquery .= ',telemetria_listado_sensores_med_actual.SensoresMedActual_'.$i;
			$subquery .= ',telemetria_listado_sensores_unimed.SensoresUniMed_'.$i;
			$subquery .= ',telemetria_listado_sensores_activo.SensoresActivo_'.$i;
		}

		/*************************************************************/
		//Se consulta
		$SIS_query = '
		telemetria_listado.idTelemetria,
		telemetria_listado.Nombre,
		telemetria_listado.Identificador,
		telemetria_listado.NumSerie,
		telemetria_listado.LastUpdateFecha,
		telemetria_listado.LastUpdateHora,
		telemetria_listado.cantSensores,
		telemetria_listado.GeoLatitud,
		telemetria_listado.GeoLongitud,
		telemetria_listado.TiempoFueraLinea,
		telemetria_listado.NErrores,
		telemetria_listado.NAlertas,
		telemetria_listado.id_Sensores,
		telemetria_listado.idGenerador,
		telemetria_listado.idTelGenerador,
		telemetria_listado.SensorActivacionID,
		telemetria_listado.SensorActivacionValor,
		telemetria_listado.idUsoFTP,
		telemetria_listado.FTP_Carpeta,
		telemetria_listado.idUbicacion'.$subquery;
		$SIS_join .= '
		LEFT JOIN `telemetria_listado_sensores_nombre`          ON telemetria_listado_sensores_nombre.idTelemetria         = telemetria_listado.idTelemetria
		LEFT JOIN `telemetria_listado_sensores_med_actual`      ON telemetria_listado_sensores_med_actual.idTelemetria     = telemetria_listado.idTelemetria
		LEFT JOIN `telemetria_listado_sensores_unimed`          ON telemetria_listado_sensores_unimed.idTelemetria         = telemetria_listado.idTelemetria
		LEFT JOIN `telemetria_listado_sensores_activo`          ON telemetria_listado_sensores_activo.idTelemetria         = telemetria_listado.idTelemetria';
		$SIS_order = 'telemetria_listado.Nombre ASC';
		$arrEquipo = array();
		$arrEquipo = db_select_array (false, $SIS_query, 'telemetria_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrEquipo');

		/*************************************************************/
		//Se traen todas las unidades de medida
		$arrUnimed = array();
		$arrUnimed = db_select_array (false, 'idUniMed,Nombre', 'telemetria_listado_unidad_medida', '', '', 'idUniMed ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrUnimed');

		//Ordeno las unidades de medida
		$arrFinalUnimed = array();
		foreach ($arrUnimed as $data) {
			$arrFinalUnimed[$data['idUniMed']] = $data['Nombre'];
		}

		/*************************************************************/
		//se traen todas las zonas
		$arrZonas = array();
		$arrZonas = db_select_array (false, 'idZona,Nombre', 'telemetria_zonas', '', '', 'idZona ASC', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrUnimed');

		//defino la variable temporal de la zona
		$_SESSION['usuario']['zona']['idZona']         = 9999;
		$_SESSION['usuario']['zona']['id_Geo']         = 2;
		$_SESSION['usuario']['zona']['idTipoUsuario']  = $idTipoUsuario;
		$_SESSION['usuario']['zona']['idSistema']      = $idSistema;
		$_SESSION['usuario']['zona']['idUsuario']      = $idUsuario;


		$nicon    = 0;
		$arrGruas = array();

		//transaccion a verificar
		$transx = "admin_telemetria_encendido_apagado.php";   //Transaccion de encendido-apagado

		//Seteo la variable a 0
		$prm_xa = 0;
		//recorro los permisos
		if(isset($_SESSION['usuario']['menu'])){
			foreach($_SESSION['usuario']['menu'] as $menu=>$productos) {
				foreach($productos as $producto) {
					//elimino los datos extras
					$str = str_replace("?pagina=1", "", $producto['TransaccionURL']);
					//le asigno el valor 1 en caso de que exista
					if($transx==$str){
						$prm_xa = 1;
					}
				}
			}
		}

		foreach ($arrEquipo as $data) {

			/**********************************************/
			//Se resetean
			$in_eq_alertas     = 0;
			$in_eq_fueralinea  = 0;
			$in_eq_ok          = 1;
			$in_sens_activ     = 0;

			/**********************************************/
			//veo si tiene configurado el sensor de activacion y si esta encendido
			if(isset($data['SensorActivacionID'])&&$data['SensorActivacionID']!=0){
				if(isset($data['SensoresMedActual_'.$data['SensorActivacionID']])&&$data['SensoresMedActual_'.$data['SensorActivacionID']]==$data['SensorActivacionValor']){
					$in_sens_activ = 1; //activo encendido
				}else{
					$in_sens_activ = 2; //activo apagado
				}
			}else{
				$in_sens_activ = 0; //inactivo
			}

			/**********************************************/
			//Fuera de linea
			$diaInicio   = $data['LastUpdateFecha'];
			$diaTermino  = $FechaSistema;
			$tiempo1     = $data['LastUpdateHora'];
			$tiempo2     = $HoraSistema;
			$Tiempo      = horas_transcurridas($diaInicio, $diaTermino, $tiempo1, $tiempo2);

			//Comparaciones de tiempo
			$Time_Tiempo     = horas2segundos($Tiempo);
			$Time_Tiempo_FL  = horas2segundos($data['TiempoFueraLinea']);
			$Time_Tiempo_Max = horas2segundos('48:00:00');
			$Time_Fake_Ini   = horas2segundos('23:59:50');
			$Time_Fake_Fin   = horas2segundos('24:00:00');
			//comparacion
			if(($Time_Tiempo<$Time_Fake_Ini OR $Time_Tiempo>$Time_Fake_Fin)&&(($Time_Tiempo>$Time_Tiempo_FL&&$Time_Tiempo_FL!=0) OR ($Time_Tiempo>$Time_Tiempo_Max&&$Time_Tiempo_FL==0))){
				$in_eq_fueralinea++;
			}

			/**********************************************/
			//Equipos Errores
			if(isset($data['NErrores'])&&$data['NErrores']>0){ $in_eq_alertas++; }

			/*******************************************************/
			//rearmo
			if($in_eq_alertas>0){    $in_eq_ok = 0;  $in_eq_alertas    = 1;    }
			if($in_eq_fueralinea>0){ $in_eq_ok = 0;  $in_eq_fueralinea = 1; $in_eq_alertas = 0;  }

			/*******************************************************/
			//se guardan estados
			$danger = '';
			$xdanger = 1;
			if($in_eq_alertas>0){    $danger = 'warning';  $xdanger = 2; $dataex = '<a href="#" title="Equipo con Alertas"        class="btn btn-warning btn-sm tooltip"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></a>';}
			if($in_eq_fueralinea>0){ $danger = 'danger';   $xdanger = 3; $dataex = '<a href="#" title="Fuera de Linea"            class="btn btn-danger btn-sm tooltip"><i class="fa fa-chain-broken" aria-hidden="true"></i></a>';}

			/*******************************************************/
			//traspasan los estados
			if($in_eq_ok==1){
				$eq_ok_icon = '<a href="#" title="Sin Problemas" class="btn btn-success btn-sm tooltip"><i class="fa fa-check" aria-hidden="true"></i></a>';
			}else{
				$eq_ok_icon = $dataex;
			}
			/*******************************************************/
			//El icono de estado de encendido apagado
			$idSensorResp = 38; //sensor que guarda la respuesta del equipo
			//si tiene los permisos
			if(isset($data['SensoresMedActual_'.$idSensorResp])&&$data['SensoresMedActual_'.$idSensorResp]!=''){
				switch ($data['SensoresMedActual_'.$idSensorResp]) {
					//inactivo
					case 0:
						$status_icon = '';
						$wid_status  = 35;
						break;
					//activo encendido
					case 1:
						//$status_icon = '<a href="" title="Encendido Remoto" class="btn btn-success btn-sm tooltip"><i class="fa fa-unlock" aria-hidden="true"></i></a>';
						//$wid_status = 70;
						$status_icon = '';
						$wid_status  = 35;
						break;
					//activo apagado
					case 2:
						$status_icon = '<a href="" title="Apagado Remoto" class="btn btn-warning btn-sm tooltip"><i class="fa fa-lock" aria-hidden="true"></i></a>';
						$wid_status  = 70;
						break;
				}
			}else{
				$status_icon = '';
				$wid_status  = 35;
			}

			/*************************************************************************/
			//Unidad de medida
			if(isset($arrFinalUnimed[$data['SensoresUniMed_37']])){
				$UniMed_37 = $arrFinalUnimed[$data['SensoresUniMed_37']];
			}else{
				$UniMed_37 = '';
			}
			//Unidad de medida
			if(isset($arrFinalUnimed[$data['SensoresUniMed_39']])){
				$UniMed_39 = $arrFinalUnimed[$data['SensoresUniMed_39']];
			}else{
				$UniMed_39 = '';
			}
			//Guardo todos los datos
			$arrGruas[$data['idUbicacion']][$xdanger][$data['idTelemetria']]['tr_color']     = $danger;
			$arrGruas[$data['idUbicacion']][$xdanger][$data['idTelemetria']]['wid_status']   = $wid_status;
			$arrGruas[$data['idUbicacion']][$xdanger][$data['idTelemetria']]['eq_ok_icon']   = $eq_ok_icon;
			$arrGruas[$data['idUbicacion']][$xdanger][$data['idTelemetria']]['status_icon']  = $status_icon;
			$arrGruas[$data['idUbicacion']][$xdanger][$data['idTelemetria']]['Nombre']       = $data['Nombre'];
			$arrGruas[$data['idUbicacion']][$xdanger][$data['idTelemetria']]['LastUpdate']   = fecha_estandar($data['LastUpdateFecha']).' '.$data['LastUpdateHora'];

			if(isset($data['SensoresMedActual_37'])&&$data['SensoresMedActual_37']!=''&&$data['SensoresMedActual_37']!=0&&$data['SensoresMedActual_37']<99900){
				$arrGruas[$data['idUbicacion']][$xdanger][$data['idTelemetria']]['Voltaje'] = cantidades($data['SensoresMedActual_37'], 1).' '.$UniMed_37;
			}else{
				$arrGruas[$data['idUbicacion']][$xdanger][$data['idTelemetria']]['Voltaje'] = '0 '.$UniMed_37;
			}
			if(isset($data['SensoresMedActual_39'])&&$data['SensoresMedActual_39']!=''&&$data['SensoresMedActual_39']!=0&&$data['SensoresMedActual_39']<99900){
				$arrGruas[$data['idUbicacion']][$xdanger][$data['idTelemetria']]['Viento'] = cantidades($data['SensoresMedActual_39'], 1).' '.$UniMed_39;
			}else{
				$arrGruas[$data['idUbicacion']][$xdanger][$data['idTelemetria']]['Viento'] = 'N/A';
			}
			//si tiene los permisos
			if(isset($prm_xa)&&$prm_xa==1){
				switch ($in_sens_activ) {
					//inactivo
					case 0:
						$arrGruas[$data['idUbicacion']][$xdanger][$data['idTelemetria']]['in_sens_activ'] = '';
						break;
					//activo encendido
					case 1:
						$arrGruas[$data['idUbicacion']][$xdanger][$data['idTelemetria']]['in_sens_activ'] = '<a href="view_crosscrane_apagado.php?view='.simpleEncode($data['idTelemetria'], fecha_actual()).'" title="Cambiar Estado" class="iframe btn btn-success btn-sm tooltip"><i class="fa fa-toggle-on" aria-hidden="true"></i></a>';
						break;
					//activo apagado
					case 2:
						$arrGruas[$data['idUbicacion']][$xdanger][$data['idTelemetria']]['in_sens_activ'] = '<a href="view_crosscrane_apagado.php?view='.simpleEncode($data['idTelemetria'], fecha_actual()).'" title="Cambiar Estado" class="iframe btn btn-danger btn-sm tooltip"><i class="fa fa-toggle-off" aria-hidden="true"></i></a>';
						break;
				}
			}else{
				switch ($in_sens_activ) {
					//inactivo
					case 0:
						$arrGruas[$data['idUbicacion']][$xdanger][$data['idTelemetria']]['in_sens_activ'] = '';
						break;
					//activo encendido
					case 1:
						$arrGruas[$data['idUbicacion']][$xdanger][$data['idTelemetria']]['in_sens_activ'] = '<a href="" title="Equipo Encendido" class="btn btn-success btn-sm tooltip"><i class="fa fa-toggle-on" aria-hidden="true"></i></a>';
						break;
					//activo apagado
					case 2:
						$arrGruas[$data['idUbicacion']][$xdanger][$data['idTelemetria']]['in_sens_activ'] = '<a href="" title="Equipo Apagado" class="btn btn-danger btn-sm tooltip"><i class="fa fa-toggle-off" aria-hidden="true"></i></a>';
						break;
				}
			}

			/****************************************************/
			//busco el tipo de equipo
			$Nombre_equipo = $data['Identificador'];
			$NumSerie      = $data['NumSerie'];
			$buscado_1     = 'elv';
			$buscado_2     = 'gen';
			$s_pos_1       = strpos($NumSerie, $buscado_1);
			$s_pos_2       = strpos($NumSerie, $buscado_2);

			/****************************************************/
			//Si esta en Planta
			if(isset($data['idUbicacion'])&&$data['idUbicacion']==1){
				$show_map = '&ShowMap=True';
			}else{
				$show_map = '';
			}

			/****************************************************/
			// Nótese el uso de ===. Puesto que == simple no funcionará como se espera
			// porque la posición de 'elv-' está en el 1° (primer) caracter.
			if ($s_pos_1 === false) {
				if ($s_pos_2 === false) {
					$arrGruas[$data['idUbicacion']][$xdanger][$data['idTelemetria']]['crosscrane_estado'] = '<a href="view_crosscrane_estado.php?view='.simpleEncode($data['idTelemetria'], fecha_actual()).$show_map.'" title="Estado Equipo" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-tasks" aria-hidden="true"></i></a>';
				}else{
					$arrGruas[$data['idUbicacion']][$xdanger][$data['idTelemetria']]['crosscrane_estado'] = '<a href="view_generador_data.php?view='.simpleEncode($data['idTelemetria'], fecha_actual()).$show_map.'" title="Datos Generador" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-battery-full" aria-hidden="true"></i></a>';
				}
			}else{
				$arrGruas[$data['idUbicacion']][$xdanger][$data['idTelemetria']]['crosscrane_estado'] = '<a href="view_crosscrane_estado_elev.php?view='.simpleEncode($data['idTelemetria'], fecha_actual()).$show_map.'" title="Estado Equipo" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-tasks" aria-hidden="true"></i></a>';
			}

			/****************************************************/
			//el resto de los botones
			$arrGruas[$data['idUbicacion']][$xdanger][$data['idTelemetria']]['CenterMap']             = '<button onclick="fncCenterMap(\''.$data['GeoLatitud'].'\', \''.$data['GeoLongitud'].'\', \''.$nicon.'\')" title="Ver Ubicación" class="btn btn-default btn-sm tooltip"><i class="fa fa-map-marker" aria-hidden="true"></i></button>';
			$arrGruas[$data['idUbicacion']][$xdanger][$data['idTelemetria']]['informe_activaciones']  = '<li><a href="view_telemetria_uso.php?idTelemetria='.$data['idTelemetria'].'&F_inicio='.$principioMes.'&F_termino='.$FechaSistema.'&Amp=&pagina=1&submit_filter=Filtrar" class="iframe" style="white-space: normal;" ><i class="fa fa-clock-o" aria-hidden="true"></i> Uso Grua</a></li>';
			$arrGruas[$data['idUbicacion']][$xdanger][$data['idTelemetria']]['AlarmasPersonalizadas'] = '<li><a href="view_alertas_personalizadas.php?view='.simpleEncode($data['idTelemetria'], fecha_actual()).'" class="iframe" style="white-space: normal;"><i class="fa fa-bell-o" aria-hidden="true"></i> Alertas Personalizadas</a></li>';
			//si tiene un generador
			/*if(isset($data['idGenerador'], $data['idTelGenerador'])&&$data['idGenerador']==1&&$data['idTelGenerador']!=''&&$data['idTelGenerador']!=0){
				$arrGruas[$data['idUbicacion']][$xdanger][$data['idTelemetria']]['Generador'] = '<li><a href="view_generador_data.php?view='.simpleEncode($data['idTelGenerador'], fecha_actual()).'" class="iframe" style="white-space: normal;"><i class="fa fa-battery-full" aria-hidden="true"></i> Datos Generador</a></li>';
			}else{
				$arrGruas[$data['idUbicacion']][$xdanger][$data['idTelemetria']]['Generador'] = '';
			}*/
			//si utiliza carpeta ftp
			if(isset($data['idUsoFTP'], $data['FTP_Carpeta'])&&$data['idUsoFTP']==1&&$data['FTP_Carpeta']!=''){
				$arrGruas[$data['idUbicacion']][$xdanger][$data['idTelemetria']]['CarpetaFTP'] = '<li><a href="view_telemetria_data_files.php?view='.simpleEncode($data['FTP_Carpeta'], fecha_actual()).'" class="iframe" style="white-space: normal;"><i class="fa fa-video-camera" aria-hidden="true"></i> Camara</a></li>';
			}else{
				$arrGruas[$data['idUbicacion']][$xdanger][$data['idTelemetria']]['CarpetaFTP'] = '';
			}

			//boton de alertas pendientes de ver
			if(isset($data['NAlertas'])&&$data['NAlertas']!=''&&$data['NAlertas']!=0){
				//Alertas
				$link_Alertas  = 'view_telemetria_alertas.php';
				$link_Alertas .= '?pagina=1';
				//$link_Alertas .= '?f_inicio='.$Fecha_inicio;
				//$link_Alertas .= '&f_termino='.$Fecha_fin;
				$link_Alertas .= '&idTelemetria='.$data['idTelemetria'];
				$link_Alertas .= '&idLeido=0';
				$link_Alertas .= '&submit_filter=+Filtrar';
				//boton
				$arrGruas[$data['idUbicacion']][$xdanger][$data['idTelemetria']]['NAlertas'] = '<a href="'.$link_Alertas.'" title="'.$data['NAlertas'].' Alertas Pendientes de ver" class="iframe btn btn-danger btn-sm tooltip"><i class="fa fa-exclamation-triangle faa-horizontal animated" aria-hidden="true"></i></a>';
			}else{
				$arrGruas[$data['idUbicacion']][$xdanger][$data['idTelemetria']]['NAlertas'] = '';
			}

			$nicon++;
		}

		//Cuento los totales
		$Count_Alerta      = 0;
		$Count_Ok          = 0;
		$Count_FueraLinea  = 0;
		$Count_Total       = 0;
		$Count_Planta      = 0;

		//obra
		if(isset($arrGruas[2][2])){foreach ( $arrGruas[2][2] as $categoria=>$grua ) {/*$Count_Alerta++;*/$Count_Ok++;$Count_Total++;}}
		if(isset($arrGruas[2][1])){foreach ( $arrGruas[2][1] as $categoria=>$grua ) {$Count_Ok++;$Count_Total++;}}
		if(isset($arrGruas[2][3])){foreach ( $arrGruas[2][3] as $categoria=>$grua ) {$Count_FueraLinea++;$Count_Total++;}}

		//planta
		if(isset($arrGruas[1][1])){foreach ( $arrGruas[1][1] as $categoria=>$grua ) {$Count_Planta++;$Count_Total++;}}
		if(isset($arrGruas[1][2])){foreach ( $arrGruas[1][2] as $categoria=>$grua ) {$Count_Planta++;$Count_Total++;}}
		if(isset($arrGruas[1][3])){foreach ( $arrGruas[1][3] as $categoria=>$grua ) {$Count_Planta++;$Count_Total++;}}

		$GPS  = '';
		$GPS .= '
			<div class="row">';
				//$GPS .= widget_Ficha_2('box-yellow', 'fa-cog', '<span id="updt_Count_Alerta">'.$Count_Alerta.'</span>', 3, 'Con Alertas', '', '', '', '', 1, 1);
				$GPS .= widget_Ficha_2('box-green', 'fa-cog', '<span id="updt_Count_Ok">'.$Count_Ok.'</span>', 3, 'En Linea', '', '', '', '', 1, 1);
				$GPS .= widget_Ficha_2('box-red', 'fa-cog', '<span id="updt_Count_FueraLinea">'.$Count_FueraLinea.'</span>', 3, 'Fuera de Linea', '', '', '', '', 1, 1);
				$GPS .= widget_Ficha_2('box-purple', 'fa-cog', '<span id="updt_Count_Planta">'.$Count_Planta.'</span>', 3, 'En Planta', '', '', '', '', 1, 1);
				$GPS .= widget_Ficha_2('box-blue', 'fa-cog', '<span id="updt_Count_Total">'.$Count_Total.'</span>', 3, 'Total', '', '', '', '', 1, 1);
				$GPS .= '
			</div>';

		$GPS .= '<script async src="https://maps.googleapis.com/maps/api/js?key='.$google.'&callback=initMap"></script>';

		$GPS .= '
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="box">
					<header>
						<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
						<h5>'.$titulo.'</h5>
						<ul class="nav nav-tabs pull-right">
							<li class="active"><a href="#obra" data-toggle="tab"><i class="fa fa-map-o" aria-hidden="true"></i> En Obras</a></li>
							<li class=""><a href="#planta" data-toggle="tab"><i class="fa fa-industry" aria-hidden="true"></i> En Plantas</a></li>
						</ul>
					</header>
					<div class="tab-content">

						<div class="tab-pane fade active in" id="obra">
							<div class="wmd-panel">

								<div class="table-responsive">
									<div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
										<div class="row">
											<div id="vehiContent" class="table-wrapper-scroll-y my-custom-scrollbar">
												<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
													<thead>
														<tr role="row">
															<th colspan="5">
																<div class="field">
																	<select name="selectZona" id="selectZona" class="form-control" onchange="chngZona()" >';
																		//La opción todos
																		$GPS .= '<option value="9999" selected="selected" >Todas las Zonas</option>';
																		foreach ( $arrZonas as $select ) {
																			$GPS .= '<option value="'.$select['idZona'].'" >'.$select['Nombre'].'</option>';
																		}
																	$GPS .= '
																	</select>
																</div>
															</th>
														</tr>';
														$GPS .= widget_sherlock(1, 5, 'TableFiltered_1');
														$GPS .= '
														<tr role="row">
															<th></th>
															<th>Equipo</th>
															<th>Voltaje (V)</th>
															<th>Viento (km/h)</th>
															<th>Acciones</th>
														</tr>
													</thead>
													<tbody role="alert" aria-live="polite" aria-relevant="all" id="TableFiltered_1">';
														/************************************************************/
														//Con alertas
														if(isset($arrGruas[2][2])){
															foreach ( $arrGruas[2][2] as $categoria=>$grua ) {
																$GPS .= '
																<tr class="odd '.$grua['tr_color'].'">
																	<td width="10">
																		<div class="btn-group" style="width: '.$grua['wid_status'].'px;" >';
																			$GPS .= $grua['eq_ok_icon'];
																			$GPS .= $grua['status_icon'];
																		$GPS .= '</div>
																	</td>
																	<td>
																		'.$grua['Nombre'].'<br/>
																		'.$grua['LastUpdate'].'
																	</td>
																	<td>'.$grua['Voltaje'].'</td>
																	<td>'.$grua['Viento'].'</td>
																	<td width="10">
																		<div class="btn-group" style="width: 175px;" >';
																			$GPS .= $grua['in_sens_activ'];
																			$GPS .= $grua['NAlertas'];
																			$GPS .= $grua['crosscrane_estado'];
																			$GPS .= $grua['CenterMap'];
																			$GPS .= '
																			<button type="button" class="btn btn-danger btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
																				<span class="caret"></span>
																				<span class="sr-only">Toggle Dropdown</span>
																			</button>
																			<ul class="dropdown-menu" style="right: 0;float: right;">
																				'.$grua['informe_activaciones'].'
																				'.$grua['AlarmasPersonalizadas'].'
																				'.$grua['CarpetaFTP'].'
																			</ul>
																		</div>
																	</td>
																</tr>';
															}
														}

														/************************************************************/
														//Ok
														if(isset($arrGruas[2][1])){
															foreach ( $arrGruas[2][1] as $categoria=>$grua ) {
																$GPS .= '
																<tr class="odd '.$grua['tr_color'].'">
																	<td width="10">
																		<div class="btn-group" style="width: '.$grua['wid_status'].'px;" >';
																			$GPS .= $grua['eq_ok_icon'];
																			$GPS .= $grua['status_icon'];
																		$GPS .= '</div>
																	</td>
																	<td>
																		'.$grua['Nombre'].'<br/>
																		'.$grua['LastUpdate'].'
																	</td>
																	<td>'.$grua['Voltaje'].'</td>
																	<td>'.$grua['Viento'].'</td>
																	<td width="10">
																		<div class="btn-group" style="width: 175px;" >';
																			$GPS .= $grua['in_sens_activ'];
																			$GPS .= $grua['NAlertas'];
																			$GPS .= $grua['crosscrane_estado'];
																			$GPS .= $grua['CenterMap'];
																			$GPS .= '
																			<button type="button" class="btn btn-danger btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
																				<span class="caret"></span>
																				<span class="sr-only">Toggle Dropdown</span>
																			</button>
																			<ul class="dropdown-menu" style="right: 0;float: right;">
																				'.$grua['informe_activaciones'].'
																				'.$grua['AlarmasPersonalizadas'].'
																				'.$grua['CarpetaFTP'].'
																			</ul>
																		</div>
																	</td>
																</tr>';
															}
														}

														/************************************************************/
														//Fuera de linea
														if(isset($arrGruas[2][3])){
															foreach ( $arrGruas[2][3] as $categoria=>$grua ) {
																$GPS .= '
																<tr class="odd '.$grua['tr_color'].'">
																	<td width="10">
																		<div class="btn-group" style="width: '.$grua['wid_status'].'px;" >';
																			$GPS .= $grua['eq_ok_icon'];
																			$GPS .= $grua['status_icon'];
																		$GPS .= '</div>
																	</td>
																	<td>
																		'.$grua['Nombre'].'<br/>
																		'.$grua['LastUpdate'].'
																	</td>
																	<td>'.$grua['Voltaje'].'</td>
																	<td>'.$grua['Viento'].'</td>
																	<td width="10">
																		<div class="btn-group" style="width: 175px;" >';
																			$GPS .= $grua['in_sens_activ'];
																			$GPS .= $grua['NAlertas'];
																			$GPS .= $grua['crosscrane_estado'];
																			$GPS .= $grua['CenterMap'];
																			$GPS .= '
																			<button type="button" class="btn btn-danger btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
																				<span class="caret"></span>
																				<span class="sr-only">Toggle Dropdown</span>
																			</button>
																			<ul class="dropdown-menu" style="right: 0;float: right;">
																				'.$grua['informe_activaciones'].'
																				'.$grua['AlarmasPersonalizadas'].'
																				'.$grua['CarpetaFTP'].'
																			</ul>
																		</div>
																	</td>
																</tr>';
															}
														}

														$GPS .= '
													</tbody>
												</table>
											</div>
										</div>
									</div>
									<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
										<div class="row">
											<div id="map_canvas" style="width: 100%; height: 550px;"></div>
										</div>
									</div>
								</div>

							</div>
						</div>

						<div class="tab-pane fade" id="planta">
							<div class="wmd-panel">

								<div class="table-responsive">
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
										<div class="row">
											<div id="vehiPlanta" class="table-wrapper-scroll-y my-custom-scrollbar">
												<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
													<thead>';
														$GPS .= widget_sherlock(1, 5, 'TableFiltered_2');
														$GPS .= '
														<tr role="row">
															<th></th>
															<th>Equipo</th>
															<th>Voltaje (V)</th>
															<th>Viento (km/h)</th>
															<th>Acciones</th>
														</tr>
													</thead>
													<tbody role="alert" aria-live="polite" aria-relevant="all" id="TableFiltered_2">';
														/************************************************************/
														//Con alertas
														if(isset($arrGruas[1][2])){
															foreach ( $arrGruas[1][2] as $categoria=>$grua ) {
																$GPS .= '
																<tr class="odd '.$grua['tr_color'].'">
																	<td width="10">
																		<div class="btn-group" style="width: '.$grua['wid_status'].'px;" >';
																			$GPS .= $grua['eq_ok_icon'];
																			$GPS .= $grua['status_icon'];
																		$GPS .= '</div>
																	</td>
																	<td>
																		'.$grua['Nombre'].'<br/>
																		'.$grua['LastUpdate'].'
																	</td>
																	<td>'.$grua['Voltaje'].'</td>
																	<td>'.$grua['Viento'].'</td>
																	<td width="10">
																		<div class="btn-group" style="width: 175px;" >';
																			$GPS .= $grua['in_sens_activ'];
																			$GPS .= $grua['NAlertas'];
																			$GPS .= $grua['crosscrane_estado'];
																			//$GPS .= $grua['CenterMap'];
																			$GPS .= '
																			<button type="button" class="btn btn-danger btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
																				<span class="caret"></span>
																				<span class="sr-only">Toggle Dropdown</span>
																			</button>
																			<ul class="dropdown-menu" style="right: 0;float: right;">
																				'.$grua['informe_activaciones'].'
																				'.$grua['AlarmasPersonalizadas'].'
																				'.$grua['CarpetaFTP'].'
																			</ul>
																		</div>
																	</td>
																</tr>';
															}
														}

														/************************************************************/
														//Ok
														if(isset($arrGruas[1][1])){
															foreach ( $arrGruas[1][1] as $categoria=>$grua ) {
																$GPS .= '
																<tr class="odd '.$grua['tr_color'].'">
																	<td width="10">
																		<div class="btn-group" style="width: '.$grua['wid_status'].'px;" >';
																			$GPS .= $grua['eq_ok_icon'];
																			$GPS .= $grua['status_icon'];
																		$GPS .= '</div>
																	</td>
																	<td>
																		'.$grua['Nombre'].'<br/>
																		'.$grua['LastUpdate'].'
																	</td>
																	<td>'.$grua['Voltaje'].'</td>
																	<td>'.$grua['Viento'].'</td>
																	<td width="10">
																		<div class="btn-group" style="width: 175px;" >';
																			$GPS .= $grua['in_sens_activ'];
																			$GPS .= $grua['NAlertas'];
																			$GPS .= $grua['crosscrane_estado'];
																			//$GPS .= $grua['CenterMap'];
																			$GPS .= '
																			<button type="button" class="btn btn-danger btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
																				<span class="caret"></span>
																				<span class="sr-only">Toggle Dropdown</span>
																			</button>
																			<ul class="dropdown-menu" style="right: 0;float: right;">
																				'.$grua['informe_activaciones'].'
																				'.$grua['AlarmasPersonalizadas'].'
																				'.$grua['CarpetaFTP'].'
																			</ul>
																		</div>
																	</td>
																</tr>';
															}
														}

														/************************************************************/
														//Fuera de linea
														if(isset($arrGruas[1][3])){
															foreach ( $arrGruas[1][3] as $categoria=>$grua ) {
																$GPS .= '
																<tr class="odd '.$grua['tr_color'].'">
																	<td width="10">
																		<div class="btn-group" style="width: '.$grua['wid_status'].'px;" >';
																			$GPS .= $grua['eq_ok_icon'];
																			$GPS .= $grua['status_icon'];
																		$GPS .= '</div>
																	</td>
																	<td>
																		'.$grua['Nombre'].'<br/>
																		'.$grua['LastUpdate'].'
																	</td>
																	<td>'.$grua['Voltaje'].'</td>
																	<td>'.$grua['Viento'].'</td>
																	<td width="10">
																		<div class="btn-group" style="width: 175px;" >';
																			$GPS .= $grua['in_sens_activ'];
																			$GPS .= $grua['NAlertas'];
																			$GPS .= $grua['crosscrane_estado'];
																			//$GPS .= $grua['CenterMap'];
																			$GPS .= '
																			<button type="button" class="btn btn-danger btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
																				<span class="caret"></span>
																				<span class="sr-only">Toggle Dropdown</span>
																			</button>
																			<ul class="dropdown-menu" style="right: 0;float: right;">
																				'.$grua['informe_activaciones'].'
																				'.$grua['AlarmasPersonalizadas'].'
																				'.$grua['CarpetaFTP'].'
																			</ul>
																		</div>
																	</td>
																</tr>';
															}
														}

														$GPS .= '
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>

							</div>
						</div>

					</div>
				</div>
			</div>
		</div>';

		$GPS .= '
		<style>
			.my-custom-scrollbar {
				position: relative;
				height: 550px;
				overflow: auto;
			}
			.table-wrapper-scroll-y {
				display: block;
			}
		</style>

		<script>
			let map;
			var markers = [];
			//Ubicación de los distintos dispositivos
			var locations = [ ';
				foreach ( $arrEquipo as $data ) {
					//Solo los que estan en obras
					if(isset($data['idUbicacion'])&&$data['idUbicacion']==2){
						//burbuja
						$explanation  = '<div class="iw-subTitle">Equipo: '.$data['Nombre'].'<br/>Identificador: '.$data['Identificador'].'</div>';
						$explanation .= 'Actualizado: '.fecha_estandar($data['LastUpdateFecha']).' - '.$data['LastUpdateHora'].'</p>';
						//verifico si tiene sensores configurados
						if(isset($data['id_Sensores'])&&$data['id_Sensores']==1){
							$explanation .= '<div class="iw-subTitle">Sensores: </div><p>';
							for ($i = 1; $i <= $data['cantSensores']; $i++) {
								//verifico que sensor este activo
								if(isset($data['SensoresActivo_'.$i])&&$data['SensoresActivo_'.$i]==1){
									//Unidad medida
									if(isset($arrFinalUnimed[$data['SensoresUniMed_'.$i]])){
										$unimed = ' '.$arrFinalUnimed[$data['SensoresUniMed_'.$i]];
									}else{
										$unimed = '';
									}
									//cadena
									if(isset($data['SensoresMedActual_'.$i])&&$data['SensoresMedActual_'.$i]<99900){$xdata=Cantidades($data['SensoresMedActual_'.$i], 2).$unimed;}else{$xdata='Sin Datos';}
									$explanation .= $data['SensoresNombre_'.$i].' : '.$xdata.'<br/>';
								}
							}
							$explanation .= '</p>';
						}
						//se arma dato
						$GPS .= "[";
							$GPS .= $data['GeoLatitud'];
							$GPS .= ", ".$data['GeoLongitud'];
							$GPS .= ", '".$explanation."'";
						$GPS .= "], ";
					}
				}
			$GPS .= '];

			async function initMap() {
				const { Map } = await google.maps.importLibrary("maps");

				var myLatlng = new google.maps.LatLng(-33.477271996598965, -70.65170304882815);

				var myOptions = {
					zoom: 12,
					center: myLatlng,
					mapTypeId: google.maps.MapTypeId.ROADMAP
				};

				map = new Map(document.getElementById("map_canvas"), myOptions);

				//ubicacion inicial
				setMarkers(map, locations, 1);
				//actualizacion de posicion
				transMarker(map, '.$SegActual.');

			}

			/* ************************************************************************** */
			function chngZona() {
				idZona = document.getElementById("selectZona").value;
				$(\'#vehiContent\').load(\'principal_update_widget_CrossCrane_ubicacion.php?idZona=\' + idZona);
				setMarkers(map, locations, 1);
			}

			/* ************************************************************************** */
			function fncCenterMap(Latitud, Longitud, n_icon){
				latlon = new google.maps.LatLng(Latitud, Longitud);
				map.panTo(latlon);
				//volver todo a normal
				for (let i = 0; i < markers.length; i++) {
					markers[i].setIcon("'.DB_SITE_REPO.'/LIB_assets/img/map-icons/1_series_orange.png");
				}
				//colorear el seleccionado
				markers[n_icon].setIcon("'.DB_SITE_REPO.'/LIB_assets/img/map-icons/1_series_green.png");
			}

			/* ************************************************************************** */
			function setMarkers(map, locations, optc) {

				var marker, i, last_latitude, last_longitude;

				for (i = 0; i < locations.length; i++) {

					//defino ubicacion y datos
					let latitude   = locations[i][0];
					let longitude  = locations[i][1];
					let data       = locations[i][2];

					//guardo las ultimas ubicaciones
					last_latitude   = locations[i][0];
					last_longitude  = locations[i][1];

					latlngset = new google.maps.LatLng(latitude, longitude);

					//se crea marcador
					var marker = new google.maps.Marker({
						map         : map,
						position    : latlngset,
						icon      	: "'.DB_SITE_REPO.'/LIB_assets/img/map-icons/1_series_orange.png"
					});
					markers.push(marker);

					//se define contenido
					var content = 	"<div id=\'iw-container\'>" +
									"<div class=\'iw-title\'>Datos</div>" +
									"<div class=\'iw-content\'>" +
									data +
									"</div>" +
									"<div class=\'iw-bottom-gradient\'></div>" +
									"</div>";

					//se crea infowindow
					var infowindow = new google.maps.InfoWindow();

					//se agrega funcion de click a infowindow
					google.maps.event.addListener(marker,\'click\', (function(marker,content,infowindow){
						return function() {
							infowindow.setContent(content);
							infowindow.open(map,marker);
						};
					})(marker,content,infowindow));

				}
				if(optc==1){
					latlon = new google.maps.LatLng(last_latitude, last_longitude);
					map.panTo(latlon);
				}
			}
			/* ************************************************************************** */
			function transMarker(map, time) {
				var newTime = time / 2;
				setInterval(function(){transMarkerTimer(map)},newTime);
			}
			/* ************************************************************************** */
			var mapax = 0;
			function transMarkerTimer(map) {

				switch(mapax) {
					//Ejecutar formulario con el recorrido y la ruta
					case 1:
						$(\'#vehiContent\').load(\'principal_update_widget_CrossCrane_ubicacion.php\');
						break;
					//se dibujan los iconos
					case 2:
						//Se ocultan y eliminan los iconos
						deleteMarkers();
						setMarkers(map, new_locations, 2);
						//actualizo la hora de actualizacion
						document.getElementById(\'update_text_HoraRefresco\').innerHTML=\'Hora Refresco: \'+HoraRefresco;

						break;
				}

				mapax++;
				if(mapax==3){mapax=1}
			}
			/* ************************************************************************** */
			// Sets the map on all markers in the array.
			function setMapOnAll(map) {
				for (let i = 0; i < markers.length; i++) {
				markers[i].setMap(map);
				}
			}
			/* ************************************************************************** */
			// Removes the markers from the map, but keeps them in the array.
			function clearMarkers() {
				setMapOnAll(null);
			}
			/* ************************************************************************** */
			// Shows any markers currently in the array.
			function showMarkers() {
				setMapOnAll(map);
			}
			/* ************************************************************************** */
			// Deletes all markers in the array by removing references to them.
			function deleteMarkers() {
				clearMarkers();
				markers = [];
			}

		</script>

		';


		return $GPS;

	}
}
/*******************************************************************************************************************/


?>
