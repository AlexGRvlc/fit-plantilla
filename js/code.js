$(document).ready(function () {
  // Log In
  let $btn = $("#btn_login"),
    $form = $("#formulario"),
    $img = $(".cargador"), // --> !
    $alerta = $(".alerta"),
    $alerta_contenido = $(".alerta_wrapper");

  $btn.on("click", function (e) {
    e.preventDefault();
    let datos_registro = $form.serialize();
    url = "../lib/validar_login.php";

    // Para trabajar dinamicamente con la aplicación
    $.ajax({
      type: "POST",
      url: url,
      data: datos_registro,
      dataType: "json",
      beforeSend: function () {
        // animación
        $img.css({ display: "block" });
      },
      complete: function () {
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
  
 // Registro
    let $btn_registro = $("#btn_registro"),
        $alerta_registro = $("#error_registro"),
        $alerta_contenido_registro = $("#msg_error_registro");
  
    $btn_registro.on("click", function (e) {
      e.preventDefault();
      $alerta_registro.css({ display: "none" });
      let formData_registro = new FormData(document.getElementById("form_registro"));
      let $url_registro = "../lib/validar_registro.php";
  
      $.ajax({
        type: "POST",
        url: $url_registro,
        data: formData_registro,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (response) {



          if (response.error) {
            $alerta_registro.css({ display: "block" });
            $alerta_contenido_registro.html(response.tipo_error);
          } else {
          }
          },
          error: function (e) {
          console.log("Error en la solicitud AJAX:", e);
          console.log("Respuesta del servidor:", e.responseText);
        },
      });
    });
  
  

  // Eliminar
  let id;


  $(document).on("click", ".accion_eliminar", function (e) {
    e.preventDefault();
    id = $(this).closest("tr").attr("data-id");
    $("#si").data("id", id);
    $(".modal-footer #si").attr("data-id", id);
    $("#caja_modal").modal("show");
  });

  $("#si").on("click", function () {
    let id = $(this).data("id");

    $.ajax({
      type: "POST",
      url: "../lib/eliminar.php",
      data: { eliminar: id },
      dataType: "json",
      success: function (response) {
        if (response.estado == "ok") {
          $("#caja_modal").modal("hide");
            location.reload();
        } else {
          alert("A ocurrido un error");
        }
      },
      error: function (err) {
        console.log(err);
      },
    });
  });

  // Editar
  $("#limpiarBusqueda").on("click", function () {    
    var baseUrl = window.location.origin + window.location.pathname; // Obtiene la URL base sin parámetros
    window.location.href = baseUrl;
  });

  $(".accion_editar").on("click", function (e) {
    e.preventDefault();

    let id = $(this).data("id");
    let nombre = $(this).data("nombre");
    let apellido = $(this).data("apellido");
    let email = $(this).data("email");
    let saldo = $(this).data("saldo");

    $("#edit_id").val(id);
    $("#edit_nombre").val(nombre);
    $("#edit_apellido").val(apellido);
    $("#edit_email").val(email);
    $("#edit_saldo").val(saldo);

    $("#modal_editar").css({ display: "block" });
    // $("#fondo_oscuro").modal(show);
  });

  $(".btn_actualizar").on("click", function (e) {
    e.preventDefault();

    let formData_editar = new FormData(document.getElementById("form_editar"));

    $.ajax({
      type: "POST",
      url: "../lib/actualizar_socio.php",
      data: formData_editar,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function (response) {
        console.log(response.path_foto)
        if (response.estado === "ok") {
          // alert(rsponse.msg)
          $("#modal_editar").css({ display: "block" });
          location.reload(); // Recargar la página para ver los cambios
        } else {
          console.log("Error en la solicitud AJAX:", response.msg);
          alert("Ocurrió un error: " + response.msg);
        }
      },
      error: function (err) {
        console.log(err);
        location.reload();
      },
    });
  });

  // $("#btn_buscar").on("click", function(e){
  //   e.preventDefault();
  //   $("#limpiarBusqueda").css({ display: "block" });

  // })
});
