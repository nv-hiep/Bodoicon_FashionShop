<?php

/**
 * /categories.php
 *
 * @author Nguyen Van Hiep
 * @package HakiShop
 * @since Sep 6, 2015
 * @version $Id$
 * @license X-TRANS Develop License 1.0
 */
class Controller_Admin_Categories extends Controller_Admin_Base
{

    /**
     * Display all categories
     *
     * @access public
     * @author Nguyen Van Hiep
     *
     * @version 1.0
     * @since 1.0
     */
    public function action_index()
    {
        $view       = View::forge('admin/categories/index');
        $view->cats = Model_Categories::get_all_cats();

        $this->template->title   = __('cat.categories');
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
        $view       = View::forge('admin/categories/add');
        $view->err  = array();
        $view->cats = Model_Categories::get_cats();

        $catgs    = Model_Categories::get_all_cats();
        // Prepare for registration
        $orders   = array();
        $id_order = array();
        foreach ($catgs as $item) {
            $orders[]            = $item->order;
            $id_order[$item->id] = $item->order;
        }
        $new_order_max = (count($orders) > 0) ? max($orders) + 1 : 1;

        if (Input::method() == 'POST') {
            $cat       = Model_Categories::forge();
            $cat->name = Input::post('name');
            $cat->slug = Input::post('slug');
            $val       = Model_Categories::validate('add', $cat);
            if ($val->run()) {
                $cat->order     = Input::post('order');
                $cat->parent_id = Input::post('parent');
                $cat->active    = !empty(Input::post('active'))  ? Input::post('active')  : false;
                $cat->storage   = !empty(Input::post('storage')) ? Input::post('storage') : false;
                if (strlen($cat->order) == 0) {
                    $cat->order = $new_order_max;
                }
                // check if input order existed in the list of cat. table
                if (in_array($cat->order, $orders)) {
                    //Input order existed in the list -> Add cat. and re-order the list
                    foreach ($id_order as $item_id => $item_order) {
                        if ($item_order >= $cat->order) {
                            $new_order = $item_order + 1;
                            Model_Categories::update_order($new_order, $item_id);
                        }
                    }
                    if ($cat->save()) {
                        Session::set_flash('success', __('message.cat_added'));
                        Response::redirect('admin/categories');
                    } else { //fail in transaction
                        Session::set_flash('error', __('message.cannot_add_cat'));
                        Response::redirect('admin/categories');
                    }
                } else { //Input order does NOT exist in the list -> Add position with a new order next to the previous maximum
                    $cat->order = $new_order_max;
                    //save
                    if ($cat->save()) {
                        Session::set_flash('success', __('message.cat_added'));
                        Response::redirect('admin/categories');
                    } else { //fail in transaction
                        Session::set_flash('error', __('message.cannot_add_cat'));
                        Response::redirect('admin/categories');
                    }
                }
            } else {//validate error
                Session::set_flash('error', __('message.validation_error'));
                $view->err = $val->error_message();
            }
        }

        $view->new_max           = $new_order_max;
        $this->template->title   = __('cat.add_cat');
        $this->template->content = $view;
    }

    /**
     * Edit Category
     *
     * @param int $id cat. ID
     *
     * @author Nguyen Van Hiep
     * @access public
     *
     * @version 1.0
     * @since 1.0
     */
    public function action_edit($id = null)
    {
        $cat = Model_Categories::find($id);
        if (!$cat) {
            Session::set_flash('error', __('message.cat_not_exists'));
            Response::redirect('admin/categories');
        }

        $view       = View::forge('admin/categories/edit');
        $view->cat  = $cat;
        $view->err  = array();
        $view->cats = Model_Categories::get_cats();

        $catgs  = Model_Categories::get_all_cats();
        $orders = array();
        $id_ord = array();
        foreach ($catgs as $item) {
            $orders[]          = $item->order;
            $id_ord[$item->id] = $item->order;
        }
        $ord_max = max($orders);

        if (Input::method() == 'POST') {
            $val = Model_Categories::validate('add', $cat);
            if ($val->run()) {
                $curr_ord = $cat->order;
                $ord      = Input::post('order');
                // If input order is not in the existing orders -> update cat. and re-order cat.s in the list
                if (!in_array($ord, $orders)) {
                    $this->updateWithMaxOrder($cat, $id_ord, $curr_ord, $ord_max);
                    // If input order is in the existing orders but NOT equal to its current order -> update and re-order
                } elseif (in_array($ord, $orders) && ($ord != $curr_ord)) {
                    $this->updateOrderWithinExistingOrders($cat, $id_ord, $curr_ord, $ord);
                } else { // else if input order is in the existing orders AND Equal to its order -> Update cat.
                    $this->updateCat($cat);
                }
            } else {
                $view->err = $val->error_message();
            }
        }

        $view->ord_max           = $ord_max;
        $this->template->title   = __('cat.edit');
        $this->template->content = $view;
    }

