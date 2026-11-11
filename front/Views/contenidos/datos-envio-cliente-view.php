<?php


if (isset($_SESSION['id_cliente'])) {

    require_once('front/Controllers/ClientesController.php');
    $ClientesController = new ClientesController();
    $cliente = $ClientesController->get_one($_SESSION['id_cliente']);



?>

    <div class="row">
        <div class="col-md-12 mb-2">
            <div class="header-section">
                <div>
                    <h5><i class="fa fa-id-card sub-icon-blue mr-2"></i> Datos de envio</h5>
                    <p>Indique dónde desea recibir su pedido</p>
                </div>
            </div>
        </div>
    </div>




    <form action="./front/ajax/Clientes_ajax.php" method="post" id="form_update_cliente_y_destinatario">
        <div class="row">
            <div class="col-md-6 ">
                <div class="card">
                    <div class="card-header bg-light">
                        <h5><i class="fa fa-user mr-1"></i>Datos del cliente</h5>
                        <input type="hidden" name="id_cliente" value="<?= $cliente['id']; ?>">
                        <input type="hidden" name="guardar_cliente_y_destinatario" value="guardar_cliente_y_destinatario">
                    </div>
                    <div class="card-body bg-light">

                        <div class="form-group">
                            <label for="nombre_cliente">Nombre:</label>
                            <input type="text" class="form-control" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ _\-]{3,40}" name="nombre_cliente" id="nombre_cliente" value="<?= $cliente['nombre']; ?>">
                        </div>

                        <div class="form-group">
                            <label for="email_cliente">Email:</label>
                            <input type="email" class="form-control" name="email_cliente" id="email_cliente" value="<?= $cliente['email']; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="direccion_cliente">Dirección:</label>
                            <textarea class="form-control" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\(\)\.\,\#\- ]{1,150}" name="direccion_cliente" id="direccion_cliente" rows="3"><?= $cliente['direccion'] ?? ''; ?></textarea>


                        </div>
                        <div class="form-group">
                            <label for="telefono_cliente">Teléfono:</label>
                            <div class="input-group has-validation">

                                <span class="input-group-text prefijo-telefono">+56</span>
                                <input type="text" class="form-control" pattern="[0-9]{9}" oninput="this.value=this.value.replace(/[^0-9]/g, '')" name="telefono_cliente" id="telefono_cliente" value="<?= $cliente['telefono']; ?>" maxlength="9">
                            </div>
                            <span class="ml-1 text-secondary">Ejemplo: 912345678</span>
                        </div>





                    </div>
                </div>
            </div>

            <div class="col-md-6 ">
                <div class="card">
                    <div class="card-header bg-light">
                        <h5><i class="fa fa-user-plus mr-1"></i> Datos de quien recibe</h5>
                    </div>
                    <div class="card-body bg-light">


                        <div class="form-check float-right">
                            <input type="checkbox" class="form-check-input" name="agregar_datos_usuario_a_cliente" id="agregar_datos_usuario_a_cliente">
                            <label for="agregar_datos_usuario_a_cliente">Agregar mis datos(El pedido lo recibiré yo):</label>
                        </div>


                        <div class="form-group">
                            <label for="nombre_destinatario">Nombre:</label>
                            <input type="text" class="form-control" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ _\-]{3,40}" name="nombre_destinatario" id="nombre_destinatario" value="<?= $destinatario['nombre'] ?? ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="email_destinatario">Email:</label>
                            <input type="email" class="form-control" name="email_destinatario" id="email_destinatario" value="<?= $destinatario['email'] ?? ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="direccion_destinatario">Dirección:</label>
                            <textarea class="form-control" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\(\)\.\,\#\- ]{1,150}" name="direccion_destinatario" id="direccion_destinatario" rows="3"><?= $destinatario['direccion'] ?? ''; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="telefono_destinatario">Teléfono:</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text prefijo-telefono">+56</span>
                                <input type="text" class="form-control" pattern="[0-9]{9}" oninput="this.value=this.value.replace(/[^0-9]/g, '')" name="telefono_destinatario" id="telefono_destinatario" value="<?= $destinatario['telefono'] ?? ''; ?>" min="8" maxlength="9">
                            </div>

                            <span class="ml-1 text-secondary">Ejemplo: 912345678</span>

                        </div>




                    </div>
                </div>




            </div>


        </div>

        <div class="row">
            <div class="col-md-12 mx-2">
                <div class="d-flex flex-column flex-md-row justify-content-md-between gap-2">
                    <a href="index.php?view=carrito" class="btn btn-outline-dark order-md-0 order-1"><i class="fa fa-arrow-circle-left mr-1"></i>Volver al carrito</a>
                    <button type="submit" class="btn btn-primary float-right order-md-1 order-0 mb-2 mb-md-0" name="guardar_cliente_y_destinatario" id="guardar_cliente_y_destinatario" value="guardar_cliente_y_destinatario"><i class="fa fa-arrow-circle-right mr-1"></i>Continuar</button>
                </div>
            </div>
        </div>

        <br><br><br>

    </form>


    <br><br><br>



