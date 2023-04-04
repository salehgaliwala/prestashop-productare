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

class PAPAdminProductTabController extends PAPControllerCore
{
	private $ajax_url;

	public function __construct($sibling, $params = array())
	{
		parent::__construct($sibling, $params);
		$this->sibling = $sibling;
		$this->base_url = Tools::getShopProtocol().Tools::getShopDomain().__PS_BASE_URI__;
		$this->ajax_url = Context::getContext()->link->getAdminLink('AdminModules', true, array(), array('configure' => $this->sibling->name, 'section' => 'producttab'));
	}

	public function setMedia()
	{
		if (Tools::getValue('controller') == 'AdminProducts')
		{
			Context::getContext()->controller->addCSS($this->sibling->_path.'views/css/lib/tools.css');
			Context::getContext()->controller->addCSS($this->sibling->_path.'views/css/lib/popup.css');
			Context::getContext()->controller->addCSS($this->sibling->_path.'views/css/admin/pap.css');

			Context::getContext()->controller->addJS($this->sibling->_path.'views/js/lib/Tools.js');
			Context::getContext()->controller->addJS($this->sibling->_path.'views/js/lib/Popup.js');
			Context::getContext()->controller->addJS($this->sibling->_path.'views/js/admin/producttab/PAPAdminProductTabGeneralController.js');
			Context::getContext()->controller->addJS($this->sibling->_path.'views/js/admin/producttab/PAPAdminProductTabCombinationsController.js');
			Context::getContext()->controller->addJS($this->sibling->_path.'views/js/admin/producttab/PAPAdminProductTabTranslationsController.js');
		}
	}

	public function render()
	{
		Context::getContext()->smarty->assign(array(
			'module_ajax_url' => $this->ajax_url,
			'module_url' => $this->getShopBaseUrl(),
			'id_product' => $this->params['id_product'],
			'id_shop' => Context::getContext()->shop->id
		));
		return $this->sibling->display($this->sibling->module_file, 'views/templates/admin/producttab/main.tpl');
	}

	public function route()
	{
		switch (Tools::getValue('route'))
		{
			case 'papadminproducttabgeneralcontroller' :
				return (new PAPAdminProductTabGeneralController($this->sibling, $this->params))->route();

			case 'papadminproducttabcombinationscontroller' :
				return (new PAPAdminProductTabCombinationsController($this->sibling, $this->params))->route();

			case 'papadminproducttabtranslationscontroller' :
				return (new PAPAdminProductTabTranslationsController($this->sibling, $this->params))->route();

			default :
				return $this->render();
		}
	}

}