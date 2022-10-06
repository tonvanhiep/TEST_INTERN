function editAdminId(id) {
    let btnEdit = document.getElementById('btn-edit-inp-' + id);
    let arrInp = document.getElementsByClassName('inp-row-' + id);

    if (btnEdit.textContent == "Sửa") {
        for (let index = 0; index < arrInp.length; index++) {
            arrInp[index].disabled = false;
            btnEdit.innerText = "Lưu";
            btnEdit.className = "btn btn-outline-success";
        }
    }
    else if (btnEdit.textContent == "Lưu") {
        $.ajax({
            type: 'POST',
            cache: false,
            url: document.getElementById('url-edit-admin').textContent,
            data: {
                "_token": document.getElementById('token-edit-admin').textContent,
                "id": id,
                "name": arrInp[0].value,
                "email": arrInp[1].value,
                "group": arrInp[2].value,
                "is_active": arrInp[3].value
            },
            success: function(data) {
                console.log(data);
                for (let index = 0; index < arrInp.length; index++) {
                    arrInp[index].disabled = true;
                    btnEdit.innerText = "Sửa";
                    btnEdit.className = "btn btn-outline-warning";
                }
                alert("Cập nhật thông tin thành công!!")
            },
            error: function(data) {
                var errors = data.responseJSON;
                var errorArr = '';

                $.each( errors.errors, function( key, value ) {
                    errorArr += '- ' + value[0] + '\n';
                });

                errorArr = 'Cập nhật thông tin không thành công.\n' + errorArr;
                alert(errorArr);
            },
        });
    }

}

function deleteAdminId(id) {
    var currentPage = document.getElementById('current-page').textContent;

    var result = confirm("Bạn có chắc chắn xóa người dùng #" + id + "?");
    if (result == true) {
        $.ajax({
            type: 'POST',
            cache: false,
            url: document.getElementById('url-delete-admin').textContent,
            data: {
                "_token": document.getElementById('token-edit-admin').textContent,
                "id": id
            },
            success: function(data) {
                console.log(data);
                alert("Xóa người dùng thành công!!!");
                pagination(currentPage);
            },
            error: function(data) {
                var errors = data.responseJSON;
                var errorArr = '';

                $.each( errors.errors, function( key, value ) {
                    errorArr += '- ' + value[0] + '\n';
                });

                errorArr = 'Xóa người dùng không thành công!\n' + errorArr;
                alert(errorArr);
            },
        });
    }
}

function submitSearchFormAjax(delSearch = 0)
{
    var email = document.getElementById('search-email').value;
    var name = document.getElementById('search-name').value;
    var group = document.getElementById('filter-group').value;
    var is_active = document.getElementById('filter-status').value;

    email = email.trim().replace(/^\s+|\s+$/gm,'');
    name = name.trim().replace(/^\s+|\s+$/gm,'');
    group = (group < 1 || group > 3) ? -1 : group;
    is_active = (is_active == 1 || is_active == 0) ? is_active : -1;

    if(delSearch == 1) {
        email = '';
        name = '';
        group = -1;
        is_active = -1;
    }
    else if (email == '' && name == '' && group == -1 && is_active == -1) {
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
            "group": (group == '') ? -1 : group,
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
    var dataPass = document.getElementById('inp-pass').value;
    var dataRePass = document.getElementById('inp-repass').value;
    var dataGroup = document.getElementById('inp-group').value;

    $.ajax({
        type: 'POST',
        cache: false,
        url: urlAction,
        data: {
            "_token": token,
            "name": dataName,
            "email": dataEmail,
            "pass": dataPass,
            "re-pass": dataRePass,
            "group": dataGroup,
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
            pagination(currentPage);
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

function pagination(page = 1)
{
    var token = document.getElementById('token-pagination').textContent;
    var email = document.getElementById('search-email').value;
    var name = document.getElementById('search-name').value;
    var group = document.getElementById('filter-group').value;
    var is_active = document.getElementById('filter-status').value;

    email = email.trim().replace(/^\s+|\s+$/gm,'');
    name = name.trim().replace(/^\s+|\s+$/gm,'');
    group = (group >= 1 && group <= 3) ? group : -1;
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
            "group": (group == '') ? -1 : group,
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
