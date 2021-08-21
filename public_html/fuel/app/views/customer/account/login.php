<div class="login">
    <div class="wrap">
        <div class="col_1_of_login span_1_of_login">
            <div class="login-title">
                <h4 class="title">Đăng nhập hệ thống</h4>
                <div id="loginbox" class="loginbox">

                    <?php echo Form::open(); ?>
                        <fieldset class="input">
                            <p>
                                <label class="text-bold required">Tên đăng nhập</label>
                                <?php echo Form::input('username', '', array(
                                    'class'        => 'inputbox',
                                    'size'         => 18,
                                    'autocomplete' => 'off',
                                    'placeholder'  => 'Nhập tên đăng nhập...'
                                )); ?>
                            </p>

                            <p>
                                <label class="text-bold required">Mật khẩu</label>
                                <?php echo Form::password('password', '', array(
                                    'class'        => 'inputbox',
                                    'size'         => 18,
                                    'autocomplete' => 'off',
                                    'placeholder'  => 'Nhập mật khẩu...'
                                )); ?>
                            </p>


                            <div class="remember">
                                <label>
                                    <a href="">Quên mật khẩu</a>
                                </label>
                                <input type="submit" name="Submit" value="Đăng nhập"><div class="clear"></div>
                            </div>

                        </fieldset>
                    <?php echo Form::close(); ?>

                </div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>
