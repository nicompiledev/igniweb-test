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
                    <!-- Profile Image -->
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
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[200px] max-w-[300px]">{{ __('Title') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[150px] max-w-[250px]">{{ __('Author') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[150px] max-w-[250px]">{{ __('Category') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[150px] max-w-[250px]">{{ __('Start Date') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[150px] max-w-[250px]">{{ __('End Date') }}</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[100px] max-w-[150px]">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="reservations-table-body">
                            @foreach($reservations as $reservation)
                            <tr id="reservation-{{ $reservation->id }}">
                                <td class="px-6 py-4 whitespace-nowrap min-w-[200px] max-w-[300px] overflow-hidden overflow-ellipsis">{{ $reservation->book->title ?? 'No Title' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap min-w-[150px] max-w-[250px] overflow-hidden overflow-ellipsis">{{ $reservation->book->author ?? 'Unknown Author' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap min-w-[150px] max-w-[250px] overflow-hidden overflow-ellipsis">{{ $reservation->book->category ?? 'Unknown Category' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap min-w-[150px] max-w-[250px] overflow-hidden overflow-ellipsis">{{ $reservation->start_date ? \Carbon\Carbon::parse($reservation->start_date)->format('Y-m-d') : 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap min-w-[150px] max-w-[250px] overflow-hidden overflow-ellipsis">{{ $reservation->end_date ? \Carbon\Carbon::parse($reservation->end_date)->format('Y-m-d') : 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap min-w-[100px] max-w-[150px]">
                                    <button type="button" class="text-red-600 hover:text-red-900" onclick="openModal({{ $reservation->id }})">
                                        {{ __('Delete') }}
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="confirmation-modal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-gray-800 bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg w-1/3 p-6">
            <h3 class="text-lg font-semibold text-gray-800">{{ __('Confirm Deletion') }}</h3>
            <p class="mt-2 text-gray-600">{{ __('Are you sure you want to delete this reservation? This action cannot be undone.') }}</p>
            <div class="mt-4 flex justify-end">
                <button id="cancel-button" class="mr-2 px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400" onclick="closeModal()">{{ __('Cancel') }}</button>
                <button id="confirm-button" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700" onclick=""> {{ __('Delete') }}</button>
            </div>
        </div>
    </div>

    <script>
        let currentReservationId = null;

        function openModal(reservationId) {
            currentReservationId = reservationId; // Save the reservation ID
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
                        // Remove the table row
                        document.getElementById(`reservation-${currentReservationId}`).remove();
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
