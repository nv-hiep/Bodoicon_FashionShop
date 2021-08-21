
    <div class="login">
        <?php echo Form::open(); ?>
            <div class="wrap checkout">
                <ul class="breadcrumb breadcrumb__t"><a class="home" href="#"><?= __('common.home') ?></a> / <a href="#"><?= __('menu.prod') ?></a> / <?= __('cart.finish_checkout') ?></ul>
                <h5 class="m_6"><?= __('cart.finish_checkout') ?></h5>
                <p><?= __('cart.merci') ?></p>
                <br>
                <p><?= __('cart.payment_bill_id') . $bill_id; ?></p>
                <div class="col_1_of_login col_1_checkout">
                    <h4 class="title" style="font-size: 1.1em;"><?= __('cart.delivery_info') ?></h4>

                                <fieldset class="input">
                                    <p>
                                        <label class="text-bold"><?= __('cart.bill_id_title') ?>: </label>
                                        <?php echo Form::label($bill_id, '', array('style' => 'font-size:1.3em;')); ?>
                                    </p>

                                    <p>
                                        <label class="text-bold"><?= __('account.fullname') ?>: </label>
                                        <?php echo Form::label($customer['fullname']); ?>
                                    </p>

                                    <p>
                                        <label class="text-bold"><?= __('account.phone') ?>: </label>
                                        <?php echo Form::label($customer['phone']); ?>
                                    </p>

                                    <p>
                                        <label class="text-bold"><?= __('account.address') ?>: </label>
                                        <?php echo Form::label($customer['address']); ?>
                                    </p>

                                    <p>
                                        <label class="text-bold"><?= __('cart.note_title') ?>: </label>
                                        <?php echo Form::label($customer['note']); ?>
                                    </p>

                                </fieldset>
                </div>
                <div class="col_1_of_login col_1_checkout">
                    <div class="login-title">
                        <h4 class="title" style="font-size: 1.1em;"><?= __('cart.payment_method') ?></h4>
                        <div id="loginbox" class="loginbox">
                            <p class="text-bold"><?= __('cart.payment_method1') ?></p>
                            <p><?= __('cart.payment_method1_detail') ?></p>
                            <br>
                            <p class="text-bold"><?= __('cart.payment_method2') ?></p>
                            <p><?= __('cart.payment_method2_detail') ?></p>

                            <br>
                            <p class="text-bold"><?= __('cart.account_info') ?></p>
                            <p><?= __('cart.account_name') ?></p>
                            <p><?= __('cart.account_num') ?></p>
                            <p><?= __('cart.account_bank') ?></p>
                            <p><?= __('cart.account_branch') ?></p>
                        </div>

                    </div>
                </div>

                <?php $pay = 0; ?>
                <div class="col_1_of_login col_3_checkout">
                    <div class="login-title">
                        <h4 class="title" style="font-size: 1.1em;"><?= __('cart.order_info') ?></h4>
                        <div id="loginbox" class="loginbox">

                            <?php foreach ($product as $product_id => $prod):
                                $pay = $pay + $prod['total']; ?>
                            <div class="col_1_of_login span_1_of_login" style="width: 25%; margin-left: .6%;">
                                    <img src="<?php echo Uri::base() . 'assets/img/prod_img/' . $prod['image']; ?>" width="100px" height="95px" alt="">

                            </div>
                            <div class="col_1_of_login span_1_of_login" style="width: 65%; margin-left: 1%;">
                                <p title="<?php echo $prod['product_name']; ?>" class="cart-prod-name"><?php echo $prod['product_name']; ?></p>

                                <?php foreach ($prod['related_info'] as $related_data): ?>
                                <p>
                                    <?php if($related_data['color'] != 'nocolor'): ?>
                                        <span class="select-color-padding" style="margin-right: 3px; background: <?= $related_data['color'] ?>"></span>
                                    <?php endif; ?>
                                    <?php echo $related_data['quantity'] . ' x '. number_format($prod['unit_price'].'000', 0, '', '.').' Đ'?>
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


                <a href="<?php echo Uri::base().'home'; ?>">
                    <button type="button" class="grey" style="float: right;  margin-right: 3.5%; margin-top: 0.8%;"><?= __('button.back') ?></button>
                </a>

                <div class="clear"></div>
            </div>
        <?php echo Form::close(); ?>
        </div>