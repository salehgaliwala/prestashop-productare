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

class PAPProductFieldModel extends ObjectModel
{
	/** @var integer Unique ID */
	public $id_pap_product_field;

	/** @var integer Dimension ID */
	public $id_pap_dimension;

	/** @var integer Product IDe */
	public $id_product;

	/** @var boolean integer Visible */
	public $visible;

	/**
	 * @see ObjectModel::$definition
	 */
	public static $definition = array(
		'table' => 'pap_product_field',
		'primary' => 'id_pap_product_field',
		'multilang' => false,
		'fields' => array(
			'id_pap_dimension' => array('type' => self::TYPE_INT),
			'id_product' =>	array('type' => self::TYPE_INT),
			'visible' => array('type' => self::TYPE_INT)
		)
	);

	public static function getByProduct($id_product)
	{
		$sql = new DbQuery();
		$sql->select('*');
		$sql->from('pap_product_field');
		$sql->where('id_product = '.(int)$id_product);
		$results = Db::getInstance()->executeS($sql);
		return self::hydrateCollection('PAPProductFieldModel', $results);
	}

	public static function deleteByProduct($id_product)
	{
		DB::getInstance()->delete(self::$definition['table'], 'id_product='.(int)$id_product);
	}


};