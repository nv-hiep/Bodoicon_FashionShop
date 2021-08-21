<div class="mens">
    <div class="main">
        <div class="wrap">
            <ul class="breadcrumb breadcrumb__t"><a class="home" href="<?= Uri::base().'home'; ?>"><?= __('common.home'); ?></a>  / <?= $prod->product_name; ?></ul>
            <div class="cont span_2_of_3">
                <div class="grid images_3_of_2 img-add-to-cart-effect">
                    <ul id="etalage">
                        <?php foreach ($prod->images as $img) :?>
                        <li>
                            <img class="etalage_thumb_image" src="<?php echo Uri::base() . 'assets/img/prod_img/thumb' . $img; ?>" class="img-responsive"/>
                            <img class="etalage_source_image" src="<?php echo Uri::base() . 'assets/img/prod_img/' . $img; ?>" class="img-responsive" title="" />
                        </li>
                        <?php endforeach;?>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="desc1 span_3_of_2">
                    <h3 class="m_3"><?= $prod->product_name; ?></h3>
                    <?php if ((strlen($prod->sale_price) > 0) and ( (float) $prod->sale_price > (float) $prod->price)) : ?>
                        <p class="m_5"><?= $prod->price; ?>.000 Đ <span class="reducedfrom"><?= $prod->sale_price; ?>.000 Đ</span></p>
                    <?php else : ?>
                        <p class="m_5"><?= $prod->price; ?>.000 Đ</p>
                    <?php endif; ?>

                    <!--số lượng sp-->
                    <div class="btn_form" style="padding: 2%">

                        <div class="col_1_of_f_2 span_1_of_f_2" style="width: 20%">
                            <label><?= __('cart.prod_quantity') ?></label>
                        </div>
                        <div class="col_1_of_f_2 span_1_of_f_2">
                            <?php echo Form::input('quantity', 1, array(
                                'class'=>'textbox quantity',
                                'size'=>2,
                                'style' => 'text-align:center'
                            )) ?>
                        </div>
                    </div>

                    <div class="clear"></div>

                    <!--size của sản phẩm-->
                    <?php
                    $size = trim($prod->size);
                    if (!empty($size)): ?>
                        <div class="btn_form" style="padding: 2%">

                            <div class="col_1_of_f_2 span_1_of_f_2" style="width: 20%">
                                <label><?= __('cart.prod_size') ?></label>
                            </div>
                            <div class="col_1_of_f_2 span_1_of_f_2">
                                <?php foreach (explode(' ', trim($size)) as $s): ?>
                                        <?php if (!empty($s)) : ?>
											<div style="float: left; width:80px; height: 25px;">
												<label class="radio-inline" style="padding-right: 5px;">
													<input type="radio" name="size" style="margin: 0px 3px 0px 0px;" value="<?php echo $s; ?>"><?php echo $s; ?>
												</label>
											</div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="clear"></div>

                    <!--Màu sắc-->
                    <?php if (!empty($prod->colors)): ?>
                        <div class="btn_form" style="padding: 2%">

                            <div class="col_1_of_f_2 span_1_of_f_2" style="width: 20%">
                                <label><?= __('cart.prod_color') ?></label>
                            </div>
                            <div class="col_1_of_f_2 span_1_of_f_2">
                                <?php foreach ($prod->colors as $color => $related_img): ?>
									<div style="float: left; width:80px; height: 30px;">
										<label class="radio-inline" style="padding-right: 5px;">
											<input name="color" type="radio" style="margin: margin: 0px 2px 0px 0px;" value="<?php echo $color; ?>"><span class="select-color-padding" style="background: <?php echo $color; ?>"></span>
											<input name="related_img_<?php echo $color ?>" type="hidden" value="<?php echo $related_img ?>">
										</label>
									</div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php else:
                        $img_tmp = $prod->images; ?>
                        <input name="related_img_nocolor" type="hidden" value="<?php echo reset($img_tmp) ?>">
                    <?php endif; ?>

                    <div class="clear"></div>

                    <div class="btn_form">
                        <form>
                            <input type="submit" class="add-to-cart" value="<?= __('cart.buy') ?>" product_id = <?php echo $prod->id ?>>
                        </form>
                    </div>
                    <p class="m_text2"><?= $prod->short_description; ?></p>
                </div>

                <div class="clear"></div>

                <div class="toogle" id="product-detail">
                    <h3 class="m_3"><?= __('prod.detail'); ?></h3>
                    <p class="m_text"><?= htmlspecialchars_decode($prod->detail_description); ?></p>
                </div>

                <div class="clients">
                    <h3 class="m_3"><?= __('prod.same_cat'); ?></h3>
                    <ul id="flexiselDemo3">
                        <?php foreach ($rel_prods as $prod) : ?>
                        <li><a href="<?= Uri::base() . $prod->slug . '.html' ;?>"><img src="<?php echo Uri::base() . 'assets/img/prod_img/' . $prod->p2pit->image_name; ?>" height="120" /></a><a href="<?= Uri::base() . $prod->slug . '.html' ;?>"><?= $prod->product_name; ?></a><p><?=$prod->price . '.000 Đ'; ?></p></li>
                        <?php endforeach; ?>
                    </ul>
                </div>

            </div>

            <?php include_once APPPATH.'views/customer/cat/side_search.php'; ?>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>
</div>