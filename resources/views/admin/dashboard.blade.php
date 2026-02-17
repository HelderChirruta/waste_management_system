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
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-line text-primary me-2"></i>
                        Entradas nos Últimos 30 Dias
                    </h5>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-sm btn-outline-secondary active" onclick="mudarPeriodo('dia')">Diário</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="mudarPeriodo('semana')">Semanal</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="mudarPeriodo('mes')">Mensal</button>
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
                        <canvas id="graficoEntradas" style="height: 350px; width: 100%;"></canvas>
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
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-header bg-white py-3">
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
                        
                        // Cores vibrantes para cada categoria
                        $coresCirculares = [
                            '#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', '#FFE194',
                            '#B19CD9', '#FF9999', '#6C5B7B', '#F08A5D', '#B83B5E',
                            '#2F9292', '#E98580', '#6A2C70', '#11999E', '#DD7631'
                        ];
                    @endphp

                    @if($distribuicao->count() > 0)
                        <div class="chart-container" style="position: relative; height: 250px;">
                            <canvas id="graficoPizza"></canvas>
                        </div>
                        
                        <!-- Legenda colorida com percentuais -->
                        <div class="mt-4">
                            @php
                                $totalGeral = $distribuicao->sum('kg');
                            @endphp
                            @foreach($distribuicao as $index => $item)
                                @php
                                    $percentual = $totalGeral > 0 ? ($item->kg / $totalGeral) * 100 : 0;
                                    $cor = $coresCirculares[$index % count($coresCirculares)];
                                @endphp
                                <div class="d-flex justify-content-between align-items-center mb-3 p-2 rounded" style="background-color: {{ $cor }}10; border-left: 4px solid {{ $cor }};">
                                    <div class="d-flex align-items-center">
                                        <span style="display: inline-block; width: 12px; height: 12px; background-color: {{ $cor }}; border-radius: 50%; margin-right: 10px;"></span>
                                        <div>
                                            <span class="fw-semibold">{{ $item->categoria->nome ?? 'Sem categoria' }}</span>
                                            <small class="text-muted d-block">{{ $item->total }} entradas</small>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <strong style="color: {{ $cor }};">{{ number_format($item->kg, 0) }} kg</strong>
                                        <span class="badge ms-2" style="background-color: {{ $cor }}20; color: {{ $cor }};">{{ number_format($percentual, 1) }}%</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Card de resumo -->
                        <div class="mt-3 p-3 bg-light rounded">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Total de categorias:</span>
                                <strong>{{ $distribuicao->count() }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mt-2">
                                <span class="text-muted">Total processado:</span>
                                <strong>{{ number_format($totalGeral, 0) }} kg</strong>
                            </div>
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
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
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
                                    <th class="py-3">Lote</th>
                                    <th class="py-3">Data/Hora</th>
                                    <th class="py-3">Categoria</th>
                                    <th class="py-3">Quantidade</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(\App\Models\EntradaResiduo::with('categoria')->latest()->limit(5)->get() as $entrada)
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
                                        <span class="badge" style="background-color: {{ $coresCirculares[$loop->index % count($coresCirculares)] }}20; color: {{ $coresCirculares[$loop->index % count($coresCirculares)] }};">
                                            {{ $entrada->categoria->nome ?? 'N/A' }}
                                        </span>
                                    </td>
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
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
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
                                    <th class="py-3">Lote</th>
                                    <th class="py-3">Tipo</th>
                                    <th class="py-3">Quantidade</th>
                                    <th class="py-3">Data</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(\App\Models\MovimentacaoResiduo::with('entrada')->latest()->limit(5)->get() as $mov)
                                <tr>
                                    <td>
                                        <span class="badge bg-info bg-opacity-10 text-info px-3 py-2">
                                            <i class="fas fa-qrcode me-1"></i>
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
                                            $tipoCores = [
                                                'separacao' => '#4e73df',
                                                'armazenamento' => '#36b9cc',
                                                'venda' => '#1cc88a',
                                                'descarte' => '#e74a3b'
                                            ];
                                        @endphp
                                        <span class="badge" style="background-color: {{ $tipoCores[$mov->tipo_movimentacao] ?? '#858796' }}20; color: {{ $tipoCores[$mov->tipo_movimentacao] ?? '#858796' }}; padding: 8px 12px;">
                                            <i class="fas 
                                                @if($mov->tipo_movimentacao == 'separacao') fa-code-branch
                                                @elseif($mov->tipo_movimentacao == 'armazenamento') fa-warehouse
                                                @elseif($mov->tipo_movimentacao == 'venda') fa-tags
                                                @elseif($mov->tipo_movimentacao == 'descarte') fa-trash
                                                @endif me-1">
                                            </i>
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
            <div class="card bg-gradient-light border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-circle-info fa-3x text-white opacity-75"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="mb-2">Bem-vindo, {{ Auth::user()->nome_completo }}!</h5>
                            <div class="row">
                                <div class="col-md-3">
                                    <p class="mb-1"><i class="fas fa-user-tag text-primary me-2"></i>Perfil: <strong>{{ Auth::user()->role->nome ?? 'Não definido' }}</strong></p>
                                </div>
                                <div class="col-md-4">
                                    <p class="mb-1"><i class="fas fa-envelope text-success me-2"></i>{{ Auth::user()->email }}</p>
                                </div>
                                <div class="col-md-3">
                                    <p class="mb-1"><i class="fas fa-calendar-check text-info me-2"></i>Membro desde: {{ Auth::user()->created_at->format('d/m/Y') }}</p>
                                </div>
                                <div class="col-md-2">
                                    <p class="mb-1"><i class="fas fa-clock text-warning me-2"></i>Último acesso: hoje</p>
                                </div>
                            </div>
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

.bg-gradient-light {
    background: linear-gradient(135deg, #f8f9fc 0%, #ffffff 100%);
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

/* Chart container */
.chart-container {
    position: relative;
    margin: auto;
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
    // Cores vibrantes para os gráficos
    const cores = [
        '#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', '#FFE194',
        '#B19CD9', '#FF9999', '#6C5B7B', '#F08A5D', '#B83B5E',
        '#2F9292', '#E98580', '#6A2C70', '#11999E', '#DD7631'
    ];

    @if($entradasPorDia->count() > 0)
    // Gráfico de Linha - Entradas por Dia
    const ctx = document.getElementById('graficoEntradas').getContext('2d');
    
    // Criar gradiente para o fundo
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(78, 115, 223, 0.3)');
    gradient.addColorStop(1, 'rgba(78, 115, 223, 0)');
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($entradasPorDia->pluck('data')->map(function($d) { 
                return \Carbon\Carbon::parse($d)->format('d/m');
            })) !!},
            datasets: [{
                label: 'Quantidade (kg)',
                data: {!! json_encode($entradasPorDia->pluck('kg')->map(function($v) { return floatval($v); })) !!},
                borderColor: '#4e73df',
                backgroundColor: gradient,
                borderWidth: 3,
                pointBackgroundColor: '#4e73df',
                pointBorderColor: 'white',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 8,
                pointHoverBackgroundColor: '#4e73df',
                pointHoverBorderColor: 'white',
                pointHoverBorderWidth: 3,
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
                    backgroundColor: 'rgba(0,0,0,0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: '#4e73df',
                    borderWidth: 2,
                    padding: 12,
                    cornerRadius: 8,
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
                        drawBorder: false,
                        color: 'rgba(0,0,0,0.05)',
                        borderDash: [5,5]
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
                    },
                    ticks: {
                        maxRotation: 45,
                        minRotation: 45
                    }
                }
            }
        }
    });
    @endif

    @if($distribuicao->count() > 0)
    // Gráfico de Pizza - Distribuição por Categoria
    const ctx2 = document.getElementById('graficoPizza').getContext('2d');
    
    // Preparar dados
    const labels = {!! json_encode($distribuicao->pluck('categoria.nome')->map(function($nome) {
        return $nome ?? 'Sem categoria';
    })) !!};
    
    const dados = {!! json_encode($distribuicao->pluck('kg')->map(function($v) { return floatval($v); })) !!};
    
    // Selecionar cores baseadas no número de categorias
    const coresGrafico = cores.slice(0, dados.length);
    
    new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: dados,
                backgroundColor: coresGrafico,
                borderColor: 'white',
                borderWidth: 3,
                hoverOffset: 15,
                hoverBorderColor: 'white',
                hoverBorderWidth: 4
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
                    backgroundColor: 'rgba(0,0,0,0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: '#4e73df',
                    borderWidth: 2,
                    padding: 12,
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            let total = dados.reduce((a, b) => a + b, 0);
                            let percentual = ((context.raw / total) * 100).toFixed(1);
                            return context.raw.toFixed(2) + ' kg (' + percentual + '%)';
                        }
                    }
                }
            },
            cutout: '65%',
            animation: {
                animateScale: true,
                animateRotate: true
            }
        }
    });
    @endif
});

// Função para mudar período do gráfico (placeholder)
function mudarPeriodo(periodo) {
    alert('Funcionalidade de período em desenvolvimento: ' + periodo);
}

// Atualizar botões ativos
document.querySelectorAll('.btn-group .btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.btn-group .btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
    });
});
</script>
@endpush
@endsection