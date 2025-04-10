@extends('admin.layouts.layout')
@section('admin_page_title')
    Dashboard - Admin Panel
@endsection
@section('admin_layout')
    <div class="container mt-4">
        <h3 class="mb-4 text-center text-white">Admin Dashboard</h3>

        <!-- Cards com Métricas -->
        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="card text-white bg-gradient-primary dashboard-card">
                    <div class="card-header">Administradores</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $numAdmins }}</h5>
                        <i class="fas fa-user-shield"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card text-white bg-gradient-success dashboard-card">
                    <div class="card-header">Vendedores</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $numVendors }}</h5>
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card text-white bg-gradient-info dashboard-card">
                    <div class="card-header">Clientes</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $numCustomers }}</h5>
                        <i class="fas fa-user"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card text-white bg-gradient-secondary dashboard-card">
                    <div class="card-header">Produtos</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $numProducts }}</h5>
                        <i class="fas fa-box"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="card text-white bg-gradient-warning dashboard-card">
                    <div class="card-header">Valor Total dos Produtos</div>
                    <div class="card-body">
                        <h5 class="card-title">€ {{ number_format($totalProductValue, 2, ',', '.') }}</h5>
                        <i class="fas fa-euro-sign"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card text-white bg-gradient-danger dashboard-card">
                    <div class="card-header">Total de Agendamentos</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $numAgendamentos }}</h5>
                        <i class="fas fa-calendar-check"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card text-white bg-gradient-dark dashboard-card">
                    <div class="card-header">Total de Pedidos</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $numOrders }}</h5>
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráficos -->
        <div class="row">
            <div class="col-md-6">
                <div class="chart-container">
                    <h4>Distribuição de Usuários</h4>
                    <div class="chart-wrapper">
                        <canvas id="userDistributionChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="chart-container">
                    <h4>Agendamentos por Mês</h4>
                    <div class="chart-wrapper">
                        <canvas id="agendamentosChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Ajuste para garantir que os gráficos tenham o mesmo tamanho */
        .chart-container {
            background: #1a1a1a !important;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(255, 255, 255, 0.05) !important;
            margin-bottom: 20px;
        }

        .chart-wrapper {
            position: relative;
            width: 100%;
            height: 400px; /* Altura fixa para  os gráficos */
        }

        .chart-wrapper canvas {
            width: 100% !important;
            height: 100% !important;
        }
    </style>

    <!-- Scripts para Gráficos -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Gráfico de Pizza - Distribuição de Usuários
        var ctxPie = document.getElementById('userDistributionChart').getContext('2d');
        var userDistributionChart = new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: {!! json_encode(array_keys($userDistribution)) !!},
                datasets: [{
                    data: {!! json_encode(array_values($userDistribution)) !!},
                    backgroundColor: ['#007bff', '#28a745', '#17a2b8'],
                    borderColor: '#fff',
                    borderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // Permite que o gráfico se ajuste ao contêiner
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            font: {
                                size: 14,
                            },
                            color: '#fff',
                        },
                    },
                    tooltip: {
                        backgroundColor: '#333',
                        titleFont: { size: 14 },
                        bodyFont: { size: 12 },
                        titleColor: '#fff',
                        bodyColor: '#fff',
                    },
                },
            }
        });

        // Gráfico de Barras - Agendamentos por Mês
        var ctxBar = document.getElementById('agendamentosChart').getContext('2d');
        var agendamentosChart = new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: {!! json_encode($meses) !!},
                datasets: [{
                    label: 'Agendamentos',
                    data: {!! json_encode($agendamentosData) !!},
                    backgroundColor: 'rgba(220, 53, 69, 0.7)',
                    borderColor: '#dc3545',
                    borderWidth: 1,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, // Permite que o gráfico se ajuste ao contêiner
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(255, 255, 255, 0.1)',
                        },
                        ticks: {
                            color: '#fff',
                            font: {
                                size: 12,
                            },
                        },
                    },
                    x: {
                        grid: {
                            display: false,
                        },
                        ticks: {
                            color: '#fff',
                            font: {
                                size: 12,
                            },
                        },
                    },
                },
                plugins: {
                    legend: {
                        labels: {
                            font: {
                                size: 14,
                            },
                            color: '#fff',
                        },
                    },
                    tooltip: {
                        backgroundColor: '#333',
                        titleFont: { size: 14 },
                        bodyFont: { size: 12 },
                        titleColor: '#fff',
                        bodyColor: '#fff',
                    },
                },
            }
        });
    </script>
@endsection
