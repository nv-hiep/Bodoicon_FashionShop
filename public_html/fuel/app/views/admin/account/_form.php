    <div class="form-group">
        <label for="account" class="col-sm-2 control-label required"><?= __('account.title_username'); ?></label>
        <div class="col-sm-6">
            <?php echo Form::input('username', $post['username'], array('autocomplete' => 'off','class'=>'form-control','placeholder'=>__('account.title_username'))); ?>
            <?php echo Form::error('username', $err); ?>
        </div>
    </div>

    <!--password field-->
    <?php isset($password_field) ? include_once $password_field : ''; ?>

    <div class="form-group">
        <label class="col-sm-2 control-label required"><?= __('account.fullname'); ?></label>
        <div class="col-sm-6">
            <?php echo Form::input('fullname', $post['fullname'],array('class'=>'form-control','placeholder'=>__('account.fullname'),'type'=>'text')); ?>
            <?php echo Form::error('fullname', $err); ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label required"><?= __('account.address'); ?></label>
        <div class="col-sm-6">
            <?php echo Form::input('address', $post['address'],array('class'=>'form-control','placeholder'=>__('account.address'),'type'=>'text')); ?>
            <?php echo Form::error('address', $err); ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label required"><?= __('account.phone');  ?></label>
        <div class="col-sm-6">
            <?php echo Form::input('phone', $post['phone'],array('class'=>'form-control','placeholder'=>__('account.phone'),'type'=>'text')); ?>
            <?php echo Form::error('phone', $err); ?>
        </div>
    </div>
    <!--roles-->
    <div class="form-group">
        <label class="col-sm-2 control-label required"><?= __('account.title_roles'); ?></label>
        <div class="col-sm-6">
            
            <?php foreach ($roles as $val) :?>
            <div class="checkbox">
              <label>
                      <?php 
                      echo Form::checkbox('roles[]', $val->id, isset($post['roles']) and in_array($val->id, $post['roles']));
                      echo $val->name;?>
              </label>
            </div>
            <?php endforeach; ?>
            
            <?php echo Form::error('roles', $err); ?>
        </div>
    </div>
