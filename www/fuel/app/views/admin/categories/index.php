<h1 class="page-header"><?= __('cat.categories'); ?><?php echo Html::anchor('admin/categories/add', __('button.add'), array('class' => 'btn btn-success btn-large pull-right')); ?></h1>
<div class="table-responsive">
    <table class="table">
        <thead>
        <th style="width:4%">#</th>
        <th style="width:9%"><?= __('cat.order'); ?></th>
        <th style="width:9%"><?= __('common.display'); ?></th>
        <th style="width:9%"><?= __('common.store'); ?></th>
        <th><?= __('cat.categories'); ?></th>
        <th><?= __('common.slug'); ?></th>
        <th style="width:30%"><?= __('cat.parent'); ?></th>
        <th style="width:9%"><?= __('title.actions'); ?></th>
        </thead>
        <tbody class="cat-table">
            <?php foreach ($cats as $key => $val): ?>
                <tr id="arrayorder_<?php echo $val->id; ?>">
                    <?php
                    if ($val->active == true) {
                        $icon = 'glyphicon glyphicon-ok icon-success';
                    } else {
                        $icon = 'glyphicon glyphicon-remove icon-danger';
                    }

                    if ($val->storage == true) {
                        $glyph = 'glyphicon glyphicon-thumbs-up icon-success';
                    } else {
                        $glyph = 'glyphicon glyphicon-thumbs-down icon-danger';
                    }
                    ?>

                    <td class="handle" style="cursor:move;" id-val="<?= $val->id; ?>" order="<?= $val->order; ?>">
                        <i class="glyphicon glyphicon-move"></i>
                    </td>
                    <td class='order'><?php echo $val->order; ?></td>
                    <td class="active-flag" id-val="<?= $val->id; ?>" flag="<?= $val->active; ?>">
                        <?php echo Html::anchor('#', "<i class='" . $icon . "'></i>", array('class' => 'btn btn-default btn-xs')); ?>
                    </td>
                    <td>
                        <?php echo Html::anchor('#', "<i class='" . $glyph . "'></i>", array('class' => 'btn btn-default btn-xs')); ?>
                    </td>
                    <td title="<?= $val->name; ?>" class="over-flow">
                        <?php echo $val->name; ?>
                    </td>
                    <td class="over-flow">
                        <?php echo $val->slug; ?>
                    </td>
                    <td><?php echo ((int) ($val->parent_id) > 1) ? $cats[$val->parent_id]->name : ''; ?></td>
                    <td>
                        <?php echo Html::anchor('admin/categories/edit/' . $val->id, '<i class="glyphicon glyphicon-pencil"></i>', array('class' => 'btn btn-default btn-xs')); ?>
                        <?php echo Html::anchor('admin/categories/delete/' . $val->id, '<i class="glyphicon glyphicon-trash"></i>', array('class' => 'btn btn-default btn-xs', 'onclick' => 'return confirm("' . __('message.deleteyn') . '");')); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>