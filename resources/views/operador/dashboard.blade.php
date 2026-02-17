@extends('layouts.admin')

@section('title', 'Dashboard Operador')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Dashboard Operador</h2>
    
    <div class="alert alert-info">
        <i class="fas fa-info-circle"></i>
        Utilize o menu "Entradas" para registrar novos resíduos.
    </div>
    
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-plus-circle fa-3x text-primary mb-3"></i>
                    <h5>Registrar Entrada</h5>
                    <a href="{{ route('operador.entradas.create') }}" class="btn btn-primary mt-2">Nova Entrada</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-list fa-3x text-success mb-3"></i>
                    <h5>Ver Entradas</h5>
                    <a href="{{ route('operador.entradas.index') }}" class="btn btn-success mt-2">Listar Entradas</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <i class="fas fa-users fa-3x text-info mb-3"></i>
                    <h5>Catadores</h5>
                    <a href="#" class="btn btn-info mt-2">Gerenciar</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection