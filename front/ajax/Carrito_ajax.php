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
    require_once('../Controllers/CarritoController.php');
    $CarritoController = new CarritoController();

    if ($data['action'] == 'agregar-producto') {
        $response = $CarritoController->agregar_producto($data);
        echo json_encode($response);
        exit();
    }

    if ($data['action'] == 'leer-carrito') {
        $response = $CarritoController->leer_carrito();
        echo json_encode($response);
        exit();
    }

    if($data['action'] == 'mas' || $data['action'] == 'menos'){
        $response = $CarritoController->modificar_cantidad($data);
        echo json_encode($response);
        exit();
    }

    if($data['action'] == 'borrar-producto' && isset($data['id'])){
        $response = $CarritoController->borrar_producto($data['id']);
        echo json_encode($response);
        exit();
    }

    if($data['action'] == 'vaciar-carrito'){
        $response = $CarritoController->vaciar_carrito();
        echo json_encode($response);
        exit();
    }

    if($data['action'] == 'check-carrito'){
        $response = $CarritoController->check_carrito();
        echo json_encode($response);
        exit();
    }



    $response = [
        "status" => false,
        "message" => "La acción solicitada es incorrecta"
    ];

    echo json_encode($response);
    exit;



} else {
    $response = [
        "status" => false,
        "message" => "La acción es incorrecta"
    ];

    echo json_encode($response);
    exit;
}
