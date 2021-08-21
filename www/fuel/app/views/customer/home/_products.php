<div class="main">
    <div class="wrap">
        <div class="section group">
            <div class="cont span_2_of_3">
                <h2 class="head"><?= __('prod.new_prod');  ?></h2>

                <?php $i=1; ?>
                <?php foreach ($new_prds as $prod) : ?>
                <?php if (($i%3) == 1)  : ?>
                <div class="top-box">
                <?php endif; ?>
                    <div class="col_1_of_3 span_1_of_3">
                        <a href="<?php echo Uri::base() . $prod->slug . '.html'; ?>">
                            <div class="inner_content clearfix">
                                <div class="product_image">
                                    <img src="<?php echo Uri::base() . 'assets/img/prod_img/' . $prod->thumbnail; ?>" width="300" height="273" alt=""/>
                                </div>
                                <div class="sale-box"><span class="on_sale title_shop">New</span></div>
                                <div class="price">
                                    <div class="cart-left">
                                        <p class="title"><?= $prod->product_name; ?></p>
                                        <div class="price1">
                                            <?php if ( (strlen($prod->sale_price) > 0) and ((float)$prod->sale_price > (float)$prod->price) ) : ?>
                                            <span class="reducedfrom"><?=$prod->sale_price;?>k</span>
                                            <span class="actual"><?=$prod->price;?>k</span>
                                            <?php else : ?>
                                            <span class="actual"><?=$prod->price;?>k</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="cart-right"> </div>
                                    <div class="clear"></div>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php if (($i%3) == 0 or ($i==count($new_prds)))  : ?>
                <div class="clear"></div>
                </div>
                <?php endif; ?>
                <?php $i++; ?>
                <?php endforeach; ?>




                <h2 class="head"><?= __('prod.ft_prod');  ?></h2>
                <?php $i=1; ?>
                <?php foreach ($ft_prds as $prod) : ?>
                <?php if (($i%3) == 1)  : ?>
                <div class="section group">
                <?php endif; ?>
                <div class="col_1_of_3 span_1_of_3">
                    <a href="<?php echo Uri::base() . $prod->slug . '.html'; ?>">
                        <div class="inner_content clearfix">
                            <div class="product_image">
                                <img src="<?php echo Uri::base() . 'assets/img/prod_img/' . $prod->thumbnail; ?>" width="300" height="273" alt=""/>
                            </div>
                            <?php
                            if ( (strlen($prod->sale_price) > 0) and ((float)$prod->sale_price > (float)$prod->price) ) {
                                $sale_box = "sale-box1";
                                $sal = 'sale';
                                $hot_bg = '';
                            } else {
                                $sale_box = "sale-box";
                                $sal = 'hot';
                                $hot_bg = 'hot-prod';
                            }
                            ?>
                            <div class="<?=$sale_box;?>"><span class="on_sale title_shop" id="<?=$hot_bg;?>"><?=$sal;?></span></div>
                            <div class="price">
                                <div class="cart-left">
                                    <p class="title"><?= $prod->product_name; ?></p>
                                    <div class="price1">
                                        <?php if ( (strlen($prod->sale_price) > 0) and ((float)$prod->sale_price > (float)$prod->price) ) : ?>
                                        <span class="reducedfrom"><?=$prod->sale_price;?>k</span>
                                        <span class="actual"><?=$prod->price;?>k</span>
                                        <?php else : ?>
                                        <span class="actual"><?=$prod->price;?>k</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="cart-right"> </div>
                                <div class="clear"></div>
                            </div>
                        </div>
                    </a>
                </div>
                <?php if (($i%3) == 0 or ($i==count($ft_prds)))  : ?>
                <div class="clear"></div>
                </div>
                <?php endif; ?>
                <?php $i++; ?>
                <?php endforeach; ?>
            </div>

            <?php require_once '_slider_right.php'; ?>
            <div class="clear"></div>
        </div>
    </div>
</div>