<?php

/**
 * /crop.php
 *
 * @author Nguyen Van Hiep
 * @package HakiShop
 * @since Sep 6, 2015
 * @version $Id$
 * @license X-TRANS Develop License 1.0
 */

/**
 * Crop
 *
 * <pre>
 * </pre>
 *
 * @copyright Copyright (C) 2015 X-TRANS inc.
 * @author Huynh Hai Lam
 * @package H_Shop
 * @since Sep 5, 2015
 * @version $Id$
 * @license X-TRANS Develop License 1.0
 */
class Controller_Admin_Crop extends Controller_Admin_Base
{

    /**
     * Resize product-image
     *
     * @param int $id image-ID
     * @param int $pid Product-ID
     *
     * @access public
     * @author Nguyen Van Hiep
     *
     * @version 1.0
     * @since 1.0
     */
    public function action_resize($id = null, $pid = null)
    {
        $this->addJs('img_product.js');

        $p = Model_Product::find($pid);
        if (!$p) {
            Session::set_flash('error', __('message.prod_not_exists'));
            Response::redirect('admin/product');
        }

        $img = Model_ProdImg::find($id);
        if (!$img) {
            Session::set_flash('error', __('message.img_not_exists'));
            Response::redirect('admin/product/edit/' . $pid);
        }

        $dir = DOCROOT . 'assets/img/prod_img/';

        $view         = View::forge('admin/crop/index');
        $view->img    = $img;
        $view->pid    = $pid;
        $view->width  = (int) $this->get_width($dir . $img->image_name);
        $view->height = (int) $this->get_height($dir . $img->image_name);

        $view->rat = ''; // Ratio
        $view->pw  = 0; // preview W
        $view->ph  = 0; // preview H

        if ($img->image_type == THUMBNAIL) {
            $view->rat = '302:275';
            $view->pw  = 302;
            $view->ph  = 275;
        } else {
            $view->rat = '486:362';
            $view->pw  = 486;
            $view->ph  = 362;
        }

        if (Input::method() == 'POST') {
            $x1 = Input::post('x1');
            $y1 = Input::post('y1');
            $x2 = Input::post('x2');
            $y2 = Input::post('y2');
            $w  = Input::post('w');
            $h  = Input::post('h');
            if ($img->image_type == true) {
                $scale = 302 / $w;
            } else {
                $scale = 1;
            }
            $this->resize_img($dir . $img->image_name, $dir . $img->image_name, $w, $h, $x1, $y1, 1.0);
//            if ($img->image_type == NORMAL) {
//                $image = Image::load($dir . $img->image_name);
//                $image->resize(null, 362, true)
//                        ->save($dir . 'thumb' . $img->image_name);
//            }
            Session::set_flash('success', __('message.img_resized'));
            Response::redirect('admin/product/edit/' . $pid);
        }

        $this->template->title   = __('slider.crop');
        $this->template->content = $view;
    }

