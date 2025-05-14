<?php
/*******************************************************************************************************************/
/*                                              Se define la clase                                                 */
/*******************************************************************************************************************/
class main extends ControllerBase {
    /******************************************************************************/
    //Variables
    private $DBConn;
    private $QBuilder;

    /******************************************************************************/
    //Constructor
    public function __construct(){
        //se instancian los datos
        $MySQL_conn    = Database::getMySQLConnection(); //Conexion a la base de datos MySQL
        $queryBuilder  = new QueryBuilder();
        $mailSender    = new MailSender();
        $checkData     = new CheckData();
        //instancias para uso interno
        $this->DBConn    = $MySQL_conn;
        $this->QBuilder  = $queryBuilder;
        //se entregan datos a la clase padre
        parent::__construct($MySQL_conn, $queryBuilder, $mailSender, $checkData);
    }

    /******************************************************************************/
    //Vista - Index
    public function index($f3){

        //Variable vacia
        $socialLinks = [];
        $Links       = [];
        $Services    = [];
        $About    = [];

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
            ],
            [
                'iconTab'  => 'ri-body-scan-line',
                'TitleTab' => 'Agro-Checking',
                'Title'    => 'Ventiladores contra heladas.',
                'Text'     => '<p>Variables climáticas para campos agrícolas. Predicción de heladas con 93% de precisión en tiempo real con
                                inteligencia artificial. También es integrable a aspas anti-heladas y así verificar el correcto funcionamiento.</p>',
                'Img'      => '/assets/img/servicios/Agro-checking.jpg',
            ],
            [
                'iconTab'  => 'ri-body-scan-line',
                'TitleTab' => 'Agro-Weather',
                'Title'    => 'Ventiladores contra heladas.',
                'Text'     => '<p>Variables climáticas para campos agrícolas. Predicción de heladas con 93% de precisión en tiempo real con
                                inteligencia artificial. También es integrable a aspas anti-heladas y así verificar el correcto funcionamiento.</p>',
                'Img'      => '/assets/img/servicios/Agro-weather.jpg',
            ],
            [
                'iconTab'  => 'ri-sun-line',
                'TitleTab' => 'Power-Crane',
                'Title'    => 'Maquinaria de alto tonelaje.',
                'Text'     => '<p>Sistema de monitoreo en tiempo real de todo tipo de maquinaria que tenga motor y panel eléctrico.
                                El objetivo de este servicio es conocer las horas de uso real del equipo, balance de líneas eléctricas
                                de motores, KPI’s, alertas y apagado remoto.</p>',
                'Img'      => '/assets/img/servicios/Power-crane.png',
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
        echo $view->render('../app/templates/error404.php'); // Header
    }



}