<?php 


$peticion_ajax = true;

if( isset($_POST['create']) || isset($_POST['update'])  || isset($_POST['delete']) ){

        require_once('../Controllers/ProductosController.php');
        $ProductoController = new ProductosController();

        if( isset($_POST['create']) && isset($_POST['nombre']) ){          
            echo $ProductoController->create_producto();
        }

       if( isset($_POST['update']) && isset($_POST['id']) && isset($_POST['nombre']) ){
           echo $ProductoController->update_producto(); 
       }

       if( isset($_POST['delete']) && isset($_POST['id']) ){
           echo $ProductoController->delete_producto(); 
       }


}else{

    session_start(['name'=>'SIS006']);
    session_unset();
    session_destroy();
    header('Location:' . SERVER_URL . 'admin/');
    exit();
}