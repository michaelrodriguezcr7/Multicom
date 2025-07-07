<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario - Ingresos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Tabla de ingresos -->
    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Fecha</th>
                        <th>Producto</th>
                        <th>Código</th>
                        <th>Categoría</th>
                        <th>Cantidad</th>
                        <th>Valor Unitario</th>
                        <th>Proveedor</th>
                        <th>Observaciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ingresos as $ing)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($ing->fecha_ingreso)->format('d/m/Y') }}</td>
                            <td>{{ $ing->producto->nombre }}</td>
                            <td>{{ $ing->producto->codigo }}</td>
                            <td>{{ $ing->producto->categoria }}</td>
                            <td>{{ $ing->cantidad_ingresada }}</td>
                            <td>${{ number_format($ing->valor_unitario, 0, ',', '.') }}</td>
                            <td>{{ $ing->proveedor }}</td>
                            <td>{{ $ing->observaciones }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">No hay ingresos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
