<?php 

require_once('MainModel.php');

class LoginClientesModel extends MainModel {

    protected static function check_cliente($data){
      
      $sql = "SELECT * FROM clientes WHERE email = :email and password = :password ;";
      $query = MainModel::conectar()->prepare($sql);
      $query->bindParam(':email',$data['email']);
      $query->bindParam(':password', $data['password']);
      $query->execute();

      return $query;

    }
    
}