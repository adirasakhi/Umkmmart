@if ($paginator->hasPages())
    <nav>
        <ul class="pagination d-flex justify-content-center mt-5">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link rounded" aria-hidden="true">&laquo;</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link rounded" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&laquo;</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page"><span class="page-link rounded">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link rounded" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link rounded" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&raquo;</a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link rounded" aria-hidden="true">&raquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif


<style>
    .page-link {
    color: #404040;
    text-decoration: none;
    background-color: #fff;
    border: 1px solid #dee2e6;
    padding: 8px 12px;
    margin: 0 4px;
}

.page-link:hover {
    color: #404040;
    background-color: #e9ecef;
    border-color: #dee2e6;
}

.page-item.active .page-link {
    color: #fff;
    background-color: #404040;
    border-color: #404040;
}

.page-item.disabled .page-link {
    color: #6c757d;
    pointer-events: none;
    background-color: #fff;
    border-color: #dee2e6;
}

.pagination {
    margin: 0;
    padding: 0;
    list-style: none;
}

</style>
