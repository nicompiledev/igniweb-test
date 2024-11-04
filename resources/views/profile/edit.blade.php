<x-app-layout>
    <x-slot name="header">
        <div class="p-2 sm:p-4 flex flex-col items-start">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                {{ __('Profile') }}
            </h2>
            <div class="flex space-x-4">
                <button id="profile-tab" class="tab-button active" onclick="showSection('profile')">
                    {{ __('Update Profile Information') }}
                </button>
                <button id="password-tab" class="tab-button" onclick="showSection('password')">
                    {{ __('Change Password') }}
                </button>
                <button id="delete-tab" class="tab-button" onclick="showSection('delete')">
                    {{ __('Delete Account') }}
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            <!-- Profile Information Section -->
            <div id="profile" class="tab-section p-4 sm:p-6 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Change Password Section -->
            <div id="password" class="tab-section hidden p-4 sm:p-6 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete Account Section -->
            <div id="delete" class="tab-section hidden p-4 sm:p-6 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>

    <script>
        // Function to show the selected tab section
        function showSection(section) {
            // Hide all sections
            const sections = document.querySelectorAll('.tab-section');
            sections.forEach(sec => sec.classList.add('hidden'));

            // Remove active class from all tab buttons
            const tabButtons = document.querySelectorAll('.tab-button');
            tabButtons.forEach(btn => btn.classList.remove('active'));

            // Show the selected section and set the active tab
            document.getElementById(section).classList.remove('hidden');
            document.getElementById(section + '-tab').classList.add('active');
        }

        // Show the profile section by default
        showSection('profile');

        document.addEventListener('DOMContentLoaded', function() {
        // Recuperar la pestaña activa desde localStorage
        const activeTab = localStorage.getItem('activeTab');
        if (activeTab) {
            document.getElementById(activeTab).click();
        }

        // Guardar la pestaña activa en localStorage al cambiar de pestaña
        document.querySelectorAll('.tab-button').forEach(button => {
            button.addEventListener('click', function() {
                localStorage.setItem('activeTab', this.id);
            });
        });
    });
    </script>

    <style>
        /* Custom styles for the tabs */
        .tab-button {
            padding: 5px 15px;
            border: none;
            background: transparent;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .tab-button:hover {
            background: rgba(0, 0, 0, 0.1);
        }
        .tab-button.active {
            font-weight: bold;
            border-bottom: 2px solid #4a5568; /* Tailwind's gray-700 */
        }
    </style>
</x-app-layout>
