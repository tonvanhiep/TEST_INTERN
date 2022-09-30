@if (isset($currentpage) && isset($totalpage))
    <div>
        <ul class="pagination">
            @if ($currentpage >= 3)
                <li class="page-item">
                    <a onclick="page(1);" class="page-link" aria-label="Next">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
            @endif

            @if ($currentpage >= 2)
                <li class="page-item">
                    <a onclick="page({{$currentpage - 1}})"; class="page-link" aria-label="Previous">
                        <span aria-hidden="true">&lsaquo;</span>
                    </a>
                </li>
            @endif

            @for ($i = 1; $i <= $totalpage; $i++)
                @if (($i > 3 && $i < $currentpage - 2) || ($i > $currentpage + 2 && $i < $totalpage - 2))
                    <li class="page-item">
                        <a class="page-link">&hellip;</a>
                    </li>

                    @php
                        if($i > 3 && $i < $currentpage - 2) {
                            $i = $currentpage - 3;
                        }
                        else if ($i > $currentpage + 2 && $i < $totalpage - 2) {
                            $i = $totalpage - 3;
                        }
                    @endphp
                @else
                    <li class="page-item {{($i == $currentpage)?'active':''}}">
                        <a class="page-link" onclick="page({{$i}});">{{$i}}</a>
                    </li>
                @endif

            @endfor

            @if ($currentpage < $totalpage)
                <li class="page-item">
                    <a onclick="page({{$currentpage + 1}});" class="page-link" aria-label="Next">
                        <span aria-hidden="true">&rsaquo;</span>
                    </a>
                </li>
            @endif

            @if ($currentpage < $totalpage - 1)
                <li class="page-item">
                    <a onclick="page({{$totalpage}});" class="page-link" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            @endif
        </ul>
    </div>
@endif
