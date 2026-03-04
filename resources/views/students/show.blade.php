<x-library-layout>
    <x-slot name="header">
        Student Details
    </x-slot>

    <!-- Student Profile Card -->
    <div x-data="{ showEditModal: false }" class="relative">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6 hover:shadow-lg transition-shadow duration-200">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <!-- Student Avatar -->
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 007-7z"></path>
                            </svg>
                        </div>

                        <!-- Student Info -->
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">{{ $student->full_name }}</h2>
                            <p class="text-gray-500">{{ $student->student_number }} • {{ $student->course }}</p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center gap-3">
                        <!-- Edit Button (Hover Trigger) -->
                        <button @click="showEditModal = true" 
                                class="inline-flex items-center px-4 py-2 bg-[#0B3C5D] text-white rounded-lg hover:bg-[#1a4d6e] transition-colors text-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z"></path>
                            </svg>
                            Edit
                        </button>
                        <a href="{{ route('students.index') }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors text-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Modal Overlay -->
        <div x-show="showEditModal" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-gray-900 bg-opacity-50 z-50"
             @click="showEditModal = false">
        </div>

        <!-- Edit Modal Content -->
        <div x-show="showEditModal" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 transform scale-95"
             x-transition:enter-end="opacity-100 transform scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 transform scale-100"
             x-transition:leave-end="opacity-0 transform scale-95"
             class="fixed inset-0 z-50 overflow-y-auto"
             @click.self="showEditModal = false">
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="relative bg-white rounded-xl shadow-xl max-w-md w-full">
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Edit Student</h3>
                        <button @click="showEditModal = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <form action="{{ route('students.update', $student) }}" method="POST" class="p-6">
                        @csrf
                        @method('PUT')
                        <div class="space-y-4">
                            <div>
                                <label for="full_name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                <input 
                                    type="text" 
                                    id="full_name"
                                    name="full_name" 
                                    required
                                    value="{{ $student->full_name }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0B3C5D] focus:border-[#0B3C5D] text-sm"
                                    placeholder="Enter full name"
                                >
                            </div>

                            <div>
                                <label for="student_number" class="block text-sm font-medium text-gray-700 mb-1">Student Number</label>
                                <input 
                                    type="text" 
                                    id="student_number"
                                    name="student_number" 
                                    required
                                    value="{{ $student->student_number }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0B3C5D] focus:border-[#0B3C5D] text-sm"
                                    placeholder="Enter student number"
                                >
                            </div>

                            <div>
                                <label for="course" class="block text-sm font-medium text-gray-700 mb-1">Course</label>
                                <input 
                                    type="text" 
                                    id="course"
                                    name="course" 
                                    required
                                    value="{{ $student->course }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0B3C5D] focus:border-[#0B3C5D] text-sm"
                                    placeholder="Enter course"
                                >
                            </div>

                            <div>
                                <label for="year_level" class="block text-sm font-medium text-gray-700 mb-1">Year Level</label>
                                <select 
                                    id="year_level"
                                    name="year_level" 
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0B3C5D] focus:border-[#0B3C5D] text-sm"
                                >
                                    <option value="1st Year" {{ $student->year_level === '1st Year' ? 'selected' : '' }}>1st Year</option>
                                    <option value="2nd Year" {{ $student->year_level === '2nd Year' ? 'selected' : '' }}>2nd Year</option>
                                    <option value="3rd Year" {{ $student->year_level === '3rd Year' ? 'selected' : '' }}>3rd Year</option>
                                    <option value="4th Year" {{ $student->year_level === '4th Year' ? 'selected' : '' }}>4th Year</option>
                                </select>
                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="flex justify-end gap-3 mt-6 pt-6 border-t border-gray-200">
                            <button 
                                type="button" 
                                @click="showEditModal = false"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors"
                            >
                                Cancel
                            </button>
                            <button 
                                type="submit"
                                class="px-4 py-2 text-sm font-medium text-white bg-[#0B3C5D] rounded-lg hover:bg-[#1a4d6e] transition-colors"
                            >
                                Update Student
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Statistics Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
            <!-- Total Borrows Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 p-3 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v10a2 2 0 002 2h5m0-10h5a2 2 0 002 2v10a2 2 0 002-2h5m0-10h5a2 2 0 002 2v10a2 2 0 002-2h5m-6-2v10a2 2 0 002 2h5a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-500">Total Borrows</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $student->borrows->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Active Borrows Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 p-3 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-500">Active Borrows</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $student->borrows->whereIn('status', ['borrowed', 'partially_returned'])->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Completed Borrows Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 p-3 bg-purple-100 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-500">Completed Borrows</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $student->borrows->where('status', 'returned')->count() }}</p>
                    </div>
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
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v10a2 2 0 002 2h5m0-10h5a2 2 0 002 2v10a2 2 0 002-2h5m-6-2v10a2 2 0 002 2h5a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2z"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-600 mb-1">No borrowing history found</h3>
                        <p class="text-gray-400 mb-4">This student hasn't borrowed any books yet.</p>
                        <a href="{{ route('borrows.create') }}" class="inline-flex items-center px-4 py-2 bg-[#0B3C5D] text-white rounded-lg hover:bg-[#1a4d6e] transition-colors text-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            First Borrow
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-library-layout>
