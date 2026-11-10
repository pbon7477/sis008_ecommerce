<?php
require('MainModel.php');

class ContactoModel extends MainModel
{

    public static function all()
    {
        $sql = "SELECT * FROM mensajes ORDER BY fecha_creacion DESC;";
        $mensajes = MainModel::ejecutar_consulta_simple($sql);
        return $mensajes;
    }

    public static function get(int $id)
    {

        try {

            $sql = "SELECT * FROM mensajes WHERE id = :id";
            $conexion = MainModel::conectar();
            $stm = $conexion->prepare($sql);
            $stm->bindParam(':id', $id);


            if ($stm->execute()) {

                $response = [
                    'status' => 'success',
                    'message' => 'Mensaje obtenido exitosamente',
                    'data' => $stm->fetch(PDO::FETCH_ASSOC)
                ];
            } else {
                $response = [
                    'status' => 'error',
                    'message' => 'El mensaje no existe en el sistema',
                    'data' => null
                ];
            }
        } catch (Exception $e) {
            $response = [
                'status' => 'error',
                'message' => $e->getMessage(),
                'data' => null,
                'linea' => $e->getLine()
            ];
        }

        return $response;
    }





    public static function set_leido(int $id)
    {
        try {

            $sql = "UPDATE mensajes SET estado = 'leido' WHERE id = :id;";
            $conexion = MainModel::conectar();
            $stm = $conexion->prepare($sql);
            $stm->bindParam(':id', $id);
            $updated = $stm->execute();

            if ($updated) {
                $response = [
                    "status" => "success",
                    "message" => "El estado del mensaje ha sido actualizado a 'leido'"
                ];
            } else {

                $response = [
                    "status" => "error",
                    "message" => "No ha sido posible actualizar el estado del mensaje"
                ];
            }
        } catch (Exception $e) {
            $response = [
                "status" => "error",
                "message" => "No ha sido posible actualizar el estado del mensaje",
                "error" => $e->getMessage(),
                "linea" => $e->getLine()
            ];
        }

        return $response;
    }

    public static function set_no_leido(int $id)
    {
        try {

            $sql = "UPDATE mensajes SET estado = 'nuevo' WHERE id = :id;";
            $conexion = MainModel::conectar();
            $stm = $conexion->prepare($sql);
            $stm->bindParam(':id', $id);
            $updated = $stm->execute();

            if ($updated) {
                $response = [
                    "status" => "success",
                    "message" => "El estado del mensaje ha sido actualizado a 'nuevo'"
                ];
            } else {

                $response = [
                    "status" => "error",
                    "message" => "No ha sido posible actualizar el estado del mensaje"
                ];
            }
        } catch (Exception $e) {
            $response = [
                "status" => "error",
                "message" => "No ha sido posible actualizar el estado del mensaje",
                "error" => $e->getMessage(),
                "linea" => $e->getLine()
            ];
        }

        return $response;
    }


    public static function set_respondido(int $id)
    {
        try {
            $sql = "UPDATE mensajes SET estado = 'respondido' WHERE id = :id";
            $conexion = MainModel::conectar();
            $stm = $conexion->prepare($sql);
            $stm->bindParam(':id', $id);

            if ($stm->execute()) {
                $response = [
                    "status" => "success",
                    "message" => "El estado del mensaje ha sido actualizado a 'respondido'"
                ];
            } else {
                $response = [
                    "status" => "error",
                    "message" => "No ha sido posible actualizar el estado del mensaje"
                ];
            }
        } catch (Exception $e) {
            $response = [
                "status" => "error",
                "message" => "No ha sido posible actualizar el estado del mensaje",
                "error" => $e->getMessage(),
                "linea" => $e->getLine()
            ];
        }

        return $response;
    }


    public static function delete(int $id)
    {

        try {
            $sql = "DELETE FROM mensajes WHERE id = :id";
            $conexion = MainModel::conectar();
            $stm = $conexion->prepare($sql);
            $stm->bindParam(':id', $id);
            $delete = $stm->execute();

            if($delete){
                $response = [
                    "status" => "success",
                    "message" => "El mensaje ha sido eliminado exitosamente"
                ];

            }else{
                $response = [
                    "status" => "error",
                    "message" => "No ha sido posible eliminar el mensaje"
                ];

            }


        } catch (Exception $e) {
            $response = [
                "status" => "error",
                "message" => "No ha sido posible eliminar mensaje",
                "error" => $e->getMessage(),
                "linea" => $e->getLine()
            ];
        }

        return $response;
    }
}
