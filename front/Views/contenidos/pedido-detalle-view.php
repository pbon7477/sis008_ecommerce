<?php
if (!isset($_SESSION['id_cliente'])) {
    echo "<script>window.location.href='" . SERVER_URL . "';</script>";
}


$id_pedido = $_POST['id_pedido'];
$id_cliente = $_SESSION['id_cliente'];

require_once('./front/Controllers/PedidosController.php');
$PedidosController = new PedidosController();
$data = $PedidosController->get_pedido_detalle($id_pedido, $id_cliente);

$cliente_y_destinatario = $data['cliente_y_destinatario'];
$cliente_y_destinatario = $cliente_y_destinatario[0];

$pedido_fecha = $cliente_y_destinatario['pedido_fecha'];
$pedido_codigo = $cliente_y_destinatario['pedido_codigo'];
$pedido_estado = $cliente_y_destinatario['pedido_estado'];

$productos = $data['productos'];






?>

<div class="row">
    <div class="col-md-12">
        <h3>Detalle de Pedido (<?= $pedido_codigo ?>)</h3>

        <div class="mb-3">
            <label for="" class="form-label"></label>
        </div>


    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-gradient-light">
                <div class="d-flex justify-content-between ">
                    <h5>Información del pedido</h5>
                    <a href="<?= SERVER_URL ?>front/descargar_comprobante.php?id_cli=<?= $_SESSION['id_cliente'] ?>&cp=<?= $pedido_codigo; ?>" target="_blank"
                        title="Descargar comprobante " class="btn btn-sm btn-warning border"><i class="fas fa-file-pdf"></i> Descargar Comprobante</a>
                </div>

            </div>
            <div class="card-body">
                <p><b>Codigo: </b><?= $pedido_codigo; ?></p>
                <p><b>Fecha: </b><?= $pedido_fecha; ?></p>
                <p><b>Estado: </b> <span class="badge bg-warning p-2"> <?= ucwords($pedido_estado); ?></span></p>

            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-gradient-light">
                <h5>Cliente</h5>
            </div>
            <div class="card-body">
                <b>Nombre: </b><?= $cliente_y_destinatario['cliente_nombre']; ?><br><b></b>
                <b>Dirección: </b><?= $cliente_y_destinatario['cliente_direccion']; ?><br>
                <b>Teléfono: </b><?= $cliente_y_destinatario['cliente_telefono']; ?><br>
                <b>Email: </b><?= $cliente_y_destinatario['cliente_email']; ?><br>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-gradient-light">
                <h5>Destinatario</h5>
            </div>
            <div class="card-body">
                <b>Nombre: </b><?= $cliente_y_destinatario['destinatario_nombre']; ?><br><b></b>
                <b>Dirección: </b><?= $cliente_y_destinatario['destinatario_direccion']; ?><br>
                <b>Teléfono: </b><?= $cliente_y_destinatario['destinatario_telefono']; ?><br>
                <b>Email: </b><?= $cliente_y_destinatario['destinatario_email']; ?><br>
            </div>
        </div>
    </div>
</div>

<div class="row">

    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-gradient-light">
                <h5>Productos</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive-md table-bordered">
                    <table class="table table-hover table-group-divider table-active ">
                        <thead class="bg-gradient-light">
                            <tr>
                                <th scope="col">N°</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Cantidad</th>
                                <th scope="col">Precio</th>
                                <th scope="col">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $contador = 0;
                            $sub_total = 0;

                            foreach ($productos as $el) {
                                $sub_total += $el['det_ped_precio_total'];
                            ?>
                                <tr class="">
                                    <td scope="row"><?= ++$contador; ?></td>
                                    <td><?= ucfirst($el['producto_nombre']); ?></td>
                                    <td><?= $el['det_ped_cantidad']; ?></td>
                                    <td>$<?= $el['producto_precio_venta']; ?></td>
                                    <td>$<?= $el['det_ped_precio_total']; ?></td>

                                </tr>

                            <?php  } ?>

                            <tr class="">
                                <td colspan="3"></td>
                                <td><b>Total:</b></td>
                                <td><b>$<?= $sub_total; ?></b></td>

                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>
</div>

<div class="row">
    <div class="col-md-12 mb-5">
        <a href="<?= SERVER_URL; ?>index.php?view=mis-pedidos" class="btn btn-warning"><i class="fa fa-arrow-circle-left"></i> Volver a mis pedidos</a>
    </div>
</div>