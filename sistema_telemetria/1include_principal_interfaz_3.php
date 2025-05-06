<?php
/*****************************************************************************************************************/
/*                                               Transacciones                                                   */
/*****************************************************************************************************************/
//variable de numero de permiso
$x_nperm = 0;

//permisos a las transacciones
$x_nperm++; $trans[$x_nperm] = "informe_gerencial_01.php";                        //01 - Informe del estado de la bodega de insumos
$x_nperm++; $trans[$x_nperm] = "informe_bodega_productos_04.php";                 //02 - Bodega de Productos
$x_nperm++; $trans[$x_nperm] = "informe_bodega_insumos_04.php";                   //03 - Bodega de Insumos
$x_nperm++; $trans[$x_nperm] = "informe_bodega_arriendos_04.php";                 //04 - Bodega de Arriendos
$x_nperm++; $trans[$x_nperm] = "informe_bodega_servicios_04.php";                 //05 - Bodega de Servicios

$x_nperm++; $trans[$x_nperm] = "analisis_listado.php";                            //06 - Ingreso analisis maquinas

$x_nperm++; $trans[$x_nperm] = "telemetria_gestion_flota.php";                    //07 - Acceso a la transaccion de administracion de gestion de flota (vehiculos)
$x_nperm++; $trans[$x_nperm] = "telemetria_gestion_sensores.php";                 //08 - Acceso a la transaccion de administracion de gestion sensores (colegios)
$x_nperm++; $trans[$x_nperm] = "telemetria_gestion_equipos.php";                  //09 - Acceso a la transaccion de administracion de gestion de equipos (todos los sensores)

$x_nperm++; $trans[$x_nperm] = "orden_trabajo_crear.php";                         //10 - Creacion de OT
$x_nperm++; $trans[$x_nperm] = "orden_trabajo_terminar.php";                      //11 - Cierre de OT

$x_nperm++; $trans[$x_nperm] = "telemetria_carga_bam.php";                        //12 - Calendario con las cargas por vencer en la semana
$x_nperm++; $trans[$x_nperm] = "ocompra_generacion.php";                          //13 - Creacion de OC basadas en solicitudes
$x_nperm++; $trans[$x_nperm] = "ocompra_listado_sin_aprobar.php";                 //14 - Mostrar las OC sin aprobar

$x_nperm++; $trans[$x_nperm] = "bodegas_arriendos_ingreso.php";                   //15 - Mostrar las facturas (Compra) de arriendo por vencer
$x_nperm++; $trans[$x_nperm] = "bodegas_insumos_ingreso.php";                     //16 - Mostrar las facturas (Compra) de insumos por vencer
$x_nperm++; $trans[$x_nperm] = "bodegas_productos_ingreso.php";                   //17 - Mostrar las facturas (Compra) de productos por vencer
$x_nperm++; $trans[$x_nperm] = "bodegas_servicios_ingreso.php";                   //18 - Mostrar las facturas (Compra) de servicios por vencer

$x_nperm++; $trans[$x_nperm] = "bodegas_arriendos_egreso.php";                    //19 - Mostrar las facturas (Venta) de arriendo por vencer
$x_nperm++; $trans[$x_nperm] = "bodegas_productos_egreso.php";                    //20 - Mostrar las facturas (Venta) de productos por vencer
$x_nperm++; $trans[$x_nperm] = "bodegas_servicios_egreso.php";                    //21 - Mostrar las facturas (Venta) de servicios por vencer
$x_nperm++; $trans[$x_nperm] = "bodegas_insumos_ventas.php";                      //22 - Mostrar las facturas (Venta) de insumos por vencer

$x_nperm++; $trans[$x_nperm] = "informe_gerencial_04.php";                        //23 - Mostrar los cheques (Compra) por vencer general
$x_nperm++; $trans[$x_nperm] = "informe_gerencial_06.php";                        //24 - Mostrar los cheques (Compra) por vencer por semana

$x_nperm++; $trans[$x_nperm] = "informe_gerencial_07.php";                        //25 - Mostrar los cheques (Venta) por vencer general
$x_nperm++; $trans[$x_nperm] = "informe_gerencial_08.php";                        //26 - Mostrar los cheques (Venta) por vencer por semana

