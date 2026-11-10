<?php 

require_once('MainModel.php');

class DestinatarioModel extends MainModel {

    protected static function create($formData){


       
        $sql = "INSERT INTO destinatarios (nombre,email,direccion,telefono,id_cliente) VALUES(:nombre,:email,:direccion,:telefono,:id_cliente);";
        
        $conexion = MainModel::conectar();
        $sentencia = $conexion->prepare($sql);

        $sentencia->bindParam(':nombre', $formData['nombre']);
        $sentencia->bindParam(':email', $formData['email']);
        $sentencia->bindParam(':direccion', $formData['direccion']);
        $sentencia->bindParam(':telefono', $formData['telefono']);
        $sentencia->bindParam(':id_cliente', $formData['id_cliente']);

        $sentencia->execute();

        $rowCount = $sentencia->rowCount();
        $lastId = $conexion->lastInsertId();


        return [
            'rowCount' => $rowCount,
            'id_destinatario' => $lastId
        ];

    }

    protected static function update_destinatario_modelo($formData){
        $sql = "UPDATE destinatarios SET nombre = :nombre,
                                    email= :email,
                                    direccion = :direccion,
                                    telefono = :telefono,
                                    id_cliente = :id_cliente 
                                    WHERE id = :id ;";

        $sentencia = MainModel::conectar()->prepare($sql);
        $sentencia->bindParam(':nombre', $formData['nombre']);
        $sentencia->bindParam(':email', $formData['email']);
        $sentencia->bindParam(':direccion', $formData['direccion']);
        $sentencia->bindParam(':telefono', $formData['telefono']);
        $sentencia->bindParam(':id_cliente', $formData['id_cliente']);
        $sentencia->execute();
        
        return $sentencia;

    }

}