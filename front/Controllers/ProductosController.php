<?php

require_once('./front/Models/ProductosModel.php');


class ProductosController  extends ProductosModel
{


    public function getAllProductos()
    {
        //Consulta para obtener la cantidad de registros ( filas )
        $sql = "SELECT * FROM productos";
        $resultados = MainModel::ejecutar_consulta_simple($sql);


        $numero_de_filas = $resultados->rowCount();
        $tamagno_paginas = 12;

        if (isset($_GET['pagina'])) {

            if ($_GET['pagina'] <= 0) {
                $pagina = 1;
            } else {
                $pagina = $_GET['pagina'];
            }
        } else {
            $pagina = 1;
        }

        $total_paginas = ceil($numero_de_filas / $tamagno_paginas);

        $empezar_desde = ($pagina - 1) * $tamagno_paginas;

        //consulta de los registros
        $sql = "SELECT * FROM productos LIMIT " . $empezar_desde . "," . $tamagno_paginas . ";";
        $query = MainModel::ejecutar_consulta_simple($sql);
        $productos = $query->fetchAll(PDO::FETCH_ASSOC);

        $url_images = "./admin/app/Views/assets/images_productos/";

        echo "<div class='row'>";

        if ($pagina > $total_paginas) {
            echo "<div class='col-12 text-center' style='height:77dvh;' >
            <p class=''>No hay registros que mostrar.</p>
            <a href='index.php?view=productos' class='btn btn-sm btn-primary mt-3'>Ir al listado de productos</a>
            </div>";
        } else {

            foreach ($productos as $prod) {
                echo "<div class='col-6 col-sm-6 col-md-4 col-lg-3 col-xl-2 ' >

                                    <div class='card border-primary'>
                                        <a href='index.php?view=detalle-producto&id=" . $prod['id'] . "'>
                                        <div class='img-container'>

                                       
                                        <img  class=' img-fluid ' 
                                        src='" . $url_images . ($prod['imagen'] == 'default.png' ? '../images/default.png' : $prod['imagen']) . "' 
                                        alt='" . $prod['nombre'] . "' title='Ver detalle'
                                        data-id='" . $prod['id'] . "'
                                        /> 
                                        </div>
                                        </a>    
                                        
                                    <div class='card-body'>
                                        <h6 class='product_name'>" . ucfirst($prod['nombre']) . "</h6>
                                        <p class='card-text product-price'>Precio: <b>$" . $prod['precio_venta'] . "</b></p>                      
                                        
                                       

                                        <a href='#' class='btn btn-xs btn-outline-dark small mt-0 mt-md-0 mt-lg-0 mt-xl-1 ' id='btnAgregarAlCarritoFront'  
                                            data-id='" . $prod['id'] . "'                                         



                                        ><i class='fas fa-plus'></i> Agregar al carrito</a>

                                    </div>
                                    </div>

                                </div>";
            }

            echo " </div>";

            echo "<div class='row'>";
            echo "  <div class='col-12 d-flex justify-content-center'>";


            echo "<nav aria-label='Page navigation' >
                            <ul class='pagination ' >
                                <li class='page-item " . ($pagina == 1 ? 'disabled' : '') . "'>
                                    <a class='page-link' href='index.php?view=productos&pagina=" . ($pagina - 1) . "' aria-label='Previous'>
                                        <span aria-hidden='true'>&laquo;</span>
                                    </a>
                                </li>";

            for ($i = 1; $i <= $total_paginas; $i++) {

                echo "       <li class='page-item " . ($pagina == $i ? 'active' : '') . "' aria-current='page' >
                                <a class='page-link' href='index.php?view=productos&pagina=" . $i . "' >" . $i . "</a>
                                </li>";
            }
            echo "       <li class='page-item " . ($pagina == $total_paginas ? 'disabled' : '') . " '>
                                    <a class='page-link' href='index.php?view=productos&pagina=" . ($pagina + 1) .  "' aria-label='Next'>
                                        <span aria-hidden='true'>&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>";

            echo "  </div>";
            echo "</div>";
            echo "<div class=''>Página (" . $pagina . ") de (" . $numero_de_filas . ") productos.</div>";
        }
    }



    public function getCategoriasProductos()
    {
        $sql = "SELECT * FROM categorias ORDER BY nombre asc;";
        $respuesta = MainModel::ejecutar_consulta_simple($sql);
        $categorias = $respuesta->fetchAll(PDO::FETCH_ASSOC);
        return $categorias;
    }


