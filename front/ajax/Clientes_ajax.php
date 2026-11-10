<?php
$peticion_ajax = true;


if( isset($_POST['create']) || isset($_POST['guardar_cliente_y_destinatario']) ){

    require_once('../Controllers/ClientesController.php');
    $ClientesController = new ClientesController();

    if( isset($_POST['create']) && isset($_POST['nombre']) && isset($_POST['email']) && isset($_POST['password1']) && isset($_POST['password2']) ){
        echo $ClientesController->create_cliente();
    }

    if( isset($_POST['guardar_cliente_y_destinatario']) && isset($_POST['nombre_cliente'])  && isset($_POST['nombre_destinatario'])  ){
        echo $ClientesController->session_cliente_y_destinatario();
        
    }
    

}else{
    echo json_encode(['message' => 'No se han enviado los datos']); 
}