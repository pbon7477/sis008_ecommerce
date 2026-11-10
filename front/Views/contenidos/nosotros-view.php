<div class="row">
    <div class="col-md-12">

        <div class="header-section">
            <div>

                <h5><i class="fa fa-building sub-icon-blue mr-2"></i>Nosotros</h5>
                <p>Información de la empresa</p>
            </div>

        </div>




    </div>
</div>

<style>
    .logo-nosotros{       
                
      
        border-radius:3px; 
    
        height:280px;
    }

    .marc-article{
        display:flex;
        justify-content:center;
        border:1px solid #d1d1d1;
        border-radius:3px;
        padding:20px;
        margin: 6px 4px 6px;
        height:auto;
        background-color:white;
    }

    .logo-nosotros-50 img{        
        height:120px;    
        
        
    }

    #nosotros_label, #mision_label, #vision_label, #procesos_label, #politicas_label{
        scroll-margin-top:100px;
    }





</style>


<div class="container">

    <!-- logo y menu-->
    <div class="row justify-content-start align-items-stretch g-2">

    
        <div class="col-lg-6 bg-light ">
            
            
            <div class="">
                <ul
                class="nav bg-light justify-content-start alig flex-column g-0" 
                >
                <li class="nav-item">
                    <a class="nav-link" href="#nosotros_label" aria-current="page" >Nosotros</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#mision_label">Misión</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#procesos_label">Procesos y etapas</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="#politicas_label">Politicas (documentación) </a>
                    </li>
                    
                </ul>
                   
            </div>
            
        </div>
        
        

        <div class="col-lg-6 my-5 ">
            <label id="nosotros_label"></label> 
            
            
            
                <div class="d-flex justify-content-center align-items-center "       >
                    <a class=""  href="<?= SERVER_URL; ?>">
                        <img src="./admin/app/Views/assets/images/logo.png" class="logo-nosotros" alt="Logo" height="32">
                    </a>
                    
                </div>
                
            </div>
            
            
            
            
        </div>
        
        <br><br>
        
        
        <!-- //nosotros -->
        
        <div class="row justify-content-start align-items-center-start g-2">
            <div class="col-lg-6 ">
                
                <h4>Nosotros</h4>
                <br/>
                
                <div class="marc-article" id="nosotros">
                    <p>Es esta zona va la descripcion de las operaciónes de la empresa o emprendimiento en ejecución, se deberia explicar enumeradamente que es lo que se hace o pretende hacer, realizar, conyevar, accionar, etc. Seguir siempre un estilo ordenado y secuencial para que se pueda entender en un texto simple y rapido de leer.</p>
                    <br>
                </div>
                
            </div>
            
        </div>
        
        
        
        
        <!-- //mision -->
        <label id="mision_label"></label>
        <div  class="row my-5 " >
            
            
            <div class="col-lg-6 col-12  ">
                
                <h4>Misión</h4>
                <br/>
                
                <div class="marc-article" >
                    <p>Descripci mb-5on de la misíon , abordar detalles descriptivos de lo que se hace y los objetivos que se pretenden lograr a corto, mediano y largo plazo.</p>
                </div>
            </div>
            
            <div class="col-lg-6  border border-0 p-0">
                <div class="">
                    <img src="<?= SERVER_URL; ?>front/Views/assets/images/mision.png" alt="foto de la mision" /> 
                </div>
            </div>
            
            
            
        </div>
        
        
        
        
        <!-- procesos -->
        <label id="procesos_label"></label>
        <h3>Procesos y etapas</h3>
        <div class="row justify-content-center align-items-center g-2 my-5 marc-article"  id="procesos">
            
            <div class="col-lg-4 mb-5 ">
                <h6>Primera etapa</h6>
                <div class="marc-article  bg-light" >
                    <p>Mini contenido agregado para dar mas detalle o simplemente mostrar un link a otra parte</p>
                    
                </div>
                
            </div>
            <div class="col-lg-4 mb-5 ">
                <h6>Desarrollo</h6>
                <div class="marc-article  bg-light" >
                    <p>Mini contenido agregado para dar mas detalle o simplemente mostrar un link a otra parte</p>
                    
                </div>
                
            </div>
            <div class="col-lg-4 mb-5 ">
                <h6>Actualidad</h6>
                <div class="marc-article  bg-light" >
                    <p>Mini contenido agregado para dar mas detalle o simplemente mostrar un link a otra parte</p>
                    
        </div>
        
    </div>
    
</div>









<h3>Politicas (documentación)</h3>
<label id="politicas_label"></label>
<div class="row">
    <div class="col-12" id="politicas" >
        
        <div class="border border-seconary bg-light p-2 my-2 ">
            <ul class="nav justify-content-start flex-column" >
                <li class="nav-item">
                    <a href="<?= SERVER_URL; ?>index.php?view=terminos-y-condiciones">Terminos y condiciónes</a>
                </li>
                <li class="nav-item">
                    <a href="<?= SERVER_URL; ?>index.php?view=politica-de-privacidad">Políticas de privacidad</a>
                </li>
                
            </ul>
        </div>
        
    </div>
</div>

<br><br><br>
<br><br><br>
<br><br><br>
<br><br><br>






</div>