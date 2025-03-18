<!-- resources/views/layouts/partials/navbar.blade.php -->
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
  <div class="container-fluid">
      <a class="navbar-brand" href="/">Tech Care</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
              <li class="nav-item">
                  <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">Home</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link {{ request()->is('catalogo') ? 'active' : '' }}" href="/catalogo">Catálogo</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link {{ request()->is('agendamento*') ? 'active' : '' }}" href="/agendamento">Agendamento</a>
              </li>
              @auth
                  <li class="nav-item">
                      <a class="nav-link {{ request()->is('profile') ? 'active' : '' }}" href="/profile">Perfil</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sair</a>
                      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                          @csrf
                      </form>
                  </li>
              @else
                  <li class="nav-item">
                      <a class="nav-link {{ request()->is('login') ? 'active' : '' }}" href="{{ route('login') }}">Login</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link {{ request()->is('register') ? 'active' : '' }}" href="{{ route('register') }}">Registrar</a>
                  </li>
              @endauth
          </ul>
      </div>
  </div>
</nav>
