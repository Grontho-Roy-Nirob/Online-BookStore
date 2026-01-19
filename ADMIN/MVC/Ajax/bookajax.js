function calcFinalAdd() {
    var price = parseFloat(document.getElementById('price').value) || 0;
    var discount = parseFloat(document.getElementById('discount').value) || 0;
 
    if (discount < 0) discount = 0;
    if (discount > 100) discount = 100;
 
    var finalPrice = price - (price * discount / 100);
    document.getElementById('final_price').value = finalPrice.toFixed(2);
}

function calcFinalUpdate(id) {
    var price = parseFloat(document.getElementById('price-' + id).value) || 0;
    var discount = parseFloat(document.getElementById('discount-' + id).value) || 0;
 
    if (discount < 0) discount = 0;
    if (discount > 100) discount = 100;
 
    var finalPrice = price - (price * discount / 100);
    document.getElementById('final-' + id).value = finalPrice.toFixed(2);
}