@extends('layouts.admin')

@section('title', 'Entradas de Resíduos')

@section('content')
<div class="container-fluid">
    <!-- Cabeçalho com estatísticas rápidas -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Entradas de Resíduos</h2>
            <p class="text-muted">
                <i class="fas fa-truck-loading me-2"></i>
                Gestão de registros de entrada
            </p>
        </div>
        <a href="{{ route('operador.entradas.create') }}" class="btn btn-primary btn-lg">
            <i class="fas fa-plus-circle me-2"></i>
            Nova Entrada
        </a>
    </div>

    <!-- Cards de Estatísticas -->
    @php
        $totalHoje = \App\Models\EntradaResiduo::whereDate('data_hora_entrada', today())->sum('quantidade');
        $totalMes = \App\Models\EntradaResiduo::whereMonth('data_hora_entrada', now()->month)->sum('quantidade');
        $mediaDiaria = $entradas->total() > 0 ? $entradas->sum('quantidade') / $entradas->total() : 0;
    @endphp

    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card bg-gradient-primary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-label">Total Registros</div>
                            <div class="stat-value">{{ $entradas->total() }}</div>
                            <div class="stat-change text-white-50">
                                <i class="fas fa-chart-line me-1"></i> 
                                {{ $entradas->total() > 0 ? number_format(($entradas->total() / max(1, $entradas->total() - $entradas->perPage())) * 100, 1) : 0 }}% vs período anterior
                            </div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-clipboard-list fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card stat-card bg-gradient-success text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-label">Quantidade Total</div>
                            <div class="stat-value">{{ number_format($entradas->sum('quantidade'), 0) }} kg</div>
                            <div class="stat-change text-white-50">
                                <i class="fas fa-weight-scale me-1"></i> 
                                Média: {{ number_format($mediaDiaria, 1) }} kg/registro
                            </div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-weight-hanging fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card stat-card bg-gradient-info text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-label">Hoje</div>
                            <div class="stat-value">{{ number_format($totalHoje, 0) }} kg</div>
                            <div class="stat-change text-white-50">
                                <i class="fas fa-calendar-day me-1"></i> 
                                {{ now()->format('d/m/Y') }}
                            </div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-sun fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card stat-card bg-gradient-warning text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-label">Este Mês</div>
                            <div class="stat-value">{{ number_format($totalMes, 0) }} kg</div>
                            <div class="stat-change text-white-50">
                                <i class="fas fa-calendar-alt me-1"></i>
                                {{ now()->format('F Y') }}
                            </div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-calendar-check fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros Avançados -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">
                <i class="fas fa-filter text-primary me-2"></i>
                Filtros de Pesquisa
            </h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('operador.entradas.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="data_inicio" class="form-label">
                        <i class="fas fa-calendar-alt me-1"></i>Data Início
                    </label>
                    <input type="date" class="form-control" id="data_inicio" name="data_inicio" value="{{ request('data_inicio') }}">
                </div>
                <div class="col-md-3">
                    <label for="data_fim" class="form-label">
                        <i class="fas fa-calendar-alt me-1"></i>Data Fim
                    </label>
                    <input type="date" class="form-control" id="data_fim" name="data_fim" value="{{ request('data_fim') }}">
                </div>
                <div class="col-md-3">
                    <label for="categoria_id" class="form-label">
                        <i class="fas fa-tag me-1"></i>Categoria
                    </label>
                    <select class="form-select select2" id="categoria_id" name="categoria_id">
                        <option value="">Todas as categorias</option>
                        @foreach($categorias ?? [] as $categoria)
                            <option value="{{ $categoria->id }}" {{ request('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                {{ $categoria->nome }} ({{ $categoria->codigo }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="estado" class="form-label">
                        <i class="fas fa-circle me-1"></i>Estado
                    </label>
                    <select class="form-select" id="estado" name="estado">
                        <option value="">Todos os estados</option>
                        <option value="separado" {{ request('estado') == 'separado' ? 'selected' : '' }}>Separado</option>
                        <option value="misturado" {{ request('estado') == 'misturado' ? 'selected' : '' }}>Misturado</option>
                        <option value="contaminado" {{ request('estado') == 'contaminado' ? 'selected' : '' }}>Contaminado</option>
                    </select>
                </div>
                <div class="col-12">
                    <hr class="my-3">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-2"></i>Aplicar Filtros
                        </button>
                        <a href="{{ route('operador.entradas.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-undo me-2"></i>Limpar Filtros
                        </a>
                        <button type="button" class="btn btn-outline-success ms-auto" onclick="exportarExcel()">
                            <i class="fas fa-file-excel me-2"></i>Exportar Excel
                        </button>
                        <button type="button" class="btn btn-outline-danger" onclick="exportarPDF()">
                            <i class="fas fa-file-pdf me-2"></i>Exportar PDF
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Lista de Entradas -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0">
                    <i class="fas fa-list-alt text-primary me-2"></i>
                    Registros de Entrada
                </h5>
            </div>
            <div class="d-flex gap-2">
                <span class="badge bg-light text-dark p-2">
                    <i class="fas fa-chart-simple me-1"></i>
                    Total: {{ number_format($entradas->sum('quantidade'), 0) }} kg
                </span>
                <span class="badge bg-light text-dark p-2">
                    <i class="fas fa-layer-group me-1"></i>
                    {{ $entradas->total() }} registros
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
                            <th class="py-3">Lote</th>
                            <th class="py-3">Data/Hora</th>
                            <th class="py-3">Origem</th>
                            <th class="py-3">Categoria</th>
                            <th class="py-3">Quantidade</th>
                            <th class="py-3">Estado</th>
                            <th class="py-3">Operador</th>
                            <th class="py-3 text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($entradas as $entrada)
                        <tr>
                            <td>
                                <span class="badge bg-info bg-opacity-10 text-info px-3 py-2">
                                    <i class="fas fa-qrcode me-1"></i>
                                    {{ $entrada->codigo_lote }}
                                </span>
                            </td>
                            <td>
                                <div>{{ $entrada->data_hora_entrada->format('d/m/Y') }}</div>
                                <small class="text-muted">
                                    <i class="far fa-clock me-1"></i>
                                    {{ $entrada->data_hora_entrada->format('H:i') }}
                                </small>
                            </td>
                            <td>
                                <div>{{ $entrada->origem->nome ?? 'N/A' }}</div>
                                <small class="text-muted">{{ $entrada->origem->tipo ?? '' }}</small>
                            </td>
                            <td>
                                <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2">
                                    {{ $entrada->categoria->nome ?? 'N/A' }}
                                </span>
                            </td>
                            <td>
                                <strong>{{ number_format($entrada->quantidade, 2) }}</strong>
                                <small class="text-muted">{{ $entrada->unidade_medida }}</small>
                                @php
                                    $movimentado = $entrada->movimentacoes->sum('quantidade');
                                    $percentual = $entrada->quantidade > 0 ? ($movimentado / $entrada->quantidade) * 100 : 0;
                                @endphp
                                @if($movimentado > 0)
                                    <div class="progress mt-1" style="height: 4px;">
                                        <div class="progress-bar bg-success" style="width: {{ $percentual }}%"></div>
                                    </div>
                                    <small class="text-muted">{{ number_format($movimentado, 1) }} kg mov.</small>
                                @endif
                            </td>
                            <td>
                                @if($entrada->estado == 'separado')
                                    <span class="badge bg-success px-3 py-2">
                                        <i class="fas fa-check-circle me-1"></i>Separado
                                    </span>
                                @elseif($entrada->estado == 'misturado')
                                    <span class="badge bg-warning px-3 py-2">
                                        <i class="fas fa-circle-exclamation me-1"></i>Misturado
                                    </span>
                                @elseif($entrada->estado == 'contaminado')
                                    <span class="badge bg-danger px-3 py-2">
                                        <i class="fas fa-triangle-exclamation me-1"></i>Contaminado
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-user-circle text-muted me-2"></i>
                                    <div>
                                        <div>{{ $entrada->operador->nome_completo ?? 'N/A' }}</div>
                                        @if($entrada->created_at != $entrada->updated_at)
                                            <small class="text-muted">
                                                <i class="fas fa-pencil-alt me-1"></i>editado
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('operador.entradas.show', $entrada->id) }}" 
                                       class="btn btn-sm btn-outline-info" 
                                       data-bs-toggle="tooltip" 
                                       title="Ver detalhes">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($entrada->data_hora_entrada->isToday())
                                        <a href="{{ route('operador.entradas.edit', $entrada->id) }}" 
                                           class="btn btn-sm btn-outline-warning"
                                           data-bs-toggle="tooltip" 
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('operador.entradas.destroy', $entrada->id) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Tem certeza que deseja excluir esta entrada? Esta ação não pode ser desfeita.')">
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
                                    <a href="{{ route('operador.movimentacoes.create', ['entrada_id' => $entrada->id]) }}" 
                                       class="btn btn-sm btn-outline-success"
                                       data-bs-toggle="tooltip" 
                                       title="Adicionar movimentação">
                                        <i class="fas fa-exchange-alt"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="fas fa-truck-loading fa-4x text-muted mb-3"></i>
                                    <h5 class="text-muted mb-3">Nenhuma entrada encontrada</h5>
                                    <p class="text-muted mb-4">Comece registrando a primeira entrada de resíduos</p>
                                    <a href="{{ route('operador.entradas.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus-circle me-2"></i>
                                        Registrar Primeira Entrada
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($entradas->hasPages())
            <div class="d-flex justify-content-between align-items-center px-3 py-3 border-top">
                <div class="text-muted small">
                    <i class="fas fa-info-circle me-1"></i>
                    Mostrando {{ $entradas->firstItem() ?? 0 }} a {{ $entradas->lastItem() ?? 0 }} de {{ $entradas->total() }} registros
                </div>
                <div>
                    {{ $entradas->appends(request()->query())->onEachSide(1)->links() }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
/* Stats Cards */
.stat-card {
    border: none;
    border-radius: 15px;
    overflow: hidden;
    transition: all 0.3s;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 15px rgba(0,0,0,0.2);
}

.stat-label {
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    opacity: 0.8;
    margin-bottom: 5px;
}

.stat-value {
    font-size: 1.8rem;
    font-weight: 700;
    line-height: 1.2;
    margin-bottom: 5px;
}

.stat-change {
    font-size: 0.8rem;
}

.stat-icon {
    opacity: 0.8;
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

/* Table Improvements */
.table th {
    font-weight: 600;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #495057;
    border-bottom-width: 1px;
}

.table td {
    padding: 1rem 0.75rem;
    vertical-align: middle;
}

.btn-group .btn {
    padding: 0.35rem 0.65rem;
    margin: 0 2px;
}

/* Progress bar */
.progress {
    background-color: #e9ecef;
    border-radius: 2px;
}

/* Empty State */
.empty-state {
    padding: 40px 20px;
}

.empty-state i {
    opacity: 0.5;
}

/* Badge styles */
.badge {
    font-weight: 500;
    font-size: 0.85rem;
}

/* Responsive */
@media (max-width: 768px) {
    .stat-value {
        font-size: 1.5rem;
    }
    
    .btn-group {
        display: flex;
        flex-direction: column;
        gap: 5px;
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

// Auto-submit filters
document.getElementById('categoria_id').addEventListener('change', function() {
    if (this.value) {
        this.form.submit();
    }
});

document.getElementById('estado').addEventListener('change', function() {
    if (this.value) {
        this.form.submit();
    }
});

// Export functions (implement later)
function exportarExcel() {
    alert('Funcionalidade de exportação Excel será implementada em breve!');
}

function exportarPDF() {
    alert('Funcionalidade de exportação PDF será implementada em breve!');
}
</script>
@endpush
@endsection