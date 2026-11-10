<?php

if ($peticion_ajax) {
    require_once('../Models/MainModel.php');
} else {
    require_once('./app/Models/MainModel.php');
}


class PedidosModel extends MainModel{

    public static function get_all(){
        $sql = "SELECT
                ped.id as id,
                cli.nombre as cli_nombre, 
                des.nombre as des_nombre,
                ped.fecha as ped_fecha,
                ped.codigo as ped_codigo,
                ped.estado as ped_estado

                FROM pedidos as ped
                INNER JOIN clientes as cli
                ON cli.id = ped.id_cliente

                INNER JOIN destinatarios as des
                ON des.id = ped.id_destinatario                 
        ";
        $pedidos = MainModel::ejecutar_consulta_simple($sql);
        return $pedidos;
    }




    public static function get_data_pedido(string $codigo){

        


        $info_pedio = self::get_info_pedido($codigo);
        $cliente = self::get_cliente($codigo);
        $destinatario = self::get_destinatario($codigo);
        $productos = self::get_productos($codigo);

        $data_pedido= [ 
            "info_pedido"=>$info_pedio,           
            "cliente"=>$cliente,
            "destinatario"=>$destinatario,
            "productos"=>$productos
        ];

        return $data_pedido;
        
    }


    protected static function get_info_pedido(string $codigo){
        $sql = "SELECT fecha, codigo, estado FROM pedidos WHERE codigo = :codigo;";
        $conexion = MainModel::conectar();
        $pointer = $conexion->prepare($sql);
        $pointer->bindParam(':codigo',$codigo);
        $pointer->execute();
        $info_pedido = $pointer->fetch(PDO::FETCH_ASSOC);
        return $info_pedido;
    }



    protected static function get_cliente(string $codigo){
        $sql = "SELECT 
                    cli.id as cli_id,
                    cli.nombre as cli_nombre,
                    cli.email as cli_email,
                    cli.direccion as cli_direccion,
                    cli.telefono as cli_telefono

                FROM pedidos as ped
                INNER JOIN clientes as cli
                ON cli.id = ped.id_cliente
                WHERE ped.codigo = :codigo
        ";

        $conexion = MainModel::conectar();
        $pointer = $conexion->prepare($sql);
        $pointer->bindParam(':codigo',$codigo);
        $pointer->execute();
        $cliente = $pointer->fetch(PDO::FETCH_ASSOC);
        return $cliente;
    }

    protected static function get_destinatario(string $codigo){
        $sql="SELECT 
              des.id as des_id,  
              des.nombre as des_nombre,
              des.email as des_email,
              des.direccion as des_direccion,
              des.telefono as des_telefono

              FROM pedidos as ped
              INNER JOIN destinatarios as des
              ON des.id = ped.id_destinatario
              WHERE ped.codigo = :codigo  
        ";

        $conexion = MainModel::conectar();
        $pointer = $conexion->prepare($sql);
        $pointer->bindParam(':codigo', $codigo);
        $pointer->execute();
        $destinatario = $pointer->fetch(PDO::FETCH_ASSOC);

        return $destinatario;
    }


    protected static function get_productos(string $codigo){

    $sql = "SELECT 

            pr.id as pr_id,
            pr.nombre as pr_nombre,
            pr.codigo as pr_codigo,
            detp.cantidad as detp_cantidad,
            detp.precio_venta as detp_precio_venta,
            detp.precio_total as detp_precio_total

            FROM pedidos as ped
            INNER JOIN detalle_pedidos as detp
            ON detp.id_pedido = ped.id

            INNER JOIN productos as pr
            ON pr.id = detp.id_producto

            WHERE ped.codigo = :codigo; ";


        $conexion = MainModel::conectar();
        $pointer = $conexion->prepare($sql); 
        $pointer->bindParam(':codigo',$codigo);
        $pointer->execute();
        
        $productos = $pointer->fetchAll(PDO::FETCH_ASSOC);
        return $productos; 
 
    }



    public static function get_numero_pedidos_ultimos_7_dias()    {
        $sql = "SELECT COUNT(id) as num FROM pedidos
    WHERE fecha BETWEEN DATE( DATE_SUB( NOW(), INTERVAL 7 DAY )) AND NOW();";

        $resultado = MainModel::ejecutar_consulta_simple($sql);
        $numero = $resultado->fetch(PDO::FETCH_ASSOC);
        return $numero['num'];
    }


    public static function get_num_pedidos(){
        $sql = "SELECT COUNT(id) as num FROM pedidos";
        $resultado = MainModel::ejecutar_consulta_simple($sql);
        $numero = $resultado->fetch(PDO::FETCH_ASSOC);
        return $numero['num']; 
    }



    public static function get_pedidos_por_dia(){
        $sql = "SELECT 
                COUNT(ped.codigo) as total_pedidos,
                ped.fecha as fecha
                FROM pedidos as ped
                INNER JOIN detalle_pedidos as det_ped
                ON det_ped.id_pedido = ped.id
                GROUP BY DAY(ped.fecha);";

        $sql = "SELECT 
                COUNT(ped.id) as total_pedidos,
                ped.fecha as fecha
                FROM pedidos as ped
                GROUP BY DAY(ped.fecha)
                ORDER BY ped.fecha
                ";


                
        $resultado = MainModel::ejecutar_consulta_simple($sql);
        $numero = $resultado->fetchAll(PDO::FETCH_ASSOC);
        return $numero;        
    }
}
