<?php $pay = 0; ?>
<div class="col_1_of_login col_3_checkout">
    <div class="login-title">
        <h4 class="title" style="font-size: 1.1em;"><?= __('cart.order_info') ?></h4>
        <div id="loginbox" class="loginbox">

            <?php foreach ($product as $product_id => $data):
                $pay = $pay + $data['total']; ?>
            <div class="col_1_of_login span_1_of_login" style="width: 25%; margin-left: .6%;">
                    <img src="<?php echo Uri::base() . 'assets/img/prod_img/' . $data['image']; ?>" width="100px" height="95px" alt="">
            </div>
            <div class="col_1_of_login span_1_of_login" style="width: 65%; margin-left: 1%;">
                <p title="<?php echo $data['product_name'];  ?>" class="cart-prod-name"><?php echo $data['product_name'];  ?></p>

                <?php foreach ($data['related_info'] as $related_data): ?>
                <p>
                    <?php if($related_data['color'] != 'nocolor'): ?>
                        <span class="select-color-padding" style="margin-right: 3px; background: <?= $related_data['color'] ?>"></span>
                    <?php endif; ?>
                    <?php echo '(' . $related_data['size'] .')' .$related_data['quantity'] . ' x '. number_format($data['unit_price'].'000', 0, '', '.').' Đ'?>
                </p>
                <?php endforeach; ?>
            </div>

            <div class="clear" style="border: solid 1px #DFDDDD;"></div>
            <?php endforeach; ?>

            <div class="col_1_of_login span_1_of_login" style="width: 40%; margin-left: 1.6%;">
                <?= __('cart.total_prod') ?>:
            </div>
            <div class="col_1_of_login span_1_of_login text-bold" style="width: 25%; margin-left: 1.6%;">
                <?php echo number_format($pay.'000', 0, '', '.').' Đ'?>
            </div>
        </div>
    </div>
</div>