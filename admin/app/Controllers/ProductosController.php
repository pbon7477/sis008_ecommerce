<?php 

if( $peticion_ajax ){
    require_once('../Models/ProductosModel.php');
}else{
    require_once('./app/Models/ProductosModel.php');
}

class ProductosController extends ProductosModel {

    public function all_productos(){
        $productos = ProductosModel::all();
        $productos = $productos->fetchAll(PDO::FETCH_ASSOC);
        return $productos; 
    }

    
    
    public function getProducto(){
        $url = explode('/',$_GET['view']);
        $id = $url[1];

        $producto = ProductosModel::find($id);
        $producto = $producto->fetch(PDO::FETCH_ASSOC);
        return $producto;

        
    }


    public function get_producto(int $id){
        
        $producto = ProductosModel::get_one($id);
        $producto = $producto->fetch(PDO::FETCH_ASSOC);
        return $producto;

        
    }


    public function create_producto(){
            
        $nombre = MainModel::limpiar_cadena($_POST['nombre']);
       
        $categoria_id = MainModel::limpiar_cadena($_POST['categoria_id']);

        $descripcion = MainModel::limpiar_cadena($_POST['descripcion']);
        $codigo = MainModel::limpiar_cadena($_POST['codigo']);

        $fecha_ingreso = MainModel::limpiar_cadena($_POST['fecha_ingreso']);

        $usuario_id = MainModel::limpiar_cadena($_POST['usuario_id']);

        $precio_compra = MainModel::limpiar_cadena($_POST['precio_compra']);
        $precio_compra = MainModel::limpiar_numero($precio_compra);

        $precio_venta = MainModel::limpiar_cadena($_POST['precio_venta']);
        $precio_venta = MainModel::limpiar_numero($precio_venta);

        $stock = MainModel::limpiar_cadena($_POST['stock']);
        $stock = MainModel::limpiar_numero($stock);
        
        $stock_minimo = MainModel::limpiar_cadena($_POST['stock_minimo']);
        $stock_minimo = MainModel::limpiar_numero($stock_minimo);

        $stock_maximo = MainModel::limpiar_cadena($_POST['stock_maximo']);
        $stock_maximo = MainModel::limpiar_numero($stock_maximo);



        if( $nombre == '' || $categoria_id == '' || $descripcion == '' || $codigo == '' || $fecha_ingreso == '' ||
            $precio_compra == '' || $precio_venta == '' ||
            $stock  == '' || $stock_minimo == '' || $stock_maximo == '' ){
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado.",
                "Texto" => "Debe llenar todos los campos.",
                "Tipo" => "error"
            ];

            return json_encode($alerta);
        }



        if (MainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ\d. '\-\" ]{0,150}", $nombre)) {
            $alerta = [
                'Alerta' => 'simple',
                'Titulo' => 'Ocurrió un error inesperado.',
                'Texto' => 'El <b>Nombre</b> no coincide con el formato solicitado.',
                'Tipo' => 'error'
            ];
            return json_encode($alerta);
            
        }


        //VERIFICAR QUE EXISTA LA CATEGORIA
        $sql = "SELECT * FROM categorias WHERE id = '" . $categoria_id . "';";
        $check_categoria = MainModel::ejecutar_consulta_simple($sql);
        

        if( $check_categoria->rowCount() <= 0 ){
            $alerta = [
                'Alerta' => 'simple',
                'Titulo' => 'Ocurrió un error inesperado.',
                'Texto' => 'La <b>Categoría</b> no existe en el sistema.',
                'Tipo' => 'error'
            ];
            return json_encode($alerta);

        }else{
            $check_categoria = $check_categoria->fetch(PDO::FETCH_ASSOC);
            $categoria_id = $check_categoria['id'];            
        }


        //VERIFICAMOS LA DESCRIPCION
        if( MainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ\d.\,\ '\-\" ]{0,250}", $descripcion) ){
            $alerta = [
                'Alerta' => 'simple',
                'Titulo' => 'Ocurrió un error inesperado.',
                'Texto' => 'La <b>Descripción </b> no coincide con el formato solicitado.',
                'Tipo' => 'error'
            ];
            return json_encode($alerta);
        }
        
