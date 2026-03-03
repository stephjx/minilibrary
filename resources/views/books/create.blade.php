<x-library-layout>
    <x-slot name="header">
        Add Book
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6">
            <form action="{{ route('books.store') }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0B3C5D] focus:border-[#0B3C5D]">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="isbn" class="block text-sm font-medium text-gray-700 mb-2">
                            ISBN <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="isbn" id="isbn" value="{{ old('isbn') }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0B3C5D] focus:border-[#0B3C5D]">
                        @error('isbn')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="total_quantity" class="block text-sm font-medium text-gray-700 mb-2">
                            Total Quantity <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="total_quantity" id="total_quantity" value="{{ old('total_quantity') }}" required min="1"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0B3C5D] focus:border-[#0B3C5D]">
                        @error('total_quantity')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Authors <span class="text-red-500">*</span>
                        </label>
                        <div class="space-y-2 max-h-32 overflow-y-auto border border-gray-300 rounded-lg p-3">
                            @foreach ($authors as $author)
                                <label class="flex items-center">
                                    <input type="checkbox" name="authors[]" value="{{ $author->id }}" 
                                           {{ in_array($author->id, old('authors', [])) ? 'checked' : '' }}
                                           class="mr-2 text-[#0B3C5D] focus:ring-[#0B3C5D]">
                                    <span class="text-sm text-gray-700">{{ $author->name }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('authors')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        @if($authors->count() === 0)
                            <p class="text-sm text-gray-500">No authors available. Please add authors first.</p>
                        @endif
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('books.index') }}" 
                       class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 bg-[#0B3C5D] text-white rounded-lg hover:bg-[#1a4d6e] transition-colors"
                            @if($authors->count() === 0) disabled @endif>
                        Save Book
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-library-layout>
