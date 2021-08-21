$(document).ready(function () {

    // AdvancedSearch Side-bar, when click on pagination links
    $('.adv-search div.pager ul li a').click(function (e) {
        e.preventDefault();
        var page = $(this).attr('href').split('\/').pop();
        if ( page.indexOf('#') > -1 ) {
            return false;
        }
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

        $.redirect(base_url + "tim-nang-cao.html/" + page,{ cats: cats, prices: prices, sizes: sizes, colors: colors});
    });
});