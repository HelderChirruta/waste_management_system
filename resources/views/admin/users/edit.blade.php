@extends('layouts.admin')

@section('title', 'Editar Usuário')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Editar Usuário: {{ $user->nome_completo }}</h2>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nome_completo" class="form-label">Nome Completo *</label>
                    <input type="text" 
                           class="form-control @error('nome_completo') is-invalid @enderror" 
                           id="nome_completo" 
                           name="nome_completo" 
                           value="{{ old('nome_completo', $user->nome_completo) }}" 
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
                           value="{{ old('email', $user->email) }}" 
                           required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="senha" class="form-label">Nova Senha (deixe em branco para manter a atual)</label>
                    <input type="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           id="password" 
                           name="password">
                    @error('password')
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
                            <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
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
                           {{ old('ativo', $user->ativo) ? 'checked' : '' }}>
                    <label class="form-check-label" for="ativo">Usuário Ativo</label>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Atualizar
                </button>
            </form>
        </div>
    </div>
</div>
@endsection