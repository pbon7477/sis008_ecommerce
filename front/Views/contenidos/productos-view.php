        <?php
        require_once('./front/Controllers/ProductosController.php');
        $ProductosControler = new ProductosController();
        $categorias = $ProductosControler->getCategoriasProductos();

        ?>


        <div class="row">
            <div class="col-md-12">



                <div class="header-section ">



                    <div>
                        <h5><i class="fa fa-cubes sub-icon-blue mr-2"></i>Productos</h5>
                        <p>Explore nuestro catálogo</p>
                    </div>

                    <div>
                        <label for="" class="form-label">Categoria:</label>
                        <select class="select-categoria" name="categoria" id="categoria" value="">

                            <option value="">--Seleccione una categoria--</option>

                            <?php

                            if (!isset($_GET['categoria'])) {
                                $categoria_seleccionada = false;
                            } else {
                                $categoria_seleccionada = $_GET['categoria'];
                            }

                            foreach ($categorias as $categoria) {
                            ?>
                                <option value=" <?= $categoria['id']; ?>" <?php echo ($categoria['id'] == $categoria_seleccionada) ? 'selected' : ''; ?>>
                                    <?= $categoria['nombre']; ?>
                                </option>

                            <?php } ?>
                        </select>
                    </div>



                </div>





                <?php

                if (!isset($_GET['categoria']) && empty($_POST['buscar'])) {
                    $ProductosControler->getAllProductos();
                }

                if (isset($_GET['categoria']) && !empty($_GET['categoria'])) {
                    $ProductosControler->getAllProductosPorCategorias();
                }

                if (isset($_GET['categoria']) && empty($_GET['categoria'])) {
                    echo '<div>Debe seleccionar una <b>categoría</b> para cargar los productos que busca.</div>';
                    $ProductosControler->getAllProductos();
                }

                if (isset($_POST['buscar']) && !empty($_POST['buscar'])) {
                    $ProductosControler->buscarProducto();
                }





                ?>



            </div>
        </div>

        <br><br><br>


        <script>
            let categoriaSelect = document.querySelector('#categoria');
            categoriaSelect.addEventListener('change', (e) => {
                let id_Categoria = e.target.value;
                window.location.href = `index.php?view=productos&categoria=${id_Categoria}`;
            })
        </script>







        <!-- Check productos seleccionados en carrito actual-->
        <script>
            check_producto_seleccionado_carrito_actual();




            function check_producto_seleccionado_carrito_actual() {
                let resultado = null;

                fetch('./front/ajax/Leer_carrito.php')
                    .then(res => res.json())
                    .then(res => {
                        let productos_en_carrito = res;
                        //console.log(productos_en_carrito);

                        if (productos_en_carrito == false) {
                            return;
                        }



                        //buscamos en los contenedores de imagenes el id de cada uno

                        let ids_encontrados = [];
                        let productos_en_panatalla = document.querySelectorAll('.img-fluid');
                        productos_en_panatalla.forEach((el) => {
                            id = el.getAttribute('data-id');
                            //console.log(id);

                            productos_en_carrito.map((el) => {
                                if (el.id == id) {
                                    //console.log(id);
                                    ids_encontrados.push(id)

                                }
                            })


                        });

                        //console.log(ids_encontrados);

                        let img_container_producto = document.querySelectorAll('.img-container img');
                        img_container_producto.forEach((img) => {

                            let id_imagen = img.getAttribute('data-id');

                            ids_encontrados.map(el => {

                                if (el == id_imagen) {
                                    //console.log(img.parentNode);
                                    let span = document.createElement('span');
                                    span.classList.add('icono-check');
                                    span.innerHTML = `<i class="fa fa-check-square "></i>`;
                                    img.parentNode.appendChild(span);

                                }
                            })




                        })



                    })
            }
        </script>



        <script>
            //Carga la animacion del icono
            document.querySelector('#badgeProductos').classList.add('parpadeo-dos-veces');
            document.querySelector('#badgeProductos_2').classList.add('parpadeo-dos-veces');
            
        </script>