<form method="POST" action="{{ route('admin.agendamento.store') }}">
    @csrf
    <div>
        <label>Nome do Cliente</label>
        <input type="text" name="nome_cliente" value="{{ old('nome_cliente') }}" required>
        @error('nome_cliente') <span>{{ $message }}</span> @enderror
    </div>
    <div>
        <label>Data</label>
        <input type="date" name="data" value="{{ old('data') }}" required>
        @error('data') <span>{{ $message }}</span> @enderror
    </div>
    <div>
        <label>Hora</label>
        <input type="time" name="hora" value="{{ old('hora') }}" required>
        @error('hora') <span>{{ $message }}</span> @enderror
    </div>
    <div>
        <label>Serviço</label>
        <input type="text" name="servico" value="{{ old('servico') }}" required>
        @error('servico') <span>{{ $message }}</span> @enderror
    </div>
    <button type="submit">Agendar</button>
</form>

@if (session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif
@if (session('error'))
    <p style="color: red;">{{ session('error') }}</p>
@endif
