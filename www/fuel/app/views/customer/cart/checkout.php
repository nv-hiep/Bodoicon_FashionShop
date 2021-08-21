<div class="login">
    <?php echo Form::open(); ?>
        <div class="wrap checkout">
            <ul class="breadcrumb breadcrumb__t"><a class="home" href="#"><?= __('common.home') ?></a> / <a href="#"><?= __('menu.prod') ?></a> / <?= __('cart.buy') ?></ul>
            <h5 class="m_6"><?= __('cart.payment_order') ?></h5>
            <div class="col_1_of_login col_1_checkout">
                <h4 class="title" style="font-size: 1.1em;"><?= __('cart.delivery_info') ?></h4>

                            <fieldset class="input">
                                <p>
                                    <?php
                                    if (!Auth::instance()->check()) {
                                        echo Form::label(__('account.fullname'), '', array('class'=>'required text-bold'));
                                        echo Form::input('fullname',$customer['fullname'], array(
                                            'class'=>'inputbox',
                                            'size'=>18,
                                            'autocomplete'=>'off',
                                            'placeholder'=>__('account.fullname')
                                        ));
                                    } else {
                                        echo Form::label(__('account.fullname') .': ', '', array('class'=>'text-bold'));
                                        echo Form::label($customer['fullname']);
                                    }?>
                                    <?php echo Form::error('fullname', $err); ?>
                                </p>


                                <p>
                                    <?php
                                    if (!Auth::instance()->check()) {
                                        echo Form::label(__('account.phone'), '', array('class'=>'required text-bold'));
                                        echo Form::input('phone', $customer['phone'], array(
                                            'class'=>'inputbox',
                                            'size'=>18,
                                            'autocomplete'=>'off',
                                            'placeholder'=>__('account.phone')
                                        ));
                                    } else {
                                        echo Form::label(__('account.phone').': ', '', array('class'=>'text-bold'));
                                        echo Form::label($customer['phone']);
                                    }?>
                                    <?php echo Form::error('phone', $err); ?>
                                </p>


                                <p>
                                    <?php
                                        if (!Auth::instance()->check()) {
                                            echo Form::label(__('account.address'), '', array('class'=>'required text-bold'));
                                            echo Form::input('address',$customer['address'], array(
                                                'class'=>'inputbox',
                                                'size'=>18,
                                                'autocomplete'=>'off',
                                                'placeholder'=>__('account.address')
                                            ));
                                        } else {
                                            echo Form::label(__('account.address').': ', '', array('class'=>'text-bold'));
                                            echo Form::label($customer['address']);
                                        } ?>
                                    <?php echo Form::error('address', $err); ?>
                                </p>


                                <p>
                                    <label class="text-bold"><?= __('cart.note_title') ?></label>
                                </p>
                                    <div class="text">
                                        <?php
                                        echo Form::textarea('note',$customer['note'], array(
                                            'style'=>'margin:0px;width:94%;height:100px;',
                                            'placeholder'=>__('cart.note'),
                                        )); ?>
                                        <?php echo Form::error('note', $err); ?>
                                    </div>

                                <?php if (!Auth::instance()->check()): ?>
                                <div class="remember" style="text-align: right">
                                    <p>
                                        <label><a  href="<?php echo Uri::base().'account/login'; ?>"><?= __('account.login_header'); ?></a></label> |
                                        <label><a href="<?php echo Uri::base().'account/register'; ?>"><?= __('account.register'); ?></a></label>
                                    </p>
                                </div>
                                <?php endif; ?>
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

            <?php include_once '_checkout_product.php'; ?>

            <button type="submit" class="grey" style="float: right;  margin-right: 3.5%; margin-top: 0.8%;"><?= __('cart.buy') ?></button>

            <div class="clear"></div>
        </div>
    <?php echo Form::close(); ?>
</div>