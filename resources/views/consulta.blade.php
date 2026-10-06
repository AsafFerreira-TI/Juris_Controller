<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta Processual - DataJud</title>
    <!-- Adicionando Tailwind CSS para um design limpo -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen py-10">

    <div class="max-w-4xl mx-auto px-4">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Juris Controller - Consulta DataJud</h1>

        <!-- Alertas de Erro -->
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif

        <!-- Formulário de Busca -->
        <div class="bg-white shadow rounded-lg p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Consultar Processo Judicial</h2>

            <form action="{{ route('consulta.buscar') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Input Número do Processo -->
                    <div class="md:col-span-2">
                        <label for="numero_processo" class="block text-sm font-medium text-gray-700 mb-1">Número do Processo (CNJ)</label>
                        <input type="text"
                               name="numero_processo"
                               id="numero_processo"
                               value="{{ old('numero_processo') }}"
                               placeholder="0000000-00.0000.0.00.0000"
                               class="w-full px-4 py-2 border rounded-md focus:ring-blue-500 focus:border-blue-500"
                               required>
                    </div>

                    <!-- Dropdown de Tribunais -->
                    <div>
                        <label for="tribunal" class="block text-sm font-medium text-gray-700 mb-1">Tribunal</label>
                        <select name="tribunal" id="tribunal" class="w-full px-4 py-2 border rounded-md focus:ring-blue-500 focus:border-blue-500" required>
                            <option value="">Selecione...</option>
                            <option value="tjsp">TJSP (São Paulo)</option>
                            <option value="tjmg">TJMG (Minas Gerais)</option>
                            <option value="tjrj">TJRJ (Rio de Janeiro)</option>
                            <option value="trf1">TRF1 (Federal Região 1)</option>
                            <option value="trt2">TRT2 (Trabalhista SP)</option>
                            <option value="trt15">TRT15 (Trabalhista Campinas)</option>
                        </select>
                    </div>
                </div>

                <div class="text-right">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-md transition duration-150">
                        Consultar Processo
                    </button>
                </div>
            </form>
        </div>

        <!-- Mensagens alternativas se não encontrar nada -->
        @if(isset($mensagem))
            <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 p-4 rounded-md text-center">
                {{ $mensagem }}
            </div>
        @endif

        <!-- Se houver resultados, exibe os metadados do processo -->
        @if(isset($processo))
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-2xl font-bold text-gray-800 mb-4 border-b pb-2">Detalhes do Processo</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <p class="text-sm text-gray-500 font-semibold">Número Único CNJ:</p>
                        <p class="text-base text-gray-900 font-bold">{{ $processo['numeroProcesso'] }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-semibold">Tribunal de Origem:</p>
                        <p class="text-base text-gray-900 font-bold uppercase">{{ $processo['siglaTribunal'] ?? 'Não informado' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-semibold">Classe Judicial:</p>
                        <p class="text-base text-gray-900">{{ $processo['classe']['nome'] ?? 'Não informada' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-semibold">Órgão Julgador:</p>
                        <p class="text-base text-gray-900">{{ $processo['orgaoJulgador']['nome'] ?? 'Não informado' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-semibold">Data de Distribuição / Ajuizamento:</p>
                        <p class="text-base text-gray-900">
                            {{ isset($processo['dataAjuizamento']) ? \Carbon\Carbon::parse($processo['dataAjuizamento'])->format('d/m/Y H:i') : 'Não informada' }}
                        </p>
                    </div>
                </div>

                <!-- Movimentações Recentes -->
                @if(!empty($processo['movimentos']))
                    <h4 class="text-lg font-bold text-gray-700 mb-3">Movimentações Recentes</h4>
                    <div class="flow-root">
                        <ul class="-mb-8">
                            @foreach($processo['movimentos'] as $key => $movimento)
                                <li>
                                    <div class="relative pb-8">
                                        @if($key < count($processo['movimentos']) - 1)
                                            <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                        @endif
                                        <div class="relative flex space-x-3">
                                            <div>
                                                <span class="h-8 w-8 rounded-full bg-blue-100 text-blue-500 flex items-center justify-center font-bold text-sm">
                                                    {{ $loop->iteration }}
                                                </span>
                                            </div>
                                            <div class="flex-1 min-w-0 pt-1.5 flex justify-between space-x-4">
                                                <div>
                                                    <p class="text-sm font-semibold text-gray-900">
                                                        {{ $movimento['nome'] ?? 'Movimentação sem nome registrado' }}
                                                    </p>
                                                    @if(isset($movimento['complementosTabelados']))
                                                        <p class="text-xs text-gray-500 italic mt-1">
                                                            @foreach($movimento['complementosTabelados'] as $comp)
                                                                {{ $comp['nome'] ?? '' }}: {{ $comp['descricao'] ?? '' }};
                                                            @endforeach
                                                        </p>
                                                    @endif
                                                </div>
                                                <div class="text-right text-xs whitespace-nowrap text-gray-500">
                                                    {{ isset($movimento['dataHora']) ? \Carbon\Carbon::parse($movimento['dataHora'])->format('d/m/Y H:i') : '' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <p class="text-sm text-gray-500 italic">Sem movimentações cadastradas na API Pública para este processo.</p>
                @endif
            </div>
        @endif
    </div>

</body>
</html>
