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

if (!defined('_PS_VERSION_'))
	exit;

class PAPProductModel extends ObjectModel
{
	/** @var integer Unique ID */
	public $id_pap_product;

	/** @var integer Shop ID */
	public $id_product;

	/** @var string Unit Name */
	public $id_shop;

	public $id_pap_unit_default = 0;

	/** @var string Display name */
	public $enabled;

    /** @var string Calculation type (normal | roll) */
    public $dynamic_price = 0;

    /** @var string Calculation type (normal | roll) */
	public $calculation_type = 'normal';

	/** @var string Unit Suffix */
	public $unit_conversion_enabled;

	/** @var string Unit Suffix */
	public $unit_conversion_operator;

	/** @var integer display position */
	public $unit_conversion_value;

	/** @var integer display position */
	public $pack_area;

	/** @var float roll height */
	public $roll_height;

	/** @var float roll width */
	public $roll_width;

    /** @var float pattern repeat */
    public $pattern_repeat = 0;

    /** @var float coverage */
	public $coverage;

	/** @var integer display position */
	public $area_price;

	/** @var integer display position */
	public $wastage_options;

	/**
	 * @see ObjectModel::$definition
	 */
	public static $definition = array(
		'table' => 'pap_product',
		'primary' => 'id_pap_product',
		'fields' => array(
			'id_product' =>	array('type' => self::TYPE_INT),
			'id_shop' =>	array('type' => self::TYPE_INT),
            'id_pap_unit_default' => array('type' => self::TYPE_INT),
			'enabled' =>	array('type' => self::TYPE_INT),
			'calculation_type' =>	array('type' => self::TYPE_STRING),
            'dynamic_price' => array('type' => self::TYPE_INT),
			'unit_conversion_enabled' => array('type' => self::TYPE_INT),
			'unit_conversion_operator' => array('type' => self::TYPE_STRING),
			'unit_conversion_value' => array('type' => self::TYPE_FLOAT),
			'pack_area' => array('type' => self::TYPE_FLOAT),
			'roll_height' => array('type' => self::TYPE_FLOAT),
			'roll_width' => array('type' => self::TYPE_FLOAT),
			'pattern_repeat' => array('type' => self::TYPE_FLOAT),
			'coverage' => array('type' => self::TYPE_FLOAT),
			'area_price' => array('type' => self::TYPE_FLOAT),
			'wastage_options' => array('type' => self::TYPE_STRING)
		)
	);

	/**
	 * Get by Product ID
	 * @param $id_product
	 */
	public function loadByProduct($id_product, $id_shop = null)
	{
		$sql = new DbQuery();
		$sql->select('*');
		$sql->from(self::$definition['table']);
		$sql->where('id_product = '.(int)$id_product);

		if (!empty($id_shop))
			$sql->where('id_shop = '.(int)$id_shop);

		$row = DB::getInstance()->getRow($sql);

		if (!empty($row))
			$this->hydrate($row);
	}

	/**
	 * Get list of dimensions
	 */
	public static function getDimensions($id_lang, $id_shop)
	{
		$sql = new DbQuery();
		$sql->select('*');
		$sql->from(self::$definition['table'], 'd');
		$sql->innerJoin('pap_dimension_lang', 'dl', 'd.id_pap_dimension = dl.id_pap_dimension AND dl.id_lang = '.(int)$id_lang);
		$sql->where('id_shop = '.(int)$id_shop);

		$results = Db::getInstance()->executeS($sql);
		if (!empty($results))
			return self::hydrateCollection('PAPDimensionModel', $results);
		else
			return array();
	}


};