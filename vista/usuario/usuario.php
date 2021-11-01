<?php
require_once 'vista/componentes/nav.php';
?>
<div class="container" style="padding-top: 4rem;">

    <h3 style="text-align:center; margin-bottom: 2%;">Listado de usuarios</h3>
    <div class="input-group mb-3">
        <span class="input-group-text" id="buscar">Buscar</span>
        <input type="text" class="form-control" aria-describedby="buscar">
    </div>
    <div id="lista-usuarios" class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellido</th>
                    <th scope="col">Capacitaciónes</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                
                <tr>
                    <th scope="row">2</th>
                    <td>Jacob</td>
                    <td>Thornton</td>
                    <td>Inscritas 5 realizadas 4</td>
                    <td>
                        <form method="post" action="vista/">
                            <input type="Hidden" name="vista" value="capacitacion_por_usuario"/>
                            <input type="Hidden" name="id" value="15"/>

                            <button type="submit" name="accion" class="btn btn-success btn-sm">
                                <img src="componentes/img/iconos/Iconos-ver.svg" />
                            </button>

                            <button type="button" class="btn btn-primary btn-sm" onclick="vermodal('asignar')">
                                <img src="componentes/img/iconos/asignar.svg" />
                            </button>
                            <button type="button" class="btn btn-success btn-sm" onclick="vermodal('informacion')">
                                <img src="componentes/img/iconos/ver-info.svg" />
                            </button>
                            <button type="button" class="btn btn-primary btn-sm" onclick="vermodal('editar')">
                                <img src="componentes/img/iconos/editar.svg" />
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" onclick="vermodal('Eliminar')">
                                <img src="componentes/img/iconos/delete.svg" />
                            </button>
                        </form>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
    <script>
        function vermodal(id) {
            var form_data = new FormData();
            form_data.append("accion", id);
            $.ajax({
                url: 'vista/componentes/modal.php',
                method: "POST",
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                success: function(id_modal) {
                    $("#id_modal").html(id_modal)
                }
            });

        }
    </script>

    <div id="id_modal">
    </div>
</div>