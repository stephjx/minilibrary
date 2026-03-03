<x-library-layout>
    <x-slot name="header">
        Edit Author
    </x-slot>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6">
            <form action="{{ route('authors.update', $author) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="max-w-md">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Author Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name', $author->name) }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0B3C5D] focus:border-[#0B3C5D]">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('authors.show', $author) }}" 
                       class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 bg-[#0B3C5D] text-white rounded-lg hover:bg-[#1a4d6e] transition-colors">
                        Update Author
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-library-layout>
