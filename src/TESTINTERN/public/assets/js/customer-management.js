function editCustomerId(id) {
    let btnEdit = document.getElementById('btn-edit-inp-' + id);
    let arrInp = document.getElementsByClassName('inp-row-' + id);

    if (btnEdit.textContent == "編集") {
        for (let index = 0; index < arrInp.length; index++) {
            arrInp[index].disabled = false;
            btnEdit.innerText = "セーブ";
            btnEdit.className = "btn btn-outline-success";
        }
    }
    else if (btnEdit.textContent == "セーブ") {
        $.ajax({
            type: 'POST',
            cache: false,
            url: document.getElementById('url-edit-customer').textContent,
            data: {
                "_token": document.getElementById('token-edit-customer').textContent,
                "id": id,
                "name": arrInp[0].value,
                "tel": arrInp[1].value,
                "email": arrInp[2].value,
                "address": arrInp[3].value,
                "is_active": arrInp[4].value
            },
            success: function(data) {
                console.log(data);
                for (let index = 0; index < arrInp.length; index++) {
                    arrInp[index].disabled = true;
                    btnEdit.innerText = "編集";
                    btnEdit.className = "btn btn-outline-warning";
                }
                alert("アカウント情報が正常に更新されました。")
            },
            error: function(data) {
                var errors = data.responseJSON;
                var errorArr = '';

                $.each( errors.errors, function( key, value ) {
                    errorArr += '- ' + value[0] + '\n';
                });

                errorArr = 'アカウント情報が正常に更新されませんでした。\n' + errorArr;
                alert(errorArr);
            },
        });
    }

}

function deleteCustomerId(id) {
    var currentPage = document.getElementById('current-page').textContent;

    var result = confirm("顧客アカウントの #" + id + " を削除してもよろしいですか?");
    if (result == true) {
        $.ajax({
            type: 'POST',
            cache: false,
            url: document.getElementById('url-delete-customer').textContent,
            data: {
                "_token": document.getElementById('token-edit-customer').textContent,
                "id": id
            },
            success: function(data) {
                console.log(data);
                alert("顧客アカウントを削除しました。");
                page(currentPage);
            },
            error: function(data) {
                var errors = data.responseJSON;
                var errorArr = '';

                $.each( errors.errors, function( key, value ) {
                    errorArr += '- ' + value[0] + '\n';
                });

                errorArr = '顧客アカウントを削除できませんでした。\n' + errorArr;
                alert(errorArr);
            },
        });
    }
}

function submitSearchFormAjax(delSearch)
{
    var email = document.getElementById('search-email').value;
    var name = document.getElementById('search-name').value;
    var address = document.getElementById('search-address').value;
    var is_active = document.getElementById('filter-status').value;

    email = email.trim().replace(/^\s+|\s+$/gm,'');
    name = name.trim().replace(/^\s+|\s+$/gm,'');
    address = address.trim().replace(/^\s+|\s+$/gm,'');
    is_active = (is_active == 1 || is_active == 0) ? is_active : -1;

    if(delSearch == 1) {
        email = '';
        name = '';
        address = '';
        is_active = -1;
    }
    else if (email == '' && name == '' && address == '' && is_active == -1) {
        alert("Bạn chưa nhập thông tin tìm kiếm");
        return;
    }

    $.ajax({
        type: 'POST',
        cache: false,
        url: document.getElementById('search-form').action,
        data: {
            "_token": document.getElementById('token-search').textContent,
            "email": (email == '') ? null : email,
            "name": (name == '') ? null : name,
            "address": (address == '') ? null : address,
            "is_active": (is_active == '') ? null : is_active,
        },
        success: function(data) {
            console.log('success');
            document.getElementById('pagination-content').innerHTML = data;
        },
        error: function(data) {
            console.log(data);
        },
    });
}

function submitRegisterFormAjax()
{
    var urlAction = document.getElementById('register-form').action;

    var currentPage = document.getElementById('current-page').textContent;
    var token = document.getElementById('token-register').textContent;
    var dataName = document.getElementById('inp-name').value;
    var dataEmail = document.getElementById('inp-email').value;
    var dataTel = document.getElementById('inp-tel').value;
    var dataPass = document.getElementById('inp-pass').value;
    var dataRePass = document.getElementById('inp-repass').value;
    var dataAddress = document.getElementById('inp-address').value;

    $.ajax({
        type: 'POST',
        cache: false,
        url: urlAction,
        data: {
            "_token": token,
            "name": dataName,
            "email": dataEmail,
            "tel": dataTel,
            "pass": dataPass,
            "re-pass": dataRePass,
            "address": dataAddress,
            "agree-rule" : true
        },
        success: function(data){
            var success = data.responseJSON;
            console.log(success);
            successHtml = '<div class="alert alert-success"><ul>';
            successHtml += '<li> Đăng ký tài khoản thành công</li>';
            successHtml += '</ul></div>';

            $( '#div-alert' ).html( successHtml );
            document.getElementById("register-form").reset();

            //load lai du lieu
            page(currentPage);
        },
        error: function(data){
            var errors = data.responseJSON;
            errorsHtml = '<div class="alert alert-danger"><ul>';

            $.each( errors.errors, function( key, value ) {
                errorsHtml += '<li>' + value[0] + '</li>';
            });
            errorsHtml += '</ul></div>';

            $( '#div-alert' ).html( errorsHtml );
        },
    });
}

function deleteSearchFormAjax()
{
    submitSearchFormAjax(1);
}

function exportCsv(urlCsv)
{
    var email = document.getElementById('search-email').value;
    var name = document.getElementById('search-name').value;
    var is_active = document.getElementById('filter-status').value;
    var address = document.getElementById('search-address').value;

    email = email.trim().replace(/^\s+|\s+$/gm,'');
    name = name.trim().replace(/^\s+|\s+$/gm,'');
    is_active = (is_active >= 0 && is_active <= 1) ? is_active : -1;
    address = address.trim().replace(/^\s+|\s+$/gm,'');

    var url = urlCsv + '?';

    if (name != '' && name != null) url += 'name=' + name;
    if (email != '' && email != null) url += '&email=' + email;
    if (is_active != '-1' && is_active != null) url += '&is_active=' + is_active;
    if (address != '' && address != null) url += '&address=' + address;

    location.href = url;
}

function pagination(page = 1)
{
    var token = document.getElementById('token-pagination').textContent;
    var email = document.getElementById('search-email').value;
    var name = document.getElementById('search-name').value;
    var address = document.getElementById('search-address').value;
    var is_active = document.getElementById('filter-status').value;

    email = email.trim().replace(/^\s+|\s+$/gm,'');
    name = name.trim().replace(/^\s+|\s+$/gm,'');
    address = address.trim().replace(/^\s+|\s+$/gm,'');
    is_active = (is_active == 1 || is_active == 0) ? is_active : -1;


    $.ajax({
        type: 'POST',
        cache: false,
        url: document.getElementById('url-pagination').textContent,
        data: {
            "_token": token,
            "page": page,
            "email": (email == '') ? null : email,
            "name": (name == '') ? null : name,
            "address": (address == '') ? null : address,
            "is_active": (is_active == '') ? -1 : is_active,
        },
        success: function(data) {
            console.log('success');
            document.getElementById('pagination-content').innerHTML = data;
        },
        error: function(data) {
            console.log(data);
        },
    });
}
