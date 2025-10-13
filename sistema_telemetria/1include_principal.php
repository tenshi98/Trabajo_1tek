<?php
/*****************************************************************************************************************/
/*                                         Se arma la interfaz                                                   */
/*****************************************************************************************************************/
//Verifico si existe
if(isset($_SESSION['usuario']['basic_data']['idInterfaz'])&&$_SESSION['usuario']['basic_data']['idInterfaz']!=''){
    //INTERFACES
    switch ($_SESSION['usuario']['basic_data']['idInterfaz']) {
        case 1:  include '1include_principal_interfaz_1.php';  break;//Interfaz Nueva v1
        case 2:  include '1include_principal_interfaz_2.php';  break;//Interfaz Antigua
        case 3:  include '1include_principal_interfaz_3.php';  break;//Interfaz Nueva v2
        case 4:  include '1include_principal_interfaz_4.php';  break;//Interfaz Solo telemetria
        case 5:  include '1include_principal_interfaz_5.php';  break;//Interfaz Agro-Checking
        case 6:  include '1include_principal_interfaz_6.php';  break;//Interfaz 1tek
        case 7:  include '1include_principal_interfaz_7.php';  break;//Interfaz Intranet 1tek
        case 8:  include '1include_principal_interfaz_8.php';  break;//Interfaz Seguridad Vecinal
        case 9:  include '1include_principal_interfaz_9.php';  break;//Interfaz Administracion Sitios
        case 10: include '1include_principal_interfaz_10.php'; break;//Interfaz Walmart
        case 11: include '1include_principal_interfaz_11.php'; break;//Interfaz Jumbo
        case 12: include '1include_principal_interfaz_12.php'; break;//Interfaz Walmart 2
    }
}

?>

