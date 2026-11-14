<?php 

    if($peticion_ajax){
    require_once('../Models/MainModel.php');
    }else{
        require_once('./app/Models/MainModel.php');
    }

    class ProductosModel extends MainModel {

        protected static function all(){

            //$sql = "SELECT * FROM productos";

             $sql = "SELECT * ,
                         prod.nombre as nombre_producto,
                         prod.id as id_producto,
                         categ.nombre as nombre_categoria,
                         usu.nombre as nombre_usuario,          
                         usu.email as usuario_email          
            
                    FROM productos as prod 

                    INNER JOIN categorias as categ
                    ON categ.id = prod.categoria_id 

                    INNER JOIN usuarios as usu 
                    ON usu.id = prod.usuario_id 

                    ORDER BY prod.nombre ASC"; 
           


            $productos = MainModel::ejecutar_consulta_simple($sql);
            return $productos;
        }



        protected static function find($id){
            $sql = "SELECT * FROM productos WHERE id ='" . $id . "'; ";
            $producto  = MainModel::ejecutar_consulta_simple($sql);            
            return $producto; 
        }



        protected static function get_one(int $id){
             $sql = "
            SELECT    
            prod.id as id_producto,        
            prod.nombre as nombre_producto,
            prod.precio_venta as precio_venta,
            prod.descripcion as descripcion,            
            prod.imagen as imagen,
            cat.nombre as categoria
            FROM productos AS prod
            INNER JOIN categorias AS cat
            ON cat.id = prod.categoria_id
            WHERE prod.id = :id
            LIMIT 1";

            $conexion = MainModel::conectar();
            $stm = $conexion->prepare($sql);
            $stm->bindParam(':id', $id);          
            $stm->execute();
            return $stm;
        }


        protected static function create($datos){
            

            $sql = "INSERT INTO productos(
            nombre,categoria_id,descripcion,codigo,fecha_ingreso,usuario_id,
            precio_compra,precio_venta,
            stock,stock_minimo,stock_maximo,imagen)
                    VALUES(:nombre,:categoria_id,:descripcion,:codigo,:fecha_ingreso,:usuario_id,
                    :precio_compra,:precio_venta,:stock,:stock_minimo,:stock_maximo,:imagen);";
            
            $sentencia = MainModel::conectar()->prepare($sql);
          
            $sentencia->bindParam(':nombre', $datos['nombre']);
            $sentencia->bindParam(':categoria_id', $datos['categoria_id']);
            $sentencia->bindParam(':descripcion', $datos['descripcion']);
            $sentencia->bindParam(':codigo', $datos['codigo']);
            $sentencia->bindParam(':fecha_ingreso', $datos['fecha_ingreso']);
            $sentencia->bindParam(':usuario_id', $datos['usuario_id']);
            $sentencia->bindParam(':precio_compra', $datos['precio_compra']);
            $sentencia->bindParam(':precio_venta', $datos['precio_venta']);
            $sentencia->bindParam(':stock', $datos['stock']);
            $sentencia->bindParam(':stock_minimo', $datos['stock_minimo']);
            $sentencia->bindParam(':stock_maximo', $datos['stock_maximo']);
            $sentencia->bindParam(':imagen', $datos['imagen']);
           
            $sentencia->execute();

            return $sentencia;           
          
        }

        protected static function update(array $datos ){
            $sql = "UPDATE productos SET 
                    nombre = :nombre,
                    categoria_id = :categoria_id,
                    descripcion = :descripcion,                               
                    usuario_id = :usuario_id,
                    precio_compra = :precio_compra,
                    precio_venta = :precio_venta,
                    stock = :stock,
                    stock_minimo = :stock_minimo,
                    stock_maximo = :stock_maximo,
                    imagen = :imagen
                    WHERE id = :id ;";

            $sentencia = MainModel::conectar()->prepare($sql);
            $sentencia->bindParam(':id', $datos['id']);        
            $sentencia->bindParam(':nombre', $datos['nombre']);        
            $sentencia->bindParam(':categoria_id', $datos['categoria_id']);        
            $sentencia->bindParam(':descripcion', $datos['descripcion']);     
              
              
            $sentencia->bindParam(':usuario_id', $datos['usuario_id']);     
            $sentencia->bindParam(':precio_compra', $datos['precio_compra']);     
            $sentencia->bindParam(':precio_venta', $datos['precio_venta']);     
            $sentencia->bindParam(':stock', $datos['stock']);     
            $sentencia->bindParam(':stock_minimo', $datos['stock_minimo']);     
            $sentencia->bindParam(':stock_maximo', $datos['stock_maximo']);     
            $sentencia->bindParam(':imagen', $datos['imagen']);     
         
            $sentencia->execute();
            return $sentencia;

        }


        protected static function destroy($id){
            $sql = "DELETE FROM productos WHERE id = :id ;";
            $sentencia = MainModel::conectar()->prepare($sql);
            $sentencia->bindParam(':id', $id);
            $sentencia->execute();
            return $sentencia;
        }




        public static function get_num_productos(){
            $sql = "SELECT COUNT(id) as num FROM productos";
            $resultado = MainModel::ejecutar_consulta_simple($sql);
            $numero = $resultado->fetch(PDO::FETCH_ASSOC);
            return $numero['num'];
        }

    }