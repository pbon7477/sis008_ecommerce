<?php


$peticion_ajax = true;

if (isset($_POST['action'])) {

    require_once('../Controllers/ContactoController.php');
    $ContactoController = new ContactoController();

    if ($_POST['action'] == 'get_one' && isset($_POST['id'])) {
        $response = $ContactoController->get_one($_POST['id']);

        echo json_encode($response);
        exit();
    } 

    if($_POST['action'] == 'set_leido' && isset($_POST['id'])){
        $response = $ContactoController->set_mensaje_leido($_POST['id']);

        echo json_encode($response);
        exit();
    }

    if($_POST['action'] == 'set_no_leido' && isset($_POST['id'])){
        $response = $ContactoController->set_mensaje_no_leido($_POST['id']);
        echo json_encode($response);
        exit();

    }

    if($_POST['action'] == 'set_respondido' && isset($_POST['id'])){
        $response = $ContactoController->set_mensaje_respondido($_POST['id']);
        echo json_encode($response);
        exit();
    }

    if($_POST['action'] == 'delete' && isset($_POST['id'])){
        $response = $ContactoController->eliminar_mensaje($_POST['id']);
        echo json_encode($response);
        exit();
    }


    exit();
    
} else {

    session_start(['name' => 'SIS006']);
    session_unset();
    session_destroy();
    header('Location:' . SERVER_URL . 'admin/');
    exit();
}
