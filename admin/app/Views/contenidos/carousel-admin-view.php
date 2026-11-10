<?php

//require_once('./app/controllers/ProductosController.php');
//require_once('./app/controllers/CarouselController.php');


//require_once __DIR__ . './../Controllers/ProductosController.php';
require_once __DIR__ . '/../../Controllers/ProductosController.php';
require_once __DIR__ . '/../../Controllers/CarouselController.php';

$ProductosController = new ProductosController();
$CarouselController = new CarouselController();
?>

<style>
    @media (max-width: 1024px) {

        #modal_productos .modal-dialog,
        #modal_item .modal-dialog,
        #modal_edit_item .modal-dialog {
            max-width: calc(100vw - 1rem);
            width: auto;
            margin: 0.5rem auto;
        }
    }
</style>



<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row ">
                <div class="col-12">
                    <div class="d-flex justify-content-between">
                        <h4 class="m-0">Administrador del Carousel</h4>
                        <button class="btn btn-primary btn-sm" id="btn-new-producto-destacado"><i class="fa fa-plus mr-2"></i>Nuevo producto destacado</button>
                    </div>

                </div><!-- /.col -->

            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Productos destacados</h3>
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 p-2">
                                    <div class="table-responsive border  p-2">
                                        <table id="tabla-items-carousel" class="table table-secondary table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>N°</th>
                                                    <th>Nombre</th>
                                                    <th>Precio</th>
                                                    <th>Descripción</th>
                                                    <th>Categoria</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $items = $CarouselController->all_items();
                                                $contador_items = 0;
                                                foreach ($items as $item) {  ?>
                                                    <tr>
                                                        <td><?= ++$contador_items . '(' . $item['id'] . ')'; ?></td>
                                                        <td><?= $item['nombre_producto']; ?></td>
                                                        <td><?= $item['precio_venta']; ?></td>
                                                        <td><?= $item['descripcion']; ?></td>
                                                        <td><?= $item['categoria']; ?></td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <button class="btn btn-sm btn-warning" data-id="<?= $item['id'];  ?>" data-item="<?= $item; ?>" id="btn-edit-item">Editar</button>
                                                                <button class="btn btn-sm btn-danger" data-id="<?= $item['id']; ?>" id="btn-delete-item">Eliminar</button>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                <?php  } ?>


                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>

                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

<!-- Modal 1  seleccionar un producto  -->
<div class="modal fade" id="modal_productos" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Listado de productos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"></button>
                <span aria-hidden="true">&times;</span>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-12 p-2">
                        <div class="table-responsive border  p-2">
                            <table id="tabla-productos" class="table table-light table-striped table-hover border">
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Nombre</th>
                                        <th>Precio</th>
                                        <th>Descripción</th>
                                        <th>Categoria</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $contador = 0;

                                    $productos = $ProductosController->All_productos();
                                    foreach ($productos as $producto) {
                                    ?>
                                        <tr>
                                            <td><?= ++$contador; ?></td>
                                            <td><?= $producto['nombre_producto']; ?></td>
                                            <td>$<?= number_format($producto['precio_venta'], 0, '', '.'); ?></td>
                                            <td><?= $producto['descripcion']; ?></td>
                                            <td><?= $producto['nombre_categoria']; ?></td>
                                            <td>
                                                <button class="btn btn-sm btn-success btn-producto-seleccionado" data-id="<?= $producto['id_producto']; ?>">Seleccionar</button>
                                            </td>
                                        </tr>

                                    <?php  } ?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>




