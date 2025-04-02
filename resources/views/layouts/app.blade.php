<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tech Care')</title>

    <!-- Bootstrap 5 CSS (atualizado para a mesma versão de welcome.blade.php) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome (adicionado para ícones na navbar) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- AOS CSS (mantido para animações) -->
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
    <!-- Incluir a navbar parcial (removida a navbar duplicada) -->
    @include('layouts.partials.navbar')

    <!-- Conteúdo Dinâmico -->
    <div class="container mt-5 mb-5">
        @yield('content')
    </div>

    <!-- Rodapé -->
    <footer>
        © {{ date('Y') }} Tech Care - Todos os direitos reservados.
    </footer>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <!-- Bootstrap 5 JS (atualizado para a mesma versão de welcome.blade.php) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS JS (mantido para animações) -->
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
