@if (session()->has('sucesso')) <div class="alert alert-success alert-dismissible fade show alerta-flutuante"
      role="alert"> <strong>Sucesso!</strong>
{{ session('sucesso') }}

    <button type="button"
            class="btn-close"
            data-bs-dismiss="alert"
            aria-label="Fechar">
    </button>
</div>

@endif

@if (session()->has('erro')) <div class="alert alert-danger alert-dismissible fade show alerta-flutuante"
      role="alert"> <strong>Erro!</strong>
{{ session('erro') }}

    <button type="button"
            class="btn-close"
            data-bs-dismiss="alert"
            aria-label="Fechar">
    </button>
</div>

@endif

@if ($errors->any()) <div class="alert alert-warning alert-dismissible fade show alerta-flutuante"
      role="alert"> <strong>Atenção!</strong>
Verifique os campos do formulário.

    <button type="button"
            class="btn-close"
            data-bs-dismiss="alert"
            aria-label="Fechar">
    </button>
</div>

@endif
