<?php
//verifico la existencia
if (isset($_SESSION['usuario']['basic_data']['Config_imgLogo'])&&$_SESSION['usuario']['basic_data']['Config_imgLogo']!='') {
	$srcFileLogo = 'upload/'.$_SESSION['usuario']['basic_data']['Config_imgLogo'];
}else{
	$srcFileLogo = 'img/login_logo_color.png';
}
?>

<div class="logo_empresa">
	<div class="pull-left">
		<img src="<?php echo $srcFileLogo; ?>" alt="Imagen Referencia">
	</div>
</div>