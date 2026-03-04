<x-library-layout>
    <x-slot name="header">
        Borrowing
    </x-slot>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-green-800">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-red-800">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <!-- Borrowing Records -->
    <div class="relative">
        <!-- Modal Button -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <!-- Table Toolbar -->
            <div class="p-4 border-b border-gray-200">
                <div class="flex items-center gap-6">
                    <!-- Search Bar -->
                    <div class="flex-1 min-w-0">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input 
                                type="text" 
                                id="searchInput"
                                placeholder="Search borrowing records..." 
                                class="w-full pl-12 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0B3C5D] focus:border-[#0B3C5D] text-sm placeholder-gray-500 leading-5"
                                value="{{ request('search') }}"
                                onkeyup="liveSearch(this.value)"
                            >
                        </div>
                    </div>
                    
                    <!-- Status Filter -->
                    <div class="min-w-0">
                        <form method="GET" action="{{ route('borrows.index') }}" class="flex items-center gap-3">
                            @if(request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif
                            <select 
                                name="status" 
                                onchange="this.form.submit()"
                                class="px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0B3C5D] focus:border-[#0B3C5D] text-sm bg-white"
                            >
                                <option value="">All Status</option>
                                <option value="borrowed" {{ request('status') === 'borrowed' ? 'selected' : '' }}>Borrowed</option>
                                <option value="partially_returned" {{ request('status') === 'partially_returned' ? 'selected' : '' }}>Partially Returned</option>
                                <option value="returned" {{ request('status') === 'returned' ? 'selected' : '' }}>Returned</option>
                            </select>
                        </form>
                    </div>
                    
                    <!-- Add Borrow Button -->
                    <div class="ml-auto">
                        <a href="{{ route('borrows.create') }}" class="inline-flex items-center px-4 py-2.5 bg-[#0B3C5D] text-white rounded-lg hover:bg-[#1a4d6e] transition-colors text-sm font-medium whitespace-nowrap">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                            </svg>
                            New Borrow
                        </a>
                    </div>
                </div>
            </div>

            <!-- Borrowing Records Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Student
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Borrow Date
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Due Date
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Books
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($borrows as $borrow)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $borrow->student->full_name }}</div>
                                    <div class="text-sm text-gray-500">{{ $borrow->student->student_number }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $borrow->borrow_date->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $borrow->due_date->format('M d, Y') }}
                                    @if($borrow->isOverdue())
                                        <span class="ml-2 text-xs text-red-600 font-medium">OVERDUE</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                        {{ $borrow->status === 'borrowed' ? 'bg-yellow-100 text-yellow-800' : 
                                           ($borrow->status === 'partially_returned' ? 'bg-blue-100 text-blue-800' : 
                                           'bg-green-100 text-green-800') }}">
                                        {{ ucfirst(str_replace('_', ' ', $borrow->status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        @foreach($borrow->borrowItems as $item)
                                            <span class="inline-block px-2 py-1 text-xs bg-gray-100 text-gray-800 rounded mr-1 mb-1">
                                                {{ $item->book->title }}
                                            </span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('borrows.show', $borrow) }}" class="p-2 bg-blue-50 rounded-lg border border-blue-200 text-blue-600 hover:bg-blue-100 transition-colors" title="View Borrow">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            </svg>
                                        </a>
                                        @if($borrow->status === 'returned')
                                            <button onclick="openDeleteModal({{ $borrow->id }}, '{{ $borrow->student->full_name }}')" class="p-2 bg-red-50 rounded-lg border border-red-200 text-red-600 hover:bg-red-100 transition-colors" title="Delete Borrow">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        </svg>
                                        <p class="text-lg font-medium text-gray-600 mb-1">No borrowing records found</p>
                                        <p class="text-sm text-gray-400">Get started by creating your first borrow record</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if ($borrows->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    @include('pagination', ['paginator' => $borrows])
                </div>
            @endif
        </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 z-50 hidden" onclick="closeDeleteModal(event)">
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative bg-white rounded-xl shadow-xl max-w-md w-full" onclick="event.stopPropagation()">
                <!-- Modal Header -->
                <div class="flex items-center justify-between p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Delete Borrow Record</h3>
                    <button onclick="closeDeleteModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-6">
                    <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-100 rounded-full mb-4">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    
                    <div class="text-center">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Are you sure?</h3>
                        <p class="text-sm text-gray-500 mb-4">
                            Do you really want to delete the borrow record for <span id="deleteBorrowTitle" class="font-semibold text-gray-900"></span>? This action cannot be undone.
                        </p>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="flex justify-end gap-3 px-6 pb-6">
                    <button 
                        type="button" 
                        onclick="closeDeleteModal()"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors"
                    >
                        Cancel
                    </button>
                    <form id="deleteForm" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button 
                            type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition-colors"
                        >
                            Confirm
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentBorrowId = null;
        let searchTimeout = null;

        function liveSearch(searchTerm) {
            // Clear previous timeout
            if (searchTimeout) {
                clearTimeout(searchTimeout);
            }
            
            // Set new timeout to avoid too many requests
            searchTimeout = setTimeout(() => {
                // Update URL with search parameter
                const url = new URL(window.location);
                if (searchTerm.trim()) {
                    url.searchParams.set('search', searchTerm);
                } else {
                    url.searchParams.delete('search');
                }
                
                // Reload page with new search parameter
                window.location.href = url.toString();
            }, 500); // Wait 500ms after user stops typing
        }

        function openDeleteModal(borrowId, studentName) {
            const modal = document.getElementById('deleteModal');
            const form = document.getElementById('deleteForm');
            const titleElement = document.getElementById('deleteBorrowTitle');
            
            // Store current borrow ID
            currentBorrowId = borrowId;
            
            // Set form action
            form.action = '/borrows/' + borrowId;
            
            // Set student name in confirmation message
            titleElement.textContent = studentName;
            
            // Show modal
            modal.classList.remove('hidden');
        }

        function closeDeleteModal(event) {
            if (!event || event.target === event.currentTarget) {
                const modal = document.getElementById('deleteModal');
                modal.classList.add('hidden');
                currentBorrowId = null;
            }
        }
    </script>
</x-library-layout>
