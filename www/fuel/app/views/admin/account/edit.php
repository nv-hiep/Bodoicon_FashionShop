<h1 class="page-header"><?= __('account.edit') ?></h1>
<?php 
    echo Form::open(array('class'=>'form-horizontal'));
    $password_field = '__password_field_edit.php';
    include_once '_form.php'; ?>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default"><?= __('button.edit') ?></button>
        </div>
    </div>
<!--</form>-->
<?php echo Form::close(); ?>