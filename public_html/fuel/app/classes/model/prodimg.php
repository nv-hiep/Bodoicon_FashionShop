<?php

/**
 * /prodimg.php
 *
 * @copyright Copyright (C) 2015 X-TRANS inc.
 * @author Nguyen Van Hiep
 * @package Haki_Shop
 * @since Sep 10, 2015
 * @version $Id$
 * @license X-TRANS Develop License 1.0
 */

/**
 * Products Image
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
class Model_ProdImg extends \Orm\Model
{

    protected static $_table_name  = 'products_image';
    protected static $_primary_key = array('id');
    protected static $_properties  = array(
        'id',
        'product_id',
        'image_name',
        'image_type',
        'colors'
    );

    /**
     * Save images of product
     *
     * @params int $id product-id
     * @params array $names Names of images
     * @params array $colors Color-codes of images
     *
     * @return void
     *
     * @access public
     * @author Nguyen Van hiep
     *
     * @version 1.0
     * @since 1.0
     */
    public static function save_images($id, $names, $colors)
    {
        foreach ($names as $key => $name) {
            $img             = Model_ProdImg::forge();
            $img->product_id = $id;
            $img->image_name = $name;
            $img->image_type = NORMAL;
            $img->colors     = $colors[$key];
            $img->save();
        }
    }

    /**
     * Save thumbnail
     *
     * @params int $id product-id
     * @params string $name Name of thumbnail
     * @params boolean $edit edit/not edit
     *
     * @return void
     *
     * @access public
     * @author Nguyen Van hiep
     *
     * @version 1.0
     * @since 1.0
     */
    public static function save_thumbnail($id, $name, $edit = false)
    {
        if ($edit == true) {
            DB::delete('products_image')
                    ->where('product_id', $id)
                    ->where('image_type', THUMBNAIL)
                    ->execute();
        }

        $thumb             = Model_ProdImg::forge();
        $thumb->product_id = $id;
        $thumb->image_name = $name;
        $thumb->image_type = THUMBNAIL;
        $thumb->colors     = null;
        $thumb->save();
    }

    /**
     * Get thumbnail of a product
     *
     * @params int $id product-id
     *
     * @return object info of thumbnail
     *
     * @access public
     * @author Nguyen Van hiep
     *
     * @version 1.0
     * @since 1.0
     */
    public static function get_prod_thumbnail($id)
    {
        $thumb = Model_ProdImg::query()
                ->where('product_id', $id)
                ->where('image_type', THUMBNAIL)
                ->get_one();
        return $thumb;
    }

    /**
     * Get thumbnail of a product
     *
     * @params int $id product-id
     *
     * @return array of object info of thumbnail
     *
     * @access public
     * @author Nguyen Van hiep
     *
     * @version 1.0
     * @since 1.0
     */
    public static function get_prod_imgs($id)
    {
        $imgs = Model_ProdImg::query()
                ->where('product_id', $id)
                ->where('image_type', NORMAL)
                ->get();
        return $imgs;
    }

    /**
     * Get all images of a product
     *
     * @params int $id product-id
     * @return array of object info of thumbnail
     *
     * @access public
     * @author Nguyen Van hiep
     *
     * @version 1.0
     * @since 1.0
     */
    public static function get_all_prod_imgs($id)
    {
        $imgs = Model_ProdImg::query()
                ->where('product_id', $id)
                ->get();
        return $imgs;
    }

    /**
     * Get all colors of products
     *
     * @return array of colors
     *
     * @access public
     * @author Nguyen Van hiep
     *
     * @version 1.0
     * @since 1.0
     */
    public static function get_all_colors()
    {
        $colors = Model_ProdImg::query()
                //->select('colors')
                ->where('colors', '!=', null)
                ->group_by('colors')
                ->get();
        $ret = array();
        foreach ($colors as $color) {
            $ret[] = $color->colors;
        }
        return $ret;
    }

    /**
     * Delete product-image
     *
     * @params int $id product-id
     *
     * @return void
     *
     * @access public
     * @author Nguyen Van hiep
     *
     * @version 1.0
     * @since 1.0
     */
    public static function del_prod_img($id)
    {
        DB::delete('products_image')
                ->where('product_id', $id)
                ->execute();
    }

    /**
     * Change color of an image
     *
     * @params int $id product-id
     * @params string $prod product-name
     * @params string $color product-color
     *
     * @return void
     *
     * @access public
     * @author Nguyen Van hiep
     *
     * @version 1.0
     * @since 1.0
     */
    public static function change_img_color($id, $prod, $color)
    {
        $item = Model_ProdImg::query()
                ->where('product_id', $id)
                ->where('image_name', $prod)
                ->get_one();
        $item->colors = $color;
        $item->save();
    }

    /**
     * Delete an image of product
     *
     * @params int $id product-id
     * @params string $prod product-name
     *
     * @return void
     *
     * @access public
     * @author Nguyen Van hiep
     *
     * @version 1.0
     * @since 1.0
     */
    public static function del_img_of_prod($id, $prod)
    {
        DB::delete('products_image')
                ->where('product_id', $id)
                ->where('image_name', $prod)
                ->execute();
    }

}
