<?php
$seccion = $_GET['view'];
$segments = explode('-', $seccion);
$modulo = $segments[0];

?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="#" class="brand-link">
    <img src="app/Views/assets/images/logo.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">Mi Tienda</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-1 py-1 mb-3 d-flex">
      <div class="image">

      </div>
      <div class="info">
        <a href="#" class="d-block"><?= ucwords($_SESSION['nombre']); ?></a>
      </div>
    </div>

    <!-- SidebarSearch Form -->
    <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sm form-control-sidebar" type="search" placeholder="Buscar" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sm btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->





        <!-- //MENU USUARIOS -->
        <li class="nav-item ">
          <a href="#" class="nav-link <?= ($modulo == 'usuarios') ? 'active-section' : ''; ?> ">
            <i class="nav-icon fas fa-users "></i>
            <p>
              Usuarios
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">

            <li class="nav-item">
              <a href="?view=usuarios-list" class="nav-link <?= ($_GET['view'] == 'usuarios-list') ? 'active' : ''; ?>">
                <i class="fas fa-list nav-icon"></i>
                <p>Listado de usuarios</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="?view=usuarios-new" class="nav-link <?= ($_GET['view'] == 'usuarios-new') ? 'active' : ''; ?>">
                <i class="fas fa-plus nav-icon"></i>
                <p>Nuevo Usuario</p>
              </a>
            </li>



          </ul>
        </li>

        <!-- //MENU CATEGORIAS -->
        <li class="nav-item ">
          <a href="#" class="nav-link <?= ($modulo == 'categorias') ? 'active-section' : ''; ?> ">
            <i class="nav-icon fas fa-tags "></i>
            <p>
              Categorias
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">

            <li class="nav-item">
              <a href="?view=categorias-list" class="nav-link <?= ($_GET['view'] == 'categorias-list') ? 'active' : ''; ?> ">
                <i class="fas fa-list nav-icon"></i>

                <p>Listado de categorias</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="?view=categorias-new" class="nav-link <?= ($_GET['view'] == 'categorias-new') ? 'active' : ''; ?> ">
                <i class="fas fas fa-plus nav-icon"></i>
                <p>Nueva categoria</p>
              </a>
            </li>
          </ul>
        </li>

        <!-- //MENU PRODUCTOS -->
        <li class="nav-item ">
          <a href="#" class="nav-link <?= ($modulo == 'productos') ? 'active-section' : ''; ?>">
            <i class="nav-icon fas fa-box "></i>
            <p>
              Productos
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">

            <li class="nav-item">
              <a href="?view=productos-list" class="nav-link <?= ($_GET['view'] == 'productos-list') ? 'active' : ''; ?> ">
                <i class="fas fa-list nav-icon"></i>
                <p>Listado de productos</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="?view=productos-new" class="nav-link <?= ($_GET['view'] == 'productos-new') ? 'active' : ''; ?> ">
                <i class="fas fas fa-plus nav-icon"></i>
                <p>Nuevo producto</p>
              </a>
            </li>
          </ul>
        </li>

        <!-- //MENU VENTAS -->
        <li class="nav-item ">
          <a href="#" class="nav-link <?= ($modulo == 'ventas') ? 'active-section' : ''; ?>">
            <i class="nav-icon fas fa-shopping-cart "></i>
            <p>
              Ventas
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">

            <li class="nav-item">
              <a href="?view=ventas-list" class="nav-link <?= ($_GET['view'] == 'ventas-list') ? 'active' : ''; ?>">
                <i class="fas fa-list nav-icon"></i>
                <p>Listado de ventas</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="?view=ventas-new" class="nav-link <?= ($_GET['view'] == 'ventas-new') ? 'active' : ''; ?>">
                <i class="fas fa-plus nav-icon"></i>
                <p>Nueva venta</p>
              </a>
            </li>

          </ul>
        </li>


        <!-- //MENU PEDIDOS -->
        <li class="nav-item ">
          <a href="#" class="nav-link <?= ($modulo == 'pedidos') ? 'active-section' : ''; ?>">
            <i class="nav-icon fas fa-clipboard-list"></i>
            <p>
              Pedidos
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">

            <li class="nav-item">
              <a href="?view=pedidos-list" class="nav-link <?= ($_GET['view'] == 'pedidos-list') ? 'active' : ''; ?>">
                <i class="fas fa-list nav-icon"></i>
                <p>Listado de pedidos</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="?view=pedidos-new" class="nav-link <?= ($_GET['view'] == 'pedidos-new') ? 'active' : ''; ?>">
                <i class="fas fa-plus nav-icon"></i>
                <p>Nueva pedido</p>
              </a>
            </li>

          </ul>
        </li>


        <!-- //MENU CLIENTES -->
        <li class="nav-item ">
          <a href="#" class="nav-link <?= ($modulo == 'clientes') ? 'active-section' : ''; ?> ">
            <i class="nav-icon fas fa-address-book"></i>
            <p>
              Clientes
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">

            <li class="nav-item">
              <a href="?view=clientes-list" class="nav-link <?= ($_GET['view'] == 'clientes-list') ? 'active' : ''; ?>">
                <i class="fas fa-list nav-icon"></i>
                <p>Listado de clientes</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="?view=clientes-new" class="nav-link <?= ($_GET['view'] == 'clientes-new') ? 'active' : ''; ?>">
                <i class="fas fa-plus nav-icon"></i>
                <p>Nuevo Cliente</p>
              </a>
            </li>


          </ul>
        </li>

        <div class="dropdown-divider"></div>

        <!-- //MENU MENSAJES -->
        <li class="nav-item ">
          <a href="#" class="nav-link <?= ($modulo == 'mensajes') ? 'active-section' : ''; ?> ">
            <i class="nav-icon fas fa-paper-plane"></i>
            <p>
              Mensajes
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">

            <li class="nav-item">
              <a href="?view=mensajes-list" class="nav-link <?= ($_GET['view'] == 'mensajes-list') ? 'active' : ''; ?>">
                <i class="fas fa-list nav-icon"></i>
                <p>Listado de mensajes</p>
              </a>
            </li>


          </ul>
        </li>



        <!-- //MENU CAROUSEL -->
        <li class="nav-item ">
          <a href="#" class="nav-link <?= ($modulo == 'carousel-admin') ? 'active-section' : ''; ?> ">
            <i class="nav-icon fas fa-images "></i>
            <p>

              <i class="right fas fa-angle-left"></i>
              Carousel
            </p>
          </a>
          <ul class="nav nav-treeview">

            <li class="nav-item">
              <a href="?view=carousel-admin" class="nav-link <?= ($_GET['view'] == 'carousel-admin') ? 'active' : ''; ?>">
                <i class="fas fa-cog nav-icon"></i>
                <p>Editar carousel </p>
              </a>
            </li>


          </ul>

        </li>

      </ul>







    </nav>
    <!-- /.sidebar-menu -->

  </div>
  <!-- /.sidebar -->
</aside>