    /**
     * Update category
     *
     * detail: Only update category when its order keeps unchanged
     *
     * @param object $obj info of category
     * @return void
     *
     * @access public
     * @since 1.0
     * @version 1.0
     * @author Nguyen Van Hiep
     */
    protected function updateCat($obj)
    {
        $obj->name      = Input::post('name');
        $obj->slug      = Input::post('slug');
        $obj->parent_id = Input::post('parent');
        $obj->active    = !empty(Input::post('active'))  ? Input::post('active')  : false;
        $obj->storage   = !empty(Input::post('storage')) ? Input::post('storage') : false;
        if ($obj->save()) {
            Session::set_flash('success', __('message.cat_edited'));
            Response::redirect('admin/categories');
        } else {
            Session::set_flash('error', __('message.cannot_edit_cat'));
            Response::redirect('admin/categories');
        }
    }

    /**
     * Update cat. with max order
     *
     * detail: Update cat. when its order is NOT in the existing list
     *
     * @param object $obj info of cat.
     * @param array $id_ord correspondence between id and order
     * @param int $curr_ord current order of cat.
     * @param int $ord new order of the cat.
     * @return void
     *
     * @access public
     * @since 1.0
     * @version 1.0
     * @author Nguyen Van Hiep
     */
    protected function updateWithMaxOrder($obj, $id_ord, $curr_ord, $ord)
    {
        foreach ($id_ord as $item_id => $item_order) {
            if ($item_order > $curr_ord) {
                $new_order = $item_order - 1;
                Model_Categories::update_order($new_order, $item_id);
            }
        }
        $obj->set(array(
            'name'      => Input::post('name'),
            'slug'      => Input::post('slug'),
            'order'     => $ord,
            'parent_id' => (strlen(Input::post('parent')) > 0) ? Input::post('parent') : null,
            'active'    => !empty(Input::post('active'))  ? Input::post('active')  : false,
            'storage'   => !empty(Input::post('storage')) ? Input::post('storage') : false
        ));
        if ($obj->save()) {
            Session::set_flash('success', __('message.cat_edited'));
            Response::redirect('admin/categories');
        } else {
            Session::set_flash('error', __('message.cannot_edit_cat'));
            Response::redirect('admin/categories');
        }
    }

    /**
     * Update cat. with order existing in the list
     *
     * detail: Update cat. when its order is in the existing list
     *
     * @param object $obj info of cat.
     * @param array $id_ord correspondence between id and order
     * @param int $curr_ord current order of cat.
     * @param int $ord new order of the cat.
     * @return void
     *
     * @access public
     * @since 1.0
     * @version 1.0
     * @author Nguyen Van Hiep
     */
    protected function updateOrderWithinExistingOrders($obj, $id_ord, $curr_ord, $ord)
    {
        if ($curr_ord < $ord) {
            foreach ($id_ord as $item_id => $item_order) {
                if (($item_order > $curr_ord) && ($item_order <= $ord)) {
                    $new_order = $item_order - 1;
                    Model_Categories::update_order($new_order, $item_id);
                }
            }
            $obj->set(array(
                'name'      => Input::post('name'),
                'slug'      => Input::post('slug'),
                'order'     => $ord,
                'parent_id' => (strlen(Input::post('parent')) > 0) ? Input::post('parent') : null,
                'active'    => !empty(Input::post('active'))  ? Input::post('active')  : false,
                'storage'   => !empty(Input::post('storage')) ? Input::post('storage') : false
            ));
            if ($obj->save()) {
                Session::set_flash('success', __('message.cat_edited'));
                Response::redirect('admin/categories');
            } else {
                Session::set_flash('error', __('message.cannot_edit_cat'));
                Response::redirect('admin/categories');
            }
        } else {
            foreach ($id_ord as $item_id => $item_order) {
                if (($item_order < $curr_ord) && ($item_order >= $ord)) {
                    $new_order = $item_order + 1;
                    Model_Categories::update_order($new_order, $item_id);
                }
            }
            $obj->set(array(
                'name'      => Input::post('name'),
                'slug'      => Input::post('slug'),
                'order'     => $ord,
                'parent_id' => (strlen(Input::post('parent')) > 0) ? Input::post('parent') : null,
                'active'    => !empty(Input::post('active'))  ? Input::post('active')  : false,
                'storage'   => !empty(Input::post('storage')) ? Input::post('storage') : false
            ));
            if ($obj->save()) {
                Session::set_flash('success', __('message.cat_edited'));
                Response::redirect('admin/categories');
            } else {
                Session::set_flash('error', __('message.cannot_edit_cat'));
                Response::redirect('admin/categories');
            }
        }
    }

