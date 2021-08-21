<ul class="nav nav-sidebar">
    <li><?php echo Html::anchor('admin/account', __('menu.account')); ?></li>
    <li><?php echo Html::anchor('admin/roles', __('menu.role')); ?></li>
    <li><?php echo Html::anchor('admin/perms', __('menu.perm')); ?></li>
    <li><?php echo Html::anchor('admin/roleperm', __('menu.role_perm')); ?></li>

    <li class="nav-divider"></li>
    <li><?php echo Html::anchor('admin/crop/prepare', __('menu.prepare_img')); ?></li>
    <li><?php echo Html::anchor('admin/crop/thumb', __('menu.download_thumb')); ?></li>
    <li><?php echo Html::anchor('admin/crop/img', __('menu.download_img')); ?></li>

    <li class="nav-divider"></li>
    <li><?php echo Html::anchor('admin/slider', __('menu.slider')); ?></li>
    <li><?php echo Html::anchor('admin/sideslider', __('menu.side_slider')); ?></li>
    <li><?php echo Html::anchor('admin/ads', __('menu.ads')); ?></li>

    <li class="nav-divider"></li>
    <li><?php echo Html::anchor('admin/categories',  __('menu.cat')); ?></li>
    <li><?php echo Html::anchor('admin/product',  __('menu.prod')); ?></li>

    <li class="nav-divider"></li>
    <li><?php echo Html::anchor('admin/cart/list', 'Quản lý đơn hàng'); ?></li>

    <li class="nav-divider"></li>
    <li><?php echo Html::anchor('admin/account/logout', __('menu.logout')); ?></li>
</ul>