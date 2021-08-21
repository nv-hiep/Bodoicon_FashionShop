<?php

/**
 * /account.php
 *
 * @copyright Copyright (C) 2015 X-TRANS inc.
 * @author Dao Anh Minh
 * @package Haki_Shop
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
 * @package Haki_Shop
 * @since Sep 5, 2015
 * @version $Id$
 * @license X-TRANS Develop License 1.0
 */
class Model_Account extends Orm\Model
{
    const ACCOUNT_REGISTER  = 'register';
    const ACCOUNT_EDIT      = 'edit';


    protected static $_table_name = 'account';
    protected static $_properties = array(
        'id',
        'username',
        'password',
        'fullname',
        'address',
        'phone'
    );

    public static function validate($mode = Model_Account::ACCOUNT_REGISTER, $edit_username = null)
    {
        $val = Validation::forge('register_account');

        // validate when edit account
        switch ($mode) {
            case Model_Account::ACCOUNT_EDIT:
                $val->add('username', __('account.name'))
                    ->add_rule('required')
                    ->add_rule('min_length', ACCOUNT_MIN_LENGHT)
                    ->add_rule('max_length', ACCOUNT_MAX_LENGHT)
                    ->add_rule('username')
                    ->add_rule('unique_username', $edit_username);
                $val->add('password', __('account.title_password'))
                    ->add_rule('min_length', PASSWORD_MIN_LEN)
                    ->add_rule('max_length', PASSWORD_MAX_LEN)
                    ->add_rule('password');
                break;

            // validate when register account
            default:
                $val->add('username', __('account.name'))
                    ->add_rule('required')
                    ->add_rule('min_length', ACCOUNT_MIN_LENGHT)
                    ->add_rule('max_length', ACCOUNT_MAX_LENGHT)
                    ->add_rule('username')
                    ->add_rule('unique_username');
                $val->add('password', __('account.title_password'))
                    ->add_rule('required')
                    ->add_rule('min_length', PASSWORD_MIN_LEN)
                    ->add_rule('max_length', PASSWORD_MAX_LEN)
                    ->add_rule('password');
                break;
        }

        $val->add('fullname', __('account.fullname'))
                ->add_rule('required')
                ->add_rule('max_length', 50);
        $val->add('address', __('account.address'))
                ->add_rule('required')
                ->add_rule('max_length', 200);
        $val->add('phone', __('account.phone'))
                ->add_rule('required')
                ->add_rule('max_length', 15)
                ->add_rule('phone_number');
        $val->add('roles', __('account.title_roles'))
                ->add_rule('required');

        return $val;
    }

    /**
     * Get full name of current logged in user
     *
     * @return string
     *
     * @access public
     * @author Dao Anh Minh
     */
    public static function get_fullname_of_logged_user()
    {
        if (Auth::instance()->check()) {
            $account = Model_Account::query()
                    ->where('username', Auth::instance()->get_screen_name())
                    ->get_one();

            return $account->fullname;
        } else {
            return '';
        }
    }
}