<!-- Modal 2  Editar informacion para guardar el nuevo item del carousel  -->
<div class="modal fade" id="modal_item" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">CREAR - Información del nuevo producto destacado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"></button>
                <span aria-hidden="true">&times;</span>
            </div>

            <div class="modal-body">



                <div class="row" id="new_item">
                    <div class="col-md-6">
                        <input type="hidden" name="id_producto" id="id_producto">

                        <div class="form-group mb-2">
                            <label for="categoria" class="label">Categoria:</label>
                            <input type="text" name="categoria" id="categoria" class="form-control" readonly>
                        </div>
                        <div class="form-group mb-2">
                            <label for="nombre_producto" class="label">Nombre producto:</label>
                            <input type="text" name="nombre_producto" id="nombre_producto" class="form-control" readonly>
                        </div>
                        <div class="form-group mb-2">
                            <label for="descripcion" class="label">Descripción:</label>
                            <textarea name="descripcion" id="descripcion" class="form-control" cols="30" rows="10" title="Descripción del producto: puedes dejarla como está o modificarla"></textarea>
                        </div>


                        <div class="form-group">
                            <label for="precio_venta" class="label">Precio venta:</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text">$</span>
                                <input type="text" name="precio_venta" id="precio_venta" class="form-control" readonly>

                            </div>

                        </div>



                    </div>

                    <div class="col-md-6 d-flex justify-content-center align-items-center">
                        <img src="<?= SERVER_URL . 'admin\app\Views\assets\images_productos\default.png'; ?>" name="imagen_producto" id="imagen_producto" alt="" class="img-thumbnail" width="350px">
                    </div>

                </div>






            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btn-crear-producto-destacado">Crear producto destacado</button>
            </div>

        </div>
    </div>
</div>



<!-- Modal 3  Editar informacion   -->
<div class="modal fade" id="modal_edit_item" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title">EDITAR- información del producto destacado en el carusel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"></button>
                <span aria-hidden="true">&times;</span>
            </div>

            <div class="modal-body">



                <div class="row" id="new_item">
                    <div class="col-md-6">
                        <input type="hidden" name="id_item" id="id_producto">

                        <div class="form-group mb-2">
                            <label for="categoria_item" class="label">Categoria:</label>
                            <input type="text" name="categoria_item" id="categoria_item" class="form-control" readonly>
                        </div>
                        <div class="form-group mb-2">
                            <label for="nombre_producto_item" class="label">Nombre producto:</label>
                            <input type="text" name="nombre_producto_item" id="nombre_producto_item" class="form-control" readonly>
                        </div>
                        <div class="form-group mb-2">
                            <label for="descripcion_item" class="label">Descripción:</label>
                            <textarea name="descripcion_item" id="descripcion_item" class="form-control" cols="30" rows="10" title="Descripción del producto: puedes dejarla como está o modificarla"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="precio_venta_item" class="label">Precio venta:</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text">$</span>
                                <input type="text" name="precio_venta_item" id="precio_venta_item" class="form-control" readonly>

                            </div>
                        </div>




                    </div>

                    <div class="col-md-6 d-flex justify-content-center align-items-center">
                        <img src="<?= SERVER_URL . 'admin\app\Views\assets\images_productos\default.png'; ?>" name="imagen_producto_item" id="imagen_producto_item" alt="" class="img-thumbnail" width="350px">
                    </div>

                </div>






            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btn-actualizar-item">Actualizar ítem producto destacado</button>
            </div>

        </div>
    </div>
</div>







