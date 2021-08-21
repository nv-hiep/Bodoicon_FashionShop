<h1 class="page-header"><?= __('slider.crop'); ?></h1>
<?php
$vals = explode(":", $rat);
$dif = ($width/$height)-($vals[0]/$vals[1]);
$mess = (abs($dif) < 0.001) ? __('message.no_need_resize') : __('message.need_resize');
?>
<h4 class="red_font"><?=$mess;?></h4>

<img src="<?php echo Uri::base() . 'assets/img/prod_img/' . $img->image_name; ?>" style="float: left; margin-right: 10px;" rat="<?= $rat; ?>" wx="<?= $width; ?>" hy="<?= $height; ?>" id="imgx" alt="" />
<div style="border:1px #e5e5e5 solid; float:left; position:relative; overflow:hidden; width:<?= $pw; ?>px; height:<?= $ph; ?>px;">
    <img src="<?php echo Uri::base() . 'assets/img/prod_img/' . $img->image_name; ?>" style="position: relative;" alt="Thumbnail Preview" />
</div>
<br style="clear:both;"/>
<?php echo Form::open(array("name" => "thumbnail", "class"=>"form-horizontal")); ?>
    <div class="form-group">
        <input type="hidden" name="x1" value="" id="x1" />
        <input type="hidden" name="y1" value="" id="y1" />
        <input type="hidden" name="x2" value="" id="x2" />
        <input type="hidden" name="y2" value="" id="y2" />
        <input type="hidden" name="w" value="" id="w" />
        <input type="hidden" name="h" value="" id="h" />
    </div>
    <div class="form-group">
        <?php echo Form::label('Image name', 'img', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-6">
            <?php echo Form::input('img', $img->image_name, array('class' => 'form-control', "readonly" => "readonly")); ?>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <?php echo Form::button('submit', 'Save', array("id"=>"save_thumb", 'class' => 'btn btn-default')); ?>
            <?php echo Html::anchor('admin/product/edit/' . $pid, __('common.cancel'), array('class' => 'btn btn-default')); ?>
        </div>
    </div>
<?php echo Form::close(); ?>