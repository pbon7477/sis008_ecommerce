<?php

require_once('MainModel.php');

class PedidosModel extends MainModel
{

    public static function cantidad_pedidos_actuales()
    {
        $sql = "SELECT COUNT(*) from pedidos";
        $cantidad = MainModel::ejecutar_consulta_simple($sql);
        return $cantidad->fetchColumn();
    }



    public static function create(array $data_pedido)
    {


        try {

            $sql = "INSERT INTO pedidos(id_cliente,id_destinatario,codigo,estado)
                    VALUES(:id_cliente, :id_destinatario, :codigo, :estado)";

            $conexion = MainModel::conectar();
            $sentencia = $conexion->prepare($sql);
            $sentencia->bindParam(":id_cliente", $data_pedido['id_cliente']);
            $sentencia->bindParam(":id_destinatario", $data_pedido['id_destinatario']);
            $sentencia->bindParam(":codigo", $data_pedido['codigo']);
            $sentencia->bindParam(":estado", $data_pedido['estado']);
            $sentencia->execute();

            $rowCount = $sentencia->rowCount();
            $lastId = $conexion->lastInsertId();

            return [
                'status' => true,
                'rowCount' => $rowCount,
                'id_pedido' => $lastId,
            ];
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1062) {
                return [
                    "status" => false,
                    "error" => "duplicado",
                    "message" => "El codigo de producto:" . $data_pedido['codigo'] . "ya existe"
                ];
            }

            return ["status" => false, "error" => "general", "message" => $e->getMessage(), "linea" => $e->getLine()];
        }
    }





    public static function get_all(int $id_cliente) {


        try {

            $sql = "SELECT * FROM pedidos WHERE id_cliente = :id_cliente;";

            $conexion = MainModel::conectar();
            $cursor = $conexion->prepare($sql);
            $cursor->bindParam(':id_cliente', $id_cliente);
            $cursor->execute();
            $pedidos = $cursor->fetchAll(PDO::FETCH_ASSOC);

            $response = $pedidos;
            
        } catch (Exception $e) {
            $response = $e->getMessage();
        }

        return $response;
    }





    public static function get_pedido_detalle_cliente_y_destinatario($id_pedido, $id_cliente){
        $sql = "SELECT 
                p.fecha as pedido_fecha,
                p.codigo as pedido_codigo,
                p.estado as pedido_estado,
                cli.nombre as cliente_nombre,
                cli.email as cliente_email,
                cli.direccion as cliente_direccion,
                cli.telefono as cliente_telefono,
                des.nombre as destinatario_nombre,
                des.email as destinatario_email,
                des.direccion as destinatario_direccion,
                des.telefono as destinatario_telefono

                 FROM pedidos as p

                 INNER JOIN clientes as cli
                 ON cli.id = p.id_cliente

                 INNER JOIN destinatarios as des 
                 ON des.id = p.id_destinatario 

                 WHERE p.id = :id_pedido AND p.id_cliente = :id_cliente;";

        $conexion = MainModel::conectar();
        $pointer = $conexion->prepare($sql);
        $pointer->bindParam(':id_pedido', $id_pedido);
        $pointer->bindParam(':id_cliente',$id_cliente);   
        $pointer->execute();
        $data = $pointer->fetchAll(PDO::FETCH_ASSOC);
        
        return $data;

        
    }


    public static function get_pedido_detalle_productos($id_pedido, $id_cliente){


        $sql = "SELECT 
                pr.nombre as producto_nombre,
                pr.precio_venta as producto_precio_venta,
                det.cantidad as det_ped_cantidad,
                det.precio_total as det_ped_precio_total
                 
                FROM pedidos as pe

                INNER JOIN detalle_pedidos as det
                ON det.id_pedido = :id_pedido

                INNER JOIN productos as pr
                ON pr.id = det.id_producto

                WHERE pe.id = :id_pedido AND pe.id_cliente = :id_cliente";

        $conexion = MainModel::conectar();
        $pointer = $conexion->prepare($sql);
        $pointer->bindParam(':id_pedido',$id_pedido);
        $pointer->bindParam(':id_cliente', $id_cliente);
        $pointer->execute();
        $productos = $pointer->fetchAll(PDO::FETCH_ASSOC);
        
        return $productos;


    }



    public static function get_cliente( string $id_cliente){
        $sql = "SELECT 
                nombre as cli_nombre,
                email as cli_email,
                direccion as cli_direccion,
                telefono as cli_telefono
                FROM clientes WHERE id=:id_cliente;";
        $conexion = MainModel::conectar();
        $pointer = $conexion->prepare($sql);
        $pointer->bindParam(':id_cliente',$id_cliente);
        $pointer->execute();
        $cliente = $pointer->fetch(PDO::FETCH_ASSOC);
        return $cliente;

    }


    public static function get_destinatario(string $codigo_pedido){
        $sql = "SELECT 
                des.nombre as des_nombre,
                des.email as des_email,
                des.direccion as des_direccion,
                des.telefono as des_telefono
               FROM pedidos as p
               
               INNER JOIN destinatarios as des
               ON des.id = p.id_destinatario
               WHERE p.codigo = :codigo_pedido;";
        
        $conexion=MainModel::conectar();
        $pointer=$conexion->prepare($sql);
        $pointer->bindParam(':codigo_pedido',$codigo_pedido);
        $pointer->execute();
        $destinatario = $pointer->fetch(PDO::FETCH_ASSOC);
        return $destinatario;

    }

    public static function get_datos_pedido(string $codigo_pedido){
        $sql = "SELECT fecha, codigo, estado FROM pedidos WHERE codigo=:codigo_pedido";
        $conexion = MainModel::conectar();
        $pointer=$conexion->prepare($sql);
        $pointer->bindParam(':codigo_pedido',$codigo_pedido);
        $pointer->execute();
        $datos_pedido = $pointer->fetch(PDO::FETCH_ASSOC);
        return $datos_pedido;
    }

    public static function get_pedido_precio_total(string $codigo_pedido){
        $sql = "SELECT SUM( det.precio_total) as det_precio_total
                FROM pedidos as ped
                INNER JOIN detalle_pedidos as det
                ON det.id_pedido = ped.id
                WHERE ped.codigo = :codigo_pedido;";

        $conexion= MainModel::conectar();
        $pointer=$conexion->prepare($sql);
        $pointer->bindParam(':codigo_pedido', $codigo_pedido);
        $pointer->execute();
        $resultado = $pointer->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;       
    }



    public static function get_productos($codigo_pedido){
        $sql="SELECT
              pr.nombre,
              det.cantidad,
              det.precio_venta,
              det.precio_total   

            FROM pedidos as ped
            
            INNER JOIN detalle_pedidos as det
            ON det.id_pedido = ped.id

            INNER JOIN productos as pr
            ON pr.id = det.id_producto

            WHERE ped.codigo = :codigo_pedido;";

        $conexion = MainModel::conectar();
        $pointer=$conexion->prepare($sql);
        $pointer->bindParam(':codigo_pedido',$codigo_pedido);
        $pointer->execute();
        $productos = $pointer->fetchAll(PDO::FETCH_ASSOC);
        return $productos;


    }
}
