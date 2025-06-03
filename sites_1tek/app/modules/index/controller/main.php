<?php
/*******************************************************************************************************************/
/*                                              Se define la clase                                                 */
/*******************************************************************************************************************/
class main extends ControllerWeb {

    /******************************************************************************/
    //Constructor
    public function __construct(){
        //se instancian los datos
        $mailSender    = new MailSender();
        //se entregan datos a la clase padre
        parent::__construct($mailSender);
    }

    /******************************************************************************/
    //Vista - Index
    public function index($f3){

        /******************************/
        //Se agregan datos
        $socialLinks = [
            [
                'class'  => 'twitter',     //Clase den enlace
                'iclass' => 'bxl-twitter', //Icono utilizado
                'Link'   => '',            //Enlace
            ],
            [
                'class'  => 'facebook',     //Clase den enlace
                'iclass' => 'bxl-facebook', //Icono utilizado
                'Link'   => '',             //Enlace
            ],
            [
                'class'  => 'instagram',     //Clase den enlace
                'iclass' => 'bxl-instagram', //Icono utilizado
                'Link'   => '',              //Enlace
            ],
            [
                'class'  => 'google-plus', //Clase den enlace
                'iclass' => 'bxl-skype',   //Icono utilizado
                'Link'   => '',            //Enlace
            ],
            [
                'class'  => 'linkedin',     //Clase den enlace
                'iclass' => 'bxl-linkedin', //Icono utilizado
                'Link'   => '',             //Enlace
            ],
        ];

        /******************************/
        //Se agregan datos
        $Links = [
            [
                'iclass' => 'bx-chevron-right', //Icono utilizado
                'Link'   => '',                 //Enlace
                'Text'   => 'Home',             //Texto Enlace
            ],

        ];

        /******************************/
        //Se agregan datos
        $Services = [
            [
                'iclass' => 'bx-chevron-right', //Icono utilizado
                'Link'   => '',                 //Enlace
                'Text'   => 'Home',             //Texto Enlace
            ],
        ];

        /******************************/
        //Se genera la query
        $About = [
            'Titulo'    => 'Nosotros',
            'Subtitulo' => 'Quienes Somos',
            'Video'     => 'https://www.youtube.com/watch?v=jDDaplaOz7Q',
            'Text'      => 'Somos una empresa innovadora dedicada a la creación de soluciones efectivas en procesos de negocios fundamentales,
                        a través de la integración de diversas tecnologías y sofisticados mecanismos de procesamiento de datos.',
            'Data'     => [
                ['Texto' => '<strong>Dashboard:</strong> Toma decisiones rápidas, reacciona rápido, sé eficiente.',],
                ['Texto' => '<strong>Tiempo real:</strong> Obtén mayor control frente a los parámetros exigidos por tu empresa.',],
                ['Texto' => '<strong>Trazabilidad:</strong> Tener la información a mano siempre será tu mejor arma.',],
                ['Texto' => '<strong>Informes:</strong> Descarga informes en PDF y Excel para obtener los reportes.',],
            ]
        ];

        /******************************/
        //Se agregan datos
        $Features = [
            [
                'iconTab'  => 'ri-gps-line',
                'TitleTab' => '1°C',
                'Title'    => 'Monitoreo temperatura.',
                'Text'     => '<p>Monitoreo de temperatura y humedad relativa en tiempo real para ambientes controlados 24/7.
                                Perfecto para la trazabilidad de cámaras de frío, camiones frigoríficos, salas de proceso de alimentos,
                                líneas de proceso de frutas y prefríos.</p>',
                'Img'      => '/assets/img/servicios/1C.png',
                'ID'       => 1,
            ],
            [
                'iconTab'  => 'ri-body-scan-line',
                'TitleTab' => 'Agro-Checking',
                'Title'    => 'Ventiladores contra heladas.',
                'Text'     => '<p>Variables climáticas para campos agrícolas. Predicción de heladas con 93% de precisión en tiempo real con
                                inteligencia artificial. También es integrable a aspas anti-heladas y así verificar el correcto funcionamiento.</p>',
                'Img'      => '/assets/img/servicios/Agro-checking.jpg',
                'ID'       => 2,
            ],
            [
                'iconTab'  => 'ri-body-scan-line',
                'TitleTab' => 'Agro-Weather',
                'Title'    => 'Ventiladores contra heladas.',
                'Text'     => '<p>Variables climáticas para campos agrícolas. Predicción de heladas con 93% de precisión en tiempo real con
                                inteligencia artificial. También es integrable a aspas anti-heladas y así verificar el correcto funcionamiento.</p>',
                'Img'      => '/assets/img/servicios/Agro-weather.jpg',
                'ID'       => 3,
            ],
            [
                'iconTab'  => 'ri-sun-line',
                'TitleTab' => 'Power-Crane',
                'Title'    => 'Maquinaria de alto tonelaje.',
                'Text'     => '<p>Sistema de monitoreo en tiempo real de todo tipo de maquinaria que tenga motor y panel eléctrico.
                                El objetivo de este servicio es conocer las horas de uso real del equipo, balance de líneas eléctricas
                                de motores, KPI’s, alertas y apagado remoto.</p>',
                'Img'      => '/assets/img/servicios/Power-crane.png',
                'ID'       => 4,
            ],
            [
                'iconTab'  => 'ri-sun-line',
                'TitleTab' => 'Power-Energy',
                'Title'    => 'Omnis fugiat ea explicabo',
                'Text'     => '<p>
                                Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate
                                velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
                                culpa qui officia deserunt mollit anim id est laborum
                            </p>
                            <p class="fst-italic">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
                                magna aliqua.
                            </p>
                            <ul>
                                <li><i class="ri-check-double-line"></i> Ullamco laboris nisi ut aliquip ex ea commodo consequat.</li>
                                <li><i class="ri-check-double-line"></i> Duis aute irure dolor in reprehenderit in voluptate velit.</li>
                                <li><i class="ri-check-double-line"></i> Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate trideta storacalaperda mastiro dolore eu fugiat nulla pariatur.</li>
                            </ul>',
                'Img'      => '/assets/img/servicios/Power-energy.png',
                'ID'       => 5,
            ],
        ];

        /******************************/
        //Se genera la query
        $Clients = [
            'Titulo'      => 'Clientes',
            'Subtitulo'   => 'Clientes a quienes prestamos servicios',
            'RouteFolder' => 'assets/img/clientes/',

        ];


        //Datos enviados a la pagina
        $f3->data = [
            /*=========== Datos de la Pagina ===========*/
            'PageTitle'       => '1Tek',
            'PageSlogan'      => 'Digitalización de tu Negocio',
            'PageDescription' => 'Optimiza tu éxito empresarial: digitaliza tus procesos, simplifica tu camino al progreso',
            'PageAuthor'      => 'asd',
            'PageKeywords'    => 'asd',
            'PageVideoTitle'  => 'Get Started',
            'PageVideoText'   => 'Watch Video',
            'PageVideoURL'    => '',
            'PageURL'         => 'https://web.1tek.cl/',
            'PageDomain'      => 'web.1tek.cl',
            'PagePreview'     => 'https://raw.githubusercontent.com/tenshi98/tenshi98/main/resources/web-1.jpg',
            'PageDirection'   => 'A108 Adam Street <br>NY 535022, USA<br>',
            'PagePhone'       => '+1 5589 55488 55',
            'PageEmail'       => 'info@example.com',
            'SystemURL'       => 'https://clientes.1tek.cl/',
            'socialLinks'     => $socialLinks,
            'Links'           => $Links,
            'Services'        => $Services,
            'About'           => $About,
            'Features'        => $Features,
            'Clients'         => $Clients,

        ];

        //Se instancia la vista
        $view = new View;
        echo $view->render('../app/templates/header.php');                                 // Header
        echo $view->render('../'.$this->returnRutaVista(__DIR__, 'app').'/main-Home.php'); // Vista
        echo $view->render('../app/templates/footer.php');                                 // Footer
    }

