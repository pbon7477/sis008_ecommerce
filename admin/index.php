<?php 
require_once('./config/app.php');
require_once('./app/Controllers/VistasController.php');
$VistasController = new VistasController();
$VistasController->obtener_plantilla_controlador();

?>