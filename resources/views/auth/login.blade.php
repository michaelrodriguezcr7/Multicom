<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS desde CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons desde CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: url('{{ asset("img/fondologin.jpg") }}') no-repeat center center fixed;
            background-size: cover;
            font-family: Arial, sans-serif;
        }

        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .login-card {
            display: flex;
            flex-direction: row;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
        }

        .login-left {
            background-color: #0015ff;
            padding: 40px 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex: 1;
        }

        .login-left i {
            font-size: 100px;
            color: white;
        }

        .login-right {
            flex: 2;
            padding: 40px 30px;
        }

        .social-icons a {
            color: #444;
            font-size: 1.5rem;
            margin: 0 10px;
        }

        .btn-block {
            width: 100%;
        }

        @media (max-width: 768px) {
            .login-card {
                flex-direction: column;
                border-radius: 10px;
            }

            .login-left {
                padding: 30px 20px;
            }

            .login-left i {
                font-size: 80px;
            }

            .login-right {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
<div class="login-container">
    <div class="login-card">
        <div class="login-left">
            <i class="bi bi-person-circle"></i>
        </div>

        <div class="login-right">
            <h3 class="text-center text-primary fw-bold">Bienvenido a MultiCom</h3>

            {{-- Mensajes de error o éxito --}}
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if (session('mensaje'))
                <div class="alert alert-info">{{ session('mensaje') }}</div>
            @endif

            {{-- FORMULARIO DE LOGIN --}}
            <form method="POST" action="{{ route('verificar.usuario') }}" id="loginForm">
                @csrf
                <p class="text-center mb-4">Inicio de sesión</p>

                <div class="mb-3">
                    <input type="text" class="form-control" name="txtlog" placeholder="Email" autocomplete="email" required>
                </div>

                <div class="input-group mb-3">
                    <input type="password" class="form-control" name="txtcla" id="txtcla" placeholder="Password" autocomplete="current-password" required>
                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">Mostrar</button>
                </div>

                <div class="mb-3 text-end">
                    <a href="#" id="forgotPasswordLink" class="text-decoration-none">¿Olvidó su contraseña?</a>
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary btn-block">Log In</button>
                </div>
            </form>

            {{-- FORMULARIO DE RECUPERAR CONTRASEÑA --}}
            <form method="POST" action="{{ route('password.recuperar') }}" id="forgotPasswordForm" style="display: none;">
                @csrf
                <p class="text-center mb-4">Recuperación de usuario</p>

                <div class="mb-3">
                    <input type="email" class="form-control" name="email" placeholder="Ingrese su correo electrónico" required>
                </div>

                <div class="mb-3">
                    <a href="#" id="backToLoginLink" class="btn btn-link">Volver al inicio de sesión</a>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-block">Restablecer Contraseña</button>
                </div>
            </form>

            <div class="text-center mt-4 social-icons">
                <a href="https://api.whatsapp.com/send?phone=573173929286"><i class="bi bi-whatsapp"></i></a>
                <a href="#"><i class="bi bi-facebook"></i></a>
                <a href="#"><i class="bi bi-twitter"></i></a>
                <a href="#"><i class="bi bi-linkedin"></i></a>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Mostrar/Ocultar contraseña
    const toggleBtn = document.getElementById('togglePassword');
    const passwordField = document.getElementById('txtcla');

    toggleBtn.addEventListener('click', function () {
        const type = passwordField.type === 'password' ? 'text' : 'password';
        passwordField.type = type;
        toggleBtn.textContent = type === 'password' ? 'Mostrar' : 'Ocultar';
    });

    // Alternar formularios
    document.getElementById('forgotPasswordLink').addEventListener('click', function (e) {
        e.preventDefault();
        document.getElementById('loginForm').style.display = 'none';
        document.getElementById('forgotPasswordForm').style.display = 'block';
    });

    document.getElementById('backToLoginLink').addEventListener('click', function (e) {
        e.preventDefault();
        document.getElementById('forgotPasswordForm').style.display = 'none';
        document.getElementById('loginForm').style.display = 'block';
    });
</script>
</body>
</html>
