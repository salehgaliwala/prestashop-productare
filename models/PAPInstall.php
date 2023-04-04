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

class PAPInstall
{
	public static function install()
	{
		self::installDB();
		return self::installData();
	}

    /**
     * Prepare the correct overrides for installation based on Prestashop version
     * @param $module_name
     * @return bool
     */
	public static function prepareOverridesForInstall($module_name)
    {
        $ps_version = str_replace('.', '', _PS_VERSION_);
        $target_folder = _PS_MODULE_DIR_ . $module_name . '/override';

        if (version_compare(_PS_VERSION_, '1.7.7.2', '>=') === true) {
            $install_folder = _PS_MODULE_DIR_ . $module_name.'/install/override_1772';
            PAPFileHelper::copyFolder($install_folder, $target_folder);
        } else {
            $install_folder = _PS_MODULE_DIR_ . $module_name . '/install/override';
            PAPFileHelper::copyFolder($install_folder, $target_folder);
        }
        return true;
    }

	public static function installDB()
	{
		$return = true;

		$return &= Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'pap_product` (
			  `id_pap_product` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `id_product` int(10) unsigned NOT NULL,
			  `id_shop` int(10) unsigned NOT NULL,
              `id_pap_unit_default` int(10) unsigned NOT NULL,			  
			  `enabled` tinyint(3) unsigned NOT NULL DEFAULT 0,
			  `calculation_type` varchar(12) DEFAULT "normal",
			  `dynamic_price` tinyint(3) unsigned NOT NULL DEFAULT 0,			  
			  `unit_conversion_enabled` tinyint(3) unsigned NOT NULL DEFAULT 0,
			  `unit_conversion_operator` varchar(3) NOT NULL,
			  `unit_conversion_value` decimal(15,2) NOT NULL,
			  `pack_area` decimal(15,4) NOT NULL,
			  `roll_width` decimal(15,2) NOT NULL DEFAULT "0.00",
			  `roll_height` decimal(15,2) NOT NULL DEFAULT "0.00",
              `pattern_repeat` decimal(15,4) NOT NULL DEFAULT "0.00",
			  `area_price` decimal(15,2) NOT NULL DEFAULT "0.00",
			  `coverage` decimal(15,2) NOT NULL DEFAULT "0.00",
			  `wastage_options` varchar(255) DEFAULT NULL,
			  PRIMARY KEY (`id_pap_product`)
			) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8 ;');

