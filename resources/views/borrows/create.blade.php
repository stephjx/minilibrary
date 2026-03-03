<x-library-layout>
    <x-slot name="header">
        New Borrow
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6">
            <form action="{{ route('borrows.store') }}" method="POST" id="borrowForm">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="student_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Student <span class="text-red-500">*</span>
                        </label>
                        <select name="student_id" id="student_id" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0B3C5D] focus:border-[#0B3C5D]">
                            <option value="">Select Student</option>
                            @foreach ($students as $student)
                                <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                    {{ $student->full_name }} ({{ $student->student_number }})
                                </option>
                            @endforeach
                        </select>
                        @error('student_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="due_date" class="block text-sm font-medium text-gray-700 mb-2">
                            Due Date <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="due_date" id="due_date" value="{{ old('due_date') }}" required
                               min="{{ now()->format('Y-m-d') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0B3C5D] focus:border-[#0B3C5D]">
                        @error('due_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Books Selection -->
                <div class="mb-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Books to Borrow</h3>
                        <button type="button" onclick="addBookRow()" 
                                class="inline-flex items-center px-3 py-1 bg-[#F4A300] text-white rounded-lg hover:bg-[#e59900] transition-colors text-sm">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Add Book
                        </button>
                    </div>
                    
                    <div id="booksContainer" class="space-y-3">
                        <!-- Initial book row -->
                        <div class="book-row grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
                            <div class="md:col-span-7">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Book</label>
                                <select name="books[0][book_id]" required
                                        class="book-select w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0B3C5D] focus:border-[#0B3C5D]">
                                    <option value="">Select Book</option>
                                    @foreach ($books as $book)
                                        <option value="{{ $book->id }}" data-available="{{ $book->available_quantity }}">
                                            {{ $book->title }} ({{ $book->available_quantity }} available)
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="md:col-span-3">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                                <input type="number" name="books[0][quantity]" min="1" required
                                       class="quantity-input w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0B3C5D] focus:border-[#0B3C5D]">
                            </div>
                            <div class="md:col-span-2">
                                <button type="button" onclick="removeBookRow(this)" 
                                        class="w-full px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors text-sm">
                                    Remove
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('borrows.index') }}" 
                       class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 bg-[#0B3C5D] text-white rounded-lg hover:bg-[#1a4d6e] transition-colors">
                        Create Borrow
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let bookRowCount = 1;

        function addBookRow() {
            const container = document.getElementById('booksContainer');
            const newRow = document.createElement('div');
            newRow.className = 'book-row grid grid-cols-1 md:grid-cols-12 gap-3 items-end';
            
            const booksSelect = `@foreach ($books as $book)
                <option value="{{ $book->id }}" data-available="{{ $book->available_quantity }}">
                    {{ $book->title }} ({{ $book->available_quantity }} available)
                </option>
            @endforeach`;
            
            newRow.innerHTML = `
                <div class="md:col-span-7">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Book</label>
                    <select name="books[${bookRowCount}][book_id]" required
                            class="book-select w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0B3C5D] focus:border-[#0B3C5D]">
                        <option value="">Select Book</option>
                        ${booksSelect}
                    </select>
                </div>
                <div class="md:col-span-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                    <input type="number" name="books[${bookRowCount}][quantity]" min="1" required
                           class="quantity-input w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0B3C5D] focus:border-[#0B3C5D]">
                </div>
                <div class="md:col-span-2">
                    <button type="button" onclick="removeBookRow(this)" 
                            class="w-full px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors text-sm">
                        Remove
                    </button>
                </div>
            `;
            
            container.appendChild(newRow);
            bookRowCount++;
        }

        function removeBookRow(button) {
            const row = button.closest('.book-row');
            const container = document.getElementById('booksContainer');
            if (container.children.length > 1) {
                row.remove();
            } else {
                alert('You must have at least one book');
            }
        }

        // Update quantity max based on available books
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('book-select')) {
                const selectedOption = e.target.options[e.target.selectedIndex];
                const availableQuantity = selectedOption.getAttribute('data-available');
                const quantityInput = e.target.closest('.book-row').querySelector('.quantity-input');
                
                if (availableQuantity) {
                    quantityInput.max = availableQuantity;
                    quantityInput.placeholder = `Max: ${availableQuantity}`;
                }
            }
        });
    </script>
</x-library-layout>
