<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of order
 *
 * @author Dao Anh Minh
 */
class Model_Order extends \Orm\Model
{
    protected static $_table_name = 'order';
    protected static $_primary_key = array('id');
    protected static $_properties = array(
        'id',
        'username',
        'fullname',
        'phone_number',
        'address',
        'note',
        'status',
        'created_date'
    );

    protected static $_has_many = array(
        'product' => array(
            'key_from'  => 'id',
            'key_to'    => 'order_id',
            'model_to'  => 'Model_Orderproduct',
            'cascade_delete' => false,
            'cascade_update' => false
        )
    );

    /**
     * Validate checkout information
     *
     * @return object validation object
     *
     * @access public
     * @author Dao Anh Minh
     */
    public static function validate()
    {
        $val = Validation::forge('order');

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
        $val->add('note', __('cart.note_title'))
                ->add_rule('max_length', 500);

        return $val;
    }
}