$x_nperm++; $trans[$x_nperm] = "caja_chica_listado.php";                          //27 - Creacion de nuevas cajas chicas
$x_nperm++; $trans[$x_nperm] = "caja_chica_ingreso.php";                          //28 - Ingreso de montos a las cajas chicas
$x_nperm++; $trans[$x_nperm] = "caja_chica_egreso.php";                           //29 - Egresos de montos de la caja chica
$x_nperm++; $trans[$x_nperm] = "caja_chica_rendicion.php";                        //30 - Ingreso de rendiciones de la caja chica
$x_nperm++; $trans[$x_nperm] = "caja_chica_rendida.php";                          //31 - Ingreso de cajas chicas ya rendidas

$x_nperm++; $trans[$x_nperm] = "cross_shipping_consolidacion.php";                //32 - Ingreso de consolidaciones de carga
$x_nperm++; $trans[$x_nperm] = "cross_shipping_consolidacion_anuladas.php";       //33 - Visualizacion de las consolidaciones anuladas
$x_nperm++; $trans[$x_nperm] = "cross_shipping_consolidacion_aprobadas.php";      //34 - Visualizacion de las consolidaciones aprobadas
$x_nperm++; $trans[$x_nperm] = "cross_shipping_consolidacion_aprobar.php";        //35 - Visualizacion de las consolidaciones en espera de aprobacion
$x_nperm++; $trans[$x_nperm] = "cross_shipping_consolidacion_aprobar_auto.php";   //36 - Visualizacion de las consolidaciones en espera de aprobacion
$x_nperm++; $trans[$x_nperm] = "cross_shipping_consolidacion_rechazadas.php";     //37 - Visualizacion de las consolidaciones rechazadas

$x_nperm++; $trans[$x_nperm] = "cross_solicitud_aplicacion_crear.php";            //38 - Ingreso de solicitudes de aplicacion
$x_nperm++; $trans[$x_nperm] = "cross_solicitud_aplicacion_ejecucion.php";        //39 - ejecucion de solicitudes de aplicacion
$x_nperm++; $trans[$x_nperm] = "cross_solicitud_aplicacion_ejecutar.php";         //40 - ejecutar de solicitudes de aplicacion
$x_nperm++; $trans[$x_nperm] = "cross_solicitud_aplicacion_terminar.php";         //41 - terminar de solicitudes de aplicacion

$x_nperm++; $trans[$x_nperm] = "vehiculos_facturacion_apoderados_listado.php";    //42 - Facturacion Planes Apoderados - furgones
$x_nperm++; $trans[$x_nperm] = "vehiculos_pagos_apoderados.php";                  //43 - Pago Facturacion Planes Apoderados - furgones

$x_nperm++; $trans[$x_nperm] = "orden_trabajo_motivo_cambiar_estado.php";         //44 - Orden de Trabajo - Cambiar Estado
$x_nperm++; $trans[$x_nperm] = "orden_trabajo_motivo_canceladas.php";             //45 - Orden de Trabajo - Canceladas
$x_nperm++; $trans[$x_nperm] = "orden_trabajo_motivo_crear.php";                  //46 - Orden de Trabajo - Crear
$x_nperm++; $trans[$x_nperm] = "orden_trabajo_motivo_ejecutar.php";               //47 - Orden de Trabajo - Ejecutar
$x_nperm++; $trans[$x_nperm] = "orden_trabajo_motivo_finalizadas.php";            //48 - Orden de Trabajo - Finalizadas
$x_nperm++; $trans[$x_nperm] = "orden_trabajo_motivo_terminar.php";               //49 - Orden de Trabajo - Forzar Cierre

$x_nperm++; $trans[$x_nperm] = "gestion_reserva_oficinas.php";                    //50 - Reserva de oficina

$x_nperm++; $trans[$x_nperm] = "gestion_tickets.php";                             //51 - Creacion de tickets
$x_nperm++; $trans[$x_nperm] = "gestion_tickets_cancelar.php";                    //52 - Cancelacion de tickets
$x_nperm++; $trans[$x_nperm] = "gestion_tickets_cerrar.php";                      //53 - Ejecucion de tickets