    /**
     * Resize product-image
     *
     * @param int $id image-ID
     * @param int $pid Product-ID
     *
     * @access public
     * @author Nguyen Van Hiep
     *
     * @version 1.0
     * @since 1.0
     */
    public function action_prepare($id = null, $pid = null)
    {
        $this->addJs('img_preparation.js');

        $up_dir    = DOCROOT . 'assets/img/prepare/temp/';
        $thumb_dir = DOCROOT . 'assets/img/prepare/thumb/';
        $img_dir   = DOCROOT . 'assets/img/prepare/img/';

        $view         = View::forge('admin/crop/imgs');
        $view->err    = array();
        $view->img    = '';
        $view->thumb  = true;
        $view->width  = 0;
        $view->height = 0;
        $view->pw     = 0;
        $view->ph     = 0;
        $view->rat    = '302:275';

        if (Input::post('submit') == 'upload') {
            // Custom configuration for this upload
            $config = array(
                'path'          => $up_dir,
                'randomize'     => false,
                'ext_whitelist' => array('jpg', 'jpeg', 'gif', 'png'),
                'max_size'      => MAX_IMG_SIZE,
                'auto_rename'   => true,
                'overwrite'     => false,
                'prefix'        => ''
            );

            Upload::process($config);

            if (Upload::is_valid()) {
                File::delete_dir($up_dir, true, true);
                Upload::save();
                $info         = Upload::get_files(0);
                $filepath     = $info['saved_to'] . $info['saved_as'];
                $view->img    = $info['saved_as'];
                $view->thumb  = Input::post('type');
                $view->width  = (int) $this->get_width($filepath);
                $view->height = (int) $this->get_height($filepath);
                if ($view->thumb == true) {
                    $view->rat = '302:275';
                    $view->pw  = 302;
                    $view->ph  = 275;
                } else {
                    $view->rat = '486:362';
                    $view->pw  = 486;
                    $view->ph  = 362;
                }

                Session::set_flash('success', __('message.slider_uploaded'));
            } else {
                $err              = Upload::get_errors()[0]['errors'][0];
                $view->err['img'] = $err['message'];
            }
        }

        if (Input::post('submit') == 'save_thumb') {
            $x1  = Input::post('x1');
            $y1  = Input::post('y1');
            $x2  = Input::post('x2');
            $y2  = Input::post('y2');
            $w   = Input::post('w');
            $h   = Input::post('h');
            $img = Input::post('img');
            $typ = Input::post('type');

            if ($typ == true) {
                $dir   = $thumb_dir;
                $scale = 302 / $w;
            } else {
                $dir   = $img_dir;
                $scale = 1;
            }

            $this->resize_img($dir . $img, $up_dir . $img, $w, $h, $x1, $y1, $scale);

            Session::set_flash('success', __('message.img_resized'));
            Response::redirect('admin/crop/prepare');
        }

        $this->template->title   = __('slider.crop');
        $this->template->content = $view;
    }

    /**
     * Download thumbnails of prepared images
     *
     * @access public
     * @author Nguyen Van Hiep
     *
     * @version 1.0
     * @since 1.0
     */
    public function action_thumb()
    {
        $thumb_dir = DOCROOT . 'assets/img/prepare/thumb/';

        $view = View::forge('admin/crop/down_thumb');

        // Read with custom rules
        $view->imgs = File::read_dir($thumb_dir, 0, array(
                    '!^\.', // no hidden files/dirs
        ));

        $this->template->title   = __('slider.crop');
        $this->template->content = $view;
    }

    /**
     * Download thumbnails of prepared images
     *
     * @access public
     * @author Nguyen Van Hiep
     *
     * @version 1.0
     * @since 1.0
     */
    public function action_img()
    {
        $img_dir = DOCROOT . 'assets/img/prepare/img/';

        $view = View::forge('admin/crop/down_img');

        // Read with custom rules
        $view->imgs = File::read_dir($img_dir, 0, array(
                    '!^\.', // no hidden files/dirs
        ));

        $this->template->title   = __('slider.crop');
        $this->template->content = $view;
    }

    /**
     * Download img
     *
     * params string $img name of img
     *
     * @access public
     * @author Nguyen Van Hiep
     *
     * @version 1.0
     * @since 1.0
     */
    public function action_download_img($img = null)
    {
        $img_dir = DOCROOT . 'assets/img/prepare/img/';
        $exists  = File::exists($img_dir . $img);
        if ($exists == false) {
            Session::set_flash('error', __('message.img_not_exists'));
            Response::redirect('admin/crop/img');
        }
        File::download($img_dir . $img);
    }

