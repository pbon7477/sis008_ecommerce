

<!-- Modal Body -->
<!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
<div
    class="modal fade"
    id="modal-<?= $producto['id'];?>"
    tabindex="-1"
    data-backdrop="static"
    data-keyboard="false"
    
    role="dialog"
    aria-labelledby="modalTitleId"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">

    <form action="<?= SERVER_URL; ?>admin/app/ajax/Productos_Ajax.php" class="formulario_ajax" data-form="update" method="post">
        <input type="hidden" name="update" value="update">
        <input type="hidden" name="id" value="<?= $producto['id'];?>" >
   
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title" id="modalTitleId"><i class="fas fa-edit"></i>&nbsp;Editar datos del producto</h5>
                <button type="button" class="btn btn-close" data-dismiss="modal" aria-label="Close">x</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" class="form-control form-control-sm" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\d. ]{0,40}" name="nombre" id="nombre" value="<?= $producto['nombre'];?>" required >
                </div>
                <div class="form-group">
                    <label for="nombre">Precio:</label>
                    <input type="text" class="form-control form-control-sm" pattern="[1-9][0-9]{0,7}" name="precio" id="precio" value="<?= $producto['precio'];?>" required >
                </div>
                <div class="form-group">
                    <label for="nombre">Stock:</label>
                    <input type="text" class="form-control form-control-sm" pattern="^[0-9]*$" name="stock" id="stock" value="<?= $producto['stock'];?>" required >
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-dark">Actualizar producto</button>
            </div>
        </div>
    </form>
    </div>
</div>


