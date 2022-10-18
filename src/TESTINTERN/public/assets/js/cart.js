let totalPrice = 0;

function deCrease(index, isCart = 1)
{
    let count = document.getElementById('inp-count-' + index);
    if(parseInt(count.value) <= 1) return;
    count.value = parseInt(count.value) - 1;
    if (isCart != 1) return;
    cart[index][3] -= 1;
    totalPrice -= cart[index][4];
    document.getElementById('price-row-' + index).textContent = fommatPrice(parseInt(cart[index][3]) * parseInt(cart[index][4]));
    document.getElementById('total-price').textContent = fommatPrice(totalPrice);
    saveToLocalStorage();
}

function inCrease(index, isCart = 1)
{
    let count = document.getElementById('inp-count-' + index);
    count.value = parseInt(count.value) + 1;
    if (isCart != 1) return;
    cart[index][3] += 1;
    totalPrice += cart[index][4];
    document.getElementById('price-row-' + index).textContent = fommatPrice(parseInt(cart[index][3]) * parseInt(cart[index][4]));
    document.getElementById('total-price').textContent = fommatPrice(totalPrice);
    saveToLocalStorage();
}

function deleteProduct(x, id)
{
    let tr = x.parentElement.parentElement;
    tr.remove();
    let index = idProductExisted(id);
    if(index < 0) return;

    let price = parseInt(cart[index][3]) * parseInt(cart[index][4]);
    totalPrice -= price;
    document.getElementById('total-price').textContent = fommatPrice(totalPrice);

    const cart1 = cart.slice(0, index);
    const cart2 = cart.slice(index + 1, cart.length);
    cart = cart1.concat(cart2);

    saveToLocalStorage();
    displayTotalCart();

    let arrRowId = document.getElementsByClassName('row-id');
    for (let i = index; i < cart.length; i++) {
        arrRowId[i].textContent = (parseInt(i) + parseInt(1));
    }

    if(cart.length <= 0) {
        document.getElementById('table-cart').innerHTML = '<tr><td colspan="7">項目がありません</td></tr>';
        document.getElementById('btn-checkout').hidden = true;
    }
}

function displayCart()
{
    let listCart = '';

    if(cart.length <= 0) {
        listCart = '<tr><td colspan="7">項目がありません</td></tr>';
    }
    else {
        document.getElementById('btn-checkout').hidden = false;
    }

    for (let index = 0; index < cart.length; index++) {
        let price = parseInt(cart[index][3]) * parseInt(cart[index][4]);
        listCart += '<tr>' +
                '<th scope="row" class="row-id">' + (parseInt(index) + parseInt(1)) +'</th>' +
                '<td>' +
                    '<img style="width: 90%; margin:auto;" src="' + cart[index][1] + '">' +
                '</td>' +
                '<td class="text-start p-2">' + cart[index][2] + '</td>' +
                '<td>' + cart[index][4] + '</td>' +
                '<td>' +
                    '<div class="btn-group btn-group-sm" role="group" aria-label="Small button group">' +
                        '<input type="button" class="btn btn-decrease" value="-" onclick="deCrease(' + index + ')">' +
                        '<input type="text" class="btn" id="inp-count-' + index + '" value="' + cart[index][3] + '" disabled style="width: 2.5rem; color:black;">' +
                        '<input type="button" class="btn btn-increase" value="+" onclick="inCrease(' + index + ')">' +
                    '</div>' +
                '</td>' +
                '<td id="price-row-' + index +'">' + fommatPrice(price) + '</td>' +
                '<td>' +
                    '<button class="btn btn-danger" onclick="deleteProduct(this, ' + cart[index][0] + ')">X</button>' +
                '</td>' +
            '</tr>';
        totalPrice += parseInt(price);
    }

    document.getElementById('table-cart').innerHTML = listCart;
    document.getElementById('total-price').textContent = fommatPrice(totalPrice);
}
