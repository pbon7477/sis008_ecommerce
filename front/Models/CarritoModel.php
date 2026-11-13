<?php 

require_once('MainModel.php');

class CarritoModel extends MainModel {

    public function get_producto( string $id){
        $response = [];


        try{
             $sql = "SELECT id,nombre,imagen,precio_venta FROM productos WHERE id = :id;";
             $conexion = MainModel::conectar();
             $stm = $conexion->prepare($sql);
             $stm->bindParam(':id',$id);
             $resultado = $stm->execute();
             

             if($resultado){
                if($stm->rowCount() != 0){

                    $response = [
                        'status'=>'success',
                        'message'=>'producto encontrado',
                        'producto'=>$stm->fetch(PDO::FETCH_ASSOC)
                        ];

                }else{
                    $response = [
                        'status'=>'error',
                        'message'=>'producto no encontrado',
                        'error'=>null
                        ];


                }
                

             }else{
                $response = [
                    'status'=>'error',
                    'message'=>'Error en la BBDD',
                    'error'=>null
                    ];
             }

             

        }catch(Exception $e){
            $response = [
                'status'=>'error',
                'message'=>$e->getMessage(),
                'linea'=> $e->getLine()
                ];
        }

        return $response;


    }

}