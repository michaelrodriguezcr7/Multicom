<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mensaje de Contacto</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            padding: 30px;
            color: #333;
        }

        .card {
            max-width: 600px;
            margin: auto;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .header {
            background-color: #2c3e50;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            letter-spacing: 1px;
        }

        .content {
            padding: 25px;
        }

        .content p {
            margin-bottom: 15px;
            line-height: 1.6;
        }

        .footer {
            background-color: #ecf0f1;
            padding: 15px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }

        strong {
            color: #2c3e50;
        }
    </style>
</head>
<body>

    <div class="card">
        <div class="header">
            <h1>System Solvers</h1>
        </div>

        <div class="content">
            <h2>📬 Nuevo mensaje de contacto</h2>

            <p>{!! $mensaje !!}</p>
        </div>

        <div class="footer">
            © {{ date('Y') }} System Solvers. Todos los derechos reservados.
        </div>
    </div>

</body>
</html>
