<?php

namespace App\Http\Controllers\Operador;

use App\Http\Controllers\Controller;
use App\Models\EntradaResiduo;
use App\Models\OrigemResiduo;
use App\Models\CategoriaPlastico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EntradaResiduoController extends Controller
{
    public function index(Request $request)
    {
        $query = EntradaResiduo::with(['origem', 'categoria', 'operador']);
        
        // Filtros
        if ($request->filled('data_inicio')) {
            $query->whereDate('data_hora_entrada', '>=', $request->data_inicio);
        }
        
        if ($request->filled('data_fim')) {
            $query->whereDate('data_hora_entrada', '<=', $request->data_fim);
        }
        
        if ($request->filled('categoria_id')) {
            $query->where('categoria_id', $request->categoria_id);
        }
        
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }
        
        $entradas = $query->orderBy('data_hora_entrada', 'desc')->paginate(15);
        
        // Dados para filtros
        $categorias = CategoriaPlastico::all();
        
        return view('operador.entradas.index', compact('entradas', 'categorias'));
    }

    public function create()
    {
        // Buscar todas as origens e categorias do banco de dados
        $origens = OrigemResiduo::all();
        $categorias = CategoriaPlastico::all();
        
        // Verificar se existem registros
        if ($origens->isEmpty()) {
            // Se não houver origens, criar algumas de exemplo
            OrigemResiduo::create([
                'nome' => 'Coleta Municipal',
                'tipo' => 'municipal',
                'contato' => '84 123456789'
            ]);
            OrigemResiduo::create([
                'nome' => 'Empresa Privada',
                'tipo' => 'privado',
                'contato' => '84 987654321'
            ]);
            $origens = OrigemResiduo::all();
        }
        
        if ($categorias->isEmpty()) {
            // Se não houver categorias, criar algumas de exemplo
            CategoriaPlastico::create([
                'codigo' => 'PET',
                'nome' => 'PET',
                'descricao' => 'Politereftalato de Etileno',
                'valor_estimado_kg' => 25.00
            ]);
            CategoriaPlastico::create([
                'codigo' => 'PEAD',
                'nome' => 'PEAD',
                'descricao' => 'Polietileno de Alta Densidade',
                'valor_estimado_kg' => 20.00
            ]);
            $categorias = CategoriaPlastico::all();
        }
        
        // Debug: verificar se os dados estão sendo carregados
        // dd($origens, $categorias); // Descomente para testar
        
        return view('operador.entradas.create', compact('origens', 'categorias'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'origem_id' => 'required|exists:origens_residuo,id',
            'categoria_id' => 'required|exists:categorias_plastico,id',
            'quantidade' => 'required|numeric|min:0.01',
            'unidade_medida' => 'required|in:kg,ton',
            'estado' => 'required|in:separado,misturado,contaminado',
            'observacoes' => 'nullable|string'
        ]);

        $validated['data_hora_entrada'] = now();
        $validated['operador_id'] = Auth::id();

        EntradaResiduo::create($validated);

        return redirect()->route('operador.entradas.index')
            ->with('success', 'Entrada registada com sucesso!');
    }

    public function show($id)
    {
        $entrada = EntradaResiduo::with(['origem', 'categoria', 'operador', 'movimentacoes.responsavel'])
            ->findOrFail($id);
            
        return view('operador.entradas.show', compact('entrada'));
    }

    public function edit($id)
    {
        $entrada = EntradaResiduo::findOrFail($id);
        
        // Verificar se a entrada é de hoje
        if (!$entrada->data_hora_entrada->isToday()) {
            return redirect()->route('operador.entradas.index')
                ->with('error', 'Apenas entradas de hoje podem ser editadas.');
        }
        
        $origens = OrigemResiduo::all();
        $categorias = CategoriaPlastico::all();
        
        return view('operador.entradas.edit', compact('entrada', 'origens', 'categorias'));
    }

    public function update(Request $request, $id)
    {
        $entrada = EntradaResiduo::findOrFail($id);
        
        // Verificar se a entrada é de hoje
        if (!$entrada->data_hora_entrada->isToday()) {
            return redirect()->route('operador.entradas.index')
                ->with('error', 'Apenas entradas de hoje podem ser editadas.');
        }
        
        $validated = $request->validate([
            'origem_id' => 'required|exists:origens_residuo,id',
            'categoria_id' => 'required|exists:categorias_plastico,id',
            'quantidade' => 'required|numeric|min:0.01',
            'unidade_medida' => 'required|in:kg,ton',
            'estado' => 'required|in:separado,misturado,contaminado',
            'observacoes' => 'nullable|string'
        ]);

        $entrada->update($validated);

        return redirect()->route('operador.entradas.index')
            ->with('success', 'Entrada atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $entrada = EntradaResiduo::findOrFail($id);
        
        // Verificar se a entrada é de hoje
        if (!$entrada->data_hora_entrada->isToday()) {
            return redirect()->route('operador.entradas.index')
                ->with('error', 'Apenas entradas de hoje podem ser excluídas.');
        }
        
        $entrada->delete();

        return redirect()->route('operador.entradas.index')
            ->with('success', 'Entrada excluída com sucesso!');
    }
}