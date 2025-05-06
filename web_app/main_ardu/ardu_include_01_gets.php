<?php
/******************************************************************************************************/
/*                                                                                                    */
/*                               RECIBE TODOS LOS GETS ENVIADOS POR LOS EQUIPOS                       */
/*                                                                                                    */
/******************************************************************************************************/
////////////////// Recepcion variables //////////////////
//Si es POST
if(isset($_POST['id'])&&$_POST['id']){
	//Datos Varios
	if ( isset($_POST['lock'])){ $lock           = LimpiarInput($_POST['lock']);  }
	if (!empty($_POST['id'])){   $Identificador  = LimpiarInput($_POST['id']);    }
	if (!empty($_POST['f'])){    $Fecha          = LimpiarInput($_POST['f']);     }
	if (!empty($_POST['h'])){    $Hora           = LimpiarInput($_POST['h']);     }
	if ( isset($_POST['lt'])){   $GeoLatitud     = LimpiarInput($_POST['lt']);    }
	if ( isset($_POST['lg'])){   $GeoLongitud    = LimpiarInput($_POST['lg']);    }
	if ( isset($_POST['v'])){    $GeoVelocidad   = LimpiarInput($_POST['v']);     }
	if ( isset($_POST['d'])){    $GeoDireccion   = LimpiarInput($_POST['d']);     }
	if ( isset($_POST['dl'])){   $Dataloger      = LimpiarInput($_POST['dl']);    }
	//if ( isset($_POST['m'])){    $GeoMovimiento  = LimpiarInput($_POST['m']);     }
	//if ( isset($_POST['ups'])){  $ups            = LimpiarInput($_POST['ups']);   }
	//Sensores Telemetria
	for ($i_num = 1; $i_num <= 72; $i_num++) {
		if ( isset($_POST['s'.$i_num])){
			$Sensor[$i_num]['valor']   = LimpiarInput($_POST['s'.$i_num]);
			$Var_Counter               = $i_num;
		}
	}
//Si es por GET
}elseif(isset($_GET['id'])&&$_GET['id']){
	//Datos Varios
	if ( isset($_GET['lock'])){ $lock           = LimpiarInput($_GET['lock']);  }
	if (!empty($_GET['id'])){   $Identificador  = LimpiarInput($_GET['id']);    }
	if (!empty($_GET['f'])){    $Fecha          = LimpiarInput($_GET['f']);     }
	if (!empty($_GET['h'])){    $Hora           = LimpiarInput($_GET['h']);     }
	if ( isset($_GET['lt'])){   $GeoLatitud     = LimpiarInput($_GET['lt']);    }
	if ( isset($_GET['lg'])){   $GeoLongitud    = LimpiarInput($_GET['lg']);    }
	if ( isset($_GET['v'])){    $GeoVelocidad   = LimpiarInput($_GET['v']);     }
	if ( isset($_GET['d'])){    $GeoDireccion   = LimpiarInput($_GET['d']);     }
	if ( isset($_GET['dl'])){   $Dataloger      = LimpiarInput($_GET['dl']);    }
	//if ( isset($_GET['m'])){    $GeoMovimiento  = LimpiarInput($_GET['m']);     }
	//if ( isset($_GET['ups'])){  $ups            = LimpiarInput($_GET['ups']);   }
	//Sensores Telemetria
	for ($i_num = 1; $i_num <= 72; $i_num++) {
		if ( isset($_GET['s'.$i_num])){
			$Sensor[$i_num]['valor']   = LimpiarInput($_GET['s'.$i_num]);
			$Var_Counter               = $i_num;
		}
	}
//Si es por JSON
}else{
	/*$inputJSON = fileinput_contents('php://input');
	$input     = json_decode($inputJSON, TRUE);
	//Datos Varios
	if ( isset($input['lock'])){ $lock           = LimpiarInput($input['lock']);  }
	if (!empty($input['id'])){   $Identificador  = LimpiarInput($input['id']);    }
	if (!empty($input['f'])){    $Fecha          = LimpiarInput($input['f']);     }
	if (!empty($input['h'])){    $Hora           = LimpiarInput($input['h']);     }
	if ( isset($input['lt'])){   $GeoLatitud     = LimpiarInput($input['lt']);    }
	if ( isset($input['lg'])){   $GeoLongitud    = LimpiarInput($input['lg']);    }
	if ( isset($input['v'])){    $GeoVelocidad   = LimpiarInput($input['v']);     }
	if ( isset($input['d'])){    $GeoDireccion   = LimpiarInput($input['d']);     }
	//if ( isset($input['m'])){    $GeoMovimiento  = LimpiarInput($input['m']);     }
	//if ( isset($input['ups'])){  $ups            = LimpiarInput($input['ups']);   }
	//Sensores Telemetria
	for ($i_num = 1; $i_num <= 72; $i_num++) {
		if ( isset($input['s'.$i_num])){
			$Sensor[$i_num]['valor']   = LimpiarInput($input['s'.$i_num]);
			$Var_Counter               = $i_num;
		}
	}*/
}


?>
