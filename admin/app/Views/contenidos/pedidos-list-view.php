<?php
require_once('app/Controllers/PedidosController.php');
$PedidosController = new PedidosController();
$pedidos = $PedidosController->get_all_pedidos();

?>



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row ">
        <div class="col-12">
          <div class="d-flex justify-content-between">
            <h4 class="m-0">Pedidos</h4>
            <a href="?view=clientes-new"><button class="btn btn-primary btn-sm" disabled><i class="fas fa-plus"></i> Nuevo Pedido</button></a>
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
              <h3 class="card-title">Datos de pedidos registrados. </h3>
            </div>

            <!-- /.card-header -->
            <div class="card-body">
<div class="table-responsive">
                <table id="table_pedidos" class="table table-secondary table-bordered table-hover ">
                <thead class="bg-light">
                  <tr>
                    <th width="30px">N°</th>
                    <th>Cliente</th>
                    <th>Destinatario</th>
                    <th>Fecha</th>
                    <th>Código</th>
                    <th>Estado</th>
                    <th class="text-center">Acciones</th>
                  </tr>
                </thead>

                <tbody>
                  <?php
                  $contador = 0;
                  ?>


                  <?php
                  foreach ($pedidos as $el) {


                    $contador++;
                  ?>

                    <tr>
                      <td class="text-left"><?= $contador; ?></td>
                      <td><?= $el['cli_nombre']; ?></td>
                      <td><?= $el['des_nombre']; ?></td>
                      <td><?= $el['ped_fecha']; ?></td>
                      <td><?= $el['ped_codigo']; ?></td>
                      <td><span class="badge <?= ($el['ped_estado'] == 'pendiente') ? 'bg-danger' : 'bg-success'; ?> p-2"><?= ucwords($el['ped_estado']); ?></span></td>

                      <td class="text-center">
                        <div class="btn-group">

                          <a href="<?= SERVER_URL; ?>admin/?view=pedidos-show&codigo=<?= $el['ped_codigo']; ?>" class="btn btn-success btn-sm border" title="Vér pedido"><i class="fas fa-eye"></i></a>
                          <a href="<?= SERVER_URL; ?>admin/?view=pedidos-edit/<?= $el['id']; ?>" class="btn btn-warning btn-sm border" title="Editar"><i class="fas fa-edit"></i></a>
                          <form action="<?= SERVER_URL; ?>admin/app/ajax/Pedidos_Ajax.php" method="post" class="formulario_ajax" data-form="delete" autocomplete="off">
                            <input type="hidden" name="delete" value="delete">
                            <input type="hidden" name="id" value="<?= $el['id']; ?>">
                            <button class="btn btn-danger btn-sm border" type="submit" title="Eliminar"><i class="fas fa-trash"></i></button>
                          </form>

                        </div>



                      </td>
                    </tr>


                  <?php } ?>
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
    $("#table_pedidos").DataTable({
      "pageLength": 10,
      "language": {
        "emptyTable": "No hay información",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Pedidos",
        "infoEmpty": "Mostrando 0 a 0 de 0 Pedido(s)",
        "infoFiltered": "(Filtrado de _MAX_ total pedido(s)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ Pedidos",
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