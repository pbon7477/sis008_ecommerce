
<?php 

  require_once('app/Controllers/CategoriasController.php');
  $CategoriasController = new CategoriasController();
  $categoria = $CategoriasController->get_category();

?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row ">
          <div class="col-sm-6">
            <h4 class="m-0">Editar categoría</h4>
           
          </div><!-- /.col -->

        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->





    <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-6">

  <?php if( $categoria ){  ?>

    <div class="card">
          <div class="card-header bg-warning">
            <h5>Datos de la categoría: <u><?= $categoria['nombre'];?></u></h5>

          </div>
          <div class="card-body">

            <form action="<?= SERVER_URL; ?>admin/app/ajax/Categorias_Ajax.php" method="post" class="formulario_ajax" data-form="update" autocomplete="off">
                <input type="hidden" name="update" value="update">
                <input type="hidden" name="id" value="<?= $categoria['id']; ?>" />

                  <div class="form-group">
                  <label for="">Nombre</label>
                  <input type="text" class="form-control form-control-sm" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ 0-9]{3,40}" name="nombre" maxlength="40" value="<?= $categoria['nombre']; ?>" required />
                  
                </div>
            
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="descripcion">Descripción:</label>
                    <textarea class="form-control form-control-sm" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,150}" name="descripcion" id="descripcion" cols="6" rows="6" placeholder="Descripción de la categoria..." required><?= $categoria['descripcion'];?></textarea>
                  </div>
                </div>
                

                

                <div class="form-group text-right">
                  <a href="?view=categorias-list" class="btn btn-secondary btn-sm">Cancelar</a>
                  <input type="submit" class="btn btn-warning btn-sm" name="actualizar"  value="Actualizar"  />
                </div>

                
            
              </form>
          </div>
        </div>
  
  <?php }else {    

      $CategoriasController->alerta_auxiliar('categoria no encontrada','?view=categorias-list'); 
  
   } ?> 

      </div>
    </div>

    
  </section>
    <!-- /.content -->
  </div>