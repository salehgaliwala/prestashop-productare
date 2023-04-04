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

class PAPAdminConfigDimensionsController extends PAPControllerCore
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

	public function renderList()
	{
		$id_lang = Context::getContext()->language->id;
		$dimensions = PAPDimensionModel::getDimensions($id_lang, Context::getContext()->shop->id);

		Context::getContext()->smarty->assign(array(
			'token' => Tools::getAdminTokenLite('AdminModules'),
			'module_config_url' => $this->module_config_url,
			'id_lang' => $id_lang,
			'dimensions' => $dimensions
		));
		return $this->sibling->display($this->sibling->module_file, 'views/templates/admin/config/dimensions.tpl');
	}

	/**
	 * Render the Add / Edit Dimension form
	 * @return mixed
	 */
	public function renderEdit()
	{
		$languages = Language::getLanguages();

		if (Tools::getValue('id_pap_dimension') != '')
			$pap_dimension = new PAPDimensionModel((int)Tools::getValue('id_pap_dimension'));
		else
			$pap_dimension = new PAPDimensionModel();

		Context::getContext()->smarty->assign(array(
			'pap_dimension' => $pap_dimension,
			'id_lang_default' => $this->id_lang_default,
			'languages' => $languages
		));
		return $this->sibling->display($this->sibling->module_file, 'views/templates/admin/config/dimensions_edit.tpl');
	}

	/**
	 * Process the Add / Edit Form
	 */
	public function processForm()
	{
		$languages = Language::getLanguages(false);

		if (Tools::getValue('id_pap_dimension') != '')
			$pap_dimension = new PAPDimensionModel((int)Tools::getValue('id_pap_dimension'));
		else
			$pap_dimension = new PAPDimensionModel();

		$pap_dimension->name = Tools::getValue('name');
		foreach ($languages as $key => $language) {
			$pap_dimension->display_name[$language{'id_lang'}] = Tools::getValue('display_name_' . $language['id_lang']);
			$pap_dimension->suffix[$language{'id_lang'}] = Tools::getValue('suffix_' . $language['id_lang']);
		}
		$pap_dimension->position = 0;
		$pap_dimension->id_shop = (int)Context::getContext()->shop->id;
		$pap_dimension->save();
	}

	/**
	 * Delete a dimension and all associated data
	 */
	public function processDelete()
	{
		PAPDimensionModel::deleteDimension(Tools::getValue('id_pap_dimension'));
	}

	public function route()
	{
		switch (Tools::getValue('action'))
		{
			case 'renderlist' :
				return $this->renderList();

			case 'renderedit' :
				return $this->renderEdit();

			case 'processform' :
				return $this->processForm();

			case 'processdelete' :
				return $this->processDelete();
		}
	}

}