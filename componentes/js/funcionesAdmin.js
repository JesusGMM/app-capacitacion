$(document).ready(function () {
  $("#empresa").select2({
    theme: "classic",
    placeholder: "Seleccionar empresa",
  });
  $("#sede").select2({
    theme: "classic",
  });
});

(function () {
  var forms = document.querySelectorAll(".needs-validation-empresa");
  Array.prototype.slice.call(forms).forEach(function (form) {
    form.addEventListener(
      "submit",
      function (event) {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add("was-validated");
      },
      false
    );
  });
})();

(function () {
  var forms = document.querySelectorAll(".needs-validation-sede");
  Array.prototype.slice.call(forms).forEach(function (form) {
    form.addEventListener(
      "submit",
      function (event) {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add("was-validated");
      },
      false
    );
  });
})();

(function () {
  var forms = document.querySelectorAll(".needs-validation-usuario");
  Array.prototype.slice.call(forms).forEach(function (form) {
    form.addEventListener(
      "submit",
      function (event) {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add("was-validated");
      },
      false
    );
  });
})();

function despublicar(id) {
  Swal.fire({
    title: "¿Está seguro de mover a borrador?",
    text: "Tenga en cuenta que una vez inicie el tiempo empesara",
    icon: "question",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#6c757d",
    cancelButtonText: "Cancelar",
    confirmButtonText: "Despublicar",
  }).then((result) => {
    if (result.isConfirmed) {
      cursos(id, "despublicar");
    }
  });
}

function eliminar(id) {
  Swal.fire({
    title: "¿Está seguro de eliminar la capacitacion?",
    text: "Esta operación no se puede deshacer",
    icon: "question",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#6c757d",
    cancelButtonText: "Cancelar",
    confirmButtonText: "Eliminar",
  }).then((result) => {
    if (result.isConfirmed) {
      cursos(id, "eliminar");
    }
  });
}

function subirImagen(event) {
  var name = document.getElementById("file").files[0].name;
  var ext = name.split(".").pop().toLowerCase();
  if (jQuery.inArray(ext, ["gif", "png", "jpg", "jpeg"]) == -1) {
    Swal.fire({
      position: "top-center",
      icon: "warning",
      title: "Archivo de imagen no válido",
      showConfirmButton: true,
    });
    document.getElementById("file").value = "";
  } else {
    var f = document.getElementById("file").files[0];
    if (f.size > 4194304) {
      Swal.fire({
        position: "top-center",
        icon: "warning",
        title: "El tamaño del archivo de imagen es muy grande",
        showConfirmButton: true,
      });
      document.getElementById("file").value = "";
    } else {
      readFile(event.target);
    }
  }
}

function readFile(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      var filePreview = document.createElement("img");
      filePreview.id = "file-preview";
      filePreview.style.cssText = "height:250px; width:100%";
      //e.target.result contents the base64 data from the image uploaded
      filePreview.src = e.target.result;
      // console.log(e.target.result);
      document.getElementById("file-preview-zone").innerHTML = "";
      var previewZone = document.getElementById("file-preview-zone");
      previewZone.appendChild(filePreview);
    };
    reader.readAsDataURL(input.files[0]);
  }
}

function eliminarPregunta(codigo) {
  Swal.fire({
    title: "¿Esta seguro de eliminar esta pregunta?",
    text: "",
    icon: "question",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#3085d6",
    cancelButtonText: "Cancelar",
    confirmButtonText: "Eliminar",
  }).then((result) => {
    if (result.isConfirmed) {
      GuardarPregunta(4, codigo);
    }
  });
}
function GuardarPregunta(accion, codigo) {
  var form = $("#form-preguntas")[0];
  var formData = new FormData(form);
  formData.append("accion", accion);
  formData.append("codigo", codigo);
  $.ajax({
    url: "acciones-ajax/guardar_preguntas.php",
    type: "post",
    data: formData,
    contentType: false,
    cache: false,
    processData: false,
    success: function (id_respuesta) {
      $("#id_respuesta").html(id_respuesta);
    },
  });
}

function eliminarCapAsignada(idCap, idUsuario) {
  $.ajax({
    url: "acciones-ajax/asignar_capacitaciones.php",
    type: "post",
    data: { codigo: idCap, usuario: idUsuario, accion: "quitar_capacitacion" },
    success: function (id_respuesta) {
      $("#id_respuesta").html(id_respuesta);
    },
  });
}

