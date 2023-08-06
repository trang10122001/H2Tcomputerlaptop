export const addToCart = (productId, quantity, productType, BASE_URL) => {
    $.ajax({
        url: `${BASE_URL}api/product/product.php`,
        type: 'post',
        data: {
            action: 'add-to-cart',
            id: productId,
            quantity: quantity,
            productType: productType
        },
        dataType: 'json',
        success: function(result) {
            $('.cart-count-product').text(result.length)
        }
    })
}
