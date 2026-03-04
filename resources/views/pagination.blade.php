@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
        <div class="text-sm text-gray-700">
            Showing 
            <span class="font-medium">{{ $paginator->firstItem() }}</span>
            to 
            <span class="font-medium">{{ $paginator->lastItem() }}</span>
            of 
            <span class="font-medium">{{ $paginator->total() }}</span>
            results
        </div>

        <ul class="flex items-center space-x-1">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-300 bg-gray-100 rounded-md cursor-not-allowed">
                    <span>Previous</span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 transition-colors">
                        <span>Previous</span>
                    </a>
                </li>
            @endif

            {{-- First Page --}}
            @if ($paginator->currentPage() > 3)
                <li>
                    <a href="{{ $paginator->url(1) }}" class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 transition-colors">
                        <span>1</span>
                    </a>
                </li>
                
                {{-- Three Dots --}}
                @if ($paginator->currentPage() > 4)
                    <li class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700">
                        <span>...</span>
                    </li>
                @endif
            @endif

            {{-- Page Numbers --}}
            @for ($page = max(1, $paginator->currentPage() - 2); $page <= min($paginator->lastPage(), $paginator->currentPage() + 2); $page++)
                @if ($page == $paginator->currentPage())
                    <li class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-[#0B3C5D] border border-[#0B3C5D] rounded-md">
                        <span>{{ $page }}</span>
                    </li>
                @else
                    <li>
                        <a href="{{ $paginator->url($page) }}" class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 transition-colors">
                            <span>{{ $page }}</span>
                        </a>
                    </li>
                @endif
            @endfor

            {{-- Last Page --}}
            @if ($paginator->currentPage() < $paginator->lastPage() - 2)
                {{-- Three Dots --}}
                @if ($paginator->currentPage() < $paginator->lastPage() - 3)
                    <li class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700">
                        <span>...</span>
                    </li>
                @endif
                
                <li>
                    <a href="{{ $paginator->url($paginator->lastPage()) }}" class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 transition-colors">
                        <span>{{ $paginator->lastPage() }}</span>
                    </a>
                </li>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 transition-colors">
                        <span>Next</span>
                    </a>
                </li>
            @else
                <li class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-300 bg-gray-100 rounded-md cursor-not-allowed">
                    <span>Next</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