		$return &= Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'pap_product_field` (
			  `id_pap_product_field` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `id_pap_dimension` int(10) unsigned NOT NULL,
			  `id_product` int(10) unsigned NOT NULL,
			  `visible` tinyint(3) unsigned NOT NULL,
			  PRIMARY KEY (`id_pap_product_field`)
			) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8 ;');

		$return &= Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'pap_productattributes` (
                `id_papattribute` int(10) unsigned NOT NULL AUTO_INCREMENT,
                `id_product` int(10) unsigned NOT NULL DEFAULT "0",
                `id_product_attribute` int(10) NOT NULL DEFAULT "0",
                `pack_area` decimal(15,4) NOT NULL,
                `area_price` decimal(15,2) NOT NULL,
                `roll_height` decimal(15,2) unsigned NOT NULL DEFAULT "0.00",
                `roll_width` decimal(15,2) unsigned NOT NULL DEFAULT "0.00",
                `pattern_repeat` decimal(15,4) NOT NULL DEFAULT "0.00",
                `coverage` decimal(15,2) NOT NULL NULL DEFAULT "0.00",
				PRIMARY KEY (`id_papattribute`)
			) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8 ;');

		$return &= Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'pap_translation` (
			  `id_translation` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `id_shop` int(10) unsigned DEFAULT NULL,
			  `name` varchar(128) DEFAULT NULL,
			  `type` varchar(32) NOT NULL,
			  PRIMARY KEY (`id_translation`)
			) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8 ;');

		$return &= Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'pap_translation_lang` (
			  `id_translation` int(10) unsigned DEFAULT NULL,
			  `id_lang` int(10) unsigned DEFAULT NULL,
			  `text` text
			) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8 ;');

		$return &= Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'pap_dimension` (
				`id_pap_dimension` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
				`id_shop` int(10) unsigned NOT NULL,
				`name` varchar(32) DEFAULT NULL,
				`display_name` varchar(32) DEFAULT NULL,
				`suffix` varchar(32) DEFAULT NULL,
				`position` int(10) unsigned NOT NULL DEFAULT "0",
				PRIMARY KEY (`id_pap_dimension`)			
			) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8 ;');

		$return &= Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'pap_dimension_lang` (
				`id_pap_dimension` int(10) unsigned NOT NULL AUTO_INCREMENT,
				`id_lang` int(10) unsigned NOT NULL,
				`display_name` varchar(32) NOT NULL,
				`suffix` varchar(32) NOT NULL,
				PRIMARY KEY (`id_pap_dimension`,`id_lang`)			
			) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8 ;');

		$return &= Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'pap_translation_product` (
				`id_translation_product` int(10) unsigned NOT NULL AUTO_INCREMENT,
				`id_product` int(10) unsigned NOT NULL,
				`name` varchar(32) NOT NULL,
				PRIMARY KEY (`id_translation_product`)			
			) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8 ;');

		$return &= Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'pap_translation_product_lang` (
				`id_translation_product` int(10) unsigned NOT NULL,
				`id_lang` int(10) unsigned NOT NULL,
				`text` varchar(255) DEFAULT NULL			
			) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8 ;');

        $return &= Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'pap_unit` (
                `id_pap_unit` int(10) unsigned NOT NULL AUTO_INCREMENT,
                `name` varchar(255) NOT NULL,
                `conversion_factor` decimal(8,2) unsigned DEFAULT 0.00,                    
                `position` int(10) unsigned DEFAULT 0.00,
            PRIMARY KEY (`id_pap_unit`)                			
			) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8 ;');

        $return &= Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'pap_unit_lang` (
                `id_pap_unit` int(10) unsigned NOT NULL,
                `id_lang` smallint(5) unsigned NOT NULL,
                `symbol` varchar(32) NOT NULL,			
            PRIMARY KEY (`id_pap_unit`,`id_lang`)                			
			) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8 ;');

        $return &= Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'pap_product_unit_conversion` (
                `id_pap_product_unit_conversion` int(10) unsigned NOT NULL AUTO_INCREMENT,
                `id_product` int(10) unsigned DEFAULT 0,
                `id_pap_unit` int(10) unsigned NOT NULL,
                `default` smallint(3) unsigned DEFAULT 0,
                `position` int(10) unsigned DEFAULT 0,			
            PRIMARY KEY (`id_pap_product_unit_conversion`)                			
			) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8 ;');
        return $return;
	}
	
	public static function addColumn($table, $name, $type)
	{
		try
		{
			$return = Db::getInstance()->execute('ALTER TABLE  `'._DB_PREFIX_.''.$table.'` ADD `'.$name.'` '.$type);
		} catch(Exception $e)
		{
			return true;
		}
		return true;
	}

	private static function dropColumn($table, $name)
	{
		Db::getInstance()->execute('ALTER TABLE  `'._DB_PREFIX_.''.$table.'` DROP `'.$name.'`');
	}

	private static function dropTable($table_name)
	{
		Db::getInstance()->execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.''.$table_name.'`;');
	}

	private static function addUnit($name, $display_name, $suffix, $id_shop)
	{
		$pap_dimension = new PAPDimensionModel();
		$pap_dimension->getByName($name, $id_shop);
		$languages = Language::getLanguages();

		if (empty($pap_dimension->name))
		{
			$pap_dimension_new = new PAPDimensionModel();
			$pap_dimension_new->name = pSQL($name);
			$pap_dimension_new->id_shop = (int)$id_shop;
			$pap_dimension_new->position = 0;

			foreach ($languages as $lang)
			{
				$pap_dimension_new->display_name[$lang{'id_lang'}] = pSQL($display_name);
				$pap_dimension_new->suffix[$lang{'id_lang'}] = pSQL($suffix);
			}
		}
		$pap_dimension_new->save();
	}

	public static function createTranslation($name, $type, $text)
	{
	    $id_shop = Configuration::get('PS_SHOP_DEFAULT', null, Context::getContext()->shop->id_shop_group, Context::getContext()->shop->id);
		$languages = Language::getLanguages();

		$pap_translation = new PAPTranslationModel();

        PAPTranslationModel::deleteByName($name, $id_shop);

		$pap_translation->name = pSQL($name);
		$pap_translation->type = pSQL($type);
		$pap_translation->id_shop = (int)$id_shop;

		foreach ($languages as $lang)
			$pap_translation->text[$lang['id_lang']] = $text;

		$pap_translation->save();
	}

    private static function _addUnit($name, $symbol, $conversion_factor, $id_lang)
    {
        $pap_unit = new PAPUnit();
        $pap_unit->getByName($name);

        if (empty($pap_unit->id_pap_unit)) {
            $pap_unit->name = pSQL($name);
            $pap_unit->symbol[$id_lang] = pSQL($symbol);
            $pap_unit->conversion_factor = (float)$conversion_factor;
            $pap_unit->add(false);
        }
    }

    public static function installData()
	{
		$languages = Language::getLanguages();
		$shops = ShopCore::getCompleteListOfShopsID();

		/* Install Dimensions */
		foreach ($shops as $id_shop)
		{
			self::addUnit('height', 'Height', 'mm', $id_shop);
			self::addUnit('width', 'Width', 'mm', $id_shop);
		}

		/* Install the translations */
		self::createTranslation('total_area', 'text', 'Total Area');
		self::createTranslation('wastage_options', 'text', 'Add Extra wastage?');
		self::createTranslation('quote', 'text', 'Quote');
		self::createTranslation('total_price_suffix', 'text', 'per m2');
		self::createTranslation('total_area_suffix', 'text', 'm2');
		self::createTranslation('required_packs', 'text', 'Required packs');
		self::createTranslation('pack_price', 'text', 'Box Price');
		self::createTranslation('pack_quote', 'text', 'Pack Quote');
		self::createTranslation('pack_quote_total_area', 'text', 'Total Area in boxes');
		self::createTranslation('coats_required', 'text', 'Number of Coats');

        /* Install sample dimensions */
        foreach ($languages as $language) {
            self::_addUnit('millimeter', 'mm', 1, $language['id_lang']);
            self::_addUnit('centimeter', 'cm', 10, $language['id_lang']);
            self::_addUnit('meter', 'm', 1000, $language['id_lang']);
            self::_addUnit('inch', 'inch', 25.40, $language['id_lang']);
            self::_addUnit('foot', 'ft', 304.80, $language['id_lang']);
        }
        return true;
	}

	public static function uninstall()
	{
		self::dropTable('pap_unit');
		self::dropTable('pap_unit_lang');
		self::dropTable('pap_translations');
		self::dropTable('pap_translations_lang');
		self::dropTable('pap_product');
		self::dropTable('pap_product_unit');
	}	

	public static function uninstallData()
	{
	}

}