    /**
     * Update cat. order
     *
     * detail: Update cat. orders when finishing drag and drop
     *
     * @return void
     *
     * @access public
     * @since 1.0
     * @version 1.0
     * @author Nguyen Van Hiep
     */
    public function action_update_order()
    {
        $array = Input::post('arrayorder');
        if (Input::post('update') == "update") {
            $count = 1;
            foreach ($array as $idval) {
                Model_Categories::update_order($count, $idval);
                $count ++;
            }
        }
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
        $cat = Model_Categories::find($id);
        if (!$cat) {
            Session::set_flash('error', __('message.cat_not_exists'));
            Response::redirect('admin/categories');
        }
        $unable_del = $this->unable_del($id);
        if ($unable_del) {
            $message = __('message.related_cat');
            array_unshift($unable_del, $message);

            $message = __('message.cannot_del_cat_:name', array('name' => $cat->name));
            array_unshift($unable_del, $message);

            Session::set_flash('error', $unable_del);
            Response::redirect('admin/categories');
        } else {
            $this->delete_cat($cat);
        }
    }

    /**
     * Delete cat. and re-order
     *
     * @param object $cat cat.
     * @return void
     *
     * @access protected
     * @author Nguyen Van Hiep
     */
    protected function delete_cat($cat)
    {
        //$name = Security::clean($position->name, array('xss_clean', 'htmlentities'));
        $order = $cat->order;
        // Delete the position, then re-order the orders in the list
        if ($cat->delete()) {
            $cats     = Model_Categories::find('all');
            $id_order = array();
            foreach ($cats as $item) {
                $id_order[$item['id']] = $item['order'];
            }
            // Re-order the orders
            foreach ($id_order as $item_id => $item_order) {
                if ($item_order > $order) {
                    $new_order = $item_order - 1;
                    Model_Categories::update_order($new_order, $item_id);
                }
            }
            Session::set_flash('success', __('message.cat_deleted'));
            Response::redirect('admin/categories');
        } else {
            Session::set_flash('error', __('message.cannot_del_cat'));
            Response::redirect('admin/categories');
        }
    }

    /**
     * Check if cat. CANNOT be deleted
     *
     * @param int $id cat. id
     * @return array $relatedcat names of related cat.s if the cat. CANNOT be deleted,
     *         boolean FALSE if the cat. CAN be deleted
     *
     * @access protected
     * @author Nguyen Van Hiep
     */
    protected function unable_del($id)
    {
        $relatedcats  = array();
        $relatedprods = array();
        $cats         = Model_Categories::get_child_cats($id);
        $cat_prods    = Model_ProdCat::get_related_prods($id);
        foreach ($cats as $item) {
            $text          = Security::clean($item->name, array('htmlentities', 'xss_clean'));
            $relatedcats[] = Html::anchor('/admin/categories/edit/' . $item->id, $text);
        }
        if (count($relatedcats) > 0) {
            array_unshift($relatedcats, '- ' . __('cat.categories') . ':');
        }

        foreach ($cat_prods as $prod) {
            $text           = Security::clean($prod->pc2p->product_name, array('htmlentities', 'xss_clean'));
            $relatedprods[] = Html::anchor('/admin/product/edit/' . $prod->product_id, $text);
        }
        if (count($relatedprods) > 0) {
            array_unshift($relatedprods, '- ' . __('prod.prods') . ':');
        }

        $ret = array_merge($relatedcats, $relatedprods);

        if (count($ret) > 0) {
            return $ret;
        } else {
            return false;
        }
    }

    /**
     * Ajax: Change active_flag of Cat.
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
        $id          = Input::post('id');
        $flag        = Input::post('flag');
        $flag        = !$flag;
        $img         = Model_Categories::find($id);
        $img->active = $flag;

        //save
        $img->save();
    }

}
