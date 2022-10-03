@if (isset($currentPage) && isset($totalPage))
<div class="d-flex justify-content-center">
    <div>
        <ul class="pagination">
            @if ($currentPage >= 3)
                <li class="page-item">
                    <a onclick="page(1);" class="page-link" aria-label="Next">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            @endif

            @if ($currentPage >= 2)
                <li class="page-item">
                    <a onclick="page({{$currentPage - 1}})"; class="page-link" aria-label="Previous">
                        <span aria-hidden="true">&lsaquo;</span>
                    </a>
                </li>
            @endif

            @for ($i = 1; $i <= $totalPage; $i++)
                @if (($i > 3 && $i < $currentPage - 2) || ($i > $currentPage + 2 && $i < $totalPage - 2))
                    <li class="page-item">
                        <a class="page-link">&hellip;</a>
                    </li>

                    @php
                        if($i > 3 && $i < $currentPage - 2) {
                            $i = $currentPage - 3;
                        }
                        else if ($i > $currentPage + 2 && $i < $totalPage - 2) {
                            $i = $totalPage - 3;
                        }
                    @endphp
                @else
                    <li class="page-item {{($i == $currentPage)?'active':''}}">
                        <a class="page-link" onclick="page({{$i}});">{{$i}}</a>
                    </li>
                @endif

            @endfor

            @if ($currentPage < $totalPage)
                <li class="page-item">
                    <a onclick="page({{$currentPage + 1}});" class="page-link" aria-label="Next">
                        <span aria-hidden="true">&rsaquo;</span>
                    </a>
                </li>
            @endif

            @if ($currentPage < $totalPage - 1)
                <li class="page-item">
                    <a onclick="page({{$totalPage}});" class="page-link" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            @endif
        </ul>
    </div>
</div>
@endif
