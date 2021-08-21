<?php echo Form::open(); ?>
<div class="col_1_of_2 span_1_of_2">
    <div>
        <?php echo Form::label(__('common.name'), 'name', array('class' => 'required')); ?>
        <br>
        <?php echo Form::input('name', Input::post('name', isset($group) ? $group->name : ''), array('placeholder' => '')); ?>
        <?php echo Form::error('name', $error); ?>
    </div>
</div>
<div>
    <?php $authorities = Input::get_field_value('auth', isset($group) ? $group : null, null, Input::method() == 'POST' ? array() : array(USER_AUTH)); ?>
    <?php
    if (Input::post() and ( Input::post('auth') == null)) {
        $authorities = array();
    }
    ?>
    <?php echo Form::label(__('common.auth'), 'authority', array('class' => '')); ?>
    <br>
    <?php foreach ($auths as $key => $auth): ?>
        <div class="checkbox">
            <label>
                <?php echo Form::checkbox('auth[]', $key, in_array($key, $authorities)); ?>
                <?php echo $auth; ?>
            </label>
        </div>
    <?php endforeach; ?>
</div>

<div class="clear"></div>
<?php echo Form::button('submit', __('common.btn_submit'), array('class' => 'button button-left')); ?>
<?php echo Html::anchor('admin/accgroup', __('common.cancel'), array('class' => 'button button-left')); ?>
<br>
<?php echo Form::close(); ?>