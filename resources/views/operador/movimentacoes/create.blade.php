@extends('layouts.admin')

@section('title', 'Nova Movimentação')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Nova Movimentação</h2>
        <a href="{{ route('operador.movimentacoes.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('operador.movimentacoes.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="entrada_id" class="form-label">Lote/Entrada *</label>
                    <select class="form-select @error('entrada_id') is-invalid @enderror" 
                            id="entrada_id" 
                            name="entrada_id" 
                            required>
                        <option value="">Selecione o lote...</option>
                        @foreach($entradas as $e)
                            <option value="{{ $e->id }}" 
                                {{ (old('entrada_id', $entrada->id ?? '') == $e->id) ? 'selected' : '' }}>
                                {{ $e->codigo_lote }} - {{ $e->categoria->nome ?? 'N/A' }} 
                                (Disponível: {{ number_format($e->quantidade - $e->movimentacoes->sum('quantidade'), 2) }} kg)
                            </option>
                        @endforeach
                    </select>
                    @error('entrada_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="tipo_movimentacao" class="form-label">Tipo de Movimentação *</label>
                        <select class="form-select @error('tipo_movimentacao') is-invalid @enderror" 
                                id="tipo_movimentacao" 
                                name="tipo_movimentacao" 
                                required>
                            <option value="">Selecione...</option>
                            <option value="separacao" {{ old('tipo_movimentacao') == 'separacao' ? 'selected' : '' }}>Separação</option>
                            <option value="armazenamento" {{ old('tipo_movimentacao') == 'armazenamento' ? 'selected' : '' }}>Armazenamento</option>
                            <option value="venda" {{ old('tipo_movimentacao') == 'venda' ? 'selected' : '' }}>Venda</option>
                            <option value="descarte" {{ old('tipo_movimentacao') == 'descarte' ? 'selected' : '' }}>Descarte</option>
                        </select>
                        @error('tipo_movimentacao')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="quantidade" class="form-label">Quantidade (kg) *</label>
                        <input type="number" 
                               step="0.01" 
                               min="0.01" 
                               class="form-control @error('quantidade') is-invalid @enderror" 
                               id="quantidade" 
                               name="quantidade" 
                               value="{{ old('quantidade') }}" 
                               required>
                        @error('quantidade')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="localizacao" class="form-label">Localização</label>
                        <input type="text" 
                               class="form-control @error('localizacao') is-invalid @enderror" 
                               id="localizacao" 
                               name="localizacao" 
                               value="{{ old('localizacao') }}"
                               placeholder="Ex: Armazém A, Prateleira 1">
                        @error('localizacao')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="destino" class="form-label">Destino</label>
                        <input type="text" 
                               class="form-control @error('destino') is-invalid @enderror" 
                               id="destino" 
                               name="destino" 
                               value="{{ old('destino') }}"
                               placeholder="Ex: Recicladora ABC, Aterro">
                        @error('destino')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 mb-3">
                        <label for="observacoes" class="form-label">Observações</label>
                        <textarea class="form-control @error('observacoes') is-invalid @enderror" 
                                  id="observacoes" 
                                  name="observacoes" 
                                  rows="3">{{ old('observacoes') }}</textarea>
                        @error('observacoes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Registrar Movimentação
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Atualizar quantidade disponível quando selecionar um lote
    document.getElementById('entrada_id').addEventListener('change', function() {
        const selected = this.options[this.selectedIndex];
        // Você pode adicionar lógica aqui para mostrar a quantidade disponível
    });
</script>
@endpush
@endsection