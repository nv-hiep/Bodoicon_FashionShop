<div class="header-bottom">
    <div class="wrap">
        <div class="header-bottom-left">
            <div class="logo">
                <a href="<?php echo Uri::base() . 'trang-chu.html' ?>"><img src="<?php echo Uri::base() . 'assets/img/template_img/logo.png' ?>" alt=""/></a>
            </div>
            <div class="menu">
                <ul class="megamenu skyblue">
                    <?php foreach ($cats as $key => $cat) : ?>
                        <?php if ($cat->parent_id == false) : ?>
                            <?php if (count($cat->subcats) > 0) : ?>
                            <li class=""><a class="color5" href="javascript:void(0)"><?= $cat->name; ?></a>
                            <div class="megapanel">
                                <div class="col1">
                                    <div class="h_nav">
                                        <h4><a href="<?php echo Uri::base() . $cat->slug . '.html' ?>"><?= $cat->name; ?></a></h4>
                                        <ul>
                                            <?php foreach ($cat->subcats as $subcat) : ?>
                                            <li><a href="<?php echo Uri::base() . $subcat->slug . '.html' ?>"><?= $subcat->name; ?></a></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <?php else : ?>
                            <li class=""><a class="color5" href="<?php echo Uri::base() . $cat->slug . '.html' ?>"><?= $cat->name; ?></a>
                            <?php endif; ?>

                        </li>

                    <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="header-bottom-right">
            <?php echo Form::open(array('action' => Uri::base() . 'tim-kiem.html', 'method' => 'get')); ?>
            <div class="search">
                <?php echo Form::input('k', Input::get('k', ''), array('id' => 'search-input', 'class' => 'textbox', 'placeholder' => __('account.search'))); ?>
                <?php echo Form::submit('', '', array('id' => "submit")); ?>
                <div id="response"> </div>
            </div>
            <?php echo Form::close(); ?>
            <div class="tag-list">
                <ul class="icon1 sub-icon1 profile_img">
                    <li class="shopping-cart"><a class="active-icon c2" href="<?php echo Uri::base() . 'cart/view_cart' ?>"> </a>
                        <ul class="sub-icon1 list" style="padding-bottom: 0px">
                            <li class="short-cart-title">
                                <h3><?= __('prod.view_cart'); ?></h3>
                                <a href=""></a>
                            </li>
                            <li class="short-cart-detail">
                                <table class="short-cart-table short-cart-table-bordered"></table>
                            </li>

                        </ul>
                    </li>
                </ul>
                <ul class="last"><li><a href="<?php echo Uri::base() . 'cart/view_cart' ?>">Giỏ hàng(<span class="short-quantity">0</span>)</a></li></ul>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>