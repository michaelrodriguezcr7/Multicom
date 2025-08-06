@extends('layouts.app') {{-- Usa tu layout principal aquí --}}

@section('title', 'Estadísticas Generales')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Estadísticas Generales de Ventas</h3>

    <a href="{{ route('reportes.ventas.pdf') }}" class="btn btn-danger mb-3" target="_blank">
    <i class="fas fa-file-pdf"></i> Generar PDF
    </a>

    <div class="row">
        <!-- Producto más vendido -->
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Producto Más Vendido</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $productoMasVendido->nombre ?? 'N/A' }}</h5>
                    <p class="card-text">Unidades: {{ $productoMasVendido->total_vendido ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Producto menos vendido -->
        <div class="col-md-3">
            <div class="card text-white bg-danger mb-3">
                <div class="card-header">Producto Menos Vendido</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $productoMenosVendido->nombre ?? 'N/A' }}</h5>
                    <p class="card-text">Unidades: {{ $productoMenosVendido->total_vendido ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Total de ventas -->
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Número Total de Ventas</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $numeroVentas }}</h5>
                    <p class="card-text">ventas registradas</p>
                </div>
            </div>
        </div>

        <!-- Vendedor con más ventas -->
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3">
                <div class="card-header">Vendedor con Más Ventas</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $vendedorTop->nombre ?? 'N/A' }}</h5>
                    <p class="card-text">Total ventas: {{ $vendedorTop->total_ventas ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
