



<!-- Modal Body -->
<!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
<div class="modal  fade" id="modal_nueva_categoria" tabindex="-1"
  role="dialog"
  aria-labelledby="modalTitleId"
  aria-hidden="true">
  <div
    class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md"
    role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title" id="modalTitleId">
          Ingrese la información de la nueva categoría
        </h5>
        <button
          type="button"
          class="close"
          data-dismiss="modal"
          aria-label="Close">&times;

        </button>
      </div>


      <div class="modal-body">


        <input type="hidden" name="create" value="create">

        <div class="col-12">
          <div id="message-warning" class="alert alert-warning d-none text-center"></div>
          <div class="form-group">
            <label for="">Nombre</label>
            <input type="text" class="form-control form-control-sm" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ 0-9 ]{3,40}" id="nombre_nueva_categoria" maxlength="40" required />

              </div>
          </div>

          <div class="col-md-12">
            <div class="form-group">
              <label for="descripcion">Descripción:</label>
              <textarea class="form-control form-control-sm" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,150}" id="descripcion_nueva_categoria" cols="6" rows="6" placeholder="Descripción de la categoria..." required></textarea>
            </div>
          </div>


        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-secondary"
            data-dismiss="modal">
            Cancelar
          </button>
          <button type="button" class="btn btn-primary" id="btn_create_categoria"><i class="fa fa-save mr-2"></i>Guardar categoria</button>
        </div>

      </div>
    </div>
  </div>



  <script>
    //crear nueva categoria
    const btn_create_categoria = document.querySelector('#btn_create_categoria');
    btn_create_categoria.addEventListener('click', (e) => {
      e.preventDefault();

      let nombre_nueva_categoria = document.querySelector('#nombre_nueva_categoria').value.trim();
      let descripcion_nueva_categoria = document.querySelector('#descripcion_nueva_categoria').value.trim();



      //Si lleno ambos campos...
      if (nombre_nueva_categoria !== '' && descripcion_nueva_categoria !== '') {
        fetch('<?= SERVER_URL; ?>admin/app/ajax/Categorias_Ajax.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
              create: 'create',
              nombre: nombre_nueva_categoria,
              descripcion: descripcion_nueva_categoria
            })

          })
          .then(res => res.json())
          .then(res => {
            console.log(res);

            if (res.Tipo == 'success') {

              Swal.fire({
                  title: res.Titulo,
                  html: res.Texto,
                  icon: res.Tipo,
                  showConfirmButton: true,
                  confirmButtonText: 'Entendido',
                  confirmButtonColor:'#222'
                })
                .then((result) => {
                  if (result.isConfirmed) {
                    $('#modal_nueva_categoria').modal('hide');
                    window.location.reload();
                  }

                })


            }else{
              Swal.fire({
                title:res.Titulo,
                html:res.Texto,
                icon:res.Tipo,
                showConfirmButton:true,
                confirmButtonText:'Entendido',
                confirmButtonColor:'#222'
              })
            }

          })

      } else {
        //Si no ha llenado todos los campos...
        let message_warning =  document.querySelector('#message-warning');
        message_warning.classList.remove('d-none');
        let message='<h5><u>Atención</u></h5>';

        if(nombre_nueva_categoria === ''){
          message+='<p>Debe ingresar un <b><u>Nombre</u></b></p>';
          
        }

        if(descripcion_nueva_categoria === ''){
          message+='<p>Debe ingresar una <b><u>Descripción</u></b></p>';
         
        }
        message_warning.innerHTML= message;
        

      }


    });
  </script>
