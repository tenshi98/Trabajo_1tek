<?php
/*******************************************************************************************************************/
/*                                              Se define la clase                                                 */
/*******************************************************************************************************************/
class ConfigData{
    /*****************************************************/
    /*
    digit601_demo_core_engine
    fdCT%$].)k0!
    */
    //Variables para MySQL
    const MySQL = [
        'HOSTNAME' => 'localhost',
        'USERNAME' => 'root',
        'PASSWORD' => '',
        'DATABASE' => 'core_engine',
        'PORT'     => 3306,
    ];
    /*****************************************************/
    //Variables para SQLite
    const SQLite = [
        'ROUTE' => '/absolute/path/to/your/database.sqlite',
    ];
    /*****************************************************/
    //Variables para Mongo DB
    const MongoDB = [
        'HOST'     => 'localhost:27017',
        'DATABASE' => 'core_engine',
    ];
    /*****************************************************/
    //Variables para Jig
    const Jig = [
        'ROUTE' => 'db/data/',
    ];


}