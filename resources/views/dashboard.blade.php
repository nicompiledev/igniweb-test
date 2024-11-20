<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Activity') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center mb-4">
                        <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : asset('images/default-user.png') }}"
                            alt="Profile Image" class="h-16 w-16 rounded-full object-cover mr-4" />
                        <div>
                            <h3 class="font-semibold text-lg">{{ __('Welcome, ') . $user->username }}</h3>
                            <p class="text-sm text-gray-600">{{ __('Total Reservations: ') . $reservations->count() }}</p>
                        </div>
                    </div>

                    <h4 class="mt-4 font-semibold">{{ __('Active Reservations') }}</h4>
                    @if($reservations->isEmpty())
                        <p>{{ __('You have no active reservations.') }}</p>
                    @else
                        <!-- Contenedor para desplazar horizontalmente -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Title') }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Author') }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Category') }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Start Date') }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('End Date') }}</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($reservations as $reservation)
                                        <tr id="reservation-{{ $reservation->id }}">
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $reservation->book->title ?? 'No Title' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $reservation->book->author ?? 'Unknown Author' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $reservation->book->category ?? 'Unknown Category' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $reservation->start_date ? \Carbon\Carbon::parse($reservation->start_date)->format('Y-m-d') : 'N/A' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $reservation->end_date ? \Carbon\Carbon::parse($reservation->end_date)->format('Y-m-d') : 'N/A' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <button type="button" class="text-red-600 hover:text-red-900" onclick="openModal({{ $reservation->id }})">
                                                    {{ __('Delete') }}
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div id="confirmation-modal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-gray-800 bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg max-w-full sm:w-1/3 w-4/5 p-6">
            <h3 class="text-lg font-semibold text-gray-800">{{ __('Confirm Deletion') }}</h3>
            <p class="mt-2 text-gray-600">{{ __('Are you sure you want to delete this reservation? This action cannot be undone.') }}</p>
            <div class="mt-4 flex justify-between sm:justify-end space-x-4">
                <button id="cancel-button" class="w-full sm:w-auto px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400" onclick="closeModal()">
                    {{ __('Cancel') }}
                </button>
                <button id="confirm-button" class="w-full sm:w-auto px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                    {{ __('Delete') }}
                </button>
            </div>
        </div>
    </div>

    <script>
        let currentReservationId = null;

        function openModal(reservationId) {
            currentReservationId = reservationId;
            document.getElementById('confirmation-modal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('confirmation-modal').classList.add('hidden');
        }

        document.getElementById('confirm-button').addEventListener('click', function() {
            if (currentReservationId) {
                fetch(`/reservations/${currentReservationId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (response.ok) {
                        document.getElementById(`reservation-${currentReservationId}`).remove();
                        const totalReservationsElement = document.querySelector('p.text-gray-600');
                        const currentTotal = parseInt(totalReservationsElement.textContent.match(/\d+/)[0]);
                        totalReservationsElement.textContent = `Total Reservations: ${currentTotal - 1}`;
                        closeModal();
                    } else {
                        alert("{{ __('An error occurred while deleting the reservation.') }}");
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert("{{ __('An error occurred while deleting the reservation.') }}");
                });
            }
        });
    </script>
</x-app-layout>
