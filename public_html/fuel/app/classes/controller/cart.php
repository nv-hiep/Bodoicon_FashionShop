<?php

/**
 * /cart.php
 *
 * @copyright Copyright (C) 2015 X-TRANS inc.
 * @author Dao Anh Minh
 * @package Haki_Shop
 * @since Sep 17, 2015
 * @version $Id$
 * @license X-TRANS Develop License 1.0
 */

/**
 * Controller_Customer_Cart
 *
 * <pre>
 * </pre>
 *
 * @copyright Copyright (C) 2015 X-TRANS inc.
 * @author Dao Anh Minh
 * @package Haki_Shop
 * @since Sep 17, 2015
 * @version $Id$
 * @license X-TRANS Develop License 1.0
 */
class Controller_Cart extends Controller_Base
{
    /**
     * Thêm sản phẩm vào giỏ hàng
     *
     * @return json trả về sản phẩm đã thêm vào giỏ hàng
     *
     * @access public
     * @author Dao Anh Minh
     */
    public function action_add_product_to_cart()
    {
        $product_id     = Input::post('product_id');
        $quantity       = Input::post('quantity');
        $size           = Input::post('size');
        $color          = Input::post('color');
        $image          = Input::post('related_img');

        $current_cart = Session::get('current_cart');

        // khởi tạo session nếu chưa tồn tại
        if (empty($current_cart)) {
            $current_cart = array();
        }

        $product_info = Model_Product::query()
                ->where('id', $product_id)
                ->get_one();

        //Cập nhật sản phẩm nếu đã tồn tại trong session
        if (key_exists($product_id, $current_cart)) {

            // Thêm thông tin theo size, color, quantity
            $add_new_related_flag = true;

            foreach ($current_cart[$product_id]['related_info'] as $related_key => $related_data) {

                // Thông tin về size + color đã có => cập nhật số lượng sản phẩm
                if ($related_data['size'] == $size and $related_data['color'] == $color) {

                    $add_new_related_flag = false;
                    $current_cart[$product_id]['related_info'][$related_key]['quantity'] += $quantity;
                }
            }

            // Thông tin về size + color chưa có => thêm số lượng sản phẩm tương ứng với size + color
            if ($add_new_related_flag) {

                $current_cart[$product_id]['related_info'][] = array(
                    'size'      => !empty($size) ? $size : 'nosize',
                    'color'     => !empty($color) ? $color : 'nocolor',
                    'quantity'  => $quantity
                );
            }

            //image
            if (!empty($image) && empty($current_cart[$product_id]['image'])) {
                $current_cart[$product_id]['image'] = $image;
            }

            //quantity
            $current_cart[$product_id]['quantity'] += $quantity;
            $total =  $current_cart[$product_id]['quantity'] * $current_cart[$product_id]['unit_price'];
            $current_cart[$product_id]['total'] = $total;
            $current_cart[$product_id]['short_total'] = number_format($total.'000', 0, '', '.');

            Session::set('current_cart', $current_cart);

        //Thêm mới sản phẩm vào session nếu sp chưa tồn tại trong session
        } else {

            $price = !empty($product_info->price) ? $product_info->price : $product_info->sale_price;
            $total = $quantity * $price;

            $current_cart[$product_id]  = array(
                'product_name'          => $product_info->product_name,
                'short_cart_product_name'    => Str::truncate($product_info->product_name, 20, '...', false),
                'image'                 => !empty($image) ? $image : '',
                'quantity'              => $quantity,
                'unit_price'            => $price,
                'short_cart_unit_price' => number_format($price.'000', 0, '', '.'),
                'total'                 => $total,
                'related_info'          => array(
                    array(
                        'size'      => !empty($size) ? $size : 'nosize',
                        'color'     => !empty($color) ? $color : 'nocolor',
                        'quantity'  => $quantity
                    )
                )
            );

            Session::set('current_cart', $current_cart);
        }

        return json_encode($current_cart);
    }

