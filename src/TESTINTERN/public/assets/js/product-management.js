// function editProductId(id) {
//     let btnEdit = document.getElementById('btn-edit-inp-' + id);
//     let arrInp = document.getElementsByClassName('inp-row-' + id);

//     if (btnEdit.textContent == "Sửa") {
//         for (let index = 0; index < arrInp.length; index++) {
//             arrInp[index].disabled = false;
//             btnEdit.innerText = "Lưu";
//             btnEdit.className = "btn btn-outline-success";
//         }
//     }
//     else if (btnEdit.textContent == "Lưu") {
//         $.ajax({
//             type: 'POST',
//             cache: false,
//             url: document.getElementById('url-edit-product').textContent,
//             data: {
//                 "_token": document.getElementById('token-edit-product').textContent,
//                 "id": id,
//                 "name": arrInp[0].value,
//                 "description": arrInp[1].value,
//                 "price": arrInp[2].value,
//                 "is_sales": arrInp[3].value
//             },
//             success: function(data) {
//                 // console.log(data);
//                 for (let index = 0; index < arrInp.length; index++) {
//                     arrInp[index].disabled = true;
//                     btnEdit.innerText = "Sửa";
//                     btnEdit.className = "btn btn-outline-warning";
//                 }
//                 alert("Cập nhật thông tin thành công!!")
//             },
//             error: function(data) {
//                 var errors = data.responseJSON;
//                 var errorArr = '';

//                 $.each( errors.errors, function( key, value ) {
//                     errorArr += '- ' + value[0] + '\n';
//                 });

//                 errorArr = 'Cập nhật thông tin không thành công.\n' + errorArr;
//                 alert(errorArr);
//             },
//         });
//     }

// }

function deleteProductId(id) {
    var currentPage = document.getElementById('current-page').textContent;

    var result = confirm("Bạn có chắc chắn xóa sản phẩm #" + id + "?");
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
                alert("Xóa sản phẩm thành công!!!");
                pagination(currentPage);
            },
            error: function(data) {
                var errors = data.responseJSON;
                var errorArr = '';

                $.each( errors.errors, function( key, value ) {
                    errorArr += '- ' + value[0] + '\n';
                });

                errorArr = 'Xóa sản phẩm không thành công!\n' + errorArr;
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
        alert("Bạn chưa nhập thông tin tìm kiếm");
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
            successHtml += '<li> Thêm sản phẩm thành công</li>';
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
    let file = document.getElementById('inp-img').files;
    if (file.length > 0) {
        let fileLoad = file[0];
        let fileReader = new FileReader();
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

function addProduct()
{
    openModal();

    document.getElementById('title-popup').textContent = "Thêm sản phẩm";

    document.getElementById('inp-name').disabled = false;
    document.getElementById('inp-img').disabled = false;
    document.getElementById('inp-desciption').disabled = false;
    document.getElementById('inp-price').disabled = false;
    document.getElementById('inp-sales').disabled = false;
    document.getElementById('div-img-product').style.display='flex' ;

    document.getElementById('submit-popup').textContent = "Lưu sản phẩm";
    document.getElementById('submit-popup').className = 'btn btn-outline-success btn-block';
    document.getElementById('submit-popup').type = 'submit';
    document.getElementById('submit-popup').onclick = function() {};
}

function submitPopup()
{

}

function displayProductId(id)
{
    openModal();
    // lay du lieu va hien thi len trang popup
    let btnEdit = document.getElementById('btn-edit-inp-' + id);
    let arrInp = document.getElementsByClassName('inp-row-' + id);

    document.getElementById('submit-popup').textContent = "Chỉnh sửa sản phẩm";

    document.getElementById('inp-name').disabled = true;
    document.getElementById('inp-img').disabled = true;
    document.getElementById('inp-desciption').disabled = true;
    document.getElementById('inp-price').disabled = true;
    document.getElementById('inp-sales').disabled = true;
    document.getElementById('div-img-product').style.display = 'none';
    document.getElementById('submit-popup').className = 'btn btn-outline-warning btn-block';
    document.getElementById('submit-popup').type = 'button';
    document.getElementById('submit-popup').onclick = function () { editProductId(id); };

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

            let btnEdit = document.getElementById('btn-edit-inp-' + id);
            let arrInp = document.getElementsByClassName('inp-row-' + id);

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

            errorArr = 'Lỗi.\n' + errorArr;
            alert(errorArr);
        },
    });
}

function editProductId(id) {
    document.getElementById('submit-popup').textContent = "Lưu thay đổi";

    document.getElementById('inp-name').disabled = false;
    document.getElementById('inp-img').disabled = false;
    document.getElementById('inp-desciption').disabled = false;
    document.getElementById('inp-price').disabled = false;
    document.getElementById('inp-sales').disabled = false;
    document.getElementById('div-img-product').style.display = 'flex';
    document.getElementById('submit-popup').className = 'btn btn-outline-success btn-block';
    document.getElementById('submit-popup').type = 'button';
    document.getElementById('submit-popup').onclick = function () { saveChangeProductId(id); };
}

function saveChangeProductId(id)
{
    $.ajax({
        type: 'POST',
        cache: false,
        url: document.getElementById('url-edit-product').textContent,
        data: {
            "_token": document.getElementById('token-edit-product').textContent,
            "id": id,
            "name": document.getElementById('inp-name').value,
            "description": document.getElementById('inp-desciption').value,
            "price": document.getElementById('inp-price').value,
            "is_sales": document.getElementById('inp-sales').value
        },
        success: function(data) {
            alert("Chỉnh sửa sản phẩm thành công.");
            displayProductId(id);
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
            this.reset();
            alert('File has been uploaded successfully');
        },
        error: function(data){
        }
    });
});
