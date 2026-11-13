<?php
if (!isset($_SESSION['codigo_pedido'])) {
    echo "<script>window.location.href='" . SERVER_URL . "';</script>";
}
?>




<div class="row">
    <div class="col-md-12 mx-auto">

        <div class="d-flex justify-content-center">
            <div class="check_circle_confirm bg-success">
                <i class="fa fa-check fs-5"></i>
            </div>
        </div>

    </div>

</div>


<div class="row">
    <div class="col-md-12">

        <div class="text-center">
            <div class="text-success"><small>PEDIDO REGISTRADO</small></div>
            <h3>¡Pedido Confirmado! </h3>
            <p><u>Codigo pedido:</u> <b><?= $_SESSION['codigo_pedido']; ?></b></p>

        </div>
    </div>
</div>

<br>

<div class="row">
    <div class="col-md-6 mx-auto p-2 ">

        <div class="alert alert-default-info mb-2 text-center border-info shadow">
            <b><?= ucfirst($_SESSION['nombre_cliente']); ?></b>, guardamos su pedido.<br>En unos minutos <b><?= COMPANY; ?></b> te va a escribir por WhatsApp para coordinar el <b>pago</b> y la <b>entrega</b>.
        </div>


    </div>
</div>

<div class="row">
    <div class="col-md-6 mx-auto p-2">
        <div class="alert alert-default-warning border border-warning  text-center">
            <i class="fa fa-lock mr-2"></i><br><u>No modifique el mensaje de WhatsApp.</u><br>El precio valido de su pedido es el que quedó registrado en el sistema asociado al pedido con el codigo N° <b><?= $_SESSION['codigo_pedido'] ?></b>, no el que diga el texto enviado.
        </div>
    </div>
</div>

<hr>

<div class="row">
    <div class="col-md-5 mx-auto border border-1 ">
        <div class="d-flex flex-column justify-content-center align-items-center">
            <a href="#" id="btn-envio-whatsapp"><button class="btn btn-success mb-2"><i class="fab fa-whatsapp mr-2"></i> Pedir por WhatsApp Ahora</button></a>
            <a href="<?= SERVER_URL ?>front/descargar_comprobante.php?id_cli=<?= $_SESSION['id_cliente'] ?>&cp=<?= $_SESSION['codigo_pedido']; ?>" target="_blank" id="btn_descargar_comprobante"><button class="btn btn-outline-dark mb-2"><i class="fa fa-file-pdf mr-2"></i>Descargar comprobante PDF</button></a>
            <a href="<?= SERVER_URL; ?>"> <button class="btn btn-outline-dark mb-2"><i class="fas fa-home mr-2"></i>Volver a la tienda</button></a>
        </div>
    </div>


</div>
</div>
<br><br><br>

<script>
    document.addEventListener('DOMContentLoaded', () => {

        function vaciar_carrito_y_destinatario() {
            fetch("<?= SERVER_URL; ?>front/ajax/Vaciar_carrito_y_destinatario.php")
                .then(res => res.json())
                .then(res => {
                    console.log(res);
                    document.querySelector('#badgeProductos').innerHTML = '';

                })
        }



        function enviar_pedido_a_whatsapp() {
            fetch('<?= SERVER_URL; ?>front/ajax/pedido_a_whatsapp.php', {
                    method: 'POST',
                    header: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        action: 'pedido_whatsapp',
                        codigo_pedido: '<?= $_SESSION['codigo_pedido'] ?>',
                        id_cliente: '<?= $_SESSION['id_cliente'] ?>'
                    })
                })
                .then(res => res.json())
                .then(res => {
                    console.log(res);
                    let btn_envio_whatsapp = document.querySelector('#btn-envio-whatsapp');
                    btn_envio_whatsapp.setAttribute('href', res.url);
                    btn_envio_whatsapp.setAttribute('target', '_blank');

                    //forzar click:
                    btn_envio_whatsapp.click();


                })
        }

        vaciar_carrito_y_destinatario();

        enviar_pedido_a_whatsapp();

    });
</script>