    /**
     * Delete img
     *
     * params string $img name of img
     *
     * @access public
     * @author Nguyen Van Hiep
     *
     * @version 1.0
     * @since 1.0
     */
    public function action_delete_img($img = null)
    {
        $img_dir = DOCROOT . 'assets/img/prepare/img/';
        $exists  = File::exists($img_dir . $img);
        if ($exists == false) {
            Session::set_flash('error', __('message.img_not_exists'));
            Response::redirect('admin/crop/img');
        }
        if (File::delete($img_dir . $img)) {
            Session::set_flash('success', __('message.img_deleted'));
            Response::redirect('admin/crop/img');
        } else {
            Session::set_flash('error', __('message.cannot_del_img'));
        }
    }

    /**
     * Download thumbnail
     *
     * params string $img name of img
     *
     * @access public
     * @author Nguyen Van Hiep
     *
     * @version 1.0
     * @since 1.0
     */
    public function action_download_thumb($img = null)
    {
        $thumb_dir = DOCROOT . 'assets/img/prepare/thumb/';
        $exists    = File::exists($thumb_dir . $img);
        if ($exists == false) {
            Session::set_flash('error', __('message.img_not_exists'));
            Response::redirect('admin/crop/thumb');
        }
        File::download($thumb_dir . $img);
    }

    /**
     * Delete thumb
     *
     * params string $img name of img
     *
     * @access public
     * @author Nguyen Van Hiep
     *
     * @version 1.0
     * @since 1.0
     */
    public function action_delete_thumb($img = null)
    {
        $thumb_dir = DOCROOT . 'assets/img/prepare/thumb/';
        $exists    = File::exists($thumb_dir . $img);
        if ($exists == false) {
            Session::set_flash('error', __('message.img_not_exists'));
            Response::redirect('admin/crop/thumb');
        }

        if (File::delete($thumb_dir . $img)) {
            Session::set_flash('success', __('message.img_deleted'));
            Response::redirect('admin/crop/thumb');
        } else {
            Session::set_flash('error', __('message.cannot_del_img'));
        }
    }

    /**
     * Get height of image
     *
     * @return int $height image-height in px
     *
     * @access protected
     * @author Nguyen Van Hiep
     *
     * @version 1.0
     * @since 1.0
     */
    protected function get_height($image)
    {
        $size   = getimagesize($image);
        $height = $size[1];
        return $height;
    }

    /**
     * Get width of image
     *
     * @return int $width image-width in px
     *
     * @access protected
     * @author Nguyen Van Hiep
     *
     * @version 1.0
     * @since 1.0
     */
    protected function get_width($image)
    {
        $size  = getimagesize($image);
        $width = $size[0];
        return $width;
    }

    /**
     * Resize of save image
     *
     * @return void
     *
     * @access protected
     * @author Nguyen Van Hiep
     *
     * @version 1.0
     * @since 1.0
     */
    protected function resize_img($img_name, $image, $width, $height, $start_width, $start_height, $scale)
    {
        list($imagewidth, $imageheight, $imagetype) = getimagesize($image);
        $imagetype = image_type_to_mime_type($imagetype);

        $new_width  = ceil($width * $scale);
        $new_height = ceil($height * $scale);
        $new_img    = imagecreatetruecolor($new_width, $new_height);
        switch ($imagetype) {
            case "image/gif":
                $source = imagecreatefromgif($image);
                break;
            case "image/pjpeg":
            case "image/jpeg":
            case "image/jpg":
                $source = imagecreatefromjpeg($image);
                break;
            case "image/png":
            case "image/x-png":
                $source = imagecreatefrompng($image);
                break;
        }
        imagecopyresampled($new_img, $source, 0, 0, $start_width, $start_height, $new_width, $new_height, $width, $height);
        switch ($imagetype) {
            case "image/gif":
                imagegif($new_img, $img_name);
                break;
            case "image/pjpeg":
            case "image/jpeg":
            case "image/jpg":
                imagejpeg($new_img, $img_name, 90);
                break;
            case "image/png":
            case "image/x-png":
                imagepng($new_img, $img_name);
                break;
        }
        chmod($img_name, 0777);
    }

}
