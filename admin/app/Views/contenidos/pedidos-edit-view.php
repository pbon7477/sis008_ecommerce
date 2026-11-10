<?php
require_once('app/Controllers/ProductosController.php');
require_once('app/Controllers/CategoriasController.php');

$ProductosControler = new ProductosController();
$producto = $ProductosControler->getProducto();


$CategoriasController = new CategoriasController();
$categorias = $CategoriasController->all_categories();

?>






<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row ">
        <div class="col-sm-6">
          <h4 class="m-0">Editar producto</h4>

        </div><!-- /.col -->

      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">

    <div class="row">

      <!-- COLUMNA IZQUIERDA -->
      <div class="col-md-8">
        <div class="card">

          <div class="card-header bg-warning ">
            Información del producto
          </div>

          <form action="<?= SERVER_URL; ?>admin/app/ajax/Productos_Ajax.php" method="post" class="formulario_ajax" data-form="update" autocomplete="off" enctype="multipart/form-data">
            <input type="hidden" name="update" value="update">
            <input type="hidden" name="id" value="<?= $producto['id']; ?>">

            <div class="card-body">

              <!-- //NOMBRE Y CATEGORIA -->
              <div class="row">
                <div class="col-md-6 ">
                  <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" class="form-control form-control-sm" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9.\- ]{0,150}" name="nombre" id="nombre" value="<?= $producto['nombre']; ?>" required>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="categoria">Categoria:</label>
                    <div class="d-flex ">
                      <select name="categoria_id" class="form-control form-control-sm" required>

                        <?php
                        foreach ($categorias as $categoria) {  ?>


                          <option value="<?= $categoria['id'];  ?>" <?= $producto['categoria_id'] == $categoria['id'] ? 'selected' : ''; ?>>
                            <?= $categoria['nombre']; ?>
                          </option>

                        <?php   }  ?>
                      </select>

                      <a href="<?php echo SERVER_URL; ?>/categorias" class="btn btn-sm btn-primary ml-2" title="Crear nueva &#10;categoria"><i class="fa fa-plus"></i></a>
                    </div>
                  </div>
                </div>


              </div>


              <!-- //DESCRIPCIÓN Y CODIGO -->
              <div class="row">

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="descripcion">Descripcion:</label>
                    <textarea class="form-control form-control-sm" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9.\- ]{1,150}" name="descripcion" id="descripcion" cols="6" rows="6" placeholder="Descripción del producto..." value="<?= $producto['descripcion']; ?>" required><?= $producto['descripcion']; ?>
                    </textarea>
                  </div>
                </div>


                <div class="col-md-6">
                  <div class="form-group">
                    <label for="codigo">Código:</label>
                    <input type="hidden" name="usuario_id" value="<?= $_SESSION['id']; ?>">
                    <input class="form-control" type="text" value="<?= $producto['codigo']; ?>" disabled>
                    <input type="text" name="codigo" value="<?= $producto['codigo']; ?>" hidden>
                  </div>
                </div>

              </div>



              <!-- // FECHA INGRESO Y USUARIO -->
              <div class="row">

                <div class="col-md-3">
                  <div class="form-group">
                    <label for="fecha_ingreso">Fecha de ingreso:</label>
                    <input type="datetime-local" class="form-control form-control-sm" name="fecha_ingreso" id="fecha_ingreso" value="<?= $producto['fecha_ingreso']; ?>" required>
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <label for="usuario">Usuario:</label>
                    <input type="text" class="form-control form-control-sm" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\d. ]{0,150}" name="usuario" id="usuario" value="<?= $_SESSION['nombre']; ?>" disabled required />
                  </div>
                </div>
              </div>






              <!--// PRECIO COMPRA Y PRECIO VENTA -->
              <div class="row">

                <div class="col-md-3">
                  <div class="form-group">
                    <label for="precio_compra">Precio compra:</label>
                    <input type="text" class="form-control form-control-sm" pattern="[1-9][0-9]{0,7}" name="precio_compra" id="precio_compra" value="<?= $producto['precio_compra']; ?>" required>
                  </div>
                </div>


                <div class="col-md-3">
                  <div class="form-group">
                    <label for="precio_venta">Precio venta:</label>
                    <input type="text" class="form-control form-control-sm" pattern="[1-9][0-9]{0,7}" name="precio_venta" id="precio_venta" value="<?= $producto['precio_venta']; ?>" required>
                  </div>
                </div>

              </div>


              <div class="row">

                <div class="col-md-2">
                  <div class="form-group">
                    <label for="stock">Stock:</label>
                    <input type="text" class="form-control form-control-sm" pattern="^[0-9]+$" name="stock" id="stock" value="<?= $producto['stock']; ?>" required>
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <label for="stock_minimo">Stock mínimo:</label>
                    <input type="text" class="form-control form-control-sm" pattern="^[0-9]+$" name="stock_minimo" id="stock_minimo" value="<?= $producto['stock_minimo']; ?>" required>
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-group">
                    <label for="stock_maximo">Stock máximo:</label>
                    <input type="text" class="form-control form-control-sm" pattern="^[0-9]+$" name="stock_maximo" id="stock_maximo" value="<?= $producto['stock_maximo']; ?>" required>
                  </div>
                </div>

              </div>


            </div>

        </div>


      </div>


      <!-- COLUMNA DERECHA -->
      <div class="col-md-4">
        <div class="card">
          <div class="card-header bg-warning ">Imagen del producto</div>
          <div class="card-body">
            <div class="form-group">
              <label for="imagen">Imagen</label>
              <input type="file" class="form-control form-control-sm" name="imagen" id="imagen">
              <div id="imagenPreview" class="d-flex justify-content-center align-items-center borde p-3">
                <img src="./app/Views/assets/images_productos/<?= $producto['imagen'] != 'default.png' ? $producto['imagen'] : '../images/default.png';  ?>" class="border rounded m-1" alt="" width="200px">
              </div>
            </div>
          </div>
          <div class="card-footer text-center">
            <button class="btn btn-sm btn-secondary mx-auto" id="btnQuitarImagen"><small>
                Quitar imagen de este producto</small></button>

          </div>
        </div>
      </div>

    </div>

    <!-- BTN REGISTRAR -->
    <div class="row">
      <div class="col-md-12">
        <div class="form-group text-center mt-3">
          <a href="?view=productos-list" class="btn btn-secondary btn-sm">Cancelar</a>
          <input type="submit" class="btn btn-warning btn-sm" name="actualizar" value="Actualizar" />
        </div>
      </div>
    </div>

    </form>

  </section>
  <!-- /.content -->
