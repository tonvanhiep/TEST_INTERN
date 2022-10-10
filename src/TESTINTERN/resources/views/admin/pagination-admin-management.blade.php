@include('components.pagination')

<div class="d-flex justify-content-end">
    <p>Hiển thị từ <strong> {{($record['min'] >= 0) ? $record['min'] : 0}} </strong> đến <strong> {{$record['max']}} </strong> trong tổng số <strong> {{$record['total']}} </strong> admin</p>
</div>

<div>
    <table class="table table-hover table-condensed">
        <thead>
            <tr>
                <th style="width:10%" class="text-center">ID</th>
                <th style="width:15%" class="text-center">Họ và tên</th>
                <th style="width:20%" class="text-center">Email</th>
                <th style="width:15%" class="text-center">Nhóm</th>
                <th style="width:15%" class="text-center">Trạng thái</th>
                <th style="width:15%" class="text-center">Ngày tạo</th>
                <th style="width:5%" class="text-center"></th>
                <th style="width:5%" class="text-center"></th>
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
                        <option value="1" {{($item->group_role == 1)?'selected':''}}>Admin</option>
                        <option value="2" {{($item->group_role == 2)?'selected':''}}>Editer</option>
                        <option value="3" {{($item->group_role == 3)?'selected':''}}>Reviewer</option>
                    </select>
                </td>
                <td class="actions" data-th="Status">
                    <select class="form-select inp-row-{{$item->admin_id}} inp-status" name="status" aria-label="Disabled select example" disabled>
                        <option value="1" {{($item->is_active == 1)?'selected':''}}>Hoạt động</option>
                        <option value="0" {{($item->is_active == 0)?'selected':''}}>Tạm khóa</option>
                    </select>
                </td>
                <td class="actions" data-th="CreatedAt">
                    {{$item->created_at}}
                </td>
                <td class="actions" data-th="Edit">
                    <button class="btn btn-outline-warning" id="btn-edit-inp-{{$item->admin_id}}" onclick="editAdminId({{$item->admin_id}});">Sửa</button>
                </td>
                <td class="actions" data-th="Remove">
                    <button class="btn btn-outline-danger" id="btn-edit-inp-{{$item->admin_id}}" onclick="deleteAdminId({{$item->admin_id}});">Xóa</button>
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
