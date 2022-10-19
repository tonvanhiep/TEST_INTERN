function deleteProductId(id)
{
    var currentPage = document.getElementById('current-page').textContent;

    var result = confirm("製品 #" + id + " を削除してもよろしいですか?");
    if (result == true) {
        $.ajax({
            type: 'POST',
            cache: false,
            url: document.getElementById('url-delete-product').textContent,
            data: {
                "_token": document.getElementById('token-edit-product').textContent,
                "id": id
            },
            success: function(data) {
                // console.log(data);
                alert("製品を正常に削除。");
                pagination(currentPage);
            },
            error: function(data) {
                var errors = data.responseJSON;
                var errorArr = '';

                $.each( errors.errors, function( key, value ) {
                    errorArr += '- ' + value[0] + '\n';
                });

                errorArr = '製品を削除できませんでした。\n' + errorArr;
                alert(errorArr);
            },
        });
    }
}

function submitSearchFormAjax(delSearch = 0)
{
    var token = document.getElementById('token-pagination').textContent;
    var minPrice = document.getElementById('search-price-min').value;
    var name = document.getElementById('search-name').value;
    var maxPrice = document.getElementById('search-price-max').value;
    var isSales = document.getElementById('filter-sales').value;

    if(delSearch == 1) {
        name = ''
        minPrice = '';
        maxPrice = '';
        is_active = -1;
    }
    else if (minPrice == '' && name == '' && maxPrice == '' && isSales == -1) {
        alert("検索情報を入力していません。");
        return;
    }

    $.ajax({
        type: 'POST',
        cache: false,
        url: document.getElementById('search-form').action,
        data: {
            "_token": token,
            "name": name,
            "minPrice": minPrice,
            "maxPrice": maxPrice,
            "isSales": isSales,
        },
        success: function(data) {
            console.log('success');
            document.getElementById('pagination-content').innerHTML = data;
        },
        error: function(data) {
            // console.log(data);
        },
    });
}

