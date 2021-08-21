$(document).ready(function() {

    //Hiệu ứng khi thêm sản phẩm vào giỏ hàng
    cart_effect();

});

function add_product_to_cart(e)
{
    var product_id      = e.attr('product_id');
    var color           = 'nocolor';
    var size            = '';
    var quantity        = $('.quantity').val();
    var related_img     = '';

    if (typeof($('input:radio[name=size]:checked').val()) !== 'undefined') {
        size =  $('input:radio[name=size]:checked').val();
    }

    if (typeof($('input:radio[name=color]:checked').val()) !== 'undefined') {
        color = ($('input:radio[name=color]:checked').val());
    }

    if (typeof($('input:hidden[name=related_img_'+color+']').val()) !== 'undefined') {
        related_img = $('input:hidden[name=related_img_'+color+']').val();
    }

    $.ajax({
        type: "POST",
        url: base_url + 'cart/add_product_to_cart',
        dataType: 'json',
        data:{
            product_id  : product_id,
            quantity    : quantity,
            size        : size,
            color       : color,
            related_img : related_img
        },
        async: true,
        success: function(response) {
            add_data_to_short_cart(response);
        }
    });
}

/**
 * Kiểm tra nhập số lượng sản phẩm hợp lệ
 *
 * @returns {Boolean}
 */
function check_valid_quanlity()
{
    var quantity = $('.quantity').val();

    if ((parseFloat(quantity) == parseInt(quantity)) && !isNaN(quantity)) {
        if (quantity.length >3 || parseInt(quantity) <=0) {
            return false;
        } else {
            return true;
        }
    } else {
        return false;
    }
}

/**
 * Kiểm tra đã chọn size chưa (nếu không có size thì bỏ qua)
 *
 * @returns boolean true|false
 */
function check_valid_size()
{
    if ($('input:radio[name=size]').length > 0) {

        if (typeof($('input:radio[name=size]:checked').val()) !== 'undefined') {
            return true;
        } else {
            return false;
        }
    } else {
        return true;
    }
}

/**
 * Kiểm tra đã chọn màu chưa (nếu không có màu thì bỏ qua)
 *
 * @returns boolean true|false
 */
function check_valid_color()
{
    if ($('input:radio[name=color]').length > 0) {

        if (typeof($('input:radio[name=color]:checked').val()) !== 'undefined') {
            return true;
        } else {
            return false;
        }
    } else {
        return true;
    }
}

function cart_effect()
{
    $('.add-to-cart').on('click', function(e) {

        //Ngăn không sumit form
        e.preventDefault();

        //Kiểm tra nhập số lượng hợp lệ
        if (check_valid_color() == false || check_valid_quanlity() == false || check_valid_size() == false) {
            alert('Chọn thông tin hợp lệ để mua hàng');
            return;
        }

        //Giỏ hàng ở góc bên phải
        var cart = $('.shopping-cart');

        //Hình sản phẩm để add vào giỏ hàng
        var imgtodrag = $('.img-add-to-cart-effect').find('.etalage_smallthumb_active').find('img').eq(0);

        if (imgtodrag) {
            var imgclone = imgtodrag.clone()
                    .offset({
                        top: imgtodrag.offset().top,
                        left: imgtodrag.offset().left
                    })
                    .css({
                        'opacity': '0.5',
                        'position': 'absolute',
                        'height': '150px',
                        'width': '150px',
                        'z-index': '100'
                    })
                    .appendTo($('body'))
                    .animate({
                        'top': cart.offset().top + 10,
                        'left': cart.offset().left + 10,
                        'width': 75,
                        'height': 75
                    }, 1000, 'easeInOutExpo');

            setTimeout(function() {
                cart.effect("bounce", {
                    times: 2
                }, 200);
            }, 1500);

            imgclone.animate({
                'width': 0,
                'height': 0
            }, function() {
                $(this).detach();
            });
        }

        //add product to cart
        add_product_to_cart($(this));
    });
}


