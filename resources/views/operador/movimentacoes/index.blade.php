@extends('layouts.admin')

@section('title', 'Movimentações de Resíduos')

@section('content')
<div class="container-fluid">
    <!-- Cabeçalho com estatísticas rápidas -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card stats-card bg-gradient-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Total Movimentações</h6>
                            <h3 class="mb-0">{{ $movimentacoes->total() }}</h3>
                        </div>
                        <div class="stats-icon">
                            <i class="fas fa-exchange-alt fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stats-card bg-gradient-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Quantidade Total</h6>
                            <h3 class="mb-0">{{ number_format($movimentacoes->sum('quantidade'), 0) }} kg</h3>
                        </div>
                        <div class="stats-icon">
                            <i class="fas fa-weight fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stats-card bg-gradient-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Hoje</h6>
                            <h3 class="mb-0">{{ number_format($movimentacoes->where('data_movimentacao', '>=', today())->sum('quantidade'), 0) }} kg</h3>
                        </div>
                        <div class="stats-icon">
                            <i class="fas fa-calendar-day fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card stats-card bg-gradient-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Média por Mov.</h6>
                            <h3 class="mb-0">{{ number_format($movimentacoes->avg('quantidade') ?? 0, 1) }} kg</h3>
                        </div>
                        <div class="stats-icon">
                            <i class="fas fa-chart-line fa-2x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros e Ações -->
    <div class="card mb-4 border-0 shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex gap-2 flex-wrap">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="window.location.href='{{ route('operador.movimentacoes.index') }}'">
                            <i class="fas fa-list"></i> Todos
                        </button>
                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="window.location.href='{{ route('operador.movimentacoes.index', ['tipo' => 'separacao']) }}'">
                            Separação
                        </button>
                        <button type="button" class="btn btn-outline-info btn-sm" onclick="window.location.href='{{ route('operador.movimentacoes.index', ['tipo' => 'armazenamento']) }}'">
                            Armazenamento
                        </button>
                        <button type="button" class="btn btn-outline-success btn-sm" onclick="window.location.href='{{ route('operador.movimentacoes.index', ['tipo' => 'venda']) }}'">
                            Venda
                        </button>
                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="window.location.href='{{ route('operador.movimentacoes.index', ['tipo' => 'descarte']) }}'">
                            Descarte
                        </button>
                    </div>
                </div>
                
                <div>
                    <a href="{{ route('operador.movimentacoes.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Nova Movimentação
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de Movimentações -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-list-alt text-primary me-2"></i>
                    Lista de Movimentações
                </h5>
                <span class="badge bg-light text-dark">
                    Total: {{ $movimentacoes->total() }} registros
                </span>
            </div>
        </div>
        
        <div class="card-body p-0">
            @if(session('success'))
                <div class="alert alert-success m-3">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger m-3">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="py-3">ID</th>
                            <th class="py-3">Lote</th>
                            <th class="py-3">Tipo</th>
                            <th class="py-3">Quantidade</th>
                            <th class="py-3">Data/Hora</th>
                            <th class="py-3">Localização/Destino</th>
                            <th class="py-3">Responsável</th>
                            <th class="py-3 text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($movimentacoes as $mov)
                        <tr>
                            <td class="fw-bold">#{{ $mov->id }}</td>
                            <td>
                                <a href="{{ route('operador.entradas.show', $mov->entrada_id) }}" class="text-decoration-none">
                                    <span class="badge bg-info bg-opacity-10 text-info px-3 py-2">
                                        <i class="fas fa-box me-1"></i>
                                        {{ $mov->entrada->codigo_lote ?? 'N/A' }}
                                    </span>
                                </a>
                            </td>
                            <td>
                                @php
                                    $tipoClasses = [
                                        'separacao' => 'bg-primary',
                                        'armazenamento' => 'bg-info',
                                        'venda' => 'bg-success',
                                        'descarte' => 'bg-danger'
                                    ];
                                    $tipoIcones = [
                                        'separacao' => 'fa-code-branch',
                                        'armazenamento' => 'fa-warehouse',
                                        'venda' => 'fa-tags',
                                        'descarte' => 'fa-trash'
                                    ];
                                @endphp
                                <span class="badge {{ $tipoClasses[$mov->tipo_movimentacao] ?? 'bg-secondary' }} px-3 py-2">
                                    <i class="fas {{ $tipoIcones[$mov->tipo_movimentacao] ?? 'fa-question' }} me-1"></i>
                                    {{ ucfirst($mov->tipo_movimentacao) }}
                                </span>
                            </td>
                            <td>
                                <strong>{{ number_format($mov->quantidade, 2) }}</strong> 
                                <small class="text-muted">kg</small>
                            </td>
                            <td>
                                <div>{{ $mov->data_movimentacao->format('d/m/Y') }}</div>
                                <small class="text-muted">{{ $mov->data_movimentacao->format('H:i') }}</small>
                            </td>
                            <td>
                                @if($mov->localizacao)
                                    <div>
                                        <i class="fas fa-map-marker-alt text-muted me-1"></i>
                                        {{ $mov->localizacao }}
                                    </div>
                                @endif
                                @if($mov->destino)
                                    <div>
                                        <i class="fas fa-arrow-right text-muted me-1"></i>
                                        {{ $mov->destino }}
                                    </div>
                                @endif
                                @if(!$mov->localizacao && !$mov->destino)
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-user-circle text-muted me-2"></i>
                                    {{ $mov->responsavel->nome_completo ?? 'N/A' }}
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('operador.movimentacoes.show', $mov->id) }}" 
                                       class="btn btn-sm btn-outline-info" 
                                       data-bs-toggle="tooltip" 
                                       title="Ver detalhes">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($mov->data_movimentacao->isToday())
                                        <a href="{{ route('operador.movimentacoes.edit', $mov->id) }}" 
                                           class="btn btn-sm btn-outline-warning"
                                           data-bs-toggle="tooltip" 
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('operador.movimentacoes.destroy', $mov->id) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Tem certeza que deseja excluir esta movimentação?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-outline-danger"
                                                    data-bs-toggle="tooltip" 
                                                    title="Excluir">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="fas fa-exchange-alt fa-4x text-muted mb-3"></i>
                                    <h5 class="text-muted mb-3">Nenhuma movimentação encontrada</h5>
                                    <p class="text-muted mb-4">Comece registrando a primeira movimentação</p>
                                    <a href="{{ route('operador.movimentacoes.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Nova Movimentação
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($movimentacoes->hasPages())
            <div class="d-flex justify-content-between align-items-center px-3 py-3 border-top">
                <div class="text-muted small">
                    Mostrando {{ $movimentacoes->firstItem() ?? 0 }} a {{ $movimentacoes->lastItem() ?? 0 }} de {{ $movimentacoes->total() }} registros
                </div>
                <div>
                    {{ $movimentacoes->links() }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
/* Stats Cards */
.stats-card {
    border: none;
    border-radius: 15px;
    overflow: hidden;
    transition: transform 0.2s;
}

.stats-card:hover {
    transform: translateY(-5px);
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.bg-gradient-success {
    background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);
}

.bg-gradient-info {
    background: linear-gradient(135deg, #6B73FF 0%, #000DFF 100%);
}

.bg-gradient-warning {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.stats-icon {
    width: 60px;
    height: 60px;
    background: rgba(255,255,255,0.2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Empty State */
.empty-state {
    padding: 40px;
}

.empty-state i {
    opacity: 0.5;
}

/* Table Improvements */
.table th {
    font-weight: 600;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #6c757d;
}

.table td {
    vertical-align: middle;
}

.btn-group .btn {
    padding: 0.25rem 0.5rem;
}

/* Badge styles */
.badge {
    font-weight: 500;
    font-size: 0.85rem;
}

/* Responsive */
@media (max-width: 768px) {
    .stats-card {
        margin-bottom: 15px;
    }
    
    .btn-group {
        flex-wrap: wrap;
    }
}
</style>

@push('scripts')
<script>
    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endpush
@endsection