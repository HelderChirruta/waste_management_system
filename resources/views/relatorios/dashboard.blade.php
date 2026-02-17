@extends('layouts.admin')

@section('title', 'Dashboard de Relatórios')

@section('content')
<div class="container-fluid">
    <!-- Cabeçalho -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Dashboard de Relatórios</h2>
            <p class="text-muted">
                <i class="fas fa-chart-line me-2"></i>
                Análise estatística de resíduos
            </p>
        </div>
        <div class="btn-group">
            <button class="btn btn-outline-primary" onclick="window.location.reload()">
                <i class="fas fa-sync-alt me-2"></i>Atualizar
            </button>
        </div>
    </div>

    <!-- Cards de Estatísticas Melhorados -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card bg-gradient-primary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-label">Hoje</div>
                            <div class="stat-value">{{ number_format($totalResiduosHoje, 2) }} kg</div>
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
            <div class="card stat-card bg-gradient-success text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-label">Este Mês</div>
                            <div class="stat-value">{{ number_format($totalResiduosMes, 2) }} kg</div>
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

        <div class="col-xl-3 col-md-6">
            <div class="card stat-card bg-gradient-info text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-label">Movimentações</div>
                            <div class="stat-value">{{ $totalMovimentacoes }}</div>
                            <div class="stat-change text-white-50">
                                <i class="fas fa-exchange-alt me-1"></i>
                                Total no sistema
                            </div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-arrows-spin fa-3x opacity-50"></i>
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
                            <div class="stat-label">Exportar</div>
                            <div class="d-flex gap-2 mt-2">
                                <a href="{{ route('relatorios.exportar-pdf') }}" class="btn btn-sm btn-light">
                                    <i class="fas fa-file-pdf text-danger me-1"></i> PDF
                                </a>
                                <button class="btn btn-sm btn-light" onclick="exportarExcel()">
                                    <i class="fas fa-file-excel text-success me-1"></i> Excel
                                </button>
                            </div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-download fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros de Período -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('relatorios.dashboard') }}" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Data Início</label>
                    <input type="date" name="data_inicio" class="form-control" value="{{ request('data_inicio', now()->subDays(30)->format('Y-m-d')) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Data Fim</label>
                    <input type="date" name="data_fim" class="form-control" value="{{ request('data_fim', now()->format('Y-m-d')) }}">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter me-2"></i>Filtrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Gráficos -->
    <div class="row g-4">
        <div class="col-xl-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-line text-primary me-2"></i>
                        Entradas - Últimos 30 Dias
                    </h5>
                </div>
                <div class="card-body">
                    @if($entradasPorDia->count() > 0)
                        <canvas id="graficoEntradas" style="height: 350px; width: 100%;"></canvas>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-chart-line fa-4x text-muted mb-3"></i>
                            <p class="text-muted">Sem dados para exibir no período.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-pie text-success me-2"></i>
                        Distribuição por Tipo
                    </h5>
                </div>
                <div class="card-body">
                    @if($distribuicaoCategorias->count() > 0)
                        <canvas id="graficoTipos" style="height: 300px; width: 100%;"></canvas>
                        
                        <!-- Legenda adicional -->
                        <div class="mt-4">
                            @foreach($distribuicaoCategorias as $item)
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div>
                                        <span class="badge" style="background-color: {{ $cores[$loop->index] ?? '#4e73df' }}; width: 12px; height: 12px; display: inline-block; border-radius: 50%;"></span>
                                        <span class="ms-2">{{ $item->categoria->nome ?? 'Sem categoria' }}</span>
                                    </div>
                                    <div>
                                        <strong>{{ number_format($item->total, 2) }} kg</strong>
                                        <span class="text-muted ms-2">
                                            ({{ number_format(($item->total / $totalResiduosMes) * 100, 1) }}%)
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-chart-pie fa-4x text-muted mb-3"></i>
                            <p class="text-muted">Sem dados para exibir.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Últimas Entradas -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-clock text-info me-2"></i>
                        Últimas Entradas
                    </h5>
                    <a href="{{ route('operador.entradas.index') }}" class="btn btn-sm btn-outline-primary">
                        Ver todas <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="py-3">Lote</th>
                                    <th class="py-3">Data/Hora</th>
                                    <th class="py-3">Categoria</th>
                                    <th class="py-3">Origem</th>
                                    <th class="py-3">Quantidade</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ultimasEntradas as $entrada)
                                <tr>
                                    <td>
                                        <span class="badge bg-info bg-opacity-10 text-info px-3 py-2">
                                            <i class="fas fa-qrcode me-1"></i>
                                            {{ $entrada->codigo_lote }}
                                        </span>
                                    </td>
                                    <td>
                                        <div>{{ $entrada->data_hora_entrada->format('d/m/Y') }}</div>
                                        <small class="text-muted">{{ $entrada->data_hora_entrada->format('H:i') }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2">
                                            {{ $entrada->categoria->nome ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td>{{ $entrada->origem->nome ?? 'N/A' }}</td>
                                    <td>
                                        <strong>{{ number_format($entrada->quantidade, 2) }}</strong>
                                        <small class="text-muted">{{ $entrada->unidade_medida }}</small>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">Nenhuma entrada registrada.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
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

/* Card improvements */
.card {
    border: none;
    border-radius: 15px;
    transition: all 0.3s;
}

.card-header {
    border-radius: 15px 15px 0 0 !important;
    border-bottom: 1px solid rgba(0,0,0,0.05);
}

/* Table improvements */
.table th {
    font-weight: 600;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #6c757d;
}

.table td {
    padding: 1rem 0.75rem;
    vertical-align: middle;
}

/* Badge improvements */
.badge {
    font-weight: 500;
    font-size: 0.85rem;
}
</style>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Debug: Verificar dados no console
    console.log('Dados recebidos:', {
        entradasPorDia: {!! json_encode($entradasPorDia) !!},
        distribuicao: {!! json_encode($distribuicaoCategorias) !!}
    });

    @if($entradasPorDia->count() > 0)
    // Gráfico de entradas por dia
    const ctx = document.getElementById('graficoEntradas').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($entradasPorDia->pluck('data')->map(function($d) { 
                return \Carbon\Carbon::parse($d)->format('d/m');
            })) !!},
            datasets: [{
                label: 'Quantidade (kg)',
                data: {!! json_encode($entradasPorDia->pluck('total')->map(function($v) { 
                    return floatval($v); 
                })) !!},
                borderColor: '#4e73df',
                backgroundColor: 'rgba(78, 115, 223, 0.05)',
                borderWidth: 2,
                pointBackgroundColor: '#4e73df',
                pointBorderColor: 'white',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.raw.toFixed(2) + ' kg';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0,0,0,0.05)'
                    },
                    ticks: {
                        callback: function(value) {
                            return value.toFixed(0) + ' kg';
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
    @endif

    @if($distribuicaoCategorias->count() > 0)
    // Cores para o gráfico
    const cores = [
        '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', 
        '#6610f2', '#fd7e14', '#20c9a6', '#e83e8c', '#6f42c1'
    ];
    
    // Gráfico de distribuição por categoria
    const ctx2 = document.getElementById('graficoTipos').getContext('2d');
    new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($distribuicaoCategorias->pluck('categoria.nome')->map(function($nome) {
                return $nome ?? 'Sem categoria';
            })) !!},
            datasets: [{
                data: {!! json_encode($distribuicaoCategorias->pluck('total')->map(function($v) { 
                    return floatval($v); 
                })) !!},
                backgroundColor: cores.slice(0, {{ $distribuicaoCategorias->count() }}),
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let total = context.dataset.data.reduce((a, b) => a + b, 0);
                            let percentual = ((context.raw / total) * 100).toFixed(1);
                            return context.raw.toFixed(2) + ' kg (' + percentual + '%)';
                        }
                    }
                }
            },
            cutout: '60%'
        }
    });
    @endif
});

// Função para exportar Excel (placeholder)
function exportarExcel() {
    alert('Funcionalidade de exportação Excel será implementada em breve!');
}
</script>
@endpush
@endsection