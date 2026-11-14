<?php 

require_once('./front/Models/MainModel.php');

class ProductosModel extends MainModel {

    protected static function allProductos(){
        $sql = "SELECT * FROM productos WHERE stock > 0;";
        $query = MainModel::ejecutar_consulta_simple($sql);
        return $query;
    }


    protected static function buscarProductos(string $buscar){
        $sql = "SELECT * FROM produCtos WHERE nombre LIKE '%" . $buscar . "%' AND stock > 0 ORDER BY nombre;";
        $query = MainModel::ejecutar_consulta_simple($sql);
        return $query;
    }


    protected static function get_producto(int $id){


        $producto = null;
        
        try{
            $sql = "SELECT * FROM productos WHERE id = :id AND stock > 0 ;";
            $conexion = MainModel::conectar();
            $stm = $conexion->prepare($sql); 
            $stm->bindParam(':id',$id);
            $stm->execute();
            $resultado = $stm->fetch(PDO::FETCH_ASSOC);
            
            if($resultado != false){
                $producto = $resultado;
                
            }

        }catch(Exception $e){   
            error_log($e->getMessage());

        }
        return $producto;
    }

    

}  