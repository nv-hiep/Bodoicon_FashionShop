<?php

/**
 * /home.php
 *
 * @copyright Copyright (C) 2015 X-TRANS inc.
 * @author Dao Anh Minh
 * @package Haki_Shop
 * @since Sep 11, 2015
 * @version $Id$
 * @license X-TRANS Develop License 1.0
 */

/**
 * Home
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
class Controller_Home extends Controller_Base
{

    /**
     * Display home index page
     *
     * @access public
     * @author Nguyen Van Hiep
     *
     * @version 1.0
     * @since 1.0
     */
    public function action_index()
    {
        $view           = View::forge('customer/home/home');
        $view->sliders  = Model_Slider::get_active_banners();
        $view->side_sld = Model_Sideslider::get_active_side_banners();
        $view->side_ads = Model_Ads::get_active_side_ads();
        $view->new_prds = Model_Product::get_new_prods();
        $view->ft_prds  = Model_Product::get_ft_prods();

        $this->template->title   = __('common.home');
        $this->template->content = $view;
    }

    /**
     * Display contact page
     *
     * @access public
     * @author Nguyen Van Hiep
     *
     * @version 1.0
     * @since 1.0
     */
    public function action_contact()
    {
        $view      = View::forge('customer/home/contact');
        $view->err = array();

        if (Input::method() == 'POST') {
            //$m->name = Input::post('auth');
            $val = Model_Message::validate('add');
            if ($val->run()) {
                if ($this->send_mail(Input::post())) {
                    Session::set_flash('success', 'Phản hồi đã gửi thành công');
                } else { //fail in transaction
                    Session::set_flash('error', 'Phản hồi không gửi được. Vui lòng thao tác lại!');
                }
            } else {//validate error
                Session::set_flash('error', __('message.validation_error'));
                $view->err = $val->error_message();
            }
        }

        $this->template->title   = __('common.contact');
        $this->template->content = $view;
    }

    /**
     * Display contact page
     *
     * @access public
     * @author Nguyen Van Hiep
     *
     * @version 1.0
     * @since 1.0
     */
    public function action_about()
    {
        $view      = View::forge('customer/home/about');
        $view->err = array();

        $this->template->title   = __('common.about');
        $this->template->content = $view;
    }
    
    /**
     * Display contact page
     *
     * @access public
     * @author Nguyen Van Hiep
     *
     * @version 1.0
     * @since 1.0
     */
    public function action_order()
    {
        $view      = View::forge('customer/home/order');

        $this->template->title   = __('common.method_order');
        $this->template->content = $view;
    }
    
    /**
     * Display contact page
     *
     * @access public
     * @author Nguyen Van Hiep
     *
     * @version 1.0
     * @since 1.0
     */
    public function action_payment()
    {
        $view      = View::forge('customer/home/payment');

        $this->template->title   = __('common.method_payment');
        $this->template->content = $view;
    }
    
    /**
     * Display contact page
     *
     * @access public
     * @author Nguyen Van Hiep
     *
     * @version 1.0
     * @since 1.0
     */
    public function action_change()
    {
        $view      = View::forge('customer/home/change');

        $this->template->title   = __('common.method_change');
        $this->template->content = $view;
    }

    /**
     * Send feedback to admin
     *
     * params array $post feedback infos
     * 
     * @access private
     * @author Nguyen Van Hiep
     *
     * @version 1.0
     * @since 1.0
     */
    private function send_mail($posts)
    {
        Config::load('email_address', 'mail');

        // Create an instance
        $email = Email::forge();

        // Set the from address"
        $email->from(Config::get('mail.from'), "Khách hàng {$posts['name']}");

        // Set the to address
        $email->to(Config::get('mail.to'));

        // Set a subject
        $email->subject("Thông tin liên hệ / Phản hồi: {$posts['subject']}");




        // And set the body.
        $mail_tempate          = \View::forge('customer/home/feedback_template');
        $mail_tempate->info    = $posts;


        $email->html_body($mail_tempate, true, false);

        try {
            return $email->send();
        } catch (\EmailValidationFailedException $e) {
            // The validation failed
            return false;
        } catch (\EmailSendingFailedException $e) {
            // The driver could not send the email
            return false;
        }
    }

}
