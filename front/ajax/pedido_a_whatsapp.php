<?php
include('../config/app.php');
$url = SERVER_URL;
header("Access-Control-Allow-Origin:" . $url);
header("Access-Control-Allow-Methods:POST");
header("Access-Control-Allow-Headers:Content-Type");




if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["success" => false, "message" => "Acceso invalido"]);
    exit();
}


$data = file_get_contents('php://input');
$data = json_decode($data, true);

if (isset($data['action']) && $data['action'] == 'pedido_whatsapp') {

    $codigo_pedido = $data['codigo_pedido'];
    $id_cliente = $data['id_cliente'];

    //hasta aqui modificando....

    $peticion_ajax = true;
    require_once('../Controllers/PedidosController.php');

    //Obtenemos la cantidad de pedidos actuales en la tabla 'pedidos'
    $PedidosController = new PedidosController();
    $data = $PedidosController->get_pedido_enviado($codigo_pedido, $id_cliente);

    //echo json_encode($data);
    //exit();

    $cliente = $data['cliente'];
    $destinatario = $data['destinatario'];
    $datos_pedido = $data['datos_pedido'];
    $precio_total = $data['precio_total'];
    $productos = $data['productos'];






    $numero_destino = '56996113302';

    $texto = "Nuevo pedido desde el sitio: \n" . SERVER_URL . "\n\n" .
        "Código: " . $datos_pedido['codigo'] . "\n" .
        "Nombre: " . $cliente['cli_nombre'] . "\n" .
        "Destinatario: " . $destinatario['des_nombre'] . "\nEstado: " . ucwords($datos_pedido['estado']) . "\n\nProductos:\n\n";

    foreach ($productos as $el) {
        $texto .= "Nombre: " . $el['nombre'] . "\nCantidad: " . $el['cantidad'] . "\nPrecio(por unidad): $" . number_format($el['precio_venta'],0,'','.') . "\nPrecio total: $" . number_format($el['precio_total'],0,'','.') . "\n\n";
    }

    $texto .= "\nPrecio Total del pedido: $" . number_format($precio_total['det_precio_total'], 0, '', '.');

    $texto .= "\nEl pago lo realiza al recibir el pedido.";

   


    $url = 'https://api.whatsapp.com/send?phone=' . $numero_destino . '&text=' . rawurlencode($texto);
    //$url = "https://api.whatsapp.com/send?phone=".$numero_destino."&text=".rawurlencode($text


    $response = [
        "status" => true,
        "texto" => $texto,
        "url" => $url
    ];

    echo json_encode($response);
    exit();
} else {
    echo "Acceso denegado";
}
