<div class="form-group">
    <label class="col-sm-2 control-label required"><?= __('account.title_password'); ?></label>
    <div class="col-sm-6">
        <?php echo Form::input('password', $post['password'], array('class' => 'form-control', 'placeholder' => 'Mật khẩu', 'type' => 'password')); ?>
        <?php echo Form::error('password', $err); ?>
    </div>
</div>