$x_nperm++; $trans[$x_nperm] = "clientes_contab_previred.php";                    //54 - Facturacion de previred

//Genero los permisos
for ($i = 1; $i <= $x_nperm; $i++) {
	//Seteo la variable a 0
	$prm_x[$i] = 0;
	//recorro los permisos
	if(isset($_SESSION['usuario']['menu'])){
		foreach($_SESSION['usuario']['menu'] as $menu=>$productos) {
			foreach($productos as $producto) {
				//elimino los datos extras
				$str = str_replace("?pagina=1", "", $producto['TransaccionURL']);
				//le asigno el valor 1 en caso de que exista
				if($trans[$i]==$str){
					$prm_x[$i] = 1;
				}
			}
		}
	}
}

/*****************************************************************************************************************/
/*                                                Consultas                                                      */
/*****************************************************************************************************************/
//Se ven las mantenciones programadas
$SIS_query = 'Fecha, Descripcion, Hora_ini, Hora_fin';
$SIS_join  = '';
$SIS_where = 'idMantencion!=0 ORDER BY idMantencion DESC';
$Mantenciones = db_select_data (false, $SIS_query, 'core_mantenciones', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'Mantenciones');

/************************************************************************************/
//consultas anidadas, se utiliza las variables anteriores para consultar cada permiso
$SIS_query = 'idOpcionesTel,idOpcionesGen_1, idOpcionesGen_2, idOpcionesGen_4, idOpcionesGen_6, idOpcionesGen_9';
$SIS_join  = '';
$SIS_where = 'idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
$n_permisos = db_select_data (false, $SIS_query, 'core_sistemas',$SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'n_permisos');

/*****************************************************************************************************************/
/*                                                Subconsultas                                                   */
/*****************************************************************************************************************/
//Variables
$subquery       = '';
$idTipoUsuario  = $_SESSION['usuario']['basic_data']['idTipoUsuario'];

