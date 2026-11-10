<?php

if( $peticion_ajax ){
    require_once('../Models/CarouselModel.php');
}else{
    require_once('./app/Models/CarouselModel.php');
}

class CarouselController extends CarouselModel{
                                

    public function all_items()
    {
        $items = CarouselModel::all();
        return $items;
    }
    
   

    public function get_item( int $id){
        $item = CarouselModel::get($id);
        return $item;
    }

    

    public function save_item(array $producto){

        //verificar que el producto no se haya ingresado ya
        $sql = "SELECT id_producto FROM carousel WHERE id_producto = '" . $producto['id_producto'] . "';";
        $existe = MainModel::ejecutar_consulta_simple($sql);

        if($existe->rowCount() > 0){
            $response = ['status'=>'error','message'=>'El producto ya está marcado como destacado.'];
            

        }else{
            $response = CarouselModel::save($producto);
        }
        
        return $response;
      

    }


    public function update_item(array $item){
        $response = CarouselModel::update($item);
        return $response;
    }

    public function delete_item( int $id ){
        
        $response = CarouselController::delete($id);
        return $response;

    }
}
