<!-- resources/views/layouts/partials/navbar.blade.php -->
<nav class="navbar navbar-expand-lg navbar-dark bg-gradient-custom fixed-top shadow-lg">
  <div class="container-fluid">
      <!-- Logo/Brand com ícone animado -->
      <a class="navbar-brand d-flex align-items-center" href="/">
          <i class="fas fa-tools animate-spin me-2"></i>
          Tech Care
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <!-- Barra de Pesquisa -->
              <li class="nav-item">
                  <form class="d-flex" action="/product/procurar" method="GET">
                      <input class="form-control me-2 search-input" type="search" placeholder="Pesquisar produtos..." aria-label="Search" name="query">
                      <button class="btn btn-outline-light" type="submit">
                          <i class="fas fa-search"></i>
                      </button>
                  </form>
              </li>
          </ul>

          <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
              <!-- Item Home -->
              <li class="nav-item">
                  <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">
                      <i class="fas fa-home me-1"></i> Home
                  </a>
              </li>

              <!-- Item Catálogo -->
              <li class="nav-item">
                  <a class="nav-link {{ request()->is('catalogo') ? 'active' : '' }}" href="/catalogo">
                      <i class="fas fa-list me-1"></i> Catálogo
                  </a>
              </li>

              <!-- Item Agendamento -->
              <li class="nav-item">
                  <a class="nav-link {{ request()->is('agendamento*') ? 'active' : '' }}" href="/agendamento">
                      <i class="fas fa-calendar-alt me-1"></i> Agendamento
                  </a>
              </li>

              <!-- Item Meu Perfil -->
<li class="nav-item">
    <a class="nav-link {{ request()->is('perfil') ? 'active' : '' }}" href="{{ route('profile') }}">
        <!-- Verifica se o utilizador está autenticado antes de tentar acessar a foto de perfil -->
        @auth
            <!-- Verifica se o utilizador tem uma foto de perfil -->
            @if(auth()->user()->profile_photo)
                <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="Foto de Perfil" class="rounded-circle" width="30" height="30" style="object-fit: cover; margin-right: 8px;">
            @else
                <i class="fas fa-user"></i>
            @endif
        @else
            <i class="fas fa-user"></i>
        @endauth
        O Meu Perfil
    </a>
</li>




              <!-- Dropdown para usuários autenticados -->
              @auth
                  <!-- Dropdown para Admin -->
                  @if(auth()->user()->role === 'admin')
                      <li class="nav-item dropdown">
                          <a class="nav-link dropdown-toggle {{ request()->is('admin*') ? 'active' : '' }}" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                              <i class="fas fa-user-shield me-1"></i> Admin
                          </a>
                          <ul class="dropdown-menu dropdown-menu-dark">
                              <li><a class="dropdown-item" href="/admin/dashboard">Dashboard</a></li>
                              <li><a class="dropdown-item" href="/admin/settings">Configurações</a></li>
                              <li><hr class="dropdown-divider"></li>
                              <li><a class="dropdown-item" href="/admin/manage/users">Gerenciar Usuários</a></li>
                              <li><a class="dropdown-item" href="/admin/manage/stores">Gerenciar Lojas</a></li>
                          </ul>
                      </li>
                  @endif

                  <!-- Dropdown para Vendor -->
                  @if(auth()->user()->role === 'vendor')
                      <li class="nav-item dropdown">
                          <a class="nav-link dropdown-toggle {{ request()->is('vendor*') ? 'active' : '' }}" href="#" id="vendorDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                              <i class="fas fa-store me-1"></i> Vendor
                          </a>
                          <ul class="dropdown-menu dropdown-menu-dark">
                              <li><a class="dropdown-item" href="/vendor/dashboard">Dashboard</a></li>
                              <li><a class="dropdown-item" href="/vendor/product/create">Criar Produto</a></li>
                              <li><a class="dropdown-item" href="/vendor/product/manage">Gerenciar Produtos</a></li>
                          </ul>
                      </li>
                  @endif

                  <!-- Dropdown para Customer -->
                  @if(auth()->user()->role === 'customer')
                      <li class="nav-item dropdown">
                          <a class="nav-link dropdown-toggle {{ request()->is('user*') ? 'active' : '' }}" href="#" id="customerDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                              <i class="fas fa-user me-1"></i> Cliente
                          </a>
                          <ul class="dropdown-menu dropdown-menu-dark">
                              <li><a class="dropdown-item" href="/user/dashboard">Dashboard</a></li>
                              <li><a class="dropdown-item" href="/user/order/history">Histórico de Pedidos</a></li>
                              <li><a class="dropdown-item" href="/user/setting/payment">Pagamentos</a></li>
                          </ul>
                      </li>
                  @endif

                  <!-- Item Perfil com Nome do Usuário -->
                  <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle {{ request()->is('profile') ? 'active' : '' }}" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                          <i class="fas fa-user-circle me-1"></i> {{ auth()->user()->name }}
                      </a>
                      <ul class="dropdown-menu dropdown-menu-dark">
                          <li><a class="dropdown-item" href="/profile">Meu Perfil</a></li>
                          <li><hr class="dropdown-divider"></li>
                          <li>
                              <a class="dropdown-item text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                  <i class="fas fa-sign-out-alt me-1"></i> Sair
                              </a>
                              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                  @csrf
                              </form>
                          </li>
                      </ul>
                  </li>
              @else
                  <!-- Item Login -->
                  <li class="nav-item">
                      <a class="nav-link {{ request()->is('login') ? 'active' : '' }}" href="{{ route('login') }}">
                          <i class="fas fa-sign-in-alt me-1"></i> Login
                      </a>
                  </li>

                  <!-- Item Registrar -->
                  <li class="nav-item">
                      <a class="nav-link {{ request()->is('register') ? 'active' : '' }}" href="{{ route('register') }}">
                          <i class="fas fa-user-plus me-1"></i> Registrar
                      </a>
                  </li>
              @endauth

              <!-- Toggle Tema Escuro/Claro -->
              <li class="nav-item">
                  <button class="btn btn-outline-light ms-2 theme-toggle" id="themeToggle">
                      <i class="fas fa-moon"></i> Tema Escuro
                  </button>
              </li>
          </ul>
      </div>
  </div>
