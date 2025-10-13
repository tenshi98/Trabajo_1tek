<?php
//Variables
$arrMenu['admin']['Count']    = 0;
$arrMenu['informes']['Count'] = 0;
$arrMenu['otros']['Count']    = 0;
//variables
$arrMenu['admin']['Menu']    = '<li class="dropdown dropdown-large"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-list" aria-hidden="true"></i> Administracion <i class="fa fa-caret-down" aria-hidden="true"></i></a><ul class="dropdown-menu dropdown-menu-large row">';
$arrMenu['informes']['Menu'] = '<li class="dropdown dropdown-large"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-list" aria-hidden="true"></i> Informes <i class="fa fa-caret-down" aria-hidden="true"></i></a><ul class="dropdown-menu dropdown-menu-large row">';
$arrMenu['otros']['Menu']    = '<li class="dropdown dropdown-large"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-list" aria-hidden="true"></i> Otros <i class="fa fa-caret-down" aria-hidden="true"></i></a><ul class="dropdown-menu dropdown-menu-large row">';

//Verifico si existe menu
if(isset($_SESSION['usuario']['menu'])){

	//recorro el menu
	foreach($_SESSION['usuario']['menu'] as $menu=>$menuCat) {

		//Se crea la categoria
		$subMenu = '
		<li class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
			<ul>
				<li class="dropdown-tittle">'.TituloMenu($menu).'</li>';

				//Verifico si existen datos
				if(isset($_SESSION['usuario']['basic_data']['idSistema'])&&$_SESSION['usuario']['basic_data']['idSistema']!=''){
					//se crea la transaccion
					foreach($menuCat as $menuList) {
						/**************************************************/
						//variable
						$view_trans = 0;
						/**************************************************/
						//verifico
						//Todos
						if($menuList['idSistema']==9998){
							$view_trans++;
						//Solo Superadministradores
						}elseif($menuList['idSistema']==9999&&$_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
							$view_trans++;
						//Limitado a un sistema
						}elseif($menuList['idSistema']==$_SESSION['usuario']['basic_data']['idSistema']){
							$view_trans++;
						}
						/**************************************************/
						//valido
						if($view_trans!=0){
							$subMenu.= '<li><a href="'.$menuList['TransaccionURL'].'"><i class="'.$menuList['CategoriaIcono'].'" aria-hidden="true"></i> '.TituloMenu($menuList['TransaccionNombre']).'</a></li>';
						}
					}
				}
				$subMenu.= '
				<li class="divider"></li>
			</ul>
		</li>';

		/**************************************************/
		switch ($menu) {
			/******************************/
			case '1 - Administrar':
			case '2 - Administrar °C':
			case '3 - Administrar Agro':
			case '4 - Administrar Power':
				//Sumo
				$arrMenu['admin']['Count']++;
				if($arrMenu['admin']['Count']==3){$subMenu.= '<div class="clearfix"></div>';$arrMenu['admin']['Count'] = 0;}
				//Se agrega cadena
				$arrMenu['admin']['Menu'] .= $subMenu;
				break;
			/******************************/
			case '5 - Informes °C':
			case '6 - Informes Agro':
			case '7 - Informes Power':
				//Sumo
				$arrMenu['informes']['Count']++;
				if($arrMenu['informes']['Count']==3){$subMenu.= '<div class="clearfix"></div>';$arrMenu['informes']['Count'] = 0;}
				//Se agrega cadena
				$arrMenu['informes']['Menu'] .= $subMenu;
				break;
			/******************************/
			default:
				//Sumo
				$arrMenu['otros']['Count']++;
				if($arrMenu['otros']['Count']==3){$subMenu.= '<div class="clearfix"></div>';$arrMenu['otros']['Count'] = 0;}
				//Se agrega cadena
				$arrMenu['otros']['Menu'] .= $subMenu;
				break;
		}

	}
}
//se cierra menu
$arrMenu['admin']['Menu']    .= '</ul></li>';
$arrMenu['informes']['Menu'] .= '</ul></li>';
$arrMenu['otros']['Menu']    .= '</ul></li>';
?>

<ul class="nav navbar-nav">
	<li><a href="principal.php"><i class="fa fa-home" aria-hidden="true"></i> Principal</a></li>
	<?php
	echo $arrMenu['admin']['Menu'];
	echo $arrMenu['informes']['Menu'];
	echo $arrMenu['otros']['Menu'];
	?>
</ul>
