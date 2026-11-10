<?php 
require_once('./app/Models/MainModel.php');

class Seeder extends MainModel {


    public static function seed_admin(){
    
           
            $sql = "SELECT * FROM usuarios WHERE id='1';";
            $existe = MainModel::ejecutar_consulta_simple($sql);
            $usuario = $existe->fetch(PDO::FETCH_ASSOC);                    

            if( $existe->rowCount() == 1 ){
                echo "<script> alert('El usuario de ID = " . $usuario['id'] . " , SI existe.'); </script>";       
            
            }
            else{                

                $id = 1;
                $nombre = 'admin';
                $email = 'admin@sis.com';
                $password = '123456789';
                $password = MainModel::encryption($password);
                $nivel = 1;

                $sql = "INSERT INTO usuarios(id, nombre, email, nivel, password ) 
                        VALUES('$id', '$nombre', '$email', '$nivel', '$password' );";

                $creado = Seeder::ejecutar_consulta_simple($sql);        
                if( $creado){
                    echo "<script> alert('El usuario: admin\nHa sido creado exitosamente.'); </script>";
                }else{
                    echo "<script> alert('No ha sido posible crear al usuario.');</script>";
                }
                 
            
            }
        
    }

}
