{{-- resources/views/partials/footer.blade.php --}}
<footer class="bg-dark text-light pt-5 pb-3">
  <div class="container">

    <!-- 1. BANNER CTA DE AGENDAMENTO -->
    <div class="card bg-secondary bg-opacity-10 border-secondary border-opacity-25 rounded-4 p-4 mb-5">
      <div class="row align-items-center">
        <div class="col-md-8 d-flex align-items-center mb-3 mb-md-0">
          <div class="me-3 fs-1 text-warning">
            <i class="bi bi-calendar-event"></i>
          </div>
          <div>
            <h5 class="fw-bold mb-1 text-white">Pronto para transformar a gestão do seu escritório?</h5>
            <p class="mb-0 text-secondary fs-6">Agende uma demonstração gratuita e veja como o Juris Control pode fazer a diferença.</p>
          </div>
        </div>
        <div class="col-md-4 text-md-end">
          <a href="#" class="btn btn-warning btn-lg fw-bold px-4">
            Agendar agora <i class="bi bi-chevron-right ms-1"></i>
          </a>
        </div>
      </div>
    </div>

    <!-- 2. NAVEGAÇÃO PRINCIPAL DO RODAPÉ -->
    <div class="row gy-4 mb-5">
      <!-- Coluna 1: Logo e Sobre -->
      <div class="col-lg-3 col-md-6">
        <div class="d-flex align-items-center mb-3">
          <div class="border border-warning border-2 rounded-circle p-2 me-2 d-inline-flex justify-content-center align-items-center" style="width: 50px; height: 50px;">
            <i class="bi bi-scale text-warning fs-4"></i>
          </div>
          <span class="fs-4 fw-bold fst-italic text-white">JURIS <span class="fw-normal">CONTROL</span></span>
        </div>
        <p class="text-secondary small">
          Soluções completas para gestão jurídica, trazendo mais controle, segurança e eficiência para o seu escritório.
        </p>
        <div class="d-flex gap-2 pt-2">
          <a href="#" class="btn btn-outline-secondary btn-sm rounded-circle"><i class="bi bi-linkedin"></i></a>
          <a href="#" class="btn btn-outline-secondary btn-sm rounded-circle"><i class="bi bi-instagram"></i></a>
          <a href="#" class="btn btn-outline-secondary btn-sm rounded-circle"><i class="bi bi-facebook"></i></a>
        </div>
      </div>

      <!-- Coluna 2: Navegação -->
      <div class="col-lg-3 col-md-6">
        <h6 class="fw-bold text-white mb-3">Navegação</h6>
        <ul class="list-unstyled text-secondary small d-flex flex-column gap-2 mb-0">
          <li><a href="#" class="text-secondary text-decoration-none">Início</a></li>
          <li><a href="#" class="text-secondary text-decoration-none">Soluções</a></li>
          <li><a href="#" class="text-secondary text-decoration-none">Recursos</a></li>
          <li><a href="#" class="text-secondary text-decoration-none">Sobre</a></li>
          <li><a href="#" class="text-secondary text-decoration-none">Contato</a></li>
        </ul>
      </div>

      <!-- Coluna 3: Soluções -->
      <div class="col-lg-3 col-md-6">
        <h6 class="fw-bold text-white mb-3">Soluções</h6>
        <ul class="list-unstyled text-secondary small d-flex flex-column gap-2 mb-0">
          <li><a href="#" class="text-secondary text-decoration-none">Gestão de Processos</a></li>
          <li><a href="#" class="text-secondary text-decoration-none">Gestão de Clientes</a></li>
          <li><a href="#" class="text-secondary text-decoration-none">Agenda Integrada</a></li>
          <li><a href="#" class="text-secondary text-decoration-none">Documentos</a></li>
          <li><a href="#" class="text-secondary text-decoration-none">Relatórios</a></li>
        </ul>
      </div>

      <!-- Coluna 4: Contato -->
      <div class="col-lg-3 col-md-6">
        <h6 class="fw-bold text-white mb-3">Contato</h6>
        <ul class="list-unstyled text-secondary small d-flex flex-column gap-3 mb-0">
          <li class="d-flex align-items-center gap-2">
            <i class="bi bi-telephone text-warning"></i> (11) 99999-9999
          </li>
          <li class="d-flex align-items-center gap-2">
            <i class="bi bi-envelope text-warning"></i> contato@juriscontrol.com.br
          </li>
          <li class="d-flex align-items-start gap-2">
            <i class="bi bi-geo-alt text-warning mt-1"></i>
            <span>Av. Paulista, 1000 - 10º andar<br>São Paulo - SP, 01310-100</span>
          </li>
        </ul>
      </div>
    </div>

    <!-- 3. DIREITOS E TERMOS -->
    <div class="border-top border-secondary border-opacity-25 pt-3 mt-4">
      <div class="row align-items-center text-secondary small">
        <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
          &copy; {{ date('Y') }} Juris Control. Todos os direitos reservados.
        </div>
        <div class="col-md-6 text-center text-md-end">
          <a href="#" class="text-secondary text-decoration-none me-2">Política de Privacidade</a>
          <span class="me-2">|</span>
          <a href="#" class="text-secondary text-decoration-none">Termos de Uso</a>
        </div>
      </div>
    </div>

  </div>
</footer>
