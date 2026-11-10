<?php

if ($peticion_ajax) {
    require_once('../Models/PedidosModel.php');
} else {
    require_once('./app/Models/PedidosModel.php');
}

class PedidosController extends PedidosModel
{

    public function get_all_pedidos()
    {
        $pedidos = PedidosModel::get_all();
        return $pedidos;
    }



    //get data pedidos(cliente. destinatario , productos)
    public function get_pedido(string $codigo)
    {

        $codigo = MainModel::limpiar_cadena($codigo);
        if ($codigo === '') {
            $response = [
                "status" => false,
                "message" => "El codigo es incorrecto"
            ];

            return $response;
        }
        //Evaluamos si el pedido existe:
        $sql = "SELECT codigo FROM pedidos WHERE codigo = '$codigo' LIMIT 1;";

        $pedido_existe = MainModel::ejecutar_consulta_simple($sql);

        if ($pedido_existe->rowCount() == 0) {
            $response = ["status" => false, "message" => "El pedido asociado a este codigo no existe"];
            return $response;
        }

        //Pasada las validaciones, solicitamos los datos

        $data_pedido = PedidosModel::get_data_pedido($codigo);
        $response = [
            "status" => true,
            "message" => "Los datos del pedido estan disponibles",
            "info_pedido"=>$data_pedido['info_pedido'],
            "cliente" => $data_pedido['cliente'],
            "destinatario" => $data_pedido['destinatario'],
            "productos" => $data_pedido['productos']
        ];
        return $response;
    }




    public function get_numero_pedidos_7_last_days()
    {
        $numero = PedidosModel::get_numero_pedidos_ultimos_7_dias();
        return $numero;
    }

    public function get_numero_pedidos()
    {
        $numero = PedidosModel::get_num_pedidos();
        return $numero;
    }


    public function pedidos_por_dia()
    {
        $numero = PedidosModel::get_pedidos_por_dia();
        return $numero;
    }
}
