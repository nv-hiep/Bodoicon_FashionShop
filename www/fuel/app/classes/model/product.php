<?php

/**
 * /product.php
 *
 * @copyright Copyright (C) 2015 X-TRANS inc.
 * @author Nguyen Van Hiep
 * @package Haki_Shop
 * @since Sep 7, 2015
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
class Model_Product extends \Orm\Model
{

    protected static $_table_name  = 'products';
    protected static $_primary_key = array('id');
    protected static $_properties  = array(
        'id',
        'product_name',
        'slug',
        'short_description',
        'detail_description',
        'price',
        'sale_price',
        'view_number',
        'status',
        'size',
        'created_date',
        'updated_date'
    );

    /**
     * Relation
     *
     * @version 1.0
     * @since 1.0
     * @access public
     * @author Dao Anh Minh
     */
    protected static $_has_many = array(
        'p2pc' => array(
            'key_from'       => 'id',
            'model_to'       => 'Model_ProdCat',
            'key_to'         => 'product_id',
            'cascade_save'   => false,
            'cascade_delete' => false
        ),
        'p2pi' => array(
            'key_from'       => 'id',
            'model_to'       => 'Model_ProdImg',
            'key_to'         => 'product_id',
            'cascade_save'   => false,
            'cascade_delete' => false
        )
    );

    /**
     * Relation
     *
     * @version 1.0
     * @since 1.0
     * @access public
     * @author Dao Anh Minh
     */
    protected static $_has_one = array(
        'p2pit' => array(
            'key_from'       => 'id',
            'model_to'       => 'Model_ProdImg',
            'key_to'         => 'product_id',
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
     * @author Dao Anh Minh
     */
    public static function validate($name, $obj)
    {
        $val = Validation::forge($name);
        $val->add_field('name', __('common.name'), 'required|max_length[255]|min_length[2]');
        $val->add_field('short_desc', __('prod.short_desc'), 'required|min_length[10]');
        $val->add_field('detail', __('prod.detail'), 'required');
        $val->add_field('price', __('common.price'), 'required');
        $val->add_field('size', __('common.size'), 'required');

        return $val;
    }

    /**
     * Get all products
     *
     * @return array ORM objects of products
     *
     * @access public
     * @author Nguyen Van hiep
     *
     * @version 1.0
     * @since 1.0
     */
    public static function get_all_products()
    {
        $prods = Model_Product::query()
                ->related('p2pc')
                ->related('p2pc.pc2c')
                ->order_by('updated_date', 'desc')
                ->get();
        return $prods;
    }

    /**
     * Get all products with offset
     *
     * @params int $offset Offset
     * @params int $limit Limit
     * @params int $cat Cat. ID
     * @return array ORM objects of products
     *
     * @access public
     * @author Nguyen Van hiep
     *
     * @version 1.0
     * @since 1.0
     */
    public static function get_all_products_with_offset($offset, $limit, $cat = null)
    {
        if ($cat != null) {
            $prods = Model_Product::query()
                    ->related('p2pc')
                    ->related('p2pit')
                    ->related('p2pc.pc2c')
                    ->where('p2pc.category_id', $cat)
                    ->where('p2pit.image_type', THUMBNAIL)
                    ->rows_offset($offset)
                    ->rows_limit($limit)
                    ->order_by('updated_date', 'desc')
                    ->get();
            return $prods;
        }

        $prods = Model_Product::query()
                ->related('p2pc')
                ->related('p2pit')
                ->related('p2pc.pc2c')
                ->where('p2pit.image_type', THUMBNAIL)
                ->rows_offset($offset)
                ->rows_limit($limit)
                ->order_by('updated_date', 'desc')
                ->get();
        return $prods;
    }

    /**
     * Get all products
     *
     * @params string $slug Product - slug
     * @return ORM objects of product
     *
     * @access public
     * @author Nguyen Van hiep
     *
     * @version 1.0
     * @since 1.0
     */
    public static function get_prod_from_slug($slug)
    {
        $prod = Model_Product::query()
                ->where('slug', $slug)
                ->get_one();
        return $prod;
    }

    /**
     * Get product detail
     *
     * @params int $id Product - ID
     * @return object ORM object of product
     *
     * @access public
     * @author Nguyen Van hiep
     * @author Dao Anh Minh
     *
     * @version 1.0
     * @since 1.0
     */
    public static function get_prod_detail($id)
    {
        $prod = Model_Product::query()
                ->related('p2pi')
                //->related('p2pc')
                //->related('p2pc.pc2c')
                ->where('id', $id)
                ->get_one();

        $prod->thumbnail = '';
        $prod->images    = array();
        $prod->colors    = array();

        foreach ($prod->p2pi as $related) {

            //product image
            if ($related->image_type == THUMBNAIL) {
                $prod->thumbnail = $related->image_name;
            } else {
                $prod->images[] = $related->image_name;
            }

            //color
            if (!empty($related->colors) and ! key_exists($related->colors, $prod->colors)) {
                $prod->colors[$related->colors] = $related->image_name;
            }
        }

        return $prod;
    }

    /**
     * Get new products
     *
     * @return array ORM objects of images
     *
     * @access public
     * @author Nguyen Van hiep
     *
     * @version 1.0
     * @since 1.0
     */
    public static function get_new_prods()
    {
        // Get 9 new products
        $prods = Model_Product::query()
                ->related('p2pi')
                ->order_by('created_date', 'desc')
                ->limit(9)
                ->get();

        foreach ($prods as $prod) {
            $prod->thumbnail = '';
            $prod->images    = array();
            foreach ($prod->p2pi as $img) {
                if ($img->image_type == THUMBNAIL) {
                    $prod->thumbnail = $img->image_name;
                } else {
                    $prod->images[] = $img->image_name;
                }
            }
        }

        return $prods;
    }

    /**
     * Get featured products
     *
     * @return array ORM objects of images
     *
     * @access public
     * @author Nguyen Van hiep
     *
     * @version 1.0
     * @since 1.0
     */
    public static function get_ft_prods()
    {
        // Get 6 new products
        $prods = Model_Product::query()
                ->related('p2pi')
                ->order_by('view_number', 'desc')
                ->limit(6)
                ->get();

        foreach ($prods as $prod) {
            $prod->thumbnail = '';
            $prod->images    = array();
            foreach ($prod->p2pi as $img) {
                if ($img->image_type == THUMBNAIL) {
                    $prod->thumbnail = $img->image_name;
                } else {
                    $prod->images[] = $img->image_name;
                }
            }
        }

        return $prods;
    }

    /**
     * Get exclusive prods
     *
     * @return array ORM objects of images
     *
     * @access public
     * @author Nguyen Van hiep
     *
     * @version 1.0
     * @since 1.0
     */
    public static function get_exclusive_prods()
    {
        // Get 10 new producrs
        $prods     = Model_Product::query()
                ->order_by('created_date', 'desc')
                ->limit(10)
                ->get();
        $new_prods = array();
        foreach ($prods as $prod) {
            $new_prods[$prod->id] = $prod->product_name;
        }

        // Get 10 most-viewed products
        $products   = Model_Product::query()
                ->order_by('view_number', 'desc')
                ->limit(10)
                ->get();
        $view_prods = array();
        foreach ($products as $prod) {
            $view_prods[$prod->id] = $prod->product_name;
        }

        $ret = array(
            'Mới nhất'       => $new_prods,
            'Xem nhiều nhất' => $view_prods
        );

        return $ret;
    }

    /**
     * Get products from keyword of name
     *
     * @params string $k keyword of name to search
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
    public static function get_prods_from_keyword($k, $offset = null, $limit = null)
    {

        if (($offset != null) or ( $limit != null)) {
            $prods = Model_Product::query()
                    ->related('p2pit')
                    ->where('product_name', 'LIKE', "%{$k}%")
                    ->order_by('created_date', 'desc')
                    ->where('p2pit.image_type', THUMBNAIL)
                    ->rows_offset($offset)
                    ->rows_limit($limit)
                    ->get();
            return $prods;
        }

        $count = Model_Product::query()
                ->where('product_name', 'LIKE', "%{$k}%")
                ->count();
        return $count;
    }

    /**
     * Get products from sidesearch
     *
     * @params array $cats categories
     * @params array $prices prices
     * @params array $sizes sizes
     * @params array $colors colors
     *
     * @return array objects of products
     *
     * @access public
     * @author Nguyen Van hiep
     *
     * @version 1.0
     * @since 1.0
     */
    public static function get_prods_from_sidesearch($cats, $prices, $sizes, $colors = null, $offset = null, $limit = null)
    {
        $query = Model_Product::query();
        if (count($cats) > 0) {
            $query->related('p2pc')
                    ->where('p2pc.category_id', 'IN', $cats);
        }

        if (count($prices) > 0) {
            $query->and_where_open();
            foreach ($prices as $price) {
                switch ($price) {
                    case "1":
                        $query->or_where('price', '<', 50);
                        break;
                    case "2":
                        $query->or_where('price', 'between', array(50, 100));
                        break;
                    case "3":
                        $query->or_where('price', 'between', array(100, 150));
                        break;
                    case "4":
                        $query->or_where('price', 'between', array(150, 200));
                        break;
                    case "5":
                        $query->or_where('price', 'between', array(200, 250));
                        break;
                    case "6":
                        $query->or_where('price', 'between', array(250, 300));
                        break;
                    case "7":
                        $query->or_where('price', 'between', array(300, 350));
                        break;
                    case "8":
                        $query->or_where('price', 'between', array(350, 400));
                        break;
                    case "9":
                        $query->or_where('price', 'between', array(400, 450));
                        break;
                    case "10":
                        $query->or_where('price', 'between', array(450, 500));
                        break;
                    case "11":
                        $query->or_where('price', 'between', array(500, 550));
                        break;
                    case "12":
                        $query->or_where('price', 'between', array(550, 600));
                        break;
                    case "13":
                        $query->or_where('price', '>', 600);
                        break;
                    default:
                        break;
                }
            }
            $query->and_where_close();
        }

        if (count($sizes) > 0) {
            $query->and_where_open();
            foreach ($sizes as $size) {
                $query->or_where('size', '=', "{$size}")
                      ->or_where('size', 'LIKE', "$size %")
                      ->or_where('size', 'LIKE', "% $size %")
                      ->or_where('size', 'LIKE', "% $size");
            }
            $query->and_where_close();
        }

        if (count($colors) > 0) {
            $query->related('p2pi');
            $query->and_where_open();
            foreach ($colors as $color) {
                $query->or_where('p2pi.colors', "{$color}");
            }
            $query->and_where_close();
        }

        if (($offset != null) or ( $limit != null)) {
            $query->rows_offset($offset)
                ->rows_limit($limit)
                ->order_by('created_date', 'desc');
            return $query->get();
        }
        return $query->count();
    }

    /**
     * Get all sizes
     *
     * @return array of sizes
     *
     * @access public
     * @author Nguyen Van hiep
     *
     * @version 1.0
     * @since 1.0
     */
    public static function get_all_sizes()
    {
        $result = DB::select('size')
                ->from('products')
                ->distinct(true)
                ->execute()
                ->as_array();
        if (count($result) == 0) {
            return $result;
        }
        $string = '';
        foreach ($result as $val) {
            $string .= " {$val['size']}";
        }
        $sizes = array_unique(explode(" ", trim($string)));

        $size_num = array();
        $size_str = array();
        foreach ($sizes as $size) {
            if (is_numeric($size)) {
                $size_num[] = $size;
            } else {
                $size_str[] = $size;
            }
        }
        sort($size_num);
        usort($size_str, 'cmp');
        return array_merge($size_num, $size_str);
    }

}

// Size comparison function:
function cmp($a, $b)
{
    $a = strtoupper($a);
    $b = strtoupper($b);

    // Make the array static for performance.
    static $sizes = array('XXXS', 'XXS', 'XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL');

    // Find the size of $a and $b (the first string for which strpos===0)
    $asize = 100; // Sort non-size strings after matching sizes.
    $apos  = -1;
    $bsize = 100;
    $bpos  = -1;
    foreach ($sizes as $val => $str) {
      // It's important to use `===` because `==` will match on
      // FALSE, which is returns for no match.
      if (($pos = strpos($a, $str)) !== FALSE && ($apos < 0 || $pos < $apos)) {
        $asize = $val;
        $apos  = $pos;
      }
      if (($pos = strpos($b, $str)) !== FALSE && ($bpos < 0 || $pos < $bpos)) {
        $bsize = $val;
        $bpos  = $pos;
      }
    }

    return ($asize == $bsize ? 0 : ($asize > $bsize ? 1 : -1));
}
