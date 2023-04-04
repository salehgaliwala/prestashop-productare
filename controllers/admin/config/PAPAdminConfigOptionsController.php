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

class PAPAdminConfigOptionsController extends PAPControllerCore
{
	protected $sibling;

	public function __construct(&$sibling = null)
	{
		parent::__construct($sibling);
		$this->id_lang_default = Configuration::get('PS_LANG_DEFAULT', null, Context::getContext()->shop->id_shop_group, Context::getContext()->shop->id);

		if ($sibling !== null)
			$this->sibling = &$sibling;
	}

	public function setMedia()
	{
	}

	public function render()
	{
		Context::getContext()->smarty->assign(array(
			'pap_product_display_location' => Configuration::get('pap_product_display_location'),
			'pap_price_list_modify' => (int)Configuration::get('pap_price_list_modify'),
			'pap_wastage_options_render_type' => Configuration::get('pap_wastage_options_render_type'),
			'pap_show_required_packs' => (int)Configuration::get('pap_show_required_packs'),
			'pap_show_quote_inc_tax' => (int)Configuration::get('pap_show_quote_inc_tax'),
			'pap_show_quote_ex_tax' => (int)Configuration::get('pap_show_quote_ex_tax'),
			'pap_show_box_price' => (int)Configuration::get('pap_show_box_price'),
			'pap_show_quote_total_area' => (int)Configuration::get('pap_show_quote_total_area')
		));
		return $this->sibling->display($this->sibling->module_file, 'views/templates/admin/config/options.tpl');
	}

	/**
	 * Process the Options form
	 */
	public function processForm()
	{
		Configuration::updateValue('pap_product_display_location', pSQL(Tools::getValue('pap_product_display_location')));
		Configuration::updateValue('pap_price_list_modify', (int)Tools::getValue('pap_price_list_modify'));
		Configuration::updateValue('pap_wastage_options_render_type', pSQL(Tools::getValue('pap_wastage_options_render_type')));
		Configuration::updateValue('pap_show_required_packs', (int)Tools::getValue('pap_show_required_packs'));
		Configuration::updateValue('pap_show_quote_inc_tax', (int)Tools::getValue('pap_show_quote_inc_tax'));
		Configuration::updateValue('pap_show_quote_ex_tax', (int)Tools::getValue('pap_show_quote_ex_tax'));
		Configuration::updateValue('pap_show_box_price', (int)Tools::getValue('pap_show_box_price'));
		Configuration::updateValue('pap_show_quote_total_area', (int)Tools::getValue('pap_show_quote_total_area'));
	}

	public function route()
	{
		switch (Tools::getValue('action'))
		{
			case 'render' :
				return $this->render();

			case 'processform' :
				return $this->processForm();
		}
	}

}