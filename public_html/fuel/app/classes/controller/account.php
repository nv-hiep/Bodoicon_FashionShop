<?php

/**
 * /account.php
 *
 * @copyright Copyright (C) 2015 X-TRANS inc.
 * @author Dao Anh Minh
 * @package Haki_Shop
 * @since Sep 25, 2015
 * @version $Id$
 * @license X-TRANS Develop License 1.0
 */

/**
 * account
 *
 * <pre>
 * </pre>
 *
 * @copyright Copyright (C) 2015 X-TRANS inc.
 * @author Dao Anh Minh
 * @package Haki_Shop
 * @since Sep 25, 2015
 * @version $Id$
 * @license X-TRANS Develop License 1.0
 */
class Controller_Account extends Controller_Base
{
    /**
     * Register new account
     *
     * @access public
     * @author Dao Anh Minh
     */
    public function action_register()
    {

        $view = View::forge('customer/account/register');

        $user_role = Model_Role::query()
                ->where('name', 'customer')
                ->get_one();

        $view->err     = array();
        $view->post    = array(
            'username'          => '',
            'password'          => '',
            'fullname'          => '',
            'address'           => '',
            'phone'             => '',
            'accept_register'   => '',
            'roles'             => $user_role->id
        );

        if (Input::method() == 'POST') {

            $accept_register = Input::post('accept_register');

            $view->post['username']         = Input::post('username');
            $view->post['password']         = Input::post('password');
            $view->post['fullname']         = Input::post('fullname');
            $view->post['address']          = Input::post('address');
            $view->post['phone']            = Input::post('phone');
            $view->post['phone']            = Input::post('phone');
            $view->post['accept_register']  = Input::post('accept_register');

            $validate = Model_Account::validate();
            $validate->add_field('accept_register', __('account.accept_register'), 'required');

            if($validate->run($view->post)) {
                $this->register_account($view->post);
            } else {
                Session::set_flash('error', __('common.validate_error'));
                $view->err = $validate->error_message();
            }
        }

        $this->template->title   = __('account.add');
        $this->template->content = $view;
    }

    /**
     * Khách hàng đăng nhập
     *
     * @access public
     * @author Dao Anh Minh
     */
    public function action_login()
    {
        // if logged in -> go to home page
        if (Auth::check()) {
            Response::redirect('home');
        }

        $view = View::forge('customer/account/login');

        if(Input::method() == 'POST') {

            if (Auth::login(Input::post('username'), Input::post('password'))) {
                Response::redirect('home');
            } else {
                Session::set_flash('error', __('account.login_error'));
            }
        }

        $this->template->title   = __('account.login_header');
        $this->template->content = $view;
    }

    /**
     * Thoát khỏi hệ thống
     *
     * @access public
     * @author Dao Anh Minh
     */
    public function action_logout()
    {
        Auth::instance()->logout();
        Response::redirect('home');
    }

    /**
     * Process register new account
     *
     * @access private
     * @author Dao Anh Minh
     */
    private function register_account($data)
    {

        $account_obj = new Model_Account();

        $account_obj->username      = $data['username'];
        $account_obj->password      = Auth::instance()->hash_password($data['password']);
        $account_obj->email         = Str::random('unique').'@dummy.dummy';
        $account_obj->fullname      = $data['fullname'];
        $account_obj->address       = $data['address'];
        $account_obj->phone         = $data['phone'];

        if ($account_obj->save()) {

            // add roles of user
            $role_obj = new Model_AccountRole();
            $role_obj->user_id = $account_obj->id;
            $role_obj->role_id = $data['roles'];
            $role_obj->save();

            Session::set_flash('success', __('account.success_register'));
            Auth::instance()->force_login($account_obj->id);
            
            Response::redirect_back();
        } else {
            Session::set_flash('error', __('common.system_error'));
            Response::redirect('account/register');
        }
    }

}
