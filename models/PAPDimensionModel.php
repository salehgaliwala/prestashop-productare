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

class PAPDimensionModel extends ObjectModel
{
	/** @var integer Unique ID */
	public $id_pap_dimension;

	/** @var integer Shop ID */
	public $id_shop;

	/** @var string Unit Name */
	public $name;

	/** @var string Display name */
	public $display_name;

	/** @var string Unit Suffix */
	public $suffix;

	/** @var integer display position */
	public $position;

	/**
	 * @see ObjectModel::$definition
	 */
	public static $definition = array(
		'table' => 'pap_dimension',
		'primary' => 'id_pap_dimension',
		'multilang' => true,
		'fields' => array(
			'id_shop'     =>	array(
				'type' => self::TYPE_INT,
			),
			'name'     =>	array(
				'type' => self::TYPE_STRING,
				'validate' => 'isMessage',
				'size' => 32,
				'required' => true
			),
			'display_name'  =>	array(
				'type' => self::TYPE_STRING,
				'validate' => 'isMessage',
				'size' => 32,
				'required' => true,
				'lang' => true
			),
			'suffix' =>	array(
				'type' => self::TYPE_STRING,
				'validate' => 'isMessage',
				'size' => 12,
				'lang' => true,
				'required' => true
			),
			'position' => array(
				'type' => self::TYPE_INT
			)
		)
	);

	/**
	 * Get list of dimensions
	 */
	public static function getDimensions($id_lang, $id_shop = '')
	{
		$sql = new DbQuery();
		$sql->select('*');
		$sql->from(self::$definition['table'], 'd');
		$sql->innerJoin('pap_dimension_lang', 'dl', 'd.id_pap_dimension = dl.id_pap_dimension AND dl.id_lang = '.(int)$id_lang);

        if (!empty($id_shop)) { 
            $sql->where('id_shop = '.(int)$id_shop); 
        } 		

		$results = Db::getInstance()->executeS($sql);
		if (!empty($results))
			return self::hydrateCollection('PAPDimensionModel', $results, $id_lang);
		else
			return array();
	}


	/**
	 * Get dimension by name
	 * @param $name
	 * @param $id_shop
	 */
	public static function getByName($name, $id_shop, $id_lang = null)
	{
		$sql = new DbQuery();
		$sql->select('*');
		$sql->from(self::$definition['table'], 'd');
		if (!empty($id_lang))
			$sql->innerJoin('pap_dimension_lang', 'dl', 'd.id_pap_dimension = dl.id_pap_dimension AND dl.id_lang = '.(int)$id_lang);
		
		$sql->where('name LIKE "'.pSQL($name).'"');

		$row = Db::getInstance()->getRow($sql);
		if (!empty($row))
			return self::hydrateCollection('PAPDimensionModel', $row, $id_lang);
		else
			return array();
	}

	/**
	 * Delete Dimension
	 * @param $id_pap_dimension
	 * @param bool $relational_delete
	 */
	public static function deleteDimension($id_pap_dimension, $relational_delete = true)
	{
		if ($relational_delete)
			DB::getInstance()->delete('pap_product_field', 'id_pap_dimension = '.(int)$id_pap_dimension);

		DB::getInstance()->delete(self::$definition['table'].'_lang', 'id_pap_dimension = '.(int)$id_pap_dimension);
		DB::getInstance()->delete(self::$definition['table'], 'id_pap_dimension = '.(int)$id_pap_dimension);
	}


};