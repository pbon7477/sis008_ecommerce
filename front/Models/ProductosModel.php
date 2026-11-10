<?php 

require_once('./front/Models/MainModel.php');

class ProductosModel extends MainModel {

    protected static function allProductos(){
        $sql = "SELECT * FROM productos;";
        $query = MainModel::ejecutar_consulta_simple($sql);
        return $query;
    }


    protected static function buscarProductos(string $buscar){
        $sql = "SELECT * FROM produCtos WHERE nombre LIKE '%" . $buscar . "%' ORDER BY nombre;";
        $query = MainModel::ejecutar_consulta_simple($sql);
        return $query;
    }

    

}  