<?php


if (!isset($_SESSION['id_cliente'])  || $_SESSION['destinatario']['nombre'] == '') {
    echo "<script>window.location.href='" . SERVER_URL . "';</script>";
}

?>

<div class="row">
    <div class="col-md-12">
        <div class="header-section">
            <div>
                <h5><i class="fa fa-list-alt sub-icon-blue mr-2"></i>Resumen del pedido: </h5>
                <p>Revise los detalles antes de confirmar su pedido</p>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12 ">

        <div class="card">
            <div class="card-header">
                <h5>Mis Productos</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive " id="tabla_pasarela">
                    <table class="table table-sm table-bordered border table-hover " id="tabla_pasarela">
                        <thead>
                            <tr>
                                <th class="bg-light" scope="col" style="width:35px;">N°</th>
                                <th class="bg-light" scope="col">Imagen</th>
                                <th class="bg-light" scope="col">Nombre</th>
                                <th class="bg-light" scope="col" class="text-center">Cantidad</th>
                                <th class="bg-light" scope="col" class="text-center">Precio</th>
                                <th class="bg-light" scope="col" class="text-center">Total</th>

                            </tr>
                        </thead>
                        <tbody id="tabla_pasarela_body">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    </div>
</div>
<hr>


<div class="alert alert-success p-3 border text-center ">

    <p><i class="fas fa-comment mr-2 "></i>El método de pago y la entrega se coordinan directamente por <u><i class="fab fa-whatsapp mx-1"></i>WhatsApp</u>
    </p>
</div>
<i class="fa fa-whatsapp fa-2x"></i>

<?php if (isset($_SESSION['id_cliente'])) {  ?>

    <div class="row" id="row-cliente-y-destinatario">

        <div class="col-md-6">

            <div class="card">
                <div class="card-header bg-light">
                    <h4><i class="fas fa-file mx-2"></i>Quien compra</h4>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><b>Nombre: </b><?= $_SESSION['cliente']['nombre']; ?></p>
                            <p><b>Email: </b><?= $_SESSION['cliente']['email']; ?></p>
                            <p><b>Dirección: </b><?= $_SESSION['cliente']['direccion']; ?></p>
                            <p><b>Teléfono: </b><?= $_SESSION['cliente']['telefono']; ?></p>

                        </div>

                    </div>



                </div>

            </div>


        </div>

        <div class="col-md-6">



            <div class="card">
                <div class="card-header bg-light">
                    <h4><i class="fas fa-box mx-2"></i>Quien recibe</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><b>Nombre: </b><?= $_SESSION['destinatario']['nombre']; ?></p>
                            <p><b>Email: </b><?= $_SESSION['destinatario']['email']; ?></p>
                            <p><b>Dirección: </b><?= $_SESSION['destinatario']['direccion']; ?></p>
                            <p><b>Teléfono: </b><?= $_SESSION['destinatario']['telefono']; ?></p>

                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>


    <div class="row" id="row-checkbox-accept">
        <div class="col-md-12 mt-2">

            <div class="form-check mt-3 ">
                <label class="form-check-label ">
                    <input type="checkbox" class="form-check-input" name="check_accept" id="check_accept" value="">
                    <span class="fs-2 h6"> Acepto los <b><a href="<?= SERVER_URL; ?>index.php?view=terminos-y-condiciones">términos y condiciones</a></b> de la tienda y confirmo que los datos ingresados son correctos.</span>
                </label>

            </div>

            <!--         <div>
            <button class="btn btn-light" id="btn_comprobante">Descargar el comprobante de mi pedido(PDF)</button>
        </div> -->


        </div>
    </div>

    <hr>
    <div class="row" id="row-btns-volver-o-confirmar">

        <div class="col-md-12 mb-5 ">
            <div class="d-flex flex-column flex-md-row justify-content-md-between gap-2">

                <a href="index.php?view=datos-envio-cliente" class="btn btn-outline-dark order-md-0 order-1"><i class="fa fa-arrow-circle-left mr-1"></i> Volver a datos de envio</a>
                <button type="button" class="btn btn-primary float-right order-md-1 order-0 mb-2 mb-md-0" id="btn_confirmar_pedido" disabled><i class="fa fa-check mr-1"></i> Confimar pedido </button>
            </div>
        </div>
    </div>

    <div id="respuesta"></div>

    <br><br><br>




<?php } ?>
<!-- //end condicional session -->







<?php if (isset($_SESSION['id_cliente'])) {  ?>

    <script>
        const check_accept = document.querySelector('#check_accept');

        check_accept.addEventListener('change', (e) => {

            if (e.target.checked) {
                document.querySelector('#btn_confirmar_pedido').removeAttribute('disabled');
            } else {
                document.querySelector('#btn_confirmar_pedido').setAttribute('disabled', true);
            }
        });
    </script>

<?php } ?>


<script src="./front/Views/assets/js/tabla_pasarela.js"></script>
<script src="./front/Views/assets/js/confirmar_pedido.js"></script>

<script>
    function check_carrito_vacio() {

        fetch("<?= SERVER_URL; ?>front/ajax/Carrito_ajax.php", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    action: 'check-carrito'
                })

            })
            .then(res => res.json())
            .then(res => {
                console.log(res);
                if (res.empty) {
                    document.querySelector('#check_accept').setAttribute('disabled', true);
                    document.querySelector('#btn_confirmar_pedido').setAttribute('disabled', true);
                    document.querySelector('#row-cliente-y-destinatario').innerText = '';
                    document.querySelector('#row-checkbox-accept').innerText = '';
                    document.querySelector('#row-btns-volver-o-confirmar').innerText = '';
                    Swal.fire({
                            title: "Atención",
                            html: "<p>El carrito no tiene productos.<br>Debe seleccionar al menos un producto para poder continuar.</p>",
                            icon: "warning",
                            confirmButtonText: 'Entendido, ir a Productos',
                            confirmButtonColor: '#228b22'
                        })
                        .then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "<?= SERVER_URL; ?>index.php?view=productos";
                            }
                            window.location.href = "<?= SERVER_URL; ?>index.php?view=productos";
                        })
                }
            })
    }

    check_carrito_vacio();
</script>