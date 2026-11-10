<?php 


    if($peticion_ajax){
    require_once('../Models/MainModel.php');
    }else{
        require_once('./app/Models/MainModel.php');
    }

class UserModel extends MainModel {

    protected static function all(){
        $sql = "SELECT id, nombre, email, nivel FROM usuarios";
        $usuarios = MainModel::ejecutar_consulta_simple($sql);
        return $usuarios;
    }


    protected static function create($datos){
        $sql = "INSERT INTO usuarios (nombre,email, nivel, password) 
        VALUES(:nombre,:email, :nivel, :password);";

        $sentencia = MainModel::conectar()->prepare($sql);
        $sentencia->bindParam(':nombre', $datos['nombre']);
        $sentencia->bindParam(':email', $datos['email']);
        $sentencia->bindParam(':nivel', $datos['nivel']);
        $sentencia->bindParam(':password', $datos['password']);
        $sentencia->execute();
        return $sentencia;
    }


    protected static function find($id){
        $sql = "SELECT id, nombre, email, nivel FROM usuarios WHERE id= '". $id ."';";
        $query = MainModel::ejecutar_consulta_simple($sql);
        $usuario = $query->fetch(PDO::FETCH_ASSOC);
        return $usuario;   
    }


    protected static function update( $datos ){
        $sql = "UPDATE usuarios 
                SET nombre =:nombre,
                    email =:email,
                    nivel = :nivel,
                    password = :password
                WHERE id = :id ;";

        $sentencia = MainModel::conectar()->prepare($sql);
        $sentencia->bindParam(':id', $datos['id']);
        $sentencia->bindParam(':nombre', $datos['nombre']);
        $sentencia->bindParam(':email', $datos['email']);
        $sentencia->bindParam(':nivel', $datos['nivel']);
        $sentencia->bindParam(':password', $datos['password']);
        $sentencia->execute();

        return $sentencia;

    }


    protected static function destroy($id){

        $sql = "DELETE FROM usuarios WHERE id=:id";
        $sentencia = MainModel::conectar()->prepare($sql);
        $sentencia->bindParam(':id', $id);
        $sentencia->execute();
        return $sentencia;

    }




     public static function get_num_usuarios(){
        $sql = "SELECT COUNT(id) as num FROM usuarios";
        $resultado = MainModel::ejecutar_consulta_simple($sql);
        $numero = $resultado->fetch(PDO::FETCH_ASSOC);
        return $numero['num']; 
    }

}
