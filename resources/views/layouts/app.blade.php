<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', 'Mi Aplicación')</title>

  <!-- Bootstrap y Bootstrap Icons desde CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    html, body {
      height: 100%;
      margin: 0;
    }

    body {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      padding-top: 70px; /* espacio para navbar fija */
    }

    .navbar {
      position: fixed;
      top: 0;
      width: 100%;
      z-index: 1030;
    }

    .main-content {
      flex: 1;
    }

    .footer {
      background-color: #1c1c1c;
      color: white;
      padding: 20px;
      text-align: center;
    }

    .btn-custom {
      background-color: #343a40;
      color: white;
      margin: 5px;
      display: inline-flex;
      align-items: center;
      padding: 8px 12px;
      border-radius: 5px;
      text-decoration: none;
    }

    .btn-custom img {
      width: 20px;
      margin-right: 5px;
    }
  </style>
</head>
<body>

  <!-- ✅ NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{ route('home') }}"><i class="bi bi-house-door"></i> BIENVENIDO (a) {{ auth()->user()->nom_usu }} {{ auth()->user()->ape_usu }}</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
            aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="#">Inicio</a></li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="modulosDropdown" role="button"
             data-bs-toggle="dropdown">Módulos</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Reportes</a></li>
            <li><a class="dropdown-item" href="{{ route('usuarios.index') }}">Usuarios</a></li>
            <li><a class="dropdown-item" href="{{ route('productos.index') }}">Ingreso de Mercancia</a></li>
            <li><a class="dropdown-item" href="#">Ventas</a></li>
            <li><a class="dropdown-item" href="#">Créditos</a></li>
            <li><a class="dropdown-item" href="#">Gastos</a></li>
            <li><a class="dropdown-item" href="#">Generador de códigos</a></li>
          </ul>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="sesionDropdown" role="button"
             data-bs-toggle="dropdown">Sesión</a>
          <ul class="dropdown-menu">
            <li>
              <a class="dropdown-item" href="#" 
                 onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                 <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
              </a>

              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
              </form>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>


  <!-- ✅ CONTENIDO PRINCIPAL -->
  <main class="container main-content py-4">
    @yield('content')
  </main>

  <!-- ✅ FOOTER -->
  <footer class="footer mt-auto">
    <div class="container">
      <div class="row">
        <!-- Información de contacto -->
        <div class="col-md-6 text-start">
          <h5>Información de Contacto</h5>
          <p>Tecnología para todos al alcance de tu mano.</p>
          <p>Desarrollo de software personalizado y soluciones tecnológicas a la medida para tu negocio.</p>
          <p>Email: systemsolvers7777@gmail.com</p>
          <p>Pasto, Nariño</p>
        </div>

        <!-- Botones de contacto -->
        <div class="col-md-6 text-end">
          <h5>Contacto</h5>
          <a href="#" class="btn-custom" data-bs-toggle="modal" data-bs-target="#modalContacto">
            <img src="https://cdn-icons-png.flaticon.com/512/281/281769.png" alt="Gmail"> Gmail
          </a>
          <a href="https://api.whatsapp.com/send?phone=573173929286" class="btn-custom">
            <img src="https://cdn-icons-png.flaticon.com/512/733/733585.png" alt="WhatsApp"> WhatsApp
          </a>
        </div>
      </div>
    </div>
  </footer>

  <!-- Scripts Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  @yield('scripts')
  <x-modales.modal_contacto />
</body>
</html>
