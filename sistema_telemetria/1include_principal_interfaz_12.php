<?php
/*****************************************************************************************************************/
/*                                                Modelado                                                       */
/*****************************************************************************************************************/
//oculto el menu
$_SESSION['menu'] = 2;
?>
<style>
	.noborderbox{border: none!important;-webkit-box-shadow: none!important;box-shadow: none!important;}
	.noborderbox .header {background-color: #fff!important;color: #333!important;border-color: #ddd!important;}
	.noborderbox .header .nav-tabs {border-bottom: 1px solid #ddd!important;}
	.noborderbox .header .nav-tabs > li.active > a{color: #333 !important;border-color: #ddd!important;border-bottom-color: transparent!important;}
	.noborderbox .header .nav-tabs > li > a {color: #665F5F !important;}
	.noborderbox .header .nav-tabs > li > a:hover,
	.noborderbox .header .nav-tabs > li > a:focus{color: #fff !important;background-color: #2E2424;}
	.noborderbox .header .nav-tabs > li.active > a:hover,
	.noborderbox .header .nav-tabs > li.active > a:focus{color: #fff !important;background-color: #2E2424;}
	.float_table table{margin-right: auto !important;margin-left: auto !important;float: none !important;}
	#loading {display: block;position: absolute;top: 0;left: 0;z-index: 100;width: 100%;height: 100%;background-color: rgba(192, 192, 192, 0.5);background-image: url("<?php echo DB_SITE_REPO.'/LIB_assets/img/loader.gif'; ?>");background-repeat: no-repeat;background-position: center;}
	#loadingWalmart {display: block;position: absolute;top: 0;left: 0;z-index: 100;width: 100%;height: 100%;background-color: rgba(192, 192, 192, 0.5);background-image: url("<?php echo DB_SITE_REPO.'/LIB_assets/img/loader.gif'; ?>");background-repeat: no-repeat;background-position: center;}

</style>

<div class="box noborderbox">
	<header class="header">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab_1" data-toggle="tab"><i class="fa fa-list-alt" aria-hidden="true"></i> Ambientes Carnes/Masas</a></li>
			<li class=""><a href="#tab_2" data-toggle="tab"><i class="fa fa-tasks" aria-hidden="true"></i> Hornos</a></li>
			<li class=""><a href="#tab_3" data-toggle="tab"><i class="fa fa-tasks" aria-hidden="true"></i> Cloro</a></li>
		</ul>
	</header>
    <div class="tab-content">

		<div class="tab-pane fade active in" id="tab_1">
			<?php
			echo widget_CrossC_Walmart2('06:00:00', 2,
										$_SESSION['usuario']['basic_data']['idSistema'],
										$_SESSION['usuario']['basic_data']['idTipoUsuario'],
										$_SESSION['usuario']['basic_data']['idUsuario'],
										$dbConn);

			?>
		</div>

		<div class="tab-pane fade" id="tab_2">
			<?php
			echo widget_CrossC_WalmartHornos('06:00:00', 2,
										$_SESSION['usuario']['basic_data']['idSistema'],
										$_SESSION['usuario']['basic_data']['idTipoUsuario'],
										$_SESSION['usuario']['basic_data']['idUsuario'],
										50,
										$dbConn);

			?>
		</div>

		<div class="tab-pane fade" id="tab_3">
			<?php
			echo widget_CrossC_WalmartCloro('06:00:00', 2,
										$_SESSION['usuario']['basic_data']['idSistema'],
										$_SESSION['usuario']['basic_data']['idTipoUsuario'],
										$_SESSION['usuario']['basic_data']['idUsuario'],
										$dbConn);

			?>
		</div>

    </div>
</div>




