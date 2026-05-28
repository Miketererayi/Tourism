@if ($paginator->hasPages())
    <nav class="pagination" aria-label="Pagination Navigation">
        
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="pagination-disabled">
                &laquo; Previous
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="pagination-link">
                &laquo; Previous
            </a>
        @endif

        {{-- Pagination Elements --}}
        <div class="pagination-pages">
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="pagination-dots">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="pagination-active">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" class="pagination-page">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="pagination-link">
                Next &raquo;
            </a>
        @else
            <span class="pagination-disabled">
                Next &raquo;
            </span>
        @endif
        
    </nav>
@endif
