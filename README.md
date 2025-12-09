# Sistema de Telemetría y Gestión ERP (1TEK)

Este proyecto es una plataforma integral de gestión empresarial y telemetría, diseñada para monitorear activos (vehículos, grúas, maquinaria), gestionar recursos humanos, bodegas, y operaciones comerciales. Integra datos provenientes de dispositivos IoT (Arduino/sensores) con un sistema ERP basado en web.

## Tabla de Contenidos

1. [Tecnologías Utilizadas](#tecnologías-utilizadas)
2. [Características Principales](#características-principales)
3. [Requisitos del Sistema](#requisitos-del-sistema)
4. [Estructura del Proyecto](#estructura-del-proyecto)
5. [Instalación](#instalación)
6. [Configuración](#configuración)
7. [Cómo Ejecutar el Proyecto](#cómo-ejecutar-el-proyecto)
8. [Descripción de Módulos](#descripción-de-módulos)
9. [Solución de Problemas](#solución-de-problemas)
10. [Notas Adicionales](#notas-adicionales)

## Tecnologías Utilizadas

*   **Lenguaje Principal:** PHP 7.x o superior
*   **Base de Datos:** MySQL
*   **Servidor Web:** Apache
*   **Frontend:** HTML5, JavaScript, jQuery, Bootstrap v3 (según estructura de vistas)
*   **Hardware/IoT:** Integración con Arduino y sensores de telemetría.
*   **Librerías Externas:** `LIBS_js`, `LIBS_php` (para generación de Excel, PDF, etc.)

## Características Principales

*   **Telemetría Avanzada:** Monitoreo en tiempo real de vehículos y maquinaria, alertas de sensores, control de geocercas y gestión de rutas.
*   **Gestión de Recursos Humanos (RRHH):** Administración de trabajadores, contratos, liquidaciones, asistencia, licencias y turnos.
*   **Gestión de Inventario y Bodega:** Control de stock, insumos, productos, arriendos y movimientos de bodega.
*   **Gestión Comercial:** Clientes, proveedores, órdenes de compra (OC), órdenes de trabajo (OT), cotizaciones y facturación.
*   **Seguridad y Control de Acceso:** Gestión de usuarios, perfiles, permisos y registro de accesos (visitas/contratistas).
*   **Reportes Automatizados:** Generación y envío automático de informes diarios, semanales y mensuales mediante Tareas Cron.

## Requisitos del Sistema

*   **Sistema Operativo:** Linux (Recomendado)
*   **Servidor Web:** Apache 2.4+ con módulo `mod_rewrite` habilitado.
*   **PHP:** Versión compatible con el código legacy (posiblemente 5.6 o 7.x).
*   **MySQL:** Servidor de base de datos MySQL o MariaDB.
*   **Acceso a Internet:** Para integración de mapas y servicios externos.

## Estructura del Proyecto

El proyecto se organiza en las siguientes carpetas principales:

*   **`sistema_telemetria/`**: Núcleo de la aplicación ERP web. Contiene las vistas, controladores y lógica de negocio principal.
    *   `core/`: Funciones esenciales del sistema, autenticación y configuración base.
    *   `img/`, `upload/`: Archivos multimedia y documentos subidos.
    *   Scripts PHP (`admin_*.php`, `informe_*.php`): Controladores para módulos específicos.
*   **`web_app/`**: Componentes backend adicionales y API para dispositivos.
    *   `ardu.php`, `ardu_include_*.php`: Scripts para la recepción y procesamiento de datos crudos desde dispositivos Arduino/IoT.
    *   `cron_*.php`: Scripts para tareas programadas (reportes, limpiezas).
*   **`A2XRXS_gears/`**: Librerías compartidas y archivos de configuración del sistema (`xrxs_configuracion`).
*   **`LIBS_js/` y `LIBS_php/`**: Bibliotecas de terceros para funcionalidades frontend y backend respectivamente.
*   **`sites_1tek_web/`**: Archivos relacionados con el sitio web público o portales satélite.
*   **`base de datos/`**: Scripts SQL para la creación y estructura de la base de datos.
*   **`Legacy/`**: Código antiguo o respaldos.

## Instalación

1.  **Clonar el Repositorio:**
    ```bash
    git clone https://github.com/tenshi98/Trabajo_1tek.git
    cd Trabajo_1tek
    ```

2.  **Configurar Base de Datos:**
    *   Crear una nueva base de datos en MySQL.
    *   Importar los scripts ubicados en la carpeta `base de datos/` para generar las tablas necesarias.

3.  **Configurar Apache:**
    *   Apuntar el `DocumentRoot` a la carpeta raíz del proyecto o a `Trabajo_1tek/sistema_telemetria/` según se desee exponer.
    *   Asegurarse de que el archivo `.htaccess` sea procesado correctamente para el manejo de URLs amigables.

4.  **Permisos:**
    *   Dar permisos de escritura a las carpetas `upload/`, `img/` y directorios de logs (`1_logs_*.txt`).

## Configuración

La configuración principal del sistema suele encontrarse en:

*   **`A2XRXS_gears/xrxs_configuracion/`**: Archivos de configuración de base de datos.
*   **`web_app/1_global_config.php`**: Variables globales para la aplicación de telemetría backend.

Edite estos archivos con las credenciales de su base de datos y rutas del servidor.

## Cómo Ejecutar el Proyecto

1.  **Interfaz Web:**
    *   Acceda a través del navegador web: `http://localhost/Trabajo_1tek/sistema_telemetria/` (o la URL configurada).
    *   Inicie sesión con credenciales de administrador.

2.  **Recepción de Datos (IoT):**
    *   Los dispositivos deben apuntar a `http://midominio.com/web_app/ardu.php` para enviar tramas de datos.

3.  **Tareas Programadas (Cron):**
    *   Configure `crontab` en su servidor Linux para ejecutar los scripts de mantenimientos y reportes.
    *   Ejemplo:
        ```bash
        # Ejecutar cada hora
        0 * * * * php /ruta/al/proyecto/web_app/cron_informe_hora.php
        ```

## Descripción de Módulos

### Sistema de Telemetría (`sistema_telemetria`)
*   **Dashboard (`principal*.php`):** Vista general del estado de la flota y alertas.
*   **Gestión de Equipos:** Registro de unidades GPS, sensores y configuración de parámetros.
*   **Informes:** Generación de reportes de velocidad, detenciones, consumo de combustible, temperatura, etc.

### Backend IoT (`web_app`)
*   **Procesamiento (`ardu*`):** Recibe datos RAW, aplica calibraciones y ponderaciones, inserta en DB y verifica geocercas/alertas.

### ERP y Gestión
*   **RRHH:** Módulos para sueldos, asistencia y documentación de empleados.
*   **Comercial:** Flujo completo desde cotización hasta facturación.
*   **Bodega:** Control de inventario y asignación de recursos a OTs.

## Solución de Problemas

*   **Error de conexión a DB:** Verifique las credenciales en `A2XRXS_gears/xrxs_configuracion`.
*   **Permisos de escritura:** Si no se suben imágenes o no se escriben logs, revise `chmod` en las carpetas `upload` y archivos `.txt`.
*   **Página en blanco:** Revise el `error_log` de Apache o habilite `display_errors` en PHP temporalmente para depurar.

## Notas Adicionales

*   Este sistema maneja información sensible (ubicación, datos personales). Asegure el servidor con HTTPS y restrinja el acceso a carpetas críticas.
*   Revise la carpeta `Legacy` antes de eliminar archivos, ya que puede contener referencias útiles de versiones anteriores.