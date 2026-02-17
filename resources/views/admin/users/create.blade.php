@extends('layouts.admin')

@section('title', 'Novo Usuário')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Novo Usuário</h2>
            <p class="text-muted">
                <i class="fas fa-user-plus me-2"></i>
                Preencha os dados para criar um novo usuário
            </p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Voltar
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">
                <i class="fas fa-user text-primary me-2"></i>
                Informações do Usuário
            </h5>
        </div>
        <div class="card-body">
            <!-- MOSTRAR ERROS DE VALIDAÇÃO -->
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- MOSTRAR MENSAGEM DE ERRO -->
            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('admin.users.store') }}" method="POST" id="formCreateUser">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nome_completo" class="form-label">
                            <i class="fas fa-user text-primary me-1"></i>
                            Nome Completo *
                        </label>
                        <input type="text" 
                               class="form-control @error('nome_completo') is-invalid @enderror" 
                               id="nome_completo" 
                               name="nome_completo" 
                               value="{{ old('nome_completo') }}" 
                               placeholder="Digite o nome completo"
                               required>
                        @error('nome_completo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope text-primary me-1"></i>
                            E-mail *
                        </label>
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               placeholder="exemplo@email.com"
                               required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="senha" class="form-label">
                            <i class="fas fa-lock text-primary me-1"></i>
                            Senha *
                        </label>
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               id="password" 
                               name="password" 
                               placeholder="Mínimo 6 caracteres"
                               required>
                        <small class="text-muted">A senha deve ter no mínimo 6 caracteres</small>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="role_id" class="form-label">
                            <i class="fas fa-user-tag text-primary me-1"></i>
                            Perfil de Acesso *
                        </label>
                        <select class="form-select @error('role_id') is-invalid @enderror" 
                                id="role_id" 
                                name="role_id" 
                                required>
                            <option value="">Selecione um perfil...</option>
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

                    <div class="col-12 mb-3">
                        <div class="form-check">
                            <input type="checkbox" 
                                   class="form-check-input" 
                                   id="ativo" 
                                   name="ativo" 
                                   value="1" 
                                   {{ old('ativo', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="ativo">
                                <i class="fas fa-check-circle text-success me-1"></i>
                                Usuário Ativo
                            </label>
                        </div>
                        <small class="text-muted">Usuários inativos não podem acessar o sistema</small>
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary" id="btnSubmit">
                        <i class="fas fa-save me-2"></i>
                        Salvar Usuário
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-2"></i>
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formCreateUser');
    const btnSubmit = document.getElementById('btnSubmit');

    form.addEventListener('submit', function(e) {
        // Mostrar loading no botão
        btnSubmit.disabled = true;
        btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Salvando...';
        
        // O formulário vai enviar normalmente
        // Se houver erro, a página recarrega com os errors
    });

    // Validar senha em tempo real
    const senhaInput = document.getElementById('senha');
    senhaInput.addEventListener('input', function() {
        if (this.value.length < 6 && this.value.length > 0) {
            this.classList.add('is-invalid');
        } else {
            this.classList.remove('is-invalid');
        }
    });
});
</script>
@endpush
@endsection