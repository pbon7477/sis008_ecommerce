<?php
if ($peticion_ajax) {
    require_once('../Models/ClientesModel.php');
} else {
    require_once('./front/Models/ClientesModel.php');
}

class ClientesController extends ClientesModel
{



    public function create_cliente()
    {

        $nombre = MainModel::limpiar_cadena($_POST['nombre']);
        $email = MainModel::limpiar_cadena($_POST['email']);
        $password1 = MainModel::limpiar_cadena($_POST['password1']);
        $password2 = MainModel::limpiar_cadena($_POST['password2']);


        if (!$nombre || !$email || !$password1 || !$password2) {

            $respuesta = "<div class='alert alert-warning'>
                        <h6>Ocurrió un error inesperado</h6>
                        <p>Por fabor, rellene todos los campos</p>            
                      </div>";

            return $respuesta;
        }

        //VERIFICAR NOMBRE
        if (MainModel::verificar_datos('[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ _\-]{3,40}', $nombre)) {

            $respuesta = "<div class='alert alert-warning'>
                        <h6>Ocurrió un error inesperado</h6>
                        <p>El <b>Nombre</b> no coincide con el formato solicitado.</p>            
                      </div>";

            return $respuesta;
        }

        //VERIFICAR EMAIL
        if ($email != '') {

            /*-- comprobando valides del email  --*/
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {


                /*-- comprobando la posible existencia del email en la BBDD  --*/
                $sql = "SELECT email FROM clientes WHERE email = '" . $email . "';";
                $check_email = MainModel::ejecutar_consulta_simple($sql);

                if ($check_email->rowCount() > 0) {


                    $respuesta = "<div class='alert alert-warning'>
                        <h6>Ocurrió un error inesperado</h6>
                        <p>El <b>email</b> ingresado ya se encuentra registrado en el sistema.</p>            
                      </div>";

                    return $respuesta;
                }
            } else {

                $respuesta = "<div class='alert alert-warning'>
                        <h6>Ocurrió un error inesperado</h6>
                        <p>El <b>email</b> ingresado no es valido.</p>            
                      </div>";

                return $respuesta;
            }
        }


        // VERIFICANDO QUE LOS PASSWORD COINCIDAN CON EL FORMATO
        if (MainModel::verificar_datos('[a-zA-Z0-9\$\@\.\-]{7,100}', $password1)  || MainModel::verificar_datos('[a-zA-Z0-9\$\@\.\-]{7,100}', $password2)) {

            $respuesta = "<div class='alert alert-warning'>
                        <h6>Ocurrió un error inesperado</h6>
                        <p>Los <b>password</b> no coinciden con el formato solicitado.</p>            
                      </div>";

            return $respuesta;
        }

        /*-- VERIFICANDO LA IGUALDAD DE AMBOS PASSWORD --*/

        if ($password1 != $password2) {

            $respuesta = "<div class='alert alert-warning'>
                        <h6>Ocurrió un error inesperado</h6>
                        <p>Los <b>password</b> no son iguales, intentelo nuevamente.</p>            
                      </div>";

            return $respuesta;
        } else {

            $password_encriptado = MainModel::encryption($password1);
        }


        $formData = [
            'nombre' => $nombre,
            'email' => $email,
            'password' => $password_encriptado
        ];

        $crear_usuario = ClientesModel::create($formData);

        if ($crear_usuario->rowCount() > 0) {

            $respuesta = "<div class='alert alert-primary text-center'>
                        <h6><u>Registro exitoso</u></h6>
                        <p>El usuario <u>$nombre</u><br>ha sido registrado exitosamente. </p> 
                        <a href='index.php?view=login-cli' class='btn btn-xs btn-primary '>ir al Login</a>   

                      </div>";
        } else {

            $respuesta = "<div class='alert alert-danger'>
                        <h6>Ocurrió un error indesperado</h6>
                        <p>No es posible realizar el registro de la cuenta. Inténtelo mas tarde.</p>            
                      </div>";
        }

        return $respuesta;
    }

    public function get_one($id)
    {
        $id = MainModel::limpiar_cadena($id);
        $sql = "SELECT * FROM clientes WHERE id = '" . $id . "';";
        $cliente = MainModel::ejecutar_consulta_simple($sql);
        return $cliente->fetch(PDO::FETCH_ASSOC);
    }



