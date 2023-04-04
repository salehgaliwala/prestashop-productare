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

class PAPAdminProductTabCombinationsController extends PAPControllerCore
{

	public function __construct($sibling, $params = array())
	{
		parent::__construct($sibling, $params);
		$this->sibling = $sibling;
		$this->base_url = Tools::getShopProtocol().Tools::getShopDomain().__PS_BASE_URI__;
	}

	public function setMedia()
	{
	}

	public function render()
	{
		// get a list of combinations
		$product = new Product(Tools::getValue('id_product'));
		$currency = Context::getContext()->currency;
		$combinations = $product->getAttributeCombinations(Context::getContext()->language->id);
		$groups = array();
		$comb_array = array();
		$default_class = 'highlighted';

		if (is_array($combinations))
		{
			$combination_images = $product->getCombinationImages(Context::getContext()->language->id);
			foreach ($combinations as $k => $combination)
			{
				$price_to_convert = Tools::convertPrice($combination['price'], $currency);
				$price = Tools::displayPrice($price_to_convert, $currency);

				$comb_array[$combination['id_product_attribute']]['id_product_attribute'] = $combination['id_product_attribute'];
				$comb_array[$combination['id_product_attribute']]['attributes'][] = array($combination['group_name'], $combination['attribute_name'], $combination['id_attribute']);
				$comb_array[$combination['id_product_attribute']]['wholesale_price'] = $combination['wholesale_price'];
				$comb_array[$combination['id_product_attribute']]['price'] = $price;
				$comb_array[$combination['id_product_attribute']]['weight'] = $combination['weight'].Configuration::get('PS_WEIGHT_UNIT');
				$comb_array[$combination['id_product_attribute']]['unit_impact'] = $combination['unit_price_impact'];
				$comb_array[$combination['id_product_attribute']]['reference'] = $combination['reference'];
				$comb_array[$combination['id_product_attribute']]['ean13'] = $combination['ean13'];
				$comb_array[$combination['id_product_attribute']]['upc'] = $combination['upc'];
				$comb_array[$combination['id_product_attribute']]['id_image'] = isset($combination_images[$combination['id_product_attribute']][0]['id_image']) ? $combination_images[$combination['id_product_attribute']][0]['id_image'] : 0;
				$comb_array[$combination['id_product_attribute']]['available_date'] = strftime($combination['available_date']);
				$comb_array[$combination['id_product_attribute']]['default_on'] = $combination['default_on'];
				if ($combination['is_color_group'])
					$groups[$combination['id_attribute_group']] = $combination['group_name'];
			}
		}

		if (isset($comb_array))
		{
			foreach ($comb_array as $id_product_attribute => $product_attribute)
			{
				$list = '';

				/* In order to keep the same attributes order */
				asort($product_attribute['attributes']);

				foreach ($product_attribute['attributes'] as $attribute)
					$list .= $attribute[0].' - '.$attribute[1].', ';

				$list = rtrim($list, ', ');
				$comb_array[$id_product_attribute]['image'] = $product_attribute['id_image'] ? new Image($product_attribute['id_image']) : false;
				$comb_array[$id_product_attribute]['available_date'] = $product_attribute['available_date'] != 0 ? date('Y-m-d', strtotime($product_attribute['available_date'])) : '0000-00-00';
				$comb_array[$id_product_attribute]['attributes'] = $list;
				$comb_array[$id_product_attribute]['name'] = $list;

				if ($product_attribute['default_on'])
					$comb_array[$id_product_attribute]['class'] = $default_class;
			}
		}

		Context::getContext()->smarty->assign(array(
			'id_product' => Tools::getValue('id_product'),
			'combinations' => $comb_array
		));
		return $this->sibling->display($this->sibling->module_file, 'views/templates/admin/producttab/combinations.tpl');
	}

	/**
	 * Render the edit combination details form
	 */
	public function renderEditForm()
	{
		$pap_product_attribute = new PAPProductAttributeModel();
		$pap_product_attribute->loadAttributeByProduct(Tools::getValue('id_product'), Tools::getValue('id_product_attribute'));

		Context::getContext()->smarty->assign(array(
			'id_product' => Tools::getValue('id_product'),
			'id_product_attribute' => Tools::getValue('id_product_attribute'),
			'pap_product_attribute' => $pap_product_attribute
		));
		return $this->sibling->display($this->sibling->module_file, 'views/templates/admin/producttab/combination_edit.tpl');
	}

	/**
	 * Save the general settings for the product
	 */
	public function processEditForm()
	{
		if ((int)Tools::getValue('id_papattribute') > 0)
			$pap_productattribute_model = new PAPProductAttributeModel(Tools::getValue('id_papattribute'));
		else
			$pap_productattribute_model = new PAPProductAttributeModel();

		$pap_productattribute_model->id_product = (int)Tools::getValue('id_product');
		$pap_productattribute_model->id_product_attribute = (int)Tools::getValue('id_product_attribute');
		$pap_productattribute_model->area_price = (float)Tools::getValue('area_price');
        $pap_productattribute_model->roll_height = (float)Tools::getValue('roll_height');
		$pap_productattribute_model->roll_width = (float)Tools::getValue('roll_width');
		$pap_productattribute_model->pattern_repeat = (float)Tools::getValue('pattern_repeat');
		$pap_productattribute_model->pack_area = (float)Tools::getValue('pack_area');
		$pap_productattribute_model->coverage = (float)Tools::getValue('coverage');
		$pap_productattribute_model->save();
	}

	public function route()
	{
		switch (Tools::getValue('action'))
		{
			case 'rendereditform' :
				die ($this->renderEditForm());

			case 'processeditform' :
				die ($this->processEditForm());

			default:
				return $this->render();
		}
	}

}