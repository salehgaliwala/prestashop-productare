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

$module_folder = 'productareapacks';

/* library classes */
include_once(_PS_MODULE_DIR_.'/'.$module_folder.'/lib/classes/PAPControllerCore.php');

/* models */
include_once(_PS_MODULE_DIR_ . '/' . $module_folder . '/models/PAPInstall.php');
include_once(_PS_MODULE_DIR_ . '/' . $module_folder . '/models/PAPDimensionModel.php');
include_once(_PS_MODULE_DIR_ . '/' . $module_folder . '/models/PAPTranslationModel.php');
include_once(_PS_MODULE_DIR_ . '/' . $module_folder . '/models/PAPTranslationProductModel.php');
include_once(_PS_MODULE_DIR_ . '/' . $module_folder . '/models/PAPProductModel.php');
include_once(_PS_MODULE_DIR_ . '/' . $module_folder . '/models/PAPProductFieldModel.php');
include_once(_PS_MODULE_DIR_ . '/' . $module_folder . '/models/PAPProductAttributeModel.php');
include_once(_PS_MODULE_DIR_ . '/' . $module_folder . '/models/PAPProductUnitConversionModel.php');
include_once(_PS_MODULE_DIR_ . '/' . $module_folder . '/models/PAPUnit.php');

/* controllers */
include_once(_PS_MODULE_DIR_.'/'.$module_folder.'/controllers/admin/config/PAPAdminConfigMainController.php');
include_once(_PS_MODULE_DIR_.'/'.$module_folder.'/controllers/admin/config/PAPAdminConfigDimensionsController.php');
include_once(_PS_MODULE_DIR_.'/'.$module_folder.'/controllers/admin/config/PAPAdminConfigOptionsController.php');
include_once(_PS_MODULE_DIR_.'/'.$module_folder.'/controllers/admin/config/PAPAdminConfigTranslationsController.php');

include_once(_PS_MODULE_DIR_.'/'.$module_folder.'/controllers/admin/producttab/PAPAdminProductTabController.php');
include_once(_PS_MODULE_DIR_.'/'.$module_folder.'/controllers/admin/producttab/PAPAdminProductTabGeneralController.php');
include_once(_PS_MODULE_DIR_.'/'.$module_folder.'/controllers/admin/producttab/PAPAdminProductTabCombinationsController.php');
include_once(_PS_MODULE_DIR_.'/'.$module_folder.'/controllers/admin/producttab/PAPAdminProductTabTranslationsController.php');

include_once(_PS_MODULE_DIR_.'/'.$module_folder.'/controllers/front/PAPFrontCartController.php');
include_once(_PS_MODULE_DIR_.'/'.$module_folder.'/controllers/front/PAPFrontProductController.php');

/* helpers */
include_once(_PS_MODULE_DIR_ . '/' . $module_folder . '/helpers/PAPFileHelper.php');
include_once(_PS_MODULE_DIR_ . '/' . $module_folder . '/helpers/PAPTranslationHelper.php');
include_once(_PS_MODULE_DIR_ . '/' . $module_folder . '/helpers/PAPProductAttributeHelper.php');
include_once(_PS_MODULE_DIR_ . '/' . $module_folder . '/helpers/PAPProductUnitConversionHelper.php');
