<?php

/**
 * /sideslide.php
 *
 * @author Nguyen Van Hiep
 * @package HakiShop
 * @since Sep 6, 2015
 * @version $Id$
 * @license X-TRANS Develop License 1.0
 */
class Controller_Admin_Ads extends Controller_Admin_Base
{

    /**
     * Display all images of Ads
     *
     * @access public
     * @author Nguyen Van Hiep
     *
     * @version 1.0
     * @since 1.0
     */
    public function action_index()
    {
        $view       = View::forge('admin/ads/index');
        $view->imgs = Model_Ads::get_all_imgs();

        $this->template->title   = __('ads.ads_banner');
        $this->template->content = $view;
    }

    /**
     * Upload ads banner
     *
     * @author Nguyen Van Hiep
     * @access public
     *
     * @version 1.0
     * @since 1.0
     */
    public function action_upload()
    {
        $view      = View::forge('admin/ads/upload');
        $view->err = array();

        if (Input::method() == 'POST') {
            // Custom configuration for this upload
            $config = array(
                'path'          => DOCROOT . 'assets/img/ads_img',
                'randomize'     => false,
                'ext_whitelist' => array('jpg', 'jpeg', 'gif', 'png'),
                'max_size'      => MAX_IMG_SIZE,
                'auto_rename'   => true,
                'overwrite'     => false,
                'prefix'        => ''
            );

            Upload::process($config);

            if (Upload::is_valid()) {
                Upload::save();
                $info     = Upload::get_files(0);
                $filepath = $info['saved_to'] . $info['saved_as'];
                $image    = Image::load($filepath);
                $image->crop_resize(230, 304)
                        //->watermark($pth.'wtm.png', "center middle")
                        ->save($filepath);

                $img               = Model_Ads::forge();
                $img->image_name   = $info['saved_as'];
                $img->link         = Input::post('link');
                $img->display_flag = true;

                //save account
                if ($img->save()) {
                    //redirect to index page
                    Session::set_flash('success', __('message.ads_uploaded'));
                    Response::redirect('admin/ads');
                } else { //fail in transaction
                    Session::set_flash('error', __('message.registration_failed'));
                }
            } else {
                $err              = Upload::get_errors()[0]['errors'][0];
                $view->err['img'] = $err['message'];
            }
        }

        $this->template->title   = __('ads.upload');
        $this->template->content = $view;
    }

    /**
     * Edit Ads Image
     *
     * @param int $id Image ID
     *
     * @author Nguyen Van Hiep
     * @access public
     *
     * @version 1.0
     * @since 1.0
     */
    public function action_edit($id = null)
    {
        $img = Model_Ads::find($id);
        if (!$img) {
            Session::set_flash('error', __('message.img_not_exists'));
            Response::redirect('admin/ads');
        }

        $view      = View::forge('admin/ads/edit');
        $view->img = $img;
        $view->err = array();

        if (Input::method() == 'POST') {
            $file = Input::file('img');
            if (strlen($file['name']) > 0) {
                // Custom configuration for this upload
                $config = array(
                    'path'          => DOCROOT . 'assets/img/ads_img',
                    'randomize'     => false,
                    'ext_whitelist' => array('jpg', 'jpeg', 'gif', 'png'),
                    'max_size'      => MAX_IMG_SIZE,
                    'auto_rename'   => true,
                    'overwrite'     => false,
                    'prefix'        => ''
                );

                Upload::process($config);

                if (Upload::is_valid()) {
                    File::delete(DOCROOT . 'assets/img/ads_img/' . $img->image_name);
                    Upload::save();
                    $info     = Upload::get_files(0);
                    $filepath = $info['saved_to'] . $info['saved_as'];
                    $image    = Image::load($filepath);
                    $image->crop_resize(230, 304)
                            //->watermark($pth.'wtm.png', "center middle")
                            ->save($filepath);

                    $img->image_name   = $info['saved_as'];
                    $img->link         = Input::post('link');
                    $img->display_flag = Input::post('display');

                    //save account
                    if ($img->save()) {
                        //redirect to index page
                        Session::set_flash('success', __('message.ads_edited'));
                        Response::redirect('admin/ads');
                    } else { //fail in transaction
                        Session::set_flash('error', __('message.registration_failed'));
                    }
                } else {
                    $err              = Upload::get_errors()[0]['errors'][0];
                    $view->err['img'] = $err['message'];
                }
            } else {
                $img->link         = Input::post('link');
                $img->display_flag = Input::post('display');

                //save account
                if ($img->save()) {
                    //redirect to index page
                    Session::set_flash('success', __('message.ads_edited'));
                    Response::redirect('admin/ads');
                } else { //fail in transaction
                    Session::set_flash('error', __('message.registration_failed'));
                }
            }
        }

        $this->template->title   = __('ads.edit');
        $this->template->content = $view;
    }

    /**
     * Delete Ads Image
     *
     * @param int $id Image ID
     *
     * @author Nguyen Van Hiep
     * @access public
     *
     * @version 1.0
     * @since 1.0
     */
    public function action_delete($id = null)
    {
        $img = Model_Ads::find($id);
        if (!$img) {
            Session::set_flash('error', __('message.img_not_exists'));
            Response::redirect('admin/ads');
        }

        $dir = DOCROOT . 'assets/img/ads_img/';
        if ($img->delete()) {
            // Delete file
            $name     = $img->image_name;
            $filename = $dir . $name;
            if (file_exists($filename)) {
                unlink($filename) ? Session::set_flash('success', __('message.file_deleted')) :
                                Session::set_flash('error', __('message.cannot_delete_file'));
                Response::redirect('admin/ads');
            } else {
                Session::set_flash('error', __('message.img_not_exists'));
                Response::redirect('admin/ads');
            }
        } else {
            Session::set_flash('error', __('message.cannot_del_img'));
        }
    }

    /**
     * Ajax: Change display_flag of Ads Image
     *
     * @param void
     *
     * @author Nguyen Van Hiep
     * @access public
     *
     * @version 1.0
     * @since 1.0
     */
    public function action_ajaxflag()
    {
        $id                = Input::post('id');
        $flag              = Input::post('flag');
        $flag              = !$flag;
        $img               = Model_Ads::find($id);
        $img->display_flag = $flag;

        //save
        $img->save();
    }

}