<?php } else { ?>

    <div class="row">
        <div class="col-md-12 mt-3 text-center">
            Debe <a href="index.php?view=login-cli"><u>Iniciar sesion</u></a> o <a href="index.php?view=registro-cli"><u>registrarse para continuar.</u></a>
        </div>
    </div>

<?php } ?>




<?php if (isset($_SESSION['id_cliente'])) { ?>

    <script>
        let nombre_destinatario = document.querySelector('#nombre_destinatario').value;
        let email_destinatario = document.querySelector('#email_destinatario').value;
        let direccion_destinatario = document.querySelector('#direccion_destinatario').value;
        let telefono_destinatario = document.querySelector('#telefono_destinatario').value;


        let checkbox_agregar = document.querySelector('#agregar_datos_usuario_a_cliente');

        checkbox_agregar.addEventListener('click', function(e) {
            let nombre_cliente = document.querySelector('#nombre_cliente').value;
            let email_cliente = document.querySelector('#email_cliente').value;
            let direccion_cliente = document.querySelector('#direccion_cliente').value;
            let telefono_cliente = document.querySelector('#telefono_cliente').value;


            if (e.target.checked == true) {

                document.querySelector('#nombre_destinatario').value = nombre_cliente;
                document.querySelector('#email_destinatario').value = email_cliente;
                document.querySelector('#direccion_destinatario').value = direccion_cliente;
                document.querySelector('#telefono_destinatario').value = telefono_cliente;
            } else {
                document.querySelector('#nombre_destinatario').value = nombre_destinatario;
                document.querySelector('#email_destinatario').value = nombre_destinatario;
                document.querySelector('#direccion_destinatario').value = direccion_destinatario;
                document.querySelector('#telefono_destinatario').value = telefono_destinatario;


            }
        })
    </script>

<?php } ?>



<?php
if (isset($_SESSION['destinatario'])) { ?>
    <script>
        document.querySelector('#nombre_destinatario').value = '<?= $_SESSION['destinatario']['nombre']; ?>';
        document.querySelector('#email_destinatario').value = '<?= $_SESSION['destinatario']['email']; ?>';
        document.querySelector('#direccion_destinatario').value = '<?= $_SESSION['destinatario']['direccion']; ?>';
        document.querySelector('#telefono_destinatario').value = '<?= $_SESSION['destinatario']['telefono']; ?>';
    </script>
<?php } ?>





<script>
    const form_update_cliente_y_destinatario = document.querySelector('#form_update_cliente_y_destinatario');


    if (form_update_cliente_y_destinatario != null) {


        form_update_cliente_y_destinatario.addEventListener('submit', function(e) {
            e.preventDefault();

            const data = new FormData(this);

            let action = this.getAttribute('action');
            let method = this.getAttribute('method');
            let encabezados = new Headers();

            let config = {
                method: method,
                headers: encabezados,
                mode: 'cors',
                cache: 'no-cache',
                body: data
            };


            fetch(action, config)
                .then((response) => response.json())
                .then((response) => {

                    if (response.success == false) {
                        let alerta = response.alerta;
                        Swal.fire({
                            title: alerta.titulo,
                            html: alerta.texto,
                            icon: alerta.icono,
                            confirmButtonText: 'Aceptar',
                            confirmButtonColor: '#222'
                        });

                    } else {
                        window.location.href = 'index.php?view=pasarela';
                    }

                })
                .catch(error => console.log(error));

        });

    }
</script>


<script>  
    function check_carrito_vacio() {

        fetch("<?= SERVER_URL; ?>front/ajax/Carrito_ajax.php",{
            method:'POST',
            headers:{'Content-Type':'application/json'},
            body:JSON.stringify({
                action:'leer-carrito'
            })

        })
            .then(res => res.json())
            .then(res => {
                console.log({contenido_actual: res, longitud:res.length});
                if (res == false) {

                    let btn_guardar_cliente_y_destinatario = document.querySelector('#guardar_cliente_y_destinatario');
                    if (btn_guardar_cliente_y_destinatario != null) {
                        guardar_cliente_y_destinatario.setAttribute('disabled', true);
                    }

                    Swal.fire({
                            title: "Atención",
                            html: "<p>El carrito no tiene productos.<br>Debe seleccionar al menos un producto para poder continuar.</p>",
                            icon: "warning",
                            confirmButtonText: 'Entendido',
                            confirmButtonColor: '#333'
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