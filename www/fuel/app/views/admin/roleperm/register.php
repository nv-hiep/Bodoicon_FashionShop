<h1 class="page-header"><?= __('title.set_role_perm'); ?></h1>
<?php echo Form::open(array("class" => "form-horizontal")); ?>

<div class="form-group">
    <?php echo Form::label(__('menu.role'), 'role', array('class' => 'col-sm-2 control-label required')); ?>
    <div class="col-sm-9">
        <?php echo Form::select('role', Input::post('role'), $auths, array('class' => 'form-control', 'id' => 'role')); ?>
        <?php echo Form::error('role', $error); ?>
    </div>
</div>

<div class="form-group">
    <?php echo Form::label(__('menu.perm'), 'permission', array('class' => 'col-sm-2 control-label required')); ?>
    <div class="col-sm-9">
        <?php echo Form::select('perm', Input::post('perm'), $perms, array('class' => 'form-control', 'id' => 'permission')); ?>
        <?php echo Form::error('perm', $error); ?>
    </div>
</div>

<div class="form-group">
    <?php echo Form::label(__('common.desc'), 'desc', array('class' => 'col-sm-2 control-label')); ?>
    <div class="col-sm-9">
        <?php echo Form::input('desc', Input::post('desc'), array('class' => 'form-control')); ?>
        <?php echo Form::error('desc', $error); ?>
    </div>
</div>

<div class="form-group">
    <?php
        $act = (Input::post('act')) ? Controller_Admin_Perms::serialise($controllers[Input::post('perm')]) : '';
    ?>
    <?php echo Form::label(__('title.actions'), 'actions', array('class' => 'col-sm-2 control-label required')); ?>
    <div class="col-sm-9">
        <span id="actions" value='<?= $act; ?>'></span>
        <br>
        <?php echo Form::error('act', $error); ?>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <?php echo Form::button('submit', __('common.btn_submit'), array('class' => 'btn btn-default prod-submit')); ?>
        <?php echo Html::anchor('admin/roleperm', __('common.cancel'), array('class' => 'btn btn-default')); ?>
    </div>
</div>
<?php echo Form::close(); ?>