function submitProductFormAjax()
{
    var urlAction = document.getElementById('product-form').action;

    var currentPage = document.getElementById('current-page').textContent;
    var token = document.getElementById('token-product').textContent;
    var dataName = document.getElementById('inp-name').value;
    var dataFile = document.getElementById('inp-img').value;
    var dataPrice = document.getElementById('inp-price').value;
    var dataDesciption = document.getElementById('inp-desciption').value;
    var dataSales = document.getElementById('inp-sales').value;

    $.ajax({
        type: 'POST',
        cache: false,
        url: urlAction,
        data: {
            "_token": token,
            "name": dataName,
            "file": dataFile,
            "price": dataPrice,
            "description": dataDesciption,
            "is_sales": dataSales,
        },
        success: function(data){
            var success = data.responseJSON;
            console.log(success);
            successHtml = '<div class="alert alert-success"><ul>';
            successHtml += '<li> 製品を正常に追加する。</li>';
            successHtml += '</ul></div>';

            $( '#div-alert' ).html( successHtml );
            resetForm();

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
    var minPrice = document.getElementById('search-price-min').value;
    var name = document.getElementById('search-name').value;
    var maxPrice = document.getElementById('search-price-max').value;
    var isSales = document.getElementById('filter-sales').value;

    $.ajax({
        type: 'POST',
        cache: false,
        url: document.getElementById('url-pagination').textContent,
        data: {
            "_token": token,
            "page": page,
            "name": name,
            "minPrice": minPrice,
            "maxPrice": maxPrice,
            "isSales": isSales,
        },
        success: function(data) {
            console.log('success');
            document.getElementById('pagination-content').innerHTML = data;
        },
        error: function(data) {
            // console.log(data);
        },
    });
}

function onchangeImageFile()
{
    var file = document.getElementById('inp-img').files;
    if (file.length > 0) {
        var fileLoad = file[0];
        var fileReader = new FileReader();
        fileReader.onload = function(fileLoaderEvent)
        {
            var srcImg = fileLoaderEvent.target.result;
            document.getElementById('img-product').src = srcImg;
        }
        fileReader.readAsDataURL(fileLoad);
    }
}

function resetForm()
{
    document.getElementById("product-form").reset();
    document.getElementById("img-product").src = '';
}

function openModal()
{
    $('#myModal').modal('show');
    resetForm();
}

function addProduct(urlAdd)
{
    openModal();

    document.getElementById('title-popup').textContent = "製品を作成";

    document.getElementById('product-form').action = urlAdd;
    document.getElementById('inp-name').disabled = false;
    document.getElementById('inp-img').disabled = false;
    document.getElementById('inp-desciption').disabled = false;
    document.getElementById('inp-price').disabled = false;
    document.getElementById('inp-sales').disabled = false;
    document.getElementById('div-img-product').style.display='flex' ;

    document.getElementById('submit-popup').textContent = "商品を保存";
    document.getElementById('submit-popup').className = 'btn btn-outline-success btn-block';
    document.getElementById('submit-popup').type = 'submit';
    document.getElementById('submit-popup').onclick = function() {};
    document.getElementById('id-product').value = null;
}

function submitPopup()
{

}

function displayProductId(urlEdit, id)
{
    openModal();
    // lay du lieu va hien thi len trang popup
    var btnEdit = document.getElementById('btn-edit-inp-' + id);
    var arrInp = document.getElementsByClassName('inp-row-' + id);

    document.getElementById('submit-popup').textContent = "商品の編集";

    document.getElementById('product-form').action = urlEdit;
    document.getElementById('inp-name').disabled = true;
    document.getElementById('inp-img').disabled = true;
    document.getElementById('inp-desciption').disabled = true;
    document.getElementById('inp-price').disabled = true;
    document.getElementById('inp-sales').disabled = true;
    document.getElementById('div-img-product').style.display = 'none';
    document.getElementById('submit-popup').className = 'btn btn-outline-warning btn-block';
    document.getElementById('submit-popup').type = 'button';
    document.getElementById('submit-popup').onclick = function () { editProductId(id); };
    document.getElementById('id-product').value = id;

    $.ajax({
        type: 'POST',
        cache: false,
        url: document.getElementById('url-product').textContent,
        data: {
            "_token": document.getElementById('token-product').textContent,
            "id": id
        },
        success: function(data) {
            document.getElementById('title-popup').textContent = data.name;
            document.getElementById('inp-name').value = data.name;
            document.getElementById('img-product').src = data.image;
            document.getElementById('inp-desciption').value = data.description;
            document.getElementById('inp-price').value = data.price;
            document.getElementById('inp-sales').value = data.is_sales;

            var btnEdit = document.getElementById('btn-edit-inp-' + id);
            var arrInp = document.getElementsByClassName('inp-row-' + id);

            arrInp[0].value = data.name;
            arrInp[1].value = data.description;
            arrInp[2].value = data.price;
            arrInp[3].value = data.is_sales;
            document.getElementById('img-row-' + id).src = data.image;
        },
        error: function(data) {
            var errors = data.responseJSON;
            var errorArr = '';

            $.each( errors.errors, function( key, value ) {
                errorArr += '- ' + value[0] + '\n';
            });

            errorArr = 'エラー。\n' + errorArr;
            alert(errorArr);
        },
    });
}

function editProductId(id) {
    document.getElementById('submit-popup').textContent = "セーブ";

    document.getElementById('inp-name').disabled = false;
    document.getElementById('inp-img').disabled = false;
    document.getElementById('inp-desciption').disabled = false;
    document.getElementById('inp-price').disabled = false;
    document.getElementById('inp-sales').disabled = false;
    document.getElementById('div-img-product').style.display = 'flex';
    document.getElementById('submit-popup').className = 'btn btn-outline-success btn-block';
    document.getElementById('submit-popup').onclick = function () { saveChangeProductId(id); };
}

function saveChangeProductId(id)
{
    document.getElementById('submit-popup').type = 'submit';
}


$('#product-form').submit(function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
        type:'POST',
        url: document.getElementById('product-form').action,
        data: formData,
        cache:false,
        contentType: false,
        processData: false,
        success: (data) => {
            if(document.getElementById('product-form').action.includes('add')) {
                alert("製品が正常に追加されました。");
                this.reset();
                resetForm();
            }
            else if(document.getElementById('product-form').action.includes('edit')) {
                alert("製品を正常に更新されました。");
                displayProductId(document.getElementById('product-form').action, document.getElementById('id-product').value);
            }
        },
        error: function(data){
            var errors = data.responseJSON;
            var errorArr = '';

            $.each( errors.errors, function( key, value ) {
                errorArr += '- ' + value[0] + '\n';
            });

            errorArr = 'エラー\n' +  errorArr;
            alert(errorArr);
        }
    });
});
