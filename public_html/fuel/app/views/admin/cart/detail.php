<h1 class="page-header"><?= __('cart.cart_detail'); ?></h1>

<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading text-bold"><?= __('cart.customer_info') ?></div>

    <!-- Table -->
  <form class="form-horizontal">
    <div class="form-group" style="margin-bottom: 0px;">
      <label class="col-sm-2 control-label"><?= __('cart.bill_id_title') ?></label>
      <div class="col-sm-10">
        <p class="form-control-static"><?= $order->bill_id; ?></p>
      </div>
    </div>
    <div class="form-group" style="margin-bottom: 0px;">
      <label class="col-sm-2 control-label"><?= __('cart.customer_name_title') ?></label>
      <div class="col-sm-10">
        <p class="form-control-static"><?= $order->fullname; ?></p>
      </div>
    </div>
    <div class="form-group" style="margin-bottom: 0px;">
      <label class="col-sm-2 control-label"><?= __('account.phone') ?></label>
      <div class="col-sm-10">
        <p class="form-control-static"><?= $order->phone_number ?></p>
      </div>
    </div>
    <div class="form-group" style="margin-bottom: 0px;">
      <label class="col-sm-2 control-label"><?= __('account.address') ?></label>
      <div class="col-sm-10">
        <p class="form-control-static"><?= $order->address; ?></p>
      </div>
    </div>
    <div class="form-group" style="margin-bottom: 0px;">
      <label class="col-sm-2 control-label"><?= __('cart.status_title') ?></label>
      <div class="col-sm-10">
          <p class="form-control-static">
            <?php if ($order->status == false): ?>
                <span class="label label-warning"><?= __('cart.no_delivery') ?></span>
            <?php else: ?>
                <span class="label label-success"><?= __('cart.delivered') ?></span>
            <?php endif; ?>
          </p>
      </div>
    </div>
    <div class="form-group" style="margin-bottom: 0px;">
      <label class="col-sm-2 control-label"><?= __('cart.note_title') ?></label>
      <div class="col-sm-10">
        <p class="form-control-static"><?= $order->note; ?></p>
      </div>
    </div>
  </form>
</div>

<div class="panel panel-default">
  <!-- Default panel contents -->
    <div class="panel-heading text-bold"><?= __('cart.product_info') ?></div>

  <!-- Table -->
    <div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <th style="width: 15%"><?= __('cart.prod_image') ?></th>
            <th style="width: 25%"><?= __('cart.prod_name') ?></th>
            <th style="width: 30%"><?= __('cart.prod_detail_quantity') ?></th>
            <th class="text-center" style="width: 10%"><?= __('cart.prod_total_quantity') ?></th>
            <th style="width: 10%"><?= __('cart.prod_price') ?></th>
            <th style="width: 10%"><?= __('cart.prod_monetize') ?></th>
        </thead>
        <tbody>
            <?php
            $pay = 0;
            foreach($order->product as $product):
                $pay = $pay + ($product->product_price*$product->quantity); ?>
                <tr>
                    <td>
                        <img class="img-thumbnail" src="<?php echo Uri::base() . 'assets/img/prod_img/' . $product->image; ?>" width="160" height="auto" alt="">
                    </td>
                    <td><?= $product->product_name; ?></td>

                    <!--chi tiết số lượng-->
                    <td>
                        <div>
                            <table class="table">
                                <thead>
                                    <th><?= __('cart.prod_size') ?></th>
                                    <th><?= __('cart.prod_color') ?></th>
                                    <th><?= __('cart.prod_quantity') ?></th>
                                </thead>
                                <tbody>
                                <?php
                                $tmp = unserialize(html_entity_decode($product->related_info, ENT_QUOTES));
                                $related_info = is_array($tmp) ? $tmp : array();
                                foreach ($related_info as $related_data): ?>
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
                                            <?= $related_data['quantity'] ?>
                                        </td>
                                    </tr>
                                <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>

                    </td>
                    <td class="text-center"><?= $product->quantity; ?></td>
                    <td><?= number_format($product->product_price.'000', 0, '', '.').' Đ'; ?></td>
                    <td><?= number_format($product->product_price*$product->quantity.'000', 0, '', '.').' Đ'; ?></td>
                </tr>
            <?php endforeach; ?>
                <tr>
                    <td colspan="5" class="text-bold text-right"><?= __('cart.prod_total_payment') ?></td>
                    <td class="text-bold">
                    <?= number_format($pay.'000', 0, '', '.').' Đ'; ?>
                    </td>
                </tr>
        </tbody>
    </table>
    </div>
</div>
<a href="<?= Uri::base().'admin/cart/list'?>" class="btn btn-info">
    <span class="glyphicon glyphicon-backward"></span> <?= __('button.back') ?>
</a>
<a href="<?= Uri::base()."admin/cart/delivered/{$order->id}"?>" class="btn btn-success pull-right"> <?= __('cart.delivered') ?>
    <span class="glyphicon glyphicon-ok"></span>
</a>
