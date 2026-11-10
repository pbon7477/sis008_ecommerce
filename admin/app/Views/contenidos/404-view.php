  
  <style>

    body{
      margin: 0;
      padding:0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #e9ecef;
    }
    .container{
      display: flex;
      justify-content: center;
      flex-direction: column;
      border:1px dashed grey;
      align-items: center;
      height: 100dvh;

    }
    h1,p, a{
      margin: 0;
      padding:0;
    }
  </style>
  <div class="container">

            <h2>404</h2>
            <hr>
            <p>Pagina no encontrada.</p>
            <a href="<?= SERVER_URL; ?>admin/?view=panel">volver</a>

  </div>