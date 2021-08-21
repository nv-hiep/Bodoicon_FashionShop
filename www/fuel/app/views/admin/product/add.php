<h1 class="page-header"><?= __('prod.add_new'); ?></h1>
<?php echo Form::open(array("class" => "form-horizontal", 'enctype' => 'multipart/form-data')); ?>
<div class="form-group">
    <?php echo Form::label(__('common.name'), 'name', array('class' => 'col-sm-2 control-label required')); ?>
    <div class="col-sm-9">
        <?php echo Form::input('name', Input::post('name'), array('id' => 'field-name', 'class' => 'form-control')); ?>
        <?php echo Form::error('name', $err); ?>
    </div>
</div>

<div class="form-group">
    <?php echo Form::label(__('common.slug'), 'slug', array('class' => 'col-sm-2 control-label required')); ?>
    <div class="col-sm-9">
        <?php echo Form::input('slug', Input::post('slug'), array('id' => 'field-slug', 'class' => 'form-control', 'readonly' => 'readonly')); ?>
        <?php echo Form::error('slug', $err); ?>
    </div>
</div>

<?php if (count($cats) > 0) : ?>
    <div class="form-group">
        <?php echo Form::label(__('prod.cat'), 'category', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-9">
            <?php echo Form::select('cat', Input::post('cat'), $cats, array('id' => 'prod-cat', 'class' => 'form-control', 'multiple' => 'multiple')); ?>
            <?php echo Form::error('cat', $err); ?>
        </div>
    </div>
<?php endif; ?>

<div class="form-group">
    <?php echo Form::label(__('common.thumbnail'), 'thumbnail', array('class' => 'col-sm-2 control-label required')); ?>
    <div class="col-sm-9">
        <?php echo Form::file('thumbnail', array('class' => '')); ?>
        <?php echo Form::error('thumbnail', $err); ?>
    </div>
</div>

<div class="form-group">
    <?php echo Form::label(__('prod.short_desc'), 'short_desc', array('class' => 'col-sm-2 control-label required')); ?>
    <div class="col-sm-9">
        <?php echo Form::textarea('short_desc', Input::post('short_desc'), array('class' => 'form-control', 'rows' => 7)); ?>
        <?php echo Form::error('short_desc', $err); ?>
    </div>
</div>

<div class="form-group">
    <?php echo Form::label(__('prod.img'), 'img', array('class' => 'col-sm-2 control-label required')); ?>
    <div class="col-sm-9" id="prod-imgs">
        <?php for ($i = 0; $i < $img_count; $i++) : ?>
        <div class='file-input'>
            <?php echo Form::file('img['. $i .']', array("class" => "col-sm-6", 'multiple' => 'multiple')); ?>
            <?php echo Form::input('colour[]', "#000000", array("class" => "col-sm-2", "type" => "color")); ?>
            <?php if ($i > 0) :?> &nbsp <a href="#" class="rm-file"><?=__('prod.del_img');?></a> <?php endif; ?>
            <?php echo Form::error('img.' . $i, $err, 'col-sm-12 pad-left-0'); ?>
            <br/> <br/>
        </div>
        <?php endfor;?>
    </div>
</div>

<div class="form-group">
    <?php echo Form::label('', 'img', array('class' => 'col-sm-2 control-label')); ?>
    <div class="col-sm-9">
        <button id="add-file" type="button" class="btn btn-sm btn-primary"><?=__('prod.add_img');?></i></button>
    </div>
</div>

<div class="form-group">
    <?php echo Form::label(__('prod.detail'), 'detail', array('class' => 'col-sm-2 control-label required')); ?>
    <!--BEGIN ADD CKEDITOR -->
    <div class="form-spacing col-lg-9 col-md-9 col-sm-9">
        <?php echo ckeditor('detail', htmlspecialchars_decode(Input::post('detail')), array('class' => 'form-control', 'rows' => 4, 'height' => '500px'), ''); ?>
        <?php echo Form::error('detail', $err); ?>
    </div>
    <!--END ADD CKEDITOR -->
</div>

<div class="form-group">
    <?php echo Form::label(__('common.price'), 'price', array('class' => 'col-sm-2 control-label required')); ?>
    <div class="col-sm-9">
        <?php echo Form::input('price', Input::post('price'), array('class' => 'form-control')); ?>
        <?php echo Form::error('price', $err); ?>
    </div>
</div>

<div class="form-group">
    <?php echo Form::label(__('common.sale'), 'sale', array('class' => 'col-sm-2 control-label')); ?>
    <div class="col-sm-9">
        <?php echo Form::input('sale', Input::post('sale'), array('class' => 'form-control')); ?>
        <?php echo Form::error('sale', $err); ?>
    </div>
</div>

<div class="form-group">
    <?php echo Form::label(__('common.size'), 'size', array('class' => 'col-sm-2 control-label required')); ?>
    <div class="col-sm-9">
        <?php echo Form::input('size', Input::post('size'), array('class' => 'form-control')); ?>
        <?php echo Form::error('size', $err); ?>
        <p><?=__('message.size_mess');?></p>
    </div>
</div>

<div class="form-group">
    <?php $status = array('1' => __('common.avail'), '0' => __('common.unavail'));?>
    <?php echo Form::label(__('common.status'), 'status', array('class' => 'col-sm-2 control-label required')); ?>
    <div class="col-sm-9">
        <?php echo Form::select('status', Input::post('status'), $status, array('class' => 'form-control')); ?>
        <?php echo Form::error('status', $err); ?>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <?php echo Form::button('submit', __('common.btn_submit'), array('class' => 'btn btn-default prod-submit')); ?>
        <?php echo Html::anchor('admin/product', __('common.cancel'), array('class' => 'btn btn-default')); ?>
    </div>
</div>
<?php echo Form::close(); ?>