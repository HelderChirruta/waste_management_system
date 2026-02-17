@extends('layouts.admin')

@section('title', 'Dashboard Gestor')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Dashboard Gestor</h2>
    
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Resumo do Mês</h5>
                </div>
                <div class="card-body">
                    <p><strong>Total entradas:</strong> {{ \App\Models\EntradaResiduo::whereMonth('data_hora_entrada', now()->month)->count() }}</p>
                    <p><strong>Quantidade total:</strong> {{ number_format(\App\Models\EntradaResiduo::whereMonth('data_hora_entrada', now()->month)->sum('quantidade'), 2) }} kg</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection@extends('layouts.admin')

@section('title', 'Dashboard Gestor')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Dashboard Gestor</h2>
    
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Resumo do Mês</h5>
                </div>
                <div class="card-body">
                    <p><strong>Total entradas:</strong> {{ \App\Models\EntradaResiduo::whereMonth('data_hora_entrada', now()->month)->count() }}</p>
                    <p><strong>Quantidade total:</strong> {{ number_format(\App\Models\EntradaResiduo::whereMonth('data_hora_entrada', now()->month)->sum('quantidade'), 2) }} kg</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection