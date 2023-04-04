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

function upgrade_module_2_0_8($object)
{
	$return = true;
	PAPInstall::addColumn('pap_product', 'coverage', "decimal(15,2) unsigned NOT NULL DEFAULT '0.00'");
	PAPInstall::addColumn('pap_product', 'calculation_type', "varchar(12) DEFAULT 'normal'");
	PAPInstall::addColumn('pap_productattributes', 'coverage', "decimal(15,2) unsigned NOT NULL DEFAULT '0.00'");
    PAPInstall::createTranslation('coats_required', 'text', 'Number of Coats');
	return $return;
}