<x-library-layout>
    <x-slot name="header">
        Student Details
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6">
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Personal Information</h3>
                    <div class="space-y-3">
                        <div>
                            <span class="text-sm font-medium text-gray-500">Student Number:</span>
                            <p class="text-gray-900">{{ $student->student_number }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500">Full Name:</span>
                            <p class="text-gray-900">{{ $student->full_name }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500">Course:</span>
                            <p class="text-gray-900">{{ $student->course }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500">Year Level:</span>
                            <p class="text-gray-900">{{ $student->year_level }}</p>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistics</h3>
                    <div class="space-y-3">
                        <div>
                            <span class="text-sm font-medium text-gray-500">Total Borrows:</span>
                            <p class="text-gray-900">{{ $student->borrows->count() }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500">Active Borrows:</span>
                            <p class="text-gray-900">{{ $student->borrows->whereIn('status', ['borrowed', 'partially_returned'])->count() }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500">Completed Borrows:</span>
                            <p class="text-gray-900">{{ $student->borrows->where('status', 'returned')->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex space-x-3">
                <a href="{{ route('students.edit', $student) }}" 
                   class="inline-flex items-center px-4 py-2 bg-[#0B3C5D] text-white rounded-lg hover:bg-[#1a4d6e] transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit Student
                </a>
                <a href="{{ route('students.index') }}" 
                   class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    Back to Students
                </a>
            </div>
        </div>
    </div>

    <!-- Borrowing History -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Borrowing History</h3>
        </div>
        <div class="p-6">
            @if($student->borrows->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
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
                            @foreach ($student->borrows as $borrow)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $borrow->borrow_date->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $borrow->due_date->format('M d, Y') }}
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
                                        <a href="{{ route('borrows.show', $borrow) }}" class="text-[#0B3C5D] hover:text-[#F4A300]">
                                            View Details
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500 text-center py-4">No borrowing history found</p>
            @endif
        </div>
    </div>
</x-library-layout>