    public function update_cliente_y_destinatario()
    {

        //Recibimos los datos del usuario
        $id = MainModel::limpiar_cadena($_POST['id_cliente']);
        $nombre_cliente = MainModel::limpiar_cadena($_POST['nombre_cliente']);
        $email_cliente = MainModel::limpiar_cadena($_POST['email_cliente']);
        $direccion_cliente = MainModel::limpiar_cadena($_POST['direccion_cliente']);
        $telefono_cliente = MainModel::limpiar_cadena($_POST['telefono_cliente']);


        //Recibimos los datos del destinatarios

        $nombre_destinatario = MainModel::limpiar_cadena($_POST['nombre_destinatario']);
        $email_destinatario = MainModel::limpiar_cadena($_POST['email_destinatario']);
        $direccion_destinatario = MainModel::limpiar_cadena($_POST['direccion_destinatario']);
        $telefono_destinatario = MainModel::limpiar_cadena($_POST['telefono_destinatario']);


        //Declaracion de la alerta
        $respuesta = ["respuesta" => false, "alerta" => ''];


        //Verificamos campos vacios del cliente
        if ($id == '' || $nombre_cliente === '' || $email_cliente === '' || $direccion_cliente == '' || $telefono_cliente === '') {

            $alerta = [               
                    'titulo' => 'Ocurrió un error inesperado',
                    'texto' => 'Debe llenar todos los campos del cliente.',
                    'icono'=>'info'
                      ];        

            $respuesta = ["success" => false, "alerta" => $alerta];

            return json_encode($respuesta);
        }



        //Verificamos campos vacios del destinatario

        if ($nombre_destinatario === '' || $email_destinatario === '' || $direccion_destinatario == '' || $telefono_destinatario === '') {

            $alerta = [               
                    'titulo' => 'Ocurrió un error inesperado',
                    'texto' => 'Debe llenar todos los campos del destinatario.',
                    'icono'=>'info'
                      ];

            $respuesta = ["success" => false, "alerta" => $alerta];

            return json_encode($respuesta);
        }


        //Verificamos el nombre del cliente
        if (MainModel::verificar_datos('[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ _\-]{3,40}', $nombre_cliente)) {
            
            $alerta = [               
                    'titulo' => 'Ocurrió un error inesperado',
                    'texto' => 'El <b>Nombre</b> del cliente no coincide con el formato solicitado.',
                    'icono'=>'info'
                      ];

            $respuesta = ["success" => false, "alerta" => $alerta];

            return json_encode($respuesta);
        }


        //Verificamos el email del cliente


        /*-- comprobando valides del email  --*/
        if (filter_var($email_cliente, FILTER_VALIDATE_EMAIL)) {


            /*-- comprobando la posible existencia del email en la BBDD  --*/
            $sql = "SELECT email FROM clientes WHERE email = '" . $email_cliente . "';";
            $check_email = MainModel::ejecutar_consulta_simple($sql);

            if ($check_email->rowCount() > 0) {
                $respuesta = ["success" => true, "alerta" => ''];

            } else {               

                $alerta = [               
                    'titulo' => 'Ocurrió un error inesperado',
                    'texto' => 'El <b>email</b> del usuario ingresado no se encuentra registrado en el sistema.',
                    'icono'=>'info'
                      ];

                    $respuesta = ["success" => false, "alerta" => $alerta];

                    return json_encode($respuesta);
            }

        } else {           

            $alerta = [               
                    'titulo' => 'Ocurrió un error inesperado',
                    'texto' => 'El <b>email</b> del usuario ingresado no es valido.',
                    'icono'=>'info'
                      ];

                    $respuesta = ["success" => false, "alerta" => $alerta];
                    return json_encode($respuesta);
        }



        //Verificamos la direccion del cliente

        if (MainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\(\)\.\,\#\- ]{1,150}", $direccion_cliente)) {
            
            $alerta = [               
                    'titulo' => 'Ocurrió un error inesperado',
                    'texto' => 'La <b>dirección</b> del usuario no coincide con el formato requerido.',
                    'icono'=>'info'
                      ];

                    $respuesta = ["success" => false, "alerta" => $alerta];
                    return json_encode($respuesta);
        }


        //Verificamos el telfono del cliente
        if (MainModel::verificar_datos('[0-9\(\)\+ ]{8,20}', $telefono_cliente)) {

            $alerta = [               
                    'titulo' => 'Ocurrió un error inesperado',
                    'texto' => 'El <b>teléfono</b> del usuario no coincide con el formato solicitado.',
                    'icono'=>'info'
                      ];

                    $respuesta = ["success" => false, "alerta" => $alerta];
                    return json_encode($respuesta);
        }

        //Si llega hasta aqui, creamos el array con los datos del cliente
        $form_data_cliente = [
            "id" => $id,
            "nombre" => $nombre_cliente,
            "email" => $email_cliente,
            "direccion" => $direccion_cliente,
            "telefono" => $telefono_cliente
        ];



        //DESTINATARIO

        //Verificamos el nombre del destinatario
        if (MainModel::verificar_datos('[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ _\-]{3,40}', $nombre_destinatario)) {

            $alerta = [               
                    'titulo' => 'Ocurrió un error inesperado',
                    'texto' => 'El <b>Nombre</b> del destinatario no coincide con el formato solicitado.',
                    'icono'=>'info'
                      ];

                    $respuesta = ["success" => false, "alerta" => $alerta];
                    return json_encode($respuesta);
        }


        //Verificamos el email del destinatario

        /*-- comprobando valides del email  --*/
        if (filter_var($email_destinatario, FILTER_VALIDATE_EMAIL)) {

            $respuesta = ["success" => true, "alerta" => ''];
        } else {

                        $alerta = [               
                    'titulo' => 'Ocurrió un error inesperado',
                    'texto' => 'El <b>email</b> ingresado para el destinatario no es valido.',
                    'icono'=>'info'
                      ];

                    $respuesta = ["success" => false, "alerta" => $alerta];
                    return json_encode($respuesta);
        }

        //Verificamos la dirección del destinatario

        if (MainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\(\)\.\,\#\- ]{1,150}", $direccion_destinatario)) {


                                    $alerta = [               
                    'titulo' => 'Ocurrió un error inesperado',
                    'texto' => 'La <b>dirección</b> para el destinatario no coincide con el formato requerido.',
                    'icono'=>'info'
                      ];

                    $respuesta = ["success" => false, "alerta" => $alerta];
                    return json_encode($respuesta);
        }


        //Verificamos el telefono del destinatario
        if (MainModel::verificar_datos('[0-9\(\)\+ ]{8,20}', $telefono_destinatario)) {



                        $alerta = [               
                    'titulo' => 'Ocurrió un error inesperado',
                    'texto' => 'El <b>teléfono</b> del destinatario no coincide con el formato solicitado.',
                    'icono'=>'info'
                      ];

                    $respuesta = ["success" => false, "alerta" => $alerta];
                    return json_encode($respuesta);
        }



        //Si pasa todas las validaciones, creamos al destinatario...
        //Si llega hasta aqui, creamos el array con los datos del cliente
        $form_data_destinatario = [
            "id" => $id,
            "nombre" => $nombre_destinatario,
            "email" => $email_destinatario,
            "direccion" => $direccion_destinatario,
            "telefono" => $telefono_destinatario
        ];

        //Verificamos que el destinatario no exista en el sistema, para no repetirlo

        $sql = "SELECT id FROM destinatarios 
               WHERE nombre = '$nombre_destinatario' 
               AND email = '$email_destinatario'
               AND direccion = '$direccion_destinatario'
               AND telefono = '$telefono_destinatario' 
               AND id_cliente = '$id';";

        $destinatario_existe = MainModel::ejecutar_consulta_simple($sql);

        if($destinatario_existe->rowCount() == 0 ) {            

            //Si no existe, creamos al destinatario

            $sql = "INSERT INTO destinatarios (nombre,email,direccion,telefono,id_cliente) 
                VALUES(:nombre,:email,:direccion,:telefono,:id_cliente);";

            $sentencia = MainModel::conectar()->prepare($sql);
            $sentencia->bindParam(':nombre', $nombre_destinatario);
            $sentencia->bindParam(':email', $email_destinatario);
            $sentencia->bindParam(':direccion', $direccion_destinatario);
            $sentencia->bindParam(':telefono', $telefono_destinatario);
            $sentencia->bindParam(':id_cliente', $id);

            $insert_destinatario =  $sentencia->execute();


            if ( $insert_destinatario) {
                $respuesta = ["success" => true, "alerta" => ''];

            } else {

                $alerta = [               
                    'titulo' => 'Ocurrió un error inesperado',
                    'texto' => 'No ha sido posible ingresar los datos del destinatario.<br>Inténtelo nuevamente.',
                    'icono'=>'info'
                    ];

                    $respuesta = ["success" => false, "alerta" => $alerta];
                    return json_encode($respuesta);
            }
        }




        //Si pasa todas las validaciones y se creo el destinatario..
        //Actualizamos los datos del cliente

        $resultado = ClientesModel::update_cliente_modelo($form_data_cliente);

        if ($resultado) {
            $respuesta = ["success" => true, "alerta" => ''];
        } else {
            $alerta = [               
                    'titulo' => 'Ocurrió un error inesperado',
                    'texto' => 'No ha sido posible actualizar los datos del cliente.<br>Inténtelo nuevamente.',
                    'icono'=>'info'
                      ];

                    $respuesta = ["success" => false, "alerta" => $alerta];
                    
        }
        
        session_start();
        $_SESSION['cliente'] = $form_data_cliente;
        $_SESSION['destinatario'] = $form_data_destinatario;

        return json_encode($respuesta);
    }


