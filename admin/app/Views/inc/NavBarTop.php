  <nav class="main-header navbar navbar-expand navbar-white navbar-light sticky-top">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?= SERVER_URL; ?>admin/?view=panel" class="nav-link">Inicio</a>
      </li>
      <li class="nav-item  d-sm-inline-block">
        <a href="<?= SERVER_URL; ?>" class="nav-link" target="_blank">Ir a mi Tienda</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>




      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>

      <!-- BTN CERRAR SESSION-->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#" title="<?= $_SESSION['nombre']; ?>">
          <i class="far fa-user"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left">
          <span class="dropdown-item dropdown-header">Acciones</span>
          <div class="dropdown-divider"></div>
          <div class="text-center">
            <a href="<?= SERVER_URL; ?>admin/?view=usuarios-edit-me/" class="dropdown-item" id="btn_editar_perfil">Editar mi perfil</a>
          </div>
          <div class="text-center">
            <button class="dropdown-item" id="btn_logout">Cerrar sesion</button>
          </div>
        </div>
      </li>

    </ul>
  </nav>