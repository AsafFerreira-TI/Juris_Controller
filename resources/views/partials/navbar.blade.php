{{-- resources/views/partials/navbar.blade.php --}}

{{-- NAVBAR PRINCIPAL --}}
<nav class="navbar navbar-dark bg-black border-bottom border-dark py-3">
    <div class="container-fluid px-lg-5">

        {{-- ESQUERDA: MENU MOBILE + LOGO --}}
        <div class="d-flex align-items-center">

            {{-- Botão aparece apenas em telas pequenas --}}
            <button
                class="navbar-toggler border-0 p-0 me-3 d-lg-none"
                type="button"
                data-bs-toggle="offcanvas"
                data-bs-target="#menuLateral"
                aria-controls="menuLateral"
                aria-label="Abrir menu"
            >
                <span class="navbar-toggler-icon"></span>
            </button>

            {{-- LOGO --}}
            <a
                class="navbar-brand fs-4 fw-bold fst-italic tracking-wide text-white m-0"
                href="{{ route('home') }}"
            >
                <span class="fw-normal">JURIS </span>CONTROL
            </a>

        </div>


        {{-- DIREITA: NAVEGAÇÃO + ÍCONES --}}
        <div class="d-flex align-items-center gap-3">

            {{-- LINKS: aparecem apenas no desktop --}}
            <ul class="navbar-nav flex-row align-items-center gap-4 d-none d-lg-flex">

               <li class="nav-item">
                    <a
                        class="nav-link fw-medium {{ request()->routeIs('home') ? 'text-white border-bottom border-warning border-2 pb-1' : 'text-secondary' }}"
                        href="{{ route('home') }}"
                    >
                        Início
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link fw-medium {{ request()->routeIs('servicos') ? 'text-white border-bottom border-warning border-2 pb-1' : 'text-secondary' }}"
                        href="{{ route('servicos') }}"
                    >
                        Serviços
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link fw-medium {{ request()->routeIs('sobre') ? 'text-white border-bottom border-warning border-2 pb-1' : 'text-secondary' }}"
                        href="{{ route('sobre') }}"
                    >
                        Sobre
                    </a>
                </li>
                @auth
                <li class="nav-item">
                    <a
                        class="nav-link fw-medium {{ request()->routeIs('processos.index') ? 'text-white border-bottom border-warning border-2 pb-1' : 'text-secondary' }}"
                        href="{{ route('processos.index') }}"
                    >
                        Processos
                    </a>
                </li>
                @endauth
            </ul>


            {{-- NOTIFICAÇÕES --}}
            <a
                href="#"
                class="text-white position-relative fs-5 text-decoration-none navbar-icon"
                aria-label="Notificações"
            >
                <i class="bi bi-bell"></i>

                <span
                    class="position-absolute top-0 start-100 translate-middle
                    p-1 bg-warning border border-dark rounded-circle"
                >
                    <span class="visually-hidden">
                        Notificações
                    </span>
                </span>
            </a>


            {{-- PERFIL --}}
            @auth
            <a
                href="{{ route('perfil') }}"
                class="text-white fs-4 text-decoration-none navbar-icon"
                aria-label="Login"
            >
                <i class="bi bi-person-circle"></i>
            </a>
            @else
            <a
                href="{{ route('login') }}"
                class="text-white fs-4 text-decoration-none navbar-icon"
                aria-label="Login"
            >
                <i class="bi bi-person-circle"></i>
            </a>
            @endauth


        </div>

    </div>
</nav>



<div
    class="offcanvas offcanvas-start text-bg-dark"
    tabindex="-1"
    id="menuLateral"
    aria-labelledby="menuLateralLabel"
>

    {{-- CABEÇALHO --}}
    <div class="offcanvas-header border-bottom border-secondary px-4 py-3">

        <a
            class="navbar-brand fs-4 fw-bold fst-italic text-white m-0"
            href="{{ route('home') }}"
        >
            <span class="fw-light">JURIS</span>
            CONTROL
        </a>

        {{-- BOTÃO FECHAR --}}
        <button
            type="button"
            class="btn-close btn-close-white"
            data-bs-dismiss="offcanvas"
            aria-label="Fechar menu"
        ></button>

    </div>


    {{-- CONTEÚDO --}}
    <div class="offcanvas-body p-4 d-flex flex-column">

        {{-- NAVEGAÇÃO --}}
        <div>

            <p class="text-uppercase text-secondary small fw-bold mb-3">
                Navegação
            </p>

            <div class="list-group list-group-flush gap-2">

                {{-- INÍCIO --}}
                <a
                    href="{{ route('home') }}"
                    class="list-group-item list-group-item-action border-0 rounded-3 fw-semibold py-3
                    {{ request()->routeIs('home')
                        ? 'bg-warning text-dark'
                        : 'bg-transparent text-white' }}"
                >
                    <i class="bi bi-house-door me-3"></i>
                    Início
                </a>


                {{-- SERVIÇOS --}}
                <a
                    href="{{ route('servicos') }}"
                    class="list-group-item list-group-item-action border-0 rounded-3 py-3
                    {{ request()->routeIs('servicos')
                        ? 'bg-warning text-dark'
                        : 'bg-transparent text-white' }}"
                >
                    <i class="bi bi-grid me-3"></i>
                    Serviços
                </a>


                {{-- SOBRE --}}
                <a
                    href="{{ route('sobre') }}"
                    class="list-group-item list-group-item-action border-0 rounded-3 py-3
                    {{ request()->routeIs('sobre')
                        ? 'bg-warning text-dark'
                        : 'bg-transparent text-white' }}"
                >
                    <i class="bi bi-info-circle me-3"></i>
                    Sobre
                </a>

            </div>

        </div>


        {{-- DIVISÓRIA --}}
        <hr class="border-secondary my-4">


        {{-- CONTA --}}
        <div>

            <p class="text-uppercase text-secondary small fw-bold mb-3">
                Conta
            </p>

            <div class="list-group list-group-flush gap-2">

                {{-- NOTIFICAÇÕES --}}
                <a
                    href="#notificacoes"
                    class="list-group-item list-group-item-action bg-transparent text-white border-0 rounded-3 py-3"
                >
                    <i class="bi bi-bell me-3"></i>
                    Notificações

                    <span class="badge text-bg-warning rounded-pill float-end">
                        3
                    </span>
                </a>

            </div>

        </div>


        {{-- ÁREA INFERIOR --}}
        <div class="mt-auto pt-4 border-top border-secondary">

            <div class="d-flex align-items-center">

                <div
                    class="rounded-circle bg-warning text-dark d-flex align-items-center justify-content-center fw-bold"
                    style="width: 42px; height: 42px;"
                >
                </div>


                <div class="ms-3">

                    @auth

                        <div class="fw-semibold">
                            {{ Auth::user()->nome_advg }}
                        </div>

                        <a
                            href="{{ route('perfil') }}"
                            class="text-decoration-none"
                        >
                            <small class="text-white">
                                Minha conta
                            </small>
                        </a>

                    @else

                        <div class="fw-semibold">
                            Entre na sua conta
                        </div>

                        <a
                            href="{{ route('perfil') }}"
                            class="text-decoration-none"
                        >
                            <small class="text-white">
                                Minha conta
                            </small>
                        </a>

                    @endauth

                </div>

            </div>

        </div>

    </div>

</div>

