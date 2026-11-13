let url = "./front/ajax/Carrito_ajax.php";

fetch(url, {
  method: "POST",
  headers: { "Content-Type": "application/json" },
  body: JSON.stringify({
    action: "leer-carrito",
  }),
})
  .then((data) => data.json())
  .then((data) => {
   //console.log(data);

    llenar_tabla_pasarela(data);
  });

function llenar_tabla_pasarela(data) {
  let tabla_pasarela_body = document.querySelector("#tabla_pasarela_body");
  tabla_pasarela_body.innerText = "";

  let TOTAL = 0;

  if (data.length > 0) {
    data.forEach((el, index) => {
      let precio = el.precio_venta;
      let total_prod = el.cantidad * precio;
      TOTAL = TOTAL + total_prod;

      tabla_pasarela_body.innerHTML += `<tr>
            <td align="center">${++index}</td>            
            <td class="bg-white" align="center" ><img src="./admin/app/Views/assets/images_productos/${el.imagen}" alt="" class="img-size-50  img-thumbnail" /></td>
            <td class="bg-white" align="left"  >${el.nombre} </td>
            <td class="bg-white" align="center" >${el.cantidad}</td>
            <td class="bg-white" align="center" ><b>$${precio}</b></td>
            <td class="bg-white" align="center" ><b>$${total_prod}</b></td>
            </tr>`;
    });

    tabla_pasarela_body.innerHTML += `
        <tr>
        <td class="bg-white p-2 text-right" colspan="5" ><h5><b>Total:</b></h5></td>
        <td class="bg-white p-2 text-center" ><h5><b> $${TOTAL}</b></h5></td>
        <input type="hidden" value="${TOTAL}" name="total" />
        </tr>
        `;
  } else {
    tabla_pasarela_body.innerHTML += `
        <tr>

        <td class="bg-white p-2 text-center" colspan="5"><p>El carrito esta vacío.<br> <a href="index.php?view=productos">Ir al catalogo de productos.</a></p></td>
     
        </tr>
        `;
  }
}
