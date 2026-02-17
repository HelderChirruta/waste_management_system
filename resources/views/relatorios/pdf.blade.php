<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Resíduos - Lixeira de Hulene</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Helvetica', 'Arial', sans-serif;
            background: #ffffff;
            color: #2c3e50;
            line-height: 1.5;
            padding: 30px;
        }

        /* Cabeçalho com logo */
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 3px solid #4e73df;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-icon i {
            font-size: 35px;
            color: white;
        }

        .logo-text h1 {
            font-size: 24px;
            font-weight: 700;
            color: #1a1e2b;
            margin: 0;
            line-height: 1.2;
        }

        .logo-text small {
            font-size: 14px;
            color: #6c757d;
            font-weight: 400;
        }

        .header-info {
            text-align: right;
        }

        .header-info .title {
            font-size: 28px;
            font-weight: 700;
            color: #4e73df;
            margin-bottom: 5px;
        }

        .header-info .subtitle {
            font-size: 14px;
            color: #6c757d;
        }

        .header-info .badge {
            background: #e8f0fe;
            color: #4e73df;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
            margin-top: 10px;
        }

        /* Informações do relatório */
        .info-section {
            background: linear-gradient(135deg, #f8f9fc 0%, #ffffff 100%);
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            border: 1px solid #e9ecef;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .info-icon {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
        }

        .info-content {
            flex: 1;
        }

        .info-label {
            font-size: 12px;
            text-transform: uppercase;
            color: #6c757d;
            letter-spacing: 0.5px;
            margin-bottom: 3px;
        }

        .info-value {
            font-size: 18px;
            font-weight: 600;
            color: #2c3e50;
        }

        .info-value small {
            font-size: 12px;
            font-weight: 400;
            color: #6c757d;
            margin-left: 5px;
        }

        /* Tabela */
        .table-container {
            margin: 30px 0;
            border-radius: 15px;
            overflow: hidden;
            border: 1px solid #e9ecef;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        thead tr {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        }

        th {
            color: white;
            font-weight: 600;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 15px 12px;
            text-align: left;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #e9ecef;
            color: #2c3e50;
            font-size: 13px;
        }

        tbody tr:hover {
            background-color: #f8f9fc;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        /* Badges de estado */
        .badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-separado {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .badge-misturado {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
        }

        .badge-contaminado {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Categoria */
        .categoria-badge {
            background: #e8f0fe;
            color: #4e73df;
            padding: 3px 10px;
            border-radius: 15px;
            font-size: 11px;
            font-weight: 600;
            display: inline-block;
        }

        /* Código do lote */
        .lote-code {
            font-family: 'Courier New', monospace;
            font-weight: 600;
            color: #4e73df;
            background: #f8f9fc;
            padding: 3px 8px;
            border-radius: 5px;
            border: 1px solid #e9ecef;
            font-size: 12px;
        }

        /* Rodapé */
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px dashed #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #6c757d;
            font-size: 12px;
        }

        .footer-left {
            display: flex;
            gap: 30px;
        }

        .footer-right {
            text-align: right;
        }

        .assinatura {
            margin-top: 30px;
            display: flex;
            justify-content: flex-end;
        }

        .assinatura-box {
            width: 200px;
            text-align: center;
        }

        .assinatura-line {
            height: 1px;
            background: #2c3e50;
            margin: 10px 0;
        }

        /* Resumo */
        .summary-box {
            background: linear-gradient(135deg, #f8f9fc 0%, #ffffff 100%);
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
            border: 1px solid #e9ecef;
            display: inline-block;
            min-width: 300px;
        }

        .summary-title {
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .summary-value {
            font-size: 32px;
            font-weight: 700;
            color: #4e73df;
        }

        .summary-unit {
            font-size: 14px;
            color: #6c757d;
            margin-left: 5px;
        }

        /* Gráfico simples (barras) */
        .chart-container {
            margin: 30px 0;
            padding: 20px;
            background: #f8f9fc;
            border-radius: 10px;
            border: 1px solid #e9ecef;
        }

        .chart-title {
            font-size: 16px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 15px;
        }

        .bar-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .bar-label {
            width: 100px;
            font-size: 12px;
            color: #6c757d;
        }

        .bar {
            flex: 1;
            height: 25px;
            background: #e9ecef;
            border-radius: 5px;
            overflow: hidden;
            margin: 0 10px;
        }

        .bar-fill {
            height: 100%;
            background: linear-gradient(90deg, #4e73df 0%, #224abe 100%);
            border-radius: 5px;
        }

        .bar-value {
            width: 80px;
            font-size: 12px;
            font-weight: 600;
            color: #2c3e50;
            text-align: right;
        }

        /* Watermark */
        .watermark {
            position: fixed;
            bottom: 20px;
            right: 20px;
            opacity: 0.1;
            font-size: 60px;
            font-weight: 700;
            color: #4e73df;
            transform: rotate(-15deg);
            pointer-events: none;
            z-index: 1000;
        }

        /* Responsividade para PDF */
        @media print {
            body {
                padding: 20px;
            }
            
            .watermark {
                opacity: 0.05;
            }
            
            thead tr {
                background: #4e73df !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            
            .badge-separado, .badge-misturado, .badge-contaminado {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>
    <!-- Watermark sutil -->
    <div class="watermark">LIXEIRA DE HULENE</div>

    <!-- Cabeçalho com logo -->
    <div class="header">
        <div class="logo-container">
            <div class="logo-icon">
                <!-- Ícone de reciclagem (usando caractere especial) -->
                <span style="font-size: 35px; color: white;">♻️</span>
            </div>
            <div class="logo-text">
                <h1>LIXEIRA DE HULENE</h1>
                <small>Sistema de Gestão de Resíduos</small>
            </div>
        </div>
        <div class="header-info">
            <div class="title">RELATÓRIO</div>
            <div class="subtitle">Entradas de Resíduos</div>
            <div class="badge">Documento Oficial</div>
        </div>
    </div>

    <!-- Informações do relatório -->
    <div class="info-section">
        <div class="info-grid">
            <div class="info-item">
                <div class="info-icon">
                    <span>📅</span>
                </div>
                <div class="info-content">
                    <div class="info-label">Período do relatório</div>
                    <div class="info-value">
                        {{ $dataInicio->format('d/m/Y') }} - {{ $dataFim->format('d/m/Y') }}
                    </div>
                </div>
            </div>

            <div class="info-item">
                <div class="info-icon">
                    <span>📊</span>
                </div>
                <div class="info-content">
                    <div class="info-label">Total de registros</div>
                    <div class="info-value">
                        {{ $entradas->count() }} <small>entradas</small>
                    </div>
                </div>
            </div>

            <div class="info-item">
                <div class="info-icon">
                    <span>⚖️</span>
                </div>
                <div class="info-content">
                    <div class="info-label">Quantidade total</div>
                    <div class="info-value">
                        {{ number_format($entradas->sum('quantidade'), 2) }} <small>kg</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráfico de distribuição por categoria (se houver dados) -->
    @if($entradas->count() > 0)
        @php
            $categorias = $entradas->groupBy('categoria.nome')->map(function($group) {
                return $group->sum('quantidade');
            })->sortDesc();
            $totalGeral = $categorias->sum();
        @endphp

        <div class="chart-container">
            <div class="chart-title">Distribuição por Categoria (kg)</div>
            @foreach($categorias as $categoria => $quantidade)
                @php
                    $percentual = ($quantidade / $totalGeral) * 100;
                @endphp
                <div class="bar-item">
                    <div class="bar-label">{{ $categoria }}</div>
                    <div class="bar">
                        <div class="bar-fill" style="width: {{ $percentual }}%"></div>
                    </div>
                    <div class="bar-value">{{ number_format($quantidade, 0) }} kg</div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Tabela de dados -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Lote</th>
                    <th>Data/Hora</th>
                    <th>Categoria</th>
                    <th>Origem</th>
                    <th>Quantidade</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($entradas as $entrada)
                <tr>
                    <td>
                        <span class="lote-code">{{ $entrada->codigo_lote }}</span>
                    </td>
                    <td>{{ $entrada->data_hora_entrada->format('d/m/Y H:i') }}</td>
                    <td>
                        <span class="categoria-badge">{{ $entrada->categoria->nome ?? 'N/A' }}</span>
                    </td>
                    <td>{{ $entrada->origem->nome ?? 'N/A' }}</td>
                    <td>
                        <strong>{{ number_format($entrada->quantidade, 2) }}</strong> 
                        <small style="color: #6c757d;">{{ $entrada->unidade_medida }}</small>
                    </td>
                    <td>
                        @if($entrada->estado == 'separado')
                            <span class="badge badge-separado">Separado</span>
                        @elseif($entrada->estado == 'misturado')
                            <span class="badge badge-misturado">Misturado</span>
                        @elseif($entrada->estado == 'contaminado')
                            <span class="badge badge-contaminado">Contaminado</span>
                        @else
                            <span class="badge">{{ $entrada->estado }}</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 40px;">
                        <span style="font-size: 16px; color: #6c757d;">Nenhum registro encontrado no período</span>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Resumo e totais -->
    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
        <div class="summary-box">
            <div class="summary-title">Resumo do período</div>
            <div style="margin-bottom: 10px;">
                <span style="color: #6c757d;">Média por dia:</span>
                <strong style="margin-left: 10px;">{{ number_format($entradas->avg('quantidade') ?? 0, 2) }} kg</strong>
            </div>
            <div style="margin-bottom: 10px;">
                <span style="color: #6c757d;">Maior entrada:</span>
                <strong style="margin-left: 10px;">{{ number_format($entradas->max('quantidade') ?? 0, 2) }} kg</strong>
            </div>
            <div>
                <span style="color: #6c757d;">Menor entrada:</span>
                <strong style="margin-left: 10px;">{{ number_format($entradas->min('quantidade') ?? 0, 2) }} kg</strong>
            </div>
        </div>

        <div class="summary-box" style="text-align: center;">
            <div class="summary-title">Total geral</div>
            <div class="summary-value">{{ number_format($entradas->sum('quantidade'), 2) }}</div>
            <div class="summary-unit">quilogramas (kg)</div>
        </div>
    </div>

    <!-- Informações adicionais por categoria -->
    @if($entradas->count() > 0)
        <div style="margin-top: 30px;">
            <h3 style="color: #2c3e50; font-size: 16px; margin-bottom: 15px;">📊 Detalhamento por categoria</h3>
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f8f9fc;">
                        <th style="padding: 10px; text-align: left;">Categoria</th>
                        <th style="padding: 10px; text-align: right;">Total (kg)</th>
                        <th style="padding: 10px; text-align: right;">%</th>
                        <th style="padding: 10px; text-align: right;">Quantidade de registros</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($entradas->groupBy('categoria.nome') as $categoria => $items)
                        @php
                            $totalCategoria = $items->sum('quantidade');
                            $percentual = ($totalCategoria / $entradas->sum('quantidade')) * 100;
                        @endphp
                        <tr>
                            <td style="padding: 8px;">{{ $categoria }}</td>
                            <td style="padding: 8px; text-align: right;">{{ number_format($totalCategoria, 2) }} kg</td>
                            <td style="padding: 8px; text-align: right;">{{ number_format($percentual, 1) }}%</td>
                            <td style="padding: 8px; text-align: right;">{{ $items->count() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <!-- Rodapé -->
    <div class="footer">
        <div class="footer-left">
            <span>📍 Lixeira de Hulene, Maputo - Moçambique</span>
            <span>📅 {{ now()->format('d/m/Y H:i') }}</span>
        </div>
        <div class="footer-right">
            <span>Documento gerado por {{ Auth::user()->nome_completo }}</span>
        </div>
    </div>

    <!-- Assinatura digital -->
    <div class="assinatura">
        <div class="assinatura-box">
            <div class="assinatura-line"></div>
            <div style="font-size: 11px; color: #6c757d;">Assinatura do Responsável</div>
        </div>
    </div>

    <!-- Informação de validação -->
    <div style="margin-top: 20px; text-align: center; font-size: 10px; color: #6c757d;">
        <span>Este relatório é gerado automaticamente pelo Sistema de Gestão de Resíduos da Lixeira de Hulene</span>
        <span style="display: block; margin-top: 5px;">Documento válido apenas com assinatura digital</span>
    </div>
</body>
</html>