<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')) {
    die('No tienes acceso a esta carpeta o archivo (Access Code 1006-002).');
}
/*******************************************************************************************************************/
/*                                                                                                                 */
/*                                                   Requires                                                      */
/*                                                                                                                 */
/*******************************************************************************************************************/
require_once '../A2XRXS_gears/xrxs_funciones/Helpers.Functions.Arduino.php';                    //Funciones para la generacion de codigo para las placas arduino
require_once '../A2XRXS_gears/xrxs_funciones/Helpers.Functions.Common.Data.php';                //Funciones comunes de manejo de datos
require_once '../A2XRXS_gears/xrxs_funciones/Helpers.Functions.Common.Notifications.php';       //Funciones notificaciones por pantalla
require_once '../A2XRXS_gears/xrxs_funciones/Helpers.Functions.Convertions.php';                //Conversiones de datos
require_once '../A2XRXS_gears/xrxs_funciones/Helpers.Functions.Data.Date.php';                  //Funciones relacionadas a las fechas
require_once '../A2XRXS_gears/xrxs_funciones/Helpers.Functions.Data.Numbers.php';               //Funciones relacionadas a los numeros
require_once '../A2XRXS_gears/xrxs_funciones/Helpers.Functions.Data.Operations.php';            //Funciones relacionadas a operaciones matematicas
require_once '../A2XRXS_gears/xrxs_funciones/Helpers.Functions.Data.Text.php';                  //Funciones relacionadas a los textos
require_once '../A2XRXS_gears/xrxs_funciones/Helpers.Functions.Data.Time.php';                  //Funciones relacionadas a las horas
require_once '../A2XRXS_gears/xrxs_funciones/Helpers.Functions.Data.Validations.php';           //Funciones de validacion de datos
require_once '../A2XRXS_gears/xrxs_funciones/Helpers.Functions.DataBase.php';                   //Funciones relacionadas a la base de datos
require_once '../A2XRXS_gears/xrxs_funciones/Helpers.Functions.Location.php';                   //Funciones relacionadas a la geolozalizacion
require_once '../A2XRXS_gears/xrxs_funciones/Helpers.Functions.Security.AntiSql_Injection.php'; //Funciones de seguridad para los sql injection
require_once '../A2XRXS_gears/xrxs_funciones/Helpers.Functions.Security.Codification.php';      //Funciones de seguridad para la codificacion y decodificacion de datos
require_once '../A2XRXS_gears/xrxs_funciones/Helpers.Functions.Security.Passwords.php';         //Funciones de seguridad para la generacion de password o palabras unicas
require_once '../A2XRXS_gears/xrxs_funciones/Helpers.Functions.Server.Client.php';              //Funciones para entregar información del cliente
require_once '../A2XRXS_gears/xrxs_funciones/Helpers.Functions.Server.Notifications.php';       //Funciones para el envio de notificaciones a traves de mail, mensajes pushup, etc
require_once '../A2XRXS_gears/xrxs_funciones/Helpers.Functions.Server.Server.php';              //Funciones para entregar información del servidor
require_once '../A2XRXS_gears/xrxs_funciones/Helpers.Functions.Server.Social.php';              //Funciones para el envio de mensajes a traves de redes sociales
require_once '../A2XRXS_gears/xrxs_funciones/Helpers.Functions.Server.Web.php';                 //Funciones para entregar información de la web

