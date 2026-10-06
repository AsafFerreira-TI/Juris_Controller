@@extends('layouts.app')

@section('title', 'Início')

@section('content')

<link rel="stylesheet" href="{{ asset('css/home.css') }}">

<section class="hero">
    <div class="hero-image">
        <img src="{{ asset('img/img_fundo_index.png') }}" alt="Escritório de advocacia">
    </div>

    <div class="hero-content">
        <h1>
            No <span>Juris Control</span> você tem total controle do seu escritório
        </h1>

        <p>
            Melhore a eficiência do seu trabalho, reduza erros operacionais,
            evitando a perda de prazos importantes.
        </p>

        <a href="#" class="btn-gold">Agendar demonstração&nbsp; ›</a>
    </div>
</section>

<section class="benefits">
    <div class="benefits-left">
        <div class="circle-logo">
            <img src="{{ asset('img/JurisControl.png') }}" alt="Juris Control">
        </div>

        <div class="benefits-text">
            <h2>Soluções inteligentes para seu escritório</h2>
            <p>
                Automatize tarefas, organize processos e tenha mais controle
                sobre sua rotina jurídica.
            </p>
        </div>
    </div>

    <div class="benefits-right">
        <div class="benefit-item">
            <img src="{{ asset('img/securityshield.png') }}" alt="">
            <div>
                <h4>Segurança de dados</h4>
                <p>Proteção total das informações.</p>
            </div>
        </div>

        <div class="benefit-item">
            <img src="{{ asset('img/relogio.png') }}" alt="">
            <div>
                <h4>Economia de tempo</h4>
                <p>Automatize tarefas repetitivas.</p>
            </div>
        </div>

        <div class="benefit-item">
            <img src="{{ asset('img/Positive Dynamic.png') }}" alt="">
            <div>
                <h4>Relatórios inteligentes</h4>
                <p>Visualize indicadores em tempo real.</p>
            </div>
        </div>
    </div>
</section>

<section class="split-section">
    <div class="split-text">
        <h2>Otimize seus processos com inteligência e praticidade</h2>

        <p>
            Centralize todas as informações do seu escritório em um único lugar.
            Com o Juris Control, você ganha mais eficiência no dia a dia,
            reduz erros e garante maior controle sobre cada etapa do seu serviço.
        </p>

        <ul class="features-list">
            <li>Gestão de processos e prazos</li>
            <li>Controle de clientes e contatos</li>
            <li>Tarefas e compromissos automatizados</li>
            <li>Armazenamento seguro de documentos</li>
        </ul>
    </div>

    <div class="split-image">
        <img src="{{ asset('img/image 28.png') }}" alt="Profissional utilizando o Juris Control">
    </div>
</section>

<section class="split-section reverse">
    <div class="split-image">
        <img src="{{ asset('img/image 29.png') }}" alt="Gestão de escritório">
    </div>

    <div class="split-text">
        <h2>Agilidade que gera mais retorno</h2>

        <p>
            Ao organizar seus processos com mais eficiência e rapidez, você reduz
            perdas de prazo e aumenta a produtividade do seu escritório. Com o
            Juris Control, a agilidade na gestão permite atender mais demandas,
            melhorar a performance da equipe e, consequentemente, alcançar um
            maior retorno financeiro.
        </p>

        <ul class="features-list">
            <li>Mais produtividade para sua equipe</li>
            <li>Redução de retrabalho e erros</li>
            <li>Atendimento mais ágil ao cliente</li>
            <li>Crescimento sustentável do seu negócio</li>
        </ul>
    </div>
</section>

<section class="resources">
    <h2>Recursos que fazem diferença</h2>

    <div class="resource-grid">
        <div class="resource-card">
            <img src="{{ asset('img/User Account.png') }}" alt="">
            <h3>Gestão de Clientes</h3>
            <p>Cadastre e organize seus clientes e acompanhe todo o histórico de atendimento.</p>
        </div>

        <div class="resource-card">
            <img src="{{ asset('img/Business.png') }}" alt="">
            <h3>Gestão de Processos</h3>
            <p>Acompanhe prazos, tarefas e etapas dos seus processos.</p>
        </div>

        <div class="resource-card">
            <img src="{{ asset('img/Google Calendar.png') }}" alt="">
            <h3>Agenda Integrada</h3>
            <p>Organize compromissos e evite perder prazos importantes.</p>
        </div>

        <div class="resource-card">
            <img src="{{ asset('img/Documents.png') }}" alt="">
            <h3>Documentos</h3>
            <p>Armazene e gerencie documentos de forma segura.</p>
        </div>

        <div class="resource-card">
            <img src="{{ asset('img/Positive Dynamic.png') }}" alt="">
            <h3>Relatórios</h3>
            <p>Visualize indicadores e tome decisões baseadas em dados.</p>
        </div>
    </div>
</section>

<section class="testimonials-modern">
    <h2>O que nossos clientes dizem</h2>

    <div class="testimonial-grid">
        <div class="testimonial-card">
            <p>
                O Juris Control transformou a forma como gerenciamos nosso escritório.
                Muito mais organização e eficiência.
            </p>
            <span class="testimonial-author">— Ana Paula, Advogada</span>
            <span class="testimonial-stars">★★★★★</span>
        </div>

        <div class="testimonial-card">
            <p>
                Reduzimos o retrabalho e ganhamos tempo para focar no que realmente importa
                para nossos clientes.
            </p>
            <span class="testimonial-author">— Carlos Mendes, Sócio</span>
            <span class="testimonial-stars">★★★★★</span>
        </div>

        <div class="testimonial-card">
            <p>
                A melhor ferramenta que já usamos. Suporte excelente e recursos que fazem
                a diferença no dia a dia.
            </p>
            <span class="testimonial-author">— Juliana Ribeiro, Gerente</span>
            <span class="testimonial-stars">★★★★★</span>
        </div>
    </div>
</section>

<section class="cta-section">
    <div>
        <div class="cta-icon">▣</div>
        <div>
            <h2>Pronto para transformar a gestão do seu escritório?</h2>
            <p>Agende uma demonstração gratuita e veja como o Juris Control pode facilitar sua rotina.</p>
        </div>
    </div>

    <a href="#" class="btn-gold">Agendar agora&nbsp; ›</a>
</section>





@endsection
