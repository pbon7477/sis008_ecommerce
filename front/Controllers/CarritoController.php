<?php

require_once(__DIR__ . '/../Models/CarritoModel.php');

class CarritoController extends CarritoModel
{

    public function agregar_producto(array $form_data)
    {

        $response = [];

        //Recibimos solo el 'id' y 'cantidad'
        $id = MainModel::limpiar_cadena($form_data['id']);
        $cantidad = MainModel::limpiar_cadena($form_data['cantidad']);

        //Pedir los datos del producto a la BBDD
        $res = CarritoModel::get_producto($id);


        if ($res['status'] == 'error') {
            $response = [
                'status' => 'error',
                'message' => $res['message'],
                'error' => $res['error']
            ];

            return $response;
        } else {



            $data = $res['producto'];




            //Si no se ha creado la session 'carrito':
            if (!isset($_SESSION['carrito'])) {

                $producto = [
                    'id' => $data['id'],
                    'nombre' => $data['nombre'],
                    'imagen' => $data['imagen'],
                    'cantidad' => $cantidad,
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
                        'cantidad' => $cantidad,
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


        $id = MainModel::limpiar_cadena($id);
        $id = (int) $id;

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


    public function check_carrito()
    {
        $response = [];
        if (empty($_SESSION['carrito'])) {
            $response = ['status' => 'success', 'message' => 'El carrito esta vacio', 'empty' => true];
        } else {
            $response = ['status' => 'success', 'message' => 'El carrito tienen productos', 'empty' => false];
        }
        return $response;
    }





    public function check_in_carrito(int $id)
    {

        $id = MainModel::limpiar_cadena($id);

        $response = [];

        if (!is_numeric($id) && $id < 0) {
            $response = ['status' => 'error', 'message' => 'El id recibido no es un numero'];
        }  
        
        if(isset($_SESSION['carrito'])){


            foreach ($_SESSION['carrito'] as $producto) {

                if ( $producto['id'] == $id) {
                    $response = ['status' => 'success', 'message' => 'El producto ya fue agregado al carrito', 'existe' => true, 'cantidad'=>$producto['cantidad']];
                    break;
                } else {
                    $response = ['status' => 'success', 'message' => 'El producto no ha sido agregado al carrito', 'existe' => false];
                }
            }
        }else{
            $response = ['status'=>'success','message'=>'Aun no se han ingresado productos al carrito'];
        }

        return $response;
    }




    public function actualizar_cantidad( array $data){
        $id = MainModel::limpiar_cadena($data['id']);
        $cantidad = MainModel::limpiar_cadena($data['nueva_cantidad']);

        $response = ['status'=>'error'];

        if( !is_numeric($id) || $id <= 0 ){
            $response = ['status'=>'error', 'message'=>'El ID no corresponde'];            
        }
            
        if( !is_numeric($cantidad) || $cantidad <= 0  ){
            $response = ['status'=>'error', 'message'=>'La cantidad no corresponde'];
        }
            
            foreach($_SESSION['carrito'] as $index=>$producto){
                
                if($producto['id'] == $id){
                    $_SESSION['carrito'][$index]['cantidad'] = $cantidad;
                    $response = [
                        'status'=>'success',
                        'message'=> 'La cantidad del producto '. $producto["nombre"] . ' ha sido actualizada a '. $cantidad .''
                         ];
        

                break;
            }else{
                $response = ['status'=>'error','No ha sido posible actualizar la cantidad'];
            }
        }


        return $response;





    }
}
