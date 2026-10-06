document.addEventListener('DOMContentLoaded', () => {
    const pagina = document.getElementById('calendario-audiencias');

    if (!pagina) {
        return;
    }

    const selectMes = document.getElementById('mes-selector');
    const tituloMes = document.getElementById('calendario-mes-titulo');
    const calendarioGrid = document.getElementById('calendario-grid');
    const audienciasTitulo = document.getElementById('audiencias-titulo');
    const audienciasConteudo = document.getElementById('audiencias-conteudo');

    const mesAtual = Number(pagina.dataset.mesAtual);
    const anoAtual = Number(pagina.dataset.anoAtual);

    const meses = [
        '',
        'Janeiro', 'Fevereiro', 'Março', 'Abril',
        'Maio', 'Junho', 'Julho', 'Agosto',
        'Setembro', 'Outubro', 'Novembro', 'Dezembro'
    ];

    let audiencias = [];

    try {
        const dados = JSON.parse(pagina.dataset.audiencias || '[]');
        audiencias = Array.isArray(dados) ? dados : [];
    } catch (error) {
        audiencias = [];
    }

    function escaparHtml(valor) {
        const elemento = document.createElement('div');
        elemento.textContent = valor ?? '';
        return elemento.innerHTML;
    }

    function obterData(audiencia) {
        if (typeof audiencia === 'string') {
            return audiencia.substring(0, 10);
        }

        if (!audiencia || typeof audiencia !== 'object') {
            return null;
        }

        return String(
            audiencia.data ??
            audiencia.data_audiencia ??
            audiencia.dataAudiencia ??
            ''
        ).substring(0, 10);
    }

    function audienciasDoDia(ano, mes, dia) {
        const chave = [
            ano,
            String(mes).padStart(2, '0'),
            String(dia).padStart(2, '0')
        ].join('-');

        return audiencias.filter((audiencia) => obterData(audiencia) === chave);
    }

    function renderizarCalendario(mes, ano) {
        calendarioGrid.replaceChildren();
        tituloMes.textContent = `${meses[mes]} ${ano}`;

        const primeiroDia = new Date(ano, mes - 1, 1).getDay();
        const ultimoDia = new Date(ano, mes, 0).getDate();

        for (let i = 0; i < primeiroDia; i += 1) {
            const vazio = document.createElement('div');
            vazio.className = 'dia dia-vazio';
            calendarioGrid.appendChild(vazio);
        }

        for (let dia = 1; dia <= ultimoDia; dia += 1) {
            const audiencias = audienciasDoDia(ano, mes, dia);
            const celula = document.createElement('div');
            celula.className = 'dia';

            const numero = document.createElement('span');
            numero.className = 'dia-numero';
            numero.textContent = dia;
            celula.appendChild(numero);

            if (audiencias.length > 0) {
                celula.classList.add('tem-audiencia');

                const indicador = document.createElement('span');
                indicador.className = 'indicador-audiencia';
                indicador.textContent = audiencias.length === 1
                    ? '1 audiência'
                    : `${audiencias.length} audiências`;
                celula.appendChild(indicador);

                celula.addEventListener('click', () => {
                    mostrarAudiencias(ano, mes, dia, audiencias);
                });
            }

            calendarioGrid.appendChild(celula);
        }

        const faltantes = (7 - (calendarioGrid.children.length % 7)) % 7;

        for (let i = 0; i < faltantes; i += 1) {
            const vazio = document.createElement('div');
            vazio.className = 'dia dia-vazio';
            calendarioGrid.appendChild(vazio);
        }
    }

    function mostrarAudiencias(ano, mes, dia, audienciasDoDiaSelecionado) {
        const data = `${String(dia).padStart(2, '0')}/${String(mes).padStart(2, '0')}/${ano}`;

        audienciasTitulo.textContent =
            `Audiências de ${dia} de ${meses[mes]} de ${ano}`;

        audienciasConteudo.replaceChildren();

        const lista = document.createElement('div');
        lista.className = 'audiencia-lista';

        audienciasDoDiaSelecionado.forEach((audiencia) => {
            const item = document.createElement('article');
            item.className = 'audiencia-item';

            const horario = typeof audiencia === 'object'
                ? (audiencia.horario ?? audiencia.hora ?? '')
                : '';

            const tipo = typeof audiencia === 'object'
                ? (audiencia.tipo ?? audiencia.tipo_audiencia ?? audiencia.tipoAudiencia ?? 'Audiência')
                : 'Audiência';

            let html = `
                <div class="audiencia-horario">${escaparHtml(horario)}</div>
                <div class="audiencia-tipo">${escaparHtml(tipo)}</div>
                <div class="audiencia-detalhes">
                    <div class="audiencia-campo">
                        <strong>Data:</strong> ${escaparHtml(data)}
                    </div>
            `;

            if (typeof audiencia === 'object') {
                const campos = [
                    ['Processo', audiencia.processo],
                    ['Cliente', audiencia.cliente],
                    ['Local', audiencia.local],
                    ['Sala', audiencia.sala],
                    ['Advogado responsável', audiencia.advogado ?? audiencia.advogado_responsavel],
                    ['Status', audiencia.status]
                ];

                campos.forEach(([rotulo, valor]) => {
                    if (valor !== undefined && valor !== null && valor !== '') {
                        html += `
                            <div class="audiencia-campo">
                                <strong>${escaparHtml(rotulo)}:</strong>
                                ${escaparHtml(valor)}
                            </div>
                        `;
                    }
                });

                const observacoes = audiencia.observacoes ?? audiencia.observacao;

                if (observacoes) {
                    html += `
                        <div class="audiencia-campo audiencia-observacoes">
                            <strong>Observações:</strong>
                            ${escaparHtml(observacoes)}
                        </div>
                    `;
                }
            }

            html += '</div>';
            item.innerHTML = html;
            lista.appendChild(item);
        });

        audienciasConteudo.appendChild(lista);

        document.querySelector('.audiencias-section')?.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }

    function limparAudienciasSelecionadas() {
        audienciasTitulo.textContent = 'Audiências do dia selecionado';
        audienciasConteudo.innerHTML = `
            <div class="audiencias-vazio">
                Selecione uma data com audiência para visualizar as informações.
            </div>
        `;
    }

    // Estado inicial: mês atual, sem exigir nenhuma ação do usuário.
    selectMes.value = String(mesAtual);
    renderizarCalendario(mesAtual, anoAtual);

    // O calendário só muda quando o usuário troca o mês.
    selectMes.addEventListener('change', () => {
        const mesSelecionado = Number(selectMes.value);

        renderizarCalendario(mesSelecionado, anoAtual);
        limparAudienciasSelecionadas();
    });
});
