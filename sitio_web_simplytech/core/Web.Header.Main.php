<head>

	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">

	<title>
		<?php
		if(isset($rowData['Nombre'])&&$rowData['Nombre']!=''){
			echo $rowData['Nombre'];
		}else{
			echo 'Inicio';
		}
		?>
	</title>
	<meta content="" name="description">
	<meta content="" name="author">
	<meta content="" name="keywords">

	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

	<!-- Vendor CSS Files -->
	<link rel="stylesheet" type="text/css" href="assets/vendor/aos/aos.css">
	<link rel="stylesheet" type="text/css" href="assets/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/vendor/bootstrap-icons/bootstrap-icons.css">
	<link rel="stylesheet" type="text/css" href="assets/vendor/boxicons/css/boxicons.min.css">
	<link rel="stylesheet" type="text/css" href="assets/vendor/glightbox/css/glightbox.min.css">
	<link rel="stylesheet" type="text/css" href="assets/vendor/remixicon/remixicon.css">
	<link rel="stylesheet" type="text/css" href="assets/vendor/swiper/swiper-bundle.min.css">

	<!-- Template Main CSS File -->
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="assets/css/my_style.css">

	<!-- Favicons-->
	<?php
	//Favicon Personalizado
	$nombre_fichero = 'upload/favicon/mifavicon.png';
	if (file_exists($nombre_fichero)){ ?>
		<link rel="icon"             type="image/png"                    href="upload/favicon/mifavicon.png" >
		<link rel="shortcut icon"    type="image/x-icon"                 href="upload/favicon/mifavicon.png" >
		<link rel="apple-touch-icon" type="image/x-icon"                 href="upload/favicon/mifavicon-57x57.png">
		<link rel="apple-touch-icon" type="image/x-icon" sizes="72x72"   href="upload/favicon/mifavicon-72x72.png">
		<link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="upload/favicon/mifavicon-114x114.png">
		<link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="upload/favicon/mifavicon-144x144.png">
	<?php
	//Favicon predefinido
	}else{ ?>
		<link rel="icon"             type="image/png"                    href="<?php echo DB_SITE_REPO ?>/LIB_assets/img/favicons/favicon.png" >
		<link rel="shortcut icon"    type="image/x-icon"                 href="<?php echo DB_SITE_REPO ?>/LIB_assets/img/favicons/favicon.png" >
		<link rel="apple-touch-icon" type="image/x-icon"                 href="<?php echo DB_SITE_REPO ?>/LIB_assets/img/favicons/apple-touch-icon-57x57-precomposed.png">
		<link rel="apple-touch-icon" type="image/x-icon" sizes="72x72"   href="<?php echo DB_SITE_REPO ?>/LIB_assets/img/favicons/apple-touch-icon-72x72-precomposed.png">
		<link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="<?php echo DB_SITE_REPO ?>/LIB_assets/img/favicons/apple-touch-icon-114x114-precomposed.png">
		<link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="<?php echo DB_SITE_REPO ?>/LIB_assets/img/favicons/apple-touch-icon-144x144-precomposed.png">
	<?php } ?>

</head>