    public function getAllProductosPorCategorias()
    {

        $categoria_id = MainModel::limpiar_cadena($_GET['categoria']);

        //Consulta para obtener la cantidad de registros ( filas )
        $sql = "SELECT id FROM productos WHERE categoria_id = '" . $categoria_id . "';";
        $resultados = MainModel::ejecutar_consulta_simple($sql);


        $numero_de_filas = $resultados->rowCount();
        $tamagno_paginas = 12;

        if (isset($_GET['pagina'])) {

            if ($_GET['pagina'] <= 0) {
                $pagina = 1;
            } else {
                $pagina = $_GET['pagina'];
            }
        } else {
            $pagina = 1;
        }

        $total_paginas = ceil($numero_de_filas / $tamagno_paginas);

        $empezar_desde = ($pagina - 1) * $tamagno_paginas;

        //consulta de los registros
        $sql = "SELECT * FROM productos WHERE categoria_id = '" . $categoria_id . "' LIMIT " . $empezar_desde . "," . $tamagno_paginas . ";";
        $query = MainModel::ejecutar_consulta_simple($sql);
        $productos = $query->fetchAll(PDO::FETCH_ASSOC);

        $url_images = "./admin/app/Views/assets/images_productos/";

        echo "<div class='row'>";

        if ($pagina > $total_paginas) {
            echo "<div class='col-12 text-center' style='height:77dvh;' >
            <p class=''>No hay registros que mostrar.</p>
            <a href='index.php?view=productos' class='btn btn-sm btn-primary mt-3'>Ir al listado de productos</a>
            </div>";
        } else {

            foreach ($productos as $prod) {
                echo "<div class='col-6 col-sm-6 col-md-4 col-lg-3 col-xl-2 ' >

                                    <div class='card border-primary'>
                                        <a href='index.php?view=detalle-producto&id=" . $prod['id'] . "'>
                                        <div class='img-container'>
                                            <img  class='img-fluid' 
                                            src='" . $url_images . ($prod['imagen'] == 'default.png' ? '../images/default.png' : $prod['imagen']) . "' 
                                                alt='" . $prod['nombre'] . "' title='Ver detalle'
                                                data-id='" . $prod['id'] . "'
                                                /> 
                                        </div>
                                        </a>

                                    <div class='card-body'>
                                        <h6 class='product_name'>" . ucfirst($prod['nombre']) . "</h6>
                                        <p class='card-text'>Precio: <b>$" . $prod['precio_venta'] . "</b></p>                      
                                        
                                        
                                       
                                        <a href='#' class='btn btn-xs btn-outline-dark small mt-0 mt-md-0 mt-lg-0 mt-xl-1 ' id='btnAgregarAlCarritoFront'  
                                            data-id='" . $prod['id'] . "'                                       



                                        ><i class='fas fa-plus '></i> Agregar al carrito</a>

                                    </div>
                                    </div>

                                </div>";
            }

            echo " </div>";

            echo "<div class='row'>";
            echo "  <div class='col-12 d-flex justify-content-center'>";


            echo "<nav aria-label='Page navigation ' >
                            <ul class='pagination ' >
                                <li class='page-item " . ($pagina == 1 ? 'disabled' : '') . "'>
                                    <a class='page-link' href='index.php?view=productos&pagina=" . ($pagina - 1) . "&categoria=" . $categoria_id . "' aria-label='Previous'>
                                        <span aria-hidden='true'>&laquo;</span>
                                    </a>
                                </li>";

            for ($i = 1; $i <= $total_paginas; $i++) {

                echo "       <li class='page-item " . ($pagina == $i ? 'active' : '') . "' aria-current='page' >
                                <a class='page-link' href='index.php?view=productos&pagina=" . $i . "&categoria=" . $categoria_id . "' >" . $i . "</a>
                                </li>";
            }
            echo "       <li class='page-item " . ($pagina == $total_paginas ? 'disabled' : '') . " '>
                                    <a class='page-link' href='index.php?view=productos&pagina=" . ($pagina + 1) .  "&categoria=" . $categoria_id . "' aria-label='Next'>
                                        <span aria-hidden='true'>&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>";

            echo "  </div>";
            echo "</div>";
            echo "<div class=''>Página (" . $pagina . ") de (" . $numero_de_filas . ") productos.</div>";
        }
    }


