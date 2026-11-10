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

        if ($request->filled('busca')) {
            $busca = $request->busca;

            $query->where(function ($q) use ($busca) {
                $q->where('num_processo', 'ILIKE', "%{$busca}%")
                    ->orWhere('desc_processo', 'ILIKE', "%{$busca}%")
                    ->orWhere('comarca', 'ILIKE', "%{$busca}%")
                    ->orWhere('tribunal_processo', 'ILIKE', "%{$busca}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status_processo', $request->status);
        }

        if ($request->filled('tipo')) {
            $query->where('tipo_processo', $request->tipo);
        }

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

        $processos = $query->paginate(10)->withQueryString();

        $totalProcessos = Processo::count();
        $emAndamento    = Processo::where('status_processo', 'andamento')->count();
        $concluidos     = Processo::where('status_processo', 'concluido')->count();
        $vencidos       = Processo::where('status_processo', 'vencido')->count();

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
        $dadosPrePreenchidos = session('dados_pre_preenchidos', []);

        return view('processos.create', compact('dadosPrePreenchidos'));
    }

    public function createFromConsulta(Request $request)
    {
        return redirect()
            ->route('processos.create')
            ->with('dados_pre_preenchidos', [
                'num_processo'           => $request->input('num_processo'),
                'tribunal_processo'      => $request->input('tribunal_processo'),
                'vara_processo'          => $request->input('vara_processo'),
                'data_abertura_processo' => $request->input('data_abertura_processo'),
                'desc_processo'          => $request->input('desc_processo'),
                'tipo_processo'          => $request->input('tipo_processo'),
                'comarca'                => $request->input('comarca'),
                'status_processo'        => $request->input('status_processo'),
            ]);
    }

    public function store(Request $request)
    {
        if ($request->filled('num_processo')) {
            $request->merge([
                'num_processo' => preg_replace('/\D/', '', $request->num_processo),
            ]);
        }

        $dados = $request->validate([
            'num_processo'           => 'required|string|max:100|unique:processos,num_processo',
            'id_cliente'             => 'required|string|max:100',
            'tipo_processo'          => 'required|string|max:100',
            'desc_processo'          => 'nullable|string|max:500',
            'data_abertura_processo' => 'nullable|date',
            'vara_processo'          => 'nullable|string|max:500',
            'status_processo'        => 'required|string|in:andamento,concluido,vencido',
            'comarca'                => 'nullable|string|max:500',
            'tribunal_processo'      => 'nullable|string|max:500',
        ]);

        $dados['id_advg'] = Auth::id();

        Processo::create($dados);

        return redirect()
            ->route('processos.index')
            ->with('toast', [
                'tipo'     => 'success',
                'titulo'   => 'Processo criado!',
                'mensagem' => 'As informações foram salvas com sucesso.',
            ]);
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
        if ($request->filled('num_processo')) {
            $request->merge([
                'num_processo' => preg_replace('/\D/', '', $request->num_processo),
            ]);
        }

        $dados = $request->validate([
            'num_processo'           => 'required|string|max:100',
            'id_cliente'             => 'required|string|max:100',
            'tipo_processo'          => 'required|string|max:100',
            'desc_processo'          => 'nullable|string|max:500',
            'data_abertura_processo' => 'nullable|date',
            'vara_processo'          => 'nullable|string|max:500',
            'status_processo'        => 'required|string|in:andamento,concluido,vencido',
            'comarca'                => 'nullable|string|max:500',
            'tribunal_processo'      => 'nullable|string|max:500',
        ]);

        $processo = Processo::findOrFail($id);
        $processo->update($dados);

        return redirect()
            ->route('processos.index')
            ->with('toast', [
                'tipo'     => 'success',
                'titulo'   => 'Processo atualizado!',
                'mensagem' => 'As alterações foram salvas com sucesso.',
            ]);
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
