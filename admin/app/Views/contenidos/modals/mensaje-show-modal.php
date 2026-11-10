<div class="modal  fade" id="modal_show_mensaje" tabindex="-1"
  role="dialog"
  aria-labelledby="modalTitleId"
  aria-hidden="true">
  <div
    class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg"
    role="document">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title" id="modalTitleId">
          Contenido del mensaje
        </h5>
        <button type="button" class="close " data-dismiss="modal" aria-label="Close">&times; </button>
      </div>


      <div class="modal-body">
        <input type="hidden" id="id_mensaje" value="">

        <div class="col-12 border p-2 ">
          <p><b>Nombre:</b> <span id="nombre"></span></p>
          <p><b>Email:</b> <span id="email"></span></p>
          <p><b>Teléfono:</b> <span id="telefono"></span></p>
          <p><b>Motivo:</b> <span id="motivo"></span></p>
          <p><b>Estado:</b> <span id="estado"></span></p>
          <p><b>Fecha creacion:</b> <span id="fecha_creacion"></span></p>
          <p><b>Fecha lectura:</b> <span id="fecha_lectura"></span></p>
          <p><b>Fecha respuesta:</b> <span id="fecha_respuesta"></span></p>
          <br>

          <div class="mb-3">
            <label for="mensaje" class="form-label">Mensaje:</label>
            <textarea class="form-control" id="mensaje" rows="10" disabled></textarea>
          </div>



        </div>




        <!--  
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
-->


      </div>
      <div class="modal-footer">
        <div class="row">
          <div class="col-12">
            <div class="">

              <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
                Cerrar
              </button>
              <button type="button" class="btn btn-outline-success btn-sm" id="btn-marcar-no-leido" ><i class="fa fa-check mr-2"></i>Marcar como no Leido</button>
              <button type="button" class="btn btn-warning btn-sm" id="btn-marcar-respondido"><i class="fa fa-check mr-2"></i>Marcar como respondido</button>
            </div>
          </div>

        </div>
      </div>

    </div>
  </div>
</div>