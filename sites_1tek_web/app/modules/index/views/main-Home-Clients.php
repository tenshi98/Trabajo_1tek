<section id="clients" class="clients">
    <div class="container" data-aos="zoom-in">
        <div class="section-title" >
            <h2><?php echo norm_text($data['Clients']['Titulo']); ?></h2>
            <p><?php echo norm_text($data['Clients']['Subtitulo']); ?></p>
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
            } ?>
        </div>
    </div>
</section>