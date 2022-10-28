let page = 1;
let cart = Array();

// Get the button:
let mybutton = document.getElementById("myBtn");

// When the user scrolls down 20px from the top of the document, show the button
function dropDown() {
    document.querySelector(".noidung_dropdown").classList.toggle("hienThi");
}

window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0; // For Safari
  document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
}

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
    if (count == null) {
        count = document.getElementById('inp-count-0').value;
    }
    let index = idProductExisted(id);
    if (index >= 0) {
        cart[index][3] = parseInt(parseInt(cart[index][3]) + parseInt(count));
        if(cart[index][1] != image) cart[index][1] = image;
        if(cart[index][2] != name) cart[index][2] = name;
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
