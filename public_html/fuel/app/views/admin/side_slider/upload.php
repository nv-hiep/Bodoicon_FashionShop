<h1 class="page-header"><?= __('slider.upload_new'); ?></h1>
<?php echo Form::open(array("class"=>"form-horizontal", 'enctype' => 'multipart/form-data')); ?>
    <div class="form-group">
        <?php echo Form::label(__('slider.photo'), 'area', array('class' => 'col-sm-2 control-label required')); ?>
        <div class="col-sm-6">
            <?php echo Form::file('img', array('class' => '')); ?>
            <?php echo Form::error('img', $err); ?>
        </div>
    </div>

    <div class="form-group">
        <?php echo Form::label(__('slider.product_link'), 'product_link', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-6">
            <?php echo Form::select('product', Input::post('product'), $prods, array('class' => 'form-control')); ?>
            <?php echo Form::error('product', $err); ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <?php echo Form::button('submit', __('common.btn_submit'), array('class' => 'btn btn-default')); ?>
            <?php echo Html::anchor('admin/sideslider', __('common.cancel'), array('class' => 'btn btn-default')); ?>
        </div>
    </div>
<?php echo Form::close(); ?>
