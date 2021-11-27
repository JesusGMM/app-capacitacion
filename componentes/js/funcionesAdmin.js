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

function asignar() {
  $.ajax({
      url: 'acciones-ajax/asignar_capacitaciones.php',
      type: 'post',
      data: $('#form-asignar').serialize(),
      success: function(id_respuesta) {
          $('#id_respuesta').html(id_respuesta)
      }
  });          
}

function eliminarUsuario(idUsuario) {
  var datos = { id: idUsuario }
  $.ajax({
      url: 'acciones-ajax/eliminar_usuario.php',
      type: 'post',
      data: datos,
      success: function(id_respuesta) {
          $('#id_respuesta').html(id_respuesta)
      }
  });          
}

function editar() {
  $.ajax({
      url: 'acciones-ajax/editar_usuario.php',
      type: 'post',
      data: $('#form-editar').serialize(),
      success: function(id_respuesta) {
          $('#id_respuesta').html(id_respuesta)
      }
  });          
}
function listadoCurso(activar){
  if (activar == 1){
    $('#borrador').removeClass('active'); 
    $('#publicar').addClass('active');
    $('#publicas').show();
    $('#borradores').hide();

  }else{
    $('#publicar').removeClass('active');
    $('#borrador').addClass('active');
    $('#publicas').hide();
    $('#borradores').show();
  }
}

function buscarCursoBorrador(pag) {
  var name = $("#busqueda-cursos").val();
  $.ajax({
    url: "cursos.php",
    method: "POST",
    data: { buscar: name, pagina: pag },
    beforeSend: function () {
      $("#lista-cursos").html(
     //   '<div class="text-center"><div class="spinner-border text-secondary" role="status"></div></div>'
      );
    },
    success: function (usuarios) {
      $("#lista-cursos").html(usuarios);
      $('#publicar').removeClass('active');
      $('#borrador').addClass('active');
      $('#publicas').hide();
      $('#borradores').show();
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
    data: { buscar: name, pagina: pag , rol :rol },
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