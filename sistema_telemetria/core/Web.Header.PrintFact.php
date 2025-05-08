<!DOCTYPE html>
<html lang="es-ES">
	<head>
		<!-- Info-->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport"              content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-Type"    content="text/html; charset=UTF-8">

		<!-- Información del sitio-->
		<title>Imprimir</title>
		<meta name="description"           content="">
		<meta name="author"                content="">
		<meta name="keywords"              content="">

		<!-- CSS Base -->
		<link rel="stylesheet" type="text/css" href="<?php echo DB_SITE_REPO ?>/Legacy/1tek_public/css/factura.css">

		<!-- Correcciones CSS -->
		<style>
			body {background-color: #FFF !important;}
		</style>
	</head>
	<body onload="window.print();">
		<div id="loader-wrapper">
			<div id="loader"></div>
			<div class="loader-section section-left"></div>
			<div class="loader-section section-right"></div>
		</div>
