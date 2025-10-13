<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-175).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                            Se ejecutan las instrucciones                                        */
/*******************************************************************************************************************/
	//ejecuto segun la funcion
	switch ($form_trabajo) {
/*******************************************************************************************************************/
		case 'silenciar_uno':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Variables
				$idErrores    = $_GET['idErrores'];
				$idTelemetria = $_GET['idTelemetriaMarc'];
				$idSistema    = $_SESSION['usuario']['basic_data']['idSistema'];

				//Filtros
				$SIS_data = "idLeido='1'";

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'telemetria_listado_errores', 'idErrores = "'.$idErrores.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/******************************************************************/
				//Recuento la cantidad de errores existentes
				$SIS_query = 'COUNT(idErrores) AS NAlertas';
				$SIS_where = "idTelemetria=".$idTelemetria." AND idLeido=0 AND idSistema=".$idSistema;
				//si existe la fecha filtro por ella
				if(isset($_GET['f_inicio'], $_GET['f_termino'])&&$_GET['f_inicio']!=''&&$_GET['f_termino']!=''){
					$SIS_where .= " AND Fecha BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."'";
				}

				$rowCuenta = db_select_data (false, $SIS_query, 'telemetria_listado_errores', '', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/******************************************************************/
				//se actualizan los datos
				$SIS_data = "NAlertas='".$rowCuenta['NAlertas']."'";
				$resultado = db_update_data (false, $SIS_data, 'telemetria_listado', 'idTelemetria = "'.$idTelemetria.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					//redirijo
					header( 'Location: '.$location.'&silenciar_uno=true' );
					die;

				}
			}

		break;
/*******************************************************************************************************************/
		case 'silenciar_todos':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Variables
				$idTelemetria = $_GET['idTelemetria'];
				$idSistema    = $_SESSION['usuario']['basic_data']['idSistema'];

				//Filtros
				$SIS_data = "idLeido='1'";

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'telemetria_listado_errores', 'idLeido = "0" AND idTelemetria="'.$idTelemetria.'" AND idSistema="'.$idSistema.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/*******************************************************/
				//se actualizan los datos
				$SIS_data = "NAlertas='0'";
				$resultado = db_update_data (false, $SIS_data, 'telemetria_listado', 'idTelemetria = "'.$idTelemetria.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					//redirijo
					header( 'Location: '.$location.'&silenciar_todos=true' );
					die;

				}
			}

		break;

/*******************************************************************************************************************/
	}

?>
