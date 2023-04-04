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
 * @copyright 2016-2017 Musaffar Patel
 * @license   LICENSE.txt
 */

class PAPProductAttributeModel extends ObjectModel
{
	public $id_papattribute;
	public $id_product;
	public $id_product_attribute;
	public $pack_area = 0;

    /** @var float Roll Width */
    public $roll_height;

    /** @var float Roll Width */
    public $roll_width;

    /** @var float Pattern Repeat */
    public $pattern_repeat;

    /** @var float coverage */
    public $coverage;

    public $area_price = 0;

	public static $definition = array(
		'table' => 'pap_productattributes',
		'primary' => 'id_papattribute',
		'multilang' => false,
		'fields' => array(
			'id_product' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt', 'required' => true),
			'id_product_attribute' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedInt', 'required' => true),
			'pack_area' => array('type' => self::TYPE_FLOAT, 'required' => false),
			'roll_height' => array('type' => self::TYPE_FLOAT, 'required' => false),
			'roll_width' => array('type' => self::TYPE_FLOAT, 'required' => false),
			'pattern_repeat' => array('type' => self::TYPE_FLOAT, 'required' => false),
			'coverage' => array('type' => self::TYPE_FLOAT, 'required' => false),
			'area_price' => array('type' => self::TYPE_FLOAT, 'required' => false)
		)
	);

	public function loadAttributeByProduct($id_product, $id_product_attribute)
	{
		$sql = new DbQuery();
		$sql->select('*');
		$sql->from(self::$definition['table'], 'pa');
		$sql->where('pa.id_product = '.(int)$id_product);
		$sql->where('pa.id_product_attribute = '.(int)$id_product_attribute);
		$row = Db::getInstance()->getRow($sql);

		if ($row) {
            $this->hydrate($row);
        }
	}

	public function getAttributesByProduct($id_product)
	{
		$sql = new DbQuery();
		$sql->select('*');
		$sql->from(self::$definition['table'], 'pa');
		$sql->where('pa.id_product = '.(int)$id_product);
		$result = Db::getInstance()->executeS($sql);
		return $result;
	}
}