<h1 class="page-header"><?= __('button.add_auth'); ?></h1>
<?php echo Form::open(array("class"=>"form-horizontal", 'enctype' => 'multipart/form-data')); ?>
    <div class="form-group">
        <?php echo Form::label(__('menu.role'), 'authority', array('class' => 'col-sm-2 control-label required')); ?>
        <div class="col-sm-6">
            <?php echo Form::input('auth', Input::post('auth'), array('class' => 'form-control')); ?>
            <?php echo Form::error('auth', $error); ?>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <?php echo Form::button('submit', __('common.btn_submit'), array('class' => 'btn btn-default')); ?>
            <?php echo Html::anchor('admin/roles', __('common.cancel'), array('class' => 'btn btn-default')); ?>
        </div>
    </div>
<?php echo Form::close(); ?>
