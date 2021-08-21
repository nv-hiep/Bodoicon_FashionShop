<?php

/**
 * /account.php
 *
 * @copyright Copyright (C) 2015 X-TRANS inc.
 * @author Dao Anh Minh
 * @package H_Shop
 * @since Sep 5, 2015
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
 * @package H_Shop
 * @since Sep 5, 2015
 * @version $Id$
 * @license X-TRANS Develop License 1.0
 */

use Fuel\Core\View;

class Controller_Admin_Account extends Controller_Admin_Base
{

    /**
     * Đăng nhập quản trị hệ thống
     *
     * @access public
     * @author Dao Anh Minh
     */
    public function action_login()
    {

        // if logged in -> go to home page
        if (Auth::check()) {
            Response::redirect('admin');
        }

        $view = View::forge('admin/login');

        if(Input::method() == 'POST') {

            if (Auth::login(Input::post('username'), Input::post('password'))) {
                Response::redirect('admin');
            } else {
                Session::set_flash('error', __('account.login_error'));
            }
        }

        $this->addCss('signin.css');
        return new Response($view);
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
        Response::redirect('admin/account/login');
    }

    /**
     * Display list of account
     *
     * @access public
     * @author Dao Anh Minh
     */
    public function action_index()
    {
        $view = View::forge('admin/account/list');

        $view->accounts = Model_Account::query()
                ->order_by('username', 'ASC')
                ->get();

        $this->template->title   = __('title.account_management');
        $this->template->content = $view;

    }

    /**
     * Register new account
     *
     * @access public
     * @author Dao Anh Minh
     */
    public function action_register()
    {
        $view = View::forge('admin/account/register');

        $view->roles = Model_Role::query()
                ->get();

        $view->err     = array();
        $view->post    = array(
            'username'      => '',
            'password'      => '',
            'fullname'      => '',
            'address'       => '',
            'phone'         => '',
            'roles'         => array()
        );

        if (Input::method() == 'POST') {

            $validate = Model_Account::validate();

            if($validate->run()) {
                $this->register_account();
            } else {
                Session::set_flash('error', __('common.validate_error'));
                $view->post = Input::post();
                $view->err = $validate->error_message();
            }
        }

        $this->template->title   = __('account.add');
        $this->template->content = $view;
    }

    /**
     * Process register new account
     *
     * @access protected
     * @author Dao Anh Minh
     */
    protected function register_account()
    {
        $data = Input::post();

        $account_obj = new Model_Account();

        $account_obj->username      = $data['username'];
        $account_obj->password      = Auth::instance()->hash_password($data['password']);
        $account_obj->email         = Str::random('unique').'@dummy.dummy';
        $account_obj->fullname      = $data['fullname'];
        $account_obj->address       = $data['address'];
        $account_obj->phone         = $data['phone'];

        if ($account_obj->save()) {

            // add roles of user
            foreach ($data['roles'] as $role_id) {
                $role_obj = new Model_AccountRole();
                $role_obj->user_id = $account_obj->id;
                $role_obj->role_id = $role_id;
                $role_obj->save();
            }

            Session::set_flash('success', __('account.success_register'));
            Response::redirect('admin/account/index');
        } else {
            Session::set_flash('error', __('common.system_error'));
            Response::redirect('admin/account/register');
        }
    }

    /**
     * Edit account
     *
     * @param integer $account_id account id
     *
     * @access public
     * @author Dao Anh Minh
     */
    public function action_edit($account_id)
    {
        $view = View::forge('admin/account/edit');

        $account_data = Model_Account::query()
                ->where('id', $account_id)
                ->get_one();

        $account_role = Model_AccountRole::query()
                ->select('role_id')
                ->where('user_id', $account_id)
                ->get();

        $current_role = array();
        foreach ($account_role as $val) {
            $current_role[] = $val->role_id;
        }

        if (empty($account_data) or $account_data['username'] == 'admin') {
            Session::set_flash('error', __('account.account_not_exist'));
            Response::redirect('admin/account');
        }

        $view->err = array();

        $view->post    = array(
            'username'      => $account_data['username'],
            'password'      => '',
            'fullname'      => $account_data['fullname'],
            'address'       => $account_data['address'],
            'phone'         => $account_data['phone'],
            'roles'         => $current_role
        );

        $validate = Model_Account::validate(Model_Account::ACCOUNT_EDIT, $account_data['username']);
        if (Input::method() == 'POST') {

            if ($validate->run()) {
                Model_AccountRole::query()
                        ->where('user_id', $account_id)
                        ->delete();
                $this->edit_account($account_data);
            } else {
                Session::set_flash('error', __('common.validate_error'));
                $view->post = Input::post();
                $view->err = $validate->error_message();
            }
        }

        $view->roles = Model_Role::query()
                ->get();
        $this->template->title   = __('account.edit');
        $this->template->content = $view;
    }

    /**
     * process edit user
     *
     * @param orm object $account
     *
     * @access protected
     * @author Dao Anh Minh
     */
    protected function edit_account($account)
    {
        $data = Input::post();

        $account->username      = $data['username'];
        if (!empty($data['password'])) {
            $account->password      = Auth::instance()->hash_password($data['password']);
        }
        $account->email         = Str::random('unique').'@dummy.dummy';
        $account->fullname      = $data['fullname'];
        $account->address       = $data['address'];
        $account->phone         = $data['phone'];

        if ($account->save()) {
            // add roles of user
            foreach ($data['roles'] as $role_id) {
                $role_obj = new Model_AccountRole();
                $role_obj->user_id = $account->id;
                $role_obj->role_id = $role_id;
                $role_obj->save();
            }

            // xóa cache quyền của user
            \Cache::delete(\Config::get('ormauth.cache_prefix', 'auth').".permissions.user_{$account->id}");

            Session::set_flash('success', __('account.success_edit'));
            Response::redirect('admin/account/index');
        } else {
            Session::set_flash('error', __('common.system_error'));
            Response::redirect('admin/account/register');
        }
    }

    /**
     * Xóa tài khoản
     *
     * @param integer $account_id account id
     *
     * @access public
     * @author Dao Anh Minh
     */
    public function action_delete($account_id)
    {
        $account = Model_Account::query()
                ->where('id', $account_id)
                ->get_one();

        if (empty($account) or $account->username == 'admin') {
            Session::set_flash('error', __('account.account_not_exist'));
            Response::redirect('admin/account');
        }

        if ($account->delete()){
            Session::set_flash('success', __('account.success_delete'));
            Response::redirect('admin/account/index');
        } else {
            Session::set_flash('error', __('common.system_error'));
            Response::redirect('admin/account/register');
        }
    }
}