</nav>

<!-- CSS Personalizado -->
<style>
  /* Gradiente personalizado para o fundo da navbar */
  .bg-gradient-custom {
      background: linear-gradient(90deg, #2c3e50, #3498db);
  }

  /* Animação do ícone da marca */
  .animate-spin {
      animation: spin 2s linear infinite;
  }
  @keyframes spin {
      from { transform: rotate(0deg); }
      to { transform: rotate(360deg); }
  }

  /* Estilização da marca */
  .navbar-brand {
      font-weight: bold;
      font-size: 1.8rem;
      color: #ffffff !important;
      transition: transform 0.3s ease;
  }
  .navbar-brand:hover {
      transform: scale(1.1);
  }

  /* Links da navegação */
  .nav-link {
      color: #ffffff !important;
      font-weight: 500;
      padding: 0.5rem 1rem;
      transition: all 0.3s ease;
  }
  .nav-link:hover, .nav-link.active {
      color: #f1c40f !important; /* Amarelo suave para destaque */
      background-color: rgba(255, 255, 255, 0.1);
      border-radius: 5px;
  }

  /* Barra de pesquisa */
  .search-input {
      border-radius: 20px;
      transition: width 0.3s ease;
  }
  .search-input:focus {
      width: 200px;
      box-shadow: 0 0 10px rgba(52, 152, 219, 0.5);
  }

  /* Dropdown */
  .dropdown-menu {
      background-color: #2c3e50;
      border: none;
      border-radius: 5px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
  }
  .dropdown-item {
      color: #ffffff;
      transition: background-color 0.3s ease;
  }
  .dropdown-item:hover {
      background-color: #34495e;
      color: #f1c40f;
  }

  /* Botão de tema */
  .theme-toggle {
      border-radius: 20px;
      padding: 0.25rem 0.75rem;
      transition: all 0.3s ease;
  }
  .theme-toggle:hover {
      background-color: #f1c40f;
      color: #2c3e50;
  }

  /* Tema Escuro/Claro */
  [data-bs-theme="dark"] .bg-gradient-custom {
      background: linear-gradient(90deg, #1a252f, #1e87f0);
  }
  [data-bs-theme="dark"] .navbar-brand,
  [data-bs-theme="dark"] .nav-link,
  [data-bs-theme="dark"] .btn-outline-light {
      color: #e0e0e0 !important;
  }
  [data-bs-theme="dark"] .dropdown-menu {
      background-color: #1a252f;
  }
</style>

<!-- JavaScript para Toggle de Tema -->
<script>
  document.getElementById('themeToggle').addEventListener('click', function() {
      const body = document.body;
      const isDark = body.getAttribute('data-bs-theme') === 'dark';
      body.setAttribute('data-bs-theme', isDark ? 'light' : 'dark');
      this.innerHTML = isDark ? '<i class="fas fa-moon"></i> Tema Escuro' : '<i class="fas fa-sun"></i> Tema Claro';
  });
</script>

<!-- Adicionar Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
