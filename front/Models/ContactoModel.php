<?php

require('MainModel.php');

class ContactoModel extends MainModel
{

    public static function save(array $data)
    {

        try { 

            $sql = "INSERT INTO mensajes(nombre,email,telefono,motivo,mensaje)
            VALUES(:nombre,:email,:telefono,:motivo,:mensaje);";
            $conexion = MainModel::conectar();
            $stm = $conexion->prepare($sql);
            $stm->bindParam(':nombre', $data['nombre']);
            $stm->bindParam(':email', $data['email']);
            $stm->bindParam(':telefono', $data['telefono']);
            $stm->bindParam(':motivo', $data['motivo']);
            $stm->bindParam(':mensaje', $data['mensaje']);


            if ($stm->execute()) {
                $response =  [
                    'status' => 'success',
                    'message' => 'Mensage guardado exitosamente',
                    'data' => [
                        'id' => $conexion->lastInsertId(),
                    ],
                    'error' => null
                ];
            } else {

                $response =  [
                    'status' => 'error',
                    'message' => 'No fue posible guardar el mensaje(1)',
                    'data' => null,
                    'error' => $stm->errorInfo()
                ];
            }

            return $response;
        } catch (PDOException $e) {
            $response =  [
                'status' => 'error',
                'message' => 'No fue posible guardar el mensaje(2)',
                'data' => null,
                'error' => $e->getMessage()
            ];

            return $response;
        }
    }
}
