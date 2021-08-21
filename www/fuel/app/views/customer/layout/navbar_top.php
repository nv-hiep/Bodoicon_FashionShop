<div class="header-top">
    <div class="wrap">
        <div class="header-top-left">
            <div class="box">
                <select tabindex="4" class="dropdown">
                    <option value="" class="label" value="">Tiếng việt </option>
<!--                    <option value="2">English</option>-->
                </select>
            </div>
            <div class="box1">
                <select tabindex="4" class="dropdown">
                    <option value="" class="label" value="">VNĐ </option>
<!--                    <option value="1">$ Dollar</option>-->
                </select>
            </div>
            <div class="clear"></div>
        </div>
        <div class="cssmenu">
            <ul>
                <?php if (Auth::instance()->check()): ?>
                <li><a href="#">Xin chào <label class="text-bold"> <?php echo $fullname; ?></label></a></li>
                |<li><a href="<?php echo Uri::base().'account/logout'; ?>">Thoát</a></li>
                <?php else: ?>
                <li><a href="<?php echo Uri::base().'account/register'; ?>">Đăng ký</a></li>
                |<li><a href="<?php echo Uri::base().'account/login'; ?>">Đăng nhập</a></li>
                <?php endif; ?>
            </ul>
        </div>
        <div class="clear"></div>
    </div>
</div>