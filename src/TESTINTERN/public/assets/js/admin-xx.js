let btnMenuExtend = document.getElementById('btn-menu-extend');
let divMenu = document.getElementById('div-menu');
let divContent = document.getElementById('div-content');

btnMenuExtend.onclick = function()
{
    if (divContent.className == "col-md-10") {
        divMenu.style.display = 'none';
        btnMenuExtend.innerText = '→';
        divContent.className = "col-md-12";

    } else if (divContent.className == "col-md-12") {
        divMenu.style.display = 'block';
        btnMenuExtend.innerText = '←';
        divContent.className = "col-md-10";
    }
}


function openPopUp()
{
    alert("Mở");
    document.getElementById('pop-up').style.display == "block";

}

function closePopUp()
{
    alert("Đóng");
    document.getElementById('pop-up').style.display == "none";
}

function page(page = 1)
{
    var urlAction = document.getElementById('url-pagination').textContent;
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
        url: urlAction,
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
