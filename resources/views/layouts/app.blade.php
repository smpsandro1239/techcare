<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tech Care')</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.1/dist/aos.css" rel="stylesheet">

    
    <style>
        /* Estilo geral do site */
        body {
            background-color: #000; /* Fundo ainda mais escuro */
            color: #ddd; /* Texto mais claro para contraste */
        }

        /* Navbar extremamente escura */
        .navbar {
            background-color: #111 !important; 
        }

        .navbar a {
            color: #bbb !important; /* Cinza claro para melhor contraste */
        }

        .navbar a:hover {
            color: #28a745 !important; /* Verde para hover */
        }

        /* Input de busca */
        .form-control {
            background-color: #333;
            color: white;
            border: 1px solid #555;
        }

        /* Botão de busca */
        .btn-outline-success {
            border-color: #28a745;
            color: #28a745;
        }

        .btn-outline-success:hover {
            background-color: #28a745;
            color: white;
        }

        /* Rodapé */
        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #111; /* Fundo ainda mais escuro */
            color: #bbb; /* Texto cinza claro */
            text-align: center;
            padding: 10px 0;
        }
    </style>

    @livewireStyles
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand text-success" href="{{ url('/') }}">Tech Care</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mx-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/') }}">Início</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('catalogo') }}">Catálogo</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.agendamento.create') }}">Agende sua Reparação</a>
            </li>
        </ul>
        <form class="form-inline mx-auto" action="{{ route('product.procurar') }}" method="GET">
    <input class="form-control mr-sm-2" type="search" placeholder="Procurar" name="search" aria-label="Search">
    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Procurar</button>
</form>

    </div>
</nav>

<!-- Conteúdo Dinâmico -->
<div class="container mt-5 mb-5">
    @yield('content')
</div>

<!-- Rodapé -->
<footer>
    &copy; {{ date('Y') }} Tech Care - Todos os direitos reservados.
</footer>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init({
    duration: 1000, // Duração da animação
    easing: 'ease-in-out', // Efeito de suavização
  });
</script>

@livewireScripts
</body>
</html>
