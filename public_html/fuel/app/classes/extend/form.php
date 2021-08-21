<?php

/**
 * /form.php
 *
 * @copyright Copyright (C) 2014 X-TRANS inc.
 * @author Bui Huu Phuc
 * @package tmd
 * @version $Id$
 * @license X-TRANS Develop License 1.0
 */

/**
 * Form
 *
 * <pre>
 * </pre>
 *
 * @copyright Copyright (C) 2014 X-TRANS inc.
 * @author Bui Huu Phuc
 * @package tmd
 * @version 1.0
 * @license X-TRANS Develop License 1.0
 */
class Form extends Fuel\Core\Form
{

    public static function error($key, $err, $img_class = null)
    {
        if (!empty($err[$key])) {
            return '<p class="red_font '. $img_class . '">' . $err[$key] . '</p>';
        }
        return '';
    }

}
