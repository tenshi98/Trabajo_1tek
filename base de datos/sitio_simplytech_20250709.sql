/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 80030 (8.0.30)
 Source Host           : localhost:3306
 Source Schema         : sitio_simplytech

 Target Server Type    : MySQL
 Target Server Version : 80030 (8.0.30)
 File Encoding         : 65001

 Date: 09/07/2025 10:52:45
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for sitios_listado
-- ----------------------------
DROP TABLE IF EXISTS `sitios_listado`;
CREATE TABLE `sitios_listado`  (
  `idSitio` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `idSistema` int UNSIGNED NOT NULL,
  `idEstado` int UNSIGNED NOT NULL,
  `Nombre` varchar(120) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Domain` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Whatsapp_number_1` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Whatsapp_number_2` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Whatsapp_tittle` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Header_Titulo` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Header_TituloStyle` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Header_Texto` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Header_TextoStyle` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Header_LinkNombre` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Header_LinkStyle` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Header_LinkURL` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Header_idNewTab` int UNSIGNED NOT NULL,
  `Header_idPopup` int UNSIGNED NOT NULL,
  `Contact_Tittle` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Contact_Tittle_body` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Contact_Address_tittle` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Contact_Address_body` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Contact_Email_tittle` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Contact_Email_body` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Contact_Phone_tittle` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Contact_Phone_body` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Contact_Recep_asunto` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Contact_Recep_mail` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Contact_Recep_name` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Social_Tittle` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Social_Twitter` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Social_Facebook` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Social_Instagram` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Social_Googleplus` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Social_Linkedin` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Config_Logo_Nombre` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Config_Logo_Archivo` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Config_Root_Folder` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Config_Menu` int UNSIGNED NOT NULL,
  `Config_MenuOtros` int UNSIGNED NOT NULL,
  `Config_Carousel` int UNSIGNED NOT NULL,
  `Config_Links_Rel` int UNSIGNED NOT NULL,
  `Config_Top_Bar` int UNSIGNED NOT NULL,
  `Config_Footer_Links` int UNSIGNED NOT NULL,
  `Config_Footer_Services` int UNSIGNED NOT NULL,
  `Config_Footer_Letters` int UNSIGNED NOT NULL,
  `Config_SMTP_mailUsername` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Config_SMTP_mailPassword` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Config_SMTP_Host` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Config_SMTP_Port` int UNSIGNED NOT NULL,
  `Config_SMTP_Secure` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Nosotros_Titulo` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Nosotros_Subtitulo` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Nosotros_Texto` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Nosotros_Link` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`idSitio`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci COMMENT = 'Limpiar al entregar' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sitios_listado
-- ----------------------------
INSERT INTO `sitios_listado` VALUES (1, 2, 1, 'SimplyTech', 'https://www.simplytech.cl', '56990994763', '', '', 'Digitalización de tu Negocio', '', 'Optimiza tu éxito empresarial: digitaliza tus procesos, simplifica tu camino al progreso', '', '', '', '', 0, 0, 'Contactenos', 'Si tiene alguna duda o consulta sobre el funcionamiento de la plataforma, env&iacute;enos un correo y le responderemos a la brevedad', 'Nuestra Direccion', 'Guardia Vieja 202, Of 902, Providencia', 'Nuestro Email', 'clientes@simplytech.cl', 'Nuestro Telefono', '56 9 9099 4763', '', '', '', '', '', '', '', '', '', '', 'logo.png', 'sitio_web_crosstech', 1, 1, 2, 2, 2, 1, 1, 2, '', '', '', 0, '', 'Quienes Somos', '', 'Somos una empresa innovadora dedicada a la creación de soluciones efectivas en procesos de negocios fundamentales, a través de la integración de diversas tecnologías y sofisticados mecanismos de procesamiento de datos', '');

-- ----------------------------
-- Table structure for sitios_listado_body
-- ----------------------------
DROP TABLE IF EXISTS `sitios_listado_body`;
CREATE TABLE `sitios_listado_body`  (
  `idBody` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `idSitio` int UNSIGNED NOT NULL,
  `idTipo` int UNSIGNED NOT NULL,
  `Icono` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `IconoStyle` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Titulo` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `TituloStyle` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Texto` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `TextoStyle` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `LinkNombre` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `LinkStyle` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `LinkURL` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `idNewTab` int UNSIGNED NOT NULL,
  `idPopup` int UNSIGNED NOT NULL,
  `idEstado` int UNSIGNED NOT NULL,
  `idPosicion` int UNSIGNED NOT NULL,
  `Imagen` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`idBody`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 30 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci COMMENT = 'Limpiar al entregar' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sitios_listado_body
-- ----------------------------
INSERT INTO `sitios_listado_body` VALUES (1, 1, 2, 'bx bx-receipt', '', 'Dashboard', '', 'Toma decisiones rápidas, reacciona rápido, sé eficiente.', '', '', '', '', 0, 0, 1, 1, '');
INSERT INTO `sitios_listado_body` VALUES (2, 1, 2, 'bx bx-cube-alt', '', 'Tiempo real', '', 'Obtén mayor control frente a los parámetros exigidos por tu empresa.', '', '', '', '', 0, 0, 1, 2, '');
INSERT INTO `sitios_listado_body` VALUES (3, 1, 2, 'bx bx-images', '', 'Trazabilidad', '', 'Tener la información a mano siempre será tu mejor arma.', '', '', '', '', 0, 0, 1, 3, '');
INSERT INTO `sitios_listado_body` VALUES (4, 1, 2, 'bx bx-shield', '', 'Informes', '', 'Descarga informes en PDF y Excel para obtener los reportes.', '', '', '', '', 0, 0, 1, 4, '');
INSERT INTO `sitios_listado_body` VALUES (5, 1, 1, 'ri-gps-line', 'Crosschecking', 'Pulverizadores agr&iacute;colas', '', 'Monitoreo de aplicaciones fitosanitarias en tiempo real.  Hacemos inteligente cualquier tipo de pulverizador, permitiendo ver KPI’s de las aplicaciones fitosanitarias y as&iacute; tomar decisiones de la calidad de &eacute;stas.', '', 'Ver mas', '', 'view_servicio_1.php', 2, 1, 2, 100, 'Crosschecking.jpg');
INSERT INTO `sitios_listado_body` VALUES (6, 1, 1, 'ri-gps-line', 'SimWeather', 'Ventiladores contra heladas', '', 'Variables clim&aacute;ticas para campos agr&iacute;colas. Predicci&oacute;n de heladas con 93% de precisi&oacute;n en tiempo real con inteligencia artificial. Tambi&eacute;n es integrable a aspas anti-heladas y as&iacute; verificar el correcto funcionamiento.', '', 'Ver mas', '', 'view_servicio_2.php', 2, 1, 1, 4, 'Crossweather.jpg');
INSERT INTO `sitios_listado_body` VALUES (7, 1, 1, 'ri-gps-line', 'SimC', 'Monitoreo temperatura', '', 'Monitoreo de temperatura y humedad relativa  en tiempo real para ambientes controlados 24/7. Perfecto para la trazabilidad de c&aacute;maras de fr&iacute;o, camiones frigor&iacute;ficos, salas de proceso de alimentos, l&iacute;neas de proceso de frutas y prefr&iacute;os.', '', 'Ver mas', '', 'view_servicio_3.php', 2, 1, 1, 1, 'CrossC.png');
INSERT INTO `sitios_listado_body` VALUES (8, 1, 1, 'ri-gps-line', 'Crosstrack', 'Gesti&oacute;n de flota con GPS', '', 'M&aacute;s que un simple GPS… Monitorea cualquier tipo de veh&iacute;culo, obteniendo informes  y alertas que permiten tomar decisiones: ubicaci&oacute;n en tiempo real, ruta, kil&oacute;metros, tiempos de detenci&oacute;n, almacenaje.', '', 'Ver mas', '', 'view_servicio_4.php', 2, 1, 2, 99, 'Crosstrack.jpg');
INSERT INTO `sitios_listado_body` VALUES (9, 1, 1, 'ri-gps-line', 'SimEnergy', 'Consumo el&eacute;ctrico en tiempo real', '', 'Para monitorear el consumo el&eacute;ctrico total de una planta y por centro de costos. Podr&aacute;s obtener informaci&oacute;n valiosa para gestionar la eficiencia el&eacute;ctrica. Podr&aacute;s ver distintas variables, entre ellas: Peaks y demanda m&aacute;xima suministrada.', '', 'Ver mas', '', 'view_servicio_5.php', 2, 1, 1, 2, 'Crossenergy.png');
INSERT INTO `sitios_listado_body` VALUES (10, 1, 1, 'ri-gps-line', 'SimCrane', 'Maquinaria de alto tonelaje', '', 'Sistema de monitoreo en tiempo real de todo tipo de maquinaria que tenga motor y panel el&eacute;ctrico. El objetivo de este servicio es conocer las horas de uso real del equipo, balance de l&iacute;neas el&eacute;ctricas de motores, KPI’s, alertas y apagado remoto.', '', 'Ver mas', '', 'view_servicio_6.php', 2, 1, 1, 3, 'Crosscrane.png');
INSERT INTO `sitios_listado_body` VALUES (11, 1, 10, '', '', 'Como 1', '', 'Cargamos en la plataforma – y en conjunto con el cliente- los <strong>datos</strong> correspondientes al servicio elegido.', '', '', '', '', 0, 0, 1, 1, 'como 1.png');
INSERT INTO `sitios_listado_body` VALUES (12, 1, 10, '', '', 'Como 2', '', 'Además, configuramos los parámetros necesarios del servicio tomado para configurar alertas de ejecución/operación.', '', '', '', '', 0, 0, 1, 2, 'como 2.png');
INSERT INTO `sitios_listado_body` VALUES (13, 1, 10, '', '', 'Como 3', '', 'Se crea una caja de telemetría con internet, circuitería y sensores específicos según el tipo de servicio que requiera el cliente.', '', '', '', '', 0, 0, 1, 3, 'como 3.png');
INSERT INTO `sitios_listado_body` VALUES (14, 1, 10, '', '', 'Como 4', '', 'Instalamos esta caja de telemetría en el equipamiento productivo del cliente, como un tractor; grúa; nebulizador; vehículo general; cámara de frío; campo agrícola; motores eléctricos, etc.', '', '', '', '', 0, 0, 1, 4, 'como 4.png');
INSERT INTO `sitios_listado_body` VALUES (15, 1, 10, '', '', 'Como 5', '', 'La caja de telemetría envía los datos mediante internet a nuestra plataforma web, donde el cliente podrá ingresar y monitorear los KPI’s de los distintos servicios.', '', '', '', '', 0, 0, 1, 5, 'como 5.png');
INSERT INTO `sitios_listado_body` VALUES (16, 1, 10, '', '', 'Como 6', '', 'Te entregramos lainformación en tiempo real en formato dashboard e informes ejecutivos para que puedas tomar decisiones en equipo y en el menor tiempo posible.', '', '', '', '', 0, 0, 1, 6, 'como 6.png');
INSERT INTO `sitios_listado_body` VALUES (17, 1, 10, '', '', 'Como 7', '', 'Revisa desde cualquier dispositivo las alertas fuera de parámetro configuradas anteriormente. A la plataforma web puedes ingresar multidispositivo y las alertas las podrás ver desde tu correo.', '', '', '', '', 0, 0, 1, 7, 'como 7.png');
INSERT INTO `sitios_listado_body` VALUES (18, 1, 11, '', '', '¿Qu&eacute; es SimplyTech?', '', 'Somos un equipo compuesto por profesionales de diferentes aptitudes con el objetivo com&uacute;n de crear tecnolog&iacute;a para el 2020; IoT internet de las cosas, inteligencia artificial, ERP y desarrollos personalizados. Para nosotros, el “famoso” BIGDATA es sin duda lo m&aacute;s valioso para nuestros clientes.', '', '', '', '', 0, 0, 1, 1, '');
INSERT INTO `sitios_listado_body` VALUES (19, 1, 11, '', '', '¿Qué es el bigdata?', '', 'BIGDATA, hace referencia la obtención masiva de datos estructurados, para luego trabajar con ellos y entregar información relevante. Nuestra forma de obtener estos datos es a través de sensores que midan variables de todo tipo. Si adicionalmente, conectamos a internet esta lectura de variables, estaremos en presencia del “IoT” (internet de las cosas). Puedes revisar nuestros servicios', '', '', '', '', 0, 0, 1, 2, '');
INSERT INTO `sitios_listado_body` VALUES (20, 1, 11, '', '', '¿Qu&eacute; es IoT (internet of the things/internet de las cosas)', '', 'IoT es conectar a internet cualquier objeto inerte para obtener informaci&oacute;n del comportamiento de ciertas variables sin interacci&oacute;n humana de por medio. Por ejemplo, si instalamos sensores en una tractor agr&iacute;cola para obtener datos (bigdata) del comportamiento de &eacute;ste, y adem&aacute;s, transferimos por internet estos a datos a una plataforma web o app m&oacute;vil para mostrarlos, estaremos en presencia del “internet de las cosas”', '', '', '', '', 0, 0, 1, 3, '');
INSERT INTO `sitios_listado_body` VALUES (21, 1, 11, '', '', '¿Qué es la telemetría?', '', 'Telemetría, quiere decir, como dice la palabra Tele (lejos) – metría (medición), es decir, medir alguna variable a distancia. Nuestro equipo proveé completo servicio desde el hardware para medir la variable, hasta la plataforma web para visualizar esta información.', '', '', '', '', 0, 0, 1, 4, '');
INSERT INTO `sitios_listado_body` VALUES (22, 1, 11, '', '', '¿Qu&eacute; puedo hacer en la plataforma?', '', 'Nuestra plataforma SimplyTech, abarcan todos los servicios que puedas encontrar en nuestra web. Esta plataforma cuenta con una robusta estructura que permite crear multiusuarios, alertar cuando existan par&aacute;metros fuera de rango (ej: tractor excede velocidad de aplicaci&oacute;n de agroqu&iacute;micos), personalizaci&oacute;n y escalamiento de alertas, inteligencia artificial para predecir alguna variable con respecto al comportamiento hist&oacute;rico (ej: Temperatura dentro de una hora. Ver SimWeather )', '', '', '', '', 0, 0, 1, 5, '');
INSERT INTO `sitios_listado_body` VALUES (23, 1, 11, '', '', '¿Qu&eacute; tipos de servicios entrega SimplyTech?', '', 'IoT: Monitoreo de aplicaciones de agroqu&iacute;micos, unidad de meteorol&oacute;gia agr&iacute;cola inteligente, monitoreo de ambientes controlados, monitoreo de pozos profundos, monitoreo de gr&uacute;as de construcci&oacute;n, gesti&oacute;n GPS de flota.Licencias: Proveemos servicios de ERP para gestionar empresas de construcci&oacute;n y consecionarias de agua potable con un todas las exigencias de la superintendencia de servicios sanitarios SISSDesarrollos personalizados: ¡Somos capaces de mucho m&aacute;s! Si sientes que ninguno de estos servicios encaja con las necesidades de tu empresa, puedes solicitarnos crear tu propio proyecto para medir variables que est&eacute;n dentro de nuestro alcance… A J&uacute;piter a&uacute;n no llegamos, pero pronto. Cont&aacute;ctanos', '', '', '', '', 0, 0, 1, 6, '');
INSERT INTO `sitios_listado_body` VALUES (24, 1, 11, '', '', '¿Qué pasa si contrato más de un servicio?', '', 'Todos los servicios están integrados en una sola plataforma. Por lo que al contratar más de uno, aparecerán viñetas en la zona principal. Ahí, podrás escoger el servicio que quieras visualizar y monitorear.', '', '', '', '', 0, 0, 1, 7, '');
INSERT INTO `sitios_listado_body` VALUES (25, 1, 11, '', '', '¿Como se contratan los servicios?', '', 'Puedes enviarnos un correo a ventas@simplytech.cl y cotiza los servicios que t&uacute; quieras. R&aacute;pidamente, nuestro equipo se pondr&aacute; en contacto contigo', '', '', '', '', 0, 0, 1, 8, '');
INSERT INTO `sitios_listado_body` VALUES (26, 1, 11, '', '', '¿Qué pasa si falla un sensor?', '', 'Nuestro objetivo es entregar un servicio continuo a nuestros clientes, por lo que SIEMPRE estarán cubiertos por problemas técnicos y sin costo alguno. (siempre y cuando sean fallas de fábricas)', '', '', '', '', 0, 0, 1, 9, '');
INSERT INTO `sitios_listado_body` VALUES (27, 1, 11, '', '', '¿Cómo se conforma el cobro de los servicio?', '', 'IoT:\r\n– Pago único por concepto de instalación\r\n– Pago mensual/anual servicio de monitoreo\r\n\r\nLicencias:\r\n– Pago anual con contrato renovable automáticamente\r\n\r\nDesarrollos personalizados:\r\n\r\nIDEM IoT y Licencias. [El costo de desarrollo lo ponemos nosotros ;)]', '', '', '', '', 0, 0, 1, 10, '');
INSERT INTO `sitios_listado_body` VALUES (28, 1, 12, '', '', 'Cotizar', '', '', '', 'Cotizar', '', 'view_cotizar.php', 2, 1, 2, 1, '');
INSERT INTO `sitios_listado_body` VALUES (29, 1, 12, '', '', 'Ingresar', '', '', '', 'Ingresar', '', 'https://clientes.crosstech.cl/', 1, 2, 1, 2, '');

-- ----------------------------
-- Table structure for sitios_listado_carousel
-- ----------------------------
DROP TABLE IF EXISTS `sitios_listado_carousel`;
CREATE TABLE `sitios_listado_carousel`  (
  `idCarousel` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `idSitio` int UNSIGNED NOT NULL,
  `idEstado` int UNSIGNED NOT NULL,
  `idPosicion` int UNSIGNED NOT NULL,
  `Imagen` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Titulo` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `TituloStyle` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Subtitulo` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `SubtituloStyle` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Texto` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `TextoStyle` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `PosicionBloque` int NOT NULL,
  PRIMARY KEY (`idCarousel`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci COMMENT = 'Limpiar al entregar' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sitios_listado_carousel
-- ----------------------------

-- ----------------------------
-- Table structure for sitios_listado_links
-- ----------------------------
DROP TABLE IF EXISTS `sitios_listado_links`;
CREATE TABLE `sitios_listado_links`  (
  `idLinks` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `idSitio` int UNSIGNED NOT NULL,
  `idEstado` int UNSIGNED NOT NULL,
  `Nombre` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Enlace` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `PalabrasClave` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`idLinks`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci COMMENT = 'Limpiar al entregar' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sitios_listado_links
-- ----------------------------

-- ----------------------------
-- Table structure for sitios_listado_menu
-- ----------------------------
DROP TABLE IF EXISTS `sitios_listado_menu`;
CREATE TABLE `sitios_listado_menu`  (
  `idMenu` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `idSitio` int UNSIGNED NOT NULL,
  `idEstado` int UNSIGNED NOT NULL,
  `idPosicion` int UNSIGNED NOT NULL,
  `Nombre` varchar(120) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Link` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `idNewTab` int UNSIGNED NOT NULL,
  `idPopup` int UNSIGNED NOT NULL,
  PRIMARY KEY (`idMenu`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 8 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci COMMENT = 'Limpiar al entregar' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sitios_listado_menu
-- ----------------------------
INSERT INTO `sitios_listado_menu` VALUES (1, 1, 1, 1, 'Inicio', '#hero', 2, 2);
INSERT INTO `sitios_listado_menu` VALUES (2, 1, 1, 2, 'Clientes', '#clientes', 2, 2);
INSERT INTO `sitios_listado_menu` VALUES (3, 1, 1, 3, 'Nosotros', '#nosotros', 2, 2);
INSERT INTO `sitios_listado_menu` VALUES (4, 1, 1, 4, 'Servicios', '#servicios', 2, 2);
INSERT INTO `sitios_listado_menu` VALUES (5, 1, 1, 5, 'Como Funciona', '#como', 2, 2);
INSERT INTO `sitios_listado_menu` VALUES (6, 1, 1, 6, 'FAQ', '#faq', 2, 2);
INSERT INTO `sitios_listado_menu` VALUES (7, 1, 1, 7, 'Contacto', '#contacto', 2, 2);

-- ----------------------------
-- Table structure for sitios_listado_menu_otros
-- ----------------------------
DROP TABLE IF EXISTS `sitios_listado_menu_otros`;
CREATE TABLE `sitios_listado_menu_otros`  (
  `idMenuOtros` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `idSitio` int UNSIGNED NOT NULL,
  `idEstado` int UNSIGNED NOT NULL,
  `idPosicion` int UNSIGNED NOT NULL,
  `Nombre` varchar(120) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Link` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `idNewTab` int UNSIGNED NOT NULL,
  `idPopup` int UNSIGNED NOT NULL,
  PRIMARY KEY (`idMenuOtros`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 3 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci COMMENT = 'Limpiar al entregar' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of sitios_listado_menu_otros
-- ----------------------------
INSERT INTO `sitios_listado_menu_otros` VALUES (1, 1, 1, 1, 'Crea tu Proyecto', 'crea-tu-proyecto.php', 1, 2);
INSERT INTO `sitios_listado_menu_otros` VALUES (2, 1, 1, 2, 'Solicita una Reunion', 'reunion.php', 1, 2);

SET FOREIGN_KEY_CHECKS = 1;
