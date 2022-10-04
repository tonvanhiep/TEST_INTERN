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

    $.ajax({
        type: 'POST',
        cache: false,
        url: urlAction,
        data: {
            "_token": token,
            "page": page
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
