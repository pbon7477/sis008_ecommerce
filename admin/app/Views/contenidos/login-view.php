<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Mi Tienda - Administrador</title>


  <link rel="stylesheet" href="<?= SERVER_URL; ?>admin/app/Views/AdminLTE/dist/css/adminlte.min.css">
  
<script src="app\Views\assets\js\sweetalert.js"></script>

</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <b>Mi</b>Tienda
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Login</p>

      <?php 

        if( isset($_POST['login']) ){
          require_once('./app/Controllers/LoginController.php');  
          $Login_controller = new LoginController();
          $Login_controller->iniciar_session_controlador();
          
          //header('Location:' . SERVER_URL . 'admin/panel.php');
          
        }
              
      ?>


      <form action="<?= $_SERVER['PHP_SELF'];?>" method="post">

        <div class="input-group mb-3">
          <input type="email" class="form-control" name="email" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        <div class="row">

          <div class="col-12 d-flex justify-content-center">
            <button type="submit" class="btn btn-outline-primary " name="login">Ingreso</button>
          </div>
        </div>
        
      </form>
      
      
      
      
      
    </div>
    <!-- /.login-card-body -->
    
    
  </div>
  
</div>
<br>

  <a href="<?= SERVER_URL;?>">Volver a la tienda</a>

<!-- /.login-box -->





</body>
</html>
