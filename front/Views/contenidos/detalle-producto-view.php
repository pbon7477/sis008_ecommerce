<?php
require_once('./front/Controllers/ProductosController.php');
$ProductoController = new ProductosController();
$producto = $ProductoController->getProducto();

?>

<div class="row">
  <div class="col-md-12">
    <div class="header-section">
      <div>
        <h5><i class="fa fa-cube sub-icon-blue mr-2"></i>Detalle de producto</h5>
        <p>Detalle y características</p>
      </div>

    </div>
  </div>
</div>


<!-- Default box -->
<div class="card card-solid">
  <div class="card-body">
    <div class="row">
      <div class="col-12 col-sm-6">

        <div class="mb-3">
          <h3 class="d-inline-block d-sm-none"><?= ucwords($producto['nombre']); ?></h3>
        </div>

        <div class="col-12">
          <img src="<?= SERVER_URL; ?>admin/app/Views/assets/images_productos/<?= $producto['imagen']; ?>" class="product-image" style="width:50%;" alt="Product Image">
        </div>
        <!--               <div class="col-12 product-image-thumbs">
                <div class="product-image-thumb active"><img src="../../dist/img/prod-1.jpg" alt="Product Image"></div>
                <div class="product-image-thumb" ><img src="../../dist/img/prod-2.jpg" alt="Product Image"></div>
                <div class="product-image-thumb" ><img src="../../dist/img/prod-3.jpg" alt="Product Image"></div>
                <div class="product-image-thumb" ><img src="../../dist/img/prod-4.jpg" alt="Product Image"></div>
                <div class="product-image-thumb" ><img src="../../dist/img/prod-5.jpg" alt="Product Image"></div>
              </div> -->

      </div>
      <div class="col-12 col-sm-6">
        <h3 class="my-3"><?= ucwords($producto['nombre']); ?></h3>
        <p><?= $producto['descripcion']; ?>.</p>

        <hr>
        <h4>Stock: <?= $producto['stock']; ?></h4>



        <div class="border bg-info py-2 px-3 mt-4">
          <h2 class="mb-0">Precio:
            $<?= number_format($producto['precio_venta'], '0', '', '.'); ?>
          </h2>

        </div>



        <div class="row">
          <div class="col-12 mt-3 d-flex">
            <label for="cantidad_producto">Cantidad:</label>
            <input type="number" class="form-control form-control-sm col-3 col-md-2 ml-2" name="cantidad_producto" id="cantidad_producto" value="1">
          </div>
        </div>

        <br>


        <div class="row">
          <div class="col-6">
            <a href="index.php?view=productos" class="btn btn-outline-dark"><i class="fa fa-arrow-circle-left mr-1"></i> Volver a productos</a>
          </div>
          
          <div class="col-6">
            <button class="btn btn-dark btn " id="btnAgregarAlCarrito"
              data-id="<?php echo $producto['id']; ?>"
              data-nombre="<?= $producto['nombre']; ?>"
              data-imagen="<?= $producto['imagen']; ?>"
              data-precio-venta="<?= $producto['precio_venta']; ?>">
              <i class="fas fa-cart-plus fa-lg mr-2"></i>
              Agregar al carrito
            </button>
          </div>
        </div>




        <div class="mt-4 product-share">
          <a href="#" class="text-gray">
            <i class="fab fa-facebook-square fa-2x"></i>
          </a>
          <a href="#" class="text-gray">
            <i class="fab fa-twitter-square fa-2x"></i>
          </a>
          <a href="#" class="text-gray">
            <i class="fas fa-envelope-square fa-2x"></i>
          </a>
          <a href="#" class="text-gray">
            <i class="fas fa-rss-square fa-2x"></i>
          </a>
        </div>

      </div>
    </div>
    <div class="row mt-4">
      <nav class="w-100">
        <div class="nav nav-tabs" id="product-tab" role="tablist">
          <a class="nav-item nav-link active" id="product-desc-tab" data-toggle="tab" href="#product-desc" role="tab" aria-controls="product-desc" aria-selected="true">Descripción</a>
          <a class="nav-item nav-link" id="product-commentarios-tab" data-toggle="tab" href="#product-commentarios" role="tab" aria-controls="product-comments" aria-selected="false">Comentarios</a>
          <a class="nav-item nav-link" id="product-rating-tab" data-toggle="tab" href="#product-rating" role="tab" aria-controls="product-rating" aria-selected="false">Valoración</a>
        </div>
      </nav>
      <div class="tab-content p-3" id="nav-tabContent">
        <div class="tab-pane fade show active" id="product-desc" role="tabpanel" aria-labelledby="product-desc-tab">
          <?= $producto['descripcion']; ?>
        </div>
        <div class="tab-pane fade" id="product-commentarios" role="tabpanel" aria-labelledby="product-commentarios-tab">Comentarios...</div>


        <div class="tab-pane fade" id="product-rating" role="tabpanel" aria-labelledby="product-rating-tab">Valoración...</div>
      </div>
    </div>
  </div>
  <!-- /.card-body -->
</div>
<!-- /.card -->