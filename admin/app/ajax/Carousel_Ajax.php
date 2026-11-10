<?php

require_once('../../config/app.php');
$peticion_ajax = true;

$url = SERVER_URL;

header("Access-Control-Allow-Origin: " . $url);
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With, X-API-KEY, Origin, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset=utf-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $data = file_get_contents('php://input');
    $data = json_decode($data, true);


    require_once('../../app/Controllers/ProductosController.php');
    require_once('../../app/Controllers/CarouselController.php');

    $ProductosControler = new ProductosController();
    $CarouselController = new CarouselController();

    if ($data['action'] === 'get_product') {
        http_response_code(202);

        $producto = $ProductosControler->get_producto($data['id']);


        $response = [
            'status' => 'success',
            'producto' => $producto
        ];

        echo json_encode($response);
        exit();

    }

    if($data['action'] == 'create-item'){
        http_response_code(202);
        $response = $CarouselController->save_item($data['producto']);
        echo json_encode($response);
        exit();
    } 
    
    if($data['action'] == 'get-item'){
        http_response_code(202);
        $response = $CarouselController->get_item($data['id']);
        echo json_encode($response);
        exit();
    }

    if($data['action'] == 'update-item'){
        http_response_code(202);
        $response = $CarouselController->update_item($data['item']);
        echo json_encode($response);
        exit();
    }

    if( $data['action'] == 'delete-item' ){
        http_response_code(202);
        $response = $CarouselController->delete_item($data['id']);
        echo json_encode($response);
        exit();
    }

    
    
        http_response_code(405);
        exit();
    
} else {
    http_response_code(401);
    exit();
}
