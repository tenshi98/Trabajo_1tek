<section id="hero">
    <div class="hero-container" data-aos="fade-up" data-aos-delay="150">
        <h1><?php echo norm_text($data['PageSlogan']); ?></h1>
        <h2><?php echo norm_text($data['PageDescription']); ?></h2>
        <?php
        //verifico si existe
        if(isset($data['PageVideoURL'])&&$data['PageVideoURL']!=''){
            echo '
            <div class="d-flex">
                <a href="#about" class="btn-get-started scrollto">'.$data['PageVideoTitle'].'</a>
                <a href="'.$data['PageVideoURL'].'" class="glightbox btn-watch-video"><i class="bi bi-play-circle"></i><span>'.$data['PageVideoText'].'</span></a>
            </div>';
        } ?>
    </div>
</section>