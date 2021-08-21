$(document).ready(function () {

    // Mở cái này ra không biết vì sao bị lỗi
    $('#prod-cat').multiselect();

    // Show Image on hover
    var offsetX = 20;
    var offsetY = 10;

    $('.img-hover').hover(function (e) {
        var href = $(this).attr('path');
        var kind = $(this).attr('kind');
        switch (kind) {
            case 'slider':
                h = 180;
                w = 504
                break;
            case 'ads':
                h = 304;
                w = 230
                break;
            case 'side-slider':
                h = 450;
                w = 230
                break;
            default:
                break;
        }

        $('<img id="largeImage" src="' + href + '" alt="large image" height=' + h + ' width=' + w + '/>')
                .css('top', e.pageY + offsetY)
                .css('left', e.pageX + offsetX)
                .appendTo('body');
    }, function () {
        $('#largeImage').remove();
    });

    $('a').mousemove(function (e) {
        $("#largeImage").css('top', e.pageY + offsetY).css('left', e.pageX + offsetX);
    });

    // Show Image on hover - product images
    $('.img-hover-prod').hover(function (e) {
        var href = $(this).attr('path');
        $('<img id="largeImage" src="' + href + '" alt="large image" width="30%"/>')
                .css('top', e.pageY - e.pageY / 7)
                .css('right', e.pageX / 3.5)
                .appendTo('body');
    }, function () {
        $('#largeImage').remove();
    });

    $('a').mousemove(function (e) {
        $("#largeImage").css('top', e.pageY).css('right', e.pageX / 3.5);
    });

    //Ajax - Show/hide image on Slider
    $('.display-flag').click(function () {
        var id = $(this).attr('id-val');
        var flag = $(this).attr('flag');

        //display corresponding input block
        $.ajax({
            url: base_url + "admin/slider/ajaxflag",
            type: "POST",
            data: ({id: id, flag: flag}),
            async: true,
            success: function (res) {
                location.reload();
            }
        });
    });

    //Ajax - Show/hide image on Ads
    $('.display-flag-ads').click(function () {
        var id = $(this).attr('id-val');
        var flag = $(this).attr('flag');

        //display corresponding input block
        $.ajax({
            url: base_url + "admin/ads/ajaxflag",
            type: "POST",
            data: ({id: id, flag: flag}),
            async: true,
            success: function (res) {
                location.reload();
            }
        });
    });

    //Ajax - Show/hide image on side-slider
    $('.display-flag-side').click(function () {
        var id = $(this).attr('id-val');
        var flag = $(this).attr('flag');

        //display corresponding input block
        $.ajax({
            url: base_url + "admin/sideslider/ajaxflag",
            type: "POST",
            data: ({id: id, flag: flag}),
            async: true,
            success: function (res) {
                location.reload();
            }
        });
    });

    // Sort Cat.
    $('.cat-table').sortable({
        opacity: 0.6,
        handle: '.handle',
        cursor: 'move',
        update: function () {
            //$.jGrowl("Update order successfully", { life: 3000});

            var i = 1;
            $('.cat-table .order').each(function () {
                $(this).empty().html(i);
                i++;
            });
            var order = $(this).sortable("serialize") + '&update=update';
            $.post(base_url + "admin/categories/update_order/", order, function () {
                alert('Updated order of categories');
            });
        },
        themeState: 'success'
    });

    //Ajax - Show/hide category
    $('.active-flag').click(function () {
        var id = $(this).attr('id-val');
        var flag = $(this).attr('flag');

        //display corresponding input block
        $.ajax({
            url: base_url + "admin/categories/ajaxflag",
            type: "POST",
            data: ({id: id, flag: flag}),
            async: true,
            success: function (res) {
                location.reload();
            }
        });
    });


    // Upload images
    $('#add-file').click(function () {
        var i = $('#prod-imgs div.file-input').size() + 1;
        $('<div class="file-input"> <input class="col-sm-6" multiple="multiple" name="img[' + (i - 1) + ']" value="" type="file"> <input name="colour[]" class="col-sm-2" value="#000000" type="color"> &nbsp <a href="#" class="rm-file">Xóa</a><br> <br></div>').appendTo("#prod-imgs");
        i++;
        return false;
    });

    $(document).on('click', '.rm-file', function () {
        var j = 0;
        $(this).parents('div.file-input').remove();
        $(".file-input").each(function () {
            $(this).find('input[type=file]').attr('name', 'img[' + j + ']');
            j++;
        });
        return false;
    });



    // Check duplicate image file - Add product
    $('.prod-submit').click(function (e) {
        var imgs = [];
        $("input:file").each(function () {
            imgs.push(this.value);
        });
        var sorted = imgs.sort();
        var results = [];
        for (var i = 0; i < sorted.length - 1; i++) {
            if ((sorted[i + 1] == sorted[i]) && (sorted[i].length > 0)) {
                results.push(sorted[i]);
            }
        }
        if (results.length > 0) {
            alert('Ảnh tải lên trùng nhau. Vui lòng chọn lại!');
            e.preventDefault();
        }

    });

    // Check duplicate image file - Edit product
    $('.prod-submit-edit').click(function (e) {
        var imgs = [];
        $("input:file").each(function () {
            imgs.push($(this).val().split('\\').pop());
        });
        $("img.prod-imgs").each(function () {
            var prod = $(this).attr('prod');
            var prefix = prod + '_';
            var img = $(this).attr('imag');
            var name = img.replace(prefix, "");
            imgs.push(name);
        });

        var sort_array = imgs.sort();
        var results = [];
        for (var i = 0; i < sort_array.length - 1; i++) {
            if ((sort_array[i + 1] == sort_array[i]) && (sort_array[i].length > 0)) {
                results.push(sort_array[i]);
            }
        }
        if (results.length > 0) {
            alert('Ảnh tải lên trùng nhau hoặc trùng với ảnh trong dữ liệu. Vui lòng chọn lại!');
            e.preventDefault();
        }
    });

    // Change color of product
    $('input.change-color').change(function () {
        var color = $(this).val();
        $(this).parent().find('a.edit-color').show().attr('color', color);
    });

    //Ajax - Edit color of product
    $('.edit-color').click(function () {
        var color = $(this).attr('color');
        var pid = $(this).parent().parent().find('div.img-area span img').attr('prod');
        var prod_name = $(this).parent().parent().find('div.img-area span img').attr('alt');

        //display corresponding input block
        $.ajax({
            url: base_url + "admin/product/ajaxcolor",
            type: "POST",
            data: ({id: pid, prod: prod_name, color: color}),
            async: true,
            success: function (res) {
                location.reload();
            }
        });
    });

    // Tạo slug
    $("#field-name").keyup(function () {
        var name = $(this).val();
        var pid  = $(this).attr('pid');
        if (name.length > 0) {
            if (pid !== undefined) {
                $('#field-slug').val(toslug(name)+'-'+pid);
            } else {
                $('#field-slug').val(toslug(name));
            }
        } else {
            $('#field-slug').val('');
        }

    });

    function toslug(str)
    {
        // Chuyển hết sang chữ thường
        str = str.toLowerCase();

        // xóa dấu
        str = str.replace(/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/g, 'a');
        str = str.replace(/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/g, 'e');
        str = str.replace(/(ì|í|ị|ỉ|ĩ)/g, 'i');
        str = str.replace(/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/g, 'o');
        str = str.replace(/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/g, 'u');
        str = str.replace(/(ỳ|ý|ỵ|ỷ|ỹ)/g, 'y');
        str = str.replace(/(đ)/g, 'd');

        // Xóa ký tự đặc biệt
        str = str.replace(/([^0-9a-z-\s])/g, '');

        // Xóa khoảng trắng thay bằng ký tự -
        str = str.replace(/(\s+)/g, '-');

        // xóa phần dự - ở đầu
        str = str.replace(/^-+/g, '');

        // xóa phần dư - ở cuối
        str = str.replace(/-+$/g, '');

        // return
        return str;
    }

    var permission = $('select#permission').val();
    if (typeof permission === 'undefined') {
        permission = '';
    }
    if (permission.length > 0) {
        var text = $( "select#permission option:selected" ).text();
        var perm = permission;
        var role = $('#role').val();
        var acts = $('#actions').attr('value');

        //display corresponding input block
        $.ajax({
            url : base_url + "admin/roleperm/ajaxload_actions",
            type: "POST",
            data: ({perm: text, pid: perm, rid: role, acts: acts}),
            async: true,
            success: function(res) {
                $("#actions").empty();
                $("#actions").append(res);
            }
        });
    }

    // change permission
    $('#permission').change(function(){
        //block page until ajax call completes
        //$.blockUI();

        var text = $( "#permission option:selected" ).text();
        var perm = $(this).val();
        var role = $('#role').val();
        var acts = '';
        var priperm = $('#actions').attr('prim-perm');

        if (text === priperm) {
            location.reload();
        }

        //display corresponding input block
        $.ajax({
            url : base_url + "admin/roleperm/ajaxload_actions",
            type: "POST",
            data: ({perm: text, pid: perm, rid: role, acts: acts, priperm: priperm}),
            async: true,
            success: function(res) {
                $("#actions").empty();
                $("#actions").append(res);
            }
        });
    });

    // Role - permission
    $(document).on('click', '.checkbox-act', function() {
        var perm = $('#permission').val();
        var role = $('#role').val();
        var i = 0;
        var n = $(".checkbox-act:checked").length;
        var final = 'a:'+n+':{';
        $('.checkbox-act:checked').each(function(){
            var value = $(this).val();
            final += 'i:' + i + ';' + 'i:' + value + ';';
            i = i + 1;
        });
        final += '}';
        if (n === 0) {
            final = '';
        }
        $("#act").val('');
        $("#act").val(final);
    });



});
