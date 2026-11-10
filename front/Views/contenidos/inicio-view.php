<!--  carrusel-->

<?php include('./front/Views/inc/carousel.php'); ?>

<?php
require_once('./front/Controllers/ProductosController.php');
$ProductosControler = new ProductosController();
$categorias = $ProductosControler->getCategoriasProductos();

?>








<div class="container">
    <div class="row">

        <div class="col-12 col-md-6 col-lg-3 mb-2 mb-md-2">
            <div class="box-icon">
                <div class="box-sub-icon"><i class="fa fa-cube sub-icon-blue"></i></div>
                <div class="p-2">
                    <h6><b>Envíos Rápidos</b></h6>
                    <small>Despacho directo y seguro</small>
                </div>
            </div>

        </div>

        <div class="col-12 col-md-6 col-lg-3 mb-2 mb-md-2">
            <div class="box-icon">
                <div class="box-sub-icon"><i class="fab fa-whatsapp sub-icon-green"></i></div>
                <div class="p-2">
                    <h6><b>Atención 24/7</b></h6>
                    <small>Compras vía WhatsApp</small>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-3 mb-2 mb-md-2">
            <div class="box-icon">
                <div class="box-sub-icon"><i class="fas fa-shield-alt sub-icon-calipso"></i></div>
                <div class="p-2">
                    <h6><b>Garantía Total</b></h6>
                    <small>Calidad 100% verificada</small>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-3 mb-2 mb-md-2">
            <div class="box-icon">
                <div class="box-sub-icon "><i class="fa fa-credit-card sub-icon-yellow"></i></div>
                <div class="p-2">
                    <h6><b>Precios claros</b></h6>
                    <small>Sin cargos ocultos</small>
                </div>
            </div>
        </div>


    </div>

</div>

<br>

<!-- categorias -->
<div class="container">
    <div class="row">
        <div class="col-12 bg-light border p-3 rounded rounded-5 mb-5">
            <h4><i class="fa fa-cube sub-icon-blue mr-2"></i>Categorías de Productos</h4>

            <div class="container-categoria-label-buttons p-3 mt-1 ">


                <?php
                foreach ($categorias as $categoria) {

                ?>

                    <a href="index.php?view=productos&categoria=<?= $categoria['id']; ?>">
                        <button class="categoria-label-button" data-id="<?= $categoria['id']; ?>"><?= $categoria['nombre']; ?></button>
                    </a>

                <?php } ?>
            </div>
        </div>


    </div>
</div>

<br><br><br>


<script src="<?= SERVER_URL ?>front/Views/assets/js/jquery.min.js"></script>
<script src="<?= SERVER_URL ?>front/Views/assets/js/carousel.js"></script>