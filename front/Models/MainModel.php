<?php 

if (!isset($peticion_ajax)) {
    $peticion_ajax = false;
}

if($peticion_ajax){
    require_once('../config/SERVER.php');
    require_once('../config/app.php');
}else{
    require_once('./front/config/SERVER.php');
    require_once('./front/config/app.php');
}





class MainModel {

    /*-- funcion conectar a la base de datos --*/

    protected static function conectar(){
        $conexion = new PDO( "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $conexion->exec('set character set utf8');
        return $conexion;
    }

    /*-- funcion para ejecutar consultas simples --*/

    protected static function ejecutar_consulta_simple( $consulta ){
        $sql = self::conectar()->prepare( $consulta );
        $sql->execute();
        return $sql;
    }


    /*-- encriptar cadena --*/

    public static function encryption( $string ){
        $output = false;
        $key = hash( 'sha256', SECRET_KEY );
        $iv = substr( hash( 'sha256', SECRET_IV ), 0, 16 );
        $output = openssl_encrypt($string, METHOD, $key, 0, $iv );
        $output = base64_encode( $output );
        return $output;
    }

    /*-- desencriptar cadena --*/

    protected static function decryption( $string ){
        $key = hash( 'sha256',SECRET_KEY);
        $iv = substr(hash('sha256', SECRET_IV), 0 , 16 );
        $output = openssl_decrypt( base64_decode( $string ), METHOD, $key, 0, $iv );
        return $output;
    }


    
    /*-- funcion para generar codigos aleatoreos --*/

    protected static function generar_codigo_aleatoreo( $letra, $longitud, $numero ){
        
        for( $i = 1; $i <= $longitud; $i++ ){
            $aleatoreo = rand( 0,9 );
            
            $letra .= $aleatoreo;
        }
      return $letra . '-' . $numero;  
    }  




    /*-- limpiar cadena --*/
    protected static function limpiar_cadena( $cadena ){
        $cadena = trim( $cadena );
        $cadena = stripslashes( $cadena );
        
        $cadena = str_ireplace('<script>','', $cadena);
        $cadena = str_ireplace('</script>','', $cadena);
        
        $cadena = str_ireplace('<script src>','', $cadena);
        $cadena = str_ireplace('<script type=>','', $cadena);
        
        $cadena = str_ireplace('SELECT * FROM','', $cadena);
        $cadena = str_ireplace('DELETE FROM','', $cadena);
        $cadena = str_ireplace('INSERT INTO','', $cadena);
        
        $cadena = str_ireplace('DROP TABLE','', $cadena);
        $cadena = str_ireplace('DROP DATABASE','', $cadena);
        $cadena = str_ireplace('TRUNCATE TABLE','', $cadena);

        $cadena = str_ireplace('SHOW TABLE','', $cadena);
        $cadena = str_ireplace('SHOW DATABASE','', $cadena);
        
        $cadena = str_ireplace('<?php','', $cadena);
        $cadena = str_ireplace('?>','', $cadena);
        $cadena = str_ireplace('--','', $cadena);
        $cadena = str_ireplace('>','', $cadena);
        $cadena = str_ireplace('<','', $cadena);
        $cadena = str_ireplace('[','', $cadena);
        $cadena = str_ireplace(']','', $cadena);
        $cadena = str_ireplace('^','', $cadena);
        $cadena = str_ireplace('==','', $cadena);
        $cadena = str_ireplace(';','', $cadena);
        $cadena = str_ireplace('::','', $cadena);
        
        $cadena = stripslashes( $cadena );
        $cadena = trim( $cadena );

        return $cadena;
    }


    /*--- funcion verificar datos( patterns ) ---*/ 

    protected static function verificar_datos( $filtro, $cadena ){

        if(preg_match('/^' . $filtro  . '$/u', $cadena)){
            return false;
        }else{
            return true;
        }

    }


    /*--  funcion verificar fechas --*/

    protected static function verificar_fechas( $fecha ){
        $valores = explode( '-',$fecha );

        if( count($valores) == 3 && checkdate( $valores[1], $valores[2], $valores[0] ) ){
            return false;
        }else{
            return true;
        }
    }


    /*-- funcion paginador de tablas --*/

    protected static function paginador_tablas($pagina, $Npaginas, $url, $botones) {
        $tabla = "<nav aria-label='Page navigation example'>
                     <ul class='pagination justify-content-center'>";
    
        // Botón "Primera"
        if ($pagina == 1) {
            $tabla .= "<li class='page-item disabled'>
                         <a class='page-link'>
                             <i class='fas fa-angle-double-left'></i>
                         </a>
                       </li>";
        } else {
            $tabla .= "<li class='page-item'>
                         <a class='page-link' href='" . $url . "1/'>
                             <i class='fas fa-angle-double-left'></i>
                         </a>
                       </li>
                       <li class='page-item'>
                         <a class='page-link' href='" . $url . ($pagina - 1) . "/'>Anterior</a>
                       </li>";
        }
    
        // Calcular los límites de las páginas a mostrar
        $inicio = max(1, $pagina - floor($botones / 2)); // Ajusta el inicio
        $fin = min($Npaginas, $inicio + $botones - 1); // Ajusta el fin
    
        // Asegúrate de que el inicio no esté por debajo de 1
        if ($fin - $inicio < $botones - 1) {
            $inicio = max(1, $fin - $botones + 1);
        }
    
        // Generar enlaces de las páginas
        for ($i = $inicio; $i <= $fin; $i++) {
            if ($pagina == $i) {
                $tabla .= "<li class='page-item'>
                             <a class='page-link active' href='" . $url . $i . "/'> " . $i . " </a>
                           </li>";
            } else {
                $tabla .= "<li class='page-item'>
                             <a class='page-link' href='" . $url . $i . "/'>" . $i . "</a>
                           </li>";
            }
        }
    
        // Botón "Siguiente"
        if ($pagina == $Npaginas) {
            $tabla .= "<li class='page-item disabled'>
                         <a class='page-link'>
                             <i class='fas fa-angle-double-right'></i>
                         </a>
                       </li>";
        } else {
            $tabla .= "<li class='page-item'>
                         <a class='page-link' href='" . $url . ($pagina + 1) . "/'>Siguiente</a>
                       </li>
                       <li class='page-item'>
                         <a class='page-link' href='" . $url . $Npaginas . "/'>
                             <i class='fas fa-angle-double-right'></i>
                         </a>
                       </li>";
        }
    
        $tabla .= "</ul></nav>";
    
        return $tabla;
    }
    

    

    /*-- Limpiar numero --*/

    protected static function limpiar_numero($numero){

        $numero = str_ireplace(',','', $numero);
        $numero = str_ireplace('.','', $numero);
        $numero = (int) $numero;
        return $numero;
    }


 
    public static function alerta_auxiliar($mensaje,$url){
         echo "<script>
                  Swal.fire({ 
                  title: 'Ocurrió un error inesperado.',
                        html : '<h4>$mensaje</h4>',
                        icon : 'error',
                        confirmButton : 'Aceptar',
                        confirmButtonColor: '#333',
                        confirmButtonText : 'Aceptar',
                     }).then((result)=>{
                                if(result.isConfirmed){
                                    window.location.href='" . SERVER_URL . "admin/$url';
                                    }else{
                                        window.location.href='" . SERVER_URL . "admin/$url';
                                }
                                });
                </script>";
                
    }
    
    public static function alerta_auxiliar_2($mensaje,$url){
         echo "<script>
                  alert('$mensaje');
                  window.location.href='" . SERVER_URL . $url .  "';
                  </script>";
                
    }
   
    public static function alerta_auxiliar_3($mensaje,$url){
         echo "<script>
                  alert('$mensaje');
                  window.location.href='" . SERVER_URL . $url .  "';
                  </script>";
                
    }


}





/* "<script>
                  Swal.fire({ 
                  title: 'Ocurrió un error inesperado.',
                        html : '<b>'" . $mensaje . "'.</b>',
                        icon : 'error',
                        confirmButton : 'Aceptar',
                        confirmButtonColor: '#333',
                     }).then((result)=>{
                                if(result.isConfirmed){
                                    window.location.href='" . SERVER_URL . "admin/". $url ."';
                                }
                                });
</script>";  */
