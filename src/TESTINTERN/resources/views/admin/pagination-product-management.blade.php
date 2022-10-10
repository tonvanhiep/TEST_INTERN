@include('components.pagination')

<div class="d-flex justify-content-end">
    <p>Hiển thị từ <strong> {{($record['min'] >= 0) ? $record['min'] : 0}} </strong> đến <strong> {{$record['max']}} </strong> trong tổng số <strong> {{$record['total']}} </strong> sản phẩm</p>
</div>


<style>
    .div-img {
        position: relative;
    }
    .img-product {
        position: absolute;
        top: 0px;
        background-color:silver;
        border-radius: 10px;
        z-index: 1;
    }
    .img-product img {
        height: auto;
        width: 40vw;
        min-width: 300px;
        max-width: 1000px;
        z-index: 1;
        margin: 15px;
    }
    .inp-name + .img-product {
        display: none;
    }

    .inp-name:hover + .img-product {
        display: block;
        font-size: 25px;
    }
</style>


<div>
    <table class="table table-hover table-condensed">
        <thead>
            <tr>
                <th style="width:5%" class="text-center">ID</th>
                <th style="width:15%" class="text-center">名前</th>
                <th style="width:32%" class="text-center">Mô tả</th>
                <th style="width:8%" class="text-center">Giá bán</th>
                <th style="width:10%" class="text-center">Trạng thái</th>
                <th style="width:12%" class="text-center">Ngày tạo</th>
                <th style="width:9%" class="text-center"></th>
                <th style="width:4%" class="text-center"></th>
            </tr>
        </thead>
        <tbody>
            <p hidden id="url-edit-product">{{route('admin.product.p_edit')}}</p>
            <p hidden id="url-delete-product">{{route('admin.product.p_delete')}}</p>
            <p hidden id="token-edit-product">{{ csrf_token() }}</p>

            @foreach ($listProduct as $item)
            <tr>
                <td data-th="ID">
                    #{{$item->product_id}}
                </td>
                <td data-th="Name" class="div-img">
                    <input class="form-control inp-row-{{$item->product_id}} inp-name" value="{{$item->product_name}}" name="name" disabled>
                    <div class="img-product">
                        <img id="img-row-{{$item->product_id}}" src="{{$item->product_image}}" alt="{{$item->product_name}}">
                    </div>
                </td>
                <td data-th="Description">
                    {{-- <input class="form-control inp-row-{{$item->description}} inp-name" value="{{$item->description}}" name="description" disabled> --}}
                    <textarea class="form-control inp-row-{{$item->product_id}} inp-description" name="description" disabled>{{$item->description}}</textarea>
                </td>
                <td data-th="Price">
                    <input class="form-control inp-row-{{$item->product_id}} inp-price" value="{{$item->product_price}}" name="price" disabled>
                </td>
                <td class="actions" data-th="Status">
                    <select class="form-select inp-row-{{$item->product_id}} inp-status" name="status" aria-label="Disabled select example" disabled>
                        <option value="1" {{($item->is_sales == 1)?'selected':''}}>Đang bán</option>
                        <option value="0" {{($item->is_sales == 0)?'selected':''}}>Tạm ngừng</option>
                    </select>
                </td>
                <td class="actions" data-th="CreatedAt">
                    {{$item->created_at}}
                </td>
                <td class="actions" data-th="Edit">
                    <button class="btn btn-outline-success" id="btn-edit-inp-{{$item->product_id}}" onclick="displayProductId({{$item->product_id}});">Chi tiết</button>
                </td>
                <td class="actions" data-th="Remove">
                    <button class="btn btn-outline-danger" id="btn-edit-inp-{{$item->product_id}}" onclick="deleteProductId({{$item->product_id}});">Xóa</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @php
        if(count($listProduct) === 0) {
            echo "Không có dữ liệu";
        }
    @endphp
</div>

@include('components.pagination')
