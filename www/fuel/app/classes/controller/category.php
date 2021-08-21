<?php

/**
 * /category.php
 *
 * @copyright Copyright (C) 2015 X-TRANS inc.
 * @author Huynh Hai Lam
 * @package Haki_Shop
 * @since Sep 11, 2015
 * @version $Id$
 * @license X-TRANS Develop License 1.0
 */

/**
 * category
 *
 * <pre>
 * </pre>
 *
 * @copyright Copyright (C) 2015 X-TRANS inc.
 * @author Huynh Hai Lam
 * @package Haki_Shop
 * @since Sep 11, 2015
 * @version $Id$
 * @license X-TRANS Develop License 1.0
 */
class Controller_Category extends Controller_Base
{

    /**
     * Display products in category
     *
     * @param void
     * @access public
     * @author Nguyen Van Hiep
     *
     * @version 1.0
     * @since 1.0
     */
    public function action_view()
    {
        $uri  = explode('/', Uri::string());
        $slug = str_replace('.html', '', $uri[0]);
        $cat  = Model_Categories::get_cat_from_slug($slug);
        $slug = $slug .'.html/';

        if (!$cat) {
            Response::redirect('404');
        }

        // Number of products of the category
        $nbr_prods = Model_ProdCat::nbr_prods_from_cat($cat->id);


        $view = View::forge('customer/cat/category');

        $config = array(
            'pagination_url'  => Uri::base() . $slug,
            'total_items'     => (int) $nbr_prods,
            'per_page'        => 30,
            'uri_segment'     => 2,
            'num_links'       => 7,
        );
        $pag    = Pagination::forge('paging', $config);

        $view->cat   = $cat->name;
        $view->prods = Model_ProdCat::get_prods_from_cat($cat->id, $pag->offset, $pag->per_page);
        $view->pag   = $pag;
        $view->cats  = Model_Categories::get_active_cats();

        $view->nbr_prods         = $nbr_prods;
        $this->template->title   = $cat->name;
        $this->template->content = $view;
    }

    /**
     * Display products of search result
     *
     * @param void
     * @access public
     * @author Nguyen Van Hiep
     *
     * @version 1.0
     * @since 1.0
     */
    public function action_search()
    {
        $k = Input::get('k');

        if (strlen($k) <= 0) {
            Response::redirect('home');
        }

        $url = 'tim-kiem.html?k=' . $k;

        $view = View::forge('customer/cat/search');
        $nbr_prods = Model_Product::get_prods_from_keyword($k);

        $config = array(
            'pagination_url'  => Uri::base() . $url,
            'total_items'     => (int) $nbr_prods,
            'per_page'        => 30,
            'uri_segment'     => 2,
            'num_links'       => 7,
        );
        $pag    = Pagination::forge('paging', $config);

        $view->prods = Model_Product::get_prods_from_keyword($k, $pag->offset, $pag->per_page);
        $view->pag   = $pag;

        $view->nbr_prods         = $nbr_prods;
        $this->template->title   = __('account.search');
        $this->template->content = $view;
    }

    /**
     * Display search results by ajax
     *
     * @param void
     * @access public
     * @author Nguyen Van Hiep
     *
     * @version 1.0
     * @since 1.0
     */
    public function action_sidesearch()
    {
        if (empty(Input::post('cats')) and empty(Input::post('prices')) and
                empty(Input::post('sizes')) and empty(Input::post('colors'))) {
            Response::redirect('trang-chu.html');
        }
        $view = View::forge('customer/cat/advanced_search');
        $this->addJs('advsearch_function.js');

        $categs = (!empty(Input::post('cats')))   ? Input::post('cats')   : array();
        $prices = (!empty(Input::post('prices'))) ? Input::post('prices') : array();
        $sizes  = (!empty(Input::post('sizes')))  ? Input::post('sizes')  : array();
        $colors = (!empty(Input::post('colors'))) ? Input::post('colors') : array();

        $view->categs = $categs;
        $view->prices = $prices;
        $view->sizes  = $sizes;
        $view->colors = $colors;

        $nbr_prods = Model_Product::get_prods_from_sidesearch($categs, $prices, $sizes, $colors);

        $config = array(
            'pagination_url' => Uri::base() . 'tim-nang-cao.html',
            'total_items'    => (int) $nbr_prods,
            'per_page'       => 30,
            'uri_segment'    => 2,
            'num_links'      => 7,
        );
        $pag    = Pagination::forge('paging', $config);

        $view->prods = Model_Product::get_prods_from_sidesearch($categs, $prices, $sizes, $colors, $pag->offset, $pag->per_page);
        $view->pag   = $pag;

        $view->nbr_prods         = $nbr_prods;
        $this->template->title   = __('account.search');
        $this->template->content = $view;
    }

}
