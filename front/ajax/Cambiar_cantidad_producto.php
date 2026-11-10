<?php 


$productos = unserialize($_COOKIE['productos']);

foreach( $productos as $clave => $valor ){
    if( $valor['id'] == $_POST['id'] ){

        if( $_POST['action'] == 'mas'){

            if($productos[$clave]['cantidad'] >= 1){
                $productos[$clave]['cantidad']++;                
            }

        }else{
            if($productos[$clave]['cantidad'] > 1){
                $productos[$clave]['cantidad']--;
            }

        }
    }
}


setcookie('productos', serialize($productos)); 
echo json_encode($productos);
