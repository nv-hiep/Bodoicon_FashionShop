<div id="fwslider">
    <div class="slider_container">
        
        <?php foreach ($sliders as $slider) : ?>
        <div class="slide">
            <!-- Slide image -->
            <img src="<?php echo Fuel\Core\Uri::base() . 'assets/img/slider/' . $slider->image_name; ?>" alt="<?=$slider->image_name;?>"/>
            <!-- /Slide image -->
            <!-- Texts container -->
            <div class="slide_content">
                <div class="slide_content_wrap">
                    <!-- Text title -->
                    <h4 class="title"><?=$slider->upper_line; ?></h4>
                    <!-- /Text title -->

                    <!-- Text description -->
                    <p class="description"><?=$slider->lower_line; ?></p>
                    <!-- /Text description -->
                </div>
            </div>
            <!-- /Texts container -->
        </div>
        <?php endforeach; ?>
        
        
        <!--/slide -->
    </div>
    <div class="timers"></div>
    <div class="slidePrev"><span></span></div>
    <div class="slideNext"><span></span></div>
</div>