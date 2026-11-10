<?php 

if( $peticion_ajax){
    
    require_once('../Models/LoginModel.php');
}else{
    require_once('./app/Models/LoginModel.php');

}

   


class LoginController extends LoginModel {


    public function iniciar_session_controlador(){

        $email = MainModel::limpiar_cadena( $_POST['email'] );
        $password = MainModel::limpiar_cadena( $_POST['password']);


        /*-- Comprobar campos vacios --*/
        if( $email === '' || $password === '' ){
            echo "<script>
                    Swal.fire({ title: 'Ocurrió un error inesperado.',
                                html : '<b>No ha llenado todos los campos.</b>',
                                icon : 'error',
                                confirmButton : 'Aceptar',
                                confirmButtonColor: '#333',
                             }).then((result)=>{
                                if(result.isConfirmed){
                                    window.location.href='" . SERVER_URL . "/admin';
                                    }else{
                                        window.location.href='" . SERVER_URL . "/admin';
                                }
                                });
                  </script>";
            exit();                       
        }

        /*-- verificar la integridad de los datos --*/
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            echo "<script>
                  Swal.fire({ title: 'Ocurrió un error inesperado.',
                        html : '<b>El email no coincide con el formato solicitado.</b>',
                        icon : 'error',
                        confirmButton : 'Aceptar',
                        confirmButtonColor: '#333',
                     }).then((result)=>{
                                if(result.isConfirmed){
                                    window.location.href='" . SERVER_URL . "admin/';
                                }else{
                                        window.location.href='" . SERVER_URL . "admin/';
                                }
                                });
                  </script>"; 
           exit();
        }
        

        if(MainModel::verificar_datos( '[a-zA-Z0-9$@.-]{7,100}', $password )){
            echo "<script>
                  Swal.fire({ title: 'Ocurrió un error inesperado.',
                        html : '<b>El password no coincide con el formato solicitado.</b>',
                        icon : 'error',
                        confirmButton : 'Aceptar',
                        confirmButtonColor: '#333',
                     }).then((result)=>{
                                if(result.isConfirmed){
                                    window.location.href='" . SERVER_URL . "admin/';
                                }
                                });
                  </script>"; 
           exit();
        }




        /*--Si llego hasta aquí, encriptamos la clave entrante --*/
        $password = MainModel::encryption( $password );

        /* preparamos el array */

        $datos_usuario = [ 'email' => $email, 'password' => $password];
        

        /* RESPUESTA DEL MODELO */
        $datos_cuenta = LoginModel::iniciar_session_modelo( $datos_usuario );

        if( $datos_cuenta->rowCount() == 1 ){

            $row = $datos_cuenta->fetch();
            session_start( ['name' =>'SIS006'] ); 
            session_regenerate_id(); 

            $_SESSION['id'] = $row['id'];
            $_SESSION['nombre'] = $row['nombre'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['nivel'] = $row['nivel'];

            $_SESSION['token_SIS006'] = md5( uniqid( mt_rand(), true ) );

            return header('Location:' . SERVER_URL .  'admin/?view=panel');
        
        }else{

            echo "<script>
            Swal.fire({ title: 'Ocurrió un error inesperado.',
                        html : '<b>El email o clave son incorrectos.</b>',
                        icon : 'error',
                        confirmButton : 'Aceptar',
                        confirmButtonColor: '#333',
                     });
                     
            </script>";

        }



        



        
    }
    
    
    //forzar_cierre_session_controlador
    public function forzar_cierre_session_controlador(){
        session_unset();
        session_destroy();      


        if( headers_sent() ){
            return "<script> window.location='" . SERVER_URL . "admin/';  </script>";
        }
        else{
            return header('Location: ' . SERVER_URL . 'admin/');
        }



    }



    //Funcion para cerrar session
    public function cerrar_session_controlador(){      

        session_unset();
        session_destroy();
      
        return true;

    }

} 