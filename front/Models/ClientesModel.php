<?php 

require_once('MainModel.php');

class ClientesModel extends MainModel {

    protected static function create($formData){
        $sql = "INSERT INTO clientes (nombre,email,password) VALUES(:nombre,:email,:password);";
        $sentencia = MainModel::conectar()->prepare($sql);
        $sentencia->bindParam(':nombre', $formData['nombre']);
        $sentencia->bindParam(':email', $formData['email']);
        $sentencia->bindParam(':password', $formData['password']);

        $sentencia->execute();
        return $sentencia;

    }

    protected static function update_cliente_modelo($form_data){
        $sql = "UPDATE clientes SET nombre = :nombre,
                                    email= :email,
                                    direccion = :direccion,
                                    telefono = :telefono 
                                    WHERE id = :id ;";

        $sentencia = MainModel::conectar()->prepare($sql);
        $sentencia->bindParam(':id', $form_data['id']);                             
        $sentencia->bindParam(':nombre', $form_data['nombre']);                                    
        $sentencia->bindParam(':email', $form_data['email']);                                  
        $sentencia->bindParam(':direccion', $form_data['direccion']);                                    
        $sentencia->bindParam(':telefono', $form_data['telefono']);
        $sentencia->execute();
        
        return $sentencia;

    }

}