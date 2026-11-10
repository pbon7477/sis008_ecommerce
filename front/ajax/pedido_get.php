<?php
session_start();
include('../config/app.php');
$url = SERVER_URL;
header("Access-Control-Allow-Origin:" . $url);
header("Access-Control-Allow-Methods:POST, OPTIONS");
header("Access-Control-Allow-Headers:Content-Type");



if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "Acceso invalido";
    exit();
}

$peticion_ajax = true;


$data = file_get_contents('php://input');
$data = json_decode($data, true);


if (isset($data['action'])) {

    require_once('../Controllers/PedidosController.php');
    $PedidosController = new PedidosController();
    
    if ($data['action'] == 'get_pedido_data') {

        echo $PedidosController->get_pedido_data($data['codigo_pedido']);
        exit();
    }


    if($data['action'] == 'get_pedidos'){
        echo $PedidosController->get_pedidos($_SESSION['id_cliente']);  
        exit();  
    }






} else {
    $response = [
        "status" => false,
        "message" => "La acción solicitada no es correcta"
    ];

    echo json_encode($response);
    exit;
}
