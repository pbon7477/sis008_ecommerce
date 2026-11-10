<?php
$peticion_ajax= true;
require_once('../Controllers/PedidosController.php');


if($_SERVER['REQUEST_METHOD'] !== 'GET'){
    echo json_encode(["success"=>false,"message"=>"Acceso invalido"]);
    exit;
}


//Obtenemos la cantidad de pedidos actuales en la tabla 'pedidos'
$PedidosController = new PedidosController();
$cantidad_pedidos_actual = $PedidosController->cantidad_actual();
$numero_pedido = $cantidad_pedidos_actual + 1;

//generar codigo del pedido
$codigo = $PedidosController->codigo_pedido();



//Obtenemos los productos desde las cookies
$productos = unserialize($_COOKIE['productos'] ?? "");

//Obtenemos el ID del cliente
//sacamos los datos del cliente y su destinatario de la session 
session_start();
$datos_cliente = $_SESSION['cliente'];
$datos_destinatario = $_SESSION['destinatario'];
$id_cliente = $_SESSION['id_cliente'];

//Guardar pedido y detalle de pedido
echo $PedidosController->guardar_pedido($id_cliente, $codigo, $productos);
return;




$cantidad_productos = count($productos); 
$precio_total = 0;   

$mis_productos = "";

foreach ($productos  as $index => $prod) {
    $precio_total += $prod['precio_venta'] * $prod['cantidad'];
    $mis_productos .= "→ " . $prod['nombre'] . " -  $" . number_format($prod['precio_venta'],0,'','.') ." (" . $prod['cantidad']. " unidades = " . number_format(($prod['precio_venta'] * $prod['cantidad']),0,'','.') . " )\n";
}




$numero_destino = '56996113302';

$texto = "Nuevo pedido desde el sitio ".SERVER_URL . "\n" . 
         "N° Pedido: " . $numero_pedido . "\n" . 
         "Codigo: " . $codigo . "\n" . 
         "Nombre: " . $datos_cliente['nombre'] . "\n" . 
         "Destinatario: " . $datos_destinatario['nombre'] . "\n\n" .
         "Productos: \n" .  $mis_productos . "\n" . 
         "Precio Total: $" . number_format($precio_total,0,'','.');


$url = 'https://api.whatsapp.com/send?phone=' . $numero_destino . '&text=' . rawurlencode($texto); 
//$url = "https://api.whatsapp.com/send?phone=".$numero_destino."&text=".rawurlencode($text
        

$response = [
    "status" => true,
    "texto" => $texto,
    "url"=> $url
];

echo json_encode($response);
