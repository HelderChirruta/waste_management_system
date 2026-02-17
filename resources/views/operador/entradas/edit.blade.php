@extends('layouts.admin')

@section('title', 'Editar Entrada')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Editar Entrada: {{ $entrada->codigo_lote }}</h2>
        <a href="{{ route('operador.entradas.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('operador.entradas.update', $entrada->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="origem_id" class="form-label">Origem do Resíduo *</label>
                        <select class="form-select @error('origem_id') is-invalid @enderror" 
                                id="origem_id" 
                                name="origem_id" 
                                required>
                            <option value="">Selecione a origem...</option>
                            @foreach($origens as $origem)
                                <option value="{{ $origem->id }}" {{ old('origem_id', $entrada->origem_id) == $origem->id ? 'selected' : '' }}>
                                    {{ $origem->nome }} ({{ $origem->tipo }})
                                </option>
                            @endforeach
                        </select>
                        @error('origem_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="categoria_id" class="form-label">Categoria do Plástico *</label>
                        <select class="form-select @error('categoria_id') is-invalid @enderror" 
                                id="categoria_id" 
                                name="categoria_id" 
                                required>
                            <option value="">Selecione a categoria...</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}" {{ old('categoria_id', $entrada->categoria_id) == $categoria->id ? 'selected' : '' }}>
                                    {{ $categoria->nome }} - {{ $categoria->codigo }}
                                </option>
                            @endforeach
                        </select>
                        @error('categoria_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="quantidade" class="form-label">Quantidade *</label>
                        <input type="number" 
                               step="0.01" 
                               min="0.01" 
                               class="form-control @error('quantidade') is-invalid @enderror" 
                               id="quantidade" 
                               name="quantidade" 
                               value="{{ old('quantidade', $entrada->quantidade) }}" 
                               required>
                        @error('quantidade')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="unidade_medida" class="form-label">Unidade de Medida *</label>
                        <select class="form-select @error('unidade_medida') is-invalid @enderror" 
                                id="unidade_medida" 
                                name="unidade_medida" 
                                required>
                            <option value="kg" {{ old('unidade_medida', $entrada->unidade_medida) == 'kg' ? 'selected' : '' }}>Quilogramas (kg)</option>
                            <option value="ton" {{ old('unidade_medida', $entrada->unidade_medida) == 'ton' ? 'selected' : '' }}>Toneladas (ton)</option>
                        </select>
                        @error('unidade_medida')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="estado" class="form-label">Estado do Resíduo *</label>
                        <select class="form-select @error('estado') is-invalid @enderror" 
                                id="estado" 
                                name="estado" 
                                required>
                            <option value="">Selecione...</option>
                            <option value="separado" {{ old('estado', $entrada->estado) == 'separado' ? 'selected' : '' }}>Separado</option>
                            <option value="misturado" {{ old('estado', $entrada->estado) == 'misturado' ? 'selected' : '' }}>Misturado</option>
                            <option value="contaminado" {{ old('estado', $entrada->estado) == 'contaminado' ? 'selected' : '' }}>Contaminado</option>
                        </select>
                        @error('estado')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 mb-3">
                        <label for="observacoes" class="form-label">Observações</label>
                        <textarea class="form-control @error('observacoes') is-invalid @enderror" 
                                  id="observacoes" 
                                  name="observacoes" 
                                  rows="3">{{ old('observacoes', $entrada->observacoes) }}</textarea>
                        @error('observacoes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    Apenas entradas registradas hoje podem ser editadas.
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Atualizar Entrada
                </button>
            </form>
        </div>
    </div>
</div>
@endsection