        //
        //VERIFICAMOS EL CODIGO
        //--
        
        //VERIFICAMOS LA FECHA Y HORA DE REGISTRO
        
        $date_time = DateTime::createFromFormat('Y-m-d\TH:i', $fecha_ingreso);
        if(!$date_time || $date_time->format('Y-m-d\TH:i') !== $fecha_ingreso){
            $alerta = [
                'Alerta' => 'simple',
                'Titulo' => 'Ocurrió un error inesperado.',
                'Texto' => 'La <b>Fecha de ingreso </b> no coincide con el formato solicitado.',
                'Tipo' => 'error'
            ];
            return json_encode($alerta);
            

        }

        
        if( MainModel::verificar_datos('[1-9][0-9]{0,7}', $precio_compra) ){
            $alerta = [
                'Alerta' => 'simple',
                'Titulo' => 'Ocurrió un error inesperado.',
                'Texto' => 'El <b>Precio de compra</b> no coincide con el formato solicitado.',
                'Tipo' => 'error'
            ];
            return json_encode($alerta);
            
        }
        
        if( MainModel::verificar_datos('[1-9][0-9]{0,7}', $precio_venta) ){
            $alerta = [
                'Alerta' => 'simple',
                'Titulo' => 'Ocurrió un error inesperado.',
                'Texto' => 'El <b>Precio de venta</b> no coincide con el formato solicitado.',
                'Tipo' => 'error'
            ];
            return json_encode($alerta);
            
        }




        if( MainModel::verificar_datos('^[0-9]+$', $stock) ){
            $alerta = [
                'Alerta' => 'simple',
                'Titulo' => 'Ocurrió un error inesperado.',
                'Texto' => 'El <b>stock</b> no coincide con el formato solicitado.',
                'Tipo' => 'error'
            ];

        return json_encode($alerta);
            
        }
        
        if( MainModel::verificar_datos('^[0-9]+$', $stock_minimo) ){
            $alerta = [
                'Alerta' => 'simple',
                'Titulo' => 'Ocurrió un error inesperado.',
                'Texto' => 'El <b>Stock mínimo</b> no coincide con el formato solicitado.',
                'Tipo' => 'error'
            ];

        return json_encode($alerta);
            
        }

        if( MainModel::verificar_datos('^[0-9]+$', $stock_maximo) ){
            $alerta = [
                'Alerta' => 'simple',
                'Titulo' => 'Ocurrió un error inesperado.',
                'Texto' => 'El <b>Stock máximo</b> no coincide con el formato solicitado.',
                'Tipo' => 'error'
            ];

        return json_encode($alerta);
            
        }


        # IMAGEN ( Procesar y subir ) #
        //creamos el nombre del Directorio de imagenes
        $images_dir = '../Views/assets/images_productos/';



        //Verificamos si se ha seleccionado una imagen
        if ($_FILES['imagen']['name'] != '' && $_FILES['imagen']['size'] > 0) {

            # Creando directorio

            //Si el directorio NO existe?
            if (!file_exists($images_dir)) {

                //...y si no se ha podido crear el directorio?
                if (!mkdir($images_dir, 0777)) {
                    $alerta = [
                        'tipo' => 'simple',
                        'titulo' => 'Ocurrió un error inesperado',
                        'texto' => 'Error al crear el directorio.',
                        'icono' => 'error'
                    ];

                    return json_encode($alerta);
                    
                }
            }

            # Verificando formato de imagen( .jpg, .jpeg y .png)
            if (
                mime_content_type($_FILES['imagen']['tmp_name']) != 'image/jpg'  &&
                mime_content_type($_FILES['imagen']['tmp_name']) != 'image/jpeg'  &&
                mime_content_type($_FILES['imagen']['tmp_name']) != 'image/png' &&
                mime_content_type($_FILES['imagen']['tmp_name']) != 'image/gif'
            ) {



                


                

                $alerta = [
                    'Alerta' => 'simple',
                    'Titulo' => 'Ocurrió un error inesperado',
                    'Texto' => 'La imagen que ha seleccionado es de un formato no permitido.',
                    'Tipo' => 'error'
                ];

                return json_encode($alerta);
                
            }


            # Verificando peso de la imagen (5MB)
            if (($_FILES['imagen']['size'] / 1024) > 5120) {

                $alerta = [
                    'Alerta' => 'simple',
                    'Titulo' => 'Ocurrió un error inesperado',
                    'Texto' => 'La imagen que ha seleccionado supera el peso permitido.',
                    'Tipo' => 'error'
                ];

                return json_encode($alerta);
                
            }


            # Definimos el nombre de la Imagen
            $fecha = new DateTime();

            $foto = str_ireplace(' ', '_', $nombre);
            $foto = $foto . '_' . $fecha->getTimestamp();

            # Extencion de la imagen
            switch (mime_content_type($_FILES['imagen']['tmp_name'])) {
                case 'image/jpg':
                    $foto = $foto . '.jpg';
                    break;
                case 'image/jpeg':
                    $foto = $foto . '.jpeg';
                    break;
                case 'image/png':
                    $foto = $foto . '.png';
                    break;
                case 'image/gif':
                    $foto = $foto . '.gif';
                    break;
            }





            # Damos permisos de lectura y escritura al programa para poder escribir la imagen
            chmod($images_dir, 0644);

            # Movemos la imagen al directoro
            $foto_guardada = move_uploaded_file($_FILES['imagen']['tmp_name'], $images_dir . $foto);

                        //--test


            if (!$foto_guardada) {
                $alerta = [
                    'Alerta' => 'simple',
                    'Titulo' => 'Ocurrió un error inesperado',
                    'Texto' => 'No es posible subir la imagen en este momento.',
                    'Tipo' => 'error'
                ];

                return json_encode($alerta);
                
            }

        } else {

            //si no se subio ninguna imagen, tendra la imagen por defecto
            $foto = 'default.png';
        }





        //PREPARACION DEL ARRAY
        $datos_producto = [          
            'nombre' => $nombre,
            'categoria_id' => $categoria_id,
            'descripcion' => $descripcion,
            'codigo' => $codigo,
            'fecha_ingreso' => $fecha_ingreso,
            'usuario_id' => $usuario_id,
            'precio_compra' => $precio_compra,
            'precio_venta' => $precio_venta,
            'stock' => $stock,
            'stock_minimo' => $stock_minimo,
            'stock_maximo' => $stock_maximo,
            'imagen' => $foto
        ];

        




        $respuesta = ProductosModel::create($datos_producto);

        $url_a_redireccionar = '?view=productos-list';

        if($respuesta->rowCount() == 1){
            $alerta = [
                'Alerta' => 'recargar',
                'Titulo' => 'Producto registrado',
                'Texto' => 'Los datos del producto <b>' . $nombre . '</b><br>Han sido registrados exitosamente.',
                'Tipo' => 'success',
                'url' => $url_a_redireccionar
            ]; 

        }else{
           
            $alerta = [
                'Alerta' => 'simple',
                'Titulo' => 'Ocurrió un error inesperado',
                'Texto' => 'No ha sido posible realizar registrar el producto, por fabor intentelo nuevamente.',
                'Tipo' => 'error'
            ];

        }

        return json_encode($alerta);
        


    }

