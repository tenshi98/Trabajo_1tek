<?php
//modificacion de la interfaz
if(isset($_SESSION['menu'])&&$_SESSION['menu']!=''){
	if($_SESSION['menu']!=3){
		$classnav = 'navvisibility';
	}else{
		$classnav = '';
	}
}else{
	$classnav = 'navvisibility';
}

//Creacion del menu
echo '<ul class="nav navbar-nav '.$classnav.'" id="navbar_nav" >
		<li><a href="principal.php"><i class="fa fa-home" aria-hidden="true"></i> Principal</a></li>
		<li><a href="principal_datos.php"><i class="fa fa-address-card-o" aria-hidden="true"></i> Mis Datos</a></li>';

	//Veo si existe el menu
	if(isset($_SESSION['usuario']['menu'])){
		//recorro el menu
		foreach($_SESSION['usuario']['menu'] as $menu=>$menuCat) {

			//si la transaccion actual es igual a la categoria
			if(isset($original, $_SESSION['usuario']['Permisos'][$original]['CategoriaNombre'])&&$menu==$_SESSION['usuario']['Permisos'][$original]['CategoriaNombre']){
				$menu_class='active';
			}else{
				$menu_class='';
			}

			//se le asigna color al icono
			if(isset($menuCat[0]['CategoriaIconoColor'])&&$menuCat[0]['CategoriaIconoColor']!=''){
				$Bgicolor = 'style="color: '.$menuCat[0]['CategoriaIconoColor'].';"';
			}else{
				$Bgicolor = '';
			}

			//Se crea la categoria
			echo '<li class="dropdown">';
				echo '<a href="#" class="dropdown-toggle '.$menu_class.'" data-toggle="dropdown">';
					echo '<i class="'.$menuCat[0]['CategoriaIcono'].'" aria-hidden="true" '.$Bgicolor.'></i>';
					echo '<span class="link-title"> '.TituloMenu($menu).'</span>';
					echo '<i class="fa fa-angle-down pull-right margin_width" aria-hidden="true"></i>';
				echo '</a>';
				echo '<ul class="dropdown-menu">';
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
								echo '<li><a href="'.$menuList['TransaccionURL'].'"><i class="'.$menuList['CategoriaIcono'].'" '.$Bgicolor.'></i> '.TituloMenu($menuList['TransaccionNombre']).'</a></li>';
							}
						}
					}
				echo '</ul>';
			echo '</li>';
		}
	}
	//Se crea el menu del super usuario
	if($_SESSION['usuario']['basic_data']['idTipoUsuario']==1){
		echo '<li class="dropdown ">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">Core - Sistema <i class="fa fa-angle-down" aria-hidden="true"></i></a>
			<ul class="dropdown-menu">
				<li><a href="core_sistemas.php?pagina=1">                    <i class="fa fa-cogs" aria-hidden="true"></i> Sistemas</a></li>
				<li><a href="core_usr_admin.php?pagina=1">                   <i class="fa fa-cogs" aria-hidden="true"></i> Listado de Administradores</a></li>

			</ul>
		</li>';
		echo '<li class="dropdown ">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">Core - Configuracion <i class="fa fa-angle-down" aria-hidden="true"></i></a>
			<ul class="dropdown-menu">
				<li><a href="core_comparacion_base.php">                     <i class="fa fa-cogs" aria-hidden="true"></i> Comparacion Base Datos</a></li>
				<li><a href="core_información_base.php">                     <i class="fa fa-cogs" aria-hidden="true"></i> Información Base Datos</a></li>
			</ul>
		</li>';
		echo '<li class="dropdown ">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">Core - Estado <i class="fa fa-angle-down" aria-hidden="true"></i></a>
			<ul class="dropdown-menu">
				<li><a href="core_info_sistema.php">                         <i class="fa fa-cogs" aria-hidden="true"></i> Información del servidor</a></li>
				<li><a href="core_log_cambios.php?pagina=1">                 <i class="fa fa-cogs" aria-hidden="true"></i> Cambios en el Sistema</a></li>
				<li><a href="core_mantenciones.php?pagina=1">                <i class="fa fa-cogs" aria-hidden="true"></i> Mantenciones al sistema</a></li>
				<li><a href="core_info_logs.php">                            <i class="fa fa-cogs" aria-hidden="true"></i> Logs de errores</a></li>
			</ul>
		</li>';
		echo '<li class="dropdown ">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">Core - Permisos <i class="fa fa-angle-down" aria-hidden="true"></i></a>
			<ul class="dropdown-menu">
				<li><a href="core_permisos_categorias.php?pagina=1">         <i class="fa fa-cogs" aria-hidden="true"></i> Permisos - Categorias</a></li>
				<li><a href="core_permisos_listado.php?pagina=1">            <i class="fa fa-cogs" aria-hidden="true"></i> Permisos - Listado</a></li>
			</ul>
		</li>';
		echo '<li class="dropdown ">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">Core - Pruebas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
			<ul class="dropdown-menu">
				<li><a href="core_cambio_usuario.php">                       <i class="fa fa-cogs" aria-hidden="true"></i> Cambio de Usuario</a></li>
				<li><a href="core_testing_code.php">                         <i class="fa fa-cogs" aria-hidden="true"></i> Testeo de codigo</a></li>
				<li><a href="core_test_email.php">                           <i class="fa fa-cogs" aria-hidden="true"></i> Testeo de correos</a></li>
				<li><a href="core_test_social.php">                          <i class="fa fa-cogs" aria-hidden="true"></i> Testeo de Whatsapp</a></li>
				<li><a href="core_test_sql_injected.php">                    <i class="fa fa-cogs" aria-hidden="true"></i> Testeo de SQL Injected</a></li>
			</ul>
		</li>';
		echo '<li class="dropdown ">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">Core - Seguridad <i class="fa fa-angle-down" aria-hidden="true"></i></a>
			<ul class="dropdown-menu">
				<li><a href="core_gestion_tickets_cerrar.php?pagina=1">      <i class="fa fa-cogs" aria-hidden="true"></i> Tickets Abiertos</a></li>
				<li><a href="core_sistema_seguridad_bloqueo.php?pagina=1">   <i class="fa fa-cogs" aria-hidden="true"></i> Seguridad - IP Bloqueadas</a></li>
				<li><a href="core_sistema_seguridad_ip_list.php">            <i class="fa fa-cogs" aria-hidden="true"></i> Seguridad - IP Relacionadas</a></li>
				<li><a href="core_sistema_seguridad_intento_hackeo.php">     <i class="fa fa-cogs" aria-hidden="true"></i> Seguridad - Intento Hackeo</a></li>
			</ul>
		</li>';

	}
	echo '</ul>';

?>
