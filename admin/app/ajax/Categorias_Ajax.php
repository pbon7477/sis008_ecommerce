<?php 


$peticion_ajax = true;

if( isset($_POST['create']) || isset($_POST['update']) || isset($_POST['delete']) ){

        require_once('../Controllers/CategoriasController.php');
        $CategoriasController = new CategoriasController();

        if( isset($_POST['create']) && isset($_POST['nombre']) ){          
            echo $CategoriasController->create_category();
        }

        if( isset($_POST['update'])  && isset($_POST['nombre']) ){
            echo $CategoriasController->update_category();
        }

        if( isset($_POST['delete']) && isset($_POST['id']) ){
            echo  $CategoriasController->delete_category();
        }
        



}else{

    session_start(['name'=>'SIS006']);
    session_unset();
    session_destroy();
    header('Location:' . SERVER_URL . 'admin/');
    exit();
}