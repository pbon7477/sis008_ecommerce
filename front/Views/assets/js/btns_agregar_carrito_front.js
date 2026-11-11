let btnsAgregarAlCarritoFront = document.querySelectorAll(
  "#btnAgregarAlCarritoFront",
);

btnsAgregarAlCarritoFront.forEach((el) => {
  el.addEventListener("click", (e) => {
    let producto = {
      id: e.target.getAttribute("data-id"),
      nombre: e.target.getAttribute("data-nombre"),
      imagen: e.target.getAttribute("data-imagen"),
      precio_venta: e.target.getAttribute("data-precio-venta"),
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
        //console.log(res);
        window.location.reload();
      });
  });
});
