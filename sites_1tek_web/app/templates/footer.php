        <div class="modal fade" id="viewModal" tabindex="-1">
            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                <div class="modal-content" id="modalContent">

                </div>
            </div>
        </div>

        <footer id="footer">
            <div class="footer-top">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3 col-md-6">
                            <div class="footer-info">
                                <h3><?php echo $data['PageTitle']; ?></h3>
                                <p><?php echo norm_text($data['PageDirection']); ?><br>
                                <strong>Fono:</strong> <?php echo $data['PagePhone']; ?><br>
                                <strong>Email:</strong> <?php echo $data['PageEmail']; ?><br>
                                </p>
                                <div class="social-links mt-3">
                                    <?php
                                    foreach ($data['Footer']['socialLinks'] as $links) {
                                        //Solo si enlace existe
                                        if(isset($links['Link'])&&$links['Link']!=''){
                                            echo '<a href="'.$links['Link'].'" class="'.$links['class'].'"><i class="'.$links['iclass'].'"></i></a>';
                                        }
                                    } ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-2 col-md-6 footer-links">
                            <h4><?php echo norm_text($data['Footer']['LinksTitulo']); ?></h4>
                            <ul>
                                <?php
                                foreach ($data['Footer']['Links'] as $links) {
                                    //Solo si enlace existe
                                    if(isset($links['Link'])&&$links['Link']!=''){
                                        echo '<li><i class="'.$links['iclass'].'"></i> <a href="'.$links['Link'].'">'.$links['Text'].'</a></li>';
                                    }
                                } ?>
                            </ul>
                        </div>

                        <div class="col-lg-3 col-md-6 footer-links">
                            <h4><?php echo norm_text($data['Footer']['ServicesTitulo']); ?></h4>
                            <ul>
                                <?php
                                foreach ($data['Footer']['Services'] as $links) {
                                    //Solo si enlace existe
                                    if(isset($links['Link'])&&$links['Link']!=''){
                                        echo '<li><i class="'.$links['iclass'].'"></i> <a href="'.$links['Link'].'">'.$links['Text'].'</a></li>';
                                    }
                                } ?>
                            </ul>
                        </div>

                        <div class="col-lg-4 col-md-6 footer-newsletter">
                            <h4>Our Newsletter</h4>
                            <p>Tamen quem nulla quae legam multos aute sint culpa legam noster magna</p>
                            <form action="" method="post">
                                <input type="email" name="email"><input type="submit" value="Subscribe">
                            </form>
                        </div>

                    </div>
                </div>
            </div>

            <div class="container">
                <div class="copyright">
                    &copy; Copyright <strong><span><?php echo $data['PageTitle']; ?></span></strong>. <?php echo norm_text($data['Footer']['Pie']); ?>
                </div>
            </div>
        </footer>

        <div id="preloader"></div>
        <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

        <!-- Vendor JS Files -->
        <script src="<?php echo $BASE.'/assets/vendor/purecounter/purecounter.js'; ?>"></script>
        <script src="<?php echo $BASE.'/assets/vendor/aos/aos.js'; ?>"></script>
        <script src="<?php echo $BASE.'/assets/vendor/bootstrap/js/bootstrap.bundle.min.js'; ?>"></script>
        <script src="<?php echo $BASE.'/assets/vendor/glightbox/js/glightbox.min.js'; ?>"></script>
        <script src="<?php echo $BASE.'/assets/vendor/isotope-layout/isotope.pkgd.min.js'; ?>"></script>
        <script src="<?php echo $BASE.'/assets/vendor/swiper/swiper-bundle.min.js'; ?>"></script>
        <!-- <script src="<?php echo $BASE.'/assets/vendor/php-email-form/validate.js'; ?>"></script> -->

        <!-- Template Main JS File -->
        <script src="<?php echo $BASE.'/assets/js/main.js'; ?>"></script>

    </body>

</html>
