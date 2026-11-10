


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row ">
          <div class="col-sm-6">
            <h4 class="m-0">Crear categoría</h4>
            
          </div><!-- /.col -->

        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header bg-primary">
               Ingrese la información de la nueva categoría
          </div>
          <div class="card-body">

            <form action="<?= SERVER_URL; ?>admin/app/ajax/Categorias_Ajax.php" method="post" class="formulario_ajax" data-form="save" autocomplete="off">
                  <input type="hidden" name="create" value="create">
                <div class="form-group">
                  <label for="">Nombre</label>
                  <input type="text" class="form-control form-control-sm" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ 0-9 ]{3,40}" name="nombre" maxlength="40" required />
                  
                </div>
            
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="descripcion">Descripción:</label>
                    <textarea class="form-control form-control-sm" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,150}" name="descripcion" id="descripcion" cols="6" rows="6" placeholder="Descripción de la categoria..." required></textarea>
                  </div>
                </div>

                  

                <div class="form-group text-right">
                  <a href="?view=categorias-list" class="btn btn-secondary btn-sm">Cancelar</a>
                  <input type="submit" class="btn btn-primary btn-sm" name="registrar"  value="Registrar"  />
                </div>

          </div>
                



                
            
              </form>
          </div>
        </div>
      </div>
    </div>

    
  </section>
    <!-- /.content -->
  </div>