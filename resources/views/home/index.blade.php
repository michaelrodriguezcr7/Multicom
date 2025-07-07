@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')

<h1 class="text-center my-4">Bienvenido, {{ session('nombre') }}</h1>

{{-- Mensajes de error o éxito --}}
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if (session('mensaje'))
        <div class="alert alert-info">{{ session('mensaje') }}</div>
    @endif

<div class="container-fluid">
    <div class="center-content">
        <div class="row text-center">
            <div class="col-6 col-md-4 col-lg-3 mb-4">
                <a href="#" class="btn btn-success btn-lg w-100">
                    <i class="bi bi-file-earmark-bar-graph"></i> Reportes
                </a>
            </div>
            <div class="col-6 col-md-4 col-lg-3 mb-4">
                <a href="{{ route('productos.inventario') }}" class="btn btn-dark btn-lg w-100">
                    <i class="bi bi-box-arrow-down"></i> Ingreso de Mercancía
                </a>
            </div>
            <div class="col-6 col-md-4 col-lg-3 mb-4" id="btnUsuarios">
                <a href="{{ route('usuarios.index') }}" class="btn btn-success btn-lg w-100">
                    <i class="bi bi-arrow-repeat"></i> Usuarios
                </a>
            </div>
            <div class="col-6 col-md-4 col-lg-3 mb-4">
                <a href="#" class="btn btn-dark btn-lg w-100">
                    <i class="bi bi-arrow-repeat"></i> Ventas
                </a>
            </div>
            <div class="col-6 col-md-4 col-lg-3 mb-4">
                <a href="#" class="btn btn-success btn-lg w-100">
                    <i class="bi bi-arrow-repeat"></i> Créditos y separados pendientes
                </a>
            </div>
            <div class="col-6 col-md-4 col-lg-3 mb-4">
                <a href="#" class="btn btn-dark btn-lg w-100">
                    <i class="bi bi-arrow-repeat"></i> Gastos
                </a>
            </div>
            <div class="col-6 col-md-4 col-lg-3 mb-4">
                <a href="#" class="btn btn-success btn-lg w-100">
                    <i class="bi bi-arrow-repeat"></i> Generador de códigos
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
