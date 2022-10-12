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
                '<span class="text-muted">' + fommatPrice(price) + '</span>' +
            '</li>';
        totalPrice += parseInt(price);
    }

    if(totalPrice >= 10000) {
        document.getElementById('shipping-fee').textContent = fommatPrice(0);
    }
    else {
        totalPrice += 300;
    }
    let html = document.getElementById('cart-checkout');
    html.innerHTML = listCart + html.innerHTML;
    document.getElementById('total-price').textContent = fommatPrice(totalPrice);
}

displayCartCheckout();
