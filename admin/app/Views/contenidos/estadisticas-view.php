<?php

require_once('./app/Controllers/PedidosController.php');
require_once('./app/Controllers/ClientesController.php');
$PedidosController = new PedidosController();
$ClientesController = new ClientesController();

$row_pedidos_dia = $PedidosController->pedidos_por_dia();


$label_pedidos = '';
$datos_pedidos = '';

foreach ($row_pedidos_dia as $i => $el) {

  $label_pedidos .= "'" . date_format(date_create($el['fecha']), 'd-m') . "',";
  $datos_pedidos .= "'" . ($el['total_pedidos']) . "',";
}

$label_pedidos = rtrim($label_pedidos, ',');
$datos_pedidos = rtrim($datos_pedidos, ',');





?>
<script>
  let label_pedidos = [<?= $label_pedidos; ?>];
  let datos_pedidos = [<?= $datos_pedidos;  ?>];
</script>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row ">
        <div class="col-sm-6">
          <h4 class="m-0">Inicio </h4>
          
        </div><!-- /.col -->

      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <h3><?= $PedidosController->get_numero_pedidos(); ?></h3>

              <p>Pedidos</p>
              <small>Pedidos de los ultimos 7 días (<?= $PedidosController->get_numero_pedidos_7_last_days(); ?>)</small>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="?view=pedidos-list" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-success">
            <div class="inner">
              <h3><?= $ClientesController->get_numero_clientes(); ?></h3>

              <p>Clientes</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="?view=clientes-list" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-warning">
            <div class="inner">
              <h3>44</h3>

              <p>User Registrations</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-danger">
            <div class="inner">
              <h3>65</h3>

              <p>Unique Visitors</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-md-12 connectedSortable">
          <!-- Custom tabs (Charts with tabs)-->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">
                <i class="fas fa-chart-pie mr-1"></i>
                Pedidos
              </h3>

            </div><!-- /.card-header -->
            <div class="card-body">
              <div class="tab-content p-0">
                <!-- Morris chart - Sales -->
                <div class="chart tab-pane active" id="revenue-chart"
                  style="position: relative; height: 300px;">
                  <canvas id="revenue-chart-canvas" height="300" style="height: 300px;"></canvas>
                </div>
                <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;">
                  <canvas id="sales-chart-canvas" height="300" style="height: 300px;"></canvas>
                </div>
              </div>
            </div><!-- /.card-body -->
          </div>
          <!-- /.card -->




        </section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-5 connectedSortable">

          <!-- Map card -->

          <!-- /.card -->

          <!-- solid sales graph -->

          <!-- /.card -->

          <!-- Calendar -->

          <!-- /.card -->
        </section>
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>





<!-- ///ESTO VA A ESTADISTICAS -->
<!-- JQVMap -->

<script src="app/Views/AdminLTE/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="app/Views/AdminLTE/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>

<!--  AdminLTE dashboard demo (This is only for demo purposes)  -->
<script src="app/Views/AdminLTE/dist/js/pages/dashboard.js"></script>

<!-- /// ESTO VA A ESTADISTICAS  -->