<?php

if ($peticion_ajax) {
    require_once('../Models/MainModel.php');
} else {
    require_once('./app/Models/MainModel.php');
}


class ClientesModel extends MainModel{

    
    public static function get_num_clientes(){
        $sql = "SELECT COUNT(id) as num FROM clientes";
        $resultado = MainModel::ejecutar_consulta_simple($sql);
        $numero = $resultado->fetch(PDO::FETCH_ASSOC);
        return $numero['num']; 
    }


    public static function get_all(){
        $sql = "SELECT id, nombre,email,direccion,telefono FROM clientes;";
        $resultado = MainModel::ejecutar_consulta_simple($sql);
        $clientes = $resultado->fetchAll(PDO::FETCH_ASSOC);
        return $clientes;

    }
}
