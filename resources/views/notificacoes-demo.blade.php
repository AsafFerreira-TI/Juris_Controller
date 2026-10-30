<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Teste de notificações | Juris_Controller</title>
    <link rel="stylesheet" href="{{ asset('css/notifications.css') }}">
    <style>
        body{margin:0;padding:32px;background:#f3f4f6;color:#1f2937;font-family:Arial,sans-serif}
        main{max-width:760px;margin:30px auto;padding:28px;background:#fff;border-radius:16px;box-shadow:0 8px 25px #0000000d}
        h1{margin-top:0}.actions{display:flex;flex-wrap:wrap;gap:10px;margin-top:22px}.actions form{margin:0}
        button{border:0;border-radius:8px;padding:11px 15px;cursor:pointer;color:#fff;background:#2563eb;font-weight:600}
        .success{background:#15803d}.error{background:#b91c1c}.warning{background:#b45309}.info{background:#1d4ed8}
    </style>
</head>
<body>
    @include('components.notification-toast')
    <main>
        <h1>Teste de notificações</h1>
        <p>Esta página temporária permite testar os quatro tipos de toast sem alterar nenhum processo real.</p>
        <p>Clique em um botão. A notificação aparece no canto superior direito e fecha sozinha em aproximadamente cinco segundos.</p>
        <div class="actions">
            @foreach (['success' => 'Testar sucesso', 'error' => 'Testar erro', 'warning' => 'Testar aviso', 'info' => 'Testar informação'] as $tipo => $rotulo)
                <form method="POST" action="{{ route('notificacoes-demo.testar') }}">
                    @csrf <input type="hidden" name="tipo" value="{{ $tipo }}">
                    <button class="{{ $tipo }}" type="submit">{{ $rotulo }}</button>
                </form>
            @endforeach
        </div>
    </main>
    <script src="{{ asset('js/notifications.js') }}" defer></script>
</body>
</html>
