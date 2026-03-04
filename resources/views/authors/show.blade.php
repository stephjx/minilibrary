<x-library-layout>
    <x-slot name="header">
        Author Details
    </x-slot>

    <!-- Author Profile Card -->
    <div x-data="{ showEditModal: false }" class="relative">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6 hover:shadow-lg transition-shadow duration-200">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <!-- Author Avatar -->
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>

                        <!-- Author Info -->
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">{{ $author->name }}</h2>
                            <p class="text-gray-500">{{ $author->books->count() }} books</p>
                            @if($author->bio)
                                <p class="text-gray-600 mt-2 text-sm leading-relaxed">{{ $author->bio }}</p>
                            @endif
                            @if($author->email)
                                <p class="text-gray-500 text-sm mt-1">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2.25 2.25 0 012.12 2.56L21 16M8 19l1.87.66a2.25 2.25 0 001.13-1.87l.66-1.87M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $author->email }}
                                </p>
                            @endif
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
                        <a href="{{ route('authors.index') }}" 
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
                        <h3 class="text-lg font-semibold text-gray-900">Edit Author</h3>
                        <button @click="showEditModal = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <form action="{{ route('authors.update', $author) }}" method="POST" class="p-6">
                        @csrf
                        @method('PUT')
                        <div class="space-y-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Author Name</label>
                                <input 
                                    type="text" 
                                    id="name"
                                    name="name" 
                                    required
                                    value="{{ $author->name }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0B3C5D] focus:border-[#0B3C5D] text-sm"
                                    placeholder="Enter author name"
                                >
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email (Optional)</label>
                                <input 
                                    type="email" 
                                    id="email"
                                    name="email" 
                                    value="{{ $author->email ?? '' }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0B3C5D] focus:border-[#0B3C5D] text-sm"
                                    placeholder="Enter email address"
                                >
                            </div>

                            <div>
                                <label for="bio" class="block text-sm font-medium text-gray-700 mb-1">Bio (Optional)</label>
                                <textarea 
                                    id="bio"
                                    name="bio" 
                                    rows="3"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0B3C5D] focus:border-[#0B3C5D] text-sm"
                                    placeholder="Enter author biography"
                                >{{ $author->bio ?? '' }}</textarea>
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
                                Update Author
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Statistics Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
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
                        <p class="text-2xl font-bold text-gray-900">{{ $author->books->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Copies Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 p-3 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-500">Total Copies</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $author->books->sum('total_quantity') }}</p>
                    </div>
                </div>
            </div>

            <!-- Available Copies Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 p-3 bg-purple-100 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-500">Available</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $author->books->sum('available_quantity') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Books Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Books by {{ $author->name }}</h3>
            </div>
            <div class="p-6">
                @if($author->books->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach ($author->books as $book)
                            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-900">{{ $book->title }}</h4>
                                        <p class="text-sm text-gray-500">ISBN: {{ $book->isbn }}</p>
                                    </div>
                                    <div class="w-8 h-8 bg-blue-100 rounded flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-blue-600">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z" />
                                        </svg>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-sm text-gray-600">
                                        {{ $book->available_quantity }}/{{ $book->total_quantity }} available
                                    </span>
                                    @if($book->available_quantity > 0)
                                        <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded">
                                            Available
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded">
                                            Unavailable
                                        </span>
                                    @endif
                                </div>

                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-gray-400">
                                        {{ $book->created_at->format('M d, Y') }}
                                    </span>
                                    <a href="{{ route('books.show', $book) }}" 
                                       class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-1">No books found</h3>
                        <p class="text-gray-500 mb-4">This author hasn't added any books yet.</p>
                        <a href="{{ route('books.create') }}" class="inline-flex items-center px-4 py-2 bg-[#0B3C5D] text-white rounded-lg hover:bg-[#1a4d6e] transition-colors text-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Add First Book
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-library-layout>
