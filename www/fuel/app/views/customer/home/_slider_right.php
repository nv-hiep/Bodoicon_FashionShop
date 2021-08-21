<div class="rsidebar span_1_of_left">
    <div class="top-border"> </div>
    <div class="border">
        <div class="slider-wrapper theme-default">
            <div id="slider" class="nivoSlider">
                <?php foreach ($side_sld as $slider) : ?>
                <a href="<?php echo isset($slider->ss2p->slug) ? Uri::base() . $slider->ss2p->slug.'.html' : '#'; ?>">
                    <img src="<?php echo Uri::base() . 'assets/img/side_slider/' . $slider->image_name; ?>"  alt="<?= $slider->image_name; ?>" />
                </a>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="btn"><a href="javascript:void(0)">Click để xem</a></div>
    </div>
    <?php foreach ($side_ads as $slider) : ?>
    <div class="top-border"> </div>
    <div class="sidebar-bottom">

        <?php $link_ads = (strlen($slider->link) > 0) ? $slider->link : 'javascript:void(0)'; ?>
        <a href="<?= $link_ads; ?>" target="_blank">
        <img src="<?php echo Uri::base() . 'assets/img/ads_img/' . $slider->image_name; ?>"  alt="<?= $slider->image_name; ?>" />
        </a>
    </div>
    <?php endforeach; ?>
</div>