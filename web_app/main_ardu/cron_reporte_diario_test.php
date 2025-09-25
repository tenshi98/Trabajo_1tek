<?php
/*******************************************************************/
//Se le da una interfaz al mensaje
$HTML_Body  = '
<div style="background-color: #182854; padding: 10px;">
    <img src="https://clientes.1tek.cl/img/login_logo_color.png" style="width: 30%;display:block;margin-left: auto;margin-right: auto;margin-top:30px;margin-bottom:30px;">
    <h3 style="text-align: center;font-size: 30px;color: #ffffff;">Resumen Estado Equipos del '.fecha_estandar($FechaSistema).'</h3>
    <p style="text-align: center;font-size: 20px;color: #ffffff;">TESTEO CORREO</p>';
/**************************************/
$HTML_Body .= '
<table rules="all" style="width:100%;border-collapse:collapse;margin: 25px 0;font-size: 0.9em;font-family: sans-serif; min-width: 400px;box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);" cellpadding="0" border="0">
    <thead>
        <tr style="background-color: #7a94cf;color: #ffffff;text-align: left;">
            <th colspan="8" style="padding: 12px 15px;text-align:center;"><strong>Resumen Estado Equipos</strong></th>
        </tr>
    </thead>
    <tbody>
        <tr style="background: #eee;">
            <td style="padding: 12px 15px;border: 1px solid #dddddd;"><strong>Subgrupo</strong></td>
            <td style="padding: 12px 15px;border: 1px solid #dddddd;"><strong>ppm Actual</strong></td>
            <td style="padding: 12px 15px;border: 1px solid #dddddd;"><strong>ppm Max</strong></td>
            <td style="padding: 12px 15px;border: 1px solid #dddddd;"><strong>ppm Min</strong></td>
        </tr>';
        foreach ($arrTelemetria as $tel) {
            $HTML_Body .= $MedicionesActuales_Correo[$tel['idTelemetria']];
        }
$HTML_Body .= '</tbody></table>';


/**************************************/
$HTML_Body .= '</div>';

/*******************************************************************/
//Envio de correo
$rmail = tareas_envio_correo('notificaciones@1tek.cl', 'Pruebas',
                                'humberto@1tek.cl', 'Humberto',
                                '', '',
                                'Resumen Estado Equipos',
                                $HTML_Body,'',
                                '',
                                2,
                                '',
                                '');

if ($rmail!=1) {
    echo "Envio Fallido->".$rmail.'<br/>';
} else {
    echo "Envio Correcto<br/>";
}

/*******************************************************************/
//Envio de correo
$rmail = tareas_envio_correo('notificaciones@1tek.cl', 'Pruebas',
                                'tenshi98@gmail.com', 'Victor',
                                '', '',
                                'Resumen Estado Equipos',
                                $HTML_Body,'',
                                '',
                                2,
                                '',
                                '');

if ($rmail!=1) {
    echo "Envio Fallido->".$rmail.'<br/>';
} else {
    echo "Envio Correcto<br/>";
}

?>