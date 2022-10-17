@include('components.pagination')

<div class="d-flex justify-content-end">
    <p><strong> {{$record['total']}} </strong> 行で<strong> {{($record['min'] >= 0) ? $record['min'] : 0}} </strong>行から<strong> {{$record['max']}} </strong>行まで表示</p>
</div>

<div>
    <table class="table table-hover table-condensed">
        <thead>
            <tr>
                <th style="width:10%" class="text-center">ID</th>
                <th style="width:15%" class="text-center">名前</th>
                <th style="width:20%" class="text-center">メール</th>
                <th style="width:15%" class="text-center">グループ</th>
                <th style="width:11%" class="text-center">スターテス</th>
                <th style="width:15%" class="text-center">作成日</th>
                <th style="width:7%" class="text-center"></th>
                <th style="width:7%" class="text-center"></th>
            </tr>
        </thead>
        <tbody>
            <p hidden id="url-edit-admin">{{route('admin.admin.p_edit')}}</p>
            <p hidden id="url-delete-admin">{{route('admin.admin.p_delete')}}</p>
            <p hidden id="token-edit-admin">{{ csrf_token() }}</p>
            @foreach ($listAdmin as $item)
            <tr>
                <td data-th="ID">
                    #{{$item->admin_id}}
                </td>
                <td data-th="Name">
                    <input class="form-control inp-row-{{$item->admin_id}} inp-name" value="{{$item->name}}" name="name" disabled>
                </td>
                <td class="actions" data-th="Email">
                    <input class="form-control inp-row-{{$item->admin_id}} inp-email" value="{{$item->email}}" name="email" disabled>
                </td>
                <td class="actions" data-th="Group">
                    <select class="form-select inp-row-{{$item->admin_id}} inp-status" name="status" aria-label="Disabled select example" disabled>
                        <option value="1" {{($item->group_role == 1)?'selected':''}}>管理者</option>
                        <option value="2" {{($item->group_role == 2)?'selected':''}}>編集者</option>
                        <option value="3" {{($item->group_role == 3)?'selected':''}}>レビュアー</option>
                    </select>
                </td>
                <td class="actions" data-th="Status">
                    <select class="form-select inp-row-{{$item->admin_id}} inp-status" name="status" aria-label="Disabled select example" disabled>
                        <option value="1" {{($item->is_active == 1)?'selected':''}}>活動</option>
                        <option value="0" {{($item->is_active == 0)?'selected':''}}>ロック</option>
                    </select>
                </td>
                <td class="actions" data-th="CreatedAt">
                    {{$item->created_at}}
                </td>
                <td class="actions" data-th="Edit">
                    <button class="btn btn-outline-warning" id="btn-edit-inp-{{$item->admin_id}}" onclick="editAdminId({{$item->admin_id}});">編集</button>
                </td>
                <td class="actions" data-th="Remove">
                    <button class="btn btn-outline-danger" id="btn-edit-inp-{{$item->admin_id}}" onclick="deleteAdminId({{$item->admin_id}});">削除</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @php
        if(count($listAdmin) === 0) {
            echo "Không có dữ liệu";
        }
    @endphp
</div>

@include('components.pagination')