function vermodal(accion, id) {
  var form_data = new FormData();
  form_data.append("accion", accion);
  form_data.append("id_usuario", id);
  $.ajax({
    url: "componentes/modal.php",
    method: "POST",
    data: form_data,
    contentType: false,
    cache: false,
    processData: false,
    success: function (id_modal) {
      $("#id_modal").html(id_modal);
    },
  });
}

function vermodalempresa(accion, id) {
  var form_data = new FormData();
  form_data.append("accion", accion);
  form_data.append("id_empresa", id);
  $.ajax({
    url: "componentes/modal_empresa.php",
    method: "POST",
    data: form_data,
    contentType: false,
    cache: false,
    processData: false,
    success: function (id_modal) {
      $("#id_modal").html(id_modal);
    },
  });
}

function vermodalsede(accion, id) {
  var form_data = new FormData();
  form_data.append("accion", accion);
  form_data.append("id_sede", id);
  $.ajax({
    url: "componentes/modal_sede.php",
    method: "POST",
    data: form_data,
    contentType: false,
    cache: false,
    processData: false,
    success: function (id_modal) {
      $("#id_modal").html(id_modal);
    },
  });
}

function buscarUsuario(pag) {
  var name = $("#busqueda").val();
  $.ajax({
    url: "usuario/listado_usuarios.php",
    method: "POST",
    data: { buscar: name, pagina: pag },
    beforeSend: function () {
      $("#lista-usuarios").html(
        '<div class="text-center"><div class="spinner-border text-secondary" role="status"></div></div>'
      );
    },
    success: function (usuarios) {
      $("#lista-usuarios").html(usuarios);
      if (pag != 1) document.getElementById("pagina" + pag).scrollIntoView();
    },
  });
}

function listarSedesEmpresa(id, accion) {
  $.ajax({
    url: "componentes/listar_sedes.php",
    method: "POST",
    data: { idempresa: id, acion: accion },
    success: function (usuarios) {
      $("#cargar-sedes").html(usuarios);
    },
  });
}

function asignar() {
  $.ajax({
    url: "acciones-ajax/asignar_capacitaciones.php",
    type: "post",
    data: $("#form-asignar").serialize(),
    success: function (id_respuesta) {
      $("#id_respuesta").html(id_respuesta);
    },
  });
}

function eliminarUsuario(idUsuario) {
  var datos = { id: idUsuario };
  $.ajax({
    url: "acciones-ajax/eliminar_usuario.php",
    type: "post",
    data: datos,
    success: function (id_respuesta) {
      $("#id_respuesta").html(id_respuesta);
    },
  });
}

function editar() {
  $.ajax({
    url: "acciones-ajax/editar_usuario.php",
    type: "post",
    data: $("#form-editar").serialize(),
    success: function (id_respuesta) {
      $("#id_respuesta").html(id_respuesta);
    },
  });
}
function listadoCurso(activar) {
  if (activar == 1) {
    $("#borrador").removeClass("active");
    $("#publicar").addClass("active");
    $("#publicas").show();
    $("#borradores").hide();
  } else {
    $("#publicar").removeClass("active");
    $("#borrador").addClass("active");
    $("#publicas").hide();
    $("#borradores").show();
  }
}

function buscarCursoBorrador(pag) {
  var name = $("#busqueda-cursos-publicos").val();
  $.ajax({
    url: "cursos.php",
    method: "POST",
    data: { buscar: name, pagina: pag },
    success: function (usuarios) {
      $("#lista-cursos").html(usuarios);
      $("#publicar").removeClass("active");
      $("#borrador").addClass("active");
      $("#publicas").hide();
      $("#borradores").show();
      if (pag != 1) document.getElementById("pagina" + pag).scrollIntoView();
    },
  });
}

function buscarCursoInformes(pag) {
  var name = $("#busqueda-cursos-informe").val();
  var rol = $("#rol").val();
  $.ajax({
    url: "componentes/curso_informe.php",
    method: "POST",
    data: { buscar: name, pagina: pag, rol: rol },
    beforeSend: function () {
      $("#informe-cursos").html(
        '<div class="text-center"><div class="spinner-border text-secondary" role="status"></div></div>'
      );
    },
    success: function (usuarios) {
      $("#informe-cursos").html(usuarios);
      if (pag != 1) document.getElementById("pagina" + pag).scrollIntoView();
    },
  });
}

