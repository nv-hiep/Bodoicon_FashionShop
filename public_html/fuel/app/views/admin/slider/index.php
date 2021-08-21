<h1 id="mmm" class="page-header"><?= __('slider.slider'); ?><?php echo Html::anchor('admin/slider/upload', __('button.upload'), array('class' => 'btn btn-success btn-large pull-right')); ?></h1>
<div class="table-responsive">
    <table class="table">
        <thead>
        <th style="width:9%"><?= __('slider.display'); ?></th>
        <th style="width:25%"><?= __('slider.name'); ?></th>
        <th style="width:30%"><?= __('slider.upper_line'); ?></th>
        <th style="width:30%"><?= __('slider.lower_line'); ?></th>
        <th><?= __('title.actions'); ?></th>
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
                    <td class="display-flag" id-val="<?= $val->id; ?>" flag="<?= $val->display_flag; ?>">
                        <?php echo Html::anchor('#', "<i class='" . $icon . "'></i>", array('class' => 'btn btn-default btn-xs')); ?>
                    </td>
                    <td title="<?= $val->image_name; ?>">
                        <span class="img-hover" path="<?= Uri::base() . 'assets/img/slider/' . $val->image_name ?>" kind="slider">
                            <?php echo Str::truncate($val->image_name, 20, '...', false); ?>
                        </span>
                    </td>
                    <td><?php echo $val->upper_line; ?></td>
                    <td><?php echo $val->lower_line; ?></td>
                    <td>
                        <?php echo Html::anchor('admin/slider/edit/' . $val->id, '<i class="glyphicon glyphicon-pencil"></i>', array('class' => 'btn btn-default btn-xs')); ?>
                        <?php echo Html::anchor('admin/slider/delete/' . $val->id, '<i class="glyphicon glyphicon-trash"></i>', array('class' => 'btn btn-default btn-xs', 'onclick' => 'return confirm("' . __('message.deleteyn') . '");')); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>