<?php

/**
 * /prodcat.php
 *
 * @copyright Copyright (C) 2015 X-TRANS inc.
 * @author Nguyen Van Hiep
 * @package Haki_Shop
 * @since Sep 10, 2015
 * @version $Id$
 * @license X-TRANS Develop License 1.0
 */

/**
 * Product
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
class Model_ProdCat extends \Orm\Model
{

    protected static $_table_name  = 'products_categories';
    protected static $_primary_key = array('id');
    protected static $_properties  = array(
        'id',
        'category_id',
        'product_id'
    );

    /**
     * Relation
     *
     * @version 1.0
     * @since 1.0
     * @access public
     * @author Dao Anh Minh
     */
    protected static $_belongs_to = array(
        'pc2c' => array(
            'key_from'       => 'category_id',
            'model_to'       => 'Model_Categories',
            'key_to'         => 'id',
            'cascade_save'   => false,
            'cascade_delete' => false
        ),
        'pc2p' => array(
            'key_from'       => 'product_id',
            'model_to'       => 'Model_Product',
            'key_to'         => 'id',
            'cascade_save'   => false,
            'cascade_delete' => false
        )
    );

    /**
     * Save product-ids and cat-ids
     *
     * @params int $id product-id
     * @params array $cat cat.-ids
     * @params boolean $edit edit/add
     *
     * @return void
     *
     * @access public
     * @author Nguyen Van hiep
     *
     * @version 1.0
     * @since 1.0
     */
    public static function save_prod_cat($id, $cats, $edit = false)
    {
        if ($edit == true) {
            DB::delete('products_categories')
                    ->where('product_id', $id)
                    ->execute();
        }

        foreach ($cats as $val) {
            $pc              = Model_ProdCat::forge();
            $pc->category_id = $val;
            $pc->product_id  = $id;
            $pc->save();
        }
    }

    /**
     * Get category_ids of a product
     *
     * @params int $id product-id
     *
     * @return array Catergory-IDs of product
     *
     * @access public
     * @author Nguyen Van hiep
     *
     * @version 1.0
     * @since 1.0
     */
    public static function get_cat_from_prod($id)
    {
        $cats = Model_ProdCat::query()
                ->where('product_id', $id)
                ->get();
        $ret  = array();
        foreach ($cats as $cat) {
            $ret[] = $cat->category_id;
        }
        return $ret;
    }

    /**
     * Get category_ids of a product
     *
     * @params array $ids cat.-ids
     *
     * @return array objects of products
     *
     * @access public
     * @author Nguyen Van hiep
     *
     * @version 1.0
     * @since 1.0
     */
    public static function get_prod_thumbs_from_cats($ids)
    {
        $ps = Model_ProdCat::query()
                ->where('category_id', 'IN', $ids)
                ->limit(15)
                ->get();

        $pids = array();
        foreach ($ps as $p) {
            $pids[] = $p->product_id;
        }

        $prods = Model_Product::query()
                ->related('p2pit')
                ->where('id', 'IN', array_unique($pids))
                ->where('p2pit.image_type', THUMBNAIL)
                ->get();

        return $prods;
    }

    /**
     * Delete category-product
     *
     * @params int $id product-id
     * @return void
     *
     * @access public
     * @author Nguyen Van hiep
     *
     * @version 1.0
     * @since 1.0
     */
    public static function del_prod_cat($id)
    {
        DB::delete('products_categories')
                ->where('product_id', $id)
                ->execute();
    }

    /**
     * Count number of products from a cat.
     *
     * @params int $id product-id
     * @return void
     *
     * @access public
     * @author Nguyen Van hiep
     *
     * @version 1.0
     * @since 1.0
     */
    public static function nbr_prods_from_cat($id)
    {
        $nbr = Model_ProdCat::query()
                ->where('category_id', $id)
                ->count();
        return $nbr;
    }

    /**
     * Get products related to cat.
     *
     * @params int $id cat.-id
     * @return void
     *
     * @access public
     * @author Nguyen Van hiep
     *
     * @version 1.0
     * @since 1.0
     */
    public static function get_related_prods($id)
    {
        $prods = Model_ProdCat::query()
                ->related('pc2p')
                ->where('category_id', $id)
                ->get();
        return $prods;
    }

    /**
     * Get products of a category
     *
     * @params int $id cat.-id
     * @params int $offset Offset
     * @params int $offset Limit
     *
     * @return array objects of products
     *
     * @access public
     * @author Nguyen Van hiep
     *
     * @version 1.0
     * @since 1.0
     */
    public static function get_prods_from_cat($id, $offset, $limit)
    {
        $ps = Model_ProdCat::query()
                ->where('category_id', $id)
                ->rows_offset($offset)
                ->rows_limit($limit)
                ->get();

        if (count($ps) == 0) {
            return array();
        }

        $pids = array();
        foreach ($ps as $p) {
            $pids[] = $p->product_id;
        }

        $prods = Model_Product::query()
                ->related('p2pit')
                ->order_by('created_date', 'desc')
                ->where('id', 'IN', array_unique($pids))
                ->where('p2pit.image_type', THUMBNAIL)
                ->get();

        return $prods;
    }

}
