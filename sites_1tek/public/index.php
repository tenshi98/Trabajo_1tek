<?php
/**********************************************************************************************************************************/
/*                                                       Include classes                                                          */
/**********************************************************************************************************************************/
//Variables
$Autoload = '../../vendors/application/controller/;'; //Controladores
$Autoload.= ' ../../vendors/application/models/;';    //Modelos
$Autoload.= ' ../../vendors/application/utils/;';     //Utilidades
$Autoload.= ' ../../vendors/application/functions/;'; //Funciones
//Se cargan los archivos de configuracion
$Autoload.= ' ../app/config/;'; //carpeta
//Se escanea la carpeta con los modulos
$x_Directory = '../app/modules/';
$x_List      = scandir($x_Directory);
//Se eliminan los datos innecesarios
unset($x_List[array_search('.', $x_List, true)]);
unset($x_List[array_search('..', $x_List, true)]);
unset($x_List[array_search('.htaccess', $x_List, true)]);
//Se recorre y se agregan los modulos existentes
foreach ($x_List as $list) {
    $Autoload.= ' '.$x_Directory.'/'.$list.'/controller/;';
}

//Base
$f3 = require('../../vendors/fatfree/base.php'); //Base
$f3->set('AUTOLOAD',$Autoload);                  //Autoload



/**********************************************************************************************************************************/
/*                                                           Loads                                                                */
/**********************************************************************************************************************************/

/*************************************************************/
/*             Rutas para usuarios no logueados              */
/*************************************************************/
/******************************/
//rutas disponibles
$f3->route('GET /', 'main->index'); //Vista - de la pagina
$f3->route('GET /feature/view/@id', 'main->View');          //Mostrar Detallado


$f3->route('GET /crearProyecto', 'main->index'); //Vista - de la pagina
$f3->route('GET /solicitarReunion', 'main->index'); //Vista - de la pagina


/******************************/
//Pagina de error
//$f3->route('GET /error', 'main->error404');
/******************************/
//Error en caso de no existir ruta
//$f3->set('ONERROR',function($f3){$f3->reroute('/error');});
//Ejecuta
$f3->run();