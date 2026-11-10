<?php 

    if($peticion_ajax){
    require_once('../Models/MainModel.php');
    }else{
        require_once('./app/Models/MainModel.php');
    }

   



class LoginModel extends MainModel {

    protected static function iniciar_session_modelo( array $datos_usuario ){
        
        $sql = "SELECT * from usuarios 
        WHERE email = :email 
        AND password = :password;";

        $sentencia = MainModel::conectar()->prepare($sql);

        $sentencia->bindParam(':email', $datos_usuario['email']);
        $sentencia->bindParam(':password', $datos_usuario['password']);
        $sentencia->execute();

        return $sentencia;
        
    }

}