<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lista de Agendamentos</title>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <h1>Lista de Agendamentos</h1>

    <!-- Botões para alternar entre visões -->
    <div style="margin-bottom: 20px;">
        <button onclick="calendar.changeView('dayGridMonth')">Mensal</button>
        <button onclick="calendar.changeView('timeGridWeek')">Semanal</button>
        <button onclick="calendar.changeView('timeGridDay')">Diário</button>
    </div>

    <!-- Calendário -->
    <div id="calendar"></div>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            window.calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: '{{ route('agendamento.json') }}',
                slotMinTime: '09:00:00',
                slotMaxTime: '19:00:00',
                slotDuration: '00:30:00',
                allDaySlot: false,
                eventClick: function(info) {
                    alert('Cliente: ' + info.event.extendedProps.description + '\nServiço: ' + info.event.title);
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

    <!-- Tabela de agendamentos -->
    <table>
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
                    <td>{{ $agendamento->data }}</td>
                    <td>{{ $agendamento->hora }}</td>
                    <td>{{ $agendamento->servico }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if (session('success') && session('popup'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Sucesso!',
                text: '{{ session('success') }}',
                confirmButtonText: 'OK'
            }).then(() => {
                window.history.replaceState({}, document.title, window.location.pathname);
            });
        </script>
    @endif
</body>
</html>
