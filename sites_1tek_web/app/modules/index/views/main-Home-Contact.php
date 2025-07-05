<section id="contact" class="contact section-bg">
    <div class="container" data-aos="fade-up"">
        <div class=" section-title">
            <h2><?php echo norm_text($data['Footer']['Titulo']); ?></h2>
            <p><?php echo norm_text($data['Footer']['Subtitulo']); ?></p>
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
                <form id="FormSendData" name="FormSendData" autocomplete="off" method="POST" action="" role="form" novalidate enctype="multipart/form-data" class="php-email-form">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <input type="text" name="Nombre" class="form-control" id="form_Nombre" placeholder="Su Nombre" required>
                        </div>
                        <div class="col-md-6 form-group mt-3 mt-md-0">
                            <input type="email" class="form-control" name="Email" id="form_Email" placeholder="Su Email" required>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <textarea class="form-control" name="Mensaje" id="form_Mensaje" rows="5" placeholder="Mensaje" required></textarea>
                    </div>
                    <div class="my-3">
                        <div id="loadingMessage" class="loading">Enviando</div>
                        <div id="errorMessage"   class="error-message">Mensaje no enviado</div>
                        <div id="sendMessage"    class="sent-message">Su mensaje ha sido enviado</div>
                    </div>
                    <div class="text-center"><button type="submit">Enviar Mensaje</button></div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
    /*********************************************************************/
    /*                      FORMULARIO DE BUSQUEDA                       */
    /*********************************************************************/
    /******************************************/
    $("#FormSendData").submit(function(e) {
        //Validaciones
        var errors = new Array();
        errors[0] = ValidateDataForms('form_Nombre', 'El Nombre', true);
        errors[1] = ValidateDataForms('form_Email', 'El Email', true);
        errors[2] = ValidateDataForms('form_Mensaje', 'El Mensaje', true);
        //Filtro eliminando los vacios
        var filter = errors.filter(function (el) {
            return el != null;
        });
        //ejecuto
        //Si hay errores se muestran
        if (Array.isArray(filter) && filter.length > 0) {
            alert(filter.join("\n"));
        //Si todo esta correcto
        }else{
            e.preventDefault();
            //Cargo el loader
            $('#loadingMessage').show();
            //Ejecuto
            let Metodo      = 'POST';
            let Direccion   = '<?php echo $BASE.'/sendMail'; ?>';
            let Informacion = $("#FormSendData").serialize();
            const Options     = {
                ClearForm:'FormSendData',
                closeObject:'#loadingMessage',
                showObject:'#sendMessage',
            };
            //Se envian los datos al formulario
            SendDataForms(Metodo, Direccion, Informacion, Options);
        }
    });
    /******************************************/
    //Se validan los inputs
    function ValidateDataForms(Element, Name, Require) {
        //Elemento a validar
        let elemVal    = $("#"+Element).val();
        //Largo del texto
        let elemLength = elemVal.length;
        //Si elemento es obligatorio
        if(Require === true && elemLength===0){
            return Name+' no puede estar en blanco';
        }
    }
</script>