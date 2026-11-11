<?php 

$productos = unserialize($_COOKIE['productos']);

foreach( $productos as $producto => $clave ){

    if( $_POST['id'] == $clave['id'] ){
        unset($productos[$producto]);
    }
    
}

$productos = array_values($productos);
setcookie('productos', serialize($productos));

echo json_encode($productos);

