<?php

class VistasModel {

    protected static function obtener_vista_modelo($vista){
        $lista_blanca = ['inicio','nosotros', 'test','productos','detalle-producto','carrito','login-cli','registro-cli','datos-envio-cliente','pasarela','resumen','pedido-confirmado','mis-pedidos','pedido-detalle','contacto','politica-de-privacidad','terminos-y-condiciones','preguntas-frecuentes'];

        if( in_array($vista, $lista_blanca) ){

                if(is_file('./front/Views/contenidos/' . $vista . '-view.php')){
                    $contenido = './front/Views/contenidos/' . $vista . '-view.php';

                }else{
                    $contenido = './front/Views/contenidos/404-view.php';
                }
                
        }else{
            $contenido = './front/Views/contenidos/404-view.php';
        }

        return $contenido; 
    }

}