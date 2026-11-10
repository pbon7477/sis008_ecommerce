<?php 

$peticion_ajax = true;

if( isset($_POST['create']) || isset($_POST['update']) || isset($_POST['delete']) ){

    require_once('../Controllers/UserController.php');
    $UserController = new UserController();
    
    if( isset($_POST['create']) &&  isset($_POST['nombre']) && isset($_POST['email']) && isset($_POST['password_1']) ){        
        echo $UserController->create_user();
    }    
    
    if( isset($_POST['update']) && isset($_POST['nombre']) && isset($_POST['email']) ){
        echo $UserController->update_user();
    }
    
    if( isset($_POST['delete']) && isset($_POST['id']) ){
        echo $UserController->delete_user();
    }
    
}else{
    session_start(['name'=>'SIS006']);
    session_unset();
    session_destroy();
    header('Location:' . SERVER_URL . 'admin/');
    exit();
}

