@extends('admin.layout-management')





@section('title')
    管理者アカウントの管理
@endsection





@section('popup')
    <div class="container">
        <div class="modal" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">管理者アカウントを登録</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div id="div-alert"></div>
                        <form id="register-form" action="{{ route('admin.p_registerManagement') }}">
                            <div class="form-outline mb-3">
                                <label class="form-label" for="inp-name">名前 *</label>
                                <input type="text" id="inp-name" class="form-control"/>
                            </div>

                            <div class="form-outline mb-3">
                                <label class="form-label" for="inp-email">メール *</label>
                                <input type="email" id="inp-email" class="form-control"/>
                            </div>

                            <div class="form-outline mb-3">
                                <label class="form-label" for="inp-pass">パスワード *</label>
                                <input type="password" id="inp-pass" class="form-control"/>
                            </div>

                            <div class="form-outline mb-3">
                                <label class="form-label" for="inp-repass">再パスワード *</label>
                                <input type="password" id="inp-repass" class="form-control"/>
                            </div>

                            <div class="form-outline mb-3">
                                <label class="form-label" for="inp-group">グループ *</label>
                                <select class="form-select" name="group" id="inp-group">
                                    <option value="1" selected>管理者</option>
                                    <option value="2" >編集者</option>
                                    <option value="3" >レビュアー</option>
                                </select>
                            </div>

                            <div class="d-flex justify-content-center">
                                <button type="button" class="btn btn-info btn-block" onclick="submitRegisterFormAjax();">アカウントを登録</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="modal" id="myModal2">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">CSVをインポート</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    @if (session()->get('success'))
                        <div class="alert alert-success">
                            <ul> <li>{{ session()->get('success') }}</li> </ul>
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session()->get('error'))
                        <div class="alert alert-danger">
                            @php
                                $error = session()->get('error');
                                $errorStr = '';
                                foreach ($error as $key => $value) {
                                    $errorStr = 'Row' . strval($key) . '{';
                                    foreach ($value as $name => $message) {

                                        $errorStr = $errorStr . $name . ':' . implode(',', $message) . ';';
                                    }
                                    $errorStr = $errorStr . '}';
                                    echo "<ul> <li> " . $errorStr . "</li> </ul>";
                                }
                            @endphp

                        </div>
                    @endif
                    <div class="modal-body">
                        <div id="div-alert"></div>
                        <form id="form-uploadfile" enctype="multipart/form-data" method="POST" action="{{ route('admin.admin.p_importCsv') }}">
                            @csrf

                            <div class="input-group">
                                <input name="filecsv" type="file" class="form-control" id="file-csv" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
                                <button class="btn btn-outline-secondary" type="submit" id="inputGroupFileAddon04">アップロード</button>
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
    <p hidden id="url-pagination">{{ route('admin.admin.p_pagination') }}</p>
    <p hidden id="url-edit-admin">{{ route('admin.admin.p_edit') }}</p>
    <p hidden id="url-delete-admin">{{ route('admin.admin.p_delete') }}</p>

    <h3 class="title-category mb-40">
        <button class="btn btn-outline-dark" id="btn-menu-extend" style="display: inline; margin-right:15px">&larr;</button>管理者アカウントの管理
    </h3>


    <div class="d-flex flex-row-reverse">
        <div class="p-2">
            <button class="btn btn-info" type="button" data-bs-toggle="modal" data-bs-target="#myModal">アカウントを作成</button>
        </div>
        <div class="p-2">
            <button class="btn btn-info" onclick="exportCsv('{{ route('admin.admin.exportCsv') }}')" >CSVをエクスポート</button>
        </div>
        <div class="p-2">
            <button class="btn btn-info" type="button" data-bs-toggle="modal" data-bs-target="#myModal2">CSVをインポート</button>
        </div>
    </div>

    <div class="options">
        <form class="d-flex flex-row" id="search-form" action="{{ route('admin.admin.p_search') }}">

            <div class="p-2">
                <label class="form-label" for="search-name">名前</label>
                <input class="form-control" id="search-name" type="search">
            </div>

            <div class="p-2">
                <label class="form-label" for="search-email">メール</label>
                <input class="form-control" id="search-email" type="search">
            </div>

            <div class="p-2">
                <label class="form-label" for="filter-group">グループ</label>
                <select class="form-select" id="filter-group">
                    <option value="-1" selected>全部</option>
                    <option value="1">管理者</option>
                    <option value="2">編集者</option>
                    <option value="3">レビュアー</option>
                </select>
            </div>

            <div class="p-2">
                <label class="form-label" for="filter-status">スターテス</label>
                <select class="form-select" id="filter-status">
                    <option value="-1" selected>全部</option>
                    <option value="1">活動</option>
                    <option value="0">ロック</option>
                </select>
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
        @include('admin.pagination-admin-management')
    </div>
</div>

@endsection





@push('js')
    <script src="{{ asset('assets/js/admin-management.js') }}"></script>
@endpush

