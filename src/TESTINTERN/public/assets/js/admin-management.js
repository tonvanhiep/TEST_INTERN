function editAdminId(id)
{
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
        $.ajax ({
            type: 'POST',
            cache: false,
            url: document.getElementById('url-edit-admin').textContent,
            data: {
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


function deleteAdminId(id)
{
    var currentPage = document.getElementById('current-page').textContent;

    var result = confirm("管理者アカウント #" + id + " を削除してもよろしいですか?");
    if (result == true) {
        $.ajax ({
            type: 'POST',
            cache: false,
            url: document.getElementById('url-delete-admin').textContent,
            data: {
                "id": id
            },
            success: function(data) {
                console.log(data);
                alert("管理者アカウントを正常に削除。");
                pagination(currentPage);
            },
            error: function(data) {
                var errors = data.responseJSON;
                var errorArr = '';

                $.each( errors.errors, function( key, value ) {
                    errorArr += '- ' + value[0] + '\n';
                });

                errorArr = '管理者アカウントを削除できませんでした。\n' + errorArr;
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
        alert("検索情報を入力していません。");
        return;
    }

    $.ajax({
        type: 'POST',
        cache: false,
        url: document.getElementById('search-form').action,
        data: {
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
            "name": dataName,
            "email": dataEmail,
            "pass": dataPass,
            "re-pass": dataRePass,
            "group": dataGroup,
        },
        success: function(data){
            var success = data.responseJSON;
            console.log(success);
            successHtml = '<div class="alert alert-success"><ul><li> アカウント登録成功。</li></ul></div>';

            $( '#div-alert' ).html( successHtml );
            document.getElementById("register-form").reset();

            //load lai du lieu
            pagination(currentPage);
        },
        error: function(data){
            var errors = data.responseJSON;
            var errorsHtml = '';

            $.each( errors.errors, function( key, value ) {
                errorsHtml += '<li>' + value[0] + '</li>';
            });

            errorsHtml = '<div class="alert alert-danger"><ul>' + errorsHtml + '</ul></div>';
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
    var email = document.getElementById('search-email').value;
    var name = document.getElementById('search-name').value;
    var group = document.getElementById('filter-group').value;
    var is_active = document.getElementById('filter-status').value;

    email = email.trim().replace(/^\s+|\s+$/gm,'');
    name = name.trim().replace(/^\s+|\s+$/gm,'');
    group = (group >= 1 && group <= 3) ? group : -1;
    is_active = (is_active == 1 || is_active == 0) ? is_active : -1;


    $.ajax ({
        type: 'POST',
        cache: false,
        url: document.getElementById('url-pagination').textContent,
        data: {
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

function exportCsv(urlCsv)
{
    var email = document.getElementById('search-email').value;
    var name = document.getElementById('search-name').value;
    var group = document.getElementById('filter-group').value;
    var is_active = document.getElementById('filter-status').value;

    email = email.trim().replace(/^\s+|\s+$/gm,'');
    name = name.trim().replace(/^\s+|\s+$/gm,'');
    group = (group >= 1 && group <= 3) ? group : -1;
    is_active = (is_active == 1 || is_active == 0) ? is_active : -1;

    var url = urlCsv + '?';

    if (name != '' && name != null) url += 'name=' + name;
    if (email != '' && email != null) url += '&email=' + email;
    if (group != '-1' && group != null) url += '&group=' + group;
    if (is_active != '-1' && is_active != null) url += '&is_active=' + is_active;

    location.href = url;
}
