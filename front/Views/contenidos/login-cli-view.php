<div  style="height:100dvh;">
  <div class="row">
  <div class="col-md-12 ">
    <div class="login-box mx-auto">
      <div class="login-logo">
        <h3>Iniciar session</h3>
      </div>
      <!-- /.login-logo -->
      <div class="card">
        <div class="card-body login-card-body">
          <p class="login-box-msg">Ingrese sus datos</p>






          <form id="form_login" method="post">

            <div class="input-group mb-3">
              <input type="email" class="form-control" id="email" placeholder="Email">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
              </div>
            </div>


            <div class="input-group mb-3">
              <input type="password" class="form-control" pattern="[a-zA-Z0-9\$\@\.\-]{7,100}" id="password" placeholder="Password" value="">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>

            <div class="row">

              <div class="col-12 d-flex justify-content-center">
                <button type="submit" class="btn btn-dark " name="login">Ingreso</button>
              </div>
            </div>

          </form>





        </div>




        <!-- /.login-card-body -->
      </div>
      <div class="text-center mt-2">
        <a href="index.php?view=registro-cli"><u>Registrarse</u></a>
      </div>

    </div>
  </div>
</div>

</div>



<!-- /.login-box -->




<script>
  const form_login = document.querySelector('#form_login');
  form_login.addEventListener('submit', (e) => {
    e.preventDefault();

    const email = document.querySelector('#email').value.trim();
    const password = document.querySelector('#password').value.trim();
    const action = 'auth';
    const type = 'login';

    fetch("<?= SERVER_URL; ?>front/ajax/login_cli_ajax.php", {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          email: email,
          password: password,
          action: action,
          type: type
        })
      })
      .then(response => response.json())
      .then(res => {

        if (res.status) {

          sessionStorage.setItem('id_cliente', res.cliente_data.id); 
          sessionStorage.setItem('nombre_cliente', res.cliente_data.nombre); 
          sessionStorage.setItem('email_cliente', res.cliente_data.email); 
          //window.location.href='index.php?view=productos';           
          
          window.history.back();

          
          
          } else {
          Swal.fire({
            title: res.title,
            html: `${res.message}`,
            icon: `${res.icon}`,
            confirmButtonText: 'Aceptar',
            confirmButtonColor: '#2994cd',
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.href = '<?= SERVER_URL; ?>index.php?view=login-cli';
            } else {
              window.location.href = '<?= SERVER_URL; ?>index.php?view=login-cli';

            }


          });


        }
      })



  })
</script>


</body>

</html>