<?php
$auth = false;
if (isset($_SESSION['nombre_cliente'])) {
    $auth = true;
}


$active = '';
if (isset($_GET['view'])) {
    $active = $_GET['view'];
}

?>

<nav class="navbar navbar-expand-md navbar-light bg-light sticky-top">
    <div class="container">
        <a class="navbar-brand" href="<?= SERVER_URL; ?>">
            <img src="./admin/app/Views/assets/images/logo.png" alt="Logo" height="32">
        </a>

        <!--formulario busqueda (sm)-->
        <div class=" d-flex d-md-none justify-content-between align-items-center">

            <form action="index.php?view=productos" method="post" class="d-flex justify-content-center align-items-center my-0 my-lg-0 mx-lg-2">
                <input class="form-control form-control-sm me-sm-2" type="search" name="buscar" placeholder="Buscar" value="<?= $_POST['buscar'] ?? ''; ?>" />
                <button class="btn btn-sm btn-outline-dark  border-none ml-2 mr-0 my-2 my-sm-0" type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div>

        <div class="d-flex">

            <a class="nav-link <?= ($active == 'carrito') ? 'active' : ''; ?>  d-md-none text-dark" href="<?= SERVER_URL; ?>index.php?view=carrito" title="Mi carrito">
                <i class="fas fa-cart-plus mr-1" id="icono_carrito_2"></i>
                <span class="badge bg-green2" id="badgeProductos_2"></span>
            </a>


            <button
                class="navbar-toggler d-lg-none"
                type="button"
                data-toggle="collapse"
                data-target="#collapsibleNavId"
                aria-controls="collapsibleNavId"
                aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>


        </div>



        <div class="collapse navbar-collapse " id="collapsibleNavId">

            <div id="nav_elements" class="col-12 d-md-flex justify-content-between ">



                <div class="nav_elements_01 d-flex flex-column flex-md-row ">

                    <ul class="navbar-nav me-auto mt-2 mt-lg-0">
                        <li class="nav-item">
                            <a class="nav-link <?= ($active == 'inicio') ? 'active' : ''; ?>" href="index.php?view=inicio" aria-current="page">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($active == 'productos') ? 'active' : ''; ?>" href="index.php?view=productos" aria-current="page">Productos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($active == 'nosotros') ? 'active' : ''; ?>" href="index.php?view=nosotros" aria-current="page">Nosotros</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($active == 'contacto') ? 'active' : ''; ?>" href="index.php?view=contacto" aria-current="page">Contacto</a>
                        </li>

                    </ul>







                    <ul class="navbar-nav me-auto mt-2 mt-lg-0">
                        <?php
                        if ($auth) {
                        ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Acciónes</a>

                                <div class="dropdown-menu" aria-labelledby="dropdownId">
                                    <a class="dropdown-item <?= ($active == 'mis-pedidos') ? 'active' : ''; ?>" href="index.php?view=mis-pedidos">Mis pedidos</a>


                                </div>
                            </li>
                        <?php }  ?>




                    </ul>


                    <!--formulario busqueda (lg)-->
                    <div class=" d-md-flex d-none   justify-content-between align-items-center">

                        <form action="index.php?view=productos" method="post" class="d-flex justify-content-center align-items-center my-0 my-lg-0 mx-lg-2">
                            <input class="form-control form-control-sm me-sm-2" type="search" name="buscar" placeholder="Buscar" value="<?= $_POST['buscar'] ?? ''; ?>" />
                            <button class="btn btn-sm btn-outline-dark  ml-2 mr-0 my-2 my-sm-0" type="submit"><i class="fa fa-search"></i></button>
                        </form>
                    </div>



                </div>







                <div class="nav_elements_02 ">
                    <ul class="navbar-nav me-auto mt-2 mt-lg-0">

                        <!-- CARRITO MENU -->
                        <li class="nav-item  d-none d-md-block">

                            <a class="nav-link <?= ($active == 'carrito') ? 'active' : ''; ?> " href="<?= SERVER_URL; ?>index.php?view=carrito" id="btn-carrito" title="Mi carrito">
                                <i class="fas fa-cart-plus mr-1 text-dark" id="icono_carrito"></i><span class="d-lg-inline-flex d-sm-none">Mi Carrito</span>
                                <span class="badge bg-green2  " id="badgeProductos"></span>
                            </a>


                            <div class="dropdown-menu dropdown-menu-right " style="width:250px" aria-labelledby="dropdownId" id="listado_carrito">


                            </div>
                        </li>

                        <!-- USER MENU -->
                        <li class="nav-item dropdown">

                            <a href="#" class="nav-link" id="dropdownUser" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="">
                                <i class="fas fa-user mr-1 text-dark" id="icono_user" aria-hidden="true"></i>
                                <?= (isset($_SESSION['nombre_cliente'])) ? ucfirst($_SESSION['nombre_cliente']) : 'Invitado'; ?>
                            </a>


                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownUser">

                                <?php if (isset($_SESSION['nombre_cliente'])) { ?>

                                    <button class="dropdown-item" id="btn_cerrar_sesion"><i class="fas fa-door-open text-dark mr-2"></i>Cerrar sesión</button>



                                <?php } else { ?>
                                    <a class="dropdown-item" href="index.php?view=login-cli"><i class="fas fa-door-open text-dark mr-2"></i>Iniciar sessión</a>
                                    <a class="dropdown-item" href="index.php?view=registro-cli"><i class="fa fa-user-plus text-dark mr-2"></i>Registrarse</a>


                                <?php } ?>


                            </div>
                        </li>



                        <!-- USER MENU -->

                    </ul>
                </div>



            </div>

        </div>
    </div>
</nav>