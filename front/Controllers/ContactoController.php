<?php
require __DIR__ . '/../Models/ContactoModel.php';

class ContactoController extends ContactoModel
{

    public function save_message(array $data)
    {

        $nombre = MainModel::limpiar_cadena($data['nombre']);
        $email = MainModel::limpiar_cadena($data['email']);
        $telefono = MainModel::limpiar_cadena($data['telefono']);
        $motivo = MainModel::limpiar_cadena($data['motivo']);
        $mensaje = MainModel::limpiar_cadena($data['mensaje']);

        if($nombre === '' || $email === '' || $telefono === '' || $motivo === '' || $mensaje === ''){
            $response = [
                'status'=>'error',
                'title'=>'Campos vacíos',
                'message'=>'Debe llenar todos los campos'                
                ];

            return $response;
            exit();    

        }


        //verificamos el nombre
        if(MainModel::verificar_datos("[A-Za-zÁÉÍÓÚÜÑáéíóúüñ]+(?:(?:[ ']|-)[A-Za-zÁÉÍÓÚÜÑáéíóúüñ]+)*", $nombre)){
            $response = [
                'status'=>'error',
                'title'=>'Nombre inválido',
                'message'=>'El nombre no coincide con el formato solicitado'                
                ];

            return $response;
            exit();    
            
        } 

        //verificamos el email
        if(MainModel::verificar_datos("[a-zA-Z0-9._%+-]+@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*\.[a-zA-Z]{2,}", $email)){
            $response = [
                'status'=>'error',
                'title'=>'Email inválido',
                'message'=>'El email no coincide con el formato solicitado'                
                ];

            return $response;
            exit();    
            
        }

        //verificamos el telefono
        if(MainModel::verificar_datos("[0-9]{9}", $telefono)){
            $response = [
                'status'=>'error',
                'title'=>'Teléfono inválido',
                'message'=>'El teléfono no coincide con el formato solicitado'                
                ];

            return $response;
            exit();    
            
        }

        //verificamos el motivo
        if($motivo !== 'consulta' && $motivo !== 'presupuesto' && $motivo !== 'otro'){
            $response = [
                'status'=>'error',
                'title'=>'Motivo inválido',
                'message'=>'El motivo no coincide con el formato solicitado'                
                ];

            return $response;
            exit();    
            
        }

        //verificamos el mensaje
        if(mb_strlen($mensaje, 'UTF-8') > 1000){
            $response = [
                'status'=>'error',
                'title'=>'Mensaje inválido',
                'message'=>'El mensaje no coincide con el formato solicitado'                
                ];

            return $response;
            exit();    
            
        }


        //preparamos el array de datos para enviarlo al modelo
        $data_contacto = [
            'nombre' => $nombre,
            'email' => $email,
            'telefono' => $telefono,
            'motivo' => $motivo,
            'mensaje' => $mensaje
        ];

        $save = ContactoModel::save($data_contacto);

        if($save['status'] === 'success') {
            $response = [
                'status' => 'success',
                'title' => 'Mensaje enviado',
                'message' => 'Su mensaje ha sido enviado exitosamente'
            ];
        } else {
            $response = [
                'status' => 'error',
                'title' => 'Error al enviar el mensaje',
                'message' => 'No fue posible enviar su mensaje, por favor intente nuevamente',
                'error' => $save['error']
            ];
        }

        return $response;
        


    }
}
