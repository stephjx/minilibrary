<x-library-layout>
    <x-slot name="header">
        Borrowing Records
        <div class="mt-2">
            <a href="{{ route('borrows.create') }}" class="inline-flex items-center px-4 py-2 bg-[#0B3C5D] text-white rounded-lg hover:bg-[#1a4d6e] transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                New Borrow
            </a>
        </div>
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6">
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
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $borrow->borrowItems->count() }} books
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('borrows.show', $borrow) }}" class="text-[#0B3C5D] hover:text-[#F4A300] mr-3">View</a>
                                    @if($borrow->status === 'returned')
                                        <form action="{{ route('borrows.destroy', $borrow) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this record?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                    No borrowing records found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if ($borrows->hasPages())
                <div class="mt-6">
                    {{ $borrows->links() }}
                </div>
            @endif
        </div>
    </div>
</x-library-layout>
