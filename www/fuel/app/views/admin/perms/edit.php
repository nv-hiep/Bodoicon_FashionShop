<h1 class="page-header"><?= __('button.edit_auth'); ?></h1>
<?php echo Form::open(array("class" => "form-horizontal")); ?>
<div class="form-group">
    <?php echo Form::label(__('common.area'), 'area', array('class' => 'col-sm-2 control-label required')); ?>
    <div class="col-sm-9">
        <?php echo Form::input('area', Input::post('area', ($perm) ? $perm->area : ''), array('class' => 'form-control', 'placeholder' => 'som')); ?>
        <?php echo Form::error('area', $error); ?>
    </div>
</div>
<div class="form-group">
    <?php echo Form::label(__('menu.perm'), 'perm', array('class' => 'col-sm-2 control-label required')); ?>
    <div class="col-sm-9">
        <?php echo Form::select('perm', Input::post('perm', ($perm) ? $perm->permission : ''), $perms, array('class' => 'form-control', 'id' => 'permission')); ?>
        <?php echo Form::error('perm', $error); ?>
    </div>
</div>

<div class="form-group">
    <?php echo Form::label(__('common.desc'), 'desc', array('class' => 'col-sm-2 control-label')); ?>
    <div class="col-sm-9">
        <?php echo Form::input('desc', Input::post('desc', ($perm) ? $perm->description : ''), array('class' => 'form-control')); ?>
        <?php echo Form::error('desc', $error); ?>
    </div>
</div>

<div class="form-group">
    <?php
    $act = isset($perm) ? $perm->actions : '';
    $act = (Input::post('act')) ? Controller_Admin_Perms::serialise($controllers[Input::post('perm')]) : $act;
    if ((Input::method() == 'POST') and ( empty(Input::post('act')))) {
        $act = '';
    }
    ?>
    <?php echo Form::label(__('title.actions'), 'actions', array('class' => 'col-sm-2 control-label required')); ?>
    <div class="col-sm-9">
        <span id="actions" value='<?= $act; ?>' prim-perm='<?= $perm->permission; ?>'></span>
        <?php echo Form::error('act', $error); ?>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <?php echo Form::button('submit', __('common.btn_submit'), array('class' => 'btn btn-default prod-submit')); ?>
        <?php echo Html::anchor('admin/perms', __('common.cancel'), array('class' => 'btn btn-default')); ?>
    </div>
</div>
<?php echo Form::close(); ?>