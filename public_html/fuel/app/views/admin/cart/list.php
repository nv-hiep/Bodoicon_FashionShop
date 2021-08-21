<h1 class="page-header"><?= __('cart.cart_management_title');?></h1>
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <th style="width: 10%"><?= __('cart.bill_id_title');?></th>
            <th style="width: 15%"><?= __('cart.customer_name_title'); ?></th>
            <th style="width: 10%"><?= __('account.phone');?></th>
            <th style="width: 30%"><?= __('account.address');?></th>
            <th style="width: 10%"><?= __('cart.status_title'); ?></th>
            <th style="width: 15%"><?= __('cart.note_title'); ?></th>
            <th style="width: 10%"><?= __('cart.action_title'); ?></th>
        </thead>
        <tbody>
            <?php foreach($orders as $order_id => $order_data):?>
                <tr>
                    <td><?php echo $order_data->bill_id; ?></td>
                    <td><?php echo $order_data->fullname; ?></td>
                    <td><?php echo $order_data->phone_number; ?></td>
                    <td><?php echo $order_data->address; ?></td>
                    <td>
                        <?php if ($order_data->status == false): ?>
                        <span class="label label-warning"><?= __('cart.no_delivery'); ?></span>
                        <?php else: ?>
                        <span class="label label-success"><?= __('cart.delivered'); ?></span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo $order_data->note; ?></td>
                    <td>
                        <a style="margin-bottom: 5px;" href="<?= Uri::base()."admin/cart/detail/{$order_id}" ?>" class="btn btn-xs btn-info">
                            <?= __('cart.product'); ?> <span class="badge"><?= count($order_data->product) ?></span>
                        </a>

                        <?php if ($order_data->status == false): ?>
                        <a style="margin-bottom: 5px;" href="<?= Uri::base()."admin/cart/delivered/{$order_id}" ?>" class="btn btn-xs btn-success">
                            <?= __('cart.delivered'); ?> <span class="glyphicon glyphicon-ok"></span>
                        </a>
                        <?php endif; ?>

                        <a style="margin-bottom: 5px;" href="<?= Uri::base()."admin/cart/delete/{$order_id}" ?>" class="btn btn-xs btn-danger" onclick = "return confirm('<?= __('common.confirm_delete'); ?>')">
                            <?= __('cart.delete_cart'); ?> <span class="glyphicon glyphicon-remove"></span>
                        </a>

                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="pagination">
        <ul class="dc_pagination dc_paginationA dc_paginationA06">
            <?php
            $pag_links = Pagination::instance('paging');
            echo $pag_links->render();
            ?>
        </ul>
        <div class="clear"></div>
    </div>

</div>
