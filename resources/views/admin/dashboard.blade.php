@extends('layouts.admin')

@section('title', 'Dashboard Administrativo')

@section('content')
<div class="container-fluid">
    <!-- Cabeçalho com saudação -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Dashboard Administrativo</h2>
            <p class="text-muted">
                <i class="fas fa-calendar-alt me-2"></i>
                {{ now()->format('l, d F Y') }}
            </p>
        </div>
        <div class="text-end">
            <span class="badge bg-primary p-3">
                <i class="fas fa-clock me-2"></i>
                Última atualização: {{ now()->format('H:i') }}
            </span>
        </div>
    </div>

    <!-- Cards de Estatísticas Principais -->
    <div class="row g-4 mb-4">
        @php
            $totalUsers = \App\Models\User::count();
            $entradasHoje = \App\Models\EntradaResiduo::whereDate('data_hora_entrada', today())->count();
            $totalResiduos = \App\Models\EntradaResiduo::sum('quantidade') ?? 0;
            $movimentacoesHoje = \App\Models\MovimentacaoResiduo::whereDate('data_movimentacao', today())->count();
        @endphp

        <div class="col-xl-3 col-md-6">
            <div class="card stat-card bg-gradient-primary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-label">Total Utilizadores</div>
                            <div class="stat-value">{{ $totalUsers }}</div>
                            <div class="stat-change text-white-50">
                                <i class="fas fa-arrow-up me-1"></i> Sistema
                            </div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-users fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="{{ route('admin.users.index') }}" class="text-white text-decoration-none small">
                        Ver todos <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card stat-card bg-gradient-success text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-label">Entradas Hoje</div>
                            <div class="stat-value">{{ $entradasHoje }}</div>
                            <div class="stat-change text-white-50">
                                <i class="fas fa-calendar-day me-1"></i> {{ now()->format('d/m') }}
                            </div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-truck-loading fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="{{ route('operador.entradas.index') }}" class="text-white text-decoration-none small">
                        Ver entradas <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card stat-card bg-gradient-info text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-label">Movimentações Hoje</div>
                            <div class="stat-value">{{ $movimentacoesHoje }}</div>
                            <div class="stat-change text-white-50">
                                <i class="fas fa-exchange-alt me-1"></i> Rastreabilidade
                            </div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-arrows-spin fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="{{ route('operador.movimentacoes.index') }}" class="text-white text-decoration-none small">
                        Ver movimentações <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card stat-card bg-gradient-warning text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-label">Total Resíduos</div>
                            <div class="stat-value">{{ number_format($totalResiduos, 0) }} kg</div>
                            <div class="stat-change text-white-50">
                                <i class="fas fa-weight-scale me-1"></i> Acumulado
                            </div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-weight-hanging fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-0">
                    <a href="{{ route('relatorios.dashboard') }}" class="text-white text-decoration-none small">
                        Ver relatórios <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficos e Estatísticas -->
    <div class="row g-4 mb-4">
        <div class="col-xl-8">
            <div class="card h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-line text-primary me-2"></i>
                        Entradas nos Últimos 30 Dias
                    </h5>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-sm btn-outline-secondary active">Diário</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary">Semanal</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary">Mensal</button>
                    </div>
                </div>
                <div class="card-body">
                    @php
                        $entradasPorDia = \App\Models\EntradaResiduo::selectRaw('DATE(data_hora_entrada) as data, COUNT(*) as total, SUM(quantidade) as kg')
                            ->whereDate('data_hora_entrada', '>=', now()->subDays(30))
                            ->groupBy('data')
                            ->orderBy('data')
                            ->get();
                    @endphp

                    @if($entradasPorDia->count() > 0)
                        <canvas id="graficoEntradas" style="height: 300px;"></canvas>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-chart-line fa-4x text-muted mb-3"></i>
                            <p class="text-muted">Sem dados para exibir no período</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card h-100">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-pie text-primary me-2"></i>
                        Distribuição por Categoria
                    </h5>
                </div>
                <div class="card-body">
                    @php
                        $distribuicao = \App\Models\EntradaResiduo::with('categoria')
                            ->selectRaw('categoria_id, COUNT(*) as total, SUM(quantidade) as kg')
                            ->groupBy('categoria_id')
                            ->get();
                    @endphp

                    @if($distribuicao->count() > 0)
                        <canvas id="graficoPizza" style="height: 250px;"></canvas>
                        <div class="mt-4">
                            @foreach($distribuicao as $item)
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div>
                                        <span class="badge" style="background-color: {{ '#' . substr(md5($item->categoria->nome ?? ''), 0, 6) }}; width: 12px; height: 12px; display: inline-block; border-radius: 50%;"></span>
                                        <span class="ms-2">{{ $item->categoria->nome ?? 'Sem categoria' }}</span>
                                    </div>
                                    <div>
                                        <strong>{{ number_format($item->kg, 0) }} kg</strong>
                                        <span class="text-muted ms-2">({{ $item->total }} entradas)</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-chart-pie fa-4x text-muted mb-3"></i>
                            <p class="text-muted">Sem dados para exibir</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Tabelas de Atividades Recentes -->
    <div class="row g-4">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-clock text-primary me-2"></i>
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
                                    <th>Lote</th>
                                    <th>Data/Hora</th>
                                    <th>Categoria</th>
                                    <th>Quantidade</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(\App\Models\EntradaResiduo::with('categoria')->latest()->limit(5)->get() as $entrada)
                                <tr>
                                    <td>
                                        <span class="badge bg-info bg-opacity-10 text-info px-3 py-2">
                                            {{ $entrada->codigo_lote }}
                                        </span>
                                    </td>
                                    <td>
                                        <div>{{ $entrada->data_hora_entrada->format('d/m/Y') }}</div>
                                        <small class="text-muted">{{ $entrada->data_hora_entrada->format('H:i') }}</small>
                                    </td>
                                    <td>{{ $entrada->categoria->nome ?? 'N/A' }}</td>
                                    <td>
                                        <strong>{{ number_format($entrada->quantidade, 2) }}</strong>
                                        <small class="text-muted">{{ $entrada->unidade_medida }}</small>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-arrows-spin text-primary me-2"></i>
                        Últimas Movimentações
                    </h5>
                    <a href="{{ route('operador.movimentacoes.index') }}" class="btn btn-sm btn-outline-primary">
                        Ver todas <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Lote</th>
                                    <th>Tipo</th>
                                    <th>Quantidade</th>
                                    <th>Data</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(\App\Models\MovimentacaoResiduo::with('entrada')->latest()->limit(5)->get() as $mov)
                                <tr>
                                    <td>
                                        <span class="badge bg-info bg-opacity-10 text-info px-3 py-2">
                                            {{ $mov->entrada->codigo_lote ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td>
                                        @php
                                            $tipoClasses = [
                                                'separacao' => 'bg-primary',
                                                'armazenamento' => 'bg-info',
                                                'venda' => 'bg-success',
                                                'descarte' => 'bg-danger'
                                            ];
                                        @endphp
                                        <span class="badge {{ $tipoClasses[$mov->tipo_movimentacao] ?? 'bg-secondary' }} px-3 py-2">
                                            {{ ucfirst($mov->tipo_movimentacao) }}
                                        </span>
                                    </td>
                                    <td><strong>{{ number_format($mov->quantidade, 2) }} kg</strong></td>
                                    <td>
                                        <div>{{ $mov->data_movimentacao->format('d/m/Y') }}</div>
                                        <small class="text-muted">{{ $mov->data_movimentacao->format('H:i') }}</small>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Informações do Sistema -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card bg-light border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-circle-info fa-3x text-primary opacity-50"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="mb-2">Bem-vindo, {{ Auth::user()->nome_completo }}!</h5>
                            <p class="text-muted mb-0">
                                <i class="fas fa-user-tag me-2"></i>Perfil: <strong>{{ Auth::user()->role->nome ?? 'Não definido' }}</strong>
                                <span class="mx-3">|</span>
                                <i class="fas fa-envelope me-2"></i>{{ Auth::user()->email }}
                                <span class="mx-3">|</span>
                                <i class="fas fa-calendar-check me-2"></i>Membro desde: {{ Auth::user()->created_at->format('d/m/Y') }}
                            </p>
                        </div>
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
    font-size: 2rem;
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

/* Cards */
.card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.card-header {
    background-color: white;
    border-bottom: 1px solid rgba(0,0,0,0.05);
    padding: 1.25rem;
    border-radius: 15px 15px 0 0 !important;
}

/* Tables */
.table th {
    font-weight: 600;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #6c757d;
    border-bottom-width: 1px;
}

.table td {
    padding: 1rem;
    vertical-align: middle;
}

/* Responsive */
@media (max-width: 768px) {
    .stat-value {
        font-size: 1.5rem;
    }
}
</style>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    @if($entradasPorDia->count() > 0)
    // Gráfico de Linha - Entradas por Dia
    const ctx = document.getElementById('graficoEntradas').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($entradasPorDia->pluck('data')->map(function($d) { 
                return \Carbon\Carbon::parse($d)->format('d/m');
            })) !!},
            datasets: [{
                label: 'Quantidade (kg)',
                data: {!! json_encode($entradasPorDia->pluck('kg')) !!},
                borderColor: 'rgb(78, 115, 223)',
                backgroundColor: 'rgba(78, 115, 223, 0.05)',
                tension: 0.4,
                fill: true,
                pointBackgroundColor: 'rgb(78, 115, 223)',
                pointBorderColor: 'white',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        drawBorder: false,
                        color: 'rgba(0,0,0,0.05)'
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

    @if($distribuicao->count() > 0)
    // Gráfico de Pizza - Distribuição por Categoria
    const ctx2 = document.getElementById('graficoPizza').getContext('2d');
    new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($distribuicao->pluck('categoria.nome')) !!},
            datasets: [{
                data: {!! json_encode($distribuicao->pluck('kg')) !!},
                backgroundColor: [
                    'rgba(78, 115, 223, 0.8)',
                    'rgba(28, 200, 138, 0.8)',
                    'rgba(246, 194, 62, 0.8)',
                    'rgba(231, 74, 59, 0.8)',
                    'rgba(97, 89, 232, 0.8)'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            cutout: '60%'
        }
    });
    @endif
});
</script>
@endpush
@endsection