<h1 class="page-header"><?= __('menu.role_perm'); ?><?php echo Html::anchor('admin/roleperm/register', __('button.add_roleperm'), array('class' => 'btn btn-success btn-large pull-right')); ?></h1>
<div class="table-responsive">
    <table class="table">
        <thead>
        <th><?= __('menu.role_perm'); ?></th>
        <th><?= __('menu.perm'); ?></th>
        <th><?= __('common.method'); ?></th>
        <th style="width:9%"><?= __('title.actions'); ?></th>
        </thead>
        <tbody>
            <?php foreach ($rps as $val): ?>
                <tr>
                    <td><?= $val->role->name; ?></td>
                    <td><?= $val->perms->area . ' : ' . $val->perms->permission; ?></td>
                    <td>
                        <?php
                        foreach ($val->acts as $act) {
                            echo $act . '<br>';
                        }
                        ?>
                    </td>
                    <td>
                        <?php echo Html::anchor('admin/roleperm/edit/' . $val->id, '<i class="glyphicon glyphicon-pencil"></i>', array('class' => 'btn btn-default btn-xs')); ?>
                        <?php echo Html::anchor('admin/roleperm/delete/' . $val->id, '<i class="glyphicon glyphicon-trash"></i>', array('class' => 'btn btn-default btn-xs', 'onclick' => 'return confirm("' . __('message.deleteyn') . '");')); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>