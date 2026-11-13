<?php 

if (!isset($peticion_ajax)) {
    $peticion_ajax = false;
}

define( 'SERVER_URL', 'http://localhost/sis008/' );
define( 'COMPANY', 'sis008 MyEcommerce' );

define('MONEDA','$');


date_default_timezone_set("America/Santiago");
$fechaHora = date('Y-m-d H:i:s');
