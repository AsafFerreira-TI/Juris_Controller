<?php

namespace App\Services;

use Carbon\CarbonImmutable;
use Google\Client as GoogleClient;
use Google\Service\Calendar;
use Illuminate\Support\Facades\Log;
use RuntimeException;
use Throwable;

class GoogleCalendarService
{
    private function client(): GoogleClient
    {
        $relativePath = config(
            'services.google_calendar.credentials',
            'storage/app/google-calendar/credentials.json'
        );
        $path = str_starts_with($relativePath, DIRECTORY_SEPARATOR)
            ? $relativePath
            : base_path($relativePath);

        if (!is_file($path)) {
            throw new RuntimeException(
                'Credencial do Google Calendar não encontrada. Confira GOOGLE_CALENDAR_CREDENTIALS.'
            );
        }

        $client = new GoogleClient();
        $client->setApplicationName(config('app.name', 'Laravel'));
        $client->setAuthConfig($path);
        $client->setScopes([Calendar::CALENDAR_READONLY]);

        return $client;
    }

    /**
     * Retorna os eventos que começam ou ocorrem durante o mês indicado.
     * O timeMin/timeMax usa o fuso configurado no Laravel.
     */
    public function eventsForMonth(int $year, int $month): array
    {
        $calendarId = config('services.google_calendar.id');

        if (!$calendarId) {
            throw new RuntimeException('GOOGLE_CALENDAR_ID não está configurado.');
        }

        $timezone = config('app.timezone', 'UTC');
        $start = CarbonImmutable::create($year, $month, 1, 0, 0, 0, $timezone)->startOfMonth();
        $end = $start->addMonth();

        try {
            $service = new Calendar($this->client());
            $items = [];
            $pageToken = null;

            do {
                $params = [
                    'timeMin' => $start->toRfc3339String(),
                    'timeMax' => $end->toRfc3339String(),
                    'singleEvents' => true,
                    'orderBy' => 'startTime',
                    'maxResults' => 2500,
                    'timeZone' => $timezone,
                ];

                if ($pageToken) {
                    $params['pageToken'] = $pageToken;
                }

                $response = $service->events->listEvents($calendarId, $params);

                foreach ($response->getItems() as $event) {
                    $eventStart = $event->getStart();
                    $eventEnd = $event->getEnd();

                    $items[] = [
                        'id' => $event->getId(),
                        'titulo' => $event->getSummary() ?: 'Evento sem título',
                        'descricao' => $event->getDescription() ?: '',
                        'local' => $event->getLocation() ?: '',
                        'inicio' => $eventStart?->getDateTime() ?: $eventStart?->getDate(),
                        'fim' => $eventEnd?->getDateTime() ?: $eventEnd?->getDate(),
                        'dia_inteiro' => (bool) ($eventStart?->getDate() && !$eventStart?->getDateTime()),
                        'link' => $event->getHtmlLink(),
                        'status' => $event->getStatus() ?: 'confirmed',
                    ];
                }

                $pageToken = $response->getNextPageToken();
            } while ($pageToken);

            return $items;
        } catch (Throwable $e) {
            Log::error('Falha ao consultar Google Calendar.', [
                'message' => $e->getMessage(),
                'calendar_id' => $calendarId,
            ]);

            throw new RuntimeException(
                'Não foi possível carregar a agenda do Google Calendar. Confira a configuração e os logs do Laravel.',
                previous: $e
            );
        }
    }
}
