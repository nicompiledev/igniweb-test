<x-guest-layout>
    <!-- Estado de la sesión -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Texto de bienvenida mejorado -->
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-4">
        Welcome Back to the Book Reservation App!
    </h2>
    <p class="text-center text-gray-600 mb-6">
        Discover and reserve your favorite books with ease. <br/>
        Log in to get started!
    </p>

    <!-- Formulario de inicio de sesión -->
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Campo de Usuario o Correo -->
        <div>
            <x-input-label for="username" :value="__('Username or Email')" />
            <x-text-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')" required autofocus />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        <!-- Campo de Contraseña -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Script para mostrar/ocultar la contraseña -->
        <script>
            function togglePasswordVisibility() {
                var passwordInput = document.getElementById("password");
                if (passwordInput.type === "password") {
                    passwordInput.type = "text";
                } else {
                    passwordInput.type = "password";
                }
            }
        </script>

        <!-- Opciones adicionales: Recordar contraseña y mostrar contraseña -->
        <div class="block mt-4 flex justify-between items-center">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>

            <div class="flex items-center">
                <input type="checkbox" id="togglePassword" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" onclick="togglePasswordVisibility()">
                <label for="togglePassword" class="text-sm text-gray-600 ms-2">{{ __('Show Password') }}</label>
            </div>
        </div>

        <!-- Enlace de registro -->
        <div class="mt-4 text-center">
            <p class="text-sm text-gray-600">
                {{ __("Don't have an account yet?") }}
                <a href="{{ route('register') }}" class="underline text-indigo-600 hover:text-indigo-900">
                    {{ __('Sign up here') }}
                </a>
            </p>
        </div>

        <!-- Botón de inicio de sesión y enlace de recuperación de contraseña -->
        <div class="flex items-center justify-end mt-6">
            @if (Route::has('password.request'))
                <a class="underline text-indigo-600 hover:text-indigo-900 me-4" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

        
            <x-primary-button class="ms-4">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
