<?php

class CarritoController
{

    public function agregar_producto(array $data)
    {

        //Si no se ha creado la session 'carrito':
        if (!isset($_SESSION['carrito'])) {

            $producto = [
                'id' => $data['id'],
                'nombre' => $data['nombre'],
                'imagen' => $data['imagen'],
                'cantidad' => $data['cantidad'],
                'precio_venta' => $data['precio_venta']
            ];

            $_SESSION['carrito'][0] = $producto;

            $response = [
                'status' => 'success',
                'message' => 'Producto agregado al carrito',
                'carrito' => $_SESSION['carrito']
            ];
        } else {
            //Si ya se  ha creado la session 'carrito':
            //Buscamos que el id del producto entrante no exista

            $ids_productos = array_column($_SESSION['carrito'], 'id');

            if (in_array($data['id'], $ids_productos)) {
                $response = [
                    'status' => 'error',
                    'message' => 'El producto ya existe en el carrito'
                ];
            } else {
                //Si no existe, lo agrega

                $numero_productos = count($_SESSION['carrito']);
                $producto = [
                    'id' => $data['id'],
                    'nombre' => $data['nombre'],
                    'imagen' => $data['imagen'],
                    'cantidad' => $data['cantidad'],
                    'precio_venta' => $data['precio_venta']
                ];
                $_SESSION['carrito'][$numero_productos] = $producto;

                $response = [
                    'status' => 'success',
                    'message' => 'Producto agregado al carrito',
                    'carrito' => $_SESSION['carrito']
                ];
            }
        }

        return $response;
    }

    public function leer_carrito()
    {
        return $_SESSION['carrito'] ?? '';
    }


    public function modificar_cantidad(array $data)
    {

        foreach ($_SESSION['carrito'] as $index => $producto) {

            if ($producto['id'] == $data['id']) {

                if ($data['action'] == 'mas') {

                    if ($_SESSION['carrito'][$index]['cantidad'] >= 1) {
                        $_SESSION['carrito'][$index]['cantidad']++;
                    }
                } else {

                    if ($_SESSION['carrito'][$index]['cantidad'] > 1) {
                        $_SESSION['carrito'][$index]['cantidad']--;
                    }
                }
            }
        }
        return $_SESSION['carrito'];
    }


    public function borrar_producto(string $id)
    {

        $response = [];

        foreach ($_SESSION['carrito'] as $index => $producto) {

            if ($producto['id'] === $id) {
                unset($_SESSION['carrito'][$index]);
                $_SESSION['carrito'] = array_values($_SESSION['carrito']);
                $response = ['status' => 'success', 'message' => 'El producto ha sido borrado del carrito', 'carrito' => $_SESSION['carrito']];
                break;
            } else {
                $response = ['status' => 'error', 'message' => 'El producto no existe en el carrito', 'producto' => $producto];
            }
        }


        return $response;
    }




    public function vaciar_carrito()
    {
        $_SESSION['carrito'] = [];
        $response = ['status' => 'success', 'message' => 'El carrito ha sido vaciado'];
        return $response;
    }


    public function check_carrito(){
        $response = [];
        if(empty($_SESSION['carrito'])){
             $response = ['status'=>'success','message'=>'El carrito esta vacio', 'empty'=>true];
             }else{
            $response = ['status'=>'success','message'=>'El carrito tienen productos', 'empty'=>false];

        }
        return $response;
    }
}
