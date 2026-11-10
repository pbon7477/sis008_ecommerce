<?php 

require_once('MainModel.php');

class CarouselModel extends MainModel {

    public static function all(){
        $sql = "SELECT * FROM carousel";
        $items = MainModel::ejecutar_consulta_simple($sql);
        return $items;
    }

}