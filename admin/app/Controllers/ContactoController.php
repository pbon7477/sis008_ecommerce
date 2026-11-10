<?php

require __DIR__ . '/../Models/ContactoModel.php';

class ContactoController extends ContactoModel {

    public function get_all(){
        $mensajes = ContactoModel::all();
        $mensajes = $mensajes->fetchAll(PDO::FETCH_ASSOC);
        return $mensajes;
    }


    public function get_one(string $id){
        $mensaje_data = ContactoModel::get($id);
        return $mensaje_data;
    }


    public function set_mensaje_leido(string $id){
        $response = ContactoModel::set_leido($id);
        return $response;
    }
    
    public function set_mensaje_no_leido(string $id){
        $response = ContactoModel::set_no_leido($id);
        return $response;
    }


    public function set_mensaje_respondido(int $id){
        $response = ContactoModel::set_respondido($id);
        return $response;
    }


    public function eliminar_mensaje(int $id){
        $response = ContactoModel::delete($id);
        return $response;
    }
}
