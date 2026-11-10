<div class="row">
    <div class="col-md-12">

        <div class="header-section">
            <div>

                <h5><i class="fas fa-envelope sub-icon-blue mr-2"></i>Contacto</h5>
                <p>Escríbenos y te responderemos en un día laborable.</p>
            </div>

        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6">

        <div class="card">
            <div class="card-header">
                <h5>Envíanos un mensaje</h5>
            </div>
            <div class="card-body">

                <div class="form-group mb-3">
                    <label for="nombre" class="form-label">Nombre*</label>
                    <input type="text" class="form-control" name="nombre" id="nombre" pattern="[A-Za-zÁÉÍÓÚÜÑáéíóúüñ]+(?:(?:[ ']|-)[A-Za-zÁÉÍÓÚÜÑáéíóúüñ]+)*" required >
                    <div id="error_nombre"></div>
                </div>

                <div class="form-group mb-3 ">
                    <label for="email" class="form-label">Email*</label>
                    <input type="email" class="form-control col-6" name="email" id="email" pattern="[A-Za-z0-9._%+\x2D]+@[A-Za-z0-9\x2D]+(?:\.[A-Za-z0-9\x2D]+)*\.[A-Za-z]{2,}" required >
                    <div id="error_email"></div>
                </div>

                <div class="form-group  ">
                    <label for="telefono">Teléfono*</label>
                    <div class="input-group has-validation ">
                        <span class="input-group-text prefijo-telefono">+56</span>
                        <input type="text" class="form-control col-4" pattern="[0-9]{9}" oninput="this.value=this.value.replace(/[^0-9]/g, '')" name="telefono" id="telefono" min="9" maxlength="9" required >

                    </div>

                    <span class="ml-1 text-secondary">Ejemplo: 912345678</span>
                    <div id="error_telefono"></div>

                </div>

                <div class="form-group mb-3">
                    <label for="" class="form-label">Motivo*</label>
                    <select
                        class="form-control form-select form-select-lg"
                        name="motivo"
                        id="motivo" required>
                        <option value='' selected>Elija un opción</option>
                        <option value="consulta">Consulta general</option>
                        <option value="presupuesto">Pedir un presupuesto</option>
                        <option value="otro">Otro motivo</option>
                    </select>
                    <div id="error_motivo"></div>

                </div>


                <div class="form-group mb-3">
                    <label for="" class="form-label">Mensaje*</label>
                    <textarea class="form-control" name="mensaje" id="mensaje" rows="3" maxlength="1000" required></textarea>

                    <div id="error_mensaje"></div>
                </div>

                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input " type="checkbox" value="privacidad" id="privacidad" />
                        <label class="form-check-label" for=""> He leído y acepto la <span class="text-primary"><a href="<?= SERVER_URL; ?>index.php?view=politica-de-privacidad">política de privacidad</a></span> </label>
                    </div>

                </div>

                <div class="form-group text-right">

                    <button class="btn btn-dark" type="submit" id="btn-enviar-mensaje"><i class="fa fa-paper-plane mr-2"></i>Enviar mensaje</button>
                </div>

            </div>
        </div>
    </div>

    <div class="col-lg-6 ">

        <div class="row">
            <div class="col-12">
                <div class="alert alert-light border" role="alert">
                    <h4 class="alert-heading">Otras formas de contactarnos</h4>

                    <hr />
                    <p><b>Correo</b></p>
                    <p class="text-primary mb-1"><?= COMPANY; ?>@empresa.cl</p>
                    <p><b>Teléfono</b></p>
                    <p class="text-primary mb-1">+56 9 88 55 44 77</p>
                    <p><b>Dirección</b></p>
                    <p class="text-primary mb-1">Calle Ejemplo 123, 25001, Puerto Montt</p>
                    <p><b>Horario de atención</b></p>
                    <p class="text-primary mb-1">Lunes a viernes, de 09:00 a 18:00</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <!-- mapa -->
                <!--   -->
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d852124.7606930961!2d-70.6412544!3d-33.459404799999994!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1ses!2scl!4v1792749463753!5m2!1ses!2scl" class="rounded border" width="100%" height="263px" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>

            </div>

        </div>





    </div>
</div>
<br><br><br>


