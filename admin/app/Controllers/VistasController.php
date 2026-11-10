<?php 

require_once('./app/Models/VistasModel.php');
class VistasController extends VistasModel {

    public function obtener_plantilla_controlador(){
        require_once('./app/Views/plantilla.php');
    }

    public function obtener_vista_controlador(){

        if( isset( $_GET['view'] )  ){
            
            $ruta = explode('/', $_GET['view']);
            $respuesta = VistasModel::obtener_vista_modelo($ruta[0]);

        }else{
            $respuesta = 'login';
        }

        return $respuesta;
    }

}