<!DOCTYPE HTML>
<html>
    <head>
        <meta name="viewport" content="width=device-width, maximum-scale=1.0, initial-scale=1, user-scalable=no" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-touch-fullscreen" content="yes" />
        <meta name="description" content="Quần áo đôi, áo cặp, áo thun, áo sơ mi, áo gia đình tại Bộ đội con shop.">
        <meta name="keywords" content="Áo đôi, Áo gia đình, Áo thun, Áo sơ mi, Bộ đội con shop">
        <link rel="icon" href="<?php echo Uri::base().'assets/img/favicon.ico'; ?>" type="image/x-icon">

        <title><?php echo isset($title) ? $title . ' | ' .__('title.pri_title') : __('title.pri_title') ?></title>

        <?php echo Asset::render('css'); ?>

        <script>var base_url = '<?php echo Uri::base(); ?>';</script>

        <?php
        $curretn_cart = Session::get('current_cart');
        if (!empty($curretn_cart)): ?>
            <script>var current_cart = <?php echo json_encode($curretn_cart); ?></script>
        <?php else: ?>
            <script>var current_cart = <?php echo json_encode(array()); ?></script>
        <?php endif; ?>

    </head>
    <body>
        <!--top menu-->
        <?php require_once 'layout/navbar_top.php'; ?>

        <?php require_once 'layout/notification.php'; ?>

        <!--main menu, content logo, categories...-->
        <?php require_once 'layout/navbar_main.php'; ?>

        <!--content-->

        <?php echo isset($content) ? $content : ''; ?>

        <!--footer-->
        <?php require_once 'layout/footer.php' ?>

        <!--javascript-->
        <?php echo Fuel\Core\Asset::render('js'); ?>
    </body>
</html>