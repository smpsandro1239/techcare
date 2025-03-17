<div class="login-container">
    <!-- Logo no topo -->
    <a href="{{ url('/') }}">
        <img src="{{ asset('admin_asset/img/techcare.png') }}" alt="TechCare Logo" class="logo">
    </a>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="input-group">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="login-input" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="input-group">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="login-input" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="options-container">
            <label for="remember_me" class="remember-me">
                <input id="remember_me" type="checkbox" class="checkbox" name="remember">
                <span>{{ __('Remember me') }}</span>
            </label>
            @if (Route::has('password.request'))
                <a class="forgot-password" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <!-- Login Button -->
        <div class="button-container">
            <x-primary-button class="login-button">
                {{ __('Log in') }}
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

    /* Fundo da página com imagem */
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

    /* Estilos do formulário */
    .login-container {
        background: none; /* Fundo transparente */
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
    .login-input {
        background-color: rgba(51, 51, 51, 0.7);
        color: #fff;
        border: 1px solid rgba(255, 255, 255, 0.5);
        padding: 12px;
        border-radius: 8px;
        width: 100%;
        font-size: 16px;
        transition: all 0.3s ease;
    }

    .login-input:focus {
        border-color: #28a745;
        outline: none;
        box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.25);
    }

    /* Estilo para os grupos de entrada */
    .input-group {
        width: 100%;
        margin-bottom: 20px;
    }

    /* Opções de lembrar senha e esqueci senha */
    .options-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        margin-bottom: 20px;
    }

    .remember-me {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
    }

    .checkbox {
        appearance: none;
        width: 16px;
        height: 16px;
        border: 2px solid #fff;
        border-radius: 4px;
        position: relative;
        cursor: pointer;
    }

    .checkbox:checked::before {
        content: "✔";
        color: #28a745;
        font-size: 12px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    /* Link "Forgot Password?" */
    .forgot-password {
        font-size: 14px;
        color: #ccc;
        text-decoration: none;
        transition: color 0.3s ease-in-out;
    }

    .forgot-password:hover {
        color: #fff;
    }

    /* Botão de login */
    .button-container {
        width: 100%;
    }

    .login-button {
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

    .login-button:hover {
        background-color: #218838;
        transform: translateY(-2px);
    }

    .login-button:active {
        transform: translateY(1px);
    }
</style>
