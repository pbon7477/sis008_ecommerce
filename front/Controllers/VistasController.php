<?php 

require_once('./front/Models/VistasModel.php');

class VistasController extends VistasModel {

    public function cargar_plantilla_controlador(){
        include('./front/Views/plantilla.php');
    }

    public function cargar_vistas_controlador(){
        
        if(isset($_GET['view'])){
            $ruta = explode('/', $_GET['view']);
            $respuesta = VistasModel::obtener_vista_modelo($ruta[0]);

        }else{
            $respuesta = './front/Views/contenidos/inicio-view.php';
        }

        return $respuesta;

    }
}