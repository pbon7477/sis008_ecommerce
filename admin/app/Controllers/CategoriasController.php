<?php 

if( $peticion_ajax ){
    require_once('../Models/CategoriasModel.php');
}else{
    require_once('./app/Models/CategoriasModel.php');
}

class CategoriasController extends CategoriasModel {

    public function all_categories(){
        $categorias = CategoriasModel::all();
        $categorias = $categorias->fetchAll();
        return $categorias;

    }

    public function get_category(){
        $url = explode("/", $_GET['view']);
        $id = $url[1];

        $categoria = CategoriasModel::find($id);
        $categoria = $categoria->fetch(PDO::FETCH_ASSOC);
        return $categoria;
    }


    public function create_category(){
        $nombre = MainModel::limpiar_cadena($_POST['nombre']);
        $descripcion = MainModel::limpiar_cadena($_POST['descripcion']);

        //VERIFICAMOS CAMPOS VACIOS
        if($nombre == '' || $descripcion == ''){
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "Debe llenar todos los campos.",
                "Tipo" => "error"
            ];

            return json_encode($alerta);
        }

        //VERIFICAMOS QUE LA CATEGORIA NO EXISTA
        $sql = "SELECT nombre FROM categorias WHERE nombre = '" . $nombre . "';";
        $check_categoria = MainModel::ejecutar_consulta_simple($sql);

        if( $check_categoria->rowCount() > 0 ){
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "El <b>nombre</b> de la categoría ya existe en el sistema.",
                "Tipo" => "error"
            ];

