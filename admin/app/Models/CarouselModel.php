<?php

if ($peticion_ajax) {
    require_once('../Models/MainModel.php');
} else {
    require_once('./app/Models/MainModel.php');
}



class CarouselModel extends MainModel
{


    public static function all()
    {
        $sql = "SELECT id,nombre_producto,descripcion,imagen,precio_venta,categoria 
                FROM carousel 
                ORDER BY id DESC;";

        $items = MainModel::ejecutar_consulta_simple($sql);
        $items = $items->fetchAll(PDO::FETCH_ASSOC);
        return $items;
    }




    public static function get(int $id){
        try {
            $sql = "SELECT id, id_producto ,nombre_producto,descripcion,imagen,precio_venta,categoria 
                    FROM carousel WHERE id = :id;";
            $conexion = MainModel::conectar();
            $stm = $conexion->prepare($sql);
            $stm->bindParam(':id', $id);
            $stm->execute();
            $item = $stm->fetch(PDO::FETCH_ASSOC);

            $response = [
                "status" => "success",
                "item" => $item
            ];
        } catch (Exception $e) {
            $response = [
                "status" => "error",
                "message" => $e->getMessage(),
                "linea" => $e->getLine()
            ];
        }

        return $response;
    }

    public static function save(array $producto)
    {

        try {

            $sql = "INSERT INTO carousel (id_producto,nombre_producto,descripcion,imagen,precio_venta,categoria)
        VALUES(:id_producto,:nombre_producto,:descripcion,:imagen,:precio_venta,:categoria)";

            $conexion = MainModel::conectar();
            $stm = $conexion->prepare($sql);
            $stm->bindParam(':id_producto', $producto['id_producto']);
            $stm->bindParam(':nombre_producto', $producto['nombre_producto']);
            $stm->bindParam(':descripcion', $producto['descripcion']);
            $stm->bindParam(':imagen', $producto['imagen']);
            $stm->bindParam(':precio_venta', $producto['precio_venta']);
            $stm->bindParam(':categoria', $producto['categoria']);
            $stm->execute();

            if ($stm->rowCount() > 0) {

                $response = [
                    "status" => "success",
                    "message" => "El nuevo item ha sido registrado exitosamente",
                    "id" => $conexion->lastInsertId()
                ];
            } else {
                $response = [
                    'status' => 'error',
                    'message' => 'No se inserto ningun registro',

                ];
            }
        } catch (Exception $e) {
            $response = [
                "status" => "error",
                "message" => "Ocurrió un error inesperado",
                "error" => $e->getMessage(),
                "Linea" => $e->getLine()
            ];
        }

        return $response;
    }



    public static function update(array $item)
    {

        try {
            $sql = "UPDATE carousel SET descripcion = :descripcion WHERE id = :id";
            $conexion = MainModel::conectar();
            $stm = $conexion->prepare($sql);
            $stm->bindParam(':descripcion', $item['descripcion']);
            $stm->bindParam(':id', $item['id']);
            $stm->execute();

            $response = [
                'status' => 'success',
                'message' => 'El ítem ha sido actualizado exitosamente',
                'stm' => $stm
            ];
        } catch (Exception $e) {
            $response = [
                "status" => "error",
                "message" => "Ocurrió un error inesperado",
                "error" => $e->getMessage(),
                "Linea" => $e->getLine()
            ];
        }

        return $response;
    }



    public static function delete(int $id)
    {
        try {
            $sql = "DELETE FROM carousel WHERE id = :id";
            $conexion = MainModel::conectar();
            $stm = $conexion->prepare($sql);
            $stm->bindParam(':id', $id);
            $stm->execute();

            $response = [
                "status" => "success",
                'message' => 'El item ha sido eliminado exitosamente',
            ];
        } catch (Exception $e) {
            $response = [
                "status" => "error",
                "message" => "Ocurrió un error inesperado",
                "error" => $e->getMessage(),
                "Linea" => $e->getLine()
            ];
        }

        return $response;
    }
}