<script>
    let btn_new_Producto_Destacado = document.querySelector('#btn-new-producto-destacado');
    let modal_productos = document.querySelector('#modal_productos');




    btn_new_Producto_Destacado.addEventListener('click', (e) => {
        $('#modal_productos').modal('show');

    });



    //seleccion de botones de productos
    let producto = {};
    const btns_productos = document.querySelectorAll('.btn-producto-seleccionado');

    //referencia a los inputs
    let id_producto = document.querySelector('#id_producto');
    let categoria = document.querySelector('#categoria');
    let nombre_producto = document.querySelector('#nombre_producto');
    let descripcion = document.querySelector('#descripcion');
    let precio_venta = document.querySelector('#precio_venta');
    let imagen_producto = document.querySelector('#imagen_producto');





    btns_productos.forEach((btn) => {

        btn.addEventListener('click', (e) => {
            console.log(e.target.getAttribute('data-id'));
            let id = e.target.getAttribute('data-id');

            fetch('<?= SERVER_URL; ?>admin/app/ajax/Carousel_Ajax.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        id: id,
                        action: 'get_product'
                    })
                })
                .then(res => res.json())
                .then(res => {
                    console.log(res);
                    producto = res.producto;
                    console.log(producto);




                    id_producto.value = producto.id_producto;
                    categoria.value = producto.categoria;
                    nombre_producto.value = producto.nombre_producto;
                    descripcion.innerText = producto.descripcion;
                    precio_venta.value = producto.precio_venta;
                    imagen_producto.src = `<?= SERVER_URL; ?>admin/app/Views/assets/images_productos/${producto.imagen}`;
                })
                .catch((error) => {
                    console.error(`Error:${error}`);
                })



            $('#modal_productos').modal('hide');
            $('#modal_item').modal('show');



        })
    });



    //Crear el producto destacado
    let btn_crear_producto_destacado = document.querySelector('#btn-crear-producto-destacado');
    btn_crear_producto_destacado.addEventListener('click', (e) => {

        e.preventDefault();
        //El unico valor que estamos modificando (por ahora ) es la descripcion
        producto.descripcion = document.querySelector('#descripcion').value;
        console.log(producto);


        Swal.fire({
                icon: 'warning',
                title: 'Atención',
                text: '¿Desea crear el nuevo producto destacado para el carousel? ',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#0d6efd'
            })
            .then((result) => {
                if (result.isConfirmed) {

                    fetch('<?= SERVER_URL; ?>admin/app/ajax/Carousel_Ajax.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                action: 'create-item',
                                producto: producto
                            })
                        })
                        .then(res => res.json())
                        .then(res => {

                            console.log(res)
                            //HASTA AQUI QUEDAMOS

                            if (res.status == 'success') {

                                Swal.fire({
                                        icon: 'success',
                                        title: "Guardado",
                                        text: res.message,
                                        showConfirmButton: false,
                                        timer: 10000,
                                        timerProgressBar: true
                                    })
                                    .then(() => {
                                        window.location.reload();
                                    })
                            } else {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Atención',
                                    text: res.message,
                                    showConfirmButton: true,
                                    confirmButtonText: 'Entendido',
                                    confirmButtonColor: '#0d6efd'

                                })
                            }

                        });

                    $('#modal_item').modal('hide');

                } else {
                    $('#modal_item').modal('hide');

                }
            });



    })
</script>









<!--//Editar producto destacado -->
<script>
    let current_item = {};

    let categoria_item = document.querySelector('#categoria_item');
    let nombre_producto_item = document.querySelector('#nombre_producto_item');
    let descripcion_item = document.querySelector('#descripcion_item');
    let precio_venta_item = document.querySelector('#precio_venta_item');
    let imagen_producto_item = document.querySelector('#imagen_producto_item');

    let btns_edit_item = document.querySelectorAll('#btn-edit-item');
    btns_edit_item.forEach((btn) => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            let id = e.target.getAttribute('data-id');

            fetch('<?= SERVER_URL; ?>admin/app/ajax/Carousel_Ajax.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        action: 'get-item',
                        id: id
                    })
                })
                .then(res => res.json())
                .then(res => {
                    console.log(res);

                    current_item = res.item;


                    categoria_item.value = current_item.categoria;
                    nombre_producto_item.value = current_item.nombre_producto;
                    descripcion_item.value = current_item.descripcion;
                    precio_venta_item.value = current_item.precio_venta;
                    imagen_producto_item.src = `<?= SERVER_URL; ?>admin/app/Views/assets/images_productos/${current_item.imagen}`;

                })

            $('#modal_edit_item').modal('show');
        });
    })


    //Actualizar item
    let btn_actulizar_item = document.querySelector('#btn-actualizar-item');
    btn_actulizar_item.addEventListener('click', (e) => {
        e.preventDefault();
        current_item.descripcion = descripcion_item.value;
        console.log(current_item);

        Swal.fire({
                title: "Atención",
                text: '¿Seguro desea "Actualizar" la información del de producto destacado?',
                icon: "warning",
                showConfirmButton: true,
                confirmButtonText: "Si, actualizar",
                confirmButtonColor: '#0d6efd',
                showCancelButton: true,
                cancelButtonText: 'Cancelar'
            })
            .then((result) => {
                if (result.isConfirmed) {
                    fetch("<?= SERVER_URL; ?>admin/app/ajax/Carousel_Ajax.php", {
                            method: 'POST',
                            headers: {
                                "Content-Type": "application/json"
                            },
                            body: JSON.stringify({
                                action: 'update-item',
                                item: current_item
                            })
                        })
                        .then(res => res.json())
                        .then(res => {
                            console.log(res);

                            if (res.status == 'success') {

                                Swal.fire({
                                        icon: 'success',
                                        title: 'Ítem Actualizado',
                                        text: res.message,
                                        showConfirmButton: false,
                                        timer: 10000,
                                        timerProgressBar: true
                                    })
                                    .then(() => {
                                        window.location.reload();
                                    })


                            } else {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Atención',
                                    text: res.message,
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true
                                });

                            }

                            $('#modal_edit_item').modal('hide');


                        });


                } else {
                    $('#modal_edit_item').modal('hide');
                }
            })
    })
