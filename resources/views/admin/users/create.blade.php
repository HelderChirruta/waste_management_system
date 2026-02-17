@extends('layouts.admin')

@section('title', 'Novo Usuário')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Novo Usuário</h2>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="nome_completo" class="form-label">Nome Completo *</label>
                    <input type="text" 
                           class="form-control @error('nome_completo') is-invalid @enderror" 
                           id="nome_completo" 
                           name="nome_completo" 
                           value="{{ old('nome_completo') }}" 
                           required>
                    @error('nome_completo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email *</label>
                    <input type="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="senha" class="form-label">Senha *</label>
                    <input type="password" 
                           class="form-control @error('senha') is-invalid @enderror" 
                           id="senha" 
                           name="senha" 
                           required>
                    @error('senha')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="role_id" class="form-label">Perfil *</label>
                    <select class="form-select @error('role_id') is-invalid @enderror" 
                            id="role_id" 
                            name="role_id" 
                            required>
                        <option value="">Selecione...</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                {{ $role->nome }}
                            </option>
                        @endforeach
                    </select>
                    @error('role_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" 
                           class="form-check-input" 
                           id="ativo" 
                           name="ativo" 
                           value="1" 
                           {{ old('ativo', true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="ativo">Usuário Ativo</label>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Salvar
                </button>
            </form>
        </div>
    </div>
</div>
@endsection