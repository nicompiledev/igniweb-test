@props([
    'name',
    'show' => false,
    'maxWidth' => '2xl'
])

@php
$maxWidth = [
    'sm' => 'sm:max-w-sm',
    'md' => 'sm:max-w-md',
    'lg' => 'sm:max-w-lg',
    'xl' => 'sm:max-w-xl',
    '2xl' => 'sm:max-w-2xl',
][$maxWidth];
@endphp

<div
    x-data="{ show: @js($show) }"
    x-init="
        $on('open-modal', id => {
            show = true;
            fetchBookDetails(id);
        });
        $on('close-modal', () => { show = false });
    "
    x-show="show"
    class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50"
    style="display: none;"
>
    <div class="fixed inset-0 transform transition-all" x-on:click="show = false">
        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
    </div>

    <div class="mb-6 bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:max-w-lg sm:mx-auto">
        <div class="p-6">
            <h2 class="text-lg font-bold" id="book-title"></h2>
            <h3 class="text-md" id="book-author"></h3>

            <div class="mt-4">
                <p class="font-semibold">Description:</p>
                <p id="book-description"></p>
            </div>

            <div class="mt-4">
                <img id="book-cover" class="w-32 h-auto" alt="Book Cover">
            </div>

            <div class="mt-4">
                <label for="reservation-start" class="block text-sm font-medium text-gray-700">Select Start Date:</label>
                <input type="date" id="reservation-start" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">

                <label for="reservation-end" class="block text-sm font-medium text-gray-700 mt-4">Select End Date:</label>
                <input type="date" id="reservation-end" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <div class="mt-6 flex justify-end">
                <button class="bg-blue-600 text-white px-4 py-2 rounded" x-on:click="reserveBook()">Reserve</button>
                <button class="ml-2 text-gray-600" x-on:click="$dispatch('close-modal')">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script>
    function fetchBookDetails(bookId) {
        fetch(`/books/${bookId}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('book-title').innerText = data.title;
                document.getElementById('book-author').innerText = data.author;
                document.getElementById('book-description').innerText = data.description;
                document.getElementById('book-cover').src = data.cover; // Asegúrate de que `data.cover` tenga la URL correcta
            })
            .catch(error => console.error('Error:', error));
    }

    function reserveBook() {
        const startDate = document.getElementById('reservation-start').value;
        const endDate = document.getElementById('reservation-end').value;

        // Aquí manejas la lógica para reservar el libro
        console.log('Reservando libro desde', startDate, 'hasta', endDate);
        // Puedes hacer un fetch para reservar el libro
    }
</script>