//UPDATE
    public function update_producto(){

        $producto_id = MainModel::limpiar_cadena($_POST['id']);

        $nombre = MainModel::limpiar_cadena($_POST['nombre']);
       
        $categoria_id = MainModel::limpiar_cadena($_POST['categoria_id']);

        $descripcion = MainModel::limpiar_cadena($_POST['descripcion']);
        //$codigo = MainModel::limpiar_cadena($_POST['codigo']);

        //$fecha_ingreso = MainModel::limpiar_cadena($_POST['fecha_ingreso']);

        $usuario_id = MainModel::limpiar_cadena($_POST['usuario_id']);

        $precio_compra = MainModel::limpiar_cadena($_POST['precio_compra']);
        $precio_compra = MainModel::limpiar_numero($precio_compra);

        $precio_venta = MainModel::limpiar_cadena($_POST['precio_venta']);
        $precio_venta = MainModel::limpiar_numero($precio_venta);

        $stock = MainModel::limpiar_cadena($_POST['stock']);
        $stock = MainModel::limpiar_numero($stock);
        
        $stock_minimo = MainModel::limpiar_cadena($_POST['stock_minimo']);
        $stock_minimo = MainModel::limpiar_numero($stock_minimo);

        $stock_maximo = MainModel::limpiar_cadena($_POST['stock_maximo']);
        $stock_maximo = MainModel::limpiar_numero($stock_maximo);

       


        //VERIFANDO LA EXISTNCIA DEL PRODUCTO

        $sql = "SELECT * FROM productos WHERE id= '" . $producto_id . "';";
        $producto_existe = MainModel::ejecutar_consulta_simple($sql);

        if($producto_existe->rowCount() == 0 ){
           

            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Respuesta.",
                "Texto" => "El producto no existe en el sistema",
                "Tipo" => "error"
            ];

            return json_encode($alerta);

            
        }else{
             $producto_existe = $producto_existe->fetch(PDO::FETCH_ASSOC);
        }


        //VALIDAMOS QUE LOS CAMPOS TRAIGAN ALGO
        if( $nombre == '' || $categoria_id == '' || $descripcion == '' || 
            $precio_compra == '' || $precio_venta == '' ||
            $stock  == '' || $stock_minimo == '' || $stock_maximo == '' ){
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado.",
                "Texto" => "Debe llenar todos los campos.",
                "Tipo" => "error"
            ];

            return json_encode($alerta);
        }

        //VALIDAMOS QUE SI SE HAYA MODIFICADO ALGO
        if( $nombre == $producto_existe['nombre'] && 
            $categoria_id == $producto_existe['categoria_id'] &&
            $descripcion == $producto_existe['descripcion'] &&
            $precio_compra == $producto_existe['precio_compra'] &&
            $precio_venta == $producto_existe['precio_venta'] &&
            $stock == $producto_existe['stock'] &&
            $stock_minimo == $producto_existe['stock_minimo'] &&
            $stock_maximo == $producto_existe['stock_maximo'] &&
            $_FILES['imagen']['name'] == '' && $_FILES['imagen']['size'] == 0
            

            ){
                $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado.",
                "Texto" => "Debe actualizar algun valor para realizar la actualización del producto.",
                "Tipo" => "error"
            ];

            return json_encode($alerta);

            }


        //VALIDAMOS EL NOMBRE
        if( $nombre != $producto_existe['nombre'] ){

            if (MainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ\d. '\-\" ]{0,150}", $nombre)) {
            $alerta = [
                'Alerta' => 'simple',
                'Titulo' => 'Ocurrió un error inesperado.',
                'Texto' => 'El <b>Nombre</b> no coincide con el formato solicitado.',
                'Tipo' => 'error'
            ];
            return json_encode($alerta);
            
            }            

        }else{
            $nombre = $producto_existe['nombre'];
        }



        //VERIFICAMOS QUE LA CATEGORIA EXISTA        
        if( $categoria_id != $producto_existe['categoria_id'] ){

            $sql = "SELECT * FROM categorias WHERE id = '" . $categoria_id . "';";
            $check_categoria = MainModel::ejecutar_consulta_simple($sql);
        

            if( $check_categoria->rowCount() <= 0 ){
                $alerta = [
                    'Alerta' => 'simple',
                    'Titulo' => 'Ocurrió un error inesperado.',
                    'Texto' => 'La <b>Categoría</b> no existe en el sistema.',
                    'Tipo' => 'error'
                ];
                return json_encode($alerta);

            }else{
                $check_categoria = $check_categoria->fetch(PDO::FETCH_ASSOC);
                $categoria_id = $check_categoria['id'];            
            }

        }else{
            $categoria_id = $producto_existe['categoria_id'];
        }
        


        //VERIFICAMOS LA DESCRIPCIÓN
        if( $descripcion != $producto_existe['descripcion'] ){

            //VERIFICAMOS LA DESCRIPCION
            if( MainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ\d. \,'\-\" ]{0,250}", $descripcion) ){
                $alerta = [
                    'Alerta' => 'simple',
                    'Titulo' => 'Ocurrió un error inesperado.',
                    'Texto' => 'La <b>Descripción </b> no coincide con el formato solicitado.',
                    'Tipo' => 'error'
                ];
                return json_encode($alerta);
            }

        }else{
            $descripcion = $producto_existe['descripcion'];
        }


        //VERIFICAMOS EL CODIGO
        //...

        // LA FECHA DE INGRESO NO SE MODIFICA 
        
            $fecha_ingreso = $producto_existe['fecha_ingreso'];
        


        //VERIFICAMOS QUE EL USUARIO EXISTA
        if( $usuario_id != $producto_existe['usuario_id'] ){
            $sql = "SELECT id FROM usuarios WHERE id='" . $usuario_id . "';";
            $check_usuario = MainModel::ejecutar_consulta_simple($sql);

            if( $check_usuario->rowCount() <= 0  ){
                $alerta = [
                        'Alerta' => 'simple',
                        'Titulo' => 'Ocurrió un error inesperado.',
                        'Texto' => 'El <b>usuario</b> no existe en el sistema.',
                        'Tipo' => 'error'
                    ];
                    return json_encode($alerta);   
            }



        }else{
            $usuario_id = $producto_existe['usuario_id'];
        }
        

        //EVALUAMOS EL PRECIO COMPRA
        if( $precio_compra != $producto_existe['precio_compra'] ){

            if( MainModel::verificar_datos('[1-9][0-9]{0,7}', $precio_compra) ){
            $alerta = [
                'Alerta' => 'simple',
                'Titulo' => 'Ocurrió un error inesperado.',
                'Texto' => 'El <b>Precio de compra</b> no coincide con el formato solicitado.',
                'Tipo' => 'error'
            ];
            return json_encode($alerta);
            
            }

        }else{
            $precio_compra = $producto_existe['precio_compra'];
        }


        //VERIFICAMOS PRECIO VENTA
        if( $precio_venta != $producto_existe['precio_venta'] ){

            if( MainModel::verificar_datos('[1-9][0-9]{0,7}', $precio_venta) ){
            $alerta = [
                'Alerta' => 'simple',
                'Titulo' => 'Ocurrió un error inesperado.',
                'Texto' => 'El <b>Precio de venta</b> no coincide con el formato solicitado.',
                'Tipo' => 'error'
            ];
            return json_encode($alerta);
            
           }

        }else{
            $precio_venta = $producto_existe['precio_venta'];
        }



        //VERIFICAMOS EL STOCK
        if($stock != $producto_existe['stock']){

                if( MainModel::verificar_datos('^[0-9]+$', $stock) ){
                    $alerta = [
                        'Alerta' => 'simple',
                        'Titulo' => 'Ocurrió un error inesperado.',
                        'Texto' => 'El <b>stock</b> no coincide con el formato solicitado.',
                        'Tipo' => 'error'
                    ];

                return json_encode($alerta);
                    
                }

        }else{
            $stock = $producto_existe['stock'];
        }


        //VERIFICAMOS EL STOCK MINIMO
        if($stock_minimo != $producto_existe['stock_minimo']){

            if( MainModel::verificar_datos('^[0-9]+$', $stock_minimo) ){
            $alerta = [
                'Alerta' => 'simple',
                'Titulo' => 'Ocurrió un error inesperado.',
                'Texto' => 'El <b>Stock mínimo</b> no coincide con el formato solicitado.',
                'Tipo' => 'error'
            ];

            return json_encode($alerta);
                
            }

        }else{
            $stock_minimo = $producto_existe['stock_minimo'];
        }


        //VERIFICAMOS EL STOCK MÁXIMO
        if($stock_maximo != $producto_existe['stock_maximo']){

            if( MainModel::verificar_datos('^[0-9]+$', $stock_maximo) ){
            $alerta = [
                'Alerta' => 'simple',
                'Titulo' => 'Ocurrió un error inesperado.',
                'Texto' => 'El <b>Stock máximo</b> no coincide con el formato solicitado.',
                'Tipo' => 'error'
            ];

            return json_encode($alerta);
                
            }

        }else{
            $stock_maximo = $producto_existe['stock_maximo'];
        }
      




      
        //VERIFICAMOS QUE LA IMAGEN TRAIGA ALGO
            //En el caso que se decidiera quitar la imagen pre existente,
             
        if($_FILES['imagen']['name'] == '' && $_FILES['imagen']['size'] == 0 ){
            
            //unlink('../Views/assets/images_productos/' . $producto_existe['imagen']);
            $imagen = $producto_existe['imagen'];


                
        }else{
            //SIGNIFICA QUE SI CAMBIO LA IMAGEN
        

                if( $_FILES['imagen']['name'] != $producto_existe['imagen']  ){


                    # IMAGEN ( Procesar y subir ) #
                    //creamos el nombre del Directorio de imagenes
                    $images_dir = '../Views/assets/images_productos/';


                        //Verificamos si se ha seleccionado una imagen
                        if ($_FILES['imagen']['name'] != '' && $_FILES['imagen']['size'] > 0) {

                            # Creando directorio


                            # Verificando formato de imagen( .jpg, .jpeg y .png)
                            if (
                                mime_content_type($_FILES['imagen']['tmp_name']) != 'image/jpg'  &&
                                mime_content_type($_FILES['imagen']['tmp_name']) != 'image/jpeg'  &&
                                mime_content_type($_FILES['imagen']['tmp_name']) != 'image/png' &&
                                mime_content_type($_FILES['imagen']['tmp_name']) != 'image/gif'
                            ) {             

                                $alerta = [
                                    'Alerta' => 'simple',
                                    'Titulo' => 'Ocurrió un error inesperado',
                                    'Texto' => 'La imagen que ha seleccionado es de un formato no permitido.',
                                    'Tipo' => 'error'
                                ];

                                return json_encode($alerta);
                                
                            }


                            # Verificando peso de la imagen (5MB)
                            if (($_FILES['imagen']['size'] / 1024) > 5120) {

                                $alerta = [
                                    'Alerta' => 'simple',
                                    'Titulo' => 'Ocurrió un error inesperado',
                                    'Texto' => 'La imagen que ha seleccionado supera el peso permitido.',
                                    'Tipo' => 'error'
                                ];

                                return json_encode($alerta);
                                
                            }


                            # Definimos el nombre de la Imagen
                            $fecha = new DateTime();

                            $imagen = str_ireplace(' ', '_', $nombre);
                            $imagen = $imagen . '_' . $fecha->getTimestamp();


                            # Extencion de la imagen
                            switch (mime_content_type($_FILES['imagen']['tmp_name'])) {
                                case 'image/jpg':
                                    $imagen = $imagen . '.jpg';
                                    break;
                                case 'image/jpeg':
                                    $imagen = $imagen . '.jpeg';
                                    break;
                                case 'image/png':
                                    $imagen = $imagen . '.png';
                                    break;
                                case 'image/gif':
                                    $imagen = $imagen . '.gif';
                                    break;
                            }



                            # Damos permisos de lectura y escritura al programa para poder escribir la imagen
                            chmod($images_dir, 0644);

                            # Movemos la imagen al directoro
                            $foto_guardada = move_uploaded_file($_FILES['imagen']['tmp_name'], $images_dir . $imagen);


                            
                            # Eliminamos la imagen anterior
                            if(!empty($producto_existe['imagen'])){

                                if( file_exists( $images_dir . $producto_existe['imagen']  ) ){
                                    $imagen_borrada = unlink($images_dir . $producto_existe['imagen']);
                                    
            
                                    if(!$imagen_borrada){
                                        $alerta = [
                                            'Alerta'=>'simple',
                                            'Titulo'=>'Respuesta',
                                            'Texto'=>'No es posible borrar la imagen',
                                            'Tipo'=>'error'
                                        ];
                                        return json_encode($alerta);
            
                                    }
                                }
                                
                            }

                                    


                            if (!$foto_guardada) {
                                $alerta = [
                                    'Alerta' => 'simple',
                                    'Titulo' => 'Ocurrió un error inesperado',
                                    'Texto' => 'No es posible subir la imagen en este momento.',
                                    'Tipo' => 'error'
                                ];

                                return json_encode($alerta);
                                
                            }

                        } else {

                            $imagen = '';
                        
                        }


                }else{
                    $imagen = $producto_existe['imagen'];
                }
        
        }        

        
        //////////////////////////////
        $arr_producto_update = [

            'id' => $producto_id,
            'nombre' => $nombre,
            'categoria_id' => $categoria_id,
            'descripcion' => $descripcion,

            'usuario_id' => $usuario_id,
            'precio_compra' => $precio_compra,
            'precio_venta' => $precio_venta,
            'stock' => $stock,
            'stock_minimo' => $stock_minimo,
            'stock_maximo' => $stock_maximo,
            'imagen' => $imagen

        ];

        $update_producto = ProductosModel::update($arr_producto_update);
        $url_a_redireccionar = '?view=productos-list';

        if( $update_producto->rowCount() == 1 ){
           
            $alerta = [
                'Alerta' => 'recargar',
                'Titulo' => 'Datos actualizados',
                'Texto' => 'Los datos del producto <b>' . $nombre . '</b><br>Han sido actualizados exitosamente.',
                'Tipo' => 'success',
                'url' => $url_a_redireccionar
            ]; 
        }else{
            $alerta = [
                'Alerta' => 'simple',
                'Titulo' => 'Ocurrió un error inesperado',
                'Texto' => 'No ha sido posible realizar la actualización, por fabor intentelo nuevamente.',
                'Tipo' => 'error'
            ];
        }

        return json_encode($alerta);     





    }



