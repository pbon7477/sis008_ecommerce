<?php 
require_once('./front/config/app.php');


require_once('./front/Controllers/VistasController.php');
$VistasController = new VistasController();
$VistasController->cargar_plantilla_controlador();

?>