            return json_encode($alerta);

        }


        // VERIFICAMOS EL NOMBRE DE LA CATEGORIA
        if (MainModel::verificar_datos('[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{3,40}', $nombre)) {
            $alerta = [
                'Alerta' => 'simple',
                'Titulo' => 'Ocurrió un error inesperado.',
                'Texto' => 'El <b>Nombre</b> no coincide con el formato solicitado.',
                'Tipo' => 'error'
            ];
            echo json_encode($alerta);
            exit();
        }

        //VERIFICAMOS LA DESCRIPCION
        if( MainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ\d.\,\ '\-\" ]{0,250}", $descripcion) ){
            $alerta = [
                'Alerta' => 'simple',
                'Titulo' => 'Ocurrió un error inesperado.',
                'Texto' => 'La <b>Descripción </b> no coincide con el formato solicitado.',
                'Tipo' => 'error'
            ];
            return json_encode($alerta);
        }


        $datos_categoria = [
            "nombre" => $nombre,
            "descripcion" => $descripcion
        ];

        $guardar_categoria = CategoriasModel::create( $datos_categoria );
        $url_a_redireccionar = "?view=categorias-list/";

        if($guardar_categoria){
            $alerta = [
                'Alerta' => 'recargar',
                'Titulo' => 'Datos actualizados',
                'Texto' => 'Los datos de la categoria <b>' . $nombre . '</b><br>Han sido registrados exitosamente.',
                'Tipo' => 'success',
                'url' => $url_a_redireccionar
            ]; 
        }else{
            $alerta = [
                'Alerta' => 'simple',
                'Titulo' => 'Ocurrió un error insesperado',
                'Texto' => 'No es posible registrar la categoría.<br>inténtelo nuevamente.',
                'Tipo' => 'success',
                'url' => $url_a_redireccionar
            ]; 
        }

        return json_encode($alerta);        

    }


    //UPDATE
    public function update_category(){
        $id = MainModel::limpiar_cadena($_POST['id']);
        $nombre = MainModel::limpiar_cadena($_POST['nombre']);
        $descripcion = MainModel::limpiar_cadena($_POST['descripcion']);

        
        //VERIFICAMOS CAMPOS VACIOS
        if($nombre == '' || $descripcion == ''){
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "Debe llenar todos los campos.",
                "Tipo" => "error"
            ];

            return json_encode($alerta);
        }

        //VERIFICAMOS LO QUE HAY EN LA BASE DE DATOS
        $sql = "SELECT * FROM categorias WHERE id = '" . $id . "';";
        $categoria_existente = MainModel::ejecutar_consulta_simple($sql);
        
        if( $categoria_existente->rowCount() == 0 ){
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "La categoría que esta intentando actualizar no existe en el sistema.",
                "Tipo" => "error"
            ];

            return json_encode($alerta);
        }else{
            $categoria_existente = $categoria_existente->fetch(PDO::FETCH_ASSOC);
        }

        //VERIFICAMOS QUE EL NOMBRE SEA DIFERENTE DE LO QUE EXSITE EN LA BBDD
        if( $nombre != $categoria_existente['nombre'] ){
            if (MainModel::verificar_datos('[a-zA-ZáéíóúÁÉÍÓÚñÑ 0-9]{3,40}', $nombre)) {
            $alerta = [
                'Alerta' => 'simple',
                'Titulo' => 'Ocurrió un error inesperado.',
                'Texto' => 'El Nombre no coincide con el formato solicitado.',
                'Tipo' => 'error'
            ];
            echo json_encode($alerta);
            exit();
            }

        }else{
            $nombre = $categoria_existente['nombre'];
        }


        //VERIFICAMOS QUE LA DESCRIPCION SEA DIFERENTE DE LO QUE EXISTE EN LA BBDD
        if($descripcion != $categoria_existente['descripcion'] ){

            if( MainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ\d.\,\ '\-\" ]{0,250}", $descripcion) ){
            $alerta = [
                'Alerta' => 'simple',
                'Titulo' => 'Ocurrió un error inesperado.',
                'Texto' => 'La <b>Descripción </b> no coincide con el formato solicitado.',
                'Tipo' => 'error'
            ];
            return json_encode($alerta);
            }

        }else{
            $descripcion = $categoria_existente['descripcion'];
        }

        $datos_categoria = [
            "id"=> $id,
            "nombre" => $nombre,
            "descripcion" => $descripcion
        ];


        $update_categoria = CategoriasModel::update($datos_categoria);
        $url_redirect = "?view=categorias-list";

        if( $update_categoria->rowCount() == 1 ){
           
            $alerta = [
                'Alerta' => 'recargar',
                'Titulo' => 'Datos actualizados',
                'Texto' => 'Los datos de la categoría <b>' . $nombre . '</b><br>Han sido actualizados exitosamente.',
                'Tipo' => 'success',
                'url' => $url_redirect
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



    //DELETE
    public function delete_category(){
        $id = MainModel::limpiar_cadena($_POST['id']);

        //VERIFICAMO QUE LA CATEGORIA A  ELIMINAR EXISTA

        $sql = "SELECT nombre FROM categorias WHERE id = '". $id ."';";
        $check_categoria = MainModel::ejecutar_consulta_simple($sql);
        $categoria = $check_categoria->fetch(PDO::FETCH_ASSOC);

        if($check_categoria->rowCount() == 0 ){
            $alerta = [ 
            "Alerta"=> "simple",
            "Titulo" => "Ocurrió un error inesperado.",
            "Texto" => "La <b>categoría </b> que esta intentando eliminar no existe en el sistema.",
            "Tipo" => "info"
        ];

        return json_encode($alerta);    
        }


        $eliminar_categoria = CategoriasModel::destroy($id);
        $url_a_redireccionar = "?view=categorias-list";

        if($eliminar_categoria->rowCount() == 1 ){

          $alerta = [
                'Alerta' => 'recargar',
                'Titulo' => 'Datos actualizados',
                'Texto' => 'Los datos de la categoría <b>' . $categoria['nombre'] . '</b><br>Han sido eliminados exitosamente.',
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




    public function get_numero_categorias(){
        $numero = CategoriasModel::get_num_categorias();
        return $numero;
    }

}