    public function buscarProducto()
    {
        $buscar = MainModel::limpiar_cadena($_POST['buscar']);

        //Consulta para obtener la cantidad de registros ( filas )
        $sql = "SELECT id FROM productos WHERE nombre LIKE '%" . $buscar . "%';";
        $resultados = MainModel::ejecutar_consulta_simple($sql);


        $numero_de_filas = $resultados->rowCount();
        $tamagno_paginas = 12;

        if (isset($_GET['pagina'])) {

            if ($_GET['pagina'] <= 0) {
                $pagina = 1;
            } else {
                $pagina = $_GET['pagina'];
            }
        } else {
            $pagina = 1;
        }

        $total_paginas = ceil($numero_de_filas / $tamagno_paginas);

        $empezar_desde = ($pagina - 1) * $tamagno_paginas;

        //consulta de los registros
        $sql = "SELECT * FROM productos WHERE nombre LIKE '%" . $buscar . "%' 
                LIMIT " . $empezar_desde . "," . $tamagno_paginas . ";";

        $query = MainModel::ejecutar_consulta_simple($sql);
        $productos = $query->fetchAll(PDO::FETCH_ASSOC);

        $url_images = "./admin/app/Views/assets/images_productos/";

        echo "<div class='row'>";

        if ($pagina > $total_paginas) {
            echo "<div class='col-12 text-center' style='height:77dvh;' >
            <p class=''>No hay registros que mostrar.</p>
            <a href='index.php?view=productos' class='btn btn-sm btn-primary mt-3'>Ir al listado de productos</a>
            </div>";
        } else {

            foreach ($productos as $prod) {
                echo "<div class='col-6 col-sm-6 col-md-4 col-lg-3 col-xl-2 ' >

                                    <div class='card border-primary'>
                                        <a href='index.php?view=detalle-producto&id=" . $prod['id'] . "'>
                                        <div class='img-container'>
                                        <img  class=' img-fluid ' 
                                        src='" . $url_images . ($prod['imagen'] == 'default.png' ? '../images/default.png' : $prod['imagen']) . "' 
                                        alt='" . $prod['nombre'] . "' title='Ver detalle'
                                        data-id='" . $prod['id'] . "'
                                        /> 
                                        </div>
                                        </a>

                                    <div class='card-body'>
                                        <h6 class='product_name'>" . ucfirst($prod['nombre']) . "</h6>
                                        <p class='card-text'>Precio: <b>$" . $prod['precio_venta'] . "</b></p>                      
                                        
                                    

                                        <a href='#' class='btn btn-xs btn-outline-dark small mt-0 mt-md-0 mt-lg-0 mt-xl-1 ' id='btnAgregarAlCarritoFront'  
                                            data-id='" . $prod['id'] . "'                                     



                                        ><i class='fas fa-plus'></i> Agregar al carrito</a>

                                    </div>
                                    </div>

                                </div>";
            }

            echo " </div>";

            echo "<div class='row'>";
            echo "  <div class='col-12 d-flex justify-content-center'>";


            echo "<nav aria-label='Page navigation' >
                            <ul class='pagination ' >
                                <li class='page-item " . ($pagina == 1 ? 'disabled' : '') . "'>
                                    <a class='page-link' href='index.php?view=productos&pagina=" . ($pagina - 1) . "' aria-label='Previous'>
                                        <span aria-hidden='true'>&laquo;</span>
                                    </a>
                                </li>";

            for ($i = 1; $i <= $total_paginas; $i++) {

                echo "       <li class='page-item " . ($pagina == $i ? 'active' : '') . "' aria-current='page' >
                                <a class='page-link' href='index.php?view=productos&pagina=" . $i . "' >" . $i . "</a>
                                </li>";
            }
            echo "       <li class='page-item " . ($pagina == $total_paginas ? 'disabled' : '') . " '>
                                    <a class='page-link' href='index.php?view=productos&pagina=" . ($pagina + 1) . "' aria-label='Next'>
                                        <span aria-hidden='true'>&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>";

            echo "  </div>";
            echo "</div>";
            echo "<div class=''>Página (" . $pagina . ") de (" . $numero_de_filas . ") productos.</div>";
        }
    }


    public function getProducto()
    {
        $id = MainModel::limpiar_cadena($_GET['id']);

        $producto = ProductosModel::get_producto($id);
        return $producto;
    }


    
}
