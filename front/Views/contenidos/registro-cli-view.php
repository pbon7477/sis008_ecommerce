<div class="row">
  <div class="col-md-12 ">
    <div class="login-box mx-auto">
      <div class="login-logo">
        <h3>Registrarse </h3>
      </div>
      <!-- /.login-logo -->
      <div class="card">
        <div class="card-body login-card-body">
          <p class="login-box-msg">Crea tu cuenta</p>

          <?php
          if (isset($_POST['create'])) {
            require_once('./front/Controllers/ClientesController.php');
            $LoginClienteController = new ClientesController();
            $respuesta = $LoginClienteController->create_cliente();

            if ($respuesta) {

              echo $respuesta;
            }
          }

          ?>




          <form action="<?php echo SERVER_URL;  ?>index.php?view=registro-cli" method="post">
            <div class="input-group mb-3">
              <input type="nombre" class="form-control" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ _\-]{3,40}" name="nombre" placeholder="Nombre" required>
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-user"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input type="email" class="form-control" name="email" placeholder="Email" required>
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
              </div>
            </div>
            <div class="input-group ">
              <input type="password" class="form-control" pattern="[a-zA-Z0-9\$\@\.\-]{7,100}" name="password1" placeholder="Password" required>
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
            <div class="small text-right mb-3 ml-1 text-secondary">Debe contener un mínimo 7 caracteres</div>

            <div class="input-group mb-3">
              <input type="password" class="form-control" pattern="[a-zA-Z0-9\$\@\.\-]{7,100}" name="password2" placeholder="Confirmar password" required>
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>

            <div class="row">

              <div class="col-12 d-flex justify-content-center">
                <button type="submit" class="btn btn-dark " name="create">Registrarse</button>
              </div>
            </div>

          </form>





        </div>




        <!-- /.login-card-body -->
      </div>
      <div class="text-center mt-2">
        <a href="index.php?view=login-cli"><u>Ir al Login</u></a>
      </div>

    </div>
  </div>
</div>
<br>



<!-- /.login-box -->





</body>

</html>