<?php

namespace App\Http\Controllers\Operador;

use App\Http\Controllers\Controller;
use App\Models\EntradaResiduo;
use App\Models\MovimentacaoResiduo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MovimentacaoController extends Controller
{
    public function index()
    {
        $movimentacoes = MovimentacaoResiduo::with(['entrada', 'responsavel'])
            ->orderBy('data_movimentacao', 'desc')
            ->paginate(15);
            
        return view('operador.movimentacoes.index', compact('movimentacoes'));
    }

    public function create(Request $request)
    {
        $entrada_id = $request->get('entrada_id');
        $entrada = null;
        
        if ($entrada_id) {
            $entrada = EntradaResiduo::findOrFail($entrada_id);
        }
        
        $entradas = EntradaResiduo::with(['categoria', 'origem'])
            ->orderBy('data_hora_entrada', 'desc')
            ->get();
            
        return view('operador.movimentacoes.create', compact('entradas', 'entrada'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'entrada_id' => 'required|exists:entradas_residuos,id',
            'tipo_movimentacao' => 'required|in:separacao,armazenamento,venda,descarte',
            'quantidade' => 'required|numeric|min:0.01',
            'localizacao' => 'nullable|string|max:255',
            'destino' => 'nullable|string|max:255',
            'observacoes' => 'nullable|string'
        ]);

        // Verificar se a quantidade não excede o disponível
        $entrada = EntradaResiduo::findOrFail($validated['entrada_id']);
        $totalMovimentado = $entrada->movimentacoes()->sum('quantidade');
        
        if (($totalMovimentado + $validated['quantidade']) > $entrada->quantidade) {
            return back()
                ->withInput()
                ->withErrors(['quantidade' => 'A quantidade total movimentada não pode exceder a quantidade da entrada.']);
        }

        $validated['responsavel_id'] = Auth::id();
        $validated['data_movimentacao'] = now();

        MovimentacaoResiduo::create($validated);

        return redirect()->route('operador.movimentacoes.index')
            ->with('success', 'Movimentação registada com sucesso!');
    }

    public function show($id)
    {
        $movimentacao = MovimentacaoResiduo::with(['entrada', 'entrada.categoria', 'entrada.origem', 'responsavel'])
            ->findOrFail($id);
            
        return view('operador.movimentacoes.show', compact('movimentacao'));
    }

    public function edit($id)
    {
        $movimentacao = MovimentacaoResiduo::findOrFail($id);
        
        // Verificar se a movimentação é de hoje
        if (!$movimentacao->data_movimentacao->isToday()) {
            return redirect()->route('operador.movimentacoes.index')
                ->with('error', 'Apenas movimentações de hoje podem ser editadas.');
        }
        
        $entradas = EntradaResiduo::with(['categoria', 'origem'])
            ->orderBy('data_hora_entrada', 'desc')
            ->get();
            
        return view('operador.movimentacoes.edit', compact('movimentacao', 'entradas'));
    }

    public function update(Request $request, $id)
    {
        $movimentacao = MovimentacaoResiduo::findOrFail($id);
        
        // Verificar se a movimentação é de hoje
        if (!$movimentacao->data_movimentacao->isToday()) {
            return redirect()->route('operador.movimentacoes.index')
                ->with('error', 'Apenas movimentações de hoje podem ser editadas.');
        }
        
        $validated = $request->validate([
            'tipo_movimentacao' => 'required|in:separacao,armazenamento,venda,descarte',
            'quantidade' => 'required|numeric|min:0.01',
            'localizacao' => 'nullable|string|max:255',
            'destino' => 'nullable|string|max:255',
            'observacoes' => 'nullable|string'
        ]);

        $movimentacao->update($validated);

        return redirect()->route('operador.movimentacoes.index')
            ->with('success', 'Movimentação atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $movimentacao = MovimentacaoResiduo::findOrFail($id);
        
        // Verificar se a movimentação é de hoje
        if (!$movimentacao->data_movimentacao->isToday()) {
            return redirect()->route('operador.movimentacoes.index')
                ->with('error', 'Apenas movimentações de hoje podem ser excluídas.');
        }
        
        $movimentacao->delete();

        return redirect()->route('operador.movimentacoes.index')
            ->with('success', 'Movimentação excluída com sucesso!');
    }
}