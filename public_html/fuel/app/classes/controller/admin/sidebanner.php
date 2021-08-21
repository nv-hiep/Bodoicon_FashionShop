<?php

/**
 * /sidebanner.php
 *
 * @copyright Copyright (C) 2015 X-TRANS inc.
 * @author Nguyen Van Hiep
 * @package som
 * @since Sep 5, 2015
 * @version $Id$
 * @license X-TRANS Develop License 1.0
 */
class Controller_Admin_Sidebanner extends Controller_Admin_Base
{

    /**
     * Display all images of slider
     *
     * @access public
     * @author Nguyen Van Hiep
     *
     * @version 1.0
     * @since 1.0
     */
    public function action_index()
    {
        $view       = View::forge('admin/slider/index');
        $view->imgs = Model_Slider::get_all_imgs();

        $this->template->title   = __('slider.slider');
        $this->template->content = $view;
    }

    /**
     * Upload CSV
     *
     * @param string $img img name
     * @param string $ext img extension
     *
     * @author Nguyen Van Hiep
     * @access public
     */
    public function action_upload($img = null, $ext = null)
    {
        $view = View::forge('account/upfile');
        $pth  = DOCROOT.'files/';
        $view->data = array();

        // Delete file
        if (!is_null($img) and !is_null($ext)) {
            $name     = $img.'.'.$ext;
            $filename = $pth.$name;
            if (file_exists($filename)) {
                unlink($filename) ? Session::set_flash('success', "Deleted file $name") :
                Session::set_flash('error', "Cannot delete file $name");
                Response::redirect('account/upload');
            } else {
                Session::set_flash('error', "The file $name does not exist");
                Response::redirect('account/upload');
            }
        }

        if (Input::method() == 'POST') {
            if (Input::post('gallery') == 'gallery') {
                $this->template  = \View::forge('template_photo');
                $this->addCss('gallery.css');
                $this->addJs('gallery.js');
                $view = View::forge('account/gallery');

                $photos = scandir(DOCROOT.'gallery/');
                if(is_array($photos)) {
                    unset($photos[0]);
                    unset($photos[1]);
                }

                $view->photos = $photos;
                $this->template->title   = 'Gallery';
                $this->template->content = $view;
            }

            // Custom configuration for this upload
            $config = array(
                'path'          => DOCROOT.'files',
                'randomize'     => false,
                'ext_whitelist' => array('csv','img', 'jpg', 'jpeg', 'gif', 'png'),
                'max_size'      => 1024000000,
                'auto_rename'   => false,
                'overwrite'     => true,
                'prefix'        => 'tmd_'
            );

            Upload::process($config);

            if (Upload::is_valid()) {
                Upload::save();
                $info = Upload::get_files(0);

                if ($info['extension'] == 'csv') {
                    $csv_data = array();
                    $handle = fopen(DOCROOT.'files\\' . $info['saved_as'], "r");
                    while (($file_data = fgetcsv($handle)) !== false) {
                        mb_convert_variables('UTF-8', 'SJIS-win', $file_data);
                        $csv_data[] = $file_data;
                    }
                    fclose($handle);
                    //$csv_data = $this->build_csv_data($csv_data);
                    $view->data = $csv_data;
                } else {
                    $filepath=$info['saved_to'].$info['saved_as'];
                    $image=Image::load($filepath);
                    $image->crop_resize(200, 200)
                          ->watermark($pth.'wtm.png', "center middle")
                          ->save($filepath);
                }
                Session::set_flash('success', 'OK! Uploaded');
            } else {
                $err = Upload::get_errors()[0]['errors'][0];
                $view->err = $err['message'];
            }
        }

        $files = scandir($pth);
        if(is_array($files)) {
            unset($files[0]);
            unset($files[1]);
        }

        $view->imgs = $files;
        $this->template->title   = 'Upload CSV file';
        $this->template->content = $view;
    }

    /**
     * Edit Authority
     *
     * @param void
     *
     * @author Nguyen Van Hiep
     * @access public
     */
    public function action_edit($id = null)
    {
        $auth = Model_Role::find($id);
        if (!$auth) {
            Session::set_flash('error', __('message.auth_not_exists'));
            Response::redirect('admin/roles');
        }

        if ($auth and ( $id <= 2)) {
            Session::set_flash('error', __('message.cannot_edit_auth'));
            Response::redirect('admin/roles');
        }

        $view        = View::forge('admin/roles/edit');
        $view->auth  = $auth;
        $view->error = array();

        if (Input::method() == 'POST') {
            $val = Model_Role::validate('edit', $auth);
            if ($val->run()) {
                $auth->name = Input::post('auth');
                if ($auth->save()) {
                    Session::set_flash('success', __('message.edited_auth'));
                    Response::redirect('admin/roles');
                } else { //fail in transaction
                    Session::set_flash('error', __('message.cannot_edit_auth'));
                }
            } else {//validate error
                Session::set_flash('error', __('message.validation_error'));
                $view->error = $val->error_message();
            }
        }
        $this->template->title   = 'Edit Authority';
        $this->template->content = $view;
    }

    /**
     * Delete Authority
     *
     * @param void
     *
     * @author Nguyen Van Hiep
     * @access public
     */
    public function action_delete($id = null)
    {
        $auth = Model_Role::find($id);
        if (!$auth) {
            Session::set_flash('error', __('message.auth_not_exists'));
            Response::redirect('admin/roles');
        }

        $auth_used = Model_Role::is_auth_used($id);
        if (($id <= 2) or ( $auth_used)) {
            Session::set_flash('error', __('message.cannot_del_auth'));
            Response::redirect('admin/roles');
        }

        if ($auth->delete()) {
            Session::set_flash('success', __('message.auth_deleted'));
            Response::redirect('admin/roles');
        } else {
            Session::set_flash('error', __('message.cannot_del_auth'));
        }
    }
}