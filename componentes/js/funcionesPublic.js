// Example starter JavaScript for disabling form submissions if there are invalid fields
(function () {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  var forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
  Array.prototype.slice.call(forms)
    .forEach(function (form) {
      form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }
        form.classList.add('was-validated')
      }, false)
    })
})()

function realizar(id) {
  Swal.fire({
    title: "NOTA",
    text: "Tenga en cuenta que una vez inicie el tiempo iniciara, en caso de que ocurra un inconveniente en la realización del examen comuníquese inmediatamente con la empresa.",
    showCancelButton: true,
    confirmButtonColor: "#157347",
    cancelButtonColor: "#6c757d",
    cancelButtonText: "Cancelar",
    confirmButtonText: "Continuar",
  }).then((result) => {
    if (result.isConfirmed) {
      location.href = "../curso/?realizar-capacitacion=" + id + "&fase=1";
    }
  });
}

function cursos(id, acciones) {
  var datos = {
    codigo: id,
    accion: acciones,
  };
  $.ajax({
    url: "acciones-ajax/acciones_curso.php",
    type: "post",
    data: datos,
    success: function (id_respuesta) {
      $("#id_respuesta").html(id_respuesta);
    },
  });
}

function realizarFase3(id) {
  Swal.fire({
    title: "NOTA",
    text: "Recuerde ver todo el video para un mejor desempeño.",
    showCancelButton: true,
    confirmButtonColor: "#157347",
    cancelButtonColor: "#6c757d",
    cancelButtonText: "Cancelar",
    confirmButtonText: "Continuar",
  }).then((result) => {
    if (result.isConfirmed) {
      location.href = "../curso/?realizar-capacitacion=" + id + "&fase=3";
    }
  });
}

function finalizar() {
  Swal.fire({
    title: "NOTA",
    icon: "info",
    text: "Antes de enviar verificar que esten respondidas todas preguntas",
    showCancelButton: true,
    confirmButtonColor: "#0d6efd",
    cancelButtonColor: "#6c757d",
    cancelButtonText: "Volver",
    confirmButtonText: "Enviar",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "acciones-ajax/respuesta.php",
        type: "post",
        data: $("#form_respuesta").serialize(),
        beforeSend: function () {
          $("#id_respuesta")
            .html(id_respuesta)
            .html(
              '<div class="text-center"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>'
            );
        },
        success: function (id_respuesta) {
          $("#id_respuesta").html(id_respuesta);
        },
      });
    }
  });
}

function buscarCursoPublicos(pag) {
  var name = $("#busqueda-cursos-publicos").val();
  $.ajax({
    url: "cursos.php",
    method: "POST",
    data: { buscar: name, pagina: pag },
    beforeSend: function () {
      $("#lista-cursos").html(
        '<div class="text-center"><div class="spinner-border text-secondary" role="status"></div></div>'
      );
    },
    success: function (usuarios) {
      $("#lista-cursos").html(usuarios);
      if (pag != 1) document.getElementById("pagina" + pag).scrollIntoView();
    },
  });
}

function buscarCursoResueltos(pag) {
  var name = $("#busqueda-cursos-resueltos").val();
  $.ajax({
    url: "usuario/mis_resultados.php",
    method: "POST",
    data: { buscar: name, pagina: pag },
    beforeSend: function () {
      $("#cursos-resueltos").html(
        '<div class="text-center"><div class="spinner-border text-secondary" role="status"></div></div>'
      );
    },
    success: function (usuarios) {
      $("#cursos-resueltos").html(usuarios);
      if (pag != 1) document.getElementById("pagina" + pag).scrollIntoView();
    },
  });
}

