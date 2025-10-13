<?php
/**************************************************************************/
$temp = $prm_x[1] + $prm_x[2] + $prm_x[3] + $prm_x[4] + $prm_x[5];
if($temp!=0){
	echo '	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
			<script type="text/javascript">';
		echo "google.charts.load('current', {'packages':['bar', 'table']});";
		echo '</script>';

	echo '<div class="tab-pane fade" id="Menu_tab_3">';
		echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';

			//Si es gerente puede ver todas las bodegas
			if($prm_x[1]=='1' OR $idTipoUsuario==1) {

				//Bodega de Productos
				echo widget_bodega('Bodega de Productos',
								   'bodegas_productos_listado', 'bodegas_productos_facturacion_existencias', 'bodegas_productos_facturacion_tipo',
								   'productos_listado', 'sistema_productos_uml', 'tipo1,tipo2,tipo3,tipo4,tipo5,tipo6,tipo7,tipo8,tipo9',1,
								   $trans[1],$dbConn, 'usuarios_bodegas_productos', $_SESSION['usuario']['basic_data']['idSistema']);

				//Bodega de Insumos
				echo widget_bodega('Bodega de Insumos',
								   'bodegas_insumos_listado', 'bodegas_insumos_facturacion_existencias', 'bodegas_insumos_facturacion_tipo',
								   'insumos_listado', 'sistema_productos_uml', 'tipo1,tipo2,tipo3,tipo4,tipo6,tipo7,tipo8,tipo9',2,
								   $trans[1],$dbConn, 'usuarios_bodegas_insumos', $_SESSION['usuario']['basic_data']['idSistema']);

				//Bodega de Arriendos
				echo widget_bodega('Bodega de Arriendos',
									'bodegas_arriendos_listado', 'bodegas_arriendos_facturacion_existencias', 'bodegas_arriendos_facturacion_tipo',
									'equipos_arriendo_listado', 0, 'tipo1,tipo2',3,
									$trans[1],$dbConn, 'usuarios_bodegas_arriendos', $_SESSION['usuario']['basic_data']['idSistema']);

			//Si no es gerente solo puede ver las que tengasn permisos
			}else{
				//Bodega de Productos
				if($prm_x[2]=='1' OR $idTipoUsuario==1) {
					echo widget_bodega('Bodega de Productos',
										'bodegas_productos_listado', 'bodegas_productos_facturacion_existencias', 'bodegas_productos_facturacion_tipo',
										'productos_listado', 'sistema_productos_uml', 'tipo1,tipo2,tipo3,tipo4,tipo5,tipo6,tipo7,tipo8,tipo9',1,
										$trans[2],$dbConn, 'usuarios_bodegas_productos', $_SESSION['usuario']['basic_data']['idSistema']);
				}
				//Bodega de Insumos
				if($prm_x[3]=='1' OR $idTipoUsuario==1) {
					echo widget_bodega('Bodega de Insumos',
										'bodegas_insumos_listado', 'bodegas_insumos_facturacion_existencias', 'bodegas_insumos_facturacion_tipo',
										'insumos_listado', 'sistema_productos_uml', 'tipo1,tipo2,tipo3,tipo4,tipo6,tipo7,tipo8,tipo9',2,
										$trans[3],$dbConn, 'usuarios_bodegas_insumos', $_SESSION['usuario']['basic_data']['idSistema']);
				}
				//Bodega de Arriendos
				if($prm_x[4]=='1' OR $idTipoUsuario==1) {
					echo widget_bodega('Bodega de Arriendos',
										'bodegas_arriendos_listado', 'bodegas_arriendos_facturacion_existencias', 'bodegas_arriendos_facturacion_tipo',
										'equipos_arriendo_listado', 0, 'tipo1,tipo2',3,
										$trans[4],$dbConn, 'usuarios_bodegas_arriendos', $_SESSION['usuario']['basic_data']['idSistema']);
				}
				//Bodega de Servicios
				if($prm_x[5]=='1' OR $idTipoUsuario==1) {

				}
			}
		echo '</div>';
	echo '</div>';
}

?>
