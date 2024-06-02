$(document).ready(function () {
  // Log In
  let $btn = $("#btn"),
    $form = $("#formulario"),
    $img = $(".cargador"),
    $alerta = $(".alerta"),
    $alerta_contenido = $(".alerta_wrapper");

  $btn.on("click", function (e) {
    e.preventDefault();
    let datos = $form.serialize();
    url = "../lib/validar_login.php";

    // Para trabajar dinamicamente con la aplicación
    $.ajax({
      type: "POST",
      url: url,
      data: datos,
      dataType: "json",
      beforeSend: function () {
        console.log("beforeSend");
        $img.css({ display: "block" });
      },
      complete: function () {
        console.log("complete");
        $img.css({ display: "none" });
      },
      success: function (respuesta) {
        if (respuesta.error) {
          $alerta.css({ display: "block" });
          $alerta_contenido.html(respuesta.tipo_error);
        } else {
          if (respuesta.rol == "administrador") {
            $(location).attr("href", "../sesiones/admin.php");
          } else {
            window.location.href =
              "../sesiones/socios.php?timestamp=" + new Date().getTime();
          }
        }
      },
      error: function (e) {
        console.log("Error en la solicitud AJAX:", e);
        console.log("Respuesta del servidor:", e.responseText);
      },
    });
  });
  // Log Out
  let $logout = $("#logout");

  $logout.on("click", function () {
    console.log("logout");
    $.ajax({
      type: "POST",
      url: "../pages/logout.php",
      dataType: "html",
      success: function (e) {
        $(location).attr("href", "../index.php");
      },
    });
  });

  // Elimnar
  let id;

  let $eliminar = $("#accion_eliminar");

  console.log("antes primer click" + id)


  
  $(document).on("click", ".accion_eliminar", function (e) {
    e.preventDefault();
    // id = $(this).closest('tr').attr("data-id");
    // $("#si").data("id", id);
    // $('.modal-footer #si').attr("data-id", id);
    // $("#caja_modal").modal("show");
    // console.log("primer click" + data)

    console.log("hola soly botony")
    console.log($eliminar)


});

$("#si").on("click", function () {
    let id = $(this).data("id");
    console.log("id antes de ajax "+ id);
    $.ajax({
        type: "POST",
        url: "../lib/eliminar.php",
        data: { eliminar: id },
        dataType: "json",
        success: function (response) {
          console.log("dentro de success")
            if (response.estado == "ok") {
                $("#caja_modal").modal("hide");
                $("tr[data-id='" + id + "']").css({
                    background: "red",
                    color: "white"
                }).slideUp(2000);
            } else {
                alert("A ocurrido un error");
            }
        },
        error: function (err) {
            console.log(err);
        }
    });
});

});
