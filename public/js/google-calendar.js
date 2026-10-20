(() => {
    'use strict';

    const app = document.getElementById('google-calendar-app');
    if (!app) return;

    const eventsUrl = app.dataset.eventsUrl;
    const monthSelect = document.getElementById('gcal-month-select');
    const monthTitle = document.getElementById('gcal-month-title');
    const daysGrid = document.getElementById('gcal-days');
    const detailsTitle = document.getElementById('gcal-details-title');
    const detailsContent = document.getElementById('gcal-details-content');
    const feedback = document.getElementById('gcal-feedback');
    const prevButton = document.getElementById('gcal-prev');
    const nextButton = document.getElementById('gcal-next');

    const monthNames = [
        'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho',
        'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
    ];
    const weekdays = ['domingo', 'segunda-feira', 'terça-feira', 'quarta-feira',
        'quinta-feira', 'sexta-feira', 'sábado'];

    let year = Number(app.dataset.initialYear);
    let month = Number(app.dataset.initialMonth); // 1-12
    let events = [];
    let selectedDay = null;
    let requestVersion = 0;

    monthNames.forEach((name, index) => {
        const option = document.createElement('option');
        option.value = String(index + 1);
        option.textContent = name;
        monthSelect.appendChild(option);
    });

    function eventDateParts(value) {
        if (!value) return null;
        // Eventos de dia inteiro vêm como YYYY-MM-DD; não usar Date() neles,
        // para evitar deslocamento de dia por fuso horário.
        const match = /^(\d{4})-(\d{2})-(\d{2})/.exec(value);
        if (match) return { year: Number(match[1]), month: Number(match[2]), day: Number(match[3]) };
        const date = new Date(value);
        if (Number.isNaN(date.getTime())) return null;
        const parts = new Intl.DateTimeFormat('en-CA', {
            timeZone: document.documentElement.lang === 'pt-BR' ? 'America/Sao_Paulo' : undefined,
            year: 'numeric', month: '2-digit', day: '2-digit'
        }).formatToParts(date);
        const get = type => Number(parts.find(part => part.type === type)?.value);
        return { year: get('year'), month: get('month'), day: get('day') };
    }

    function dayKey(y, m, d) {
        return `${y}-${String(m).padStart(2, '0')}-${String(d).padStart(2, '0')}`;
    }

    function getEventDay(event) {
        return eventDateParts(event.inicio);
    }

    function eventsOnDay(day) {
        return events.filter(event => {
            const parts = getEventDay(event);
            return parts && parts.year === year && parts.month === month && parts.day === day;
        });
    }

    function renderCalendar() {
        monthTitle.textContent = `${monthNames[month - 1]} de ${year}`;
        monthSelect.value = String(month);
        daysGrid.replaceChildren();

        const firstWeekday = new Date(year, month - 1, 1).getDay();
        const daysInMonth = new Date(year, month, 0).getDate();

        for (let i = 0; i < firstWeekday; i++) {
            const empty = document.createElement('div');
            empty.className = 'gcal-day gcal-day-empty';
            empty.setAttribute('aria-hidden', 'true');
            daysGrid.appendChild(empty);
        }

        for (let day = 1; day <= daysInMonth; day++) {
            const dayEvents = eventsOnDay(day);
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'gcal-day';
            button.dataset.day = String(day);
            button.setAttribute('aria-label', `${day} de ${monthNames[month - 1]}, ${dayEvents.length} evento(s)`);
            if (dayEvents.length) button.classList.add('has-events');
            if (selectedDay === day) button.classList.add('is-selected');

            const number = document.createElement('span');
            number.className = 'gcal-day-number';
            number.textContent = String(day);
            button.appendChild(number);

            if (dayEvents.length) {
                const indicator = document.createElement('span');
                indicator.className = 'gcal-day-indicator';
                indicator.textContent = dayEvents.length === 1 ? '1 evento' : `${dayEvents.length} eventos`;
                button.appendChild(indicator);
            }

            button.addEventListener('click', () => {
                selectedDay = day;
                renderCalendar();
                renderDetails(day);
            });
            daysGrid.appendChild(button);
        }

        // Mantém a grelha com múltiplos de 7 células.
        while (daysGrid.children.length % 7 !== 0) {
            const empty = document.createElement('div');
            empty.className = 'gcal-day gcal-day-empty';
            empty.setAttribute('aria-hidden', 'true');
            daysGrid.appendChild(empty);
        }
    }

    function formatTime(value, allDay) {
        if (!value) return 'Horário não informado';
        if (allDay) return 'Dia inteiro';
        const date = new Date(value);
        if (Number.isNaN(date.getTime())) return value;
        return new Intl.DateTimeFormat('pt-BR', {
            hour: '2-digit', minute: '2-digit', timeZone: 'America/Sao_Paulo'
        }).format(date);
    }

    function addDetail(label, value, parent) {
        if (!value) return;
        const row = document.createElement('p');
        row.className = 'gcal-event-meta';
        const strong = document.createElement('strong');
        strong.textContent = `${label}: `;
        row.appendChild(strong);
        row.appendChild(document.createTextNode(value));
        parent.appendChild(row);
    }

    function renderDetails(day) {
        detailsTitle.textContent = `Eventos de ${day} de ${monthNames[month - 1]} de ${year}`;
        detailsContent.replaceChildren();
        const list = eventsOnDay(day);

        if (!list.length) {
            const empty = document.createElement('p');
            empty.className = 'gcal-empty';
            empty.textContent = 'Não há eventos nesta data.';
            detailsContent.appendChild(empty);
            return;
        }

        list.forEach(event => {
            const article = document.createElement('article');
            article.className = 'gcal-event-card';

            const title = document.createElement('h3');
            title.textContent = event.titulo || 'Evento sem título';
            article.appendChild(title);

            addDetail('Horário', formatTime(event.inicio, event.dia_inteiro), article);
            addDetail('Local', event.local, article);
            addDetail('Descrição', event.descricao, article);

            if (event.link) {
                const link = document.createElement('a');
                link.href = event.link;
                link.target = '_blank';
                link.rel = 'noopener noreferrer';
                link.textContent = 'Abrir no Google Calendar';
                link.className = 'gcal-event-link';
                article.appendChild(link);
            }
            detailsContent.appendChild(article);
        });
    }

    async function loadMonth() {
        const version = ++requestVersion;
        feedback.textContent = 'Carregando eventos…';
        daysGrid.setAttribute('aria-busy', 'true');

        try {
            const url = new URL(eventsUrl, window.location.origin);
            url.searchParams.set('ano', String(year));
            url.searchParams.set('mes', String(month));

            const response = await fetch(url.toString(), {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                credentials: 'same-origin'
            });
            const payload = await response.json().catch(() => ({}));
            if (!response.ok) throw new Error(payload.message || 'Não foi possível carregar os eventos.');
            if (version !== requestVersion) return;

            events = Array.isArray(payload.eventos) ? payload.eventos : [];
            selectedDay = null;
            renderCalendar();
            detailsTitle.textContent = 'Selecione uma data';
            detailsContent.replaceChildren();
            const empty = document.createElement('p');
            empty.className = 'gcal-empty';
            empty.textContent = 'Clique em uma data para consultar as audiências/eventos.';
            detailsContent.appendChild(empty);
            feedback.textContent = `${events.length} evento(s) encontrado(s) neste mês.`;
        } catch (error) {
            if (version !== requestVersion) return;
            events = [];
            renderCalendar();
            feedback.textContent = error.message || 'Erro ao carregar a agenda.';
        } finally {
            if (version === requestVersion) daysGrid.removeAttribute('aria-busy');
        }
    }

    function changeMonth(value) {
        month = Number(value);
        if (month < 1) { month = 12; year--; }
        if (month > 12) { month = 1; year++; }
        loadMonth();
    }

    monthSelect.addEventListener('change', () => changeMonth(monthSelect.value));
    prevButton.addEventListener('click', () => changeMonth(month - 1));
    nextButton.addEventListener('click', () => changeMonth(month + 1));

    loadMonth();
})();
