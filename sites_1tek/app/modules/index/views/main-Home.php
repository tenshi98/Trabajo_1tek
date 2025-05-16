<!-- ======= Hero Section ======= -->
<section id="hero">
    <div class="hero-container" data-aos="fade-up" data-aos-delay="150">
        <h1><?php echo $data['PageSlogan']; ?></h1>
        <h2><?php echo $data['PageDescription']; ?></h2>
        <?php
        //verifico si existe
        if(isset($data['PageVideoURL'])&&$data['PageVideoURL']!=''){
            echo '
            <div class="d-flex">
                <a href="#about" class="btn-get-started scrollto">'.$data['PageVideoTitle'].'</a>
                <a href="'.$data['PageVideoURL'].'" class="glightbox btn-watch-video"><i class="bi bi-play-circle"></i><span>'.$data['PageVideoText'].'</span></a>
            </div>';
        }
        ?>
        <!--  -->
    </div>
</section><!-- End Hero -->

<main id="main">

    <!-- ======= About Boxes Section ======= -->
    <section id="about-boxes" class="about-boxes">
        <div class="container" data-aos="fade-up">

            <div class="section-title" >
                <h2><?php echo $data['About']['Titulo']; ?></h2>
                <p><?php echo $data['About']['Subtitulo']; ?></p>
            </div>

            <div class="row">

                <div class="col-lg-6 video-box align-self-baseline" data-aos="zoom-in" data-aos-delay="100">
                    <img src="<?php echo $BASE.'/assets/img/about.jpg'; ?>" class="img-fluid img-radius" alt="">
                    <a href="<?php echo $data['About']['Video']; ?>" class="glightbox play-btn mb-4"></a>
                </div>

                <div class="col-lg-6 pt-3 pt-lg-0 content">
                    <p class="fst-italic"><?php echo $data['About']['Text']; ?></p>
                    <ul>
                        <?php
                        foreach ($data['About']['Data'] as $links) {
                            //Solo si enlace existe
                            if(isset($links['Texto'])&&$links['Texto']!=''){
                                echo '<li><i class="bx bx-check-double"></i> '.norm_text($links['Texto']).'</li>';
                            }
                        }
                        ?>
                    </ul>
                    <a type="button" class="btn-linkBtn scrollto"  href="#contact">Contacto</a>
                </div>

            </div>

        </div>
    </section><!-- End About Boxes Section -->

    <!-- ======= Features Section ======= -->
    <section id="features" class="features">
        <div class="container" data-aos="fade-up">

            <ul class="nav nav-tabs row d-flex">
                <?php
                //Variable
                $Contador = 1;
                foreach ($data['Features'] as $links) {
                    $tabAct = ($Contador === 1) ? 'active show' : '';
                    echo '
                    <li class="nav-item col-3">
                        <a class="nav-link '.$tabAct.'" data-bs-toggle="tab" href="#tab-'.$Contador.'">
                            <i class="'.$links['iconTab'].'"></i>
                            <h4 class="d-none d-lg-block">'.$links['TitleTab'].'</h4>
                        </a>
                    </li>';
                    $Contador++;
                }
                ?>
            </ul>

            <div class="tab-content">
                <?php
                //Variable
                $Contador = 1;
                foreach ($data['Features'] as $links) {
                    $tabAct = ($Contador === 1) ? 'active show' : '';
                    echo '
                    <div class="tab-pane '.$tabAct.'" id="tab-'.$Contador.'">
                        <div class="row">
                            <div class="col-lg-6 order-2 order-lg-1 mt-3 mt-lg-0">
                                <h3>'.$links['Title'].'</h3>
                                '.norm_text($links['Text']).'
                                <button type="button" class="btn-linkBtn" onclick="ViewFeature('.$links['ID'].')">Ver mas</button>
                            </div>
                            <div class="col-lg-6 order-1 order-lg-2 text-center">
                                <img src="'.$BASE.$links['Img'].'" alt="" class="img-fluid">
                            </div>
                        </div>
                    </div>';
                    $Contador++;
                }
                ?>
            </div>

        </div>
    </section><!-- End Features Section -->

    <!-- ======= Clients Section ======= -->
    <section id="clients" class="clients">
        <div class="container" data-aos="zoom-in">

            <div class="section-title" >
                <h2><?php echo $data['Clients']['Titulo']; ?></h2>
                <p><?php echo $data['Clients']['Subtitulo']; ?></p>
            </div>

            <div class="row">
                <?php
				/****************************************************/
				//funcion
				$thefolder = $data['Clients']['RouteFolder'];
                $files     = glob($thefolder . '*.jpg');
                $rand_keys = array_rand($files, 6);
                for ($i=0; $i < 6; $i++) {
                    echo '
                    <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
                        <img src="'.$files[$rand_keys[$i]].'" class="img-fluid" alt="">
                    </div>';
                }
				?>
            </div>

        </div>
    </section><!-- End Clients Section -->

    <!-- ======= Services Section ======= -->
    <section id="services" class="services section-bg">
        <div class="container" data-aos="fade-up">

            <div class="section-title">
                <h2>Services</h2>
                <p>Check our Services</p>
            </div>

            <div class="row" data-aos="fade-up" data-aos-delay="200">
                <div class="col-md-6">
                    <div class="icon-box">
                        <i class="bi bi-laptop"></i>
                        <h4><a href="#">Lorem Ipsum</a></h4>
                        <p>Voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident</p>
                    </div>
                </div>
                <div class="col-md-6 mt-4 mt-md-0">
                    <div class="icon-box">
                        <i class="bi bi-bar-chart"></i>
                        <h4><a href="#">Dolor Sitema</a></h4>
                        <p>Minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat tarad limino ata</p>
                    </div>
                </div>
                <div class="col-md-6 mt-4 mt-md-0">
                    <div class="icon-box">
                        <i class="bi bi-brightness-high"></i>
                        <h4><a href="#">Sed ut perspiciatis</a></h4>
                        <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur</p>
                    </div>
                </div>
                <div class="col-md-6 mt-4 mt-md-0">
                    <div class="icon-box">
                        <i class="bi bi-briefcase"></i>
                        <h4><a href="#">Nemo Enim</a></h4>
                        <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
                    </div>
                </div>
                <div class="col-md-6 mt-4 mt-md-0">
                    <div class="icon-box">
                        <i class="bi bi-card-checklist"></i>
                        <h4><a href="#">Magni Dolore</a></h4>
                        <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque</p>
                    </div>
                </div>
                <div class="col-md-6 mt-4 mt-md-0">
                    <div class="icon-box">
                        <i class="bi bi-clock"></i>
                        <h4><a href="#">Eiusmod Tempor</a></h4>
                        <p>Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi</p>
                    </div>
                </div>
            </div>

        </div>
    </section><!-- End Services Section -->

    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
        <div class="container" data-aos="fade-up"">

            <div class=" section-title">
                <h2>Contacto</h2>
                <p>Contactanos por los siguientes medios</p>
            </div>

            <div class="row">

                <div class="col-lg-6">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="info-box">
                                <i class="bx bx-map"></i>
                                <h3>Direccion</h3>
                                <p><?php echo norm_text($data['PageDirection']); ?></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box mt-4">
                                <i class="bx bx-envelope"></i>
                                <h3>Email</h3>
                                <p><?php echo $data['PageEmail']; ?></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box mt-4">
                                <i class="bx bx-phone-call"></i>
                                <h3>Fono</h3>
                                <p><?php echo $data['PagePhone']; ?></p>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-lg-6 mt-4 mt-lg-0">
                    <form action="" method="post" role="form" class="php-email-form">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required>
                            </div>
                            <div class="col-md-6 form-group mt-3 mt-md-0">
                                <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required>
                        </div>
                        <div class="form-group mt-3">
                            <textarea class="form-control" name="message" rows="5" placeholder="Message" required></textarea>
                        </div>
                        <div class="my-3">
                            <div class="loading">Loading</div>
                            <div class="error-message"></div>
                            <div class="sent-message">Your message has been sent. Thank you!</div>
                        </div>
                        <div class="text-center"><button type="submit">Send Message</button></div>
                    </form>
                </div>

            </div>

        </div>
    </section><!-- End Contact Section -->

</main><!-- End #main -->

<script>
    /*********************************************************************/
    /*                        OPCIONES DE LA TABLA                       */
    /*********************************************************************/
    /******************************************/
    function ViewFeature(ID) {
        //Cargo el loader
        $('#preloader').show();
        //Ejecuto
        let Div       = '#modalContent';
        let URL       = '<?php echo $BASE.'/feature/view/'; ?>'+ID;
        const Options = {
            showModal : '#viewModal',
            closeObject:'#preloader',
        };
        //Se envian los datos al formulario
        UpdateContentId(Div, URL, Options);
    }
</script>
<?php
function norm_text($Text){
    //Datos buscados
    $healthy = array('&lt;', '&gt;', '&quot;');
    $yummy   = array('<', '>', '"');
    //devolver
    return str_replace($healthy, $yummy, $Text);

}
?>