<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Correo de Notificación</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 0;
        }
        .contenedor {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .encabezado {
            background-color: #2c3e50;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }
        .contenido {
            padding: 30px;
        }
        .boton {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 25px;
            background-color: #3498db;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #888888;
            padding: 20px;
        }
    </style>
</head>
<body>

    <div class="contenedor">
        <div class="encabezado">
            <h1>System Solvers</h1>
        </div>

        <div class="contenido">
            <h1>  Cambio de Contraseña </h1>
            <h3> {!! $mensaje !!} </h3>


            @if(isset($link))
                <a href="{{ $link }}" class="boton">Ir al sistema</a>
            @endif
        </div>

        <div class="footer">
            © {{ date('Y') }} System Solvers. Todos los derechos reservados.
        </div>
    </div>

</body>
</html>
