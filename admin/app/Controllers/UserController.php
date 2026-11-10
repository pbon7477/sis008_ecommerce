<?php

use BcMath\Number;

if( $peticion_ajax ){
    require_once('../Models/UserModel.php');
}else{
    require_once('./app/Models/UserModel.php');
}


class UserController extends UserModel{

    public function all_users(){
        $usuarios = UserModel::all();
        $usuarios = $usuarios->fetchAll();
        return $usuarios;

    }

    public function create_user(){
        
        $nombre = MainModel::limpiar_cadena($_POST['nombre']);
        $email = MainModel::limpiar_cadena($_POST['email']);
        $nivel = MainModel::limpiar_cadena($_POST['nivel']);
        $password_1 = MainModel::limpiar_cadena($_POST['password_1']);
        $password_2 = MainModel::limpiar_cadena($_POST['password_2']);


        //VERIFICANDO CAMPOS VACIOS
        if( $nombre === '' || $email === '' || $nivel == '' || $password_1 === '' || $password_2 === '' ){
          
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado.",
                "Texto" => "Debe llenar todos los campos.",
                "Tipo" => "error"
            ];

            echo json_encode($alerta);
            exit();
        }


        //VERIFICAR NOMBRE
        if (MainModel::verificar_datos('[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}', $nombre)) {
            $alerta = [
                'Alerta' => 'simple',
                'Titulo' => 'Ocurrió un error inesperado.',
                'Texto' => 'El Nombre no coincide con el formato solicitado.',
                'Tipo' => 'error'
            ];
            echo json_encode($alerta);
            exit();
        }


        //VERIFICAR EMAIL
        if ($email != '') {

            /*-- comprobando valides del email  --*/
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {


                /*-- comprobando la posible existencia del email en la BBDD  --*/
                $sql = "SELECT email FROM usuarios WHERE email = '" . $email . "';";
                $check_email = MainModel::ejecutar_consulta_simple($sql);

                if ($check_email->rowCount() > 0) {
                    $alerta = [
                        'Alerta' => 'simple',
                        'Titulo' => 'Ocurrió un error inesperado.',
                        'Texto' => 'El <b>email</b> ingresado ya se encuentra registrado en el sistema.',
                        'Tipo' => 'error'
                    ];
                    echo json_encode($alerta);
                    exit();
                }

            } else {
                $alerta = [
                    'Alerta' => 'simple',
                    'Titulo' => 'Ocurrió un error inesperado',
                    'Texto' => 'El <b>email</b> ingresado no es valido.',
                    'Tipo' => 'error'
                ];
                echo json_encode($alerta);
                exit();
            }
        }


        //VERIFICAR NIVEL
        if (MainModel::verificar_datos('[0-5]{0,1}', $nivel)) {
            $alerta = [
                'Alerta' => 'simple',
                'Titulo' => 'Ocurrió un error inesperado.',
                'Texto' => 'El Nivel no coincide con el formato solicitado.',
                'Tipo' => 'error'
            ];
            echo json_encode($alerta);
            exit();
        }


        // VERIFICANDO QUE LOS PASSWORD COINCIDAN CON EL FORMATO
        if ( MainModel::verificar_datos('[a-zA-Z0-9\$\@\.\-]{7,100}', $password_1)  || MainModel::verificar_datos('[a-zA-Z0-9\$\@\.\-]{7,100}', $password_2) ) {
            $alerta = [
                'Alerta' => 'simple',
                'Titulo' => 'Ocurrió un error inesperado',
                'Texto' => 'Las claves no coinciden con el formato solicitado.',
                'Tipo' => 'error'
            ];

            echo json_encode($alerta);
            exit();
        }

          /*-- VERIFICANDO LA IGUALDAD DE AMBOS PASSWORD --*/

        if ($password_1 != $password_2) {
            $alerta = [
                'Alerta' => 'simple',
                'Titulo' => 'Ocurrió un error inesperado',
                'Texto' => 'Las claves no son iguales, intentelo nuevamente.',
                'Tipo' => 'error'
            ];

            echo json_encode($alerta);
            exit();
        } else {

            $password_encriptado = MainModel::encryption($password_1);
        }

        //PREPARAMOS EL ARRAY PARA ENVIAR AL MODELO
        $datos_usuario = [
            'nombre'=>$nombre,
            'email'=>$email,
            'nivel' => $nivel,
            'password' => $password_encriptado
        ];

        $respuesta = UserModel::create( $datos_usuario );

