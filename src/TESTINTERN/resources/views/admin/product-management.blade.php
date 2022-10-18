@extends('admin.layout-management')





@section('title')
製品の管理
@endsection





@section('popup')
<div class="container">
    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header flex">
                    <h5 id="title-popup" style="max-width:80%" class="modal-title">製品を作成</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="div-alert"></div>
                    <form id="product-form" enctype="multipart/form-data" action="">
                        <p hidden id="url-product">{{ route('admin.product.p_product') }}</p>
                        <p hidden id="token-product">{{ csrf_token() }}</p>
                        @csrf
                        <input hidden name="id" id="id-product">
                        <div class="form-outline mb-3">
                            <label class="form-label" for="inp-email">製品の名前 *</label>
                            <input type="text" class="form-control" placeholder="BMW" id="inp-name" name="name">
                        </div>

                        <div class="form-outline mb-3">
                            <label class="form-label" for="inp-name">製品の画像 *</label>
                            <div class="input-group mb-3" id="div-img-product">
                                <input type="file" name="image" class="form-control" id="inp-img" accept="image/*" onchange="onchangeImageFile();">
                                {{-- <label class="input-group-text" for="inputGroupFile02">アップロード</label> --}}
                            </div>
                        </div>

                        <div class="form-outline mb-3">
                            <img id="img-product" style="width: 100%; height:auto;" src="">
                        </div>

                        <div class="form-outline mb-3">
                            <label class="form-label" for="inp-price">値段 *</label>
                            <div class="input-group flex-nowrap">
                                <span class="input-group-text" id="addon-wrapping">$</span>
                                <input type="number" class="form-control" name="price" placeholder="100" id="inp-price">
                            </div>
                        </div>

                        <div class="form-outline mb-3">
                            <label class="form-label" for="inp-email">説明 *</label>
                            <textarea class="form-control" name="description" placeholder="製品の説明。。。" id="inp-desciption"></textarea>
                        </div>

                        <div class="form-outline mb-3">
                            <label class="form-label" for="inp-email">スターテス *</label>
                            <select class="form-select" name="is_sales" id="inp-sales">
                                <option value="1" selected>活動</option>
                                <option value="0">ロック</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-center">
                            <button id="submit-popup" type="submit" class="btn btn-outline-success btn-block">Lưu sản phẩm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection





@section('content')
<div class="right-sidebar">
    <p hidden id="url-pagination">{{route('admin.product.p_pagination')}}</p>
    <p hidden id="token-pagination">{{csrf_token()}}</p>

    <h3 class="title-category mb-40">
        <button class="btn btn-outline-dark" id="btn-menu-extend" style="display: inline; margin-right:15px">&larr;</button>製品の管理
    </h3>


    <div class="d-flex flex-row-reverse">
        <div class="p-2">
            <button class="btn btn-info" type="button" onclick="addProduct('{{route('admin.product.p_add')}}');">製品を作成</button>
        </div>
    </div>

    <div class="options">
        <form class="d-flex flex-row" id="search-form" action="{{route('admin.product.p_search')}}">
            <p hidden id="token-search">{{ csrf_token() }}</p>
            <div class="p-2">
                <label class="form-label" for="search-name">製品の名前</label>
                <input class="form-control" id="search-name" type="search" placeholder="製品の名前を入力。。。">
            </div>
            <div class="p-2">
                <label class="form-label" for="filter-sales">スターテス</label>
                <select class="form-select" id="filter-sales" style="width: 200px">
                    <option value="-1" selected>全部</option>
                    <option value="1">活動</option>
                    <option value="0">ロック</option>
                </select>
            </div>

            <div class="p-2">
                <label class="form-label" for="search-price-min">から</label>
                <input class="form-control" id="search-price-min" style="width: 100px" type="search" placeholder="10">
            </div>
            <div class="align-self-end p-2">
                ～
            </div>
            <div class="p-2">
                <label class="form-label" for="search-price-max">まで</label>
                <input class="form-control" id="search-price-max" style="width: 100px" type="search" placeholder="100">
            </div>
            <div class="align-self-end p-2">
                <button class="btn btn-outline-dark" type="button" onclick="submitSearchFormAjax();">検索</button>
            </div>
            <div class="align-self-end p-2">
                <button class="btn btn-outline-dark" type="reset" onclick="deleteSearchFormAjax();">検索を削除</button>
            </div>
        </form>
    </div>



    <div class="mt-3" id="pagination-content">
        @include('admin.pagination-product-management')
    </div>
</div>

@endsection





@section('js')
    <script src="{{asset('assets/js/product-management.js')}}"></script>
@endsection

