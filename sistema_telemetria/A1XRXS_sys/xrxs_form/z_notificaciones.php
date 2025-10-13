<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-247).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/
	//Traspaso de valores input a variables
	if (!empty($_GET['id']))    $id     = $_GET['id'];
	if (!empty($_GET['all']))   $all    = $_GET['all'];

	if (!empty($_POST['idNotificaciones']))   $idNotificaciones      = $_POST['idNotificaciones'];
	if (!empty($_POST['idSistema']))          $idSistema             = $_POST['idSistema'];
	if (!empty($_POST['idUsuario']))          $idUsuario             = $_POST['idUsuario'];
	if (!empty($_POST['Titulo']))             $Titulo                = $_POST['Titulo'];
	if (!empty($_POST['Notificacion']))       $Notificacion          = $_POST['Notificacion'];
	if (!empty($_POST['Fecha']))              $Fecha                 = $_POST['Fecha'];
	if (!empty($_POST['idUsrReceptor']))      $idUsrReceptor         = $_POST['idUsrReceptor'];
	if (!empty($_POST['idTipoUsuario']))      $idTipoUsuario         = $_POST['idTipoUsuario'];
	if (!empty($_POST['Nombre']))             $Nombre                = $_POST['Nombre'];
	if (!empty($_POST['rango_a']))            $rango_a               = $_POST['rango_a'];
	if (!empty($_POST['rango_b']))            $rango_b               = $_POST['rango_b'];
	if (!empty($_POST['idCiudad']))           $idCiudad              = $_POST['idCiudad'];
	if (!empty($_POST['idComuna']))           $idComuna              = $_POST['idComuna'];
	if (!empty($_POST['Direccion']))          $Direccion             = $_POST['Direccion'];

/*******************************************************************************************************************/
/*                                      Verificacion de los datos obligatorios                                     */
/*******************************************************************************************************************/

	//limpio y separo los datos de la cadena de comprobacion
	$form_obligatorios = str_replace(' ', '', $_SESSION['form_require']);
	$INT_piezas = explode(",", $form_obligatorios);
	//recorro los elementos
	foreach ($INT_piezas as $INT_valor) {
		//veo si existe el dato solicitado y genero el error
		switch ($INT_valor) {
			case 'idNotificaciones': if(empty($idNotificaciones)){  $error['idNotificaciones']  = 'error/No ha ingresado el id';}break;
			case 'idSistema':        if(empty($idSistema)){         $error['idSistema']         = 'error/No ha ingresado el sistema';}break;
			case 'idUsuario':        if(empty($idUsuario)){         $error['idUsuario']         = 'error/No ha ingresado el usuario creador';}break;
			case 'Titulo':           if(empty($Titulo)){            $error['Titulo']            = 'error/No ha ingresado el titulo';}break;
			case 'Notificacion':     if(empty($Notificacion)){      $error['Notificacion']      = 'error/No ha ingresado la notificacion';}break;
			case 'Fecha':            if(empty($Fecha)){             $error['Fecha']             = 'error/No ha ingresado la fecha';}break;
			case 'idUsrReceptor':    if(empty($idUsrReceptor)){     $error['idUsrReceptor']     = 'error/No ha ingresado el usuario receptor';}break;
			case 'idTipoUsuario':    if(empty($idTipoUsuario)){     $error['idTipoUsuario']     = 'error/No ha seleccionado el tipo de usuario';}break;
			case 'Nombre':           if(empty($Nombre)){            $error['Nombre']            = 'error/No ha ingresado el nombre';}break;
			case 'rango_a':          if(empty($rango_a)){           $error['rango_a']           = 'error/No ha ingresado la fecha de nacimiento inicio';}break;
			case 'rango_b':          if(empty($rango_b)){           $error['rango_b']           = 'error/No ha ingresado la fecha de nacimiento termino';}break;
			case 'idCiudad':         if(empty($idCiudad)){          $error['idCiudad']          = 'error/No ha ingresado la ciudad';}break;
			case 'idComuna':         if(empty($idComuna)){          $error['idComuna']          = 'error/No ha ingresado la comuna';}break;
			case 'Direccion':        if(empty($Direccion)){         $error['Direccion']         = 'error/No ha ingresado la dirección';}break;

		}
	}
