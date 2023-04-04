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

class PAPTranslationModel extends ObjectModel
{
	/** @var integer Unique ID */
	public $id_translation;

	/** @var integer Shop ID */
	public $id_shop;

	/** @var string translation name */
	public $name;

	/** @var string field type */
	public $type;

	/** @var string translated text */
	public $text;

	/**
	 * @see ObjectModel::$definition
	 */
	public static $definition = array(
		'table' => 'pap_translation',
		'primary' => 'id_translation',
		'multilang' => true,
		'fields' => array(
			'id_shop' => array('type' => self::TYPE_INT),
			'name' => array('type' => self::TYPE_STRING, 'validate' => 'isMessage', 'size' => 32, 'required' => true),
			'type' => array('type' => self::TYPE_STRING, 'validate' => 'isMessage', 'size' => 32, 'required' => true),
			'text' => array('type' => self::TYPE_STRING, 'validate' => 'isMessage', 'size' => 32, 'required' => true, 'lang' => true)
		)
	);

	public static function getTranslations($id_lang, $id_shop)
	{
        $sql = new DbQuery();
        $sql->select('t.*, tl.text, tl.id_lang');
        $sql->from(self::$definition['table'], 't');

        if (empty($id_lang))
            $sql->leftJoin('pap_translation_lang', 'tl', 't.id_translation = tl.id_translation');
        else
            $sql->leftJoin('pap_translation_lang', 'tl', 't.id_translation = tl.id_translation AND tl.id_lang = ' . (int)$id_lang);

        $sql->where('id_shop = ' . (int)$id_shop);

        $results = Db::getInstance()->executeS($sql);

        if (!empty($results)) {
            $collection = self::hydrateCollection('PAPTranslationModel', $results);

            if (empty($id_lang)) {
                $languages = Language::getLanguages();
                foreach ($collection as &$item) {
                    foreach ($languages as $language) {
                        $id_lang = $language['id_lang'];
                        if (empty($item->text[$id_lang])) {
                            $item->text[$id_lang] = '';
                        }
                    }
                }
            }
            return $collection;
        } else
            return array();
	}

	public static function updateTranslation($id_translation, $text, $id_lang)
	{
        DB::getInstance()->delete(self::$definition['table'] . '_lang', 'id_lang = '.(int)$id_lang.' AND id_translation = '.(int)$id_translation);
        DB::getInstance()->insert(self::$definition['table'] . '_lang', array(
            'text' => pSQL($text),
            'id_lang' => (int)$id_lang,
            'id_translation' => (int)$id_translation
        ));		
	}

	public static function getTranslationByName($name, $id_lang = null)
	{
		$sql = new DbQuery();
        $sql->select('t.*, tl.text, tl.id_lang ');
		$sql->from(self::$definition['table'], 't');

		if (empty($id_lang))
			$sql->leftJoin('pap_translation_lang', 'tl', 't.id_translation = tl.id_translation');
		else
			$sql->leftJoin('pap_translation_lang', 'tl', 't.id_translation = tl.id_translation AND dl.id_lang = '.(int)$id_lang);

		$sql->where('name LIKE "'.pSQL($name).'"');

		$results = Db::getInstance()->executeS($sql);
        if (!empty($results)) {
            $item = self::hydrateCollection('PAPTranslationModel', $results)[0];

            if (empty($id_lang)) {
                $languages = Language::getLanguages();
                foreach ($languages as $language) {
                    $id_lang = $language['id_lang'];
                    if (empty($item->text[$id_lang])) {
                        $item->text[$id_lang] = '';
                    }
                }
            }
            return $item;
        } else
            return array();
	}

	public static function deleteByName($name, $id_shop)
    {
        $sql = new DbQuery();
        $sql->select('*');
        $sql->from(self::$definition['table']);
        $sql->where('name LIKE "' . pSQL($name) . '"');
        $sql->where('id_shop = '.(int)$id_shop);

        $results = Db::getInstance()->executeS($sql);

        if (empty($results)) {
            return true;
        }

        foreach ($results as $row) {
            DB::getInstance()->delete(self::$definition['table'].'_lang', 'id_translation='.(int)$row['id_translation']);
        }

        DB::getInstance()->delete(self::$definition['table'], 'name LIKE "' . pSQL($name).'"');
    }
}
