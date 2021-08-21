<?php

/**
 * /slider.php
 *
 * @copyright Copyright (C) 2015 X-TRANS inc.
 * @author Nguyen Van Hiep
 * @package HakiShop
 * @since Sep 5, 2015
 * @version $Id$
 * @license X-TRANS Develop License 1.0
 */

/**
 * Currency
 *
 * <pre>
 * </pre>
 *
 * @copyright Copyright (C) 2014 X-TRANS inc.
 * @author Bui Huu Phuc
 * @package HakiShop
 * @since Sep 5, 2015
 * @version $Id$
 * @license X-TRANS Develop License 1.0
 */
class Model_Sideslider extends \Orm\Model
{

    protected static $_table_name  = 'side_slider';
    protected static $_primary_key = array('id');
    protected static $_properties = array(
        'id',
        'image_name',
        'product_id',
        'display_flag'
    );

    /**
     * Relation
     *
     * @version 1.0
     * @since 1.0
     * @access public
     * @author Dinh Van Huong
     */
    protected static $_belongs_to = array(
        'ss2p' => array(
            'key_from'       => 'product_id',
            'model_to'       => 'Model_Product',
            'key_to'         => 'id',
            'cascade_save'   => false,
            'cascade_delete' => false
        )
    );

    /**
     * Validate form value
     *
     * @param String $name name of validation
     * @param object $obj model to check validation
     * @return object Validation object
     *
     * @version 1.0
     * @since 1.0
     * @access public
     * @author Dinh Van Huong
     */
    public static function validate($name, $obj)
    {
        $val = Validation::forge($name);

        $val->field('name')->add_rule('unique_field', 'image_name', $obj);

        return $val;
    }

    /**
     * Get images
     *
     * @return array ORM objects of images
     *
     * @access public
     * @author Dinh Van Huong
     *
     * @version 1.0
     * @since 1.0
     */
    public static function get_all_imgs()
    {
        $imgs = Model_Sideslider::query()
                ->related('ss2p')
                ->get();
        return $imgs;
    }

    /**
     * Get active side banners
     *
     * @return array ORM objects of banners
     *
     * @access public
     * @author Nguyen Van hiep
     *
     * @version 1.0
     * @since 1.0
     */
    public static function get_active_side_banners()
    {
        $banners = Model_Sideslider::query()
                ->related('ss2p')
                ->where('display_flag', true)
                ->get();
        return $banners;
    }

}
