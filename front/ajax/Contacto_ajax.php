<?php
$peticion_ajax=true;
include('../config/app.php');
$url = SERVER_URL;
header("Access-Control-Allow-Origin:" . $url);
header("Access-Control-Allow-Methods:POST");
header("Access-Control-Allow-Headers:Content-Type");



if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo "Acceso invalido";
    exit();
}


$data = file_get_contents('php://input');
$data = json_decode($data,true);

if($data['action']){

    if($data['action'] === 'save_message'){
       http_response_code(202); 
       require_once('../Controllers/ContactoController.php');
       $ContactoController = new ContactoController();
       $response = $ContactoController->save_message($data);
       echo json_encode($response);
       exit();
    } 


}else{
    http_response_code(403);
    exit();
}

