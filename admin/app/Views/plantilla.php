<?php 
$peticion_ajax=false;
$modulo = $_GET['view'] ?? '';
require_once('./app/Controllers/VistasController.php');
$VistasController = new VistasController();
$vista = $VistasController->obtener_vista_controlador();


if( $vista == 'login' || $vista == '404'){
    require_once( './app/Views/contenidos/' . $vista . '-view.php' );

}else{
    session_start(['name' =>'SIS006']);
    session_regenerate_id(true);
    
    if( !isset($_SESSION['token_SIS006']) || !isset($_SESSION['email']) || !isset($_SESSION['id']) ){
        require_once('./app/Controllers/LoginController.php');
        $peticion_ajax = false;
        $LoginController = new LoginController();
        $LoginController->forzar_cierre_session_controlador();
    }
    
?>


<?php include('app/Views/inc/Header.php'); ?>


<?php  include($vista); ?>



<?php include('app/Views/inc/Footer.php'); ?>

  



<?php     
} ?>