    /**
     * Xem giỏ hàng
     *
     * @access public
     * @author Dao Anh Minh
     */
    public function action_view_cart()
    {
        $view = View::forge('customer/cart/view_cart');

        if (Input::method() == 'POST') {

            if (key_exists('delete_quantity', Input::post())) {

                $this->detele_quantity();

            } elseif (key_exists('update_quantity', Input::post())) {

                $this->update_quantity();

            }
        }

        $this->addCss('bootstrap.min.css');
        $this->addJs('bootstrap.min.js');
        $this->template->title      = __('cart.title');
        $view->current_cart         = Session::get('current_cart');
        $this->template->content    = $view;
    }

    /**
     * Cập nhật số lượng sản phẩm trong giỏ hàng
     *
     * @access private
     * @author Dao Anh Minh
     */
    private function update_quantity()
    {

        list($product_id, $size, $color) = explode('_', Input::post('update_quantity'));

        $current_cart = Session::get('current_cart');

        $validate = Validation::forge('update_quantity');
        $validate->add("quantity.{$product_id}.{$size}.{$color}", __('cart.prod_quantity'))
                ->add_rule('required')
                ->add_rule('quantity');

        if ($validate->run()) {

            foreach ($current_cart[$product_id]['related_info'] as $related_key => $realted_data) {

                $new_quantity = Input::post('quantity')[$product_id][$size][$color];

                if ($realted_data['size'] == $size and $realted_data['color'] == $color) {

                    // Lấy tổng số lượng trừ bớt đi số lượng cũ
                    $current_cart[$product_id]['quantity'] -= $realted_data['quantity'];

                    // Lấy tổng số lượng cộng số lượng mới vào
                    $current_cart[$product_id]['quantity'] += $new_quantity;

                    // Cập nhật số lượng mới dựa theo size và màu
                    $current_cart[$product_id]['related_info'][$related_key]['quantity'] = $new_quantity;
                }
            }

            $total                                      =  $current_cart[$product_id]['quantity'] * $current_cart[$product_id]['unit_price'];
            $current_cart[$product_id]['total']         = $total;
            $current_cart[$product_id]['short_total']   = number_format($total.'000', 0, '', '.');

            Session::set('current_cart', $current_cart);

        } else {
            Session::set_flash('error', __('cart.limit'));
        }
    }

    /**
     * Xóa bớt sản phẩm trong giỏ hàng
     *
     * @access private
     * @author Dao Anh Minh
     */
    private function detele_quantity()
    {
        list($product_id, $size, $color) = explode('_', Input::post('delete_quantity'));

        $current_cart = Session::get('current_cart');

        foreach ($current_cart[$product_id]['related_info'] as $related_key => $related_data) {
            if ($related_data['size'] == $size and $related_data['color'] == $color) {
                unset($current_cart[$product_id]['related_info'][$related_key]);
                $current_cart[$product_id]['quantity'] -= Input::post('quantity')[$product_id][$size][$color];
            }
        }

        if ($current_cart[$product_id]['quantity'] <= 0) {
            unset($current_cart[$product_id]);
        }

        Session::set('current_cart', $current_cart);
    }

