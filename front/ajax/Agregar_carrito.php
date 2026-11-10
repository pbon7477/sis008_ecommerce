<?php 

$productos = unserialize ($_COOKIE['productos'] ?? '');


if( is_array( $productos ) == false ){
    $productos = [];    
} 

$existe = false;

foreach( $productos as $key => $value ){
    if( $value['id'] == $_POST['id'] ){
        $productos[$key]['cantidad'] =  $productos[$key]['cantidad'] +  $_POST['cantidad'];
        $existe = true;
    }
}

if( $existe == false ){
    $nuevo_producto = [
        'id' => $_POST['id'],
        'nombre' => $_POST['nombre'],
        'imagen' => $_POST['imagen'],
        'cantidad' => $_POST['cantidad'],
        'precio_venta' => $_POST['precio_venta']
    ];

    array_push($productos, $nuevo_producto);
}


setcookie("productos",serialize($productos));


echo json_encode($productos);


?>