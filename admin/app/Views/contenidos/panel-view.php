<?php

require_once('./app/Controllers/UserController.php');
require_once('./app/Controllers/CategoriasController.php');

require_once('./app/Controllers/ProductosController.php');
require_once('./app/Controllers/VentasController.php');

require_once('./app/Controllers/ClientesController.php');
require_once('./app/Controllers/PedidosController.php');

$UserController = new UserController();
$CategoriasController = new CategoriasController();

$ProductosController = new ProductosController();
$VentasController = new VentasController();

$ClientesController = new ClientesController();
$PedidosController = new PedidosController();




?>


<div class="content-wrapper">

  <div class="content-header">
    <div class="container-fluid">
      <div class="row ">
        <div class="col-12">
          <div class="">
            <h4 class="m-0">Administrador </h4>
            <p>Contenidos de los Modulos</p>


          </div>
        </div>

      </div>
    </div>
  </div>


  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">


      <div class="row">

        <!-- USUARIOS -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-success">
            <div class="inner">
              <h3><?= $UserController->get_numero_usuarios(); ?></h3>

              <p>Usuarios</p>
            </div>
            <div class="icon">
              <i class="fa fa-users"></i>
            </div>
            <a href="?view=usuarios-list" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <!-- CATEGORÍAS -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-warning">
            <div class="inner">
              <h3><?= $CategoriasController->get_numero_categorias(); ?></h3>

              <p>Categorías</p>
            </div>
            <div class="icon">
              <i class="fa fa-tags"></i>
            </div>
            <a href="?view=categorias-list" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <!-- PRODUCTOS -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-danger">
            <div class="inner">
              <h3><?= $ProductosController->get_numero_productos(); ?></h3>

              <p>Productos</p>
            </div>
            <div class="icon">
              <i class="fa fa-box"></i>
            </div>
            <a href="?view=productos-list" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <!-- VENTAS -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-primary">
            <div class="inner">
              <h3><?= $VentasController->get_numero_ventas(); ?></h3>

              <p>Ventas</p>
            </div>
            <div class="icon">
              <i class="fa fa-shopping-cart"></i>
            </div>
            <a href="?view=ventas-list" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <!-- PEDIDOS -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <h3><?= $PedidosController->get_numero_pedidos(); ?></h3>

              <p>Pedidos</p>
              <small>Pedidos de los ultimos 7 días (<?= $PedidosController->get_numero_pedidos_7_last_days(); ?>)</small>
            </div>
            <div class="icon">
              <i class="fa fa-clipboard-list"></i>
            </div>
            <a href="?view=pedidos-list" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->

        <!-- CLIENTES -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <h3><?= $ClientesController->get_numero_clientes(); ?></h3>

              <p>Clientes</p>
            </div>
            <div class="icon">
              <i class="fa fa-address-book"></i>
            </div>
            <a href="?view=clientes-list" class="small-box-footer">Más información <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>





      </div>

    </div>
  </section>

</div>