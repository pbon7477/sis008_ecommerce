<?php 

if( $peticion_ajax ){
    require_once('../Models/VentasModel.php');
}else{
    require_once('./app/Models/VentasModel.php');
}


class VentasController extends VentasModel {


    public function get_numero_ventas(){
        $numero = VentasModel::get_num_ventas();
        return $numero;
    } 



}