<!DOCTYPE html>
<html lang="es">

    <head>
        <meta charset="utf-8">
        <meta name="viewport"   content="width=device-width, initial-scale=1">

        <title><?php echo $data['PageTitle']; ?></title>
        <meta name="description" content="<?php echo $data['PageDescription']; ?>">
        <meta name="author"      content="<?php echo $data['PageAuthor']; ?>">
        <meta name="keywords"    content="<?php echo $data['PageKeywords']; ?>">

        <!-- Favicons -->
        <link rel="icon"             type="image/png"                    href="<?php echo $BASE.'/assets/img/favicon/mifavicon.png'; ?>" >
        <link rel="shortcut icon"    type="image/x-icon"                 href="<?php echo $BASE.'/assets/img/favicon/mifavicon.png'; ?>" >
        <link rel="apple-touch-icon" type="image/x-icon"                 href="<?php echo $BASE.'/assets/img/favicon/mifavicon-57x57.png'; ?>">
        <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72"   href="<?php echo $BASE.'/assets/img/favicon/mifavicon-72x72.png'; ?>">
        <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="<?php echo $BASE.'/assets/img/favicon/mifavicon-114x114.png'; ?>">
        <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="<?php echo $BASE.'/assets/img/favicon/mifavicon-144x144.png'; ?>">

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i">

        <!-- Vendor CSS Files -->
        <link rel="stylesheet" type="text/css" href="<?php echo $BASE.'/assets/vendor/aos/aos.css'; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $BASE.'/assets/vendor/bootstrap/css/bootstrap.min.css'; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $BASE.'/assets/vendor/bootstrap-icons/bootstrap-icons.css'; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $BASE.'/assets/vendor/boxicons/css/boxicons.min.css'; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $BASE.'/assets/vendor/glightbox/css/glightbox.min.css'; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $BASE.'/assets/vendor/remixicon/remixicon.css'; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo $BASE.'/assets/vendor/swiper/swiper-bundle.min.css'; ?>">

        <!-- Template Main CSS File -->
        <link rel="stylesheet" type="text/css" href="<?php echo $BASE.'/assets/css/style.css'; ?>">

        <!-- Funcionalidad -->
        <script src="<?php echo $BASE.'/assets/js/jquery-3.7.1.min.js'; ?>"></script>
        <script src="<?php echo $BASE.'/assets/js/functions.js'; ?>"></script>

        <!-- Facebook Meta Tags -->
        <meta property="og:url"         content="<?php echo $data['PageURL']; ?>">
        <meta property="og:type"        content="website">
        <meta property="og:title"       content="<?php echo $data['PageTitle']; ?>">
        <meta property="og:description" content="<?php echo $data['PageDescription']; ?>">
        <meta property="og:image"       content="<?php echo $data['PagePreview']; ?>">

        <!-- Twitter Meta Tags -->
        <meta name="twitter:card"        content="summary_large_image">
        <meta property="twitter:domain"  content="<?php echo $data['PageDomain']; ?>">
        <meta property="twitter:url"     content="<?php echo $data['PageURL']; ?>">
        <meta name="twitter:title"       content="<?php echo $data['PageTitle']; ?>">
        <meta name="twitter:description" content="<?php echo $data['PageDescription']; ?>">
        <meta name="twitter:image"       content="<?php echo $data['PagePreview']; ?>">

    </head>

    <body>
        <header id="header" class="fixed-top ">
            <div class="container d-flex align-items-center justify-content-between">

                <a href="#hero" class="logo"><img src="<?php echo $BASE.'/assets/img/logo.png'; ?>" alt="Logo" class="img-fluid"></a>

                <nav id="navbar" class="navbar">
                    <ul>
                        <li><a class="nav-link scrollto active" href="#hero">Inicio</a></li>
                        <li><a class="nav-link scrollto"  href="#about-boxes">Nosotros</a></li>
                        <li><a class="nav-link scrollto " href="#features">Servicios</a></li>
                        <li><a class="nav-link scrollto"  href="#clients">Clientes</a></li>
                        <li><a class="nav-link scrollto"  href="#contact">Contacto</a></li>
                        <li class="dropdown"><a href="#"><span>Ver Mas</span> <i class="bi bi-chevron-down"></i></a>
                            <ul>
                                <li><a href="<?php echo $BASE.'/crearProyecto'; ?>">Crea tu Proyecto</a></li>
                                <li><a href="<?php echo $BASE.'/solicitarReunion'; ?>">Solicita una reunion</a></li>
                            </ul>
                        </li>
                        <li><a class="getstarted scrollto" href="<?php echo $data['SystemURL']; ?>">Ingresar</a></li>
                    </ul>
                    <i class="bi bi-list mobile-nav-toggle"></i>
                </nav>

            </div>
        </header>