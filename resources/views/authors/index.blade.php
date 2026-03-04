<x-library-layout>
    <x-slot name="header">
        Authors
    </x-slot>

    <!-- Author Modals -->
    <div x-data="{ showModal: false, showEditModal: false, selectedAuthor: null }" class="relative">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <!-- Table Toolbar -->
            <div class="p-4 border-b border-gray-200">
                <div class="flex items-center gap-6">
                    <!-- Search Bar -->
                    <div class="flex-1 min-w-0">
                        <form method="GET" action="{{ route('authors.index') }}">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <input 
                                    type="text" 
                                    name="search"
                                    placeholder="Search authors..." 
                                    class="w-full pl-12 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0B3C5D] focus:border-[#0B3C5D] text-sm placeholder-gray-500 leading-5"
                                    value="{{ request('search') }}"
                                >
                            </div>
                            <!-- Preserve filter when searching -->
                            @if(request('date_filter'))
                                <input type="hidden" name="date_filter" value="{{ request('date_filter') }}">
                            @endif
                        </form>
                    </div>
                    
                    <!-- Date Filter Dropdown -->
                    <div>
                        <form method="GET" action="{{ route('authors.index') }}">
                            <select 
                                name="date_filter" 
                                class="px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0B3C5D] focus:border-[#0B3C5D] text-sm min-w-[140px]"
                                onchange="this.form.submit()"
                            >
                                <option value="">All Dates</option>
                                <option value="today" {{ request('date_filter') == 'today' ? 'selected' : '' }}>Today</option>
                                <option value="this_week" {{ request('date_filter') == 'this_week' ? 'selected' : '' }}>This Week</option>
                                <option value="this_month" {{ request('date_filter') == 'this_month' ? 'selected' : '' }}>This Month</option>
                                <option value="this_year" {{ request('date_filter') == 'this_year' ? 'selected' : '' }}>This Year</option>
                            </select>
                            <!-- Preserve search -->
                            @if(request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif
                        </form>
                    </div>
                    
                    <!-- Add Author Button -->
                    <div class="ml-auto">
                        <button @click="showModal = true" class="inline-flex items-center px-4 py-2.5 bg-[#0B3C5D] text-white rounded-lg hover:bg-[#1a4d6e] transition-colors text-sm font-medium whitespace-nowrap">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Add Author
                        </button>
                    </div>
                </div>
            </div>

            <!-- Authors Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Name
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Books Count
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Created At
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($authors as $author)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $author->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ $author->books_count }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $author->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('authors.show', $author) }}" class="p-2 bg-blue-50 rounded-lg border border-blue-200 text-blue-600 hover:bg-blue-100 transition-colors" title="View Author">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            </svg>
                                        </a>
                                        <button @click="selectedAuthor = {{ $author->id }}; showEditModal = true" class="p-2 bg-green-50 rounded-lg border border-green-200 text-green-600 hover:bg-green-100 transition-colors" title="Edit Author">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                            </svg>
                                        </button>
                                        <form action="{{ route('authors.destroy', $author) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this author?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 bg-red-50 rounded-lg border border-red-200 text-red-600 hover:bg-red-100 transition-colors" title="Delete Author">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                        <p class="text-lg font-medium text-gray-600 mb-1">No authors found</p>
                                        <p class="text-sm text-gray-400">Get started by adding your first author</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if ($authors->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    @include('pagination', ['paginator' => $authors])
                </div>
            @endif
        </div>

        <!-- Add Author Modal -->
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
                        <h3 class="text-lg font-semibold text-gray-900">Add New Author</h3>
                        <button @click="showModal = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <form action="{{ route('authors.store') }}" method="POST" class="p-6">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Author Name</label>
                                <input 
                                    type="text" 
                                    id="name"
                                    name="name" 
                                    required
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
                                ></textarea>
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
                                Save Author
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Author Modal -->
        <!-- Modal Overlay -->
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

        <!-- Modal Content -->
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
                    <form action="#" method="POST" class="p-6">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="author_id" x-model="selectedAuthor">
                        <div class="space-y-4">
                            <div>
                                <label for="edit_name" class="block text-sm font-medium text-gray-700 mb-1">Author Name</label>
                                <input 
                                    type="text" 
                                    id="edit_name"
                                    name="name" 
                                    required
                                    x-init="$watch('selectedAuthor', (value) => {
                                        if (value) {
                                            const author = {{ json_encode($authors->keyBy('id')->toArray()) }};
                                            $refs.edit_name.value = author[value]?.name || '';
                                            $refs.edit_email.value = author[value]?.email || '';
                                            $refs.edit_bio.value = author[value]?.bio || '';
                                        }
                                    })"
                                    x-ref="edit_name"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0B3C5D] focus:border-[#0B3C5D] text-sm"
                                    placeholder="Enter author name"
                                >
                            </div>

                            <div>
                                <label for="edit_email" class="block text-sm font-medium text-gray-700 mb-1">Email (Optional)</label>
                                <input 
                                    type="email" 
                                    id="edit_email"
                                    name="email" 
                                    x-ref="edit_email"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0B3C5D] focus:border-[#0B3C5D] text-sm"
                                    placeholder="Enter email address"
                                >
                            </div>

                            <div>
                                <label for="edit_bio" class="block text-sm font-medium text-gray-700 mb-1">Bio (Optional)</label>
                                <textarea 
                                    id="edit_bio"
                                    name="bio" 
                                    rows="3"
                                    x-ref="edit_bio"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#0B3C5D] focus:border-[#0B3C5D] text-sm"
                                    placeholder="Enter author biography"
                                ></textarea>
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
    </div>
</x-library-layout>
