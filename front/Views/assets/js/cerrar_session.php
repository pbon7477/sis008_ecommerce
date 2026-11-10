<?php 

if(isset($_SESSION['id_cliente'])) { ?>

<script>


  let btn_cerrar_sesion = document.querySelector("#btn_cerrar_sesion");
  btn_cerrar_sesion.addEventListener("click", (e) => {
    Swal.fire({
      title: "Cerrar sesión",
      html: "<p>¿Esta seguro que deseaa cerrar tu sesion?</p>",
      icon: "question",
      showConfirmButton: true,
      confirmButtonColor: "#2994cd",
      confirmButtonText: "Sí, cerrar sesión",
      showCancelButton: true,
      cancelButtonText: "Cancelar",
    }).then((result) => {
      if (result.isConfirmed) {
        const action = "auth";
        const type = "logout";

        fetch("./front/ajax/login_cli_ajax.php", {
          method: "POST",
          header: { "Content-Type": "application/json" },
          body: JSON.stringify({
            action: action,
            type: type,
          }),
        })
          .then((response) => response.json())
          .then((res) => {
            if (res.status) {
              sessionStorage.removeItem("id_cliente");
              sessionStorage.removeItem("nombre_cliente");
              sessionStorage.removeItem("email_cliente");

              window.location.reload();
            }
          });
      }
    });
  });

</script>

<?php } ?>