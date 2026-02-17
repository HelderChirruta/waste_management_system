@extends('layouts.admin')

@section('title', 'Detalhes da Entrada')

@section('content')
<div class="container-fluid">
    <!-- Cabeçalho com ações melhorado -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Detalhes da Entrada</h2>
            <span class="text-muted">
                <i class="fas fa-box"></i> Lote: <strong>{{ $entrada->codigo_lote }}</strong>
            </span>
        </div>
        
        <!-- Grupo de botões melhor organizado -->
        <div class="btn-group" role="group">
            <a href="{{ route('operador.entradas.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
            
            <!-- Botão de Movimentação em destaque -->
            <a href="{{ route('operador.movimentacoes.create', ['entrada_id' => $entrada->id]) }}" 
               class="btn btn-success">
                <i class="fas fa-exchange-alt"></i> Nova Movimentação
            </a>
            
            @if($entrada->data_hora_entrada->isToday())
                <a href="{{ route('operador.entradas.edit', $entrada->id) }}" 
                   class="btn btn-warning">
                    <i class="fas fa-edit"></i> Editar
                </a>
            @endif
        </div>
    </div>

    <!-- Status Bar com informações rápidas -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-light">
                <div class="card-body py-2">
                    <small class="text-muted">Quantidade Total</small>
                    <h5 class="mb-0">{{ number_format($entrada->quantidade, 2) }} {{ $entrada->unidade_medida }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light">
                <div class="card-body py-2">
                    <small class="text-muted">Movimentado</small>
                    <h5 class="mb-0 text-info">{{ number_format($entrada->movimentacoes->sum('quantidade'), 2) }} kg</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light">
                <div class="card-body py-2">
                    <small class="text-muted">Saldo Disponível</small>
                    <h5 class="mb-0 text-success">{{ number_format($entrada->quantidade - $entrada->movimentacoes->sum('quantidade'), 2) }} kg</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light">
                <div class="card-body py-2">
                    <small class="text-muted">Estado</small>
                    <h5 class="mb-0">
                        @if($entrada->estado == 'separado')
                            <span class="badge bg-success">Separado</span>
                        @elseif($entrada->estado == 'misturado')
                            <span class="badge bg-warning">Misturado</span>
                        @elseif($entrada->estado == 'contaminado')
                            <span class="badge bg-danger">Contaminado</span>
                        @endif
                    </h5>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Coluna da Esquerda - Informações da Entrada -->
        <div class="col-md-6">
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle text-primary me-2"></i>
                        Informações da Entrada
                    </h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="40%" class="text-muted">Código do Lote:</th>
                            <td><span class="badge bg-info fs-6 px-3 py-2">{{ $entrada->codigo_lote }}</span></td>
                        </tr>
                        <tr>
                            <th class="text-muted">Data/Hora de Entrada:</th>
                            <td>{{ $entrada->data_hora_entrada->format('d/m/Y H:i:s') }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Origem:</th>
                            <td>{{ $entrada->origem->nome ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Tipo de Origem:</th>
                            <td>{{ $entrada->origem->tipo ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Categoria:</th>
                            <td>{{ $entrada->categoria->nome ?? 'N/A' }} ({{ $entrada->categoria->codigo ?? 'N/A' }})</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Quantidade:</th>
                            <td><strong>{{ number_format($entrada->quantidade, 2) }}</strong> {{ $entrada->unidade_medida }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Operador:</th>
                            <td>{{ $entrada->operador->nome_completo ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Observações:</th>
                            <td>{{ $entrada->observacoes ?? 'Sem observações' }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Registado em:</th>
                            <td>{{ $entrada->created_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Última atualização:</th>
                            <td>{{ $entrada->updated_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Coluna da Direita - Movimentações -->
        <div class="col-md-6">
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-history text-success me-2"></i>
                        Movimentações do Lote
                    </h5>
                    
                    <!-- Botão de movimentação também no header -->
                    <a href="{{ route('operador.movimentacoes.create', ['entrada_id' => $entrada->id]) }}" 
                       class="btn btn-success btn-sm">
                        <i class="fas fa-plus"></i> Nova Movimentação
                    </a>
                </div>
                
                <div class="card-body">
                    @if($entrada->movimentacoes->count() > 0)
                        <!-- Timeline -->
                        <div class="timeline">
                            @foreach($entrada->movimentacoes->sortByDesc('data_movimentacao') as $mov)
                                <div class="timeline-item mb-3">
                                    <div class="timeline-marker" style="background: 
                                        @if($mov->tipo_movimentacao == 'separacao') #007bff
                                        @elseif($mov->tipo_movimentacao == 'armazenamento') #17a2b8
                                        @elseif($mov->tipo_movimentacao == 'venda') #28a745
                                        @elseif($mov->tipo_movimentacao == 'descarte') #dc3545
                                        @endif">
                                    </div>
                                    <div class="timeline-content">
                                        <div class="card border-0 bg-light">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <span class="badge 
                                                            @if($mov->tipo_movimentacao == 'separacao') bg-primary
                                                            @elseif($mov->tipo_movimentacao == 'armazenamento') bg-info
                                                            @elseif($mov->tipo_movimentacao == 'venda') bg-success
                                                            @elseif($mov->tipo_movimentacao == 'descarte') bg-danger
                                                            @endif mb-2">
                                                            {{ ucfirst($mov->tipo_movimentacao) }}
                                                        </span>
                                                    </div>
                                                    <small class="text-muted">
                                                        <i class="far fa-clock"></i> {{ $mov->data_movimentacao->diffForHumans() }}
                                                    </small>
                                                </div>
                                                
                                                <div class="row mt-2">
                                                    <div class="col-6">
                                                        <small class="text-muted d-block">Quantidade</small>
                                                        <strong>{{ number_format($mov->quantidade, 2) }} kg</strong>
                                                    </div>
                                                    @if($mov->localizacao)
                                                    <div class="col-6">
                                                        <small class="text-muted d-block">Localização</small>
                                                        <span>{{ $mov->localizacao }}</span>
                                                    </div>
                                                    @endif
                                                </div>
                                                
                                                @if($mov->destino)
                                                <div class="mt-2">
                                                    <small class="text-muted d-block">Destino</small>
                                                    <span>{{ $mov->destino }}</span>
                                                </div>
                                                @endif
                                                
                                                <div class="mt-2">
                                                    <small class="text-muted d-block">Responsável</small>
                                                    <span>{{ $mov->responsavel->nome_completo ?? 'N/A' }}</span>
                                                </div>
                                                
                                                @if($mov->observacoes)
                                                <div class="mt-2 p-2 bg-white rounded">
                                                    <small class="text-muted">
                                                        <i class="fas fa-quote-left"></i> {{ $mov->observacoes }}
                                                    </small>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="fas fa-box-open fa-4x text-muted"></i>
                            </div>
                            <h6 class="text-muted mb-3">Nenhuma movimentação registrada</h6>
                            <a href="{{ route('operador.movimentacoes.create', ['entrada_id' => $entrada->id]) }}" 
                               class="btn btn-success">
                                <i class="fas fa-plus"></i> Adicionar Primeira Movimentação
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}
.timeline:before {
    content: '';
    position: absolute;
    left: 10px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e9ecef;
}
.timeline-item {
    position: relative;
    margin-bottom: 20px;
}
.timeline-marker {
    position: absolute;
    left: -34px;
    top: 20px;
    width: 14px;
    height: 14px;
    border-radius: 50%;
    border: 3px solid white;
    box-shadow: 0 0 0 2px #dee2e6;
    z-index: 1;
}
.timeline-content {
    margin-left: 0;
}
.card {
    transition: all 0.2s;
}
.card:hover {
    transform: translateX(5px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
.btn-group .btn {
    margin-left: 5px;
    border-radius: 5px !important;
}
.btn-group .btn:first-child {
    margin-left: 0;
}
</style>
@endsection