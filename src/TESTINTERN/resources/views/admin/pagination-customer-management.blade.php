@include('components.pagination')

<div class="d-flex justify-content-end">
    <p><strong> {{ $record['total'] }} </strong> 行で <strong> {{ ($record['min'] >= 0) ? $record['min'] : 0 }} </strong> 行から <strong> {{ $record['max'] }} </strong> 行まで表示</p>
</div>

<div style="overflow-x:auto;">
    <table class="table table-hover table-condensed">
        <thead>
            <tr>
                <th style="width:7%" class="text-center">ID</th>
                <th style="width:15%" class="text-center">名前</th>
                <th style="width:10%" class="text-center">電話番後</th>
                <th style="width:15%" class="text-center">メール</th>
                <th style="width:21%" class="text-center">住所</th>
                <th style="width:8%" class="text-center">スターテス</th>
                <th style="width:12%" class="text-center">作成日</th>
                <th style="width:6%" class="text-center"></th>
                <th style="width:6%" class="text-center"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($listCustomer as $item)
            <tr>
                <td data-th="ID">
                    #{{ $item->customer_id }}
                </td>
                <td data-th="Name">
                    <input style="min-width: max-content" class="form-control inp-row-{{ $item->customer_id }} inp-name" value="{{ $item->customer_name }}" name="name" disabled>
                </td>
                <td data-th="Subtotal" class="Tel">
                    <input style="min-width: max-content" class="form-control inp-row-{{ $item->customer_id }} inp-tel" value="{{ $item->tel_num }}" name="tel" disabled>
                </td>
                <td class="actions" data-th="Email">
                    <input style="min-width: max-content" class="form-control inp-row-{{ $item->customer_id }} inp-email" value="{{ $item->email }}" name="email" disabled>
                </td>
                <td class="actions" data-th="Address">
                    <input style="min-width: max-content" class="form-control inp-row-{{ $item->customer_id }} inp-address" value="{{ $item->address }}" name="address" disabled>
                </td>
                <td class="actions" data-th="Status">
                    <select style="min-width: max-content" class="form-select inp-row-{{$item->customer_id}} inp-status" name="status" aria-label="Disabled select example" disabled>
                        <option value="1" {{ ($item->is_active == 1) ? 'selected' : '' }}>活動</option>
                        <option value="0" {{ ($item->is_active == 0) ? 'selected' : '' }}>ロック</option>
                    </select>
                </td>
                <td class="actions" data-th="CreatedAt">
                    {{ $item->created_at }}
                </td>
                <td class="actions" data-th="Edit">
                    <button class="btn btn-outline-warning" id="btn-edit-inp-{{ $item->customer_id }}" onclick="editCustomerId({{ $item->customer_id }});">編集</button>
                </td>
                <td class="actions" data-th="Remove">
                    <button class="btn btn-outline-danger" id="btn-edit-inp-{{ $item->customer_id }}" onclick="deleteCustomerId({{ $item->customer_id }});">削除</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @if (count($listCustomer) === 0)
            <p>データがありません</p>
    @endif
</div>

@include('components.pagination')
