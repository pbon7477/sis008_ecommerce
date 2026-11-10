<?php 

    if($peticion_ajax){
    require_once('../Models/MainModel.php');
    }else{
        require_once('./app/Models/MainModel.php');
    }

    class CategoriasModel extends MainModel {

        protected static function all (){
            $sql = "SELECT * FROM categorias ORDER BY nombre ASC";
            $query = MainModel::ejecutar_consulta_simple($sql);
            return $query;
        }

        protected static function find($id){
            $sql = "SELECT * FROM categorias WHERE id = '" . $id . "';";
            $query = MainModel::ejecutar_consulta_simple($sql);
            return $query;

        }


        protected static function create($data){
            $sql = "INSERT INTO categorias (nombre, descripcion)
                    VALUES(:nombre, :descripcion);";

            $sentencia = MainModel::conectar()->prepare($sql);
            
            $sentencia->bindParam(':nombre', $data['nombre']);
            $sentencia->bindParam(':descripcion', $data['descripcion']);
            $sentencia->execute();
            return $sentencia;
        }



        protected static function update($data){
            $sql = "UPDATE categorias SET nombre = :nombre, descripcion = :descripcion WHERE id= :id ; ";
            $sentencia = MainModel::conectar()->prepare($sql);
            
            $sentencia->bindParam(':id', $data['id']);
            $sentencia->bindParam(':nombre', $data['nombre']);
            $sentencia->bindParam(':descripcion', $data['descripcion']);
            $sentencia->execute();
            return $sentencia;
        }

        protected static function destroy($id){
            $sql = "DELETE FROM categorias WHERE id= :id ;";
            $sentencia = MainModel::conectar()->prepare($sql);

            $sentencia->bindParam(':id', $id);
            $sentencia->execute();
            return $sentencia;
        }






        public static function get_num_categorias(){
            $sql = "SELECT count(id) as num FROM categorias";
            $resultado = MainModel::ejecutar_consulta_simple($sql);
            $numero = $resultado->fetch(PDO::FETCH_ASSOC);
            return $numero['num'];
        }

        


    }
