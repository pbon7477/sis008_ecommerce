<?php

class VistasModel {

    protected static function obtener_vista_modelo( string $vistas ){
        $lista_blanca = [ 'panel',
                          'usuarios-list',
                          'usuarios-new',
                          'usuarios-edit',
                          'usuarios-edit-me',
                          'productos-list',
                          'productos-new',
                          'productos-edit',
                          'categorias-list',
                          'categorias-new',
                          'categorias-edit',
                          'ventas-list',
                          'ventas-new',
                          'pedidos-list',
                          'pedidos-new',
                          'pedidos-show',
                          'clientes-list',
                          'clientes-new',
                          'mensajes-list',
                          'carousel-admin'
                        ];

        if(in_array( $vistas, $lista_blanca )){
            
            if(is_file('./app/Views/contenidos/' . $vistas . '-view.php')){
                $contenido = './app/Views/contenidos/' . $vistas . '-view.php';
            }else{
                 $contenido = '404';
            }
            
        }elseif( $vistas == 'login' || $vistas == 'index'){
            $contenido = 'login';
        
        }else{
            $contenido = '404';
        }
       
       return $contenido; 
    }
}
