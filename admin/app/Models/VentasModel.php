<?php 

if($peticion_ajax){
    require_once('../Models/MainModel.php');
    }else{
        require_once('./app/Models/MainModel.php');
    }

class VentasModel extends MainModel {


    public static function get_num_ventas(){
        $sql = "SELECT COUNT(id) as num FROM ventas";
        $resultado = MainModel::ejecutar_consulta_simple($sql);
        $numero = $resultado->fetch(PDO::FETCH_ASSOC);
        return $numero['num']; 
    }

}