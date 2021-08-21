<?php

/**
 * /base.php
 *
 * @copyright Copyright (C) 2015 X-TRANS inc.
 * @author Dao Anh Minh
 * @package H_Shop
 * @since Sep 5, 2015
 * @version $Id$
 * @license X-TRANS Develop License 1.0
 */

/**
 * base
 *
 * <pre>
 * </pre>
 *
 * @copyright Copyright (C) 2015 X-TRANS inc.
 * @author Dao Anh Minh
 * @package H_Shop
 * @since Sep 5, 2015
 * @version $Id$
 * @license X-TRANS Develop License 1.0
 */
class Controller_Base extends Controller_Common
{
    public $template = 'customer/template';

    public function before()
    {
        parent::before();

        //Load language
        Lang::load('language.ini');

        $this->init_js();
        $this->init_css();

        $cats       = Model_Categories::get_active_cats();
        $all_colors = Model_ProdImg::get_all_colors();
        $all_sizes  = Model_Product::get_all_sizes();

        View::set_global('cats', $cats, false);
        View::set_global('all_colors', $all_colors, false);
        View::set_global('all_sizes', $all_sizes, false);

        $this->template->fullname = Model_Account::get_fullname_of_logged_user();
    }

    protected function init_css()
    {
        $this->addCss('template.css');
        $this->addCss('form.css');
        $this->addCss('exo2.css');
        $this->addCss('megamenu.css');
        $this->addCss('fwslider.css');
        $this->addCss('style.css');

        $this->addCss('default.css');
        $this->addCss('nivo-slider.css');
        $this->addCss('product-img.css');
    }

    protected function init_js()
    {
        $this->addJs('jquery-1.11.1.min.js');
        $this->addJs('jquery.redirect.js');
        $this->addJs("jquery.smoove.min.js");
        $this->addJs("smoove.function.js");
        $this->addJs('leo_template/megamenu.js');
        $this->addJs('jquery-ui.js');
        $this->addJs('leo_template/css3-mediaqueries.js');
        $this->addJs('leo_template/fwslider.js');
        $this->addJs('leo_template/jquery.easydropdown.js');
        $this->addJs('leo_template/jquery.nivo.slider.js');
        $this->addJs('app_function.js');
    }

    /**
     * display error 404 not page found
     *
     * @access public
     * @author Dao Anh Minh
     */
    public function action_404()
    {
        $view                    = View::forge('common/404');
        $this->template->title   = __('title.page_404');
        $this->template->content = $view;
    }

    /**
     * display access denied page
     *
     * @access public
     * @author Dao Anh Minh
     */
    public function action_error()
    {
        $view                    = View::forge('common/error');
        $this->template->title   = 'Access denied';
        $this->template->content = $view;
    }

    /**
     * Create bill id
     *
     * EX: BDC_000123
     *
     * @param integer $order_id order id
     * @return string bill id
     *
     * @access protected
     * @author Dao Anh Minh
     */
    protected function create_bill_id($order_id)
    {
        return BILL_PREFIX . str_pad($order_id, 6, '0', STR_PAD_LEFT);
    }
}
