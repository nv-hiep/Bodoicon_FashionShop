$(document).ready(function () {

    // Crop Image
    var xx  = $('#phox').attr('wx');
    var yy  = $('#phox').attr('hy');
    var rat = $('#phox').attr('rat');
    var ret = rat.split(":");

    $('#phox').imgAreaSelect({aspectRatio: rat, maxWidth: xx, maxHeight: yy, handles: true,
        x1: 0, y1: 0, x2: xx, y2: yy,
        onSelectChange: function (photo, sel) {
            var scaleX = ret[0] / sel.width;
            var scaleY = ret[1] / sel.height;

            $('#phox + div > img').css({
                    width: Math.round(scaleX * xx) + 'px',
                    height: Math.round(scaleY * yy) + 'px',
                    marginLeft: '-' + Math.round(scaleX * sel.x1) + 'px',
                    marginTop: '-' + Math.round(scaleY * sel.y1) + 'px'
            });
            $('#x1').val(sel.x1);
            $('#y1').val(sel.y1);
            $('#x2').val(sel.x2);
            $('#y2').val(sel.y2);
            $('#w').val(sel.width);
            $('#h').val(sel.height);
        }
    });

    $('#save_prethumb').click(function() {
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