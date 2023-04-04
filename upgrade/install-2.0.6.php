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

include_once(_PS_MODULE_DIR_.'/productareapacks/lib/bootstrap.php');

function upgrade_module_2_0_6($object)
{
	$return = true;

	$return &= Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'pap_translation_product` (
				`id_translation_product` int(10) unsigned NOT NULL AUTO_INCREMENT,
				`id_product` int(10) unsigned NOT NULL,
				`name` varchar(32) NOT NULL,
				PRIMARY KEY (`id_translation_product`)			
			) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8 ;');

	$return &= Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'pap_translation_product_lang` (
				`id_translation_product` int(10) unsigned NOT NULL,
				`id_lang` int(10) unsigned NOT NULL,
				`text` varchar(255) DEFAULT NULL			
			) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8 ;');

	return $return;
}