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

    if ($data['action'] == 'agregar_producto') {


        require_once('../Controllers/CarritoController.php');

        $CarritoController = new CarritoController();
        $response = $CarritoController->agregar_producto($data);
        echo json_encode($response);
        exit();

    } else {

        $response = [
            "status" => false,
            "message" => "La acción solicitada no es correcta"
        ];

        echo json_encode($response);
        exit;
    }

} else {
    $response = [
        "status" => false,
        "message" => "La acción es incorrecta"
    ];

    echo json_encode($response);
    exit;
}
