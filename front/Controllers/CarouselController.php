<?php 


    require_once('./front/Models/CarouselModel.php');

    class CarouselController extends CarouselModel {

    public function all_items(){
        $items = CarouselModel::all();
        return $items->fetchAll(PDO::FETCH_ASSOC);

    }

    }