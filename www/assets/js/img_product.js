$(document).ready(function () {
    // Resize Image
    var wx = $('#imgx').attr('wx');
    var hy = $('#imgx').attr('hy');
    var rt = $('#imgx').attr('rat');
    var res = rt.split(":");

    $('#imgx').imgAreaSelect({aspectRatio: rt, maxWidth: wx, maxHeight: hy, handles: true,
        x1: 0, y1: 0, x2: wx, y2: hy,
        onSelectChange: function (img, selection) {
            var scaleX = res[0] / selection.width;
            var scaleY = res[1] / selection.height;

            $('#imgx + div > img').css({
                    width: Math.round(scaleX * wx) + 'px',
                    height: Math.round(scaleY * hy) + 'px',
                    marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px',
                    marginTop: '-' + Math.round(scaleY * selection.y1) + 'px'
            });
            $('#x1').val(selection.x1);
            $('#y1').val(selection.y1);
            $('#x2').val(selection.x2);
            $('#y2').val(selection.y2);
            $('#w').val(selection.width);
            $('#h').val(selection.height);
        }
    });

    $('#save_thumb').click(function() {
        var x1 = $('#x1').val();
        var y1 = $('#y1').val();
        var x2 = $('#x2').val();
        var y2 = $('#y2').val();
        var w = $('#w').val();
        var h = $('#h').val();
        if(x1=="" || y1=="" || x2=="" || y2=="" || w=="" || h==""){
                alert("You must make a selection first !");
                return false;
        }else{
                return true;
        }
    });
});