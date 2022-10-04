@include('components.pagination')

<div class="d-flex justify-content-end">
    <p>Hiển thị từ <strong> {{$record['min']}} </strong> đến <strong> {{$record['max']}} </strong> trong tổng số <strong> {{$record['total']}} </strong> khách hàng</p>
</div>

<div>
    <table class="table table-hover table-condensed">
        <thead>
            <tr>
                <th style="width:7%" class="text-center">ID</th>
                <th style="width:15%" class="text-center">Họ và tên</th>
                <th style="width:10%" class="text-center">Số đt</th>
                <th style="width:15%" class="text-center">Email</th>
                <th style="width:23%" class="text-center">Địa chỉ</th>
                <th style="width:10%" class="text-center">Trạng thái</th>
                <th style="width:12%" class="text-center">Ngày tạo</th>
                <th style="width:4%" class="text-center"></th>
                <th style="width:4%" class="text-center"></th>
            </tr>
        </thead>
        <tbody>
            <p hidden id="url-edit-customer">{{route('admin.p_editCustomerManagement')}}</p>
            <p hidden id="url-delete-customer">{{route('admin.p_deleteCustomerManagement')}}</p>
            <p hidden id="token-edit-customer">{{ csrf_token() }}</p>
            @foreach ($listCustomer as $item)
            <tr>
                <td data-th="ID">
                    #{{$item->customer_id}}
                </td>
                <td data-th="Name">
                    <input class="form-control inp-row-{{$item->customer_id}} inp-name" value="{{$item->customer_name}}" name="name" disabled>
                </td>
                <td data-th="Subtotal" class="Tel">
                    <input class="form-control inp-row-{{$item->customer_id}} inp-tel" value="{{$item->tel_num}}" name="tel" disabled>
                </td>
                <td class="actions" data-th="Email">
                    <input class="form-control inp-row-{{$item->customer_id}} inp-email" value="{{$item->email}}" name="email" disabled>
                </td>
                <td class="actions" data-th="Address">
                    <input class="form-control inp-row-{{$item->customer_id}} inp-address" value="{{$item->address}}" name="address" disabled>
                </td>
                <td class="actions" data-th="Status">
                    <select class="form-select inp-row-{{$item->customer_id}} inp-status" name="status" aria-label="Disabled select example" disabled>
                        <option value="1" {{($item->is_active == 1)?'selected':''}}>Hoạt động</option>
                        <option value="0" {{($item->is_active == 0)?'selected':''}}>Tạm khóa</option>
                    </select>
                </td>
                <td class="actions" data-th="CreatedAt">
                    {{$item->created_at}}
                </td>
                <td class="actions" data-th="Edit">
                    <button class="btn btn-outline-warning" id="btn-edit-inp-{{$item->customer_id}}" onclick="editCustomerId({{$item->customer_id}});">Sửa</button>
                </td>
                <td class="actions" data-th="Remove">
                    <button class="btn btn-outline-danger" id="btn-edit-inp-{{$item->customer_id}}" onclick="deleteCustomerId({{$item->customer_id}});">Xóa</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@include('components.pagination')
