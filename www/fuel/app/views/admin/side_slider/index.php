<h1 class="page-header"><?= __('slider.sideslider'); ?><?php echo Html::anchor('admin/sideslider/upload', __('button.upload'), array('class' => 'btn btn-success btn-large pull-right')); ?></h1>
<div class="table-responsive">
    <table class="table">
        <thead>
            <th style="width:10%"><?= __('slider.display'); ?></th>
            <th style="width:40%"><?= __('slider.name'); ?></th>
            <th style="width:40%"><?= __('common.product'); ?></th>
            <th style="width:10%"><?= __('title.actions'); ?></th>
        </thead>
        <tbody>
            <?php foreach ($imgs as $key => $val): ?>
                <tr>
                    <?php
                    if ($val->display_flag == true) {
                        $icon = 'glyphicon glyphicon-ok icon-success';
                    } else {
                        $icon = 'glyphicon glyphicon-remove icon-danger';
                    }
                    ?>
                    <td class="display-flag-side" id-val="<?= $val->id; ?>" flag="<?= $val->display_flag; ?>">
                        <?php echo Html::anchor('#', "<i class='" . $icon . "'></i>", array('class' => 'btn btn-default btn-xs')); ?>
                    </td>
                    <td title="<?= $val->image_name; ?>">
                        <span class="img-hover" path="<?= Uri::base() . 'assets/img/side_slider/' . $val->image_name ?>" kind="side-slider">
                            <?php echo Str::truncate($val->image_name, 50, '...', false); ?>
                        </span>
                    </td>
                    <td><?php echo isset($val->ss2p->product_name) ? Str::truncate($val->ss2p->product_name, 70, '...', false) : ''; ?></td>
                    <td>
                        <?php echo Html::anchor('admin/sideslider/edit/'   . $val->id, '<i class="glyphicon glyphicon-pencil"></i>', array('class' => 'btn btn-default btn-xs')); ?>
                        <?php echo Html::anchor('admin/sideslider/delete/' . $val->id, '<i class="glyphicon glyphicon-trash"></i>', array('class' => 'btn btn-default btn-xs', 'onclick' => 'return confirm("'.__('message.deleteyn').'");')); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>