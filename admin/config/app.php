<?php 

if (!isset($peticion_ajax)) {
    $peticion_ajax = false;
}

define( 'SERVER_URL', 'http://localhost/sis006/' );
define( 'COMPANY', 'sis006 MyEcommerce' );

define('MONEDA','$');


date_default_timezone_set("America/Santiago");
$fechaHora = date('Y-m-d H:i:s');
