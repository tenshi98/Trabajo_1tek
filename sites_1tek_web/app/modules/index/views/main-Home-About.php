<section id="about-boxes" class="about-boxes">
    <div class="container" data-aos="fade-up">
        <div class="section-title" >
            <h2><?php echo norm_text($data['About']['Titulo']); ?></h2>
            <p><?php echo norm_text($data['About']['Subtitulo']); ?></p>
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
                    } ?>
                </ul>
                <a type="button" class="btn-linkBtn scrollto"  href="#contact">Contacto</a>
            </div>
        </div>
    </div>
</section>