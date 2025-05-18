<!DOCTYPE html>
<html lang="es">
<head>
    <title>Solicitud</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}"/>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css"
          href="{{ asset('assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/animate/animate.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/css-hamburgers/hamburgers.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/select2/select2.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/util.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/main.css') }}">
    <!--===============================================================================================-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
    <style>
        body, p, h1, span, button, input {
            font-family: 'Inter', sans-serif !important;
        }
    </style>
</head>
<body>

<div class="bg-contact2" style="/ContactFrom_v2/images/bg-01.jpg">
    <div class="container-contact2">
        <div class="wrap-contact2">

            <form method="POST" class="contact2-form validate-form" enctype="multipart/form-data">


                <img class="mb-5" style="width: 100%;" src="{{ asset('img/logo-estudio-app.png')  }}"/>
                <h1 class="contact2-form-title mb-5">Problema Login 🚫</h1>


                <p class="mt-2 mb-2 text-justify">
                    El correo con el que se ha intentado ingresar NO está autorizado, no es dominio de google, no está
                    permitido o no ha sido pasado por el proceso de importación favor de contactar al administrador 📭.

                </p>

                <div style="text-align: right;">
                    <a href="https://nive.la" style="color: purple">Nivel A</a>
                </div>
            </form>
        </div>
    </div>
</div>


<!--===============================================================================================-->
<script src="{{ asset('assets/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
<!--===============================================================================================-->
<script src="{{ asset('assets/vendor/bootstrap/js/popper.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<!--===============================================================================================-->
<script src="{{ asset('assets/vendor/select2/select2.min.js') }}"></script>
<!--===============================================================================================-->
<script src="{{ asset('assets/js/main.js') }}"></script>

</body>
</html>
