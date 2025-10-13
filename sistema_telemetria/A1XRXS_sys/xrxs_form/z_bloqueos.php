<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-223).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_GET['f_Fecha']))      $Fecha       = $_GET['f_Fecha'];
	if (!empty($_GET['f_usuario']))    $usuario     = $_GET['f_usuario'];
	if (!empty($_GET['f_email']))      $email       = $_GET['f_email'];
	if (!empty($_GET['f_IP_Client']))  $IP_Client   = $_GET['f_IP_Client'];

/*******************************************************************************************************************/
/*                                            Se ejecutan las instrucciones                                        */
/*******************************************************************************************************************/
	//ejecuto segun la funcion
	switch ($form_trabajo) {

/*******************************************************************************************************************/
		case 'del_1':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			$filter = 'idAcceso!=0';
			if(isset($Fecha)&&$Fecha!=''){          $filter .= " AND Fecha = '".$Fecha."'";}
			if(isset($usuario)&&$usuario!=''){      $filter .= " AND usuario = '".$usuario."'";}
			if(isset($email)&&$email!=''){          $filter .= " AND email = '".$email."'";}
			if(isset($IP_Client)&&$IP_Client!=''){  $filter .= " AND IP_Client = '".$IP_Client."'";}

			//Condiciono el borrado
			if($filter!='idAcceso!=0'){
				//se borran los datos
				$resultado = db_delete_data (false, 'alumnos_checkbrute', $filter, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					//redirijo
					header( 'Location: '.$location.'&deleted=true' );
					die;

				}
			}

		break;
/*******************************************************************************************************************/
		case 'del_2':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			$filter = 'idAcceso!=0';
			if(isset($Fecha)&&$Fecha!=''){          $filter .= " AND Fecha = '".$Fecha."'";}
			if(isset($usuario)&&$usuario!=''){      $filter .= " AND usuario = '".$usuario."'";}
			if(isset($email)&&$email!=''){          $filter .= " AND email = '".$email."'";}
			if(isset($IP_Client)&&$IP_Client!=''){  $filter .= " AND IP_Client = '".$IP_Client."'";}

			//Condiciono el borrado
			if($filter!='idAcceso!=0'){
				//se borran los datos
				$resultado = db_delete_data (false, 'clientes_checkbrute', $filter, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					//redirijo
					header( 'Location: '.$location.'&deleted=true' );
					die;

				}
			}

		break;
/*******************************************************************************************************************/
		case 'del_3':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			$filter = 'idAcceso!=0';
			if(isset($Fecha)&&$Fecha!=''){          $filter .= " AND Fecha = '".$Fecha."'";}
			if(isset($usuario)&&$usuario!=''){      $filter .= " AND usuario = '".$usuario."'";}
			if(isset($email)&&$email!=''){          $filter .= " AND email = '".$email."'";}
			if(isset($IP_Client)&&$IP_Client!=''){  $filter .= " AND IP_Client = '".$IP_Client."'";}

			//Condiciono el borrado
			if($filter!='idAcceso!=0'){
				//se borran los datos
				$resultado = db_delete_data (false, 'transportes_checkbrute', $filter, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					//redirijo
					header( 'Location: '.$location.'&deleted=true' );
					die;

				}
			}

		break;
/*******************************************************************************************************************/
		case 'del_4':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			$filter = 'idAcceso!=0';
			if(isset($Fecha)&&$Fecha!=''){          $filter .= " AND Fecha = '".$Fecha."'";}
			if(isset($usuario)&&$usuario!=''){      $filter .= " AND usuario = '".$usuario."'";}
			if(isset($email)&&$email!=''){          $filter .= " AND email = '".$email."'";}
			if(isset($IP_Client)&&$IP_Client!=''){  $filter .= " AND IP_Client = '".$IP_Client."'";}

			//Condiciono el borrado
			if($filter!='idAcceso!=0'){
				//se borran los datos
				$resultado = db_delete_data (false, 'usuarios_checkbrute', $filter, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					//redirijo
					header( 'Location: '.$location.'&deleted=true' );
					die;

				}
			}

		break;
/*******************************************************************************************************************/
	}

?>
