<h1>Lista de Agendamentos</h1>
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

<div id="calendar"></div>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: '{{ route('agendamentos.json') }}',
            eventClick: function(info) {
                alert('Cliente: ' + info.event.extendedProps.description + '\nServiço: ' + info.event.title);
            }
        });
        calendar.render();
    });
</script>
