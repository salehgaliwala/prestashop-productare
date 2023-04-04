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

class PAPUnit extends ObjectModel
{
    /** @var integer Unique ID */
    public $id_pap_unit;

    /** @var string Dimension Name */
    public $name;

    /** @var string symbol position */
    public $symbol;

    /** @var float mm */
    public $conversion_factor;

    /** @var integer position */
    public $position;

    /**
     * @see ObjectModel::$definition
     */

    public static $definition = array(
        'table' => 'pap_unit',
        'primary' => 'id_pap_unit',
        'multilang' => true,
        'fields' => array(
            'name' => array(
                'type' => self::TYPE_STRING,
                'validate' => 'isMessage',
                'size' => 255,
                'required' => true
            ),
            'symbol' => array(
                'type' => self::TYPE_STRING,
                'validate' => 'isMessage',
                'size' => 64,
                'required' => true,
                'lang' => true
            ),
            'conversion_factor' => array(
                'type' => self::TYPE_FLOAT
			),
            'position' => array(
                'type' => self::TYPE_INT
            )
        )
    );

    /**
     * PAPUnit constructor.
     * @param null $id
     * @param null $id_lang
     * @param null $id_shop
     * @param null $translator
     * @throws PrestaShopDatabaseException
     * @throws PrestaShopException
     */
    public function __construct($id = null, $id_lang = null, $id_shop = null, $translator = null)
    {
        parent::__construct($id, $id_lang, $id_shop, $translator);
        if ((int)$this->id > 0) {
            $this->symbol = Tools::stripslashes($this->symbol);
        }
    }

    public static function getUnits()
    {
        $sql = new DbQuery();
        $sql->select('*');
        $sql->from('pap_unit', 'u');
        return Db::getInstance()->executeS($sql);
    }

    public function getByName($name)
    {
        $sql = new DbQuery();
        $sql->select('*');
        $sql->from('pap_unit');
        $sql->where('name LIKE "' . pSQL($name) . '"');
        $row = Db::getInstance()->getRow($sql);
        if (is_array($row)) {
            $this->hydrate($row);
        }
    }
}
