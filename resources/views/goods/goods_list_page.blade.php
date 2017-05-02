@if ($paginator->hasPages())
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <button class="page-item btn btn-default btn-lg disabled"><span class="page-link">&laquo; 上一页</span></button>
        @else
            <button class="page-item btn btn-default btn-lg"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo; 上一页</a></button>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <button class="page-item btn btn-default btn-lg pull-right"><a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">下一页 &raquo;</a></button>
        @else
            <button class="page-item btn btn-default btn-lg disabled pull-right"><span class="page-link">下一页 &raquo;</span></button>
        @endif
@endif
