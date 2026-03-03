<x-library-layout>
    <x-slot name="header">
        Borrow Details
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6">
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Borrow Information</h3>
                    <div class="space-y-3">
                        <div>
                            <span class="text-sm font-medium text-gray-500">Student:</span>
                            <p class="text-gray-900">{{ $borrow->student->full_name }}</p>
                            <p class="text-sm text-gray-500">{{ $borrow->student->student_number }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500">Borrow Date:</span>
                            <p class="text-gray-900">{{ $borrow->borrow_date->format('F d, Y') }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500">Due Date:</span>
                            <p class="text-gray-900">{{ $borrow->due_date->format('F d, Y') }}</p>
                            @if($borrow->isOverdue())
                                <p class="text-sm text-red-600 font-medium">OVERDUE</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Status & Fine</h3>
                    <div class="space-y-3">
                        <div>
                            <span class="text-sm font-medium text-gray-500">Status:</span>
                            <p>
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $borrow->status === 'borrowed' ? 'bg-yellow-100 text-yellow-800' : 
                                       ($borrow->status === 'partially_returned' ? 'bg-blue-100 text-blue-800' : 
                                       'bg-green-100 text-green-800') }}">
                                    {{ ucfirst(str_replace('_', ' ', $borrow->status)) }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500">Current Fine:</span>
                            <p class="text-lg font-semibold text-red-600">₱{{ number_format($fine, 2) }}</p>
                        </div>
                        @if($borrow->isOverdue())
                            <div class="bg-red-50 border border-red-200 rounded-lg p-3">
                                <p class="text-sm text-red-800">
                                    This borrow is overdue by {{ $borrow->due_date->diffInDays(now()) }} days.
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="mt-6 flex space-x-3">
                @if($borrow->status !== 'returned')
                    <a href="{{ route('borrows.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-[#0B3C5D] text-white rounded-lg hover:bg-[#1a4d6e] transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Return Books
                    </a>
                @endif
                <a href="{{ route('borrows.index') }}" 
                   class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    Back to Borrows
                </a>
            </div>
        </div>
    </div>

    <!-- Borrowed Books -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Borrowed Books</h3>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Book
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Authors
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Quantity Borrowed
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Quantity Returned
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($borrow->borrowItems as $borrowItem)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $borrowItem->book->title }}</div>
                                    <div class="text-sm text-gray-500">ISBN: {{ $borrowItem->book->isbn }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        @foreach($borrowItem->book->authors as $author)
                                            <span class="inline-block px-2 py-1 text-xs bg-gray-100 text-gray-800 rounded mr-1 mb-1">
                                                {{ $author->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $borrowItem->quantity }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $borrowItem->returned_quantity }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                        {{ $borrowItem->isFullyReturned() ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ $borrowItem->isFullyReturned() ? 'Returned' : 'Borrowed' }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Return Books Form -->
    @if($borrow->status !== 'returned')
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Return Books</h3>
            </div>
            <div class="p-6">
                <form action="{{ route('borrows.return', $borrow) }}" method="POST">
                    @csrf
                    
                    <div class="space-y-4">
                        @foreach ($borrow->borrowItems as $borrowItem)
                            @if(!$borrowItem->isFullyReturned())
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <h4 class="font-medium text-gray-900 mb-2">{{ $borrowItem->book->title }}</h4>
                                    <p class="text-sm text-gray-500 mb-3">
                                        Borrowed: {{ $borrowItem->quantity }} | Returned: {{ $borrowItem->returned_quantity }} | 
                                        Remaining: {{ $borrowItem->remaining_quantity }}
                                    </p>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                                Return Quantity
                                            </label>
                                            <input type="number" name="returns[{{ $borrowItem->id }}][quantity]" 
                                                   min="1" max="{{ $borrowItem->remaining_quantity }}" required
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0B3C5D] focus:border-[#0B3C5D]">
                                            <input type="hidden" name="returns[{{ $borrowItem->id }}][borrow_item_id]" value="{{ $borrowItem->id }}">
                                        </div>
                                        <div class="flex items-end">
                                            <span class="text-sm text-gray-500">
                                                Max: {{ $borrowItem->remaining_quantity }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    @if($borrow->borrowItems->contains('remaining_quantity', '>', 0))
                        <div class="mt-6 flex justify-end">
                            <button type="submit" 
                                    class="px-4 py-2 bg-[#0B3C5D] text-white rounded-lg hover:bg-[#1a4d6e] transition-colors">
                                Process Return
                            </button>
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-4">All books have been returned</p>
                    @endif
                </form>
            </div>
        </div>
    @endif
</x-library-layout>
