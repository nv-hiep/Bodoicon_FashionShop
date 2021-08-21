<div class="login">
    <div class="wrap">
        <ul class="breadcrumb breadcrumb__t"><a class="home" href="<?= Uri::base().'home'; ?>"><?= __('common.home'); ?></a>  / <?= __('common.contact'); ?></ul>
        <div class="content-top">
            <?php echo Form::open('lien-he.html'); ?>
                <div class="to">
                    <?php $class = (!empty($err['name'])) ? 'red-bg' : 'text'; ?>
                    <?php echo Form::input('name', Input::post('name'), array('class' => $class, 'placeholder' => __('common.name'))); ?>
                    <?php $class = (!empty($err['email'])) ? 'red-bg' : 'text'; ?>
                    <?php echo Form::input('email', Input::post('email'), array('class' => $class, "style" => "margin-left: 2px", 'placeholder' => __('common.email'))); ?>
                </div>
                <div class="to">
                    <?php $class = (!empty($err['phone'])) ? 'red-bg' : 'text'; ?>
                    <?php echo Form::input('phone', Input::post('phone'), array('class' => $class, 'placeholder' => __('account.phone'))); ?>
                    <?php $class = (!empty($err['subject'])) ? 'red-bg' : 'text'; ?>
                    <?php echo Form::input('subject', Input::post('subject'), array('class' => $class, "style" => "margin-left: 2px", 'placeholder' => __('common.subject'))); ?>
                </div>
                <div class="text">
                    <?php $class = (!empty($err['content'])) ? 'red-bg' : ''; ?>
                    <?php echo Form::textarea('content', Input::post('content'), array('class' => $class, 'placeholder' => __('common.mess'))); ?>
                </div>
                <div class="submit">
                    <input type="submit" value="<?= __('common.send'); ?>">
                </div>
            <?php echo Form::close(); ?>
            <div class="map">
                <h3>Hồ Chí Minh</h3>
                <iframe style="height:400px; width:100%;border:0;" frameborder="0" src="https://www.google.com/maps/embed/v1/place?q=128+Đường+59,+phường+14,+Ho+Chi+Minh+City,+Ho+Chi+Minh,+Vietnam&key=AIzaSyAN0om9mFmy1QN6Wf54tXAowK4eT0ZUPrU"></iframe>
                <br>
                <br>
                <h3>Kon Tum</h3>
                <iframe style="height:400px; width:100%;border:0;" frameborder="0" src="https://www.google.com/maps/embed/v1/place?q=226+Hai+Bà+Trưng,+tp.+Kon+Tum,+Kon+Tum+Province,+Vietnam&key=AIzaSyAN0om9mFmy1QN6Wf54tXAowK4eT0ZUPrU"></iframe>
            </div>
        </div>
    </div>
</div>