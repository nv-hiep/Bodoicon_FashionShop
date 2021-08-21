<h1 class="page-header"><?= __('menu.perm'); ?><?php echo Html::anchor('admin/perms/register', __('button.add_perms'), array('class' => 'btn btn-success btn-large pull-right')); ?></h1>
<div class="table-responsive">
    <table class="table">
        <thead>
            <th style="width:10%"><?= __('common.area'); ?></th>
			<th style="width:15%"><?= __('menu.perm'); ?></th>
			<th style="width:65%"><?= __('common.method'); ?></th>
			<th><?= __('title.actions'); ?></th>
        </thead>
        <tbody>
            <?php foreach($perms as $key => $val):?>
                <tr>
                    <td><?php echo $val->area; ?></td>
                    <td><?php echo $val->permission; ?></td>
                    <td title="<?= $val->actions; ?>"><?php echo Str::truncate($val->actions, 130); ?></td>
                    <td>
                        <?php echo Html::anchor('admin/perms/edit/' . $key, '<i class="glyphicon glyphicon-pencil"></i>', array('class' => 'btn btn-default btn-xs')); ?>
                        <?php echo Html::anchor('admin/perms/delete/' . $key, '<i class="glyphicon glyphicon-trash"></i>', array('class' => 'btn btn-default btn-xs', 'onclick' => 'return confirm("'.__('message.deleteyn').'");')); ?>
					</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>