
<!DOCTYPE html>
<html lang="en" <head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Login</title>
<!-- Estilo de boostrapt -->

<link href="../componentes/css/bootstrap.min.css" rel="stylesheet">
<!-- Estilo de personalizados -->
<link href="../componentes/css/login.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="../componentes/js/jquery-3.6.0.min.js" type="text/javascript"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
<div>
    <div class="container-fluid h-custom">
        <div class="row d-flex justify-content-center align-items-center vh-100">

            <div class="col-md-9 col-lg-6 col-xl-5" style="margin-top:1%">
                <img src="https://mdbootstrap.com/img/Photos/new-templates/bootstrap-login-form/draw2.png" class="img-fluid" alt="Sample image">
            </div>
            <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                <form action="../vista/" method="post">

                    <div style="text-align:center; margin-top:18%">
                        <p class="lead fw-normal mb-0 me-3">Iniciar Seccion</p>
                    </div>

                    <div class="divider d-flex align-items-center my-4">
                    </div>

                    <!-- Email input -->
                    <div class="form-outline mb-4">
                        <input type="text" name="usuario" id="form3Example3" class="form-control form-control-lg" placeholder="Usuario" required />
                        <label class="form-label" for="form3Example3">Nombre de Usuario o Correo Electronico</label>
                    </div>

                    <!-- Password input -->
                    <div class="form-outline mb-3">
                        <input type="password" id="form3Example4" class="form-control form-control-lg" placeholder="Contraseña" required />
                        <label class="form-label" for="form3Example4">Contraseña</label>
                    </div>



                    <div class="text-center text-lg-start mt-4 pt-2">
                        <button type="submit" class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;">Iniciar Sección</button>
                        <p class="small fw-bold mt-2 pt-1 mb-0"></p>
                    </div>

                </form>
            </div>
            <div class="col-md-9 col-lg-6 col-xl-5" style="margin-bottom:12%">
            </div>
            <div class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-4 px-4 px-xl-5 bg-primary">
                <!-- Copyright -->
                <div class="text-white" style="width:100%">
                    © 2021 <a href="https://marktech.co/" class="link-light">Marktech.</a> Todos los derechos reservados, prohibida su reproducción total o parcial.
                    <a href="https://www.facebook.com/Marktech0" class="text-white">
                        <svg style="margin-left: 1%;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                            <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z" />
                        </svg>
                    </a>
                </div>
            </div>

        </div>


    </div>
</div>
<script src="../componentes/js/bootstrap.min.js" type="text/javascript"></script>
</body>

</html>
