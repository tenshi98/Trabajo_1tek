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
            } ?>
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
            } ?>
        </div>
    </div>
</section>