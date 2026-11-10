<?php
require_once('app/Controllers/PedidosController.php');


$PedidosController = new PedidosController();

if (isset($_GET['codigo']) || $_GET['codigo'] != '') {

  $codigo = $_GET['codigo'];
  $response = $PedidosController->get_pedido($codigo);

  if ($response['status'] == true) {

    $info_pedido = $response['info_pedido'];
    $cliente = $response['cliente'];
    $destinatario = $response['destinatario'];
    $productos = $response['productos'];
  } else {
    echo "<script>window.location.href='" . SERVER_URL . "/admin';</script>";
  }
} else {

  echo "<script>window.location.href='" . SERVER_URL . "/admin';</script>";
}

?>









<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row ">
        <div class="col-sm-6">
          <h4 class="m-0">Detalle de pedido (<?= $info_pedido['codigo'];  ?>)</h4>
         
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

        <!-- CARD INFO CLIENTE Y DESTINATARIO -->
        <div class="card">

          <div class="card-header bg-warning ">
            Desglose del pedido
          </div>


          <div class="card-body">

            <!-- Info pedido-->
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header bg-info">Información del Pedido </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-12">
                        <b>Estado: </b><span class="badge <?= ($info_pedido['estado'] == 'pendiente') ? 'bg-danger' : 'bg-success'; ?>  ?> px-2 py-2"><?= ucwords($info_pedido['estado']) ?></span> <br>
                        <b>Código: </b><?= $info_pedido['codigo'] ?> <br>
                        <b>Fecha: </b><?= $info_pedido['fecha'] ?> <br>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- END Info pedido-->


            <!-- tabla datos del cliente -->
            <div class="row">
              <div class="col-md-6">
                <div class="card">
                  <div class="card-header bg-info">Información del cliente</div>
                  <div class="card-body">
                    <b>Nombre:</b> <?= $cliente['cli_nombre']; ?><br>
                    <b>Email:</b> <?= $cliente['cli_email']; ?><br>
                    <b>Dirección:</b> <?= $cliente['cli_direccion']; ?><br>
                    <b>Teléfono:</b> <?= $cliente['cli_telefono']; ?><br>
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="card">
                  <div class="card-header bg-info">Información del Destinatario</div>
                  <div class="card-body">
                    <b>Nombre:</b> <?= $destinatario['des_nombre']; ?><br>
                    <b>Email:</b> <?= $destinatario['des_email']; ?><br>
                    <b>Dirección:</b> <?= $destinatario['des_direccion']; ?><br>
                    <b>Teléfono:</b> <?= $destinatario['des_telefono']; ?><br>
                  </div>
                </div>
              </div>
            </div>
            <!-- end tabla datos del cliente -->

            <div class="row">
              <div class="col-md-12">

                <!--  CARD PRODUCTOS-->
                <div class="card">
                  <div class="card-header bg-info">Detalle de productos</div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-12">
                        <div
                          class="table-responsive border ">
                          <table class="table table-secondary table-bordered table-hover">
                            <thead class="bg-light">
                              <tr>
                                <th scope="col">N°</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Codigo</th>
                                <th scope="col">Precio venta</th>
                                <th scope="col">Cantitdad</th>
                                <th scope="col">Precio total</th>

                              </tr>
                            </thead>
                            <tbody>
                              <?php
                              $contador = 0;
                              $total = 0;
                              foreach ($productos as $el) {
                                $total += $el['detp_precio_total'];
                              ?>

                                <tr class="">
                                  <td><?= ++$contador; ?></td>
                                  <td><?= ucwords($el['pr_nombre']); ?></td>
                                  <td><?= $el['pr_codigo']; ?></td>
                                  <td><b>$<?= number_format($el['detp_precio_venta'], 0, '', '.'); ?></b></td>
                                  <td><?= $el['detp_cantidad']; ?></td>
                                  <td><b>$<?= number_format($el['detp_precio_total'], 0, '', '.'); ?></b></td>
                                </tr>
                              <?php } ?>
                              <tr>
                                <td colspan="5" align="right" class="h5"><b>Total:</b></td>
                                <td class="h5"><b>$<?= number_format($total, 0, '', '.'); ?></b></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>

                      </div>
                    </div>

                  </div>
                </div>
                <!--  END CARD PRODUCTOS-->

              </div>
            </div>

          </div>

        </div>
        <!-- END CARD INFO CLIENTE Y DESTINATARIO -->




      </div>




    </div>






    <!-- /.content -->
    <div class="row">
      <div class="col-md-8 text-center">
        <a href="<?= SERVER_URL ?>admin/?view=pedidos-list" class="btn btn-success my-3 mx-auto"><i class="fa fa-arrow-left"></i> Listado de pedidos</a>
      </div>
    </div>
</div>