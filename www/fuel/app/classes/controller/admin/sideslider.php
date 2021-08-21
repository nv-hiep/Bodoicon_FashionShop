<?php

/**
 * /sideslide.php
 *
 * @author Nguyen Van Hiep
 * @package HakiShop
 * @since Sep 6, 2015
 * @version $Id$
 * @license X -TRANS Develop License 1.0
 */
class Controller_Admin_Sideslider extends Controller_Admin_Base
{

    /**
     * Display all images of side-slider
     *
     * @access public
     * @author Nguyen Van Hiep
     *
     * @version 1.0
     * @since 1.0
     */
    public function action_index()
    {
        $view       = View::forge('admin/side_slider/index');
        $view->imgs = Model_Sideslider::get_all_imgs();

        $this->template->title   = __('slider.sideslider');
        $this->template->content = $view;
    }

    /**
     * Upload slider
     *
     * @author Nguyen Van Hiep
     * @access public
     *
     * @version 1.0
     * @since 1.0
     */
    public function action_upload()
    {
        $view        = View::forge('admin/side_slider/upload');
        $view->err   = array();
        $view->prods = Model_Product::get_exclusive_prods();

        if (Input::method() == 'POST') {
            // Custom configuration for this upload
            $config = array(
                'path'          => DOCROOT . 'assets/img/side_slider',
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
                $image->crop_resize(230, 450)
                        //->watermark($pth.'wtm.png', "center middle")
                        ->save($filepath);

                $img               = Model_Sideslider::forge();
                $img->image_name   = $info['saved_as'];
                $img->product_id   = Input::post('product');
                $img->display_flag = true;

                //save account
                if ($img->save()) {
                    //redirect to index page
                    Session::set_flash('success', __('message.slider_uploaded'));
                    Response::redirect('admin/sideslider');
                } else { //fail in transaction
                    Session::set_flash('error', __('message.registration_failed'));
                }
            } else {
                $err              = Upload::get_errors()[0]['errors'][0];
                $view->err['img'] = $err['message'];
            }
        }

        $this->template->title   = __('slider.side_upload');
        $this->template->content = $view;
    }

    /**
     * Edit Slider Image
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
        $img = Model_Sideslider::find($id);
        if (!$img) {
            Session::set_flash('error', __('message.img_not_exists'));
            Response::redirect('admin/sideslider');
        }

        $view        = View::forge('admin/side_slider/edit');
        $view->img   = $img;
        $view->err   = array();
        $view->prods = Model_Product::get_exclusive_prods();

        if (Input::method() == 'POST') {
            $file = Input::file('img');
            if (strlen($file['name']) > 0) {
                // Custom configuration for this upload
                $config = array(
                    'path'          => DOCROOT . 'assets/img/side_slider',
                    'randomize'     => false,
                    'ext_whitelist' => array('jpg', 'jpeg', 'gif', 'png'),
                    'max_size'      => MAX_IMG_SIZE,
                    'auto_rename'   => false,
                    'overwrite'     => true,
                    'prefix'        => ''
                );

                Upload::process($config);

                if (Upload::is_valid()) {
                    File::delete(DOCROOT . 'assets/img/side_slider/' . $img->image_name);
                    Upload::save();
                    $info     = Upload::get_files(0);
                    $filepath = $info['saved_to'] . $info['saved_as'];
                    $image    = Image::load($filepath);
                    $image->crop_resize(230, 450)
                            //->watermark($pth.'wtm.png', "center middle")
                            ->save($filepath);

                    $img->image_name   = $info['saved_as'];
                    $img->product_id   = Input::post('product');
                    $img->display_flag = Input::post('display');

                    //save account
                    if ($img->save()) {
                        //redirect to index page
                        Session::set_flash('success', __('message.slider_edited'));
                        Response::redirect('admin/sideslider');
                    } else { //fail in transaction
                        Session::set_flash('error', __('message.registration_failed'));
                    }
                } else {
                    $err              = Upload::get_errors()[0]['errors'][0];
                    $view->err['img'] = $err['message'];
                }
            } else {
                $img->product_id   = Input::post('product');
                $img->display_flag = Input::post('display');

                //save account
                if ($img->save()) {
                    //redirect to index page
                    Session::set_flash('success', __('message.slider_edited'));
                    Response::redirect('admin/sideslider');
                } else { //fail in transaction
                    Session::set_flash('error', __('message.registration_failed'));
                }
            }
        }

        $this->template->title   = __('slider.edit');
        $this->template->content = $view;
    }

    /**
     * Delete Slider Image
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
        $img = Model_Sideslider::find($id);
        if (!$img) {
            Session::set_flash('error', __('message.img_not_exists'));
            Response::redirect('admin/sideslider');
        }

        $dir = DOCROOT . 'assets/img/side_slider/';
        if ($img->delete()) {
            // Delete file
            $name     = $img->image_name;
            $filename = $dir . $name;
            if (file_exists($filename)) {
                unlink($filename) ? Session::set_flash('success', __('message.file_deleted')) :
                                Session::set_flash('error', __('message.cannot_delete_file'));
                Response::redirect('admin/sideslider');
            } else {
                Session::set_flash('error', __('message.img_not_exists'));
                Response::redirect('admin/sideslider');
            }
        } else {
            Session::set_flash('error', __('message.cannot_del_img'));
        }
    }

    /**
     * Ajax: Change display_flag of Side-Slider Image
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
        $img               = Model_Sideslider::find($id);
        $img->display_flag = $flag;

        //save
        $img->save();
    }

}
