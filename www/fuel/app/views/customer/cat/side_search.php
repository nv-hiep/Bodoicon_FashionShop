<div class="rsidebar span_1_of_left">
    <section  class="sky-form">
        <h4><?= __('cat.categories'); ?></h4>
        <div class="row row1">
            <?php foreach ($cats as $key => $cat) : ?>
                <?php if (($cat->parent_id == false) and ( $cat->storage == true)) : ?>
                    <div class="col col-4 category">
                        <?php if (count($cat->subcats) > 0) : ?>
                            <label class="pull-left"><?= $cat->name; ?></label>
                            <?php $check = ((isset($categs)) and (in_array($cat->id, $categs))) ? 'checked' : ''; ?>
                            <label class="checkbox">
                                <input type="checkbox" class="checkbox-search checkbox-cats" name="cats[]" value="<?= $cat->id; ?>" <?= $check; ?>>
                                <i></i><?= $cat->name; ?>
                            </label>
                            <?php foreach ($cat->subcats as $subcat) : ?>
                            <?php $check = ((isset($categs)) and (in_array($subcat->id, $categs))) ? 'checked' : ''; ?>
                                <label class="checkbox">
                                    <input type="checkbox" class="checkbox-search checkbox-cats" name="cats[]" value="<?= $subcat->id; ?>" <?= $check; ?>>
                                    <i></i><?= $subcat->name; ?>
                                </label>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <label class="pull-left"><?= $cat->name; ?></label>
                            <?php $check = ((isset($categs)) and (in_array($cat->id, $categs))) ? 'checked' : ''; ?>
                            <label class="checkbox">
                                <input type="checkbox" class="checkbox-search checkbox-cats" name="cats[]" value="<?= $cat->id; ?>" <?= $check; ?>>
                                <i></i><?= $cat->name; ?>
                            </label>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </section>

    <section  class="sky-form">
        <h4><?= __('common.price'); ?></h4>
        <div class="row row1">
            <div class="col col-4">
                <label class="checkbox"><input type="checkbox" class="checkbox-search checkbox-prices" name="prices[]" value="1" <?= ((isset($prices)) and (in_array('1', $prices))) ? 'checked' : ''; ?>><i></i>< 50K</label>
                <label class="checkbox"><input type="checkbox" class="checkbox-search checkbox-prices" name="prices[]" value="2" <?= ((isset($prices)) and (in_array('2', $prices))) ? 'checked' : ''; ?>><i></i>50K - 100K</label>
                <label class="checkbox"><input type="checkbox" class="checkbox-search checkbox-prices" name="prices[]" value="3" <?= ((isset($prices)) and (in_array('3', $prices))) ? 'checked' : ''; ?>><i></i>100K - 150K</label>
                <label class="checkbox"><input type="checkbox" class="checkbox-search checkbox-prices" name="prices[]" value="4" <?= ((isset($prices)) and (in_array('4', $prices))) ? 'checked' : ''; ?>><i></i>150K - 200K</label>
                <label class="checkbox"><input type="checkbox" class="checkbox-search checkbox-prices" name="prices[]" value="5" <?= ((isset($prices)) and (in_array('5', $prices))) ? 'checked' : ''; ?>><i></i>200K - 250K</label>
                <label class="checkbox"><input type="checkbox" class="checkbox-search checkbox-prices" name="prices[]" value="6" <?= ((isset($prices)) and (in_array('6', $prices))) ? 'checked' : ''; ?>><i></i>250K - 300K</label>
                <label class="checkbox"><input type="checkbox" class="checkbox-search checkbox-prices" name="prices[]" value="7" <?= ((isset($prices)) and (in_array('7', $prices))) ? 'checked' : ''; ?>><i></i>300K - 350K</label>
                <label class="checkbox"><input type="checkbox" class="checkbox-search checkbox-prices" name="prices[]" value="8" <?= ((isset($prices)) and (in_array('8', $prices))) ? 'checked' : ''; ?>><i></i>350K - 400K</label>
                <label class="checkbox"><input type="checkbox" class="checkbox-search checkbox-prices" name="prices[]" value="9" <?= ((isset($prices)) and (in_array('9', $prices))) ? 'checked' : ''; ?>><i></i>400K - 450K</label>
                <label class="checkbox"><input type="checkbox" class="checkbox-search checkbox-prices" name="prices[]" value="10" <?= ((isset($prices)) and (in_array('10', $prices))) ? 'checked' : ''; ?>><i></i>450K - 500K</label>
                <label class="checkbox"><input type="checkbox" class="checkbox-search checkbox-prices" name="prices[]" value="11" <?= ((isset($prices)) and (in_array('11', $prices))) ? 'checked' : ''; ?>><i></i>500K - 550K</label>
                <label class="checkbox"><input type="checkbox" class="checkbox-search checkbox-prices" name="prices[]" value="12" <?= ((isset($prices)) and (in_array('12', $prices))) ? 'checked' : ''; ?>><i></i>550K - 600K</label>
                <label class="checkbox"><input type="checkbox" class="checkbox-search checkbox-prices" name="prices[]" value="13" <?= ((isset($prices)) and (in_array('13', $prices))) ? 'checked' : ''; ?>><i></i>> 600K</label>
            </div>
        </div>
    </section>

    <section  class="sky-form">
        <h4><?= __('common.size'); ?></h4>
        <div class="row row1">
            <div class="col col-4">
                <?php foreach ($all_sizes as $size) : ?>
                <label class="checkbox"><input type="checkbox" class="checkbox-search checkbox-sizes" name="sizes[]" value="<?= $size; ?>" <?= ((isset($sizes)) and (in_array($size, $sizes))) ? 'checked' : ''; ?>><i></i><?= $size; ?></label>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section  class="sky-form">
        <h4><?= __('common.color_used'); ?></h4>
        <div class="row row1">
            <div class="col col-4">
            <?php foreach ($all_colors as $color): ?>
            <label class="checkbox"><span class="color-search" style="background-color:<?= $color;?>"> </span><input type="checkbox" class="checkbox-search checkbox-colors" name="colors[]" value="<?= $color; ?>" <?= ((isset($colors)) and (in_array($color, $colors))) ? 'checked' : ''; ?>><i></i></label>
            <?php endforeach; ?>
            </div>
        </div>
    </section>
</div>