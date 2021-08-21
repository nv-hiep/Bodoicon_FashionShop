
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?= __('title.system_manager_title'); ?></title>
    <?php  echo Asset::render('css');?>
  </head>
  <body>
    <div class="container">
        <?php if(Session::get_flash('error')) : ?>
            <div class="bs-callout bs-callout-danger" style="width: 50%; margin: 0 auto;">
                <h4><?php echo __("common.Error") ?></h4>
                <p><?php echo implode('</p><p>', (array) Session::get_flash('error')); ?></p>
            </div>
        <?php endif; ?>
        <?php echo Form::open(array('class'=>'form-signin', 'action'=>Uri::base().'admin/account/login')); ?>

            <h2 class="form-signin-heading"><?= __('title.system_manager_title'); ?></h2>
            <?php echo Form::input('username', Input::post('username'), array('autocomplete'=>'off','class'=>'form-control','placeholder'=>'Tên đăng nhập')); ?>

            <?php echo Form::input('password', Input::post('password'),array('class'=>'form-control','placeholder'=>'Mật khẩu','type'=>'password')); ?>

            <button class="btn btn-lg btn-primary btn-block" type="submit"><?= __('button.account_login'); ?></button>

        <?php echo Form::close(); ?>
    </div>
  </body>
</html>
