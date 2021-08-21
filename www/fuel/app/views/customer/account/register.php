<div class="login">
    <div class="wrap">
        <div class="col_1_of_login span_1_of_login">
            <div class="login-title">
                <h4 class="title">Đăng ký tài khoản</h4>
                <div id="loginbox" class="loginbox">

                    <?php echo Form::open(); ?>
                        <fieldset class="input">
                            <p>
                                <label class="text-bold required">Tên đăng nhập</label>
                                <?php echo Form::input('username', $post['username'], array(
                                    'class'        => 'inputbox',
                                    'size'         => 18,
                                    'autocomplete' => 'off',
                                    'placeholder'  => 'Nhập tên đăng nhập...'
                                )); ?>
                                <?php echo Form::error('username', $err); ?>
                            </p>

                            <p>
                                <label class="text-bold required">Mật khẩu</label>
                                <?php echo Form::password('password', $post['password'], array(
                                    'class'        => 'inputbox',
                                    'size'         => 18,
                                    'autocomplete' => 'off',
                                    'placeholder'  => 'Nhập mật khẩu...'
                                )); ?>
                                <?php echo Form::error('password', $err); ?>
                            </p>

                            <p>
                                <label class="text-bold required">Họ tên</label>
                                <?php echo Form::input('fullname', $post['fullname'], array(
                                    'class'        => 'inputbox',
                                    'size'         => 18,
                                    'autocomplete' => 'off',
                                    'placeholder'  => 'Nhập tên đầy đủ...'
                                )); ?>
                                <?php echo Form::error('fullname', $err); ?>
                            </p>

                            <p>
                                <label class="text-bold required">Số điện thoại</label>
                                <?php echo Form::input('phone', $post['phone'], array(
                                    'class'        => 'inputbox',
                                    'size'         => 18,
                                    'autocomplete' => 'off',
                                    'placeholder'  => 'Nhập số điện thoại...'
                                )); ?>
                                <?php echo Form::error('phone', $err); ?>
                            </p>

                            <p>
                                <label class="text-bold required">Địa chỉ</label>
                                <?php echo Form::input('address', $post['address'], array(
                                    'class'        => 'inputbox',
                                    'size'         => 18,
                                    'autocomplete' => 'off',
                                    'placeholder'  => 'Nhập số điện thoại...'
                                )); ?>
                                <?php echo Form::error('address', $err); ?>
                            </p>


                            <div class="remember">
                                <label class="required">
                                    <?php echo Form::checkbox('accept_register', 1, !empty($post['accept_register']) ?: false) ?>
                                    Đồng ý với các quy định chung
                                </label>
                                <?php echo Form::error('accept_register', $err); ?>
                                <input type="submit" name="Submit" value="Đăng ký"><div class="clear"></div>
                            </div>

                        </fieldset>
                    <?php echo Form::close(); ?>

                </div>
            </div>
        </div>
        <div class="col_1_of_login span_1_of_login">
            <h4 class="title">Điều khoản sử dụng</h4>
            <p class="text-bold">Tài khoản sử dụng cho mục đích sau</p>
            <p>- Mua hàng</p>
            <p>- Quản lý hóa đơn mua hàng</p>
            <p>- Nhận các khuyến mãi dành cho thành viên tích cực</p>
            <p>- Và nhiều các tiện ích dành cho thành viên...</p>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>
</div>