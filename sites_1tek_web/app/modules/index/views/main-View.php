<div class="modal-header">
    <h5 class="modal-title"><i class="bi bi-file-earmark"></i> <?php echo $data['ViewData']['ModalTitle']; ?></h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

    <!-- ======= About Boxes Section ======= -->
    <section id="about-boxes" class="about-boxes no-bg">
        <div class="container" data-aos="fade-up">

            <div class="section-title head-title" >
                <h2><?php echo $data['ViewData']['Subtitulo']; ?></h2>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <h3><?php echo $data['ViewData']['Contenido1_Titulo']; ?></h3>
                    <p><?php echo norm_text($data['ViewData']['Contenido1_Texto']); ?></p>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 video-box align-self-baseline" data-aos="zoom-in" data-aos-delay="100">
                    <img src="<?php echo $BASE.'/assets/img/view_servicio/'.$data['ViewData']['Contenido2_IMG']; ?>" class="img-fluid" alt="">
                </div>
                <div class="col-lg-8 pt-3 pt-lg-0 content">
                    <h3><?php echo $data['ViewData']['Contenido2_Titulo']; ?></h3>
                    <p><?php echo norm_text($data['ViewData']['Contenido2_Texto']); ?></p>
                </div>
            </div>

        </div>
    </section><!-- End About Boxes Section -->


    <!-- ======= Services Section ======= -->
    <section id="services" class="services section-bg">
        <div class="container" data-aos="fade-up">
            <div class="section-title head-title">
                <h2><?php echo $data['ViewData']['porHacerTitulo']; ?></h2>
            </div>
            <div class="row" data-aos="fade-up" data-aos-delay="200">
                <?php
                foreach ($data['ViewData']['porHacerPuntos'] as $val) {
                    echo '
                    <div class="col-md-6">
                        <div class="icon-box">
                            <i class="'.$val['Icono'].'"></i>
                            <h4><a href="#">'.$val['Titulo'].'</a></h4>
                            <p>'.norm_text($val['Texto']).'</p>
                        </div>
                    </div>';
                } ?>
            </div>
        </div>
    </section><!-- End Services Section -->

    <!-- ======= About Boxes Section ======= -->
    <section id="about-boxes" class="about-boxes no-bg">
        <div class="container" data-aos="fade-up">

            <div class="section-title head-title" >
                <h2><?php echo $data['ViewData']['CaracteristicasTitulo']; ?></h2>
            </div>

            <?php
            //Contador
            $count = 0;
            //recorro
            foreach ($data['ViewData']['CaracteristicasPuntos'] as $val) {
                if($count%2){
                    echo '
                    <div class="row pt-3">
                        <div class="col-lg-4 video-box align-self-baseline" data-aos="zoom-in" data-aos-delay="100">
                            <img src="'.$BASE.'/assets/img/view_servicio/'.$val['IMG'].'" class="img-fluid" alt="">
                        </div>
                        <div class="col-lg-8 pt-3 content">
                            <h3>'.$val['Titulo'].'</h3>
                            <p>'.norm_text($val['Texto']).'</p>
                        </div>
                    </div>';
                }else{
                    echo '
                    <div class="row pt-3">
                        <div class="col-lg-8 pt-3 content">
                            <h3>'.$val['Titulo'].'</h3>
                            <p>'.norm_text($val['Texto']).'</p>
                        </div>
                        <div class="col-lg-4 video-box align-self-baseline" data-aos="zoom-in" data-aos-delay="100">
                            <img src="'.$BASE.'/assets/img/view_servicio/'.$val['IMG'].'" class="img-fluid" alt="">
                        </div>
                    </div>';
                }
                $count++;
            }
            ?>
        </div>
    </section><!-- End About Boxes Section -->








</div>
<div class="modal-footer">
    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="bx bi-x-circle"></i> Cerrar</button>
</div>

<?php
function norm_text($Text){
    //Datos buscados
    $healthy = array('&lt;', '&gt;', '&quot;');
    $yummy   = array('<', '>', '"');
    //devolver
    return str_replace($healthy, $yummy, $Text);

}
?>