<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridReportesad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-125).');
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
		case 'validate':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/******************************************************************/
				//variables
				$idTipo          = $_GET['idTipofil'];
				$idEventoPeligro = $_GET['idEventoPeligro'];
				$idValidado      = 2;
				$idRevisado      = 2;

				/******************************************************************/
				//actualizo el post
				//peligro
				if(isset($idTipo)&&$idTipo==1){
					//Filtros
					$SIS_data = "idPeligro='".$idEventoPeligro."'";
					if(isset($idValidado) && $idValidado!=''){  $SIS_data .= ",idValidado='".$idValidado."'";}
					//se actualizan los datos
					$resultado = db_update_data (false, $SIS_data, 'seg_vecinal_peligros_listado', 'idPeligro = "'.$idEventoPeligro.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//evento
				}elseif(isset($idTipo)&&$idTipo==2){
					//Filtros
					$SIS_data = "idEvento='".$idEventoPeligro."'";
					if(isset($idValidado) && $idValidado!=''){  $SIS_data .= ",idValidado='".$idValidado."'";}
					//se actualizan los datos
					$resultado = db_update_data (false, $SIS_data, 'seg_vecinal_eventos_listado', 'idEvento = "'.$idEventoPeligro.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				}

				/******************************************************************/
				//descarto los reportes
				$SIS_data = "idRevisado='".$idRevisado."'";

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'seg_vecinal_reportes_post_listado', 'idEventoPeligro = "'.$idEventoPeligro.'" AND idTipo = "'.$idTipo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					//redirijo
					header( 'Location: '.$location.'&edited=true' );
					die;

				}
			}

		break;
/*******************************************************************************************************************/
		case 'disabled':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/******************************************************************/
				//variables
				$idTipo          = $_GET['idTipofil'];
				$idEventoPeligro = $_GET['idEventoPeligro'];
				$idCliente       = $_GET['idCreador'];
				$idEstado        = 2;
				$idRevisado      = 2;

				/******************************************************************/
				//desactivo al usuario creador del post
				$SIS_data = "idEstado='".$idEstado."'";

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'seg_vecinal_clientes_listado', 'idCliente = "'.$idCliente.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/******************************************************************/
				//descarto los reportes
				$SIS_data = "idRevisado='".$idRevisado."'";

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'seg_vecinal_reportes_post_listado', 'idEventoPeligro = "'.$idEventoPeligro.'" AND idTipo = "'.$idTipo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado){

					header( 'Location: '.$location.'&edited=true' );
					die;

				}
			}

		break;
/*******************************************************************************************************************/
		case 'banned':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/******************************************************************/
				//variables
				$idTipo          = $_GET['idTipofil'];
				$idEventoPeligro = $_GET['idEventoPeligro'];
				$idCliente       = $_GET['idCreador'];
				$idEstado        = 2;
				$idRevisado      = 2;
				$Fecha           = fecha_actual();
				$Hora            = hora_actual();

				/******************************************************************/
				//desactivo al usuario creador del post
				$SIS_data = "idEstado='".$idEstado."'";

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'seg_vecinal_clientes_listado', 'idCliente = "'.$idCliente.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/****************************************/
				// Se trae un listado con todas las ip
				$SIS_query = 'seg_vecinal_clientes_listado_ip.IP_Client, seg_vecinal_clientes_listado.Nombre AS Vecino';
				$SIS_join  = 'LEFT JOIN `seg_vecinal_clientes_listado` ON seg_vecinal_clientes_listado.idCliente = seg_vecinal_clientes_listado_ip.idCliente';
				$SIS_where = 'seg_vecinal_clientes_listado_ip.idCliente='.$idCliente;
				$SIS_order = 0;
				$arrIPClient = array();
				$arrIPClient = db_select_array (false, $SIS_query, 'seg_vecinal_clientes_listado_ip', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				/****************************************/
				//baneo todas las ip relacionadas
				foreach ($arrIPClient as $ipc) {
					//busca si la ip del usuario ya existe
					$n_ip = db_select_nrows (false, 'idBloqueo', 'sistema_seguridad_bloqueo_ip', '', "IP_Client='".$ipc['IP_Client']."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//si la ip no existe la guarda
					if(isset($n_ip)&&$n_ip==0){

						//Variables
						$Motivo = 'Baneo del usuario '.$ipc['Vecino'];

						//filtros
						if(isset($Fecha) && $Fecha!=''){                        $SIS_data  = "'".$Fecha."'";              }else{$SIS_data  ="''";}
						if(isset($Hora) && $Hora!=''){                          $SIS_data .= ",'".$Hora."'";              }else{$SIS_data .=",''";}
						if(isset($ipc['IP_Client']) && $ipc['IP_Client']!=''){  $SIS_data .= ",'".$ipc['IP_Client']."'";  }else{$SIS_data .=",''";}
						if(isset($Motivo) && $Motivo!=''){                      $SIS_data .= ",'".$Motivo."'";            }else{$SIS_data .=",''";}

						// inserto los datos de registro en la db
						$SIS_columns = 'Fecha,Hora, IP_Client, Motivo';
						$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'sistema_seguridad_bloqueo_ip', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					}
				}

				/******************************************************************/
				//descarto los reportes
				$SIS_data = "idRevisado='".$idRevisado."'";

				/*******************************************************/
				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'seg_vecinal_reportes_post_listado', 'idEventoPeligro = "'.$idEventoPeligro.'" AND idTipo = "'.$idTipo.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado){

					header( 'Location: '.$location.'&edited=true' );
					die;

				}
			}

		break;
/*******************************************************************************************************************/
	}

?>
