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
            events: '{{ route('agendamentos.json') }}',
            slotMinTime: '09:00:00', // Início do horário laboral
            slotMaxTime: '19:00:00', // Fim do horário laboral
            slotDuration: '00:30:00', // Intervalos de 30 minutos na visão diária
            allDaySlot: false, // Remove a seção "all day"
            eventClick: function(info) {
                alert('Cliente: ' + info.event.extendedProps.description + '\nServiço: ' + info.event.title);
            },
            businessHours: {
                daysOfWeek: [1, 2, 3, 4, 5], // Segunda a sexta
                startTime: '09:00',
                endTime: '19:00'
            },
            hiddenDays: [0, 6], // Esconde sábado e domingo
        });
        calendar.render();
    });
</script>

<!-- Tabela de agendamentos (opcional, pode remover se preferir só o calendário) -->
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