</script>





<!-- Eliminar item -->
<script>
    let btn_delete_item = document.querySelectorAll('#btn-delete-item');
    btn_delete_item.forEach((btn) => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            let id = e.target.getAttribute('data-id');


            Swal.fire({
                    icon: 'info',
                    title: 'Atención',
                    text: '¿Seguro que desea "Eliminar" el ítem seleccionado?',
                    showConfirmButton: true,
                    confirmButtonText: "Si, Eliminar",
                    confirmButtonColor: '#0d6efd',
                    showCancelButton: true,
                    cancelButtonText: 'Cancelar'
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        fetch("<?= SERVER_URL; ?>admin/app/ajax/Carousel_Ajax.php", {
                                method: 'POST',
                                headers: {
                                    "Content-Type": "application/json"
                                },
                                body: JSON.stringify({
                                    action: 'delete-item',
                                    id: id
                                })
                            })
                            .then(res => res.json())
                            .then(res => {
                                if (res.status == 'success') {
                                    Swal.fire({
                                            icon: 'success',
                                            title: 'Ítem Eliminado',
                                            text: res.message,
                                            showConfirmButton: false,
                                            timer: 10000,
                                            timerProgressBar: true
                                        })
                                        .then(() => {
                                            window.location.reload();
                                        })
                                }
                            })

                    }
                })
        })
    })
</script>








<!--  Datatable config -->
<script type="module">
    $(document).ready(function() {

        /* Datatable para items carousel */
        $('#tabla-items-carousel').DataTable({


            pageLength: 10, // filas por página
            lengthMenu: [5, 10, 25, 50, 100], //opciones del selector de paginación
            order: [
                [0, 'asc'] // orden inicial por la columna 0 (en este caso es 'nombre')
            ],
            language: {
                "proccessing": "Procesando...",
                "search": "Buscar:",
                "lengthMenu": "Mostrar _MENU_ registros",
                "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                "loadingRecords": "Cargando...",
                "zeroRecords": "No se encontraron resultados",
                "emptyTable": "Ningún dato disponible en esta tabla",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                },

            }
        });


        /* Datatable para productos */
        $('#tabla-productos').DataTable({


            pageLength: 10, // filas por página
            lengthMenu: [5, 10, 25, 50, 100], //opciones del selector de paginación
            order: [
                [0, 'asc'] // orden inicial por la columna 0 (en este caso es 'nombre')
            ],
            language: {
                "proccessing": "Procesando...",
                "search": "Buscar:",
                "lengthMenu": "Mostrar _MENU_ registros",
                "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                "loadingRecords": "Cargando...",
                "zeroRecords": "No se encontraron resultados",
                "emptyTable": "Ningún dato disponible en esta tabla",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                },

            }
        });




    });
</script>