/*******************************************************************************************************************/
/*                                                                                                                 */
/*                                                  Funciones                                                      */
/*                                                                                                                 */
/*******************************************************************************************************************/
/*******************************************************************************************************************/
/* Toma dos input y calcula valores*/
function prod_print_value($tabla1, $input_1, $input_result_1, $input_result_2, $dbConn) {

    /******************************************************/
	$SIS_query =
    $tabla1.'.idProducto AS idAlgo,
	sistema_productos_uml.Nombre AS Unimed,
	proveedor_listado.Nombre AS Proveedor';
	$SIS_join  = '
	LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml   = '.$tabla1.'.idUml
	LEFT JOIN `proveedor_listado`     ON proveedor_listado.idProveedor = '.$tabla1.'.idProveedor';
	$SIS_where = '';
	$SIS_order = 'sistema_productos_uml.Nombre ASC';
	$arrProductos = array();
	$arrProductos = db_select_array (false, $SIS_query, $tabla1, $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrProductos');

	/******************************************************/
	$cadena = '';
	$cadena .= '<script>';
	foreach ($arrProductos as $prod) {
		$cadena .= 'let id_data_'.$prod['idAlgo'].'= "'.$prod['Unimed'].'";';
	}
	foreach ($arrProductos as $prod) {
		if(isset($prod['Proveedor'])&&$prod['Proveedor']!=''){$prov=$prod['Proveedor'];}else{$prov='Sin proveedor';}
		$cadena .= 'let id_prov_'.$prod['idAlgo'].'= "'.$prov.'";';
	}
	$cadena .= '</script>';

    $cadena .= '
    <script>
		document.getElementById("'.$input_1.'").onchange = function() {myFunction_'.$input_1.'()};

		function myFunction_'.$input_1.'() {
			const Componente = document.getElementById("'.$input_1.'").value;
			if (Componente != "") {
				document.getElementById("'.$input_result_1.'").value = eval("id_data_" + Componente);
				document.getElementById("'.$input_result_2.'").value = eval("id_prov_" + Componente);
			}
		}
	</script>
    ';
    return $cadena;
}
/*******************************************************************************************************************/
/* Toma dos input y calcula valores*/
function sell_print_value($tabla1, $input_1, $input_result_1, $input_result_2, $dbConn) {

    /******************************************************/
	$SIS_query =
    $tabla1.'.idProducto AS idAlgo,
	sistema_productos_uml.Nombre AS Unimed,
	clientes_listado.Nombre AS Cliente';
	$SIS_join  = '
	LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = '.$tabla1.'.idUml
	LEFT JOIN `clientes_listado`      ON clientes_listado.idCliente  = '.$tabla1.'.idCliente';
	$SIS_where = '';
	$SIS_order = 'sistema_productos_uml.Nombre ASC';
	$arrProductos = array();
	$arrProductos = db_select_array (false, $SIS_query, $tabla1, $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrProductos');

	/******************************************************/
	$cadena = '';
	$cadena .= '<script>';
	foreach ($arrProductos as $prod) {
		$cadena .= 'let id_data_'.$prod['idAlgo'].'= "'.$prod['Unimed'].'";';
	}
	foreach ($arrProductos as $prod) {
		if(isset($prod['Cliente'])&&$prod['Cliente']!=''){$prov=$prod['Cliente'];}else{$prov='Sin cliente';}
		$cadena .= 'let id_prov_'.$prod['idAlgo'].'= "'.$prov.'";';
	}
	$cadena .= '</script>';

    $cadena .= '
    <script>
		document.getElementById("'.$input_1.'").onchange = function() {myFunction_'.$input_1.'()};

		function myFunction_'.$input_1.'() {
			const Componente = document.getElementById("'.$input_1.'").value;
			if (Componente != "") {
				document.getElementById("'.$input_result_1.'").value = eval("id_data_" + Componente);
				document.getElementById("'.$input_result_2.'").value = eval("id_prov_" + Componente);
			}
		}
	</script>
    ';
    return $cadena;
}
/*******************************************************************************************************************/
/* Toma dos input y calcula valores*/
function venta_print_value($tabla1, $input_1, $input_result_1, $dbConn) {

    /******************************************************/
	$SIS_query =
    $tabla1.'.idProducto AS idAlgo,
	sistema_productos_uml.Nombre AS Unimed';
	$SIS_join  = 'LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = '.$tabla1.'.idUml';
	$SIS_where = '';
	$SIS_order = 'sistema_productos_uml.Nombre ASC';
	$arrProductos = array();
	$arrProductos = db_select_array (false, $SIS_query, $tabla1, $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrProductos');

	/******************************************************/
	$cadena = '';
	$cadena .= '<script>';
	foreach ($arrProductos as $prod) {
		$cadena .= 'let id_data_'.$prod['idAlgo'].'= "'.$prod['Unimed'].'";';
	}
	$cadena .= '</script>';

    $cadena .= '
    <script>
		document.getElementById("'.$input_1.'").onchange = function() {myFunction_'.$input_1.'()};

		function myFunction_'.$input_1.'() {
			const Componente = document.getElementById("'.$input_1.'").value;
			if (Componente != "") {
				document.getElementById("'.$input_result_1.'").value = eval("id_data_" + Componente);
			}
		}
	</script>
    ';
    return $cadena;
}
/*******************************************************************************************************************/
/* Toma dos input y calcula valores*/
function operacion_input($input_1, $input_2, $input_result_1, $input_result_2, $operation) {

    switch ($operation) {
		case 1: $oper = '+'; break;
		case 2: $oper = '-'; break;
		case 3: $oper = '*'; break;
		case 4: $oper = '/'; break;
	}

    $cadena = '
    <script>
		document.getElementById("'.$input_1.'").onkeyup = function() {myFunction_'.$input_1.'()};
		document.getElementById("'.$input_2.'").onkeyup = function() {myFunction_'.$input_2.'()};

		function myFunction_'.$input_1.'() {
			const elem1 = document.getElementById("'.$input_1.'").value;
			const elem2 = document.getElementById("'.$input_2.'").value;
			if (elem1 != "" && elem2 != "") {
				document.getElementById("'.$input_result_1.'").value = elem2 '.$oper.' elem1;
				document.getElementById("'.$input_result_2.'").value = elem2 '.$oper.' elem1;
			}
		}

		function myFunction_'.$input_2.'() {
			const elem1 = document.getElementById("'.$input_2.'").value;
			const elem2 = document.getElementById("'.$input_1.'").value;
			if (elem1 != "" && elem2 != "") {
				document.getElementById("'.$input_result_1.'").value = elem1 '.$oper.' elem2;
				document.getElementById("'.$input_result_2.'").value = elem1 '.$oper.' elem2;
			}
		}
	</script>
    ';
    return $cadena;
}
/*******************************************************************************************************************/
/* Toma dos input y calcula valores*/
function prod_print_venta($idBodega, $dato, $tabla1, $tabla2, $input_select, $input_result_1, $input_result_2,
						  $input_result_3,$input_result_4, $dbConn) {

	//Imprimo las variables
	$SIS_query =
	$tabla1.'.idProducto,
	'.$tabla1.'.'.$dato.' AS Valorizacion,
	sistema_productos_uml.Nombre AS Unimed,
	(SELECT SUM(Cantidad_ing) AS ingreso FROM `'.$tabla2.'` WHERE idProducto = '.$tabla1.'.idProducto AND idBodega='.$idBodega.') AS ingreso,
	(SELECT SUM(Cantidad_eg) AS egreso FROM `'.$tabla2.'` WHERE idProducto = '.$tabla1.'.idProducto AND idBodega='.$idBodega.') AS egreso';
	$SIS_join  = 'LEFT JOIN `sistema_productos_uml` ON sistema_productos_uml.idUml = '.$tabla1.'.idUml';
	$SIS_where = $tabla1.'.idEstado=1';
	$SIS_order = 'sistema_productos_uml.Nombre ASC';
	$arrTipo = array();
	$arrTipo = db_select_array (false, $SIS_query, $tabla1, $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'arrTipo');

	/***********************************************/
	$cadena = '';

	$cadena .= '<script>';
	foreach ($arrTipo as $tipo) {
		$Total_existencias = $tipo['ingreso'] - $tipo['egreso'];
		$cadena .= 'let uml_data_'.$tipo['idProducto'].'= "'.$tipo['Unimed'].'";';
		$cadena .= 'let valor_data_'.$tipo['idProducto'].'= "'.Cantidades_decimales_justos($tipo['Valorizacion']).'";';
		$cadena .= 'let existencia_'.$tipo['idProducto'].'= "'.Cantidades_decimales_justos($Total_existencias).'";';
	}
	$cadena .= '</script>';

    $cadena .= '
    <script>
    document.getElementById("'.$input_select.'").onchange = function() {myFunction_'.$input_select.'()};

		function myFunction_'.$input_select.'() {
			const Componente = document.getElementById("'.$input_select.'").value;
			if (Componente != "") {
				document.getElementById("'.$input_result_1.'").value = eval("uml_data_" + Componente);
				document.getElementById("'.$input_result_2.'").value = eval("valor_data_" + Componente);
				document.getElementById("'.$input_result_3.'").value = eval("existencia_" + Componente);
				document.getElementById("'.$input_result_4.'").value = eval("valor_data_" + Componente);
			}
		}
	</script>
    ';
    return $cadena;
}
/*******************************************************************************************************************/
//Funcion para seleccionar el tipo de input en los analisis
function print_select ($tipo, $Nombre,$idNombre,$valor, $Validacion) {
	//Verifico el tipo de dato
	switch ($tipo) {
		//Medicion (Decimal) con parametros limitantes
		case 1:
			return form_input_number($Nombre,$idNombre,$valor, 1);
			break;
		//Medicion (Decimal) sin parametros limitantes
		case 2:
			return form_input_number($Nombre,$idNombre,$valor, 1);
			break;
		//Medicion (Enteros) con parametros limitantes
		case 3:
			return form_input_number_integer($Nombre,$idNombre,$valor, 1);
			break;
		//Medicion (Enteros) sin parametros limitantes
		case 4:
			return form_input_number_integer($Nombre,$idNombre,$valor, 1);
			break;
		//Fecha
		case 5:
			return form_date($Nombre,$idNombre,$valor, 1);
			break;
		//Hora
		case 6:
			return form_time_popover($Nombre,$idNombre,$valor, 1, 1, 24);
			break;
		//Texto Libre
		case 7:
			return form_textarea($Nombre,$idNombre,$valor, 1);
			break;
		//Seleccion 1 a 3
		case 8:
			return form_select_n_auto($Nombre,$idNombre,$valor, 1, 1, 3);
			break;
		//Seleccion 1 a 5
		case 9:
			return form_select_n_auto($Nombre,$idNombre,$valor, 1, 1, 5);
			break;
		//Seleccion 1 a 10
		case 10:
			return form_select_n_auto($Nombre,$idNombre,$valor, 1, 1, 10);
			break;
		//Texto Libre con Validacion
		case 11:
			echo form_input_validate($Nombre,$idNombre,$valor, 1, $Validacion);
			break;

	}

}
/*******************************************************************************************************************/
//Verifico si los parametros estan dentro del radio
function TituloMenu( $Nombre ) {
	//Verifico si no esta vacio
	if(isset($Nombre)&&$Nombre!=''){
		$xdata  = array("91 - ", "92 - ", "93 - ", "94 - ", "95 - ", "96 - ", "97 - ", "98 - ", "99 - ", "100 - ",
						"81 - ", "82 - ", "83 - ", "84 - ", "85 - ", "86 - ", "87 - ", "88 - ", "89 - ", "90 - ",
						"71 - ", "72 - ", "73 - ", "74 - ", "75 - ", "76 - ", "77 - ", "78 - ", "79 - ", "80 - ",
						"61 - ", "62 - ", "63 - ", "64 - ", "65 - ", "66 - ", "67 - ", "68 - ", "69 - ", "70 - ",
						"51 - ", "52 - ", "53 - ", "54 - ", "55 - ", "56 - ", "57 - ", "58 - ", "59 - ", "60 - ",
						"41 - ", "42 - ", "43 - ", "44 - ", "45 - ", "46 - ", "47 - ", "48 - ", "49 - ", "50 - ",
						"31 - ", "32 - ", "33 - ", "34 - ", "35 - ", "36 - ", "37 - ", "38 - ", "39 - ", "40 - ",
						"21 - ", "22 - ", "23 - ", "24 - ", "25 - ", "26 - ", "27 - ", "28 - ", "29 - ", "30 - ",
						"11 - ", "12 - ", "13 - ", "14 - ", "15 - ", "16 - ", "17 - ", "18 - ", "19 - ", "20 - ",
						"01 - ", "02 - ", "03 - ", "04 - ", "05 - ", "06 - ", "07 - ", "08 - ", "09 - ", "10 - ",
						"1 - ", "2 - ", "3 - ", "4 - ", "5 - ", "6 - ", "7 - ", "8 - ", "9 - ", "00 - ",
						"91.- ", "92.- ", "93.- ", "94.- ", "95.- ", "96.- ", "97.- ", "98.- ", "99.- ", "100.- ",
						"81.- ", "82.- ", "83.- ", "84.- ", "85.- ", "86.- ", "87.- ", "88.- ", "89.- ", "90.- ",
						"71.- ", "72.- ", "73.- ", "74.- ", "75.- ", "76.- ", "77.- ", "78.- ", "79.- ", "80.- ",
						"61.- ", "62.- ", "63.- ", "64.- ", "65.- ", "66.- ", "67.- ", "68.- ", "69.- ", "70.- ",
						"51.- ", "52.- ", "53.- ", "54.- ", "55.- ", "56.- ", "57.- ", "58.- ", "59.- ", "60.- ",
						"41.- ", "42.- ", "43.- ", "44.- ", "45.- ", "46.- ", "47.- ", "48.- ", "49.- ", "50.- ",
						"31.- ", "32.- ", "33.- ", "34.- ", "35.- ", "36.- ", "37.- ", "38.- ", "39.- ", "40.- ",
						"21.- ", "22.- ", "23.- ", "24.- ", "25.- ", "26.- ", "27.- ", "28.- ", "29.- ", "30.- ",
						"11.- ", "12.- ", "13.- ", "14.- ", "15.- ", "16.- ", "17.- ", "18.- ", "19.- ", "20.- ",
						"01.- ", "02.- ", "03.- ", "04.- ", "05.- ", "06.- ", "07.- ", "08.- ", "09.- ", "10.- ",
						"1.- ", "2.- ", "3.- ", "4.- ", "5.- ", "6.- ", "7.- ", "8.- ", "9.- ", "00.- ");

		$newText = str_replace($xdata, "", $Nombre);

		return $newText;
	}

    
}
/*******************************************************************************************************************/
//Permite verificar si se trata de ingresar a un sitio a la fuerza
function checkbrute($usuario, $email, $IP_Client, $table, $dbConn) {
    /**********************************************************************/
	// Obtiene el timestamp del tiempo actual.
    $now = time();

    // Todos los intentos de inicio de sesión se cuentan desde las 2 horas anteriores.
    $valid_attempts = $now - (2 * 60 * 60);

	//variables vacias
	$num_rows = 0;

	/**********************************************************************/
	//Consulto si el usuario ha tratado de ingresar en reiteradas ocaciones
	if($num_rows==0&&isset($usuario)&&$usuario!=''){
		$num_rows = db_select_nrows (false, 'idAcceso', $table, '', 'usuario = "'.$usuario.'" AND Time > "'.$valid_attempts.'"', $dbConn, 'rowSis', basename($_SERVER["REQUEST_URI"], ".php"), 'rowSis');
	}

	//Consulto si el ip ha tratado de ingresar en reiteradas ocaciones
	if($num_rows==0&&isset($IP_Client)&&$IP_Client!=''){
		$num_rows = db_select_nrows (false, 'idAcceso', $table, '', 'IP_Client = "'.$IP_Client.'" AND Time > "'.$valid_attempts.'"', $dbConn, 'rowSis', basename($_SERVER["REQUEST_URI"], ".php"), 'rowSis');
	}

	//Consulto si el ip ha tratado de ingresar en reiteradas ocaciones
	if($num_rows==0&&isset($email)&&$email!=''){
		$num_rows = db_select_nrows (false, 'idAcceso', $table, '', 'email = "'.$email.'" AND Time > "'.$valid_attempts.'"', $dbConn, 'rowSis', basename($_SERVER["REQUEST_URI"], ".php"), 'rowSis');
	}

	/**********************************************************************/
    // Si ha habido más de 5 intentos de inicio de sesión fallidos.
    if ($num_rows > 5) {
        return true;
    } else {
        return false;
    }

}
/*******************************************************************************************************************/
//Funcion para guardar datos
function valida_latxlong($Direccion, $Config_IDGoogle){
	$geocodeData = getGeocodeData($Direccion, $Config_IDGoogle);
	if($geocodeData) {
		return true;
    } else {
        return false;
    }
}
/*******************************************************************************************************************/
//Funcion para guardar datos
function latxlong($Direccion, $Config_IDGoogle,  $idSubasta, $dbConn){
	$geocodeData = getGeocodeData($Direccion, $Config_IDGoogle);
	if($geocodeData) {
		$GeoLatitud  = $geocodeData[0];
		$GeoLongitud = $geocodeData[1];

		if(isset($idSubasta) && $idSubasta!=''){        $SIS_data  = "'".$idSubasta."'";      }else{$SIS_data  = "''";}
		if(isset($GeoLatitud) && $GeoLatitud!=''){      $SIS_data .= ",'".$GeoLatitud."'";    }else{$SIS_data .= ",''";}
		if(isset($GeoLongitud) && $GeoLongitud!=''){    $SIS_data .= ",'".$GeoLongitud."'";   }else{$SIS_data .= ",''";}
		if(isset($Direccion) && $Direccion!=''){        $SIS_data .= ",'".$Direccion."'";     }else{$SIS_data .= ",''";}

		// inserto los datos de registro en la db
		$SIS_columns = 'idSubasta, GeoLatitud,GeoLongitud,Direccion';
		$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'subastas_listado_ubicaciones', $dbConn, 'db_insert_data', basename($_SERVER["REQUEST_URI"], ".php"), 'db_insert_data');

	}
}
/*******************************************************************************************************************/
//Funcion para saber si esta o no dentro de un area
function inLocationPoint($arrZonas, $pointLocation, $GeoLatitud, $GeoLongitud){
	//variable
	$nx = 0;
	//recorro las areas
	foreach ($arrZonas as $todaszonas=>$zonas) {
		//arreglo para el pligono
		$polygon = array();
		//variables para cerrar el poligono
		$ini     = 0;
		$f_lat   = 0;
		$f_long  = 0;
		//recorro las zonas
		foreach ($zonas as $puntos) {
			array_push( $polygon,$puntos['Latitud'].' '.$puntos['Longitud'] );
			//si es el primer dato
			if($ini==0){
				$f_lat  = $puntos['Latitud'];
				$f_long = $puntos['Longitud'];
			}
			$ini++;
		}
		//inserto el primer dato como el ultimo para cerrar poligono
		array_push( $polygon,$f_lat.' '.$f_long );
		//verifico
		$c_chek =  $pointLocation->pointInPolygon($GeoLatitud.' '.$GeoLongitud, $polygon);
		//si esta dentro de la zona
		if($c_chek=='inside'){
			if($nx==0){
				$nx = $todaszonas;
			}
		}
	}
	//devuelvo
	return $nx;
}
/*******************************************************************************************************************/
//Funcion mostrar superficies
function SuperficieDisponible($idUniMed, $SupDisp, $UniMed){

	/********************************************************/
	//Definicion de errores
	$errorn = 0;
	//se definen las opciones disponibles
	$tipos = array(1,4);
	//verifico si el dato ingresado existe dentro de las opciones
	if (!in_array($idUniMed, $tipos)) {
		alert_post_data(4,1,1,0, 'La configuracion $idUniMed ('.$idUniMed.') entregada no esta dentro de las opciones');
		$errorn++;
	}
	/********************************************************/
	//Ejecucion si no hay errores
	if($errorn==0){

		/********************************************/
		//Si se envia valores
		if(isset($SupDisp)&&$SupDisp!=0){
			switch ($idUniMed) {
				/********************************************/
				//hectareas
				case 1:
					$S_1 = $SupDisp;
					$S_2 = $SupDisp * 10000;
					$U_1 = $UniMed;
					$U_2 = 'm<sup>2</sup>';

					$data = Cantidades($S_1, 2).' '.$U_1;
					$data.= ' / ';
					$data.= Cantidades($S_2, 0).' '.$U_2;

					break;
				/********************************************/
				//metro cuadrado
				case 4:
					$S_1 = $SupDisp / 10000;
					$S_2 = $SupDisp;
					$U_1 = 'hás';
					$U_2 = $UniMed;

					$data = Cantidades($S_1, 2).' '.$U_1;
					$data.= ' / ';
					$data.= Cantidades($S_2, 0).' '.$U_2;

					break;
			}
		/********************************************/
		//si no hay valor solo devuelve unidad medida
		}else{
			$data = $UniMed;
		}

		/********************************************/
		//devuelvo
		return $data;
	}
}
/*******************************************************************************************************************/
//Funcion mostrar superficies
function SuperficieDisponibleEdificios($idUniMed, $SupDisp, $UniMed){

	/********************************************************/
	//Definicion de errores
	$errorn = 0;
	//se definen las opciones disponibles
	$tipos = array(1,4);
	//verifico si el dato ingresado existe dentro de las opciones
	if (!in_array($idUniMed, $tipos)) {
		alert_post_data(4,1,1,0, 'La configuracion $idUniMed ('.$idUniMed.') entregada no esta dentro de las opciones');
		$errorn++;
	}
	/********************************************************/
	//Ejecucion si no hay errores
	if($errorn==0){

		/********************************************/
		//Si se envia valores
		if(isset($SupDisp)&&$SupDisp!=0){
			switch ($idUniMed) {
				/********************************************/
				//hectareas
				case 1:
					$S_2 = $SupDisp * 10000;
					$U_2 = 'm<sup>2</sup>';

					$data = Cantidades($S_2, 0).' '.$U_2;

					break;
				/********************************************/
				//metro cuadrado
				case 4:
					$S_2 = $SupDisp;
					$U_2 = $UniMed;

					$data = Cantidades($S_2, 0).' '.$U_2;

					break;
			}
		/********************************************/
		//si no hay valor solo devuelve unidad medida
		}else{
			$data = $UniMed;
		}

		/********************************************/
		//devuelvo
		return $data;
	}
}
/*******************************************************************************************************************/
//Funcion mostrar superficies
function SuperficieDisponibleCasas($idUniMed, $SupDisp, $UniMed){

	/********************************************************/
	//Definicion de errores
	$errorn = 0;
	//se definen las opciones disponibles
	$tipos = array(1,4);
	//verifico si el dato ingresado existe dentro de las opciones
	if (!in_array($idUniMed, $tipos)) {
		alert_post_data(4,1,1,0, 'La configuracion $idUniMed ('.$idUniMed.') entregada no esta dentro de las opciones');
		$errorn++;
	}
	/********************************************************/
	//Ejecucion si no hay errores
	if($errorn==0){

		/********************************************/
		//Si se envia valores
		if(isset($SupDisp)&&$SupDisp!=0){
			switch ($idUniMed) {
				/********************************************/
				//hectareas
				case 1:
					$S_1 = $SupDisp;
					$U_1 = $UniMed;

					$data = Cantidades($S_1, 2).' '.$U_1;

					break;
				/********************************************/
				//metro cuadrado
				case 4:
					$S_1 = $SupDisp / 10000;
					$U_1 = 'hás';

					$data = Cantidades($S_1, 2).' '.$U_1;

					break;
			}
		/********************************************/
		//si no hay valor solo devuelve unidad medida
		}else{
			$data = $UniMed;
		}

		/********************************************/
		//devuelvo
		return $data;
	}
}
/*******************************************************************************************************************/
//el contrato entre la administracion y el cliente
function polz_contrato_01($idUnidadNegocio, $color, $dbConn){

	/**************************************************************/
	// consulto los datos
	$SIS_query = '
	unidad_negocio_listado.Direccion AS ObraDireccion,

	clientes_listado.Nombre AS ClienteNombre,
	clientes_listado.Rut AS ClienteRut,
	clientes_listado.RepLegalNombre AS ClienteNombreRL,
	clientes_listado.RepLegalRut AS ClienteRutRL,
	clientes_listado.Direccion AS ClienteDireccion,

	cliente_ciudad.Nombre AS ClienteCiudad,
	cliente_comunas.Nombre AS ClienteComuna,
	obras_listado.Nombre AS ObraNombre,
	obras_listado.FichaValor AS ObraValor,
	obras_listado_calendario.Fecha AS FechaReservada,
	obra_ciudad.Nombre AS ObraCiudad,
	obra_comunas.Nombre AS ObraComuna

	';
	$SIS_join  = '
	LEFT JOIN `clientes_listado`                         ON clientes_listado.idCliente             = unidad_negocio_listado.idCliente
	LEFT JOIN `core_ubicacion_ciudad`   cliente_ciudad   ON cliente_ciudad.idCiudad                = clientes_listado.idCiudad
	LEFT JOIN `core_ubicacion_comunas`  cliente_comunas  ON cliente_comunas.idComuna               = clientes_listado.idComuna
	LEFT JOIN `obras_listado`                            ON obras_listado.idObra                   = unidad_negocio_listado.idObra
	LEFT JOIN `obras_listado_calendario`                 ON obras_listado_calendario.idCalendario  = unidad_negocio_listado.idCalendario
	LEFT JOIN `core_ubicacion_ciudad`   obra_ciudad      ON obra_ciudad.idCiudad                   = unidad_negocio_listado.idCiudad
	LEFT JOIN `core_ubicacion_comunas`  obra_comunas     ON obra_comunas.idComuna                  = unidad_negocio_listado.idComuna
	';
	$SIS_where = 'unidad_negocio_listado.idUnidadNegocio = '.$idUnidadNegocio;
	$rowData = db_select_data (false, $SIS_query, 'unidad_negocio_listado', $SIS_join, $SIS_where, $dbConn, 'rowData', basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

	/**************************************************************/
	//variables
	if(isset($rowData['ObraDireccion'])&&$rowData['ObraDireccion']){        $ObraDireccion     = $rowData['ObraDireccion'];     }else{$ObraDireccion     = '<strong style="color:red;">SIN DATOS</strong>';}
	if(isset($rowData['ClienteNombre'])&&$rowData['ClienteNombre']){        $ClienteNombre     = $rowData['ClienteNombre'];     }else{$ClienteNombre     = '<strong style="color:red;">SIN DATOS</strong>';}
	if(isset($rowData['ClienteRut'])&&$rowData['ClienteRut']){              $ClienteRut        = $rowData['ClienteRut'];        }else{$ClienteRut        = '<strong style="color:red;">SIN DATOS</strong>';}
	if(isset($rowData['ClienteNombreRL'])&&$rowData['ClienteNombreRL']){    $ClienteNombreRL   = $rowData['ClienteNombreRL'];   }else{$ClienteNombreRL   = '<strong style="color:red;">SIN DATOS</strong>';}
	if(isset($rowData['ClienteRutRL'])&&$rowData['ClienteRutRL']){          $ClienteRutRL      = $rowData['ClienteRutRL'];      }else{$ClienteRutRL      = '<strong style="color:red;">SIN DATOS</strong>';}
	if(isset($rowData['ClienteDireccion'])&&$rowData['ClienteDireccion']){  $ClienteDireccion  = $rowData['ClienteDireccion'];  }else{$ClienteDireccion  = '<strong style="color:red;">SIN DATOS</strong>';}
	if(isset($rowData['ClienteCiudad'])&&$rowData['ClienteCiudad']){        $ClienteCiudad     = $rowData['ClienteCiudad'];     }else{$ClienteCiudad     = '<strong style="color:red;">SIN DATOS</strong>';}
	if(isset($rowData['ClienteComuna'])&&$rowData['ClienteComuna']){        $ClienteComuna     = $rowData['ClienteComuna'];     }else{$ClienteComuna     = '<strong style="color:red;">SIN DATOS</strong>';}
	if(isset($rowData['ObraNombre'])&&$rowData['ObraNombre']){              $ObraNombre        = $rowData['ObraNombre'];        }else{$ObraNombre        = '<strong style="color:red;">SIN DATOS</strong>';}
	if(isset($rowData['ObraValor'])&&$rowData['ObraValor']){                $ObraValor         = $rowData['ObraValor'];         }else{$ObraValor         = '<strong style="color:red;">SIN DATOS</strong>';}
	if(isset($rowData['FechaReservada'])&&$rowData['FechaReservada']){      $FechaReservada    = $rowData['FechaReservada'];    }else{$FechaReservada    = '<strong style="color:red;">SIN DATOS</strong>';}
	if(isset($rowData['ObraCiudad'])&&$rowData['ObraCiudad']){              $ObraCiudad        = $rowData['ObraCiudad'];        }else{$ObraCiudad        = '<strong style="color:red;">SIN DATOS</strong>';}
	if(isset($rowData['ObraComuna'])&&$rowData['ObraComuna']){              $ObraComuna        = $rowData['ObraComuna'];        }else{$ObraComuna        = '<strong style="color:red;">SIN DATOS</strong>';}

	/**************************************************************/
	$Contrato = '
	<div class="bs-example" data-example-id="simple-pre" >
		<div style="border-top:solid '.$color.' 1.0pt;border-left:none;border-bottom:solid '.$color.' 1.0pt; border-right:none;padding:1.0pt 0in 1.0pt 0in;margin-bottom:55px;margin-top: 55px;">
			<p style="margin: 0;text-align: center;font-size: 16.0pt;color: '.$color.';font-weight: bold;">Contrato para la Compra de Funciones de Teatro (Comprador)</p>
		</div>

		<p style="font-size: 14px;">
			En Santiago de Chile, a '.Fecha_completa_alt(fecha_actual()).', entre don '.$ClienteNombreRL.', cédula nacional de
			identidad Nº'.$ClienteRutRL.', con domicilio en calle '.$ClienteDireccion.', Comuna '.$ClienteComuna.',
			Ciudad '.$ClienteCiudad.', actuando en representaciòn de '.$ClienteNombre.' Rut '.$ClienteRut.' ,
			en adelante e indistintamente “EL Comprador” y la empresa Somos Teatro SpA, RUT : XXXXXXX, en adelante e indistintamente
			”Somos Teatro” o “Gestora Cultural”, representada por Doña SANDRA MERCEDES SOLIMANO LATORRE, cedula nacional de identidad
			número seis millones doscientos siete mil doscientos trece guion k, chilena, casada, actriz, correo electrónico
			ssolimano@somosteatro.cl, con domicilio comercial en calle Badajoz número cien, oficina ciento siete, comuna de Las
			Condes, ciudad de Santiago, Región Metropolitana, se ha acordado celebrar el siguiente Contrato de Servicios:
		</p>

		<h4><strong>PRIMERO:</strong> De los comparecientes.</h4>
		<p style="font-size: 14px;">
			<strong>1.1</strong> Las partes reconocen disponer de las competencias y las capacidades necesarias para suscribir de mutua
			voluntad, el presente Contrato (en adelante indistintamente “el Contrato”), constituyendo un marco de actuación en la venta
			de funciones de teatro.
			<br/><br/>
			<strong>1.2</strong> Las partes, al disponer de la representatividad necesarias, podrán actuar en representación propia o de
			terceros.
		</p>

		<h4>SEGUNDO:</strong> De la Gestora Cultural.</h4>
		<p style="font-size: 14px;">
			<strong>2.1</strong> La Gestora Cultural cuenta con la representación necesaria para cerrar contratos de venta de funciones,
			sobre la obra de teatro denominada “'.$ObraNombre.'”.
		</p>

		<h4><strong>TERCERO:</strong> Del cliente.</h4>
		<p style="font-size: 14px;">
			<strong>3.1</strong> Que el cliente viene en contratar *una función(es), de la obra teatral denominada “'.$ObraNombre.'”,
			fijada(s) a las (Indicar hora), para el (o los días) '.Fecha_completa_alt($FechaReservada).', la(s) que ser realizará(n)
			en las dependencias del espacio escénico XXXXXXX ubicado en calle '.$ObraDireccion.', ciudad de '.$ObraCiudad.'.
		</p>

		<h4><strong>CUARTO:</strong> Del precio.</h4>
		<p style="font-size: 14px;">
			<strong>4.1</strong> El precio por la(s) función(es) de teatro, será de '.Valores($ObraValor, 0).' valor neto más impuestos.
			<br/><br/>
			<strong>4.2</strong> Cuando la función se dé fuera de la Región Metropolitana, las partes acuerdan que todos los costos relacionados a
			la alimentación, alojamiento y el transporte tanto del elenco, como del personal técnico junto a la escenografía de la obra de teatro,
			serán cubierto por el Comprador de la función.
		</p>

		<h4><strong>QUINTO:</strong> Del plazo.</h4>
		<p style="font-size: 14px;">
			<strong>5.1</strong> El presente contrato tendrá una duración de un año corrido, a contar del día de su firma.
			<br/><br/>
			<strong>5.2</strong> Sin perjuicio de lo anterior, las partes podrán poner término anticipado al presente contrato, en cualquier
			tiempo y sin causa alguna que lo justifique, mediante aviso enviado a la contraria, por medio de la dirección email registrada
			en la comparecencia, con una anticipación no inferior a cuarenta y cinco días corridos, respecto a la fecha establecida para
			la exhibición de la función teatral.
		</p>

		<h4><strong>SEXTO:</strong> De la forma de pago y facturación.</h4>
		<p style="font-size: 14px;">
			<strong>6.1</strong>El pago de cada función se realizará de la siguiente manera:
			<br/><br/>
			a) Un 10% al momento de confirmar la reserva y suscribir el presente contrato. Tiempo en el cual la Gestor Cultural emitirá
			la factura correspondiente a ese 10%.<br/>
			b) El saldo pendiente, correspondiente al 90% restante, el Comprador deberá pagarlo dentro de un plazo máximo de 30 días
			corridos posteriores a la fecha de la función, debiendo tener previamente en su poder, la respectiva factura emitida por
			Somos Teatro.<br/>
		</p>

		<h4><strong>SÉPTIMO:</strong> Cancelaciones</h4>
		<p style="font-size: 14px;">
			La cancelación de la función por caso fortuito o razones de fuerza mayor, dentro de los cinco primeros días, posteriores a la
			firma, dará derecho al Comprador, al rembolso integral del 10% anticipado, sin embargo, no se reembolsará dicho monto pasados
			los cinco días o en caso de que la cancelación se deba a un hecho imputable al cliente como:
			<br/><br/>
			<strong>7.1</strong> No cumplir con los términos y condiciones establecidos en el contrato<br/>
			<strong>7.2</strong> Quiebra o notoria insolvencia del cliente.<br/>
			<strong>7.3</strong> Cancelación por decisión unilateral del cliente, por motivos políticos, religiosos, culturales o simplemente
			no declarados.<br/>
			<strong>7.4</strong> No pago de gastos relacionados a la función, cuando esta se exhiba fuera de la Región Metropolitana.<br/>
			<strong>7.5</strong> En la eventualidad que no se pueda llevar a cabo la función acordada, por caso fortuito o razones de fuerza
			mayor, sin negligencia de alguna de las partes, tanto la Gestora Cultural como el Comprador están facultados para coordinarse y
			reprogramar la fecha de presentación, dando aviso a la Compañía de Teatro, con un mínimo de 10 días de antelación.
		</p>

		<h4><strong>OCTAVO:</strong> Contratos Vinculantes</h4>
		<p style="font-size: 14px;">
			<strong>8.1</strong> Los contratos firmados entre La Compañía de Teatro y Somos Teatro SpA, como entre El Comprador y Somos
			Teatro, son vinculantes, por lo que, en el caso de darse lo expresado en el punto anterior, dará derecho tanto a la Gestora
			Cultural como a la Compañía de Teatro, a exigir el pago total de la factura, a modo indemnizatorio.
		</p>

		<h4><strong>NOVENO:</strong> Responsabilidades de la Gestora Cultural.</h4>
		<p style="font-size: 14px;">
			<strong>9.1</strong> Será responsabilidad de la Gestora Cultural, administrar la venta de funciones teatrales, a través de
			los medios que considere más convenientes y oportunos.<br/>
			<strong>9.2</strong> Tendrá la facultad de proponer acuerdos, mediar en conflictos y asesorar en la coordinación entre la
			Compañía de Teatros y el Cliente.<br/>
			<strong>9.3</strong> Somos Teatro tendrá la exclusiva responsabilidad de realizar los cobros, sobre cada función realizada,
			debiendo emitir una factura dentro de un plazo máximo de 30 días corridos, antes de cada función.
		</p>


		<h4><strong>DÉCIMO:</strong> De la confidencialidad.</h4>
		<p style="font-size: 14px;">
			Las partes reconocen y aceptan el carácter confidencial y reservado del presente acuerdo y, especialmente, de aquella
			información que sea entregada recíprocamente entre las partes, durante la vigencia del mismo. Ninguna de las partes podrá
			divulgar su contenido sin autorización expresa de la otra parte.
		</p>

		<h4><strong>DÉCIMO PRIMERO:</strong> Relación laboral.</h4>
		<p style="font-size: 14px;">
			<strong>8.1</strong> Se deja expresa constancia que todo el personal que alguna de las partes deba disponer, para dar
			cumplimiento al presente contrato, serán de su única y exclusiva responsabilidad, por lo que no tienen ni tendrán vinculación
			laboral y de dependencia con la otra parte.
		</p>

		<h4><strong>DÉCIMO SEGUNDO:</strong> Disposiciones generales</h4>
		<p style="font-size: 14px;">
			En el evento de que alguna Cláusula o parte de ella sea declarada nula o no válida, dicha nulidad o falta de validez no
			afectará la validez del contrato ni de ninguna otra disposición en él contenida.<br/>
			La falta de ejercicio, ejercicio tardío o parcial de un derecho, la falta de insistencia en el cumplimiento de alguna
			obligación de alguna de las partes, la condonación de algún incumplimiento y otras situaciones análogas, no serán
			interpretadas como una renuncia tácita por parte de la otra respecto del ejercicio total y completo de sus derechos
			bajo el contrato.<br/>
			El presente contrato contiene el acuerdo íntegro entre las partes y sustituye cualquier otro acuerdo o negociación
			anterior entre las partes.
		</p>

		<h4><strong>DÉCIMO TERCERO:</strong> Cesión de Contrato.</h4>
		<p style="font-size: 14px;">
			Las partes no podrán ceder, transferir o gravar de cualquier forma el presente contrato o los derechos que de él emanen,
			sin consentimiento previo y escrito de la parte contraria.
		</p>

		<h4><strong>DÉCIMO CUARTO:</strong> Declaración.</h4>
		<p style="font-size: 14px;">
			El presente contrato no constituye asociación, jointventure, agencia, representación, ni sociedad entre los comparecientes.
			En consecuencia, las partes declaran ser personas jurídicas independientes una de las otras.
		</p>

		<h4><strong>DÉCIMO QUINTO:</strong> De la jurisdicción.</h4>
		<p style="font-size: 14px;">
			<strong>10.1</strong> Para todos los efectos legales del presente contrato, las partes fijan domicilio en la ciudad de
			Santiago y se someten a sus tribunales de justicia.
		</p>

		<h4><strong>DÉCIMO SEXTO:</strong> Controversias.</h4>
		<p style="font-size: 14px;">
			Toda controversia que surja entre las partes, sobre la interpretación del presente contrato, montos, pagos y otra circunstancia
			cualquiera, deberá ser resuelta por los Tribunales Ordinarios de Justicia de Santiago.
		</p>

		<h4><strong>DÉCIMO SÉPTIMO:</strong> Ejemplares.</h4>
		<p style="font-size: 14px;">
			El presente instrumento será firmado al final de este, mediante la utilización de firma electrónica, a la cual las partes
			reconocen la misma validez y autenticidad que cualquier firma física. Asimismo, este documento electrónico firmado por
			ambas partes tendrá validez y producirá los mismos efectos, que los celebrados en soporte de papel.
		</p>

		<h4><strong>DÉCIMO OCTAVO:</strong> Personerías.</h4>
		<p style="font-size: 14px;">
			La personería de Sandra Solimano Latorre para representar a la empresa Somos Teatro SpA, consta de escritura pública de
			fecha XXXXX, otorgada en la notaría de Santiago de don XXXXX.
		</p>

	</div>';

	/**************************************************************/
	return $Contrato;
}
/*******************************************************************************************************************/
//el contrato entre la administracion y la compañia de teatro
function polz_contrato_02($idUnidadNegocio, $color, $dbConn){

	/**************************************************************/
	// consulto los datos
	$SIS_query = '
	unidad_negocio_listado.Direccion AS ObraDireccion,

	compania_teatro_listado.Nombre AS CompaniaNombre,
	compania_teatro_listado.Rut AS CompaniaRut,
	compania_teatro_listado.RepLegalNombre AS CompaniaNombreRL,
	compania_teatro_listado.RepLegalRut AS CompaniaRutRL,
	compania_teatro_listado.Direccion AS CompaniaDireccion,

	comp_ciudad.Nombre AS CompaniaCiudad,
	comp_comunas.Nombre AS CompaniaComuna,
	obras_listado.Nombre AS ObraNombre,
	obras_listado.FichaValor AS ObraValor,
	obras_listado_calendario.Fecha AS FechaReservada,
	obra_ciudad.Nombre AS ObraCiudad,
	obra_comunas.Nombre AS ObraComuna
	';
	$SIS_join  = '
	LEFT JOIN `obras_listado`                            ON obras_listado.idObra                   = unidad_negocio_listado.idObra
	LEFT JOIN `compania_teatro_listado`                  ON compania_teatro_listado.idCompania     = obras_listado.idCompania
	LEFT JOIN `core_ubicacion_ciudad`   comp_ciudad      ON comp_ciudad.idCiudad                   = compania_teatro_listado.idCiudad
	LEFT JOIN `core_ubicacion_comunas`  comp_comunas     ON comp_comunas.idComuna                  = compania_teatro_listado.idComuna
	LEFT JOIN `obras_listado_calendario`                 ON obras_listado_calendario.idCalendario  = unidad_negocio_listado.idCalendario
	LEFT JOIN `core_ubicacion_ciudad`   obra_ciudad      ON obra_ciudad.idCiudad                   = unidad_negocio_listado.idCiudad
	LEFT JOIN `core_ubicacion_comunas`  obra_comunas     ON obra_comunas.idComuna                  = unidad_negocio_listado.idComuna
	';
	$SIS_where = 'unidad_negocio_listado.idUnidadNegocio = '.$idUnidadNegocio;
	$rowData = db_select_data (false, $SIS_query, 'unidad_negocio_listado', $SIS_join, $SIS_where, $dbConn, 'rowData', basename($_SERVER["REQUEST_URI"], ".php"), 'rowData');

	/**************************************************************/
	//variables
	if(isset($rowData['CompaniaNombre'])&&$rowData['CompaniaNombre']){        $CompaniaNombre     = $rowData['CompaniaNombre'];    }else{$CompaniaNombre    = '<strong style="color:red;">SIN DATOS</strong>';}
	if(isset($rowData['CompaniaRut'])&&$rowData['CompaniaRut']){              $CompaniaRut        = $rowData['CompaniaRut'];       }else{$CompaniaRut       = '<strong style="color:red;">SIN DATOS</strong>';}
	if(isset($rowData['CompaniaNombreRL'])&&$rowData['CompaniaNombreRL']){    $CompaniaNombreRL   = $rowData['CompaniaNombreRL'];  }else{$CompaniaNombreRL  = '<strong style="color:red;">SIN DATOS</strong>';}
	if(isset($rowData['CompaniaRutRL'])&&$rowData['CompaniaRutRL']){          $CompaniaRutRL      = $rowData['CompaniaRutRL'];     }else{$CompaniaRutRL     = '<strong style="color:red;">SIN DATOS</strong>';}
	if(isset($rowData['CompaniaCiudad'])&&$rowData['CompaniaCiudad']){        $CompaniaCiudad     = $rowData['CompaniaCiudad'];    }else{$CompaniaCiudad    = '<strong style="color:red;">SIN DATOS</strong>';}
	if(isset($rowData['CompaniaComuna'])&&$rowData['CompaniaComuna']){        $CompaniaComuna     = $rowData['CompaniaComuna'];    }else{$CompaniaComuna    = '<strong style="color:red;">SIN DATOS</strong>';}
	if(isset($rowData['CompaniaDireccion'])&&$rowData['CompaniaDireccion']){  $CompaniaDireccion  = $rowData['CompaniaDireccion']; }else{$CompaniaDireccion = '<strong style="color:red;">SIN DATOS</strong>';}
	if(isset($rowData['ObraNombre'])&&$rowData['ObraNombre']){                $ObraNombre         = $rowData['ObraNombre'];        }else{$ObraNombre        = '<strong style="color:red;">SIN DATOS</strong>';}
	if(isset($rowData['ObraValor'])&&$rowData['ObraValor']){                  $ObraValor          = $rowData['ObraValor'];         }else{$ObraValor         = '<strong style="color:red;">SIN DATOS</strong>';}
	if(isset($rowData['FechaReservada'])&&$rowData['FechaReservada']){        $FechaReservada     = $rowData['FechaReservada'];    }else{$FechaReservada    = '<strong style="color:red;">SIN DATOS</strong>';}
	if(isset($rowData['ObraCiudad'])&&$rowData['ObraCiudad']){                $ObraCiudad         = $rowData['ObraCiudad'];        }else{$ObraCiudad        = '<strong style="color:red;">SIN DATOS</strong>';}
	if(isset($rowData['ObraComuna'])&&$rowData['ObraComuna']){                $ObraComuna         = $rowData['ObraComuna'];        }else{$ObraComuna        = '<strong style="color:red;">SIN DATOS</strong>';}
	if(isset($rowData['ObraDireccion'])&&$rowData['ObraDireccion']){          $ObraDireccion      = $rowData['ObraDireccion'];     }else{$ObraDireccion     = '<strong style="color:red;">SIN DATOS</strong>';}

	/**************************************************************/
	$Contrato = '
	<div class="bs-example" data-example-id="simple-pre" >
		<div style="border-top:solid '.$color.' 1.0pt;border-left:none;border-bottom:solid '.$color.' 1.0pt; border-right:none;padding:1.0pt 0in 1.0pt 0in;margin-bottom:55px;margin-top: 55px;">
			<p style="margin: 0;text-align: center;font-size: 16.0pt;color: '.$color.';font-weight: bold;">Contrato para Venta de Funciones de Teatro (Compañía)</p>
		</div>

		<p style="font-size: 14px;">
			En Santiago de Chile, a '.Fecha_completa_alt(fecha_actual()).', entre don '.$CompaniaNombreRL.', cédula nacional de identidad
			Nº'.$CompaniaRutRL.', con domicilio en calle '.$CompaniaDireccion.', Comuna '.$CompaniaComuna.', Región de '.$CompaniaCiudad.',
			actuando en representaciòn de la Compañía de Teatro  '.$CompaniaNombre.' Rut '.$CompaniaRut.' , en adelante e indistintamente
			“La Compañía” y la Sociedad XXXXXXX RUT : XXXXXXXXX, actuando en representaciòn de la empresa Somos Teatro SpA, en adelante e
			indistintamente ”Somos Teatro” o “Gestora Cultural”, representada por Doña SANDRA MERCEDES SOLIMANO LATORRE, cedula nacional
			de identidad número seis millones doscientos siete mil doscientos trece guion k, chilena, casada, actriz, correo electrónico
			ssolimano@somosteatro.cl, con domicilio comercial en calle Badajoz número cien, oficina ciento siete, comuna de Las Condes,
			ciudad de Santiago, Región Metropolitana, se ha acordado celebrar el siguiente Contrato de Servicios:</p>

		<h4><strong>PRIMERO:</strong> De los comparecientes.</h4>
		<p style="font-size: 14px;">
			<strong>1.1</strong> Las partes reconocen disponer de las competencias y las capacidades necesarias para suscribir de mutua
			voluntad, el presente Contrato (en adelante indistintamente “el Contrato”), constituyendo un marco de actuación en la venta de
			funciones de la obra teatral denominada “'.$ObraNombre.'”.<br/><br/>
			<strong>1.2</strong> Las partes, al disponer de la representatividad necesarias, podrán actuar en representación propia o de terceros.
		</p>

		<h4><strong>SEGUNDO:</strong> De la Contratación.</h4>
		<p style="font-size: 14px;">
			<strong>2.1</strong> Que La Compañía contrata los servicios de comercialización de Somos Teatro SpA, para que gestione la venta de
			funciones de la obra ya descrita en la cláusula anterior, dentro del círculo de clientes que dispone, mientras esta se encuentre
			en exibición.
		</p>

		<h4><strong>TERCERO:</strong> De La Compañía</h4>
		<p style="font-size: 14px;">
			<strong>3.1</strong> Que La Compañía se encuentra plenamente capacitada para dar cumplimiento al presente contrato y realizar
			la(s) función(es) fijada(s) para el (o los días) '.Fecha_completa_alt($FechaReservada).', la(s) que se realizará(n) en las
			dependencias del espacio escénico XXXXXXX ubicada en calle '.$ObraDireccion.', ciudad de '.$ObraCiudad.'.
		</p>

		<h4><strong>CUARTO:</strong> De la Exclusividad</h4>
		<p style="font-size: 14px;">
			Con el propósito de resguardar el trabajo de la Gestora Cultural, sobre los cliente aportado por la misma y que lleguen a
			concretar la compra de funciones, la Compañía cederá a la Gestora sus derechos de comercialización de la obra, para con
			este cliente, por un periodo de 18 meses.
		</p>

		<h4><strong>QUINTO:</strong> Del Precio.</h4>
		<p style="font-size: 14px;">
			<strong>5.1</strong> El precio por la(s) función(es) de teatro, será de '.Valores($ObraValor, 0).' valor neto más impuestos.<br/><br/>
			<strong>5.2</strong> Cuando la función se dé fuera de la Región Metropolitana, todos los costos relacionados a la alimentación,
			alojamiento y el transporte tanto del elenco, como del personal técnico junto a la escenografía de la obra de teatro, deberán
			ser cubierto por el Comprador de la función.
		</p>

		<h4><strong>SEXTO:</strong> Del pago a Somos Teatro</h4>
		<p style="font-size: 14px;">
			<strong>6.1</strong> Se establece entre las partes que a la empresa Somos Teatro SpA, le corresponderá un 10% más impuesto, por la
			venta de cada función que llegue a concretar. Este monto lo pagará el comprador de la función, luego de haber firmado el respectivo
			contrato con la empresa Somos Teatro SpA, la que a su vez, le deberá emitir una factura por ese 10%.<br/><br/>
			<strong>6.2</strong> La factura del 90% restante, se la deberá emitir la Gestora Cultural al comprador, dentro de un plazo de 30
			días, antes de efectuarce la función. De igual forma, la Compañía de Teatro deberá hacer entrega a la empresa Somos Teatro SpA,
			de una factura por el 90% restante, luego de efectuada la función
		</p>

		<h4><strong>SEPTIMO:</strong> Del pago a la Compañía de Teatro.</h4>
		<p style="font-size: 14px;">
			<strong>7.1</strong> El saldo pendiente, se deberá pagar en un plazo máximo de 30 días corridos posteriores a la fecha de la función.<br/><br/>
			<strong>7.2</strong> Para el efecto, la Gestora Cultural tendrá la responsabilidad de cobrarle al Comprador, el saldo adeudado.<br/><br/>
			<strong>7.3</strong> El no cumplimiento de esta cláusula, por parte del Comprador, en su contrato vinculante con Somos Teatro SpA,
			dará derecho tanto a la Compañía de Teatro como a Somos Teatro, para dar inicio a un proceso legal indemnizatorio.<br/><br/>
			<strong>7.4</strong> Pagado este saldo por parte del Comprador, la Gestora Cultural tendrá un plazo máximo de 5 días hábiles para
			depositarle a su vez, a la Compañía de Teatro.
		</p>

		<h4><strong>OCTAVO:</strong> Del plazo.</h4>
		<p style="font-size: 14px;">
			<strong>8.1</strong> El presente contrato tendrá una duración de [____] meses, contados desde el día [___] de [_____] de 2024 hasta
			el día [____] de [_____] de 2024.<br/><br/>
			<strong>8.2</strong> Sin perjuicio de lo anterior, las partes podrán poner término anticipado al presente contrato en cualquier
			tiempo y sin causa alguna que lo justifique, mediante aviso enviado a la contraria por el email registrado en la comparecencia,
			con una anticipación no inferior a treinta días corridos respecto del día en el cual desee poner término al presente instrumento,
			sin dejar de mantener como válido, lo establecido en el punto Cuarto del presente contrato.
		</p>

		<h4><strong>NOVENO:</strong> La cancelación de la función</h4>
		<p style="font-size: 14px;">
			<strong>9.1</strong> Las partes podrán desistir voluntariamente del presente acuerdo, dentro de un plazo de 5 días hábiles, a
			contar de la firma del mismo, lo que obligará a la Gestora Cultural al reenbolso del 10% adelantado. Pasado ese tiempo, el 10%
			le corresponderá a Somos Teatro Spa.<br/><br/>
			<strong>9.2</strong> En el evento que el comprador deba cancelar la función por razones de fuerza mayor o un caso fortuito,
			evidente y justificado, este hecho obligará a la Gestora Cultural a reembolsar el pago realizado del 10%.<br/><br/>
			<strong>9.3</strong> En el caso que la Compañía de Teatro no pueda llevar a cabo la función acordada, por un caso fortuito
			o razones de fuerza mayor, esta podrá reagendar la fecha acordada, coordinando con la Gestora Cultural y dando aviso al
			Comprador, con un mínimo de 10 días de antelación. Si no fuera posible reagendar la función dentro de un plazo prudente,
			la Gestora Cultural deberá reembolsar el 10% pagado inicialmente.<br/><br/>
			<strong>9.4</strong> En caso que la cancelación de la obra tenga por motivo un hecho injustificado, imputable a La Compañía,
			la Gestora Cultural y el Comprador podrán exigir judicialmente reparación por la totalidad de los perjuicios generados.
		</p>

		<h4><strong>DÉCIMO:</strong> Responsabilidades de la Gestora Cultural.</h4>
		<p style="font-size: 14px;">
			<strong>9.1</strong> Será responsabilidad de la Gestora Cultural, gestionar y administrar la venta de funciones teatrales, a
			través de los medios que considere más convenientes y oportunos.<br/><br/>
			<strong>9.2</strong> Tendrá la facultad de proponer acuerdos, mediar en conflictos y eventualmente, colaborar en la coordinación
			entre la Compañía de Teatros y el Cliente Final.<br/><br/>
			<strong>9.3</strong> Somos Teatro tendrá la exclusiva responsabilidad de realizar los cobros, sobre cada función realizada,
			debiendo emitir al Comprador, una primera factura por el 10% inicial y una segunda factura, correspondiente al 90 restante,
			dentro de un plazo máximo de 30 días antes de la fecha establecida para la exhibición de la función.
		</p>

		<h4><strong>DÉCIMO PRIMERO:</strong> Obligaciones de La Compañía.</h4>
		<p style="font-size: 14px;">
			<strong>10.1</strong> Estar en posesión de todas las autorizaciones, licencias y derechos de exhibición pública de la obra,
			debiendo poner a disposición de la Gestora, antes del estreno, la documentación que acredite esta circunstancia.<br/><br/>
			<strong>10.2</strong> Disponer de un productor para coordinar y hacer entrega de la ficha técnica a la Gestora Cultural, asi
			como al Comprador, de la ficha artística del espectáculo, junto con una relación de necesidades técnicas y del personal. Esta
			gestión debe estar presente con al menos 2 semanas de antelación sobre la fecha prevista para la presentación.<br/><br/>
			<strong>10.3</strong> La Compañía deberá adaptarse en lo posible a las condiciones técnicas dispuestas por el cliente.<br/><br/>
			<strong>10.4</strong> Cualquier cambio que se produzca en el reparto, deberá ser debidamente informado al Comprador y a la
			Gestora Cultural, vía email, con a lo menos 1 semana de antelación.<br/><br/>
			<strong>10.5</strong> Entregar la obra totalmente montada y en condiciones para realizar la función, con todos los elementos
			necesarios para su exhibición, respetando el cumplimiento estricto de los horarios de actuación, la carga y descarga, montaje
			y desmontaje, conforme a lo previamente acordado entre la Compañía y el cliente Comprador.
		</p>

		<h4><strong>DÉCIMO SEGUNDO:</strong> Autorización de la Compañía</h4>
		<p style="font-size: 14px;">
			<strong>11.1</strong> Realizar grabaciones audiovisuales de la obra contratada, con finalidades promocionales, educativas,
			publicitarios o informativas, presentes o futuras y para sus archivos, sin que ello de derecho a percepciones económicas
			suplementarias ni al Comprador ni a la Gestora Cultural.<br/><br/>
			<strong>11.2</strong> De ser requerido, La Compañía se compromete a obtener de los miembros del elenco o personal de la
			obra, autorización para dicha grabación.<br/><br/>
			<strong>11.3</strong> La grabación audiovisual después de editada, podrá tener una duración máxima de tres minutos, a partir
			de tomas fragmentadas de la obra teatral.
		</p>

		<h4><strong>DÉCIMO TERCERO:</strong> De la confidencialidad.</h4>
		<p style="font-size: 14px;">
			Las partes reconocen y aceptan el carácter confidencial y reservado del presente acuerdo, especialmente, de aquella información
			que sea entregada recíprocamente entre las partes, durante la vigencia del mismo. Ninguna de las partes podrá divulgar su
			contenido sin autorización expresa de la otra parte.
		</p>

		<h4><strong>DÉCIMO CUARTO:</strong> Relación laboral.</h4>
		<p style="font-size: 14px;">
			<strong>13.1</strong> Se deja expresa constancia que todo el personal que alguna de las partes deba disponer, para dar
			cumplimiento al presente contrato, serán de su única y exclusiva responsabilidad, por lo que no tienen ni tendrán
			vinculación laboral ni dependencia con la Gestora Cultural.
		</p>

		<h4><strong>DÉCIMO QUINTO:</strong> Disposiciones generales.</h4>
		<p style="font-size: 14px;">
			En el evento de que alguna Cláusula o parte de ella sea declarada nula o no válida, dicha nulidad o falta de validez no
			afectará la validez del contrato ni de ninguna otra disposición en él contenida.<br/><br/>
			La falta de ejercicio, ejercicio tardío o parcial de un derecho, la falta de insistencia en el cumplimiento de alguna
			obligación de alguna de las partes, la condonación de algún incumplimiento y otras situaciones análogas, no serán
			interpretadas como una renuncia tácita por parte de la otra respecto del ejercicio total y completo de sus derechos
			bajo el contrato.<br/><br/>
			El presente contrato contiene el acuerdo íntegro entre las partes y sustituye cualquier otro acuerdo, negociación anterior
			entre las partes.
		</p>

		<h4><strong>DÉCIMO SEXTO:</strong> Cesión del Contrato.</h4>
		<p style="font-size: 14px;">
			Las partes no podrán ceder, transferir o gravar de cualquier forma el presente contrato o los derechos que de él emanen, sin
			consentimiento previo y escrito de la parte contraria.
		</p>

		<h4><strong>DÉCIMO SÉPTIMO:</strong> Declaración.</h4>
		<p style="font-size: 14px;">
			El presente contrato no constituye asociación, jointventure, agencia, representación, ni sociedad entre los comparecientes.
			En consecuencia, las partes declaran ser personas jurídicas independientes una de las otras.
		</p>

		<h4><strong>DÉCIMO OCTAVO:</strong> De la jurisdicción.</h4>
		<p style="font-size: 14px;">
			Para todos los efectos legales del presente contrato, las partes fijan domicilio en la ciudad de Santiago y se someten a sus
			tribunales de justicia.
		</p>

		<h4><strong>DÉCIMO NOVENO:</strong> Controversias</h4>
		<p style="font-size: 14px;">
			Toda controversia que surja entre las partes, sobre la interpretación del presente contrato, montos, pagos y otra circunstancia
			cualquiera, deberá ser resuelta por los Tribunales Ordinarios de Justicia.
		</p>

		<h4><strong>VIGÉSIMO:</strong> Ejemplares.</h4>
		<p style="font-size: 14px;">
			El presente instrumento será firmado al final de este, mediante la utilización de firma electrónica, a la cual las partes reconocen
			la misma validez y autenticidad que cualquier firma física. Asimismo, este documento electrónico firmado por ambas partes tendrá validez y producirá los mismos efectos, que los celebrados en soporte de papel.
		</p>

		<h4><strong>VIGÉCIMO PRIMERO:</strong> Personerías.</h4>
		<p style="font-size: 14px;">
			La personería de Sandra Solimano Latorre para representar a la empresa Somos Teatro SpA, consta de escritura pública de
			fecha ____________________, otorgada en la notaría de Santiago de don _________________.
		</p>

	</div>';

	/**************************************************************/
	return $Contrato;
}

?>
