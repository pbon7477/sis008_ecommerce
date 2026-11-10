<?php
require_once('app/Controllers/ClientesController.php');
$ClientesController = new ClientesController();
$clientes = $ClientesController->get_all_clientes();

?>



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="d-flex justify-content-between">
            <h4 class="m-0">Clientes</h4>
            <a href="?view=clientes-new"><button class="btn btn-primary btn-sm" disabled><i class="fas fa-plus"></i> Nuevo Cliente</button></a>
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
              <h3 class="card-title">Datos de clientes registrados. </h3>
            </div>

            <!-- /.card-header -->
            <div class="card-body">
              <div class="table-responsive">
                <table id="table_usuarios" class="table table-secondary table-bordered table-hover">
                  <thead class="bg-light">
                    <tr>
                      <th width="30px">N°</th>
                      <th>Nombre</th>
                      <th>Email</th>
                      <th>Dirección</th>
                      <th>Teléfono</th>
                      <th class="text-center">Acciones</th>
                    </tr>
                  </thead>

                  <tbody>
                    <?php
                    $contador = 0;
                    ?>


                    <?php
                    foreach ($clientes as $el):


                      $contador++;
                    ?>

                      <tr>
                        <td class="text-left"><?= $contador; ?></td>
                        <td><?= $el['nombre']; ?></td>
                        <td><?= $el['email']; ?></td>
                        <td><?= $el['direccion']; ?></td>
                        <td><?= $el['telefono']; ?></td>
                        <td class="text-center">
                          <div class="btn-group">

                            <a href="<?= SERVER_URL; ?>admin/?view=clientes-edit/<?= $el['id']; ?>" class="btn btn-warning btn-sm border" title="Editar"><i class="fas fa-edit"></i></a>
                            <form action="<?= SERVER_URL; ?>admin/app/ajax/Clientes_Ajax.php" method="post" class="formulario_ajax" data-form="delete" autocomplete="off">
                              <input type="hidden" name="delete" value="delete">
                              <input type="hidden" name="id" value="<?= $el['id']; ?>">
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
    $("#table_usuarios").DataTable({
      "pageLength": 10,
      "language": {
        "emptyTable": "No hay información",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Usuarios",
        "infoEmpty": "Mostrando 0 a 0 de 0 Usuario(s)",
        "infoFiltered": "(Filtrado de _MAX_ total Usuario(s)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ Usuarios",
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