    /**
     * Checkout
     *
     * @access public
     * @author Dao Anh Minh
     */
    public function action_checkout()
    {

        $current_cart = Session::get('current_cart');

        if (empty($current_cart)) {
            Session::set_flash('error', __('cart.no_product'));
            Response::redirect('cart/view_cart');
        }

        $view = View::forge('customer/cart/checkout');

        $view->customer = array(
            'username'  => null,
            'fullname'  => '',
            'phone'     => '',
            'address'   => '',
            'note'      => ''
        );

        // Nếu khách hàng đăng nhập rồi thì lấy thông tin của khách hàng làm thông tin mua hàng
        if (Auth::instance()->check()) {

            $account = Model_Account::query()
                    ->where('username', Auth::instance()->get_screen_name())
                    ->get_one();

            $view->customer = array(
                'username'  => $account->username,
                'fullname'  => $account->fullname,
                'phone'     => $account->phone,
                'address'   => $account->address,
                'note'      => ''
            );
        }

        $view->err = array();

        $validate = Model_Order::validate();

        if (Input::method() == 'POST') {

            if (!Auth::instance()->check()) {
                $view->customer['fullname'] = Input::post('fullname');
                $view->customer['phone']    = Input::post('phone');
                $view->customer['address']  = Input::post('address');
                $view->customer['note']     = Input::post('note');
            } else {
                $view->customer['note']     = Input::post('note');
            }

            if ($validate->run($view->customer)){

                // create new order
                $order_create = $this->create_new_order($view->customer);

                if ($order_create !== false) {

                    // Delete cart
                    //Session::delete('current_cart');

                    // display finish order page
                    $finish_page                = View::forge('customer/cart/finish');
                    $finish_page->product       = $current_cart;
                    $finish_page->customer      = $view->customer;
                    $finish_page->bill_id       = $this->create_bill_id($order_create->id);

                    // send mail to admin
                    $this->send_mail($finish_page->product, $finish_page->customer, $finish_page->bill_id);

                    // display finish page
                    $this->template->content    = $finish_page;
                    return;

                } else {

                    Session::set_flash('error', __('common.system_error'));
                    $view->customer = Input::post();
                }

            } else {
                Session::set_flash('error', __('common.validate_error'));
                $view->err = $validate->error_message();
            }
        }

        $view->product = $current_cart;
        $this->template->title = __('cart.checkout_title');
        $this->template->content = $view;
    }

    /**
     * Gửi mail cho người quản trị khi có đơn đặt hàng mới
     *
     * @param array $product
     * @param array $customer
     * @param string $bill_id
     * @return boolean
     *
     * @access private
     * @author Dao Anh Minh
     */
    private function send_mail($product, $customer, $bill_id)
    {
        Config::load('email_address', 'mail');

        // Create an instance
        $email = Email::forge();

        // Set the from address"
        $email->from(Config::get('mail.from'), __('cart.order')." - {$bill_id}");

        // Set the to address
        $email->to(Config::get('mail.to'));

        // Set a subject
        $email->subject("{$customer['fullname']}: {$customer['phone']}");

        // And set the body.
        $mail_tempate = \View::forge('customer/cart/mail_template');
        $mail_tempate->customer = $customer;
        $mail_tempate->product  = $product;
        $mail_tempate->bill_id  = $bill_id;


        $email->html_body($mail_tempate, true, false);

        try
        {
            return $email->send();
        }
        catch(\EmailValidationFailedException $e)
        {
            // The validation failed
            return false;
        }
        catch(\EmailSendingFailedException $e)
        {
            // The driver could not send the email
            return false;
        }
    }

    /**
     * Create new order
     *
     * @param array $data customer information
     * @return mixed boolean|\Model_Order model object if ok | false if error on save
     *
     * @access private
     * @author Dao Anh Minh
     */
    private function create_new_order($data)
    {
        $order_obj = new Model_Order();

        $order_obj->username        = $data['username'];
        $order_obj->fullname        = $data['fullname'];
        $order_obj->phone_number    = $data['phone'];
        $order_obj->address         = $data['address'];
        $order_obj->note            = $data['note'];
        $order_obj->status          = false;

        if ($order_obj->save()) {

           if ($this->create_order_product($order_obj)) {
               return $order_obj;
           } else {
               return false;
           }

        } else {
            return false;
        }
    }

    /**
     * Create products belong to new order
     *
     * @param object $order orm object
     * @return boolean
     *
     * @access private
     * @author Dao Anh Minh
     */
    private function create_order_product($order)
    {
        $result = array();

        $current_cart = Session::get('current_cart');

        foreach ($current_cart as $prod) {

            $order_prod = new Model_Orderproduct();

            $order_prod->order_id       = $order->id;
            $order_prod->product_name   = $prod['product_name'];
            $order_prod->quantity       = $prod['quantity'];
            $order_prod->product_price  = $prod['unit_price'];
            $order_prod->related_info   = serialize($prod['related_info']);
            $order_prod->image          = $prod['image'];

            $result[] = $order_prod->save();
        }

        if (in_array(false, $result)) {
            return false;
        } else {
            return true;
        }
    }
}
