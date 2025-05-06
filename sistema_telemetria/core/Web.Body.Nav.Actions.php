
<div class="topnav menutop2-toggle">

    <div class="btn-group grouphidden">
        <a id="toggleFullScreen" title="Pantalla Completa" class="btn btn-default btn-sm tooltip" >
            <i class="fa fa-arrows-alt" aria-hidden="true"></i>
        </a>
        <a onClick="setVsual()" title="Ocultar Menu" class="btn btn-default btn-sm tooltip" >
            <i class="fa fa-bars" aria-hidden="true"></i>
        </a>
    </div>

    <div class="btn-group">
		<?php if((isset($_SESSION['usuario']['basic_data']['COunt'])&&$_SESSION['usuario']['basic_data']['COunt']>1) OR $_SESSION['usuario']['basic_data']['idTipoUsuario']==1){ ?>
			<a href="index_select.php?bla=true" title="Cambio Sistema" data-toggle="modal" class="btn btn-primary btn-sm tooltip" >
				<i class="fa fa-exchange" aria-hidden="true"></i>
			</a>
		<?php } ?>
		<?php
		$ubicacion = $original.'?salir=true';
		$dialogo   = '¿Realmente desea cerrar su sesion?'; ?>
		<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Cerrar sesion" class="btn btn-metis-1 btn-sm tooltip">
            <i class="fa fa-power-off" aria-hidden="true"></i>
        </a>
    </div>

</div>






<?php
//se resetea la interfaz
if(isset($_SESSION['menu'])&&$_SESSION['menu']!=''){
	$iii = $_SESSION['menu'];
}else{
	$iii = 1; 
} ?>

<script type='text/javascript'>
    let sesionbase = <?php echo $iii; ?>;
    let a          = $("body");
    let b          = $("#navbar_nav");
    //Muestra y oculta la barra lateral
    function setVsual() {
		sesionbase = sesionbase + 1;
		
		switch(sesionbase){
			case 2:
				a.removeClass("sidebar-left-hidden");
				a.addClass("sidebar-left-mini");
				$("#navbar_nav").addClass("navvisibility");
				break;
			case 3:
				a.removeClass("sidebar-left-mini");
				a.addClass("sidebar-left-hidden");
				$("#navbar_nav").removeClass("navvisibility");
				break;
			case 4:
				sesionbase = 1;
				a.removeClass("sidebar-left-hidden");
				a.removeClass("sidebar-left-mini");
				$("#navbar_nav").addClass("navvisibility");
				break;
		}

        xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "1setSession.php?variable=" + sesionbase , true);
        xmlhttp.send();
    }
</script>