    public function session_cliente_y_destinatario() {

        //Recibimos los datos del usuario
        $id = MainModel::limpiar_cadena($_POST['id_cliente']);
        $nombre_cliente = MainModel::limpiar_cadena($_POST['nombre_cliente']);
        $email_cliente = MainModel::limpiar_cadena($_POST['email_cliente']);
        $direccion_cliente = MainModel::limpiar_cadena($_POST['direccion_cliente']);
        $telefono_cliente = MainModel::limpiar_cadena($_POST['telefono_cliente']);


        //Recibimos los datos del destinatarios

        $nombre_destinatario = MainModel::limpiar_cadena($_POST['nombre_destinatario']);
        $email_destinatario = MainModel::limpiar_cadena($_POST['email_destinatario']);
        $direccion_destinatario = MainModel::limpiar_cadena($_POST['direccion_destinatario']);
        $telefono_destinatario = MainModel::limpiar_cadena($_POST['telefono_destinatario']);


        //Declaracion de la alerta
        $respuesta = ["respuesta" => false, "alerta" => ''];


        //Verificamos campos vacios del cliente
        if ($id == '' || $nombre_cliente === '' || $email_cliente === '' || $direccion_cliente == '' || $telefono_cliente === '') {

            $alerta = [               
                    'titulo' => 'Ocurrió un error inesperado',
                    'texto' => 'Debe llenar todos los campos del cliente.',
                    'icono'=>'info'
                      ];        

            $respuesta = ["success" => false, "alerta" => $alerta];

            return json_encode($respuesta);
        }



        //Verificamos campos vacios del destinatario

        if ($nombre_destinatario === '' || $email_destinatario === '' || $direccion_destinatario == '' || $telefono_destinatario === '') {

            $alerta = [               
                    'titulo' => 'Ocurrió un error inesperado',
                    'texto' => 'Debe llenar todos los campos del destinatario.',
                    'icono'=>'info'
                      ];

            $respuesta = ["success" => false, "alerta" => $alerta];

            return json_encode($respuesta);
        }


        //Verificamos el nombre del cliente
        if (MainModel::verificar_datos('[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ _\-]{3,40}', $nombre_cliente)) {
            
            $alerta = [               
                    'titulo' => 'Ocurrió un error inesperado',
                    'texto' => 'El <b>Nombre</b> del cliente no coincide con el formato solicitado.',
                    'icono'=>'info'
                      ];

            $respuesta = ["success" => false, "alerta" => $alerta];

            return json_encode($respuesta);
        }


        //Verificamos el email del cliente


        /*-- comprobando valides del email  --*/
        if (filter_var($email_cliente, FILTER_VALIDATE_EMAIL)) {


            /*-- comprobando la posible existencia del email en la BBDD  --*/
            $sql = "SELECT email FROM clientes WHERE email = '" . $email_cliente . "';";
            $check_email = MainModel::ejecutar_consulta_simple($sql);

            if ($check_email->rowCount() > 0) {
                $respuesta = ["success" => true, "alerta" => ''];

            } else {               

                $alerta = [               
                    'titulo' => 'Ocurrió un error inesperado',
                    'texto' => 'El <b>email</b> del usuario ingresado no se encuentra registrado en el sistema.',
                    'icono'=>'info'
                      ];

                    $respuesta = ["success" => false, "alerta" => $alerta];

                    return json_encode($respuesta);
            }

        } else {           

            $alerta = [               
                    'titulo' => 'Ocurrió un error inesperado',
                    'texto' => 'El <b>email</b> del usuario ingresado no es valido.',
                    'icono'=>'info'
                      ];

                    $respuesta = ["success" => false, "alerta" => $alerta];
                    return json_encode($respuesta);
        }



        //Verificamos la dirección del cliente

        if (MainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\(\)\.\,\#\- ]{1,150}", $direccion_cliente)) {
            
            $alerta = [               
                    'titulo' => 'Ocurrió un error inesperado',
                    'texto' => 'La <b>dirección</b> del usuario no coincide con el formato requerido.',
                    'icono'=>'info'
                      ];

                    $respuesta = ["success" => false, "alerta" => $alerta];
                    return json_encode($respuesta);
        }


        //Verificamos el telefono del cliente
        if (MainModel::verificar_datos('[0-9\(\)\+ ]{8,20}', $telefono_cliente)) {

            $alerta = [               
                    'titulo' => 'Ocurrió un error inesperado',
                    'texto' => 'El <b>teléfono</b> del usuario no coincide con el formato solicitado.',
                    'icono'=>'info'
                      ];

                    $respuesta = ["success" => false, "alerta" => $alerta];
                    return json_encode($respuesta);
        }

        //Si llega hasta aqui, creamos el array con los datos del cliente
        $form_data_cliente = [
            "id" => $id,
            "nombre" => $nombre_cliente,
            "email" => $email_cliente,
            "direccion" => $direccion_cliente,
            "telefono" => $telefono_cliente
        ];



        //DESTINATARIO

        //Verificamos el nombre del destinatario
        if (MainModel::verificar_datos('[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ _\-]{3,40}', $nombre_destinatario)) {

            $alerta = [               
                    'titulo' => 'Ocurrió un error inesperado',
                    'texto' => 'El <b>Nombre</b> del destinatario no coincide con el formato solicitado.',
                    'icono'=>'info'
                      ];

                    $respuesta = ["success" => false, "alerta" => $alerta];
                    return json_encode($respuesta);
        }


        //Verificamos el email del destinatario

        /*-- comprobando valides del email  --*/
        if (filter_var($email_destinatario, FILTER_VALIDATE_EMAIL)) {

            $respuesta = ["success" => true, "alerta" => ''];
        } else {

                        $alerta = [               
                    'titulo' => 'Ocurrió un error inesperado',
                    'texto' => 'El <b>email</b> ingresado para el destinatario no es valido.',
                    'icono'=>'info'
                      ];

                    $respuesta = ["success" => false, "alerta" => $alerta];
                    return json_encode($respuesta);
        }

        //Verificamos la dirección del destinatario

        if (MainModel::verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\(\)\.\,\#\- ]{1,150}", $direccion_destinatario)) {


                    $alerta = [               
                    'titulo' => 'Ocurrió un error inesperado',
                    'texto' => 'La <b>dirección</b> para el destinatario no coincide con el formato requerido.',
                    'icono'=>'info'
                      ];

                    $respuesta = ["success" => false, "alerta" => $alerta];
                    return json_encode($respuesta);
        }


        //Verificamos el telefono del destinatario
        if (MainModel::verificar_datos('[0-9\(\)\+ ]{8,20}', $telefono_destinatario)) {
                        $alerta = [               
                    'titulo' => 'Ocurrió un error inesperado',
                    'texto' => 'El <b>teléfono</b> del destinatario no coincide con el formato solicitado.',
                    'icono'=>'info'
                      ];

                    $respuesta = ["success" => false, "alerta" => $alerta];
                    return json_encode($respuesta);
        }



        //Si pasa todas las validaciones, creamos al destinatario...
        //Si llega hasta aqui, creamos el array con los datos del cliente
        $form_data_destinatario = [            
            "nombre" => $nombre_destinatario,
            "email" => $email_destinatario,
            "direccion" => $direccion_destinatario,
            "telefono" => $telefono_destinatario
        ];
  






  
        //Actualizamos los datos del cliente si es que modifico algo(A excepcion de la contraseña)

        $resultado = ClientesModel::update_cliente_modelo($form_data_cliente);

        if ($resultado) {
            $respuesta = ["success" => true, "alerta" => ''];
        } else {
            $alerta = [               
                    'titulo' => 'Ocurrió un error inesperado',
                    'texto' => 'No ha sido posible actualizar los datos del cliente.<br>Inténtelo nuevamente.',
                    'icono'=>'info'
                      ];

                    $respuesta = ["success" => false, "alerta" => $alerta];
                    
        }
        
        //creamos las variables de session para el cliente y el destinatario
        session_start();
        $_SESSION['cliente'] = $form_data_cliente;
        $_SESSION['destinatario'] = $form_data_destinatario;

        return json_encode($respuesta);
    }

}