/*******************************************************************************************************************/
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Titulo) && $Titulo!=''){             $Titulo       = EstandarizarInput($Titulo);}
	if(isset($Notificacion) && $Notificacion!=''){ $Notificacion = EstandarizarInput($Notificacion);}
	if(isset($Nombre) && $Nombre!=''){             $Nombre       = EstandarizarInput($Nombre);}
	if(isset($Direccion) && $Direccion!=''){       $Direccion    = EstandarizarInput($Direccion);}

/*******************************************************************************************************************/
/*                                        Verificación de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($Titulo)&&contar_palabras_censuradas($Titulo)!=0){              $error['Titulo']       = 'error/Edita Titulo, contiene palabras no permitidas';}
	if(isset($Notificacion)&&contar_palabras_censuradas($Notificacion)!=0){  $error['Notificacion'] = 'error/Edita Notificacion, contiene palabras no permitidas';}
	if(isset($Nombre)&&contar_palabras_censuradas($Nombre)!=0){              $error['Nombre']       = 'error/Edita Nombre,contiene palabras no permitidas';}
	if(isset($Direccion)&&contar_palabras_censuradas($Direccion)!=0){        $error['Direccion']    = 'error/Edita Direccion, contiene palabras no permitidas';}

/*******************************************************************************************************************/
/*                                            Se ejecutan las instrucciones                                        */
/*******************************************************************************************************************/
	//ejecuto segun la funcion
	switch ($form_trabajo) {
/*******************************************************************************************************************/
		case 'aprobar_uno':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/*******************************************************/
				//se actualizan los datos
				$SIS_data = "idEstado=2, FechaVisto='".fecha_actual()."'";
				$resultado = db_update_data (false, $SIS_data, 'principal_notificaciones_ver', 'idNoti = "'.$id.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					//redirijo
					header( 'Location: '.$location.'&aprobar_uno=true' );
					die;

				}

			}

		break;
/*******************************************************************************************************************/
		case 'aprobar_todos':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				/*******************************************************/
				//se actualizan los datos
				$SIS_data = "idEstado=2, FechaVisto='".fecha_actual()."'";
				$resultado = db_update_data (false, $SIS_data, 'principal_notificaciones_ver', 'idUsuario = "'.$all.'"  AND idEstado=1', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					//redirijo
					header( 'Location: '.$location.'&aprobar_todos=true' );
					die;

				}

			}

		break;
