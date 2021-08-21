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
 * Slider
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
class Model_Slider extends \Orm\Model
{
    protected static $_table_name ='banner';
    protected static $_primary_key = array('id');

    protected static $_properties = array(
        'id',
        'upper_line',
        'lower_line',
        'image_name',
        'display_flag',
        'updated_at'
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
     * @author Dao Anh Minh
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
     * @author Nguyen Van hiep
     *
     * @version 1.0
     * @since 1.0
     */
    public static function get_all_imgs()
    {
        $imgs = Model_Slider::query()
              ->order_by('updated_at', 'desc')
              ->get();
        return $imgs;
    }
    
    /**
     * Get active banners
     *
     * @return array ORM objects of banners
     *
     * @access public
     * @author Nguyen Van hiep
     *
     * @version 1.0
     * @since 1.0
     */
    public static function get_active_banners()
    {
        $banners = Model_Slider::query()
                ->where('display_flag', true)
                ->order_by('updated_at', 'desc')
                ->get();
        return $banners;
    }
}