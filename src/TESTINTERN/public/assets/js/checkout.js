let shippingFee = 0;

function displayCartCheckout()
{
    let listCart = '';
    let totalPrice = 0;
    if(cart.length <= 0) {
        listCart = '<li class="list-group-item d-flex justify-content-between lh-condensed"><div><h6 class="my-0">No items</h6><small class="text-muted"></div></li>';
    }

    for (let index = 0; index < cart.length; index++) {
        let price = parseInt(cart[index][3]) * parseInt(cart[index][4]);
        listCart += '<li class="list-group-item d-flex justify-content-between lh-condensed">' +
                '<div>' +
                    '<h6 class="my-0">' + cart[index][2] + '</h6>' +
                    '<small class="text-muted"> (x' + cart[index][3] + ')</small>' +
                '</div>' +
                '<span class="text-muted text-end">' + fommatPrice(price) + '</span>' +
            '</li>';
        totalPrice += parseInt(price);
    }

    if(totalPrice >= 10000) {
        shippingFee = 0
        document.getElementById('shipping-fee').textContent = fommatPrice(shippingFee);
    }
    else {
        shippingFee = 300;
        totalPrice = parseInt(parseInt(totalPrice) + parseInt(shippingFee));
    }
    let html = document.getElementById('cart-checkout');
    html.innerHTML = listCart + html.innerHTML;
    document.getElementById('total-price').textContent = fommatPrice(totalPrice);
}

function saveCartToCookie()
{
    let strCart = '';
    let strTotal = '';
    let total = 0;
    let totalPrice = 0;
    for (let index = 0; index < cart.length; index++) {
        let price = parseInt(cart[index][3]) * parseInt(cart[index][4]);
        total = parseInt(parseInt(total) + parseInt(price));
        strCart += cart[index][0] + ':' + cart[index][4] + ':' + cart[index][3] + ':' + price + '/';
    }

    totalPrice = parseInt(parseInt(total) + parseInt(shippingFee));
    strTotal = total + '-' + shippingFee + '-' + totalPrice;

    var now = new Date();
    var time = now.getTime();
    var expireTime = time + 1000*60;
    now.setTime(expireTime);

    document.cookie = 'cart=' + strCart + '; expires=' + now.toUTCString();
    document.cookie = 'total=' + strTotal + '; expires=' + now.toUTCString();
}