<script>
    const nombre = document.querySelector('#nombre');
    const email = document.querySelector('#email');
    const telefono = document.querySelector('#telefono');
    const motivo = document.querySelector('#motivo');
    const mensaje = document.querySelector('#mensaje');

    limpiar_mensajes_de_error();






    const input_checkbox_privacidad = document.querySelector('#privacidad');

    const btn_enviar_mensaje = document.querySelector('#btn-enviar-mensaje');
    btn_enviar_mensaje.setAttribute('disabled', true);

    //Activa la accion del boton
    input_checkbox_privacidad.addEventListener('change', (e) => {
        e.preventDefault();

        if (e.target.checked) {
            btn_enviar_mensaje.removeAttribute('disabled');

        } else {
            btn_enviar_mensaje.setAttribute('disabled', true);
        }
    })


    //Click
    btn_enviar_mensaje.addEventListener('click', (e) => {
        e.preventDefault();
        enviar_mensaje();
    });



    function enviar_mensaje() {



        if (nombre.value.trim() == '') {
            document.querySelector('#error_nombre').innerHTML = "<p class='text-danger'>*Ingrese su nombre</p>";
            nombre.focus();
            return
        }

        if (email.value.trim() == '') {
            document.querySelector('#error_email').innerHTML = "<p class='text-danger'>*Ingrese un Email</p>";
            email.focus();
            return
        }

        //validar email
        const patron = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*\.[a-zA-Z]{2,}$/;

        if (!patron.test(email.value.trim())) {
            document.querySelector('#error_email').innerHTML = "<p class='text-danger'>*Ingrese un email valido</p>";
            email.focus();
            return
        }

        //validar teléfono
        if (telefono.value.trim() == '') {
            document.querySelector('#error_telefono').innerHTML = "<p class='text-danger'>*Ingrese un numero teléfonico</p>";
            telefono.focus();
            return
        }

        if (telefono.value.trim().length !== 9) {
            document.querySelector('#error_telefono').innerHTML = "<p class='text-danger'>*Ingrese un numero teléfonico valido</p>";
            telefono.focus();
            return
        }




        if (motivo.value.trim() == '') {
            document.querySelector('#error_motivo').innerHTML = "<p class='text-danger'>*Seleccione el motivo de su mensaje</p>";
            motivo.focus();
            return
        }

        if (mensaje.value.trim() == '') {
            document.querySelector('#error_mensaje').innerHTML = "<p class='text-danger'>*Escriba el contenido de su mensaje</p>";
            mensaje.focus();
            return
        }



        btn_enviar_mensaje.innerText = 'Enviando...';



        const data = {
            nombre: nombre.value,
            email: email.value,
            telefono: telefono.value,
            motivo: motivo.value,
            mensaje: mensaje.value,
            action: 'save_message'
        };



        console.log('Enviando...');
        setTimeout(() => {
            guardar_mensaje(data);
        }, 2000);







    }


    function guardar_mensaje(data) {

        fetch('<?= SERVER_URL; ?>front/ajax/Contacto_ajax.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(res => res.json())
            .then(res => {

                if (res.status == 'success') {

                    console.log(res);
                    limpiar_campos();
                    Swal.fire({
                        title: res.title,
                        html: res.message,
                        icon: res.status,
                        timer: 6000,
                        timerProgressBar: true,
                        showConfirmButton: false
                    });
                }
            })
            .catch((error) => {
                console.log(error);
            });
    }




    function limpiar_mensajes_de_error() {

        nombre.addEventListener('input', (e) => {
            document.querySelector('#error_nombre').innerHTML = '';
        });
        email.addEventListener('input', (e) => {
            document.querySelector('#error_email').innerHTML = '';
        });
        telefono.addEventListener('input', (e) => {
            document.querySelector('#error_telefono').innerHTML = '';
        });
        motivo.addEventListener('input', (e) => {
            document.querySelector('#error_motivo').innerHTML = '';
        });

        mensaje.addEventListener('input', (e) => {
            document.querySelector('#error_mensaje').innerHTML = '';
        });


    }





    function limpiar_campos() {

        nombre.value = '';
        email.value = '';
        telefono.value = '';
        motivo.value = '';
        mensaje.value = '';
        input_checkbox_privacidad.checked = false;
        btn_enviar_mensaje.innerText = 'Enviar mensaje';
    }
</script>