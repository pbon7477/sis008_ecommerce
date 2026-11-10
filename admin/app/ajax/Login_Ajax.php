<?php     

$peticion_ajax = true;
require_once('../../config/app.php');
session_start(['name'=>'SIS006']);

if(isset($_SESSION['token_SIS006']) && isset($_SESSION['nombre']) ){

   
    require_once('../Controllers/LoginController.php');
    $LoginController = new LoginController();
    $respuesta = $LoginController->cerrar_session_controlador();
    echo $respuesta;

}else{

    echo false;
}



?>