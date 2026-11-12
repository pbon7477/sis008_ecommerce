//BOTON PARA HACER PEDIDO (Pasarela view)
(function () {
  let btn_pedido = document.querySelector("#btn_confirmar_pedido");  
  btn_pedido.addEventListener("click", (e)=>{
    e.preventDefault();
    confirmar_pedido();
  });

  //Leemos lo que tenga el carrito
  function confirmar_pedido() {
    btn_pedido.setAttribute("disabled", true);
    btn_pedido.innerText = "Enviando...";

    Swal.fire({
      title: "Confirmar pedido",
      html: "Se registrara su pedido y se abrirá WhatsApp para enviarlo",
      icon: "success",
      showConfirmButton: true,
      confirmButtonText: "Confirmar",
      confirmButtonColor: "#2994cd",
      showCancelButton: true,
      cancelButtonText: "Cancelar",
      cancelButtonColor: "#acacac",
    })
    .then((result) => {
      
      if (result.isConfirmed) {
        fetch("./front/ajax/Pedidos_ajax.php", {
          method: 'POST',
          headers: { 'Content-type': 'application/x-www-form-urlencoded' },
          body: new URLSearchParams({
            action: "pedido-create",
          }),
        })
          .then((res) => res.json())
          .then((res) => {
          
            
            btn_pedido.innerText = "Listo, pedido ingresado";
            document.querySelector('#check_accept').setAttribute('disabled', true);        
                       
            //campturamos la url y la odificamos para re-dirigir 
            let url = window.location.href;
            url = url.replace('view=pasarela','view=pedido-confirmado');
            window.location.href=url;
           

          });
      }

      if (result.isDismissed) {
        btn_pedido.innerHTML = "<i class='fa fa-paper-plane mr-1'></i>Hacer pedido";
        btn_pedido.removeAttribute('disabled');
        return;
      }
    });
  }
})();








