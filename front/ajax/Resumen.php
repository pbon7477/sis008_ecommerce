<?php
include('../config/app.php');
$url = SERVER_URL;
header("Access-Control-Allow-Origin:" . $url);
header("Access-Control-Allow-Methods:POST, OPTIONS");
header("Access-Control-Allow-Headers:Content-Type");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "Acceso invalido";
    exit;
}


$data = file_get_contents('php://input');
$data = json_decode($data, true);


$peticion_ajax = true;

if ( isset($data['codigo'])  && $data['action'] === 'resumen') {
    
    include("../Controllers/PedidosController.php");
    $PedidosController = new PedidosController();

    echo $PedidosController->get_resumen_pedido($data['codigo']);
    
    
}else{
    echo "Acceso invalido";
    exit;
}
