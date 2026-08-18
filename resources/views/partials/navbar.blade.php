{{-- resources/views/partials/navbar.blade.php --}}
<nav class="navbar navbar-expand-lg navbar-dark bg-black border-bottom border-dark py-3">
  <div class="container-fluid px-lg-5">

    <!-- ÍCONE MENU (TOGGLER) + LOGO -->
    <div class="d-flex align-items-center">
      <button class="navbar-toggler border-0 p-0 me-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarConteudo">
        <span class="navbar-toggler-icon"></span>
      </button>

      <a class="navbar-brand fs-4 fw-bold fst-italic tracking-wide text-white m-0" href="{{ route('home') }}">
        <span class="fw-normal">JURIS </span>CONTROL
      </a>
    </div>

    <!-- NAVEGAÇÃO E ÍCONES -->
    <div class="collapse navbar-collapse" id="navbarConteudo">
      <!-- Links Principais (Centralizados/Alinhados à Direita) -->
      <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-3 my-2 my-lg-0">
        <li class="nav-item">
          <a class="nav-link active text-white fw-medium border-bottom border-warning border-2 pb-1" href="{{ route('home') }}">Início</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-secondary fw-medium" href="#solucoes">Soluções</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-secondary fw-medium" href="#recursos">Recursos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-secondary fw-medium" href="#sobre">Sobre</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-secondary fw-medium" href="#contato">Contato</a>
        </li>
      </ul>

      <!-- Ícones de Ação (Notificação com Badge + Perfil) -->
      <div class="d-flex align-items-center gap-3 ms-lg-4 pt-2 pt-lg-0">
        <!-- Notificação -->
        <a href="#" class="text-white position-relative fs-5 text-decoration-none">
          <i class="bi bi-bell"></i>
          <span class="position-absolute top-0 start-100 translate-middle p-1 bg-warning border border-dark rounded-circle">
            <span class="visually-hidden">Notificações</span>
          </span>
        </a>

        <!-- Perfil de Usuário -->
        <a href="#" class="text-white fs-4 text-decoration-none">
          <i class="bi bi-person-circle"></i>
        </a>
      </div>
    </div>

  </div>
</nav>
