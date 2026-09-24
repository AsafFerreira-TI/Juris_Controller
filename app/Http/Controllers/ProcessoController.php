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
                ->orWhere('tipo_processo', 'ILIKE', "%{$busca}%")
                ->orWhere('desc_processo', 'ILIKE', "%{$busca}%");

            });
        }

        if ($request->filled('status_processo')) {
            $query->where('status_processo', $request->status_processo);
        }

        $processos = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $totalProcessos = Processo::count();

        $emAndamento = Processo::where('status_processo', 'andamento')->count();

        $concluidos = Processo::where('status_processo', 'concluido')->count();

        $emPrazo = Processo::where('status_processo', true)
            ->whereDate('data_abertura_processo', '>=', now())
            ->count();

        return view('processos.index', compact(
            'processos',
            'totalProcessos',
            'emAndamento',
            'concluidos',
            'emPrazo'
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
            'id_cliente' => 'required|string|max:100|',
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
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
