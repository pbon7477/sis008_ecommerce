<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row ">
        <div class="col-12">
          <div class="d-flex justify-content-between">
            <h4 class="m-0">Categorías</h4>
            <a href="?view=categorias-new"><button class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Nueva Categoría</button></a>
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
              <h3 class="card-title">Datos de categorías registradas. </h3>
            </div>
            <?php
            require_once('app/Controllers/CategoriasController.php');
            $CategoriaController = new CategoriasController();
            $categorias = $CategoriaController->all_categories();

            ?>

            <!-- /.card-header -->
            <div class="card-body">
              <div class="table-responsive">
                <table id="table_categorias" class="table table-secondary table-bordered table-hover">
                  <thead class="bg-light">
                    <tr>
                      <th width="30px">N°</th>
                      <th>Nombre</th>
                      <th>Descripción</th>

                      <th class="text-center">Acciones</th>
                    </tr>
                  </thead>

                  <tbody>
                    <?php
                    $contador = 0;
                    ?>


                    <?php
                    foreach ($categorias as $categoria):

                      $contador++;
                    ?>

                      <tr>
                        <td class="text-left"><?= $contador; ?></td>
                        <td><?= $categoria['nombre']; ?></td>
                        <td><?= $categoria['descripcion']; ?></td>

                        <td class="text-center">
                          <div class="btn-group">

                            <a href="<?= SERVER_URL; ?>admin/?view=categorias-edit/<?= $categoria['id']; ?>" class="btn btn-warning btn-sm border" title="Editar"><i class="fas fa-edit"></i></a>
                            <form action="<?= SERVER_URL; ?>admin/app/ajax/Categorias_Ajax.php" method="post" class="formulario_ajax" data-form="delete" autocomplete="off">
                              <input type="hidden" name="delete" value="delete">
                              <input type="hidden" name="id" value="<?= $categoria['id']; ?>">
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
    $("#table_categorias").DataTable({
      "pageLength": 10,
      "language": {
        "emptyTable": "No hay información",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Categorías",
        "infoEmpty": "Mostrando 0 a 0 de 0 Categoría(s)",
        "infoFiltered": "(Filtrado de _MAX_ total Categoría(s)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ Categorías",
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