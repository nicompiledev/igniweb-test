<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Available Books') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Container for success message -->
                    <div id="successMessage" class="hidden p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg"
                        role="alert">
                        <span class="font-medium">{{ __('Book reserved successfully!') }}</span>
                    </div>

                    <!-- Category filter and search box - Now responsive -->
                    <div class="mb-4 flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4 items-center">
                        <div class="flex items-center w-full sm:w-auto">
                            <label for="category-filter" class="mr-2 whitespace-nowrap">{{ __('Filter by Category:')
                                }}</label>
                            <select id="category-filter" class="border rounded p-2 w-full sm:w-auto">
                                <option value="all">{{ __('All') }}</option>
                                @foreach ($categories as $category)
                                <option value="{{ strtolower($category) }}">{{ ucfirst($category) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="text" id="search-box" placeholder="{{ __('Search for books...') }}"
                            class="border rounded p-2 w-full sm:w-auto">
                    </div>

                    <!-- Book table with responsive design -->
                    @if(!$books->isEmpty())
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Title') }}</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Author') }}</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Category') }}</th>
                                    <th
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($books as $book)
                                <tr>
                                    <td class="px-4 py-4 whitespace-nowrap overflow-hidden overflow-ellipsis">{{
                                        $book->title }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap overflow-hidden overflow-ellipsis">{{
                                        $book->author }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap overflow-hidden overflow-ellipsis">{{
                                        $book->category ?? 'Unknown' }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <button type="button" class="text-blue-600 hover:text-blue-900"
                                            onclick="openReservationModal('{{ $book->id }}', '{{ $book->title }}', '{{ $book->author }}', '{{ $book->description }}', '{{ $book->cover_book_url }}')">
                                            {{ __('Reserve') }}
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div id="pagination" class="flex justify-center space-x-2 mt-4">
                        {!! $books->appends(request()->query())->links() !!}
                    </div>
                    @else
                    <p class="text-center">{{ __('There are no books available at the moment.') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Reservation Modal - Now more responsive -->
    <div id="reservationModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-[95%] max-w-[600px] shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4" id="modalTitle"></h3>
                <p class="text-sm text-gray-500 mb-2" id="modalAuthor"></p>

                <!-- Error Message Container -->
                <div id="errorMessage" class="hidden p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                    <span class="font-medium" id="errorMessageText"></span>
                </div>

                <!-- Description and Cover - Now responsive flex -->
                <div class="flex flex-col sm:flex-row mb-4">
                    <div class="flex-1 mb-4 sm:mr-4 sm:mb-0">
                        <p id="modalDescription" class="text-sm text-gray-500 mb-4 overflow-hidden overflow-ellipsis"
                            style="max-height: 80px; line-clamp: 4;"></p>
                    </div>
                    <div class="flex justify-center sm:block">
                        <img id="bookCover" src="" alt="Book Cover"
                            class="w-48 h-64 sm:w-64 sm:h-80 object-cover border border-gray-200 rounded-md shadow-md">
                    </div>
                </div>

                <!-- Dates and Total Days - Now responsive grid -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="startDate">
                            {{ __('Start Date') }}
                        </label>
                        <input type="date" id="startDate"
                            class="shadow appearance-none border rounded w-full py-1 px-1 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            onchange="calculateTotalDays()">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="endDate">
                            {{ __('End Date') }}
                        </label>
                        <input type="date" id="endDate"
                            class="shadow appearance-none border rounded w-full py-1 px-1 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            onchange="calculateTotalDays()">
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="totalDays">
                            {{ __('Total Days') }}
                        </label>
                        <p id="totalDays" class="text-gray-700">0</p>
                    </div>
                </div>

                <input type="hidden" id="bookId">
                <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-2 px-4 py-3">
                    <button id="cancelButton"
                        class="px-4 py-2 bg-gray-300 text-gray-700 text-base font-medium rounded-md sm:w-24"
                        onclick="closeReservationModal()">
                        {{ __('Cancel') }}
                    </button>
                    <button id="confirmButton"
                        class="px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md sm:w-24"
                        onclick="confirmReservation()">
                        {{ __('Confirm') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('category-filter').addEventListener('change', fetchBooks);
            document.getElementById('search-box').addEventListener('keyup', fetchBooks);

            // Set minimum date as today for the dates
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('startDate').min = today;
            document.getElementById('endDate').min = today;

            // Initialize pagination
            document.getElementById('pagination').addEventListener('click', handlePagination);
        });

        function fetchBooks(page = 1, category = '', search = '') {
            if(!category) {
                category = document.getElementById('category-filter').value;
            }

            if(!search) {
                search = document.getElementById('search-box').value;
            }

            fetch(`/books/filter?category=${category}&search=${search}&page=${page}`)
                .then(response => response.json())
                .then(data => {
                    updateBookTable(data.data);
                    updatePagination(data);
                })
                .catch(error => console.error('Error:', error));
        }

        function updateBookTable(books) {
            const tbody = document.querySelector('tbody');
            tbody.innerHTML = '';

            books.forEach(book => {
                const row = document.createElement('tr');
                row.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap min-w-[200px] max-w-[300px] overflow-hidden overflow-ellipsis">${book.title}</td>
                <td class="px-6 py-4 whitespace-nowrap min-w-[150px] max-w-[250px] overflow-hidden overflow-ellipsis">${book.author}</td>
                <td class="px-6 py-4 whitespace-nowrap min-w-[150px] max-w-[250px] overflow-hidden overflow-ellipsis">${book.category || 'Unknown'}</td>
                <td class="px-6 py-4 whitespace-nowrap min-w-[100px] max-w-[150px]">
                    <button type="button" class="text-blue-600 hover:text-blue-900"
                        onclick="openReservationModal('${book.id}', '${book.title}', '${book.author}', '${book.description}', '${book.cover_book_url}')">
                        Reserve
                    </button>
                </td>
            `;
                tbody.appendChild(row);
            });

            if (books.length === 0) {
                tbody.innerHTML = `<tr><td colspan="4" class="text-center">${__('No books available at the moment.')}</td></tr>`;
            }
        }

function updatePagination(data) {
    const paginationContainer = document.getElementById('pagination');
    paginationContainer.innerHTML = data.links.map(link => {
        if (link.url === null) {

            return `<span class="px-2 py-1 text-gray-500 cursor-default">${link.label}</span>`;
        }
        const activeClass = link.active
            ? 'bg-blue-500 text-white cursor-default'
            : 'bg-gray-200 text-gray-700 hover:bg-blue-500 hover:text-white';
        return `<a href="#" data-page="${link.url.split('page=')[1]}"
                   class="px-2 py-1 rounded ${activeClass}">${link.label}</a>`;
    }).join('');


    document.querySelectorAll('#pagination a').forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const page = e.target.getAttribute('data-page');
            fetchBooks(page);
        });
    });
}




        function handlePagination(event) {
            if (event.target.classList.contains('pagination-link')) {
                const page = event.target.dataset.page;
                fetchBooks(page);
            }
        }

        function openReservationModal(id, title, author, description, coverUrl) {
            document.getElementById('modalTitle').innerText = title;
            document.getElementById('modalAuthor').innerText = `by ${author}`;
            document.getElementById('modalDescription').innerText = description;
            document.getElementById('bookCover').src = coverUrl;
            document.getElementById('bookId').value = id;
            document.getElementById('errorMessage').classList.add('hidden'); // Reset error message
            document.getElementById('successMessage').classList.add('hidden'); // Reset success message

            // Reset date and total days fields
            document.getElementById('startDate').value = '';
            document.getElementById('endDate').value = '';
            document.getElementById('totalDays').innerText = 0;

            // Show the modal
            document.getElementById('reservationModal').classList.remove('hidden');
        }

        function closeReservationModal() {
            document.getElementById('reservationModal').classList.add('hidden');
            document.getElementById('errorMessage').classList.add('hidden'); // Reset error message on close
            document.getElementById('successMessage').classList.add('hidden'); // Reset success message on close
        }

        function calculateTotalDays() {
            const startDate = new Date(document.getElementById('startDate').value);
            const endDate = new Date(document.getElementById('endDate').value);

            if (startDate && endDate && startDate <= endDate) {
                const totalDays = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24)) + 1;
                document.getElementById('totalDays').innerText = totalDays;
            } else {
                document.getElementById('totalDays').innerText = 0;
            }
        }

        function confirmReservation() {
            const bookId = document.getElementById('bookId').value;
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;

            fetch(`/books/${bookId}/reserve`, { // Change the URL here
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ start_date: startDate, end_date: endDate }), // Only send the dates here
            })
                .then(response => {
                    if (response.ok) {
                        return response.json().then(data => {
                            closeReservationModal();
                            document.getElementById('successMessage').classList.remove('hidden'); // Show success message

                            // Hide message after 3 seconds
                            setTimeout(() => {
                                document.getElementById('successMessage').classList.add('hidden');
                            }, 3000); // 3000 milliseconds = 3 seconds

                            fetchBooks(); // Refresh the book list
                        });

    // Paginación} else {
                        return response.json().then(error => {
                            showErrorMessage(error.message); // Show error message
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showErrorMessage('An unexpected error occurred.'); // Show generic error message
                });
        }

        function showErrorMessage(message) {
            const errorMessageText = document.getElementById('errorMessageText');
            errorMessageText.innerText = message; // Set the error message text
            document.getElementById('errorMessage').classList.remove('hidden'); // Show the error message
        }
    </script>

</x-app-layout>
