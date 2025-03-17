<div class="register-container">
    <!-- Logo no topo -->
    <a href="{{ url('/') }}">
        <img src="{{ asset('admin_asset/img/techcare.png') }}" alt="TechCare Logo" class="logo">
    </a>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="input-group">
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="register-input" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="input-group">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="register-input" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="input-group">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="register-input" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="input-group">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="register-input" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Already Registered & Register Button -->
        <div class="options-container">
            <a class="forgot-password" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>
        </div>

        <div class="button-container">
            <x-primary-button class="register-button">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</div>

<style>
    /* Reset de estilos padrão */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* Fundo da página */
    body {
        background-image: url('{{ asset('admin_asset/img/background.jpg') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        color: #fff;
        font-family: 'Roboto', sans-serif;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0;
    }

    /* Container do formulário */
    .register-container {
        background: none;
        color: #fff;
        padding: 40px;
        border-radius: 12px;
        width: 100%;
        max-width: 420px;
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.3);
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    /* Logo */
    .logo {
        width: 120px; /* Ajuste conforme necessário */
        margin-bottom: 20px;
        cursor: pointer;
        transition: transform 0.3s;
    }

    .logo:hover {
        transform: scale(1.1);
    }

    /* Inputs */
    .register-input {
        background-color: rgba(51, 51, 51, 0.7);
        color: #fff;
        border: 1px solid rgba(255, 255, 255, 0.5);
        padding: 12px;
        border-radius: 8px;
        width: 100%;
        font-size: 16px;
        transition: all 0.3s ease;
    }

    .register-input:focus {
        border-color: #28a745;
        outline: none;
        box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.25);
    }

    /* Estilo para os grupos de entrada */
    .input-group {
        width: 100%;
        margin-bottom: 20px;
    }

    /* Opções de "Already registered?" */
    .options-container {
        width: 100%;
        text-align: right;
        margin-bottom: 20px;
    }

    .forgot-password {
        font-size: 14px;
        color: #ccc;
        text-decoration: none;
        transition: color 0.3s ease-in-out;
    }

    .forgot-password:hover {
        color: #fff;
    }

    /* Botão de registro */
    .button-container {
        width: 100%;
    }

    .register-button {
        background-color: rgb(71, 75, 72);
        color: white;
        padding: 12px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        width: 100%;
        font-size: 16px;
        transition: background-color 0.3s, transform 0.3s;
    }

    .register-button:hover {
        background-color: #218838;
        transform: translateY(-2px);
    }

    .register-button:active {
        transform: translateY(1px);
    }

    .logo {
    width: 120px;
    margin-bottom: 20px;
    cursor: pointer;
    transition: transform 0.3s;
}

.logo:hover {
    transform: scale(1.1);
}
</style>
