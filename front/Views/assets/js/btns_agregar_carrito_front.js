let btnsAgregarAlCarritoFront = document.querySelectorAll(
  "#btnAgregarAlCarritoFront"
);

btnsAgregarAlCarritoFront.forEach((el) => {
  el.addEventListener("click", (e) => {
    let producto = {
      id: e.target.getAttribute("data-id"),      
      cantidad: 1,
      action: "agregar-producto",
    };

    //console.log(producto);

    fetch("./front/ajax/Carrito_ajax.php", {
      method: "post",
      headers: { "Content-type": "application/json" },
      body: JSON.stringify(producto),
    })
      .then((res) => res.json())
      .then((res) => {
        if(res.status == 'success'){
          console.log(res);
          window.location.reload();
        }

        if(res.status == 'error'){
          window.location.reload();
        }

      });
  });
});
