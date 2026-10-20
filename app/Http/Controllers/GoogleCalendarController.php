<?php

namespace App\Http\Controllers;

use App\Services\GoogleCalendarService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use RuntimeException;
use Throwable;

class GoogleCalendarController extends Controller
{
    public function index(): View
    {
        return view('calendario.google', [
            'anoInicial' => now()->year,
            'mesInicial' => now()->month,
        ]);
    }

    public function events(Request $request, GoogleCalendarService $calendar): JsonResponse
    {
        $validated = $request->validate([
            'ano' => ['required', 'integer', 'min:2000', 'max:2100'],
            'mes' => ['required', 'integer', 'min:1', 'max:12'],
        ]);

        try {
            return response()->json([
                'eventos' => $calendar->eventsForMonth(
                    (int) $validated['ano'],
                    (int) $validated['mes']
                ),
            ]);
        } catch (RuntimeException $e) {
            report($e);

            return response()->json([
                'message' => $e->getMessage(),
            ], 502);
        } catch (Throwable $e) {
            report($e);

            return response()->json([
                'message' => 'Erro inesperado ao carregar os eventos.',
            ], 500);
        }
    }
}
