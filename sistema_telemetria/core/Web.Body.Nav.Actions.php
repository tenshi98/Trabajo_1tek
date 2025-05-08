<?php
//verifico la existencia
if (isset($_SESSION['usuario']['basic_data']['Direccion_img'])&&$_SESSION['usuario']['basic_data']['Direccion_img']!='') {
    $srcFileNavAc = 'upload/Usuarios/'.$_SESSION['usuario']['basic_data']['Direccion_img'];
}else{
    $srcFileNavAc = DB_SITE_REPO.'/LIB_assets/img/usr.png';
}
?>
<ul class="nav navbar-nav navbar-right nav_user">
	<li class="dropdown">
		<a href="#" data-toggle="dropdown" class="dropdown-toggle user-action">
            <img src="<?php echo $srcFileNavAc ?>" class="avatar" alt="Avatar"> <?php echo $_SESSION['usuario']['basic_data']['Nombre']; ?> <i class="fa fa-caret-down" aria-hidden="true"></i>
        </a>
		<ul class="dropdown-menu">
			<li><a href="principal_datos.php"><i class="fa fa-user-o" aria-hidden="true"></i> Editar Perfil</a></li>

             <?php
            //Solo si es administrador
            if (isset($_SESSION['usuario']['basic_data']['idTipoUsuario'])&&$_SESSION['usuario']['basic_data']['idTipoUsuario']==1) {

                echo '<li class="divider"></li>';
                echo '<li><a href="core_sistemas.php?pagina=1">                    <i class="fa fa-cogs" aria-hidden="true"></i> Sistema - Listado Sistemas</a></li>';
				echo '<li><a href="core_usr_admin.php?pagina=1">                   <i class="fa fa-cogs" aria-hidden="true"></i> Sistema - Listado de Administradores</a></li>';
                echo '<li><a href="core_test_email.php">                           <i class="fa fa-cogs" aria-hidden="true"></i> Sistema - Testeo de correos</a></li>';
                echo '<li><a href="core_test_social.php">                          <i class="fa fa-cogs" aria-hidden="true"></i> Sistema - Testeo de Whatsapp</a></li>';
                echo '<li><a href="core_cambio_usuario.php">                       <i class="fa fa-cogs" aria-hidden="true"></i> Sistema - Cambio de Usuario</a></li>';

                echo '<li class="divider"></li>';
                echo '<li><a href="core_info_sistema.php">                         <i class="fa fa-cogs" aria-hidden="true"></i> Estado - Información del servidor</a></li>';
				echo '<li><a href="core_info_logs.php">                            <i class="fa fa-cogs" aria-hidden="true"></i> Estado - Logs de errores</a></li>';
                echo '<li><a href="core_log_cambios.php?pagina=1">                 <i class="fa fa-cogs" aria-hidden="true"></i> Estado - Cambios en el Sistema</a></li>';

                echo '<li class="divider"></li>';
                echo '<li><a href="core_permisos_categorias.php?pagina=1">         <i class="fa fa-cogs" aria-hidden="true"></i> Permisos - Categorias</a></li>';
				echo '<li><a href="core_permisos_listado.php?pagina=1">            <i class="fa fa-cogs" aria-hidden="true"></i> Permisos - Listado</a></li>';

                echo '<li class="divider"></li>';
                echo '<li><a href="core_sistema_seguridad_bloqueo.php?pagina=1">   <i class="fa fa-cogs" aria-hidden="true"></i> Seguridad - IP Bloqueadas</a></li>';
				echo '<li><a href="core_sistema_seguridad_intento_hackeo.php">     <i class="fa fa-cogs" aria-hidden="true"></i> Seguridad - Intento Hackeo</a></li>';
                echo '<li><a href="core_mantenciones.php?pagina=1">                <i class="fa fa-cogs" aria-hidden="true"></i> Seguridad - Mantenciones al sistema</a></li>';
                echo '<li><a href="core_sistema_seguridad_ip_list.php">            <i class="fa fa-cogs" aria-hidden="true"></i> Seguridad - IP Relacionadas</a></li>';

            }
            ?>
			<li class="divider"></li>
            <?php if((isset($_SESSION['usuario']['basic_data']['COunt'])&&$_SESSION['usuario']['basic_data']['COunt']>1) OR $_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?>
                <li><a href="index_select.php?bla=true"><i class="fa fa-exchange" aria-hidden="true"></i> Cambio Sistema</a></li>
		    <?php } ?>
			<li class="divider"></li>
            <?php
            $ubicacion = $original.'?salir=true';
            $dialogo   = '¿Realmente desea cerrar su sesion?'; ?>
			<li><a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Cerrar sesion" class="power_off"><i class="fa fa-power-off" aria-hidden="true"></i> Cerrar sesion</a></li>
		</ul>
	</li>
</ul>