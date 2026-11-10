<style>
  .mensaje_truncado {
    max-width: 100px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .celda_corta {

    max-width: 150px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  table th {
    text-align: left;
  }

  table td {
    text-align: left;
  }

  .respondido {

    color: #0f85fa;
    text-decoration: underline;
    font-weight: bold;
  }

  .leido {
    color: green;
    font-weight: bold;

  }

  .nuevo {
    background:'#c3c3c3';
    font-weight: bold;

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
            <h4 class="m-0"><i class="fa fa-paper-plane mr-2"></i>Mensajes</h4>

          </div>
          <p>Listado de mensajes provenientes del formulario de contacto de la tienda</p>

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
              <h3 class="card-title">Listado de mensajes</h3>
            </div>
            <?php
            require_once('app/Controllers/ContactoController.php');
            $ContactoController = new ContactoController();
            $mensajes = $ContactoController->get_all();

            /*
 [0] => Array ( 
 [id] => 1 
 [nombre] => Caroline Pierce 
 [email] => caroline@sis.com 
 [telefono] => 988554477 
 [motivo] => consulta 
 [mensaje] => Hola Pablo, como estas? espero que bien. Te echo mucho de menos 
 [estado] => nuevo 
 [respuesta] => 
 [fecha_creacion] => 2026-10-29 06:01:02 
 [fecha_lectura] => 
 [fecha_respuesta] => 
*/
            ?>




            <!-- /.card-header -->
            <div class="card-body">
              <div class="table-responsive">
                <table id="table_mensajes" class="table table-secondary table-bordered table-hover ">
                  <thead class="bg-light">
                    <tr>
                      <th width="30px">N°</th>
                      <th>Nombre</th>
                      <th>Motivo</th>
                      <th>Estado</th>
                      <th class="text-left">Fecha</th>

                      <th class="text-center">Acciones</th>
                    </tr>
                  </thead>

                  <tbody>

                    <?php
                    $contador = 0;
                    ?>


                    <?php
                    foreach ($mensajes as $mensaje):

                      $estado_class = 'nuevo';

                      if ($mensaje['estado'] === 'leido') {
                        $estado_class = 'leido';
                      }

                      if ($mensaje['estado'] === 'respondido') {
                        $estado_class = 'respondido';
                      }

                      $contador++;
                    ?>

                      <tr class="<?= $mensaje['estado'] == 'nuevo' ? 'bg-light' : ''; ?>">
                        <td class="text-left"><?= $contador; ?></td>
                        <td class="celda_corta"><?= $mensaje['nombre']; ?></td>

                        <td class="celda_corta"><?= ucfirst($mensaje['motivo']); ?></td>

                        <td class="celda_corta <?= $estado_class; ?>"> <?= ucfirst($mensaje['estado']); ?></td>
                        <td class="text-left"><?= $mensaje['fecha_creacion']; ?></td>
                        <td class="text-center">
                          <div class="btn-group">

                            <button id="btn-show-mensaje" data-id="<?= $mensaje['id']; ?>" class="btn btn-success btn-sm border btn-show-mensaje" data-toggle="modal"
                              data-target="#modal_show_mensaje" title="Vér contenido del mensaje"><i class="fas fa-eye"></i></button>


                            <button class="btn btn-danger btn-sm border btn-eliminar-mensaje" type="button" title="Eliminar mensaje" data-id="<?= $mensaje['id']; ?>"><i class="fas fa-trash"></i></button>


                          </div>



                        </td>
                      </tr>


                    <?php endforeach; ?>
                  </tbody>

                </table>
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



<?php include(__DIR__ . '/modals/mensaje-show-modal.php'); ?>



<script>
  const btn_show_mensaje = document.querySelectorAll('.btn-show-mensaje');
  btn_show_mensaje.forEach((btn) => {
    btn.addEventListener('click', (e) => {

      const id = e.currentTarget.dataset.id;
      marcar_mensaje_leido(id);

      fetch('<?= SERVER_URL; ?>admin/app/ajax/Contacto_Ajax.php', {
          method: 'POST',
          header: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: new URLSearchParams({
            action: 'get_one',
            id: id
          })
        })
        .then(res => res.json())
        .then(res => {

          let data = res.data;


          document.querySelector('#nombre').innerText = data.nombre;
          document.querySelector('#email').innerText = data.email;
          document.querySelector('#telefono').innerText = data.telefono;
          document.querySelector('#motivo').innerText = data.motivo;
          document.querySelector('#mensaje').innerText = data.mensaje;
          document.querySelector('#estado').innerText = data.estado;
          document.querySelector('#fecha_creacion').innerText = data.fecha_creacion;
          document.querySelector('#fecha_respuesta').innerText = data.fecha_respuesta;
          document.querySelector('#fecha_lectura').innerText = data.fecha_lectura;
          document.querySelector('#id_mensaje').value = data.id;

        });





    })
  });


  function marcar_mensaje_leido(id) {
    fetch("<?= SERVER_URL; ?>admin/app/ajax/Contacto_Ajax.php", {
        method: 'POST',
        header: {
          "Content-Type": "application/x-www-form-urlencoded"
        },
        body: new URLSearchParams({
          action: 'set_leido',
          id: id
        })
      })
      .then(res => res.json())
      .then(res => {
        console.log(res);
      })
  }


  //cerrar modal y actualizar
  $(document).ready(function() {
    $('#modal_show_mensaje').on('hidden.bs.modal', function() {

      window.location.reload();
    })
  });



  //Marcar como no leido
  const btn_marcar_no_leido = document.querySelector('#btn-marcar-no-leido');
  btn_marcar_no_leido.addEventListener('click', (e) => {
    e.preventDefault();

    let id = document.querySelector('#id_mensaje').value;
    console.log(id);


    fetch("<?= SERVER_URL; ?>admin/app/ajax/Contacto_Ajax.php", {
        method: 'POST',
        header: {
          "Content-Type": "application/x-www-form-urlencoded"
        },
        body: new URLSearchParams({
          action: 'set_no_leido',
          id: id
        })
      })
      .then(res => res.json())
      .then(res => {
        console.log(res);
        $('#modal_show_mensaje').modal('hide');
      });


  });


  //marcar como respondido
  const btn_marcar_respondido = document.querySelector("#btn-marcar-respondido");
  btn_marcar_respondido.addEventListener('click', (e) => {
    e.preventDefault();

    let id = document.querySelector('#id_mensaje').value;
    fetch('<?= SERVER_URL; ?>admin/app/ajax/Contacto_Ajax.php', {
        method: 'POST',
        header: {
          "Content-Type": "application/x-www-form-urlencoded"
        },
        body: new URLSearchParams({
          action: 'set_respondido',
          id: id
        })

      })
      .then(res => res.json())
      .then(res => {
        console.log(res);
        $('#modal_show_mensaje').modal('hide');
      })

  });


  //eleiminar mensaje
  const btn_eliminar_mensaje = document.querySelectorAll('.btn-eliminar-mensaje');

  btn_eliminar_mensaje.forEach((el) => {
    el.addEventListener('click', (e) => {
      e.preventDefault();
      const id = e.currentTarget.dataset.id;

      eliminar_mensaje(id);
    })
  })

  function eliminar_mensaje(id) {

    Swal.fire({
        title: 'Atención',
        html: `<p>¿Seguro que desea eliminar el mensaje?<br><small><b>Una vez eliminado ya no podra recuperar la información del contactante</b></small></p>`,
        icon: 'info',
        showConfirmButton: true,
        showCancelButton: true,
        confirmButtonColor: 'blue',
        confirmButtonText: 'Si, eliminar mensaje'
      })
      .then((results) => {
        if (results.isConfirmed) {
          fetch("<?= SERVER_URL; ?>admin/app/ajax/Contacto_Ajax.php",{
            method:'POST',
            headers:{"Content-Type":"application/x-www-form-urlencoded"},
            body:new URLSearchParams({
              action:'delete',
              id:id
            })
          })
          .then(res=>res.json())
          .then(res=>{
            if(res.status == 'success'){
              Swal.fire({
                title:"Mensaje Eliminado",
                html:`<p>${res.message}</p>`,
                icon:'success',
                showConfirmButton:false,
                timer:10000,
                timerProgressBar:true
              })
              .then(()=>{
                window.location.reload()
              })
            }
          
          })

        } 
      })

  }
</script>


<script>
  $(function() {
    $("#table_mensajes").DataTable({
      "pageLength": 10,
      "language": {
        "emptyTable": "No hay información",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ mensajes",
        "infoEmpty": "Mostrando 0 a 0 de 0 mensaje(s)",
        "infoFiltered": "(Filtrado de _MAX_ total mensaje(s)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ mensajes",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": "Buscador:",
        "zeroRecords": "Sin resultados encontrados",
        "paginate": {
          "first": "Primero",
          "last": "Ultimo",
          "next": "Siguiente",
          "previous": "Anterior"
        }
      },
      "responsive": true,
      "lengthChange": true,
      "autoWidth": false,
      buttons: []
    })

  });
</script>