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
class Model_GroupRole extends \Orm\Model
{
    protected static $_table_name ='account_group_roles';
    protected static $_primary_key = array('group_id', 'role_id');
    protected static $_properties = array(
        'group_id',
        'role_id'
    );

    /**
     * Check if user has adminstrator auth
     *
     * @param integer $user_id user ID
     * @return boolean true|false
     *
     * @since 1.0
     * @version 1.0
     * @access public
     * @author Nguyen Van Hiep
     */
    public static function abc($user_id)
    {

    }
}
