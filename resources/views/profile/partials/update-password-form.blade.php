<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
            <div class="flex items-center mt-2">
                <input type="checkbox" id="toggleCurrentPassword" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" onclick="togglePasswordVisibility('update_password_current_password')">
                <label for="toggleCurrentPassword" class="text-sm text-gray-600 ms-2">{{ __('Show Password') }}</label>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('New Password')" />
            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <div class="flex items-center mt-2">
                <input type="checkbox" id="toggleNewPassword" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" onclick="togglePasswordVisibility('update_password_password')">
                <label for="toggleNewPassword" class="text-sm text-gray-600 ms-2">{{ __('Show Password') }}</label>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <div class="flex items-center mt-2">
                <input type="checkbox" id="togglePasswordConfirmation" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" onclick="togglePasswordVisibility('update_password_password_confirmation')">
                <label for="togglePasswordConfirmation" class="text-sm text-gray-600 ms-2">{{ __('Show Password') }}</label>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>

    <script>
        function togglePasswordVisibility(fieldId) {
            var passwordInput = document.getElementById(fieldId);
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
            } else {
                passwordInput.type = "password";
            }
        }
    </script>
</section>
