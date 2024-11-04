<section class="mt-15">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __('Update your profile information.') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-12" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- Contenedor flex para centrar las columnas horizontalmente -->
        <div class="flex justify-center space-x-8 mt-8">
            <!-- Columna para la imagen de perfil -->
            <!-- Columna para la imagen de perfil -->
<div class="flex flex-col items-center">
    <x-input-label for="profile_image" :value="__('Profile Image')" class="text-center mb-2" />

    @if ($user->profile_image)
        <!-- Mostrar la imagen de perfil actual -->
        <div class="mb-4">
            <img
                src="{{ asset('storage/' . $user->profile_image) }}"
                alt="Current Profile Image"
                class="h-32 w-32 object-cover rounded-full"
            >
        </div>

        <!-- Botón para eliminar la imagen de perfil -->
        <button
            type="submit"
            name="remove_profile_image"
            value="1"
            class="text-red-600 hover:text-red-900 mb-4"
        >
            {{ __('Remove Profile Image') }}
        </button>
    @endif

    <!-- Campo para subir una nueva imagen de perfil -->
    <div class="w-32"> <!-- Fija el ancho para alinear con la imagen -->
        <input
            type="file"
            id="profile_image"
            name="profile_image"
            class="block"
            accept="image/*"
        />
    </div>
    <x-input-error class="mt-2" :messages="$errors->get('profile_image')" />
</div>

            <!-- Columna para campos de texto -->
            <div class="space-y-6 max-w-md">
                <!-- Campo para el nombre de usuario -->
                <div>
                    <x-input-label for="username" :value="__('Username')" />
                    <x-text-input
                        id="username"
                        name="username"
                        type="text"
                        class="mt-1 block w-full"
                        :value="old('username', $user->username)"
                        required
                        autofocus
                        autocomplete="username"
                    />
                    <x-input-error class="mt-2" :messages="$errors->get('username')" />
                </div>

                <!-- Campo para el correo electrónico -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input
                        id="email"
                        name="email"
                        type="email"
                        class="mt-1 block w-full"
                        :value="old('email', $user->email)"
                        required
                        autocomplete="email"
                    />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                </div>
            </div>
        </div>

        <!-- Botón de guardar cambios -->
        <div class="flex items-center gap-4 mt-6">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
        </div>
    </form>
</section>
