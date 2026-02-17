<?php

namespace App\Http\Controllers\Relatorios;

use App\Http\Controllers\Controller;
use App\Models\EntradaResiduo;
use App\Models\MovimentacaoResiduo;
use App\Models\CategoriaPlastico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class RelatorioController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        // Totais gerais - CORRIGIDO
        $totalResiduosHoje = EntradaResiduo::whereDate('data_hora_entrada', today())->sum('quantidade') ?? 0;
        $totalResiduosMes = EntradaResiduo::whereMonth('data_hora_entrada', now()->month)
                            ->whereYear('data_hora_entrada', now()->year)
                            ->sum('quantidade') ?? 0;
        $totalMovimentacoes = MovimentacaoResiduo::count() ?? 0;
        
        // Distribuição por categoria - CORRIGIDO
        $distribuicaoCategorias = EntradaResiduo::with('categoria')
            ->select('categoria_id', DB::raw('SUM(quantidade) as total'))
            ->groupBy('categoria_id')
            ->get();
        
        // Log para debug (remover em produção)
        \Log::info('Distribuição:', $distribuicaoCategorias->toArray());
        
        // Últimas entradas
        $ultimasEntradas = EntradaResiduo::with(['categoria', 'origem'])
            ->latest()
            ->limit(10)
            ->get();

        // Dados para gráficos - CORRIGIDO
        $entradasPorDia = EntradaResiduo::select(
                DB::raw('DATE(data_hora_entrada) as data'), 
                DB::raw('SUM(quantidade) as total')
            )
            ->whereDate('data_hora_entrada', '>=', now()->subDays(30))
            ->groupBy('data')
            ->orderBy('data')
            ->get();

        return view('relatorios.dashboard', compact(
            'totalResiduosHoje',
            'totalResiduosMes',
            'totalMovimentacoes',
            'distribuicaoCategorias',
            'ultimasEntradas',
            'entradasPorDia'
        ));
    }

    public function exportarPdf(Request $request)
    {
        $dataInicio = $request->get('data_inicio', now()->startOfMonth());
        $dataFim = $request->get('data_fim', now());
        
        $entradas = EntradaResiduo::with(['categoria', 'origem', 'operador'])
            ->whereBetween('data_hora_entrada', [$dataInicio, $dataFim])
            ->get();
            
        $pdf = Pdf::loadView('relatorios.pdf', compact('entradas', 'dataInicio', 'dataFim'));
        
        return $pdf->download('relatorio-residuos-' . now()->format('Y-m-d') . '.pdf');
    }

    public function estatisticasCatadores()
    {
        $estatisticas = Catador::withSum('coletas as total_coletado', 'quantidade_kg')
            ->withCount('coletas')
            ->having('total_coletado', '>', 0)
            ->orderBy('total_coletado', 'desc')
            ->get();
            
        return view('relatorios.catadores', compact('estatisticas'));
    }
}