<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= COMPANY; ?></title>
    <?php include('./front/Views/inc/Links.php'); ?>

    <?php
    require_once('./front/Controllers/VistasController.php');
    $VistasController = new VistasController();

    //EVALUAMOS LA VISTA 
    $vista = $VistasController->cargar_vistas_controlador();
    ?>


</head>


<body>
    <?php $peticion_ajax = false; ?>



    <div class="container-front">
        <?php include('./front/Views/inc/Navbar.php'); ?>
        <!-- // CONTENEDOR -->
        <div class="container">        

            <br>

            <?php include($vista); ?>
        </div>


        <?php include('./front/Views/inc/Footer.php'); ?>

    </div>


    <?php include('./front/Views/inc/Scripts.php'); ?>

</body>

</html>