//Filtro
$SIS_where_1  = " WHERE idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
$SIS_where_2  = " WHERE idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
$SIS_where_3  = " idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
//Verifico el tipo de usuario que esta ingresando
if($idTipoUsuario==1){
	$SIS_where_1.= " AND idUsuario>=0";
	$SIS_where_4 = "idUsuario>=0";
}else{
	$SIS_where_1.= " AND idUsuario=".$_SESSION['usuario']['basic_data']['idUsuario'];
	$SIS_where_4 = "idUsuario = ".$_SESSION['usuario']['basic_data']['idUsuario'];
}
/****************************************/
//Visualizacion de los widgets Comunes, se verifica si esta activado o si es un superusuario
if($n_permisos['idOpcionesGen_1']=='1' OR $idTipoUsuario==1){
	$subquery .= ",(SELECT COUNT(idNoti) FROM principal_notificaciones_ver  ".$SIS_where_1." AND idEstado='1' LIMIT 1) AS Notificacion";
	$subquery .= ",(SELECT COUNT(idAgenda) FROM principal_agenda_telefonica ".$SIS_where_2." AND idUsuario = '".$_SESSION['usuario']['basic_data']['idUsuario']."' OR idUsuario=9999 LIMIT 1) AS CuentaContactos";
	$subquery .= ",(SELECT COUNT(idSoftware) FROM soporte_software_listado LIMIT 1) AS CuentaProgramas";
	$subquery .= ",(SELECT COUNT(idCalendario) FROM principal_calendario_listado ".$SIS_where_2." AND Mes=".mes_actual()." AND Ano=".ano_actual()." LIMIT 1) AS CuentaEventos";
}
/****************************************/
//Visualizacion de los widgets de las transacciones
if($n_permisos['idOpcionesGen_2']=='1' OR $idTipoUsuario==1){

	/***************************************** PRIMERA COLUMNA *****************************************/
	/*** Cargas por Vencer ***/
	if($prm_x[12]=='1' OR $idTipoUsuario==1){$subquery .= ",(SELECT COUNT(idCarga) FROM telemetria_carga_bam ".$SIS_where_2." AND Semana=".semana_actual()." AND Ano=".ano_actual()." LIMIT 1) AS CuentaRecargas";}

	/*** Solicitudes sin OC ***/
	if($prm_x[13]=='1' OR $idTipoUsuario==1){
		$subquery .= ",(SELECT COUNT(idExistencia) FROM solicitud_listado_existencias_productos ".$SIS_where_2." AND idOcompra=0 LIMIT 1) AS CuentaSolProd";
		$subquery .= ",(SELECT COUNT(idExistencia) FROM solicitud_listado_existencias_insumos ".$SIS_where_2." AND idOcompra=0 LIMIT 1) AS CuentaSolIns";
		$subquery .= ",(SELECT COUNT(idExistencia) FROM solicitud_listado_existencias_arriendos ".$SIS_where_2." AND idOcompra=0 LIMIT 1) AS CuentaSolArr";
		$subquery .= ",(SELECT COUNT(idExistencia) FROM solicitud_listado_existencias_servicios ".$SIS_where_2." AND idOcompra=0 LIMIT 1) AS CuentaSolServ";
		$subquery .= ",(SELECT COUNT(idExistencia) FROM solicitud_listado_existencias_otros ".$SIS_where_2." AND idOcompra=0 LIMIT 1) AS CuentaSolOtro";
	}

	/*** OC sin Aprobar ***/
	if($prm_x[14]=='1' OR $idTipoUsuario==1){$subquery .= ",(SELECT COUNT(idOcompra) FROM ocompra_listado ".$SIS_where_2." AND idEstado=1 LIMIT 1) AS CuentaOC";}

	/*** OT Maquinas para la Semana ***/
	$OT_Semana = $prm_x[10] + $prm_x[11];
	if($OT_Semana!=0 OR $idTipoUsuario==1) {
		$subquery .= ",(SELECT COUNT(idOT) FROM orden_trabajo_listado WHERE  ".$SIS_where_3." AND progSemana=".semana_actual()."   AND progAno=".ano_actual()." AND idEstado=1  LIMIT 1 ) AS CountOTSemana";
	}

	/*** OT Maquinas no Cumplidas ***/
	$OT_Semana = $prm_x[10] + $prm_x[11];
	if($OT_Semana!=0 OR $idTipoUsuario==1) {
		$subquery .= ",(SELECT COUNT(idOT) FROM orden_trabajo_listado WHERE  ".$SIS_where_3." AND progSemana<".semana_actual()."   AND progAno=".ano_actual()." AND idEstado=1  LIMIT 1 ) AS CountOTRetrasada";
	}

	/*** OT Tareas para la Semana ***/
	$OT_Semana = $prm_x[44] + $prm_x[45] + $prm_x[46] + $prm_x[47] + $prm_x[48] + $prm_x[49];
	if($OT_Semana!=0 OR $idTipoUsuario==1) {
		$subquery .= ",(SELECT COUNT(idOT) FROM orden_trabajo_tareas_listado WHERE  ".$SIS_where_3." AND f_programacion_Semana=".semana_actual()."   AND f_programacion_Ano=".ano_actual()." AND idEstado=1  LIMIT 1 ) AS CountOTSemanaTarea";
	}

	/*** OT Tareas no Cumplidas ***/
	$OT_Semana = $prm_x[44] + $prm_x[45] + $prm_x[46] + $prm_x[47] + $prm_x[48] + $prm_x[49];
	if($OT_Semana!=0 OR $idTipoUsuario==1) {
		$subquery .= ",(SELECT COUNT(idOT) FROM orden_trabajo_tareas_listado WHERE  ".$SIS_where_3." AND f_programacion_Semana<".semana_actual()."   AND f_programacion_Ano=".ano_actual()." AND idEstado=1  LIMIT 1 ) AS CountOTRetrasadaTarea";
	}

	/*** OT Tareas no Cumplidas ***/
	$Tickets_temp = $prm_x[51] + $prm_x[52] + $prm_x[53];
	if($Tickets_temp!=0 OR $idTipoUsuario==1) {
		$subquery .= ",(SELECT COUNT(gestion_tickets.idTicket)
		FROM gestion_tickets
		LEFT JOIN `gestion_tickets_area_correos` ON gestion_tickets_area_correos.idArea = gestion_tickets.idArea
		WHERE gestion_tickets_area_correos.idUsuario=".$_SESSION['usuario']['basic_data']['idUsuario']."
		AND gestion_tickets.idEstado=1
		AND gestion_tickets.idTipoTicket=1
		AND gestion_tickets.idSistema=".$_SESSION['usuario']['basic_data']['idSistema']."
		) AS CountTickets";
	}

	/*** Previred Pendientes ***/
	$Previred = $prm_x[54];
	if($Previred!=0 OR $idTipoUsuario==1) {
		$subquery .= ",(SELECT COUNT(idContabPrevired) FROM contabilidad_clientes_previred WHERE  ".$SIS_where_3." AND idEstado=1  LIMIT 1 ) AS CountPreviredPendiente";
	}

	/***************************************** SEGUNDA COLUMNA *****************************************/
	/*************** Compras ***************/
	/*** Facturas atrasadas ***/
	$PermFactComp = $prm_x[15] + $prm_x[16] + $prm_x[17] + $prm_x[18];
	if($PermFactComp!=0 OR $idTipoUsuario==1) {
		$subquery .= ",(SELECT COUNT(idFacturacion) FROM bodegas_arriendos_facturacion    INNER JOIN usuarios_bodegas_arriendos ON usuarios_bodegas_arriendos.idBodega = bodegas_arriendos_facturacion.idBodega           WHERE bodegas_arriendos_facturacion.idEstado=1  AND bodegas_arriendos_facturacion.idTipo=1   AND bodegas_arriendos_facturacion.".$SIS_where_3."   AND bodegas_arriendos_facturacion.Pago_Semana<".semana_actual()."   AND bodegas_arriendos_facturacion.Pago_ano=".ano_actual()."  AND usuarios_bodegas_arriendos.".$SIS_where_4." LIMIT 1) AS CountFactArriendo_retr";
		$subquery .= ",(SELECT COUNT(idFacturacion) FROM bodegas_insumos_facturacion      INNER JOIN usuarios_bodegas_insumos ON usuarios_bodegas_insumos.idBodega = bodegas_insumos_facturacion.idBodegaDestino          WHERE bodegas_insumos_facturacion.idEstado=1    AND bodegas_insumos_facturacion.idTipo=1     AND bodegas_insumos_facturacion.".$SIS_where_3."     AND bodegas_insumos_facturacion.Pago_Semana<".semana_actual()."     AND bodegas_insumos_facturacion.Pago_ano=".ano_actual()."    AND usuarios_bodegas_insumos.".$SIS_where_4." LIMIT 1) AS CountFactInsumo_retr";
		$subquery .= ",(SELECT COUNT(idFacturacion) FROM bodegas_productos_facturacion    INNER JOIN usuarios_bodegas_productos ON usuarios_bodegas_productos.idBodega = bodegas_productos_facturacion.idBodegaDestino    WHERE bodegas_productos_facturacion.idEstado=1  AND bodegas_productos_facturacion.idTipo=1   AND bodegas_productos_facturacion.".$SIS_where_3."   AND bodegas_productos_facturacion.Pago_Semana<".semana_actual()."   AND bodegas_productos_facturacion.Pago_ano=".ano_actual()."  AND usuarios_bodegas_productos.".$SIS_where_4." LIMIT 1) AS CountFactProducto_retr";
		$subquery .= ",(SELECT COUNT(idFacturacion) FROM bodegas_servicios_facturacion WHERE bodegas_servicios_facturacion.idEstado=1  AND bodegas_servicios_facturacion.idTipo=1   AND bodegas_servicios_facturacion.".$SIS_where_3." AND bodegas_servicios_facturacion.Pago_Semana<".semana_actual()." AND bodegas_servicios_facturacion.Pago_ano=".ano_actual()." LIMIT 1) AS CountFactServicio_retr";
	}

	/*** Facturas x pagar ***/
	$PermFactComp = $prm_x[15] + $prm_x[16] + $prm_x[17] + $prm_x[18];
	if($PermFactComp!=0 OR $idTipoUsuario==1) {
		$subquery .= ",(SELECT COUNT(idFacturacion) FROM bodegas_arriendos_facturacion    INNER JOIN usuarios_bodegas_arriendos ON usuarios_bodegas_arriendos.idBodega = bodegas_arriendos_facturacion.idBodega           WHERE bodegas_arriendos_facturacion.idEstado=1  AND bodegas_arriendos_facturacion.idTipo=1   AND bodegas_arriendos_facturacion.".$SIS_where_3."   AND bodegas_arriendos_facturacion.Pago_Semana=".semana_actual()."   AND bodegas_arriendos_facturacion.Pago_ano=".ano_actual()."  AND usuarios_bodegas_arriendos.".$SIS_where_4." LIMIT 1) AS CountFactArriendo";
		$subquery .= ",(SELECT COUNT(idFacturacion) FROM bodegas_insumos_facturacion      INNER JOIN usuarios_bodegas_insumos ON usuarios_bodegas_insumos.idBodega = bodegas_insumos_facturacion.idBodegaDestino          WHERE bodegas_insumos_facturacion.idEstado=1    AND bodegas_insumos_facturacion.idTipo=1     AND bodegas_insumos_facturacion.".$SIS_where_3."     AND bodegas_insumos_facturacion.Pago_Semana=".semana_actual()."     AND bodegas_insumos_facturacion.Pago_ano=".ano_actual()."    AND usuarios_bodegas_insumos.".$SIS_where_4." LIMIT 1) AS CountFactInsumo";
		$subquery .= ",(SELECT COUNT(idFacturacion) FROM bodegas_productos_facturacion    INNER JOIN usuarios_bodegas_productos ON usuarios_bodegas_productos.idBodega = bodegas_productos_facturacion.idBodegaDestino    WHERE bodegas_productos_facturacion.idEstado=1  AND bodegas_productos_facturacion.idTipo=1   AND bodegas_productos_facturacion.".$SIS_where_3."   AND bodegas_productos_facturacion.Pago_Semana=".semana_actual()."   AND bodegas_productos_facturacion.Pago_ano=".ano_actual()."  AND usuarios_bodegas_productos.".$SIS_where_4." LIMIT 1) AS CountFactProducto";
		$subquery .= ",(SELECT COUNT(idFacturacion) FROM bodegas_servicios_facturacion WHERE bodegas_servicios_facturacion.idEstado=1  AND bodegas_servicios_facturacion.idTipo=1   AND bodegas_servicios_facturacion.".$SIS_where_3." AND bodegas_servicios_facturacion.Pago_Semana=".semana_actual()." AND bodegas_servicios_facturacion.Pago_ano=".ano_actual()." LIMIT 1) AS CountFactServicio";
	}

	/*** Devolucion Arriendos ***/
	if($prm_x[15]=='1' OR $idTipoUsuario==1){$subquery .= ",(SELECT COUNT(idFacturacion) FROM bodegas_arriendos_facturacion    INNER JOIN usuarios_bodegas_arriendos ON usuarios_bodegas_arriendos.idBodega = bodegas_arriendos_facturacion.idBodega           WHERE bodegas_arriendos_facturacion.idTipo=1 AND bodegas_arriendos_facturacion.idEstadoDevolucion=1   AND bodegas_arriendos_facturacion.".$SIS_where_3."   AND bodegas_arriendos_facturacion.Devolucion_Semana=".semana_actual()."   AND bodegas_arriendos_facturacion.Devolucion_ano=".ano_actual()."  AND usuarios_bodegas_arriendos.".$SIS_where_4." LIMIT 1) AS CountArriendoIn";}

	/*** Documentos x Pagar ***/
	$PermChequesPagar = $prm_x[23] + $prm_x[24];
	if($PermChequesPagar!=0 OR $idTipoUsuario==1) {
		$subquery .= ",(SELECT COUNT(idPago) FROM pagos_facturas_proveedores    INNER JOIN usuarios_documentos_pago ON usuarios_documentos_pago.idDocPago = pagos_facturas_proveedores.idDocPago           WHERE  pagos_facturas_proveedores.".$SIS_where_3."   AND pagos_facturas_proveedores.F_Pago_Semana=".semana_actual()."   AND pagos_facturas_proveedores.F_Pago_ano=".ano_actual()."  AND pagos_facturas_proveedores.".$SIS_where_4." LIMIT 1) AS CountChequePago";
	}

	/*************** Ventas ***************/
	/*** Facturas x Cobrar ***/
	$PermFactComp = $prm_x[19] + $prm_x[20] + $prm_x[21] + $prm_x[22];
	if($PermFactComp!=0 OR $idTipoUsuario==1) {
		$subquery .= ",(SELECT COUNT(idFacturacion) FROM bodegas_arriendos_facturacion    INNER JOIN usuarios_bodegas_arriendos ON usuarios_bodegas_arriendos.idBodega = bodegas_arriendos_facturacion.idBodega           WHERE bodegas_arriendos_facturacion.idEstado=1  AND bodegas_arriendos_facturacion.idTipo=2   AND bodegas_arriendos_facturacion.".$SIS_where_3."   AND bodegas_arriendos_facturacion.Pago_Semana=".semana_actual()."   AND bodegas_arriendos_facturacion.Pago_ano=".ano_actual()."  AND usuarios_bodegas_arriendos.".$SIS_where_4." LIMIT 1) AS CountFactArriendoVent";
		$subquery .= ",(SELECT COUNT(idFacturacion) FROM bodegas_insumos_facturacion      INNER JOIN usuarios_bodegas_insumos   ON usuarios_bodegas_insumos.idBodega = bodegas_insumos_facturacion.idBodegaDestino        WHERE bodegas_insumos_facturacion.idEstado=1    AND bodegas_insumos_facturacion.idTipo=2     AND bodegas_insumos_facturacion.".$SIS_where_3."     AND bodegas_insumos_facturacion.Pago_Semana=".semana_actual()."     AND bodegas_insumos_facturacion.Pago_ano=".ano_actual()."    AND usuarios_bodegas_insumos.".$SIS_where_4." LIMIT 1) AS CountFactInsumoVent";
		$subquery .= ",(SELECT COUNT(idFacturacion) FROM bodegas_productos_facturacion    INNER JOIN usuarios_bodegas_productos ON usuarios_bodegas_productos.idBodega = bodegas_productos_facturacion.idBodegaDestino    WHERE bodegas_productos_facturacion.idEstado=1  AND bodegas_productos_facturacion.idTipo=2   AND bodegas_productos_facturacion.".$SIS_where_3."   AND bodegas_productos_facturacion.Pago_Semana=".semana_actual()."   AND bodegas_productos_facturacion.Pago_ano=".ano_actual()."  AND usuarios_bodegas_productos.".$SIS_where_4." LIMIT 1) AS CountFactProductoVent";
		$subquery .= ",(SELECT COUNT(idFacturacion) FROM bodegas_servicios_facturacion WHERE bodegas_servicios_facturacion.idEstado=1  AND bodegas_servicios_facturacion.idTipo=2   AND bodegas_servicios_facturacion.".$SIS_where_3." AND bodegas_servicios_facturacion.Pago_Semana=".semana_actual()." AND bodegas_servicios_facturacion.Pago_ano=".ano_actual()." LIMIT 1) AS CountFactServicioVent";

	}

	/*** Devolucion Arriendos ***/
	if($prm_x[19]=='1' OR $idTipoUsuario==1){$subquery .= ",(SELECT COUNT(idFacturacion) FROM bodegas_arriendos_facturacion    INNER JOIN usuarios_bodegas_arriendos ON usuarios_bodegas_arriendos.idBodega = bodegas_arriendos_facturacion.idBodega           WHERE bodegas_arriendos_facturacion.idTipo=2 AND bodegas_arriendos_facturacion.idEstadoDevolucion=1   AND bodegas_arriendos_facturacion.".$SIS_where_3."   AND bodegas_arriendos_facturacion.Devolucion_Semana=".semana_actual()."   AND bodegas_arriendos_facturacion.Devolucion_ano=".ano_actual()."  AND usuarios_bodegas_arriendos.".$SIS_where_4." LIMIT 1) AS CountArriendoOut";}

	/*** Documentos x Cobrar ***/
	$PermChequesCobrar = $prm_x[25] + $prm_x[26];
	if($PermChequesCobrar!=0 OR $idTipoUsuario==1) {
		$subquery .= ",(SELECT COUNT(idPago) FROM pagos_facturas_clientes    INNER JOIN usuarios_documentos_pago ON usuarios_documentos_pago.idDocPago = pagos_facturas_clientes.idDocPago           WHERE  pagos_facturas_clientes.".$SIS_where_3."   AND pagos_facturas_clientes.F_Pago_Semana=".semana_actual()."   AND pagos_facturas_clientes.F_Pago_ano=".ano_actual()."  AND pagos_facturas_clientes.".$SIS_where_4." LIMIT 1) AS CountChequeCobro";
	}

	/***************************************** TERCERA COLUMNA *****************************************/
	/*** Analisis Maquinas ***/
	$PermAnalisis = $prm_x[6];
	if($PermAnalisis!=0 OR $idTipoUsuario==1) {
		$subquery .= ",(SELECT COUNT(idAnalisisAlertas) FROM analisis_listado_alertas WHERE  nivel=1 AND Creacion_mes=".mes_actual()."   AND Creacion_ano=".ano_actual()."  LIMIT 1 ) AS CountAlertaNivel_1";
		$subquery .= ",(SELECT COUNT(idAnalisisAlertas) FROM analisis_listado_alertas WHERE  nivel=2 AND Creacion_mes=".mes_actual()."   AND Creacion_ano=".ano_actual()."  LIMIT 1 ) AS CountAlertaNivel_2";
		$subquery .= ",(SELECT COUNT(idAnalisisAlertas) FROM analisis_listado_alertas WHERE  nivel=3 AND Creacion_mes=".mes_actual()."   AND Creacion_ano=".ano_actual()."  LIMIT 1 ) AS CountAlertaNivel_3";
	}

}

