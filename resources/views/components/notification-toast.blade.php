@if (session()->has('toast'))
    @php
        $toast = session('toast', []);
        $tipo = $toast['tipo'] ?? 'success';
        $tipos = ['success', 'error', 'warning', 'info'];
        if (!in_array($tipo, $tipos, true)) $tipo = 'info';
        $icones = ['success' => '✓', 'error' => '!', 'warning' => '⚠', 'info' => 'i'];
    @endphp
    <div class="app-toast app-toast--{{ $tipo }}" id="app-toast"
         role="{{ $tipo === 'error' ? 'alert' : 'status' }}"
         aria-live="{{ $tipo === 'error' ? 'assertive' : 'polite' }}" data-autoclose="5000">
        <div class="app-toast__icon" aria-hidden="true">{{ $icones[$tipo] }}</div>
        <div class="app-toast__content">
            <strong>{{ $toast['titulo'] ?? 'Notificação' }}</strong>
            @if (!empty($toast['mensagem'])) <p>{{ $toast['mensagem'] }}</p> @endif
            @if (!empty($toast['detalhes']) && is_array($toast['detalhes']))
                <ul>@foreach ($toast['detalhes'] as $detalhe)<li>{{ $detalhe }}</li>@endforeach</ul>
            @endif
        </div>
        <button type="button" class="app-toast__close" aria-label="Fechar notificação"
                onclick="this.closest('.app-toast')?.remove()">&times;</button>
    </div>
@endif
