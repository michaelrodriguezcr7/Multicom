<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Ventas</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2, h3 { text-align: center; }
    </style>
</head>
<body>

@php
    $totalGeneral = 0;
    $totalGananciaDia = 0;
@endphp

<h2>Reporte Diario de Ventas</h2>

@foreach($detalles as $ventaId => $venta)
    @php
        $totalVenta = $venta->sum('total');
        $totalGanancia = $venta->sum('ganancia');

        $totalGeneral += $totalVenta;
        $totalGananciaDia += $totalGanancia;
    @endphp

    <p><strong>ID Venta:</strong> {{ $ventaId }}</p>
    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Vendedor</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Costo</th>
                <th>Precio Venta</th>
                <th>Total</th>
                <th>Ganancia</th>
            </tr>
        </thead>
        <tbody>
            @foreach($venta as $item)
                <tr>
                    <td>{{ $item->fecha }}</td>
                    <td>{{ $item->usuario }}</td>
                    <td>{{ $item->producto }}</td>
                    <td>{{ $item->cantidad }}</td>
                    <td>${{ number_format($item->costo_unitario, 0) }}</td>
                    <td>${{ number_format($item->precio_unitario, 0) }}</td>
                    <td>${{ number_format($item->total, 0) }}</td>
                    <td>${{ number_format($item->ganancia, 0) }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="6" style="text-align: right;"><strong>Total Venta:</strong></td>
                <td><strong>${{ number_format($totalVenta, 0) }}</strong></td>
                <td><strong>${{ number_format($totalGanancia, 0) }}</strong></td>
            </tr>
        </tbody>
    </table>
    <hr>
@endforeach

<h3 style="text-align: right;">Total General del Día: ${{ number_format($totalGeneral, 0) }}</h3>
<h3 style="text-align:right;">Total Ganancias del Día: ${{ number_format($totalGananciaDia, 0) }}</h3>


</body>
</html>
