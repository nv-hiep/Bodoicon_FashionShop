$(document).ready(function () {

    $(".megamenu").megamenu();

    // init rigt slider
    $('#slider').nivoSlider();

    //Stop search if no text entered
    $('input#submit').click(function (e) {
        var text = $('input#search-input').val();
        if (text.length === 0) {
            e.preventDefault();
        }
    });

    //Flickr Integration
    //https://api.flickr.com/services/rest/?method=flickr.people.getPublicPhotos&api_key=e77220f93bbe669a4a2d51c71976c42a&user_id=137018506@N03&safe_search=1&extras=url_m&format=json&per_page=15
    //https://api.flickr.com/services/rest/?method=flickr.photos.search&api_key=e77220f93bbe669a4a2d51c71976c42a&format=json&nojsoncallback=1&text=cats&extras=url_o&per_page=15
    $.getJSON("http://api.flickr.com/services/feeds/photos_public.gne?id=137018506@N03&lang=en-us&format=json&jsoncallback=?", function (data) {
        $.each(data.items, function (i, item) {
            if (i <= 11) { // <— change this number to display more or less images
                $("<img/>").attr("src", item.media.m.replace('_m', '_s')).appendTo(".FlickrImages ul")
                        .wrap("<li><a href='" + item.link + "' target='_blank' title='Flickr'></a></li>");
            }
        });
    });

    // hiển thị giỏ hàng
    add_data_to_short_cart(current_cart);

    // Hiển thị danh sách hình của sản phẩm
    if ($('#etalage').length > 0) {
        $('#etalage').etalage({
            thumb_image_width: 360,
            thumb_image_height: 360,
            source_image_width: 900,
            source_image_height: 900,
            show_hint: true,
            click_callback: function (image_anchor, instance_id) {
                alert('Callback example:\nYou clicked on an image with the anchor: "' + image_anchor + '"\n(in Etalage instance: "' + instance_id + '")');
            }
        });
    }

    // Hiển thị các sản phẩm cùng danh mục khi xem chi tiết một sản phẩm
    $(window).load(function () {

        // Làm đẹp thanh scroll bar của các mục trong trang chi tiết sản phẩm
        if ($('.scroll-pane').length > 0) {
            $('.scroll-pane').jScrollPane();
        }

        if ($("#flexiselDemo3").length > 0) {
            $("#flexiselDemo3").flexisel({
                visibleItems: 5,
                animationSpeed: 1000,
                autoPlay: true,
                autoPlaySpeed: 3000,
                pauseOnHover: true,
                enableResponsiveBreakpoints: true,
                responsiveBreakpoints: {
                    portrait: {
                        changePoint: 480,
                        visibleItems: 1
                    },
                    landscape: {
                        changePoint: 640,
                        visibleItems: 2
                    },
                    tablet: {
                        changePoint: 768,
                        visibleItems: 3
                    }
                }
            });
        }

    });

    // Search Side-bar
    $('input.checkbox-search').click(function () {
        var cats = $('input:checkbox:checked.checkbox-cats').map(function () {
            return this.value;
        }).get();
        var prices = $('input:checkbox:checked.checkbox-prices').map(function () {
            return this.value;
        }).get();
        var sizes = $('input:checkbox:checked.checkbox-sizes').map(function () {
            return this.value;
        }).get();
        var colors = $('input:checkbox:checked.checkbox-colors').map(function () {
            return this.value;
        }).get();

        $.redirect(base_url + "tim-nang-cao.html", {cats: cats, prices: prices, sizes: sizes, colors: colors});
    });
});

/**
 * Thêm sản phẩm vào phần xem nhanh giỏ hàng
 *
 * @param json data
 */
function add_data_to_short_cart(data)
{
    var product_number = 0;
    var pay = 0;

    if (jQuery.isEmptyObject(data)) {

        $('.short-cart-title > h3').html('Giỏ hàng trống')

    } else {

        //xóa giỏ hàng trước
        $('.short-cart-detail > table').html('');

        //tiêu đề giỏ hàng
        $('.short-cart-title > h3').html('Xem nhanh giỏ hàng')

        jQuery.each(data, function (i, val) {

            product_number = product_number + parseInt(val.quantity);

            pay = pay + (parseInt(val.unit_price) * parseInt(val.quantity));


            var tr = $('<tr>');

            $(tr).append(
                    $('<td>').append(
                    '<img class="short-cart-img-thumbnail" src="' + base_url + 'assets/img/prod_img/' + val.image + '" width="70" height="65" alt="">'
                    ).attr('class', 'text-center')
                    );

            $(tr).append(
                    $('<td>').append(
                    val.short_cart_product_name
                    ).attr('class', 'text-middle').attr('width', '28%')
                    );

            $(tr).append(
                    $('<td>').append(
                    val.quantity + ' x ' + val.short_cart_unit_price + ' Đ'
                    ).attr('class', 'text-middle')
                    );


            $('.short-cart-detail > table').append(tr);

        });

        var row_total_pay = $('<tr>');
        var row_checkout = $('<tr>');

        var total_pay = parseInt(pay + '000').toFixed(0).replace(/./g, function (c, i, a) {
            return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "." + c : c;
        });

        // Dòng tổng tiền phải thanh toán
        $(row_total_pay).append(
                $('<td>').append('Tổng tiền').attr('class', 'text-middle').attr('colspan', '2')
                );

        $(row_total_pay).append(
                $('<td>').append(total_pay + ' Đ').attr('class', 'text-bold')
                );

        // Dòng hiển thị nút checkout
        $(row_checkout).append(
                $('<td>').append(
                '<a href="' + base_url + 'cart/checkout"><button type="button" class="grey" style="float: right;  margin-right: 3.5%; margin-top: 0.8%;">Thanh toán</button></a>'
                ).attr('class', 'text-middle').attr('colspan', '3').attr('style', 'text-align:center')
                );

        $('.short-cart-detail > table').append(row_total_pay);
        $('.short-cart-detail > table').append(row_checkout);

        $('.short-quantity').html('');
        $('.short-quantity').html(product_number);
    }
}
