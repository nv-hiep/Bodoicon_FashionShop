<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- icon -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="description" content="Quần áo đôi, áo cặp, áo thun, áo sơ mi, áo gia đình tại Bộ đội con shop.">
        <meta name="keywords" content="Áo đôi, Áo gia đình, Áo thun, Áo sơ mi, Bộ đội con shop">
        <title><?php echo isset($title) ? $title . ' | ' .__('title.pri_title') : __('title.pri_title') ?></title>

        <!-- CSS here-->
        <?php  echo Asset::render('css');?>
        <script>
            var base_url = '<?php echo Uri::base(); ?>';
        </script>
    </head>
    <body>

        <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#" style="color: white"><?php echo __('admin_common.main_title'); ?></a>
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="navbar-header pull-right">
                    <a class="navbar-brand" target="_blank" href="<?php echo Uri::base() . 'home'; ?>" style="color: white"><?php echo __('admin_common.view_page'); ?></a>
                </div>
            </div>
        </div>

        <div class="container-fluid">

            <div class="row">

                <div class="col-sm-3 col-md-2 sidebar" id="bs-example-navbar-collapse-1" style="overflow-x: hidden">
                    <!-- Menu -->
                    <?php include_once 'menu.php'; ?>
                </div>

                <!-- Content of edit user page, add user page, etc. -->
                <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

                    <?php if (Session::get_flash('success')) : ?>
                        <div class="bs-callout bs-callout-success">
                            <h4><?php echo __("common.Success") ?></h4>
                            <p><?php echo implode('</p><p>', (array) Session::get_flash('success')); ?></p>
                        </div>
                    <?php endif; ?>


                    <?php if(Session::get_flash('error')) : ?>
                        <div class="bs-callout bs-callout-danger">
                            <h4><?php echo __("common.Error") ?></h4>
                            <p><?php echo implode('</p><p>', (array) Session::get_flash('error')); ?></p>
                        </div>
                    <?php endif; ?>

                    <?php echo isset($content) ? $content : ''; ?>
                </div>

            </div>

        </div>

        <!-- JS here-->
        <?php echo Asset::render('js'); ?>
    </body>
    <?php
        $cache = Session::get_flash('cache');
        if ($cache == 'del') {
            Controller_Admin_Base::delete_files(APPPATH . '/cache/auth/');
        }
    ?>
</html>
