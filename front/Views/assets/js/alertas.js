

const formularios_ajax = document.querySelectorAll('.formulario_ajax');

formularios_ajax.forEach( (form)=>{
    form.addEventListener('submit', enviarFormularioAjax );
});


function enviarFormularioAjax(e){
    e.preventDefault();

    let data = new FormData(this);
    let action = this.getAttribute('action');
    let method = this.getAttribute('method');
    let tipo = this.getAttribute('data-form');
    let encabezados = new Headers();

 

    let config = {
        method: method,
        headers:encabezados,
        mode:'cors',
        cache:'no-cache',
        body: data
    }

    

    let textoAlerta;

     if( tipo == 'save'){
        textoAlerta = 'Los datos se guardaran en la base de datos.';
     
    }else if(tipo == 'create_cliente'){
        textoAlerta = "Sí, crear mi cuenta de usuario."

    }else if( tipo == 'delete'){
        textoAlerta = 'Los datos serán eliminados del sistema.';
        
    }else if( tipo == 'update' ){
        textoAlerta = 'Los datos serán actualizados del sistema.';
        
    }else{
        textoAlerta = '¿Desea realizar la operación solicitada?';
    }

    Swal.fire({
        title : '¿Esta seguro?',
        html : textoAlerta,
        icon : 'question',
        confirmButtonText : 'Aceptar',
        confirmButtonColor: '#228B22',
        showCancelButton : true,
        cancelButtonColor: '#777',
        cancelButtonText: 'Cancelar'

    }).then( (result)=>{
        if( result.value ){                      
            fetch( action, config )
            .then( respuesta => respuesta.json())
            .then( respuesta => {
                console.log( respuesta );
                return alerta_ajax( respuesta );
            })
        }
    } );
    
}


function alerta_ajax( alerta ){

    if(alerta.Alerta == 'simple'){
        console.log("En las alertas, aqui....");
        Swal.fire({
            title : alerta.Titulo,
            html : alerta.Texto,
            icon : alerta.Tipo,
            confirmButtonText: 'Aceptar',
            confirmButtonColor: '#333',
        });

    }else if( alerta.Alerta == 'recargar'){
        Swal.fire({
            title : alerta.Titulo,
            html : alerta.Texto,
            icon : alerta.Tipo,
            confirmButtonText: 'Aceptar',
            confirmButtonColor: '#333'            
        }).then(( result )=>{
            if( result.value ){
                window.location.href=alerta.url;
                //location.reload();
            }
        });
    
    }else if( alerta.Alerta == 'limpiar' ){
        Swal.fire({
            title : alerta.Titulo,
            html : alerta.Texto,
            icon : alerta.Tipo,
            confirmButtonText: 'Aceptar',
            confirmButtonColor: '#333'
            
        }).then( (result)=>{
            if(result.value ){
                window.location.reload(true);
               
            }
        } );
    
    }else if( alerta.Alerta == 'redireccionar' ){
        window.location = alerta.URL;
    }

}












/*


const formularios_ajax = document.querySelectorAll('.Formulario_Ajax');

formularios_ajax.forEach( formularios =>{
    formularios.addEventListener( 'submit', enviarFormularioAjax );

});


function enviarFormularioAjax (e){ 
    e.preventDefault();

    let data = new FormData(this);
    let method = this.getAttribute('method');   // post
    let action = this.getAttribute('action');   //captura a donde va a ir,ejemplo.. ( action="<?= SERVER_URL; ?>ajax/usuario_Ajax.php" ) 
    let tipo = this.getAttribute('data-form');  // lo que tiene en ...( Ejemplo: data-form="save")

    
    let encabezados = new Headers();
    
    let config = {
        method : method,
        headers : encabezados,
        mode : 'cors',
        cache : 'no-cache',
        body: data
    }
 
   

     let textoAlerta;

     if( tipo == 'save'){
        textoAlerta = 'Los datos se guardaran en la base de datos.';
     
    }else if( tipo == 'delete'){
        textoAlerta = 'Los datos serán eliminados del sistema.';
        
    }else if( tipo == 'update' ){
        textoAlerta = 'Los datos serán actualizados del sistema.';
        
    }else if( tipo == 'search'){
        textoAlerta = 'El término de búsqueda será eliminado.<br>Deberá ingresar un nuevo término de búsqueda.';
        
    }else if( tipo == 'loans' ){
        textoAlerta = 'Desea remover los datos seleccionados para prestamos y reservaciones?';

    }else{
        textoAlerta = '¿Desea realizar la operación solicitada?';
    }

    Swal.fire({
        title : '¿Esta seguro?',
        html : textoAlerta,
        icon : 'question',
        confirmButtonText : 'Aceptar',
        confirmButtonColor: '#1190cb',
        showCancelButton : true,
        cancelButtonColor: '#555',
        cancelButtonText: 'Cancelar'
    }).then( (result)=>{
        if( result.value ){                      
            fetch( action, config )
            .then( respuesta => respuesta.json())
            .then( respuesta => {
                console.log( respuesta );
                return alerta_ajax( respuesta );
            })
        }
    } );



}





function alerta_ajax( alerta ){

    if(alerta.Alerta == 'simple'){
        Swal.fire({
            title : alerta.Titulo,
            html : alerta.Texto,
            icon : alerta.Tipo,
            confirmButtonText: 'Aceptar'
        });

    }else if( alerta.Alerta == 'recargar'){
        Swal.fire({
            title : alerta.Titulo,
            html : alerta.Texto,
            icon : alerta.Tipo,
            confirmButtonText: 'Aceptar'
        }).then(( result )=>{
            if( result.value ){
                location.reload();
            }
        });
    
    }else if( alerta.Alerta == 'limpiar' ){
        Swal.fire({
            title : alerta.Titulo,
            html : alerta.Texto,
            icon : alerta.Tipo,
            confirmButtonText: 'Aceptar'
        }).then( (result)=>{
            if(result.value ){
                window.location.reload(true);
                //document.querySelector('.Formulario_Ajax').reset();
            }
        } );
    
    }else if( alerta.Alerta == 'redireccionar' ){
        window.location = alerta.URL;
    }

} */