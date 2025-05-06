<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')) {
    die('No tienes acceso a esta carpeta o archivo (Access Code 1003-008).');
}
/*******************************************************************************************************************/
/*                                                                                                                 */
/*                                                  Funciones                                                      */
/*                                                                                                                 */
/*******************************************************************************************************************/
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Cortar Texto
*
*===========================     Detalles    ===========================
* Permite cortar un texto determinado despues de cierta cantidad de
* caracteres determinados por el usuario, poniendo tres puntos
* suspensivos indicando que el texto esta cortado
*===========================    Modo de uso  ===========================
*
* 	//se ejecuta operacion
* 	cortar('Lorem ipsum dolor sit amet, consectetur', 10); //Devuelve 'Lorem ipsu...'
*
*===========================    Parametros   ===========================
* String   $texto     Texto a cortar
* int      $cuantos   Cantidad de caracteres a mostrar antes de cortar
* @return  String
************************************************************************/
//Funcion
function cortar($texto, $cuantos){

	/**********************/
	//Validaciones
	if (!validarNumero($cuantos)){  return 'El dato ingresado no es un numero';}
	if (!validaEntero($cuantos)){   return 'El dato ingresado no es un numero entero';}

	/**********************/
	//Si todo esta ok
	//si el largo texto es inferior a la cantidad a cortar
	if (strlen($texto) <= $cuantos){
		return $texto;
	//si el largo texto es superior a la cantidad a cortar
	}else{
		return substr($texto, 0, $cuantos) . '...';
	}

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Elimina el digito verificador
*
*===========================     Detalles    ===========================
* Elimina el digito verificador del rut entregado, dejando solo los
* numeros. Hay que tener en cuenta que solo funciona en Rut chilenos
*===========================    Modo de uso  ===========================
*
* 	//se ejecuta operacion
* 	cortarRut('10294658-9'); //Devuelve 10294658
*
*===========================    Parametros   ===========================
* String   $Rut    Rut a cortar
* @return  String
************************************************************************/
//Funcion
function cortarRut($Rut){
	//verifico si existe el guion
	$var1 = substr_count($Rut, '-');
	//se verifica el largo del texto
	$var2 = strlen($Rut);
	//se consulta
	if($var1==1){
		$x = $var2 - 2;
		return substr($Rut, 0, $x);
	}else{
		return $Rut;
	}
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Verificar largo
*
*===========================     Detalles    ===========================
* Verifica la cantidad de caracteres minimos dentro de la palabra u
* oracion a revisar
*===========================    Modo de uso  ===========================
*
* 	//se ejecuta operacion
* 	palabra_largo('Lorem', 10); //Devuelve 'El dato ingresado debe tener al menos 10 caracteres'
* 	palabra_largo('Lorem ipsum dolor sit amet, consectetur', 10); //Devuelve 1
*
*===========================    Parametros   ===========================
* String   $oracion   Palabra u oracion entregada
* int      $largo     Cantidad de caracteres minimos a admitir
* @return  String
************************************************************************/
//Funcion
function palabra_largo($oracion, $largo){

	/**********************/
	//Validaciones
	if (!validarNumero($largo)){ return 'El dato ingresado no es un numero';}
	if (!validaEntero($largo)){  return 'El dato ingresado no es un numero entero';}

	/**********************/
	//Si todo esta ok
	//se verifica el largo
	if (strlen($oracion) < $largo) {
		return 'El dato ingresado debe tener al menos '.$largo.' caracteres';
	}else{
		return true;
	}

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Verificar corto
*
*===========================     Detalles    ===========================
* Verifica la cantidad de caracteres maximo dentro de la palabra u
* oracion a revisar
*===========================    Modo de uso  ===========================
*
* 	//se ejecuta operacion
* 	palabra_corto('Lorem ipsum dolor sit amet, consectetur', 10); //Devuelve 'El dato ingresado debe tener no mas de 10 caracteres'
* 	palabra_corto('Lorem', 10); //Devuelve 1
*
*===========================    Parametros   ===========================
* String   $oracion   Palabra u oracion entregada
* int      $largo     Cantidad de caracteres maximo a admitir
* @return  String
************************************************************************/
//Funcion
function palabra_corto($oracion, $largo){

	/**********************/
	//Validaciones
	if (!validarNumero($largo)){ return 'El dato ingresado no es un numero';}
	if (!validaEntero($largo)){  return 'El dato ingresado no es un numero entero';}

	/**********************/
	//Si todo esta ok
	//se verifica el corto
	if (strlen($oracion) > $largo) {
		return 'El dato ingresado debe tener no mas de '.$largo.' caracteres';
	}else{
		return true;
	}

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Limpiar String
*
*===========================     Detalles    ===========================
* Permite limpiar palabras u oraciones de caracteres raros o no admitidos
*===========================    Modo de uso  ===========================
*
* 	//se ejecuta operacion
* 	limpiarString('Lorem ipsum\n dolor sit amet\n, consectetur\r'); //Devuelve 'Lorem ipsum dolor sit amet consectetur'
*
*===========================    Parametros   ===========================
* String   $texto   Texto a limpiar
* @return  String
************************************************************************/
//Funcion
function limpiarString($texto){

	/**********************/
	//Validaciones
	if(!isset($texto) OR $texto==''){  return 'No ha ingresado ningun dato';}

	/**********************/
	//Si todo esta ok
    //Se eliminan saltos de linea y pagina
    $texto = str_replace(array("\n", "\r"), '', $texto);
    $texto = str_replace('\n', '', $texto);
    $texto = str_replace('\r', '', $texto);
    //Limpieza caracteres normales
    $texto = preg_replace('([^A-Za-z0-9.])', ' ', $texto);
    $texto = strip_tags($texto, '');
    return $texto;
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Reemplazar espacios por guiones
*
*===========================     Detalles    ===========================
* Transforma los espacios dentro de una oracion a guiones bajos
*===========================    Modo de uso  ===========================
*
* 	//se ejecuta operacion
* 	espacio_guion('Lorem ipsum dolor sit amet, consectetur'); //Devuelve 'Lorem_ipsum_dolor_sit_amet,_consectetur'
*
*===========================    Parametros   ===========================
* String   $dato   Oracion a transformar
* @return  String
************************************************************************/
//Funcion
function espacio_guion($dato) {

	/**********************/
	//Validaciones
	if(!isset($dato) OR $dato==''){  return 'No ha ingresado ningun dato';}

	/**********************/
	//Si todo esta ok
    return str_replace(' ', '_', $dato);

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Reemplazar los caracteres especiales
*
*===========================     Detalles    ===========================
* Transforma los caracteres especiales por los estandares html
*===========================    Modo de uso  ===========================
*
* 	//se ejecuta operacion
* 	texto_mail('Lorem ipsum dolor sit amet, consectetur'); //Devuelve 'Lorem ipsum dolor sit amet, consectetur'
*
*===========================    Parametros   ===========================
* String   $dato   Oracion a transformar
* @return  String
************************************************************************/
//Funcion
function texto_mail($dato) {

	/**********************/
	//Validaciones
	if(!isset($dato) OR $dato==''){  return 'No ha ingresado ningun dato';}

	/**********************/
	//Si todo esta ok
    //Datos a cambiar
    $healthy = array("á", "é", "í", "ó", "ú", "ñ", "à", "è", "ò");
	$yummy   = array("&aacute;", "&eacute;", "&iacute;", "&oacute;", "&uacute;", "&ntilde;", "&agrave;", "&egrave;", "&ograve;");

    return str_replace($healthy, $yummy, $dato);

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Reemplazar los caracteres web
*
*===========================     Detalles    ===========================
* Transforma los caracteres estandares html por los especiales
*===========================    Modo de uso  ===========================
*
* 	//se ejecuta operacion
* 	DeSanitizar('Lorem ipsum dolor sit amet, consectetur'); //Devuelve 'Lorem ipsum dolor sit amet, consectetur'
*
*===========================    Parametros   ===========================
* String   $dato   Oracion a transformar
* @return  String
************************************************************************/
//Funcion
function DeSanitizar($dato) {

	/**********************/
	//Validaciones
	if(!isset($dato) OR $dato==''){  return 'No ha ingresado ningun dato';}

	/**********************/
	//Si todo esta ok
    //Datos a cambiar
	$healthy = array("&aacute;", "&eacute;", "&iacute;", "&oacute;", "&uacute;","&ntilde;", "&agrave;", "&egrave;", "&ograve;");
    $yummy   = array("á", "é", "í", "ó", "ú", "ñ", "à", "è", "ò");

    return str_replace($healthy, $yummy, $dato);

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Reemplaza las comillas
*
*===========================     Detalles    ===========================
* Reemplaza las comillas simples y dobles
*===========================    Modo de uso  ===========================
*
* 	//se verifica
* 	EstandarizarInput("bla"bla'bla"); //Devuelve 'bla%27bla%27bla'
*
*===========================    Parametros   ===========================
* String   $string   Texto a estandarizar
* @return  String
************************************************************************/
function EstandarizarInput($Data){

	/**********************/
	//Validaciones
	if(!isset($Data) OR $Data==''){  return 'No ha ingresado ningun dato';}

	/**********************/
	//Si todo esta ok
	//Se eliminan saltos de linea y pagina
	$Data = str_replace(array("\n", "\r"), '', $Data);
	$Data = strip_tags($Data, '');

	/******************************************/
	//Elimino los acentos y reemplazo la ñ
	$Data = texto_mail($Data);

	/******************************************/
	//Elimino las comillas simples y dobles
	$Data = str_replace("'", '%27', $Data);
	$Data = str_replace('"', '%22', $Data);

	return $Data;

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Base de datos con las palabras a censurar
*
*===========================     Detalles    ===========================
* Base de datos con las palabras a censurar
*===========================    Modo de uso  ===========================
*
* 	//se verifica
* 	bd_palabras_censuradas(1); //Devuelve el arreglo con palabras censuradas
*
*===========================    Parametros   ===========================
* int      $type   Tipo de base de datos
* @return  Array
************************************************************************/
function bd_palabras_censuradas($type) {

	/**********************/
	//Validaciones
	//se definen las opciones disponibles
	$requerido_1 = array(1,2,3,4);
	//verifico si el dato ingresado existe dentro de las opciones
	if (!in_array($type, $requerido_1)) {
		return false;
	}

	/**********************/
	//Si todo esta ok
	switch ($type) {
		/****************************************/
		case 1:
			//Lista de palabras censuradas en ingles
			$censuradas = array('fuck','horny','aroused','hentai','slut','slag','boob','pussy','vagina',
						'faggot','bugger','bastard','cunt','nigga','nigger','jerk','wanker',
						'tosser','shit','rape','rapist','dick','cock','whore','bitch','asshole',
						'twat','titt','piss','intercourse','sperm','spunk','testicle','milf',
						'retard','anus','dafuq','gay','lesbian','homo','homosexual','cum',
						'prostitute','wtf','penis','ffs','pedo','hack','dumb','crap','fuck you',
						'bullshit','damn','hell','ass','badass','son of a bitch','pissed off',
						'dickhead','motherfucker','dumbass','tramp');
			break;
		/****************************************/
		case 2:
			//Lista de palabras censuradas en español
			$censuradas = array('zorra', 'prostituta', 'cerda', 'mujer pública', 'mujer publica',
						'fulana','bruja', 'mujerzuela', 'mujer fácil', 'mujer facil', 'cortesana',
						'abanto', 'abrazafarolas', 'adufe', 'alcornoque', 'alfeñique', 'andurriasmo',
						'arrastracueros', 'artaban', 'atarre', 'baboso', 'barrabas', 'barriobajero',
						'bebecharcos', 'bellaco', 'belloto', 'berzotas', 'besugo', 'bobalicon',
						'bocabuzon', 'bocachancla', 'bocallanta', 'boquimuelle', 'borrico',
						'botarate', 'brasas', 'cabestro', 'cabezaalberca', 'cabezabuque',
						'cachibache', 'cafre', 'cagalindes', 'cagarruta', 'calambuco',
						'calamidad', 'calduo', 'calientahielos', 'calzamonas', 'cansalmas',
						'cantamañanas', 'capullo', 'caracaballo', 'caracarton', 'caraculo',
						'caraflema', 'carajaula', 'carajote', 'carapapa', 'carapijo', 'cazurro',
						'cebollino', 'cenizo', 'cenutrio', 'ceporro', 'cernicalo', 'charran',
						'chiquilicuatre', 'chirimbaina', 'chupacables', 'chupasangre', 'chupoptero',
						'cierrabares', 'cipote', 'comebolsas', 'comechapas', 'comeflores',
						'comestacas', 'cretino', 'cuerpoescombro', 'culopollo', 'descerebrado',
						'desgarracalzas', 'dondiego', 'donnadie', 'echacantos', 'ejarramantas',
						'energumeno', 'esbaratabailes', 'escolimoso', 'escornacabras', 'estulto',
						'fanfosquero', 'fantoche', 'fariseo', 'filimincias', 'foligoso', 'fulastre',
						'ganapan', 'ganapio', 'gandul', 'gañan', 'gaznapiro', 'gilipuertas',
						'giraesquinas', 'gorrino', 'gorrumino', 'guitarro', 'gurriato', 'habahela',
						'huelegateras', 'huevon', 'lamebotas', 'lamecharcos', 'lameculos', 'lameplatos',
						'lechuguino', 'lerdo', 'letrin', 'lloramigas', 'lumbreras', 'maganto',
						'majadero', 'malasangre', 'malasombra', 'malparido', 'mameluco', 'mamporrero',
						'manegueta', 'mangarran', 'mangurrian', 'mastuerzo', 'matacandiles', 'meapilas',
						'mendrugo', 'mentecato', 'mequetrefe', 'merluzo', 'metemuertos', 'metijaco',
						'mindundi', 'morlaco', 'morroestufa', 'muerdesartenes', 'orate', 'ovejo',
						'pagafantas', 'palurdo', 'pamplinas', 'panarra', 'panoli', 'papafrita',
						'papanatas', 'papirote', 'pardillo', 'parguela', 'pasmarote', 'pasmasuegras',
						'pataliebre', 'patan', 'pavitonto', 'pazguato', 'pecholata', 'pedorro',
						'peinabombillas', 'peinaovejas', 'pelagallos', 'pelagambas', 'pelagatos',
						'pelatigres', 'pelazarzas', 'pelele', 'pelma', 'percebe', 'perrocostra',
						'perroflauta', 'peterete', 'petimetre', 'picapleitos', 'pichabrava',
						'pillavispas', 'piltrafa', 'pinchauvas', 'pintamonas', 'piojoso', 'pitañoso',
						'pitofloro', 'plomo', 'pocasluces', 'pollopera', 'quitahipos', 'rastrapajo',
						'rebañasandias', 'revientabaules', 'rieleches', 'robaperas', 'sabandija',
						'sacamuelas', 'sanguijuela', 'sinentraero', 'sinsustancia', 'sonajas',
						'sonso', 'soplagaitas', 'soplaguindas', 'sosco', 'tagarote', 'tarado',
						'tarugo', 'tiralevitas', 'tocapelotas', 'tocho', 'tolai', 'tontaco',
						'tontucio', 'tordo', 'tragaldabas', 'tuercebotas', 'tunante', 'zamacuco',
						'zambombo', 'zampabollos', 'zamugo', 'zangano', 'zarrapastroso', 'zascandil',
						'zopenco', 'zoquete', 'zote', 'zullenco', 'zurcefrenillos', 'mamon');
			break;
		/****************************************/
		case 3:
			//Lista de palabras censuradas chilenas
			$censuradas = array('amermelao', 'antifoca', 'apitutaa', 'apitutada', 'apitutado', 'apitutao',
						'apretao', 'atao', 'ataoso', 'bacan', 'bajon', 'bajoneao', 'bajonearse',
						'barateli', 'barsa', 'barsuo', 'bolsera', 'bolsero', 'cachai', 'cachar',
						'cacheteo', 'cacheton', 'cachetona', 'cacho', 'cagada', 'cagarla', 'cagarse',
						'cagaste', 'cahuin', 'cahuinera', 'caleta', 'charcha', 'charchas', 'chauchas',
						'chorear', 'chorearse', 'chucha', 'chucha tu madre', 'chuche tu madre',
						'chula', 'chuleteo', 'chulo', 'concha tu madre', 'conche tu madre', 'copete',
						'copucha', 'copuchar', 'copuchenta', 'copuchento', 'corremano', 'correr mano',
						'creerse la muerte', 'cresta', 'cuatico', 'cuevuo', 'cuica', 'cuico',
						'dejar la cagada', 'dejar la crema', 'dejar la escoba', 'el descueve',
						'engrupir', 'facha', 'facho', 'fleto', 'fome', 'funao', 'funar', 'hocicon',
						'hocicona', 'hociconear', 'hueada', 'hueco', 'julepe', 'lacha', 'lacho',
						'lanza', 'lanzazo', 'lesear', 'leseo', 'manoseo', 'ni ahi', 'ni cagando',
						'nica', 'no estar ni ahi', 'paco', 'paja', 'pajaron', 'pajear', 'pajearse',
						'pajera', 'pajero', 'pelotillehue', 'penca', 'pito', 'pucho', 'pulento',
						'punga', 'puta', 'valer hongo', 'volao', 'volarse', 'agüevonao', 'agüevona',
						'agüevonada', 'ahueonao', 'ahueona', 'ahueonada', 'awueonao', 'awueona',
						'awueonada', 'güevon', 'güevona', 'güeon', 'güeona', 'güevada', 'guevon',
						'guevona', 'gueon', 'guevada', 'gueona', 'huevon', 'huevona', 'huevonada',
						'hueon', 'hueona', 'hueonada', 'huevada', 'hueveo', 'wueon', 'wuevada',
						'wueveo', 'concha tu madre', 'conchetumare', 'conchatumare', 'conche tu mare',
						'concha tu mare', 'conche tumare', 'concha tumare', 'conchesumare', 'conchasumare',
						'conche su mare', 'concha su mare', 'conche sumare', 'concha sumare', 'culiao',
						'gil', 'agilao', 'agila', 'sapo culiao', 'tragasables', 'jolaperra', 'maricon',
						'maricona', 'perkin', 'longi', 'sacoweas', 'mermelao', 'weon', 'weona', 'pichula',
						'tula', 'wueona', 'pija', 'marica');
			break;
		/****************************************/
		case 4:
			//Lista de palabras inclusivas
			$censuradas = array('aliades', 'elles', 'cuerpa');
			break;
	}

	return $censuradas;

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Cuenta si hay palabras malas u ofensivas
*
*===========================     Detalles    ===========================
* Cuenta si hay palabras malas u ofensivas que esten prohibidas por el
* sistema
*===========================    Modo de uso  ===========================
*
* 	//se ejecuta operacion
* 	contar_palabras_censuradas('Lorem ipsum dolor sit amet, fuck d'); //Devuelve 1
*
*===========================    Parametros   ===========================
* String   $oracion   Oracion a revisar
* @return  Integer
************************************************************************/
//Funcion
function contar_palabras_censuradas($oracion) {

	/*
utf8_decode($oracion);
mb_convert_encoding($oracion, 'ISO-8859-1', 'UTF-8');

utf8_encode($cadena);
mb_convert_encoding($cadena, 'UTF-8', 'ISO-8859-1');
	*/

    //se definen las letras a reemplazar
    $originales   = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿª';
    $modificadas  = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybya';
    $cadena       = mb_convert_encoding($oracion, 'ISO-8859-1', 'UTF-8');
    $cadena       = strtr($cadena, mb_convert_encoding($originales, 'ISO-8859-1', 'UTF-8'), $modificadas);
    $oracion      = mb_convert_encoding($cadena, 'UTF-8', 'ISO-8859-1');
    //se cambian todas las letras a minusculas
    $oracion      = strtolower($oracion);
	//bd con las palabras
    $censuradas_1 = bd_palabras_censuradas(1);
    $censuradas_2 = bd_palabras_censuradas(2);
    $censuradas_3 = bd_palabras_censuradas(3);
    $censuradas_4 = bd_palabras_censuradas(4);

	//Contamos la partes
	$partes_1   = count($censuradas_1);
	$partes_2   = count($censuradas_2);
	$partes_3   = count($censuradas_3);
	$partes_4   = count($censuradas_4);
	$contador   = 0;

	//Recorremos la cadena para censurar las palabras prohibidas en ingles
	for ($i=0; $i < $partes_1; $i++) {
		if( strpos($oracion,' '.$censuradas_1[$i].' ') !== false ){
			//Cuenta las prohibidas
			$contador++;
		}
	}
	//Recorremos la cadena para censurar las palabras prohibidas en español
	for ($i=0; $i < $partes_2; $i++) {
		if( strpos($oracion,' '.$censuradas_2[$i].' ') !== false ){
			//Cuenta las prohibidas
			$contador++;
		}
	}
	//Recorremos la cadena para censurar las palabras prohibidas chilenas
	for ($i=0; $i < $partes_3; $i++) {
		if( strpos($oracion,' '.$censuradas_3[$i].' ') !== false ){
			//Cuenta las prohibidas
			$contador++;
		}
	}
	//Recorremos la cadena para censurar las palabras prohibidas inclusivas
	for ($i=0; $i < $partes_4; $i++) {
		if( strpos($oracion,' '.$censuradas_4[$i].' ') !== false ){
			//Cuenta las prohibidas
			$contador++;
		}
	}

	//Numero de palabras prohibidas
	return $contador;

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Filtra si hay palabras malas u ofensivas
*
*===========================     Detalles    ===========================
* Filtra si hay palabras malas u ofensivas que esten prohibidas por el
* sistema, reemplazandolas por un ****
*===========================    Modo de uso  ===========================
*
* 	//se ejecuta operacion
* 	filtrar_palabras_censuradas('Lorem ipsum dolor sit amet, fuck d'); //Devuelve 'lorem ipsum dolor sit amet, **** d'
*
*===========================    Parametros   ===========================
* String   $oracion   Oracion a revisar
* @return  String
************************************************************************/
//Funcion
function filtrar_palabras_censuradas($oracion) {

		/*
utf8_decode($oracion);
mb_convert_encoding($oracion, 'ISO-8859-1', 'UTF-8');

utf8_encode($cadena);
mb_convert_encoding($cadena, 'UTF-8', 'ISO-8859-1');
	*/

    //se definen las letras a reemplazar
    $originales   = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿª';
    $modificadas  = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybya';
    $cadena       = mb_convert_encoding($oracion, 'ISO-8859-1', 'UTF-8');
    $cadena       = strtr($cadena, mb_convert_encoding($originales, 'ISO-8859-1', 'UTF-8'), $modificadas);
    $oracion      = mb_convert_encoding($cadena, 'UTF-8', 'ISO-8859-1');
    //se cambian todas las letras a minusculas
    $oracion      = strtolower($oracion);
	//bd con las palabras
    $censuradas_1 = bd_palabras_censuradas(1);
    $censuradas_2 = bd_palabras_censuradas(2);
    $censuradas_3 = bd_palabras_censuradas(3);
    $censuradas_4 = bd_palabras_censuradas(4);

	//Contamos la partes
	$partes_1   = count($censuradas_1);
	$partes_2   = count($censuradas_2);
	$partes_3   = count($censuradas_3);
	$partes_4   = count($censuradas_4);

	//Recorremos la cadena para censurar las palabras prohibidas en ingles
	for ($i=0; $i < $partes_1; $i++) {
		if( strpos($oracion,' '.$censuradas_1[$i].' ') !== false ){
			//Replazamos las prohibidas con ****
			$oracion = str_replace($censuradas_1[$i],'****',$oracion);
		}
	}
	//Recorremos la cadena para censurar las palabras prohibidas en español
	for ($i=0; $i < $partes_2; $i++) {
		if( strpos($oracion,' '.$censuradas_2[$i].' ') !== false ){
			//Replazamos las prohibidas con ****
			$oracion = str_replace($censuradas_2[$i],'****',$oracion);
		}
	}
	//Recorremos la cadena para censurar las palabras prohibidas chilenas
	for ($i=0; $i < $partes_3; $i++) {
		if( strpos($oracion,' '.$censuradas_3[$i].' ') !== false ){
			//Replazamos las prohibidas con ****
			$oracion = str_replace($censuradas_3[$i],'****',$oracion);
		}
	}
	//Recorremos la cadena para censurar las palabras prohibidas inclusivas
	for ($i=0; $i < $partes_4; $i++) {
		if( strpos($oracion,' '.$censuradas_4[$i].' ') !== false ){
			//Replazamos las prohibidas con ****
			$oracion = str_replace($censuradas_4[$i],'****',$oracion);
		}
	}

	//Frase limpia de palabras prohibidas
	return $oracion;

}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Genera un cuadro de alerta
*
*===========================     Detalles    ===========================
* Permite generar un cuadro de alerta personalizado
*===========================    Modo de uso  ===========================
* 	//se imprime input
* 	super_title(1,1,1,'','dato' ); //Devuelve HTML
* 	super_title(2,2,1,'','dato' ); //Devuelve HTML
* 	super_title(3,3,1,'','dato' ); //Devuelve HTML
*
*===========================    Parametros   ===========================
* int      $Type    Tipo de elemento
* int      $Color   Color del elemento
* int      $Align   Alineacion del elemento
* String   $Style   Estilo extra del elemento
* String   $Text    Texto del elemento
* @return  HTML
************************************************************************/
//Funcion
function super_title($Type, $Color, $Align, $Style, $Text){

	/**********************/
	//conteo
	$nerrors = 0;
	//Validaciones
	if(!validarNumero($Type)){   $nerrors++; alert_post_data(4,1,1,0, 'No ha ingresado un numero en $Type');}
	if(!validarNumero($Color)){  $nerrors++; alert_post_data(4,1,1,0, 'No ha ingresado un numero en $Color');}
	if(!validarNumero($Align)){  $nerrors++; alert_post_data(4,1,1,0, 'No ha ingresado un numero en $Align');}

	/**********************/
	//Si todo esta ok
	//Valido si los datos ingresados estan correctos
	if ($nerrors==0){
		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido_1 = array(1,2,3,4,5,6,7,8);
		$requerido_2 = array(1,2,3,4,5,6,7,8);
		$requerido_3 = array(1,2,3);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($Type, $requerido_1)) {
			alert_post_data(4,1,1,0, 'La configuracion $Type entregada no esta dentro de las opciones');
			$errorn++;
		}
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($Color, $requerido_2)) {
			alert_post_data(4,1,1,0, 'La configuracion $Color entregada no esta dentro de las opciones');
			$errorn++;
		}
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($Align, $requerido_3)) {
			alert_post_data(4,1,1,0, 'La configuracion $Align entregada no esta dentro de las opciones');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){
			//Selecciono el tipo de titulo
			$options = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p', 'strong'];
			$tipo    = $options[$Type-1];

			//Selecciono el color
			$options = ['', 'text-muted', 'text-primary', 'text-warning', 'text-danger', 'text-success', 'text-info', 'text-facture'];
			$color   = $options[$Color-1];

			//Selecciono el tipo de mensaje
			$options = ['text-align: left;', 'text-align: center;', 'text-align: right;'];
			$align   = $options[$Align-1];

			/******************************************/
			//generacion del input
			$input = '<'.$tipo.' class="'.$color.' '.$Style.'" style="'.$align.'">'.$Text.'</'.$tipo.'>';

			//Imprimir dato
			echo $input;
		}
	}
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Genera un cuadro de alerta
*
*===========================     Detalles    ===========================
* Permite generar un cuadro de alerta personalizado
*===========================    Modo de uso  ===========================
* 	//se imprime input
* 	divider_line(1,1,1); //Devuelve HTML
* 	divider_line(2,2,1); //Devuelve HTML
* 	divider_line(3,3,1); //Devuelve HTML
*
*===========================    Parametros   ===========================
* int      $Type         Tipo de elemento
* int      $Color        Color del elemento
* int      $InnerColor   Color interno del elemento
* @return  HTML
************************************************************************/
//Funcion
function divider_line($Type, $Color, $InnerColor){

	/**********************/
	//conteo
	$nerrors = 0;
	//Validaciones
	if(!validarNumero($Type)){        $nerrors++; alert_post_data(4,1,1,0, 'No ha ingresado un numero en $Type');}
	if(!validarNumero($Color)){       $nerrors++; alert_post_data(4,1,1,0, 'No ha ingresado un numero en $Color');}
	if(!validarNumero($InnerColor)){  $nerrors++; alert_post_data(4,1,1,0, 'No ha ingresado un numero en $InnerColor');}

	/**********************/
	//Si todo esta ok
	//Valido si los datos ingresados estan correctos
	if ($nerrors==0){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido_1 = array(1,2,3,4,5);
		$requerido_2 = array(1,2,3,4,5,6,7);
		$requerido_3 = array(1);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($Type, $requerido_1)) {
			alert_post_data(4,1,1,0, 'La configuracion $Type entregada no esta dentro de las opciones');
			$errorn++;
		}
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($Color, $requerido_2)) {
			alert_post_data(4,1,1,0, 'La configuracion $Color entregada no esta dentro de las opciones');
			$errorn++;
		}
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($InnerColor, $requerido_3)) {
			alert_post_data(4,1,1,0, 'La configuracion $InnerColor entregada no esta dentro de las opciones');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){
			//Selecciono el tipo de titulo
			$options = ['', 'div-arrow-down', 'div-tab-down', 'div-stopper', 'div-dot'];
			$tipo    = $options[$Type-1];

			//Selecciono el tipo de titulo
			$options = ['', 'div-muted', 'div-primary', 'div-warning', 'div-danger', 'div-success', 'div-info'];
			$color   = $options[$Color-1];

			//Selecciono el color
			$options  = [''];
			$colorInt = $options[$InnerColor-1];

			/******************************************/
			//generacion del input
			$input = '<div class="'.$color.' divider div-transparent '.$tipo.' '.$colorInt.'"></div>';

			//Imprimir dato
			echo $input;
		}
	}
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////
/***********************************************************************
* Genera un cuadro de alerta
*
*===========================     Detalles    ===========================
* Permite generar un cuadro de alerta personalizado
*===========================    Modo de uso  ===========================
* 	//se imprime input
* 	hr_line(1,1); //Devuelve HTML
* 	hr_line(2,1); //Devuelve HTML
* 	hr_line(3,1); //Devuelve HTML
*
*===========================    Parametros   ===========================
* int      $Type    Tipo de elemento
* int      $Color   Color del elemento
* @return  HTML
************************************************************************/
//Funcion
function hr_line($Type, $Color){

	/**********************/
	//conteo
	$nerrors = 0;
	//Validaciones
	if(!validarNumero($Type)){        $nerrors++; alert_post_data(4,1,1,0, 'No ha ingresado un numero en $Type');}
	if(!validarNumero($Color)){       $nerrors++; alert_post_data(4,1,1,0, 'No ha ingresado un numero en $Color');}

	/**********************/
	//Si todo esta ok
	//Valido si los datos ingresados estan correctos
	if ($nerrors==0){

		/********************************************************/
		//Definicion de errores
		$errorn = 0;
		//se definen las opciones disponibles
		$requerido_1 = array(1,2,3,4,5,6,7,8,9);
		$requerido_2 = array(1,2,3,4,5,6,7);
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($Type, $requerido_1)) {
			alert_post_data(4,1,1,0, 'La configuracion $Type entregada no esta dentro de las opciones');
			$errorn++;
		}
		//verifico si el dato ingresado existe dentro de las opciones
		if (!in_array($Color, $requerido_2)) {
			alert_post_data(4,1,1,0, 'La configuracion $Color entregada no esta dentro de las opciones');
			$errorn++;
		}
		/********************************************************/
		//Ejecucion si no hay errores
		if($errorn==0){
			//Selecciono el tipo de titulo
			$options = ['', 'hr-muted', 'hr-primary', 'hr-warning', 'hr-danger', 'hr-success', 'hr-info'];
			$color   = $options[$Color-1];
			/******************************************/
			//generacion del input
			$input = '<hr class="'.$color.' hr_style-'.$Type.'">';

			//Imprimir dato
			echo $input;
		}
	}
}



?>
