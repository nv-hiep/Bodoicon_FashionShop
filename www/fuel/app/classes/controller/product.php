<?php

/**
 * /product.php
 *
 * @copyright Copyright (C) 2015 X-TRANS inc.
 * @author Dao Anh Minh
 * @package Haki_Shop
 * @since Sep 11, 2015
 * @version $Id$
 * @license X-TRANS Develop License 1.0
 */

/**
 * product
 *
 * <pre>
 * </pre>
 *
 * @copyright Copyright (C) 2015 X-TRANS inc.
 * @author Dao Anh Minh
 * @package Haki_Shop
 * @since Sep 11, 2015
 * @version $Id$
 * @license X-TRANS Develop License 1.0
 */
class Controller_Product extends Controller_Base
{

    /**
     * Display detailed page of a product
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
        $p = Model_Product::get_prod_from_slug(Uri::string());
        if (!$p) {
            Response::redirect('base/error');
        }

        $uri = explode('-', Uri::string());
        $id = array_pop($uri);
        $p = Model_Product::find($id);
        if (!$p) {
            Session::set_flash('error', __('prod.not_exist'));
            Response::redirect('base/404');
        }

        $p->view_number = (int) $p->view_number + 1;
        $p->save();

        $this->addCss('etalage.css');

        $this->addJs('leo_template/jquery.jscrollpane.min.js');
        $this->addJs('leo_template/slides.min.jquery.js');
        $this->addJs('leo_template/jquery.etalage.min.js');
        $this->addJs('leo_template/jquery.flexisel.js');
        $this->addJs('cart.js');

        $view = View::forge('customer/product/detail');
        $view->prod = Model_Product::get_prod_detail($id);
        $cats = Model_ProdCat::get_cat_from_prod($id);
        $view->rel_prods = Model_ProdCat::get_prod_thumbs_from_cats($cats);

        $this->template->title   = $view->prod->product_name;
        $this->template->content = $view;
    }

}
