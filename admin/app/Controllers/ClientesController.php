<?php

if ($peticion_ajax) {
    require_once('../Models/ClientesModel.php');
} else {
    require_once('./app/Models/ClientesModel.php');
}

class ClientesController extends ClientesModel{



    public function get_numero_clientes(){
        $numero = ClientesModel::get_num_clientes();
        return $numero;
    }


    public function get_all_clientes(){
        $clientes = ClientesModel::get_all();
        return $clientes;
    }
}
