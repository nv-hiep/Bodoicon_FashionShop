<?php

/**
 * /accgroup.php
 *
 * @copyright Copyright (C) 2015 X-TRANS inc.
 * @author Nguyen Van Hiep
 * @package som
 * @since Jul 14, 2015
 * @version $Id$
 * @license X-TRANS Develop License 1.0
 */

/**
 * Admin_Accgroup
 *
 * <pre>
 * </pre>
 *
 * @copyright Copyright (C) 2014 X-TRANS inc.
 * @author Dao Anh Minh
 * @package tmd
 * @since Nov 6, 2014
 * @version $Id$
 * @license X-TRANS Develop License 1.0
 */
class Controller_Admin_Accgroup extends Controller_Admin_Base
{

    /**
     * Display
     *
     * @param integer
     *
     * @access public
     * @author
     *
     * @version 1.0
     * @since 1.0
     */
    public function action_index()
    {
        $view                    = View::forge('admin/accgroup/index');
        $view->groups            = Model_Accgroup::get_groups();
        $this->template->title   = 'Account Groups';
        $this->template->content = $view;
    }

    /**
     * Add permission
     *
     * @author Nguyen Van Hiep
     * @access public
     */
    public function action_register()
    {
        $view        = View::forge('admin/accgroup/register');
        $view->error = array();

        if (Input::method() == 'POST') {
            $group              = Model_Accgroup::forge();
            $group->name        = Input::post('name');

            $group->user_id     = 0;
            $group->created_at  = date('Y-m-d h:i:s', time());
            $group->updated_at  = date('Y-m-d h:i:s', time());
            $val                = Model_Accgroup::validate('add', $group);
            if ($val->run()) {
                if ($group->save()) {
                    $this->add_auth($group->id);
                    Session::set_flash('cache', 'del');
                    Session::set_flash('success', __('message.accgroup_added'));
                    Response::redirect('admin/accgroup/');
                } else { //fail in transaction
                    Session::set_flash('error', __('message.cannot_add_accgroup'));
                }
            } else {//validate error
                Session::set_flash('error', __('message.validation_error'));
                $view->error = $val->error_message();
            }
        }

        $view->auths             = Model_Role::get_all_roles();
        $this->template->title   = 'Add Account Group';
        $this->template->content = $view;
    }

    /**
     * Edit permission
     *
     * @param integer $id Account-Group ID
     *
     * @author Nguyen Van Hiep
     * @access public
     */
    public function action_edit($id = null)
    {
        $group = Model_Accgroup::get_group_by_id($id);
        if (!$group) {
            Session::set_flash('error', __('message.accgroup_not_exists'));
            Response::redirect('admin/accgroup');
        }

        $view        = View::forge('admin/accgroup/edit');
        $view->group = $group;
        $view->error = array();

        if (Input::method() == 'POST') {
            $group->name        = Input::post('name');
            $group->user_id     = 0;
            $group->updated_at  = date('Y-m-d h:i:s', time());
            $val = Model_Accgroup::validate('edit', $group);
            if ($val->run()) {
                $group->auth = null;
                if ($group->save()) {
                    $this->add_auth($id, true);
                    Session::set_flash('cache', 'del');
                    Session::set_flash('success', __('message.accgroup_edited'));
                    Response::redirect('admin/accgroup');
                } else { //fail in transaction
                    Session::set_flash('error', __('message.cannot_edit_accgroup'));
                }
            } else {//validate error
                Session::set_flash('error', __('message.validation_error'));
                $view->error = $val->error_message();
            }
        }
        $view->auths             = Model_Role::get_all_roles();
        $this->template->title   = 'Edit Authority';
        $this->template->content = $view;
    }

    /**
     * Add permission
     *
     * @param $id string delete
     *
     * @author Nguyen Van Hiep
     * @access public
     */
    public function action_delete($id = null)
    {
        $group = Model_Accgroup::find($id);
        if (!$group) {
            Session::set_flash('error', __('message.accgroup_not_exists'));
            Response::redirect('admin/accgroup');
        }

        if ($group->delete()) {
            Session::set_flash('success', __('message.accgroup_deleted'));
            Response::redirect('admin/accgroup');
        } else {
            Session::set_flash('error', __('message.cannot_del_accgroup'));
        }
    }

    /**
     * Create Authority
     *
     * @param integer $group_id group id
     * @param boolean $edit remove old groups when edit
     * @return void
     *
     * @access protected
     * @since 1.0
     * @version 1.0
     * @author Bui Huu Phuc
     */
    protected function add_auth($group_id, $edit = false)
    {
        if ($edit) {
            //remove all account authority
            Model_GroupRole::query()->where('group_id', $group_id)->delete();
        }
        $auths = !empty(Input::post('auth')) ? Input::post('auth') : array();
        //save authority
        foreach ($auths as $auth) {
            Model_GroupRole::forge(array(
                'group_id' => $group_id,
                'role_id'  => $auth
            ))->save();
        }

        //delete author cache
        //Cache::delete(\Config::get('ormauth.cache_prefix', 'auth') . '.permissions.user_' . $group_id);
    }
}
