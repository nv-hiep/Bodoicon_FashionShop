<h1 class="page-header"><?= __('menu.role'); ?><?php echo Html::anchor('admin/roles/register', __('button.add'), array('class' => 'btn btn-success btn-large pull-right')); ?></h1>
<div class="table-responsive">
    <table class="table">
        <thead>
        <th><?= __('menu.role'); ?></th>
        <th style="width:9%"><?= __('title.actions'); ?></th>
        </thead>
        <tbody>
            <?php foreach ($auths as $key => $val): ?>
                <tr>
                    <td ><?= $val; ?></td>
                    <td>
                        <?php if ($key > 2): ?>
                            <?php echo Html::anchor('admin/roles/edit/' . $key, '<i class="glyphicon glyphicon-pencil"></i>', array('class' => 'btn btn-default btn-xs')); ?>
                            <?php echo Html::anchor('admin/roles/delete/' . $key, '<i class="glyphicon glyphicon-trash"></i>', array('class' => 'btn btn-default btn-xs', 'onclick' => 'return confirm("' . __('message.deleteyn') . '");')); ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>