/*******************************************************************************************************************/
		case 'enviar_masivo':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idSistema) && $idSistema!=''){         $SIS_data  = "'".$idSistema."'";          }else{$SIS_data  = "''";}
				if(isset($idUsuario) && $idUsuario!=''){         $SIS_data .= ",'".$idUsuario."'";         }else{$SIS_data .= ",''";}
				if(isset($Titulo) && $Titulo!=''){               $SIS_data .= ",'".$Titulo."'";            }else{$SIS_data .= ",''";}
				if(isset($Notificacion) && $Notificacion!=''){   $SIS_data .= ",'".$Notificacion."'";      }else{$SIS_data .= ",''";}
				if(isset($Fecha) && $Fecha!=''){                 $SIS_data .= ",'".$Fecha."'";             }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema,idUsuario,Titulo,Notificacion,Fecha';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'principal_notificaciones_listado', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){

					//variables para armar el mensaje
					$Notificacion  = '<div class="btn-group" ><a href="view_notificacion.php?view='.simpleEncode($ultimo_id, '123333').'" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a></div>';
					$Notificacion .= ' '.$Titulo;
					$Estado = '1';

					//busco a todos los usuarios del sistema
					$arrUsuarios = array();
					$arrUsuarios = db_select_array (false, 'usuarios_listado.idUsuario', 'usuarios_listado', 'LEFT JOIN `usuarios_sistemas` ON usuarios_sistemas.idUsuario = usuarios_listado.idUsuario', 'usuarios_sistemas.idSistema = "'.$idSistema.'" AND usuarios_listado.idEstado=1 GROUP BY usuarios_listado.idUsuario', 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//Inserto el mensaje de entrega de materiales
					foreach($arrUsuarios as $users) {
						if(isset($idSistema) && $idSistema!=''){                     $SIS_data  = "'".$idSistema."'";               }else{$SIS_data  = "''";}
						if(isset($users['idUsuario']) && $users['idUsuario']!=''){   $SIS_data .= ",'".$users['idUsuario']."'";     }else{$SIS_data .= ",''";}
						if(isset($Notificacion) && $Notificacion!=''){               $SIS_data .= ",'".$Notificacion."'";           }else{$SIS_data .= ",''";}
						if(isset($Fecha) && $Fecha!=''){                             $SIS_data .= ",'".$Fecha."'";                  }else{$SIS_data .= ",''";}
						if(isset($Estado) && $Estado!=''){                           $SIS_data .= ",'".$Estado."'";                 }else{$SIS_data .= ",''";}
						if(isset($ultimo_id) && $ultimo_id!=''){                     $SIS_data .= ",'".$ultimo_id."'";              }else{$SIS_data .= ",''";}
						$SIS_data .= ",'".hora_actual()."'";

						// inserto los datos de registro en la db
						$SIS_columns = 'idSistema,idUsuario,Notificacion, Fecha, idEstado, idNotificaciones, Hora';
						$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'principal_notificaciones_ver', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					}

					//redirijo
					header( 'Location: '.$location.'&created=true' );
					die;
				}
			}

		break;
/*******************************************************************************************************************/
		case 'enviar_usuario':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idSistema) && $idSistema!=''){         $SIS_data  = "'".$idSistema."'";          }else{$SIS_data  = "''";}
				if(isset($idUsuario) && $idUsuario!=''){         $SIS_data .= ",'".$idUsuario."'";         }else{$SIS_data .= ",''";}
				if(isset($Titulo) && $Titulo!=''){               $SIS_data .= ",'".$Titulo."'";            }else{$SIS_data .= ",''";}
				if(isset($Notificacion) && $Notificacion!=''){   $SIS_data .= ",'".$Notificacion."'";      }else{$SIS_data .= ",''";}
				if(isset($Fecha) && $Fecha!=''){                 $SIS_data .= ",'".$Fecha."'";             }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema,idUsuario,Titulo,Notificacion,Fecha';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'principal_notificaciones_listado', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					//variables para armar el mensaje
					$Notificacion  = '<div class="btn-group" ><a href="view_notificacion.php?view='.simpleEncode($ultimo_id, '123333').'" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a></div>';
					$Notificacion .= ' '.$Titulo;
					$Estado = '1';

					if(isset($idSistema) && $idSistema!=''){            $SIS_data  = "'".$idSistema."'";          }else{$SIS_data  = "''";}
					if(isset($idUsrReceptor) && $idUsrReceptor!=''){    $SIS_data .= ",'".$idUsrReceptor."'";     }else{$SIS_data .= ",''";}
					if(isset($Notificacion) && $Notificacion!=''){      $SIS_data .= ",'".$Notificacion."'";      }else{$SIS_data .= ",''";}
					if(isset($Fecha) && $Fecha!=''){                    $SIS_data .= ",'".$Fecha."'";             }else{$SIS_data .= ",''";}
					if(isset($Estado) && $Estado!=''){                  $SIS_data .= ",'".$Estado."'";            }else{$SIS_data .= ",''";}
					if(isset($ultimo_id) && $ultimo_id!=''){            $SIS_data .= ",'".$ultimo_id."'";         }else{$SIS_data .= ",''";}
					$SIS_data .= ",'".hora_actual()."'";

					// inserto los datos de registro en la db
					$SIS_columns = 'idSistema,idUsuario,Notificacion, Fecha, idEstado, idNotificaciones, Hora';
					$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'principal_notificaciones_ver', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//Si ejecuto correctamente la consulta
					if($ultimo_id!=0){
						//redirijo
						header( 'Location: '.$location.'&created=true' );
						die;
					}
				}
			}

		break;
