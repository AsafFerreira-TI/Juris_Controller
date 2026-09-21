<?php

namespace App\Http\Controllers;

use App\Models\Processo;
use Illuminate\Http\Request;

class ProcessoController extends Controller
{
    public function index(Request $request)
    {
        return view('processos.index');
       /* $query = Processo::query();

        if ($request->filled('busca')) {

            $busca = $request->busca;

            $query->where(function ($q) use ($busca) {

                $q->where('numero', 'ILIKE', "%{$busca}%")
                  ->orWhere('cliente', 'ILIKE', "%{$busca}%")
                  ->orWhere('assunto', 'ILIKE', "%{$busca}%");

            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        $processos = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $totalProcessos = Processo::count();

        $emAndamento = Processo::where('status', 'andamento')->count();

        $concluidos = Processo::where('status', 'concluido')->count();

        $emPrazo = Processo::where('status', 'andamento')
            ->whereDate('prazo', '>=', now())
            ->count();

        $vencendo = Processo::whereBetween(
            'prazo',
            [now(), now()->addDays(7)]
        )->count();

        return view('processos.index', compact(
            'processos',
            'totalProcessos',
            'emAndamento',
            'concluidos',
            'emPrazo',
            'vencendo'
        ));
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    }
    public function store(Request $request)
    {
        //
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
