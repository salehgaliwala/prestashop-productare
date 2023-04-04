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

class PAPTranslationProductModel extends ObjectModel
{
	/** @var integer Unique ID */
	public $id_translation_product;

	/** @var integer Product ID */
	public $id_product;

	/** @var string Name */
	public $name;

	/** @var string Text */
	public $text;

	/**
	 * @see ObjectModel::$definition
	 */
	public static $definition = array(
		'table' => 'pap_translation_product',
		'primary' => 'id_translation_product',
		'multilang' => true,
		'fields' => array(
			'id_product' => array('type' => self::TYPE_INT),
			'name' => array('type' => self::TYPE_STRING, 'validate' => 'isMessage', 'size' => 32, 'required' => true),
			'text' => array('type' => self::TYPE_STRING, 'validate' => 'isMessage', 'size' => 32, 'required' => false, 'lang' => true)
		)
	);

	public function getByProduct($id_product, $id_lang = null)
	{
		$sql = new DbQuery();
		$sql->select('*');
		$sql->from(self::$definition['table'], 't');

		if (empty($id_lang)) {
			$sql->innerJoin('pap_translation_product_lang', 'tl', 't.id_translation_product = tl.id_translation_product');
		}
		else {
			$sql->innerJoin('pap_translation_product_lang', 'tl', 't.id_translation_product = tl.id_translation_product AND tl.id_lang = ' . (int)$id_lang);
		}

		$sql->where('t.id_product = '.(int)$id_product);
		$results = Db::getInstance()->executeS($sql);#

		if (!empty($results)) {
			return self::hydrateCollection('PAPTranslationProductModel', $results);
		}
		else {
			return array();
		}
	}

}