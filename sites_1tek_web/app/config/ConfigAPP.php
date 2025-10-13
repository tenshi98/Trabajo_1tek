<?php
/*******************************************************************************************************************/
/*                                              Se define la clase                                                 */
/*******************************************************************************************************************/
class ConfigAPP{

    //Datos del Software
    const SOFTWARE = [
        'SoftwareName'    => '1Tek',                                                       //Nombre del software
        'SoftwareSlogan'  => 'Digitaliza tus procesos, simplifica tu camino al progreso',  //Slogan del software
        'CompanyName'     => '1Tek',                                                       //Nombre de la compañia
        'CompanyEmail'    => 'contacto@1Tek.cl',                                           //Email de la compañia
        'CompanyCredits'  => '',                                                           //Creditos
    ];

    //Configuracion de la aplicacion
    const APP = [
        'N_MaxItems'      => 10000,                                         //Numero maximo de registros sin paginar
        'N_Items'         => 60,                                            //Numero de registros a mostrar en la paginacion
        'uploadFolder'    => __DIR__ .'/../../../admin/sites_1tek/upload/', //Carpeta de subida de archivos
    ];

}