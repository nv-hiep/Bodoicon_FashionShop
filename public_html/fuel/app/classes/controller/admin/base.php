<?php

/**
 * /init.php
 *
 * @copyright Copyright (C) 2015 X-TRANS inc.
 * @author Dao Anh Minh
 * @package H_Shop
 * @since Sep 5, 2015
 * @version $Id$
 * @license X-TRANS Develop License 1.0
 */

/**
 * init
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
class Controller_Admin_Base extends Controller_Common
{

    public $template = 'admin/template';
    public $contr    = array();

    public function before()
    {
        parent::before();

        // kiểm tra quyền
        $this->check_permission();
        //Load language
        Lang::load('language.ini');

        $this->init_css();
        $this->init_js();
    }

    private function init_css()
    {
        $this->addCss('bootstrap.min.css');
        $this->addCss('dashboard.css');
        $this->addCss('bootstrap-multiselect.css');
        $this->addCss('imgareaselect-animated.css');
        $this->addCss('style.css');
    }

    private function init_js()
    {
        $this->addJs('jquery-1.11.1.min.js');
        $this->addJs('jquery-ui.js');
        $this->addJs('bootstrap.min.js');
        $this->addJs('bootstrap-multiselect.js');
        $this->addJs('jquery.imgareaselect.pack.js');
        $this->addJs('functions.js');
    }

    /**
     * Check admin permission
     *
     * @access private
     * @author Dao Anh Minh
     */
    private function check_permission()
    {

        $controller = $this->get_controller_name();
        $action     = $this->get_action_name();

        // nếu action không cần kiểm tra quyền thì bỏ qua
        if ($this->ignore_check_permission($action)) {
            return;
        }

        if (Auth::check()) {

            if ($this->check_permisstion('admin', $controller, $action) == false) {

                // yêu cầu log-in lại nếu không có quyền truy cập
                Response::redirect('/admin/base/access_denied');
            }
        } else {

            // Hiển thị trang login
            Response::redirect('admin/account/login');
        }
    }

    /**
     * Bỏ qua kiểm tra quyền với một vài action
     *
     * @param string $action_name action name
     * @return boolean
     *
     * @access private
     * @author Dao Anh Minh
     */
    private function ignore_check_permission($action_name)
    {
        $ignore = array(
            'login',
            'logout',
            'access_denied'
        );

        return in_array($action_name, $ignore);
    }

    /**
     * display access denied page
     *
     * @access public
     * @author Dao Anh Minh
     */
    public function action_access_denied()
    {
        Auth::instance()->login();
        Session::set_flash('error', 'Cần quyền quản trị để truy cập');

        $view = View::forge('admin/login');

        $this->addCss('signin.css');
        return new Response($view);
    }

    /**
     * Get controllers
     *
     * @return list of controlelrs
     *
     * @author Nguyen Van Hiep
     * @access public
     */
    public function get_controller()
    {
        if (count($this->contr) == 0) {
            $this->set_controller(APPPATH . 'classes/controller/');
        }


        $controllers = array();
        $names       = array();

        foreach ($this->contr as $contr) {
            if (strpos($contr, 'Admin')) {
                if ($contr == 'Controller_Admin_Base') {
                    $actions = get_class_methods($contr);
                } else {
                    $actions = array_diff(get_class_methods($contr), get_class_methods('Controller_Admin_Base'));
                }
            } else {
                if ($contr == 'Controller_Base') {
                    $actions = get_class_methods($contr);
                } else {
                    $actions = array_diff(get_class_methods($contr), get_class_methods('Controller_Base'));
                }
            }

            $contr         = strtolower(str_replace('Controller_', '', $contr));
            $names[$contr] = $contr;
            foreach ($actions as $action) {
                if (preg_match('/^action_/', $action)) {
                    $controllers[$contr][] = str_replace('action_', '', $action);
                }
            }
        }

        foreach ($names as $key => $name) {
            if (!array_key_exists($name, $controllers)) {
                unset($names[$key]);
            }
        }
        $names =  array('' => __('message.select_perm')) + $names;
        return array(
            'controllers' => $controllers,
            'names'       => $names,
        );
    }

    /**
     * Set controllers
     *
     * @param string path
     * @return list of controlelrs
     *
     * @author Nguyen Van Hiep
     * @access protected
     */
    protected function set_controller($path)
    {
        $files  = scandir($path);
        $subdir = str_replace(APPPATH . 'classes/controller/', '', $path);
        $prefix = str_replace(' ', '_', ucfirst(str_replace('/', ' ', $subdir)));

        foreach ($files as $key => $file) {
            if (preg_match('/^\.+/', $file)) {
                unset($files[$key]);
                continue;
            }

            if (preg_match('/\.php$/', $file)) {
                array_push($this->contr, 'Controller_' . $prefix . ucfirst(str_replace('.php', '', $file)));
            } else {
                $path = APPPATH . 'classes/controller/';
                $path = $path . $file . '/';
                $this->set_controller($path);
            }
        }
    }

    /*
     * php delete function that deals with directories recursively
     */

    public static function delete_files($target)
    {
        if (!file_exists($target)) {
            return false;
        }
        if (!is_link($target) && is_dir($target)) {
            // it's a directory; recursively delete everything in it
            $files = array_diff(scandir($target), array('.', '..'));
            foreach ($files as $file) {
                self::delete_files("$target/$file");
            }
            rmdir($target);
        } else {
            // probably a normal file or a symlink; either way, just unlink() it
            unlink($target);
        }
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
