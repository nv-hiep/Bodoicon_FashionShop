<?php

/**
 * /orderproduct.php
 *
 * @copyright Copyright (C) 2015 X-TRANS inc.
 * @author Dao Anh Minh
 * @package Haki_Shop
 * @since Sep 24, 2015
 * @version $Id$
 * @license X-TRANS Develop License 1.0
 */

/**
 * orderproduct
 *
 * <pre>
 * </pre>
 *
 * @copyright Copyright (C) 2015 X-TRANS inc.
 * @author Dao Anh Minh
 * @package Haki_Shop
 * @since Sep 24, 2015
 * @version $Id$
 * @license X-TRANS Develop License 1.0
 */
class Model_Orderproduct extends Orm\Model
{
    protected static $_table_name = 'order_product';
    protected static $_primary_key = array('id');
    protected static $_properties = array(
        'id',
        'order_id',
        'product_name',
        'quantity',
        'product_price',
        'related_info',
        'image'
    );
}