        if( $respuesta->rowCount() == 1 ){
            $alerta = [
                'Alerta' => 'limpiar',
                'Titulo' => 'Usuario registrado.',
                'Texto' => 'Los datos del usuario: <b>' . $nombre . '</b><br>Nivel: <b><u>' . $nivel . '</u></b><br/>Han sido registrados exitosamente.',
                'Tipo' => 'success'
            ];
        }else{
            $alerta = [
                'Alerta' => 'limpiar',
                'Titulo' => 'Ocurrió un error insesperado.',
                'Texto' => 'No ha sido posible registrar al usuario.',
                'Tipo' => 'error'
            ];
        }

        return json_encode($alerta);  

    
    }

    public function get_user(){
        $ruta= explode('/', $_GET['view']);
        $id = $ruta[1];
        
        $id = MainModel::limpiar_cadena($id);        
              
        $usuario = UserModel::find($id);  
     
        
        if( $id === '' ||   !$usuario || !is_numeric($id)){
            return false;
        }else{
            return $usuario;
        }


    }

    public function get_my_user(){
        $mi_perfil = UserModel::find($_SESSION['id']);
        return $mi_perfil;
    }


    public function update_user(){

        $id = MainModel::limpiar_cadena($_POST['id']);
        $nombre = MainModel::limpiar_cadena($_POST['nombre']);
        $email = MainModel::limpiar_cadena($_POST['email']);
        $nivel = MainModel::limpiar_cadena($_POST['nivel']);
        $password_1 = MainModel::limpiar_cadena($_POST['password_1'])??'';
        $password_2 = MainModel::limpiar_cadena($_POST['password_2'])??'';


        //VERIFICAMOS QUE EL USUARIO EXISTA
        $sql = "SELECT * FROM usuarios WHERE id = '" . $id . "';";
        $check_user = MainModel::ejecutar_consulta_simple($sql);
         if( $check_user->rowCount() <= 0 ){
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado.",
                "Texto" => "El usuario no existe en el sistema.",
                "Tipo" => "error"
            ];

            echo json_encode($alerta);
            exit();

         }else{
            $usuario_existente = $check_user->fetch(PDO::FETCH_ASSOC);
         }


        //VERIFICAMOS CAMPOS VACIOS PROVENIENTES DEL FORMULARIO
        if( $id == '' || $nombre == '' || $email == '' || $nivel == '' ){
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado.",
                "Texto" => "Debe llenar todos los campos.",
                "Tipo" => "error"
            ];

            echo json_encode($alerta);
            exit();
        }





        //VERIFICAR EMAIL PROVENIENTES DEL FORMULARIO
        if ( $email != $usuario_existente['email'] ) {

            /*-- comprobando valides del email  --*/
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                /*-- comprobando la posible existencia del email en la BBDD  --*/
                $sql = "SELECT email FROM usuarios WHERE email = '" . $email . "' AND id != '" . $id . "';";
                $check_email = MainModel::ejecutar_consulta_simple($sql);

                    if ($check_email->rowCount() > 0) {
                        $alerta = [
                            'Alerta' => 'simple',
                            'Titulo' => 'Ocurrió un error inesperado.',
                            'Texto' => 'El <b>email</b> ingresado ya se encuentra registrado en el sistema.',
                            'Tipo' => 'error'
                        ];
                        echo json_encode($alerta);
                        exit();
                    }

            } else {
                $alerta = [
                    'Alerta' => 'simple',
                    'Titulo' => 'Ocurrió un error inesperado.',
                    'Texto' => 'El <b>email</b> ingresado no es valido.',
                    'Tipo' => 'error'
                ];
                echo json_encode($alerta);
                exit();
            }


        }else{
            $email = $usuario_existente['email'];
        }


        //VERIFICAR NIVEL
        if( $nivel != $usuario_existente['nivel'] ){

            
            if (MainModel::verificar_datos('[0-5]{0,1}', $nivel)) {
            $alerta = [
                'Alerta' => 'simple',
                'Titulo' => 'Ocurrió un error inesperado.',
                'Texto' => 'El Nivel no coincide con el formato solicitado.',
                'Tipo' => 'error'
            ];
            echo json_encode($alerta);
            exit();
            }
        
        }else{
            $nivel = $usuario_existente['nivel'];
        }   



        //VERIFICAMOS SI SE INGRESO ALGO EN LOS PASSWORD
        if( $password_1 != '' &&  $password_2 != '' ){


            // VERIFICANDO QUE LOS PASSWORD COINCIDAN CON EL FORMATO
            if ( MainModel::verificar_datos('[a-zA-Z0-9\$\@\.\-]{7,100}', $password_1)  || MainModel::verificar_datos('[a-zA-Z0-9\$\@\.\-]{7,100}', $password_2) ) {
                $alerta = [
                    'Alerta' => 'simple',
                    'Titulo' => 'Ocurrió un error inesperado.',
                    'Texto' => 'Las claves no coinciden con el formato solicitado.',
                    'Tipo' => 'error'
                ];

                echo json_encode($alerta);
                exit();
            }

            /*-- VERIFICANDO LA IGUALDAD DE AMBOS PASSWORD --*/

            if ($password_1 != $password_2) {
                $alerta = [
                    'Alerta' => 'simple',
                    'Titulo' => 'Ocurrió un error inesperado',
                    'Texto' => 'Las claves no son iguales, intentelo nuevamente.',
                    'Tipo' => 'error'
                ];

                echo json_encode($alerta);
                exit();
            } else {

                $password_encriptado = MainModel::encryption($password_1);
                
                
            }



        }else{
            $password_encriptado = $usuario_existente['password'];
        }


        


        //PREPARAMOS EL ARRAY
        $datos_usuario_update = [
            'id'=>$id,
            'nombre'=>$nombre,
            'email'=>$email,
            'nivel'=>$nivel,
            'password' => $password_encriptado
        ];

        $respuesta = UserModel::update($datos_usuario_update);


        // si es el administrador el que se esta actualizando que redireccione al panel ,
        // si no es el administrador que redireccione a la lista de usuarios. 
        $url_a_redireccionar =  $datos_usuario_update['id'] == 1 ? '?view=panel' : '?view=usuarios-list'; 

        if($respuesta->rowCount() > 0){
            $alerta = [
                'Alerta' => 'recargar',
                'Titulo' => 'Datos actualizados',
                'Texto' => 'Los datos del usuario <b>' . $nombre . '</b><br>Nivel: <b><u>' . $nivel . '</u></b><br>Han sido actualizados exitosamente.',
                'Tipo' => 'success',
                'url' => $url_a_redireccionar
            ]; 
        }else{
            $alerta = [
                'Alerta' => 'simple',
                'Titulo' => 'Ocurrió un error inesperado',
                'Texto' => 'No ha sido posible realizar la actualización, por fabor intentelo nuevamente.',
                'Tipo' => 'error'
            ];
        }


        return json_encode($alerta);     




    }


    public function delete_user(){
        $id = MainModel::limpiar_cadena($_POST['id']);

        /* - Evaluamos si se esta intentando eliminar al usuario principal - */
        if ($id == 1) {
            $alerta = [
                'Alerta' => 'simple',
                'Titulo' => 'Ocurrió un error inesperado.',
                'Texto' => 'No es posible eliminar al usuario principal del sistema.',
                'Tipo' => 'error'
            ];
            echo json_encode($alerta);
            exit();
        }

        //CONSULTAMOS SI EL USUARIO EXISTE
        $sql = "SELECT id FROM usuarios WHERE id = '" .$id . "';";
        $check_user = MainModel::ejecutar_consulta_simple($sql);

        if($check_user->rowCount() <= 0){
            $alerta = [
                'Alerta' => 'simple',
                'Titulo' => 'Ocurrió un error inesperado.',
                'Texto' => 'El usuario que esta intentando eliminar no existe en el sistema.',
                'Tipo' => 'error'
            ];
            echo json_encode($alerta);
            exit();
        }


        //ELIMINAMOS AL USUARIO
        $respuesta = UserModel::destroy($id);

        if($respuesta->rowCount() == 1){
            $alerta = [
                'Alerta' => 'recargar',
                'Titulo' => 'Usuario eliminado.',
                'Texto' => 'El usuario ha sido eliminado exitosamente del sistema.',
                'Tipo' => 'success',
                'url' => '?view=usuarios-list'
            ];

        }else{
            $alerta = [
                'Alerta' => 'simple',
                'Titulo' => 'Ocurrió un error inesperado.',
                'Texto' => 'No ha sido posible eliminar al usuario del sistema.',
                'Tipo' => 'success'
            ];
        }

        return json_encode( $alerta );



    }



    public function get_numero_usuarios(){
        $numero = UserModel::get_num_usuarios();
        return $numero;
    }

} 