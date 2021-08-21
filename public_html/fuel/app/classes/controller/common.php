<?php

/**
 * /common.php
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
class Controller_Common extends Fuel\Core\Controller_Template
{

    public function before()
    {
        parent::before();
    }

    /**
     * add more neccessary css file to use
     *
     * @param string $file name of css file
     *
     * @access public
     * @author Dao Anh Minh
     */
    protected function addCss($file)
    {
        Asset::css($file, array(), 'css', false);
    }

    /**
     * add more neccessary js file to use
     *
     * @param string $file name of js file
     *
     * @access public
     * @author Dao Anh Minh
     */
    protected function addJs($file)
    {
        Asset::js($file, array(), 'js', false);
    }

    /**
     * Get controller name
     *
     * @return string controller name
     */
    protected function get_controller_name()
    {
        return strtolower(substr(Request::active()->controller, 11));
    }

    /**
     * Get action name
     *
     * @return string action name
     */
    protected function get_action_name()
    {
        return Request::active()->action;
    }
    
    /**
     * Check permission
     * 
     * @param string $area
     * @param string $controller
     * @param string $action
     * @return boolean true|false
     * 
     * @access protected
     * @author Dao Anh Minh
     */
    protected function check_permisstion($area, $controller, $action)
    {
        if (Auth\Auth::instance()->has_access("{$area}.{$controller}.[{$action}]")) {
            return true;
        } else {
            return false;
        }
    }

}
