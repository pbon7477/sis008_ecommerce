  <footer>
    <div class="row">
      <div class="col-md-6 pb-2">
        <small>@2026 <?= COMPANY; ?></small>
        <ul id="footer-links">
          <li><a href="<?= SERVER_URL; ?>index.php?view=terminos-y-condiciones">Terminos y condiciones</a></li>
          <li><a href="<?= SERVER_URL; ?>index.php?view=politica-de-privacidad">Políticas de privacidad</a></li>
        </ul>
        <smal>Precios y ofertas vigentes a la fecha de publicación, sujeto a disponbilidad de stock</smal>

      </div>

      <div class="col-md-6 ">
        <p class="text-light"><b>Horario de atención</b></p>
        <p>Calle ejemplo , Puerto Montt, 09:00 -19:00</p>
        <p>+56 9 88 55 44 11</p>

        <div class="box_icons_rrss">
          <a href="#" class="icon_facebook"></a>
        <a href="#" class="icon_instagram"></a>
        <a href="#" class="icon_wathsapp"></a>
         </div>

      </div>

    </div>



    <div class="row">
      <div class="col-12 mt-2">
        <small>

          <strong>&copy; <span id="current_year"></span> <a href="<?= SERVER_URL; ?>"><?= COMPANY; ?></a>.</strong>
          Todos los derechos reservados.
          <div class="float-right d-none d-sm-inline-block px-5 pt-1">
            <b>Version</b> 3.2.0
          </div>
        </small>
      </div>
    </div>


  </footer>



  <script>
    let date = new Date();
    let current_year = date.getFullYear();
    document.querySelector('#current_year').innerText = current_year;

    </script>