$(document).ready(function () {
  //leer_carrito y llenar listado en el nav(cantidad en el icono)
  $.ajax({
    type: "post",
    url: "./front/ajax/Leer_carrito.php",
    dataType: "json",
    success: function (response) {
      llenar_carrito(response);
    },
  });

  // TABLA CARRITO
  //leer_carrito y llenar tabla
  $.ajax({
    type: "post",
    url: "./front/ajax/Leer_carrito.php",
    dataType: "json",
    success: function (response) {
      llenar_tabla_carrito(response);
    },
  });

  //BOTON PARA INCREMENTAR O DECREMENTAR PRODUCTOS DEL CARRITO
  $(document).on("click", "#btn_mas, #btn_menos", function (e) {
    e.preventDefault();
    let id = $(this).data("id");
    let action = $(this).data("action");

    $.ajax({
      type: "post",
      url: "./front/ajax/Cambiar_cantidad_producto.php",
      data: { id: id, action: action },
      dataType: "json",
      success: function (response) {
        llenar_carrito(response);
        llenar_tabla_carrito(response);
      },
    });
  });

  //Boton para agregar productos al carrito
  //(Apunta al modulo detalle de producto)
  $("#btnAgregarAlCarrito").click(function (e) {
    e.preventDefault();
    let id = $(this).data("id");
    let nombre = $(this).data("nombre");
    let imagen = $(this).data("imagen");
    let cantidad = $("#cantidad_producto").val();
    let precio_venta = $(this).data("precio-venta");

    let producto = {
      id: id,
      nombre: nombre,
      imagen: imagen,
      cantidad: cantidad,
      precio_venta: precio_venta,
    };

    $.ajax({
      type: "post",
      url: "./front/ajax/Agregar_carrito.php",
      data: producto,
      dataType: "json",
      success: function (response) {
        llenar_carrito(response);
      },
    });
  });

  //BOTON BORRAR CARRITO (En el listado en el navbar)
  $(document).on("click", "#borrar_carrito", function (e) {
    e.preventDefault();

    Swal.fire({
      title: "Borrar carrito",
      text: "¿Esta seguro que desea borrar el carrito? ",
      icon: "info",
      confirmButton: true,
      confirmButtonText: "Si, vaciar",
      confirmButtonColor: "#d33",
      showCancelButton: true,
      cancelButtonText: "No, Cancelar",
      canclButtonColor: "#3085d6",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "post",
          url: "./front/ajax/Borrar_carrito.php",
          dataType: "json",
          success: function (response) {
            llenar_carrito(response);
            window.location.reload();
          },
        });
      }
    });
  });
});

//BOTON ELIMINAR PRODUCTO DEL CARRITO
//(En la tabla del carrito)
$(document).on("click", "#btn_borrar_producto", function (e) {
  e.preventDefault();
  let id = $(this).data("id");

  $.ajax({
    type: "post",
    url: "./front/ajax/Borrar_producto_carrito.php",
    data: { id: id },
    dataType: "json",
    success: function (response) {
      llenar_carrito(response);
      llenar_tabla_carrito(response);
    },
  });
});

//FUNCION PARA LLENAR EL LISTADO DEL CARRITO EN EL NAVBAR
function llenar_carrito(response) {
  //Obtenemos y cargamos el numero de la cantidad de productos agregados(Numero en el carrito )
  let cantidad_productos = Object.keys(response).length;

  //Si el carrito tiene algo?
  if (cantidad_productos > 0) {
    $("#badgeProductos").text(cantidad_productos);
    $("#badgeProductos_2").text(cantidad_productos);
    
  } else {
    $("#badgeProductos").text("");
    $("#badgeProductos_2").text("");
  }
}

//FUNCION PARA LLENA LA TABLA DEL CARRITO
function llenar_tabla_carrito(response) {
  if (response.length > 0) {
    let TOTAL = 0;

    $("#tabla_carrito_body").text("");

    response.forEach((prod,index) => {
      let total_precio = prod.cantidad * prod.precio_venta;
      TOTAL = TOTAL + total_precio;
      $("#tabla_carrito_body").append(`
                <tr>
                <td class="text-center">${++index}</td>
                 <td class="text-center" > <img src="./admin/app/Views/assets/images_productos/${prod.imagen}" alt="" class="img-size-50  img-thumbnail" /> </td>
                 <td class="bg-light" style="width:1%; white-space:nowrap; padding-right:10px;">${prod.nombre}</td>
                 <td class="bg-light " style="width:1%; white-space:nowrap; padding-right:20px;"><b>$${prod.precio_venta}</b></td>
                 <td class="bg-light text-left" style="width:1%;" >

                 <div class="d-flex justify-content-start">

                 <div class="d-flex justify-content-evenly ">
                  <button class=""  data-id="${prod.id}" data-action="menos" id="btn_menos"><i class="fas fa-minus mx-0 my-1"></i></button>  
                    <span class="mx-2 f-2"> ${prod.cantidad}</span>
                  <button class=""  data-id="${prod.id}" data-action="mas" id="btn_mas"><i class="fas fa-plus mx-0 my-1"></i></button>   
                    
                 </div>


                 </div>

                    </td>
                 
                 <td class="bg-light" class="text-center"><b>$${total_precio}</b></td>
                 <td class="" id="action"><button class="btn btn-sm btn-outline-danger" id="btn_borrar_producto" data-id="${prod.id}" title="Eliminar producto del carrito" ><i class="fas fa-trash"></i></button></td>

                
                </tr>
                `);
    });

    $("#tabla_carrito_body").append(`
                <tr class="">
                    <td class=" p-2 text-right" colspan="4" ><h5><b>Total:</b></h5></td>
                    <td class=" p-2 text-left border "><h5><b>$${TOTAL}</b></h5></td>
                    <td></td>
                </tr>    
            `);
  } else {
    $("#tabla_carrito").text(``);
    $("#tabla_carrito").append(`
                    <div class="text-center ">
                     <p>No hay productos agregados al carrito.</p>                    
                     <a href="index.php?view=productos" class="btn btn-sm btn-primary mt-3">Ir al listado de productos</a>
                    </div>
                    `);

    $("#btns_volver_a_productos_y_datos_cliente").text("");
  }
}
