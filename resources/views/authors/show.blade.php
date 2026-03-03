<x-library-layout>
    <x-slot name="header">
        Author Details
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6">
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Author Information</h3>
                    <div class="space-y-3">
                        <div>
                            <span class="text-sm font-medium text-gray-500">Name:</span>
                            <p class="text-gray-900">{{ $author->name }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500">Total Books:</span>
                            <p class="text-gray-900">{{ $author->books->count() }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500">Member Since:</span>
                            <p class="text-gray-900">{{ $author->created_at->format('F d, Y') }}</p>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistics</h3>
                    <div class="space-y-3">
                        <div>
                            <span class="text-sm font-medium text-gray-500">Total Books Written:</span>
                            <p class="text-gray-900">{{ $author->books->count() }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500">Total Copies in Library:</span>
                            <p class="text-gray-900">{{ $author->books->sum('total_quantity') }}</p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500">Available Copies:</span>
                            <p class="text-gray-900">{{ $author->books->sum('available_quantity') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex space-x-3">
                <a href="{{ route('authors.edit', $author) }}" 
                   class="inline-flex items-center px-4 py-2 bg-[#0B3C5D] text-white rounded-lg hover:bg-[#1a4d6e] transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit Author
                </a>
                <a href="{{ route('authors.index') }}" 
                   class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    Back to Authors
                </a>
            </div>
        </div>
    </div>

    <!-- Books by Author -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Books by {{ $author->name }}</h3>
        </div>
        <div class="p-6">
            @if($author->books->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($author->books as $book)
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                            <h4 class="font-semibold text-gray-900 mb-2">{{ $book->title }}</h4>
                            <p class="text-sm text-gray-600 mb-3">ISBN: {{ $book->isbn }}</p>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-500">
                                    {{ $book->available_quantity }}/{{ $book->total_quantity }} available
                                </span>
                                <a href="{{ route('books.show', $book) }}" 
                                   class="text-sm text-[#0B3C5D] hover:text-[#F4A300] font-medium">
                                    View Details
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-4">No books found for this author</p>
            @endif
        </div>
    </div>
</x-library-layout>
