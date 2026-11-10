<script>

    let btn_logout = document.querySelector('#btn_logout');
    btn_logout.addEventListener('click', ()=>{
        

        Swal.fire({
            title:'¿Desea salir del sistema? ',
            text : 'La sesion actual se cerrara y saldara del sistema.',
            icon : 'question',
            showCancelButton : 'true',
            confirmButtonText : 'Aceptar',
            cancelButtonText : 'Cancelar',
            confirmButtonColor: '#333',
            cancelButtonColor: '#777'
       
        }).then( (result)=>{
            if(result.isConfirmed){

                 let url = '<?= SERVER_URL;?>admin/app/ajax/Login_Ajax.php';               

                 fetch( url, {method:'post', body:'ok' } )
                 .then( (response)=> response.text())
                 .then( (respuesta)=>{                                                                       

                    window.location='<?= SERVER_URL; ?>admin/';                


                 });
                 
            }

        
        });

    });
</script>