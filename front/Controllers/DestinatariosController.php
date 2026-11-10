<?php
if ($peticion_ajax) {
    require_once('../Models/DestinatarioModel.php');
} else {
    require_once('./front/Models/DestinatarioModel.php');
}

class DestinatarioController extends DestinatarioModel
{



    public function create_destinatario(array $datos_destinatario,  $id_cliente)    {

        $nombre = MainModel::limpiar_cadena($datos_destinatario['nombre']);
        $email = MainModel::limpiar_cadena($datos_destinatario['email']);
        $direccion = MainModel::limpiar_cadena($datos_destinatario['direccion']);
        $telefono = MainModel::limpiar_cadena($datos_destinatario['telefono']);
        $id_cliente = MainModel::limpiar_cadena($id_cliente);


        if ($nombre == '' || $email == '' || $direccion == '' || $telefono == '' || $id_cliente == '') {

            $response = [
                "status" => false,
                "message" => "No se han enviado todos los datos del destinatario."
            ];

            return json_encode($response);
            exit;
        }

        //VERIFICAR NOMBRE
        if (MainModel::verificar_datos('[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ _\-]{3,40}', $nombre)) {


            $response = [
                "status" => false,
                "message" => "El Nombre no coincide con el formato solicitado"
            ];

            return json_encode($response);
            exit;
        }


        //VERIFICAR EMAIL

        /*-- comprobando valides del email  --*/
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {                       

            $response = [
                    "status" => false,
                    "message" => ">El email ingresado no es valido."
                ];

                return json_encode($response);
                exit;            
        }



        // VERIFICANDO QUE LOS DIRECCION COINCIDAN CON EL FORMATO
        if ( MainModel::verificar_datos('[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\(\)\.\,\#\- ]{1,150}', $direccion) ) {

            $response = [
                    "status" => false,
                    "message" => ">La dirección no coinciden con el formato solicitado.."
                ];

                return json_encode($response);
                exit;
        }


        //VERIFICANDO QUE EL TELEFONO COINCIDA CON EL FORMATO SOLICITADO
        if( MainModel::verificar_datos('[0-9\(\)\+ ]{8,20}',$telefono) ){

        $response = [
                    "status" => false,
                    "message" => "El Teléfono no coincide con el formato solicitado."
                ];

                return json_encode($response);
                exit;

        }



        $formData = [
            'nombre' => $nombre,
            'email' => $email,
            'direccion' => $direccion,
            'telefono' => $telefono,
            'id_cliente'=>$id_cliente

        ];

        $crear_destinatario = DestinatarioModel::create($formData);

        if ($crear_destinatario['rowCount'] > 0) {

            $response = [
                    "status" => true,
                    "message" => "El destinatario ha sido registrado exitosamente.",
                    "id_destinatario"=>$crear_destinatario['id_destinatario']
                ];
                
        } else {
            $response = [
                    "status" => false,
                    "message" => "No ha sido poscible registrar al destinatario."
                ];
        }

        return $response;
    }




    public function get_one($id) {
        $id = MainModel::limpiar_cadena($id);
        $sql = "SELECT * FROM destinatarios WHERE id = '" . $id . "';";
        $destinatario = MainModel::ejecutar_consulta_simple($sql);
        return $destinatario->fetch(PDO::FETCH_ASSOC);
    }







}
