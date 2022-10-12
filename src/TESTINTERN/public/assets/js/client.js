let page = 1;
let cart = Array();

function loadMoreProduct()
{
    $.ajax({
        type: 'POST',
        cache: false,
        url: document.getElementById('url-load-more').textContent,
        data: {
            "_token": document.getElementById('token-load-more').textContent,
            "page": ++page
        },
        success: function(data) {
            console.log('success');
            document.getElementById('display-product').innerHTML += data.data;
            if(data.loadMore == 0) {
                document.getElementById("btn-load-more").hidden = true;
            }
        },
        error: function(data) {
            console.log(data);
        },
    });
}

function fommatPrice(price) {
    price += '';
    var x = price.split('.');
    var x1 = x[0];
    var x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2 + ' 円';
}

function saveToLocalStorage()
{
    localStorage.setItem('cart', JSON.stringify(cart));
}

function getCartLocalStorage()
{
    if(localStorage.cart == null) {
        localStorage.setItem('cart', JSON.stringify(cart));
    }
    else cart = JSON.parse(localStorage.getItem('cart'));
}

function idProductExisted(id)
{
    for (let index = 0; index < cart.length; index++) {
        if(cart[index][0] == id) return index;
    }
    return -1;
}

function displayTotalCart()
{
    document.getElementById('total-items').textContent = cart.length;
}

function turnOffAlert() {
    document.getElementById('div-alert').hidden = true;
}

function displayAlert()
{
    document.getElementById('div-alert').hidden = false;
    setTimeout(turnOffAlert, 2000);
}

function addToCart(id, image, name, count, price)
{
    let index = idProductExisted(id);
    if(index >= 0) {
        cart[index][3] += count;
        if(cart[index][1] != price) cart[index][1] = image;
        if(cart[index][2] != price) cart[index][2] = name;
        if(cart[index][4] != price) cart[index][4] = price;
    }
    else {
        let newCart = new Array(id, image, name, count, price);
        cart.push(newCart);
    }
    saveToLocalStorage();
    displayAlert();
    displayTotalCart();
}


getCartLocalStorage();
displayTotalCart();