/************************************************************************************/
//consultas anidadas, se utiliza las variables anteriores para consultar cada permiso
$SIS_query = 'core_ubicacion_ciudad.Nombre AS Ciudad,
core_ubicacion_comunas.Nombre AS Comuna,
core_ubicacion_comunas.Wheater AS Wheater'.$subquery;
$SIS_join  = '
LEFT JOIN core_ubicacion_ciudad    ON core_ubicacion_ciudad.idCiudad    = core_sistemas.idCiudad
LEFT JOIN core_ubicacion_comunas   ON core_ubicacion_comunas.idComuna   = core_sistemas.idComuna';
$SIS_where = 'core_sistemas.idSistema='.$_SESSION['usuario']['basic_data']['idSistema'];
$subconsulta = db_select_data (false, $SIS_query, 'core_sistemas',$SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'subconsulta');

/*****************************************************************************************************************/
/*                                                Modelado                                                       */
/*****************************************************************************************************************/

?>

<div class="row">

	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="cover profile">
			<?php include '1include_principal_interfaz_3_portada.php'; ?>
		</div>
		<div class="box profile_content" style="margin-top:0px;">
			<?php include '1include_principal_interfaz_3_menu.php'; ?>

			<div class="tab-content">

				<?php
				//contenido en tabs
				include '1include_principal_interfaz_tab_1.php';
				include '1include_principal_interfaz_tab_2.php';
				include '1include_principal_interfaz_tab_3.php';
				include '1include_principal_interfaz_tab_4.php';
				include '1include_principal_interfaz_tab_5.php';
				include '1include_principal_interfaz_tab_6.php';
				include '1include_principal_interfaz_tab_7.php';
				include '1include_principal_interfaz_tab_8.php';
				include '1include_principal_interfaz_tab_9.php';

				include '1include_principal_interfaz_tab_99.php';
				?>

			</div>
		</div>
	</div>

</div>
