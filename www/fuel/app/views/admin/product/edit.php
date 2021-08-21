<h1 class="page-header"><?= __('prod.edit'); ?></h1>
<div class="col-sm-9">
    <?php echo Form::open(array("class" => "form-horizontal", 'enctype' => 'multipart/form-data')); ?>
    <div class="form-group">
        <?php echo Form::label(__('common.name'), 'name', array('class' => 'col-sm-2 control-label required')); ?>
        <div class="col-sm-9">
            <?php echo Form::input('name', Input::post('name', isset($p) ? $p->product_name : ''), array('id' => 'field-name', 'pid' => $p->id, 'class' => 'form-control')); ?>
            <?php echo Form::error('name', $err); ?>
        </div>
    </div>

    <div class="form-group">
        <?php echo Form::label(__('common.slug'), 'slug', array('class' => 'col-sm-2 control-label required')); ?>
        <div class="col-sm-9">
            <?php echo Form::input('slug', Input::post('slug', isset($p) ? $p->slug : ''), array('id' => 'field-slug', 'class' => 'form-control', 'readonly' => 'readonly')); ?>
            <?php echo Form::error('slug', $err); ?>
        </div>
    </div>

    <?php if (count($cats) > 0) : ?>
        <div class="form-group">
            <?php echo Form::label(__('prod.cat'), 'category', array('class' => 'col-sm-2 control-label')); ?>
            <div class="col-sm-9">
                <?php echo Form::select('cat', Input::post('cat', isset($sel_cats) ? $sel_cats : array()), $cats, array('id' => 'prod-cat', 'class' => 'form-control', 'multiple' => 'multiple')); ?>
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
            <?php echo Form::textarea('short_desc', Input::post('short_desc', isset($p) ? $p->short_description : ''), array('class' => 'form-control', 'rows' => 7)); ?>
            <?php echo Form::error('short_desc', $err); ?>
        </div>
    </div>

    <div class="form-group">
        <?php echo Form::label(__('prod.img'), 'img', array('class' => 'col-sm-2 control-label required')); ?>
        <div class="col-sm-9" id="prod-imgs">
            <?php for ($i = 0; $i < $img_count; $i++) : ?>
                <div class='file-input'>
                    <?php echo Form::file('img[' . $i . ']', array("class" => "col-sm-6", 'multiple' => 'multiple')); ?>
                    <?php echo Form::input('colour[]', "#000000", array("class" => "col-sm-2", "type" => "color")); ?>
                    <?php if ($i > 0) : ?> &nbsp <a href="#" class="rm-file"><?= __('prod.del_img'); ?></a> <?php endif; ?>
                    <?php echo Form::error('img.' . $i, $err, 'col-sm-12 pad-left-0'); ?>
                    <br/> <br/>
                </div>
            <?php endfor; ?>
        </div>
    </div>

    <div class="form-group">
        <?php echo Form::label('', 'img', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-9">
            <button id="add-file" type="button" class="btn btn-sm btn-primary"><?= __('prod.add_img'); ?></i></button>
        </div>
    </div>

    <div class="form-group">
        <?php echo Form::label(__('prod.detail'), 'detail', array('class' => 'col-sm-2 control-label required')); ?>
        <!--BEGIN ADD CKEDITOR -->
        <div class="form-spacing col-lg-9 col-md-9 col-sm-9">
            <?php echo ckeditor('detail', htmlspecialchars_decode(Input::post('detail', isset($p) ? $p->detail_description : '')), array('class' => 'form-control', 'rows' => 4, 'height' => '500px'), ''); ?>
            <?php echo Form::error('detail', $err); ?>
            <div class="preview"></div>
        </div>
        <!--END ADD CKEDITOR -->
    </div>

    <div class="form-group">
        <?php echo Form::label(__('common.price'), 'price', array('class' => 'col-sm-2 control-label required')); ?>
        <div class="col-sm-9">
            <?php echo Form::input('price', Input::post('price', isset($p) ? $p->price : ''), array('class' => 'form-control')); ?>
            <?php echo Form::error('price', $err); ?>
        </div>
    </div>

    <div class="form-group">
        <?php echo Form::label(__('common.sale'), 'sale', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-9">
            <?php echo Form::input('sale', Input::post('sale', isset($p) ? $p->sale_price : ''), array('class' => 'form-control')); ?>
            <?php echo Form::error('sale', $err); ?>
        </div>
    </div>

    <div class="form-group">
        <?php echo Form::label(__('common.size'), 'size', array('class' => 'col-sm-2 control-label required')); ?>
        <div class="col-sm-9">
            <?php echo Form::input('size', Input::post('size', isset($p) ? $p->size : ''), array('class' => 'form-control')); ?>
            <?php echo Form::error('size', $err); ?>
            <p><?= __('message.size_mess'); ?></p>
        </div>
    </div>

    <div class="form-group">
        <?php $status = array('1' => __('common.avail'), '0' => __('common.unavail')); ?>
        <?php echo Form::label(__('common.status'), 'status', array('class' => 'col-sm-2 control-label required')); ?>
        <div class="col-sm-9">
            <?php echo Form::select('status', Input::post('status', isset($p) ? $p->status : ''), $status, array('class' => 'form-control')); ?>
            <?php echo Form::error('status', $err); ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <?php echo Form::button('submit', __('common.btn_submit'), array('class' => 'btn btn-default prod-submit-edit')); ?>
            <?php echo Html::anchor('admin/product', __('common.cancel'), array('class' => 'btn btn-default')); ?>
        </div>
    </div>
    <?php echo Form::close(); ?>
</div>


<div class="col-sm-3 content-right">
    <h4><?= __('common.thumbnail'); ?></h4>
    <div>
        <div>
            <span class="img-hover-prod" path="<?= Uri::base() . 'assets/img/prod_img/' . $thumb->image_name ?>">
                <?php echo Html::img(Uri::base() . 'assets/img/prod_img/' . $thumb->image_name, array("prod" => "p" . $thumb->product_id, "imag" => $thumb->image_name, "alt" => $thumb->image_name, 'class' => "img-thumbnail img-responsive prod-imgs", 'width' => 208)); ?>
            </span>
        </div>
        <div class="img-action">
            <a href="<?= Uri::base() . 'admin/crop/resize/' . $thumb->id . '/' . $p->id; ?>" class="btn btn-default btn-xs del-img"><i class="glyphicon glyphicon-pencil icon-success"></i>  <?= __('prod.resize'); ?></a>
        </div>
    </div>

    <h4 class="prod-img-show"><?= __('prod.prod_img'); ?></h4>
    <?php foreach ($imags as $img) : ?>
        <div class="form-group">
            <div class="img-area">
                <span class="img-hover-prod" path="<?= Uri::base() . 'assets/img/prod_img/' . $img->image_name ?>">
                    <?php echo Html::img(Uri::base() . 'assets/img/prod_img/' . $img->image_name, array("prod" => "p" . $img->product_id, "imag" => $img->image_name, "alt" => $img->image_name, 'class' => "img-thumbnail img-responsive prod-imgs", 'width' => 208)); ?>
                </span>
            </div>
            <div class="img-action">
                <?php echo Form::input('', $img->colors, array("class" => "btn btn-default btn-xs change-color", "type" => "color")); ?>
                <a href="#" class="btn btn-default btn-xs edit-color"><i class="glyphicon glyphicon-ok icon-success"></i>  <?= __('prod.edit_color'); ?></a>
                <a href="<?= Uri::base() . 'admin/crop/resize/' . $img->id . '/' . $p->id; ?>" class="btn btn-default btn-xs del-img"><i class="glyphicon glyphicon-pencil icon-success"></i>  <?= __('prod.resize'); ?></a>
                <a href="<?= Uri::base() . 'admin/product/delimg/' . $img->image_name . '/'; ?>" class="btn btn-default btn-xs del-img" onclick="return confirm('<?= __('message.deleteyn'); ?>')"><i class="glyphicon glyphicon-remove icon-danger"></i>  <?= __('prod.del_img'); ?></a>
            </div>
        </div>
    <?php endforeach; ?>

</div>