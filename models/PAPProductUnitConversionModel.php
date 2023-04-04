<?php
/**
 * NOTICE OF LICENSE
 *
 * This file is licenced under the Software License Agreement.
 * With the purchase or the installation of the software in your application
 * you accept the licence agreement.
 *
 * You must not modify, adapt or create derivative works of this source code
 *
 * @author    Musaffar Patel
 * @copyright 2016-2021 Musaffar Patel
 * @license   LICENSE.txt
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class PAPProductUnitConversionModel extends ObjectModel
{
    /** @var integer Unique ID */
    public $id_product;

    /** @var integer Unique ID */
    public $id_pap_unit;

    /** @var integer is_default */
    public $default;

    /** @var string Option value */
    public $position;

    /**
     * @see ObjectModel::$definition
     */

    public static $definition = array(
        'table' => 'pap_product_unit_conversion',
        'primary' => 'id_pap_product_unit_conversion',
        'fields' => array(
            'id_product' => array('type' => self::TYPE_INT),
            'id_pap_unit' => array('type' => self::TYPE_INT, 'required' => true),
            'default' => array('type' => self::TYPE_INT),
            'position' => array('type' => self::TYPE_INT)
        )
    );
}
