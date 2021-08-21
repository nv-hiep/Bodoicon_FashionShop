<h1 class="page-header"><?= __('title.account_management') ?>
    <a href="<?php echo Uri::base(); ?>admin/account/register" class="btn btn-success btn-large pull-right">
        <i class="glyphicon"></i>
        <?php echo 'Đăng ký' ?>
    </a>
</h1>
<div class="table-responsive">
    <table class="table">
        <thead>
        <th><?= __('account.title_username'); ?></th>
        <th><?= __('account.title_action'); ?></th>
        </thead>
        <tbody>
            <?php
                foreach($accounts as $val):
            ?>
            <tr>
                <td>
                    <?php echo $val['username'] ?>
                </td>
                <td>
                    <!--cannot delete or edit admin user-->
                    <?php if ($val['username'] != 'admin') : ?>
                        <a href="<?php echo Uri::base(); ?>admin/account/edit/<?php echo $val['id'] ?>" class="btn btn-default btn-xs">
                            <span class="glyphicon glyphicon-pencil"></span>
                        </a>
                        <a onclick="return confirm('<?= __('common.confirm_delete'); ?>')" href="<?php echo Uri::base(); ?>admin/account/delete/<?php echo $val['id'] ?>" class="btn btn-default btn-xs delete-account">
                            <span class="glyphicon glyphicon-trash"></span>
                        </a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach;?>

        </tbody>
    </table>
</div>