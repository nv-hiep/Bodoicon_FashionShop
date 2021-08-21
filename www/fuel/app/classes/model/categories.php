<?php

/**
 * /categories.php
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
 * @package tmd
 * @since Sep 5, 2015
 * @version $Id$
 * @license X-TRANS Develop License 1.0
 */
class Model_Categories extends \Orm\Model
{

    protected static $_table_name  = 'categories';
    protected static $_primary_key = array('id');
    protected static $_properties = array(
        'id',
        'name',
        'slug',
        'order',
        'parent_id',
        'active',
        'storage'
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
        $val->add_field('name', __('common.name'), 'required|max_length[64]|min_length[2]');
        $val->add_field('slug', __('common.slug'), 'required|max_length[64]|min_length[2]');
        $val->field('name')->add_rule('unique_field', 'name', $obj);

        return $val;
    }

    /**
     * Get categories
     *
     * @return array ORM objects of categories
     *
     * @access public
     * @author Nguyen Van hiep
     *
     * @version 1.0
     * @since 1.0
     */
    public static function get_all_cats()
    {
        $imgs = Model_Categories::query()
                ->order_by('order', 'asc')
                ->get();
        return $imgs;
    }

    /**
     * Get active categories
     *
     * @param boolean $store Category is store of products?
     * @return array ORM objects of active categories
     *
     * @access public
     * @author Nguyen Van hiep
     *
     * @version 1.0
     * @since 1.0
     */
    public static function get_active_cats($store = false)
    {
        $query = Model_Categories::query()
                ->where('active', true);
        if ($store == true) {
            $query->where('storage', true);
        }
        $query->order_by('order', 'asc');

        $cats = $query->get();

        foreach ($cats as $key => $cat) {
            $cats[$key]->subcats = Model_Categories::get_child_cats($cat->id, true);
        }

        return $cats;
    }

    /**
     * Get categories
     *
     * @return array of categories
     *
     * @access public
     * @author Nguyen Van hiep
     *
     * @version 1.0
     * @since 1.0
     */
    public static function get_cats()
    {
        $res = Model_Categories::query()
                ->get();

        $ret = array('0' => '---');
        foreach ($res as $val) {
            $ret[$val->id] = $val->name;
        }
        return $ret;
    }

    /**
     * Get list of categories
     *
     * @return array list of categories
     *
     * @access public
     * @author Nguyen Van hiep
     *
     * @version 1.0
     * @since 1.0
     */
    public static function get_cat_list()
    {
        $res = Model_Categories::query()
                ->get();
        
        $ret = array();

        foreach ($res as $val) {
            $ret[$val->id] = $val->name;
        }
        return $ret;
    }

    /**
     * Update cat. orders to database
     *
     * @param integer $id cat. id
     * @return int $result numer of lines executed
     *
     * @access public
     * @since 1.0
     * @version 1.0
     * @author Nguyen Van Hiep
     */
    public static function update_order($order, $id)
    {
        $result = DB::update('categories')
                ->value('order', $order)
                ->where('id', '=', $id)
                ->execute();
        return $result;
    }

    /**
     * Get child cat.s of a cat.
     *
     * @param integer $id cat. id
     * @param boolean $active Category is active?
     * @return array $res array of objects
     *
     * @access public
     * @since 1.0
     * @version 1.0
     * @author Nguyen Van Hiep
     */
    public static function get_child_cats($id, $active = false)
    {
        $res = Model_Categories::query()
                ->where('parent_id', $id);
        if ($active ==  true) {
            $res->where('active', true);
        }
        return $res->get();
    }

    /**
     * Get cat. from slug
     *
     * @param string $slug cat.-slug
     * @return object $res object of cat.
     *
     * @access public
     * @since 1.0
     * @version 1.0
     * @author Nguyen Van Hiep
     */
    public static function get_cat_from_slug($slug)
    {
        $res = Model_Categories::query()
                ->where('slug', $slug)
                ->get_one();
        return $res;
    }

}
