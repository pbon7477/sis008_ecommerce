<?php
if (!isset($_SESSION['id_cliente'])) {
    echo "<script>window.location.href='" . SERVER_URL . "';</script>";
}
?>
<?php
require_once('./front/Controllers/PedidosController.php');

$PedidosController = new PedidosController();
$pedidos = $PedidosController->all($_SESSION['id_cliente']);


?>

<div class="row">
    <div class="col-md-12">
        <div class="header-section">
        <div>
            <h5><i class="fa fa-cubes color sub-icon-blue mr-2"></i>Mis pedidos</h5>
            
            <p>Consulte el estado de sus pedidos</p>
        </div>    

        </div>

    </div>
</div>



<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-gradient-light">
                <h5>Pedidos registrados </h5>
            </div>

            <!-- /.card-header -->
            <div class="card-body">
                <table id="table_mis_pedidos" class="table table-bordered table-hover">
                    <thead class="bg-light">
                        <tr>
                            <th width="30px">N°</th>
                            <th class="text-left">Codigo</th>
                            <th class="text-left">Fecha</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $contador = 0;
                        ?>


                        <?php
                        foreach ($pedidos as $el):


                            $contador++;
                        ?>

                            <tr>
                                <td class="text-left"><?= $contador; ?></td>
                                <td class="text-left"><?= $el['codigo']; ?></td>
                                <td class="text-left"><?= $el['fecha']; ?></td>
                                <td class="text-center">

                                    <span class="badge bg-warning p-2"><?= ucwords($el['estado']); ?></span>
                                </td>

                                <td class="text-center">
                                    <div class="btn-group ">
                                        <form action="<?= SERVER_URL ?>index.php?view=pedido-detalle" method="POST">

                                            <input type="hidden" name="id_pedido" value="<?= $el['id']; ?>">
                                            <button type="submit" class="btn btn-success btn-sm border mr-1"><i class="fas fa-eye"></i> Vér detalle</button>

                                        </form>
                                        <a href="<?= SERVER_URL ?>front/descargar_comprobante.php?id_cli=<?= $_SESSION['id_cliente'] ?>&cp=<?= $el['codigo']; ?>" target="_blank"
                                            title="Descargar comprobante " class="btn btn-sm btn-warning border"><i class="fas fa-file-pdf"></i> Comprobante</a>


                                    </div>



                                </td>
                            </tr>


                        <?php endforeach; ?>
                    </tbody>

                </table>
            </div>
            <!-- /.card-body -->
        </div>

    </div>
    <!-- /.col -->
</div>

<br><br><br>












<script src="<?= SERVER_URL; ?>front/Views/assets/js/jquery.min.js"> </script>



<script>
    $(function() {
        $("#table_mis_pedidos").DataTable({
            "pageLength": 10,
            "language": {
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de (_TOTAL_ Pedidos)",
                "infoEmpty": "Mostrando 0 a 0 de 0 Pedido(s)",
                "infoFiltered": "(Filtrado de _MAX_ total Pedido(s)",
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