//ELIMINAR PRODUCTO
    public function delete_producto(){

        $id = MainModel::limpiar_cadena($_POST['id']);

        $sql = "SELECT * FROM productos WHERE id='". $id ."';";
        $check_producto = MainModel::ejecutar_consulta_simple($sql);

        if( $check_producto->rowCount() == 0  ){

            $alerta = [ 'Alerta' => 'simple',
                       'Titulo' => 'Ocurrió un error inesperado.',
                       'Texto' => 'El producto que esta intentando eliminar no existe ne el sistema',
                       'Tipo'  => 'error'
            ];

            return json_encode($alerta);

        }


        $producto = $check_producto->fetch(PDO::FETCH_ASSOC);

        //Eliminamos el archivo de imagen del directorio interno
        $images_dir = "../Views/assets/images_productos/";

        if( !empty($producto['imagen']) ){
            if( file_exists( $images_dir . $producto['imagen']  ) ){
             $imagen_borrada = unlink( $images_dir . $producto['imagen'] );
                if(!$imagen_borrada){
                    $alerta = [ 
                       'Alerta' => 'simple',
                       'Titulo' => 'Ocurrió un error inesperado.',
                       'Texto' => 'No es posible borrar la imagen',
                       'Tipo'  => 'error'
                ];
                           
                return json_encode($alerta);
                            
                }
        }
        }
     

        $respuesta = ProductosModel::destroy($id);
        $url_redireccion = '?view=productos-list';

        if($respuesta->rowCount() == 1){
            $alerta = [
                'Alerta' => 'recargar',
                'Titulo' => 'Producto eliminado.',
                'Texto' => "El producto <b>" . $producto['nombre'] ."</b><br>Ha sido eliminado exitosamente del sistema.",
                'Tipo' => 'success',
                'url' => $url_redireccion
            ];

        }else{
            $alerta = [
                'Alerta' => 'simple',
                'Titulo' => 'Ocurrió un error inesperado.',
                'Texto' => 'No ha sido posible eliminar el producto del sistema.',
                'Tipo' => 'error'
            ];
        }

        return json_encode( $alerta );
       
    }





 public function get_numero_productos(){
    $numero = ProductosModel::get_num_productos();
    return $numero;
 }
    
}
















