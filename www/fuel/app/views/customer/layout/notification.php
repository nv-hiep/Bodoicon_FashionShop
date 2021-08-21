<?php if (Session::get_flash('success')): ?>
    <div class="wrap customer_message_success">
        <?php echo Security::clean(Session::get_flash('success'), array('htmlentities', 'xss_clean')); ?>
    </div>
<?php endif; ?>

<?php if (Session::get_flash('error')): ?>
    <div class="wrap customer_message_error">
        <?php echo Security::clean(Session::get_flash('error'), array('htmlentities', 'xss_clean')); ?>
    </div>
<?php endif; 
