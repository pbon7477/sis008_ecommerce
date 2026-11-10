<?php

class CarritoController
{

    public function agregar_producto(array $data)
    {


        if (!isset($_SESSION['carrito'])) {

            $producto = [
                'id' => $data['id'],
                'nombre' => $data['nombre'],
                'imagen' => $data['imagen'],
                'cantidad' => $data['cantidad'],
                'precio_venta' => $data['precio_venta']
            ];

            $_SESSION['carrito'][0] = $producto;

        } else {
            $numero_productos = count($_SESSION['carrito']);
            $producto = [
                'id' => $data['id'],
                'nombre' => $data['nombre'],
                'imagen' => $data['imagen'],
                'cantidad' => $data['cantidad']
            ];
            $_SESSION['carrito'][$numero_productos] = $producto;
        }

        $response = [
            'status' => 'success',
            'message' => 'Producto agregado al carrito',
            'carrito'=>$_SESSION['carrito']
        ];

        return $response;
    }
}
