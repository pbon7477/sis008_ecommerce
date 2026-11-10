<?php
include_once('./front/Controllers/CarouselController.php');
$CarouselController = new CarouselController();
$items = $CarouselController->all_items();

?>


<?php if (count($items) > 0) { ?>



  <!-- carousel  -->
  <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="10000">



    <ol class="carousel-indicators ">
      <?php
      foreach ($items as $index => $item) {
      ?>
        <li data-target="#myCarousel" data-slide-to="<?= $index; ?>" class="border  <?= $index == 0 ? 'active' : '' ?>"></li>


      <?php  } ?>
    </ol>




    <div class="carousel-inner background-frame ">



      <?php
      foreach ($items as $index => $item) {

      ?>



        <!-- item -->
        <div class="<?= $index === 0 ? 'carousel-item active' : 'carousel-item'; ?>">

          <div class="promo-frame">

            <!-- imformación del producto-->

            <div class="promo-info">
              <div class="promo-category">
                <div class="promo-label">PRODUCTO DESTACADO</div>
                <div class="promo-label-categoria"><?= $item['categoria']; ?></div>
              </div>
              <h1><?= ucfirst($item['nombre_producto']); ?></h1>
              <p class="promo-description"><?= $item['descripcion']; ?></p>
              <p class="promo-precio">$<?= number_format($item['precio_venta'], 0, '', '.'); ?></p>
              <p class="promo-extra"></p>
              <a><button class="btn-ver-detalle   d-none d-md-block" data-id="<?= $item['id_producto']; ?>">Ver producto</button></a>
            </div>

            <div class="promo-imagen">
              <img src="<?= SERVER_URL; ?>admin/app/Views/assets/images_productos/<?= $item['imagen']; ?>" class="" alt="<?= $item['nombre_producto']; ?>">
              <a><button class="btn-ver-detalle  d-block d-md-none  mx-auto my-2" data-id="<?= $item['id_producto']; ?>">Ver producto</button></a>
            </div>
          </div>





        </div>



      <?php } ?>


    </div>

    <button class="carousel-control-prev" type="button" data-target="#myCarousel" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </button>

    <button class="carousel-control-next" type="button" data-target="#myCarousel" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </button>


  </div>



  <!-- end carousel  -->



<?php
} else {
?>

  <!-- carousel default-->
  <div class="carousel-default">
    <div class="banner-default">
      <div class="logo">
        <img src="<?= SERVER_URL; ?>admin/app/Views/assets/images/logo.png" alt="logo">
      </div>
      <div class="bienvenido entrar-fade-in"><?= COMPANY; ?> | Bienvenido</div>
    </div>

  </div>
  <!-- end carousel default-->
<?php } ?>







<script>
  let btns_ver_detalle = document.querySelectorAll('.btn-ver-detalle');
  btns_ver_detalle.forEach((btn) => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      let id = e.target.getAttribute('data-id');
      window.location.href = `<?= SERVER_URL; ?>index.php?view=detalle-producto&id=${id}`;
    })
  })
</script>