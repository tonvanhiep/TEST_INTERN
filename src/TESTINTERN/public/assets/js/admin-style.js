let btnMenuExtend = document.getElementById('btn-menu-extend');
let divMenu = document.getElementById('div-menu');
let divContent = document.getElementById('div-content');

btnMenuExtend.onclick = function()
{
    if (divContent.className == "col-md-10") {
        divMenu.style.display = 'none';
        btnMenuExtend.innerText = '>';
        divContent.className = "col-md-12";

    } else if (divContent.className == "col-md-12") {
        divMenu.style.display = 'block';
        btnMenuExtend.innerText = '<';
        divContent.className = "col-md-10";
    }
}


