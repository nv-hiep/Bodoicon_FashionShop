<h1 class="page-header"><?= __('cat.add_cat'); ?></h1>
<?php echo Form::open(array("class"=>"form-horizontal")); ?>
    <div class="form-group">
        <?php echo Form::label(__('common.name'), 'name', array('class' => 'col-sm-2 control-label required')); ?>
        <div class="col-sm-6">
            <?php echo Form::input('name', Input::post('name', isset($cat) ? $cat->name : ''), array('id' => 'field-name', 'class' => 'form-control')); ?>
            <?php echo Form::error('name', $err); ?>
        </div>
    </div>

    <div class="form-group">
        <?php echo Form::label(__('common.slug'), 'slug', array('class' => 'col-sm-2 control-label required')); ?>
        <div class="col-sm-6">
            <?php echo Form::input('slug', Input::post('slug', isset($cat) ? $cat->slug : ''), array('id' => 'field-slug', 'class' => 'form-control', 'readonly' => 'readonly')); ?>
            <?php echo Form::error('slug', $err); ?>
        </div>
    </div>

    <div class="form-group">
        <?php echo Form::label(__('cat.order'), 'order', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-6">
            <?php echo Form::input('order', Input::post('order', isset($cat) ? $cat->order : ''), array('class' => 'form-control', 'placeholder' => $ord_max)); ?>
            <?php echo Form::error('order', $err); ?>
        </div>
    </div>

    <?php if (count($cats) > 1) : ?>
    <div class="form-group">
        <?php echo Form::label(__('cat.parent'), 'parent', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-6">
            <?php echo Form::select('parent', Input::post('parent', isset($cat) ? $cat->parent_id : ''), $cats, array('class' => 'form-control')); ?>
            <?php echo Form::error('parent', $err); ?>
        </div>
    </div>
    <?php endif; ?>

    <div class="form-group">
        <?php echo Form::label('', 'display', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-6 checkbox">
            <label>
                <?php
                if (Input::method() == 'POST') {
                    $display = Input::post('active');
                } else {
                    $display = $cat->active;
                }
                ?>
                <?php echo Form::checkbox('active', true, $display); ?>
                <?php echo __('common.display'); ?>
            </label>
        </div>
    </div>

    <div class="form-group">
        <?php echo Form::label('', 'storage', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-6 checkbox">
            <label>
                <?php
                if (Input::method() == 'POST') {
                    $storage = Input::post('storage');
                } else {
                    $storage = $cat->storage;
                }
                ?>
                <?php echo Form::checkbox('storage', true, $storage); ?>
                <?php echo __('common.cat_of_prods'); ?>
            </label>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <?php echo Form::button('submit', __('common.btn_submit'), array('class' => 'btn btn-default')); ?>
            <?php echo Html::anchor('admin/categories', __('common.cancel'), array('class' => 'btn btn-default')); ?>
        </div>
    </div>
<?php echo Form::close(); ?>