/*******************************************************************************************************************/
		case 'enviar_filtro':

			$z = '&filtro=true';
			if(isset($idTipoUsuario)&&$idTipoUsuario!='') {    $z .= '&idTipoUsuario='.$idTipoUsuario;}
			if(isset($Nombre)&&$Nombre!='') {                  $z .= '&Nombre='.$Nombre;}
			if(isset($rango_a)&&$rango_a!='') {                $z .= '&rango_a='.$rango_a;}
            if(isset($rango_b)&&$rango_b!='') {                $z .= '&rango_b='.$rango_b;}
			if(isset($idCiudad)&&$idCiudad!='') {              $z .= '&idCiudad='.$idCiudad; }
			if(isset($idComuna)&&$idComuna!='') {              $z .= '&idComuna='.$idComuna; }
			if(isset($Direccion)&&$Direccion!='') {            $z .= '&Direccion='.$Direccion;}
			if(isset($idSistema)&&$idSistema!='') {            $z .= '&idSistema='.$idSistema;}

			header( 'Location: '.$location.$z );
			die;

		break;
/*******************************************************************************************************************/
		case 'enviar_filtrados':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idSistema) && $idSistema!=''){         $SIS_data  = "'".$idSistema."'";          }else{$SIS_data  = "''";}
				if(isset($idUsuario) && $idUsuario!=''){         $SIS_data .= ",'".$idUsuario."'";         }else{$SIS_data .= ",''";}
				if(isset($Titulo) && $Titulo!=''){               $SIS_data .= ",'".$Titulo."'";            }else{$SIS_data .= ",''";}
				if(isset($Notificacion) && $Notificacion!=''){   $SIS_data .= ",'".$Notificacion."'";      }else{$SIS_data .= ",''";}
				if(isset($Fecha) && $Fecha!=''){                 $SIS_data .= ",'".$Fecha."'";             }else{$SIS_data .= ",''";}

				// inserto los datos de registro en la db
				$SIS_columns = 'idSistema,idUsuario,Titulo,Notificacion,Fecha';
				$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'principal_notificaciones_listado', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				//Si ejecuto correctamente la consulta
				if($ultimo_id!=0){
					//variables para armar el mensaje
					$Notificacion  = '<div class="btn-group" ><a href="view_notificacion.php?view='.simpleEncode($ultimo_id, '123333').'" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a></div>';
					$Notificacion .= ' '.$Titulo;
					$Estado        = '1';

					//busco a todos los usuarios del sistema
					$z = 'usuarios_listado.idEstado = 1';
					if(isset($_GET['idTipoUsuario']) && $_GET['idTipoUsuario']!=''){    $z .= " AND usuarios_listado.idTipoUsuario = '".$_GET['idTipoUsuario']."'";}
					if(isset($_GET['Nombre']) && $_GET['Nombre'] != ''){              $z .= " AND usuarios_listado.Nombre LIKE '%".EstandarizarInput($_GET['Nombre'])."%'";}
					if(isset($_GET['idCiudad']) && $_GET['idCiudad'] != ''){          $z .= " AND usuarios_listado.idCiudad = '".$_GET['idCiudad']."'";}
					if(isset($_GET['idComuna']) && $_GET['idComuna'] != ''){          $z .= " AND usuarios_listado.idComuna = '".$_GET['idComuna']."'";}
					if(isset($_GET['Direccion']) && $_GET['Direccion'] != ''){        $z .= " AND usuarios_listado.Direccion LIKE '%".EstandarizarInput($_GET['Direccion'])."%'";}
					if(isset($_GET['idSistema']) && $_GET['idSistema'] != ''){        $z .= " AND usuarios_sistemas.idSistema = '".$_GET['idSistema']."'";}
					if(isset($_GET['rango_a']) && $_GET['rango_a'] != ''&&isset($_GET['rango_b']) && $_GET['rango_b']!=''){
						$z .= " AND usuarios_listado.fNacimiento BETWEEN '".$_GET['rango_a']."' AND '".$_GET['rango_b']."'";
					}

					$arrPermiso = array();
					$arrPermiso = db_select_array (false, 'usuarios_listado.idUsuario', 'usuarios_listado', 'LEFT JOIN `usuarios_sistemas` ON usuarios_sistemas.idUsuario = usuarios_listado.idUsuario', $z.' GROUP BY usuarios_listado.idUsuario', 0, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//Inserto el mensaje de entrega de materiales
					foreach($arrPermiso as $permiso) {
						if(isset($idSistema) && $idSistema!=''){                         $SIS_data  = "'".$idSistema."'";               }else{$SIS_data  = "''";}
						if(isset($permiso['idUsuario']) && $permiso['idUsuario']!=''){   $SIS_data .= ",'".$permiso['idUsuario']."'";   }else{$SIS_data .= ",''";}
						if(isset($Notificacion) && $Notificacion!=''){                   $SIS_data .= ",'".$Notificacion."'";           }else{$SIS_data .= ",''";}
						if(isset($Fecha) && $Fecha!=''){                                 $SIS_data .= ",'".$Fecha."'";                  }else{$SIS_data .= ",''";}
						if(isset($Estado) && $Estado!=''){                               $SIS_data .= ",'".$Estado."'";                 }else{$SIS_data .= ",''";}
						if(isset($ultimo_id) && $ultimo_id!=''){                         $SIS_data .= ",'".$ultimo_id."'";              }else{$SIS_data .= ",''";}
						$SIS_data .= ",'".hora_actual()."'";

						// inserto los datos de registro en la db
						$SIS_columns = 'idSistema,idUsuario,Notificacion, Fecha, idEstado, idNotificaciones, Hora';
						$ultimo_id2 = db_insert_data (false, $SIS_columns, $SIS_data, 'principal_notificaciones_ver', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					}

					//redirijo
					header( 'Location: '.$location.'&created=true' );
					die;

				}
			}

		break;
/*******************************************************************************************************************/
		case 'del':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Variable
			$errorn = 0;

			//verifico si se envia un entero
			if((!validarNumero($_GET['del']) OR !validaEntero($_GET['del']))&&$_GET['del']!=''){
				$indice = simpleDecode($_GET['del'], fecha_actual());
			}else{
				$indice = $_GET['del'];
				//guardo el log
				php_error_log($_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo, '', 'Indice no codificado', '' );

			}

			//se verifica si es un numero lo que se recibe
			if (!validarNumero($indice)&&$indice!=''){
				$error['validarNumero'] = 'error/El valor ingresado en $indice ('.$indice.') en la opción DEL  no es un numero';
				$errorn++;
			}
			//Verifica si el numero recibido es un entero
			if (!validaEntero($indice)&&$indice!=''){
				$error['validaEntero'] = 'error/El valor ingresado en $indice ('.$indice.') en la opción DEL  no es un numero entero';
				$errorn++;
			}

			if($errorn==0){
				//se borran los datos
				$resultado_1 = db_delete_data (false, 'principal_notificaciones_listado', 'idNotificaciones = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$resultado_2 = db_delete_data (false, 'principal_notificaciones_ver', 'idNotificaciones = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado_1==true OR $resultado_2==true){

					//redirijo
					header( 'Location: '.$location.'&deleted=true' );
					die;

				}
			}else{
				//se valida hackeo
				require_once '0_hacking_1.php';
			}

		break;
/*******************************************************************************************************************/
	}

?>
