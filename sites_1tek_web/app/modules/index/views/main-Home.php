<?php require_once('main-Home-Hero.php'); ?>

<main id="main">
    <?php
    require_once('main-Home-About.php');
    require_once('main-Home-Features.php');
    require_once('main-Home-Clients.php');
    require_once('main-Home-Services.php');
    require_once('main-Home-Contact.php');
    ?>
</main>

<script>
    /*********************************************************************/
    /*                      EJECUCION DE LA LOGICA                       */
    /*********************************************************************/
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

} ?>