</div>



<script>
  function archivo(e) {
    let files = e.target.files;

    for (let i = 0, f; f = files[i]; i++) {

      if (!f.type.match('image,*')) {
        continue;
      }

      let reader = new FileReader();

      reader.onload = (function(theFile) {
        return function(e) {
          document.getElementById('imagenPreview')
            .innerHTML = ['<img class="border rounded m-1" src="', e.target.result, '" width="200px" title="', theFile.name, '"/>'].join('');
        };
      })(f);
      reader.readAsDataURL(f);
    }
    document.querySelector('#btnQuitarImagen').style.display = "inline";
  }
  document.getElementById('imagen').addEventListener('change', archivo, false);
</script>


<script>
  //QUITAR IMAGEN DEL PRODUCTO 

  //Ocultamos inicialmente el boton
  let btnQuitarImagen = document.querySelector('#btnQuitarImagen');
  btnQuitarImagen.style.display = 'none';

  //seleccionamos la imagen <img ../>
  let imagenPreview = document.querySelector('#imagenPreview').firstChild.nextSibling;


  //evaluamos si la imagen no es la imagen por defecto(para mostrar el boton)
  if (!imagenPreview.src.endsWith('default.png')) {
    btnQuitarImagen.style.display = 'inline';
  }

  btnQuitarImagen.addEventListener('click', (e) => {
    e.preventDefault();
    document.querySelector('#imagen').value = '';
    document.querySelector('#imagenPreview')
      .innerHTML = "<img src='./app/Views/assets/images/default.png' class='border rounded m-1'   alt='' width='200px' />";

    btnQuitarImagen.style.display = 'none';



  });
</script>