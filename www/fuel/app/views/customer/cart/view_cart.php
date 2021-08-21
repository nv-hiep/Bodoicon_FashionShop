<?php $pay = 0; ?>
<div class="mens">
    <div class="main">
        <div class="wrap">
            <ul class="breadcrumb breadcrumb__t"><a class="home" href="#"><?= __('common.home') ?></a> / <a href="#"><?= __('menu.prod') ?></a> /<?= __('cart.title') ?></ul>

            <h5 class="m_6"><?= __('cart.detail') ?></h5>

            <?php if (empty($current_cart)): ?>
            <h5 class="m_3"><?= __('cart.no_product') ?></h5>
            <div class="clear"></div>
            <a href="<?php echo Uri::base().'home' ?>" class="btn btn-default">
                <?= __('cart.continue_buy') ?> <span class="glyphicon glyphicon-share-alt"></span>
            </a>
            <?php else: ?>
                <?php echo Form::open(array('action' => Uri::base().'cart/view_cart', 'method' => 'post', 'class'=>'form-inline')) ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-bold"><?= __('cart.prod_image') ?></th>
                            <th class="text-bold"><?= __('cart.prod_name') ?></th>
                            <th class="text-bold" style="width: 25%"><?= __('cart.prod_detail_quantity') ?></th>
                            <th class="text-bold" style="width: 10%"><?= __('cart.prod_price') ?></th>
                            <th class="text-bold" style="width: 10%"><?= __('cart.prod_total_quantity') ?></th>
                            <th class="text-bold" style="width: 10%"><?= __('cart.prod_monetize') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($current_cart as $product_id => $data):
                            $pay = $pay + $data['total'];?>
                            <tr>
                                <td style="text-align: center;">
                                    <img class="img-thumbnail" src="<?php echo Uri::base() . 'assets/img/prod_img/' . $data['image']; ?>" width="145" height="132" alt="">
                                </td>
                                <td><?php echo $data['product_name'] ?></td>
                                <td>
                                    <div>
                                        <table class="table">
                                            <thead>
                                                <th><?= __('cart.prod_size') ?></th>
                                                <th><?= __('cart.prod_color') ?></th>
                                                <th><?= __('cart.prod_quantity') ?></th>
                                            </thead>
                                            <tbody>
                                            <?php foreach ($data['related_info'] as $related_data): ?>
                                                <tr>
                                                    <!--size-->
                                                    <td>
                                                        <?= $related_data['size'] != 'nosize' ? $related_data['size'] : '' ?>
                                                    </td>

                                                    <!--color-->
                                                    <td>
                                                    <?php if ($related_data['color'] != 'nocolor'): ?>
                                                        <p>
                                                            <span class="select-color-padding" style="background: <?= $related_data['color'] ?>"></span>
                                                        </p>
                                                    <?php endif; ?>
                                                    </td>

                                                    <!--số lượng-->
                                                    <td>
                                                        <div class="form-group">
                                                            <input class="form-control input-sm" style="text-align: center; height:23px; width: 42px; " type="text" size="1" name="<?= "quantity[{$product_id}][{$related_data['size']}][{$related_data['color']}]" ?>" value="<?= $related_data['quantity'] ?>" >

                                                            <!--update button-->
                                                            <button style="z-index: 0" class="btn btn-success btn-xs" name="update_quantity" type="submit" value="<?= "{$product_id}_{$related_data['size']}_{$related_data['color']}" ?>"><span class="glyphicon glyphicon-refresh"></span></button>

                                                            <!--delete button-->
                                                            <button style="z-index: 0" type="submit" name="delete_quantity" class="btn btn-danger btn-xs" value="<?= "{$product_id}_{$related_data['size']}_{$related_data['color']}" ?>">
                                                                <span class="glyphicon glyphicon-remove"></span>
                                                            </button>
                                                         </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach;?>
                                            </tbody>
                                        </table>
                                    </div>

                                </td>
                                <td><?php echo number_format($data['unit_price'].'000', 0, '', '.').' Đ' ?></td>

                                <!--Tổng số lượng-->
                                <td class="text-center">
                                    <?= $data['quantity']; ?>
                                </td>
                                <td><?php echo number_format($data['total'].'000', 0, '', '.').' Đ' ?></td>
                            </tr>
                        <?php endforeach;?>
                            <tr>
                                <td colspan="5" class="text-bold" style="text-align: center">
                                    <?= __('cart.prod_total_payment') ?>
                                </td>
                                <td  colspan="2" class="text-bold">
                                    <?php echo number_format($pay.'000', 0, '', '.').' Đ'; ?>
                                </td>
                            </tr>
                    </tbody>
                </table>
                <?php echo Form::close(); ?>
                <a href="<?php echo Uri::base().'home' ?>" class="btn btn-default text-bold">
                    <?= __('cart.continue_buy') ?> <span class="glyphicon glyphicon-share-alt"></span>
                </a>
                <a href="<?php echo Uri::base().'cart/checkout' ?>" class="btn btn-default pull-right text-bold">
                    <span class="glyphicon glyphicon-check"></span> <?= __('cart.checkout_title') ?>
                </a>
            <?php endif; ?>

        </div>
    </div>
</div>