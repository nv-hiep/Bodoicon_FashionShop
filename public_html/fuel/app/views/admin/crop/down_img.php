<h1 id="mmm" class="page-header">
    <?= __('img.down_img'); ?>
    <?php echo Html::anchor('admin/crop/prepare', __('button.img_prepare'), array('class' => 'btn btn-primary btn-large pull-right img-prepare')); ?>
</h1>
<div class="table-responsive borderless">
    <table class="table">
        <thead>
        <th style="width:15%"></th>
        <th></th>
        </thead>
        <tbody>
            <?php foreach ($imgs as $key => $val): ?>
                <tr>
                    <td>
                        <?php echo Html::img(Uri::base().'assets/img/prepare/img/'.$val, array('class' => "img-thumbnail img-responsive prod-imgs", 'title' => $val, "width" => 243)); ?>
                    </td>
                    <td style="vertical-align:middle;">
                        <?php echo Html::anchor('admin/crop/download_img/' . $val.'/', '<i class="glyphicon glyphicon-save"></i>', array('class' => 'btn btn-default btn-xs')); ?>
                        <?php echo Html::anchor('admin/crop/delete_img/' . $val.'/', '<i class="glyphicon glyphicon-trash"></i>', array('class' => 'btn btn-default btn-xs', 'onclick' => 'return confirm("' . __('message.deleteyn') . '");')); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>