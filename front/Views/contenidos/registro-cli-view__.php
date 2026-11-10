<div class="row">
    <div class="col-md-12">
        <h3>Registrarse </h3>
        <?php echo SERVER_URL;  ?>

        <?php 

        

        ?>
        
    </div>
</div>
<div class="row">
        <div class="col-md-4 mx-auto">
            <div class="card">
                <div class="card-header bg-dark">Crea tu cuenta</div>
                <div class="card-body login-card-body bg-light">
                    
                    <form action="<?php echo SERVER_URL;  ?>front/ajax/clientes_ajax.php" class="formulario_ajax" data-form="create_cliente" method="post">
                        <input type="hidden" name="create" value="create" >
                    <div class="form-group mb-3">
                        <label for="nombre" class="form-label" >Nombre</label>
                        <input type="text" class="form-control" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ _\-]{3,40}" name="nombre" id="nombre" required >
                    </div>

                    <div class="form-group mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="email" required >
                    </div>

                    <div class="form-group mb-3">
                        <label for="password1" class="form-label">Password:<small id="helpId" class="form-text text-muted">(Mayúsculas o minúsculas y mas de 7 caracteres.) </small></label>
                        <input type="password" class="form-control" pattern="[a-zA-Z0-9\$\@\.\-]{7,100}" name="password1" id="password1"  aria-describedby="helpId" > 
                        
                    </div>

                    <div class="form-group mb-3">
                        <label for="password2" class="form-label">Confirmar Password</label>
                        <input type="password" class="form-control" pattern="[a-zA-Z0-9\$\@\.\-]{7,100}" name="password2" id="password2" >
                        
                    </div>
                    
                    <div class=""> 
                        <a href="index.php?view=productos"><button type="button" class="btn btn-secondary">Cancelar</button>       </a>                
                        <button type="submit" class="btn btn-success float-right">Registrarse</button>
                    </div>

                    </form>
                </div>
            </div>
            
        </div>
</div>




