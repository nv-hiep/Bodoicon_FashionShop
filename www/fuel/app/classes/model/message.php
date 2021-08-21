<?php
/**
 * /role.php
 *
 * @copyright Copyright (C) 2014 X-TRANS inc.
 * @author Bui Huu Phuc
 * @package tmd
 * @since Nov 14, 2014
 * @version $Id$
 * @license X-TRANS Develop License 1.0
 */

/**
 * Role
 *
 * <pre>
 * </pre>
 *
 * @copyright Copyright (C) 2014 X-TRANS inc.
 * @author Bui Huu Phuc
 * @package tmd
 * @since Nov 14, 2014
 * @version $Id$
 * @license X-TRANS Develop License 1.0
 */
class Model_Message extends \Orm\Model
{

    protected static $_properties = array(
        'name',
        'email',
        'phone',
        'subject',
        'content'
    );

    /*
     * Validate for Form input
     *
     * @access public
     * @param  String $name model validate
     * @param object $obj model check validate
     * @return Form validate
     *
     * @access public
     * @author Nguyen Van Hiep
     */
    public static function validate($name)
    {
        $val = Validation::forge($name);
        $val->add_field('name', __('common.name'), 'required');
        $val->add_field('email', __('common.email'), 'required|valid_email');
        $val->add_field('phone', __('account.phone'), 'required');
        $val->add_field('subject', __('common.subject'), 'required');
        $val->add_field('content', __('common.mess'), 'required');
        return $val;
    }

}
