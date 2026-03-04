<x-library-layout>
    <x-slot name="header">
        Borrow Details
    </x-slot>

    <!-- Borrow Profile Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6 hover:shadow-lg transition-shadow duration-200">
        <div class="p-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <!-- Borrow Avatar -->
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v10a2 2 0 002 2h5m0-10h5a2 2 0 002 2v10a2 2 0 002-2h5m-6-2v10a2 2 0 002 2h5a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2z"></path>
                        </svg>
                    </div>

                    <!-- Borrow Info -->
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Borrow #{{ $borrow->id }}</h2>
                        <p class="text-gray-500">{{ $borrow->student->full_name }} • {{ $borrow->student->student_number }}</p>
                    </div>
                </div>

                <!-- Status Badge -->
                <div class="flex items-center gap-3">
                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full 
                        {{ $borrow->status === 'borrowed' ? 'bg-yellow-100 text-yellow-800' : 
                           ($borrow->status === 'partially_returned' ? 'bg-blue-100 text-blue-800' : 
                           'bg-green-100 text-green-800') }}">
                        {{ ucfirst(str_replace('_', ' ', $borrow->status)) }}
                    </span>
                    @if($borrow->isOverdue())
                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-800">
                            Overdue
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Total Books Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4">
                <div class="flex-shrink-0 p-3 bg-blue-100 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-500">Total Books</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $borrow->borrowItems->sum('quantity') }}</p>
                </div>
            </div>
        </div>

        <!-- Returned Books Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4">
                <div class="flex-shrink-0 p-3 bg-green-100 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-500">Returned</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $borrow->borrowItems->sum('returned_quantity') }}</p>
                </div>
            </div>
        </div>

        <!-- Remaining Books Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4">
                <div class="flex-shrink-0 p-3 bg-yellow-100 rounded-lg">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-500">Remaining</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $borrow->borrowItems->sum('remaining_quantity') }}</p>
                </div>
            </div>
        </div>

        <!-- Fine Amount Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center gap-4">
                <div class="flex-shrink-0 p-3 {{ $fine > 0 ? 'bg-red-100' : 'bg-gray-100' }} rounded-lg">
                    <svg class="w-6 h-6 {{ $fine > 0 ? 'text-red-600' : 'text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-500">Current Fine</p>
                    <p class="text-2xl font-bold {{ $fine > 0 ? 'text-red-600' : 'text-gray-900' }}">₱{{ number_format($fine, 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Borrow Information and Timeline -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Borrow Information -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Borrow Information</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div class="flex items-center justify-between py-3 border-b border-gray-100">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-50 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Student</p>
                                <p class="text-sm text-gray-500">{{ $borrow->student->full_name }}</p>
                                <p class="text-xs text-gray-400">{{ $borrow->student->student_number }} • {{ $borrow->student->course }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between py-3 border-b border-gray-100">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-green-50 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Borrow Date</p>
                                <p class="text-sm text-gray-500">{{ $borrow->borrow_date->format('F d, Y') }}</p>
                                <p class="text-xs text-gray-400">{{ $borrow->borrow_date->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between py-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 {{ $borrow->isOverdue() ? 'bg-red-50' : 'bg-yellow-50' }} rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 {{ $borrow->isOverdue() ? 'text-red-600' : 'text-yellow-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Due Date</p>
                                <p class="text-sm text-gray-500">{{ $borrow->due_date->format('F d, Y') }}</p>
                                @if($borrow->isOverdue())
                                    <p class="text-xs text-red-600 font-medium">Overdue by {{ $borrow->due_date->diffInDays(now()) }} days</p>
                                @else
                                    <p class="text-xs text-gray-400">{{ $borrow->due_date->diffForHumans() }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Actions</h3>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    @if($borrow->status !== 'returned')
                        <a href="{{ route('borrows.return', $borrow) }}" 
                           class="w-full inline-flex items-center justify-center px-4 py-3 bg-[#0B3C5D] text-white rounded-lg hover:bg-[#1a4d6e] transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Return Books
                        </a>
                    @endif

                    <a href="{{ route('borrows.index') }}" 
                       class="w-full inline-flex items-center justify-center px-4 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Borrows
                    </a>

                    @if($borrow->isOverdue())
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-red-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                                <div>
                                    <p class="text-sm font-medium text-red-800">Overdue Notice</p>
                                    <p class="text-sm text-red-600">This borrow is overdue by {{ $borrow->due_date->diffInDays(now()) }} days.</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
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
                                Book Details
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Authors
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Quantity
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($borrow->borrowItems as $borrowItem)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-start gap-3">
                                        <div class="w-12 h-16 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $borrowItem->book->title }}</p>
                                            <p class="text-sm text-gray-500">ISBN: {{ $borrowItem->book->isbn }}</p>
                                            <p class="text-xs text-gray-400 mt-1">Category: {{ $borrowItem->book->category ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($borrowItem->book->authors as $author)
                                            <span class="inline-flex px-2 py-1 text-xs bg-gray-100 text-gray-800 rounded-md">
                                                {{ $author->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="space-y-1">
                                        <div class="flex items-center justify-center gap-2">
                                            <span class="text-sm text-gray-900">{{ $borrowItem->returned_quantity }}</span>
                                            <span class="text-gray-400">/</span>
                                            <span class="text-sm font-medium text-gray-900">{{ $borrowItem->quantity }}</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-1.5">
                                            <div class="bg-blue-600 h-1.5 rounded-full" style="width: {{ ($borrowItem->returned_quantity / $borrowItem->quantity) * 100 }}%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex px-2.5 py-1 text-xs font-semibold rounded-full 
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
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-green-50 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Return Books</h3>
                        <p class="text-sm text-gray-500">Process book returns for this borrow transaction</p>
                    </div>
                </div>
            </div>
            <div class="p-6">
                <form action="{{ route('borrows.return', $borrow) }}" method="POST">
                    @csrf
                    
                    <div class="space-y-6">
                        @foreach ($borrow->borrowItems as $borrowItem)
                            @if(!$borrowItem->isFullyReturned())
                                <div class="border border-gray-200 rounded-xl p-6 hover:shadow-md transition-shadow">
                                    <div class="flex items-start gap-4">
                                        <div class="w-16 h-20 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="font-semibold text-gray-900 mb-2">{{ $borrowItem->book->title }}</h4>
                                            <div class="flex flex-wrap gap-2 mb-4">
                                                <span class="inline-flex px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-md">
                                                    ISBN: {{ $borrowItem->book->isbn }}
                                                </span>
                                                <span class="inline-flex px-2 py-1 text-xs bg-gray-100 text-gray-800 rounded-md">
                                                    Total: {{ $borrowItem->quantity }}
                                                </span>
                                                <span class="inline-flex px-2 py-1 text-xs bg-green-100 text-green-800 rounded-md">
                                                    Returned: {{ $borrowItem->returned_quantity }}
                                                </span>
                                                <span class="inline-flex px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-md">
                                                    Remaining: {{ $borrowItem->remaining_quantity }}
                                                </span>
                                            </div>
                                            
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                                        Return Quantity
                                                    </label>
                                                    <div class="relative">
                                                        <input type="number" name="returns[{{ $borrowItem->id }}][quantity]" 
                                                               min="1" max="{{ $borrowItem->remaining_quantity }}" required
                                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0B3C5D] focus:border-[#0B3C5D] pr-16"
                                                               placeholder="Enter quantity">
                                                        <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-sm text-gray-500">
                                                            / {{ $borrowItem->remaining_quantity }}
                                                        </span>
                                                    </div>
                                                    <input type="hidden" name="returns[{{ $borrowItem->id }}][borrow_item_id]" value="{{ $borrowItem->id }}">
                                                </div>
                                                <div class="flex items-end">
                                                    <div class="text-sm text-gray-500">
                                                        <p class="font-medium">Maximum: {{ $borrowItem->remaining_quantity }}</p>
                                                        <p class="text-xs">{{ $borrowItem->remaining_quantity > 1 ? 'books' : 'book' }} remaining</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    @if($borrow->borrowItems->contains('remaining_quantity', '>', 0))
                        <div class="mt-8 flex justify-end gap-3 pt-6 border-t border-gray-200">
                            <a href="{{ route('borrows.show', $borrow) }}" 
                               class="px-6 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="px-6 py-2.5 bg-[#0B3C5D] text-white rounded-lg hover:bg-[#1a4d6e] transition-colors flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Process Return
                            </button>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-1">All Books Returned</h3>
                            <p class="text-gray-500">All books from this borrow transaction have been successfully returned.</p>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    @endif
</x-library-layout>
