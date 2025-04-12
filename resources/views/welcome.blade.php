<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tech Care</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        body {
            background-color: #000;
            color: #ddd;
            padding-top: 70px; /* altura do navbar fixo */
        }

        footer {
            background-color: #111;
            color: #bbb;
            text-align: center;
            padding: 15px 0;
            margin-top: 60px;
        }

        .features {
            text-align: center;
            margin: 80px 0;
        }

        .features h2 {
            color: #fff;
            font-size: 2.5rem;
            margin-bottom: 40px;
            text-shadow: 0 2px 4px rgba(255,255,255,0.1);
        }

        .features .feature-item {
            background-color: #1a1a1a;
            color: #fff;
            border-radius: 12px;
            padding: 30px 20px;
            box-shadow: 0 4px 12px rgba(255,255,255,0.05);
            transition: transform 0.3s ease-in-out;
            margin-bottom: 30px;
            max-width: 300px;
            width: 100%;
        }

        .features .feature-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 20px rgba(0, 255, 100, 0.3);
        }

        .features .feature-item i {
            font-size: 48px;
            color: #0dcaf0;
            margin-bottom: 15px;
        }

        .banner {
            position: relative;
            width: 100%;
            overflow: hidden;
        }

        .banner img {
            width: 100%;
            max-height: 600px;
            object-fit: cover;
        }

        .banner-button {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            padding: 15px 30px;
            background-color: #0dcaf0;
            color: #000;
            font-weight: bold;
            font-size: 1.2rem;
            border: none;
            border-radius: 30px;
            text-transform: uppercase;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(0, 255, 255, 0.3);
        }

        .banner-button:hover {
            background-color: #28a745;
            color: #fff;
        }

        .techicon-logo {
            height: 100vh;
            width: 100%;
            background-image: url('{{ asset('admin_asset/img/techicon.png') }}');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center center;
            background-color: #000;
            opacity: 0;
            animation: fadeIn 2s ease-out forwards;
        }

        .techicon-logo img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(30px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            .banner-button {
                font-size: 1rem;
                padding: 12px 25px;
            }
            .features .feature-item {
                width: 100%;
            }
        }

        @media (max-width: 576px) {
            .features h2 {
                font-size: 2rem;
            }
            .features .feature-item {
                padding: 20px 15px;
            }
        }
        @media (max-width: 400px) {
            .banner-button {
                font-size: 0.9rem;
                padding: 10px 20px;
            }
        }
        @media (max-width: 768px) {
            .banner img {
                max-height: 400px;
            }
        }
    </style>

    @livewireStyles
</head>
<body>
    @include('layouts.partials.navbar')

    <div class="techicon-logo"></div>

    <div class="banner">
        <img src="{{ asset('admin_asset/img/banner2.png') }}" alt="Banner da Loja">
        <a href="{{ auth()->check() ? route('agendamento.create') : route('login') }}" class="banner-button">Agendar Agora</a>
    </div>

    <div class="container features">
        <h2>Porque Escolher-nos?</h2>
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="feature-item text-center">
                    <i class="fas fa-tools"></i>
                    <h4>Melhores Técnicos</h4>
                    <p>Profissionais altamente qualificados prontos para ajudar.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-item text-center">
                    <i class="fas fa-users"></i>
                    <h4>+1 Milhão de Clientes</h4>
                    <p>Temos uma base de clientes fiel e satisfeita com nossos serviços.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-item text-center">
                    <i class="fas fa-map-marker-alt"></i>
                    <h4>Número 1 no Norte</h4>
                    <p>Nosso serviço é o mais procurado na região norte.</p>
                </div>
            </div>
        </div>
    </div>
    <style>
.features {
    text-align: center;
    margin: 80px auto;
    max-width: 1200px;
}

.feature-item {
    margin: 0 auto;
    max-width: 300px;
}
    </style>



    <footer>
        © {{ date('Y') }} Tech Care - Todos os direitos reservados.
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @livewireScripts
</body>
</html>
