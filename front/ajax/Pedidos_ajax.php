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



$peticion_ajax = true;

if( isset($_POST['action']) ){

    //require_once('./front/PedidosController.php');
    //$PedidosController = new PedidosController();

    if( $_POST['action'] == 'pedido-create'  ){
        session_start();
        $productos = $_SESSION['carrito'];
        $response = ['status'=>'success','message'=>'Pedidos_ajax.php','productos'=>$productos];
        echo json_encode($response);
        exit();
        
        }        

        $response = ["status" => false,"message" => "La acción es incorrecta"];
        echo json_encode($response);
        exit();







} else {
    $response = ['status'=>'error','message'=>'Acción no permitida'];
    echo json_encode($response);
    exit;
}



/** old */

    
    if (isset($_POST['action'])  && $_POST['action'] === 'pedido-create') {
        
        $productos = unserialize($_COOKIE['productos'] ?? "");
        
        session_start();
        $datos_cliente = $_SESSION['cliente'];
        $datos_destinatario = $_SESSION['destinatario'];





        //Guardamos al destinatario
    require_once('../Controllers/DestinatariosController.php');
    $DestinatarioController = new DestinatarioController();
    $destinatario_guardado = $DestinatarioController->create_destinatario($datos_destinatario, $datos_cliente['id']);
    $datos_destinatario['id'] = $destinatario_guardado['id_destinatario'];
    
    //Guardamos el pedido
    require_once('../Controllers/PedidosController.php');
    $PedidosController = new PedidosController();
    $pedido_guardado = $PedidosController->create_pedido($datos_cliente, $datos_destinatario, $productos);
    
    
    
    

    
    if ($destinatario_guardado['status'] && $pedido_guardado['status']) {
        
        $_SESSION['codigo_pedido'] = $pedido_guardado['codigo_pedido'];
        
        $response = [
            "status" => true,
            "message" => "El pedido ha sido registrado exitosamente en la BBDD"            
            ];
 
    } else {
        
        $response = [
            "status" => false,
            "message" => [
                "error"=>"No ha sido poscible registrar el pedido en la BBDD",
                "message_destinatario_guardado" => $destinatario_guardado['message'],
                "message_pedido_guardado"=> $pedido_guardado['message'] 
                ]
                
                ];
                }
                
                echo json_encode($response);
                exit;

                
                
                } else {

                    $response = [
                        "status" => false,
                        "message" => "No se ha enviado ningun detalle del pedidos"
                        ];
                        
    echo json_encode($response);
                        
    exit;
}
