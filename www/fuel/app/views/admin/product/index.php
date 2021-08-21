<h1 class="page-header">
    <?= __('prod.prods'); ?>
    <?php echo Html::anchor('admin/product/add', __('button.add'), array('class' => 'btn btn-success btn-large pull-right')); ?>
    <?php echo Html::anchor('admin/crop/prepare', __('button.img_prepare'), array('class' => 'btn btn-primary btn-large pull-right img-prepare')); ?>
</h1>
<div class="row">
    <?php echo Form::open(array('class' => 'form-inline pull-right')); ?>
    <?php if (count($cats) > 0) : ?>
        <div class="form-group">
            <div class="col-sm-4">
                <?php echo Form::select('cate', Input::post('cate'), $cats, array('class' => 'form-control')); ?>
            </div>
        </div>
    <?php endif; ?>
    <div class="form-group">
        <div class="col-sm-2">
            <?php echo Form::button('submit', __('account.search'), array('class' => 'btn btn-warning')); ?>
        </div>
    </div>
    <?php echo Form::close(); ?>
</div>
<div class="clear"></div>
<div class="table-responsive">
    <table class="table">
        <thead>
        <th style="width:15%"><?= __('prod.cat'); ?></th>
        <th style="width:25%"><?= __('prod.prods'); ?></th>
        <th style="width:15%"><?= __('common.thumbnail'); ?></th>
        <th style="width:12%"><?= __('common.price'); ?></th>
        <th style="width:12%"><?= __('common.size'); ?></th>
        <th style="width:14%"><?= __('common.status'); ?></th>
        <th><?= __('title.actions'); ?></th>
        </thead>
        <tbody>
            <?php foreach ($prds as $key => $val): ?>
                <tr>
                    <td>
                        <?php
                        foreach ($val->p2pc as $cat) {
                            echo $cat->pc2c->name . '<br>';
                        }
                        ?>
                    </td>
                    <td title="<?= $val->product_name; ?>">
                        <?php echo Str::truncate($val->product_name, 40, '...', false); ?>
                    </td>
                    <td title="<?= $val->p2pit->image_name; ?>">
                        <?php echo Html::img(Uri::base() . 'assets/img/prod_img/'.$val->p2pit->image_name, array("title" => $val->p2pit->image_name, "alt" => $val->p2pit->image_name, 'class' => "", 'height' => 120, 'width' => 132)); ?>
                    </td>
                    <td><?php echo $val->price; ?></td>
                    <td><?php echo $val->size; ?></td>
                    <td><?php echo ($val->status == true) ? __('common.avail') : __('common.unavail'); ?></td>
                    <td>
                        <?php echo Html::anchor('admin/product/edit/' . $val->id, '<i class="glyphicon glyphicon-pencil"></i>', array('class' => 'btn btn-default btn-xs')); ?>
                        <?php echo Html::anchor('admin/product/delete/' . $val->id, '<i class="glyphicon glyphicon-trash"></i>', array('class' => 'btn btn-default btn-xs', 'onclick' => 'return confirm("' . __('message.deleteyn') . '");')); ?>
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