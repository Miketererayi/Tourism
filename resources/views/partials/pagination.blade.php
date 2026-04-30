@if ($paginator->hasPages())
    <nav style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--border); padding-top: 1.5rem;" aria-label="Pagination Navigation">
        
        <!-- Previous Page Link -->
        @if ($paginator->onFirstPage())
            <span style="padding: 0.5rem 1rem; color: var(--text-muted); cursor: not-allowed; border: 1px solid var(--border); border-radius: var(--radius); background: var(--surface); opacity: 0.5;">
                &laquo; Previous
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" style="padding: 0.5rem 1rem; color: var(--text); border: 1px solid var(--border); border-radius: var(--radius); background: var(--surface); transition: background 0.2s;">
                &laquo; Previous
            </a>
        @endif

        <!-- Pagination Elements -->
        <div style="display: none; @media (min-width: 640px) { display: flex; } gap: 0.25rem;">
            @foreach ($elements as $element)
                <!-- "Three Dots" Separator -->
                @if (is_string($element))
                    <span style="padding: 0.5rem; color: var(--text-muted);">{{ $element }}</span>
                @endif

                <!-- Array Of Links -->
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span style="padding: 0.5rem 1rem; background: var(--primary); color: white; border-radius: var(--radius); font-weight: 600;">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" style="padding: 0.5rem 1rem; color: var(--text); border-radius: var(--radius); transition: background 0.2s;" onmouseover="this.style.background='var(--border)'" onmouseout="this.style.background='transparent'">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        <!-- Next Page Link -->
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" style="padding: 0.5rem 1rem; color: var(--text); border: 1px solid var(--border); border-radius: var(--radius); background: var(--surface); transition: background 0.2s;">
                Next &raquo;
            </a>
        @else
            <span style="padding: 0.5rem 1rem; color: var(--text-muted); cursor: not-allowed; border: 1px solid var(--border); border-radius: var(--radius); background: var(--surface); opacity: 0.5;">
                Next &raquo;
            </span>
        @endif
        
    </nav>
@endif
