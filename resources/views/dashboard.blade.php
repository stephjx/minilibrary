<x-library-layout>
    <x-slot name="header">
        Dashboard
    </x-slot>

    <!-- Add Student Modal -->
    <div x-data="{ showModal: false }" class="relative">
        <!-- SECTION 1 - Page Header with Welcome -->
        <div class="mb-8">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-1">Welcome back, {{ Auth::user()->name }}!</h1>
                    <p class="text-lg text-gray-600">Here's what's happening with your library today.</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">{{ now()->format('l') }}</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ now()->format('F d, Y') }}</p>
                </div>
            </div>
        </div>

        <!-- SECTION 2 - Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Students -->
            <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-200 hover:shadow-2xl hover:border-blue-300 hover:scale-105 transition-all duration-300 cursor-pointer" style="transition: all 0.3s ease;">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-4 bg-blue-50 rounded-xl border border-blue-200" style="background-color: #eff6ff; border-color: #bfdbfe;">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #2563eb;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <span class="text-xs font-bold text-blue-700 bg-blue-100 px-3 py-1.5 rounded-full border border-blue-300 shadow-sm" style="background-color: #dbeafe; color: #1d4ed8; border-color: #93c5fd;">+12%</span>
                </div>
                <h3 class="text-sm font-bold text-gray-800 mb-1" style="color: #1f2937; font-weight: 700;">Total Students</h3>
                <p class="text-3xl font-black text-gray-900" style="color: #111827; font-weight: 900;">{{ $totalStudents }}</p>
                <p class="text-sm font-semibold text-gray-700 mt-2" style="color: #374151; font-weight: 600;">Active this month</p>
            </div>

            <!-- Total Books -->
            <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-200 hover:shadow-2xl hover:border-green-300 hover:scale-105 transition-all duration-300 cursor-pointer" style="transition: all 0.3s ease;">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-4 bg-green-50 rounded-xl border border-green-200" style="background-color: #f0fdf4; border-color: #bbf7d0;">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #16a34a;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <span class="text-xs font-bold text-green-700 bg-green-100 px-3 py-1.5 rounded-full border border-green-300 shadow-sm" style="background-color: #dcfce7; color: #15803d; border-color: #86efac;">+8%</span>
                </div>
                <h3 class="text-sm font-bold text-gray-800 mb-1" style="color: #1f2937; font-weight: 700;">Total Books</h3>
                <p class="text-3xl font-black text-gray-900" style="color: #111827; font-weight: 900;">{{ $totalBooks }}</p>
                <p class="text-sm font-semibold text-gray-700 mt-2" style="color: #374151; font-weight: 600;">{{ $availableBooks }} available</p>
            </div>

            <!-- Active Borrows -->
            <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-200 hover:shadow-2xl hover:border-yellow-300 hover:scale-105 transition-all duration-300 cursor-pointer" style="transition: all 0.3s ease;">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-4 bg-yellow-50 rounded-xl border border-yellow-200" style="background-color: #fefce8; border-color: #fef3c7;">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #ca8a04;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <span class="text-xs font-bold text-yellow-700 bg-yellow-100 px-3 py-1.5 rounded-full border border-yellow-300 shadow-sm" style="background-color: #fef3c7; color: #a16207; border-color: #fde047;">+15%</span>
                </div>
                <h3 class="text-sm font-bold text-gray-800 mb-1" style="color: #1f2937; font-weight: 700;">Active Borrows</h3>
                <p class="text-3xl font-black text-gray-900" style="color: #111827; font-weight: 900;">{{ $activeBorrows }}</p>
                <p class="text-sm font-semibold text-gray-700 mt-2" style="color: #374151; font-weight: 600;">This week</p>
            </div>

            <!-- Overdue Books -->
            <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-200 hover:shadow-2xl hover:border-red-300 hover:scale-105 transition-all duration-300 cursor-pointer" style="transition: all 0.3s ease;">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-4 bg-red-50 rounded-xl border border-red-200" style="background-color: #fef2f2; border-color: #fecaca;">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #dc2626;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span class="text-xs font-bold text-red-700 bg-red-100 px-3 py-1.5 rounded-full border border-red-300 shadow-sm" style="background-color: #fee2e2; color: #b91c1c; border-color: #fca5a5;">Alert</span>
                </div>
                <h3 class="text-sm font-bold text-gray-800 mb-1" style="color: #1f2937; font-weight: 700;">Overdue Books</h3>
                <p class="text-3xl font-black text-red-600" style="color: #dc2626; font-weight: 900;">{{ $overdueBorrows }}</p>
                <p class="text-sm font-semibold text-gray-700 mt-2" style="color: #374151; font-weight: 600;">₱{{ number_format($totalFines, 2) }} fines</p>
            </div>
        </div>

        <!-- SECTION 3 - Outstanding Fines Banner -->
        @if ($overdueBorrows > 0)
        <div class="bg-gradient-to-r from-red-50 to-orange-50 border border-red-200 rounded-xl p-6 mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-red-100 rounded-full">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-red-900">Outstanding Fines Alert</h3>
                        <p class="text-red-700">You have {{ $overdueBorrows }} overdue books with total fines of ₱{{ number_format($totalFines, 2) }}</p>
                    </div>
                </div>
                <a href="{{ route('borrows.index') }}" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                    View Details
                </a>
            </div>
        </div>
        @endif

        <!-- SECTION 4 - Library Activity Chart and Quick Actions -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- LEFT: Library Activity Chart -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Library Activity</h3>
                    <span class="text-sm text-gray-500">Last 6 months</span>
                </div>
                <div class="h-64">
                    <canvas id="activityChart"></canvas>
                </div>
            </div>

            <!-- RIGHT: Quick Actions -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Quick Actions</h3>
                </div>
                <div class="p-6 space-y-3">
                    <button @click="showModal = true" class="w-full bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 rounded-lg p-4 flex items-center space-x-3 transition-colors duration-200 group">
                        <div class="p-2 bg-blue-500 rounded-lg group-hover:bg-blue-600 transition-colors">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                        </div>
                        <div class="flex-1 text-left">
                            <p class="font-medium text-blue-900">Add Student</p>
                            <p class="text-xs text-blue-600">Register new student</p>
                        </div>
                        <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>

                    <a href="{{ route('books.create') }}" class="w-full bg-green-50 hover:bg-green-100 text-green-700 border border-green-200 rounded-lg p-4 flex items-center space-x-3 transition-colors duration-200 group">
                        <div class="p-2 bg-green-500 rounded-lg group-hover:bg-green-600 transition-colors">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-green-900">Add Book</p>
                            <p class="text-xs text-green-600">Add new book to library</p>
                        </div>
                        <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>

                    <a href="{{ route('borrows.create') }}" class="w-full bg-purple-50 hover:bg-purple-100 text-purple-700 border border-purple-200 rounded-lg p-4 flex items-center space-x-3 transition-colors duration-200 group">
                        <div class="p-2 bg-purple-500 rounded-lg group-hover:bg-purple-600 transition-colors">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-purple-900">New Borrow</p>
                            <p class="text-xs text-purple-600">Create borrow transaction</p>
                        </div>
                        <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>

                    <a href="{{ route('borrows.index') }}" class="w-full bg-orange-50 hover:bg-orange-100 text-orange-700 border border-orange-200 rounded-lg p-4 flex items-center space-x-3 transition-colors duration-200 group">
                        <div class="p-2 bg-orange-500 rounded-lg group-hover:bg-orange-600 transition-colors">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-orange-900">View Borrows</p>
                            <p class="text-xs text-orange-600">Manage all borrowings</p>
                        </div>
                        <svg class="w-4 h-4 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- SECTION 5 - Recent Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Overdue Borrows -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Overdue Borrows</h3>
                    <span class="text-xs bg-red-100 text-red-800 px-2 py-1 rounded-full">{{ $overdueBorrows }} items</span>
                </div>
                <div class="space-y-3">
                    @if ($overdueBorrows > 0)
                        <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-red-200 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Sample Student</p>
                                    <p class="text-sm text-gray-500">Sample Book Title</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-red-600">₱{{ number_format($totalFines, 2) }}</p>
                                <p class="text-xs text-gray-500">Overdue</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Recent Transactions -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Recent Transactions</h3>
                    <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full">Last 5</span>
                </div>
                <div class="space-y-3">
                    @if ($activeBorrows > 0)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Sample Student</p>
                                    <p class="text-sm text-gray-500">Sample Book Title</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-green-600">Active</p>
                                <p class="text-xs text-gray-500">{{ now()->format('M d, Y') }}</p>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-gray-500">No recent transactions</p>
                            <p class="text-sm text-gray-400 mt-1">New transactions will appear here</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Popular Books -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Popular Books</h3>
                    <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full">Top 5</span>
                </div>
                <div class="space-y-3">
                    @if ($totalBooks > 0)
                        <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Sample Book Title</p>
                                    <p class="text-sm text-gray-500">Sample Author</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-green-600">5x</p>
                                <p class="text-xs text-gray-500">borrowed</p>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <p class="text-gray-500">No books available</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Modal Overlay -->
        <div x-show="showModal" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-gray-900 bg-opacity-50 z-50"
             @click="showModal = false">
        </div>

        <!-- Modal Content -->
        <div x-show="showModal" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 transform scale-95"
             x-transition:enter-end="opacity-100 transform scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 transform scale-100"
             x-transition:leave-end="opacity-0 transform scale-95"
             class="fixed inset-0 z-50 overflow-y-auto"
             @click.self="showModal = false">
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="relative bg-white rounded-xl shadow-xl max-w-md w-full">
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Add New Student</h3>
                        <button @click="showModal = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <form action="{{ route('students.store') }}" method="POST" class="p-6">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label for="student_number" class="block text-sm font-medium text-gray-700 mb-1">Student Number</label>
                                <input 
                                    type="text" 
                                    id="student_number"
                                    name="student_number" 
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0B3C5D] focus:border-[#0B3C5D] text-sm"
                                    placeholder="Enter student number"
                                >
                            </div>

                            <div>
                                <label for="full_name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                <input 
                                    type="text" 
                                    id="full_name"
                                    name="full_name" 
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0B3C5D] focus:border-[#0B3C5D] text-sm"
                                    placeholder="Enter full name"
                                >
                            </div>

                            <div>
                                <label for="course" class="block text-sm font-medium text-gray-700 mb-1">Course</label>
                                <select 
                                    id="course"
                                    name="course" 
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0B3C5D] focus:border-[#0B3C5D] text-sm"
                                >
                                    <option value="">Select a course</option>
                                    <option value="Computer Science">Computer Science</option>
                                    <option value="Information Technology">Information Technology</option>
                                    <option value="Computer Engineering">Computer Engineering</option>
                                    <option value="Information Systems">Information Systems</option>
                                </select>
                            </div>

                            <div>
                                <label for="year_level" class="block text-sm font-medium text-gray-700 mb-1">Year Level</label>
                                <select 
                                    id="year_level"
                                    name="year_level" 
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0B3C5D] focus:border-[#0B3C5D] text-sm"
                                >
                                    <option value="">Select year level</option>
                                    <option value="1st Year">1st Year</option>
                                    <option value="2nd Year">2nd Year</option>
                                    <option value="3rd Year">3rd Year</option>
                                    <option value="4th Year">4th Year</option>
                                </select>
                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="flex justify-end gap-3 mt-6 pt-6 border-t border-gray-200">
                            <button 
                                type="button" 
                                @click="showModal = false"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors"
                            >
                                Cancel
                            </button>
                            <button 
                                type="submit"
                                class="px-4 py-2 text-sm font-medium text-white bg-[#0B3C5D] rounded-lg hover:bg-[#1a4d6e] transition-colors"
                            >
                                Save Student
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Initialization Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('activityChart');
            if (ctx) {
                const chartData = @json($chartData);
                
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: chartData.map(item => item.month),
                        datasets: [{
                            label: 'Borrow Transactions',
                            data: chartData.map(item => item.count),
                            borderColor: '#0B3C5D',
                            backgroundColor: 'rgba(11, 60, 93, 0.1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: '#0B3C5D',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                titleColor: '#ffffff',
                                bodyColor: '#ffffff',
                                padding: 12,
                                displayColors: false,
                                callbacks: {
                                    label: function(context) {
                                        return 'Borrows: ' + context.parsed.y;
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    color: '#6b7280',
                                    font: {
                                        size: 11
                                    }
                                }
                            },
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.05)'
                                },
                                ticks: {
                                    color: '#6b7280',
                                    font: {
                                        size: 11
                                    },
                                    stepSize: 1
                                }
                            }
                        },
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        }
                    }
                });
            }
        });
    </script>
</x-library-layout>
