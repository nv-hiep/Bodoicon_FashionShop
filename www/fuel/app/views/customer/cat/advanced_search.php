<div class="mens" id="search-result">
    <div class="main">
        <div class="wrap">
            <div class="cont span_2_of_3">
                <h2 class="head"><?= __('account.search'); ?></h2>
                <div class="mens-toolbar adv-search">
                    <div class="sort">
                        <div class="sort-by">
                            <label><?php echo ((int) $nbr_prods > 0) ? $nbr_prods . ' ' . __('message.search_result') : __('message.no_result'); ?></label>
                        </div>
                    </div>
                    <?php
                    $pag_links = Pagination::instance('paging');
                    echo $pag_links->render();
                    ?>
                    <div class="clear"></div>
                </div>

                <?php $i         = 1; ?>
                <?php foreach ($prods as $prod) : ?>
                    <?php if (($i % 3) == 1) : ?>
                        <div class="top-box">
                        <?php endif; ?>
                        <div class="col_1_of_3 span_1_of_3 prodblock" data-rotate-x="30deg" data-rotate-y="30deg" data-move-z="-100px">
                            <a href="<?php echo Uri::base() . $prod->slug . '.html' ?>">
                                <div class="inner_content clearfix">
                                    <div class="product_image">
                                        <img src="<?php echo Uri::base() . 'assets/img/prod_img/' . $prod->p2pit->image_name ?>" alt="<?= $prod->p2pit->image_name; ?>"/>
                                    </div>
                                    <?php
                                    if ((strlen($prod->sale_price) > 0) and ( (float) $prod->sale_price > (float) $prod->price)) {
                                        $sale_box = "sale-box1";
                                        $sal      = 'sale';
                                        $hot_bg   = '';
                                    } else {
                                        $sale_box = "sale-box";
                                        $sal      = 'hot';
                                        $hot_bg   = 'hot-prod';
                                    }
                                    ?>
                                    <div class="<?= $sale_box; ?>"><span class="on_sale title_shop" id="<?= $hot_bg; ?>"><?= $sal; ?></span></div>
                                    <div class="price">
                                        <div class="cart-left">
                                            <p class="title"><?= $prod->product_name; ?></p>
                                            <div class="price1">
                                                <?php if ((strlen($prod->sale_price) > 0) and ( (float) $prod->sale_price > (float) $prod->price)) : ?>
                                                    <span class="reducedfrom"><?= $prod->sale_price; ?>k</span>
                                                    <span class="actual"><?= $prod->price; ?>k</span>
                                                <?php else : ?>
                                                    <span class="actual"><?= $prod->price; ?>k</span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="cart-right"> </div>
                                        <div class="clear"></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <?php if ((($i % 3) == 0) or ( $i == count($prods))) : ?>
                            <div class="clear"></div>
                        </div>
                    <?php endif; ?>
                    <?php $i++; ?>
                <?php endforeach; ?>

                <div class="clear"></div>

                <div class="mens-toolbar adv-search">
                    <?php
                    $pag_links = Pagination::instance('paging');
                    echo $pag_links->render();
                    ?>
                    <div class="clear"></div>
                </div>

            </div>
            <?php include_once 'side_search.php'; ?>
            <div class="clear"></div>
        </div>
    </div>
</div>