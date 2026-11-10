
<?php 

  require_once('app/Controllers/UserController.php');
  $UserController = new UserController();
  $usuario = $UserController->get_user();

?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row ">
          <div class="col-sm-6">
            <h4 class="m-0">Editar usuario</h4>
            
          </div><!-- /.col -->

        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->





    <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-6">

  <?php if( $usuario ){  ?>

    <div class="card">
          <div class="card-header bg-warning">
            <h5>Datos del usuario: <u><?= $usuario['nombre'];?></u></h5>

          </div>
          <div class="card-body">

            <form action="<?= SERVER_URL; ?>admin/app/ajax/Usuario_Ajax.php" method="post" class="formulario_ajax" data-form="update" autocomplete="off">
                <input type="hidden" name="update" value="update">
                <input type="hidden" name="id" value="<?= $usuario['id']; ?>" />
                <div class="form-group">
                  <label for="">Nombre*</label>
                  <input type="text" class="form-control form-control-sm" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" name="nombre" value="<?= $usuario['nombre']?>" maxlength="40" required />
                  
                </div>
            
                <div class="form-group">
                  <label for="">Email*</label>
                  <input type="email" class="form-control form-control-sm" name="email" value="<?= $usuario['email'];?>" maxlength="70" required />
                </div>
                
                <div class="form-group col-3">
                    <label for="nivel" class="form-label">Nivel</label>
                      <select class="form-control form-control-sm"  name="nivel" id="nivel">
                     
                   
                        <option  class="bg-light" value="0" <?= $usuario['nivel'] == '0' ? 'selected': ''; ?>  >0</option>
                        <option  class="bg-danger" value="1" <?= $usuario['nivel'] == '1' ? 'selected': ''; ?>  >1</option>
                        <option  class="bg-warning" value="2" <?= $usuario['nivel'] == '2' ? 'selected': ''; ?>  >2</option>
                        <option  class="bg-success" value="3" <?= $usuario['nivel'] == '3' ? 'selected': ''; ?>  >3</option>
                        <option  class="bg-secondary" value="4" <?= $usuario['nivel'] == '4' ? 'selected': ''; ?>  >4</option>
                      </select>
                </div>

                <small><b>Opcional:</b></small>
                <div class="form-group">
                  <label for="">Password</label>
                  <input type="password" class="form-control form-control-sm" name="password_1" pattern="[a-zA-Z0-9\$\@\.\-]{7,100}" maxlength="100"  />
                </div>
                
                <div class="form-group">
                  <label for="">Confirmar Password</label>
                  <input type="password" class="form-control form-control-sm" name="password_2" pattern="[a-zA-Z0-9\$\@\.\-]{7,100}" maxlength="100"  />
                </div>

                <div class="form-group text-right">
                  <a href="?view=usuarios-list" class="btn btn-secondary btn-sm">Cancelar</a>
                  <input type="submit" class="btn btn-warning btn-sm" name="actualizar"  value="Actualizar"  />
                </div>

                
            
              </form>
          </div>
        </div>
  
  <?php }else {    

      $UserController->alerta_auxiliar('Usuario no encontrado','?view=usuarios-list'); 
  
   } ?> 

      </div>
    </div>

    
  </section>
    <!-- /.content -->
  </div>