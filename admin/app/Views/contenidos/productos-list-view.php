<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="d-flex justify-content-between">
            <h4 class="m-0">Productos</h4>
            <a href="?view=productos-new"><button class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Nuevo producto</button></a>
          </div>
         
        </div><!-- /.col -->

      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Datos de productos registrados. </h3>
            </div>
            <?php
            require_once('app/Controllers/ProductosController.php');
            $ProductoController = new ProductosController();
            $productos = $ProductoController->all_productos();


            ?>

            <!-- /.card-header -->
            <div class="card-body">

              <div class="table-responsive">
                              <table id="table_productos" class="table table-secondary  table-bordered table-hover">
                <thead class="bg-light">
                  <tr>
                    <th>N°</th>
                    <th>Nombre</th>
                    <th>Categoria</th>
                    <th>Precio compra</th>
                    <th>Precio venta</th>
                    <th>Stock</th>
                    <th>Código</th>
                    <th>Usuario</th>
                    <th>Imagen</th>
                    <th class="text-center">Acciones</th>
                  </tr>
                </thead>

                <tbody>
                  <?php
                  $contador = 0;
                  ?>


                  <?php
                  foreach ($productos as $producto):
                    $contador++;
                  ?>

                    <tr>
                      <td class="text-left "><?= $contador; ?></td>
                      <td><?= $producto['nombre_producto']; ?></td>
                      <td><?= $producto['nombre_categoria']; ?></td>
                      <td>$<?= $producto['precio_compra']; ?></td>
                      <td>$<?= $producto['precio_venta']; ?></td>
                      <td><?= $producto['stock']; ?></td>
                      <td><?= $producto['codigo']; ?></td>
                      <td><?= $producto['nombre_usuario']; ?></td>
                      <td><img class="" src="<?= SERVER_URL . 'admin/app/Views/assets/images_productos/' . ($producto['imagen'] != 'default.png' ? $producto['imagen'] : 'default.png'); ?>" alt="" height="28px" /></td>

                      <td class="text-center">
                        <div class="btn-group">

                          <a href="<?= SERVER_URL; ?>admin/?view=productos-edit/<?= $producto['id_producto']; ?>" class="btn btn-warning btn-sm"> <i class="fas fa-edit"></i></a>
                          <form action="<?= SERVER_URL; ?>admin/app/ajax/Productos_Ajax.php" method="post" class="formulario_ajax" data-form="delete" autocomplete="off">
                            <input type="hidden" name="delete" value="delete">
                            <input type="hidden" name="id" value="<?= $producto['id_producto']; ?>">
                            <button class="btn btn-danger btn-sm border" type="submit" title="Eliminar"><i class="fas fa-trash"></i></button>
                          </form>


                        </div>



                      </td>
                    </tr>

                  <?php endforeach; ?>
                </tbody>

              </table>
              </div>
            </div>
            <!-- /.card-body -->
          </div>

        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>



<script>
  $(function() {
    $("#table_productos").DataTable({
      "pageLength": 10,
      "language": {
        "emptyTable": "No hay información",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Productos",
        "infoEmpty": "Mostrando 0 a 0 de 0 Producto(s)",
        "infoFiltered": "(Filtrado de _MAX_ total Producto(s)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ Productos",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": "Buscador:",
        "zeroRecords": "Sin resultados encontrados",
        "paginate": {
          "first": "Primero",
          "last": "Ultimo",
          "next": "Siguiente",
          "previous": "Anterior"
        }
      },
      "responsive": true,
      "lengthChange": true,
      "autoWidth": false,
      buttons: []
    })

  });
</script>



