@extends('layouts.app')

@section('content')
<div class="container">
    <h2>O Meu Perfil</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Formulário para Atualizar o Perfil -->
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Nome</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="mb-3">
            <label>Número de Telefone</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
            @error('phone')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Foto de Perfil</label>
            <input type="file" name="profile_photo" class="form-control">
            @if($user->profile_photo)
                <img src="{{ asset('storage/' . $user->profile_photo) }}" class="mt-2" width="100">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Atualizar Perfil</button>
    </form>

    <hr>

    <h3>Alterar Senha</h3>
    <!-- Formulário para Alterar a Senha -->
    <form action="{{ route('profile.password') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Senha Atual</label>
            <input type="password" name="current_password" class="form-control" required>
            @error('current_password')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Nova Senha</label>
            <input type="password" name="new_password" class="form-control" required>
            @error('new_password')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label>Confirmar Nova Senha</label>
            <input type="password" name="new_password_confirmation" class="form-control" required>
            @error('new_password_confirmation')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-danger">Alterar Senha</button>
    </form>
</div>
@endsection
