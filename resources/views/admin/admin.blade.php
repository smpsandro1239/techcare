@extends('admin.layouts.layout')
@section('admin_page_title')
Dashboard - Admin Panel
@endsection
@section('admin_layout')
    <h3>Admin Dashboard</h3>

    <!-- Cards com Métricas -->
    <div class="row">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Administradores</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $numAdmins }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Vendedores</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $numVendors }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info mb-3">
                <div class="card-header">Clientes</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $numCustomers }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-secondary mb-3">
                <div class="card-header">Produtos</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $numProducts }}</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3">
                <div class="card-header">Valor Total dos Produtos</div>
                <div class="card-body">
                    <h5 class="card-title">€ {{ number_format($totalProductValue, 2, ',', '.') }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-danger mb-3">
                <div class="card-header">Total de Agendamentos</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $numAgendamentos }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-dark mb-3">
                <div class="card-header">Total de Pedidos</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $numOrders }}</h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficos -->
    <div class="row">
        <div class="col-md-6">
            <h4>Distribuição de Usuários</h4>
            <canvas id="userDistributionChart"></canvas>
        </div>
        <div class="col-md-6">
            <h4>Agendamentos por Mês</h4>
            <canvas id="agendamentosChart"></canvas>
        </div>
    </div>

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
                }]
            },
            options: {
                responsive: true,
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
                    backgroundColor: '#dc3545',
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
