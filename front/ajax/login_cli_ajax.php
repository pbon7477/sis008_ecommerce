<?php
include('../config/app.php');
$url = SERVER_URL;
header("Access-Control-Allow-Origin:" . $url);
header("Access-Control-Allow-Methods:POST, OPTIONS");
header("Access-Control-Allow-Headers:Content-Type");

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo "Acceso denegado";
    header("Location:". SERVER_URL);
    exit;
}




$peticion_ajax = true;

$input = file_get_contents("php://input");
$data = json_decode($input, true);

$respuesta = false;


if($data['action'] === 'auth'){
    require_once('../Controllers/LoginClienteController.php');
    $LoginClienteController = new LoginClientesController();

    
    if ($data['type'] == 'login') {     
        
        echo $LoginClienteController->iniciar_session_clientes( $data['email'], $data['password']);
    
    }

    if( $data['type'] == 'logout' ){
        echo $LoginClienteController->cerrar_session_cliente();
    }



}else{
    header("Location:". SERVER_URL);
    exit;
}



