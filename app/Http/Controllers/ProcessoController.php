<?php

namespace App\Http\Controllers;

use App\Models\Processo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProcessoController extends Controller
{
    public function index(Request $request)
    {
        $query = Processo::query();

        // Pesquisa
        if ($request->filled('busca')) {

            $busca = $request->busca;

            $query->where(function ($q) use ($busca) {

                $q->where('num_processo', 'ILIKE', "%{$busca}%")
                    ->orWhere('desc_processo', 'ILIKE', "%{$busca}%")
                    ->orWhere('comarca', 'ILIKE', "%{$busca}%")
                    ->orWhere('tribunal_processo', 'ILIKE', "%{$busca}%");

            });
        }

        // Filtro por status
        if ($request->filled('status')) {
            $query->where('status_processo', $request->status);
        }

        // Filtro por tipo
        if ($request->filled('tipo')) {
            $query->where('tipo_processo', $request->tipo);
        }

        // Ordenação
        switch ($request->ordem) {

            case 'antigos':
                $query->orderBy('created_at', 'asc');
                break;

            case 'prazo':
                $query->orderBy('data_abertura_processo', 'asc');
                break;

            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        // Processos
        $processos = $query
            ->paginate(10)
            ->withQueryString();

        // Indicadores
        $totalProcessos = Processo::count();

        $emAndamento = Processo::where(
            'status_processo',
            'andamento'
        )->count();

        $concluidos = Processo::where(
            'status_processo',
            'concluido'
        )->count();

        $vencidos = Processo::where(
            'status_processo',
            'vencido'
        )->count();

        return view('processos.index', compact(
            'processos',
            'totalProcessos',
            'emAndamento',
            'concluidos',
            'vencidos'
        ));
    }


    public function create()
    {
        return view('processos.create');
    }


    public function store(Request $request)
    {
        $dados = $request->validate([
            'num_processo' => 'required|string|max:100|unique:processos,num_processo',
            'id_cliente' => 'required|string|max:100',
            'tipo_processo' => 'required|string|max:100',
            'desc_processo' => 'nullable|string|max:500',
            'data_abertura_processo' => 'nullable|date',
            'vara_processo' => 'nullable|string|max:500',
            'status_processo' => 'required|string|in:andamento,concluido,vencido',
            'comarca' => 'nullable|string|max:500',
            'tribunal_processo' => 'nullable|string|max:500',
        ]);

        $dados['id_advg'] = Auth::id();

        Processo::create($dados);

        return redirect()
            ->route('processos.index')
            ->with('sucesso', 'Processo criado com sucesso!');
    }


    public function show(string $id)
    {
        $processo = Processo::findOrFail($id);

        return view('processos.show', compact('processo'));
    }


    public function edit(string $id)
    {
        $processo = Processo::findOrFail($id);

        return view('processos.edit', compact('processo'));
    }


    public function update(Request $request, string $id)
    {
        $dados = $request->validate([
            'num_processo' => 'required|string|max:100',
            'id_cliente' => 'required|string|max:100',
            'tipo_processo' => 'required|string|max:100',
            'desc_processo' => 'nullable|string|max:500',
            'data_abertura_processo' => 'nullable|date',
            'vara_processo' => 'nullable|string|max:500',
            'status_processo' => 'required|string|in:andamento,concluido,vencido',
            'comarca' => 'nullable|string|max:500',
            'tribunal_processo' => 'nullable|string|max:500',
        ]);

        $processo = Processo::findOrFail($id);

        $processo->update($dados);

        return redirect()
            ->route('processos.index')
            ->with('sucesso', 'Processo atualizado com sucesso!');
    }


    public function destroy(string $id)
    {
        $processo = Processo::findOrFail($id);

        $processo->delete();

        return redirect()
            ->route('processos.index')
            ->with('sucesso', 'Processo excluído com sucesso!');
    }
}
