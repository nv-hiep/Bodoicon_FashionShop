<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title><?= $bill_id ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <style type="text/css">

      table {
          border-spacing: 0px;
          border: 1px solid #cccccc;
      }

      table thead tr th {
          font-weight: bold;
          border: 1px solid #ddd;
      }

      table td:first-child {
          font-weight: bold;
      }

      table td {
          padding: 5px 5px 5px 5px;
          border: 1px solid #ddd;
      }

  </style>
</head>

<body style="margin: 0; padding: 0;">

    <h2><?= Str::upper(__('cart.order_info')) ?> <span style="font-weight: bold;"><?= $bill_id; ?></span> </h2>

    <h3><?= __('cart.customer_info') ?></h3>

    <table style="width: 500px; border: 1px solid #cccccc;">
     <tr>
         <td style="width:120px;"> <?= __('cart.customer_name_title') ?> </td>
        <td> <?= $customer['fullname']; ?> </td>
     </tr>

     <tr>
        <td> <?= __('account.phone') ?> </td>
        <td> <?= $customer['phone']; ?> </td>
     </tr>

     <tr>
      <td> <?= __('account.address') ?> </td>
      <td> <?= $customer['address']; ?> </td>
     </tr>

     <tr>
      <td> <?= __('cart.note_title') ?> </td>
      <td> <?= $customer['note']; ?> </td>
     </tr>

    </table>

    <h3><?= __('cart.product_info') ?></h3>

    <table style="width: 100%">
        <thead>
            <tr>
                <th style="width: 15% "><?= __('cart.prod_image') ?></th>
                <th style="width: 20%"><?= __('cart.prod_name') ?></th>
                <th style="width: 30%"><?= __('cart.prod_detail_quantity') ?></th>
                <th style="width: 12%"><?= __('cart.prod_price') ?></th>
                <th style="width: 10%"><?= __('cart.prod_total_quantity') ?></th>
                <th style="width: 12%"><?= __('cart.prod_monetize') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $pay = 0;
            foreach ($product as $product_id => $data):
            $pay = $pay + $data['total'];?>
                <tr>
                    <td style="text-align: center;">
                        <img src="<?php echo Uri::base() . 'assets/img/prod_img/' . $data['image']; ?>" width="145" height="132" alt="">
                    </td>
                    <td><?php echo $data['product_name'] ?></td>
                    <td>

                        <div>
                            <table style="width: 100%;">
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
                                                <span style="background: <?= $related_data['color'] ?>;padding: 0px 10px; border: solid 1px #BFBFBF; border-radius: 4px;"></span>
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
                    <td><?php echo number_format($data['unit_price'].'000', 0, '', '.').' Đ' ?></td>
                    <td style="text-align: center">
                        <?php echo $data['quantity'] ?>
                    </td>
                    <td><?php echo number_format($data['total'].'000', 0, '', '.').' Đ' ?></td>
                </tr>
            <?php endforeach;?>
                <tr>
                    <td colspan="5" style="text-align: center">
                        <?= __('cart.prod_total_payment') ?>
                    </td>
                    <td  colspan="2" style="font-weight: bold">
                        <?php echo number_format($pay.'000', 0, '', '.').' Đ'; ?>
                    </td>
                </tr>
        </tbody>
    </table>

</body>

</html>