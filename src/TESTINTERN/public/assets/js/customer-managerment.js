function editCustomerId(id) { // chua xong
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

function deleteCustomerId(id) {
    var currentPage = document.getElementById('current-page').textContent;

    var result = confirm("Bạn có chắc chắn xóa người dùng #" + id + "?");
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
                alert("Xóa người dùng thành công!!!");
                page(currentPage);
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

function submitSearchFormAjax()
{
    alert("submitSearchFormAjax");
    //var urlAction = document.getElementById('search-form').action;

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
    alert("deleteSearchFormAjax");
    var urlAction = document.getElementById('register-form').action;

    // $.ajax({
    //     type: 'POST',
    //     cache: false,
    //     url: urlAction,
    //     data: {
    //         "_token": "",
    //         "name": "s",
    //         "email": "m",
    //         "pass": "p",
    //         "re-pass": "rp",
    //         "address": "ad"
    //     },
    //     success: function(data) {
    //         console.log(data);
    //     },
    //     error: function(data) {
    //         console.log(data);
    //     },
    // });
}

function importCSV()
{
    alert("importCSV");
}

function exportCSV()
{
    alert("exportCSV");
}
