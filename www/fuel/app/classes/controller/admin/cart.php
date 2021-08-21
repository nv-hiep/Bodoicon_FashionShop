<?php

/**
 * /cart.php
 *
 * @copyright Copyright (C) 2015 X-TRANS inc.
 * @author Dao Anh Minh
 * @package Haki_Shop
 * @since Sep 29, 2015
 * @version $Id$
 * @license X-TRANS Develop License 1.0
 */

/**
 * cart
 *
 * <pre>
 * </pre>
 *
 * @copyright Copyright (C) 2015 X-TRANS inc.
 * @author Dao Anh Minh
 * @package Haki_Shop
 * @since Sep 29, 2015
 * @version $Id$
 * @license X-TRANS Develop License 1.0
 */
class Controller_Admin_Cart extends Controller_Admin_Base
{
    /**
     * List of all orders
     *
     * @access public
     * @author Dao Anh Minh
     */
    public function action_list()
    {
        $config = array(
            'pagination_url'  => Uri::base() . 'admin/cart/list',
            'total_items'     => (int) Model_Order::count(),
            'per_page'        => 10,
            'uri_segment'     => 4,
            'num_links'       => 7,
        );
        $pag    = Pagination::forge('paging', $config);

        // view
        $view = View::forge('admin/cart/list');

        $view->orders = Model_Order::query()
                ->related('product')
                ->rows_offset($pag->offset)
                ->rows_limit($pag->per_page)
                ->order_by('status','ASC')
                ->order_by('created_date', 'DESC')
                ->get();

        foreach ($view->orders as $order_data) {
            $view->orders[$order_data['id']]->bill_id = $this->create_bill_id($order_data['id']);
        }

        $this->template->title   = __('cart.cart_management_title');
        $this->template->content = $view;
    }

    /**
     * Delete order
     *
     * @param integer $order_id
     *
     * @access public
     * @author Dao Anh Minh
     */
    public function action_delete($order_id)
    {
        $order = Model_Order::query()
                ->where('id', $order_id)
                ->get_one();

        if (count($order) <= 0) {
            Session::set_flash('error', __('cart.bill_id_not_exist'));
            Response::redirect_back('admin/cart/list', 'refresh');
        }

        if ($order->delete()) {

            $bill_id = $this->create_bill_id($order_id);

            Session::set_flash('success', __('cart.delete_success', array('bill_id' => $bill_id)));
            Response::redirect_back('admin/cart/list', 'refresh');
        } else {
            Session::set_flash('error', __('common.system_error'));
            Response::redirect_back('admin/cart/list', 'refresh');
        }
    }

    /**
     * Update order status
     *
     * @param type $order_id
     *
     * @access public
     * @author Dao Anh Minh
     */
    public function action_delivered($order_id)
    {
        $order = Model_Order::query()
                ->where('id', $order_id)
                ->get_one();

        if (count($order) <= 0) {
            Session::set_flash('error', __('cart.bill_id_not_exist'));
            Response::redirect_back('admin/cart/list', 'refresh');
        }

        if ($order->set('status', true)->save()) {

            $bill_id = $this->create_bill_id($order_id);

            Session::set_flash('success', __('cart.finish', array('bill_id'=>$bill_id)));
            Response::redirect_back('admin/cart/list', 'refresh');
        } else {
            Session::set_flash('error', __('common.system_error'));
            Response::redirect_back('admin/cart/list', 'refresh');
        }
    }

    /**
     * View detail product of order
     *
     * @param integer $order_id
     *
     * @access public
     * @author Dao Anh Minh
     */
    public function action_detail($order_id)
    {
        $view = View::forge('admin/cart/detail');

        $view->order = Model_Order::query()
                ->where('id', $order_id)
                ->get_one();

        if (count($view->order) <= 0) {
            Session::set_flash('error', __('cart.bill_id_not_exist'));
            Response::redirect_back('admin/cart/list', 'refresh');
        }
        
        $view->order->bill_id    = $this->create_bill_id($order_id);
        $this->template->title   = __('cart.cart_detail');
        $this->template->content = $view;
    }
}
