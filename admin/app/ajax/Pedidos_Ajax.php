<?php 

$peticion_ajax = true;

if(isset($data['action'])){
   





}else{
    session_start(['name'=>'SIS006']);
    session_unset();
    session_destroy();
    header('Location:' . SERVER_URL . 'admin/');
    exit();
}