    /******************************************************************************/
    //Ver datos
    public function View($f3, $params){

        /******************************/
        //Se genera la query
        $ViewData[1] = [
            'ModalTitle'        => '1°C',
            'Subtitulo'         => 'Monitoreo de temperatura.',
            'Contenido1_Titulo' => 'Monitoreo de temperatura en tiempo real.',
            'Contenido1_Texto'  => '1°C es un sistema de monitoreo basado en tecnología IoT (internet de las cosas) que permite monitorear y obtener <strong>trazabilidad</strong> de las variables críticas de ambientes controlados, tales como <strong>cámaras de frigoríficos y líneas de proceso</strong>. Optimiza los recursos para dar mayor vida útil al equipamiento de frío',
            'Contenido2_Titulo' => 'IoT - Internet de las cosas',
            'Contenido2_Texto'  => 'Hacemos <strong>inteligente</strong> tu equipamiento de frío. Conectándolo a internet podrás monitorear desde cualquier lugar la <strong>temperatura y humedad en tiempo real</strong>. Adicionalmente, te entregamos un equipo de telemetría extra para medir el <strong>consumo eléctrico</strong> en tiempo real de una cámara de frío.',
            'Contenido2_IMG'    => 'view_1_1.png',

            'porHacerTitulo'    => '¿Qué puedes hacer con 1°C?',
            'porHacerPuntos'    => [
                ['Icono' => 'bi bi-pc-display-horizontal', 'Titulo' => 'Monitorear',   'Texto' => 'Desde cualquier lugar podrás saber en TIEMPO REAL qué cámara está en condiciones óptimas y cuáles no.',],
                ['Icono' => 'bi bi-bar-chart',             'Titulo' => 'Trazabilidad', 'Texto' => 'Esencial para dar un respaldo frente a auditorías internas o solicitudes de clientes sobre T° de almacenaje.',],
                ['Icono' => 'bi bi-broadcast-pin',         'Titulo' => 'Sensores',     'Texto' => 'Utilizamos sensores digitales con calibración única al vacío. Miden temperatura desde -40°C a +80°C.',],
                ['Icono' => 'bi bi-bell',                  'Titulo' => 'Alertas',      'Texto' => 'Te alertamos directamente al correo y/o al Whatsapp para mejorar la gestión.',],
            ],

            'CaracteristicasTitulo' => 'Funciones',
            'CaracteristicasPuntos' => [
                ['Titulo' => 'La información que quieras a tu alcance','Texto' => 'Monitorea interactivamente desde donde quiera que estés. ¡Descarga gráficos y datos cuándo lo necesites!',                                  'IMG' => 'view_1_2.png',],
                ['Titulo' => 'Las alertas cuando más lo necesites',    'Texto' => '1°C, puede generar alertas cuando se detecten temperaturas fuera del rango permitido. Te enviamos un Whatsapp directamente a tu telefono', 'IMG' => 'view_1_3.jpg',],
            ],
        ];
        $ViewData[2] = [
            'ModalTitle'        => 'Agro-Checking',
            'Subtitulo'         => 'Ventiladores contra heladas.',
            'Contenido1_Titulo' => '',
            'Contenido1_Texto'  => '',
            'Contenido2_Titulo' => '',
            'Contenido2_Texto'  => '',
            'Contenido2_IMG'    => '',

            'porHacerTitulo'    => '',
            'porHacerPuntos'    => [
                ['Icono' => 'asd','Titulo' => 'qwer','Texto' => 'asdasd',],
            ],

            'CaracteristicasTitulo' => '',
            'CaracteristicasPuntos' => [
                ['Titulo' => 'qwer','Texto' => 'asdasd','IMG' => 'asdasd',],
            ],
        ];
        $ViewData[3] = [
            'ModalTitle'        => 'Agro-Weather',
            'Subtitulo'         => '',
            'Contenido1_Titulo' => '',
            'Contenido1_Texto'  => '',
            'Contenido2_Titulo' => '',
            'Contenido2_Texto'  => '',
            'Contenido2_IMG'    => '',

            'porHacerTitulo'    => '',
            'porHacerPuntos'    => [
                ['Icono' => 'asd','Titulo' => 'qwer','Texto' => 'asdasd',],
            ],

            'CaracteristicasTitulo' => '',
            'CaracteristicasPuntos' => [
                ['Titulo' => 'qwer','Texto' => 'asdasd','IMG' => 'asdasd',],
            ],
        ];
        $ViewData[4] = [
            'ModalTitle'        => 'Power-Crane',
            'Subtitulo'         => 'Maquinaria de alto tonelaje.',
            'Contenido1_Titulo' => 'Monitoreo de maquinaria de alto tonelaje',
            'Contenido1_Texto'  => 'Power-Crane es un sistema de monitoreo basado en tecnología IoT (internet de las cosas) que permite monitorear las variables críticas de una grúa de construcción. Además, permite visualizar el trabajo REAL realizado por el operario (Horario real de trabajo en obra). Todo esto a través de sensores que son conectados al equipamiento (telemetría)',
            'Contenido2_Titulo' => 'IoT - Internet de las cosas',
            'Contenido2_Texto'  => 'Power-Crane es una plataforma web que procesa información entregada por los sensores conectados a las grúas. También conocido como telemetría, el IoT, consta de hacer inteligente una grúa de construcción conectándola a internet, monitorear remotamente los KPI’s en tiempo real y apagar/encender remotamente éstas. Finalmente, se muestra la información en un dashboard e informes para tomar decisiones rápidas y efectivas',
            'Contenido2_IMG'    => 'view_4_1.png',

            'porHacerTitulo'    => '¿Qué puedes hacer con Power-Crane?',
            'porHacerPuntos'    => [
                ['Icono' => 'bi bi-pie-chart', 'Titulo' => 'Dashboard',      'Texto' => 'Cada grúa tiene su propio panel para monitorear desde nuestra plataforma web',],
                ['Icono' => 'bi bi-people',    'Titulo' => 'Trabajo real',   'Texto' => 'Podrás ver las horas trabajadas efectivas del operario, y así evitar malentendidos',],
                ['Icono' => 'bi bi-power',     'Titulo' => 'Apagado remoto', 'Texto' => 'Podrás apagar y/o encender remotamente cada una',],
                ['Icono' => 'bi bi-bell',      'Titulo' => 'Alertas',        'Texto' => 'Recibe en tu correo y plataforma web todos los parámetros fuera de rango',],
            ],

            'CaracteristicasTitulo' => 'Decisiones rápidas; ahorra tiempo',
            'CaracteristicasPuntos' => [
                ['Titulo' => 'Obtén trazabilidad', 'Texto' => 'Registra el comportamiento de cada motor (elevación, carro y giro) en sus tres fases. Además, puedes consultar por trazabilidad del voltaje en el tiempo.',                                             'IMG' => 'view_4_3.png',],
                ['Titulo' => 'Tiempo de uso',      'Texto' => 'Registra el tiempo de uso de cada motor en un tiempo determinado que tú elijas. Esto se calcula en base al consumo eléctrico que leen los sensores que instalamos.',                                    'IMG' => 'view_4_4.png',],
                ['Titulo' => 'Ciclos componentes', 'Texto' => 'En la plataforma, se registra la cantidad de horas y/o ciclos de cada contactor para determinar el cumplimiento de su vida útil. Además, se configura una alerta para prever una mantención a tiempo ', 'IMG' => 'view_4_5.png',],
            ],
        ];
        $ViewData[5] = [
            'ModalTitle'        => 'Power-Energy',
            'Subtitulo'         => 'Monitoreo eléctrico',
            'Contenido1_Titulo' => 'Monitoreo consumo eléctrico',
            'Contenido1_Texto'  => '<strong>¿Sabes cuánto consumes al mes? ¿Te gustaría poder gestionar el mismo mes el consumo eléctrico de tu planta y en tiempo real?</strong><br>Power-Energy es un sistema de <strong>monitoreo de consumo eléctrico en tiempo real</strong> para la planta completa y por cada maquinaria, pudiendo obtener el consumo por <strong>centro de costo</strong>. Además, el sistema Power-Energy entrega información valiosa para gestionar la <strong>eficiencia eléctrica</strong>, podrás ver consumo eléctrico del mes actual y mes anterior; Peaks de consumo eléctrico, demanda máxima de suministro del mes actual y 12 meses anteriores; potencia observada y voltaje de líneas trifásicas.',
            'Contenido2_Titulo' => 'IoT - Internet de las cosas',
            'Contenido2_Texto'  => 'Conectamos a internet el panel eléctrico general de la planta y el de cada maquinaria productiva. Esto, gracias a nuestro propios equipos de telemetría no invasivos que tienen su propia conexión y comunicación a internet. Lo más interesante es que puedes revisar los KPI’s en la plataforma web <strong>¡Y desde cualquier punto del país!</strong>',
            'Contenido2_IMG'    => 'view_5_1.png',

            'porHacerTitulo'    => '¿Qué puedes hacer con Power-Energy?',
            'porHacerPuntos'    => [
                ['Icono' => 'bi bi-pc-display-horizontal', 'Titulo' => 'Monitorear',   'Texto' => 'Desde cualquier computador y cualquier punto del país',],
                ['Icono' => 'bi bi-pencil-square',         'Titulo' => 'Revisar KPIs', 'Texto' => 'Revisa en tiempo real si se están cumpliendo los consumos y peaks.',],
                ['Icono' => 'bi bi-bell',                  'Titulo' => 'Alertas',      'Texto' => 'Crea alertas de parámetros fuera de rango. EJ: Consumo mes sobre X kW/h',],
            ],

            'CaracteristicasTitulo' => '',
            'CaracteristicasPuntos' => [
                ['Titulo' => 'Dashboard panel general o equipo en particular', 'Texto' => 'asdasd','IMG' => 'view_5_2.png',],
                ['Titulo' => '¿Sabes cuánto estás consumiendo en el mes?',     'Texto' => 'asdasd','IMG' => 'view_5_3.png',],
                ['Titulo' => '¿Demanda máxima suministrada? Aquí está',        'Texto' => 'asdasd','IMG' => 'view_5_4.png',],
                ['Titulo' => 'También, potencia en hora punta',                'Texto' => 'asdasd','IMG' => 'view_5_5.png',],
                ['Titulo' => 'Revisa la potencia observada',                   'Texto' => 'asdasd','IMG' => 'view_5_6.png',],
            ],
        ];

        //Datos enviados a la pagina
        $f3->data = [
            'ViewData' => $ViewData[$params['id']],
        ];

        //Se instancia la vista
        $view = new View;
        echo $view->render('../'.$this->returnRutaVista(__DIR__, 'app').'/main-View.php'); // Vista
    }

    /******************************************************************************/
    //Recuperar Contraseña
    public function error404($f3){

        //Datos enviados a la pagina
        $f3->data = [
            /*=========== Datos de la Pagina ===========*/
            'PageTitle'       => 'Página de error',
            'PageDescription' => 'asd',
            'PageAuthor'      => 'asd',
            'PageKeywords'    => 'asd',
        ];

        //Se instancia la vista
        $view = new View;
        echo $view->render('../app/templates/error404.php'); // pagina
    }



}