function buscarCursoEmpresa(pag, id) {
  var name = $("#busqueda-cursos-empresa").val();
  $.ajax({
    url: "empresa/mis_cursos.php",
    method: "POST",
    data: { buscar: name, pagina: pag, idempresa: id },
    beforeSend: function () {
      $("#cursos-asigandos-empresa").html(
        '<div class="text-center"><div class="spinner-border text-secondary" role="status"></div></div>'
      );
    },
    success: function (usuarios) {
      $("#cursos-asigandos-empresa").html(usuarios);
      if (pag != 1) document.getElementById("pagina" + pag).scrollIntoView();
    },
  });
}

function buscarCursoSede(pag, id) {
  var name = $("#busqueda-cursos-sede").val();
  $.ajax({
    url: "sede/mis_cursos.php",
    method: "POST",
    data: { buscar: name, pagina: pag, idsede: id },
    beforeSend: function () {
      $("#cursos-asigandos-sede").html(
        '<div class="text-center"><div class="spinner-border text-secondary" role="status"></div></div>'
      );
    },
    success: function (usuarios) {
      $("#cursos-asigandos-sede").html(usuarios);
      if (pag != 1) document.getElementById("pagina" + pag).scrollIntoView();
    },
  });
}

function quitarCapacitacionUsuario(id, idusuario) {
  Swal.fire({
    title: "¿Está seguro de quitar la capacitación?",
    text: "",
    icon: "question",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#3085d6",
    cancelButtonText: "Cancelar",
    confirmButtonText: "Eliminar",
  }).then((result) => {
    if (result.isConfirmed) {
      eliminarCapAsignada(id, idusuario);
    }
  });
}

function quitarCursoEmpresa(id, idempresa) {
  Swal.fire({
    title: "¿Está seguro de quitar la capacitación?",
    text: "Tenga en cuenta que se le quitará a todas las sedes y usuarios pertenecientes a esta empresa",
    icon: "question",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#3085d6",
    cancelButtonText: "Cancelar",
    confirmButtonText: "Eliminar",
  }).then((result) => {
    if (result.isConfirmed) {
      eliminarCapAsignadaEmpresa(id, idempresa);
    }
  });
}

function eliminarCapAsignadaEmpresa(idCap, idempresa) {
  $.ajax({
    url: "acciones-ajax/asignar_capacitaciones_empresa.php",
    type: "post",
    data: { codigo: idCap, empresa: idempresa, accion: "quitar_capacitacion" },
    success: function (id_respuesta) {
      $("#id_modal").html(id_respuesta);
    },
  });
}

function asignarEmpresa() {
  $.ajax({
    url: "acciones-ajax/asignar_capacitaciones_empresa.php",
    type: "post",
    data: $("#form-asignar-empresa").serialize(),
    success: function (id_respuesta) {
      $("#id_respuesta").html(id_respuesta);
    },
  });
}

function informacion() {
  Swal.fire({
    position: "top-center",
    icon: "info",
    title:
      "Tenga en cuenta que el estado también cambiara para todas las sedes y usuarios pertenecientes a esta empresa",
    confirmButtonColor: "#3fc3ee",
    showConfirmButton: true,
  });
}

function editarEmpresa() {
  var form = $("#form-editar-empresa")[0];
  var dato_archivo = $("#file").prop("files")[0];
  var form_data = new FormData(form);
  form_data.append("imagen", dato_archivo);
  $.ajax({
    url: "acciones-ajax/editar_empresa.php",
    type: "post",
    data: form_data,
    contentType: false,
    cache: false,
    processData: false,
    beforeSend: function () {
      $("#id_respuesta").html(
        '<div class="text-center"><div class="spinner-border text-secondary" role="status"></div></div>'
      );
    },
    success: function (id_respuesta) {
      $("#id_respuesta").html(id_respuesta);
    },
  });
}

function eliminarEmpresa(id) {
  Swal.fire({
    title: "¿Está seguro de eliminar la empresa?",
    text: "Tenga en cuenta que se le eliminaran todas las sedes y usuarios pertenecientes a esta empresa",
    icon: "question",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#6c757d",
    cancelButtonText: "Cancelar",
    confirmButtonText: "Eliminar",
  }).then((result) => {
    if (result.isConfirmed) {
      eliminarEmpresaComfirmado(id, "eliminar");
    }
  });
}

