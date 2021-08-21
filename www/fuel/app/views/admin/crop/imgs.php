<h1 class="page-header"><?= __('slider.crop_prepare'); ?></h1>

<h3>Tải ảnh</h3>
<div class="form-group-border">
<?php echo Form::open(array("class"=>"form-horizontal", 'enctype' => 'multipart/form-data')); ?>
    <div class="form-group">
        <?php echo Form::label(__('slider.photo'), 'photo', array('class' => 'col-sm-2 control-label required')); ?>
        <div class="col-sm-6">
            <?php echo Form::file('img', array('class' => '')); ?>
            <?php echo Form::error('img', $err); ?>
        </div>
    </div>

    <div class="form-group">
        <?php $type = array('1' => __('common.thumbnail'), '0' => __('common.prod_img'));?>
        <?php echo Form::label(__('common.type'), 'type', array('class' => 'col-sm-2 control-label required')); ?>
        <div class="col-sm-9">
            <?php echo Form::select('type', Input::post('status'), $type, array('class' => 'form-control')); ?>
            <?php echo Form::error('type', $err); ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <?php echo Form::button('submit', __('common.btn_submit'), array('value' => 'upload', 'class' => 'btn btn-default')); ?>
            <?php echo Html::anchor('admin/crop/prepare', __('common.cancel'), array('class' => 'btn btn-default')); ?>
        </div>
    </div>
<?php echo Form::close(); ?>
</div>

<?php if (strlen($img) > 0) : ?>
<h3><?=__('img.resize'); ?> - <?php echo ($thumb == true) ? __('common.thumbnail') : __('common.prod_img'); ?> </h3>
<div class="form-group-border">
    <img src="<?php echo Uri::base() . 'assets/img/prepare/temp/' . $img; ?>" style="float: left; margin-right: 10px;" rat="<?= $rat; ?>" wx="<?= $width; ?>" hy="<?= $height; ?>" id="phox" alt="" />
    <div style="border:1px #e5e5e5 solid; float:left; position:relative; overflow:hidden; width:<?= $pw; ?>px; height:<?= $ph; ?>px;">
        <img src="<?php echo Uri::base() . 'assets/img/prepare/temp/' . $img; ?>" style="position: relative;" alt="Thumbnail Preview" />
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
            <input type="hidden" name="type" value="<?=$thumb;?>"/>
        </div>
        <div class="form-group">
            <?php echo Form::label('Image name', 'img', array('class' => 'col-sm-2 control-label')); ?>
            <div class="col-sm-6">
                <?php echo Form::input('img', $img, array('class' => 'form-control', "readonly" => "readonly")); ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <?php echo Form::button('submit', __('common.save'), array('value' => 'save_thumb', "id"=>"save_prethumb", 'class' => 'btn btn-default')); ?>
                <?php echo Html::anchor('admin/crop/prepare/', __('common.cancel'), array('class' => 'btn btn-default')); ?>
            </div>
        </div>
    <?php echo Form::close(); ?>
</div>
<?php endif; ?>