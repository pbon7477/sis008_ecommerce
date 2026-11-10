<?php 
setcookie('productos',"");

session_start();
$_SESSION['destinatario']['nombre'] = '';
$_SESSION['destinatario']['email'] = '';
$_SESSION['destinatario']['direccion'] = '';
$_SESSION['destinatario']['telefono'] = '';

$response = [
    "status"=>true,
    "message"=>"Los productos del carrito y los datos del destinatario han sido vaciados."
];

echo json_encode($response);

