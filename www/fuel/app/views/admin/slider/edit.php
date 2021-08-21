<h1 class="page-header"><?= __('slider.edit'); ?></h1>
<?php echo Form::open(array("class"=>"form-horizontal", 'enctype' => 'multipart/form-data')); ?>
    <div class="form-group">
        <?php echo Form::label(__('slider.photo'), 'area', array('class' => 'col-sm-2 control-label required')); ?>
        <div class="col-sm-6">
            <?php echo Form::file('img', array('class' => '')); ?>
            <?php echo Form::error('img', $err); ?>
        </div>
    </div>

    <div class="form-group">
        <?php echo Form::label('', 'photo', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-6">
            <?php echo Html::img(Uri::base().'assets/img/slider/'.$img->image_name, array("title" => $img->image_name, "alt" => $img->image_name, 'class' => "", 'height' => 180, 'width' => 504)); ?>
        </div>
    </div>

    <div class="form-group">
        <?php echo Form::label(__('slider.upper_line'), 'upper_line', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-6">
            <?php echo Form::input('uline', Input::post('uline', isset($img) ? $img->upper_line : ''), array('class' => 'form-control')); ?>
            <?php echo Form::error('uline', $err); ?>
        </div>
    </div>

    <div class="form-group">
        <?php echo Form::label(__('slider.lower_line'), 'lower_line', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-6">
            <?php echo Form::input('dline', Input::post('dline', isset($img) ? $img->lower_line : ''), array('class' => 'form-control')); ?>
            <?php echo Form::error('dline', $err); ?>
        </div>
    </div>

    <div class="form-group">
        <?php echo Form::label('', 'display', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-6 checkbox">
            <label>
                <?php
                if (Input::method() == 'POST') {
                    $display = Input::post('display');
                } else {
                    $display = $img->display_flag;
                }
                ?>
                <?php echo Form::checkbox('display', true, $display); ?>
                <?php echo __('common.display'); ?>
            </label>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <?php echo Form::button('submit', __('common.btn_submit'), array('class' => 'btn btn-default')); ?>
            <?php echo Html::anchor('admin/slider', __('common.cancel'), array('class' => 'btn btn-default')); ?>
        </div>
    </div>
<?php echo Form::close(); ?>
