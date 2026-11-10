<?php
if ($peticion_ajax) {
    require_once('../Models/PedidosModel.php');
} else {
    require_once('./front/Models/PedidosModel.php');
}

class PedidosController extends PedidosModel
{


    public function create_pedido(array $datos_cliente, array $datos_destinatario, array $productos)
    {

        $id_cliente = MainModel::limpiar_cadena($datos_cliente['id']);
        $id_destinatario = MainModel::limpiar_cadena($datos_destinatario['id']);
        $codigo_pedido = self::codigo_pedido();

        if ($id_cliente == '' || $id_destinatario == '') {
            $response = [
                "status" => false,
                "message" => "Debe enviar todos los datos del cliente y destinatario"
            ];

            return json_encode($response);
        }

        //Verificamos que el codigo no exista:
        $codigo_existe = MainModel::ejecutar_consulta_simple("SELECT * FROM pedidos WHERE codigo ='" . $codigo_pedido . "';");
        if ($codigo_existe->rowCount() > 0) {
            $response = [
                "status" => false,
                "message" => "El codigo ya existe, no es poscible realizar la insercion del pedido"
            ];

            return json_encode($response);
            exit;
        }





        $datos_pedido = [
            "id_cliente" => $id_cliente,
            "id_destinatario" => $id_destinatario,
            "codigo" => $codigo_pedido,
            "estado" => 'pendiente'
        ];


        $guardar_pedido = PedidosModel::create($datos_pedido);


        //GUARDAR DETALLE DE PEDIDO
        //ID debuelto por la consulta insert recien realizada
        $id_pedido = $guardar_pedido['id_pedido'];

        $guardar_detalles = self::guardar_detalle_pedido($id_pedido, $productos);




        if ($guardar_pedido['rowCount'] > 0 && $guardar_detalles['status']) {

            $_SESSION['id_pedido'] = $id_pedido;


            $response = [
                "status" => true,
                "message" => "El pedido ha sido registrado exitosamente.",
                "codigo_pedido" => $codigo_pedido
            ];
        } else {
            $response = [
                "status" => false,
                "message" => "No ha sido poscible registrar el pedido. Intentelo mas tarde."
            ];
        }

        return $response;
    }







    public static function guardar_detalle_pedido(int $id_pedido, array $productos)
    {

        $cantidad_productos = count($productos);
        $insertaDetalle = '';
        $sub_total = 0;

        for ($i = 0; $i < $cantidad_productos; $i++) {
            $sub_total = $productos[$i]['precio_venta'] * $productos[$i]['cantidad'];
            $insertaDetalle = $insertaDetalle . "('" . $id_pedido . "','" . $productos[$i]['id'] . "','" . $productos[$i]['cantidad'] . "','" . $productos[$i]['precio_venta'] . "','" . $sub_total . "'),";
        }

        $insertaDetalle = rtrim($insertaDetalle, ',');



        $sql = "INSERT INTO detalle_pedidos(id_pedido,id_producto,cantidad,precio_venta,precio_total)
                VALUES " . $insertaDetalle . ";";

        $detalle_pedidos_save = PedidosModel::ejecutar_consulta_simple($sql);


        if ($detalle_pedidos_save->rowCount() > 0) {

            $response = [
                "status" => true,
                "message" => "Se han guardado los Detalles de productos exitosamente"
            ];
        } else {

            $response = [
                "status" => false,
                "message" => "No ha sido poscible guardar los Detalles de productos en la base de datos."
            ];
        }

        return $response;
    }







    public function cantidad_actual()
    {
        $numero_pedidos = PedidosModel::cantidad_pedidos_actuales();
        return $numero_pedidos;
    }



    public function codigo_pedido()
    {
        $contador_de_pedidos = self::cantidad_actual();

        $codigo =  "COD-P-" . self::ceros($contador_de_pedidos + 1);

        return $codigo;
    }



    public function ceros(int $numero)
    {

        $length = 0;
        $cantidad_ceros = 5;
        $aux = $numero;
        $largo_numero = strlen($numero);
        $length = $cantidad_ceros - $largo_numero;

        for ($i = 0; $i < $length; $i++) {
            $aux = '0' . $aux;
        }

        return $aux;
    }







    public function verificar_pedido_existente(string $codigo)
    {

        $sql = "SELECT id FROM pedidos WHERE codigo = '$codigo'";
        $existe = MainModel::ejecutar_consulta_simple($sql);



        if ($existe->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }



    public function get_resumen_pedido(string $codigo)
    {
        session_start();
        // $sql = "SELECT * FROM pedidos WHERE codigo = '".$codigo."';";
        $sql = "SELECT 
                   p.id as id_pedido,
                   p.codigo,
                   p.fecha,
                   p.estado,
                   c.nombre as nombre_cliente,
                   c.email as email_cliente,
                   c.direccion as direccion_cliente,
                   c.telefono as telefono_cliente,
                   d.nombre as nombre_destinatario,
                   d.direccion as direccion_destinatario,
                   d.email as email_destinatario,
                   d.telefono as telefono_destinatario
                   FROM pedidos as p
                   INNER JOIN clientes as c ON p.id_cliente = c.id
                   INNER JOIN destinatarios as d on p.id_destinatario = d.id
                   WHERE codigo = '" . $codigo . "';";



        $row_data = MainModel::ejecutar_consulta_simple($sql);
        $row_data_pedido = $row_data->fetch(PDO::FETCH_ASSOC);




        $response = [
            "status" => true,
            "codigo_recibido" => $codigo,
            "id_pedido" => $_SESSION['id_pedido'],
            "row_data" => $row_data_pedido

        ];

        return json_encode($response);
    }




    



    public function all(int $id_cliente){            

            $pedidos = PedidosModel::get_all($id_cliente);
            
            return $pedidos;
    }



    public function get_pedido_detalle($id_pedido, $id_cliente){
            
            $cliente_y_destinatario = PedidosModel::get_pedido_detalle_cliente_y_destinatario($id_pedido, $id_cliente);
            $productos = PedidosModel::get_pedido_detalle_productos($id_pedido, $id_cliente);


            
            $data= [
                'cliente_y_destinatario'=>$cliente_y_destinatario,
                'productos'=>$productos
            ];

            return $data;
            
    }


    public function get_pedido_enviado(string $codigo_pedido, string $id_cliente){

    $cliente = PedidosModel::get_cliente($id_cliente);
    $destinatario = PedidosModel::get_destinatario($codigo_pedido);
    $datos_pedido = PedidosModel::get_datos_pedido($codigo_pedido);
    $productos = PedidosModel::get_productos($codigo_pedido);
    $precio_total = PedidosModel::get_pedido_precio_total($codigo_pedido);

    $response = [
        'cliente'=> $cliente,
        'destinatario'=>$destinatario,
        'datos_pedido'=>$datos_pedido,
        'productos'=>$productos,
        'precio_total'=>$precio_total[0]
        ];
    return $response;       

    }
}
