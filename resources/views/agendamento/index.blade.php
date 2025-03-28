<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Agendamentos</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- FullCalendar -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            background-color: #000;
            color: #ddd;
        }
        .container {
            background-color: #111;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }
        .btn {
            border-radius: 10px;
        }
        .btn-primary { background-color: #28a745; border: none; }
        .btn-primary:hover { background-color: #218838; }
        .btn-secondary { background-color: #555; border: none; }
        .btn-secondary:hover { background-color: #444; }
        .btn-danger { background-color: #dc3545; border: none; }
        .btn-danger:hover { background-color: #c82333; }
        table {
            background-color: #222;
            color: #ddd;
        }
        th, td {
            border: 1px solid #444;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #333;
        }
        .calendar-container {
            background-color: #222;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }
        /* Ajuste das cores do calendário */
        .fc-daygrid-day-number, .fc-event-title, .fc-col-header-cell-cushion {
            color: white !important;
        }
    </style>
</head>
<body>
    @include('layouts.partials.navbar')
    
    <div class="container mt-5">
        <h1 class="text-center text-success">Lista de Agendamentos</h1>

        <div class="text-center my-3">
            <button onclick="calendar.changeView('dayGridMonth')" class="btn btn-primary">Mensal</button>
            <button onclick="calendar.changeView('timeGridWeek')" class="btn btn-secondary">Semanal</button>
            <button onclick="calendar.changeView('timeGridDay')" class="btn btn-danger">Diário</button>
        </div>

        <div class="calendar-container mb-4">
            <div id="calendar"></div>
        </div>

        <h2 class="text-success">Agendamentos Recentes</h2>
        <div class="table-responsive">
            <table class="table table-dark table-bordered">
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Data</th>
                        <th>Hora</th>
                        <th>Serviço</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($agendamentos as $agendamento)
                        <tr>
                            <td>{{ $agendamento->nome_cliente }}</td>
                            <td>{{ \Carbon\Carbon::parse($agendamento->data)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($agendamento->hora)->format('H:i') }}</td>
                            <td>{{ $agendamento->servico }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <footer class="text-center text-light mt-5 p-3 bg-dark">
        © {{ date('Y') }} Tech Care - Todos os direitos reservados.
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            window.calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: '{{ route('agendamento.json') }}',
                slotMinTime: '09:00:00',
                slotMaxTime: '19:00:00',
                allDaySlot: false,
                eventClick: function(info) {
                    Swal.fire({
                        title: 'Detalhes do Agendamento',
                        html: `<strong>Cliente:</strong> ${info.event.extendedProps.description} <br>
                               <strong>Serviço:</strong> ${info.event.title}`,
                        icon: 'info',
                        confirmButtonText: 'OK'
                    });
                },
                businessHours: {
                    daysOfWeek: [1, 2, 3, 4, 5],
                    startTime: '09:00',
                    endTime: '19:00'
                },
                hiddenDays: [0, 6],
            });
            calendar.render();
        });
    </script>
</body>
</html>
