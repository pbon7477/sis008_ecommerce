
<?php 

  require_once('app/Controllers/UserController.php');
  $UserController = new UserController();
  $mi_perfil = $UserController->get_my_user();

?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row 2">
          <div class="col-sm-6">
            <h4 class="m-0">Editar mi perfil</h4>
            
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
          <div class="card-header bg-danger">
            <h5>Datos del usuario: <u><?= $mi_perfil['nombre'];?></u></h5>

          </div>
          <div class="card-body">

            <form action="<?= SERVER_URL; ?>admin/app/ajax/Usuario_Ajax.php" method="post" class="formulario_ajax" data-form="update" autocomplete="off">
                <input type="hidden" name="update" value="update">
                <input type="hidden" name="id" value="<?= $mi_perfil['id']; ?>" />
                <div class="form-group">
                  <label for="">Nombre*</label>
                  <input type="text" class="form-control form-control-sm" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" name="nombre" value="<?= $mi_perfil['nombre']?>" maxlength="40" required />
                  
                </div>
            
                <div class="form-group">
                  <label for="">Email*</label>
                  <input type="email" class="form-control form-control-sm" name="email" value="<?= $mi_perfil['email'];?>" maxlength="70" required />
                </div>
                
                <div class="form-group col-3">
                    <label for="nivel" class="form-label">Nivel</label>
                     <select class="form-control form-control-sm"  name="nivel" id="nivel">                   
                        <option  class="bg-light" value="0" <?= $mi_perfil['nivel'] == '0' ? 'selected': ''; ?>  >0</option>
                        <option  class="bg-danger" value="1" <?= $mi_perfil['nivel'] == '1' ? 'selected': ''; ?>  >1</option>
                        <option  class="bg-warning" value="2" <?= $mi_perfil['nivel'] == '2' ? 'selected': ''; ?>  >2</option>
                        <option  class="bg-success" value="3" <?= $mi_perfil['nivel'] == '3' ? 'selected': ''; ?>  >3</option>
                        <option  class="bg-secondary" value="4" <?= $mi_perfil['nivel'] == '4' ? 'selected': ''; ?>  >4</option>
                      </select>
                </div>      
                
                <small><b>Obligatorio:</b></small>
                <div class="form-group">
                  <label for="">Password</label>
                  <input type="password" class="form-control form-control-sm" name="password_1" pattern="[a-zA-Z0-9\$\@\.\-]{7,100}" maxlength="100" required />
                </div>
                
                <div class="form-group">
                  <label for="">Confirmar Password</label>
                  <input type="password" class="form-control form-control-sm" name="password_2" pattern="[a-zA-Z0-9\$\@\.\-]{7,100}" maxlength="100" required />
                </div>

                <div class="form-group text-right">
                  <a href="?view=panel" class="btn btn-secondary btn-sm">Cancelar</a>
                  <input type="submit" class="btn btn-danger btn-sm" name="actualizar"  value="Actualizar"  />
                </div>

                
            
              </form>
          </div>
        </div>
  
  

      </div>
    </div>

    
  </section>
    <!-- /.content -->
  </div>