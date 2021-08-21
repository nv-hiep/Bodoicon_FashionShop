<?php

/**
 * /product.php
 *
 * @author Nguyen Van Hiep
 * @package HakiShop
 * @since Sep 6, 2015
 * @version $Id$
 * @license X-TRANS Develop License 1.0
 */

/**
 * Product
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
class Controller_Admin_Product extends Controller_Admin_Base
{

    // Configuration for upload-images
    private $dir = '';
    // Configuration for upload-images
    private $config = array();

    /**
     * before
     *
     * @access public
     * @author Nguyen Van Hiep
     *
     * @version 1.0
     * @since 1.0
     */
    public function before()
    {
        parent::before();

        $this->dir = DOCROOT . 'assets/img/prod_img/';

        $this->config = array(
            'path'          => $this->dir,
            'randomize'     => false,
            'ext_whitelist' => array('jpg', 'jpeg', 'gif', 'png'),
            'max_size'      => MAX_IMG_SIZE,
            'auto_rename'   => false,
            'overwrite'     => true,
            'prefix'        => ''
        );
    }

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
        $view       = View::forge('admin/product/index');
        $view->cats = Model_Categories::get_cat_list();

        $config = array(
            'pagination_url'  => Uri::base() . 'admin/product/',
            'total_items'     => (int) Model_Product::count(),
            'per_page'        => 30,
            'uri_segment'     => __('common.page').'-',
            'num_links'       => 7,
        );
        $pag    = Pagination::forge('paging', $config);

        $view->prds = Model_Product::get_all_products_with_offset($pag->offset, $pag->per_page);
        $view->pag  = $pag;

        if (Input::method() == 'POST') {
            $view->prds = Model_Product::get_all_products_with_offset($pag->offset, $pag->per_page, Input::post('cate'));
        }

        $this->template->title   = __('prod.prods');
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
    public function action_add()
    {
        $view            = View::forge('admin/product/add');
        $view->err       = array();
        $view->img_count = 1;

        $view->cats = Model_Categories::get_cat_list();

        if (Input::method() == 'POST') {
            if (count(Input::file()) == 0) {
                Session::set_flash('error', __('message.upload_files_error'));
                Response::redirect('admin/product/add');
            }

            $view->img_count = count(Input::post('colour'));

            $p               = Model_Product::forge();
            $p->product_name = Input::post('name');
            $val             = Model_Product::validate('add', $p);

            // Custom configuration for this upload
            Upload::process($this->config);

            if (($val->run()) and ( count(Upload::get_errors()) == 0)) {
                $p->short_description  = Input::post('short_desc');
                $p->detail_description = Input::post('detail');
                $p->price              = Input::post('price');
                $p->sale_price         = Input::post('sale');
                $p->view_number        = 0;
                $p->status             = Input::post('status');
                $p->size               = Input::post('size');
                $p->created_date       = date('Y-m-d h:i:s', time());
                $p->updated_date       = date('Y-m-d h:i:s', time());

                //save account
                if ($p->save()) {
                    // Save Product-Slug
                    $p->slug = Input::post('slug') . '-' . $p->id;
                    $p->save();

                    // Save Product-Category
                    $prodcat = (Input::post('cat')) ? Input::post('cat') : array();
                    Model_ProdCat::save_prod_cat($p->id, $prodcat);

                    //Save images
                    $this->save_imgs($p->id);

                    //redirect to index page
                    Session::set_flash('success', __('message.prod_added'));
                    Response::redirect('admin/product');
                } else { //fail in transaction
                    Session::set_flash('error', __('message.registration_failed'));
                }
            } else {
                $view->err = $val->error_message();
                $err       = $this->upload_errors(Upload::get_errors());
                $view->err = array_merge($view->err, $err);
            }
        }

        $this->template->title   = __('prod.add_new');
        $this->template->content = $view;
    }

    /**
     * Save images
     *
     * params int $id Product-ID
     *
     * @author Nguyen Van Hiep
     * @access public
     *
     * @version 1.0
     * @since 1.0
     */
    protected function save_imgs($id)
    {
        Upload::save();
        foreach (Upload::get_files() as $info) {
            $filepath = $info['saved_to'] . $info['saved_as'];
            $image    = Image::load($filepath);
            $image->save_pa('p' . $id . '_');

            $image->resize(null, 362, true)
                  -> save($this->dir . 'thumbp' . $id . '_' . $info['saved_as']);
            File::delete($filepath);
        }

        $imgs = $this->img_info($id, Input::file());
        Model_ProdImg::save_thumbnail($id, $imgs['thumbnail']);
        Model_ProdImg::save_images($id, $imgs['img_names'], Input::post('colour'));
    }

    /**
     * Get info of uploaded images
     *
     * params int $id Product-ID
     * params array $files Info of uploaded images
     *
     * @author Nguyen Van Hiep
     * @access public
     *
     * @version 1.0
     * @since 1.0
     */
    protected function img_info($id, $files)
    {
        $thumb     = 'p' . $id . '_' . $files['thumbnail']['name'];
        $img_names = $files['img']['name'];
        foreach ($img_names as $key => $name) {
            $img_names[$key] = 'p' . $id . '_' . $name;
        }
        return array(
            'thumbnail' => $thumb,
            'img_names' => $img_names
        );
    }

    /**
     * Errors of uploads
     *
     * params array $err_files Errors of uploading files
     *
     * @author Nguyen Van Hiep
     * @access public
     *
     * @version 1.0
     * @since 1.0
     */
    protected function upload_errors($err_files)
    {
        $ret = array();
        foreach ($err_files as $file) {
            $field       = str_replace(':', '.', $file['field']);
            $ret[$field] = $file['errors'][0]['message'];
        }
        return $ret;
    }

    /**
     * Save images when editing
     *
     * params int $id Product-ID
     * params boolean $is_upthumb Upload thumbnail or not
     * params boolean $is_upimgs Upload images or not
     *
     * @author Nguyen Van Hiep
     * @access public
     *
     * @version 1.0
     * @since 1.0
     */
    protected function save_imgs_edit($id, $is_upthumb, $is_upimgs)
    {
        Upload::save();
        foreach (Upload::get_files() as $info) {
            $filepath = $info['saved_to'] . $info['saved_as'];
            $image    = Image::load($filepath);
            $image->save_pa('p' . $id . '_');
            $image->resize(null, 362, true)
                  -> save($this->dir . 'thumbp' . $id . '_' . $info['saved_as']);
            File::delete($filepath);
        }

        $imgs = $this->img_info($id, Input::file());
        if ($is_upthumb == true) {
            $current_thumb = Model_ProdImg::get_prod_thumbnail($id);
            Model_ProdImg::save_thumbnail($id, $imgs['thumbnail'], true);
            File::delete($this->dir . $current_thumb->image_name);
            File::delete($this->dir . 'thumb' . $current_thumb->image_name);
        }

        if ($is_upimgs == true) {
            Model_ProdImg::save_images($id, $imgs['img_names'], Input::post('colour'));
        }
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
        $p = Model_Product::find($id);
        if (!$p) {
            Session::set_flash('error', __('message.prod_not_exists'));
            Response::redirect('admin/product');
        }

        $view      = View::forge('admin/product/edit');
        $view->p   = $p;
        $view->err = array();

        $view->img_count = 1;
        $view->cats      = Model_Categories::get_cat_list();
        $view->sel_cats  = Model_ProdCat::get_cat_from_prod($id);
        $view->thumb     = Model_ProdImg::get_prod_thumbnail($id);
        $view->imags     = Model_ProdImg::get_prod_imgs($id);

        if (Input::method() == 'POST') {
            if (count(Input::file()) == 0) {
                Session::set_flash('error', __('message.upload_files_error'));
                Response::redirect('admin/product/edit');
            }

            $view->img_count = count(Input::post('colour'));

            $p->product_name       = Input::post('name');
            $p->slug               = Input::post('slug');
            $p->short_description  = Input::post('short_desc');
            $p->detail_description = Input::post('detail');
            $p->price              = Input::post('price');
            $p->sale_price         = Input::post('sale');
            //$p->view_number        = 0;
            $p->status             = Input::post('status');
            $p->size               = Input::post('size');
            //$p->created_date       = date('Y-m-d h:i:s', time());
            $p->updated_date       = date('Y-m-d h:i:s', time());
            $val                   = Model_Product::validate('add', $p);

            Upload::process($this->config);

            $upload_errs = Upload::get_errors();
            $input_file  = Input::file();
            $upthumb     = $input_file['thumbnail']['name'];
            $upimgs      = $input_file['img']['name'];
            $is_upthumb  = true;
            $is_upimgs   = true;

            // Check if upload new thumbnail or not
            // Check if upload new images or not
            foreach ($upload_errs as $key => $file) {
                if (($file['field'] == 'thumbnail') and ( strlen($upthumb) == 0)) {
                    unset($upload_errs[$key]);
                    $is_upthumb = false;
                }
                if ((count($upimgs) == 1) and ( strlen($upimgs[0]) == 0)) {
                    unset($upload_errs[$key]);
                    $is_upimgs = false;
                }
            }

            if (($val->run()) and ( count($upload_errs) == 0)) {
                //save account
                if ($p->save()) {
                    // Save Product-Category
                    $prodcat = (Input::post('cat')) ? Input::post('cat') : array();
                    Model_ProdCat::save_prod_cat($p->id, $prodcat, true);

                    //Save images
                    $this->save_imgs_edit($p->id, $is_upthumb, $is_upimgs);

                    //redirect to index page
                    Session::set_flash('success', __('message.prod_edited'));
                    Response::redirect('admin/product');
                } else { //fail in transaction
                    Session::set_flash('error', __('message.registration_failed'));
                }
            } else {
                $view->err = $val->error_message();
                $err       = $this->upload_errors($upload_errs);
                $view->err = array_merge($view->err, $err);
            }
        }

        $this->template->title   = __('prod.edit');
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
        $p = Model_Product::find($id);
        if (!$p) {
            Session::set_flash('error', __('message.prod_not_exists'));
            Response::redirect('admin/product');
        }

        // Delete images
        $prod_imgs = Model_ProdImg::get_all_prod_imgs($id);
        foreach ($prod_imgs as $img) {
            File::delete($this->dir . $img->image_name);
            File::delete($this->dir . 'thumb' . $img->image_name);

        }
        Model_ProdImg::del_prod_img($id);
        Model_ProdCat::del_prod_cat($id);

        if ($p->delete()) {
            Session::set_flash('success', __('message.prod_deleted'));
            Response::redirect('admin/product');
        } else {
            Session::set_flash('error', __('message.cannot_del_prod'));
        }
    }

    /**
     * Change color of an image
     *
     * @author Nguyen Van Hiep
     * @access public
     *
     * @version 1.0
     * @since 1.0
     */
    public function action_ajaxcolor()
    {
        $id    = str_replace('p', '', Input::post('id'));
        $prod  = Input::post('prod');
        $color = Input::post('color');
        Model_ProdImg::change_img_color($id, $prod, $color);
    }

    /**
     * Delete an image of product
     * @param int $img name of image
     *
     * @author Nguyen Van Hiep
     * @access public
     *
     * @version 1.0
     * @since 1.0
     */
    public function action_delimg($img = null)
    {
        $exists = File::exists($this->dir . $img);
        if (!$exists) {
            Session::set_flash('error', __('message.img_not_exists'));
            Response::redirect('admin/product');
        } else {
            $info = explode('_', $img);
            $pid  = str_replace('p', '', $info[0]);
            Model_ProdImg::del_img_of_prod($pid, $img);
            if (File::delete($this->dir . $img) and File::delete($this->dir . 'thumb' . $img)) {
                Session::set_flash('success', __('message.img_deleted'));
                Response::redirect('admin/product/edit/' . $pid);
            } else {
                Session::set_flash('error', __('message.cannot_del_img'));
            }
        }
    }

}
