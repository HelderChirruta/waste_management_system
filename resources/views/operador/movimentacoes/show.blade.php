@extends('layouts.admin')

@section('title', 'Detalhes da Movimentação #' . $movimentacao->id)

@section('content')
<div class="container-fluid">
    <!-- Cabeçalho com breadcrumb -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="{{ route('operador.movimentacoes.index') }}">Movimentações</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detalhes #{{ $movimentacao->id }}</li>
                </ol>
            </nav>
            <h2 class="mb-0">
                <i class="fas fa-exchange-alt text-primary me-2"></i>
                Detalhes da Movimentação #{{ $movimentacao->id }}
            </h2>
        </div>
        <div class="d-flex gap-2">
            @if($movimentacao->data_movimentacao->isToday())
                <a href="{{ route('operador.movimentacoes.edit', $movimentacao->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit me-2"></i>Editar
                </a>
            @endif
            <a href="{{ route('operador.movimentacoes.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Voltar
            </a>
        </div>
    </div>

    <!-- Status Bar -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card bg-light border-0">
                <div class="card-body">
                    <small class="text-muted text-uppercase">Tipo de Movimentação</small>
                    <div class="d-flex align-items-center mt-2">
                        @php
                            $tipoConfig = [
                                'separacao' => ['bg-primary', 'fa-code-branch', 'Separação'],
                                'armazenamento' => ['bg-info', 'fa-warehouse', 'Armazenamento'],
                                'venda' => ['bg-success', 'fa-tags', 'Venda'],
                                'descarte' => ['bg-danger', 'fa-trash', 'Descarte']
                            ];
                            $config = $tipoConfig[$movimentacao->tipo_movimentacao] ?? ['bg-secondary', 'fa-question', 'Desconhecido'];
                        @endphp
                        <span class="badge {{ $config[0] }} p-3 fs-6">
                            <i class="fas {{ $config[1] }} me-2"></i>
                            {{ $config[2] }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-light border-0">
                <div class="card-body">
                    <small class="text-muted text-uppercase">Quantidade</small>
                    <div class="d-flex align-items-center mt-2">
                        <i class="fas fa-weight-scale fa-2x text-primary me-3"></i>
                        <div>
                            <h3 class="mb-0">{{ number_format($movimentacao->quantidade, 2) }}</h3>
                            <small class="text-muted">quilogramas (kg)</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-light border-0">
                <div class="card-body">
                    <small class="text-muted text-uppercase">Data/Hora</small>
                    <div class="d-flex align-items-center mt-2">
                        <i class="fas fa-calendar-alt fa-2x text-success me-3"></i>
                        <div>
                            <h6 class="mb-0">{{ $movimentacao->data_movimentacao->format('d/m/Y') }}</h6>
                            <small class="text-muted">{{ $movimentacao->data_movimentacao->format('H:i:s') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-light border-0">
                <div class="card-body">
                    <small class="text-muted text-uppercase">Responsável</small>
                    <div class="d-flex align-items-center mt-2">
                        <i class="fas fa-user-circle fa-2x text-info me-3"></i>
                        <div>
                            <h6 class="mb-0">{{ $movimentacao->responsavel->nome_completo ?? 'N/A' }}</h6>
                            <small class="text-muted">{{ $movimentacao->responsavel->email ?? '' }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Informações Detalhadas -->
    <div class="row">
        <!-- Coluna Esquerda - Detalhes da Movimentação -->
        <div class="col-lg-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle text-primary me-2"></i>
                        Informações Detalhadas
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tr>
                                <th width="35%" class="text-muted">ID da Movimentação:</th>
                                <td><span class="badge bg-secondary">#{{ $movimentacao->id }}</span></td>
                            </tr>
                            <tr>
                                <th class="text-muted">Tipo:</th>
                                <td>
                                    <span class="badge {{ $config[0] }} px-3 py-2">
                                        <i class="fas {{ $config[1] }} me-1"></i>
                                        {{ $config[2] }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-muted">Quantidade:</th>
                                <td>
                                    <strong class="fs-5">{{ number_format($movimentacao->quantidade, 2) }}</strong>
                                    <small class="text-muted">kg</small>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-muted">Data/Hora:</th>
                                <td>
                                    <i class="far fa-calendar-alt me-1"></i>
                                    {{ $movimentacao->data_movimentacao->format('d/m/Y') }}
                                    <i class="far fa-clock ms-3 me-1"></i>
                                    {{ $movimentacao->data_movimentacao->format('H:i:s') }}
                                </td>
                            </tr>
                            @if($movimentacao->localizacao)
                            <tr>
                                <th class="text-muted">Localização:</th>
                                <td>
                                    <i class="fas fa-map-marker-alt text-danger me-1"></i>
                                    {{ $movimentacao->localizacao }}
                                </td>
                            </tr>
                            @endif
                            @if($movimentacao->destino)
                            <tr>
                                <th class="text-muted">Destino:</th>
                                <td>
                                    <i class="fas fa-arrow-right text-success me-1"></i>
                                    {{ $movimentacao->destino }}
                                </td>
                            </tr>
                            @endif
                            <tr>
                                <th class="text-muted">Responsável:</th>
                                <td>
                                    <i class="fas fa-user me-1"></i>
                                    {{ $movimentacao->responsavel->nome_completo ?? 'N/A' }}
                                    <br>
                                    <small class="text-muted ms-3">{{ $movimentacao->responsavel->email ?? '' }}</small>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-muted">Registado em:</th>
                                <td>
                                    <i class="far fa-clock me-1"></i>
                                    {{ $movimentacao->created_at->format('d/m/Y H:i:s') }}
                                    @if($movimentacao->created_at != $movimentacao->updated_at)
                                        <span class="badge bg-warning ms-2">Editado</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="text-muted">Última atualização:</th>
                                <td>
                                    <i class="far fa-edit me-1"></i>
                                    {{ $movimentacao->updated_at->format('d/m/Y H:i:s') }}
                                </td>
                            </tr>
                            @if($movimentacao->observacoes)
                            <tr>
                                <th class="text-muted">Observações:</th>
                                <td>
                                    <div class="bg-light p-3 rounded">
                                        <i class="fas fa-quote-left text-muted me-1"></i>
                                        {{ $movimentacao->observacoes }}
                                    </div>
                                </td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Coluna Direita - Informações do Lote -->
        <div class="col-lg-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-box text-success me-2"></i>
                        Lote Relacionado
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tr>
                                <th width="35%" class="text-muted">Código do Lote:</th>
                                <td>
                                    <a href="{{ route('operador.entradas.show', $movimentacao->entrada_id) }}" 
                                       class="text-decoration-none">
                                        <span class="badge bg-info px-3 py-2">
                                            <i class="fas fa-qrcode me-1"></i>
                                            {{ $movimentacao->entrada->codigo_lote ?? 'N/A' }}
                                        </span>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-muted">Categoria:</th>
                                <td>
                                    <span class="badge bg-secondary px-3 py-2">
                                        {{ $movimentacao->entrada->categoria->nome ?? 'N/A' }}
                                    </span>
                                    <small class="text-muted d-block">
                                        {{ $movimentacao->entrada->categoria->codigo ?? '' }}
                                    </small>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-muted">Origem:</th>
                                <td>
                                    <strong>{{ $movimentacao->entrada->origem->nome ?? 'N/A' }}</strong>
                                    <small class="text-muted d-block">
                                        Tipo: {{ $movimentacao->entrada->origem->tipo ?? '' }}
                                    </small>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-muted">Data de Entrada:</th>
                                <td>
                                    <i class="far fa-calendar-alt me-1"></i>
                                    {{ $movimentacao->entrada->data_hora_entrada->format('d/m/Y H:i') }}
                                </td>
                            </tr>
                            <tr>
                                <th class="text-muted">Quantidade Total:</th>
                                <td>
                                    <strong>{{ number_format($movimentacao->entrada->quantidade, 2) }}</strong>
                                    <small class="text-muted">{{ $movimentacao->entrada->unidade_medida }}</small>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-muted">Estado do Lote:</th>
                                <td>
                                    @php
                                        $estadoClasses = [
                                            'separado' => 'success',
                                            'misturado' => 'warning',
                                            'contaminado' => 'danger'
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $estadoClasses[$movimentacao->entrada->estado] ?? 'secondary' }} px-3 py-2">
                                        {{ ucfirst($movimentacao->entrada->estado ?? 'N/A') }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 py-3">
                    <a href="{{ route('operador.entradas.show', $movimentacao->entrada_id) }}" 
                       class="btn btn-outline-primary w-100">
                        <i class="fas fa-eye me-2"></i>
                        Ver detalhes completos do lote
                    </a>
                </div>
            </div>

            <!-- Histórico do Lote (opcional) -->
            @if($movimentacao->entrada->movimentacoes->count() > 1)
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-history text-info me-2"></i>
                        Outras Movimentações deste Lote
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @foreach($movimentacao->entrada->movimentacoes->where('id', '!=', $movimentacao->id)->take(5) as $mov)
                            <a href="{{ route('operador.movimentacoes.show', $mov->id) }}" 
                               class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="badge 
                                        @if($mov->tipo_movimentacao == 'separacao') bg-primary
                                        @elseif($mov->tipo_movimentacao == 'armazenamento') bg-info
                                        @elseif($mov->tipo_movimentacao == 'venda') bg-success
                                        @elseif($mov->tipo_movimentacao == 'descarte') bg-danger
                                        @endif me-2">
                                        {{ ucfirst($mov->tipo_movimentacao) }}
                                    </span>
                                    <span>{{ number_format($mov->quantidade, 2) }} kg</span>
                                </div>
                                <small class="text-muted">{{ $mov->data_movimentacao->format('d/m/Y H:i') }}</small>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
/* Breadcrumb styling */
.breadcrumb {
    background: none;
    padding: 0;
}

.breadcrumb-item a {
    color: #4e73df;
    text-decoration: none;
}

.breadcrumb-item a:hover {
    text-decoration: underline;
}

.breadcrumb-item.active {
    color: #6c757d;
}

/* Card enhancements */
.card {
    border: none;
    border-radius: 15px;
    transition: all 0.3s;
}

.card:hover {
    box-shadow: 0 8px 15px rgba(0,0,0,0.1) !important;
}

.card-header {
    border-radius: 15px 15px 0 0 !important;
    border-bottom: 1px solid rgba(0,0,0,0.05);
}

/* Table styling */
.table th {
    font-weight: 500;
    color: #495057;
    border-top: none;
    padding-left: 0;
}

.table td {
    border-top: none;
    padding-right: 0;
}

/* Badge enhancements */
.badge {
    font-weight: 500;
    font-size: 0.9rem;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .d-flex.justify-content-between {
        flex-direction: column;
        align-items: start !important;
        gap: 15px;
    }
    
    .btn-group {
        width: 100%;
    }
    
    .btn-group .btn {
        flex: 1;
    }
}
</style>

@push('scripts')
<script>
    // Adicionar tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });

    // Função para imprimir (opcional)
    function imprimirMovimentacao() {
        window.print();
    }
</script>
@endpush
@endsection