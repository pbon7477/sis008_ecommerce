<?php

if ($peticion_ajax) {

    require_once('../Models/LoginClientesModel.php');
} else {
    require_once('./front/Models/LoginClientesModel.php');
}

class LoginClientesController extends LoginClientesModel
{

    public function iniciar_session_clientes($email, $password)
    {
        $email = MainModel::limpiar_cadena($email);
        $password = MainModel::limpiar_cadena($password);

        if ($email == '' || $password == '') {
            $response = [
                "status" => false,
                "title" => "Ocurrió un error inesperado",
                "message" => "No ha llenado todos los campos.<br>Ingrese su Email y Password",
                "icon" => "warning"
            ];
            return json_encode($response);
        }


        //evaluamos que el email sea un email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

            $response = [
                "status" => false,
                "title" => "Ocurrió un error inesperado",
                "message" => "El <b>email</b> no coincide con el formato solicitado.",
                "icon" => "warning"
            ];
            return json_encode($response);
        }


        //Evaluamos que la contraseña cumpla el formato solicitado
        if (MainModel::verificar_datos('[a-zA-Z0-9\$\@\.\-]{7,100}', $password)) {

            $response = [
                "status" => false,
                "title" => "Ocurrió un error inesperado",
                "message" => "El <b>Password</b> no coincide con el formato solicitado",
                "icon" => "warning"
            ];
            return json_encode($response);
            
        }



        //Encriptamos el password entrante
        $password_hasheado = MainModel::encryption($password);

        //Verificamos si el email (usuario) existe
        $cliente_data = [
            'email' => $email,
            'password' => $password_hasheado
        ];


        $cliente_existe = LoginClientesModel::check_cliente($cliente_data);

        if ($cliente_existe->rowCount() == 0) {

            $response = [
                "status" => false,
                "title" => "Ocurrió un error inesperado",
                "message" => "Email o Password incorrectos",
                "icon" => "error"
            ];
            return json_encode($response);

        } else {

            //Obtenemos los datos para iniciar session
            $cliente_data = $cliente_existe->fetch(PDO::FETCH_ASSOC);


            session_start();
            $_SESSION['id_cliente'] = $cliente_data['id'];
            $_SESSION['nombre_cliente'] = $cliente_data['nombre'];
            $_SESSION['email_cliente'] = $cliente_data['email'];
            
            

            $response = [
                "status" => true,                
                "cliente_data"=>$cliente_data
            ];

            return json_encode($response);;
        }
        
    }


    public function cerrar_session_cliente() {
        session_start();
        session_unset();
        session_destroy();
        
        $response = [
            'status'=>true,
            'message'=>'session cerrada'
        ];

        return json_encode($response);
    }
}