function eliminarEmpresaComfirmado(id) {
  $.ajax({
    url: "acciones-ajax/eliminar_empresa.php",
    method: "POST",
    data: { idempresa: id },
    beforeSend: function () {
      $("#id_respuesta").html(
        '<div class="text-center"><div class="spinner-border text-secondary" role="status"></div></div>'
      );
    },
    success: function (id_respuesta) {
      $("#id_respuesta").html(id_respuesta);
    },
  });
}

function buscarEmpresa(pag) {
  var name = $("#busqueda-empresa").val();
  $.ajax({
    url: "empresa/listar_empresa.php",
    method: "POST",
    data: { buscar: name, pagina: pag },
    beforeSend: function () {
      $("#lista-empresa").html(
        '<div class="text-center"><div class="spinner-border text-secondary" role="status"></div></div>'
      );
    },
    success: function (usuarios) {
      $("#lista-empresa").html(usuarios);
      if (pag != 1) document.getElementById("pagina" + pag).scrollIntoView();
    },
  });
}

function buscarSede(pag) {
  var name = $("#busqueda-sede").val();
  $.ajax({
    url: "sede/listar_sede.php",
    method: "POST",
    data: { buscar: name, pagina: pag },
    beforeSend: function () {
      $("#lista-sede").html(
        '<div class="text-center"><div class="spinner-border text-secondary" role="status"></div></div>'
      );
    },
    success: function (usuarios) {
      $("#lista-sede").html(usuarios);
      if (pag != 1) document.getElementById("pagina" + pag).scrollIntoView();
    },
  });
}

function quitarCursoSede(id, idsede) {
  Swal.fire({
    title: "¿Está seguro de quitar la capacitación?",
    text: "Tenga en cuenta que se le quitará a todos los usuarios pertenecientes a esta sede",
    icon: "question",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#3085d6",
    cancelButtonText: "Cancelar",
    confirmButtonText: "Eliminar",
  }).then((result) => {
    if (result.isConfirmed) {
      eliminarCapAsignadaSede(id, idsede);
    }
  });
}

function eliminarCapAsignadaSede(idCap, idsede) {
  $.ajax({
    url: "acciones-ajax/asignar_capacitaciones_sede.php",
    type: "post",
    data: { codigo: idCap, sede: idsede, accion: "quitar_capacitacion" },
    success: function (id_respuesta) {
      $("#id_modal").html(id_respuesta);
    },
  });
}

function asignarSede() {
  $.ajax({
    url: "acciones-ajax/asignar_capacitaciones_sede.php",
    type: "post",
    data: $("#form-asignar-sede").serialize(),
    success: function (id_respuesta) {
      $("#id_respuesta").html(id_respuesta);
    },
  });
}

function editarSede() {
  var form = $("#form-editar-sede")[0];
  var dato_archivo = $("#file").prop("files")[0];
  var form_data = new FormData(form);
  form_data.append("imagen", dato_archivo);
  $.ajax({
    url: "acciones-ajax/editar_sede.php",
    type: "post",
    data: form_data,
    contentType: false,
    cache: false,
    processData: false,
    beforeSend: function () {
      $("#id_respuesta").html(
        '<div class="text-center"><div class="spinner-border text-secondary" role="status"></div></div>'
      );
    },
    success: function (id_respuesta) {
      $("#id_respuesta").html(id_respuesta);
    },
  });
}

function eliminarSede(id) {
  Swal.fire({
    title: "¿Está seguro de eliminar la sede?",
    text: "Tenga en cuenta que se le eliminaran todos los usuarios pertenecientes a esta sede",
    icon: "question",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#6c757d",
    cancelButtonText: "Cancelar",
    confirmButtonText: "Eliminar",
  }).then((result) => {
    if (result.isConfirmed) {
      eliminarSedeComfirmado(id, "eliminar");
    }
  });
}

function eliminarSedeComfirmado(id) {
  $.ajax({
    url: "acciones-ajax/eliminar_sede.php",
    method: "POST",
    data: { idsede: id },
    beforeSend: function () {
      $("#id_respuesta").html(
        '<div class="text-center"><div class="spinner-border text-secondary" role="status"></div></div>'
      );
    },
    success: function (id_respuesta) {
      $("#id_respuesta").html(id_respuesta);
    },
  });
}

function validarPerfil(perfil) {
  if (perfil == 1) {
    $("#cargar-sedes").hide();
    $("#cargar-empresas").hide();
    $('#empresa').attr('required', false)
  } else {
    $("#cargar-sedes").show();
    $("#cargar-empresas").show();
    $('#empresa').attr('required', true);
  }
}
